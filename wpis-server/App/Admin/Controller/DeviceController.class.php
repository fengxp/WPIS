<?php
/*
 * @thinkphp3.2.3 
 * @wamp2.5  php5.5.12  mysql5.6.17
 * @Created on 2016/06/12
 * @Author  fengxp
 *
 */
namespace Admin\Controller;
use Think\Model;

//权限控制类
class DeviceController extends BaseController {
	//列表
	public function lists(){		
		$this->display();
	}
	//维修管理新增
	public function repairadd()
	{
		$this->repairnum = date("Ymd-His",time());
		$this->display('repairform');
	}
	
	public function repairupdate()
	{
			$id =  isset($_POST['id']) ? $_POST['id'] : false;
			$data['repairnum'] =  isset($_POST['repairnum']) ? $_POST['repairnum'] : '';
			$data['name'] =  isset($_POST['name']) ? $_POST['name'] : '';
			$data['repairer'] =  isset($_POST['repairer']) ? $_POST['repairer'] : '';
			$data['begindate'] =  isset($_POST['begindate']) ? strtotime($_POST['begindate']) : 0;
			$data['enddate'] =  isset($_POST['enddate']) ? strtotime($_POST['enddate']) : 0;
			$data['device'] =  isset($_POST['device']) ? $_POST['device'] : '';
			$data['sub_time']=time();
			$data['count']=1;
			echo $id;
			exit;
			if ($id) {	
				$device=explode(',',$data['device']);
				for($index=0;$index<count($device);$index++){
					if($index==0 && $device[$index]!=1)
						$data['device']='1,'.$data['device'];
				}
				$device_repair= M('device_repair')->where('id=' . $id)->data($data)->save();
				if ($device_repair) {
					if($data['begindate']<=$data['enddate'])
					{
					$this->success('修改成功！',U('repairlists'));
					exit(0);
					}
					else
					{
						$this->error('修改失败，开始日期不能大于结束日期');
					}

				} else {
					$this->success('未修改内容');
				}
			} else {
				if($data['begindate']<=$data['enddate'])
				{
				M('device_repair')->data($data)->add();
				$this->success('新增成功！');
				exit(0);
				}
				else
				{
					$this->error('新增失败，开始日期不能大于结束日期');
				}
			}	
	}
	
	public function repairlists()
	{
		$field   = isset($_GET['field']) ? $_GET['field'] : '';
		$keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
		$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
		$where   = '';
		if ($order == 'asc') {
			$order = " sub_time asc";
		} elseif ($order == 'desc') {
			$order = " sub_time desc";
		} else {
			$order = " id desc";
		}
		if ($keyword <> '') {
			$where = " name LIKE '%$keyword%' " ;
		}
		$count =  M('device_repair')->where($where)->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$device_repair = M('device_repair')->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('list', $device_repair);
		$this->assign('pages',$pages);
		$this->display();
	}
	public function repairedit(){

		$id = $this->_get('id');
		$res = M('device_repair')->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->display();
			
	}
	
	public function repairsee(){
	
		$id = $this->_get('id');
		$res = M('device_repair')->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->display();
			
	}
	public function repairdel()
	{
	
		$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
		if (!$ids) {
			$this->error('没选择要删除的维修单 !');
		}
		if(is_array($ids)){
			$where = 'id in('.implode(',',$ids).')';
		}else{
			$where = 'id='.$ids;
		}
		$role = M('device_repair');
		$res = $role->where($where)->delete();
		if($res)
		{
			$this->success('成功删除', U('repairlists'));
		}
		else
			$this->error('删除失败');
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
	public function deviceInfo(){
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
		
		$this->display("deviceInfo");
			
	}
	/**
	* 修改设备设备详细信息
	*/
	public function device_edit(){
	
		if(IS_POST){
			//表单提交
			$device = M('device');		
			$data['id'] = $this->_post('id');
			$data['name'] = $this->_post('name');
			$data['type'] = $this->_post('type');
			$data['submit_time'] =time();
			if(empty($data['name'])){
				$this->error('请输入名称');
			}
			if(	$device->create($data)){
				if($device->save() >=0 ){
					if($data['type'] == 1)
					{
						$this->assign('jumpUrl', 'javascript:window.parent.location.reload();');
						$this->success('提交成功');
					}else{
						$device_info = M('device_info');
						$id=$data['id'];
						$data_info['name']=$this->_post('name');
						$data_info['addr1']=$this->_post('addr1');
						$data_info['addr2']=$this->_post('addr2');
						$data_info['mac']=$this->_post('mac');
						$res=$device_info->where('id='.$id)->save($data_info);
						$this->assign('jumpUrl', 'javascript:window.parent.location.reload();');
						$this->success('提交成功');
// 						if($res==0){
// 							$this->assign('jumpUrl', 'javascript:window.parent.location.reload();');
// 							$this->success('提交成功');
// 						}else{
// 							$this->error('修改失败！');
// 						}
						
					}
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($admin_user->getError().' [ <a href="javascript:history.back()">返 回</a> ]');
			}
			
		}
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
		
		$this->display();
			
	}
	/**
	 * 删除
	 */
	public function device_del(){
		$id = $this->_get('id');
		$type = $this->_get('type');
		$role = M('device');
		if($type == 0){
			$role1 = M('device_info');
			$res = $role->where('id='.$id)->delete();
			$res1 = $role1->where('id='.$id)->delete();
			if($res && $res1){
				$this->assign('jumpUrl', 'javascript:window.parent.location.reload();');
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}else{
			$res = $role->where('p_id='.$id)->find();
			if($res)
			{
				$this->error('包含设备的节点不能被删除');
			}else{
				$res = $role->where('id='.$id)->delete();
				if($res){
					$this->assign('jumpUrl', 'javascript:window.parent.location.reload();');
					$this->success('删除成功');
				}else{
					$this->error('删除失败');
				}
			}
		
		}
	}
	/**
	 * 新增设备
	 */
	public function device_add(){
		$id = $this->_get('id');
		if(IS_POST){
			$device = M('device');
			$data['p_id'] = $this->_post('id');
			$data['name'] = $this->_post('name');
			$data['type'] = $this->_post('myselect');
			$data['sub_time'] = time();
			if(empty($data['name'])){
				$this->error('请输入名称');
			}
			if(	$device->create($data)){
				$id = $device->add();
				if( $id>0 ){
					if($data['type'] == 1)
					{
						$this->assign('jumpUrl', 'javascript:window.parent.location.reload();');
						$this->success('提交成功');
					}else{
						$device_info = M('device_info');
						$data_info['id'] = $id;
						$data_info['name']=$this->_post('name');
						$data_info['addr1']=$this->_post('addr1');
						$data_info['addr2']=$this->_post('addr2');
						$data_info['mac']=$this->_post('mac');
						$res=$device_info->add($data_info);
						if($res){
							$this->assign('jumpUrl', 'javascript:window.parent.location.reload();');
							$this->success('提交成功');
						}else{
							$this->error('增加失败！');
						}
					}
					
				}else{
					$this->error('增加失败');
				}
			}else{
				$this->error($admin_user->getError().' [ <a href="javascript:history.back()">返 回</a> ]');
			}
		}
		$this->assign('id',$id);
 		$this->display();
	}
	
}