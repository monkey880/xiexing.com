 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title>提交订单 -  <?PHP ECHO CFG_WEBNAME ?>住7送一-最实惠酒店预订平台</title>

<meta name="keywords" content="" />

<meta name="description" content="" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/orderpage.css" type="text/css" rel="stylesheet" />

<link href="http://tp1.znimg.com/css/un_orderpage.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<style>
#book { width:950px;}
#book_top { background:#e0f5fc; color:#295574;}
#book_con {border: 6px solid #e0f5fc; border-width:0 6px 0 6px;}
#book_bot { background:#e0f5fc;}
</style>


</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

    <?php $this->load->view('inc/nav');?>

    <div class="main">

        <div id="maincontent">

            <div id="content">

               
             <div id="book">
    <h1>订单提交成功</h1>
  <div id="book_con1">
    <h2>订单号：<span><?php echo $orderNum ?></span>&#12288;订单已提交，正在为您处理...</h2>
    <div class="ordersave">
      <ul>
        <li>我们将在20分钟内尽快确认您的预订，如有其它疑问，请致电住哪网400-600-2069，我们将竭诚为您服务</li>
        <li>如果您所填写的手机号码或入住人信息有误，此订单将被自动被取消</li>
        <li style="display:none;">因订单是否预订成功是通过短信和邮件的形式告知您的，请保持您的通讯工具为可联系状态（手机为开机状态）或者关注下表中订单状态</li>
      </ul>
      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="ordertable1">
        <tbody><tr>
          <td class="td_r">订单号：</td>
          <td><?php echo $orderNum ?></td>
          <td class="td_r">订单状态：</td>
          <td width="300"><span style="color:#f00; font-weight:bold;">处理中</span></td>
        </tr>
        <tr>
          <td class="td_r">酒店名称：</td>
          <td><?php echo $hotel_name ?></td>
          <td class="td_r">入住日期：</td>
          <td><?php echo date('Y-m-d',$CheckInDate) ?></td>
        </tr>
        <tr>
          <td class="td_r">客房类型：</td>
          <td><?php echo $roomtitle ?></td>
          <td class="td_r">离店日期：</td>
          <td><?php echo date('Y-m-d',$CheckOutDate) ?></td>
        </tr>
        <tr>
          <td class="td_r">房间数量：</td>
          <td><?php echo $roomnumber ?>间</td>
          <td class="td_r">到店时间：</td>
          <td><?php echo $rkTime ?></td>
        </tr>
        <tr>
          <td class="td_r">费用总计：</td>
          <td colspan="3"><strong style="color:#f00">￥<?php echo round($roomallprice) ?></strong></td>
        </tr>
                <tr>
                  <td class="td_r">酒店地址：</td>
                  <td colspan="3"><?php echo $Address ?></td>
                </tr>
        
      </tbody></table>
      <div id="book_note"><h4>注意事项：</h4>
      	<ul>
        	<li>如您选择的房间保留时间超过<font color="red">18点</font>，建议您在<font color="red">入住日18点</font>前与酒店联系确认房间保留时间</li>
          <li>如果您的旅行计划有变动请致电 <font color="red">400-600-2069</font> 修改或取消订单</li>
          <li>如果您需要延住酒店，请致电 <font color="red">400-600-2069</font> 延长订单，以便获得延住期间的奖金</li>
        </ul>
      </div>
      
<div style="padding-bottom:0;" id="otherAct">
  <a href="javascript:location.reload();"><span>刷新当前订单状态</span></a>&#12288;<a href="<?php echo base_url();?>ebook/index/?hid=<?php echo $hotel_id ?>&amp;tm1=<?php echo date('Y-m-d',$CheckInDate) ?>&amp;tm2=<?php echo date('Y-m-d',$CheckOutDate) ?>"><span>继续预订该酒店</span></a>&#12288;<a href="http://www.xexing.com/"><span>返回首页</span></a> &#12288;<a href="javascript:AddFavorite('携行网订单处理详情');"><span>添加至收藏夹</span></a>
</div>
    </div>
  </div>
  <div id="book_bot"></div>
             </div>

            </div>

        </div>   

    </div>

</div>
<div id="test"></div>
<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

</body>

</html>