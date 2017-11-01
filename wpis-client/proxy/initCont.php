<?php
/*
* 读取缓存文件内容
* 20170301
* fengxp
*/
	error_reporting(0);
	$type = isset($_GET['type']) ? $_GET['type'] : 'tpl';
	
	$callback = @$_GET['callback'];
	
	if($type =='tpl'){
		$filename  = dirname(__FILE__).'/event/tpl.log';
	}elseif($type == 'img'){
		$filename  = dirname(__FILE__).'/event/img.log';
	}elseif($type == 'video'){
		$filename  = dirname(__FILE__).'/event/video.log';
	}
	
	// return a json array
	
	$response = array();
	$response['msg']  = file_get_contents($filename);
	
	$result = json_encode($response);
    
	echo $callback."($result)"; 
	flush();
?>