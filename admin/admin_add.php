<?php

include("../include/init.php");
include("check_admin.php");

$admin = new M("admin");
if ($_POST) {
	$data = array(
		"admin_name"=>$_POST["admin_name"],
		"admin_pwd"=>md5($_POST["admin_pwd"]),
		"admin_site"=>$_POST["admin_site"],
		"admin_nickname"=>$_POST["admin_nickname"],
		"admin_email"=>$_POST["admin_email"],
		"admin_qq"=>$_POST["admin_qq"],
	);
	if($_FILES['admin_img']['size']>0) {
	    $uploads_path = DIR."/uploads";
	    $img_name = uploads("admin_img",1048576,"$uploads_path");
	    $data['admin_img'] ="uploads/".$img_name;
	}
	$insert_id = $admin->save($data);
	if ($insert_id) {
		show_msg("添加管理员成功","admin_list.php");
		exit;
	}else{
		show_msg("添加管理员失败","admin_add.php");
		exit;
	}
}

//设置模板路径
$smarty->display('admin/admin_add.html');
?>