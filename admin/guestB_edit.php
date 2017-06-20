<?php

include("../include/init.php");
include("check_admin.php");





$guestbook = new M("guestbook");

$guestB_id = isset($_GET['guestB_id']) ? $_GET['guestB_id']:0;
if (!$guestB_id) {
	show_msg("重新选择","moodlist_list.php");
	exit;
}
$where = "guestB_id = $guestB_id";
$guestB_msg = $guestbook->select($where)->findOne();




if ($_POST) {
	$data = array(
		"guestB_name"=>$_POST["guestB_name"],
		"guestB_email"=>$_POST["guestB_email"],
		"guestB_cont"=>$_POST["guestB_cont"],
		"guestB_site"=>$_POST["guestB_site"],
		"guestB_time"=>strtotime($_POST['guestB_time']),
		"guestB_state"=>$_POST["guestB_state"],
		"guestB_reply"=>$_POST["guestB_reply"],
	);
	
	
	$affect_id = $guestbook->update($data,"guestB_id=$guestB_id");
	if ($affect_id) {
		show_msg("修改留言成功","guestB_list.php");
		exit;
	}else{
		show_msg("修改留言失败","guestB_edit.php");
		exit;
	}

}




$smarty->assign("guestB_msg",$guestB_msg);

//设置模板路径
$smarty->display('admin/guestB_edit.html');






?>