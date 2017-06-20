<?php

include("../include/init.php");
include("check_admin.php");


$admin = new M("admin");

/*--- 单条删除 ---*/
$delete_id = isset($_GET['admin_id'])?$_GET['admin_id']:0;
if ($delete_id) {
	$affect_id = $admin->delete("admin_id=$delete_id");
	if ($affect_id) {
		show_msg("删除管理员成功","admin_list.php");
		exit;
	}else{
		show_msg("删除管理员失败","admin_list.php");
		exit;
	}
}

/*--- 批量删除 ---*/
$delete_admin = isset($_GET['id'])?$_GET['id']:0;
if ($delete_admin) {
	$delete_arr = implode(",",$delete_admin);
	$affect_id = $admin->delete("admin_id IN ($delete_arr)");
	if ($affect_id) {
		show_msg("批量删除管理员成功","admin_list.php");
		exit;
	}else{
		show_msg("批量删除管理员失败","admin_list.php");
		exit;
	}
}


/*--- 搜索 ---*/

$keywords = isset($_GET['keywords'])?trim($_GET['keywords']):"";

$where = "";
 if (!empty($keywords)) {
	$where = "admin_name = '$keywords'";
}else{
	$where = 1;
}


/*--- 分页 ---*/

$count = $admin->select($where,"COUNT(*) AS c")->findOne();
// var_dump($count);
$current = isset($_GET['page'])?$_GET['page']:1;   //获取当前页码值
$limit = 5;
$start = ($current-1)*$limit;
$size = 3;

$page_str =  page($current,$count["c"],$limit,$size);


$admin_list = $admin->select($where)->orderBy(["admin_id","DESC"])->limit(["$start","$limit"])->findAll();

/*--- 赋值 ---*/

$smarty->assign("admin_list",$admin_list);
$smarty->assign("page_str",$page_str);
$smarty->assign("keywords",$keywords);

//设置模板路径
$smarty->display('admin/admin_list.html');


?>