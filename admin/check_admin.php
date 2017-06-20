<?php

if (!isset($_SESSION['admin_info']) || empty($_SESSION['admin_info']) || !is_array($_SESSION['admin_info']) ) {
	show_msg("重新登录","login.php");
	exit;
}else{
	$smarty->assign("admin_info",$_SESSION['admin_info']);
}


?>