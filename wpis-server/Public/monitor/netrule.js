$(function(){
	var cpu=$("#cpu").val();
	var memory=$("#memory").val();
	var diskpercent=$("#diskpercent").val();
	if(cpu>60)
		$("#cpu_row").attr("bgcolor","#FF0000");
	if(memory>50)
		$("#memory_row").attr("bgcolor","#FF0000");
	if(diskpercent>70)
		$("#diskpercent_row").attr("bgcolor","#FF0000");
});
