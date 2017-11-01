/*
布局
*/
function layout() {
	
    var moveObj = undefined,
        startX, startY, endX, endY, orignX, orignY;

    $(".zoomElement").each(function() {


        $(this).mousemove(function(e) {
            var target = e.target;

            var offsetX = e.offsetX;
            var offsetY = e.offsetY;

            var direction = inZoomArea(offsetX, offsetY, target);
        });

        $(this).mousedown(function(e) {
            var target = e.target;

            var offsetX = e.offsetX;
            var offsetY = e.offsetY;

            var direction = inZoomArea(offsetX, offsetY, target);

            handleZoomByDirection(direction, target);
        });
    })

    window.onmousedown = function(e) {
        e.preventDefault();
        if (e.target.className.indexOf("moveElement") != -1 && inZoomArea(e.offsetX, e.offsetY, e.target) == "no") {
            moveObj = e.target;

            var parent = $(moveObj).parents(".moveAndZoom");

            orignX = e.offsetX;
            orignY = e.offsetY;

            startX = findOffsetLeftOrTopFromElementToParent("offsetLeft", parent, $("body"));
            startY = findOffsetLeftOrTopFromElementToParent("offsetTop", parent, $("body"));
            endX = parent[0].offsetWidth - moveObj.offsetWidth;
            endY = parent[0].offsetHeight - moveObj.offsetHeight;

            moveObj.style.cursor = "move";
        }
    }

    window.onmousemove = function(e) {
        e.preventDefault(); //阻止默认事件
        if (moveObj != undefined && moveObj.className.indexOf("moveElement") != -1) {
            var target = moveObj;

            var left = e.pageX - startX - orignX;
            var top = e.pageY - startY - orignY;

            if (left <= 0) left = 0;
            if (top <= 0) top = 0;
            if (left >= endX) left = endX;
            if (top >= endY) top = endY;

            moveObj.style.left = left + "px";
            moveObj.style.top = top + "px";

            moveObj.style.cursor = "move";
        }
    }

    window.onmouseup = function(e) {
        e.preventDefault();
        if (moveObj != undefined && moveObj.className.indexOf("moveElement") != -1) {
            var target = moveObj;

            var left = e.pageX - startX - orignX;
            var top = e.pageY - startY - orignY;
            if (left <= 0) left = 0;
            if (top <= 0) top = 0;
            if (left >= endX) left = endX;
            if (top >= endY) top = endY;

            moveObj.style.left = left + "px";
            moveObj.style.top = top + "px";

            moveObj.style.cursor = "auto";

            moveObj = undefined;
        }
    }
}
/*
 return element is in zoom area or not
*/
function inZoomArea(offsetX, offsetY, target) {
    var width = target.offsetWidth;
    var height = target.offsetHeight;

    //只处理右下角一种情况
    if (offsetX >= width - 5 && offsetY >= height - 5) {
        target.style.cursor = "nw-resize";
        return "nw";
    }else{
    	target.style.cursor = "auto";
    	return "no";
    }

    return;

    if (offsetX < 5 && offsetY < 5 || offsetX >= width - 5 && offsetY >= height - 5) {
        target.style.cursor = "nw-resize";
        return "nw";
    } else if (offsetX < 5 && offsetY >= height - 5 || offsetX >= width - 5 && offsetY < 5) {
        target.style.cursor = "sw-resize";
        return "sw";
    } else if (offsetX < 5 || offsetX >= width - 5) {
        target.style.cursor = "w-resize";
        return "w";
    } else if (offsetY < 5 || offsetY >= height - 5) {
        target.style.cursor = "n-resize";
        return "n";
    } else {
        target.style.cursor = "auto";
        return "no";
    }
}

function handleZoomByDirection(direction, target) {
    switch (direction) {
        //左上和右下
        case "nw":
            //左下和右上
        case "sw":
            (function() {
                var parent = $(target).parents(".moveAndZoom");

                var orignX = target.offsetLeft;
                var orignY = target.offsetTop;
                var orignWidth = target.offsetWidth;
                var orignHeight = target.offsetHeight;

                parent.mousedown(function(e) {
                    e.preventDefault();
                    startX = findOffsetLeftOrTopFromElementToParent("offsetLeft", parent, $("body"));
                    startY = findOffsetLeftOrTopFromElementToParent("offsetTop", parent, $("body"));
                    endX = parent[0].offsetWidth;
                    endY = parent[0].offsetHeight;
                });

                parent.mousemove(function(e) {
                    e.preventDefault();

                    var newWidth = e.pageX - startX - orignX;
                    var newHeight = e.pageY - startY - orignY;

                    target.style.opacity = 0.5;
                    target.style.width = newWidth + "px";
                    target.style.height = newHeight + "px";

                });

                parent.mouseup(function(e) {
                    e.preventDefault();

                    parent.unbind("mousedown");
                    parent.unbind("mousemove");
                    parent.unbind("mouseup");

                    target.style.opacity = 1;
                });



            })();
            break;
        case "w":
            break;
        case "n":
            break;
        default:
            break;
    }
}
/*
startElement and endElement are jquery object

direction value = offsetLeft or offsetTop
*/
function findOffsetLeftOrTopFromElementToParent(direction, startElement, endElement) {
    if (startElement[0] === endElement[0]) {
        return 0;
    } else {
        return findOffsetLeftOrTopFromElementToParent(direction, $(startElement[0].offsetParent), endElement) + startElement[0][direction];
    }
}
function layout_location(obj,layout){
	var m_left=(obj.getBoundingClientRect().left-layout.getBoundingClientRect().left);
	var m_top=(obj.getBoundingClientRect().top-layout.getBoundingClientRect().top);

	var m_width=(obj.getBoundingClientRect().width);
	var m_height=(obj.getBoundingClientRect().height);
	if(parseInt(m_left) < 0)
		return 0;
	var val=(m_left+':'+m_top+':'+m_width+':'+m_height);
		return val;
}
function layout_submit(){
	//alert('dd');
	var layout = document.getElementById('layout');
	var img=document.getElementById('photo');
	var video=document.getElementById('video');
	var ats=document.getElementById('ats');
	var weather=document.getElementById('weather');
	var info1=document.getElementById('info1');
	var info2=document.getElementById('info2');
	var info3=document.getElementById('info3');

	var img_val='';
	var video_val='';
	var ats_val='';
	var weather_val='';
	var info1_val='';
	var info2_val='';
	var info3_val='';
	
	img_val=layout_location(img,layout);
	video_val=layout_location(video,layout);
	ats_val=layout_location(ats,layout);
	weather_val=layout_location(weather,layout);
	info1_val=layout_location(info1,layout);
	info2_val=layout_location(info2,layout);
	info3_val=layout_location(info3,layout);

	document.getElementById('img_val').value=img_val;
	document.getElementById('video_val').value=video_val;
	document.getElementById('ats_val').value=ats_val;
	document.getElementById('weather_val').value=weather_val;
	document.getElementById('info1_val').value=info1_val;
	document.getElementById('info2_val').value=info2_val;
	document.getElementById('info3_val').value=info3_val;
	
	//return false;
	
}
function myReMouse(obj,url){
	layer.open({
		type: 2,
		closeBtn: 1,
		area: ['300px', '300px'],
		shadeClose: true,
		title: '设置参数',
		content: url
	});
	return false;
}
function myReMouse2(obj,url){
	layer.open({
		type: 2,
		closeBtn: 1,
		area: ['500px', '500px'],
		shadeClose: true,
		title: '设置参数',
		content: url
	});
    return false;
}

function reSizeMove(){
	$(".moveDiv").resizable({handler: '.handler'}).draggable({containment:'.moveAndZoom'});
}
function select_img(){
	
	$("#photo").show();
}
function select_video(){
	$("#video").show();
}
function select_ats(){
	$("#ats").show();
}
function select_weather(){
	$("#weather").show();
}
function select_info(val){
	if(val == 1){
		$("#info1").show();
	}
	if(val == 2){
		$("#info2").show();
	}
	if(val == 3){
		$("#info3").show();
	}

}
function layout_reset(){
	window.location.reload();
}
