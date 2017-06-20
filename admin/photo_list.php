<?php

include("../include/init.php");
include("check_admin.php");


$photo = new M("photograph");



/*--- 单条删除 ---*/
$delete_id = isset($_GET['photo_id'])?$_GET['photo_id']:0;
if ($delete_id) {
	$affect_id = $photo->delete("photo_id=$delete_id");
	if ($affect_id) {
		show_msg("删除图片信息成功","photo_list.php");
		exit;
	}else{
		show_msg("删除图片信息失败","photo_list.php");
		exit;
	}
}

/*--- 批量删除 ---*/
$delete_photo = isset($_GET['id'])?$_GET['id']:0;
if ($delete_photo) {
	$delete_arr = implode(",",$delete_photo);
	$affect_id = $photo->delete("photo_id IN ($delete_arr)");
	if ($affect_id) {
		show_msg("批量删除图片信息成功","photo_list.php");
		exit;
	}else{
		show_msg("批量删除图片信息失败","photo_list.php");
		exit;
	}
}


/*--- 搜索 ---*/

$keywords = isset($_GET['keywords'])?trim($_GET['keywords']):"";

$where = "";
 if (!empty($keywords)) {
	$where = "photo_cate = '$keywords'";
}else{
	$where = 1;
}




/*--- 分页 ---*/

$count = $photo->select($where,"COUNT(*) AS c")->findOne();
// var_dump($count);
$current = isset($_GET['page'])?$_GET['page']:1;   //获取当前页码值
$limit = 5;
$start = ($current-1)*$limit;
$size = 3;

$page_str =  page($current,$count["c"],$limit,$size);


$photo_list = $photo->select($where)->orderBy(["photo_id","DESC"])->limit(["$start","$limit"])->findAll();




/*--- 赋值 ---*/

$smarty->assign("photo_list",$photo_list);
$smarty->assign("page_str",$page_str);
$smarty->assign("keywords",$keywords);

//设置模板路径
$smarty->display('admin/photo_list.html');






?>