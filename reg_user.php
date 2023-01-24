<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// РЕГИСТРАЦИЯ НОВОГО КЛИЕНТА
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    debug_to_console(1);
    $registration_date = date('Y/m/d H:i:s');
    $email_login_actual = str_replace(" ","", $_POST['email']);

    //при регистрации исходный емейл и является актуальным
    $email_login_original = $email_login_actual;
    $password = trim($_POST['password']);

    if(isset($_POST['req_type']) && strlen($_POST['req_type']) !==0)  {
        //определяем юридическую форму
        switch ($_POST['req_type']) {
            case 'Физическое лицо':
                $juridical_form = 1;
                break;
            case 'Юридическое лицо':
                $juridical_form = 2;
                break;
            case 'Индивидуальный предприниматель':
                $juridical_form = 3;
                break;
            default: $juridical_form = 0;
        }
    } else {
        die();
        var_dump(777);
    }


    // Хэшируем login для создания ссылки подтверждения login-а
    $hash = password_hash($email_login_actual . time(), PASSWORD_DEFAULT);
    if ($email_login_actual === '' || $password === '') {
        echo('Заполните обязательные поля');
    } else if (!filter_var($email_login_actual, FILTER_VALIDATE_EMAIL)) {
        echo('Некорректный email');
    } else if (strlen($password) < 6) {
        echo('Пароль должен быть не меньше 6 символов');
    } else {
        // проверяем может юзер уже был зарегистрирован
        // ищем юзера в БД по емейлу
        $existence = db_selectOne('user', ['email_login_actual' => $email_login_actual]);
        // такая почта уже была зарегистрирована
        if ($existence !== false && $existence['email_login_actual'] === $email_login_actual) {
            echo('Пользователь с таким логином уже зарегистрирован!');
        } else {
            // если все ок, вносим юзера в БД
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $post = [
                'registration_date' => $registration_date,
                'hash' => $hash,
                'account_status' => '0',
                'juridical_form' => $juridical_form,
                'email_login_actual' => $email_login_actual,
                'email_login_original' => $email_login_original,
                'password' => $password_hash,
            ];

            $id = db_insert('user', $post);
            $user = db_selectOne('user', ['id' => $id]);
            $_SESSION['id'] = $id;
            $_SESSION['login'] = $user['email_login_actual'];
            echo("success");


            // Формирование отправки сообщения на email с кодом подтверждения
//            $headers = "MIME-Version: 1.0\r\n";
//            $headers .= "Content-type: text/html; charset=utf-8\r\n";
//            $headers .= "To: <$login_actual>\r\n";
//            $headers .= "From: <mail@example.com>\r\n";
//            $subject = "Подтвердите email на сайте lk.enengin.ru";
//            $message = '<html>
//                <head>
//                <title>Завершение регистрации в личном кабинете потребителей ООО "Энергоинжиниринг"</title>
//                </head>
//                <body>
//                <p> Helllllo , okay</p>
//                </body>
//                </html>
//            ';
//            if ($send = mail($login_actual, $subject, $message, $headers)) {
//                echo"OK";
//            };
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

    $filename = "d:\zhopa.txt";
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
