<?php

if(!defined('allow_access_to_this_script')){die();}

echo "<div class='page_logo'>ЛИЧНЫЕ ДАННЫЕ ПОТРЕБИТЕЛЯ</div>";

/*
 * - ПОКАЗЫВАТЬ СТАТУС ПРОВЕРЕН/НЕТ (КТО ПРОВЕРИЛ)
 * - ОТЛИЧАТЬ ПО ЮРИДИЧЕСКОМУ СТАТУСУ
 * - возможность вернуться к списку
 * - показываем имя или название потребителя
 * - получаем всё из бд по юзеру
 * - строим все поля в форму
 * - думается, что все заявки юзера и документы лучше отдельно сделать
 */

$value = db_selectOne('user', ['id' => $_GET['edit']]);

echo "<div class='page_select'>";
    echo "<div class='doc_checking1'><b>";

switch($value['juridical_form'])
{
    case "1":
        echo $value['fio_lastname_or_company']." ".$value['fio_name_or_company_short']." ".$value['fio_middlename'];
        break;
    case "2":
        echo $value['fio_lastname_or_company']." ".$value['fio_name_or_company_short']." ".$value['fio_middlename'];
        break;
    case "3":
        echo $value['fio_lastname_or_company'];
        break;
}

    echo "</b><br/>";

    switch($value['juridical_form'])
    {
        case "1":
            echo "Физическое лицо";
            break;

        case "2":
            echo "Индивидуальный предприниматель";
            break;

        case "3":
            echo "Юридическое лицо";
            break;
    }

    echo "</div>";
    echo "<div class='doc_checking2'><b>Статус:</b><br/>";

    if($value['account_status_check']==true)
    {
        echo "Проверено";
    }else{
        echo "Не проверено";
    }

    echo "</div>";
    echo "<div class='doc_checking3'>";

         echo "<div style='display:inline-block;width:150px;'>";
         echo "<div style='height:24px;' class='mybutton' onClick=\"window.location='?".time()."'\">Вернуться к спискам</div></div>";

    echo "</div>";
    echo "</div>";


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  ПОЛОСА МИНИАТЮР
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<div style="display:flex;justify-content: center; overflow:auto; width:100%;flex-wrap: wrap;">
    <div class="thumbnail" onClick="changeImage('page1.webp');"><img src="page1_thumbnail.webp">
        <svg class="fire_icon" x="0px" y="0px" viewBox="0 0 92.27 122.88" xmlns="http://www.w3.org/2000/svg">
            <g>
                <path class="fire_icon_color1" d="M18.61,54.89C15.7,28.8,30.94,10.45,59.52,0C42.02,22.71,74.44,47.31,76.23,70.89 c4.19-7.15,6.57-16.69,7.04-29.45c21.43,33.62,3.66,88.57-43.5,80.67c-4.33-0.72-8.5-2.09-12.3-4.13C10.27,108.8,0,88.79,0,69.68 C0,57.5,5.21,46.63,11.95,37.99C12.85,46.45,14.77,52.76,18.61,54.89L18.61,54.89z"></path>
                <path class="fire_icon_color2" d="M33.87,92.58c-4.86-12.55-4.19-32.82,9.42-39.93c0.1,23.3,23.05,26.27,18.8,51.14 c3.92-4.44,5.9-11.54,6.25-17.15c6.22,14.24,1.34,25.63-7.53,31.43c-26.97,17.64-50.19-18.12-34.75-37.72 C26.53,84.73,31.89,91.49,33.87,92.58L33.87,92.58z"></path>
            </g>
        </svg>
    </div>
    <div class="thumbnail" onClick="changeImage('page2.webp');"><img src="page2_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page3.webp');"><img src="page3_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page4.webp');"><img src="page4_thumbnail.webp"></div>
    <div class="thumbnail_selected"><img src="page5_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page6.webp');"><img src="page6_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page7.webp');"><img src="page7_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page8.webp');"><img src="page8_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page9.webp');"><img src="page9_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page10.webp');"><img src="page10_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page11.webp');"><img src="page11_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page12.webp');"><img src="page12_thumbnail.webp"></div>
    <div class="thumbnail" onClick="changeImage('page13.webp');"><img src="page13_thumbnail.webp"></div>
</div>

<!-- ДВА СТОЛБЦА -->
<div class="privatedata_screen" >

    <!-- РЕДАКТИРОВАНИЕ ЛИЧНЫХ ДАННЫХ-->

    <div class="privatedata_edit">

<?php

echo "<div class='document_title'>";

    echo "<b>Последний проверявший:</b><br>";
    if($value['account_status_check_who']!="")
    {
        echo $value['account_status_check_who'];
    }else{
        echo "никто";
    }

echo "</div>";


/******************************************************************************************************************
 * МАССИВ ДЛЯ ГЕНЕРАЦИИ ФОРМЫ ЛИЧНЫХ ДАННЫХ
 * ---# вместо названия поля в БД означает визуальный разделитель в форме
 * цифра после него и прочее не учитывается и нужно только для уникальности строки
 *
 * Структура конечного массива:
 * [НАЗВАНИЕ ИНПУТА], [МАСКА ИЛИ ЛИМИТ],  [ТИП ИНПУТА], [ПОЯСНЕНИЕ ПЕРЕД ИНПУТОМ], [PATTERN REGEX ДЛЯ HTML5], [REGEX ЗАМЕНА В ФОРМАТЕ JS]
 *
 * текстовые массивы с | нужны для мультиэлементов
 *
 * [МАСКА ИЛИ ЛИМИТ] если заполнено, то:
 * "mask___+7(999)-999-9999" - сложные маски
 * "limit___25" или "limit___3-300" - ограничение количества символов (обычно для текстовых полей)
 * "empty___25" или "empty___2-25" - поле будет принято без заполнения, либо согласно правилам
 * где 3-300 - минимальное и максимальное значение
 *
 * Паспортные данные состоят из:
 * - серияномер
 * - дата рождения
 * - дата выдачи паспорта
 * - кем выдан
 * - код подразделения
*****************************************************************************************************************/

$c=0;
$FORMS = [
        1 => [
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'fio_lastname_or_company'   => ['Фамилия',           'text',                          'limit___2-25',                                                      '',                '[а-яА-Я]', ''],
                'fio_name_or_company_short' => ['Имя',               'text',                          'limit___2-25',                                                      '',                '', ''],
                'fio_middlename'            => ['Отчество',          'text',                          'empty___2-25',                                                      '',                '', ''],
                'sex'                       => ['Пол',               'radio|radio',                   '',                                                                  'Мужской|Женский', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'fio_rusforms'              => ['Формы склонения',   'text|text|text|text|text|text', 'limit___77|limit___77|limit___77|limit___77|limit___77|limit___77', 'Кто|Кого|Кому|Кого|Кем|О ком',     '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'passport'                  => ['Паспортные данные', 'text|date|date|text|text',      'mask___9999 999999|||limit___3-300|mask___999-999',                 'Серия и номер|Дата рождения|Дата выдачи|Кем выдан|Код подразделения',                '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'phone'                     => ['Телефон (без +7)',  'text',                          'mask___(999)-999-9999',                                           '',                '', ''],
                'inn'                       => ['ИНН',               'text',                          'mask___999999999999',                                               '',                '', ''],
                'snils'                     => ['СНИЛС',             'text',                          'mask___999-999-999 99',                                             '',                '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['Адрес по прописке', '', '', '', '', ''],
                'legal_address_region'      => ['Регион',            'text',                          'limit___150',                                                       '',                '', ''],
                'legal_address_location'    => ['Город',             'text',                          'limit___150',                                                       '',                '', ''],
                'legal_address_street'      => ['Улица',             'text',                          'limit___150',                                                       '',                '', ''],
                'legal_address_building'    => ['Дом',               'text',                          'limit___50',                                                        '',                '', ''],
                'legal_address_apart'       => ['Квартира',          'text',                          'empty___50',                                                        '',                '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['Фактический адрес', '', '', '', '', ''],
                'real_address_region'       => ['Регион',            'text',                          'limit___150',                                                       '',                '', ''],
                'real_address_location'     => ['Город',             'text',                          'limit___150',                                                       '',                '', ''],
                'real_address_street'       => ['Улица',             'text',                          'limit___150',                                                       '',                '', ''],
                'real_address_building'     => ['Дом',               'text',                          'limit___50',                                                        '',                '', ''],
                'real_address_apart'        => ['Квартира',          'text',                          'empty___50',                                                        '',                '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', '']
            ],

        2 => [
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'fio_lastname_or_company'   => ['Фамилия',                'text',                          'limit___2-25',                                                      '', '', ''],
                'fio_name_or_company_short' => ['Имя',                    'text',                          'limit___2-25',                                                      '', '', ''],
                'fio_middlename'            => ['Отчество',               'text',                          'empty___2-25',                                                      '', '', ''],
                'sex'                       => ['Пол',                    'radio|radio',                   '',                                                                  'Мужской|Женский', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'fio_rusforms'              => ['Формы склонения',        'text|text|text|text|text|text', 'limit___77|limit___77|limit___77|limit___77|limit___77|limit___77', 'Кто|Кого|Кому|Кого|Кем|О ком', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'passport'                  => ['Паспортные данные',      'text|date|date|text|text',      'mask___9999 999999|||limit___3-300|mask___999-999',                 'Серия и номер|Дата рождения|Дата выдачи|Кем выдан|Код подразделения', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'phone'                     => ['Телефон (без +7)',       'text',                          'mask___(999)-999-9999',                                           '', '', ''],
                'inn'                       => ['ИНН',                    'text',                          'mask___999999999999',                                               '', '', ''],
                'snils'                     => ['СНИЛС',                  'text',                          'mask___999-999-999 99',                                             '', '', ''],
                'egrul_number'              => ['Номер ОГРНИП',           'text',                          '',                                                                  '', '', ''],
                'egrul_data'                => ['Дата ОГРНИП',            'date',                          '',                                                                  '', '', ''],
                'pay_tax_form'              => ['Форма налогооблажения',  'radio|radio',                   '',                                                                  'Общая|Упрощённая', '', ''],
                'pay_checking_account'      => ['Расчётный счёт',         'text',                          '',                                                                  '', '', ''],
                'pay_correspondent_account' => ['Корреспондентский счёт', 'text',                          '',                                                                  '', '', ''],
                'pay_bank'                  => ['Банк',                   'text',                          '',                                                                  '', '', ''],
                'pay_bank_bic'              => ['БИК',                    'text',                          '',                                                                  '', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['Адрес по прописке', '', '', '', '', ''],
                'legal_address_region'      => ['Регион',                 'text',                          'limit___150',                                                       '', '', ''],
                'legal_address_location'    => ['Город',                  'text',                          'limit___150',                                                       '', '', ''],
                'legal_address_street'      => ['Улица',                  'text',                          'limit___150',                                                       '', '', ''],
                'legal_address_building'    => ['Дом',                    'text',                          'limit___50',                                                        '', '', ''],
                'legal_address_apart'       => ['Квартира',               'text',                          'empty___50',                                                        '', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['Фактический адрес', '', '', '', '', ''],
                'real_address_region'       => ['Регион',                 'text',                          'limit___150',                                                       '', '', ''],
                'real_address_location'     => ['Город',                  'text',                          'limit___150',                                                       '', '', ''],
                'real_address_street'       => ['Улица',                  'text',                          'limit___150',                                                       '', '', ''],
                'real_address_building'     => ['Дом',                    'text',                          'limit___50',                                                        '', '', ''],
                'real_address_apart'        => ['Квартира',               'text',                          'empty___50',                                                        '', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', '']
             ],

        3 => [
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'fio_lastname_or_company'   => ['Полное наименование',      'text',          '',                        '',                 '', ''],
                'fio_name_or_company_short' => ['Сокращённое наименование', 'text',          '',                        '',                 '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'phone'                     => ['Телефон (без +7)',         'text',          'mask___(999)-999-9999', '',                 '', ''],
                'contact'                   => ['Контактное лицо',          'text',          '',                        '',                 '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'inn'                       => ['ИНН',                      'text',          'mask___9999999999',       '',                 '', ''],
                'egrul_number'              => ['Номер ЕГРЮЛ',              'text',          '',                        '',                 '', ''],
                'egrul_data'                => ['Дата ЕГРЮЛ',               'date',          '',                        '',                 '', ''],
                'pay_tax_form'              => ['Форма налогооблажения',    'radio|radio',   '',                        'Общая|Упрощённая', '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['', '', '', '', '', ''],
                'pay_code_of_reason'        => ['КПП',                      'text',          '',                        '',                 '', ''],
                'pay_checking_account'      => ['Расчётный счёт',           'text',          '',                        '',                 '', ''],
                'pay_correspondent_account' => ['Корреспондентский счёт',   'text',          '',                        '',                 '', ''],
                'pay_bank'                  => ['Банк',                     'text',          '',                        '',                 '', ''],
                'pay_bank_bic'              => ['БИК',                      'text',          '',                        '',                 '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['Юридический адрес', '', '', '', '', ''],
                'legal_address_region'      => ['Регион',                   'text',          'limit___150',             '',                 '', ''],
                'legal_address_location'    => ['Город',                    'text',          'limit___150',             '',                 '', ''],
                'legal_address_street'      => ['Улица',                    'text',          'limit___150',             '',                 '', ''],
                'legal_address_building'    => ['Дом',                      'text',          'limit___50',              '',                 '', ''],
                'legal_address_apart'       => ['Офис',                     'text',          'empty___50',              '',                 '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', ''],
                '<<<'.($c++)                => ['Почтовый адрес', '', '', '', '', ''],
                'real_address_region'       => ['Регион',                   'text',          'limit___150',             '',                 '', ''],
                'real_address_location'     => ['Город',                    'text',          'limit___150',             '',                 '', ''],
                'real_address_street'       => ['Улица',                    'text',          'limit___150',             '',                 '', ''],
                'real_address_building'     => ['Дом',                      'text',          'limit___50',              '',                 '', ''],
                'real_address_apart'        => ['Офис',                     'text',          'empty___50',              '',                 '', ''],
                '>>>'.($c++)                => ['', '', '', '', '', '']
             ]
];




    // ВЫВОД ФОРМЫ ДЛЯ РЕДАКТИРОВАНИЯ
    echo "<form method='post' action='?edit=".$_GET['edit']."'>";
    $input_num=0;
    $last_one_was_separator=""; // фикс, чтобы не переделывать некоторые поля в БД
    $last_one_was_separator_counter=0;
    $masked_scripts="<script>$(function(){";

    foreach($FORMS[$value['juridical_form']] as $key => $data)
    {


        // ПРОВЕРКА НА СЛУЖЕБНЫЕ ЭЛЕМЕНТЫ
        $y = substr($key, 0,3);

        // ПРОВЕРКА НА РАЗДЕЛИТЕЛЬ
        if($y!='---' && $y!='>>>' && $y!='<<<')
        {
            // НАЗВАНИЕ ЭЛЕМЕНТА
            echo "<div style='display:flex;margin-top:4px;'>";

            if($last_one_was_separator=='')
            {
                echo "<div style='flex:40%;'>".$data[0]."</div><div style='flex:60%;'>";
            }else{
                if($last_one_was_separator_counter==0)
                {
                    echo "<div style='flex:40%;'>".$last_one_was_separator."</div><div style='flex:60%;'>".$data[0];
                    $last_one_was_separator_counter++;
                }else{
                    echo "<div style='flex:40%;'></div><div style='flex:60%;'>".$data[0];
                }
            }


                    // ОПРЕДЕЛЯЕМ ТИП ЭЛЕМЕНТА С УЧЁТОМ МАССИВОВ ЭЛЕМЕНТОВ
                    $types = explode("|", $data[1]);
                    $types_title = explode("|", $data[3]);
                    $values_array = explode("|", $value[$key]);
                    $limits = explode("|", $data[2]);
                    $pattern_regex = explode("|", $data[4]);

                    $types_num = 0;
                    foreach($types as $types_key)
                    {
                        $types_id = "data".$input_num."_".$types_num;

                        switch($types_key)
                        {
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            case "text":
                                if(isset($types_title[$types_num]))
                                {
                                    if($last_one_was_separator=='')
                                    {
                                        echo $types_title[$types_num];
                                    }
                                }

                                echo "<input name='".$types_id."' id='".$types_id."' type='text'";

                                    // ВСТАВЛЯЕМ ДАННЫЕ ИЗ БД
                                    if($values_array[$types_num]!="") echo " value='".$values_array[$types_num]."'";

                                    // ЛИМИТЫ
                                    $limit_type = strtok($limits[$types_num], '___');
                                    if($limit_type!='')
                                    {
                                        $limit_settings = explode("-", explode("___", $limits[$types_num])[1]);

                                        switch($limit_type)
                                        {
                                            case "limit":
                                                    if(!isset($limit_settings[1]))
                                                    {
                                                        // одиночный лимит до максимума
                                                        if(isset($pattern_regex[$types_num]))
                                                        {
                                                            echo "pattern='";
                                                            echo $pattern_regex[$types_num];
                                                            echo ".{1,".$limit_settings[0]."}' required";
                                                        }
                                                    }else{
                                                        // двойной лимит от и до
                                                        if(isset($pattern_regex[$types_num]))
                                                        {
                                                            echo "pattern='";
                                                            echo $pattern_regex[$types_num];
                                                            echo ".{".$limit_settings[0].",".$limit_settings[1]."}' required";
                                                        }
                                                    }
                                                break;

                                            case "empty":
                                                    if(!isset($limit_settings[1]))
                                                    {
                                                        // одиночный лимит до максимума
                                                        if(isset($pattern_regex[$types_num]))
                                                        {
                                                            echo "pattern='";
                                                            echo $pattern_regex[$types_num];
                                                            echo ".{1,".$limit_settings[0]."}'";
                                                        }
                                                    }else{
                                                        // двойной лимит от и до
                                                        if(isset($pattern_regex[$types_num]))
                                                        {
                                                            echo "pattern='";
                                                            echo $pattern_regex[$types_num];
                                                            echo ".{".$limit_settings[0].",".$limit_settings[1]."}'";
                                                        }
                                                    }
                                                break;

                                            case "mask":
                                                $masked_scripts.= "$('#".$types_id."').mask('".explode("___", $limits[$types_num])[1]."');";
                                                break;
                                        }
                                    }

                                echo ">";


                                break;

                            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            case "radio":
                                echo "<div class='div_radio'><input name='"."data".$input_num."' id='"."data".$input_num."' value='".$types_id."' type='radio' ";

                                    // ВСТАВЛЯЕМ ДАННЫЕ ИХ БД
                                    if($types_num == ($value[$key] ? '1' : '0')) echo "checked";

                                echo "> ".$types_title[$types_num]."</div>";

                                break;

                            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            case  "date":
                                echo "<input name='".$types_id."' id='".$types_id."' type='date' value='";

                                    // ВСТАВЛЯЕМ ДАННЫЕ ИЗ БД
                                    //echo 2022-06-03 20:25:13 -> 30.12.2023
                                    if(is_numeric($values_array[$types_num]))
                                    {
                                        echo date("Y-m-d", $values_array[$types_num]);
                                    }else{
                                        echo date("Y-m-d", strtotime($values_array[$types_num]));
                                    }

                                echo "'>";
                                if(isset($types_title[$types_num])) echo " ".$types_title[$types_num];
                                break;
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        }

                        $types_num++;
                    }
                    $input_num++;


            echo "</div></div>";



        }else{
            // ОБНАРУЖЕН РАЗДЕЛИТЕЛЬ
            switch($y)
            {
                case "<<<":
                    echo "<div class='set_of_inputs'>";
                    $last_one_was_separator=$data[0];
                    break;
                case ">>>":
                    $last_one_was_separator='';
                    $last_one_was_separator_counter=0;
                    echo "</div>";
                    break;
            }

        }



    }

    echo "<input type=submit>";
    echo "</form>";

    $masked_scripts.="});</script>";
    echo $masked_scripts;









?>





    </div>

    <!-- РАБОТА С ВЫБРАННЫМ ИЗОБРАЖЕНИЕМ -->

    <div class="privatedata_image">
        <div class="privatedata_panel">


            <div style='display:flex;'>


                <div class='mytool' id="tool_zoomin">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512"  xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M495.9,436.3L374.7,332.9c-12.1-11.2-26.1-16.8-36.4-15.8c28.9-33.6,45.7-77.4,45.7-124.9
		c0-106.3-85.8-192-192-192S0,85.8,0,192.1s85.8,192,192,192c47.5,0,91.4-17.7,124.9-45.7c-0.9,11.2,4.7,24.2,15.8,36.4L436.3,496
		c17.7,19.6,46.6,21.4,64.3,3.7C517.4,482.9,515.5,454.1,495.9,436.3L495.9,436.3z M191.1,320.7c-70.8,0-128.6-57.8-128.6-128.6
		S120.3,63.5,191.1,63.5s128.6,57.8,128.6,128.6C319.7,263,261.9,320.7,191.1,320.7z M223.7,96.1h-64.3v64.3H95.1v64.3h64.3v64.3
		h64.3v-64.3H288v-64.3h-64.3V96.1z"></path>
                        </g>
                    </svg>
                </div>


                <div class='mytool' id="tool_zoomout">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M495.9,436.3L374.7,332.9c-12.1-11.2-26.1-16.8-36.4-15.8c28.9-33.6,45.7-77.4,45.7-124.9
		c0-106.3-85.8-192-192-192S0,85.8,0,192.1s85.8,192,192,192c47.5,0,91.4-17.7,124.9-45.7c-0.9,11.2,4.7,24.2,15.8,36.4L436.3,496
		c17.7,19.6,46.6,21.4,64.3,3.7C517.4,482.9,515.5,454.1,495.9,436.3L495.9,436.3z M191.1,320.7c-70.8,0-128.6-57.8-128.6-128.6
		S120.3,63.5,191.1,63.5s128.6,57.8,128.6,128.6C319.7,263,261.9,320.7,191.1,320.7z M95.1,160.4h192v64.3h-192V160.4z"></path>
                        </g>
                    </svg>
                </div>


                <div style='margin-left:20px;' class='mytool' id="tool_rotate">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M233.2,95.9c8.4-1,16.7-1.5,25-1.6v41.2c0,4.2,4.8,6.5,8.1,3.9l82.7-65.2c2.6-2.1,2.6-5.9,0-7.9L266.5,1.1
		c-3.3-2.6-8.1-0.3-8.1,3.9l-0.1,41.3c-76.5,0.3-152.2,34.5-203,99.5C10.3,203.4-6.6,274,2.8,341h48.3c-0.6-3.4-1.1-6.9-1.5-10.4
		c-3.3-27.2-1.4-54.3,5.7-80.5c7.4-27.2,20-52.3,37.5-74.7c17.6-22.4,38.9-40.8,63.5-54.4C180.2,107.6,206,99.2,233.2,95.9z"></path>
                            <path d="M491,203.5H150.3c-11.4,0-20.7,9.2-20.7,20.7v267.2c0,11.4,9.2,20.7,20.7,20.7H491c11.4,0,20.7-9.2,20.7-20.7V224.2
		C511.7,212.8,502.5,203.5,491,203.5z M462.6,463h-284V252.6h284V463z"></path>
                        </g>
                    </svg>
                </div>


                <div class='mytool' id="tool_crop">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M93.09,372.36c0,25.61,20.93,46.55,46.55,46.55h232.73V512h46.55v-93.09h93.09v-46.55H139.63V0H93.09v93.08
		H-0.01v46.55h93.09V372.36z M418.91,325.81V139.63c0-25.59-20.96-46.55-46.55-46.55H186.18v46.55h186.19v186.19H418.91z"></path>
                        </g>
                    </svg>
                </div>


                <div class='mytool' id="tool_flipv">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512"  xmlns="http://www.w3.org/2000/svg">
                        <defs></defs>
                        <g>
                            <path d="M25.6,281.6h460.8c14.1,0,25.6-11.5,25.6-25.6c0-14.1-11.5-25.6-25.6-25.6H25.6C11.5,230.4,0,241.9,0,256
		C0,270.1,11.5,281.6,25.6,281.6"></path>
                            <path d="M128,384h147.6l-122,61l0-86.6c0-14.1-11.5-25.6-25.6-25.6s-25.6,11.5-25.6,25.6v128c0,8.9,4.6,17.1,12.1,21.8
		c7.6,4.7,16.9,5.1,24.9,1.1l256-128c10.6-5.3,16.2-17.2,13.5-28.8c-2.7-11.6-13-19.7-24.9-19.7H128c-14.1,0-25.6,11.5-25.6,25.6
		C102.4,372.5,113.9,384,128,384L128,384z"></path>
                            <path d="M128,179.2h256c11.9,0,22.2-8.1,24.9-19.7c2.7-11.6-2.8-23.5-13.5-28.8l-256-128c-8-4-17.3-3.6-24.9,1.1
		c-7.6,4.7-12.1,12.9-12.1,21.8v128C102.4,167.7,113.9,179.2,128,179.2c14.1,0,25.6-11.5,25.6-25.6V67l122,61L128,128
		c-14.1,0-25.6,11.5-25.6,25.6C102.4,167.7,113.9,179.2,128,179.2L128,179.2z"></path>
                        </g>
                    </svg>
                </div>


                <div class='mytool' id="tool_fliph"">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <defs></defs>
                        <g>
                            <path d="M230.4,25.6v460.8c0,14.1,11.5,25.6,25.6,25.6c14.1,0,25.6-11.5,25.6-25.6V25.6C281.6,11.5,270.1,0,256,0
		C241.9,0,230.4,11.5,230.4,25.6"></path>
                            <path d="M332.8,128v256c0,6.7,2.7,13.3,7.5,18.1c4.8,4.8,11.4,7.5,18.1,7.5h128c8.9,0,17.1-4.6,21.8-12.1c4.7-7.6,5.1-17,1.1-24.9
		l-128-256c-6.3-12.6-21.7-17.8-34.3-11.4c-12.6,6.3-17.8,21.7-11.4,34.3L445,358.4h-61V128c0-14.1-11.5-25.6-25.6-25.6
		C344.3,102.4,332.8,113.9,332.8,128L332.8,128z"></path>
                            <path d="M128,128v230.4H67l109.5-218.9c6.3-12.6,1.2-28-11.4-34.3c-12.6-6.3-28-1.2-34.3,11.4l-128,256c-4,8-3.6,17.3,1.1,24.9
		c4.7,7.6,12.9,12.1,21.8,12.1h128c6.7,0,13.3-2.7,18.1-7.5c4.8-4.8,7.5-11.4,7.5-18.1V128c0-14.1-11.5-25.6-25.6-25.6
		C139.5,102.4,128,113.9,128,128z"></path>
                        </g>
                    </svg>
                </div>


                <div style='margin-left:20px;' class='mytool' id="tool_delete">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M42.75,469.3c0,23.5,19.1,42.7,42.7,42.7h341.3c23.5,0,42.7-19.1,42.7-42.7V192H42.75V469.3z M362.75,256h42.7v192h-42.7
		V256z M234.75,256h42.7v192h-42.7V256z M106.75,256h42.7v192h-42.7V256z M490.75,85.3h-128V42.7c0-23.6-19.2-42.7-42.7-42.7h-128
		c-23.5,0-42.7,19.1-42.7,42.7v42.7h-128c-11.8-0.1-21.3,9.5-21.3,21.3V128c0,11.8,9.5,21.3,21.3,21.3h469.3
		c11.8,0,21.3-9.5,21.3-21.3v-21.3C512.05,94.9,502.55,85.3,490.75,85.3z M320.05,85.3h-128V42.7h128V85.3z"></path>
                        </g>
                    </svg>
                </div>

                <div class='mytool' id="tool_accept">
                    <svg width="18px" x="0px" y="0px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M433.8,286.3V384c0,24.2-8.4,45.6-26.1,62.4c-17.7,17.7-38.2,26.1-62.4,26.1H88.4
		c-24.2,0-45.6-8.4-62.4-26.1C8.4,428.7,0,408.2,0,384V128c0-24.2,8.4-45.6,26.1-62.4c17.7-17.7,38.2-26.1,62.4-26.1h256
		c13,0,25.1,2.8,36.3,7.4c2.8,1.9,4.7,3.7,5.6,7.4c0.9,3.7,0,6.5-2.8,9.3l-14.9,14.9c-1.9,1.9-4.7,2.8-7.4,2.8c-0.9,0-1.9,0-2.8-0.9
		c-4.7-0.9-9.3-0.9-14-0.9h-256c-14,0-25.1,4.7-34.4,14.9c-9.3,9.3-14.9,21.4-14.9,34.4v256c0,14,4.7,25.1,14.9,34.4
		c9.3,9.3,21.4,14.9,34.4,14.9h256c14,0,25.1-4.7,34.4-14.9c9.3-9.3,14.9-21.4,14.9-34.4v-78.2c0-2.8,0.9-4.7,2.8-6.5l19.5-19.5
		c1.9-1.9,4.7-2.8,7.4-2.8c0.9,0,2.8,0,3.7,0.9C431,279.7,433.8,282.5,433.8,286.3z M504.6,136.4L254.1,386.8
		c-4.7,4.7-11.2,7.4-17.7,7.4s-13-2.8-17.7-7.4L86.6,254.6c-4.7-4.7-7.4-11.2-7.4-17.7s2.8-13,7.4-17.7l33.5-33.5
		c4.7-4.7,11.2-7.4,17.7-7.4s13,2.8,17.7,7.4l81,81L435.7,67.5c4.7-4.7,11.2-7.4,17.7-7.4c6.5,0,13,2.8,17.7,7.4l33.5,33.5
		c4.7,4.7,7.4,11.2,7.4,17.7S509.2,130.8,504.6,136.4z"></path>
                        </g>
                    </svg>
                </div>

            <!-- тултипы должны быть тут, иначе позиция сбивается -->
            <div id="tooltip" role="tooltip">Приблизить<div id="arrow" data-popper-arrow></div></div>
            <div id="tooltip2" role="tooltip">Отдалить<div id="arrow" data-popper-arrow></div></div>
            <div id="tooltip3" role="tooltip">Повернуть<div id="arrow" data-popper-arrow></div></div>
            <div id="tooltip4" role="tooltip">Обрезать белые края<div id="arrow" data-popper-arrow></div></div>
            <div id="tooltip5" role="tooltip">Отразить по вертикали<div id="arrow" data-popper-arrow></div></div>
            <div id="tooltip6" role="tooltip">Отразить по горизонтали<div id="arrow" data-popper-arrow></div></div>
            <div id="tooltip7" role="tooltip">Удалить<div id="arrow" data-popper-arrow></div></div>
            <div id="tooltip8" role="tooltip">Одобрить<div id="arrow" data-popper-arrow></div></div>

            <div class="document_date">11 января 2023, 23:49</div>


            </div>
        </div>

<!-- КАРТИНКА ****************************************************************************************************** -->


        <style>
            #myViewport {
                cursor: grab;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #myContent {
                position: relative;
                display: flex;
                align-items: center;
            }

            .col-12 {
                position: relative;
                width: 100%;
                min-height: 1px;
                -webkit-box-flex: 0;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
            }

            .embed-responsive {
                position: relative;
                display: block;
                width: 100%;
                padding: 0;
                overflow: hidden;
                border-radius: 5px;
            }

            .embed-responsive::before {
                display: block;
                content: "";
            }

            .embed-responsive-16by9::before {
                padding-top: 56.25%;
            }

            .embed-responsive .embed-responsive-item,
            .embed-responsive iframe,
            .embed-responsive embed,
            .embed-responsive object,
            .embed-responsive video {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border: 0;
            }

            #myContent {
                vertical-align: middle;
                border-style: none;
                user-select: none;
            }

            #image_viewer_shadow::after {
                box-shadow: 1px 1px 5px 0px rgb(0,0,0,0.5) inset;
                content: '';
                display: block;
                height: 100%;
                position: absolute;
                top: 0;
                width: 100%;
                border-radius: 5px;
                pointer-events:none;
            }

        </style>

        <div class="image_viewer">
            <div>
                <div id="image_viewer_shadow" class="col-12">

                    <div class="embed-responsive embed-responsive-16by9">
                        <div id="myViewport" class="embed-responsive-item">
                            <img id="myContent" src="https://worka.github.io/files/wheel_zoom_example.jpg" alt="image"/>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script src="site_html/wheel-zoom.min.js" type="text/javascript"></script>

        <script type="text/javascript">
            var a=true;
            var b=true;
            var animationDuration = 0.2;

            document.addEventListener('DOMContentLoaded', function () {
                var frame = document.getElementById('myViewport');
                var image = document.getElementById('myContent');

                var wzoom = WZoom.create('#myContent', {
                    dragScrollableOptions: {
                        onGrab: function () {
                            frame.style.cursor = 'grabbing';
                            image.style.transition="none";
                            b=false;
                        },
                        onDrop: function () {
                            frame.style.cursor = 'grab';
                            b=true;
                        }
                    }
                });


                tool_zoomin.addEventListener('click', function () {
                    wzoom.zoomUp();
                });

                tool_zoomout.addEventListener('click', function () {
                    wzoom.zoomDown();
                });

                window.addEventListener('resize', function () {
                    if (wzoom) wzoom.prepare();
                });




                // ФУНКЦИЯ ПОВОРОТА ////////////////////////////////////////////////////////////////////////////////////
                var degreeRotation = 0;
                function changeTransformRotateProperty(element, value) {
                    newstyle = element.style.transform.replace(/(^|\s)rotate\(\d+deg\)($|\s)/i, '') + ' rotate(' + value + 'deg)';
                    // сюда добавить отражения
                    element.style.transform = newstyle;
                }
                function rotateImage() {
                    if(a!=true) {
                        degreeRotation=0;
                        image.style.transition="none";
                        changeTransformRotateProperty(image, 0);
                        return;
                    }

                    if(b==true)
                    {
                        image.style.transition = 'transform ' + animationDuration + 's';
                    }

                    changeTransformRotateProperty(image, degreeRotation);

                    if (degreeRotation > 270 && animationDuration) {
                        setTimeout(function () {
                            changeTransformRotateProperty(image, 0);
                        }, animationDuration * 1000);
                    }
                }
                var observer = new MutationObserver(rotateImage);
                observer.observe(image, { attributes: true, attributeFilter: [ 'style' ] });


                ////////////////////////////////////////////////////////////////////////////////////////////////////////


                // КНОПКА ПОВОРОТА
                tool_rotate.addEventListener('click', function () {
                    degreeRotation += 90;
                    rotateImage();
                });

                // КНОПКА ОТРАЗИТЬ ПО ГОРИЗОНТАЛИ
                tool_fliph.addEventListener('click', function () {
                    imageFlipH();
                });

                // КНОПКА ОТРАЗИТЬ ПО ВЕРТИКАЛИ
                tool_flipv.addEventListener('click', function () {
                    imageFlipV();
                });


            });

            // СМЕНА ИЗОБРАЖЕНИЯ
            function changeImage(file)
            {
                a=false;
                $('#myContent').attr('src',file);
                degreeRotation=0;
                document.getElementById('myContent').style.transition="none";
                $("#myContent").one("load", function() {
                    a=true;
                })
            }

            // ФУНКЦИИ ОТРАЖЕНИЯ ///////////////////////////////////////////////////////////////////////////////////

            function imageFlipH()
            {
                alert("по вертикали");
            }

            function imageFlipV()
            {
                alert("по горизонтали");
            }



        </script>

<!-- *************************************************************************************************************** -->


    </div>
</div>







<style>
#tooltip, #tooltip2, #tooltip3, #tooltip4, #tooltip5, #tooltip6, #tooltip7, #tooltip8 {
    background-color: #000000;
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 13px;
    display: none;
    box-shadow: 1px 1px 2px rgb(0,0,0,0.5);
    user-select: none;
}

#tooltip[data-show], #tooltip2[data-show], #tooltip3[data-show], #tooltip4[data-show], #tooltip5[data-show], #tooltip6[data-show], #tooltip7[data-show], #tooltip8[data-show] {
    display: block;
}

#arrow,
#arrow::before {
    position: absolute;
    width: 8px;
    height: 8px;
    z-index: -1;
}
#arrow {
    visibility: hidden;
}

#arrow::before {
    content: '';
    transform: rotate(45deg);
    background: #000000;
    visibility: visible;
    box-shadow: 1px 1px 2px rgb(0,0,0,0.5);
}

#tooltip[data-popper-placement^='top'] > #arrow, #tooltip2[data-popper-placement^='top'] > #arrow, #tooltip3[data-popper-placement^='top'] > #arrow, #tooltip4[data-popper-placement^='top'] > #arrow, #tooltip5[data-popper-placement^='top'] > #arrow, #tooltip6[data-popper-placement^='top'] > #arrow, #tooltip7[data-popper-placement^='top'] > #arrow, #tooltip8[data-popper-placement^='top'] > #arrow  {
    bottom: -4px;
}

</style>



<script src="site_html/popper.js"></script>
<script>

    /*********************************************************************************************************/

    const tool_zoomin = document.querySelector('#tool_zoomin');
    const tooltip_zoomin = document.querySelector('#tooltip');

    const popper_zoomin = Popper.createPopper(tool_zoomin, tooltip_zoomin, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_zoomin() {
        tooltip_zoomin.setAttribute('data-show', '');
        popper_zoomin.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_zoomin.update();
    }

    function hide_zoomin() {
        tooltip_zoomin.removeAttribute('data-show');
        popper_zoomin.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const tool_zoomout = document.querySelector('#tool_zoomout');
    const tooltip_zoomout = document.querySelector('#tooltip2');

    const popper_zoomout = Popper.createPopper(tool_zoomout, tooltip_zoomout, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_zoomout() {
        tooltip_zoomout.setAttribute('data-show', '');
        popper_zoomout.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_zoomout.update();
    }

    function hide_zoomout() {
        tooltip_zoomout.removeAttribute('data-show');
        popper_zoomout.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    const tool_rotate = document.querySelector('#tool_rotate');
    const tooltip_rotate = document.querySelector('#tooltip3');

    const popper_rotate = Popper.createPopper(tool_rotate, tooltip_rotate, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_rotate() {
        tooltip_rotate.setAttribute('data-show', '');
        popper_rotate.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_rotate.update();
    }

    function hide_rotate() {
        tooltip_rotate.removeAttribute('data-show');
        popper_rotate.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const tool_crop = document.querySelector('#tool_crop');
    const tooltip_crop = document.querySelector('#tooltip4');

    const popper_crop = Popper.createPopper(tool_crop, tooltip_crop, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_crop() {
        tooltip_crop.setAttribute('data-show', '');
        popper_crop.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_crop.update();
    }

    function hide_crop() {
        tooltip_crop.removeAttribute('data-show');
        popper_crop.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const tool_flipv = document.querySelector('#tool_flipv');
    const tooltip_flipv = document.querySelector('#tooltip5');

    const popper_flipv = Popper.createPopper(tool_flipv, tooltip_flipv, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_flipv() {
        tooltip_flipv.setAttribute('data-show', '');
        popper_flipv.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_flipv.update();
    }

    function hide_flipv() {
        tooltip_flipv.removeAttribute('data-show');
        popper_flipv.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const tool_fliph = document.querySelector('#tool_fliph');
    const tooltip_fliph = document.querySelector('#tooltip6');

    const popper_fliph = Popper.createPopper(tool_fliph, tooltip_fliph, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_fliph() {
        tooltip_fliph.setAttribute('data-show', '');
        popper_fliph.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_fliph.update();
    }

    function hide_fliph() {
        tooltip_fliph.removeAttribute('data-show');
        popper_fliph.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const tool_delete = document.querySelector('#tool_delete');
    const tooltip_delete = document.querySelector('#tooltip7');

    const popper_delete = Popper.createPopper(tool_delete, tooltip_delete, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_delete() {
        tooltip_delete.setAttribute('data-show', '');
        popper_delete.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_delete.update();
    }

    function hide_delete() {
        tooltip_delete.removeAttribute('data-show');
        popper_delete.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const tool_accept = document.querySelector('#tool_accept');
    const tooltip_accept = document.querySelector('#tooltip8');

    const popper_accept = Popper.createPopper(tool_accept, tooltip_accept, {
        placement: 'top',
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });

    function show_accept() {
        tooltip_accept.setAttribute('data-show', '');
        popper_accept.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }));
        popper_accept.update();
    }

    function hide_accept() {
        tooltip_accept.removeAttribute('data-show');
        popper_accept.setOptions((options) => ({
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const showEvents = ['mouseenter', 'focus'];
    const hideEvents = ['mouseleave', 'blur'];

    showEvents.forEach((event) => {
        tool_zoomin.addEventListener(event, show_zoomin);
        tool_zoomout.addEventListener(event, show_zoomout);
        tool_rotate.addEventListener(event, show_rotate);
        tool_crop.addEventListener(event, show_crop);
        tool_flipv.addEventListener(event, show_flipv);
        tool_fliph.addEventListener(event, show_fliph);
        tool_delete.addEventListener(event, show_delete);
        tool_accept.addEventListener(event, show_accept);
    });

    hideEvents.forEach((event) => {
        tool_zoomin.addEventListener(event, hide_zoomin);
        tool_zoomout.addEventListener(event, hide_zoomout);
        tool_rotate.addEventListener(event, hide_rotate);
        tool_crop.addEventListener(event, hide_crop);
        tool_flipv.addEventListener(event, hide_flipv);
        tool_fliph.addEventListener(event, hide_fliph);
        tool_delete.addEventListener(event, hide_delete);
        tool_accept.addEventListener(event, hide_accept);
    });

</script>

