<?php
include("../include/init.php");


$admin = new M('admin');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == 'logout'){
	session_destroy();
	show_msg('退出成功','login.php');
	exit;
}

if($_POST){
	$admin_name = $_POST['admin_name'];
	$admin_pwd = md5($_POST['admin_pwd']);
	$img_code = strtolower(trim($_POST['img_code']));

	if($img_code != $_SESSION['img_code']){
		show_msg('验证码输入错误','login.php');
		exit;
	}

	$where = "admin_name = '$admin_name' AND admin_pwd = '$admin_pwd'";
	$admin_info = $admin->select($where)->findOne();

	if(!empty($admin_info)){
		unset($admin_info['admin_pwd']);
		$_SESSION['admin_info'] = $admin_info;
		show_msg("登录成功",'index.php');
	}
}



//设置模板路径
$smarty->display('admin/login.html');



?>