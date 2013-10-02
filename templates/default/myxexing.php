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
});
</script>


</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

	<?php $this->load->view('inc/nav');?>

	<div class="main"> <br />


		<div id="maincontent" style=";">
     
        
 <div class="user">
<?php $this->load->view('inc/user_nav');?>
  <div class="user_main myxexing">
    
   
    <div class="user_welcom">您好，尊敬会员，欢迎回来！<br />
  登录名：<?php echo $user_name ?> 手机： <?php echo $mobile_phone ?> 邮箱：<?php echo $email ?> 
</div>
<dl>
<dt><h3>订单信息</h3></dt>
<dd>您当前账户有：（<span class="f_f00"><?php echo $weiruzhu_order ?></span>）条未出行订单，（<span class="f_f00"><?php echo $pingjia_order ?></span>）条待评价订单</dd>
</dl>
<dl>
<dt><h3>我的赠送客房</h3></dt>
<dd>我的订七送一：可领取（<span class="f_f00"><?php echo $zhu7_keling ?></span>），再累计入住（<span class="f_f00"><?php echo $zhu7_hx ?></span>）日间可赠送一间！<br />
  我的订六送一：可领取（<span class="f_f00"><?php echo $zhu6_keling ?></span>），再连续入住（<span class="f_f00"><?php echo $zhu6_sz ?></span>）天可赠送一间！
</dd>
</dl>
<dl>
<dt><h3>我的积分</h3></dt>
<dd>可用积分：<span class="f_f00"><?php echo $UserExp ?></span>分 <a href="/gift">兑换好礼？</a><br />
已冻结积分：<span class="f_f00"><?php echo $dhExp ?></span>分<br />
更多积分换礼，尽在携行免费礼品！</dd>
</dl>
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