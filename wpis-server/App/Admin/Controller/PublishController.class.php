<?php
/*
 * @thinkphp3.2.3 
 * @wamp2.5  php5.5.12  mysql5.6.17
 * @Created on 2016/06/23
 * @Author  fengxp
 *
 */
namespace Admin\Controller;
use Think\Model;
//权限控制类
class PublishController extends BaseController {
	
	//已发布模版节目列表
	public function index()
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
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.temp_name from '
				.$prex.'publish_tpl as a, '.$prex.'layout as b where a.program_id=b.id and a.status<2 ';
		if(session('uid')==1)
		{
			//$sql=$sqltemp.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			$sql=$sqltemp;
		}
		else
		{
			//$sql=$sqltemp.'and device='.$device.' order by a.id desc limit '.$Page->firstRow.','.$Page->listRows;
			$sql=$sqltemp.'and device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	public function program(){
		$this->display();
	}
	//发布模版节目
	public function programtosave(){
		if(IS_POST){				
			$data['device'] = $this->_post('device');
			$data['program_id']= $this->_post('program');
			$data['begindate'] = $this->_post('begindate');
			$data['enddate'] = $this->_post('enddate');
			$data['rules'] = $this->_post('rules');
			$data['sub_time'] = time();
			$data['status'] = $prex = C('DEFAULT_PUBLISH_STATUS');
			$data['atonce'] = $this->_post('atonce');
		
			if(empty($data['device'])||empty($data['program_id']))
				$this->error('请选择设备或者模版节目');
			$role = M('publish_tpl');
			if($role->create($data)){
				if($role->add($data)){
					if($data['begindate']<=$data['enddate'])
					{
						getNowPush($data,0,3);
						$this->success('发布成功',U('index'));
					}
					else
					{
						$this->error('发布失败，开始日期不能大于结束日期');
					}					
				}else{
					$this->error('发布失败');
				}
			}else{
				$this->error($role->getError());
			}
		}	
		$this->display();
	}
	//模版列表
	public function proLists(){
		$display = $this->_post('display');
		$schedule = M('schedule');
		$timelists = $schedule->order('id asc')->select();
		$member['begindate'] = $member['enddate']=time();
		$week = date("w",time());
		$this->assign('timelists',$timelists);
		$this->assign('member',$member);
		$this->assign('week',$week);
		$this->assign('display',"none");
		
		$this->display("proLists");
	}
	//模版节目弹出框
	public function dialogproLists(){
    	$media = M('layout');
		$id = isset($_GET['id'])?$_GET['id']:0;
		$count = $media->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$list = $media->order('id desc')->where(searchLists($this->_get('keyword'),"sub_time","temp_name"))->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display("dialogproLists");
	}
	//查看发布模版节目详情
	public function see(){
		$Model = new Model();
		$id = isset($_GET['id'])?$_GET['id']:0;
		$prex = C('DB_PREFIX');
		$sql = 'select a.*,b.id as pid,b.temp_name from '.$prex.'publish_tpl as a, '.$prex.'layout as b where a.program_id=b.id and a.id='.$id;
	
		$list = $Model->query($sql);
		$this->assign('val',$list[0]);
		$this->display();
	}
	
	//已发布预定义信息 
	public function preinfoindex()
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
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.preinfonum,b.name from '
				.$prex.'publish_predefineinfo as a, '.$prex.'prog_predefineinfo as b where a.program_id=b.id and a.status<2 ';
		if(session('uid')==1)
		{
			$sql=$sqltemp;
		}
		else
		{
			$sql=$sqltemp.'and device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	
	
	public function preinfoprogram(){
		$this->display();
	}
	//发布预定义信息
	public function preinfoprogramtosave(){
		if(IS_POST){
			$data['device'] = $this->_post('device');
			$data['program_id']= $this->_post('program');
			$data['begindate'] = $this->_post('begindate');
			$data['enddate'] = $this->_post('enddate');
			$data['rules'] = $this->_post('rules');
			$data['sub_time'] = time();
			$data['status'] = $prex = C('DEFAULT_PUBLISH_STATUS');
			$data['atonce'] = $this->_post('atonce');
			$data['length' ]= 60;
			if(empty($data['device'])||empty($data['program_id']))
				$this->error('请选择设备或者预定义信息');
			$role = M('publish_predefineinfo');
			if($role->create($data)){
				if($role->add($data)){
					if($data['begindate']<=$data['enddate'])
					{
						getNowPush($data,0,6);
						$this->success('发布成功',U('preinfoindex'));
					}
					else
					{
						$this->error('发布失败，开始日期不能大于结束日期');
					}
				}else{
					$this->error('发布失败');
				}
			}else{
				$this->error($role->getError());
			}
		}
		$this->display();
	}
	//预定义信息列表
	public function preinfoproLists(){
		$display = $this->_post('display');
		$schedule = M('schedule');
		$timelists = $schedule->order('id asc')->select();
		$member['begindate'] = $member['enddate']=time();
		$week = date("w",time());
		$this->assign('timelists',$timelists);
		$this->assign('member',$member);
		$this->assign('week',$week);
		$this->assign('display',"none");
	
		$this->display("preinfoproLists");
	}
	//预定义信息弹出框
	public function preinfodialogproLists(){
		$media = M('prog_predefineinfo');
		$id = isset($_GET['id'])?$_GET['id']:0;
		$count = $media->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$list = $media->order('id desc')->where(searchLists($this->_get('keyword'),"sub_time","preinfonum"))->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display("preinfodialogproLists");
	}
	//查看发布预定义信息详情
	public function preinfosee(){
		$Model = new Model();
		$id = isset($_GET['id'])?$_GET['id']:0;
		$prex = C('DB_PREFIX');
		$sql = 'select a.*,b.id as pid,b.preinfonum from '.$prex.'publish_predefineinfo as a, '.$prex.'prog_predefineinfo as b where a.program_id=b.id and a.id='.$id;
	
		$list = $Model->query($sql);
		$this->assign('val',$list[0]);
		$this->display();
	}
	
	//已发布流媒体
	public function streamindex()
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
			$where = " and content LIKE '%$keyword%' order by ".$order ;
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
		$sqltemp='select id as pid,sub_time,status,content from '.$prex.'publish_stream where status<2 ';
		if(session('uid')==1)
		{
			$sql=$sqltemp;
		}
		else
		{
			$sql=$sqltemp.'and device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	public function streamprogram(){
		$this->display();
	}
	//发布流媒体
	public function streamprogramtosave(){
		if(IS_POST){
			$data['device'] = $this->_post('device');
			$data['program_id']= $this->_post('program');
			$data['begindate'] = $this->_post('begindate');
			$data['enddate'] = $this->_post('enddate');
			$data['rules'] = $this->_post('rules');
			$data['content'] = $this->_post('content');
			$data['sub_time'] = time();
			$data['status'] = $prex = C('DEFAULT_PUBLISH_STATUS');
			$data['atonce'] = $this->_post('atonce');

			if(empty($data['device'])||empty($data['content']))
				$this->error('请选择设备或者填写流媒体内容');
			$role = M('publish_stream');
			if($role->create($data)){
				if($role->add($data)){
					if($data['begindate']<=$data['enddate'])
					{
						getNowPush($data,0,5);
						$this->success('发布成功',U('streamindex'));
					}
					else
					{
						$this->error('发布失败，开始日期不能大于结束日期');
					}
				}else{
					$this->error('发布失败');
				}
			}else{
				$this->error($role->getError());
			}
		}
		$this->display();
	}
	//流媒体列表
	public function streamproLists(){
		$display = $this->_post('display');
		$schedule = M('schedule');
		$timelists = $schedule->order('id asc')->select();
		$member['begindate'] = $member['enddate']=time();
		$week = date("w",time());
		$this->assign('timelists',$timelists);
		$this->assign('member',$member);
		$this->assign('week',$week);
		$this->assign('display',"none");
	
		$this->display("streamproLists");
	}
//  流媒体弹出框(暂不需要)
// 	public function streamdialogproLists(){
// 		$stream = M('publish_stream');
// 		$id = isset($_GET['id'])?$_GET['id']:0;
// 		$count = $stream->count();
// 		$cur_page = isset($_GET['page'])?$_GET['page']:1;
// 		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
// 		$pages = $Page->show();
// 		$list = $stream->order('id desc')->where(searchLists($this->_get('keyword'),"sub_time","preinfonum"))->page($cur_page.','.C('DEFAULT_NUMS'))->select();
// 		$this->assign('lists',$list);
// 		$this->assign('pages',$pages);
// 		$this->assign('counts',$count);
// 		$this->display("streamdialogproLists");
// 	}
	//查看发布流媒体详情
	public function streamsee(){
		$Model = new Model();
		$id = isset($_GET['id'])?$_GET['id']:0;
		$prex = C('DB_PREFIX');
		$sql = 'select * from '.$prex.'publish_stream where id='.$id;
		$list = $Model->query($sql);
		$this->assign('val',$list[0]);
		$this->display();
	}
	
	//已发布视频节目列表
	public function videoindex()
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
			$count = $publish->where('status<2')->count();
		}
		else
		{
			$count = $publish->where('status<2 and device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$Model = new Model();
		$prex = C('DB_PREFIX');
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '
				.$prex.'publish_video as a, '.$prex.'prog_video as b where a.program_id=b.id and a.status<2';
		if(session('uid')==1)
		{
			$sql=$sqltemp;
		}
		else
		{
			$sql=$sqltemp.'and device='.$device;
		}		
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	public function videoprogram(){
		$this->display();
	}
	//发布视频节目
	public function videoprogramtosave(){
		if(IS_POST){
			$data['device'] = $this->_post('device');
			$data['program_id']= $this->_post('program');
			$data['begindate'] = $this->_post('begindate');
			$data['enddate'] = $this->_post('enddate');
			$data['rules'] = $this->_post('rules');
			$data['sub_time'] = time();
			$data['status'] = $prex = C('DEFAULT_PUBLISH_STATUS');
			$data['atonce'] = $this->_post('atonce');
			if(empty($data['device'])||empty($data['program_id']))
				$this->error('请选择设备或者视频节目');
			$role = M('publish_video');
			if($role->create($data)){
				if($role->add($data)){		
					if($data['begindate']<=$data['enddate'])
					{
						//sendPublish($data['program_id'],'prog_video','lists');
						getNowPush($data,0,2);
						$this->success('发布成功',U('videoindex'));
					}
					else
					{
						$this->error('发布失败，开始日期不能大于结束日期');
					}
				}else{
					$this->error('发布失败');
				}
			}else{
				$this->error($role->getError());
			}
		}
		$this->assign('display',"none");
		$this->display();
	}
	//视频节目单列表
	public function videoproLists(){
		$display = $this->_post('display');
		$schedule = M('schedule');
		$timelists = $schedule->order('id asc')->select();
		$member['begindate'] = $member['enddate']=time();
		$week = date("w",time());
		$this->assign('week',$week);
		$this->assign('member',$member);
		$this->assign('timelists',$timelists);
		$this->assign('display',"none");
		$this->display("videoproLists");
	}
	//视频节目弹出框
	public function videodialogproLists(){
		
		$media = M('prog_video');
		$id = isset($_GET['id'])?$_GET['id']:0;
		$count = $media->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$list = $media->order('id desc')->where(searchLists($this->_get('keyword'),"sub_time","name"))->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display("videodialogproLists");
	}
	//查看发布视频节目详情
	public function videosee(){
		$Model = new Model();
		$id = isset($_GET['id'])?$_GET['id']:0;
		$prex = C('DB_PREFIX');
		$sql = 'select a.*,b.id as pid,b.name from '.$prex.'publish_video as a, '.$prex.'prog_video as b where a.program_id=b.id and a.id='.$id;
	
		$list = $Model->query($sql);
		$this->assign('val',$list[0]);
		$this->display();
	}
	//已发布图片节目列表
	public function imgindex()
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
			$count = $publish->where('status<2')->count();
		}
		else
		{
			$count = $publish->where('status<2 and device='.$device)->count();
		}
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$Model = new Model();
		$prex = C('DB_PREFIX');
		$sqltemp='select a.id as pid,a.program_id,a.sub_time,a.status,b.id,b.name from '
				.$prex.'publish_img as a, '.$prex.'prog_img as b where a.program_id=b.id and a.status<2';
		if(session('uid')==1)
		{
			$sql=$sqltemp;
		}
		else
		{
			$sql=$sqltemp.'and device='.$device;
		}
		$list = $Model->query($sql.$where.' limit '.$Page->firstRow.','.$Page->listRows);
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display();
	}
	public function imgprogram(){
		$this->display();
	}
	//发布图片节目
	public function imgprogramtosave(){
		if(IS_POST){
	
			$data['device'] = $this->_post('device');
			$data['program_id']= $this->_post('program');
			$data['begindate'] = $this->_post('begindate');
			$data['enddate'] = $this->_post('enddate');
			$data['rules'] = $this->_post('rules');
			$data['sub_time'] = time();
			$data['status'] = $prex = C('DEFAULT_PUBLISH_STATUS');
			$data['atonce'] = $this->_post('atonce');
			if(empty($data['device'])||empty($data['program_id']))
				$this->error('请选择设备或者图片节目');
			$role = M('publish_img');
			if($role->create($data)){
				if($role->add($data)){
					if($data['begindate']<=$data['enddate'])
					{
					//sendPublish($data['program_id'],'prog_img','lists');
					getNowPush($data,0,1);
					$this->success('发布成功',U('imgindex'));
					}
					else
					{
						$this->error('发布失败，开始日期不能大于结束日期');
					}
				}else{
					$this->error('发布失败');
				}
			}else{
				$this->error($role->getError());
			}
		}
	
		$this->display();
	}
	//图片节目单列表
	public function imgproLists(){
	
		$display = $this->_post('display');
		$schedule = M('schedule');
		$timelists = $schedule->order('id asc')->select();
		$member['begindate'] = $member['enddate']=time();
		$week = date("w",time());
		$this->assign('week',$week);
		$this->assign('member',$member);
		$this->assign('timelists',$timelists);
		$this->assign('display',"none");
		$this->display("imgproLists");
	}
	//图片节目弹出框
	public function imgdialogproLists(){
	
		$media = M('prog_img');
		$id = isset($_GET['id'])?$_GET['id']:0;
		$count = $media->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$list = $media->order('id desc')->where(searchLists($this->_get('keyword'),"sub_time","name"))->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('lists',$list);
		$this->assign('pages',$pages);
		$this->assign('counts',$count);
		$this->display("imgdialogproLists");
	}
	//查看发布图片节目详情
	public function imgsee(){
		$Model = new Model();
		$id = isset($_GET['id'])?$_GET['id']:0;
		$prex = C('DB_PREFIX');
		$sql = 'select a.*,b.id as pid,b.name from '.$prex.'publish_img as a, '.$prex.'prog_img as b where a.program_id=b.id and a.id='.$id;
	
		$list = $Model->query($sql);
		$this->assign('val',$list[0]);
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

	public function device(){
		$this->display();
	}
	//删除发布节目详情
	public function delete_true(){
		$id = $this->_get('id');
		$role = M('publish');
		$res = $role->where('id='.$id)->delete();
		if($res){
			$this->success('成功删除');
		}else{
			$this->error('删除失败');
		}
    } 
    //假删除发布数据
    public function delete(){
    	$id = $this->_get('id');
    	$type = $this->_get('type');
    	if($type =='tpl')
    		$role = M('publish_tpl');
    	else if($type == 'img')
    		$role = M('publish_img');
    	else if($type == 'video')
    		$role = M('publish_video');
    
    	$data = array('del'=>time(),'status'=>3);
    	$res = $role-> where('id='.$id)->setField($data);
    	if($res){
    		$this->success('成功删除',U('index'));
    	}else{
    		$this->error('删除失败');
    	}
    }
    //删除发布节目详情(目前使用的)
    public function del_true()
    {
    	$type = $this->_get('type');
    	if($type =='tpl')
    	{
    		$role = M('publish_tpl');
    		$url = U('Log/program');
    		$messages='没选择要删除的模版日志 !';
    	}
    	if($type == 'img')
    	{
    		$role = M('publish_img');
    		$url = U('Log/imgprogram');
    		$messages='没选择要删除的图片日志 !';
    	}
    	if($type == 'video')
    	{
    		$role = M('publish_video');
    		$url = U('Log/videoprogram');
    		$messages='没选择要删除的视频日志 !';
    	}
    	if($type == 'preinfo')
    	{
    		$role = M('publish_predefineinfo');
    		$url = U('Log/preinfoprogram');
    		$messages='没选择要删除的预定义信息日志 !';
    	}
    	if($type == 'stream')
    	{
    		$role = M('publish_stream');
    		$url = U('Log/streamprogram');
    		$messages='没选择要删除的流媒体日志 !';
    	}
    	$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
    	if (!$ids) {
    		$this->error($messages);
    	}
    	if(is_array($ids)){
    		$where = 'id in('.implode(',',$ids).')';
    	}else{
    		$where = 'id='.$ids;
    	}
    	$res = $role->where($where)->delete();
    	if($res)
    	{
    		$this->success('成功删除',$url);
    	}
    	else
    		$this->error('删除失败');
    }
    //假删除发布数据(目前使用的)
    public function del()
    {
		$type = $this->_get('type');
		if($type =='tpl')
		{
			$role = M('publish_tpl');
			$url = U('index');
			$messages='没选择要删除的发布模版 !';
		}
		if($type == 'img')
		{
			$role = M('publish_img');
			$url = U('imgindex');
			$messages='没选择要删除的发布图片 !';
		}
		if($type == 'video')
		{
			$role = M('publish_video');
			$url = U('videoindex');
			$messages='没选择要删除的发布视频 !';
		}
		if($type == 'preinfo')
		{
			$role = M('publish_predefineinfo');
			$url = U('preinfoindex');
			$messages='没选择要删除的发布预定义信息 !';
		}
		if($type == 'stream')
		{
			$role = M('publish_stream');
			$url = U('streamindex');
			$messages='没选择要删除的发布流媒体 !';
		}
    	$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
    	if (!$ids) {
    		$this->error($messages);
    	}
    	if(is_array($ids)){
    		$where = 'id in('.implode(',',$ids).')';
    	}else{
    		$where = 'id='.$ids;
    	}
    	$data = array('del'=>time(),'status'=>3);
    	$res = $role-> where($where)->setField($data);
    	if($res)
    	{
    		$this->success('成功删除',$url);
    	}
    	else
    		$this->error('删除失败');
    }
	
   /**********************************以下是时间拖拽控件所需方法*******************************/
	public function datetimepick()
	{
		$date = $_GET['start'];
		$enddate = isset($_GET['end'])?$_GET['end']:"";
		echo $date;
		$this->display();
	}
	public function addform(){
		$date = $_GET['start'];
		$enddate = isset($_GET['end'])?$_GET['end']:"";
		if($date==$enddate) $enddate='';
		if(empty($enddate)){
			$display = 'style="display:none"';
			$enddate = $date;
			$chk = '';
		}else{
			$display = 'style=""';
			$chk = 'checked';
		}
		$enddate = empty($_GET['end'])?$date:$_GET['end'];
		$this->assign('date',$date);
		$this->assign('enddate',$enddate);
		$this->assign('display',$display);
		$this->assign('chk',$chk);
		$this->display();
	}
	public function addsuccess()
	{
//方式1:
		if(IS_POST){
			//表单提交
			$cs = M('calendar');
			$data['title'] =$this->_post('event');
			$data['starttime'] =$this->_post('startdate');
			$data['endtime'] =$this->_post('enddate');
			if(	$cs->create($data)){
				if($id=$cs->add()){
					$this->success('新增成功',U('datetimepick'));
				}else{
					$this->error('新增失败');
				}
			}else{
				$this->error($cs->getError().' [ <a href="javascript:history.back()">返 回</a> ]');
			}
		}else{
			$cs = M('calendar');
			$role_list = $cs->order('id desc')->select();
			$this->assign('lists',$role_list);
			$this->display();
		}
//方式2:			
// 		$events = mysql_real_escape_string(strip_tags($events), $link); //过滤HTML标签，并转义特殊字符	
// 		$isallday = $_POST['isallday']; //是否是全天事件
// 		$isend = isset($_POST['isend']) ? $_POST['isend'] : ""; //是否有结束时间
// 		$startdate = trim($_POST['startdate']); //开始日期
// 		$enddate = trim($_POST['enddate']); //结束日期	
// 		$s_time = $_POST['s_hour'] . ':' . $_POST['s_minute'] . ':00'; //开始时间
// 		$e_time = $_POST['e_hour'] . ':' . $_POST['e_minute'] . ':00'; //结束时间
// 		$endtime = 0;
// 		if ($isallday == 1 && $isend == 1) {
// 			$starttime = strtotime($startdate);
// 			$endtime = strtotime($enddate);
// 		} elseif ($isallday == 1 && $isend == "") {
// 			$starttime = strtotime($startdate);
// 		} elseif ($isallday == "" && $isend == 1) {
// 			$starttime = strtotime($startdate . ' ' . $s_time);
// 			$endtime = strtotime($enddate . ' ' . $e_time);
// 		} else {
// 			$starttime = strtotime($startdate . ' ' . $s_time);
// 		}	
// 		$colors = array("#360", "#f30", "#06c");
// 		$key = array_rand($colors);
// 		$color = $colors[$key];	
// 		$isallday = $isallday ? 1 : 0;
// 		$sql = "insert into calendar (title,starttime,endtime,allday,color) values ('$events','$starttime','$endtime','$isallday','$color')";
// 		$query = mysql_query($sql);
// 		if (mysql_insert_id() > 0) {
// 			echo '1';
// 		} else {
// 			echo '写入失败！';
// 		}

	}
	public function  myjson()
	{	
		$calendar = M('calendar');
		$query = $calendar->select();
		while ($row = mysql_fetch_array($query)) {
			$allday = $row['allday'];
			$is_allday = $allday == 1 ? true : false;	
			$data[] = array(
					'id' => $row['id'],
					'title' => $row['title'],
					'start' => date('Y-m-d H:i', $row['starttime']),
					'end' => date('Y-m-d H:i', $row['endtime']),
					//        'url' => $row['url'],
					'allDay' => $is_allday,
					'color' => $row['color']
			);
		}
		$this->assign('data',$data);
		$this->display("datetimepick");
	}
}