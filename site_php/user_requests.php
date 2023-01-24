<?php
if(!defined('allow_access_to_this_script')) die();

require_once("site_html/user_header.php");
require_once("site_php/user_html.php"); // меню и прочее

bodyTitle("Подача и статус заявок");

$sub_menu = [
    "status" => "Статус заявок",
    "new" => "Создать заявку",
    "upload" => "Загрузить документы"
];

subMenu();


require_once("site_html/user_bottom.php");


?>

