<?php

if(!defined('allow_access_to_this_script')){die();}

echo "СВОДКА</br><hr></br>";


$count_new_users = db_count("user", ["account_status" => "1"]);
$count_new_requests = db_count("request");

echo "Новых и непрочитанных сообщений: <b>0</b></br></br>";

echo "Требуется проверка документов: <b>".$count_new_users."</b></br></br>";

echo "Заявок на рассмотрении: <b>".$count_new_requests."</b></br></br>";




?>




