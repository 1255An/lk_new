<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// АВТОРИЗАЦИЯ КЛИЕНТА
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email_login_actual = str_replace(" ", "", $_POST['email']);
    $password = trim($_POST['password']);
    // проверяем валидность емейла и пароля
    if ($email_login_actual === '' || $password === '') {
        echo('Заполните обязательные поля');
    } else if (!filter_var($email_login_actual, FILTER_VALIDATE_EMAIL)) {
        echo('Некорректный email');
    } else {
        // проверяем зарегистрирован ли юзер
        // ищем юзера в БД по емейлу
        $existence = db_selectOne('user', ['email_login_actual' => $email_login_actual]);
        // если такой юзер есть в БД и пароль введены вверно
        if ($existence && password_verify($password, $existence['password'])) {
            echo("success");
            $_SESSION['id'] = $existence['id'];
            debug_to_console($_SESSION['id']);
        } else {
            echo('Почта или пароль введены неверно');
        }
    }
} else {
    $email_login_actual = '';
    $password = '';
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    //echo "<script.sql>console.log('Debug Objects: " . $output . "' );</script.sql>";

    $filename = "d:\zhopa1.txt";
    if (!$fp = fopen($filename, 'a')) {
        echo "Cannot open file ($filename)";
        exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($fp, $output) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    fclose($fp);


}


?>
