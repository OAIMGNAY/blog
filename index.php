<?php

include("include/init.php");
include("side.php");

$article = new M("article");
$admin = new M("admin");
//获取海报文章内容
$banner_info = $article->select("artcate_id = 8")->findOne();
//获取个人信息
$personal = $admin->select("admin_id = 1")->findOne();
//获取最文章
$new_article = $article->select(1)->orderBy(['article_id',"DESC"])->limit([5])->findAll();


$smarty->assign("banner_info",$banner_info);
$smarty->assign("personal",$personal);
$smarty->assign('new_article',$new_article);

//设置模板路径
$smarty->display('index.html');






?>