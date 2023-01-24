<?php

if(!defined('allow_access_to_this_script')){die();}

// ЗДЕСЬ ФУНКЦИИ, СВЯЗАННЫЕ ТОЛЬКО С ВНЕШНИМ ВИДОМ
// ГЕНЕРАТОР МЕНЮ И Т.П. ЭЛЕМЕНТОВ

function front_header()
{
    global $menu_admin;

    /**************************************************************************************/
    // ПЕРЕХОДИМ ПО РАЗДЕЛАМ МЕНЮ
    if(isset($_GET['go']))
    {
        if(!array_search($_GET['go'], $menu_admin))
        {
            $_SESSION['page']="main";
        }else{
            $_SESSION['page']=$_GET['go'];
        }

        header('Location:ADMIN.PHP?'.time());
        exit;
    }
    /**************************************************************************************/

    // HTML КОД ЗАГОЛОВКА
    include_once("site_html/ADMIN_HEADER");

    // ТЕКУЩИЙ ПОЛЬЗОВАТЕЛЬ
    echo $_SESSION['login_user']."</div></div></div>";

    // ГЕНЕРАЦИЯ МЕНЮ ЛИЧНОГО КАБИНЕТА
    foreach ($menu_admin as $value)
    {
        if($_SESSION['page']==$value)
        {
            //echo "<b>".array_search($value, $menu_admin)."</b></br>";
            echo "<div class='menu_thispage'>".array_search($value, $menu_admin)."</div>";
        }else{
            echo "<div class='menu_page' onClick=\"window.location='?go=".$value."'\">".array_search($value, $menu_admin)."</div>";
            //echo "<a href='?go=".$value."'>".array_search($value, $menu_admin)."</a></br>";
        }
    }

    echo "</br></br>";

}

function front_bottom()
{
    include_once("site_html/ADMIN_BOTTOM");
}


?>