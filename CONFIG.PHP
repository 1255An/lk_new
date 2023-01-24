<?php

if(!defined('allow_access_to_this_script')){die();}

// СУПЕРАДМИН
$superadmin_login = "iam@super.admin";
$superadmin_password = "1";

// НАСТРОЙКИ БАЗЫ ДАННЫХ POSTGRESQL
$config_db_host = 'localhost';
$config_db_name = 'lkenergo';
$config_db_user = 'AnnaTrofimova';
$config_db_pass = 'LbtMm64';
$config_db_prefix = 'test';

// НАСТРОЙКИ САЙТА
setlocale(LC_CTYPE, "ru_RU.UTF-8");

// ПОДКЛЮЧЕНИЕ НАБОРА ОБЩИХ ФУНКЦИЙ
require_once("vendor/autoload.php");
require_once("FUNCTIONS.PHP");

// ПОДКЛЮЧЕННЫЕ СТРАНИЦЫ В АДМИНИСТРАТОРСКОЙ
$menu_admin = array(
                    "Сводка"         => "MAIN",
                    "Заявки"         => "REQUESTS",
                    "Потребители"    => "CLIENTS",
                    "Администраторы" => "MODERATORS",
                    "Сообщения"      => "CHAT",
                    "Журнал"         => "LOG",
                    "Выйти"          => "EXIT"
                   );




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ТАБЛИЦЫ БАЗЫ ДАННЫХ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$TABLES = [
    "user"     =>  ["id"                        => "SERIAL NOT NULL",   // id пользоваля
                    "registration_date"         => "TIMESTAMP DEFAULT NOW()",         // дата регистрации пользоваля
                    "hash"                      => "TEXT DEFAULT ''",              // хэш для проверки адреса электронной почты
                    "hash_expired"              => "TIMESTAMP DEFAULT '1000-01-01'",         // дата когда истечёт срок действия хэша
                    "account_status_mail"       => "BOOLEAN DEFAULT FALSE",           // подтверждена ли почта (нужно снова подтверждать при смене почты)
                    "account_status_check"      => "BOOLEAN DEFAULT FALSE",           // проверены ли личные данные
                    "account_status_check_who"  => "VARCHAR DEFAULT ''",           // имя админа (не id, так как админ может уволиться и быть удалённым)
                    "juridical_form"            => "SMALLINT DEFAULT 1",          // юридическая форма: 1 - физическое лицо, 2 - юридическое лицо, 3 - индивидуальный предприниматель

                    "sex"                       => "BOOLEAN DEFAULT FALSE",           // пол (0 - мужчина/фирма, 1 - женщина) если выбрано физлицо или ИП. для юрлица 0

                    "fio_name_or_company_short" => "VARCHAR DEFAULT ''",           // фамилия физлица или название компании (в зависимости от юридической формы)
                    "fio_lastname_or_company"   => "VARCHAR DEFAULT ''",           // имя физлица или короткое название компании (в зависимости от юридической формы)
                    "fio_middlename"            => "VARCHAR DEFAULT ''",           // отчество физлица
                    "fio_rusforms"              => "TEXT DEFAULT ''",              // explode-массив с падежами ФИО
                    "email_login_actual"        => "VARCHAR NOT NULL",           // логин в виде электронной почты, который можно изменить
                    "email_login_original"      => "VARCHAR NOT NULL",           // первоначальный адрес почты при регистрации
                    "password"                  => "VARCHAR NOT NULL",           // пароль для авторизации в виде md5 хэша

                    "phone"                     => "VARCHAR DEFAULT ''",            // номер телефона без +7 или 8 в начале
                    "passport"                  => "TEXT DEFAULT ''",              // explode-массив с паспортными данными: серия и номер паспорта одним числом, дата рождения, дата выдачи паспорта, кем выдан, код подразделения
                    "inn"                       => "VARCHAR DEFAULT ''",            // идентификационный номер налогоплательщика
                    "snils"                     => "VARCHAR DEFAULT ''",            // страховой номер индивидуального лицевого счёта
                    "legal_address_region"      => "VARCHAR DEFAULT ''",           // юридический адрес: регион
                    "legal_address_location"    => "VARCHAR DEFAULT ''",           // юридический адрес: город
                    "legal_address_street"      => "VARCHAR DEFAULT ''",           // юридический адрес: улица
                    "legal_address_building"    => "VARCHAR DEFAULT ''",           // юридический адрес: строение
                    "legal_address_apart"       => "VARCHAR DEFAULT ''",           // юридический адрес: помещение, офис, квартира
                    "real_address_region"       => "VARCHAR DEFAULT ''",           // фактический адрес: регион
                    "real_address_location"     => "VARCHAR DEFAULT ''",           // фактический адрес: город
                    "real_address_street"       => "VARCHAR DEFAULT ''",           // фактический адрес: улица
                    "real_address_building"     => "VARCHAR DEFAULT ''",           // фактический адрес: строение
                    "real_address_apart"        => "VARCHAR DEFAULT ''",           // фактический адрес: помещение, офис, квартира
                    "egrul_number"              => "VARCHAR DEFAULT ''",            // номер в едином государственном реестре юридических лиц
                    "egrul_data"                => "TIMESTAMP DEFAULT '1000-01-01'",          // дата регистрации в едином государственном реестре юридических лиц

                    "pay_code_of_reason"        => "VARCHAR DEFAULT ''",            // КПП
                    "pay_checking_account"      => "VARCHAR DEFAULT ''",           // расчётный счёт
                    "pay_bank"                  => "VARCHAR DEFAULT ''",           // банк
                    "pay_correspondent_account" => "VARCHAR DEFAULT ''",           // корреспондентский счёт
                    "pay_bank_bic"              => "VARCHAR DEFAULT ''",            // БИК
                    "pay_tax_form"              => "BOOLEAN DEFAULT TRUE",           // форма налогооблажения: true - общая, false - упрощённая
                    "log"                       => "TEXT DEFAULT ''",              // текстовой журнал активности аккаунта (изменения данных, заходы и т.д.)
                    "last_visit_online"         => "TIMESTAMP DEFAULT NOW()",         // время последнего появления на сайте
                    "docs_checked"              => "SMALLINT DEFAULT 0",          // количество проверенных документов
                    "docs_unchecked"            => "SMALLINT DEFAULT 0",          // количество непроверенных документов
                    "request_active"            => "SMALLINT DEFAULT 0",          // активных заявок в процессе
                    "request_all"               => "SMALLINT DEFAULT 0",          // заявок вообще за всё время
                    "contact"                   => "VARCHAR DEFAULT ''"],          // ФИО и контактны представителя ЮЛ - ответственного лица

    "request"   =>  ["id"                       => "SERIAL NOT NULL",   // id заявки
                    "id_user"                   => "INT",               // id пользователя
                    "textnumber"                => "VARCHAR",           // служебный номер заявки: №16-08-00132ПрУ
                    "date"                      => "TIMESTAMP",         // дата подачи заявки
                    "reason"                    => "INT",               // вид заявки (причина)
                    "object_type"               => "VARCHAR",           // тип ТОО (жилой дом, нежилое помещение, земельный участок и т.д.)

                    "object_name"               => "VARCHAR",           // наименование энергопринимающего устройства
                    "object_region"             => "VARCHAR",           // регион объекта - выбрать из существующих доступных
                    "object_city"               => "VARCHAR",           // (при наличии) город объекта
                    "object_street"             => "VARCHAR",           // (при наличии) улица объекта
                    "object_building"           => "VARCHAR",           // (при наличии) здание объекта
                    "object_apart"              => "VARCHAR",           // (при наличии) помещение, офис, квартира
                    "cadastral_number"          => "VARCHAR",               // кадастровый номер
                    "ownership"                 => "VARCHAR",           // права собственности
                    "wattage_total"             => "SMALLINT",               // максимальная мощность энергопринимающих устройств (присоединяемых и ранее присоединяемых)
                    "voltage_total"             => "FLOAT",               // напряжение устройств (присоединяемых и ранее присоединяемых)
                    "wattage_before"            => "SMALLINT",               // максимальная мощность присоединяемых энергопринимающих устройств
                    "voltage_before"            => "FLOAT",               // напряжение устройств (присоединяемых)
                    "wattage_after"             => "SMALLINT",               // максимальная мощность ранее присоединенных энергопринимающих устройстd
                    "voltage_after"             => "FLOAT",               // напряжение устройств (ранее присоединенных)
                    "safe_category"             => "SMALLINT",               // категория надёжности
                    "project_date"              => "VARCHAR",           // explode-строка сроки поэтапного проектирования
                    "warrant_supplier"          => "VARCHAR",           // наименование гарантирующего поставщика
                    "status_for_user"           => "INT",               // статус заявки для пользователя
                    "status_for_admin"          => "INT",               // статус заявки для администратора
                    "log"                       => "TEXT"],             // лог действий по заявке

    "contracts" =>  ["id"                       => "SERIAL NOT NULL",   // id документа
                    "type"                      => "INT",               // тип документа
                    "name"                      => "VARCHAR",           // название документа (формируется автоматически, но можно изменить)
                    "price_with_tax"            => "FLOAT",             // сумма оплаты с НДС
                    "payment_status"            => "BOOLEAN",           // заплатил или не заплатил (TRUE, FALSE)
                    "tu_textnumber"             => "VARCHAR",           // номер ТУ
                    "tz_textnumber"             => "VARCHAR",           // номер ТЗ
                    "lep_textnumber"            => "VARCHAR",           // питающая ЛЭП
                    "tp_textnumber"             => "VARCHAR",           // центр питания
                    "pole_textnumber"           => "VARCHAR",           // опора
                    "line_textnumber"           => "VARCHAR",           // линия
                    "ownership"                 => "VARCHAR",           // собственность
                    "ntt"                       => "BOOLEAN",           // наличие трансформаторов тока
                    "npntt"                     => "BOOLEAN",           // наличие пломб на трансформаторах тока
                    "ntp"                       => "BOOLEAN",           // наличие трансформаторов напряжения
                    "npntn"                     => "BOOLEAN",           // наличие пломб на трансформаторах напряжение
                    "n_aiis_kuee"               => "VARCHAR",           // наименование АИИС КУЭЭ
                    "measurements"              => "BOOLEAN",           // проводились ли измерения
                    "nodsd"                     => "BOOLEAN",           // наличие оборудования дистанционного сбора данных
                    "p_post_vt"                 => "VARCHAR",           // потери постоянные в трансформаторе
                    "p_per_vt"                  => "VARCHAR",           // потери переменные в трансформаторе
                    "p_per_v_vl_kl"             => "VARCHAR"],          // потери переменные в ВК и КЛ

    "city"      =>  ["id"                       => "SERIAL NOT NULL",   // id города
                    "name"                      => "VARCHAR",           // название города
                    "short"                     => "VARCHAR"],          // сокращение до пары букв для документооборота

    "admins"    =>  ["id"                       => "SERIAL NOT NULL",   // id администратора
                    "email_login"               => "VARCHAR",           // логин администратора
                    "password"                  => "VARCHAR",           // пароль в хэше
                    "name"                      => "VARCHAR",           // имя администратора для понимания
                    "log"                       => "TEXT",              // лог действий администратора
                    "photo"                     => "BOOLEAN",           // фотография есть или нет
                    "privilege"                 => "VARCHAR"],          // выданные права администратора

    "seal"      =>  ["id"                       => "SERIAL NOT NULL",   // id пломбы
                    "id_user"                   => "INT",               // id пользователя
                    "number"                    => "VARCHAR",           // номер пломбы
                    "type"                      => "VARCHAR",           // тип пломбы
                    "place"                     => "VARCHAR",           // место установки
                    "logo"                      => "VARCHAR",           // логотип
                    "notes"                     => "TEXT"],             // примечание администратора

    "counter"   =>  ["id"                       => "SERIAL NOT NULL",   // id счётчика
                    "id_user"                   => "INT",               // id владельца
                    "serial_number"             => "VARCHAR",           // заводской номер
                    "type"                      => "VARCHAR",           // тип
                    "check_date"                => "TIMESTAMP",              // дата предыдущей проверки
                    "meter_reading"             => "VARCHAR",           // показания счётчика (для АОКУ)
                    "r_k"                       => "BOOLEAN",           // расчётный или контрольный
                    "status"                    => "BOOLEAN",           // статус - снят или установлен
                    "notes"                     => "TEXT"],             // примечание админа

    "seal_type" =>  ["id"                       => "SERIAL NOT NULL",   // id пломбы
                    "type"                      => "VARCHAR",           // тип пломбы
                    "tie"                       => "VARCHAR",           // тип измеряемой энергии
                    "i_nom"                     => "VARCHAR",           // I номинальный
                    "u_num"                     => "VARCHAR",           // U номинальный
                    "precise_class"             => "VARCHAR",           // класс точности
                    "mpi"                       => "VARCHAR"],          // межпроверочный интервал

    "message"   =>  ["id"                      => "SERIAL NOT NULL",   // id сообщения
                    "id_from"                  => "INT",               // отправитель из таблицы user или admins
                    "id_to"                    => "INT",               // получатель из таблицы user или admins
                    "from_type"                => "BOOLEAN",           // отправитель админ или пользователь
                    "from_to"                  => "BOOLEAN",           // получатель админ или пользователь
                    "date"                     => "TIMESTAMP",         // дата создания
                    "edited"                   => "BOOLEAN",           // было ли отредактировано
                    "date_edited"              => "TIMESTAMP",         // дата последнего редактирования
                    "text"                     => "TEXT",              // текст сообщения
                    "place"                    => "SMALLINT",          // 1 - поддержка, 2 - заявка
                    "place_id"                 => "INT"],              // id заявки, если есть

    "user_doc"  =>  ["id"                      => "SERIAL NOT NULL",   // id страницы документа
                     "doc_token"               => "BIGINT",            // токен для всего документа
                     "user_id"                 => "INT",               // кто прислал документ из таблицы user
                     "date"                    => "TIMESTAMP",         // дата отправки
                     "status"                  => "SMALLINT",          // статус документа (0 - непроверен, 1 - не прошёл (удален), 2 - прошёл)
                     "complete_load"           => "BOOLEAN",           // true -документ загружен полностью, 0 - документ не догружен
                     "comment"                 => "VARCHAR",           // комментарий админа, почему не прошел проверку
                     "doc_source"              => "SMALLINT",          // 0 - документ закачан из личных данных, 1 - из документов заявки,
                     "original_filename"       => "TEXT",              // оригинальное название файла
                     "who_checked_id"          => "SMALLINT"]          // кто проверил документ из таблицы admins
];
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////




?>