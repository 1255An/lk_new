<!doctype html>
<html lang="ru">
<head>
    <link href="site_html/style.css" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Авторизация клиентов</title>
</head>
<body>
<div class="auth_user_page">
    <div class="form">
        <form method="post" id="form-auth" class="form_body">
            <h1 class="form_title">Войти в личный кабинет</h1>

            <div class="form_item">
                <label for="email" class="form_label">Электронная почта*:</label>
                <input id="email" type="email" placeholder="Например: user@mail.ru" name="email" class="form_input">
                <small>Error message</small>
                <span id="result"></span>
            </div>
            <div class="form_item">
                <label for="password" class="form_label">Пароль*:</label>
                <input id="password" type="password" placeholder="Например: 12345678" name="password"
                       class="form_input">
                <small>Error message</small>
            </div>

            <!-- КАПЧА -->
            <!-- здесь будет капча-->

            <button type="submit" class="sign_in_button" name="sign_in_button">Войти</button>
            <button type="submit" onclick="window.location.assign('reg_page_front.php'); return false;"
                    class="sign_up_button" name="sign_up_button">Создать новый аккаунт
            </button>
            <p><a href="pwd_reset_request_front.php">Восстановить пароль</a></p>
            <p><a href="#">Восстановить логин</a></p>
        </form>
    </div>
</div>

<script>
    // проверка валидности email, пароля, вывод ошибок
    const emailValue = document.getElementById('email');
    const passwordValue = document.getElementById('password');
    const formValues = document.getElementById('form-auth');
    formValues.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let err = checkInputs();
        // если err больше 2, значит емейл и пароль верные
        if (err >= 2) {
            $.ajax({
                url: 'auth_user.php',
                method: 'post',
                dataType: 'html',
                data: $(this).serialize(),
                success: [function (data) {
                    if (data === "success") {
                      window.location.assign("personal_data_fl.php");
                    } else {
                        $('#result').html(data);
                    }

                }]
            })
            // где-то тут должен быть переход в лк
        } else {
            $('#result').html('');
        }
    }

    // чекаем то что ввёл юзер
    function checkInputs() {
        // trim для удаления пробелов
        const email = emailValue.value.trim();
        const password = passwordValue.value.trim();

        let err = 0;

        if (email === '') {
            setErrorFor(emailValue, 'Введите email');
        } else if (!isEmail(email)) {
            setErrorFor(emailValue, 'Некорректный email');
        } else {
            setSuccessFor(emailValue);
            err++;
        }

        if (password === '') {
            setErrorFor(passwordValue, 'Введите пароль');
        } else if (password.length < 6) {
            setErrorFor(passwordValue, 'Пароль не может быть меньше 6 символов');
        } else {
            setSuccessFor(passwordValue);
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

</body>
</html>