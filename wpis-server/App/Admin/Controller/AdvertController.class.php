<?php
/*
 * @thinkphp3.2.3 
 * @wamp2.5  php5.5.12  mysql5.6.17
 * @Created on 2016/07/08
 * @Author
 */
namespace Admin\Controller;
use Think\Model;

class AdvertController extends BaseController {
	//显示广告统计图
 public function advertlists()
    {	
   		$xcoordinate=getCoordinateX('advertiser','contract');
   		$ycoordinate=getCoordinateY('count(*) as count','count','advertiser','contract');
    	$this->assign('xcoordinate',$xcoordinate);
    	$this->assign('ycoordinate',$ycoordinate);
    	$this->display('advertlists_table');
    } 
    //新增合同管理信息
    public function contractadd()
    {
    	$this->contractnum = date("Ymd-His",time());
    	$this->display('contractform');
    }
    //新增保存或修改保存合同管理信息
    public function contractupdate()
    {
    	$id =  isset($_POST['id']) ? $_POST['id'] : false;
    	$data['contractnum'] =  isset($_POST['contractnum']) ? $_POST['contractnum'] : '';
    	$data['name'] =  isset($_POST['name']) ? $_POST['name'] : '';
    	$data['type'] = isset($_POST['type']) ? $_POST['type'] : '';
    	$data['advertiser'] =  isset($_POST['advertiser']) ? $_POST['advertiser'] : '';
    	$data['contracts'] =  isset($_POST['contracts']) ? $_POST['contracts'] : '';
		$data['begindate'] =  isset($_POST['begindate']) ? strtotime($_POST['begindate']) : 0;
		$data['enddate'] =  isset($_POST['enddate']) ? strtotime($_POST['enddate']) : 0;
    	$data['sub_time']=time();
    	if ($id) {
    		$device_repair= M('contract')->where('id=' . $id)->data($data)->save();
    		if ($device_repair) {
    			$this->success('修改成功！',U('contractlists'));
    			exit(0);
    		} else {
    			$this->success('未修改内容');
    		}
    	} else {
    		M('contract')->data($data)->add();
    		$this->success('新增成功！');
    		exit(0);
    	}
    }
    //获取合同管理信息列表
    public function contractlists()
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
    	$count =  M('contract')->where($where)->count();
    	$cur_page = isset($_GET['page'])?$_GET['page']:1;
    	$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
    	$pages = $Page->show();
    	$device_repair = M('contract')->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
    	$this->assign('list', $device_repair);
    	$this->assign('pages',$pages);
    	$this->display();
    }
    //删除合同管理信息
    public function contractdel()
    {
    	$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
    	if (!$ids) {
    		$this->error('没选择要删除的合同管理信息 !');
    	}
    	if(is_array($ids)){
    		$where = 'id in('.implode(',',$ids).')';
    	}else{
    		$where = 'id='.$ids;
    	}
    	$role = M('contract');
    	$res = $role->where($where)->delete();
    	if($res)
    	{
    		$this->success('成功删除', U('contractlists'));
    	}
    	else
    		$this->error('删除失败');
    }
    //查看合同管理信息
    public function contractsee(){
    	$id = $this->_get('id');
    	$res = M('contract')->where(' id ='.$id)->find();
    	$this->assign('val',$res);
    	$this->display();  		
    }
    //修改合同管理信息
    public function contractedit(){
    	$id = $this->_get('id');
    	$res = M('contract')->where(' id ='.$id)->find();
    	$this->assign('val',$res);
    	$this->display();
    }  
}
