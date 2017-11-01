<?php
require('./Class/Response.class.php');
require('./Class/Db.class.php');
require('./Class/Cache.class.php');
require('./Class/Library.class.php');
require('./Class/Log.class.php');
require('./function/function.php');

/*
 *  APP接口数据库配置文件
 *  
*/
define('DB_HOST','127.0.0.1');       //主机
define('DB_USER','pids');            //数据库用户
define('DB_PWD','pids123456');  				 //数据库密码
define('DB_DATABASE','pids');        //数据库名称

define('LOG_PATH','../Log/apiLog.txt');

/*
 *  连接数据库
 *  
*/
error_reporting(E_ERROR);
try{
	$connect = Db::getInstance()->dbConnect();
}catch (Exception $e){
	return Response::show('400','数据库链接失败');
}

?>