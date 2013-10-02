<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $keywords_array['k_title'] ?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />

<meta name="description" content="><?php echo $keywords_array['k_description'] ?>" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/formValidator/formValidator-4.0.1.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/formValidator/formValidatorRegex.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/formValidator/style/validator.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({formID:"regedit",debug:false,submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			alert(msg);
		},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...'
	});

	$("#username").formValidator({onShow:"请输入手机号",onFocus:"",onCorrect:"可以使用"}).inputValidator({min:11,max:11,onError:"请输入正确的手机号码"}).regexValidator({regExp:"mobile",dataType:"enum",onError:"你输入的手机号码格式不正确"});

	$("#password").formValidator({onShow:"请输入密码",onFocus:"至少6个长度",onCorrect:"密码合法"}).inputValidator({min:6,empty:{leftEmpty:false,rightEmpty:false,emptyError:"密码两边不能有空符号"},onError:"密码不能为空,请确认"});
	
	
});
function loginCheck(){
	$('#frmlogin').submit();
}
</script>
</head>

<body>

<div class="fastLogin">
    <div class="fastLoginText">
      <ul class="reds">
            <p>直接预订</p>
            <li>如果您不是我们的会员，点击下面的按钮继续</li>
            <li><input type="button" onclick="top.location='<?php echo base_url();?><?php echo urldecode($url); ?>';return false;" class="btn124x32" value="继续预订"></li>
            <li style="color:#666;">订单提交后系统会自动将您注册为携行网会员。</li>
        </ul>
		 <form action="/user/login" method="post" name="frmlogin" id="frmlogin">
        <input name="url" type="hidden" value="<?php echo $url; ?>" />
        <ul class="logins">
            <p>老会员登录并预订</p>
			<li id="error_msg" style="color:#F00; display:none"></li>
            <li>手机号：<input type="text" class="fastLoginInputTit" id="username" name="username"><span class="col_help"></span></li>
            <li>密&nbsp;&nbsp;码：<input type="password" class="fastLoginInputTit" id="password" name="password"><span class="col_help"></span></li>
            <li><input type="button" onclick="loginCheck()" class="btn124x32" value="登陆，继续预订" id="button" name="button"> <a target="_blank" style="color:#060;" href="/?r=user/getpwd">忘记密码？</a></li>
            <li><input type="button" onclick="top.location='/user/regedit/?url=<?php echo $url; ?>';return false;" id="regbutton" class="btn124x32gr" value="免费注册会员"></li>
			
        </ul>
		</form>
    </div>
</div>
</body>

</html>