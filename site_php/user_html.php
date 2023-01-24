<?php
if(!defined('allow_access_to_this_script')){die();}
?>

    <div class="logo">
        <div class="logo_column"><div class="logo_title">Личный Кабинет</div></div>
        <div class="logo_column" style="justify-content: right;"><div class="logo_logon">
                <?php
                // ЗДЕСЬ ВЫВОДИМ ПОЧТУ, ЕСЛИ ЮЗЕР АВТОРИЗОВАН
                if($_SESSION['front_id']!=-1)
                {
                    echo "<div class='logo_name'>".$user_search['email_login_actual']."</div>";
                    // включаем кнопку выхода
                    $menu_user['exit'][0]=true;
                }else{
                    ?>
                    <div style="display:flex;flex:34%;justify-content: center;">
                        <button onclick="window.location.assign('?login'); return false;" class="logo_buttons">Войти</button>
                        <button onclick="window.location.assign('?registration'); return false;" class="logo_buttons">Регистрация</button>
                    </div>
                    <?php
                }
                ?>
            </div></div></div>
<?php

// ВЫВОДИМ МЕНЮ
foreach ($menu_user as $key => $value)
{
    $b=true;

        if(isset($_GET))
        {
            if(array_key_first($_GET)==$key)
            {
                $b=false;
            }else{
                if(array_search(array_key_first($_GET), $value[2]))
                {
                    $b=false;
                }
            }
        }

    if($value[0]==true)
    {
        if($key == '')
        {
            $link = '/';
        }else{
            $link = '?'.$key;
        }

        if($b==true)
        {
            echo "<div class='menu_page' onClick=\"window.location='".$link."'\">".$value[3]."</div>";
        }else{
            echo "<div class='menu_thispage' onClick=\"window.location='".$link."'\">".$value[3]."</div>";
        }
    }

}


function bodyTitle($string)
{
    echo "<div class='logo_pagename'>";
    echo $string;
    echo "</div>";
}



// ВЫВОДИМ СТРАНИЦУ С ПОДМЕНЮ $sub_menu (задаётся на основной странице)
function subMenu()
{
    echo "<div class='window'><div class='window_column1'>";

    global $sub_menu, $menu_user;
    $this_menu='';
    $php_subfile='';

    if(isset($menu_user[array_key_first($_GET)])) $this_menu = array_key_first($_GET);

    // ОПРЕДЕЛЕНИЕ ВЫБРАННОЙ СТРАНИЦЫ
    $selected = '';
    foreach($sub_menu as $key => $value)
    {
        if(isset($_GET[$key]))
        {
            $selected = $key;
        }
    }
    // ЕСЛИ СТРАНИЦА НЕ ВЫБРАНА, ТО СТАВИМ ПЕРВУЮ
    if($selected=='') $selected = array_key_first($sub_menu);

    // ВЫВОДИМ ПОДМЕНЮ
    foreach($sub_menu as $key => $value)
    {
        if($key == $selected)
        {
            echo "<div class='subpage_menu_selected'>";
            echo $value;
            $php_subfile = $key;
            echo "</div>";
        }else{
            echo "<div class='subpage_menu' onClick=\"window.location='?".$this_menu."&".$key."'\">";
            echo $value;
            echo "</div>";
        }
    }

//

//
//        <div style="font-size:14px; margin-bottom:10px; padding:10px; text-align: center; display:block; border: 2px solid lightgrey; border-radius:10px;">
//            Загрузить документы
//        </div>
//
//        <div style="font-size:14px; margin-bottom:10x; padding:10px; text-align: center; display:block; border: 1px solid black; border-radius:10px;">
//            Изменить данные
//        </div>

    echo "</div><div class='window_column2'>";

    require_once("site_php/".$menu_user[array_key_first($_GET)][1]."_".$php_subfile.".php");

    echo "</div></div>";

}
