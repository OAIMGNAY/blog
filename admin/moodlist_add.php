<?php

include("../include/init.php");
include("check_admin.php");



//获取添加文章记录
$moodlist = new M("moodlist");

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
	
	$insert_id = $moodlist->save($data);
	if ($insert_id) {
		show_msg("添加心情语录成功","moodlist_list.php");
		exit;
	}else{
		show_msg("添加心情语录失败","moodlist_add.php");
		exit;
	}

}


//设置模板路径
$smarty->display('admin/moodlist_add.html');


?>