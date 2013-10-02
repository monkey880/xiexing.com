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
<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.easing-1.3.pack.js" type="text/javascript"></script>

<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$(function(){
	$("a.iframe").fancybox({
			'width':'50%',
			'height':'60%',
			'autoDimensions':'false'
			
		});
		
		
		$("#getSms").click(function(){
			$.ajax({

			type: "GET",

			url: "<?php echo base_url() ?>user/sendSmsCheck?type=2&mobile="+$("#mobile").val(),
			
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
     
        
 <div class="user">
  <?php $this->load->view('inc/user_nav');?>
  <div class="user_main">
    <h2><span><?php echo $title ?></span></h2>
<div class="user_list">
<?php if($isbank){ ?>

<form action="/member/tixian" method="post">
<input name="mobile" type="hidden" id="mobile" value="<?php echo $mobile_phone;?>" />
<input name="action" type="hidden" value="tixian" />
<table width="100%" border="0">
  <tr>
    <td colspan="2"><p>您还没有绑定银行卡，请先绑定</p>
      <p>提现目前仅支持建设银行的借记卡。提现银行卡不必开通网银。</p></td>
    </tr>
  <tr>
    <td width="15%">银行帐号</td>
    <td width="85%"><?php echo $bank_name ?> &nbsp;&nbsp;&nbsp;<?php echo $bank_num ?>&nbsp;&nbsp;&nbsp;<?php echo $bank_renname ?></td>
  </tr>
  <tr>
    <td>提现金额</td>
    <td><label for="jiner"></label>
      <input name="jiner" type="text" id="jiner" size="10" />
      元</td>
  </tr>
  <tr>
    <td>验证码</td>
    <td><label for="yzm"></label>
      <input name="yzm" type="text" id="yzm" size="10" />
      <input id="getSms" type="button" name="button"  value="获取验证码" /><span id="mobile4Tip"></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button2" id="button2" value="提交" /></td>
  </tr>
</table></form>
<?php }else{?>
<form action="/member/tixian" method="post">
<input name="mobile" type="hidden" id="mobile" value="<?php echo $mobile_phone;?>" />
<input name="action" type="hidden" value="bank" />
<table width="100%" border="0">
  <tr>
    <td colspan="2"><p>您还没有绑定银行卡，请先绑定</p>
      <p>提现目前仅支持建设银行的借记卡。提现银行卡不必开通网银。</p></td>
    </tr>
  <tr>
    <td width="15%">开户行</td>
    <td width="85%">建设银行</td>
  </tr>
  <tr>
    <td>帐号</td>
    <td><label for="bank_num"></label>
      <input name="bank_num" type="text" id="bank_num" size="30" /></td>
  </tr>
  <tr>
    <td>姓名</td>
    <td><label for="bank_num"></label>
      <input name="bank_renname" type="text" id="bank_renname" size="10" /></td>
  </tr>
  <tr>
    <td>验证码</td>
    <td><label for="yzm"></label>
      <input name="yzm" type="text" id="yzm" size="10" />
     <input id="getSms" type="button" name="button"  value="获取验证码" /><span id="mobile4Tip"></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button2" id="button2" value="提交" /></td>
  </tr>
</table></form>
<?php }?>
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