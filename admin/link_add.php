<?php

include("../include/init.php");
include("check_admin.php");




$link = new M("link");

if ($_POST) {
	$data = array(
		"link_name"=>$_POST["link_name"],
		"link_address"=>$_POST["link_address"],
		"link_desc"=>$_POST["link_desc"],
	);
	
	
	$insert_id = $link->save($data);
	if ($insert_id) {
		show_msg("添加友情链接成功","link_list.php");
		exit;
	}else{
		show_msg("添加友情链接失败","link_add.php");
		exit;
	}

}



//设置模板路径
$smarty->display('admin/link_add.html');






?>