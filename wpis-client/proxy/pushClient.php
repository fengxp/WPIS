<?php
	//set_time_limit(0);
	$uid = $_SERVER['argc'] > 1 ? $_SERVER['argv'][1] : FALSE;
	$sock = $_SERVER['argc'] > 2 ? $_SERVER['argv'][2] : FALSE;
	//$sock = 'tcp://192.168.2.200:26766';
	//填写正确uid
	if(!$uid){
		echo "php XXX uid \r\n";
		exit;
	}
	if(!$sock)
	{
		echo "php XXX uid tcp://127.0.0.1:23456\r\n";
                exit;
	}
	//解析ORDER
	function disOrder($file_name,$type){

		file_put_contents($file_name,$type);
		switch($type){
			case 1:
				echo "reboot\r\n";
				exec("reboot");
				break;
			case 2:
				echo "shutdown\r\n";
				exec("shutdown -s");
				break;
			case 3:
				echo "horizontal\r\n";
				exec("xrandr -o normal");
				break;
			case 4:
				echo "vertical\r\n";
				exec("xrandr -o left");
				break;
			 default:
                echo  '未知错误！\r\n';
				break;
		}
	}
	//解析直播
	function vlcPlay($file_name,$content,$retreat){
		//printf("content=[%s] retreat=[%d]\r\n",$content,$retreat);
		if(!$retreat){
			echo "vlc play....$content\r\n";
			exec("/var/eadv/vlcStart $content &");
		}else{
			echo "vlc stop....\r\n";
			exec("killall vlc");
			exec("/var/eadv/vlcStart");
		}
		return 0;
	}
	//解析收到的字符串
	function disBuff($buff)
	{
		echo $buff."\r\n";
		$json_buf = @json_decode($buff, ture);
		$error=json_last_error();	
		var_dump($error);
		$file_name = dirname(__FILE__)."/event/event.log";
		file_put_contents($file_name,$buff);
		
		if($json_buf["msgType"]==1)
			$file_name = dirname(__FILE__)."/event/img.log";
		else if($json_buf["msgType"]==2)
			$file_name = dirname(__FILE__)."/event/video.log";
		else if($json_buf["msgType"]==3)
			$file_name = dirname(__FILE__)."/event/tpl.log";
		else if($json_buf["msgType"]==4){
			$file_name = dirname(__FILE__)."/event/order.log";
			disOrder($file_name,$json_buf["type"]);
			return true;
		}else if($json_buf["msgType"]==5){
			$file_name = dirname(__FILE__)."/event/vlc.log";
			vlcPlay($file_name,$json_buf["content"],$json_buf["retreat"]);
		}
		file_put_contents($file_name,$buff);
	}
	
	while(TRUE){
	
		while(@!$client){
			$client = @stream_socket_client($sock, $errno, $errmsg,3,STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT);
			//$client = @stream_socket_client($sock, $errno, $errmsg,1);
			printf("client[%s]\t errno[%d]\t errmsg[%s]\r\n", $client, $errno, $errmsg);
			sleep(1);
		}
		
		
		if($client){
			printf("client[%s]\t errno[%d]\t errmsg[%s]\r\n", $client, $errno, $errmsg);
			$write = @fwrite($client,$uid);
			if( $write <= 0){
				@fclose($client);
				$client = 0;
				sleep(3);
				continue;
			 }
			
			$buff = @fread($client, 8192);
			if($buff)
				disBuff($buff);
			
		}
		//stream_set_timeout($client,3);
		
		//$status = @socket_get_status($client);
		
		//printf("status=[%s] eof=[%s]\r\n",$status['timed_out'],$status['eof']);
		
		//echo "fread=" .@fread($client,8192);
		//echo '$status='.$status['timed_out'];
			
		
	}

