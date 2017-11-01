<?php
/*
 * @thinkphp3.2.3 
 * @wamp2.5  php5.5.12  mysql5.6.17
 * @Created on 2016/06/24
 * @Author  fengxp
 *
 */
namespace Admin\Controller;
use Think\Model;

class OrderController extends BaseController {
	
	//已发布列表
	public function index()
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
			$where = " and type LIKE '%$keyword%' ";
		}
		$auth_group_access = M('auth_group_access');
		$auth_group = M('auth_group');
		$auth_group_access_data = $auth_group_access->where( ' uid ='.session('uid'))->select();
		foreach ($auth_group_access_data as $k=>$v){
			$group_id=$v['group_id'];
			$auth_group_data = $auth_group->where(' id = '.$group_id)->select();
			foreach ($auth_group_data as $k=>$v){
				if(strstr($v['device'],"1,") && (stripos($v['device'],"1,")==0))
				$device='"'.$v['device'].'"';
				else 
				$device='"1,'.$v['device'].'"';
			}
		}
		$model = M('order');	
		if(session('uid')==1)
		{
			$count = $model->where('status<2')->count();
		}
		else
		{
			$count = $model->where('status<2 and device='.$device)->count();
		}
		
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		if(session('uid')==1)
		{
			$sql='status<2 ';
		}
		else
		{
			$sql='device='.$device.' and status<2 ';
		}
		
		$list = $model->order($order)->where($sql)->page($cur_page.','.C('DEFAULT_NUMS'))->select();

		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	public function add(){
		
		$this->display();
	}
	/**
	* 增加发布信息
	*/
	public function save(){
		if(IS_POST){
			$data['device'] = $this->_post('device');
			$data['type' ]= $this->_post('type');
			$data['sub_time'] = time();
			$data['status'] = $prex = C('DEFAULT_PUBLISH_STATUS');
			$data['atonce'] = $this->_post('atonce');
			if(empty($data['device']))
				$this->error('请选择设备');
			$role = M('order');
			$url=U('index');
			if($role->create($data)){
				if($role->add($data)){
					infoPush2($data,0,4);
					$this->success('发布成功',U('index'));
				}else{
					
				}
			}else{
				$this->error($role->getError());
			}
			
		}
		$this->display();
	}
	/**
	* 获取设备列表
	*/
	public function getDevice(){
		
		$role = M('Device');
		$res = $role->select();
		echo json_encode($res);
		exit;
	}
	/**
	* 显示设备树
	*/
	public function device(){
		$this->display();
	}
	//查看发布详情
	public function see(){
		
		$Model = new Model();
		$id = isset($_GET['id'])?$_GET['id']:0;
		$role = M('order');
		$res = $role->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->display();
	}

    public function del_true()
    {
    	 
    	$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
    	if (!$ids) {
    	$this->error('没选择要删除的指令日志 !');
    	}
    	if(is_array($ids)){
    		$where = 'id in('.implode(',',$ids).')';
    	}else{
    		$where = 'id='.$ids;
    	}
    	$role = M('order');
    	$res = $role->where($where)->delete();
    	if($res)
    	{
    		$this->success('成功删除', U('Log/order'));
    	}
    	else
    		$this->error('删除失败');
    }
    public function del()
    {
    	$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
    	if (!$ids) {
    		$this->error('没选择要删除的发布指令!');
    	}
    	if(is_array($ids)){
    		$where = 'id in('.implode(',',$ids).')';
    	}else{
    		$where = 'id='.$ids;
    	}
    	$role = M('order');
    	$data = array('del'=>time(),'status'=>3);
    	$res = $role-> where($where)->setField($data);
    	//$res = $role->where($where)->delete();
    	if($res)
    		$this->success('成功删除',U('index'));
    	else
    		$this->error('删除失败');
    }
	//假删除发布数据
	public function delete(){
		$id = $this->_get('id');
		$role = M('order');
		
		$data = array('del'=>time(),'status'=>3);
		$res = $role-> where('id='.$id)->setField($data);
		if($res){	
			$this->success('成功删除',U('index'));
		}else{
			$this->error('删除失败');
		}
    }
    //删除发布详情
    public function delete_true(){
    	$id = $this->_get('id');
    	$role = M('order');
    	$res = $role->where('id='.$id)->delete();
    	if($res){
    		$this->success('成功删除');
    	}else{
    		$this->error('删除失败');
    	}
    }
 
}
