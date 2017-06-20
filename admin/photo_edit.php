<?php

include("../include/init.php");
include("check_admin.php");

$photo = new M("photograph");


$photo_id = isset($_GET['photo_id'])?$_GET['photo_id']:0;
if (!$photo_id) {
	show_msg("重新选择管理员","photo_list.php");
	exit;
}
$photo_info = $photo->select("photo_id=$photo_id")->findOne();




if ($_POST) {
	$data = array(
		"photo_desc"=>$_POST["photo_desc"],
		"photo_cate"=>$_POST["photo_cate"],
		"photo_time"=>strtotime($_POST["photo_time"]),
	);
	if ($_POST['photo_pwd']) {
		$data['photo_pwd'] =md5($_POST["photo_pwd"]);
	}else{
		$data['photo_pwd'] =$photo_info['photo_pwd'];
	}
	if($_FILES['photo_img']['size']>0) {
	    $uploads_path = DIR."/uploads";
	    $img_name = uploads("photo_img",1048576,"$uploads_path");
	    $data['photo_img'] ="uploads/".$img_name;
	}

	$affect_id = $photo->update($data,"photo_id=$photo_id");
	if ($affect_id) {
		show_msg("修改管理员成功","photo_list.php");
		exit;
	}else{
		show_msg("修改管理员失败","photo_edit.php");
		exit;
	}

}


$smarty->assign("photo_info",$photo_info);

//设置模板路径
$smarty->display('admin/photo_edit.html');






?>