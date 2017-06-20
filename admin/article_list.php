<?php

include("../include/init.php");
include("check_admin.php");


$article = new M("article");
$artcate = new M("artcate");

$artcate_list = $artcate->select()->findAll();

/*--- 单条删除 ---*/
$delete_id = isset($_GET['article_id'])?$_GET['article_id']:0;
if ($delete_id) {
	$affect_id = $article->delete("article_id=$delete_id");
	if ($affect_id) {
		show_msg("删除文章成功","article_list.php");
		exit;
	}else{
		show_msg("删除文章失败","article_list.php");
		exit;
	}
}

/*--- 批量删除 ---*/
$delete_article = isset($_GET['id'])?$_GET['id']:0;
if ($delete_article) {
	$delete_arr = implode(",",$delete_article);
	$affect_id = $article->delete("article_id IN ($delete_arr)");
	if ($affect_id) {
		show_msg("批量删除文章成功","article_list.php");
		exit;
	}else{
		show_msg("批量删除文章失败","article_list.php");
		exit;
	}
}


/*--- 搜索 ---*/
$start_time = isset($_GET['start_time'])?strtotime($_GET['start_time']):0;
$end_time = isset($_GET['end_time'])?strtotime($_GET['end_time']):0;
$keywords = isset($_GET['keywords'])?trim($_GET['keywords']):0;
$artcate_id = isset($_GET['artcate_id'])?$_GET['artcate_id']:0;

$where = "";
if ($start_time && !$end_time) {
	$count_where = "article_time > $start_time";
	$msg_where = "art.article_time > $start_time";
}else if (!$start_time && $end_time  ) {
	$count_where = "article_time < $end_time";
	$msg_where = "art.article_time < $end_time";
}else if ($start_time && $end_time) {
	$count_where = "article_time BETWEEN $start_time AND $end_time";
	$msg_where = "art.article_time BETWEEN $start_time AND $end_time";
}else if (!empty($keywords)) {
	$count_where = "article_title = '$keywords'";
	$msg_where = "art.article_title = '$keywords'";
}else if ($artcate_id) {
	$count_where = "artcate_id = $artcate_id";
	$msg_where = "art.artcate_id = $artcate_id";
}else{
	$count_where = 1;
	$msg_where = 1;
}





/*--- 分页 ---*/


$count = $article->select($count_where,"COUNT(*) AS c")->findOne();
$current = isset($_GET['page'])?$_GET['page']:1;   //获取当前页码值
$limit = 5;
$start = ($current-1)*$limit;
$size = 3;

$page_str =  page($current,$count["c"],$limit,$size);


//获取记录内容
$str = "* FROM ".$article->prefix."article AS art LEFT JOIN ".$article->prefix."artcate AS artcate ON art.artcate_id =  artcate.artcate_id";
$article_list = $article->select($msg_where,$str,true)->orderBy(["art.article_id","DESC"])->limit(["$start","$limit"])->findAll();




/*--- 赋值 ---*/
$smarty->assign("artcate_list",$artcate_list);
$smarty->assign("article_list",$article_list);
$smarty->assign("page_str",$page_str);
$smarty->assign("start_time",$start_time);
$smarty->assign("end_time",$end_time);
$smarty->assign("keywords",$keywords);
$smarty->assign("artcate_id",$artcate_id);

//设置模板路径
$smarty->display('admin/article_list.html');






?>