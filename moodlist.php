<?php

include("include/init.php");

$moodlist = new M("moodlist");


//查询web
$mood_list = $moodlist->select(1)->orderBy(['mood_id',"DESC"])->limit([15])->findAll();


$smarty->assign('mood_list',$mood_list);
//设置模板路径
$smarty->display('moodlist.html');






?>