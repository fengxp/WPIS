<?php

class RongYun{
	
	 //调用云通讯发送sms
	 //**************************************举例说明***********************************************************************
	 //*假设您用测试Demo的APP ID，则需使用默认模板ID 1，发送手机号是13800000000，传入参数为6532和5，则调用方式为           *
	 //*result = sendTemplateSMS("13800000000" ,array('6532','5'),"1");																		  *
	 //*则13800000000手机号收到的短信内容是：【云通讯】您使用的是云通讯短信模板，您的验证码是6532，请于5分钟内正确输入     *
	 //*********************************************************************************************************************
	 public function sendTemplateSMS($to,$datas,$tempId){
		 // 初始化REST SDK
		 global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
		 $rest = new REST($serverIP,$serverPort,$softVersion);
		 $rest->setAccount($accountSid,$accountToken);
		 $rest->setAppId($appId);
		
		 // 发送模板短信
		 //echo "Sending TemplateSMS to $to <br/>";
		 $result = $rest->sendTemplateSMS($to,$datas,$tempId);
		 if($result == NULL ) {
			 //echo "result error!";
			 return 1;
			 break;
		 }
		 if($result->statusCode!=0) {
			 //echo "error code :" . $result->statusCode . "<br>";
			 //echo "error msg :" . $result->statusMsg . "<br>";
			 //TODO 添加错误处理逻辑
			 return 2;
		 }else{
			 //echo "Sendind TemplateSMS success!<br/>";
			  //获取返回信息
			 $smsmessage = $result->TemplateSMS;
			 //echo "dateCreated:".$smsmessage->dateCreated."<br/>";
			 //echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
			 //TODO 添加成功处理逻辑
			 return 0;
		 }


	}
	/**
	 * 创建子帐号
	 * @param friendlyName 子帐号名称
	 */
	function createSubAccount($friendlyName) {
		// 初始化REST SDK
		global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
		$rest = new REST($serverIP,$serverPort,$softVersion);
		$rest->setAccount($accountSid,$accountToken);
		$rest->setAppId($appId);
		
		// 调用云通讯平台的创建子帐号,绑定您的子帐号名称
		echo "Try to create a subaccount, binding to user $friendlyName <br/>";
		$result = $rest->createSubAccount($friendlyName);
		if($result == NULL ) {
			echo "result error!";
			return FALSE;
			break;
		}
		if($result->statusCode!=0) {
			echo "error code :" . $result->statusCode . "<br/>";
			echo "error msg :" . $result->statusMsg . "<br>";
			return FALSE;
			//TODO 添加错误处理逻辑
		}else {
			echo "create SubbAccount success<br/>";
			// 获取返回信息
			$subaccount = $result->SubAccount;
			echo "subAccountid:".$subaccount->subAccountSid."<br/>";
			echo "subToken:".$subaccount->subToken."<br/>";
			echo "dateCreated:".$subaccount->dateCreated."<br/>";
			echo "voipAccount:".$subaccount->voipAccount."<br/>";
			echo "voipPwd:".$subaccount->voipPwd."<br/>";
			//TODO 把云平台子帐号信息存储在您的服务器上.
			//TODO 添加成功处理逻辑 
			return (string)$subaccount->subAccountSid;
		}      
	}

	//Demo调用,参数填入正确后，放开注释可以调用   
	//createSubAccount("子帐号名称");
	
	/**
	  * 子帐号信息查询
	  * @param friendlyName 子帐号名称
	  */
	function querySubAccount($friendlyName)
	{
		// 初始化REST SDK
		global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
		$rest = new REST($serverIP,$serverPort,$softVersion);
		$rest->setAccount($accountSid,$accountToken);
		$rest->setAppId($appId);
		
		// 调用云通讯平台的子帐号信息查询接口
		echo "Try to query a subaccount : $friendlyName<br/>";
		$result = $rest->querySubAccount($friendlyName);
		if($result == NULL ) {
			echo "result error!";
			break;
		}
		
		if($result->statusCode!=0) {
			echo "error code :" . $result->statusCode . "<br/>";
			echo "error msg :" . $result->statusMsg . "<br>";
			//TODO 添加错误处理逻辑
		}else {
			echo "query SubAccount success<br/>";
			// 获取返回信息
			$subaccount = $result->SubAccount;
			echo "subAccountid:".$subaccount->subAccountSid."<br/>";
			echo "subToken:".$subaccount->subToken."<br/>";
			echo "dateCreated:".$subaccount->dateCreated."<br/>";
			echo "voipAccount:".$subaccount->voipAccount."<br/>";
			echo "voipPwd:".$subaccount->voipPwd."<br/>";
			//TODO 把云平台子帐号信息存储在您的服务器上.
			//TODO 添加成功处理逻辑
			return (string)$subaccount->subAccountSid;
		}      
	}

	//Demo调用,参数填入正确后，放开注释可以调用   
	//querySubAccount("子帐号名称");
	
	/**
	 * IM PUSH
	 * @
	 */
	function imPush($pushType, $senderid, $receiverids, $msgType, $msgContent, $msgfilename,$msgfileurl,$domain) {
		// 初始化REST SDK
		global $accountSid,$accountToken,$appId,$appToken,$serverIP,$serverPort,$softVersion;
		$rest = new REST($serverIP,$serverPort,$softVersion);
		$rest->setAccount($accountSid,$accountToken);
		$rest->setAppId($appId);
		
		//echo "Try to IM Push <br/>";
		$result = $rest->imPush($pushType, $senderid, $receiverids, $msgType, $msgContent, $msgfilename,$msgfileurl,$domain);
		if($result == NULL ) {
			//echo "IM push result error!";
			return FALSE;
		}
		if($result->statusCode!=0) {
			//echo "error code :" . $result->statusCode . "<br/>";
			//echo "error msg :" . $result->statusMsg . "<br>";
			return FALSE;
		}  
		return TRUE;
	}
}
?>