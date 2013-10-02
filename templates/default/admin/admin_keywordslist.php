<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<title>携行网酒店后台管理系统</title>

</head>



<body>

<div class="container">

    <?php $this->load->view('admin/admin_header');?>

    <div class="box">

        <?php $this->load->view('admin/admin_left');?>

        <div class="box_right">

            <table width="100%" cellpadding="0" cellspacing="0" class="ym_bk">

            <tr><td>

            <div class="wzdh"><h2>后台管理>>页面关键字管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">页面关键字管理</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="bt">

                        <td width="5%">编号</td>

                        <td style="border-left:none;">页面名称</td>

                        <td style="border-left:none;">页面地址</td>

                        <td style="border-left:none;">修改日期</td>

                        <td style="border-left:none; width:141px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($keywordsList) > 0 ) {

                            foreach ($keywordsList as $keywords) { ?>

                       <tr>

                        <td class=""><?php echo $keywords['k_id'] ;?></td>

                       	<td class="left"><?php echo $keywords['k_pagename'] ;?></td>

                       	<td class="left"><?php echo $keywords['k_page'] ;?></td>

                       	<td class=""><?php echo $keywords['time_show'] ;?></td>

                       	<td><?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/keywords/add_keywords/'.$keywords['k_id'].'/'.$page); ?>">修改</a><?php } ?></td>

                       </tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="6">还没有页面关键字，赶紧添加吧!</td></tr>';

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