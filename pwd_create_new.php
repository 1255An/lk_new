<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// СОЗДАНИЕ НОВОГО ПАРОЛЯ ПОЛЬЗОВАТЕЛЯ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

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
    <title>Новый пароль</title>
</head>
<body>
<?php

//юзер прошел по ссылке из письма- получаем данные из запроса
$hash = $_GET["hash"];
$id = $_GET["id"];

//проверяем валидность
if (empty($hash) || empty($id)) {
    echo 'Не удалось обработать ваш запрос';
} else {

    ?>
    <div class="pwd_create_new_page">
        <div class="form">
            <form action="pwd_reset_final.php" method="post" id="form-create-new" name="form-create-new"
                  class="form_body">
                <input type="hidden" name="hash" value="<?php echo $hash ?>">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="form_item">
                    <label for="pwd" class="form_label">Введите новый пароль:</label>
                    <input id="pwd" type="password" placeholder="Например: 12345678" name="pwd" class="form_input">
                    <small>Error message</small>
                    <span id="result"></span>
                </div>
                <button type="submit" name="reset-submit" class="reset-submit">Изменить пароль</button>
            </form>
        </div>
        <script>
            // проверка валидности email, вывод ошибок
            const pwdValue = document.getElementById('pwd');
            const formValues = document.getElementById('form-create-new');
            formValues.addEventListener('submit', formSend);

            async function formSend(e) {
                e.preventDefault();

                let err = checkInputs();

                // если err больше 1, значит емейл и пароль верные
                if (err >= 1) {
                    $.ajax({
                        url: 'pwd_reset_final.php',
                        method: 'post',
                        dataType: 'html',
                        data: $(this).serialize(),
                        success: function (data) {
                            if (data == "good") {
                                // все ок, переводим на страницу авторизации
                                window.location.href = "auth_page_front.php";
                            } else {
                                $('#result').html(data);
                            }
                        }
                    });
                } else {
                    $('#result').html('');
                }
            }


            // чекаем то что ввёл юзер
            function checkInputs() {
                // trim для удаления пробелов
                const pwd = pwdValue.value.trim();

                let err = 0;

                if (pwd === '') {
                    setErrorFor(pwdValue, 'Введите пароль');
                } else if (pwd.length < 6) {
                    setErrorFor(pwdValue, 'Пароль не может быть меньше 6 символов');
                } else if (pwd.includes(" ") || pwd.includes("/") || pwd.includes("\\") || pwd.includes("\"") || pwd.includes("'")) {
                    setErrorFor(pwdValue, 'Пароль не должен содержать знаков пробела и /, \\, \", \'');
                } else {
                    setSuccessFor(pwdValue);
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

        </script>
    </div>
    <?php
}
?>
</body>

</html>