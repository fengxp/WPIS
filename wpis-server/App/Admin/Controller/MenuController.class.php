<?php
/**
 *
 * 版权所有：
 * 作    者：
 * 日    期：
 * 版    本：
 * 功能说明：
 *
 **/

namespace Admin\Controller;

class MenuController extends BaseController
{
    public function index()
    {


        $p = isset($_GET['p']) ? intval($_GET['p']) : '1';


        $m = M('auth_rule');
        $pagesize = 10;#每页数量
        $offset = $pagesize * ($p - 1);//计算记录偏移量
        $count = $m->count();

        $list = $m->order('o asc')->select();
		$this->IndexFlag=1;
        $list = $this->getMenu($list);

        $page = new \Think\Page($count, $pagesize);
        $this->assign('list', $list);

        $this->display();
    }

    public function del()
    {
        $ids = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
        if (!$ids) {
            $this->error('请勾选删除菜单！');
        }
        //uid为1的禁止删除
        if (is_array($ids)) {
            foreach ($ids as $k => $v) {
                $ids[$k] = intval($v);
            }
            if (!$ids) {
                $this->error('参数错误！');
                $uids = implode(',', $uids);
            }
        }

        $map['id'] = array('in', $ids);
        if (M('auth_rule')->where($map)->delete()) {

            addlog('删除菜单ID：' . $ids);
            $this->success('恭喜，菜单删除成功！');
        } else {
            $this->error('参数错误！');
        }
    }

    public function edit($id = 0)
    {
        $id = intval($id);
        $m = M('auth_rule');
        $currentmenu = $m->where("id='$id'")->find();
        if (!$currentmenu) {
            $this->error('参数错误！');
        }

        $option = $m->order('o ASC')->select();
        $option = $this->getMenu($option);
        $this->assign('option', $option);
        $this->assign('currentmenu', $currentmenu);
        $this->display('form');
    }

    public function update()
    {
        $id = I('post.id', '', 'intval');
        $data['pid'] = I('post.pid', '', 'intval');
        $data['title'] = I('post.title', '', 'strip_tags');
        $data['name'] = I('post.name', '', 'strip_tags');
        $data['icon'] = I('post.icon');
        $data['islink'] = I('post.islink', '', 'intval');
        $data['status'] = 1;
        $data['o'] = I('post.o', '', 'intval');
        $data['tips'] = I('post.tips');
        if ($id) {
            M('auth_rule')->data($data)->where("id='{$id}'")->save();
            addlog('编辑菜单，ID：' . $id);
        } else {
            M('auth_rule')->data($data)->add();
            addlog('新增菜单，名称：' . $data['title']);
        }

        $this->success('操作成功！');
    }


    public function add()
    {

        $option = M('auth_rule')->order('o ASC')->select();
        $option = $this->getMenu($option);
        $this->assign('option', $option);
        $this->display('form');
    }
}