<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ГЛАВНЫЙ СКРИПТ АДМИНКИ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ПЕРЕМЕННЫЕ
$superadmin_is_online = FALSE; // это суперадминистратор или нет (его не может быть в базе данных)
$admin_is_online = FALSE; // авторизован ли пользователь

// при успешной авторизации $_SESSION['login_user'] является логином

// надо ли вывести окно авторизации
$we_need_authorization_screen = FALSE;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// АВТОРИЗАЦИЯ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// НЕТ ЛИ ДАННЫХ ДЛЯ АВТОРИЗАЦИИ ИЗ AJAX
if ((isset($_POST['login_password'])) && (isset($_POST['login_user']))) {
    // ДАННЫЕ ОБНАРУЖЕНЫ, ФИЛЬТРУЕМ
    $_POST['login_user'] = filter_var($_POST['login_user'], FILTER_SANITIZE_EMAIL);

    //ПРОВЕРЯЕМ НА СУПЕРАДМИНА
    if (($_POST['login_password'] == $superadmin_password) && ($_POST['login_user'] == $superadmin_login) && ($_POST['smart-token'])) {

        // ПРОВЕРКА КАПЧИ
        if (check_captcha($_POST['smart-token'])) {
            // ЭТО СУПЕРАДМИН, ПЕРЕЗАГРУЖАЕМ СТРАНИЦУ
            $_SESSION['login_user'] = $_POST['login_user'];
            $_SESSION['login_password'] = $_POST['login_password'];
            echo "reloadpage";
            exit;
        } else {
            // КАПЧА НЕВЕРНАЯ
            echo "wrongcaptcha";
            exit;
        }

    } else {

        $admin_search = db_selectOne('admins', ['email_login' => $_POST['login_user']]);
        if ($admin_search !== false) {
            // ОБНАРУЖЕН АДМИН, НАДО ПРОВЕРИТЬ ПАРОЛЬ
            if ($admin_search['password'] == $_POST['login_password']) {

                // ПАРОЛЬ ВЕРНЫЙ, ПРОВЕРЯЕМ КАПЧУ
                if (!isset($_POST['smart-token'])) {
                    $_POST['smart-token'] = "";
                }
                if (check_captcha($_POST['smart-token'])) {
                    // ВСЕ ХОРОШО, АВТОРИЗИРУЕМ
                    $admin_is_online = TRUE;
                    $_SESSION['login_user'] = $_POST['login_user'];
                    $_SESSION['login_password'] = $_POST['login_password'];

                    // ПЕРЕЗАГРУЖАЕМ СТРАНИЦУ
                    echo "reloadpage";
                    exit;
                } else {
                    // КАПЧА НЕВЕРНАЯ
                    echo "wrongcaptcha";
                    exit;
                }

            } else {
                // ПАРОЛЬ НЕВЕРНЫЙ
                echo "wrongpass";
                exit;
            }
        } else {
            // НЕ ОБНАРУЖЕН АДМИН В БД, НО ВДРУГ ЭТО СУПЕРАДМИН?
            if ($_POST['login_user'] == $superadmin_login) {
                // ПРОВЕРКА ПАРОЛЯ
                if ($_POST['login_password'] == $superadmin_password) {
                    // ПРОВЕРКА КАПЧИ
                    if (!isset($_POST['smart-token'])) {
                        $_POST['smart-token'] = "";
                    }
                    if (check_captcha($_POST['smart-token'])) {
                        // ВСЕ ХОРОШО, АВТОРИЗИРУЕМ
                        $admin_is_online = TRUE;
                        $_SESSION['login_user'] = $_POST['login_user'];
                        $_SESSION['login_password'] = $_POST['login_password'];

                        // ПЕРЕЗАГРУЖАЕМ СТРАНИЦУ
                        echo "reloadpage";
                        exit;
                    } else {
                        // КАПЧА НЕВЕРНАЯ
                        echo "wrongcaptcha";
                        exit;
                    }
                } else {
                    // ПАРОЛЬ НЕВЕРНЫЙ
                    echo "wrongpass";
                    exit;
                }
            } else {
                echo "wronguser";
                exit;
            }
        }
    }

} else {

    // ЭТО НЕ ПОПЫТКА ВХОДА ЧЕРЕЗ АВТОРИЗАЦИЮ
    if ((isset($_SESSION['login_password'])) && (isset($_SESSION['login_user']))) {
        // ДАННЫЕ ОБНАРУЖЕНЫ, ФИЛЬТРУЕМ
        $_SESSION['login_user'] = filter_var($_SESSION['login_user'], FILTER_SANITIZE_EMAIL);

        //ПРОВЕРЯЕМ НА СУПЕРАДМИНА
        if (($_SESSION['login_password'] == $superadmin_password) && ($_SESSION['login_user'] == $superadmin_login)) {
            // ЭТО СУПЕРАДМИН
            $superadmin_is_online = TRUE;
            $admin_is_online = TRUE;
        } else {
            // ЭТО МОЖЕТ БЫТЬ ОБЫЧНЫЙ ПОЛЬЗОВАТЕЛЬ, ИЩЕМ В БАЗЕ ДАННЫХ
            $admin_search = db_selectOne('admins', ['email_login' => $_SESSION['login_user'], 'password' => $_SESSION['login_password']]);
            if ($admin_search != false) {
                // ОБНАРУЖЕН АДМИН
                $admin_is_online = TRUE;
            } else {
                // НЕ ОБНАРУЖЕН АДМИН, ТРЕБУЕТСЯ АВТОРИЗАЦИЯ
                $we_need_authorization_screen = TRUE;
            }
        }

    } else {
        // ТРЕБУЕТСЯ АВТОРИЗАЦИЯ
        $we_need_authorization_screen = TRUE;
    }

}


// ЕСЛИ НАДО ВЫВЕСТИ АВТОРИЗАЦИЮ
if ($we_need_authorization_screen == TRUE) {
    // ВЫВОДИМ ШАБЛОН ДЛЯ АВТОРИЗАЦИИ
    require_once("site_html/AUTHORIZATION.PHP");
    exit;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ВЫВОДИМ КАБИНЕТ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (!isset($_SESSION['page'])) {
    // СТРАНИЦА НЕ ВЫБРАНА, ЗНАЧИТ ВЫДАЁМ ГЛАВНУЮ
    $_SESSION['page'] = array_values($menu_admin)[0];
}

// ФУНКЦИИ ДЛЯ UI
require_once("site_php/HTML.PHP");

// ВЫДАЁМ СТРАНИЦУ
front_header();
require_once("site_php/" . mb_strtoupper($_SESSION['page']) . ".PHP");
front_bottom();

exit;


?>