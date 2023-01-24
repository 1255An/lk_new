<?php
if(!defined('allow_access_to_this_script')) die();




$error = false;

// переход по ссылке из письма
// confirm, hash id
if( isset($_GET['hash']) && isset($_GET['id']) )
{
    if(is_numeric($_GET['id']))
    {
        $user = db_selectOne('user', ['id' => $_GET['id']]);
        if($uset['account_status_mail']==TRUE)
        {
            // уже подтверждена почта
            require_once("site_html/user_header.php");
            require_once("site_php/user_html.php"); // меню и прочее
?>
            <div class="authorization_form">

                    <h2>Уже сделано</h2>

                    <div>Этот адрес почты уже подтверждён и проходить заново по ссылке не требуется.</div>

<!--                    <div style="display:flex;margin-top:30px;justify-content: right;"><button onclick="window.location='/'" class="form_button">Начать работу</button></div>-->

            </div>
<?php
            require_once("site_html/user_bottom.php");
            die();
        }else{
            if ($user && $user['hash'] == $_GET['hash'])
            {
                db_update('user', $_GET['id'], ['account_status_mail' => 'TRUE']);
                // выводим окошко, что всё, авторизировалось и переход на основную страницу
                require_once("site_html/user_header.php");
                require_once("site_php/user_html.php"); // меню и прочее
?>
                <div class="authorization_form">
                        <h2>Почта подтверждена</h2>

                        <div>Ваш почтовый адрес <b><?php echo $_SESSION['front_user']; ?></b> подтверждён.</div>

<!--                        <div style="display:flex;margin-top:30px;justify-content: right;"><button onclick="window.location='/'" class="form_button">Начать работу</button></div>-->

                </div>
<?php
                require_once("site_html/user_bottom.php");
                die();
            }else{
                $error=true;
            }
        }
    }else{
        $error=true;
    }
}

if($error==true)
{
// выводим окошко, что ссылка содержит посторонние символы
    require_once("site_html/user_header.php");
    require_once("site_php/user_html.php"); // меню и прочее
?>
    <div class="authorization_form">
            <h2>Почта не подтверждена</h2>

            <div>Эта ссылка для подтверждения почтового адреса содержит посторонние символы. Пройдите по ссылке из высланного письма.</div>

<!--            <div style="display:flex;margin-top:30px;justify-content: right;"><button onclick="window.location='/'" class="form_button">На главную</button></div>-->

    </div>
<?php
    require_once("site_html/user_bottom.php");
    die();
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once("site_html/user_header.php");
require_once("site_php/user_html.php"); // меню и прочее

?>
    <div class="authorization_form">

            <h2>Завершение регистрации</h2>

            <div>На ваш почтовый адрес <b><?php echo $_SESSION['front_user']; ?></b> отправлено письмо. Пройдите по ссылке в письме для завершения регистрации. Можно запросить новое письмо в личных данных.</div>

<!--            <div style="display:flex;margin-top:30px;justify-content: right;"><button onclick="window.location='/'" class="form_button">На главную</button></div>-->

    </div>

<?php
    require_once("site_html/user_bottom.php");
?>
