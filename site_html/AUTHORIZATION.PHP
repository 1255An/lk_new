<html>
<header>
    <title>Авторизация</title>
</header>
<body>

<form action="#" method="post" name="login_form">

<b>Авторизация:</b></br></br>
Логин администратора:</br>
<input id="email" type="email" placeholder="Например: user@mail.ru" name="login_user"></br>
<div style="height:30px;">
    <div style="display:none;color:red;" id="login_user_not_found">
        Администратор с таким логином не найден</br>
    </div>
</div>
</br>

Пароль администратора:</br>
<input id="password" type="password" placeholder="Например: 12345678" name="login_password"></br>
<div style="height:30px;">
    <div style="display:none;color:red;" id="login_password_wrong">
        Пароль не подходит</br>
    </div>
</div>
</br>


<!-- КАПЧА -->
<script src="https://captcha-api.yandex.ru/captcha.js?hl=ru" defer></script>
<div
        style="height: 100px"
        id="captcha-container"
        class="smart-captcha"
        data-sitekey="Dkh2GIA5lWccFD0mWOWUNKLGK255Qrus74Q1Q8YJ"
></div>


    <div style="display:none;color:red;" id="login_captcha">
            Пройдите проверку и нажмите &laquo;Войти&raquo; снова</br>
    </div>


    </br>

<button type="submit">Войти</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>
    // здесь проверка на email, наличие пароля ajax авторизация, вывод ошибок, переход далее

    const login_form = $("[name='login_form']")[0];
    login_form.addEventListener('submit', formSend);

    async function formSend(e)
    {
        e.preventDefault();

            $.ajax({
                url: 'ADMIN.PHP',
                method: 'post',
                dataType: 'html',
                data: $(this).serialize(),
                success: [function (data) {
                    if(data=="wronguser")
                    {
                        // юзер не найден
                        $("#login_user_not_found").show();
                        $("#login_password_wrong").hide();
                        $("#login_captcha").hide();
                    }else{
                        if(data=="wrongpass")
                        {
                            // неверный пароль
                            $("#login_user_not_found").hide();
                            $("#login_password_wrong").show();
                            $("#login_captcha").hide();
                        }else{

                            // проверяем капчу
                            if(data=="wrongcaptcha")
                            {
                                // неверная каптча
                                $("#login_user_not_found").hide();
                                $("#login_password_wrong").hide();
                                $("#login_captcha").show();
                            }else {
                                // всё отлично, перезагружаем страницу
                                location.reload();
                            }
                        }
                    }
                }]
            });

    }

</script>


</body>
</html>