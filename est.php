<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

$post = [
    'id_user' => 1,
    'object_type' => test_input("\\\\123"),
    'tp_number' => test_input("\"123"),

];

db_insert('request', $post);


//для удаления спецсимволов
function test_input($data)
{
    $data = trim($data);
   $data = stripslashes($data);
    $data = str_replace(array("^","|", "\\"),"",$data);
    $data = htmlspecialchars($data);
    return $data;

}
?>