<?php
/*
 *  布局的配置参数
 *  
*/
require_once('./Config/Config.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$time_str = getTimeStr();
//echo $time_str."\n";
$date = date("Y-m-d");
$sql = "select lists From ps_prog_img as a,ps_publish_img as b Where a.id = b.program_id and b.device LIKE '%$id%' and ('$date' >= b.begindate and '$date' <= b.enddate) and b.rules LIKE '%$time_str%' order by b.id desc limit 1";
$query = mysqli_query($connect,$sql);
$result = mysqli_fetch_assoc($query);

$sql = "SELECT distinct a.temp_name From ps_media as a WHERE a.id IN ($result[lists]) order by field( a.id,$result[lists])" ;

$query = mysqli_query($connect,$sql);
//echo $sql;		    
while($result = mysqli_fetch_assoc($query)){
			
	$datas [] = $result;
}
//var_dump($datas);

if(is_array($datas) && !empty($datas))
{
	$jsondata = json_encode($datas,JSON_UNESCAPED_UNICODE);
}
$callback = $_GET['callback'];
echo $callback."($jsondata)"; 


?>