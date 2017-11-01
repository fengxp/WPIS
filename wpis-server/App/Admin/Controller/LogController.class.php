<?php
/*
 * @thinkphp3.2.3 
 * @wamp2.5  php5.5.12  mysql5.6.17
 * @Created on 2016/07/08
 * @Author  fengxp
 *
 */
namespace Admin\Controller;
use Think\Model;

class LogController extends BaseController {
	//已发布视频节目日志
	public function videoprogram()
	{
		$field   = isset($_GET['field']) ? $_GET['field'] : '';
		$keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
		$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
		$where   = '';
		if ($order == 'asc') {
			$order = " a.sub_time asc";
		} elseif ($order == 'desc') {
			$order = " a.sub_time desc";
		} else {
			$order = " a.id desc";
		}
		if ($keyword <> '') {
			$where = " and b.name LIKE '%$keyword%' order by ".$order ;
		}
		else 
		$where=" order by ".$order ;
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
		$publish = M('publish_video');
		if(session('uid')==1)
		{
			$count = $publish->count();
		}
		else
		{
			$count = $publish->where('device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$Model = new Model();
		$prex = C('DB_PREFIX');
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.del,a.status,b.id,b.name from '.$prex.'publish_video as a, '.$prex.'prog_video as b where a.program_id=b.id';
		if(session('uid')==1)
		{
			//$sql = 'select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '.$prex.'publish as a, '.$prex.'prog_video as b where a.program_id=b.id order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			//$sql=$sqltemp.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows
			$sql=$sqltemp;
		}
		else
		{
			//$sql = 'select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '.$prex.'publish as a, '.$prex.'prog_video as b where a.program_id=b.id and a.device='.$device.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			//$sql=$sqltemp.' and a.device='.$device.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			$sql=$sqltemp.' and a.device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	//已发布图片节目日志
	public function imgprogram()
	{
		$field   = isset($_GET['field']) ? $_GET['field'] : '';
		$keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
		$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
		$where   = '';
		if ($order == 'asc') {
			$order = " a.sub_time asc";
		} elseif ($order == 'desc') {
			$order = " a.sub_time desc";
		} else {
			$order = " a.id desc";
		}
		if ($keyword <> '') {
			$where = " and b.name LIKE '%$keyword%' order by ".$order ;
		}
		else 
		$where=" order by ".$order ;
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
		$publish = M('publish_img');
		if(session('uid')==1)
		{
			$count = $publish->count();
		}
		else
		{
			$count = $publish->where('device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$Model = new Model();
		$prex = C('DB_PREFIX');
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.del,a.status,b.id,b.name from '.$prex.'publish_img as a, '.$prex.'prog_img as b where a.program_id=b.id';
		if(session('uid')==1)
		{
			//$sql = 'select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '.$prex.'publish as a, '.$prex.'prog_img as b where a.program_id=b.id order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			//$sql=$sqltemp.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows
			$sql=$sqltemp;
		}
		else
		{
			//$sql = 'select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '.$prex.'publish as a, '.$prex.'prog_img as b where a.program_id=b.id and a.device='.$device.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			//$sql=$sqltemp.' and a.device='.$device.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			$sql=$sqltemp.' and a.device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	//已发布预定义信息日志
	public function preinfoprogram()
	{
		$field   = isset($_GET['field']) ? $_GET['field'] : '';
		$keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
		$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
		$where   = '';
		if ($order == 'asc') {
			$order = " a.sub_time asc";
		} elseif ($order == 'desc') {
			$order = " a.sub_time desc";
		} else {
			$order = " a.id desc";
		}
		if ($keyword <> '') {
			$where = " and b.name LIKE '%$keyword%' order by ".$order ;
		}
		else
			$where=" order by ".$order ;
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
		$publish = M('publish_predefineinfo');
		if(session('uid')==1)
		{
			$count = $publish->count();
		}
		else
		{
			$count = $publish->where('device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$Model = new Model();
		$prex = C('DB_PREFIX');
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.del,a.status,b.id,b.preinfonum,b.name from '.$prex.'publish_predefineinfo as a, '.$prex.'prog_predefineinfo as b where a.program_id=b.id';
		if(session('uid')==1)
		{
			//$sql = 'select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '.$prex.'publish as a, '.$prex.'prog_img as b where a.program_id=b.id order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			//$sql=$sqltemp.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows
			$sql=$sqltemp;
		}
		else
		{
			//$sql = 'select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '.$prex.'publish as a, '.$prex.'prog_img as b where a.program_id=b.id and a.device='.$device.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			//$sql=$sqltemp.' and a.device='.$device.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			$sql=$sqltemp.' and a.device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	//已发布流媒体日志
	public function streamprogram()
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
			$where = "  and content LIKE '%$keyword%' order by ".$order ;
		}
		else
			$where=" order by ".$order ;
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
		$publish = M('publish_stream');
		if(session('uid')==1)
		{
			$count = $publish->count();
		}
		else
		{
			$count = $publish->where('device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$Model = new Model();
		$prex = C('DB_PREFIX');
		$sqltemp='select id as pid,program_id,sub_time,del,status,content from '.$prex.'publish_stream where 1=1 ';
		if(session('uid')==1)
		{
			$sql=$sqltemp;
		}
		else
		{
			$sql=$sqltemp.' and device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	//已发布模版节目日志
	public function program()
	{
		$field   = isset($_GET['field']) ? $_GET['field'] : '';
		$keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
		$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
		$where   = '';
		if ($order == 'asc') {
			$order = " a.sub_time asc";
		} elseif ($order == 'desc') {
			$order = " a.sub_time desc";
		} else {
			$order = " a.id desc";
		}
		if ($keyword <> '') {
			$where = " and b.temp_name LIKE '%$keyword%' order by ".$order ;
		}
		else 
		$where=" order by ".$order ;
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
		$publish = M('publish_tpl');
		if(session('uid')==1)
		{
			$count = $publish->count();
		}
		else
		{
			$count = $publish->where('device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$Model = new Model();
		$prex = C('DB_PREFIX');
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.del,a.status,b.id,b.temp_name from '.$prex.'publish_tpl as a, '.$prex.'layout as b where a.program_id=b.id';
		if(session('uid')==1)
		{
			$sql=$sqltemp;
		}
		else
		{
			$sql=$sqltemp.' and a.device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	//发布信息日志
	public function info()
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
			$where = " and title LIKE '%$keyword%' " ;
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
		$model = M('info');
		if(session('uid')==1)
		{
			$count = $model->count();
		}
		else
		{
			$count = $model->where(' device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;	
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		if(session('uid')==1)
		{
			$sql=' 1=1 ';
		}
		else
		{
			$sql=' 1=1 and device='.$device;
		}
		$list = $model->where($sql.$where)->order($order)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	//已发布指令日志
	public function order()
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
			$count = $model->count();
		}
		else
		{
			$count = $model->where(' device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;	
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		if(session('uid')==1)
		{
			$sql=' 1=1 ';
		}
		else
		{
			$sql=' 1=1 and device='.$device;
		}
		$list = $model->where($sql)->order($order)->page($cur_page.','.C('DEFAULT_NUMS'))->select();

		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	//设备日志
	public function device(){
		
		$this->display();
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

			$this->display();
		}
			
	}
	
}
