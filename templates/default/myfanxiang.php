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

	<div class="main"><br /> 

		<div id="maincontent" style=";">
     
        
 <div class="user">
  <?php $this->load->view('inc/user_nav');?>
  <div class="user_main">
    <h2><span><?php echo $title ?></span></h2>
<div class="user_list">
  <?php if($orderlist) {?>
  <table width="100%" border="0" cellpadding="5">
  <tr class="order_list_title">
    <td width="190" bgcolor="#F1F1F1">订单编号</td>
    <td width="140" bgcolor="#F1F1F1">返现金额</td>
    <td bgcolor="#F1F1F1">返现日期</td>
    
    
  </tr>
  <?php foreach($orderlist as $list){?>
  <tr class="list_order">
    <td bgcolor="#DBF3FF"> <?php echo $list['orderNum'] ?></td>
    <td bgcolor="#DBF3FF"><?php echo $list['TotalJiangjin'] ?></td>
    <td bgcolor="#DBF3FF"><?php echo date('Y-m-d H:i:s',$list['addtime']);?></td>
  </tr>
   <?php }?>
   <tr>
    <td height="30" colspan="4" bgcolor="#F1F1F1">&nbsp;&nbsp;可兑换积分：<?php echo $UserExp-$dhExp ?>&nbsp;&nbsp;&nbsp;&nbsp;帐户总积分：<?php echo $UserExp ?></td>
    </tr>
</table>

     
    <?php }else{?>
  <div style="text-align:center; padding:20px;">没有订单！</div>
  </div>
<?php }?>
   
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