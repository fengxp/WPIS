<?php
	class Log{
	/**
	*  showlog
	*/
	private $Filename='../Log/log.txt'; //日志文件
	private $Handle;
	private $Batch;  //时间sh
	private $enabeLog = true; //日志开关。可填值：true
	function __construct()	
	{
		date_default_timezone_set("PRC");  
		$this->Batch = date("Ymd-His");
        $this->Handle = fopen($this->Filename, 'a');
		
	}

	/**
    * 打印日志
    * 
    * @param log 日志内容
    */
    public function showlog($log){
      if($this->enabeLog){
         fwrite($this->Handle,$this->Batch.":".$log."\n");  
      }
    }

}
?>