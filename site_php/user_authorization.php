<?php
if(!defined('allow_access_to_this_script')) die();

// АВТОРИЗОВАННЫМ СЮДА НЕЛЬЗЯ
if($_SESSION['front_id']!=-1)
{
    header('Location: /');
    die();
}


// НЕТ ЛИ ДАННЫХ ДЛЯ АВТОРИЗАЦИИ ИЗ AJAX
if ((isset($_POST['front_password'])) && (isset($_POST['front_user']))) {

    // ДАННЫЕ ОБНАРУЖЕНЫ, ФИЛЬТРУЕМ
    $_POST['front_user'] = strtolower(filter_var($_POST['front_user'], FILTER_SANITIZE_EMAIL));

    //$user_search = db_selectOne('user', ['email_login_actual' => $_POST['front_user']]);

    $sql = "SELECT * FROM ".$config_db_prefix."_user WHERE LOWER(email_login_actual) = LOWER('".$_POST['front_user']."')";
    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
    $user_search = $query->fetch();


    if ($user_search !== false) {

        //$password_hash = password_hash($_POST['front_password'], PASSWORD_DEFAULT);
        $password_hash = hash('sha256', $_POST['front_password']);

        //echo $user_search['password']."---".$password_hash;

        // ОБНАРУЖЕН ПОТРЕБИТЕЛЬ, НАДО ПРОВЕРИТЬ ПАРОЛЬ
        //if (password_verify($_POST['front_password'], $user_search['password'])) {
        if ($user_search['password'] == $password_hash) {

            // ПАРОЛЬ ВЕРНЫЙ, ПРОВЕРЯЕМ КАПЧУ
            if (!isset($_POST['smart-token'])) {
                $_POST['smart-token'] = "";
            }

            if (check_captcha($_POST['smart-token'])) {
                // ВСЕ ХОРОШО, АВТОРИЗИРУЕМ
                $admin_is_online = TRUE;
                $_SESSION['front_user'] = $_POST['front_user'];
                $_SESSION['front_password'] = $password_hash;
                $_SESSION['front_id'] = $user_search['id'];

                // ПЕРЕЗАГРУЖАЕМ СТРАНИЦУ
                echo "success";
                exit;
            } else {
                // КАПЧА НЕВЕРНАЯ
                echo "error_captcha";
                exit;
            }

        } else {
            // ПАРОЛЬ НЕВЕРНЫЙ
            echo "error_password";
            exit;
        }
    }else{
        echo "error_login";
        exit;
    }

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once("site_html/user_header.php");
require_once("site_php/user_html.php"); // меню и прочее

?>


    <div class="authorization_form">
        <form method="post" id="form-auth">
            <h2>Вход в личный кабинет</h2>

            <div style="display:flex;">
                <div style="flex:40%;align-items: center;display:flex;">Электронная почта:</div>
                <div style="flex:60%"><input id="front_user" type="email" placeholder="Например: user@mail.ru" name="front_user" class="form_input"></div>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Пароль:</div>
                <div style="flex:60%"><input id="front_password" type="password" placeholder="Например: 12345678" name="front_password" class="form_input"></div>
            </div>

            <div style="margin-top:10px; color:red; height:25px; font-size:12px;">
                <div id="error_message"></div>
            </div>

            <!-- КАПЧА -->
            <script src="https://captcha-api.yandex.ru/captcha.js?hl=ru" defer></script>
            <div id="captcha-container" class="smart-captcha" data-sitekey="Dkh2GIA5lWccFD0mWOWUNKLGK255Qrus74Q1Q8YJ"></div>

            <div style="display:flex;margin-top:15px;justify-content: right;">
<!--            <div style="display:flex; margin-top:15px;">-->
                <button type="submit" class="form_button" name="sign_in_button">Войти</button>
<!--                <div style="display:flex;flex:33%;justify-content: left;"></div>-->
<!--                <div style="display:flex;flex:34%;justify-content: center;"><button onclick="window.location.assign('?registration'); return false;" class="form_button" name="sign_up_button">Зарегистрироваться</button></div>-->
<!--                <div style="display:flex;flex:33%;justify-content: right;">-->
                    <button style='margin-left:10px;' onclick="window.location.assign('?lostpassword'); return false;" class="form_button" name="sign_in_button">Вспомнить пароль</button>
<!--                </div>-->
            </div>

        </form>
    </div>


<script>

    document.getElementById('form-auth').addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

            $.ajax({
                url: '?login',
                method: 'post',
                dataType: 'html',
                data: $(this).serialize(),
                success: [function (data) {

                    switch (data)
                    {
                        case "success":
                            window.location.assign("/");
                            //alert('УСПЕШНО!');
                            break;

                        case "error_captcha":
                            $('#error_message').text("Проверка капчи не пройдена. Попробуйте ещё раз.");
                            $("#front_user").attr('class', 'form_input');
                            $("#front_password").attr('class', 'form_input');
                            break;

                        case "error_password":
                            $('#error_message').text("Пароль не совпадает. Если пароль утерян нажмите \"Вспомнить пароль\".");
                            $("#front_user").attr('class', 'form_input');
                            $("#front_password").attr('class', 'form_input_error');
                            break;

                        case "error_login":
                            $('#error_message').text("Такая электронная почта не зарегистрирована.");
                            $("#front_user").attr('class', 'form_input_error');
                            $("#front_password").attr('class', 'form_input');
                            break;

                        case "error_confirm":
                            window.location.assign("?confirm");

                            break;

                        default:
                            $('#error_message').text(data);
                            break;
                    }

                }]
            })

    }

</script>


<?php
    require_once("site_html/user_bottom.php");
?>
