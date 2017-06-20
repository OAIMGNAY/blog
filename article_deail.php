<?php

include("include/init.php");
include("side.php");

$article = new M("article");

$article_id = isset($_GET['article_id'])?$_GET['article_id']:0;
if (!$article_id) {
	show_msg("操作失败，重新查看","articles.php");
	exit;
}

$article_deail = $article->select("article_id=$article_id")->findOne();


$smarty->assign("article_deail",$article_deail);
//设置模板路径
$smarty->display('article_deail.html');






?>