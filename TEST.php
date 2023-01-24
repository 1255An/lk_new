<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЗАПОЛНЕНИЕ БАЗЫ ДАННЫХ ТЕСТОВЫМИ ДАННЫМИ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////




// КЛАСС ПОЛУЧЕНИЯ ИМЁН
/************************************************************************************************************/
class getRussianNames {
    private $n, $ready, $fmale, $ffemale, $flast, $fpatronymic;

    // ПОДГРУЗКА ИМЁН
    public function __construct ($n=1) {
        $this->n = $n;
        $this->fmale=dirname(__FILE__).'/site_html/'.'names_male.txt';
        $this->ffemale=dirname(__FILE__).'/site_html/'.'names_female.txt';
        $this->flast=dirname(__FILE__).'/site_html/'.'names_last.txt';
        $this->fpatronymic=dirname(__FILE__).'/site_html/'.'names_patronymic.txt';
        $this->ready =
            (file_exists($this->fmale) and filesize($this->fmale)>1 and
                file_exists($this->ffemale) and filesize($this->ffemale)>1 and
                file_exists($this->flast) and filesize($this->flast)>1 and
                file_exists($this->fpatronymic) and filesize($this->fpatronymic)>1);
    }

    // ЖЕНСКАЯ ФОРМА ФАМИЛИЙ
    private function getWomanForm ($last) {
        $last = preg_replace ("/^(.+)(ов|ев|ёв|ин|ын)$/","$1$2а",$last);
        $last = preg_replace ("/^(.+)(ый|ий)$/","$1ая",$last);
        return $last;
    }

    // ЖЕНСКАЯ ФОРМА ОТЧЕСТВ
    private function getWomanPatronymic ($last) {
        $last = preg_replace ("/^(.+)(ьич)$/","$1ьичевна",$last);
        $last = preg_replace ("/^(.+)(ич)$/","$1на",$last);
        $last = preg_replace ("/^(.+)(ыч)$/","$1овна",$last);
        return $last;
    }

    // ПОЛУЧИТЬ ИМЯ
    public function get ($div="<br /><br />\n") {
        $str = '';
        if (!$this->ready) return 'Неизвестное Ноунейменко';
        $male = file($this->fmale,FILE_IGNORE_NEW_LINES);
        $female = file($this->ffemale,FILE_IGNORE_NEW_LINES);
        $last = file($this->flast,FILE_IGNORE_NEW_LINES);
        $patronymic = file($this->fpatronymic, FILE_IGNORE_NEW_LINES);
        shuffle($male);
        shuffle($female);
        shuffle($last);
        shuffle($patronymic);

        // ГЕНЕРАЦИЯ ФЕЙКОВОГО ПОТРЕБИТЕЛЯ
        for ($i=0; $i<$this->n; $i++) {

            // [-] - id (сам создаётся в базе)
            // [0] - дата регистрации
            $str .= str_replace(" ", "_", date('d.m.Y H:i:s', mt_rand(time()-31556926,time()-604800)))." ";

            // [1] - хэш
            $str .= "без_хэша ";

            // [2] - время устаревания хэша
            $str .= str_replace(" ", "_", date('d.m.Y H:i:s', time()-1000000))." ";

            // [3] статус аккаунта
            $account_status_mail = (bool)random_int(0, 1);
            $str .= ($account_status_mail ? "0" : "1");

            $account_status_check = (bool)random_int(0, 1);
            $str .= " " . ($account_status_check ? "0" : "1");

            $str .= " ТестовыйАдминистратор ";

            // [4] юридическая форма (1 - физ.лицо, 2 - им, 3 - юрлицо)
            $jur = mt_rand(1,3);
            $str .= $jur;

            // [5] пол (0 - мужчина/фирма, 1 - женщина)
            if($jur!=3) {
                $gender = (bool)random_int(0, 1);
                $str .= " " . ($gender ? "0" : "1") . " ";
            }else{
                $str .= " 0 ";
            }

            // [6][7][8] ФИО и [9] СКЛОНЕНИЯ
            if($jur!=3)
            {
                $str .= ($gender ? $male[$i].' '.$last[$i].' '.$patronymic[$i]:
                   $female[$i].' '.$this->getWomanForm($last[$i]).' '.$this->getWomanPatronymic($patronymic[$i]));

                //$forms = morphos\Russian\getNameCases("Иванов Пётр Сидорович", morphos\Gender::MALE);

                if($gender == true) {
                    $forms = morphos\Russian\getNameCases($last[$i].' '.$male[$i].' '.$patronymic[$i], morphos\Gender::MALE);
                }else {
                    $forms = morphos\Russian\getNameCases($this->getWomanForm($last[$i]).' '.$female[$i].' '.$this->getWomanPatronymic($patronymic[$i]), morphos\Gender::FEMALE);
                }

                $str .= " ".str_replace(" ","_",implode("|", $forms));

            }else{
                // генератор названия компании и короткого названия компании
                $random_company = GenerateCompanyName();
                $random_company_short = preg_replace('/[^qQwWrRtTpPsSdDfFgGhHjJkKlLzZxXcCvVbBnNmM\-]/', '', $random_company);
                $str .= $random_company_short." ".$random_company." без_отчества без_склонений";
            }

            // [10] почта
            if($jur!=3)
            {
                if($gender==TRUE) {
                    $email_name = mb_strtolower(convert_cyr2lat($male[$i]));
                }else {
                    $email_name = mb_strtolower(convert_cyr2lat($female[$i]));
                }
            }else {
                $email_name = mb_strtolower($random_company);
            }
            $str .= " ".$email_name."@".GenerateMailService();

            // [11] оригинальная почта
            $str .= " ".$email_name."@".GenerateMailService();

            // [12] пароль к логину
            $str .= " ".hash('sha256',mt_rand(1, time()));
            //$str .= " ".hash('sha256',mt_rand(1, time()));

            // [13] телефон
            $str .= " ".GenerateBigNumber(10);

            // [14] паспорт
            $str .= " ".GenerateBigNumber(10)."|".(time()-100000)."|".time()."|КЕМВЫДАН|".GenerateBigNumber(6);

            // [15] inn
            if($jur==3)
            {
                $str .= " ".GenerateBigNumber(10);
            }else{
                $str .= " ".GenerateBigNumber(12);
            }

            // [16] snils
            $str .= " ".GenerateBigNumber(11);

            // [17] юридический адрес: регион
            $str .= " ".str_replace(" ","_",GenerateRegion());
            // [18] город
            $str .= " ".str_replace(" ","_",GenerateCity());
            // [19] улица
            $str .= " ".str_replace(" ", "_",GenerateStreet());
            // [20] строение
            $str .= " ".mt_rand(1,100);
            // [21] помещение
            $str .= " ".mt_rand(1,300);

            // [22] фактический адрес: регион
            $str .= " ".str_replace(" ","_",GenerateRegion());
            // [23] город
            $str .= " ".str_replace(" ","_",GenerateCity());
            // [24] улица
            $str .= " ".str_replace(" ", "_",GenerateStreet());
            // [25] строение
            $str .= " ".mt_rand(1,100);
            // [26] помещение
            $str .= " ".mt_rand(1,300);

            // [27] егрюл номер
            $str .= " ".GenerateBigNumber(13);

            // [28] егрюл дата
            $str .= " ".str_replace(" ", "_", date('d.m.Y H:i:s', mt_rand(time()-31556926,time()-604800)));
            //$str .= " ".mt_rand(time()-31556926,time()-604800);

            // [29] КПП
            $str .= " ".GenerateBigNumber(9);

            // [30] расчётный счёт
            $str .= " ".GenerateBigNumber(20);

            // [31] банк
            $str .= " ".str_replace(" ", "_",GenerateBank());

            // [32] корреспондентский счёт
            $str .= " ".GenerateBigNumber(20);

            // [33] БИК
            $str .= " ".GenerateBigNumber(9);

            // [34] форма налогооблажения (true - общая/нету, false - упрощённая)
            if($jur!=1)
            {
                $str.=" ".random_int(0, 1);
            }else {
                $str.=" 0";
            }

            // [35] текстовой журнал активности
            $str.=" журнал_пуст";

            // [36] время последнего появления на сайте
            $str .= " ".str_replace(" ", "_", date('d.m.Y H:i:s', mt_rand(time()-604800,time()-36800)));

            // [37] количество проверенных документов
            $str.=" 0";

            // [38] количество непроверенных документов
            $str.=" 0";

            // [39] количество проверенных документов
            $str.=" 0";

            // [40] количество непроверенных документов
            $str.=" 0";

            // [41] ФИО представителя
            $str .= " Без_представителя";

            if ($i<$this->n-1) $str .= $div;

        }
        return $str;
    }
}
/************************************************************************************************************/



function GenerateBank()
{
    $bank = array_flip(array('Сбербанк','ВТБ','Тинькофф','Альфа-банк','Уралсиб','Открытие','Точка','HomeCredit','МТС Банк','Росбанк','Газпромбанк'));
    return array_rand($bank);
}

function GenerateBigNumber($max) {

    $output = rand(1,9);

    for($i=0; $i<($max-1); $i++) {
        $output .= rand(0,9);
    }

    return $output;
}

function GenerateRegion()
{
    $region = array_flip(array('Белгородская область','Брянская область','Владимирская область','Воронежская область', 'Ивановская область','Калужская область','Костромская область','Курская область','Липецкая область','Московская область','Орловская область','Рязанская область','Смоленская область','Тамбовская область','Тверская область','Тульская область','Ярославская область','Северо-Западный федеральный округ','Республика Карелия','Республика Коми','Архангельская область','Вологодская область','Калининградская область','Ленинградская область','Мурманская область','Новгородская область','Псковская область','Южный федеральный округ','Республика Адыгея','Республика Дагестан','Республика Ингушетия','Кабардино-Балкарская Республика','Республика Калмыкия','Карачаево-Черкесская Республика','Республика Северная Осетия - Алания','Чеченская Республика','Краснодарский край','Ставропольский край','Астраханская область','Волгоградская область','Ростовская область','Приволжский федеральный округ','Республика Башкортостан','Республика Марий Эл','Республика Мордовия','Республика Татарстан','Удмуртская Республика','Чувашская Республика','Кировская область','Нижегородская область','Оренбургская область','Пензенская область','Пермская область','Самарская область','Саратовская область','Ульяновская область','Уральский федеральный округ','Курганская область','Свердловская область','Тюменская область','Ханты-Мансийский автономный округ','Ямало-Ненецкий автономный округ','Челябинская область','Сибирский федеральный округ','Республика Алтай','Республика Бурятия','Республика Тыва','Республика Хакасия','Алтайский край','Красноярский край','Эвенкийский автономный округ','Иркутская область','Кемеровская область','Новосибирская область','Омская область','Томская область','Читинская область','Бурятский автономный округ','Дальневосточный федеральный округ','Республика Саха (Якутия)','Приморский край','Хабаровский край','Амурская область','Камчатская область','Корякский автономный округ','Магаданская область','Сахалинская область','Еврейская автономная область','Чукотский автономный округ'));

    return array_rand($region);
}

$city_file = dirname(__FILE__).'/site_html/'.'names_cities.txt';
$city_ready = false;
if(file_exists($city_file) and filesize($city_file )>1)
{
    $city_ready = true;
    $city = file($city_file, FILE_IGNORE_NEW_LINES);
    $city = array_flip($city);
}

function GenerateCity()
{
    global $city, $city_ready;

    if($city_ready==true)
    {
        return array_rand($city);
    } else {
        return "Ошибка загрузки городов";
    }
}

$street_file = dirname(__FILE__).'/site_html/'.'names_street.txt';
$street_ready = false;
if(file_exists($street_file) and filesize($street_file )>1)
{
    $street_ready = true;
    $street = file($street_file, FILE_IGNORE_NEW_LINES);
    $street = array_flip($street);
}

function GenerateStreet()
{
    global $street, $street_ready;

    if($street_ready==true)
    {
        return array_rand($street);
    } else {
        return "Ошибка загрузки улиц";
    }
}


function GenerateMailService()
{
    $services = array_flip(array('mail', 'gmail', 'bk', 'msn', 'hotmail', 'rambler', 'aport', 'yandex', 'ya', 'yahoo', 'outlook'));
    $domens = array_flip(array('com', 'ru', 'org'));

    return array_rand($services).".".array_rand($domens);
}


/************************************************************************************************************/
function GenerateCompanyName()
{
    $techTerms = array_flip(array('AddOn', 'Algorithm', 'Architect', 'Array', 'Asynchronous', 'Avatar', 'Band', 'Base', 'Beta', 'Binary', 'Blog', 'Board', 'Boolean', 'Boot', 'Bot', 'Browser', 'Bug', 'Cache', 'Character', 'Checksum', 'Chip', 'Circuit', 'Client', 'Cloud', 'Cluster', 'Code', 'Codec', 'Coder', 'Column', 'Command', 'Compile', 'Compression', 'Computing', 'Console', 'Constant', 'Control', 'Cookie', 'Core', 'Cyber', 'Default', 'Deprecated', 'Dev', 'Developer', 'Development', 'Device', 'Digital', 'Domain', 'Dynamic', 'Emulation', 'Encryption', 'Engine', 'Error', 'Exception', 'Exploit', 'Export', 'Extension', 'File', 'Font', 'Fragment', 'Frame', 'Function', 'Group', 'Hacker', 'Hard', 'HTTP', 'Icon', 'Input', 'IT', 'Kernel', 'Key', 'Leak', 'Link', 'Load', 'Logic', 'Mail', 'Mashup', 'Mega', 'Meme', 'Memory', 'Meta', 'Mount', 'Navigation', 'Net', 'Node', 'Open', 'OS', 'Output', 'Over', 'Packet', 'Page', 'Parallel', 'Parse', 'Path', 'Phone', 'Ping', 'Pixel', 'Port', 'Power', 'Programmers', 'Programs', 'Protocol', 'Push', 'Query', 'Queue', 'Raw', 'Real', 'Repository', 'Restore', 'Root', 'Router', 'Run', 'Safe', 'Sample', 'Scalable', 'Script', 'Server', 'Session', 'Shell', 'Smart', 'Socket', 'Soft', 'Solid', 'Sound', 'Source', 'Streaming', 'Symfony', 'Syntax', 'System', 'Tag', 'Tape', 'Task', 'Template', 'Thread', 'Token', 'Tool', 'Tweak', 'URL', 'Utility', 'Viral', 'Volume', 'Ware', 'Web', 'Wiki', 'Window', 'Wire'));
    $culinaryTerms = array_flip(array('Appetit', 'Bake', 'Beurre', 'Bistro', 'Blend', 'Boil', 'Bouchees', 'Brew', 'Buffet', 'Caffe', 'Caffeine', 'Cake', 'Carve', 'Caviar', 'Chef', 'Chocolate', 'Chop', 'Citrus', 'Cocoa', 'Compote', 'Cook', 'Cooker', 'Cookery', 'Cool', 'Core', 'Coulis', 'Course', 'Crouton', 'Cuisine', 'Dash', 'Dessert', 'Dip', 'Dish', 'Dress', 'Entree', 'Espresso', 'Extracts', 'Fajitas', 'Fibers', 'Fold', 'Formula', 'Fruit', 'Fumet', 'Fusion', 'Gastronomy', 'Glucose', 'Gourmet', 'Grains', 'Gratin', 'Greens', 'Guacamole', 'Herbs', 'Honey', 'Hybrid', 'Ice', 'Icing', 'Immersion', 'Induction', 'Instant', 'Jasmine', 'Jelly', 'Juice', 'Kiwi', 'Lean', 'Leek', 'Legumes', 'Lemon', 'Lime', 'Liqueur', 'Madeleine', 'Mango', 'Marinate', 'Melon', 'Mill', 'Mince', 'Mirepoix', 'Mix', 'Mousse', 'Muffin', 'Mull', 'Munster', 'Nectar', 'Nut', 'Olive', 'Organic', 'Organic', 'Pan', 'Papillote', 'Pare', 'Pasta', 'Pate', 'Peanut', 'Pear', 'Pesto', 'Picante', 'Pie', 'Pigment', 'Pinot', 'Plate', 'Plum', 'Pod', 'Prepare', 'Pressure', 'Pudding', 'Pulp', 'Quiche', 'Rack', 'Raft', 'Raisin', 'Recipe', 'Reduce', 'Relish', 'Render', 'Risotto', 'Rosemary', 'Roux', 'Rub', 'Salad', 'Salsa', 'Sauce', 'Sauté', 'Season', 'Slice', 'Smoked', 'Soft', 'Sorbet', 'Soup', 'Spaghetti', 'Specialty', 'Spicy', 'Splash', 'Steam', 'Stem', 'Sticky', 'Stuff', 'Sugar', 'Supreme', 'Sushi', 'Sweet', 'Table', 'Tart', 'Taste', 'Tasting', 'Tea', 'Tender', 'Terrine', 'Tomato', 'Vanilla', 'Wash', 'Wax', 'Wine', 'Wok', 'Zest'));

    switch(mt_rand(3,6)) {
        case "3":
            return array_rand($techTerms).array_rand($culinaryTerms);
            break;
        case "4":
            return array_rand($culinaryTerms).array_rand($techTerms);
            break;
        case "5":
            return array_rand($culinaryTerms).array_rand($culinaryTerms);
            break;
        case "6":
            return array_rand($techTerms).array_rand($techTerms);
            break;

    }

}
/************************************************************************************************************/



// количество для добавление - предел где-то 500 с лишним из-за текстовых файлов с именами
$num=500;
echo "<b>ДОБАВЛЕНИЕ ФЕЙКОВЫХ ПОТРЕБИТЕЛЕЙ: ".$num."</b><br /><br />";

// генератор ФИО
$list = new getRussianNames($num);
$flood_users = $list->get("~");



// парсер результатов
$all_users = array();
$u=0;
$flood_users_exploded = explode("~", $flood_users);
foreach($flood_users_exploded as $flood_users_this)
{
    $o=0;
    $flood_user_entity = explode(" ", $flood_users_this);
    foreach($flood_user_entity as $key)
    {
        $all_users[$u][$o]=$key;
        $o++;
    }
    $u++;
}


// получаем список колонок
$all_columns='(';
$p=0;
foreach ($TABLES['user'] as $key => $value)
{
    if($p>1)
    {
        $all_columns.=",";
    }

    if($p!=0)
    {
        $all_columns.=$key;
    }

    $p++;
}
$all_columns.=')';

// получаем список всех строк
$all_rows='';
$all_users_num=0;
foreach($all_users as $key => $value)
{
    $p=0;
    if($all_users_num>0)
    {
        $all_rows.=",(";
    }else {
        $all_rows.="(";
    }

    foreach ($value as $key2)
    {
        if($p>0)
        {
            $all_rows.=",";
        }
        $all_rows.="'".str_replace("_", " ", $key2)."'";
        $p++;
    }

    $all_rows.=")";

    $all_users_num++;
}

$sql = "INSERT INTO ".$config_db_prefix."_user ".$all_columns." VALUES ".$all_rows.";";

echo "<PRE>".$sql."</PRE>";
$query = $db->prepare($sql);
$query->execute();
db_checkError($query);

echo "<pre>";
print_r($all_users);
echo "</pre>";

echo "<br /><br /><b>ЗАВЕРШЕНО</b>";

?>