//获取选中checkbox值方式1:
//$(function(){ 
//    $("input:button").click(function() {
//        text = $("input:checkbox[name='times']:checked").map(function(index,elem) {
//            return $(elem).val();
//        }).get().join(';'); 
//        var starttime=$("#begindate").val();
//        var endtime=$("#enddate").val();
//        alert("选中的checkbox的值为："+text);
//        window.location.href="addtimerules?rules="+text+"&starttime="+starttime+"&starttime="+endtime;
//    });
//});

$(function(){ 
	$('input[name="times"]').change(function() {
        text = $("input:checkbox[name='times']:checked").map(function(index,elem) {
            return $(elem).val();
        }).get().join(';'); 
		$("#rules").val(text);
//		alert($("#rules").val());
	});
});