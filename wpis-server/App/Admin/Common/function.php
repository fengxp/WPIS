<?php
/**
 * 增加日志
 * @param $log
 * @param bool $name
 */
use Think\Model;
function addlog($log, $name = false)
{
    $Model = M('log');
    if (!$name) {
        session_start();
        $uid = session('uid');
        if ($uid) {
            $user = M('member')->field('user')->where(array('uid' => $uid))->find();
            $data['name'] = $user['user'];
        } else {
            $data['name'] = '';
        }
    } else {
        $data['name'] = $name;
    }
    $data['t'] = time();
    $data['ip'] = $_SERVER["REMOTE_ADDR"];
    $data['log'] = $log;
    $Model->data($data)->add();
}


/**
 *
 * 获取用户信息
 *
 **/
function member($uid, $field = false)
{
    $model = M('Member');
    if ($field) {
        return $model->field($field)->where(array('uid' => $uid))->find();
    } else {
        return $model->where(array('uid' => $uid))->find();
    }
}
//网管/监控 根据设备各个参数规则设定设备状态
function setDeviceStatus($id,$cpu,$memory,$diskpercent,$status,$device,$device_info)
{
	$cup_rule=C('CPU_RULE');
	$memory_rule=C('MEMORY_RULE');
	$diskpercent_rule=C('DISKPERCENT_RULE');	
	$device_info_list=M($device_info)->where(' id in ('.$id.') ')->select();
	foreach($device_info_list as $value){
		if($value[$cpu]>$cup_rule || $value[$memory]>$memory_rule || $value[$diskpercent]> $diskpercent_rule)
		{
			$data[$status] =  'abnormal';
		}
		else 
		{
			$data[$status] =  'normal';
		}		
	}
	$tblist= M($device)->where(' id =' . $id)->data($data)->save();
	$tblist1= M($device_info)->where(' id =' . $id)->data($data)->save();
}
//获取echart 横坐标值
function getCoordinateX($attrname,$tbname)
{
	$model = M($tbname);
	$listx = $model->field($attrname)->group($attrname)->order($attrname)->select();
// 	echo  count($listx);
// 	echo "$";
// 	exit;
	foreach($listx as $value){
		$tempfirst.=$value[$attrname].',';
	}
	$finalmiddle=explode(',',$tempfirst);
	for($index=0;$index<count($finalmiddle)-1;$index++){
		if($index==(count($finalmiddle)-2))
		{
			$tempfinal.='"'.$finalmiddle[$index].'"';
		}
		else
		{
			$tempfinal.='"'.$finalmiddle[$index].'",';
		}
	}
	return "[".$tempfinal."]";
}
//获取echart 纵坐标值
function getCoordinateY($count,$alias,$attrname,$tbname)
{

	$model = M($tbname);
	$listx = $model->field($count)->group($attrname)->order($attrname)->select();
	foreach($listx as $value){
		$tempfirst.=$value[$alias].',';
	}
	$finalmiddle=explode(',',$tempfirst);
	for($index=0;$index<count($finalmiddle)-1;$index++){
		if($index==(count($finalmiddle)-2))
		{
			$tempfinal.=''.$finalmiddle[$index].'';
		}
		else
		{
			$tempfinal.=''.$finalmiddle[$index].',';
		}
	}
	return "[".$tempfinal."]";
}
 //取得当前审核状态
function getAuditStatus($audit) {
    $audit_status=C('AUDIT_STATUS');
	if(!empty($audit_status[$audit]))
		return $audit_status[$audit];
	else
		return "Out of Range";
}
//取得节目类别
function getMediaAttr($val) {
    $status=C('MEDIA_ATTR');
	if(!empty($status[$val]))
		return $status[$val];
	else
		return "Out of Range";
}


//获取预定义信息类别
function getAllType($val,$alltype) {
	$status=C($alltype);
	if(!empty($status[$val]))
		return $status[$val];
	else
		return "Out of Range";
}
//获取合同类型
function getContractType($val) {
	$status=C('CONTRACT_TYPE');
	if(!empty($status[$val]))
		return $status[$val];
	else
		return "Out of Range";
}
function getPreInfoType($val) {
	$status=C('PREDEFINEINFO_TYPE');
	if(!empty($status[$val]))
		return $status[$val];
	else
		return "Out of Range";
}
//取得信息类型
function getInfoType($audit) {
    $audit_status=C('INFO_TYPE');
	if(!empty($audit_status[$audit]))
		return $audit_status[$audit];
	else
		return "Out of Range";
}
//取得指令类型
function getOrderType($audit) {
    $audit_status=C('ORDER_TYPE');
	if(!empty($audit_status[$audit]))
		return $audit_status[$audit];
	else
		return "Out of Range";
}
function searchLists($key,$orderattr,$seachattr) {
	$field   = isset($_GET['field']) ? $_GET['field'] : '';
	$keyword = isset($_GET['keyword']) ? $key : '';
	$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
	$type    = isset($_GET['type']) ? $_GET['type'] : '';
	$where   = '';	
	if ($order == 'asc') {
		$order = $orderattr." asc";
	} elseif ($order == 'desc') {
		$order = $orderattr." desc";
	} else {
		$order = "id desc";
	}
	if ($keyword <> '') {
		$where = $seachattr." LIKE '%$keyword%'";
	}
	return $where;
}
//判断设备树设备类型
function getDeviceType($type)
{
	$device_type=C('DEVICE_TYPE');
	if(!empty($device_type[$type]))
		return $device_type[$type];
	else
		return "Out of Range";
}
//通用下拉选择框
function mySelect($config_str,$val,$disable) {
    $status=C($config_str);
	$result = "";
	$selected = "";
	$result = "<select id='myselect' name='myselect' class='select' ".$disable.">";
	foreach ( $status as $key => $value ) {
		if ($key == $val) {
			$selected = "selected";
		}else
			$selected = "";
		
		$result .= "<option value=$key $selected > $value </option>";
	}
	$result .= "</select>";
	return $result;
}
//得到更新时间
function getUpdateTime($time)
{
	if(empty($time))
		return "";
	else
	{
		date_default_timezone_set(PRC);
		$date=date("Y-m-d H:i",$time);
		return $date;
	}
}
//根据device设备，返回IP数组
function getDeviceIP($deviceID){
	$prex = C('DB_PREFIX');
	$Model = new Model();
	$sql = "select addr1 from ".$prex."device_info where id IN (".$deviceID.")";
	$res = $Model->query($sql);
	return $res;
}
//发布命令
function sendOrder($val){
	$output = array ();
	$cmd = '/var/eadv/.bin/sendOrder.sh '.$val.' &';
	
	exec ( $cmd, $output );
	//	exec ( "whoami", $output );
	//	var_dump($output);
	//	exit;
	return true;
}
//发布关机命令
function sendShutDown($val){
	$output = array ();
	$cmd = '/var/eadv/.bin/sendShutDown.sh '.$val.' &';
	//	echo $cmd . "<br />";
	exec ( $cmd, $output );
	//	exec ( "whoami", $output );
	//	var_dump($output);
	//	exit;
	return true;
}
/*直连方式
* retreat 0：发布  retreat 1: 撤销
* msgType 0：文本  msgType 3：模板 msgType 2: 视频  msgType 1: 图片
*/
function infoPush($data,$retreat=0,$msgType=0)
{
	$file = DOC_ROOT."/log/";
	$prex = C('DB_PREFIX');
	$Model = new Model();
	$sql = "select id from ".$prex."device where id IN (".$data['device'].") and type='0'";
	$res = $Model->query($sql);
	if($retreat==0)
		$info_txt=urlencode(json_encode(array("msgType"=>$msgType,"retreat"=>$retreat,"type"=>$data['type'],"title"=>$data['title'],'length'=>$data['length'],"sub_time"=>$data['sub_time'],"content"=>$data['content'])));
	else
		$info_txt=urlencode(json_encode(array("msgType"=>$msgType,"retreat"=>$retreat,"type"=>$data['type'],"sub_time"=>$data['sub_time'])));
	foreach($res as $val)
	{
		$file_name = $file.$val['id'].".txt";
		file_put_contents($file_name,$info_txt);
	}

	return true;
}
/*代理方式
* retreat 0：发布  retreat 1: 撤销
*
* msgType 0：文本  
* msgType 1: 图片
* msgType 2: 视频 
* msgType 3：模板 
* msgType 4: 指令  type：1-重启 2-关机 3-横屏 4-竖屏
* msgType 5: 流媒体
* msgType 6: 预定义
*/
function infoPush2($data,$retreat=0,$msgType=0)
{
	$prex = C('DB_PREFIX');
	$Model = new Model();
	$sql = "select id from ".$prex."device where id IN (".$data['device'].") and type='0'";
	$res = $Model->query($sql);
	if($retreat==0)
		$info_txt=array("msgType"=>$msgType,"retreat"=>$retreat,"type"=>$data['type'],"title"=>$data['title'],'length'=>$data['length'],"sub_time"=>$data['sub_time'],"content"=>$data['content']);
	else
		$info_txt=array("msgType"=>$msgType,"retreat"=>$retreat,"type"=>$data['type'],"sub_time"=>$data['sub_time']);
	$sock = C('SOCKET_MQ');
	import("Library.EventMq");
	$eventMq = new \EventMq($sock);
	foreach($res as $val)
	{
		$msg = array('uid'=>$val['id'])+$info_txt;
		$eventMq->send($msg);
	}
	
	return true;
}
function getTimeStr(){
		date_default_timezone_set('PRC');
		//echo date("Y-m-d H:i:s");
		if(date("i")<30)
			$str = date("N").",".date("H").":00-".date("H").":30";
		else
			$str = date("N").",".date("H").":30-".(date("H")+1).":00";
		return $str;
	}
function getNowPush($data,$ret,$type){
	//var_dump($data);
	
	if($data["atonce"] ==1){
		if($type == 5){
			//直播直接返回地址
			return infoPush2($data,$ret,$type);
		}
		elseif($type == 6){
			$media_cont=getPushCont($data['program_id'],$type);
			
			$data['content'] = $media_cont['content'];
			$data['type'] = $media_cont['type'];
			
		}else{
			
			$media_cont=getPushCont($data['program_id'],$type);	
			$data['content'] = $media_cont;
		}
		return infoPush2($data,$ret,$type);
		
	}
	$nowDate =  strtotime(date("Y-m-d"));
	$nowTime =  getTimeStr();
	if($nowDate >= strtotime($data['begindate']) &&  $nowDate <= strtotime($data['enddate']))
	{
		if(in_array($nowTime,explode(";",$data['rules']))){
			if($type ==5){
				//直播直接返回地址
				return infoPush2($data,$ret,$type);
			}elseif($type ==6){
				$media_cont=getPushCont($data['program_id'],$type);
				
				$data['content'] = $media_cont['content'];
				$data['type'] = $media_cont['type'];
			
			}else{
				$media_list=getPushCont($data['program_id'],$type);	
				if($media_list){
					$data['content'] = $media_list;
				}
			}
			return infoPush2($data,$ret,$type);
			
		}	
	}else
		return 0;
	
}

function getPushCont($id,$type,$content=null){
	$prex = C('DB_PREFIX');
	$Model = new Model();
	if($type == 1) $table = $prex."prog_img";
	elseif($type == 2) $table = $prex."prog_video";
	elseif($type == 3){
		$sql = "SELECT a.temp_name as bg_name ,b.* FROM ".$prex."media as a,".$prex."layout as b WHERE b.temp_bg=a.id and b.id=$id";
		//echo $sql;
		$res = $Model->query($sql);
		return ($res[0]);
	}elseif($type == 6){
		$sql = "SELECT content,type FROM ".$prex."prog_predefineinfo as a WHERE a.id=$id";
		//echo $sql;
		$res = $Model->query($sql);
		return ($res[0]);
	}
	
	$sql = "select lists from $table where id=$id" ;
	$res = $Model->query($sql);
	$lists=$res[0]['lists'];

	$sql = "SELECT  a.temp_name,a.id From ps_media as a WHERE a.id IN ($lists) order by field( a.id,$lists)";
	$res = $Model->query($sql);
	
	//var_dump($res);
	
	foreach($res as $val){
		$media[$val['id']]=$val['temp_name'];
	}
	foreach($arList=explode(",",$lists) as $val){
		if($media[$val]==null)break;
		$media_list[] = $media[$val];
	}
	if(count($media_list)>0)
		return implode(',',$media_list);
	else 
		return 0;
}
//审核下拉选择框

function setAuditStatus($audit) {
    $audit_status=C('AUDIT_STATUS');
	$result = "";
	$selected = "";
	$result = "<select name=audit>";
	foreach ( $audit_status as $key => $value ) {
		if ($key == $audit) {
			$selected = "selected";
		}else
			$selected = "";
		
		$result .= "<option value=$key $selected > $value </option>";
	}
	$result .= "</select>";
	return $result;
}
//发布节目
function sendPublish($prog_id,$tablename,$attrname)
{
	$role = M($tablename);
	$res = $role->where('id='.$prog_id)->find();
	$prex = C('DB_PREFIX');
	$Model = new Model();
	$sql = "select id,temp_name from ".$prex."media where id IN (".$res[$attrname].") order by field(id,".$res[$attrname].")";
	$res = $Model->query($sql);
	foreach ($res as $val)
	{
		$play_list .="'../../data/".$val['temp_name']."',";
	}
	$play_info = 'var vList = ['.$play_list.'];';
	//$file = DOC_ROOT."/Log/play.js";
	$file = "/var/eadv/data/playList/play.js";
	file_put_contents($file,$play_info);

	$output = array ();
	$cmd = '/var/eadv/.bin/sendPlay.sh &';
	exec ( $cmd, $output );
	return true;
}
//输出json格式
function echo_json($code=0,$msg="sucess",$id=null)
{
	$arrayError=array("errcode"=>$code,"errmsg"=>$msg,"id"=>$id);
	$jsonStr=json_encode($arrayError);
	echo $jsonStr;
	exit;
}

 function https_request($url,$data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;

}
function my_file_get_contents($url){
	$opts = array( 
            'http'=>array( 
           'method'=>"GET", 
           'timeout'=>3, //设置超时
			) 
		); 
	$context = stream_context_create($opts); 
	$contents = @file_get_contents($url,false,$context); 
	return $contents;
}
function characet($data){

  if( !empty($data) ){

    $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;

    if( $fileType != 'UTF-8'){

      $data = mb_convert_encoding($data ,'utf-8' , $fileType);

    }

  }

  return $data;

}
//预览媒体素材

function preview_media($name)
{
	
	$type = end(explode('.', $name));
        if($type =="mp4")
        {
                $str='<video src="http://'.$_SERVER['SERVER_NAME'].__ROOT__.'/Public/upload/'.$name.'" width="320" height="200" controls preload></video>';
        }else
                $str='<img src="http://'.$_SERVER['SERVER_NAME'].__ROOT__.'/Public/upload/'.$name.'"  height=200 width=320 />';

        return $str;

}

//根据Id字符串得到素材名称，返回数组
function getMediaNameArray($id){
	//sql: select * from table where id IN (3,6,9,1,2,5,8,7) order by field(id,3,6,9,1,2,5,8,7); 
	$prex = C('DB_PREFIX');
	$Model = new Model();
	$sql = "select id,file_name from ".$prex."media where id IN (".$id.") order by field(id,".$id.")";
	
	$res = $Model->query($sql);
	return $res;
}
