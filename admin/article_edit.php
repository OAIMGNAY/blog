<?php

include("../include/init.php");
include("check_admin.php");



//获取文章所有分类
$article_cate = new M("artcate");
$artcate_list = $article_cate->select()->findAll();



//获取添加文章记录
$article = new M("article");

$article_id = isset($_GET['article_id']) ? $_GET['article_id']:0;
if (!$article_id) {
	show_msg("重新选择文章","article_list.php");
	exit;
}
$where = "article_id = $article_id";
$article_msg = $article->select($where)->findOne();




if ($_POST) {
	$data = array(
		"article_title"=>$_POST["article_title"],
		"article_desc"=>$_POST['article_desc'],
		"article_content"=>$_POST['article_content'],
		"article_time"=>strtotime($_POST['article_time']),
		"artcate_id"=>$_POST['artcate_id'],
	);
	if($_FILES['article_img']['size']>0) {
	    $uploads_path = DIR."/uploads";
	    $img_name = uploads("article_img",1048576,"$uploads_path");
	    $data['article_img'] ="uploads/".$img_name;
	}

	$affect_id = $article->update($data,$where);
	if ($affect_id) {
		show_msg("修改文章成功","article_list.php");
		exit;
	}else{
		show_msg("修改文章失败","article_edit.php");
		exit;
	}

}



// /*--- 赋值 ---*/
$smarty->assign("artcate_list",$artcate_list);  //文章分类


$smarty->assign("article_msg",$article_msg);

//设置模板路径
$smarty->display('admin/article_edit.html');






?>