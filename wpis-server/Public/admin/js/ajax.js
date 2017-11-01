
function ajax(obj){
	if(!obj.url){
		console.error("url不能为空");
		return false;
	}
	var url=obj.url;
	var type=obj.type||"get";
	var data=obj.data||"";
	var datatype=obj.datatype||"text";
	var asynch=obj.asynch==undefined?true:false;
	if(typeof data=="object"){
		var str="";
        for(var i in data){//json只能这样遍历
            str+=i+"="+data[i]+"&";

        }
		data=str.slice(0,-1);
	}
	var xml=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");//Microsoft.XMLHTTP
	xml.onreadystatechange=function(){
		if(xml.readyState==4){//readyState中S大写
			if(xml.status==200){
				if(datatype=="text"){
					obj.success(xml.responseText);
				}
				else if(datatype=="xml"){
					obj.success(xml.responseXML);
				}
				else if(datatype=="json"){
				//返回的是字符串，要让符合语意规则的字符串被当作代码执行，用到eval
					var objdata=eval("("+xml.responseText+")");
					obj.success(objdata);
				}
			}
		}
	}
	if(type=="get"){
		xml.open(type,url+"?"+data,asynch);
		xml.send();
	}
	else if(type=="post"){
		xml.open(type,url,asynch);
		xml.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xml.send(data);
	}
}



















































































































































































































































