<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo base_url('public/js/ueditor')?>/editor_all.js"></script>

<script>window.UEDITOR_HOME_URL = '<?php echo base_url();?>'+"public/js/ueditor/";var imgpath_me = "<?php echo base_url();?>";</script>

<script type="text/javascript" charset="utf-8" src="<?php echo base_url('public/js/ueditor')?>/editor_config.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/js/ueditor/themes/default')?>/ueditor.css" />

<!--选择时间用到的js-->

<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/dialog/dialog.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/swfupload/swfupload.js"></script>

<title>携行网－后台管理系统</title>

<style>

#content {

	width: 750px;

}

</style>

</head>

<body>

	<div class="container">

    <?php $this->load->view('admin/admin_header');?>

    <div class="box">

        <?php $this->load->view('admin/admin_left');?>

        <div class="box_right">

				<table width="100%" cellpadding="0" cellspacing="0" class="ym_bk">

					<tr>

						<td><div class="wzdh">

								<h2>后台管理>>订单管理</h2>

							</div></td>

					</tr>

					<tr>

						<td><div class="zhuti">

								<ul>

									<li class="current">酒店管理</li>

								</ul>

							</div></td>

					</tr>

					<tr>

					  <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/hotel/save_hotel'),array('id'=>'hotelform'));?>

                        <input type="hidden" name="hid" value="<?php echo $hid ?>" />

                       

                 
                        <table width="100%" cellpadding="0"  cellspacing="5" class="xx">

								<tr style="background: #fffef2;">

									<td colspan="4" class="left"

										style="height: 30px; line-height: 30px; width: 120px; padding-left: 20px; border: #f9d8b4 1px solid; color: #e86f0d;"><h2 style="float:left">酒店订单</h2></td>

								</tr>

								<tr>

									<td colspan="4" bgcolor="#E3E3FF" >订单信息</td>

								</tr>

                                <tr>

									<td class="right" width="24">编号：</td>

									<td colspan="3"><?php echo $orderNum ?></td>

								</tr>

								<tr>

									<td class="right" width="24">入住人：</td>

									<td colspan="3"><?php echo $Customername ?></td>

								</tr>

								<tr>

									<td class="right" width="24">电话：</td>

									<td colspan="3"><?php echo $phone ?></td>

								</tr>

								<tr>
								  <td class="right">邮箱：</td>
								  <td colspan="3" class="td_left"><?php echo $email ?></td>
								  </tr>
								<tr>
								  <td class="right">住房日期：</td>
								  <td colspan="3" class="td_left">入：<?php echo date('Y-m-d',$CheckInDate);?> 退：<?php echo date('Y-m-d',$CheckOutDate);?> <font color="#FF0000"><?php echo $tian_num;?></font> 天</td>
								  </tr>
								<tr>
								  <td class="right">预订房型：</td>
								  <td width="49" class="td_left"><?php echo $roomtitle ?></td>
								  <td width="49" class="td_left">间数：</td>
								  <td width="336" class="td_left"><?php echo $roomnumber ?></td>
				          </tr>
								<tr>
								  <td class="right">总价：</td>
								  <td class="td_left"><?php echo $roomallprice ?>元</td>
								  <td class="td_left">反现：<?php echo $TotalJiangjin ?>元</td>
								  <td class="td_left"><?php if($yifanxian>0) {echo '已反现'.$yifanxian.'元';}?></td>
				          </tr>
								<tr>

	                                <td class="right" width="24">下单时间：</td>

	                                <td colspan="3" class="td_left"><?php echo date("Y-m-d H:i:s",$addtime); ?></td>

	                            </tr>
<tr>

									<td class="right" width="24">状态：</td>

									<td colspan="3"><?php echo $this->model_config->hotelorder_status_ary($state) ?></td>

						  </tr>
                          <tr>

	                                <td class="right" width="24">操作：</td>

	                                <td colspan="3" class="td_left"><input type="button" name="button" id="button" value="处理中" onclick="window.location.href='/easyou/hotel/order_state/<?php echo $orderID ?>/0'" /> <input type="button" name="button2" id="button2" value="预定成功" onclick="window.location.href='/easyou/hotel/order_state/<?php echo $orderID ?>/1'" /> <input type="button" name="button3" id="button3" value="已入住" onclick="window.location.href='/easyou/hotel/order_state/<?php echo $orderID ?>/2'" /> <input type="button" name="button4" id="button4" value="已失效" onclick="window.location.href='/easyou/hotel/order_state/<?php echo $orderID ?>/9'" />  <input type="button" name="button4" id="button4" value="客人未到" onclick="window.location.href='/easyou/hotel/order_state/<?php echo $orderID ?>/4'" /><input type="button" name="button4" id="button4" value="反现" <?php if($yifanxian>0){?> disabled="disabled" <?php }?> onclick="window.location.href='/easyou/hotel/jiangjin/<?php echo $orderID ?>/<?php echo $TotalJiangjin ?>'" /></td>

	                            </tr>
                            	<tr>
                            	  <td colspan="4" class="right">&nbsp;</td>
                           	  </tr>
                            	<tr>
                            	  <td colspan="4" bgcolor="#E3E3FF" >酒店信息</td>
                           	  </tr>
                            	<tr>
                            	  <td class="right">酒店名称：</td>
                            	  <td colspan="3" ><?php echo $HotelName ?>&nbsp;</td>
                           	    </tr>
                            	<tr>
                            	  <td class="right">地址：</td>
                            	  <td colspan="3" ><?php echo $Address ?></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">服务：</td>
                            	  <td colspan="3" ><?php echo $Service ?></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">支持银行卡：:</td>
                            	  <td colspan="3" ><?php echo $Card ?></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">餐饮：</td>
                            	  <td colspan="3" ><?php echo $Canyin ?></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">娱乐健身：</td>
                            	  <td colspan="3" ><?php echo $yulejianshen ?></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">客房设施：</td>
                            	  <td colspan="3" ><?php echo $kefangsheshi ?></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">交通：</td>
                            	  <td colspan="3" ><?php echo $Traffic ?></td>
                          	  </tr>
                            
                            	<tr>

									<td class="right" width="24"></td>

									<td colspan="3"></td>

								</tr>

						  </table>

						  </form>

						</td>

					</tr>

				</table>

			</div>

		</div>
    <?php $this->load->view('admin/admin_footer');?>

</div>


<!--选择城市用到的js-->



</body>

</html>