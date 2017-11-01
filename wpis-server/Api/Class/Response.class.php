<?php
class Response{
	/**
	* 按综合通信方式输出数据
	* $code 状态码   200 成功    400 失败
	* $message 提示信息
	* $data 数据
	*/	
	const JSON = 'json';  //定义一个常量
	public static function shows($code,$message='',$data=array(),$dataz=array(),$type=self::JSON){
		if(!is_numeric($code)){
			return '';
		}
		$type = isset($_GET['format']) ? $_GET['format'] : self::JSON;
		$result = array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data,
			'dataz'=>$dataz
		);
		if($type == 'json'){
			self::jsons($code,$message,$data,$dataz);
			exit;
		}elseif($type == 'array'){
			echo "这里仅是调试模式，不能进行数据传输使用<br/>++++++++++++++++++++++++++++++++++++++<pre>";
			print_r($result);
			echo "</pre>++++++++++++++++++++++++++++++++++++++";
		}elseif($type == 'xml'){
			self::xmlEncode($code,$message,$data);
			exit;
		}else{
			echo "抱歉，暂时未提供此种数据格式";
			//扩展对象或其他方式等
			exit;
		}
	}
	/**
	* 按json格式封装数据
	* $code 状态码
	* $message 提示信息
	* $data 数据
	*/
	public static function jsons($code,$message='',$data=array(),$dataz=array()){
		if(!is_numeric($code)){
			return '';
		}	
		$result = array(
			'code'=>$code,
			'message'=>urlencode($message),
			'data'=>$data,
			'dataz'=>$dataz
		);
		echo urldecode(json_encode($result));
		exit;
	}
	public static function show($code,$message='',$data=array(),$type=self::JSON){
		if(!is_numeric($code)){
			return '';
		}
		$type = isset($_GET['format']) ? $_GET['format'] : self::JSON;
		$result = array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		if($type == 'json'){
			self::json($code,$message,$data);
			
			exit;
		}elseif($type == 'array'){
			echo "这里仅是调试模式，不能进行数据传输使用<br/>++++++++++++++++++++++++++++++++++++++<pre>";
			print_r($result);
			echo "</pre>++++++++++++++++++++++++++++++++++++++";
		}elseif($type == 'xml'){
			self::xmlEncode($code,$message,$data);
			exit;
		}else{
			echo "抱歉，暂时未提供此种数据格式";
			//扩展对象或其他方式等
			exit;
		}
	}
	/**
	* 按json格式封装数据
	* $code 状态码
	* $message 提示信息
	* $data 数据
	*/
	public static function json($code,$message='',$data=array()){
		if(!is_numeric($code)){
			return '';
		}	
		$result = array(
			'code'=>$code,
			'message'=>urlencode($message),
			'data'=>$data
		);
		echo urldecode(json_encode($result));
		//echo json_encode($result);
		
		exit;
	}
	
	/**
	* 按xml格式封装数据
	* $code 状态码
	* $message 提示信息
	* $data 数据
	*/	
	public static function xmlEncode($code,$message,$data){
		if(!is_numeric($code)){
			return '';
		}
		$result = array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		header("Content-Type:text/xml");
		$xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
		$xml .= "<root>\n";
		$xml .= self::xmlToEncode($result);
		$xml .= "</root>";
		echo $xml;
	}
	//解析xmlEncode()方法里的$result数组，拼装成xml格式	
	public static function xmlToEncode($data){
		$xml = $attr = "";
		foreach($data as $key => $value){
			//因为xml节点不能为数字，如果$key是数字的话，就重新定义一个节点名，把该数字作为新节点的id名称
			if(is_numeric($key)){
				$attr = " id='{$key}'";
				$key = "item";
			}
			$xml .= "<{$key}{$attr}>\n";
			//递归方法处理$value数组，如果是数组继续解析，如果不是数组，就直接给值
			$xml .= is_array($value) ? self::xmlToEncode($value) : $value;
			$xml .= "</{$key}>";
		}
		return $xml;
	}
}
?>