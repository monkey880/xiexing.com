<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<title>携行网－后台管理系统</title>

</head>



<body>

<div class="container">

    <?php $this->load->view('admin/admin_header');?>

    <div class="box">

        <?php $this->load->view('admin/admin_left');?>

        <div class="box_right">

            <table width="100%" cellpadding="0" cellspacing="0" class="ym_bk">

            <tr><td>

            <div class="wzdh"><h2>后台管理>>酒店管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">礼品订单</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="10">


                        </td>

                        <td></td>

                       </tr>

                       <tr class="bt">

                       	<td width="5%">&nbsp;</td>

                        <td>订单编号</td>

                        <td style="border-left:none;">礼品名称</td>

                        <td style="border-left:none;">礼品类型</td>

                        <td style="border-left:none;">申请人</td>

                        <td style="border-left:none;">电话</td>
                        
                         <td style="border-left:none;">下单时间</td>
                        
                        <td style="border-left:none;">状态</td>

                        <td style="border-left:none; width:181px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($hotellist) > 0 ) {

                            foreach ($hotellist as $hotel) { ?>

                       <tr>

                        <td class=""><input name="hotel_box" type="checkbox" value="<?php echo $hotel['poid'] ;?>" /></td>

                        <td class="left"><?php echo $hotel['poNum'] ;?></td>

                        <td class="f_f60"><a href="<?php echo site_url('/gift/info/'.$hotel['poid']) ;?>"><?php echo $hotel['ProductName'];?></a></td>

                        <td><?php echo $this->model_config->product_type_ary($hotel['ProductType']);?></td>

                        <td class="f_f60"><?php echo $hotel['name'];?></td>
                        
                        <td class="f_f60"><?php echo $hotel['phone'];?></td>
                        
                          <td class="f_f60"><?php echo date('Y-m-d H:i:s',$hotel['addTime']);?></td>
                        
                        
                       
                        </td>
                        
                        
                        
                        <td class="f_f60"><?php echo $this->model_config->get_gift_ary($hotel['state']) ?></td>

                    

                       <td><?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/product/orderinfo/'.$hotel['poid'].'/'.$page); ?>">查看</a><?php } ?>   </td></tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="7">还没有信息，赶紧添加吧!</td></tr>';

                       } ?>

                       <tr><td colspan="7" class="left" style="height:60px;" >

                       <div class="fy">

                            <?php echo $pagenav;?>

                         </div>

                       </td></tr>

                   </table>

            </td></tr>

            </table>

        </div>

    </div>

<?php $this->load->view('admin/admin_footer');?>

</div>



</body>

</html>