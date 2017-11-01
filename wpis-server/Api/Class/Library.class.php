<?php
/*
 * 公共方法集合类
 */
class Library{
	//获取短信验证码   去兼职网
	public static function getSms($mobile){
		$sms_code = self::getSmsCode();   //获取随机码
		$account = 'jichengze';		//短信api账号
		$password = 'qjz51688';		//密码
		$content = '短信验证码是：'.$sms_code.'【去兼职】';
		//即时发送
		$url = "http://www.smswst.com/api/httpapi.aspx?action=send&account=".$account."&password=".$password."&mobile=".$mobile."&content=".$content;
		$data = array();
		$data['sms_code'] = $sms_code;
		file_get_contents($url);
		return $data;
	}

	//随机生成 5 个字母的字符串
	public static function getRndstr($length=5){
		$str='abcdefghijklmnopqrstuvwxyz';
		$rndstr = '';
		for($i=0;$i<$length;$i++){
			$rndcode=rand(0,25);
			$rndstr.=$str[$rndcode];
		}
		return $rndstr;
	}	
	//随机生成 6 位数字短信码
	public static function getSmsCode($length=6){
			return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
	}	
	//数据去重复并重新排序
	public static function arrayUnique($array){
		$out = array();
		foreach ($array as $key=>$value){
			if (!in_array($value, $out)){
				$out[$key] = $value;
			}
		}
		sort($out);
		return $out;
	}
	//弧度转换
	public static function rad($d){
		return $d * 3.1415926535898 / 180.0;
	}
	/**
	 * @desc 根据经纬度，计算两点之间公里数
	 * @param float $lat 纬度值
	 * @param float $lng 经度值
	 */
	public static function GetDistance($lat1, $lng1, $lat2, $lng2){
	     $EARTH_RADIUS = 6378.137;
		 $radLat1 = Library::rad($lat1);
	     $radLat2 = Library::rad($lat2);
	     $a = $radLat1 - $radLat2;
	     $b = Library::rad($lng1) - Library::rad($lng2);
	     $s = 2 * asin(sqrt(pow(sin($a/2),2) +
		 cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
	     $s = $s *$EARTH_RADIUS;
	     $s = round($s * 10000) / 10000;
	     return $s;
	}
	//获取IP地址
	public static function getIP(){
		if(getenv("HTTP_CLIENT_IP")){
			$ip = getenv("HTTP_CLIENT_IP");
		}elseif(getenv("HTTP_X_FORWARDED_FOR")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}elseif(getenv("REMOTE_ADDR")){
			$ip = getenv("REMOTE_ADDR");
		}else{
			$ip = '';
		}
		return $ip;
	}
	//根据出生年月日计算年龄
	public static function getAge($YTD){
		 $YTD = strtotime($YTD);//int strtotime ( string $time [, int $now ] )
		 $year = date('Y', $YTD);
		 if(($month = (date('m') - date('m', $YTD))) < 0){
		  $year++;
		 }else if ($month == 0 && date('d') - date('d', $YTD) < 0){
		  $year++;
		 }
		 return date('Y') - $year;
	}
	//时间转换，友好时间格式
	public static function mdate($time = NULL){
		$text = '';
		$time = $time === NULL || $time > time() ? time() : intval($time);
		$t = time() - $time; //时间差 （秒）
		$y = date('Y', $time)-date('Y', time());//是否跨年
		switch($t){
			case $t == 0:
				$text = '刚刚';
				break;
			case $t < 60:
				$text = $t . '秒前'; // 一分钟内
				break;
			case $t < 60 * 60:
				$text = floor($t / 60) . '分钟前'; //一小时内
				break;
			case $t < 60 * 60 * 24:
				$text = floor($t / (60 * 60)) . '小时前'; // 一天内
				break;
			case $t < 60 * 60 * 24 * 3:
				$text = floor($time/(60*60*24)) ==1 ?'昨天 ' . date('H:i', $time) : '前天 ' . date('H:i', $time) ; //昨天和前天
				break;
			case $t < 60 * 60 * 24 * 30:
				$text = date('m月d日  H:i', $time); //一个月内
				break;
			case $t < 60 * 60 * 24 * 365&&$y==0:
				$text = date('m月d日', $time); //一年内
				break;
			default:
				$text = date('Y年m月d日', $time); //一年以前
				break;
		}
		return $text;
	}

	
}




