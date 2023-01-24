<?php

if(!defined('allow_access_to_this_script')){die();}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЗАГОЛОВКИ HTTP, ЧТОБЫ ВСЕГДА ПОДГРУЖАЛИСЬ НОВЫЕ СТРАНИЦЫ
header("Expires: Mon, 11 Mar 1984 09:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=utf-8');
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


date_default_timezone_set('Asia/Yekaterinburg');


///////////////////////////////////////////////////////////////////////////////////////////////////////////
// СЕССИИ ВМЕСТО ПЕЧЕНЕК
session_start();
// НЕ ДАЁМ УДАЛИТЬ СЕССИЮ, ЕСЛИ ПОЛЬЗОВАТЕЛЬ ЕЩЁ НА САЙТЕ
if( !isset($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60 )
    $_SESSION['last_access'] = time();
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ПОДКЛЮЧЕНИЕ К БД
$dsn = "pgsql:host=$config_db_host;port=5432;dbname=$config_db_name;";

$db_options = [PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]; // убирает дублирование ассоциативного массива

try {
    $db = new PDO($dsn, $config_db_user, $config_db_pass, $db_options);
} catch (PDOException $i) {
    die("Ошибка подключения к базе данных");
}
unset($config_db_name);
unset($config_db_user);
unset($config_db_pass);
unset($config_db_host);
unset($db_options);
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



///////////////////////////////////////////////////////////////////////////////////////////////////////////
// SQL: ПОЛУЧЕНИЕ ДАННЫХ С ОДНОЙ ТАБЛИЦЫ
// !!! добавить case insensitive
function db_selectAll($table, $params = [], $columns = [], $order="", $order_option=false, $limit=0, $offset=-1)
{
    global $db, $config_db_prefix;

    // ПРЕФИКС ТАБЛИЦЫ
    $table=$config_db_prefix."_".$table;


    if (empty($columns))
    {
        $sql = "SELECT * FROM ".$table;
    }else {
        $z=0;
        $sql = "SELECT ";

        foreach ($columns as $value)
        {
            if($z>0)$sql.= ",";
            $sql.= $value;
            $z++;
        }

        $sql.=" FROM ".$table;
    }

    if (!empty($params)) {
        $i = 0;
        $last_key='';
        $last_same=false;
        $last_sep='';
        foreach ($params as $key => $value)
        {

            $keys = explode('|', $key);
            $key=$keys[1];

            if($last_key!=$key)
            {
                $last_key=$key;
                $key="(".$key;
                if(isset($keys[2])) $keys[2]="(".$keys[2];
                $last_sep=")";
            }else{
                $last_sep="";
            }

            if (!is_numeric($value[0])) {
                $value[0] = "'".$value[0]."'"; //добавляем кавычки если переданный параметр - строка
            }

            if($value[1]=='') $value[1]="=";

            if ($i === 0) { // i - количество параметров
                if(isset($keys[2]))
                {
                    $sql.=" WHERE ".$keys[2]." ".$value[1]." ".$value[0];
                }else{
                    $sql.=" WHERE ".$key." ".$value[1]." ".$value[0];
                }
            } else {
                if(isset($keys[2]))
                {
                    $sql.=$last_sep." ".$value[2]." ".$keys[2]." ".$value[1]." ".$value[0];
                }else{
                    $sql.=$last_sep." ".$value[2]." ".$key." ".$value[1]." ".$value[0];
                }
            }
            $i++;

        }
        $sql.=")";
    }

    if($order!="")$sql.=" ORDER BY ".$order;
    if($order_option==true)$sql.=" DESC";
    if($order_option==false)$sql.=" ASC";
    if($limit!=0)$sql.=" LIMIT ".$limit;
    if($offset!=-1)$sql.=" OFFSET ".$offset;

    //echo "<br /><br />".$sql."<br /><br />";

    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
    return $query->fetchAll();
}

// SQL: ПОЛУЧЕНИЕ ОДНОЙ СТРОКИ С ВЫБРАННОЙ ТАБЛИЦЫ
function db_selectOne($table, $params = [])
{
    global $db, $config_db_prefix;

    // ПРЕФИКС ТАБЛИЦЫ
    $table=$config_db_prefix."_".$table;

    $sql = "SELECT * FROM $table";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'".$value."'"; //добавляем кавычки если переданный параметр - строка
            }
            if ($i === 0) { // i - количество параметров
                $sql.=" WHERE ".$key." = ".$value;
            } else {
                $sql.=" AND ".$key." = ".$value;
            }
            $i++;
        }
    }
    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
    return $query->fetch();
}


// SQL: ЗАПИСЬ В ТАБЛИЦУ
// !!! добавить case insensitive
function db_insert($table, $params)
{
    global $db, $config_db_prefix;

    // ПРЕФИКС ТАБЛИЦЫ
    $table=$config_db_prefix."_".$table;

    $i = 0;
    $column = '';
    $mask = '';
    foreach ($params as $key => $value) {
        // парсим переданные параметры
        if ($i === 0) {
            $column = $column.$key;
            $mask = "'".$value."'";
        } else {
            $column = $column.", ".$key;
            $mask = $mask.", '".$value."'";
        }
        $i++;
    }

    $sql = "INSERT INTO $table ($column) VALUES ($mask)";
    //echo $sql;
    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
    return ($db->lastInsertId());
}

// SQL: ВНЕСТИ ИЗМЕНЕНИЯ
// !!! добавить case insensitive
function db_update($table, $id, $params)
{
    global $db, $config_db_prefix;

    // ПРЕФИКС ТАБЛИЦЫ
    $table=$config_db_prefix."_".$table;

    $i = 0;
    $str = '';

    foreach ($params as $key => $value) {
        //парсим переданные параметры
        if ($i === 0) {
            $str = $key." = '".$value."'";
        } else {
            $str = $str.", ".$key." = '".$value."'";
        }
        $i++;
    }

    $sql = "UPDATE $table SET $str WHERE id = $id";
    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
}

// SQL: ПРОВЕРКА ВЫПОЛНЕНИЯ ЗАПРОСА В БД
// !!! добавить case insensitive
function db_checkError($query)
{
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[2];
        exit();
    }
    return true;
}

// SQL: УНИЧТОЖЕНИЕ ТАБЛИЦЫ
function db_drop($table)
{
    global $db, $config_db_prefix;

    // ПРЕФИКС ТАБЛИЦЫ
    $table=$config_db_prefix."_".$table;

    $sql = "DROP TABLE IF EXISTS ".$table;
    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
}

// SQL: СОЗДАНИЕ ТАБЛИЦЫ
// !!! добавить case insensitive
function db_create($table, $params)
{
    global $db, $config_db_prefix;

    // ПРЕФИКС ТАБЛИЦЫ
    $table=$config_db_prefix."_".$table;

    $i = 0;
    $str = '';

    foreach ($params as $key => $value) {
        //парсим переданные параметры
        if ($i === 0) {
            $str = $key." ".$value;
            $key_id=$key;
        } else {
            $str = $str.", ".$key." ".$value;
        }
        $i++;
    }

    $sql = "CREATE TABLE $table ($str, PRIMARY KEY ($key_id))";
    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
    unset($key_id);
}

// ПОДСЧИТАТЬ КОЛИЧЕСТВО ЭЛЕМЕНТОВ
// !!! добавить case insensitive
function db_count($table, $params = [])
{
    global $db, $config_db_prefix;

    // ПРЕФИКС ТАБЛИЦЫ
    $table=$config_db_prefix."_".$table;

    $sql = "SELECT COUNT(*) FROM $table";
    if (!empty($params)) {
        $i = 0;
        $last_key='';
        $last_same=false;
        $last_sep='';
        foreach ($params as $key => $value)
        {

            $keys = explode('|', $key);
            $key=$keys[1];

            if($last_key!=$key)
            {
                $last_key=$key;
                $key="(".$key;
                if(isset($keys[2])) $keys[2]="(".$keys[2];
                $last_sep=")";
            }else{
                $last_sep="";
            }

            if (!is_numeric($value[0])) {
                $value[0] = "'".$value[0]."'"; //добавляем кавычки если переданный параметр - строка
            }

            if($value[1]=='') $value[1]="=";

            if ($i === 0) { // i - количество параметров
                if(isset($keys[2]))
                {
                    $sql.=" WHERE ".$keys[2]." ".$value[1]." ".$value[0];
                }else{
                    $sql.=" WHERE ".$key." ".$value[1]." ".$value[0];
                }
            } else {
                if(isset($keys[2]))
                {
                    $sql.=$last_sep." ".$value[2]." ".$keys[2]." ".$value[1]." ".$value[0];
                }else{
                    $sql.=$last_sep." ".$value[2]." ".$key." ".$value[1]." ".$value[0];
                }
            }
            $i++;

        }
       $sql.=")";
    }
    //echo "<br/><br/>".$sql."<br/><br/>";
    $query = $db->prepare($sql);
    $query->execute();
    db_checkError($query);
    return $query->fetchColumn();
}
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФАЙЛОВЫЙ ЛОГ ДЛЯ ОТЛАДКИ
///////////////////////////////////////////////////////////////////////////////////////////////////////////
$filename="log.txt";
@unlink($filename);
function debug_log($output)
{
    global $filename;

    if (!$fp = fopen($filename, 'a')) {
        echo "Cannot open file ($filename)";
        exit;
    }

    if (fwrite($fp, $output) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    fclose($fp);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////
// YANDEX SMARTCAPTCHA
///////////////////////////////////////////////////////////////////////////////////////////////////////////
define('SMARTCAPTCHA_SERVER_KEY', 'Dkh2GIA5lWccFD0mWOWUoO7gZMFWb9VezQvaUtFc');
function check_captcha($token)
{
    $ch = curl_init();
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR'], // Нужно передать IP пользователя.
        // Как правильно получить IP зависит от вашего прокси.
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://captcha-api.yandex.ru/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////
// КИРИЛЛИЦА В ЛАТИНИЦУ
///////////////////////////////////////////////////////////////////////////////////////////////////////////
function convert_cyr2lat($string)
{
    $cyr=array(
        "Щ", "Ш", "Ч","Ц", "Ю", "Я", "Ж","А","Б","В",
        "Г","Д","Е","Ё","З","И","Й","К","Л","М","Н",
        "О","П","Р","С","Т","У","Ф","Х","Ь","Ы","Ъ",
        "Э",
        "щ", "ш", "ч","ц", "ю", "я", "ж","а","б","в",
        "г","д","е","ё","з","и","й","к","л","м","н",
        "о","п","р","с","т","у","ф","х","ь","ы","ъ",
        "э"
    );
    $lat=array(
        "Shch","Sh","Ch","C","Yu","Ya","J","A","B","V",
        "G","D","e","e","Z","I","y","K","L","M","N",
        "O","P","R","S","T","U","F","H","",
        "Y","" ,"E",
        "shch","sh","ch","c","yu","ya","j","a","b","v",
        "g","d","e","e","z","i","y","k","l","m","n",
        "o","p","r","s","t","u","f","h",
        "", "y","" ,"e"
    );

    for($i=0; $i<count($cyr); $i++)
    {
        $c_cyr = $cyr[$i];
        $c_lat = $lat[$i];
        $string = str_replace($c_cyr, $c_lat, $string);
    }

    $string = preg_replace("/([eyuioaEYUIOA]+)[Kk]h/", "\${1}h", $string);
    $string = preg_replace("/^kh/", "h", $string);
    $string = preg_replace("/^Kh/", "H", $string);
    return $string;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ВЫДАЁМ ИМЯ СОГЛАСНО ЗАРАНЕЕ ГОТОВОМУ СПИСКУ ПАДЕЖЕЙ (0-5)
///////////////////////////////////////////////////////////////////////////////////////////////////////////
function nameForm($massiv, $padezh)
{
    $n = explode("|", $massiv);
    return $n[$padezh];
}



// Показывает даты в нужном формате
function niceLookingDate($num, $type)
{
    $day   = array('нулевой день','понедельник','вторник','среда','четверг','пятница','суббота','воскресенье');
    $month = array('нулевой месяц','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');

    $n=date("n",$num);

    switch($type)
    {
        case 1: // HH:MM:SS
            return date("H:i:s",$num);
            break;
        case 2: // 22 апреля 2007, вторник, 17:18
            return date("d",$num)." ".$month[$n]." ".date("Y",$num).", ".$day[date("w",$num)].date(", H:i",$num);
            break;
        case 3: // 22 апреля 2007, вторник
            return date("d",$num)." ".$month[$n]." ".date("Y",$num).", ".$day[date("w",$num)];
            break;
        case 4: // 31.12.2007
            return date("d",$num).".".$n.".".date("Y",$num);
            break;
        case 5: // 31.12.2007, HH:MM:SS
            return date("d",$num).".".$n.".".date("Y",$num).", ".date("H:i:s",$num);
            break;
        case 6: // 22 апреля 2007, HH:MM
            return date("d",$num)." ".$month[$n]." ".date("Y",$num).", ".date("H:i",$num);
            break;
    }

}



?>