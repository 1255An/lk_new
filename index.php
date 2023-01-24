<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////




// СТРАНИЦЫ ПОТРЕБИТЕЛЬСКОЙ ЧАСТИ
/*  формат:
    "запрос_GET" => [да/нет, "страница_php","к_чему_относится_в_меню_сайта", "Название"]
    где да/нет - отображается или нет в главном меню
*/
$menu_user = array(
    ""               => [true,  "user_mainpage",      ["login","lostpassword","registration","confirm"], "Главная"],
    "login"          => [false, "user_authorization", [], "Вход в личный кабинет"],
    "lostpassword"   => [false, "user_lostpassword",  [], "Сброс пароля"],
    "registration"   => [false, "user_registration",  [], "Регистрация"],
    "confirm"        => [false, "user_confirm", [], "Подтверждение адреса почты"],

    "profile"        => [true,"user_profile", [], "Мои данные"],
    "apply"          => [true,"user_requests", [], "Мои заявки"],
   // "messages"       => [true,"user_messages", [], "Переписка"],
    "instructions"   => [true,"user_instructions", [],"Инструкции"],
    "exit"           => [false,"user_exit", [],"Выйти"]

);


$this_page = "";


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// АВТОРИЗАЦИЯ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$user_is_online = FALSE;

// при успешной авторизации $_SESSION['front_user'] является логином

// надо ли вывести окно авторизации
$_SESSION['front_id'] = -1;

// ПРОВЕРКА ЛОГИНА И ПАРОЛЯ
if ((isset($_SESSION['front_password'])) && (isset($_SESSION['front_user']))) {

    // ИЩЕМ В БАЗЕ ДАННЫХ
    $user_search = db_selectOne('user', ['email_login_actual' => $_SESSION['front_user'], 'password' => $_SESSION['front_password']]);

    if ($user_search != false) {
        $_SESSION['front_id'] = $user_search['id'];
    }

} else {
    // ТРЕБУЕТСЯ АВТОРИЗАЦИЯ
    $_SESSION['front_id'] = -1;
}




if(isset($_GET))
{
    if(isset($menu_user[array_key_first($_GET)]))
    {
        @include_once("site_php/".$menu_user[array_key_first($_GET)][1].".php");
        $this_page = $menu_user[array_key_first($_GET)];
    }else{
        die();
    }
}else{
    // ВЫДАЁМ СТРАНИЦУ ПО УМОЛЧАНИЮ
    require_once("site_php/user_mainpage.php");
}


?>