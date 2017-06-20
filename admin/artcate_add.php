<?php

include("../include/init.php");
include("check_admin.php");

$artcate = new M("artcate");

if ($_POST) {
	$data = array(
		"artcate_name"=>$_POST["artcate_name"],
	);
	
	$insert_id = $artcate->save($data);
	if ($insert_id) {
		show_msg("添加文章分类成功","artcate_list.php");
		exit;
	}else{
		show_msg("添加文章分类失败","artcate_add.php");
		exit;
	}

}

//设置模板路径
$smarty->display('admin/artcate_add.html');

?>