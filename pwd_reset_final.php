<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЗАКЛЮЧИТЕЛЬНЫЙ ЭТАП В ИЗМЕНЕНИИ ПАРОЛЯ ПОЛЬЗОВАТЕЛЯ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

if (isset($_POST["pwd"])) {
    $hash = $_POST["hash"];
    $id = $_POST["id"];
    $passwordNew = $_POST["pwd"];

    //проверяем введен ли новый пароль
    if (empty($passwordNew)) {
        echo('Вы не ввели пароль!');
        exit();

        // пароль введен
    } else {
        $user = db_selectOne('user', ['id' => $id]);

        //проверяем есть ли такой юзер и правильный ли хэш в БД
        if ($user && $user['hash'] === $hash) {

            //проверяем, не совпадает ли новый пароль со старым
            if(password_verify($passwordNew, $user['password'])) {
                echo('Новый пароль не должен совпадать со старым');
                exit;
            }

            //проверяем не истек ли срок действия ссылки
            $dateNow = date('d.m.Y H:i:s', time());
            $date_str = date("d.m.Y H:i:s", strtotime($dateNow));
            if ($user['hash_expires'] < $date_str) {
                echo('Ссылка больше не действительна. Попробуйте заново');
            }
            $newPasswordHash = password_hash($passwordNew, PASSWORD_DEFAULT);
            db_update('user', $id, ['password' => $newPasswordHash]);
            echo('good');

        } else {
            echo('Неверная ссылка');
        }
    }
}
?>
