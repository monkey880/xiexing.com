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
    <!--<div class="list_nav"><a href="/member/freeroomorder/1">试住客房订单</a> <a href="/member/freeroomorder/2">住七送一订单</a> <a href="/member/freeroomorder/3">住六送一订单</a></div>-->
<div class="user_list">
  <?php if($orderlist) {?>
  <table width="100%" border="0" cellpadding="5">
  <tr class="order_list_title">
    <td width="190">订单编号</td>
    <td width="140">礼品名称</td>
    <td>礼品类型</td>
    <td>申请/兑换时间</td>
    <td>订单状态</td>
    <td>操作</td>
  </tr>
  <?php foreach($orderlist as $list){?>
  <tr class="list_order">
    <td><?php echo $list['poNum'] ?></td>
    <td><a href="/giftinfo/<?php echo $list['product_id'] ?>"><?php echo $list['ProductName'] ?></a></td>
    <td><?php echo $this->model_config->product_type_ary($list['ProductType']) ?></td>
    <td><?php echo date('Y-m-d H:i:s',$list['addTime']) ?></td>
    <td><a class="iframe" href="/member/gift_orderinfo/<?php echo $list['poid'] ?>"><?php echo $this->model_config->get_gift_ary($list['state']) ?></a></td>
    <td><?php if($list['state']==0||$list['state']==1){?><a href="/member/cancel_gift_order/<?php echo $list['poid'] ?>/9">取消订单</a><?php } else {echo '-----';}?></td>
  </tr>
   <?php }?>
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