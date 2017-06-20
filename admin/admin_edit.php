<?php

include("../include/init.php");
include("check_admin.php");

$admin = new M("admin");


$admin_id = isset($_GET['admin_id'])?$_GET['admin_id']:0;
if (!$admin_id) {
	show_msg("重新选择管理员","admin_list.php");
	exit;
}
$admin_info = $admin->select("admin_id=$admin_id")->findOne();

if ($_POST) {
	$data = array(
		"admin_name"=>$_POST["admin_name"],
		"admin_site"=>$_POST["admin_site"],
		"admin_nickname"=>$_POST["admin_nickname"],
		"admin_email"=>$_POST["admin_email"],
		"admin_qq"=>$_POST["admin_qq"],
	);
	if ($_POST['admin_pwd']) {
		$data['admin_pwd'] =md5($_POST["admin_pwd"]);
	}else{
		$data['admin_pwd'] =$admin_info['admin_pwd'];
	}
	if($_FILES['admin_img']['size']>0) {
	    $uploads_path = DIR."/uploads";
	    $img_name = uploads("admin_img",1048576,"$uploads_path");
	    $data['admin_img'] ="uploads/".$img_name;
	}

	$affect_id = $admin->update($data,"admin_id=$admin_id");
	if ($affect_id) {
		show_msg("修改管理员成功","admin_list.php");
		exit;
	}else{
		show_msg("修改管理员失败","admin_edit.php");
		exit;
	}

}


$smarty->assign("admin_info",$admin_info);

//设置模板路径
$smarty->display('admin/admin_edit.html');






?>