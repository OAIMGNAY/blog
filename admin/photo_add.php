<?php

include("../include/init.php");
include("check_admin.php");




$photo = new M("photograph");

if ($_POST) {
	$data = array(
		"photo_desc"=>$_POST["photo_desc"],
		"photo_cate"=>$_POST["photo_cate"],
		"photo_time"=>strtotime($_POST["photo_time"]),
	);
	if($_FILES['photo_img']['size']>0) {
	    $uploads_path = DIR."/uploads";
	    $img_name = uploads("photo_img",1048576,"$uploads_path");
	    $data['photo_img'] ="uploads/".$img_name;
	}
	$insert_id = $photo->save($data);
	if ($insert_id) {
		show_msg("添加图片信息成功","photo_list.php");
		exit;
	}else{
		show_msg("添加图片信息失败","photo_add.php");
		exit;
	}

}



//设置模板路径
$smarty->display('admin/photo_add.html');






?>