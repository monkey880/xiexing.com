<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $keywords_array['k_title'] ?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />

<meta name="description" content="><?php echo $keywords_array['k_description'] ?>" />
<style>
body {background:none}
table { border-collapse:collapse; margin-top:4px;}
td {
	border-bottom:1px solid #eee;
	padding:6px;
	line-height: 20px;
}
textarea { overflow:auto; width:98%;}
.question_post { padding:12px 30px; width:536px;}
.question_post h1 { font-size:16px; height:40px; line-height:40px; padding-left:40px; border-bottom:2px solid #ddd; background:url(/Images/report_32.png) 0 3px no-repeat;}
</style>
</head>

<body>
<div class="question_post">
  <h1>订单详情：</h1>
  <?php if($action=='gift'){?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right" valign="top">订单编号：</td>
      <td><strong><?php echo $poNum; ?></strong> </td>
    </tr>
    <tr>
      <td align="right" valign="top">订单状态：</td>
      <td><span class="f_14b_f00"><?php echo $this->model_config->product_order_state($state) ?></span></td>
    </tr>
    <tr>
      <td align="right" valign="top">礼品类型：</td>
      <td><span class="f_14b_f00"><?php echo $this->model_config->product_type_ary($ProductType) ?></span></td>
    </tr>
      <tr>
        <td width="80" align="right" valign="top">礼品名称：</td>
        <td valign="top"><a href="/giftinfo/<?php echo $poid ?>" target="_blank"><?php echo $ProductName ?></a></td>
      </tr>
      <tr>
        <td align="right" valign="top">物流信息： </td>
        <td valign="top">快递公司：<?php echo $wuli_company ?><br />
          快递单号：<?php echo $wuli_num ?><br />
         </td>
      </tr>
     <!-- <tr>
        <td align="right" valign="top">价格明细：</td>
        <td valign="top" style="width:440px;table-layout: fixed;WORD-BREAK: break-all; WORD-WRAP: break-word"><strong>2013-05-31:245&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
      </tr>-->
      
     <!-- <tr id="reg">
        <td align="right" valign="top">奖金：</td>
        <td valign="top"><strong><font color="#FF0000">18元</font></strong> （来自住哪网合作网站,如需点评请联系客服010-61136611-2）</td>
      </tr>-->
      
     
      
    </form>
    </table>
    <?php } else{?>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="10">
    <tr>
      <td align="right" valign="top">订单编号：</td>
      <td><strong><?php echo $orderNum; ?></strong> </td>
    </tr>
    <tr>
      <td align="right" valign="top">订单状态：</td>
      <td><span class="f_14b_f00"><?php if($action=='gift') {echo $this->model_config->get_gift_ary($state);} else{ echo $this->model_config->hotelorder_status_ary($state);} ?></span></td>
    </tr>
    <tr>
      <td align="right" valign="top">订单类型：</td>
      <td><span class="f_14b_f00"><?php echo $this->model_config->order_type_ary($type) ?></span></td>
    </tr>
      <tr>
        <td width="80" align="right" valign="top">酒店名称：</td>
        <td valign="top"><a href="/hotelinfo/<?php echo $hotel_id ?></a>" target="_blank"><?php echo $hotel_name ?></a></td>
      </tr>
      <tr>
        <td align="right" valign="top">订单明细： </td>
        <td valign="top">房型：<?php echo $roomtitle ?><br />
          房数：<?php echo $roomnumber ?>间(人)<br />
          总价：<font color="#FF0000"><?php echo $roomallprice ?></font> 元(前台支付)&nbsp;&nbsp;&nbsp;&nbsp;  返现：<font color="#FF0000"><?php echo $TotalJiangjin ?></font>元<br />
          
        入住：<?php echo date('Y-m-d',$CheckInDate) ?>&nbsp;&nbsp;离店:<?php echo date('Y-m-d',$CheckOutDate) ?></td>
      </tr>
     <!-- <tr>
        <td align="right" valign="top">价格明细：</td>
        <td valign="top" style="width:440px;table-layout: fixed;WORD-BREAK: break-all; WORD-WRAP: break-word"><strong>2013-05-31:245&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
      </tr>-->
      
     <!-- <tr id="reg">
        <td align="right" valign="top">奖金：</td>
        <td valign="top"><strong><font color="#FF0000">18元</font></strong> （来自住哪网合作网站,如需点评请联系客服010-61136611-2）</td>
      </tr>-->
      
      <tr>
        <td align="right" valign="top">入住人：</td>
        <td>姓名：<?php echo $Customername ?><br />
        手机：<?php echo $phone ?></td>
      </tr>
      
    </form>
    </table>
    <?php }?>
</div>
</body>
</html>