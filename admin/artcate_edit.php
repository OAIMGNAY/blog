<?php

include("../include/init.php");
include("check_admin.php");

$artcate = new M("artcate");


$artcate_id = isset($_GET['artcate_id']) ? $_GET['artcate_id'] : 0;
if (!$artcate_id) {
	show_msg("重新选择文章分类","artcate_list.php");
	exit;
}

$where = "artcate_id = $artcate_id";
$artcate_info = $artcate->select($where)->findOne();



if ($_POST) {
	$data = array(
		"artcate_name"=>$_POST["artcate_name"],
	);
	
	
	$affect_id = $artcate->update($data,$where);
	if ($affect_id) {
		show_msg("修改文章分类成功","artcate_list.php");
		exit;
	}else{
		show_msg("修改文章分类失败","artcate_edit.php");
		exit;
	}

}


$smarty->assign("artcate_info",$artcate_info);

//设置模板路径
$smarty->display('admin/artcate_edit.html');






?>