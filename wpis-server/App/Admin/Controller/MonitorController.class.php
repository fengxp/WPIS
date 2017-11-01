<?php
/*
 * @thinkphp3.2.3 
 * @wamp2.5  php5.5.12  mysql5.6.17
 * @Created on 2016/07/08
 * @Author
 */
namespace Admin\Controller;
use Think\Model;

class MonitorController extends BaseController {
    //新增合同管理信息
    public function net()
    {
    	$role = M('Device');
    	$deviceinfo=M('Device_info');
    	$auth_group_access = M('auth_group_access');
    	$auth_group = M('auth_group');
    	$auth_group_access_data = $auth_group_access->where( ' uid ='.session('uid'))->select();
    	foreach ($auth_group_access_data as $k=>$v){
    		$group_id=$v['group_id'];
    		$auth_group_data = $auth_group->where(' id = '.$group_id)->select();
    		foreach ($auth_group_data as $k=>$v1){
    			$device=explode(',',$v1['device']);
    			for($index=0;$index<count($device);$index++){
    				if($index==0 && $device[$index]!=1)
    					$temp_device.='1,';
    				if($index==(count($device)-1))
    					$temp_device.=$device[$index];
    				else
    					$temp_device.=$device[$index].',';
    			}
    		}
    	}
    	if(session('uid')==1)
    		$res = $role->select();
    	else
    		$res = $role->where(' id in ('.$temp_device.') ')->select();
    	
    	foreach($res as $value){
			$temp.=$value['id'];
			if($value['type']==0)
			{
				setDeviceStatus($value['id'],'cpu','memory','diskpercent','status','device','device_info');
			}   		
    	}
    	$this->display('netdevicelists');
    	
    }
    /**
     * 获取设备列表
     */
    public function getDevice(){
    
    	$role = M('Device');
    	$auth_group_access = M('auth_group_access');
    	$auth_group = M('auth_group');
    	$auth_group_access_data = $auth_group_access->where( ' uid ='.session('uid'))->select();
    	foreach ($auth_group_access_data as $k=>$v){
    		$group_id=$v['group_id'];
    		$auth_group_data = $auth_group->where(' id = '.$group_id)->select();
    		foreach ($auth_group_data as $k=>$v1){
    			$device=explode(',',$v1['device']);
    			for($index=0;$index<count($device);$index++){
    				if($index==0 && $device[$index]!=1)
    					$temp_device.='1,';
    				if($index==(count($device)-1))
    					$temp_device.=$device[$index];
    				else
    					$temp_device.=$device[$index].',';
    			}
    		}
    	}
    	if(session('uid')==1)
    		$res = $role->select();
    	else
    		$res = $role->where(' id in ('.$temp_device.') ')->select();
    	echo json_encode($res);
    	exit;
    }
    /**
     * 设备详细信息
     */
    public function netdeviceInfo(){
    	$id = $this->_get('id');
    	$type = $this->_get('type');
    	if($type == 0)
    	{
    		$prex = C('DB_PREFIX');
    		$Model = new Model();
    		$sql = "select a.*,b.* from ".$prex."device as a,".$prex."device_info as b where a.id=$id and b.id=$id";
    		$res = $Model->query($sql);
    		$this->assign('val',$res[0]);
    		$this->assign('display','none');
    	}else
    	{
    		$role = M('device');
    		$res = $role->where('id='.$id)->find();
    		$this->assign('val',$res);
    		$this->assign('hidden','none');
    	}
    	$this->display("netdeviceInfo"); 		
    }
    //监视
    public function monitor()
    {
    	$this->display('monitordevicelists');
    }
    public function monitordeviceInfo(){
    	$this->display('monitordeviceInfo');
    }
    //文件下载进度
    public function file()
    {
    	$this->display('fileprogressdevicelists');
    }
    public function fileprogressdeviceInfo(){
    	$id   = isset($_GET['id']) ? $_GET['id'] : '';
    	$field   = isset($_GET['field']) ? $_GET['field'] : '';
    	$keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
    	$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
    	$where   = ' device= '.$id;
    	

//     	if ($order == 'asc') {
//     		$order = " sub_time asc";
//     	} elseif ($order == 'desc') {
//     		$order = " sub_time desc";
//     	} else {
//     		$order = " id desc";
//     	}
//     	if ($keyword <> '') {
//     		$where = " filename LIKE '%$keyword%' order by ".$order ;
//     	}
//     	else
//     		$where=" order by ".$order ;
    	if ($keyword <> '') {
    		$where .= " and filename LIKE '%$keyword%'";
    	}
    	$file=M('monitor_file');
    	$lists = $file->where($where)->select();
    	$this->assign('list', $lists);
    	$this->display('fileprogressdeviceInfo');
    }
}
