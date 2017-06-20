<?php
	/**
	 * 公共函数库
	 * @author dazhaozhao
	 * @email mrtwenty@foxmail.com
	 */


	 
/**
 * 
 * 前台设置cookie
 * @param string $string
 * @param int $start
 * @param int $length
 * @param string $charset
 * @param string $dot
 * 
 * @return string
 */

  function cookie_user($key,$value,$time){
  		return setcookie($key,$value,$time);
  }
	 
/**
 * 
 * 字符截取
 * @param string $string
 * @param int $start
 * @param int $length
 * @param string $charset
 * @param string $dot
 * 
 * @return string
 */
function str_cut(&$string, $start, $length, $charset = "utf-8", $dot = '...') {
	if(function_exists('mb_substr')) {
		if(mb_strlen($string, $charset) > $length) {
			return mb_substr ($string, $start, $length, $charset) . $dot;
		}
		return mb_substr ($string, $start, $length, $charset);
		
	}else if(function_exists('iconv_substr')) {
		if(iconv_strlen($string, $charset) > $length) {
			return iconv_substr($string, $start, $length, $charset) . $dot;
		}
		return iconv_substr($string, $start, $length, $charset);
	}

	$charset = strtolower($charset);
	switch ($charset) {
		case "utf-8" :
			preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $ar);
			if(func_num_args() >= 3) {
				if (count($ar[0]) > $length) {
					return join("", array_slice($ar[0], $start, $length)) . $dot;
				}
				return join("", array_slice($ar[0], $start, $length));
			} else {
				return join("", array_slice($ar[0], $start));
			}
			break;
		default:
			$start = $start * 2;
			$length   = $length * 2;
			$strlen = strlen($string);
			for ( $i = 0; $i < $strlen; $i++ ) {
				if ( $i >= $start && $i < ( $start + $length ) ) {
					if ( ord(substr($string, $i, 1)) > 129 ) $tmpstr .= substr($string, $i, 2);
					else $tmpstr .= substr($string, $i, 1);
				}
				if ( ord(substr($string, $i, 1)) > 129 ) $i++;
			}
			if ( strlen($tmpstr) < $strlen ) $tmpstr .= $dot;
			
			return $tmpstr;
	}
}
	 
	//页面跳转函数
function show_msg($msg="", $url=""){
	@header("Content-Type:text/html;charset=utf-8");
	echo '<script type="text/javascript">';
	echo 'alert("'.$msg.'");';
	
	if(!empty($url)){
		echo 'location.href = "'.$url.'"';
	}else{
		echo 'history.go(-1);';
	}
	
	echo '</script>';
	exit;
}
/**
 *	实现文件的上传
 *  @param string 上传的表单中类型为file的name值
 *  @param int 	  上传文件大小的限制
 *  @param array  上传文件类型的限制
 *  @param string 上传文件保存的目录
 *  @return string 错误，返回对应错误信息，正确，返回图片信息。
 */	
function uploads($name='img',$size=1048576,$path='uploads',$arr=array('jpg','png','gif')){
		$num= $_FILES[$name]['error'];
		if($num>0){
			if($num==1){
				return '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。';
				
			}else if($num==2){
				return '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。';
			}else if($num==3){
				return '文件只有部分被上传。 ';
				
			}else if($num==4){
				return '没有文件被上传';
				
			}else{
				return '其他情况';
			
			}		
		}
		// 再次拦截
		 if($_FILES[$name]['size']>$size){
			return '你是故意的';
		 }
		 
		  //文件后缀名
		 $pre=pathinfo($_FILES[$name]['name'],PATHINFO_EXTENSION);


		
		  if(!in_array($pre,$arr)){
			return '文件的类型不对';
		  }
		//文件名跟文件后缀需要重新处理
		$filename=date('Ymdhis').mt_rand(1000,9999).'.'.$pre;
		
		  //判断是否是通过http post上传过来的文件
		 if(is_uploaded_file($_FILES[$name]['tmp_name'])){
			move_uploaded_file($_FILES[$name]['tmp_name'],$path.'/'.$filename);
			return $filename;
		  }else{
			return false;
		  }
}




//得到当前网址
function get_url(){
	$str = $_SERVER['PHP_SELF'].'?';
	if($_GET){
		foreach ($_GET as $k=>$v){  //$_GET['page']
			if($k!='page'){
				$str .= $k.'='.$v.'&';
			}
		}
	}
	return $str;
}



//分页函数
/**
 *@pargam $current	当前页
 *@pargam $count	记录总数
 *@pargam $limit	每页显示多少条
 *@pargam $size		中间显示多少条
 *@pargam $class	样式
*/
function page($current,$count,$limit,$size,$class='sabrosus'){
	$str='';
	if($count>$limit){
		$pages = ceil($count/$limit);//算出总页数
		$url = get_url();//获取当前页面的URL地址（包含参数）
		
		$str.='<div class="'.$class.'">';
		//开始
		if($current==1){
			$str.='<span class="disabled">首&nbsp;&nbsp;页</span>';
			$str.='<span class="disabled">  &lt;上一页 </span>';
		}else{
			$str.='<a href="'.$url.'page=1">首&nbsp;&nbsp;页 </a>';
			$str.='<a href="'.$url.'page='.($current-1).'">  &lt;上一页 </a>';
		}
		//中间
		//判断得出star与end
	    
		 if($current<=floor($size/2)){ //情况1
			$star=1;
			$end=$pages >$size ? $size : $pages; //看看他两谁小，取谁的
		 }else if($current>=$pages - floor($size/2)){ // 情况2
				 
			$star=$pages-$size+1<=0?1:$pages-$size+1; //避免出现负数
		
			$end=$pages;
		 }else{ //情况3
		 
			$d=floor($size/2);
			$star=$current-$d;
			$end=$current+$d;
		 }
	
		for($i=$star;$i<=$end;$i++){
			if($i==$current){
				$str.='<span class="current">'.$i.'</span>';	
			}else{
				$str.='<a href="'.$url.'page='.$i.'">'.$i.'</a>';
			}
		}
		//最后
		if($pages==$current){
			$str .='<span class="disabled">  下一页&gt; </span>';
			$str.='<span class="disabled">尾&nbsp;&nbsp;页  </span>';
		}else{
			$str.='<a href="'.$url.'page='.($current+1).'">下一页&gt; </a>';
			$str.='<a href="'.$url.'page='.$pages.'">尾&nbsp;&nbsp;页 </a>';
		}
		$str.='</div>';
	}
	
	return $str;
}

//获取随机数
function GetRandStr($len) 
{ 
    $chars = array( 
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
        "3", "4", "5", "6", "7", "8", "9" 
    ); 
    $charsLen = count($chars) - 1; 
    shuffle($chars);   //打乱
    $output = ""; 
    for ($i=0; $i<$len; $i++) 
    { 
        $output .= $chars[mt_rand(0, $charsLen)]; 
    }  
    return $output;  
}
