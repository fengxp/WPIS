function init(){
	initJsonp();
	initJsonp('img');
	initJsonp('video');
}
function initJsonp(type){
	//alert(Date.parse(new Date())/1000);
	//alert(polling_url);
	$.ajax({  
		url: init_url,  
		data: {"timestamp": timestamp,"type":type},  
		//dataType: "text",
		dataType:'jsonp',  
		jsonp:'callback',
		timeout: 1000*10,//超时，可自定义设置  
		error: function (XMLHttpRequest, textStatus, errorThrown) {   
			if (textStatus == "timeout") { // 请求超时  
				console.log("init timeout"); 
				
			} else { // 其他错误，如网络错误等 
				console.log("init Error");
			}
		},  
		success: function (data, textStatus) {   
			if (textStatus == "success") { // 请求成功
				checkPush(data);
				console.log("init success");

			}  
		}  
	});  

}
//lang polling
function longPolling() { 
	//alert(Date.parse(new Date())/1000);
	//alert(polling_url);
	$.ajax({  
		url: polling_url,  
		data: {"timestamp": timestamp,"id":null},  
		//dataType: "text",
		dataType:'jsonp',  
		jsonp:'callback',
		timeout: 1000*60,//超时，可自定义设置  
		error: function (XMLHttpRequest, textStatus, errorThrown) {   
			if (textStatus == "timeout") { // 请求超时  
				console.log("polling timeout");
				setTimeout("longPolling()",1000); // 递归调用  
			} else { // 其他错误，如网络错误等 
				console.log("polling Error");
				setTimeout("longPolling()",1000);  
			}  
		},  
		success: function (data, textStatus) {   
			if (textStatus == "success") { // 请求成功
				checkPush(data);
				console.log("polling success");
				timestamp = data['currentmodif'];
				setTimeout("longPolling()",1000);
				  
			}  
		}  
	});  

}

//设置背景布局
function setLayout(data){
	var bg_name = data.bg_name;
	var bg_width = data.temp_width;
	var bg_height = data.temp_height;
	var video_info = data.video_info.split(":");
	var img_info = data.img_info.split(":");
	var clock_info = data.clock_info.split(":");
	var clock2_info = data.clock2_info.split(":");
	var info1 = data.info1_info.split(":");
	var info2 = data.info2_info.split(":");
	var info3 = data.info3_info.split(":");

	var info1_txt = data.info1_txt.split(":");
	var info2_txt = data.info2_txt.split(":");
	var info3_txt = data.info3_txt.split(":");
	var video = document.getElementById("myVideo");

	console.log("video_info="+video_info);
	console.log("img_inf0="+img_info);

	$(".layOut").css({ "width":bg_width,"height":bg_height});
	$(".layOut").css("background-image","url(../data/upload/"+bg_name+")");
	if(video_info ==0){
		$(".videoDiv").hide();
		video.pause();
	}else{
		$(".videoDiv").show();
		video.play();
		$(".videoDiv").css({ "left":video_info[0]+"px","top":video_info[1]+"px","width":video_info[2],"height":video_info[3]});
	}
	if(img_info ==0){
		$(".imgDiv").hide();
	}else
	{
		$(".imgDiv").show();
		$(".imgDiv").css({ "left":img_info[0]+"px","top":img_info[1]+"px","width":img_info[2],"height":img_info[3]});
	}
	if(clock_info ==0){
		$(".clockDiv").hide();
	}else{
		$(".clockDiv").show();
		$(".clockDiv").css({ "left":clock_info[0]+"px","top":clock_info[1]+"px","width":clock_info[2],"height":clock_info[3]});
	}
	if(clock2_info ==0){
		$(".clock2Div").hide();
	}else{
		$(".clock2Div").show();
		$(".clock2Div").css({ "left":clock2_info[0]+"px","top":clock2_info[1]+"px","width":clock2_info[2],"height":clock2_info[3]});
	}
	$(".info1Div").css({ "left":info1[0]+"px","top":info1[1]+"px","width":info1[2],"height":info1[3]});
	$(".info2Div").css({ "left":info2[0]+"px","top":info2[1]+"px","width":info2[2],"height":info2[3]});
	$(".info3Div").css({ "left":info3[0]+"px","top":info3[1]+"px","width":info3[2],"height":info3[3]});

	if(info1_txt != ""){
		var info1_str="<marquee id='marquee1' scrollamount='"+info1_txt[3]+"' direction='"+info1_txt[1]+"' style='width:100%;height:100%;' ><span id='marquee_text1' style='font-size:"+info1_txt[2]+";color:"+info1_txt[0]+"' >"+info1_txt[4]+"</span></marquee>";
		$("#info1").html(info1_str);
	}else
		$("#info1").html('');
	if(info2_txt != ""){
		var info2_str="<marquee id='marquee2' scrollamount='"+info2_txt[3]+"' direction='"+info2_txt[1]+"' style='width:100%;height:100%;' ><span id='marquee_text2' style='font-size:"+info2_txt[2]+";color:"+info2_txt[0]+"' >"+info2_txt[4]+"</span></marquee>";
		$("#info2").html(info2_str);
	}else{
		$("#info2").html('');
	}
	if(info3_txt !=""){
		var info3_str="<marquee id='marquee3' scrollamount='"+info3_txt[3]+"' direction='"+info3_txt[1]+"' style='width:100%;height:100%;' ><span id='marquee_text3' style='font-size:"+info3_txt[2]+";color:"+info3_txt[0]+"' >"+info3_txt[4]+"</span></marquee>";
		$("#info3").html(info3_str);
	}else{
		$("#info3").html('');
	}

	//var video_str ="<video autoplay='autoplay' src='img/play.mp4' width='100%' height='100%' controls preload></video>";
	//$("#video").html(video_str);
}
function CheckImgExists(imgurl) {  
    var ImgObj = new Image(); //判断图片是否存在  
    ImgObj.src = imgurl;  
    //没有图片，则返回-1  
    if (ImgObj.fileSize > 0 || (ImgObj.width > 0 && ImgObj.height > 0)) {  
        return true;  
    } else {  
        return false;
    }  
} 

function setImg(data){
	//var msg = JSON.stringify(data);
	var imgList = new Array();
	imgList = data.split(",");
	vListImg.splice(0,vListImg.length);//清空数组
	for(var i=0; i<imgList.length; i++)  
    {  
        //console.log(data[i].temp_name);
		if(CheckImgExists("../data/upload/"+imgList[i]))
		{
			vListImg[i]="../data/upload/"+imgList[i];
		}

    } 
	vListImg.length = imgList.length;
	console.log(vListImg);
}

function setVideo(data){
	//console.log(JSON.stringify(data));
	var List = new Array();
	List = data.split(",");
	for(var i=0; i<data.length; i++)  
    {  
      //alert(data[i].temp_name);
	  
		vListVideo[i]="../data/upload/"+List[i];
		
    } 
	vListVideo.length = List.length;
	console.log(vListVideo);
}
function myVideo(){
	document.getElementById("myVideo").volume = 0.1;		
	var vLen = vListVideo.length; // 播放列表的长度
	var curr = 0; // 当前播放的视频
	//if( curr_cookie !="null")curr = curr_cookie;
	var video = document.getElementById("myVideo");
	
	video.addEventListener('ended', play);
	video.addEventListener('error', play);
	play();
	function play(e) {
		video.src = vListVideo[curr];
		if(video.networkState == 3){
			video.load(); // 如果短的话，可以加载完成之后再播放，监听 canplaythrough 事件即可    
			video.play();
		}
		curr++;
		if (curr >= vLen) curr = 0; // 播放完了，重新播放
		//alert(sessionStorage.curr);
		//sessionStorage.curr=curr;
		
	}
}

function myImg(){
	var img = document.getElementsByTagName('img');
	var pos = 1;
	var vLen = vListImg.length;
	img[0].src = vListImg[0];
	setInterval(function(){
		if(typeof(vListImg[pos])!="undefined"){
			img[0].src = vListImg[pos];
		}
		pos++;
		if (pos >= vLen) pos = 0;
	},5000);

}


//检测中心更新的内容。
function checkPush(data){
	console.log(data);
	msg=JSON.parse(data.msg);
	
	console.log("msgType="+msg.msgType);
	
	switch(msg.msgType*1)
	{
		case 6:
		case 0:
			if(msg.retreat == 0)
				scroll_set(msg.type,msg.length,msg.content);
			else
				cancle(msg.type);
			break;
		case 1:
			//myJsonp(img_url,1);
			setImg(msg.content);
			break;
		case 2:
			//myJsonp(video_url,2);
			setVideo(msg.content);
			break;
		case 3:
			//myJsonp(layout_url,3);
			setLayout(msg.content);
			break;
		default:
			break;
	}
	
}
//取消推送的状态
function cancle(type)
{
	//var audioEle = document.getElementById("audio_scroll");
	
	var marquee_txt = "marquee_text"+type;
	document.getElementById("marquee"+type).stop();
	var marqueeText = document.getElementById(marquee_txt);
	marqueeText.innerHTML="";
	//audioEle.src="";

}
//设置滚动信息
function scroll_set(msgType,time,content)
{
	var playTime= parseInt(arguments[1] || TimeOut)*1000*60;
	marquee_txt = "marquee_text"+msgType;
	var marqueeText = document.getElementById(marquee_txt);
	if( marqueeText != null){
		marqueeText.innerHTML=content;
		document.getElementById("marquee"+msgType).stop();
		document.getElementById("marquee"+msgType).start();
		//var audioEle = document.getElementById("audio_scroll");
		//audioEle.src="../audio/scroll.mp3";
		//audioEle.play();
		setTimeout(function(){cancle(msgType);},playTime);
	}
}
