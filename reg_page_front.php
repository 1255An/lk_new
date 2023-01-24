<!doctype html>
<html lang="ru">
<head>
    <link href="site_html/style.css" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Регистрация клиентов</title>
</head>
<body>
<div class="reg_user_page">
    <div class="form">
        <form action="reg_user.php" method="post" id="form-reg" name="form" class="form_body">
            <h1 class="form_title">Зарегистрироваться в личном кабинете</h1>
            <div class="form_item">
                <div class="form_label">Тип потребителя*:</div>
                <select name="req_type" class="select">
                    <option selected disabled value="">Выберите из списка</option>
                    <option value="Физическое лицо">Физическое лицо</option>
                    <option value="Юридическое лицо">Юридическое лицо</option>
                    <option value="Индивидуальный предприниматель">Индивидуальный предприниматель</option>
                </select>
                <span id = "selectionTypeError"></span>
            </div>

            <div class="form_item">
                <label for="email" class="form_label">Электронная почта*:</label>
                <input id="email" type="email" placeholder="Например: user@mail.ru" name="email" class="form_input">
                <small>Error message</small>
                <span id="result" style="overflow:auto;display:flex;flex-wrap:wrap;width:100%;"></span>
            </div>

            <div class="form_item">
                <label for="password" class="form_label">Пароль*:</label>
                <input id="password" type="password" placeholder="Например: 12345678" name="password"
                       class="form_input">
                <small>Error message</small>
            </div>

            <button type="submit" class="sign_up_button" name="sign_up_button">Зарегистрироваться</button>
            <button type="button" onclick="window.location.assign('auth_page_front.php'); return false;"
                    class="sign_in_button" name="sign_in_button">Войти
            </button>
        </form>
    </div>
</div>

<script>
    // проверка валидности email, пароля, вывод ошибок
    const emailValue = document.getElementById('email');
    const passwordValue = document.getElementById('password');
    const formValues = document.getElementById('form-reg');

    const select = document.querySelector('select');

    formValues.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let err = checkInputs();
        if (err === 0) {
            $.ajax({
                url: '../reg_user.php',
                method: 'post',
                dataType: 'html',
                data: $(this).serialize(),
                success: [function (data) {
                    if (data === "success") {
                        if (select.value == "Физическое лицо") {
                            window.location.assign("personal_data_fl.php");
                        } else if (select.value == "Юридическое лицо") {
                            window.location.assign("personal_data_ul.php");
                        } else if (select.value == "Индивидуальный предприниматель") {
                            window.location.assign("personal_data_ip.php");
                        }
                    } else {
                        $('#result').html(data);
                    }
                }]
            });
        } else {
            $('#result').html('');
        }
    }

    function checkInputs() {
        // trim to remove the whitespaces
        const email = emailValue.value.trim();
        const password = passwordValue.value.trim();

        let err = 0;

        if (select.value === '') {
            $('#selectionTypeError').html('Выберите тип потребителя из списка');
            err++;
        } else {
            $('#selectionTypeError').html('');
        }

        if (email === '') {
            setErrorFor(emailValue, 'Введите email');
            err++;
        } else if (!isEmail(email)) {
            setErrorFor(emailValue, 'Некорректный email');
            err++;
        } else {
            setSuccessFor(emailValue);
        }

        if (password === '') {
            setErrorFor(passwordValue, 'Введите пароль');
            err++;
        } else if (password.length < 6) {
            setErrorFor(passwordValue, 'Пароль не может быть меньше 6 символов');
            err++;
        } else if (password.includes(" ") || password.includes("/") || password.includes("\\") || password.includes("\"") || password.includes("'")) {
            setErrorFor(passwordValue, 'Пароль не должен содержать знаков пробела и /, \\, \", \'');
            err++;
        } else {
            setSuccessFor(passwordValue);
        }
        return err;
    }

    //новый вариант
    function setErrorFor(input, message) {
        const form = input.parentElement;
        form.classList.add('_error');
        input.classList.add('_error');
        const small = form.querySelector('small');
        small.innerText = message;
    }

    function setSuccessFor(input) {
        const form = input.parentElement;
        form.classList.remove('_error');
        input.classList.remove('_error');
        // form.classList.add('_success');
        // input.classList.add('_success');
    }

    function isEmail(emailValue) {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(emailValue);
    }

</script>
</body>
</html>