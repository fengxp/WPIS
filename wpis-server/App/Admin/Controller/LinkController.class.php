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

class LinkController extends BaseController
{

    //友情链接
    public function index()
    {

        $list = M('links')->order('o asc')->select();
        $this->assign('list', $list);
        $this->display();
    }

    //新增链接
    public function add()
    {

        $this->display('form');
    }

    //新增或修改链接
    public function edit($id = null)
    {

        $id = intval($id);
        $link = M('links')->where('id=' . $id)->find();
        $this->assign('link', $link);
        $this->display('form');
    }

    //删除链接
    public function del()
    {

        $ids = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
        if ($ids) {
            if (is_array($ids)) {
                $ids = implode(',', $ids);
                $map['id'] = array('in', $ids);
            } else {
                $map = 'id=' . $ids;
            }
            if (M('links')->where($map)->delete()) {
                addlog('删除友情链接，ID：' . $ids);
                $this->success('恭喜，删除成功！');
            } else {
                $this->error('参数错误！');
            }
        } else {
            $this->error('参数错误！');
        }
    }

    //保存链接
    public function update($id = 0)
    {
        $id = intval($id);
        $data['title'] = I('post.title', '', 'strip_tags');
        if (!$data['title']) {
            $this->error('请填写标题！');
        }
        $data['url'] = I('post.url', '', 'strip_tags');
        $data['o'] = I('post.o', '', 'strip_tags');
        $pic = I('post.logo', '', 'strip_tags');
        if ($pic <> '') {
            $data['logo'] = $pic;
        }
        if ($id) {
            M('links')->data($data)->where('id=' . $id)->save();
            addlog('修改友情链接，ID：' . $id);
        } else {
            M('links')->data($data)->add();
            addlog('新增友情链接');
        }

        $this->success('恭喜，操作成功！', U('index'));
    }
}