<?php
/**
 *
 * 版权所有：
 * 作    者：
 * 日    期：
 * 版    本：
 * 功能说明：模板管理
 *
 **/

namespace Admin\Controller;
use Think\Model;
class TempletController extends BaseController
{
    public function lists()
    {
        $field   = isset($_GET['field']) ? $_GET['field'] : '';
        $keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
        $order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
		$type    = isset($_GET['type']) ? $_GET['type'] : '';
        $where   = '';


        if ($order == 'asc') {
            $order = "sub_time asc";
        } elseif ($order == 'desc') {
            $order = "sub_time desc";
        } else {
            $order = "id desc";
        }
        if ($keyword <> '') {
            $where = "temp_name LIKE '%$keyword%'";
        }


        $media = M('layout');
		$count = $media->where($where)->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		if(empty($type)){
			$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
			$pages = $Page->show();
			$list = $media->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
			$this->assign('list',$list);
			$this->assign('page',$pages);
			$this->display();
		}else
		{
			$Page = new \Think\Page($count,C('DEFAULT_NUMS_TABLE')); //实例化page对象
			$pages = $Page->show();
			$list = $media->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS_TABLE'))->select();
			$this->assign('list',$list);
			$this->assign('page',$pages);
			$this->display('lists_table');
		}

    }

    public function del()
    {

        $ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
        if (!$ids) {
        	$this->error('没选择要删除的模版!');
        }
        //判断id是数组还是一个数值
		if(is_array($ids)){
			$where = 'id in('.implode(',',$ids).')';
		}else{
			$where = 'id='.$ids;
		} 
		$role = M('layout');
		$res = $role->where($where)->delete();
		if($res)
			$this->success('成功删除',U('lists'));
		else
			$this->error('删除失败');
    }
	/**
	 * 删除
	 */
	public function delete($uid=NULL){
		$id = empty($uid) ? $this->_get('id') : $uid;
		$role = M('layout');
		$res = $role->where('id='.$id)->delete();
		
		if($res){
			$this->success('成功删除',U('lists'));
		}else{
			$this->error('删除失败');
		}
		
	}

    public function edit()
    {

        if(IS_POST){
			//表单提交
			$role = M('layout');
			$data['id']=$this->_post('id');
			$data['temp_name']=$this->_post('TempName');
			$data['temp_width']=$this->_post('width');
			$data['temp_height']=$this->_post('height');
			if(empty($data['temp_name'])){
				$this->error('名称为空');
			}
			if($role->create($data)){
				if($role->save($data)>=0){
					$this->success('更新成功',U('lists'));
				}else{
					$this->error('更新失败');
				}
			}else{
				$this->error("创建失败");
			}
		}
		else{
			$role = M('layout');
			$id = $this->_get('id');
		
			$prex = C('DB_PREFIX');
			$Model = new Model();
			$sql = "select a.*,b.file_name from ".$prex."layout as a,".$prex."media as b where a.id=$id and b.id=a.temp_bg";
			$res = $Model->query($sql);
			$this->assign('val',$res[0]);
			$this->display('edit');
		}
    }

    /* 新增布局 */
	public function add() {
		$time=date(DATE_RFC822);
		$this->name = date("Ymd-His",time());
		$this->width = 1024;
		$this->height = 768;
		
		$this->display ();
	}
	/* 字幕设置*/
	public function infoConf() {
		$info_id=$this->_get('info');
		$this->info_id = $info_id;
		
		$this->display ();
	}
	/* 图片设置*/
	public function imgConf() {
		$info_type=$this->_get('type');
		$this->infoType = $info_type;
		
		$this->display ();
	}
	/* 布局 */
	public function layout() {
		$tmp_name=$this->_post('TempName');
		$bg_id=$this->_post('bg_id');
		$bg_name=$this->_post('bg_name');
		$tmp_width=$this->_post('width');
		$tmp_height=$this->_post('height');
		
		if( empty($tmp_name) || empty($bg_id) || empty($tmp_width) || empty($tmp_height) )
		{
			$this->error('参数错误');
		}
		$this->TempName = $tmp_name;
		$this->bg_name = $bg_name;
		$this->bg_id = $bg_id;
		$this->width = $tmp_width;
		$this->height = $tmp_height;
		$this->display ('layout');
	}
	/* 保存布局 */
	public function layout_save() {
		$data['temp_name']		= $this->_post('TempName');
		$data['temp_bg']		= $this->_post('bg_id');
		//$data['bg_name']		= $this->_post('bg_name');
		$data['temp_width']		= $this->_post('bg_width');
		$data['temp_height']	= $this->_post('bg_height');
		$data['img_info']		= $this->_post('img_val');
		$data['video_info']		= $this->_post('video_val');
		$data['sub_time']		= time();
		$data['ats_info']		= $this->_post('ats_val');
		$data['weather_info']	= $this->_post('weather_val');
		$data['info1_info']		= $this->_post('info1_val');
		$data['info2_info']		= $this->_post('info2_val');
		$data['info3_info']		= $this->_post('info3_val');
		$data['info1_txt']		= $this->_post('info1_txt');
		$data['info2_txt']		= $this->_post('info2_txt');
		$data['info3_txt']		= $this->_post('info3_txt');

		$role = M ('layout');
		if($role->create($data)){
			if($role->add($data))
				$this->success('设置成功',U('lists'));
			else
				$this->error('设置失败！');
		}else
			$this->error($role->getError());
		
	}
	/**
	* 预览
	*/
	public function see(){
		
		$role = M('layout');
		$id = $this->_get('id');
	
		$prex = C('DB_PREFIX');
		$Model = new Model();
		$sql = "select a.*,b.temp_name from ".$prex."layout as a,".$prex."media as b where a.id=$id and b.id=a.temp_bg";
		//echo $sql;
		$res = $Model->query($sql);
		$this->assign('val',$res[0]);

		import("Library.Layout");
		$layout = new \Layout();
		$this->assign('divStr',$layout->getLayout($res[0]));

		$this->display();
			
	}
	public function publishsee(){
	
		$role = M('layout');
		$id = $this->_get('id');
	
		$prex = C('DB_PREFIX');
		$Model = new Model();
		$sql = "select a.*,b.temp_name from ".$prex."layout as a,".$prex."media as b where a.id=$id and b.id=a.temp_bg";
		//echo $sql;
		$res = $Model->query($sql);
		$this->assign('val',$res[0]);
	
		import("Library.Layout");
		$layout = new \Layout();
		$this->assign('divStr',$layout->getLayout($res[0]));
	
		$this->display();
			
	}
	//背景
	public function bg()
    {
        $field   = isset($_GET['field']) ? $this->_get['field'] : '';
        $keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
        $order   = isset($_GET['order']) ? $this->_get['order'] : 'DESC';
		$type    = isset($_GET['type']) ? $this->_get['type'] : '';
        $where   = ' attr=4 and auditstatus="审核通过" ';

        if ($order == 'asc') {
            $order = "sub_time asc";
        } elseif ($order == 'desc') {
            $order = "sub_time desc";
        } else {
            $order = "id desc";
        }
        if ($keyword <> '') {
                $where .= " and file_name LIKE '%$keyword%'";
        }
        
        $media = M('media');
		$count = $media->where($where)->count();
		$cur_page = isset($_GET['page'])?$_GET['page']:1;
		if(empty($type)){
			$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
			$pages = $Page->show();
			$list = $media->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
			$this->assign('list',$list);
			$this->assign('page',$pages);
			$this->display();
		}else
		{
			$Page = new \Think\Page($count,C('DEFAULT_NUMS_TABLE')); //实例化page对象
			$pages = $Page->show();
			$list = $media->order($order)->where($where)->page($cur_page.','.C('DEFAULT_NUMS_TABLE'))->select();
			$this->assign('list',$list);
			$this->assign('page',$pages);
			$this->display();
		}

    }

}