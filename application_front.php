<!doctype html>
<html lang="ru">
<head>
    <link href="/site_html/style.css" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- Masked input lib-->
    <script src="/jquery.maskedinput-master/dist/jquery.maskedinput.js" type="text/javascript"></script>


    <script src="/cleave.js-master/dist/cleave.min.js"></script>

    <!-- Address suggestions lib-->
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">


    <title>Подача заявки</title>
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

<div class="application_page">
    <div class="form">

        <!--Форма подачи заявки потребителем-->

        <form action="#" method="post" id="form-apply" name="form" class="form_body">
            <h1 class="form_title">Заявка на технологическое присоединение</h1>
            <span id="resultInputs"></span>


            <!--Вид заявки-->
            <fieldset style="border:none;">
                <div class="form_item">
                    <div class="form_label">Причина подачи заявки*:</div>
                    <select name="apply_type" class="select" id="select_type_apply" required="">
                        <option value="" disabled>Выберите из списка:</option>
                        <option value="Новое строительство">Новое строительство</option>
                        <option value="Увеличение мощности">Увеличение объема максимальной мощности</option>
                        <option value="Уменьшение мощности">Уменьшение объема максимальной мощности</option>
                        <small>Error message</small>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <h3>Общая информация об энергопринимающем устройстве</h3>
                </legend>

                <!--Тип ТОО-->
                <div class="form_item">
                    <label for="object_type" class="form_label">Тип ТОО:</label>
                    <input id="object_type" type="text" placeholder="Например: жилое помещение" name="object_type"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#object_type').keyup(function () {
                                setCookie("object_type", $('#object_type').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('object_type');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#object_type').val() == '') {
                                $('#object_type').val(x);
                            }
                        }
                    </script>

                    <small>Error message</small>

                </div>

                <!--Наименование энергопринимающего устройства-->
                <div class="form_item">
                    <label for="object_name" class="form_label">Наименование энергопринимающего устройства:</label>
                    <input id="object_name" type="text" placeholder="Например: дом" name="object_name"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#object_name').keyup(function () {
                                setCookie("object_name", $('#object_name').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('object_name');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#object_name').val() == '') {
                                $('#object_name').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

            </fieldset>

            <fieldset>
                <legend>
                    <h3>Адрес энергопринимающего устройства</h3>
                </legend>
                <!--Регион-->
                <div class="form_item">
                    <label for="object_address_region" class="form_label">Регион/район:</label>
                    <input id="object_address_region" type="text" placeholder="Например: Республика Башкортостан"
                           name="object_address_region"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#object_address_region').keyup(function () {
                                setCookie("object_address_region", $('#object_address_region').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('object_address_region');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#object_address_region').val() == '') {
                                $('#object_address_region').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Город-->
                <div class="form_item">
                    <label for="object_address_location" class="form_label">Город/населенный пункт:</label>
                    <input id="object_address_location" type="text" placeholder="Например: д. Шмидтово"
                           name="object_address_location"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#object_address_location').keyup(function () {
                                setCookie("object_address_location", $('#object_address_location').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('object_address_location');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#object_address_location').val() == '') {
                                $('#object_address_location').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Улица-->
                <div class="form_item">
                    <label for="object_address_street" class="form_label">Улица:</label>
                    <input id="object_address_street" type="text" placeholder="Например: ул. Архангельская"
                           name="object_address_street"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#object_address_street').keyup(function () {
                                setCookie("object_address_street", $('#object_address_street').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('object_address_street');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#object_address_street').val() == '') {
                                $('#object_address_street').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

                <!--Дом, корпус-->
                <div class="form_item">
                    <label for="object_address_building" class="form_label">Дом*, корпус (при наличии):</label>
                    <input id="object_address_building" type="text" placeholder="Например: д. 1/1"
                           name="object_address_building"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#object_address_building').keyup(function () {
                                setCookie("object_address_building", $('#object_address_building').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('object_address_building');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#object_address_building').val() == '') {
                                $('#object_address_building').val(x);
                            }
                        }
                    </script>

                    <h6>* В случае, если номер дома еще не присвоен, указать номер участка</h6>
                    <small>Error message</small>
                </div>
            </fieldset>

            <!--Квартира-->
            <!--            <div class="form_item">-->
            <!--                <label for="object_address_apart" class="form_label">Квартира (при наличии):</label>-->
            <!--                <input id="object_address_apart" type="text" placeholder="Например: кв. 1" name="object_address_apart"-->
            <!--                       class="form_input">-->
            <!--                <small>Error message</small>-->
            <!--                <span id="result"></span>-->
            <!--            </div>-->

            <!--Чекбокс если нет квартиры -->
            <!--            <div class="form_item">-->
            <!--                <div class="checkbox">-->
            <!--                    <input id="noObjectApart" type="checkbox" name="checkObjectApart" class="checkbox_input">-->
            <!--                    <label for="noObjectApart" class="checkbox_label">Нет номера квартиры</label>-->
            <!--                </div>-->
            <!--            </div>-->

            <fieldset>
                <legend>
                    <h3>Информация о праве собственности</h3>
                </legend>
                <!--Кадастровый номер объекта-->
                <div class="form_item">
                    <label for="cad_number" class="form_label">Кадастровый номер объекта:</label>
                    <input id="cad_number" type="text" placeholder="Например: 02:47:130801:1111" name="cad_number"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#cad_number').keyup(function () {
                                setCookie("cad_number", $('#cad_number').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('cad_number');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#cad_number').val() == '') {
                                $('#cad_number').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                    <span id="resultCadNumber"></span>

                    <!--Чекбокс если нет кад номера -->
                    <div class="checkbox">
                        <input id="noCadNumber" type="checkbox" name="checkCadNumber" class="checkbox_input">
                        <label for="noCadNumber" class="checkbox_label">Нет кадастрового номера</label>
                    </div>

                </div>

                <!--Условный номер объекта-->
                <div class="uslov_number" style="display: none;margin-bottom: 20px;">
                    <label for="uslov_number" class="form_label">Условный номер объекта:</label>
                    <input id="uslov_number" type="hidden"
                           placeholder="Например: 31:16:0:0034:043679-00/003:0001/А2/0079"
                           name="uslov_number"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#uslov_number').keyup(function () {
                                setCookie("uslov_number", $('#uslov_number').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('uslov_number');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#uslov_number').val() == '') {
                                $('#uslov_number').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>


                <!--Номер и дата выдачи прав собственности-->
                <div class="form_item">
                    <label for="own_number" class="form_label">Вид, номер и дата государственной регистрации права на
                        объект:</label>
                    <textarea id="own_number" type="textarea"
                              placeholder="Например: Собственность №02:47:130801:111-02/100/2022-1 от 01.01.2022"
                              name="own_number"
                              class="form_input"></textarea>
                    <small>Error message</small>
                </div>

            </fieldset>


            <fieldset>
                <legend>
                    <h3>Информация о мощности и напряжении энергопринимающих устройств (ЭУ)</h3>
                </legend>

                <!--максимальная мощность ранее присоединенных и присоединяемых ЭУ (общее)-->
                <div class="row">
                    <div class="col-half" style="width: 40%">
                        <div class="watt_total" style="display: none;margin-bottom: 20px;">
                            <label for="watt_total" class="form_label">Максимальная мощность <b>ранее присоединенных и
                                    присоединяемых</b> ЭУ:</label>
                            <input id="watt_total" type="hidden" placeholder="Например: 15" name="watt_total"
                                   class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#watt_total').keyup(function () {
                                        setCookie("watt_total", $('#watt_total').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('watt_total');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#watt_total').val() == '') {
                                        $('#watt_total').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <div class="col-half-measure" style="width: 10%; display: none">
                        <div class="form_item">
                            <label class="form_label"><br><br></label>
                            <input type="text" id="measure" disabled value="кВт" class="form_input"
                                   style="border: none; background-color: #ffffff; font-size: 14px; font-weight: bold">
                        </div>
                    </div>

                    <!--напряжение ранее присоединенных и присоединяемых ЭУ (общее)-->
                    <div class="col-half" style="width: 40%">
                        <div class="volt_total" style="display: none;margin-bottom: 20px;">
                            <label for="volt_total" class="form_label"><br>при напряжении:</label>
                            <input id="volt_total" type="hidden" placeholder="Например: 0,4" name="volt_total"
                                   class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#volt_total').keyup(function () {
                                        setCookie("volt_total", $('#volt_total').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('volt_total');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#volt_total').val() == '') {
                                        $('#volt_total').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <div class="col-half-measure" style="width: 10%;display: none">
                        <div class="form_item">
                            <label class="form_label"><br><br></label>
                            <input type="text" id="measure" disabled value="кВ" class="form_input"
                                   style="border: none; background-color: #ffffff; font-size: 14px; font-weight: bold">
                        </div>
                    </div>

                </div>

                <!--максимальная мощность присоединяемых ЭУ-->
                <div class="row">
                    <div class="col-half" style="width: 40%">
                        <div class="form_item">
                            <label for="watt_after" class="form_label">Максимальная мощность <b><br>присоединяемых</b>
                                ЭУ:</label>
                            <input id="watt_after" type="text" placeholder="Например: 15" name="watt_after"
                                   class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#watt_after').keyup(function () {
                                        setCookie("watt_after", $('#watt_after').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('watt_after');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#watt_after').val() == '') {
                                        $('#watt_after').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <div class="col-half" style="width: 10%;">
                        <div class="form_item">
                            <label class="form_label"><br><br></label>
                            <input type="text" disabled value="кВт" class="form_input"
                                   style="border: none; background-color: #ffffff; font-size: 14px; font-weight: bold">
                        </div>
                    </div>


                    <!--напряжение присоединяемых ЭУ-->
                    <div class="col-half" style="width: 40%">
                        <div class="form_item">
                            <label for="volt_after" class="form_label"><br>при напряжении:</label>
                            <input id="volt_after" type="text" placeholder="Например: 0,4" name="volt_after"
                                   class="form_input" onKeyUp="replacement()">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#volt_after').keyup(function () {
                                        setCookie("volt_after", $('#volt_after').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('volt_after');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#volt_after').val() == '') {
                                        $('#volt_after').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <div class="col-half" style="width: 10%;">
                        <div class="form_item">
                            <label class="form_label"><br><br></label>
                            <input type="text" disabled value="кВ" class="form_input"
                                   style="border: none; background-color: #ffffff; font-size: 14px; font-weight: bold">
                        </div>
                    </div>

                </div>
                <!--максимальная мощность ранее присоединенных ЭУ-->

                <div class="row">
                    <div class="col-half" style="width: 40%">
                        <div class="watt_before" style="display: none;margin-bottom: 20px;">
                            <label for="watt_before" class="form_label">Максимальная мощность <b>ранее присоединенных </b>ЭУ:</label>
                            <input id="watt_before" type="hidden" placeholder="Например: 5" name="watt_before"
                                   class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#watt_before').keyup(function () {
                                        setCookie("watt_before", $('#watt_before').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('watt_before');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#watt_before').val() == '') {
                                        $('#watt_before').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <div class="col-half-measure" style="width: 10%; display: none">
                        <div class="form_item">
                            <label class="form_label"><br><br></label>
                            <input type="text" id="measure" disabled value="кВт" class="form_input"
                                   style="border: none; background-color: #ffffff; font-size: 14px; font-weight: bold">
                        </div>
                    </div>


                    <!--напряжение ранее присоединенных ЭУ-->
                    <div class="col-half" style="width: 40%">
                        <div class="volt_before" style="display: none;margin-bottom: 20px;">
                            <label for="volt_before" class="form_label"><br>при напряжении:</label>
                            <input id="volt_before" type="hidden" placeholder="Например: 0,4" name="volt_before"
                                   class="form_input">
                            <script>
                                // при вводе текста будет сохраняться куки
                                $(function () {
                                    $('#volt_before').keyup(function () {
                                        setCookie("volt_before", $('#volt_before').val(), 1);
                                    });
                                });

                                // восстановить данные из куков
                                var x = getCookie('volt_before');
                                if (x) {
                                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                                    if ($('#volt_before').val() == '') {
                                        $('#volt_before').val(x);
                                    }
                                }
                            </script>
                            <small>Error message</small>
                        </div>
                    </div>

                    <div class="col-half-measure" style="width: 10%;display: none">
                        <div class="form_item">
                            <label class="form_label"><br><br></label>
                            <input type="text" id="measure" disabled value="кВ" class="form_input"
                                   style="border: none; background-color: #ffffff; font-size: 14px; font-weight: bold">
                        </div>
                    </div>

                </div>
                <!--категория надежности-->
                <div class="form_item">
                    <div class="form_label">Категория надежности электроснабжения:</div>
                    <div class="form_radio_btn">
                        <input id="category1" type="radio" name="secure_category" value="1" checked>
                        <label for="category1">I категория</label>
                    </div>

                    <div class="form_radio_btn">
                        <input id="category2" type="radio" name="secure_category" value="2">
                        <label for="category2">II категория</label>
                    </div>

                    <div class="form_radio_btn">
                        <input id="category3" type="radio" checked name="secure_category" value="3">
                        <label for="category3">III категория</label>
                    </div>

                </div>

            </fieldset>


            <fieldset>
                <legend>
                    <h3>Информация о сроках проектирования и введения в эксплуатацию объекта</h3>
                </legend>

                <!--этапы проектирования-->
                <div class="form_item">
                    <label for="project_steps" id="project_steps" class="form_label">Сроки проектирования и поэтапного
                        введения в эксплуатацию
                        объекта, планируемого поэтапного распределения мощности:</label>
                    <table id="project_steps_table">
                        <tr>
                            <th scope="col">Этап (очередь) строительства</th>
                            <th scope="col">Планируемый срок проектирования энергопринимающих устройств (месяц, год)
                            </th>
                            <th scope="col">Планируемый срок введения энергопринимающих устройств в эксплуатацию (месяц,
                                год)
                            </th>
                            <th scope="col">Максимальная мощность энергопринимающих устройств (кВт)</th>
                            <th scope="col">Категория надежности энергопринимающих устройств</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input type="month" id="plan_term_project_1" class="table_input"
                                       name="plan_term_project_1">
                            </td>
                            <td><input type="month" id="plan_term_end_1" class="table_input" name="plan_term_end_1">
                            </td>
                            <td><input type="text" id="max_watt_1" class="table_input" placeholder="Например: 15"
                                       name="max_watt_1" style="width: 100px; font-size: 12px;"></td>
                            <td><input type="text" id="secure_categ_1" class="table_input" placeholder="Например: 3"
                                       name="secure_categ_1" style="width: 100px; font-size: 12px;"></td>
                        </tr>
                        <span id="resultTable"></span>
                    </table>
                    <button type="button" onclick="myCreateFunction()">Добавить</button>
                    <button type="button" onclick="myDeleteFunction()">Удалить</button>

                </div>

            </fieldset>


            <fieldset>
                <legend>
                    <h3>Информация о гарантирующем поставщике электрической энергии</h3>
                </legend>

                <!--наименование гарантирующего поставщика-->
                <div class="form_item">
                    <label for="garant_supplier" class="form_label">Наименование гарантирующего поставщика:</label>
                    <input id="garant_supplier" type="text" placeholder='Например: ООО "ЭСКБ"' name="garant_supplier"
                           class="form_input">
                    <script>
                        // при вводе текста будет сохраняться куки
                        $(function () {
                            $('#garant_supplier').keyup(function () {
                                setCookie("garant_supplier", $('#garant_supplier').val(), 1);
                            });
                        });

                        // восстановить данные из куков
                        var x = getCookie('garant_supplier');
                        if (x) {
                            // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                            if ($('#garant_supplier').val() == '') {
                                $('#garant_supplier').val(x);
                            }
                        }
                    </script>
                    <small>Error message</small>
                </div>

            </fieldset>

            <fieldset>
                <legend>
                    <h3>Прикрепить документы</h3>
                </legend>
                <div class="form_upload">
                    <div class="upload_box">
                        <div class="upload_image" style="display: none;">
                            <img src="/images/Ajax-loader.gif" style="width: 16px; height: 16px;">
                        </div>
                        <p>Поддерживаемые форматы файлов: PDF, JPEG, JPG, PNG</p>
                        <input type="multipart/form-data" id="input-file-upload" style="display: none">

                        <div class="upload_click">Выбрать</div>
                    </div>
                </div>

                <div id="server-response" style="overflow:auto;display:flex;flex-wrap:wrap;width:100%;"></div>
            </fieldset>

            <button type="submit" id="pd-submit" class="pd-submit" name="pd-submit">Отправить заявку</button>
        </form>
    </div>
</div>

</body>
<script>
    function myCreateFunction() {
        var table = document.getElementById("project_steps_table");

        var row = table.insertRow();
        var cell1 = row.insertCell();
        var cell2 = row.insertCell();
        var cell3 = row.insertCell();
        var cell4 = row.insertCell();
        var cell5 = row.insertCell();

        let i = countRows(table);

        var cell2HTML = '<input type="month" id="plan_term_project_' + i + '" class="table_input" name="plan_term_project_' + i + '" style="width: 100px; font-size: 12px;">';
        var cell3HTML = '<input type="month" id="plan_term_end_' + i + '" class="table_input" name="plan_term_end_' + i + '" style="width: 100px; font-size: 12px;">';
        var cell4HTML = '<input type="text" id="max_watt_' + i + '" class="table_input" placeholder="Например: 15" name="max_watt_' + i + '" style="width: 100px; font-size: 12px;">';
        var cell5HTML = '<input type="text" id="secure_categ_' + i + '" class="table_input" placeholder="Например: 3" name="secure_categ_' + i + '" style="width: 100px; font-size: 12px;">';

        cell1.innerHTML = $('#project_steps_table tr').length - 1;
        cell2.innerHTML = cell2HTML;
        cell3.innerHTML = cell3HTML;
        cell4.innerHTML = cell4HTML;
        cell5.innerHTML = cell5HTML;
    }

    function myDeleteFunction() {
        document.getElementById("project_steps_table").deleteRow($('#project_steps_table tr').length - 1);
    }

    function countRows(table) {
        let i = table.rows.length - 1;
        return i;
    }

</script>

<script>
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////// Скрипт для автоматического заполнения полей при отметке чекбоксов (пока не используется)
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //    //    Сделать неактивным поля адреса и вставить - в  поле если отмечено что нет
    //    document.getElementById('noObjectAddress').addEventListener('click', function () {
    //        let streetInput = document.getElementById("object_address_street");
    //        let buildingInput = document.getElementById("object_address_building");
    //        let apartInput = document.getElementById("object_address_apart");
    //        if (document.getElementById("noObjectAddress").checked) {
    //            streetInput.disabled = true;
    //            buildingInput.disabled = true;
    //            apartInput.disabled = true;
    //            streetInput.value = "-";
    //            buildingInput.value = "-";
    //            apartInput.value = "-";
    //        } else {
    //            streetInput.disabled = false;
    //            buildingInput.disabled = false;
    //            apartInput.disabled = false;
    //            streetInput.value = "";
    //            buildingInput.value = "";
    //            apartInput.value = "";
    //        }
    //    });
    //
    //
    // //   Сделать неактивным поле номер квартиры и вставить - в  поле если отмечено что нет
    //    document.getElementById('noObjectApart').addEventListener('click', function () {
    //        let objectApart = document.getElementById('object_address_apart');
    //        if (document.getElementById('noObjectApart').checked) {
    //            objectApart.disabled = true;
    //            objectApart.value = "-";
    //        } else {
    //            objectApart.disabled = false;
    //            objectApart.value = "";
    //        }
    //    });

    //Показать поле с вводом условного номера если отмечено что нет кадастрового
    document.getElementById('noCadNumber').addEventListener('click', function () {
        let cad_number = document.getElementById('cad_number');
        let uslov_number = document.getElementById('uslov_number');
        if (document.getElementById('noCadNumber').checked) {
            cad_number.disabled = true;
            cad_number.value = "-";
            uslov_number.setAttribute("type", "input");
            $('.uslov_number').show();
        } else {
            cad_number.disabled = false;
            cad_number.value = "";
            uslov_number.setAttribute("type", "hidden");
            $('.uslov_number').hide();
        }
    });

    //Показать поле с вводом данных о ранее присоединенных и общих мощностях при выборе типа заявки - увеличение или уменьшение мощности
    document.getElementById('select_type_apply').addEventListener('click', function () {
        let watt_before = document.getElementById('watt_before');
        let volt_before = document.getElementById('volt_before');
        let watt_total = document.getElementById('watt_total');
        let volt_total = document.getElementById('volt_total');
        let select_type = document.getElementById('select_type_apply');
        if (select_type.value === "Увеличение мощности" || select_type.value === "Уменьшение мощности") {
            watt_before.setAttribute("type", "input");
            volt_before.setAttribute("type", "input");
            watt_total.setAttribute("type", "input");
            volt_total.setAttribute("type", "input");
            $('.watt_before').show();
            $('.volt_before').show();
            $('.watt_total').show();
            $('.volt_total').show();
            $('.col-half-measure').show();
        } else {
            watt_before.setAttribute("type", "hidden");
            volt_before.setAttribute("type", "hidden");
            watt_total.setAttribute("type", "hidden");
            volt_total.setAttribute("type", "hidden");
            $('.watt_before').hide();
            $('.volt_before').hide();
            $('.watt_total').hide();
            $('.volt_total').hide();
            $('.col-half-measure').hide();
        }
    });

    //Замена запятой на точку

    function replacement() {
        let voltAfter = document.getElementById('volt_after').value.replace(/\,/g, '.');
        $("#volt_after").val(voltAfter);
    }
</script>

<script>

</script>


<script>

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////// Скрипт для валидации полей
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // проверка валидности полей, вывод ошибок



    const form = document.getElementById('form-apply');


    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();


            $.ajax({
                url: '/application.php',
                method: 'POST',
                dataType: 'html',
                data: $(this).serialize(),
                success: [function (data) {
                    if (data == "success") {

                        // эт все не надо
                        $('#resultTable').html('');
                        $('#resultInputs').html('');
                        $('#resultCadNumber').html('');

                    } else if (data == "emptyRows") {
                        $('#resultTable').html('Таблица должна содержать хотя бы одну заполненную строку');
                        // $('#project_steps_table,th,td').css ('border-color', 'red');
                    } else if (data == "emptyInputs") {
                        $('#resultInputs').html('Заполнены не все поля!');
                        $('#resultTable').html('');
                        $('#resultCadNumber').html('');
                    } else if (data == "wrongCadNumber") {
                        $('#resultCadNumber').html('Неверный кадастровый номер объекта');
                        $('#resultInputs').html('');
                        $('#resultTable').html('');
                    }
                }]
            });
        }




</script>


<script src="site_html/addressSuggestions.js"></script>
</html>