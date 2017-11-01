<?php
/**
 *
 * 版权所有：
 * 作    者：
 * 日    期：
 * 版    本：
 * 功能说明：管理后台模块公共控制器，用于储存公共数据。
 *
 **/

namespace Common\Controller;

use Think\Controller;

class ComController extends Controller
{
    public function _initialize()
    {
		
        C(setting());
    }
	protected function _get($val){
		return htmlspecialchars($_GET[$val]);
	}

	protected function _post($val){
		return htmlspecialchars($_POST[$val]);
	}
	protected function _request($val){
		return htmlspecialchars($_REQUEST[$val]);
	}
}