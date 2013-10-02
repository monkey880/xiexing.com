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

            <div class="wzdh"><h2>后台管理>>提现记录</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">提现记录</li>

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

                        <td>ID</td>

                        <td style="border-left:none;">提现金额</td>

                        <td style="border-left:none;">用户名</td>

                        <td style="border-left:none;">银行卡</td>

                        <td style="border-left:none;">提现日期</td>
                        
                        <td style="border-left:none;">状态</td>
                        
                        <td style="border-left:none;">操作</td>

                       </tr>

                       <?php

                       if(count($hotellist) > 0 ) {

                            foreach ($hotellist as $hotel) { ?>

                       <tr>

                        <td class=""><input name="hotel_box" type="checkbox" value="<?php echo $hotel['id'] ;?>" /></td>

                        <td class="left"><?php echo $hotel['id'] ;?></td>

                        <td class="f_f60"><?php echo $hotel['jiner'];?></td>

                        <td><?php echo $hotel['mobile_phone'];?></td>

                        <td class="f_f60"><?php echo $hotel['bank_name'];?><br />
                        <?php echo $hotel['bank_num'];?><br />
                        <?php echo $hotel['bank_renname'];?>
</td>
                        
                        <td class="f_f60"><?php echo date('Y-m-d H:i:s',$hotel['addtime']);?></td>
                        
                        <td class="f_f60"><?php echo $this->model_config->fanxian_status_ary($hotel['status']);?></td>
                        
                        <td class="f_f60">
                        
                         <a class="xg" href="/easyou/hotel/setTixianStatus/2/<?php echo $hotel['id'] ;?>">成功</a> <a class="xg" href="/easyou/hotel/setTixianStatus/1/<?php echo $hotel['id'] ;?>">失败</a> <a class="xg" href="/easyou/hotel/setTixianStatus/3/<?php echo $hotel['id'] ;?>">已退</a></td>
                        
                       </tr>

                       <?php  }

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