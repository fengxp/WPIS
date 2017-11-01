<?php
/**
 *
 * 版权所有
 * 作    者
 * 日    期：
 * 版    本：
 * 功能说明：Admin配置文件。
 *
 **/
return array(
	//节目类别
	'MEDIA_ATTR'	 =>array(
		'1'	=> '商业',
		'2'	=> '普通',
		'3' => '公益',
		'4' => '模板'
	),
	'DEVICE_TYPE'	 =>array(
				'1'	=> '节点',
				'0'	=> '设备'
	),
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
    	'__PUBLIC__' => __ROOT__ . '/Public',
        '__ADMIN__' => __ROOT__ . '/Public/admin',
    	'__DTREE__' => __ROOT__ . '/Public/dtree',
    	'__ECHARTS__'=>__ROOT__ . '/Public/echarts',
    ),
    DEFAULT_PUBLISH_STATUS => 1,
	 /*定义组件类型*/
    'TPL_MODULE' => array(
    		//名字,图标class,说明,图标url或组件index.htmlurl
            array('1','视频', "glyphicon glyphicon-film", "插入视频区域","video.png"), 
            array('2','音频', "glyphicon glyphicon-volume-up", "插入音频组件","music.png"),
            array('3','图片', "glyphicon glyphicon-picture", "插入图片区域","photo.png"),
            array('5','文字', "glyphicon glyphicon-font", "插入文字组件",""),       
            array('6','FLASH', "glyphicon glyphicon-facetime-video", "插入FLASH组件","flash.png"),
        ),
	//审核类型
	'AUDIT_STATUS'	 =>array(
		'0'	=> '未审核',
		'1'	=> '审核通过',
		'2' => '审核拒绝',
		'3' => '已删除'
	),
	//默认审核类型
	DEFAULT_AUDIT =>'0',
	//信息类型
	'INFO_TYPE'	 =>array(
		'1'	=> '字幕1',
		'2'	=> '字幕2',
		'3' => '字幕3',
	),
	//预定义信息类型
	'PREDEFINEINFO_TYPE'	 =>array(
				'1'	=> '字幕1',
				'2'	=> '字幕2',
				'3' => '字幕3',
		),
	//合同类型
		'CONTRACT_TYPE'	 =>array(
				'1'	=> '商务合同',
				'2' => '其他',
		),
	//指令
	'ORDER_TYPE'	 =>array(
		'1'	=> '重启',
		'2'	=> '关机',
		'3'	=> '横屏',
		'4'	=> '竖屏',
	),
	'PUBLISH_TYPE'	 =>array(
		'0'	=> '文本',
		'1'	=> '图片',
		'2'	=> '视频',
		'3'	=> '模板',
		'4'	=> 'ATS',
		'5'	=> '天气',
	),
	//event server ip地址和端口号
	SOCKET_MQ => 'tcp://127.0.0.1:5555',
	//文件上传路径
	UPLOAD_PATH =>'Public/upload',
);