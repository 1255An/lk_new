<?php
define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЗАПРОС ПОЛЬЗОВАТЕЛЯ НА ВОССТАНОВЛЕНИЕ ПАРОЛЯ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['email'])) {

    //находим юзера по емейлу в БД
    $userEmail = str_replace(" ", "", $_POST["email"]);
    $user = db_selectOne('user', ['email_login_actual' => $userEmail]);

    //если такого юзера нет в БД, то перекидываем на страницу регистрации
    if (!$user) {

        echo 'Данный логин не зарегистрирован в системе!';
        //       header("Location: ../reg_page_front.php");
        exit();
    }

    //если есть в БД, апдейтим хэш юзера
    $hash = password_hash($userEmail . time(), PASSWORD_DEFAULT);
    $id = $user['id'];
    db_update('user', $id, ['hash' => $hash]);

    //формируем ссылку для отправки, отправляем
    $url = "http://localhost:63342/LKEnengin/pwd_create_new.php?hash=" . $hash . "&id=" . $id;
    $to = $userEmail;
    $subject = 'Восстановление пароля для ЛК ООО "ЭНЕРГОИНЖИНИРИНГ"';
    $message = '<br> Мы получили от вас запрос на изменение пароля. 
Если вы запрашивали это изменение, нажмите на ссылку ниже для установления нового пароля:</br></p>';
    $message .= '<a href = "' . $url . '">' . $url . '</a></p>';
    $message .= '<br> Если это были не вы, проигнорируйте это письмо</br></p>';
    $headers = "From: Zhopa <zhopa@gmail.com> \r\n";
    $headers .= "Reply-To: <zhopa@gmail.com> \r\n";
    $headers = "Content-type: text/html \r\n";
//    mail($to, $subject, $message, $headers);
    debug_to_console($message); //временно записываем в файл

    //записываем дату истечения действия ссылки
    $dateNow = date('d.m.Y H:i:s', time());
    $hashExpires = date("d.m.Y H:i:s", strtotime("+15 minute", strtotime($dateNow)));

    //обновляем срок действия ссылки
    db_update('user', $id, ['hash_expires' => $hashExpires]);

    //если все ок, выводим сообщение чтобы юзер проверил почту
    echo('На вашу почту отправлено письмо для восстановления пароля');
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