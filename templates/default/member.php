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
</script>
</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

	<?php $this->load->view('inc/nav');?>

	<div class="main"><br /> 

		<div id="maincontent" style=";">
     
        
 <div class="user">
  <div class="user_nav">
    <ul>
      <li><a href="myorder" id="user_curr">我的订单</a></li>
      <li><a href="mod_password.asp?p=http://www.xexing.com|_|酒店预订网|_|3706736|_|5298a9488aa16dac|_|950aacbeee0f5fc295574|_|">修改密码</a></li>
      <li><a href="login_out.asp?p=http://www.xexing.com|_|酒店预订网|_|3706736|_|5298a9488aa16dac|_|950aacbeee0f5fc295574|_|">退出系统</a></li>
    </ul>
  </div>
  <div class="user_main">
    <h2><span>我的订单</span></h2>
    <div class="user_list">
      <ul>
        <li class="title"><div><span>预订房型</span><span class="s_riqi">入住日期</span><span>订单状态</span><span>状态说明</span><span>操作</span></div>酒店名称</li>
 
	</ul>
  <div style="text-align:center; padding:20px;">没有订单！</div>
    </div>

    <!--<div id="page"> <strong>1</strong> <a title="第2页">2</a> <a title="第3页">3</a> <a title="&amp;gt;&amp;gt;">&gt;&gt;</a> <a title="..165">..165</a> <a title="..166">..166</a> </div>-->
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