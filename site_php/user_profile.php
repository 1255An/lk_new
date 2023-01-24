<?php
if(!defined('allow_access_to_this_script')) die();

require_once("site_html/user_header.php");
require_once("site_php/user_html.php"); // меню и прочее

bodyTitle("Информация о потребителе");

$sub_menu = [
                "status" => "Текущий статус",
                "upload" => "Загрузить документы",
                "edit" => "Изменить данные"
            ];

subMenu();




require_once("site_html/user_bottom.php");


?>

