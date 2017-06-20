<?php

include("../include/init.php");
include("check_admin.php");





$moodlist = new M("moodlist");

$mood_id = isset($_GET['mood_id']) ? $_GET['mood_id']:0;
if (!$mood_id) {
	show_msg("重新选择","moodlist_list.php");
	exit;
}
$where = "mood_id = $mood_id";
$mood_msg = $moodlist->select($where)->findOne();




if ($_POST) {
	$data = array(
		"mood_content"=>$_POST["mood_content"],
		"mood_time"=>strtotime($_POST['mood_time']),
	);
	if($_FILES['mood_img']['size']>0) {
	    $uploads_path = DIR."/uploads";
	    $img_name = uploads("mood_img",1048576,"$uploads_path");
	    $data['mood_img'] ="uploads/".$img_name;
	}
	
	$affect_id = $moodlist->update($data,"mood_id=$mood_id");
	if ($affect_id) {
		show_msg("修改心情随笔成功","moodlist_list.php");
		exit;
	}else{
		show_msg("修改心情随笔失败","moodlist_edit.php");
		exit;
	}

}




$smarty->assign("mood_msg",$mood_msg);

//设置模板路径
$smarty->display('admin/moodlist_edit.html');






?>