<?php
/*
 *  轮询
 *  
*/
require_once('./Config/Config.php');
$type = isset($_GET['type']) ? $_GET['type'] : 'tpl';

$time_str = getTimeStr();
//echo $time_str."\n";
$date = date("Y-m-d");
if( $type == 'tpl')
{
	$msgType = 3;
	$dbName = 'ps_publish_tpl';
}else if( $type == 'img')
{	
	$msgType = 1;
	$dbName = 'ps_publish_img';
}else if( $type == 'video')
{
	$msgType = 2;
	$dbName = 'ps_publish_video';
}else
	exit;
$sql = "select id,device From $dbName Where ('$date' >= begindate and '$date' <= enddate) and rules LIKE '%$time_str%' order by id desc limit 1";

$query = mysqli_query($connect,$sql);
$result = mysqli_fetch_assoc($query);
//var_dump( $result);

if(is_array($result) && !empty($result))
{
	$sql = "SELECT id From ps_device  WHERE type = 0 and id IN ($result[device])" ;

	$query = mysqli_query($connect,$sql);
	
	while($result = mysqli_fetch_assoc($query)){
		$datas [] = $result;		
	}
	poller_push($datas,0,$msgType);
}

?>