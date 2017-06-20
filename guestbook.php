<?php

include("include/init.php");

$guestbook = new M("guestbook");
if ($_POST) {
	$data = array(
		"guestB_name"=>$_POST["guestB_name"],
		"guestB_email"=>$_POST["guestB_email"],
		"guestB_cont"=>$_POST["guestB_cont"],
		"guestB_site"=>$_POST["guestB_site"],
		"guestB_time"=>time(),
		"guestB_state"=>0,
	);
	if ($data['guestB_name']=="" || $data['guestB_email']=="" || $data['guestB_cont']=="") {
		show_msg("提交失败，请重新填写！","guestbook.php");
		exit;
	}

	$insert_id = $guestbook->save($data);
	if ($insert_id) {
		show_msg("添加留言成功","guestbook.php");
		exit;
	}else{
		show_msg("添加留言失败","guestbook.php");
		exit;
	}

}


//设置模板路径
$smarty->display('guestbook.html');






?>