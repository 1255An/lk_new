<?php

$im = imagecreatefromwebp('test.webp');

$im = imagecropauto($im,IMG_CROP_THRESHOLD, 100, 16777215);

imagewebp($im, 'result.webp');

imagedestroy($im);


?>