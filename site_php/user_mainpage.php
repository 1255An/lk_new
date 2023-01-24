<?php
if(!defined('allow_access_to_this_script')) die();

require_once("site_html/user_header.php");
require_once("site_php/user_html.php"); // меню и прочее


    if($_SESSION['front_id']==-1)
    {
        bodyTitle("Добро пожаловать!");

        echo "<div class='window'>";
            echo "Тут буклет про кабинет";
        echo "</div>";

    }else{
        bodyTitle("Уведомления");

        echo "<div class='window'>";
            echo "Тут про заявки";
            /*
             *  Почта - авторизирована или нет (выслать новое письмо)
             *  Личные данные проверены или нет (перейти в личные данные)
             *  Список заявок и статус заявок
             *  Сообщения от администраторов
             */
        echo "</div>";
    }


require_once("site_html/user_bottom.php");


?>

