

<div class="personal_data_fl_form">
        <h2>Информация о заявителе</h2>

        <fieldset>
            <legend>
                <h3>Персональные данные</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Фамилия:</div>
                <div style="flex:60%"><input id="lastname" type="text" placeholder='Например: Петров'
                                             name="lastname" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Имя:</div>
                <div style="flex:60%"><input id="name" type="text" placeholder='Например: Петр'
                                             name="name" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Отчество:</div>
                <div style="flex:60%"><input id="middlename" type="text" placeholder='Например: Петрович'
                                             name="middlename" class="form_input"></div>
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
            </div>

            <div class="checkbox">
                <input id="noMiddlename" type="checkbox" name="noMiddlename" class="checkbox_input" value="on">
                <label for="noMiddlename" class="checkbox_label">Нет отчества</label>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Дата рождения:</div>
                <div style="flex:60%"><input id="birth_date" type="date" placeholder=''
                                             name="birth_date" class="form_input"></div>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Укажите пол:</div>
                <div style="flex:60%"><input id="user_male" type="radio" name="user_sex" class="form_input"
                                             value="муж"></div>
                <label for="user_male">Муж</label>

                <div style="flex:60%"><input id="user_female" type="radio" name="user_sex" class="form_input"
                                             value="жен"></div>
                <label for="user_female">Жен</label>
                <div style="margin-top:15px; color:red; height:25px; font-size:12px;">
                    <div id="error_radio_sex" style="width:100%;text-align:center;"></div>
                </div>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Контактный телефон:</div>
                <div style="flex:60%"><input id="contact_phone" type="text" placeholder='Например: +7(917)123-45-67'
                                             name="contact_phone" class="form_input"></div>
                <script>
                    // при вводе текста будет сохраняться куки
                    $(function () {
                        $('#contact_phone').keyup(function () {
                            setCookie("contact_phone", $('#contact_phone').val(), 1);
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
            </div>
        </fieldset>

        <fieldset>
            <legend>
                <h3>Паспортные данные, ИНН, СНИЛС</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Серия и номер паспорта:</div>
                <div style="flex:60%"><input id="passport_numb" type="text" placeholder='Например: 1234 567891'
                                             name="passport_numb" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Дата выдачи паспорта:</div>
                <div style="flex:60%"><input id="passport_date" type="date" placeholder=''
                                             name="passport_date" class="form_input"></div>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Кем выдан паспорт:</div>
                <div style="flex:60%"><input id="passport_issued_by" type="text"
                                             placeholder='Например: МВД России по Республике Башкортостан'
                                             name="passport_issued_by" class="form_input"></div>
                <script>
                    // при вводе текста будет сохраняться куки
                    $(function () {
                        $('#passport_issued_by').keyup(function () {
                            setCookie("passport_issued_by", $('#passport_issued_by').val(), 1);
                        });
                    });

                    // восстановить данные из куков
                    var x = getCookie('passport_issued_by');
                    if (x) {
                        // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                        if ($('#passport_issued_by').val() == '') {
                            $('#passport_issued_by').val(x);
                        }
                    }
                </script>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Код подразделения:</div>
                <div style="flex:60%"><input id="passport_code" type="text" placeholder='Например: 111-111'
                                             name="passport_code" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">ИНН:</div>
                <div style="flex:60%"><input id="inn_numb" type="text" placeholder='Например: 123456789123'
                                             name="inn_numb" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">CНИЛС:</div>
                <div style="flex:60%"><input id="snils_numb" type="text" placeholder='Например: 123-456-789 12'
                                             name="snils_numb" class="form_input"></div>
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
                            $('#snils_numb').val(x);
                        }
                    }
                </script>
            </div>
        </fieldset>

        <fieldset>
            <legend>
                <h3>Адрес по месту постоянной регистрации</h3>
            </legend>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Регион/район:</div>
                <div style="flex:60%"><input id="legal_address_region" type="text"
                                             placeholder='Например: Республика Башкортостан'
                                             name="legal_address_region" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Город/населенный пункт:</div>
                <div style="flex:60%"><input id="legal_address_location" type="text" placeholder='Например: г. Уфа'
                                             name="legal_address_location" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Улица:</div>
                <div style="flex:60%"><input id="legal_address_street" type="text"
                                             placeholder='Например: ул. Комсомольская'
                                             name="legal_address_street" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Дом, корпус (при наличии):</div>
                <div style="flex:60%"><input id="legal_address_building" type="text" placeholder='Например: д. 111'
                                             name="legal_address_building" class="form_input"></div>
                <script>
                    // при вводе текста будет сохраняться куки
                    $(function () {
                        $('#legal_address_building').keyup(function () {
                            setCookie("legal_address_building", $('#legal_address_building').val(), 1);
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Квартира:</div>
                <div style="flex:60%"><input id="legal_address_apart" type="text" placeholder='Например: кв. 1'
                                             name="legal_address_apart" class="form_input"></div>
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
            </div>

            <!--Чекбокс если нет квартиры по прописке-->
            <div class="checkbox">
                <input id="noLegalApart" type="checkbox" name="checkLegalApart" class="checkbox_input">
                <label for="noLegalApart" class="checkbox_label">Нет номера квартиры</label>
            </div>
        </fieldset>

        <fieldset>
            <legend>
                <h3>Адрес фактического проживания</h3>
            </legend>

            <div class="checkbox">
                <input id="same_address" type="checkbox" name="same_address"
                       onchange="fillSameAddressFunction()" class="checkbox_input">
                <label for="same_address" class="checkbox_label">Совпадает с адресом постоянной
                    регистрации</label>
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Регион/район:</div>
                <div style="flex:60%"><input id="real_address_region" type="text"
                                             placeholder='Например: Республика Башкортостан'
                                             name="real_address_region" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Город/населенный пункт:</div>
                <div style="flex:60%"><input id="real_address_location" type="text" placeholder='Например: г. Уфа'
                                             name="real_address_location" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Улица:</div>
                <div style="flex:60%"><input id="real_address_street" type="text" placeholder='Например: ул. Рязанская'
                                             name="real_address_street" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Дом, корпус (при наличии):</div>
                <div style="flex:60%"><input id="real_address_building" type="text" placeholder='Например: д. 1'
                                             name="real_address_building" class="form_input"></div>
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
            </div>

            <div style="display:flex;margin-top:10px;">
                <div style="flex:40%;align-items: center;display:flex;">Квартира:</div>
                <div style="flex:60%"><input id="real_address_apart" type="text" placeholder='Например: кв. 3'
                                             name="real_address_apart" class="form_input"></div>
                <script>
                    // при вводе текста будет сохраняться куки
                    $(function () {
                        $('#real_address_apart').keyup(function () {
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
            </div>

            <!--Чекбокс если нет квартиры по факт адресу-->
            <div class="checkbox">
                <input id="noRealApart" type="checkbox" name="checkRealApart" class="checkbox_input">
                <label for="noRealApart" class="checkbox_label">Нет номера квартиры</label>
            </div>
        </fieldset>

</div>

<!--Скрипт для показа и скрытия полей при отметке чекбоксов-->
<script>

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



