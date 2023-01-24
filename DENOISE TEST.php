<?php


$imagick = new \Imagick(realpath("page1.webp"));



$imagick->autoLevelImage();
$imagick->despeckleImage();
$imagick->enhanceImage();

//$imagick->floodFillPaintImage("rgb(255, 255, 255)", 2500, "rgb(255,255,255)", 0 , 0, false);



header("Content-Type: image/jpg");
echo $imagick->getImageBlob();


?>