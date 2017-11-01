<?php
/*
 *  布局的配置参数
 *  
*/
require_once('./Config/Config.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$time=time();

$sql = "SELECT a.temp_name as bg_name ,b.temp_width,b.temp_height,b.video_info,b.img_info,b.weather_info,b.info1_info,b.info2_info,b.info3_info,info1_txt,info2_txt,info3_txt FROM ps_media as a,ps_layout as b WHERE b.temp_bg=a.id order by b.id desc";

//$sql = "SELECT a.temp_name as bg_name ,b.temp_width,b.temp_height,b.video_info,b.img_info,b.weather_info,b.info1_info,b.info2_info,b.info3_info,info1_txt,info2_txt,info3_txt FROM ps_media as a,ps_layout as b, ps_publish_tpl as c WHERE b.temp_bg=a.id and b.id=c.program_id and c.device LIKE '%$id%'";

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