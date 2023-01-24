<div class="personal_data_ul_form">
    <h2>Информация о заявителе</h2>

    <fieldset>
        <legend>
            <h3>Данные компании</h3>
        </legend>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">Полное наименование компании:</div>
            <div style="flex:60%"><input id="lastname" type="text"
                                         placeholder='Например: Общество с ограниченной ответственностью "Company"'
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
            <div style="flex:40%;align-items: center;display:flex;">Сокращённое наименование компании:</div>
            <div style="flex:60%"><input id="name" type="text" placeholder='Например: ООО "Company"'
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
            <div style="flex:40%;align-items: center;display:flex;">ОГРН:</div>
            <div style="flex:60%"><input id="egrul_number" type="text" placeholder='Например: 1234567891234'
                                         name="egrul_number" class="form_input"></div>
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
        </div>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">Дата регистрации:</div>
            <div style="flex:60%"><input id="egrul_data" type="date" placeholder=''
                                         name="egrul_data" class="form_input"></div>
        </div>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">ИНН:</div>
            <div style="flex:60%"><input id="inn_numb" type="text" placeholder='Например: 1234567891'
                                         name="inn_numb" class="form_input"></div>
            <script>
                // при вводе текста будет сохраняться куки
                $(function () {
                    $('#inn_numb').keyup(function () {
                        setCookie("inn_number", $('#inn_numb').val(), 1);
                    });
                });

                // восстановить данные из куков
                var x = getCookie('inn_number');
                if (x) {
                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                    if ($('#inn_numb').val() == '') {
                        $('#inn_numb').val(x);
                    }
                }
            </script>
        </div>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">КПП:</div>
            <div style="flex:60%"><input id="kpp_number" type="text" placeholder='Например: 123456789'
                                         name="kpp_number" class="form_input"></div>
            <script>
                // при вводе текста будет сохраняться куки
                $(function () {
                    $('#kpp_number').keyup(function () {
                        setCookie("kpp_number", $('#kpp_number').val(), 1);
                    });
                });

                // восстановить данные из куков
                var x = getCookie('kpp_number');
                if (x) {
                    // ЕСЛИ VALUE ПУСТ У INPUT_ID, ТО ЗАПОЛНЯЕМ ЕГО X
                    if ($('#kpp_number').val() == '') {
                        $('#kpp_number').val(x);
                    }
                }
            </script>
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
        <h3>Юридический адрес</h3>
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
        <div style="flex:40%;align-items: center;display:flex;">Офис (помещение):</div>
        <div style="flex:60%"><input id="legal_address_apart" type="text" placeholder='Например: офис 1'
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

    <!--Чекбокс если нет офиса по прописке-->
    <div class="checkbox">
        <input id="noLegalApart" type="checkbox" name="checkLegalApart" class="checkbox_input">
        <label for="noLegalApart" class="checkbox_label">Нет номера офиса</label>
    </div>
</fieldset>

<fieldset>
    <legend>
        <h3>Почтовый адрес</h3>
    </legend>

    <div class="checkbox">
        <input id="same_address" type="checkbox" name="same_address"
               onchange="fillSameAddressFunction()" class="checkbox_input">
        <label for="same_address" class="checkbox_label">Совпадает с юридическим адресом</label>
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
        <div style="flex:40%;align-items: center;display:flex;">Офис (помещение):</div>
        <div style="flex:60%"><input id="real_address_apart" type="text" placeholder='Например: офис 3'
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
        <label for="noRealApart" class="checkbox_label">Нет номера офиса</label>
    </div>
</fieldset>

    <fieldset>
        <legend>
            <h3>Банковские реквизиты</h3>
        </legend>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">Номер расчетного счета:</div>
            <div style="flex:60%"><input id="check_account_number" type="text" placeholder=''
                                         name="check_account_number" class="form_input"></div>
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
        </div>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">Наименование банка:</div>
            <div style="flex:60%"><input id="bank_name" type="text" placeholder=''
                                         name="bank_name" class="form_input"></div>
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
        </div>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">БИК:</div>
            <div style="flex:60%"><input id="bank_bic" type="text" placeholder=''
                                         name="bank_bic" class="form_input"></div>
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
        </div>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">Корреспондентский счет:</div>
            <div style="flex:60%"><input id="bank_correspond" type="text" placeholder=''
                                         name="bank_correspond" class="form_input"></div>
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
        </div>

        <div style="display:flex;margin-top:10px;">
            <div style="flex:40%;align-items: center;display:flex;">Форма налогообложения:</div>
            <div style="flex:60%"><input id="common_form" type="radio" name="tax_form" class="form_input"
                                         value="0"></div>
            <label for="common_form">Общий режим налогообложения</label>

            <div style="flex:60%"><input id="simplified_form" type="radio" name="tax_form" class="form_input"
                                         value="1"></div>
            <label for="simplified_form">Упрощенная система налогообложения</label>
        </div>
    </fieldset>

</div>

<!--Скрипт для показа и скрытия полей при отметке чекбоксов-->
<script>

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



