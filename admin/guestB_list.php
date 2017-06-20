<?php

include("../include/init.php");
include("check_admin.php");


$guestB = new M("guestbook");



/*--- 单条删除 ---*/
$delete_id = isset($_GET['guestB_id'])?$_GET['guestB_id']:0;
if ($delete_id) {
	$affect_id = $guestB->delete("guestB_id=$delete_id");
	if ($affect_id) {
		show_msg("删除留言成功","guestB_list.php");
		exit;
	}else{
		show_msg("删除留言失败","guestB_list.php");
		exit;
	}
}

/*--- 批量删除 ---*/
$delete_guestB = isset($_GET['id'])?$_GET['id']:0;
if ($delete_guestB) {
	$delete_arr = implode(",",$delete_guestB);
	$affect_id = $guestB->delete("guestB_id IN ($delete_arr)");
	if ($affect_id) {
		show_msg("批量删除留言成功","guestB_list.php");
		exit;
	}else{
		show_msg("批量删除留言失败","guestB_list.php");
		exit;
	}
}


/*--- 搜索 ---*/
$start_time = isset($_GET['start_time'])?strtotime($_GET['start_time']):0;
$end_time = isset($_GET['end_time'])?strtotime($_GET['end_time']):0;
$keywords = isset($_GET['keywords'])?trim($_GET['keywords']):0;

$where = "";
if ($start_time && !$end_time) {
	$where = "guestB_time > $start_time";
}else if (!$start_time && $end_time  ) {
	$where = "guestB_time < $end_time";
}else if ($start_time && $end_time) {
	$where = "guestB_time BETWEEN $start_time AND $end_time";
}else if (!empty($keywords)) {
	$where = "guestB_name = '$keywords'";
}else{
	$where = 1;
}





/*--- 分页 ---*/
$count = $guestB->select($where,"COUNT(*) AS c")->findOne();
$current = isset($_GET['page'])?$_GET['page']:1;   //获取当前页码值
$limit = 5;
$start = ($current-1)*$limit;
$size = 3;

$page_str =  page($current,$count["c"],$limit,$size);

//获取记录内容
$guestB_list = $guestB->select($where)->orderBy(["guestB_id","DESC"])->limit(["$start","$limit"])->findAll();



/*--- 赋值 ---*/

$smarty->assign("guestB_list",$guestB_list);
$smarty->assign("page_str",$page_str);
$smarty->assign("start_time",$start_time);
$smarty->assign("end_time",$end_time);

//设置模板路径
$smarty->display('admin/guestB_list.html');






?>