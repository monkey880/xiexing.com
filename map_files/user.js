//无刷新页面验证登录信息
function checklogin(obj){
    var username = $('#username').val();
    var password = $('#password').val();
    var bol=false;
    if(username==''||username=="请输入手机号/账号/邮箱") {
		$('#login_msg').css('display','block');
		$('#err_email').html('请输入手机号/账号/邮箱');
		$('#err_pw').css('background','none');
		$.colorbox.resize();
		return false;
	} else {
		$('#login_msg').css('display','none');
		$('#err_email').html('');
		$('#err_pw').attr('style','');
	}
	
	var strP = /\s/;
	if (password=='') {
		$('#login_msg').css('display','block');
		$('#err_pw').html('请输入密码');
		$('#err_email').css('background','none');
		$.colorbox.resize();
		return false;
	} else if (strP.test(password)==true) {
		$('#login_msg').css('display','block');
		$('#err_pw').html('密码请勿使用空格');
		$('#err_email').css('background','none');
		$.colorbox.resize();
		return false;
	} else if(password.length<6) {
		$('#login_msg').css('display','block');
		$('#err_pw').html('密码太短了，最少6位。');
		$('#err_email').css('background','none');
		$.colorbox.resize();
		return false;
	} else if(password.length>16) {		
		$('#login_msg').css('display','block');
		$('#err_pw').html('密码太长了，最多16位。');
		$('#err_email').css('background','none');
		$.colorbox.resize();
		return false;
	} else {
		$('#login_msg').css('display','none');
		$('#err_pw').html('');
		$('#err_email').attr('style','');
	}
	//$.colorbox.resize();
	$.ajax({
		type:"post",
		async:false,
		url:user_php_self+"?m=accounts.checklogin",
		data:"username="+username+"&password="+password,
		success:function(result){		
			if(result.success) {
				if(result.message.isxiugai==1){
					if(result.message.uid>0){
				       bol=true;
					}else{
						$('#login_msg').css('display','block');
						$('#err_email').html('数据错误');
						$('#err_pw').css('background','none');
						bol=false;
					}
				}else{
					$('#login_msg').css('display','block');
					$('#err_email').css('width','399px');
					$('#err_email').html('您的密码过于简单，请点击下面”忘记密码“修改密码');
					$('#err_pw').css('background','none');
					bol=false;
				}
			}else{
				if(result.status==201){
					$('#login_msg').css('display','block');
					$('#err_email').html('手机号不存在');
					$('#err_pw').css('background','none');
				}else if(result.status==202) {
					$('#login_msg').css('display','block');
					$('#err_email').html('邮箱不存在');
					$('#err_pw').css('background','none');
				}else if(result.status==203) {
					$('#login_msg').css('display','block');
					$('#err_email').html('用户名不存在');
					$('#err_pw').css('background','none');
				}else if(result.status==204) {
					$('#login_msg').css('display','block');
					$('#err_pw').html('密码不正确');
					$('#err_email').css('background','none');
				}else if(result.status==205) {
					$('#login_msg').css('display','block');
					$('#err_email').css('width','399px');
					$('#err_email').html('当天密码输入错误次数超出限制，请联系网站管理员');
					$('#err_pw').css('background','none');
				}else if(result.status==206) {
					$('#login_msg').css('display','block');
					$('#err_email').css('width','399px');
					$('#err_email').html('十五分钟内密码输入错误次数超出限制，请稍后再试');
					$('#err_pw').css('background','none');
				}				
				bol=false;
			}
			//$.colorbox.resize();
		}
	});
	$.colorbox.resize();
    return bol;
}

function showusername(obj){
    $("#username").addClass("focused");
    if(obj.value == "请输入手机号/账号/邮箱"){
		obj.value = "";
	}
}

function hideusername(obj){
    $("#username").removeClass("focused");
	if(obj.value == ""){
		obj.value = "请输入手机号/账号/邮箱";
	}
}

function hidepwlable(){
	$("#password").addClass("focused");
	$("#pwlable").hide();
}

function showpwlable(obj){
    var password = $("#password").val();
    if(password == "") {
		$("#pwlable").show();
	} else {
		$("#pwlable").hide();
	}
	$("#password").removeClass("focused");
}

/**
 * 取字符串字节长度
 */
function getLength(str) {
    ///<summary>获得字符串实际长度，中文2，英文1</summary>
    ///<param name="str">要获得长度的字符串</param>
    var realLength = 0, len = str.length, charCode = -1;
    for (var i = 0; i < len; i++) {
        charCode = str.charCodeAt(i);
        if (charCode >= 0 && charCode <= 128) realLength += 1;
        else realLength += 2;
    }
    return realLength;
};

$(document).ready(function(){
	$("#top_center").live('mouseover',function(){
		$("#mtip").hide();								   
		$(this).addClass('head_on');								   
		$(this).children("li").first().attr('class','down');
		$(this).children("li:gt(0)").each(function() {						
			$(this).show();					
		});
	});
	$("#top_center").live('mouseout',function(){
		$(this).removeClass('head_on');								   
		$(this).children("li").first().attr('class','up');
		$(this).children("li:gt(0)").each(function() {						
			$(this).hide();					
		});
	});
	$("#mtip").find("u").live('click',function(){					
		$("#mtip").hide();
		$.cookie('tipclose', 1, { expires: 1 }); 
	});
});