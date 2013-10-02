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

								<h2>后台管理>>礼品订单管理</h2>

							</div></td>

					</tr>

					<tr>

						<td><div class="zhuti">

								<ul>

									<li class="current">礼品订单管理</li>

								</ul>

							</div></td>

					</tr>

					<tr>

					  <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/product/save_order'),array('id'=>'productform'));?>

                        <input type="hidden" name="poid" value="<?php echo $poid ?>" />

                       

                 
                        <table width="100%" cellpadding="0"  cellspacing="5" class="xx">

								<tr style="background: #fffef2;">

									<td colspan="4" class="left"

										style="height: 30px; line-height: 30px; width: 120px; padding-left: 20px; border: #f9d8b4 1px solid; color: #e86f0d;"><h2 style="float:left">礼品订单管理</h2></td>

								</tr>

								<tr>

									<td colspan="4" bgcolor="#E3E3FF" >订单信息</td>

								</tr>

                                <tr>

									<td class="right" width="122">编号：</td>

									<td width="729" colspan="3"><?php echo $poNum ?></td>

								</tr>

								<tr>

									<td class="right" width="122">申请人：</td>

									<td colspan="3"><?php echo $name ?></td>

								</tr>

								<tr>

									<td class="right" width="122">电话：</td>

									<td colspan="3"><?php echo $phone ?></td>

								</tr>

								<tr>
								  <td class="right">地址：</td>
								  <td colspan="3" class="td_left"><?php echo $address ?></td>
								  </tr>
								
								<tr>

	                                <td class="right" width="122">下单时间：</td>

	                                <td colspan="3" class="td_left"><?php echo date("Y-m-d H:i:s",$addTime); ?></td>

	                            </tr>
<tr>

									<td class="right" width="122">状态：</td>

									<td colspan="3"><?php echo $this->model_config->get_gift_ary($state) ?></td>

						  </tr>
                          <tr>

	                                <td class="right" width="122">操作：</td>

	                                <td colspan="3" class="td_left"><input type="button" name="button" id="button" value="审核通过" onclick="window.location.href='/easyou/product/order_state/<?php echo $poid ?>/1'" /> <input type="button" name="button2" id="button2" value="审核不通过" onclick="window.location.href='/easyou/product/order_state/<?php echo $poid ?>/4'" /> <input type="button" name="button3" id="button3" value="已发货" onclick="window.location.href='/easyou/product/order_state/<?php echo $poid ?>/2'" /> <input type="button" name="button4" id="button4" value="已领取" onclick="window.location.href='/easyou/product/order_state/<?php echo $poid ?>/3'" />
                                    <input type="button" name="button4" id="button4" value="已失效" onclick="window.location.href='/easyou/product/order_state/<?php echo $poid ?>/5'" />
                                    </td>

	                            </tr>
                            	<tr>
                            	  <td colspan="4" class="right">&nbsp;</td>
                           	  </tr>
                            	<tr>
                            	  <td colspan="4" bgcolor="#E3E3FF" >酒店信息</td>
                           	  </tr>
                            	<tr>
                            	  <td class="right">礼品名称：</td>
                            	  <td colspan="3" ><?php echo $ProductName ?>&nbsp;</td>
                           	    </tr>
                            	<tr>
                            	  <td class="right">礼品类型：</td>
                            	  <td colspan="3" ><?php echo $this->model_config->product_type_ary($ProductType) ?></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">物流公司：</td>
                            	  <td colspan="3" ><input name="wuli_company" type="text" id="wuli_company" value="<?php echo $wuli_company ?>" /></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">快递单号：:</td>
                            	  <td colspan="3" ><input name="wuli_num" type="text" id="wuli_num" value="<?php echo $wuli_num ?>" /></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">&nbsp;</td>
                            	  <td colspan="3" ><input type="submit" name="button5" id="button5" value="提交" /></td>
                          	  </tr>
                            	
                            
                            	<tr>

									<td class="right" width="122"></td>

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