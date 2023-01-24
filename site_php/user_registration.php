<?php
if(!defined('allow_access_to_this_script')) die();

// АВТОРИЗОВАННЫМ СЮДА НЕЛЬЗЯ
if($_SESSION['front_id']!=-1)
{
    header('Location: /');
    die();
}


// ПРИСЛАНА ФОРМА РЕГИСТРАЦИИ
if ( (isset($_POST['email'])) && (isset($_POST['password'])) && (isset($_POST['password2'])) && (isset($_POST['reg_type'])) )
{
    $registration_date = date('Y/m/d H:i:s');

    $_POST['email'] = strtolower(str_replace(" ","", $_POST['email']));
    $_POST['password'] = trim($_POST['password']);
    $_POST['password2'] = trim($_POST['password2']);

    // ПРОВЕРКА ТИПА ПОТРЕБИТЕЛЯ
    if(!is_numeric($_POST['reg_type'])) $_POST['reg_type'] = 0;
    if(($_POST['reg_type']<1)||($_POST['reg_type']>3)) $_POST['reg_type'] = 0;
    if($_POST['reg_type']==0)
    {
        echo "error_notselected";
        die();
    }

    // ПРОВЕРКА ПАРОЛЯ
    if (strlen($_POST['password']) < 8)
    {
        echo "error_password";
        die();
    }
    if(is_numeric($_POST['password']))
    {
        echo "error_passnumeric";
        die();
    }
    if($_POST['password']!=$_POST['password2'])
    {
        echo "error_dualpass";
        die();
    }

    // ПРОВЕРКА ПОЧТЫ
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "error_mail";
        die();
    }

    // Хэшируем login для создания ссылки подтверждения login-а
    //$hash = password_hash($_POST['email'] . time(), PASSWORD_DEFAULT);
    $hash = hash('sha256', $_POST['email'] . time());

    // проверяем может юзер уже был зарегистрирован
    // ищем юзера в БД по емейлу
    $existence = db_selectOne('user', ['email_login_actual' => $_POST['email']]);
    // такая почта уже была зарегистрирована
    if ($existence !== false && $existence['email_login_actual'] === $_POST['email']) {
        echo "error_login";
        die();
    } else {
        // если все ок, вносим юзера в БД
        //$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_hash = hash('sha256', $_POST['password']);
        $post = [
            'registration_date' => $registration_date,
            'hash' => $hash,
            'account_status_mail' => 'FALSE',
            'account_status_check' => 'FALSE',
            'juridical_form' => $_POST['reg_type'],
            'email_login_actual' => $_POST['email'],
            'email_login_original' => $_POST['email'],
            'password' => $password_hash,
        ];

        $id = db_insert('user', $post);
        echo "success";
        $_SESSION['front_id'] = $id;
        $_SESSION['front_user'] = $_POST['email'];
        $_SESSION['front_password'] = $password_hash;
        $url = "lk.enengin.ru/?confirm&hash=" . $hash . "&id=" . $id;
        $to = $_POST['email'];
        $subject = 'Подтверждение регистрации для Личного Кабинета ООО "ЭНЕРГОИНЖИНИРИНГ"';
        $message = 'Для завершения регистрации пройдите по ссылке ниже:<br/>';
        $message .= "<a href='".$url."'>".$url."</a>";
        $message .= '<br/><br/>Если это были не вы, проигнорируйте это письмо.';
        $headers = "From: LK.ENENGIN.RU <support@lk.enengin.ru> \r\n";
        $headers .= "Reply-To: <support@lk.enengin.ru> \r\n";
        $headers = "Content-type: text/html \r\n";
        die();
    }



}










////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once("site_html/user_header.php");
require_once("site_php/user_html.php"); // меню и прочее




?>




    <div class="authorization_form">
        <form method="post" id="form-reg">
            <h2>Регистрация в личном кабинете</h2>

            <div style="display:flex;">
                <div style="flex:40%;align-items: center;display:flex;">Тип потребителя:</div>
                <div style="flex:60%"><select name="reg_type" class="form_input">
                        <option selected style='color:gray;' value="0">Выберите из списка</option>
                        <option value="1">Физическое лицо</option>
                        <option value="2">Индивидуальный предприниматель</option>
                        <option value="3">Юридическое лицо</option>
                    </select></div>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Электронная почта:</div>
                <div style="flex:60%"><input id="email" type="email" placeholder="Например: user@mail.ru" name="email" class="form_input"></div>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Пароль:</div>
                <div style="flex:60%"><input id="password" type="password" placeholder="Например: 12345678" name="password" class="form_input"></div>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Повторите пароль:</div>
                <div style="flex:60%"><input id="password2" type="password" placeholder="Введите тот же самый" name="password2" class="form_input"></div>
            </div>

            <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                <div id="error_message" style="width:100%;text-align:center;"></div>
            </div>

            <div style="display:flex;margin-top:5px;justify-content: right;">
                <button type="submit" class="form_button" name="sign_up_button">Зарегистрироваться</button>
<!--                <button style="margin-left:10px;" type="button" onclick="window.location.assign('?login'); return false;" class="form_button" name="sign_in_button">Войти</button>-->
            </div>
        </form>
    </div>


<script>
    document.getElementById('form-reg').addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();


                    $.ajax({
                        url: '?registration',
                        method: 'post',
                        dataType: 'html',
                        data: $(this).serialize(),
                        success: [function (data) {
                            switch (data)
                            {
                                case "success":
                                    window.location.assign("?confirm");
                                    break;

                                case "error_notselected":
                                    $('#error_message').text("Нужно выбрать тип потребителя.");
                                    break;

                                case "error_mail":
                                    $('#error_message').text("Нужно указать корректный адрес почты.");
                                    break;

                                case "error_login":
                                    $('#error_message').text("Такая почта уже зарегистрирована.");
                                    break;

                                case "error_password":
                                    $('#error_message').text("Требуется хотя бы 8 символов для пароля.");
                                    break;

                                case "error_dualpass":
                                    $('#error_message').text("Пароли не совпадают.");
                                    break;

                                case "error_passnumeric":
                                    $('#error_message').text("Придумайте пароль не только из цифр.");
                                    break;

                                default:
                                    $('#error_message').text(data);
                                    break;
                            }

                        }]
                    });
    }

</script>



<?php
    require_once("site_html/user_bottom.php");
?>
