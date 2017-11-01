<?php
/**
 *
 * 版权所有：
 * 作    者：
 * 日    期：
 * 版    本：
 * 功能说明：素材管理
 *
 **/

namespace Admin\Controller;

class MediaController extends BaseController
{
	//素材列表
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
                $where = "file_name LIKE '%$keyword%'";
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
			$this->display('lists_table');
		}

    }
	//未审核素材列表
    public function auditlists()
    {
    	$field   = isset($_GET['field']) ? $_GET['field'] : '';
    	$keyword = isset($_GET['keyword']) ? $this->_get('keyword') : '';
    	$order   = isset($_GET['order']) ? $_GET['order'] : 'DESC';
    	$type    = isset($_GET['type']) ? $_GET['type'] : '';
    	$where   = ' auditstatus!="审核通过" ';
    
    
    	if ($order == 'asc') {
    		$order = "sub_time asc";
    	} elseif ($order == 'desc') {
    		$order = "sub_time desc";
    	} else {
    		$order = "id desc";
    	}
    	if ($keyword <> '') {
    		$where = $where." and file_name LIKE '%$keyword%'";
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
    		$this->display('auditlists_table');
    	}
    
    }
    public function auditsee()
    {
    	$role = M('media');
    	$id = $this->_get('id');
    	$res = $role->where('id='.$id)->find();
    	$this->assign('val',$res);
    	$this->display();
    }
    public function auditupdate()
    {
    		$role = M('media');
    		$data['auditstatus']=$this->_request('auditstatus');
    		$id = $this->_request('id');
    		$role->data($data)->where(" id=".$id )->save();	
    		$this->success('操作成功！',U('auditlists'));
    }
    public function del()
    {

        $ids  = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
        if (!$ids) {
        	$this->error('没选择要删除的素材!');
        }
        if (is_array($ids)) {
            foreach ($ids as $k => $v) {
               $this->delete($v);
            }
        }
		$this->success('成功删除',U('lists'));
    }
	/**
	 * 删除
	 */
	public function delete($uid=NULL){

		$id = empty($uid) ? $this->_get('id') : $uid;
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		//$id = $this->_get('id');
		$role = M('media');
		$res = $role->where('id='.$id)->find();
		$temp_name=$res['temp_name'];
		$url='./Public/upload/'.$temp_name;
		$unlink=unlink($url);
		$res = $role->where('id='.$id)->delete();
		if(empty($uid)){
			if($res){
				if($type=='table')
					$this->success('成功删除',U('lists',array('type'=>'table')));
				else
					$this->success('成功删除',U('lists'));
			}else{
				$this->error('删除失败');
			}
		}
	}

    public function edit()
    {

        if(IS_POST){
			//表单提交
			$role = M('media');
			$data['id']=$this->_post('id');
			$data['file_name']=$this->_post('FileName');
			$data['attr']=$this->_post('myselect');
			if(empty($data['file_name'])){
				$this->error('文件名称为空');
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
			$role = M('media');
			$id = $this->_get('id');
			$res = $role->where('id='.$id)->find();
			$this->assign('val',$res);
			$this->display('edit');
		}
    }

    public function add(){
			$attr = $this->_get('attr');
		
			$time=date(DATE_RFC822);
			$this->assign('time',$time);
			$this->assign('attr',$attr);
			$this->display(openadd);	
	}
	/**
	* 查看
	*/
	public function see(){
		
		$role = M('media');
		$id = $this->_get('id');
		$res = $role->where('id='.$id)->find();
		$this->assign('val',$res);
		$this->display();
			
	}
	/**
	* 上传
	*/
	public function uploadify(){
	
    	$targetFolder = $_POST['url']; // Relative to the root
		//$attr = $_POST['myselect'];

    	$targetPath = __ROOT__."/Public/upload/";
	
		//echo $_POST['token'];
		//echo $targetPath;
		$attr = $_POST['attr'];
		$verifyToken = md5($_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

			import("Library.UploadFile");
			$name=time().rand();	//设置上传图片的规则

			$upload = new \UploadFile();// 实例化上传类

			//$upload->maxSize  = 31457280 ;// 设置附件上传大小
			$upload->maxSize  = 1024000000 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型

			$upload->savePath =  './Public/upload/';// 设置附件上传目录
			
			$upload->saveRule = $name;  //设置上传图片的规则
	
			if(!$upload->upload()) {// 上传错误提示错误信息

				//return false;

				echo $upload->getErrorMsg();
				//echo $targetPath;
				exit;
			}else{// 上传成功 获取上传文件信息

				$info =  $upload->getUploadFileInfo();
				$data['file_name']=$info[0]['name'];
				$data['size'] = $info[0]['size'];
				$data['type'] = $info[0]['extension'];
				$data['attr'] = $attr;
				$data['temp_name'] = $info[0]["savename"];
				$data['sub_time'] = time();
				$data['auditstatus'] ='未审核';
				$role = M('media');
				if($role->create($data)){
					if($role->add($data)){
						//$this->success('新增成功');
					}else{
						//$this->error('新增失败');	
					}
				}else{
					$this->error($role->getError());
				}
				echo $targetPath.$info[0]["savename"];
				exit;
			}


		}

    }

	public function openupload(){
		$filename = iconv('UTF-8', 'GBK', $_FILES['file']['name']);
		$type = end(explode('.', $filename));
		$newfile = date('YmdHis').mt_rand(1,1000).'.'.$type;

		$key = $_POST['key'];
		$key2 = $_POST['key2'];
		$attr = $_POST['attr'];
		//echo $_FILES['file']['tmp_name'];
		
		$savefile = C(UPLOAD_PATH).'/'.$newfile;
		if ($filename) {
			//$fileup=move_uploaded_file($_FILES["file"]["tmp_name"],C(UPLOAD_PATH) .'/'.$filename);
			if(!move_uploaded_file($_FILES["file"]["tmp_name"], $savefile)) 
			{
				echo  '文件上传保存错误！';
			}
		}
		$data['file_name']=$filename;
		$data['size'] = $_FILES['file']['size'];
		$data['type'] = $type;
		$data['attr'] = $attr;
		$data['temp_name'] = $newfile;
		$data['sub_time'] = time();
		$data['auditstatus'] = C(DEFAULT_AUDIT);
		
		$role = M('media');
		if($role->create($data)){
			if(!$id=$role->add($data)){
				echo "数据增加失败";
			}
		}else{
			echo "数据创建失败";
		}
		$jsonStr['name']=$newfile;
		$jsonStr['id']=$id;
		echo json_encode($jsonStr);
		exit;	
	}
	public function opendel(){
		$data=(file_get_contents('php://input'));
		$data=json_decode($data,true);
		//echo $data['name'];
		
		$file = C(UPLOAD_PATH).'/'.$data['name'];
		$id = $data['id'];
		if(!unlink ($file)){
			echo "文件删除失败";
		}else{
			
			$role = M('media');
			$res = $role->where('id='.$id)->delete();
			if($res){
				echo "数据删除成功";
			}else
			{
				echo "数据删除失败";
			}
		}
		exit;
	}
}