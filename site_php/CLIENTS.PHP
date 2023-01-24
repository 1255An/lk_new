<?php

if(!defined('allow_access_to_this_script')){die();}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЗАПРОШЕНО РЕДАКТИРОВАНИЕ ПОТРЕБИТЕЛЯ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['edit']))
{
    if(is_numeric($_GET['edit']))
    {
        require_once('site_php/CLIENT_EDIT.PHP');
        die();
    }
}



echo "<div class='page_logo'>СПИСОК ПОТРЕБИТЕЛЕЙ</div>";


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// СПИСОК ПОТРЕБИТЕЛЕЙ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Сколько показывать строчек на экране
if(!isset($_SESSION['list_size'])) $_SESSION['list_size']               = 10;

// Текущая выбранная страница
if(!isset($_SESSION['list_page'])) $_SESSION['list_page']               = 1;

// Сортировка списка
if(!isset($_SESSION['list_sort'])) $_SESSION['list_sort']               = 1;
if(!isset($_SESSION['list_side'])) $_SESSION['list_side']               = false;


$_SESSION['list_filter_need_check'] = false;                   // Включён ли фильтр поиска непроверенных пользователей''


// ВЫБОР РАЗМЕРА СТРАНИЦ
if(isset($_GET['size']))
{
    // ПРОВЕРКА ЗНАЧЕНИЯ
    if($_GET['size']!="10" && $_GET['size']!="25" && $_GET['size']!="50" && $_GET['size']!="100")
    {
        $_GET['size']=10;
    }

    $_SESSION['list_size']=$_GET['size'];
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}

// НАПРАВЛЕНИЕ ВЫБОРКИ
if(isset($_GET['sort']))
{
    if(is_numeric($_GET['sort']))
    {
        if($_GET['sort']==$_SESSION['list_sort'])
        {
            if($_SESSION['list_side']==false)
            {
                $_SESSION['list_side']=true;
            }else{
                $_SESSION['list_side']=false;
            }
        }
    }else{
        $_GET['sort']=1;
    }

    $_SESSION['list_sort']=$_GET['sort'];
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}

if(isset($_GET['filters']))
{
    if($_GET['filters']=="off")
    {
        $_SESSION['filter_on']=false;
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }
}


// НАБОР ФИЛЬТРОВ
// ФОРМАТ: МАССИВ[*]['Название_фильтра','столбец_в_бд','тип_инпута','макс_длина','значение_для_бд_если_есть','regex_в_формате_javascript','']
// ТИП СТОЛБЦА БЕРЁТСЯ ИЗ МАССИВА $TABLES
// ФИЛЬТРЫ С ОДИНАКОВЫМИ НАЗВАНИЯМИ ДОЛЖНЫ НАХОДИТЬСЯ РЯДОМ
$f=0;
$filters = array();
$filters[$f++]   = ['Юридические лица','checkbox','','juridical_form', '3', '','OR'];
$filters[$f++] = ['Индивидуальные предприниматели','checkbox','','juridical_form', '2', '','OR'];
$filters[$f++] = ['Физические лица','checkbox','','juridical_form','1', '','OR'];
$filters[$f++] = ['С заявками в обработке','checkbox','','request_active','>0', '','AND'];
$filters[$f++] = ['С завершёнными заявками','checkbox','','request_all','>0', '','AND'];
$filters[$f++] = ['С непроверенными документами','checkbox','','docs_checked','>0', '','AND'];
$filters[$f++] = ['С проверенными документами','checkbox','','docs_unchecked','>0', '','AND'];
$filters[$f++] = ['С подтверждённой почтой','checkbox','','account_status_mail','1', '','AND'];
$filters[$f++] = ['С непроверенными личными данными','checkbox','','account_status_check','0', '','AND'];
$filters[$f++] = ['Название или имя содержит','search','20','fio_name_or_company_short|fio_lastname_or_company|fio_middlename','','/[^а-яё0-9a-z]+$/ig','AND'];
$filters[$f++] = ['Электронная почта содержит','search','10','email_login_actual|email_login_original','','/[^a-z@.0-9]/ig','AND'];
$filters[$f++] = ['Телефонный номер содержит (без +7)','search','10','phone','','/[^0-9]/ig','AND'];
$filters[$f++] = ['ИНН содержит','search','12','inn','','/[^0-9]/ig','AND'];

if(!isset($_SESSION['filter_on'])) $_SESSION['filter_on']=false;

// ЕСЛИ ПРИЛЕТЕЛО ИЗМЕНЕНИЕ ФИЛЬТРОВ
if(isset($_POST['filter_on']))
{
    switch($_POST['filter_on'])
    {

        case "true":
            $_SESSION['filter_on'] = "true";
            break;

        case "false":
            $_SESSION['filter_on'] = "false";
            break;

        default:
            $_SESSION['filter_on'] = "false";
            break;
    }

    $f=0;
    foreach($filters as $key)
    {
        if(isset($_POST['filter'.$f]))
        {
            // АДАПТИРУЕМ REGEX ОТ JAVASCRIPT К PHP
            $regex = rtrim($key[5], 'g'); // PREG НЕ ПОНИМАЕТ ФЛАГ G
            $regex = str_replace(']/i',']/iu', $regex);
            $regex = str_replace(']+$/i',']+$/iu', $regex);

            // ОЧИЩАЕМ ПОЛУЧЕННЫЕ ДАННЫЕ РЕГЕКСОМ
            if($key[5]!='') $_POST['filter'.$f]=preg_replace($regex,'', $_POST['filter'.$f]);
            $_SESSION['filter'.$f]=$_POST['filter'.$f];

            // ЕСЛИ ПОЛУЧИЛОСЬ СЛИШКОМ КОРОТКО, ТО ОЧИЩАЕМ
            if(strlen($_SESSION['filter'.$f])<2) $_SESSION['filter'.$f]='';
        }else{
            // НЕОТМЕЧЕННЫЕ ЧЕКБОКСЫ НЕ ПРИЛЕТАЮТ, УЧИТЫВАЕМ ЭТО
            if($key[1]=="checkbox") $_SESSION['filter'.$f]="";
        }
        $f++;
    }
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}


// СОЗДАЁМ МАССИВ params для запросов
$f=0; // номер фильтра
$p=0; // номер параметра (так как могут быть повторные)
$list_params = array();
foreach($filters as $key)
{
    if(@$_SESSION['filter'.$f]!='')
    {
        // ФИЛЬТР МОЖЕТ ИСПОЛЬЗОВАТЬ НЕСКОЛЬКО ПОЛЕЙ В БД
        $multi_field = strpos($key[3], "|");

        if($multi_field === false)
        {

            switch($TABLES["user"][$key[3]])
            {
                case "TIMESTAMP":
                case "SMALLINT":
                case "BIGINT":
                case "INT":
                case "FLOAT":
                    // ЧИСЛОВОЙ ТИП
                    // ПОЛУЧАЕМ ОПЕРАТОРЫ СРАВНЕНИЯ
                    $compare_nodigits = preg_replace('/[0-9]+/', '', $key[4]);
                    $compare_onlydigits = preg_replace('/[^0-9]+/', '', $key[4]);
                    if($compare_onlydigits!='') $list_params[($p++)."|".$key[3]]=array($compare_onlydigits, $compare_nodigits, $key[6]);
                    break;

                case "TEXT":
                case "VARCHAR":
                    // СТРОЧНЫЙ ТИП
                    $list_params[($p++)."|".$key[3]]=array("%".$_SESSION['filter'.$f]."%", "LIKE", $key[6]);
                    break;

                case "BOOLEAN":
                    // БУЛЕВОЙ ТИП
                    if($key['4'] == 1)
                    {
                        $compare_boolean = "TRUE";
                    }else{
                        $compare_boolean = "FALSE";
                    }

                    $list_params[($p++)."|".$key[3]]=array($compare_boolean, "=", $key[6]);
                    break;
            }


        }else{

            $multi_keys = explode("|", $key[3]);
            $b=0;
            $v='';
            foreach($multi_keys as $multi_keys_this)
            {
                    if($b==0)
                    {
                        $key[6]="AND";
                        $v=$multi_keys_this;
                    }else{
                        $key[6]="OR";
                    }

                    switch($TABLES["user"][$multi_keys_this])
                    {
                        case "TIMESTAMP":
                        case "SMALLINT":
                        case "BIGINT":
                        case "INT":
                        case "FLOAT":
                            // ЧИСЛОВОЙ ТИП
                            // ПОЛУЧАЕМ ОПЕРАТОРЫ СРАВНЕНИЯ
                            $compare_nodigits = preg_replace('/[0-9]+/', '', $key[4]);
                            $compare_onlydigits = preg_replace('/[^0-9]+/', '', $key[4]);
                            if($compare_onlydigits!='') $list_params[($p++)."|".$v."|".$multi_keys_this]=array($compare_onlydigits, $compare_nodigits, $key[6]);
                            break;

                        case "TEXT":
                        case "VARCHAR":
                            // СТРОЧНЫЙ ТИП
                            $list_params[($p++)."|".$v."|".$multi_keys_this]=array("%".$_SESSION['filter'.$f]."%", "LIKE",$key[6]);
                            break;

                        case "BOOLEAN":
                            // БУЛЕВОЙ ТИП
                            if($key['4'] == 1)
                            {
                                $compare_boolean = "TRUE";
                            }else{
                                $compare_boolean = "FALSE";
                            }

                            $list_params[($p++)."|".$v."|".$multi_keys_this]=array($compare_boolean, "=", $key[6]);
                            break;
                    }

                    $b++;

            }
        }
    }

    $f++;
}



// ПОЛУЧАЕМ КОЛИЧЕСТВО ВСЕХ СТРАНИЦ
if($_SESSION['filter_on']==true)
{
    $list_all_users = db_count("user", $list_params);
}else{
    $list_all_users = db_count("user");
}
$list_all_users_no_filters = db_count("user");
$list_all_pages = ceil($list_all_users/$_SESSION['list_size']);




// ВЫБОР ТЕКУЩЕЙ СТРАНИЦЫ
if(isset($_GET['page']))
{
    if(!is_numeric($_GET['page'])||$_GET['page']<1||$_GET['page']>$list_all_pages) $_GET['page']=1;
    $_SESSION['list_page']=$_GET['page'];
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}else {
    if ($_SESSION['list_page'] > $list_all_pages) $_SESSION['list_page'] = 1;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// СТАРТУЕТ ВЫВОД (ДАЛЕЕ HEADER НЕВОЗМОЖЕН)
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



// ГОТОВИМ СПИСОК СТРАНИЦ
$paginator = '';
$paginator.="<div class='page_selector_outer'><div class='page_selector'>";

// <<
if($_SESSION['list_page']>1)
{
    $paginator.="<div class='page_button' onClick=\"window.location='?page=1'\">1</div>";
}else{
    $paginator.="<div class='page_button_cantselect'>1</div>";
}

// <
if($_SESSION['list_page']>1)
{
    $paginator.="<div class='page_button' onClick=\"window.location='?page=".($_SESSION['list_page']-1)."'\">";
    $paginator.="<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z\"/></svg>";
    $paginator.="</div>";
}else{
    $paginator.="<div class='page_button_cantselect'>";
    $paginator.="<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z\"/></svg>";
    $paginator.="</div>";
}

$paginator.="<div class='page_spacing'></div>";

$i = $_SESSION['list_page']-4;
if($i<1) $i=1;

// добавляем страниц справа, если слева их меньше
$m=5-$_SESSION['list_page'];
if($m<0)$m=0;
$o = $_SESSION['list_page']+4;
if($o>$list_all_pages) $o=$list_all_pages;
$j=$o+$m;
if($j>$list_all_pages)$j=$list_all_pages;


$k=($_SESSION['list_page']-$list_all_pages)+4;
if($k<0)$k=0;
$l=$i-$k;

for($p=$l; $p<=$j; $p++)
{
    if($p>0)
    {
        if ($_SESSION['list_page'] == $p) {
            $paginator.="<div class='page_button_selected'>".$p."</div>";
        } else {
            $paginator.="<div class='page_button' onClick=\"window.location='?page=".$p."'\">".$p."</div>";
        }
    }
}


$paginator.="<div class='page_spacing'></div>";

// >
if($_SESSION['list_page']<$list_all_pages)
{
    $paginator.="<div class='page_button' onClick=\"window.location='?page=".($_SESSION['list_page']+1)."'\">";
    $paginator.="<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z\"/></svg>";
    $paginator.="</div>";
}else{
    $paginator.="<div class='page_button_cantselect'>";
    $paginator.="<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z\"/></svg>";
    $paginator.="</div>";
}

// >>
if($_SESSION['list_page']<$list_all_pages)
{
    $paginator.="<div class='page_button' onClick=\"window.location='?page=".$list_all_pages."'\">".$list_all_pages."</div>";
}else{
    $paginator.="<div class='page_button_cantselect'>".$list_all_pages."</div>";
}

$paginator.="</div></div>";




// ВЫБОР ОТОБРАЖЕНИЯ КОЛИЧЕСТВА СТРАНИЦ
echo "<div class='page_select'>";
echo "<div class='page_select_1'>Показывать по <select class='page_select_1_css' name='list_size' id='list_size'>";
$list_sizes = array(10,25,50,100);

    foreach($list_sizes as $key)
    {
        echo "<option value='".$key."'";
        if($_SESSION['list_size']==$key)echo " selected";
        echo ">".$key."</option>";
    }

echo "</select></div>";

    ?>

<script>
$('#list_size').change(function() {
    window.location="?size="+$(this).val();
});
</script>

<?php
echo $paginator;

// ВЫВОДИМ ВЫБОР СТРАНИЦЫ
echo "<div class='page_select_3'>";
echo "Перейти на страницу ";
echo "<input placeholder='1...' type='number' id='list_go' min='1' max='".$list_all_pages."'> ";
echo "<img id='list_go_button' src='site_html/arrow_right.png'>";
echo "</div>";

?>

<script>
    $('#list_go_button').click(function() {
        window.location="?page="+$('#list_go').val();
    });
</script>

<?php

echo "</div>"; // конец page_select





// ГЕНЕРАЦИЯ HTML ФИЛЬТРОВ
?>
<div class='filter_select'><div class='filter_toggle'>

<div class='filter_switcher' onClick="filterToggle()">
    <div class='filter_switcher_flex'>
        <div class='filter_switcher_1'>
            <div class='filter_switcher_svg'>
                <svg style='display:<?php
                if($_SESSION['filter_on']==false)
                {
                    echo "inline-block";
                }else{
                    echo "none";
                }
                ?>' id="filter_svg_off" viewBox="0 0 35 18" xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path style="fill: rgb(255,255, 255);" d="M 22.966 2.153 L 9.092 2.153 C 4.501 2.153 0.768 5.685 0.768 10.028 C 0.768 14.37 4.501 17.902 9.092 17.902 L 22.966 17.902 C 27.555 17.902 31.289 14.37 31.289 10.028 C 31.289 5.685 27.555 2.153 22.966 2.153 Z"></path>
                    <path style="fill: rgb(120, 120, 120);" d="M 22.268 1.106 L 8.395 1.106 C 3.804 1.106 0.07 4.639 0.07 8.981 C 0.07 13.323 3.804 16.855 8.395 16.855 L 22.268 16.855 C 26.857 16.855 30.591 13.323 30.591 8.981 C 30.591 4.639 26.857 1.106 22.268 1.106 Z"></path>
                    <circle style="fill: rgb(255, 255, 255);" cx="13.575" cy="44.467" r="14.062" transform="matrix(0.493276, 0, 0, 0.466634, 1.709126, -11.768669)"></circle>
                    <path style="fill: rgb(175, 175, 175);" d="M 8.406 16.856 C 3.815 16.856 0.081 13.324 0.081 8.982 C 0.081 4.64 3.815 1.107 8.406 1.107 C 12.996 1.107 16.729 4.64 16.729 8.982 C 16.729 13.324 12.996 16.856 8.406 16.856 Z M 8.406 3.732 C 5.345 3.732 2.856 6.087 2.856 8.982 C 2.856 11.876 5.345 14.231 8.406 14.231 C 11.464 14.231 13.954 11.876 13.954 8.982 C 13.954 6.087 11.464 3.732 8.406 3.732 Z"></path>
                </svg>

                <svg style='display:<?php
                if($_SESSION['filter_on']==true)
                {
                    echo "inline-block";
                }else{
                    echo "none";
                }
                ?>' id="filter_svg_on" viewBox="0 0 35 18" xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path style="fill: rgb(255, 255, 255);" d="M 22.966 2.153 L 9.092 2.153 C 4.501 2.153 0.768 5.685 0.768 10.028 C 0.768 14.37 4.501 17.902 9.092 17.902 L 22.966 17.902 C 27.555 17.902 31.289 14.37 31.289 10.028 C 31.289 5.685 27.555 2.153 22.966 2.153 Z"></path>
                    <path style="fill: rgb(95,210,100);" d="M 22.268 1.106 L 8.395 1.106 C 3.804 1.106 0.07 4.639 0.07 8.981 C 0.07 13.323 3.804 16.855 8.395 16.855 L 22.268 16.855 C 26.857 16.855 30.591 13.323 30.591 8.981 C 30.591 4.639 26.857 1.106 22.268 1.106 Z"></path>
                    <circle style="fill: rgb(255, 255, 255);" cx="13.575" cy="44.467" r="14.062" transform="matrix(0.493276, 0, 0, 0.466634, 15.54731, -11.769765)"></circle>
                    <path style="fill: rgb(175, 175, 175);" d="M 22.244 16.855 C 17.653 16.855 13.919 13.323 13.919 8.981 C 13.919 4.639 17.653 1.106 22.244 1.106 C 26.834 1.106 30.567 4.639 30.567 8.981 C 30.567 13.323 26.834 16.855 22.244 16.855 Z M 22.244 3.731 C 19.183 3.731 16.694 6.086 16.694 8.981 C 16.694 11.875 19.183 14.23 22.244 14.23 C 25.302 14.23 27.792 11.875 27.792 8.981 C 27.792 6.086 25.302 3.731 22.244 3.731 Z"></path>
                </svg>
            </div>
            <div class='filter_switcher_label'>Фильтры</div>
        </div>
        <div class="list_all_users">
            <?php echo "Потребителей выбрано ".$list_all_users." из ".$list_all_users_no_filters; ?>
        </div>
        <div class="filter_switcher_1"></div>
    </div>
</div>



<script>
function filterToggle()
{
    $("#filter_svg_off").toggle();
    $("#filter_svg_on").toggle();
    $("#filter_list").toggle();
    if($('#filter_list').is(':visible'))
    {
        $('#filter_on').val("true");
    }else{
        $('#filter_on').val("false");

        // пока без jquery так
        window.location="ADMIN.PHP?filters=off";
    }

}
</script>



<?php

echo "</div><div style='display:";
if($_SESSION['filter_on']==true)
{
    echo "inline-block";
}else{
    echo "none";
}
echo "' id='filter_list' class='filter_list'>";

echo "<form action='ADMIN.PHP' method='POST' id='filter_go' name='filter_go'>";

$f=0;
foreach($filters as $key)
{

    // заполняем несуществующие значения фильтров
    // чекбоксы по умолчанию включены
    if(!isset($_SESSION['filter'.$f]))
    {
        if($key[1]!="checkbox")
        {
            $_SESSION['filter'.$f]='';
        }else{
            $_SESSION['filter'.$f]='on';
        }
    }

    echo "<input type='".$key[1]."' id='filter".$f."' name='filter".$f."'";

    // максимальная длина символов
    if($key[2]!='') echo " maxlength='".$key[2]."'";

    if($key[5]!='') echo " onkeyup=\"this.value=this.value.replace(".$key[5].",'');\"";

    // выставляем выбранное значение в зависимости от типа элементов
    switch($key[1])
    {
        case 'checkbox':
            if($_SESSION['filter'.$f]=='on')
            {
                echo " checked";
            }
            break;

        case 'search':
        case 'number':
            if($_SESSION['filter'.$f]!='')
            {
                echo " value='".$_SESSION['filter'.$f]."'";
            }
            break;
    }

    echo "> ".$key[0]."<br />";

    $f++;
}

echo "<input type='hidden' id='filter_on' name='filter_on' value='".$_SESSION['filter_on']."'>";
echo "<div style='height:20px;width:138px;' class='mybutton' onClick=\"$('#filter_go').submit()\">Обновить страницу</div>";
echo "</form>";

echo "</div></div>"; // конец "<div class='filter_select'>";









/* ОСНОВНАЯ ИНФА ДЛЯ ВЫВОДА
 * имя, фамилия, отчество или название компании
 * тип потребителя (физлицо, юрлицо, ип)
 * адрес почты актуальной
 * номер телефона
 * количество непроверенных документов, количество документов вообще
 * количество заявок активных и количество заявок всего
 */

$sort='';
switch($_SESSION['list_sort'])
{
    case 1:
        $sort='fio_lastname_or_company';
        break;

    case 2:
        $sort='email_login_actual';
        break;

    case 3:
        $sort='phone';
        break;

    case 4:
        $sort='docs_unchecked';
        break;

    case 5:
        $sort='request_active';
        break;

    case 6:
        $sort='id'; // СПЕЦИАЛЬНЫЙ ВЫБОР
        break;

    default:
        $sort='id';
        $_SESSION['list_sort']=1;
        break;
}

// ПОЛУЧАЕМ СПИСОК КЛИЕНТОВ
if($_SESSION['filter_on']==true)
{
    $users_to_list = db_selectAll("user", $list_params,['id','registration_date','account_status_mail','account_status_check','account_status_check_who','fio_lastname_or_company','fio_name_or_company_short','fio_middlename','email_login_actual','email_login_original','phone','juridical_form','docs_checked','docs_unchecked','request_active','request_all','fio_rusforms','sex'],$sort,$_SESSION['list_side'], $_SESSION['list_size'], (($_SESSION['list_page']-1)*$_SESSION['list_size']));
}else{
    $users_to_list = db_selectAll("user", '',['id','registration_date','account_status_mail','account_status_check','account_status_check_who','fio_lastname_or_company','fio_name_or_company_short','fio_middlename','email_login_actual','email_login_original','phone','juridical_form','docs_checked','docs_unchecked','request_active','request_all','fio_rusforms','sex'],$sort,$_SESSION['list_side'], $_SESSION['list_size'], (($_SESSION['list_page']-1)*$_SESSION['list_size']));
}



?>

<table style="width:100%;" class="table_list">
        <thead>
            <tr>
<?php
    $titles = array('ФИО ИЛИ НАЗВАНИЕ', 'ПОЧТА', 'ТЕЛЕФОН', 'ДОКУМЕНТЫ', 'ЗАЯВКИ');
    foreach($titles as $key => $value)
    {
        if(($key+1)!=$_SESSION['list_sort'])
        {
            echo "<th class='th_link' onClick=\"window.location='?sort=".($key+1)."'\">";
            echo $value;

            if($_SESSION['list_side']==false)
            {
            ?>
            <svg style="height:10px;" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 322 511.21" xmlns="http://www.w3.org/2000/svg">
                <defs></defs>
                <path fill-rule="nonzero" d="M 26.71 299.68 L 295.27 299.67 C 310.03 299.67 322 311.64 322 326.4 C 322 333.36 319.34 339.7 314.98 344.46 L 185.01 501.53 C 175.62 512.89 158.79 514.48 147.43 505.08 C 146.29 504.15 145.25 503.12 144.3 502.05 L 6.56 343.94 C -3.12 332.82 -1.95 315.94 9.17 306.25 C 14.23 301.85 20.48 299.69 26.71 299.68 Z" style=""></path>
                <path fill-rule="nonzero" d="M 295.27 211.54 L 26.71 211.54 C 20.48 211.52 14.23 209.36 9.17 204.96 C -1.95 195.27 -3.12 178.39 6.56 167.27 L 144.3 9.16 C 145.25 8.09 146.29 7.06 147.43 6.13 C 158.79 -3.27 175.62 -1.68 185.01 9.68 L 314.98 166.75 C 319.503 171.676 322.009 178.122 322 184.81 C 322 199.57 310.03 211.54 295.27 211.54 Z" style="fill: rgb(168, 168, 168);"></path>
            </svg>
            <?php
            }else{
            ?>
                <svg style="height:10px;" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 322 511.21" xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path fill-rule="nonzero" d="M 26.71 299.68 L 295.27 299.67 C 310.03 299.67 322 311.64 322 326.4 C 322 333.36 319.34 339.7 314.98 344.46 L 185.01 501.53 C 175.62 512.89 158.79 514.48 147.43 505.08 C 146.29 504.15 145.25 503.12 144.3 502.05 L 6.56 343.94 C -3.12 332.82 -1.95 315.94 9.17 306.25 C 14.23 301.85 20.48 299.69 26.71 299.68 Z" style="fill: rgb(168, 168, 168);"></path>
                    <path fill-rule="nonzero" d="M 295.27 211.54 L 26.71 211.54 C 20.48 211.52 14.23 209.36 9.17 204.96 C -1.95 195.27 -3.12 178.39 6.56 167.27 L 144.3 9.16 C 145.25 8.09 146.29 7.06 147.43 6.13 C 158.79 -3.27 175.62 -1.68 185.01 9.68 L 314.98 166.75 C 319.503 171.676 322.009 178.122 322 184.81 C 322 199.57 310.03 211.54 295.27 211.54 Z" style=""></path>
                </svg>
                <?php
            }

            echo "</th>";
        }else{
            echo "<th class='th_selected' onClick=\"window.location='?sort=".($key+1)."'\">";
            echo $value;

            if($_SESSION['list_side']==false)
            {
                ?>
                <svg style="height:10px;" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 322 511.21" xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path fill-rule="nonzero" d="M 26.71 299.68 L 295.27 299.67 C 310.03 299.67 322 311.64 322 326.4 C 322 333.36 319.34 339.7 314.98 344.46 L 185.01 501.53 C 175.62 512.89 158.79 514.48 147.43 505.08 C 146.29 504.15 145.25 503.12 144.3 502.05 L 6.56 343.94 C -3.12 332.82 -1.95 315.94 9.17 306.25 C 14.23 301.85 20.48 299.69 26.71 299.68 Z" style=""></path>
                    <path fill-rule="nonzero" d="M 295.27 211.54 L 26.71 211.54 C 20.48 211.52 14.23 209.36 9.17 204.96 C -1.95 195.27 -3.12 178.39 6.56 167.27 L 144.3 9.16 C 145.25 8.09 146.29 7.06 147.43 6.13 C 158.79 -3.27 175.62 -1.68 185.01 9.68 L 314.98 166.75 C 319.503 171.676 322.009 178.122 322 184.81 C 322 199.57 310.03 211.54 295.27 211.54 Z" style="fill: rgb(168, 168, 168);"></path>
                </svg>
                <?php
            }else{
                ?>
                <svg style="height:10px;" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 322 511.21" xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path fill-rule="nonzero" d="M 26.71 299.68 L 295.27 299.67 C 310.03 299.67 322 311.64 322 326.4 C 322 333.36 319.34 339.7 314.98 344.46 L 185.01 501.53 C 175.62 512.89 158.79 514.48 147.43 505.08 C 146.29 504.15 145.25 503.12 144.3 502.05 L 6.56 343.94 C -3.12 332.82 -1.95 315.94 9.17 306.25 C 14.23 301.85 20.48 299.69 26.71 299.68 Z" style="fill: rgb(168, 168, 168);"></path>
                    <path fill-rule="nonzero" d="M 295.27 211.54 L 26.71 211.54 C 20.48 211.52 14.23 209.36 9.17 204.96 C -1.95 195.27 -3.12 178.39 6.56 167.27 L 144.3 9.16 C 145.25 8.09 146.29 7.06 147.43 6.13 C 158.79 -3.27 175.62 -1.68 185.01 9.68 L 314.98 166.75 C 319.503 171.676 322.009 178.122 322 184.81 C 322 199.57 310.03 211.54 295.27 211.54 Z" style=""></path>
                </svg>
                <?php
            }

            echo "</th>";
        }
    }

?>
            </tr>
        </thead>
        <tbody>
<?php

$row=0;
foreach($users_to_list as $key => $value)
{
    // ПОТРЕБИТЕЛЬ
    echo "<tr class='tr_list' onClick=\"$('#row".$row."').toggle();\">";

        echo "<td>";

        if($value['docs_unchecked']>0)
        {
        ?>
    <svg height="12px" x="0px" y="0px" viewBox="0 0 92.27 122.88" xmlns="http://www.w3.org/2000/svg">
        <defs></defs>
        <style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;fill: #ff401f;}  .st1{fill-rule:evenodd;clip-rule:evenodd;fill:#FAD15C;}</style>
        <g>
            <path class="st0" d="M18.61,54.89C15.7,28.8,30.94,10.45,59.52,0C42.02,22.71,74.44,47.31,76.23,70.89 c4.19-7.15,6.57-16.69,7.04-29.45c21.43,33.62,3.66,88.57-43.5,80.67c-4.33-0.72-8.5-2.09-12.3-4.13C10.27,108.8,0,88.79,0,69.68 C0,57.5,5.21,46.63,11.95,37.99C12.85,46.45,14.77,52.76,18.61,54.89L18.61,54.89z"></path>
            <path class="st1" d="M33.87,92.58c-4.86-12.55-4.19-32.82,9.42-39.93c0.1,23.3,23.05,26.27,18.8,51.14 c3.92-4.44,5.9-11.54,6.25-17.15c6.22,14.24,1.34,25.63-7.53,31.43c-26.97,17.64-50.19-18.12-34.75-37.72 C26.53,84.73,31.89,91.49,33.87,92.58L33.87,92.58z"></path>
        </g>
    </svg>
<?php
        }

        switch($value['juridical_form'])
        {
            case "1":
                $u = $value['fio_lastname_or_company']." ".$value['fio_name_or_company_short']." ".$value['fio_middlename'];
                if(str_replace(" ", "", $u)=="")
                {
                    $u = "Не указано";
                }
                echo $u;
                break;
            case "2":
                $u = $value['fio_lastname_or_company'].$value['fio_name_or_company_short'].$value['fio_middlename'];
                if($u=='')
                {
                    echo "Не указано";
                }else{
                    echo "ИП ".$value['fio_lastname_or_company']." ".mb_substr($value['fio_name_or_company_short'],0,1).".".mb_substr($value['fio_middlename'],0,1).".";
                }
                break;
            case "3":
                $u = $value['fio_lastname_or_company'].$value['fio_name_or_company_short'];
                if($u=='')
                {
                    echo "Не указано";
                }else{
                    echo $value['fio_lastname_or_company']." (".$value['fio_name_or_company_short'].")";
                }
                break;
        }
    echo "</td>";

    // АКТУАЛЬНАЯ ПОЧТА
    echo "<td class='td_center'>";
        echo $value['email_login_actual'];
    echo "</td>";

    // ТЕЛЕФОН
    echo "<td class='td_center'>";
        //echo "+7 (".substr($value['phone'],0,3).") ".substr($value['phone'],3);
        // ЗДЕСЬ НАДО ФОРМАТИРОВАНИЕ ТЕЛЕФОНА
        if($value['phone']=='')
        {
            echo "Не указано";
        }else{
            echo $value['phone'];
        }
    echo "</td>";

    // ДОКУМЕНТЫ
    echo "<td class='td_center'>";
        echo $value['docs_unchecked']." новых, ".$value['docs_checked']." всего";
    echo "</td>";

    // ЗАЯВКИ
    echo "<td class='td_center'>";
        echo $value['request_active']." в обработке, ".$value['docs_checked']." всего";
    echo "</td>";
    
    echo "</tr>";

    // ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ
    echo "<tr id='row".$row."' class='table_hidden_info'><td colspan='5' class='table_hidden_td'>";

        echo "<table class='hidden_info'><tr>";

        // показываем тут краткую дополнительную инфу:
        echo "<td>Подтверждённая почта:</td><td><b>".($value['account_status_mail'] ? "нет" : "да")."</b>";

        echo "<div style='display:inline-block;margin-left:10px;'>";
        echo "(регистрация: ".niceLookingDate(strtotime($value['registration_date']),6).")";
        echo "</div>";

        echo "</td>";
        echo "</tr><tr>";


        echo "<td>Личные данные:</td><td>";
        if($value['account_status_check']==true)
        {
            echo "<b>проверены</b>";
            echo " (".$value['account_status_check_who'].")";
            echo "<div style='margin-left:10px;display:inline-block;width:100px;'>";
            echo "<div class='mybutton' onClick=\"window.location='?edit=".$value['id']."'\">Изменить</div></div>";
        }else{
            echo "<b>не проверены</b><div style='margin-left:10px;display:inline-block;width:100px;'>";
            echo "<div class='mybutton' onClick=\"window.location='?edit=".$value['id']."'\">Проверить</div></div>";
        }



        echo "</td></tr><tr><td>";
        echo "Загруженных документов:</td><td>";


    ?>
    <div style='display:inline-block;width:20px;font-weight:700;'>
    4
    </div>

    <div style='display:inline-block;width:100px;'>
        <div class='mybutton'>Посмотреть</div>
    </div>

<?php
echo "</td></tr><tr>";
    echo "<td>Почта при регистрации:</td><td><b>".$value['email_login_original']."</b>";
        if($value['email_login_original']!=$value['email_login_actual'])
        {
        echo " (была при регистрации ".$value['email_login_original'].")";
        }




        echo "</td></tr><tr><td>";
        echo "Заявки: </td><td>";
    ?>

    <select>
        <option>Хуесосино</option>
        <option>Писькодрапово</option>
        <option>Зажопинск</option>
    </select>

    <div style='display:inline-block;width:100px;'>
        <div class='mybutton'>Перейти</div>
    </div>
    <?php


    echo "</td></tr></table>";
    $row++;
}



?>
        </tbody>
</table>

<?php

echo "<div class='page_select_bottom'>";
echo "<div class='page_select_1'></div>";
echo $paginator;
echo "<div class='page_select_3'>";
?>


    <div id='scrollToTop' class='page_up' onClick="toTop()">Наверх

        <svg id='page_up_svg' height='8px' shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512.01 336.37" xmlns="http://www.w3.org/2000/svg">
            <defs></defs>
            <path fill-rule="nonzero" d="M469.51 336.37H42.47c-9.9-.03-19.84-3.47-27.89-10.47-17.68-15.4-19.55-42.24-4.15-59.92L229.45 14.56c1.51-1.7 3.17-3.33 4.98-4.82 18.06-14.93 44.83-12.41 59.76 5.65l206.65 249.76a42.308 42.308 0 0 1 11.17 28.71c0 23.47-19.03 42.51-42.5 42.51z"></path>
        </svg>

    </div>

</div>
</div>


        <script>
            function toTop()
            {
                $('html, body').animate({ scrollTop: 0 }, 300);
                return false;
            }
        </script>






















