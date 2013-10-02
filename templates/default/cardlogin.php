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

	$("#cardnum").formValidator({onShow:"请输入会员卡号",onFocus:"会员卡6个数字",onCorrect:""}).inputValidator({min:6,empty:{leftEmpty:false,rightEmpty:false,emptyError:"会员卡两边不能有空符号"},onError:"会员卡号不能为空,请确认"});
	
	
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
        <h2>会员卡登录酒店预订网！</h2>
        <form action="/user/cardlogin" method="post" name="regedit" id="regedit">
        <input name="url" type="hidden" value="<?php echo $url; ?>" />
        <input name="action" type="hidden" value="login" />
        <ul id="errorlist"></ul>
          <ul>
            <li>
              <label for="mobile">手机号:</label>
              <input type="text" class="reg_text" id="username" name="username">
              <span id="usernameTip" style="width:250px"></span> </li>
            <li>
              <label for="mobile2">会员卡号:</label>
              <input type="text" class="reg_text" id="cardnum" name="cardnum">
              <span class="col_help">输入您的会员卡号</span> </li>
          
            <li style="padding-left:86px;">
              <input type="button" value=" " style="background:url(/public/images/ajaxLoader.gif) no-repeat scroll center center transparent;cursor: auto;display:none;" class="reg_btn" id="loginloading">
              <input type="submit" class="reg_btn" value="立即登录" id="button" name="button">
              
            </li>
          </ul>
        </form>
      </div>
      
          <div id="reg_other">
            <ul>
              <li>如果您还不是会员，请注册</li>
              <li><a href="regedit"><img width="88" height="24" src="/public/images/reg_reg.gif"></a></li>
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