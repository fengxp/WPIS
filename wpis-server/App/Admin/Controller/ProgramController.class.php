<?php
/**
 *
 * 版权所有：
 * 作    者：
 * 日    期：
 * 版    本：
 * 功能说明：节目单管理
 *
 **/

namespace Admin\Controller;
use Think\Model;
class ProgramController extends BaseController
{
	public $type = 0;
	public function videoLists()
	{
		$this->type = 1;
		$this->lists();
	}
	public function imgLists()
	{
		$this->type = 2;
		$this->lists();
	}
	//视频节目单
    public function lists()
    {
        $field   = isset($_GET['field']) ? $_GET['field'] : '';
        $keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
        $order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
        $where   = '';

        if ($order == 'asc') {
            $order = "sub_time asc";
        } elseif ($order == 'desc') {
            $order = "sub_time desc";
        } else {
            $order = "id desc";
        }
        if ($keyword <> '') {
            $where = " name LIKE '%$keyword%'";
        }
		if($this->type == 1)
			$media = M('prog_video');
		if($this->type == 2)
			$media = M('prog_img');

		$count = $media->where($where)->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$list = $media->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('list',$list);
		$this->assign('page',$pages);
		$this->assign('m_type',$this->type);
		$this->display('lists');
		

    }
    public function del()
    {
    	$m_type = $this->_get('m_type');
    	if($m_type == 1)
    	{
    		$role = M('prog_video');
    		$url = U('videoLists');
    	}
    	if($m_type == 2)
    	{
    		$role = M('prog_img');
    		$url = U('imgLists');
    	}
    	$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
    	if (!$ids) {
    		$this->error('没选择要删除的节目单!');
    	}
    	if(is_array($ids)){
    		$where = 'id in('.implode(',',$ids).')';
    	}else{
    		$where = 'id='.$ids;
    	}

    	$res = $role->where($where)->delete();
    	if($res)
    		$this->success('成功删除',$url);
    	else
    		$this->error('删除失败');
    }
	/**
	 * 删除
	 */
	public function delete($uid=NULL){
		$m_type = $this->_get('m_type');
		if($m_type == 1)
		{
			$role = M('prog_video');
			$url = U('videoLists');
		}
		if($m_type == 2)
		{
			$role = M('prog_img');
			$url = U('imgLists');
		}
		$id = empty($uid) ? $this->_get('id') : $uid;
		$res = $role->where('id='.$id)->delete();	
		if($res){
			$this->success('成功删除',$url);
		}else{
			$this->error('删除失败');
		}
	}

    
    /* 新增 */
	public function add() {
		$m_type = $this->_request('m_type');
		if($m_type == 1)
		{
				$program = D('prog_video');
				$this->type = 1;
				$url = U('videoLists');
		}
		if($m_type == 2)
		{
				$program = D('prog_img');
				$this->type = 2;
				$url = U('imgLists');
		}
		if(IS_POST){
			//表单提交
			$data['name']=$this->_post('ProgName'); //.'_'.date("Ymdhis");
			$data['lists']=$this->_post('ids');
			$data['sub_time']=time();
			
			if(	$program->create($data)){
				if($id=$program->add($data)){
					$this->success('新增成功',$url);
				}else{
					$this->error('新增失败');
				}
			}else{
				$this->error($program->getError().' [ <a href="javascript:history.back()">返 回</a> ]');
			}
		}else{

			$time=date(DATE_RFC822);
			$this->name = date("Ymd-His",time());
			$this->assign('m_type',$this->type);
			$this->display ();
		}
	}
	
	public function mediaList() {
		$m_type = $this->_get('m_type');
		if($m_type == 1)
			$where = "type = 'mp4' and auditstatus='审核通过'";
		if($m_type == 2)
			$where = "attr != '4' and type !='mp4' and auditstatus='审核通过' ";
		$media = M('media');
		$count = $media->where($where)->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$list = $media->where($where)->order('id desc')->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->mpList = $list;
		$this->assign('page',$pages);
		$this->display('mediaList');
	}
	
	/**
	* 
	*/
	public function see(){
		$m_type = $this->_get('m_type');
		if($m_type == 1)
			$role = M('prog_video');
		if($m_type == 2)
			$role = M('prog_img');
		$id = $this->_get('id');
		$res = $role->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->imgList = getMediaNameArray($res['lists']);
		$this->display();
			
	}
	public function publishsee(){
		$m_type = $this->_get('m_type');
		if($m_type == 2)
			$role = M('prog_video');
		if($m_type == 1)
			$role = M('prog_img');
		$id = $this->_get('id');
		$res = $role->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->imgList = getMediaNameArray($res['lists']);
		$this->display();
			
	}
	//预定义信息
	public function preinfoadd()
	{
		$attr = $this->_get('attr');
		$this->preinfonum = date("Ymd-His",time());
		$this->assign('attr',$attr);
		$this->display('preinfoform');
	}
	public function preinfoupdate()
	{
		$id =  isset($_POST['id']) ? $_POST['id'] : false;
		$data['preinfonum'] =  isset($_POST['preinfonum']) ? $_POST['preinfonum'] : '';
		$data['name'] =  isset($_POST['name']) ? $_POST['name'] : '';
		$data['type'] = isset($_POST['type']) ? $_POST['type'] : '';
		$data['content'] =  isset($_POST['content']) ? $_POST['content'] : '';
		$data['sub_time']=time();

		if ($id) {
			$device_repair= M('prog_predefineinfo')->where('id=' . $id)->data($data)->save();
			if ($device_repair) {
					$this->success('修改成功！',U('preinfolists'));
					exit(0);
			} else {
				$this->success('未修改内容');
			}
		} else {
				M('prog_predefineinfo')->data($data)->add();
				$this->success('新增成功！');
				exit(0);
		}
	}
	public function preinfolists()
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
		$count =  M('prog_predefineinfo')->where($where)->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
		$pages = $Page->show();
		$device_repair = M('prog_predefineinfo')->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
		$this->assign('list', $device_repair);
		$this->assign('pages',$pages);
		$this->display();
	}
	
	public function preinfodel()
	{
	
		$ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
		if (!$ids) {
			$this->error('没选择要删除的预定义信息 !');
		}
		if(is_array($ids)){
			$where = 'id in('.implode(',',$ids).')';
		}else{
			$where = 'id='.$ids;
		}
		$role = M('prog_predefineinfo');
		$res = $role->where($where)->delete();
		if($res)
		{
			$this->success('成功删除', U('preinfolists'));
		}
		else
			$this->error('删除失败');
	}
	public function preinfosee(){
	
		$id = $this->_get('id');
		$res = M('prog_predefineinfo')->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->display();
			
	}
	public function preinfoedit(){
	
		$id = $this->_get('id');
		$res = M('prog_predefineinfo')->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->display();
			
	}
	
}