<?php

include("../include/helpers.php");

/*
验证码处理
 1,创建一个验证码图片 imagecreatetruecolor()
 2，给验证码图片添加背景颜色 和文字颜色 imagecolorallocate()
 3, 在指定图片上面，画一个矩形 imagefilledrectangle()
 4, 获取随机数
 5,将随机数写入到这个图片里面去 imagestring()
 6,防止别人去恶意刷我们的验证码 可以在这个图片上面加上一些点 imagesetpixel()
 7,开启session会话  将我们的验证码 存储到session当中与我们表单当中输入的验证码进行匹配
 8,输入图片的 头信息 和 图片资源 删除 header("Content-Type:image/png"); imagepng($img); imagedestroy($img);
 */

$width = 45;
$height = 20;

$img = imagecreatetruecolor($width,$height);

//验证码的背景颜色
$background_color = imagecolorallocate($img,74,147,223);

//验证码的文字颜色
$text_color = imagecolorallocate($img,255,255,255);

imagefilledrectangle($img,0,0,$width,$height,$background_color);

$str = GetRandStr(4);

imagestring($img,5,5,1,$str,$text_color);

//在图片当中去画一些点 防止有人而已破解验证码
for($i=1;$i<=100;$i++){
  $x = mt_rand(0,45);
  $y = mt_rand(0,20);
  imagesetpixel($img,$x,$y,imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
}


session_start();
$_SESSION['img_code'] = strtolower($str);


header("Content-type:image/png");
imagepng($img);
imagedestroy($img);








?>