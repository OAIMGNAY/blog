<?php

include("../include/init.php");
include("check_admin.php");

$link = new M("link");


$link_id = isset($_GET['link_id']) ? $_GET['link_id'] : 0;
if (!$link_id) {
	show_msg("重新链接修改","link_list.php");
	exit;
}

$where = "link_id = $link_id";
$link_info = $link->select($where)->findOne();



if ($_POST) {
	$data = array(
		"link_name"=>$_POST["link_name"],
		"link_address"=>$_POST["link_address"],
		"link_desc"=>$_POST["link_desc"],
	);
	
	
	$affect_id = $link->update($data,$where);
	if ($affect_id) {
		show_msg("修改友情链接成功","link_list.php");
		exit;
	}else{
		show_msg("修改友情链接失败","link_edit.php");
		exit;
	}

}


$smarty->assign("link_info",$link_info);

//设置模板路径
$smarty->display('admin/link_edit.html');






?>