<?php

include('smarty/Smarty.class.php');

define("DIR", dirname(dirname(str_replace("\\", "/", __FILE__))));



$smarty = new Smarty();   //实例化模板引擎类

$smarty->setTemplateDir(DIR."/templates/");   //设置网站的模板目录

$smarty->setCompileDir(DIR."/templates_c/");  //设置网站模板的编译目录

$smarty->setCacheDir(DIR."/cache/");  //设置网站的缓存目录

$smarty->setConfigDir(DIR.'/config/');  //设置网站的配置目录

$smarty->caching  = false;  //为了方便在开发周期进行程序调试，建议初期不开启缓存

$smarty->cache_lifetime = 60*60*24;  //设置缓存的时间

//下面的两个配置选项代表的目的是，设置解析变量的定界符
$smarty->left_delimiter = "<{"; 
$smarty->right_delimiter = "}>";

// <{$name}>













?>