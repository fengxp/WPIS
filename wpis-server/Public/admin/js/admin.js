/*
 * 后台相关公用JS
 */
	
	function check_accadd(){
		var user_name = $('#account').val();
		var password = $('#password').val();
		var re_password = $('#re_password').val();
		var role_id = $('#role_id').val();

		var check_code = $('#check_code').val();	//验证码验证结果
		if(user_name == ''){
			layer.tips('请输入用户名', '#account');
			return false;
		}
		if(password == ''){
			layer.tips('请输入密码', '#password');
			return false;
		}
		if(re_password == ''){
			layer.tips('请输入确认密码', '#re_password');
			return false;
		}
		if( (password != re_password) ){
			layer.tips('密码不一致', '#re_password');
			return false;
		}

		if(role_id == 0){
			layer.tips('请选择角色', '#role_id');
			return false;
		}
		
		
		return true;
	}

	//删除
	function mydelete(url){
		var ischecked=$("input[type='checkbox']").is(':checked');
			layer.confirm('你确定要删除吗？', {icon: 3}, function(index){
				layer.close(index);
				//alert(url);
				window.location.href=url;
			});
	}
	//删除
	function mydeleteAll(url){
		var ischecked=$("input[type='checkbox']").is(':checked');
		if(!ischecked){
            bootbox.confirm({
                title: "系统提示",
                message: "请勾选要删除的行！",
                callback: function (ischecked) {
                    if (!ischecked) {
                    	return;
                    }
                },
                buttons: {
                    "cancel": {"label": "取消"},
                    "confirm": {
                        "label": "确定",
                        "className": "btn-danger"
                    }
                }
            });
        }else{
			layer.confirm('你确定要删除吗？', {icon: 3}, function(index){
				layer.close(index);
				//alert(url);
				window.location.href=url;
			});
		}
	}	
	function selectAll(){ 
		
		if ($("#SelectAll").prop("checked")) {
			$(":checkbox").prop("checked", true);  
		} else {  
			$(":checkbox").prop("checked", false);  
		}  
	}

	$("#delete").click(function () {
			var ischecked=$("input[type='checkbox']").is(':checked');
            bootbox.confirm({
                title: "系统提示",
                message:  ischecked==true? "是否要删除所选内容？":"没选择要删除的内容",
                callback: function () {
                    if (ischecked) {
                        $("#export-form").submit();
                    }
                },
                buttons: {
                    "cancel": {"label": "取消"},
                    "confirm": {
                        "label": "确定",
                        "className": "btn-danger"
                    }
                }
            });
        });
        $(".del").click(function () {
            //var url = $(this).attr('val');
			$(this).parents("tr").find("td").eq(0).children().attr("checked", true);
         	var ischecked=$("input[type='checkbox']").is(':checked');
            var checkedCount=$("input[type='checkbox']:checked").length;
            bootbox.confirm({
                title: "系统提示",
                message: (checkedCount!=1 && ischecked==true)? "一次只能删除一条内容":(ischecked==true? "是否要删除所选内容？":"没选择要删除的内容"),
                callback: function (ischecked) {
                    if (ischecked && checkedCount==1 ) {
                        //window.location.href = url;
                    	$("#export-form").submit();
                    }
                },
                buttons: {
                    "cancel": {"label": "取消"},
                    "confirm": {
                        "label": "确定",
                        "className": "btn-danger"
                    }
                }
            });
        });

//		$(".check-all").click(function () {
//            $(".ids").prop("checked", this.checked);
//        });
//        $(".ids").click(function () {
//            var option = $(".ids");
//            option.each(function (i) {
//                if (!this.checked) {
//                    $(".check-all").prop("checked", false);
//                    return false;
//                } else {
//                    $(".check-all").prop("checked", true);
//                }
//            });
//        });