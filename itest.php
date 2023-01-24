<?php

echo "start: ".date("l jS \of F Y h:i:s A")." // RAM: ".memory_get_usage()."<br/>";
$im = new Imagick('3.pdf');
$pages = $im->getNumberImages();


$im-> clear();
$im-> destroy();
echo "checkpages: ".date("l jS \of F Y h:i:s A")." // RAM: ".memory_get_usage()."<br/>";

$resolution = 300;
$imagick = new Imagick();
$imagick->setResolution($resolution, $resolution);
$imagick->readImage('3.pdf');
$imagick->setImageFormat('jpeg');
//$imagick->setOption('webp:method', '6');

$imagick->resizeImage(2000, 2000, Imagick::FILTER_LANCZOS, false, true);
$imagick->setImageBackgroundColor('white');
$imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
$imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

echo "readed: ".date("l jS \of F Y h:i:s A")." // RAM: ".memory_get_usage()."<br/>";
foreach ($imagick as $i => $imagick) {
    echo "save".$i.": ".date("l jS \of F Y h:i:s A")." // RAM: ".memory_get_usage()."<br/>";
    $imagick->writeImage( 'page ' .($i+1) . 'of'. $pages . '.jpeg');
}
echo "final: ".date("l jS \of F Y h:i:s A")." // RAM: ".memory_get_usage()."<br/>";


//$im-> setImageFormat('webp');
//$im->setOption('webp:method', '6');
//
//
//$im->resizeImage(2000, 2000, Imagick::FILTER_LANCZOS, false, true);
//
//
//$im->setImageBackgroundColor('white');
//$im->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
//$im->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
//
//$im -> writeImage('uploads_tmp/'.time().'.webp');


?>