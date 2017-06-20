<?php

include("../include/init.php");
include("check_admin.php");



//获取添加文章记录
$guestbook = new M("guestbook");

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
	
	$insert_id = $guestbook->save($data);
	if ($insert_id) {
		show_msg("添加留言成功","guestB_list.php");
		exit;
	}else{
		show_msg("添加留言失败","guestB_add.php");
		exit;
	}

}


//设置模板路径
$smarty->display('admin/guestB_add.html');


?>