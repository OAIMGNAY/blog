<?php

$link = new M('link');
$photo = new M('photograph');
$article = new M('article'); 

//友情链接十条信息
$link_side = $link->select(1)->orderBy(['link_id',"DESC"])->limit([6])->findAll();
//九章最新图片
$photo_side = $photo->select(1)->orderBy(['photo_id',"DESC"])->limit([9])->findAll();
//栏目更新
$article_side = $article->select(1)->orderBy(['article_id',"DESC"])->limit([10])->findAll();

$smarty->assign('link_side',$link_side);
$smarty->assign('photo_side',$photo_side);
$smarty->assign('article_side',$article_side);






?>