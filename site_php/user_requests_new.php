<script src="site_html/cookies.js"></script>

<!-- Address suggestions lib-->
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>

<script src="site_html/addressSuggestions.js"></script>


<div class="request_new_form">
    <form action="#" method="post" id="form-request">
        <h2>Подать заявку на технологическое присоединение</h2>

        <div style="display:flex;">
            <div style="flex:40%;align-items: center;display:flex;">Причина подачи заявки:</div>
            <div style="flex:60%"><select name="request_type" id="request_type" class="form_input" required>
                    <option selected style='color:gray;' disabled value="0">Выберите из списка</option>
                    <option value="1">Новое строительство</option>
                    <option value="2">Увеличение объема максимальной мощности</option>
                    <option value="3">Уменьшение объема максимальной мощности</option>
                </select></div>
        </div>

        <?php
        $user = db_selectOne('user', ['id' => $_SESSION['front_id']]);
        $juridical_form = $user['juridical_form'];

        switch ($juridical_form) {
            case 1:
                require_once("user_data_fl.php");
                break;
            case 2:
                require_once("user_data_ip.php");
                break;
            case 3:
                require_once("user_data_ul.php");
                break;
        }

        ?>

        <fieldset>
            <legend>
                <h3>Общая информация об энергопринимающем устройстве</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Тип ТОО:</div>
                <div style="flex:60%"><input id="object_type" type="text" placeholder="Например: жилое помещение"
                                             name="object_type" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Наименование энергопринимающего устройства:
                </div>
                <div style="flex:60%"><input id="object_name" type="text" placeholder="Например: дом" name="object_name"
                                             class="form_input"></div>
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
            </div>
        </fieldset>


        <fieldset>
            <legend>
                <h3>Адрес энергопринимающего устройства</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Регион/район:</div>
                <div style="flex:60%"><input id="object_address_region" type="text"
                                             placeholder="Например: Республика Башкортостан, Уфимский р-н"
                                             name="object_address_region" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Город/населенный пункт:</div>
                <div style="flex:60%"><input id="object_address_location" type="text"
                                             placeholder="Например: д. Шмидтово"
                                             name="object_address_location" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Улица:</div>
                <div style="flex:60%"><input id="object_address_street" type="text"
                                             placeholder="Например: ул. Архангельская" name="object_address_street"
                                             class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Дом*, корпус (при наличии):</div>
                <div style="flex:60%"><input id="object_address_building" type="text" placeholder="Например: д. 1/1"
                                             name="object_address_building" class="form_input"></div>
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
            </div>
            <h6>* В случае, если номер дома еще не присвоен, указать номер участка</h6>
        </fieldset>


        <fieldset>
            <legend>
                <h3>Информация о праве собственности</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Кадастровый номер объекта:</div>
                <div style="flex:60%"><input id="cad_number" type="text" placeholder="Например: 02:47:130801:1111"
                                             name="cad_number" class="form_input"></div>
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
            </div>

            <!--Чекбокс если нет кад номера -->
            <div class="checkbox">
                <input id="noCadNumber" type="checkbox" name="checkCadNumber" class="checkbox_input">
                <label for="noCadNumber" class="checkbox_label">Нет кадастрового номера</label>
            </div>

            <div style="display:none;margin-top:10px;" id="uslov_number_input">
                <div style="flex:40%;align-items: center;display:flex;">Условный номер объекта:</div>
                <div style="flex:60%"><input id="uslov_number" type="text"
                                             placeholder="Например: 31:16:0:0034:043679-00/003:0001/А2/0079"
                                             name="uslov_number" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Вид, номер и дата государственной регистрации
                    права на объект:
                </div>
                <div style="flex:60%"><input id="own_number" type="textarea"
                                             placeholder="Например: Собственность №02:47:130801:111-02/100/2022-1 от 01.01.2022"
                                             name="own_number" class="form_input"></div>
            </div>
        </fieldset>


        <fieldset>
            <legend>
                <h3>Информация о мощности и напряжении энергопринимающих устройств (ЭУ)</h3>
            </legend>

            <!--максимальная мощность ранее присоединенных и присоединяемых ЭУ (общее)-->
            <div style="display:none;margin-top:10px;" id="watt_total_input">
                <div style="flex:40%;align-items: center;display:flex;">Максимальная мощность <b>ранее присоединенных и
                        присоединяемых</b> ЭУ:
                </div>
                <div style="flex:60%"><input id="watt_total" type="text" placeholder="Например: 15" name="watt_total"
                                             class="form_input" onKeyUp="replacement('watt_total')"></div>
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
                <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                    <div id="error_watt_total" style="width:100%;text-align:center;"></div>
                </div>
            </div>

            <!--напряжение ранее присоединенных и присоединяемых ЭУ (общее)-->
            <div style="display:none;margin-top:10px;" id="volt_total_input">
                <div style="flex:40%;align-items: center;display:flex;">при напряжении:</div>
                <div style="flex:60%"><input id="volt_total" type="text" placeholder="Например: 0.4" name="volt_total"
                                             class="form_input" onKeyUp="replacement('volt_total')"></div>
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
                <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                    <div id="error_volt_total" style="width:100%;text-align:center;"></div>
                </div>
            </div>

            <!--максимальная мощность присоединяемых ЭУ-->
            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Максимальная мощность <b>присоединяемых</b>
                    ЭУ:
                </div>
                <div style="flex:60%"><input id="watt_after" type="text" placeholder="Например: 15" name="watt_after"
                                             class="form_input" onKeyUp="replacement('watt_after')"></div>
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

                <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                    <div id="error_watt_after" style="width:100%;text-align:center;"></div>
                </div>

            </div>

            <!--напряжение присоединяемых ЭУ-->
            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">при напряжении:</div>
                <div style="flex:60%"><input id="volt_after" type="text" placeholder="Например: 0.4" name="volt_after"
                                             class="form_input" onKeyUp="replacement('volt_after')"></div>
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

                <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                    <div id="error_volt_after" style="width:100%;text-align:center;"></div>
                </div>

            </div>

            <!--максимальная мощность ранее присоединенных ЭУ-->
            <div style="display:none;margin-top:10px;" id="watt_before_input">
                <div style="flex:40%;align-items: center;display:flex;">Максимальная мощность <b>ранее
                        присоединенных </b>ЭУ:
                </div>
                <div style="flex:60%"><input id="watt_before" type="text" placeholder="Например: 5" name="watt_before"
                                             class="form_input" onKeyUp="replacement('watt_before')"></div>
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
                <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                    <div id="error_watt_before" style="width:100%;text-align:center;"></div>
                </div>
            </div>

            <!--напряжение ранее присоединенных ЭУ-->
            <div style="display:none;margin-top:10px;" id="volt_before_input">
                <div style="flex:40%;align-items: center;display:flex;">при напряжении:</div>
                <div style="flex:60%"><input id="volt_before" type="text" placeholder="Например: 5" name="volt_before"
                                             class="form_input" onKeyUp="replacement('volt_before')"></div>
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
                <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                    <div id="error_volt_before" style="width:100%;text-align:center;"></div>
                </div>
            </div>

            <!--категория надежности-->
            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Категория надежности электроснабжения:</div>
                <div style="flex:60%"><input id="category1" type="radio" name="secure_category" class="form_input"
                                             value="1"></div>
                <label for="category1">I категория</label>

                <div style="flex:60%"><input id="category2" type="radio" name="secure_category" class="form_input"
                                             value="2"></div>
                <label for="category2">II категория</label>

                <div style="flex:60%"><input id="category3" type="radio" name="secure_category" class="form_input"
                                             value="3"></div>
                <label for="category2">III категория</label>
            </div>
        </fieldset>


        <fieldset>
            <legend>
                <h3>Информация о сроках проектирования и введения в эксплуатацию объекта</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
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
                </table>
                <button type="button" onclick="myCreateFunction()">Добавить</button>
                <button type="button" onclick="myDeleteFunction()">Удалить</button>
            </div>
        </fieldset>


        <fieldset>
            <legend>
                <h3>Информация о гарантирующем поставщике электрической энергии</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Наименование гарантирующего поставщика:</div>
                <div style="flex:60%"><input id="garant_supplier" type="text" placeholder='Например: ООО "ЭСКБ"'
                                             name="garant_supplier" class="form_input"></div>
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
            </div>
        </fieldset>


        <fieldset>
            <legend>
                <h3>Прикрепить документы</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Прикрепить документы</div>
                <div style="flex:60%"><input id="input-file-upload" type="multipart/form-data"></div>
                <button type="button">Выбрать</button>
            </div>
        </fieldset>


        <!-- Показываем согласие на обработку ПД только для физ лиц и ИП! -->
        <?php
        if ($user['juridical_form'] == 1 || $user['juridical_form'] == 2) {
            ?>
            <div class="checkbox">
                <input type="checkbox" class="checkbox_input" id="formAgreement" name="formAgreement">

                <!--здесь надо перенаправить на документ-->
                <label for="formAgreement">Подтверждаю свое согласие на обработку персональных данных</label>
            </div>
            <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                <div id="error_agreement" style="width:100%;text-align:center;"></div>
            </div>
            <?php
        }
        ?>


        <div style="display:flex;margin-top:5px;justify-content: right;" id = "sign_request_button">
            <button type="button" class="form_button" onclick="open_sign_form()">Подписать
                заявку
            </button>
        </div>

        <div style="display:none;margin-top:5px;justify-content: right;" id="send_button">
            <button type="submit" class="form_button">Отправить заявку
            </button>
        </div>

    </form>
</div>

<div class="authorization_form" id="sign_request_form" style="display: none">
    <form id="form-sign-request">
        <h2>Подписание заявки</h2>
        <div>Для того, чтобы отправить заявку на рассмотрение в ООО "Энергоинжиниринг", Вам необходимо ее подписать.
            Нажимая на кнопку «Подписать заявку», вы подтверждаете факт формирования своей подписи. Юридически это
            действие приравнивается к постановке собственноручной подписи.
        </div>

        <div style="display:flex;margin-top:5px;justify-content: right;">
            <button type="button" class="form_button" onclick="confirm_sign_request()">Подписать заявку</button>
        </div>

    </form>
</div>

<!--Скрипт для кнопок добавить и удалить строку в таблице-->
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

<!--Скрипт для показа дополнительных полей при отметке чекбоксов-->
<script>

    //Показать поле с вводом условного номера если отмечено что нет кадастрового
    document.getElementById('noCadNumber').addEventListener('click', function () {
        let cad_number = document.getElementById('cad_number');
        let uslov_number = document.getElementById('uslov_number_input');
        if (document.getElementById('noCadNumber').checked) {
            cad_number.disabled = true;
            cad_number.value = "-";
            uslov_number.style.display = "flex";
        } else {
            cad_number.disabled = false;
            cad_number.value = "";
            uslov_number.style.display = "none";
        }
    });


    //Показать поле с вводом данных о ранее присоединенных и общих мощностях при выборе типа заявки - увеличение или уменьшение мощности
    document.getElementById('request_type').addEventListener('change', function () {
        let watt_before = document.getElementById('watt_before_input');
        let volt_before = document.getElementById('volt_before_input');
        let watt_total = document.getElementById('watt_total_input');
        let volt_total = document.getElementById('volt_total_input');
        let request_type = document.getElementById('request_type');
        if (request_type.value == "2" || request_type.value == "3") {
            watt_before.style.display = "flex";
            volt_before.style.display = "flex";
            watt_total.style.display = "flex";
            volt_total.style.display = "flex";
        } else {
            watt_before.style.display = "none";
            volt_before.style.display = "none";
            watt_total.style.display = "none";
            volt_total.style.display = "none";

            //очистить то что сохранилось в пещеньки
            // eraseCookie('watt_before');
            // eraseCookie('volt_before');
            // eraseCookie('watt_total');
            // eraseCookie('volt_total');
        }
    });

</script>

<!--//Скрипт замена запятой на точку-->
<script>

    //Замена запятой на точку
    function replacement(input) {
        let replace = document.getElementById(input).value.replace(/\,/g, '.');
        $("#" + input).val(replace);
    }
</script>

<!--Скрипт для post запроса ajax-->
<script>

    const form = document.getElementById('form-request');

    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let err = checkInputs();
        if (err === 0) {
            alert(0);
            $.ajax({
                url: 'user_create_new_request',
                method: 'post',
                dataType: 'json',
                data: $(this).serialize(),
                success: [function (response) {
                    if (response.type == "success") {
                        alert('success');
                        $('#error_watt_after').text('');
                        $('#error_volt_after').text('');
                        $('#error_watt_before').text('');
                        $('#error_volt_before').text('');
                        $('#error_watt_total').text('');
                        $('#error_volt_total').text('');
                        $('#error_radio_sex').text('');
                    } else if (response.type = "error") {

                        $('#error_watt_after').text('');
                        $('#error_volt_after').text('');
                        $('#error_watt_before').text('');
                        $('#error_volt_before').text('');
                        $('#error_watt_total').text('');
                        $('#error_volt_total').text('');
                        $('#error_radio_sex').text('');
                        for (let i = 0; i < response.msg.length; i++) {

                            switch (response.msg[i]) {

                                case "error_watt_after":
                                    $('#error_watt_after').text("Поле должно содержать только численные значения.");
                                    break;

                                case "error_volt_after":
                                    $('#error_volt_after').text("Поле должно содержать только численные значения.");
                                    break;

                                case "error_watt_before":
                                    $('#error_watt_before').text("Поле должно содержать только численные значения.");
                                    break;

                                case "error_volt_before":
                                    $('#error_volt_before').text("Поле должно содержать только численные значения.");
                                    break;

                                case "error_watt_total":
                                    $('#error_watt_total').text("Поле должно содержать только численные значения.");
                                    break;

                                case "error_volt_total":
                                    $('#error_volt_total').text("Поле должно содержать только численные значения.");
                                    break;

                                case "error_radio_sex":
                                    $('#error_radio_sex').text("Вы не указали пол.");
                                    break;
                            }
                        }
                    }
                }],
            });
        }
    }


    function checkInputs() {

        let err = 0;

        //обязательные проверки

        if ($("#formAgreement").prop("checked") == false) {
            $('#error_agreement').text('Вы не дали своего согласия на обработку персональных данных');
            err++
        } else {
            $('#error_agreement').text('');
        }
        return err;
    }

</script>

<!--Скрипт вызывающий окно подписания заявки -->
<script>
    function open_sign_form() {
        let sign_form = document.getElementById('sign_request_form');
        sign_form.style.display = "flex";
        //сделать посередине модульное окно

        let request_form = document.getElementById('form-request');
        //здесь затемнение фона

    }


    function confirm_sign_request() {
        //после клика "подписать" в модульном окне, скрываем кнопку "подписать" и показываем "отправить"
        let sign_form = document.getElementById('sign_request_form');
        sign_form.style.display = "none";
        let send_button = document.getElementById('send_button');
        send_button.style.display = "flex";
        let sign_request_button = document.getElementById('sign_request_button');
        sign_request_button.style.display = "none";
    }
</script>


