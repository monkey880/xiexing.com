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
        <h2>找回密码！</h2>
        <form action="lostpassword2" method="post" name="aForm" id="aForm">
          <ul>
            <li>
              <label for="mobile">手机号:</label>
              <input type="text" class="reg_text" id="username" name="username">
              <span class="col_help">输入您注册时的手机号</span> </li>
            <li>
              <label for="mobile2">验证码:</label>
              <input type="text" class="reg_text" id="captcha" name="captcha">
              <img width="70" id="captcha_img" onclick="refresh_captcha();" height="30" alt="点击刷新验证码" src="<?php echo base_url('data/captcha').'/'.$time.'.jpg'?>"  style="display:inline"/>
           
            <li style="padding-left:86px;">
              <input type="submit" class="reg_btn" value="找回密码" id="button" name="button">
              
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
<script type="text/javascript">
function refresh_captcha()

{

	var url = "<?php echo site_url('/user/refresh_captcha')?>?"+Math.random(1); 

	

	$.get(url, function(data){

		var dataObj=eval('('+ data +')'); 

		var picurl = '<?php echo base_url('data/captcha').'/'?>'+dataObj.time+'.jpg';

	    $('#captcha_img').attr('src',picurl);

	});	

}

</script>

</body>

</html>