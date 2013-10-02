<?php
require '../basic.php';
require '../lib/cropImage.class.php';
$img = $_POST['filename'];
$x1 = $_POST['x1'];
$x2 = $_POST['x2'];
$y1 = $_POST['y1'];
$y2 = $_POST['y2'];
$w = $_POST['filewidth'];
$resize_width = $_POST['resize_width'];
$cropImg = new cropImage(ROOT_PATH.$img,$x1,$x2,$y1,$y2,$w,$resize_width);
echo str_replace(ROOT_PATH,'',$cropImg->dstimg);
?>
