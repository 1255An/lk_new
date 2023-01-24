<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <link href="/site_html/style.css" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- parsing pdf-->
    <script src="pdf.js"></script>
    <!-- Masked input lib-->
    <script src="jquery.maskedinput-master/dist/jquery.maskedinput.js" type="text/javascript"></script>

    <!-- Address suggestions lib-->
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>

    <script>$(document).ready(function () {
            $("#contact_phone").mask("+7(999)-999-9999");
            $("#passport_numb").mask("9999 999999");
            $("#passport_code").mask("999-999");
            $("#inn_numb").mask("999999999999");
            $("#snils_numb").mask("999-999-999 99")
        });
    </script>
    <title>Личные данные физического лица</title>
</head>
<body>

<script>
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
</script>

<div class="personal_data_page">
    <div class="form">

        <!--Форма личных данных для ИП-->

        <form action="#" method="post" id="form-pd-ip" name="form" class="form_body">
            <h1 class="form_title">Данные пользователя личного кабинета (ИП)</h1>

            <span id="resultInputs"></span>
            <!--Логин (почта)-->
            <div class="form_item" style="padding-bottom: 0">
                <label for="email" class="form_label">Ваш логин:</label>
                <input id="email" disabled type="email" placeholder="" name="email" class="form_input">
                <small>Error message</small>
            </div>

            <!--            <p><a href="#">Изменить логин</a></p>-->
            <!--            <p><a href="../pwd_reset_request_front.php">Изменить пароль</a></p>-->
            <button type="button" onclick="window.location.assign('changeLogin.php'); return false;">Изменить логин
            </button>
            <button type="button" onclick="window.location.assign('pwd_reset_request_front.php'); return false;">
                Изменить пароль
            </button>
            <!--            </div>-->


            <fieldset>
                <legend>
                    <h3>Персональные данные</h3>
                </legend>
                <div class="row">

                    <div class = "col-half" style="width: 10%;">
                        <div class="form_item">
                            <label class="form_label"><br></label>
                        <input type="text" disabled value="ИП" class="form_input">
                        </div>
                    </div>

                    <div class="col-half" style="width: 30%">
                        <!--Фамилия-->
                        <div class="form_item">

                            <label for="lastname" class="form_label">Фамилия:</label>
                            <input id="lastname" type="text" placeholder=" " name="lastname" class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#lastname').keyup(function () {
                                        setCookie("lastname", $('#lastname').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('lastname');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#lastname').val() == '') {
                                        $('#lastname').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <!--Имя-->
                    <div class="col-half" style="width: 30%">
                        <div class="form_item">
                            <label for="name" class="form_label">Имя:</label>
                            <input id="name" type="text" placeholder=" " name="name" class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#name').keyup(function () {
                                        setCookie("name", $('#name').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('name');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#name').val() == '') {
                                        $('#name').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <!--Отчество-->
                    <div class="col-half" style="width: 30%">
                        <div class="form_item">
                            <label for="middlename" class="form_label">Отчество:</label>
                            <input id="middlename" type="text" placeholder=" " name="middlename" class="form_input"
                                   style="margin-bottom: 0">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#middlename').keyup(function () {
                                        setCookie("middlename", $('#middlename').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('middlename');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#middlename').val() == '') {
                                        $('#middlename').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>

                            <div class="checkbox">
                                <input id="noMiddlename" type="checkbox" name="checkMiddlename" class="checkbox_input">
                                <label for="noMiddlename" class="checkbox_label">Нет отчества</label>
                            </div>

                        </div>
                    </div>
                </div>

                <!--Номер ОГРНИП-->
                <div class="row">
                    <div class="col-half">
                        <div class="form_item">
                            <label for="egrul_number" class="form_label">ОГРНИП:</label>
                            <input id="egrul_number" type="text" placeholder=" " name="egrul_number" class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#egrul_number').keyup(function () {
                                        setCookie("egrul_number", $('#egrul_number').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('egrul_number');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#egrul_number').val() == '') {
                                        $('#egrul_number').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <!--Дата внесения записи-->
                    <div class="col-half">
                        <div class="form_item">
                            <label for="egrul_data" class="form_label">Дата регистрации ИП:</label>
                            <input id="egrul_data" type="date" placeholder=" " name="egrul_data" class="form_input">
                            <small>Error message</small>
                        </div>
                    </div>
                </div>


                <!--Дата рождения-->
                <div class="row">
                    <div class="col-half">
                        <div class="form_item">
                            <label for="birth_date" class="form_label">Дата рождения:</label>
                            <input id="birth_date" type="date" placeholder=" " name="birth_date" class="form_input">
                            <small>Error message</small>
                        </div>
                    </div>

                    <!--Пол-->
                    <div class="col-half">
                        <div class="form_item" style="padding-left: 70px">
                            <div class="form_label">Укажите пол:</div>

                            <div class="form_radio_btn">
                                <input id="user_male" type="radio" name="user_sex" value="0">
                                <label for="user_male">Муж</label>
                            </div>

                            <div class="form_radio_btn">
                                <input id="user_female" type="radio" name="user_sex" value="1">
                                <label for="user_female">Жен</label>

                            </div>
                            <span id=radioValid hidden><br>Укажите ваш пол</span>

                        </div>
                    </div>
                </div>


                <!--Контактный телефон-->
                <div class="form_item">
                    <label for="contact_phone" class="form_label">Контактный телефон:</label>
                    <input id="contact_phone" type="text" placeholder=" " name="phone" class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#contact_phone').keyup(function () {
                                setCookie("contact_phone", $('#middlename').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('contact_phone');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#contact_phone').val() == '') {
                                $('#contact_phone').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <h3>Паспортные данные, ИНН, СНИЛС</h3>
                </legend>

                <!--Серия и номер паспорта-->
                <div class="form_item">
                    <label for="passport_numb" class="form_label">Серия и номер паспорта:</label>
                    <input id="passport_numb" type="text" placeholder=" " name="passport_numb" class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#passport_numb').keyup(function () {
                                setCookie("passport_numb", $('#passport_numb').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('passport_numb');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#passport_numb').val() == '') {
                                $('#passport_numb').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Дата выдачи паспорта-->
                <div class="form_item">
                    <label for="passport_date" class="form_label">Дата выдачи паспорта:</label>
                    <input id="passport_date" type="date" placeholder=" " name="passport_date" class="form_input">
                    <small>Error message</small>
                </div>

                <!--Кем выдан паспорт-->
                <div class="form_item">
                    <label for="passport_issued_by" class="form_label">Кем выдан паспорт:</label>
                    <textarea name="passport_issued_by" id="passport_issued_by" class="form_input"></textarea>
                    <small>Error message</small>
                </div>

                <!--Код подразделения паспорта-->
                <div class="form_item">
                    <label for="passport_code" class="form_label">Код подразделения:</label>
                    <input id="passport_code" type="text" placeholder=" " name="passport_code" class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#passport_code').keyup(function () {
                                setCookie("passport_code", $('#passport_code').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('passport_code');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#passport_code').val() == '') {
                                $('#passport_code').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--ИНН-->
                <div class="form_item">
                    <label for="inn_numb" class="form_label">ИНН:</label>
                    <input id="inn_numb" type="text" placeholder=" " name="inn_numb" class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#inn_numb').keyup(function () {
                                setCookie("inn_numb", $('#inn_numb').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('inn_numb');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#inn_numb').val() == '') {
                                $('#inn_numb').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--СНИЛС-->
                <div class="form_item">
                    <label for="snils_numb" class="form_label">CНИЛС:</label>
                    <input id="snils_numb" type="text" placeholder=" " name="snils_numb" class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#snils_numb').keyup(function () {
                                setCookie("snils_numb", $('#snils_numb').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('snils_numb');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#snils_numb').val() == '') {
                                $('#snils_num').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <h3>Адрес по месту постоянной регистрации</h3>
                </legend>

                <!--Регион-->
                <div class="form_item">
                    <label for="legal_address_region" class="form_label">Регион/район:</label>
                    <input id="legal_address_region" type="text" placeholder=" " name="legal_address_region"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#legal_address_region').keyup(function () {
                                setCookie("legal_address_region", $('#legal_address_region').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('legal_address_region');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#legal_address_region').val() == '') {
                                $('#legal_address_region').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Город-->
                <div class="form_item">
                    <label for="legal_address_location" class="form_label">Город/населенный пункт:</label>
                    <input id="legal_address_location" type="text" placeholder=" " name="legal_address_location"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#legal_address_location').keyup(function () {
                                setCookie("legal_address_location", $('#legal_address_location').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('legal_address_location');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#legal_address_location').val() == '') {
                                $('#legal_address_location').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Улица-->
                <div class="form_item">
                    <label for="legal_address_street" class="form_label">Улица:</label>
                    <input id="legal_address_street" type="text" placeholder=" " name="legal_address_street"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#legal_address_street').keyup(function () {
                                setCookie("legal_address_street", $('#legal_address_street').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('legal_address_street');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#legal_address_street').val() == '') {
                                $('#legal_address_street').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Дом, корпус-->
                <div class="form_item">
                    <label for="legal_address_building" class="form_label">Дом, корпус (при наличии):</label>
                    <input id="legal_address_building" type="text" placeholder=" " name="legal_address_building"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#legal_address_building').keyup(function () {
                                setCookie("legal_address_street", $('#legal_address_building').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('legal_address_building');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#legal_address_building').val() == '') {
                                $('#legal_address_building').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Квартира-->
                <div class="form_item">
                    <label for="legal_address_apart" class="form_label">Квартира (при наличии):</label>
                    <input id="legal_address_apart" type="text" placeholder=" " name="legal_address_apart"
                           class="form_input" style="margin-bottom: 0">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#legal_address_apart').keyup(function () {
                                setCookie("legal_address_apart", $('#legal_address_apart').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('legal_address_apart');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#legal_address_apart').val() == '') {
                                $('#legal_address_apart').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>

                    <!--Чекбокс если нет квартиры по прописке-->

                    <div class="checkbox">
                        <input id="noLegalApart" type="checkbox" name="checkLegalApart" class="checkbox_input">
                        <label for="noLegalApart" class="checkbox_label">Нет номера квартиры</label>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <h3>Фактический адрес проживания</h3>
                </legend>

                <div class="form_item">
                    <div class="checkbox">
                        <input id="same_address" type="checkbox" name="same_address"
                               onchange="fillSameAddressFunction()" class="checkbox_input">
                        <label for="same_address" class="checkbox_label">Совпадает с адресом постоянной
                            регистрации</label>
                    </div>
                </div>

                <!--Регион-->
                <div class="form_item">
                    <label for="real_address_region" class="form_label">Регион/район:</label>
                    <input id="real_address_region" type="text" placeholder=" " name="real_address_region"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#real_address_region').keyup(function () {
                                setCookie("real_address_region", $('#real_address_region').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('real_address_region');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#real_address_region').val() == '') {
                                $('#real_address_region').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Город-->
                <div class="form_item">
                    <label for="real_address_location" class="form_label">Город/населенный пункт:</label>
                    <input id="real_address_location" type="text" placeholder=" " name="real_address_location"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#real_address_location').keyup(function () {
                                setCookie("real_address_location", $('#real_address_location').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('real_address_location');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#real_address_location').val() == '') {
                                $('#real_address_location').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Улица-->
                <div class="form_item">
                    <label for="real_address_street" class="form_label">Улица:</label>
                    <input id="real_address_street" type="text" placeholder=" " name="real_address_street"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#real_address_street').keyup(function () {
                                setCookie("real_address_street", $('#real_address_street').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('real_address_street');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#real_address_street').val() == '') {
                                $('#real_address_street').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Дом, корпус-->
                <div class="form_item">
                    <label for="real_address_building" class="form_label">Дом, корпус (при наличии):</label>
                    <input id="real_address_building" type="text" placeholder=" " name="real_address_building"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#real_address_building').keyup(function () {
                                setCookie("real_address_building", $('#real_address_building').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('real_address_building');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#real_address_building').val() == '') {
                                $('#real_address_building').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Квартира-->
                <div class="form_item">
                    <label for="real_address_apart" class="form_label">Квартира (при наличии):</label>
                    <input id="real_address_apart" type="text" placeholder=" " name="real_address_apart"
                           class="form_input" style="margin-bottom: 0">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#real_address_building').keyup(function () {
                                setCookie("real_address_apart", $('#real_address_apart').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('real_address_apart');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#real_address_apart').val() == '') {
                                $('#real_address_apart').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>

                    <!--Чекбокс если нет квартиры по факт адресу-->
                    <div class="checkbox">
                        <input id="noRealApart" type="checkbox" name="checkRealApart" class="checkbox_input">
                        <label for="noRealApart" class="checkbox_label">Нет номера квартиры</label>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <h3>Банковские реквизиты (при наличии)</h3>
                </legend>

                <!-- Расчетный счет -->
                <div class="form_item">
                    <label for="check_account_number" class="form_label">Номер расчетного счета:</label>
                    <input id="check_account_number" type="text" placeholder=" " name="check_account_number"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#check_account_number').keyup(function () {
                                setCookie("check_account_number", $('#check_account_number').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('check_account_number');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#check_account_number').val() == '') {
                                $('#check_account_number').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!-- Название банка -->
                <div class="form_item">
                    <label for="bank_name" class="form_label">Наименование банка:</label>
                    <input id="bank_name" type="text" placeholder=" " name="bank_name"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#bank_name').keyup(function () {
                                setCookie("bank_name", $('#bank_name').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('bank_name');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#bank_name').val() == '') {
                                $('#bank_name').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!-- БИК -->
                <div class="form_item">
                    <label for="bank_bic" class="form_label">БИК:</label>
                    <input id="bank_bic" type="text" placeholder=" " name="bank_bic"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#bank_bic').keyup(function () {
                                setCookie("bank_bic", $('#bank_bic').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('bank_bic');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#bank_bic').val() == '') {
                                $('#bank_bic').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!-- Кор счет  -->
                <div class="form_item">
                    <label for="bank_correspond" class="form_label">Корреспондентский счет:</label>
                    <input id="bank_correspond" type="text" placeholder=" " name="bank_correspond"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#bank_correspond').keyup(function () {
                                setCookie("bank_correspond", $('#bank_correspond').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('bank_correspond');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#bank_correspond').val() == '') {
                                $('#bank_correspond').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!-- Форма налогообложения-->
                <div class="form_item">
                    <div class="form_label">Форма налогообложения:</div>
                    <div class="form_radio_btn">
                        <input id="common_form" type="radio" name="tax_form" value="0">
                        <label for="common_form">Общий режим налогообложения</label>
                    </div>

                    <div class="form_radio_btn">
                        <input id="simplified_form" type="radio" name="tax_form" value="1">
                        <label for="simplified_form">Упрощенная система налогообложения</label>

                    </div>
                </div>
            </fieldset>

            <h3>Прикрепить документы здесь</h3>
            <div class="form_upload">

                <div class="upload_box">
                    <div class="upload_image" style="display: none;">
                        <img src="images/Ajax-loader.gif" style="width: 16px; height: 16px;">
                    </div>
                    <p>Поддерживаемые форматы файлов: PDF, JPEG, JPG, PNG</p>
                    <input type="file" id="input-file-upload" multiple style="display: none">
                    <div class="upload_click">Выбрать</div>
                </div>
            </div>


            <div id="server-response" style="overflow:auto;display:flex;flex-wrap:wrap;width:100%;"></div>

            <div class="form_item">
                <div class="checkbox">
                    <input type="checkbox" class="checkbox_input" id="formAgreement" name="formAgreement">

                    <!--здесь надо перенаправить на документ-->
                    <label for="formAgreement">Подтверждаю свое согласие на обработку персональных данных</label>
                </div>
                <span id="agreementError"></span>
            </div>

            <button type="submit" id="pd-submit" class="pd-submit" name="pd-submit">Отправить на проверку</button>

        </form>
    </div>
</div>
</body>
<script>
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////// Скрипт для загрузки файлов
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(function () {

        //прикрепить обработчик кликов к загрузчику
        $('.upload_click').click(function () {
            $('#input-file-upload').trigger('click');
        });

        //прикрепить обработчик изменений к файлу
        $('#input-file-upload').change(function () {

            //проверка поддерживается ли file api браузером
            if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
                window.alert("Не удалось загрузить файл, т.к. это не поддерживается данным браузером");
                return;
            }

            //создать новый файл ридер
            let fileReader = new FileReader();

            //создаем фильтр для формата файла
            let filter = /^(?:image\/jpeg|image\/jpg|image\/png|application\/pdf)$/i;

            //удостовериться что файл был загружен
            if (this.files.length == 0) {
                window.alert("Загрузите файл");
                return;
            }

            let file = this.files[0];
            let size = file.size;
            let type = file.type;


            //удостоверится что загруженный файл - картинка
            if (!filter.test(type)) {
                window.alert("Неподдерживаемый формат файла");
                return;
            }

            let max = 2000000;

            //проверка что файл не более 2 мб
            // if (size > max) {
            //     window.alert("Файл должен быть не более 2Мб");
            //     return;
            // }

            //показываем картинку загрузки
            $('.upload_image').show();

            //скрываем страницу загрузки
            $('.upload_click').hide();

            //создать новый formData
            let formData = new FormData();
            formData.append('image_data', file);

            //загружаем через аджакс и получаем в ответ какой тип и сколько страниц
            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                url: 'upload_file.php',
                data: formData,
                dataType: 'json',
                success: function (response) {

                    //показываем ответ
                    if (response.type == 'pdf') {
                        $('.upload_image').hide();
                        $('.upload_click').show()
                        //если многостраничный пдф то парсим каждую страницу
                        startPDFparsing(response.msg);


                    } else if (response.type == 'image_success') {
                        $('.upload_image').hide();
                        $('.upload_click').show();
                        $("#server-response").html('<div class = success>' + response.msg + '</div>');

                    } else {
                        $("#server-response").html('<div class = "error">' + response.msg + '</div>')
                    }
                }
            })
        })
    })


</script>

<script>

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////// Скрипт для автозаполнения почты из сессии
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //Отображать заполненные логин и пароль из сессии
    document.addEventListener("DOMContentLoaded", function () {


        $.ajax({
            url: 'personal_account_page.php',
            method: 'get',
            dataType: 'json',
            success: function (response) {
                if (response.type == "success") {
                    $('#email').val(response.msg);
                } else if (response.type == "errorReg") {
                    window.location = 'reg_page_front.php';
                } else if (response.type == 'errorAuth') {
                    window.location = 'auth_page_front.php';
                }
            }
        })
    });
</script>

<script>

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////// Скрипт для автоматического заполнения полей при отметке чекбоксов
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //    Сделать неактивным поле отчество и очистить поле если отмечено что нет
    document.getElementById('noMiddlename').addEventListener('click', function () {
        let middlenameInput = document.getElementById("middlename");
        if (document.getElementById("noMiddlename").checked) {
            middlenameInput.disabled = true;
            middlenameInput.value = "-";
        } else {
            middlenameInput.disabled = false;
            middlenameInput.value = "";
        }
    });

    //Сделать неактивным поле номер квартиры по прописке и очистить поле если отмечено что нет
    document.getElementById('noLegalApart').addEventListener('click', function () {
        let legalApart = document.getElementById('legal_address_apart');
        if (document.getElementById('noLegalApart').checked) {
            legalApart.disabled = true;
            legalApart.value = "-";
        } else {
            legalApart.disabled = false;
            legalApart.value = "";
        }
    });

    //Сделать неактивным поле номер квартиры фактического адреса и очистить поле если отмечено что нет
    document.getElementById('noRealApart').addEventListener('click', function () {
        let realApart = document.getElementById('real_address_apart');
        if (document.getElementById('noRealApart').checked) {
            realApart.disabled = true;
            realApart.value = "-";
        } else {
            realApart.disabled = false;
            realApart.value = "";
        }
    });

    // Заполнение почтового адреса
    function fillSameAddressFunction() {
        if (document.getElementById('same_address').checked) {
            document.getElementById('real_address_region').value = document.getElementById('legal_address_region').value;
            document.getElementById('real_address_location').value = document.getElementById('legal_address_location').value;
            document.getElementById('real_address_street').value = document.getElementById('legal_address_street').value;
            document.getElementById('real_address_building').value = document.getElementById('legal_address_building').value;
            document.getElementById('real_address_apart').value = document.getElementById('legal_address_apart').value;
            if (document.getElementById('noLegalApart').checked) {
                document.getElementById('noRealApart').checked = true;
            }
        } else {
            document.getElementById('real_address_region').value = '';
            document.getElementById('real_address_location').value = '';
            document.getElementById('real_address_street').value = '';
            document.getElementById('real_address_building').value = '';
            document.getElementById('real_address_apart').value = '';

        }
    }

</script>

<script>

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////// Скрипт для валидации полей
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const user_sex = document.getElementsByName('user_sex');
    const form= document.getElementById('form-pd-ip');



    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let err = checkInputs();
        if (err === 0) {
            $.ajax({
                url: 'personal_account_page.php',
                method: 'post',
                dataType: 'html',
                data: $(this).serialize(),
                success: [function (data) {
                    if (data == "success") {
                        $('#resultInputs').html('Success');

                    } else if (data == "errorReg") {
                        window.location = 'reg_page_front.php';
                    }
                }]
            });
        }
    }

    function checkInputs() {

        let err = 0;

        //обязательные проверки

        if ($("#formAgreement").prop("checked") == false) {
            $('#agreementError').html('Вы не дали своего согласия на обработку персональных данных');
            err++
        } else {
            $('#agreementError').html('');
        }


        if (user_sex[0].checked == false && user_sex[1].checked == false) {
            $('#radioValid').show();
            err++;
        } else {
            $('#radioValid').hide();
        }

        return err;
    }



</script>

<script>
    //загрузка документов

    const file = document.getElementById('file');
    const filePreview = document.getElementById('file')


</script>

<script src = "site_html/addressSuggestions.js"></script>

</html>