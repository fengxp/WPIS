<?php
/**
 *
 * 版权所有：
 * 作    者：
 * 日    期：
 * 版    本：
 * 功能说明：用户控制器。
 *
 **/

namespace Admin\Controller;

class GroupController extends BaseController
{
    public function index()
    {
    	$p = isset($_GET['p']) ? intval($_GET['p']) : '1';
    	$field = isset($_GET['field']) ? $_GET['field'] : '';
    	$keyword = isset($_GET['keyword']) ? htmlentities($_GET['keyword']) : '';
    	$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
    	$where = '';
    	
    	$prefix = C('DB_PREFIX');
    	if ($order == 'asc') {
    		$order = "{$prefix}auth_group.title asc";
    	} elseif (($order == 'desc')) {
    		$order = "{$prefix}auth_group.title desc";
    	} else {
    		$order = "{$prefix}auth_group.uid asc";
    	}
    	if ($keyword <> '') {
    		if ($field == 'title') {
    			$where = "{$prefix}auth_group.title LIKE '%$keyword%'";
    		}
    		
    	}
    	$count =  M('auth_group')->where($where)->count();
    	$cur_page = isset($_GET['page'])?$_GET['page']:1;
    	$Page = new \Think\Page($count,C('DEFAULT_NUMS')); //实例化page对象
    	$pages = $Page->show();
        $group = M('auth_group')->where($where)->page($cur_page.','.C('DEFAULT_NUMS'))->select();
        $this->assign('list', $group);
        $this->assign('pages',$pages);
        //$this->assign('nav', array('user', 'grouplist', 'grouplist'));//导航
        $this->display();
    }

    public function del()
    {
        $ids = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
        if (is_array($ids)) {
            foreach ($ids as $k => $v) {
                $ids[$k] = intval($v);
            }
            $ids = implode(',', $ids);
            $map['id'] = array('in', $ids);
            if (M('auth_group')->where($map)->delete()) {
                addlog('删除用户组ID：' . $ids);
                $this->success('恭喜，用户组删除成功！');
            } else {
                //$this->error('参数错误！');
            	$this->success('没选择要删除的用户组!',U('index'));
            }
        } else {
            //$this->error('参数错误！');
            $this->success('没选择要删除的用户组!',U('index'));
        }
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
    
    public function update()
    {

        $data['title'] = isset($_POST['title']) ? trim($_POST['title']) : false;
        $id = isset($_POST['id']) ? intval($_POST['id']) : false;
        if ($data['title']) {
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            if ($status == 'on') {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
            //如果是超级管理员一直都是启用状态
            if ($id == 1) {
                $data['status'] = 1;
            }

            $rules = isset($_POST['rules']) ? $_POST['rules'] : 0;
            if (is_array($rules)) {
                foreach ($rules as $k => $v) {
                    $rules[$k] = intval($v);
                }
                $rules = implode(',', $rules);
            }
            $data['rules'] = $rules;
            if ($id) {
            	$data['device'] = isset($_POST['device']) ? $_POST['device'] : 0;
            	$device=explode(',',$data['device']);
            	for($index=0;$index<count($device);$index++){
            		if($index==0 && $device[$index]!=1)
            			$data['device']='1,'.$data['device'];
            	}
                $group = M('auth_group')->where('id=' . $id)->data($data)->save();
                if ($group) {
                    addlog('编辑用户组，ID：' . $id . '，组名：' . $data['title']);
                    $this->success('恭喜，用户组修改成功！');
                    exit(0);
                } else {
                    $this->success('未修改内容');
                }
            } else {
            	$data['device'] = isset($_POST['device']) ? $_POST['device'] : 0;
                M('auth_group')->data($data)->add();
                addlog('新增用户组，ID：' . $id . '，组名：' . $data['title']);
                $this->success('恭喜，新增用户组成功！');
                exit(0);
            }
        } else {
            $this->success('用户组名称不能为空！');
        }
    }

    public function edit()
    {

        $id = isset($_GET['id']) ? intval($_GET['id']) : false;
        if (!$id) {
            $this->error('参数错误！');
        }

        $group = M('auth_group')->where('id=' . $id)->find();
        if (!$group) {
            $this->error('参数错误！');
        }
        //获取所有启用的规则
        $rule = M('auth_rule')->field('id,pid,title')->where('status=1')->order('o asc')->select();
        $group['rules'] = explode(',', $group['rules']);
        $rule = $this->getMenu($rule);
        $this->assign('rule', $rule);
        $this->assign('group', $group);
        $this->assign('nav', array('user', 'grouplist', 'addgroup'));//导航
        $this->display('form');
    }

    public function add()
    {

        //获取所有启用的规则
        $rule = M('auth_rule')->field('id,pid,title')->where('status=1')->order('o asc')->select();
        $rule = $this->getMenu($rule);
        $this->assign('rule', $rule);
        $this->display('form');
    }

    public function status()
    {

        $id = I('id');
        if (!$id) {
            $this->error('参数错误！');
        }
        if ($id == 1) {
            $this->error('此用户组不可变更状态！');
        }
        $group = M('auth_group')->where('id=' . $id)->find();
        if (!$group) {
            $this->error('参数错误！');
        }
        $status = $group['status'];
        if ($status == 1) {
           $res = M('auth_group')->data(array('status' => 0))->where('id=' . $id)->save();
        }
        if ($status != 1 ) {
            $res = M('auth_group')->data(array('status' => 1))->where('id=' . $id)->save();
        }
        if ($res) {
            $this->success('恭喜，更新状态成功！');
        } else {
            $this->error('更新失败！');
        }
    }
}