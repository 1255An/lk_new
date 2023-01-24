<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

//setup configuration
$upload_dir = "uploads_tmp/";
$upload_dir_url = "http://localhost:63342/LKEnengin/uploads_tmp/";
$image_height = 2000;
$image_width = 2000;

//проверяем был ли POST через Ajax
if (isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    //проверяем что файл существует и не пуст
    if (!isset($_FILES['image_data']) || !is_uploaded_file(($_FILES['image_data']['tmp_name']))) {
        $response = json_encode(array(
            'type' => 'error',
            'msg' => 'Файла не существует'
        ));
    }

    //если все ок, определяем размер файла
    $image_size_info = getimagesize($_FILES['image_data']['tmp_name']);
    if ($image_size_info) {
        $image_type = $image_size_info['mime'];
    } else {
        $response = json_encode(array(
            'type' => 'error',
            'msg' => 'Файла не существует'
        ));
    }

    //получаем id юзера из сессии
    $user_id = $_SESSION['id'];


    //определяем тип файла
    $image_type_info = mime_content_type($_FILES['image_data']['tmp_name']);

    //если файл формата пдф, то сначала определяем количество страниц в документе
    if ($image_type_info === "application/pdf") {

        $im = new Imagick($_FILES['image_data']['tmp_name']);

        $pages = $im->getNumberImages();
        $im-> clear();
        $im-> destroy();
        if($pages >= 1) {
            $_SESSION['pdf_file']="pdf_processing_".time()."_".rand(1000000,9999999).".pdf";
            copy($_FILES['image_data']['tmp_name'], $upload_dir.$_SESSION['pdf_file']);
            $_SESSION['pdf_pages']=$pages;
            $_SESSION['pdf_current_page']=0;

            $response = json_encode(array(
                'type' => 'pdf',
                'msg' => $pages
            ));

            die($response);
        }


    } else if ($image_type_info === "image/png" || $image_type_info === "image/jpeg" || $image_type_info === "image/jpg") {
        $image = new Imagick();
        $image->readImage($_FILES['image_data']['tmp_name']);
        $image->setImageFormat('webp');

        //меняем размер
        $image->resizeImage($image_height, $image_width, Imagick::FILTER_LANCZOS, false, true);

        //устанавливаем параметр webp
        $image->setOption('webp:method', '6');

        //нынешний timestamp
        $date = date("Y-m-d H:i:s");

        //добавляем документ в таблицу и получаем его id
        $post = [
            'user_id' => $user_id,
            'date' => $date
        ];
        $doc_id = db_insert('user_doc', $post);

        try {
            $results = $image->writeImage('uploads_tmp/' . $user_id . '_' . $doc_id . '.webp');
        } catch (ImagickException $e) {
            //удалим из таблицы user_doc запись
        }
    }



    list($width, $height) = $image_size_info;
    if ($width > $height) {
        $side = "width";
    } else {
        $side = "height";
    }

    if ($results) {
        list($width, $height) = $image_size_info;
        if ($width > $height) {
            $response = json_encode(array(
                'type' => 'image_success',
                'msg' => '<br> <img width="100px" src = "' . $upload_dir_url . $user_id . '_' . $doc_id . '.webp" >'
            ));
            die($response);
        } else {
            $response = json_encode(array(
                'type' => 'image_success',
                'msg' => 'Документ загружен <br> <img height="100px" src = "' . $upload_dir_url . $user_id . '_' . $doc_id . '.webp" >'
            ));
            die($response);
        }
    }
}

?>