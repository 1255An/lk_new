<?php

?>

    <!doctype html>
    <html lang="ru">
    <head>
        <link href="/site_html/style.css" type="text/css" rel="stylesheet"/>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <title>Восстановление пароля</title>
    </head>
    <body>
    <!--Страница, куда юзер попадает после нажатия кнопки в форме авторизации-->
    <div class="pwd_reset_page">
        <div class="form">
            <form action="pwd_reset_request_front.php" method="post" id="form-reset" name="pwd-reset-form"
                  class="form_body">
                <h1 class="form_title">Восстановить пароль</h1>
                <p>Вам будет отправлен e-mail с инструкциями для восстановления пароля</p>
                <div class="form_item">
                    <label for="email" class="form_label">Электронная почта*:</label>
                    <input id="email" type="email" placeholder="Например: user@mail.ru" name="email" class="form_input">
                    <small>Error message</small>
                    <span id="result"></span>
                </div>
                <button type="submit" name="reset-request-submit" class="reset-request-submit">Получить новый пароль по
                    email
                </button>
            </form>
        </div>
        <script>
            // проверка валидности email, вывод ошибок
            const emailValue = document.getElementById('email');
            const formValues = document.getElementById('form-reset');
            formValues.addEventListener('submit', formSend);

            async function formSend(e) {
                e.preventDefault();

                let err = checkInputs();
                // если err больше 1, значит емейл и пароль верные
                if (err >= 1) {
                    $.ajax({
                        url: 'pwd_reset_request.php',
                        method: 'post',
                        dataType: 'html',
                        data: $(this).serialize(),
                        success: [function (data) {
                            $('#result').html(data);
                        }]
                    });
                } else {
                    $('#result').html('');
                }
            }

            // чекаем то что ввёл юзер
            function checkInputs() {
                // trim для удаления пробелов
                const email = emailValue.value.trim();

                let err = 0;

                if (email === '') {
                    setErrorFor(emailValue, 'Введите email');
                } else if (!isEmail(email)) {
                    setErrorFor(emailValue, 'Некорректный email');
                } else {
                    setSuccessFor(emailValue);
                    err++;
                }
                return err;
            }

            //выводим ошибку если есть
            function setErrorFor(input, message) {
                const form = input.parentElement;
                const small = form.querySelector('small');
                form.className = 'form_item error';
                small.innerText = message;
            }

            function setSuccessFor(input) {
                const form = input.parentElement;
                form.className = 'form_item success';
            }

            function isEmail(emailValue) {
                return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(emailValue);
            }

        </script>
    </div>
    </body>
    </html>
