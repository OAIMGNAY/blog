<?php

include("../include/init.php");
include("check_admin.php");


$artcate = new M("artcate");



/*--- 单条删除 ---*/
$delete_id = isset($_GET['artcate_id'])?$_GET['artcate_id']:0;
if ($delete_id) {
	$affect_id = $artcate->delete("artcate_id=$delete_id");
	if ($affect_id) {
		show_msg("删除文章分类成功","artcate_list.php");
		exit;
	}else{
		show_msg("删除文章分类失败","artcate_list.php");
		exit;
	}
}

/*--- 批量删除 ---*/
$delete_artcate = isset($_GET['id'])?$_GET['id']:0;
if ($delete_artcate) {
	$delete_arr = implode(",",$delete_artcate);
	$affect_id = $artcate->delete("artcate_id IN ($delete_arr)");
	if ($affect_id) {
		show_msg("批量删除文章分类成功","artcate_list.php");
		exit;
	}else{
		show_msg("批量删除文章分类失败","artcate_list.php");
		exit;
	}
}




/*--- 分页 ---*/

$count = $artcate->select(1,"COUNT(*)  AS c")->findOne();
// var_dump($count);
$current = isset($_GET['page'])?$_GET['page']:1;   //获取当前页码值
$limit = 5;
$start = ($current-1)*$limit;
$size = 3;

$page_str =  page($current,$count["c"],$limit,$size);


$artcate_list = $artcate->select(1)->orderBy(["artcate_id","DESC"])->limit(["$start","$limit"])->findAll();




/*--- 赋值 ---*/

$smarty->assign("artcate_list",$artcate_list);
$smarty->assign("page_str",$page_str);

//设置模板路径
$smarty->display('admin/artcate_list.html');






?>