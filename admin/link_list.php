<?php

include("../include/init.php");
include("check_admin.php");


$link = new M("link");



/*--- 单条删除 ---*/
$delete_id = isset($_GET['link_id'])?$_GET['link_id']:0;
if ($delete_id) {
	$affect_id = $link->delete("link_id=$delete_id");
	if ($affect_id) {
		show_msg("删除链接成功","link_list.php");
		exit;
	}else{
		show_msg("删除链接失败","link_list.php");
		exit;
	}
}

/*--- 批量删除 ---*/
$delete_link = isset($_GET['id'])?$_GET['id']:0;
if ($delete_link) {
	$delete_arr = implode(",",$delete_link);
	$affect_id = $link->delete("link_id IN ($delete_arr)");
	if ($affect_id) {
		show_msg("批量删除链接成功","link_list.php");
		exit;
	}else{
		show_msg("批量删除链接失败","link_list.php");
		exit;
	}
}




/*--- 分页 ---*/

$count = $link->select(1,"COUNT(*)  AS c")->findOne();
// var_dump($count);
$current = isset($_GET['page'])?$_GET['page']:1;   //获取当前页码值
$limit = 5;
$start = ($current-1)*$limit;
$size = 3;

$page_str =  page($current,$count["c"],$limit,$size);


$link_list = $link->select(1)->orderBy(["link_id","DESC"])->limit(["$start","$limit"])->findAll();




/*--- 赋值 ---*/

$smarty->assign("link_list",$link_list);
$smarty->assign("page_str",$page_str);

//设置模板路径
$smarty->display('admin/link_list.html');






?>