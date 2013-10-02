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
<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/formValidator/formValidator-4.0.1.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/formValidator/formValidatorRegex.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/formValidator/style/validator.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({formID:"regform",debug:false,submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			alert(msg);
		},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...'
	});

	$("#mobile").formValidator({onShow:"请输入手机号",onFocus:"",onCorrect:"可以使用"}).inputValidator({min:11,max:11,onError:"请输入正确的手机号码"}).regexValidator({regExp:"mobile",dataType:"enum",onError:"你输入的手机号码格式不正确"})
	
	.ajaxValidator({
		dataType : "html",
		async : true,
		url : "<?php echo base_url();?>user/checkuserinfo?type=1",
		success : function(data){
            if( data== '0' ) return true;
            if( data=='1' ) return false;
			return false;
		},
		buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "该用户已注册，请直接登录",
		onWait : "正在对用户名进行合法性校验，请稍候..."
	});

	$("#password").formValidator({onShow:"请输入密码",onFocus:"至少6个字符",onCorrect:" "}).inputValidator({min:6,empty:{leftEmpty:false,rightEmpty:false,emptyError:"密码两边不能有空符号"},onError:"密码不能为空,请确认"});
	$("#password2").formValidator({onShow:"输再次输入密码",onFocus:"至少6个字符",onCorrect:"密码一致"}).inputValidator({min:6,empty:{leftEmpty:false,rightEmpty:false,emptyError:"重复密码两边不能有空符号"},onError:"重复密码至少6个字符,请确认"}).compareValidator({desID:"password",operateor:"=",onError:"2次密码不一致,请确认"});
	$("#Email").formValidator({onShow:"请输入邮箱",onFocus:"邮箱6-100个字符,输入正确了才能离开焦点",onCorrect:"恭喜你,你输对了",defaultValue:"@"}).inputValidator({min:6,max:100,onError:"你输入的邮箱长度非法,请确认"}).regexValidator({regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onError:"你输入的邮箱格式不正确"});
	
	$("#mobile4").formValidator({onShow:"请输入短信验证码",onFocus:"请输入短信验证码",onCorrect:" "}).inputValidator({min:4,max:4,onError:"请输入正确的短信验证码"})
	.ajaxValidator({
		dataType : "html",
		async : true,
		url : "<?php echo base_url();?>user/checksms?",
		success : function(data){
            if( data== '0' ) return true;
            if( data=='1' ) return false;
			return false;
		},
		buttons: $("#button"),
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "您输入的短信验证码不正确",
		onWait : "正在对短信验证码校验，请稍候..."
	});
	
	$("#getSms").click(function(){
			$.ajax({

			type: "GET",

			url: "<?php echo base_url() ?>user/sendSmsCheck?mobile="+$("#mobile").val(),
			
			beforeSend : function(data)

			{

				$("#getSms").disabled='disabled';


			},


			success: function(msg)

			{
				$('#mobile4Tip').html('短信验证码已发送');	

	        },

			timeout:20000,

			error: function () 

			{	


				$('#mobile4Tip').html='请求超时请重试';	

			}

		});
	});
});
</script>
</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

	<?php $this->load->view('inc/nav');?>

	<div class="main"><br /> 

		<div id="maincontent" style=";">

		   <div style="margin:0pt auto;width:950aacbeee0f5fc295574px">
<div id="reg">
      <div id="reg_con">
        <h2>立即注册会员！</h2>
        <form name="regform" id="regform" action="regedit_save" method="post">
          <ul>
            <li>
              <label for="mobile">手机号:</label>
              <input type="text" empty="false" type_="mobile" class="reg_text" id="mobile" name="mobile">
              <span id="mobileTip" style="width:250px"></span></li>
            <li>
              <label for="mobile2">密码:</label>
              <input type="password" empty="false" type_="password" class="reg_text" id="password" name="password">
              <span id="passwordTip" style="width:250px"></span> </li>
            <li>
              <label for="mobile3">确认密码:</label>
              <input type="password" empty="false" type_="password2" class="reg_text" id="password2" name="password2">
              <span id="password2Tip" style="width:250px"></span> </li>
            <li>
              <label for="mobile4">Email:</label>
              <input type="text"  class="reg_text" id="Email" name="Email">
              <span id="EmailTip" style="width:250px"></span> </li>
            <li class="hidden">
              <label for="mobile4">短信验证码:</label>
              <input type="text" class="reg_text" id="mobile4" name="mobile4"><input id="getSms" type="button" value="点击获取" />
              <span id="mobile4Tip" style="width:250px"></span></li>
            <li style="padding-left:86px;">
              <input type="hidden" value="1" id="step" name="step">
              <input type="submit" class="reg_btn" value="立即注册" id="button" name="button">
               
            </li>
          </ul>
        </form>
      </div>
      
      <div id="reg_other">
        <ul>
          <li>如果您已经是会员，请登录</li>
          <li><a href="./"><img width="88" height="24" src="/public/images/reg_login.gif"></a></li>
          <li>忘记密码，<a href="lostpassword">请点这里找回</a></li>
        </ul>
      </div>
      
    </div>
</div>
		</div>

	</div>

</div>

<div class="inbz"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/inbz.jpg" width="950" height="57" /></div>

<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

</body>

</html>