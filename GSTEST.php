<?php


session_start();



/***********************************************************************************************************************
 * НАСТРОЙКИ
 **********************************************************************************************************************/




// НАСТРОЙКИ
$pdf_format = "png16m"; // может быть png16m, jpeg, pngmono (оттенки серого), pngmonod (2 цвета)
$pdf_extension = "png";
$pdf_dpi = "300";

// ФАЙЛ ДЛЯ ОБРАБОТКИ
$pdf_file='2.pdf';


// ОПРЕДЕЛЯЕМ ОПЕРАЦИОННУЮ СИСТЕМУ
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $pdf_app="gswin64c.exe";
    $pdf_windows = true;
    $pdf_path = str_replace('\\', '/', __DIR__)."/";
} else {
    $pdf_app="gs";
    $pdf_windows = false;
    $pdf_path = __DIR__."/";
}





/***********************************************************************************************************************
 * AJAX ОБРАБОТКА
 **********************************************************************************************************************/
if(isset($_GET['page']))
{
    if(isset($_SESSION['pdf_current']))
    {
        // ВЫТАСКИВАЕМ СТРАНИЦУ ИЗ PDF И СОХРАНЯЕМ В PNG
        if($pdf_windows==true)
        {
            $command = $pdf_app." -q --permit-file-read=\"".$pdf_path."\" -dFirstPage=".$_SESSION['pdf_current']." -dLastPage=".$_SESSION['pdf_current']." -dGraphicsAlphaBits=4 -dTextAlphaBits=4 -sDEVICE=".$pdf_format." -dNOPAUSE -dBATCH -sOutputFile=".$pdf_path."page".$_SESSION['pdf_current'].".".$pdf_extension." -r".$pdf_dpi." -f ".$pdf_path.$pdf_file;
        }else{
            $command = $pdf_app." -q -dFirstPage=".$_SESSION['pdf_current']." -dLastPage=".$_SESSION['pdf_current']." -dGraphicsAlphaBits=4 -dTextAlphaBits=4 -sDEVICE=".$pdf_format." -dNOPAUSE -dBATCH -sOutputFile=".$pdf_path."page".$_SESSION['pdf_current'].".".$pdf_extension." -r".$pdf_dpi." -f ".$pdf_path.$pdf_file;
        }
        $a = exec($command);

        // ПЕРЕСОХРАНЯЕМ В WEBP

        $imagick = new Imagick();
        $imagick->readImage($pdf_path."page".$_SESSION['pdf_current'].".".$pdf_extension);
        $imagick->setImageFormat('webp');
        $imagick->setOption('webp:method', '6');
        $imagick->resizeImage(2000, 2000, Imagick::FILTER_CATROM, 0.5, true);

        try {
            $imagick->writeImage($pdf_path."page".$_SESSION['pdf_current'].".webp");

            // МИНИАТУРА
            $imagick->resizeImage(200, 200, Imagick::FILTER_CATROM, 0.5, true);
            $imagick->writeImage($pdf_path."page".$_SESSION['pdf_current']."_thumbnail.webp");

            // УДАЛЯЕМ PNG ФАЙЛ
            @unlink($pdf_path."page".$_SESSION['pdf_current'].".".$pdf_extension);
        } catch (ImagickException $e) {

            // СЛУЧИЛАСЬ ПОЛНАЯ ЖОПА
            echo "error";
            die();
        }



        $_SESSION['pdf_current']++;

        if($_SESSION['pdf_current']>$_SESSION['pdf_all_pages'])
        {
            echo "end";
        }else{
            echo $_SESSION['pdf_current'];
        }
        die();
    }else{
        echo "НЕТ СЕССИИ";
        die();
    }
}







/***********************************************************************************************************************
 * СТАРТУЕМ
 **********************************************************************************************************************/

// ЕСТЬ ЛИ ВОЗМОЖНОСТЬ ЗАПУСКАТЬ ПРОГРАММЫ НА СЕРВЕРЕ
function isEnabled($func) {
    return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
}

?><html><head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script></head><body><div id="log"><?php

if (isEnabled('shell_exec')) {

    // МОЖНО
    echo "- shell_exec доступен<br/>";

    // УСТАНОВЛЕН ЛИ GHOSTSCRIPT
    $retval = shell_exec($pdf_app.' --version');
    if ( $retval != '' ) {

        // GS ЕСТЬ
        echo "- ghostscript доступен: ".$retval."<br/>";

                        // ПОЛУЧАЕМ КОЛИЧЕСТВО СТРАНИЦ
                        if($pdf_windows==true)
                        {
                            $command = $pdf_app." -q --permit-file-read=\"".$pdf_path."\" -dNODISPLAY -c \"(".$pdf_path.$pdf_file.") (r) file runpdfbegin pdfpagecount = quit\"";
                        }else{
                            $command = $pdf_app." -q -dNODISPLAY -c \"(".$pdf_path.$pdf_file.") (r) file runpdfbegin pdfpagecount = quit\"";
                        }
                        $pdf_all_pages = shell_exec($command);
                        $_SESSION['pdf_all_pages']=$pdf_all_pages;
                        $_SESSION['pdf_current']=1;

                        echo "- Файл ".$pdf_file.": ".$pdf_all_pages." страниц в файле";


?>

        <script>

    function pdf_nextpage(data)
    {
        $.ajax({
            url: 'GSTEST.php?page='+data,
            method: 'get',
            dataType: 'html',
            data: $(this).serialize(),
            success: [function (data) {
                if(data!='end')
                {
                    $("#log").append("<br/>- Страница завершена: "+(data-1));
                    pdf_nextpage(data);
                }else{
                    if(data=='end')
                    {
                        $("#log").append("<br/>- Последняя страница завершена");
                    }else{
                        $("#log").append("<br/>- Ошибка записи файла");
                    }
                }
            }]
        })
    }

    // запускаем
    pdf_nextpage(1);

        </script>

</div></body></html>


<?php

    }else{
        // GS НЕТУ, КОНЕЦ
        echo "- ghostscript недоступен<br/>";
    }

}else{
    // НЕЛЬЗЯ
    echo "- shell_exec недоступен<br/>";
}


?>

