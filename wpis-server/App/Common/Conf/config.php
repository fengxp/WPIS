<?php
/**
 *
 * 版权所有
 * 作    者
 * 日    期：
 * 版    本：
 * 功能说明：配置文件。
 *
 **/
return array(
    //网站配置信息
    'URL' => '', //网站根URL
    'COOKIE_SALT' => 'pids', //设置cookie加密密钥
    //备份配置
    'DB_PATH_NAME' => 'db',        //备份目录名称,主要是为了创建备份目录
    'DB_PATH' => './db/',     //数据库备份路径必须以 / 结尾；
    'DB_PART' => '20971520',  //该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M
    'DB_COMPRESS' => '1',         //压缩备份文件需要PHP环境支持gzopen,gzwrite函数        0:不压缩 1:启用压缩
    'DB_LEVEL' => '9',         //压缩级别   1:普通   4:一般   9:最高
    //扩展配置文件
    'LOAD_EXT_CONFIG' => 'db,admin,monitorrule',
	//默认路径
	'DEFAULT_MODULE'  => 'Admin',
	'Version' =>'2.0',
	//分页配置
	'VAR_PAGE' => 'page',
	'DEFAULT_NUMS' => '10',
	'DEFAULT_NUMS_TABLE' => '15',
	'TMPL_ACTION_SUCCESS'=>'Public:dispatch_jump',
	'TMPL_ACTION_ERROR'=>'Public:dispatch_jump',
	'DEFAULT_TIMEZONE'=>'Asia/Shanghai', 
);