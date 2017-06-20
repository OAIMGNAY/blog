<?php

include("include/init.php");
include("side.php");

$article = new M("article");

//查询web
$art2_info = $article->select("artcate_id=2")->orderBy(['article_id',"DESC"])->limit([5])->findAll();
//查询网站运营
$art4_info = $article->select("artcate_id=4")->orderBy(['article_id',"DESC"])->limit([5])->findAll();
//查询心得笔记
$art5_info = $article->select("artcate_id=5")->orderBy(['article_id',"DESC"])->limit([5])->findAll();
//查询五花八门
$art6_info = $article->select("artcate_id=6")->orderBy(['article_id',"DESC"])->limit([5])->findAll();


$smarty->assign("art2_info",$art2_info);
$smarty->assign("art4_info",$art4_info);
$smarty->assign("art5_info",$art5_info);
$smarty->assign("art6_info",$art6_info);
//设置模板路径
$smarty->display('articles.html');






?>