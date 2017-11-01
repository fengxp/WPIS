<?php
/*
 * @thinkphp3.2.3 
 * @wamp2.5  php5.5.12  mysql5.6.17
 * @Created on 2016/06/04
 * @Author  fengxp
 *
 */
namespace Admin\Controller;
use Think\Controller;
//权限控制类
class PublicController extends Controller {
	
	/**
	 * 查看
	 */
	public function see(){
		isset($_GET['id'])?$id = $_GET['id'] : $id=0;
		$role = M('temp_info');
		
		$res = $role->where('info_id='.$id)->find();
		$this->assign('val',$res);
		$this->display();
			
	}
	public function seeInform(){
		isset($_GET['id'])?$id = $_GET['id'] : $id=0;
		$role = M('temp_info');
		
		$res = $role->where('info_id='.$id)->find();
		$this->assign('val',$res);
		$this->display(seeInform);
			
	}
	public function bind(){
		isset($_GET['id'])?$id = $_GET['id'] : $id=0;
		
		$this->display();
			
	}
}