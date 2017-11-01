<?php
/*
*	事件类
*
*/
class EventMq{
	
	public $client;
	private $errno;
	private $errmsg;

	public function  __construct($sock,$timeout=1){
		
		$this->client = stream_socket_client($sock, $this->errno, $this->errmsg, $timeout);
	} 

	public function send($data){
		
		return (fwrite($this->client, json_encode($data)."\n"));
		
	}
	public function recv(){
		// 读取推送结果
		return (fread($this->client, 8192));
	}
	public function close(){

		fclose($this->client);
	}
	public function get_errno()
	{
		return $this->errno;
	}
	public function get_errmsg(){
		return $this->errmsg;
	}

	
}