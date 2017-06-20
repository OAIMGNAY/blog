<?php

include("../include/init.php");
include("check_admin.php");


$moodlist = new M("moodlist");



/*--- 单条删除 ---*/
$delete_id = isset($_GET['mood_id'])?$_GET['mood_id']:0;
if ($delete_id) {
	$affect_id = $moodlist->delete("mood_id=$delete_id");
	if ($affect_id) {
		show_msg("删除心情随笔成功","moodlist_list.php");
		exit;
	}else{
		show_msg("删除心情随笔失败","moodlist_list.php");
		exit;
	}
}

/*--- 批量删除 ---*/
$delete_moodlist = isset($_GET['id'])?$_GET['id']:0;
if ($delete_moodlist) {
	$delete_arr = implode(",",$delete_moodlist);
	$affect_id = $moodlist->delete("mood_id IN ($delete_arr)");
	if ($affect_id) {
		show_msg("批量删除心情随笔成功","moodlist_list.php");
		exit;
	}else{
		show_msg("批量删除心情随笔失败","moodlist_list.php");
		exit;
	}
}


/*--- 搜索 ---*/
$start_time = isset($_GET['start_time'])?strtotime($_GET['start_time']):0;
$end_time = isset($_GET['end_time'])?strtotime($_GET['end_time']):0;


$where = "";
if ($start_time && !$end_time) {
	$count_where = "mood_time > $start_time";
	$msg_where = "art.mood_time > $start_time";
}else if (!$start_time && $end_time  ) {
	$count_where = "mood_time < $end_time";
	$msg_where = "art.mood_time < $end_time";
}else if ($start_time && $end_time) {
	$count_where = "mood_time BETWEEN $start_time AND $end_time";
	$msg_where = "art.mood_time BETWEEN $start_time AND $end_time";
}else{
	$count_where = 1;
	$msg_where = 1;
}





/*--- 分页 ---*/


$count = $moodlist->select($count_where,"COUNT(*) AS c")->findOne();
$current = isset($_GET['page'])?$_GET['page']:1;   //获取当前页码值
$limit = 5;
$start = ($current-1)*$limit;
$size = 3;

$page_str =  page($current,$count["c"],$limit,$size);


//获取记录内容
$mood_list = $moodlist->select($msg_where)->orderBy(["mood_id","DESC"])->limit(["$start","$limit"])->findAll();



/*--- 赋值 ---*/

$smarty->assign("mood_list",$mood_list);
$smarty->assign("page_str",$page_str);
$smarty->assign("start_time",$start_time);
$smarty->assign("end_time",$end_time);

//设置模板路径
$smarty->display('admin/moodlist_list.html');






?>