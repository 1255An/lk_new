<?php
define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

$upload_dir_url = "http://localhost:63342/LKEnengin/uploads_tmp/";

if (isset($_POST)) {
    if (isset($_SESSION['pdf_file']) && isset($_SESSION['id'])) {

        $user_id = $_SESSION['id'];
        $pages = $_SESSION['pdf_pages'];
        $resolution = 300;

        //создаем объект имэджик
        $imagick = new Imagick();
        $imagick->setResolution($resolution, $resolution);
        $imagick->readImage('uploads_tmp/' . $_SESSION['pdf_file']);
        $imagick->setImageFormat('webp');
        $imagick->setOption('webp:method', '6');

        $imagick->setIteratorIndex($_SESSION['pdf_current_page']);
        $imagick->resizeImage(2000, 2000, Imagick::FILTER_LANCZOS, false, true);

        $imagick->setImageBackgroundColor('white');
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);


        //нынешний timestamp
        $date = date("Y-m-d H:i:s");

        //добавляем документ в таблицу и получаем его id
        $post = [
            'user_id' => $user_id,
            'date' => $date
        ];
        $doc_id = db_insert('user_doc', $post);



        //сохраняем каждую страницу в файл
        try {
            $upload_result = $imagick->writeImage('uploads_tmp/' . $user_id . '_' . $doc_id . '_' . 'page' . ($_SESSION['pdf_current_page'] + 1) . 'of' . $pages . '.webp');
        } catch (ImagickException $e) {
            //удаляем документ из БД
        }
        $_SESSION['pdf_current_page']++;



    } else {
        //move to auth page
        header("Location: http://localhost:63342/LKEnengin/site_html/auth_page_front.php");
    }
}


if (($_SESSION['pdf_current_page']) < ($_SESSION['pdf_pages'])) {
    $current_percent = ($_SESSION['pdf_current_page'] * 100) / ($pages);
} else if ($_SESSION['pdf_current_page'] = $_SESSION['pdf_pages']) {
    $current_percent = 100;
}

if ($upload_result) {
    $response = json_encode(array(
        'type' => 'upload_in_progress',
        'msg' => $current_percent,
        'result' => '<br> <img width="100px" src = "' . $upload_dir_url . $user_id . '_' . $doc_id . '_' . 'page' . $_SESSION['pdf_current_page'] . 'of' . $pages . '.webp" >'
    ));
    die($response);
} else {
    $response = json_encode(array(
        'type' => 'upload_in_progress',
        'msg' => 'Что-то пошло не так'
    ));
    die($response);
}

//if($current_percent =100) {
//    $response = json_encode(array(
//        'type' => 'success',
//        'msg' => $current_percent
//    ));
//    die($response);
//}

?>