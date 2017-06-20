<?php

include("include/init.php");

$link = new M('link');

$link_list = $link->select(1)->orderBy(['link_id',"DESC"])->findAll();



$smarty->assign('link_list',$link_list);

//设置模板路径
$smarty->display('link.html');






?>