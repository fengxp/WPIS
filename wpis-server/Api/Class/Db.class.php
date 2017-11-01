<?php
class Db{
	/**
	*  单例模式链接数据库
	*/
	static private $_instance;   //单例资源
	static private $_connectSource;   //链接资源
	private $_dbConfig = array(
		'db_host'=>DB_HOST,		//主机地址
		'db_user'=>DB_USER,		//数据库用户
		'db_pwd'=>DB_PWD,     //密码
		'db_database'=>DB_DATABASE,   //数据库名				
	);
	private function __construct(){} 	//构造函数，初始化数据
		
	static public function getInstance(){   //此方法为了在类的内部实例化此类
		if(!self::$_instance instanceof self){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	// 封装链接数据库方法
	public function dbConnect(){
		if(!self::$_connectSource){		
			self::$_connectSource = mysqli_connect($this->_dbConfig['db_host'],$this->_dbConfig['db_user'],$this->_dbConfig['db_pwd'],$this->_dbConfig['db_database']);	
			if(!self::$_connectSource){
				throw new Exception();  //数据库链接失败时，抛出异常
				die('mysql connectSource error' . mysql_error());
			}
			//mysql_select_db($this->_dbConfig['db_database'],self::$_connectSource);
			mysqli_query(self::$_connectSource,'set names UTF8');
		}
		return self::$_connectSource;
	}
	//打印函数
	static public function dump($data){
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}
}

?>