var DEVICE_ID = "23";
var TimeOut = 1000*60*30   //默认信息播放时间30分钟
//var SERVER = "127.0.0.1";
//var myRoot = "lms/server2/Api/";
var SERVER = "127.0.0.1:8080";
//var myRoot = "lms/client2/proxy/";
var myRoot = "";

var timestamp = Date.parse(new Date())/1000;

var init_url = "http://"+SERVER+"/"+myRoot+"initCont.php";

var polling_url = 'http://'+SERVER+'/'+myRoot+'polling.php';

var vListVideo = [
	'img/play.mp4'
];

var vListImg = [
	'img/play.jpg'
];