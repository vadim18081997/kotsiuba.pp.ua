<?php	
$random = rand(10001, 99999);
$_SESSION['captcha'] = md5($random);
$img = imagecreatetruecolor(110, 30);
imagefilledrectangle($img, 0, 0, 110, 30,imagecolorallocate($img, 71, 85, 192));
imagettftext($img, 40, 0, 15, 23, imagecolorallocate($img, 255, 255, 255), 'resource/font.ttf', $random);
header('Expires: Wed, 1 Jan 1997 00:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Content-Type: image/gif');
imagegif($img);
imagedestroy($img);
?>