<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<!--选择时间用到的js-->

<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<title>携行网酒店后台管理系统</title>

<style>

#content{

    width:750px;

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

                            <h2>后台管理>>页面关键字管理</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">页面关键字管理</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/keywords/save_keywords'),array('id'=>'keywordsform'));?>

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <input name="k_id" type="hidden" type="title" value="<?php echo $k_id;?>"/>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx" onSubmit="return checkForm();>

                            <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2>添加页面关键字</h2></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">页面名： </td>

                                <td>

                                    <input size="40" name="pagename" id="pagename" type="text" value="<?php echo $k_pagename;?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">文件名：</td>

                                <td><?php echo $k_page;?></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">页面标题： </td>

                                <td><textarea id="title" rows="5" cols="60" name="title"><?php echo $k_title;?></textarea></td>

                            </tr><tr>

                                <td class="right" width="120px">页面关键字： </td>

                                <td><textarea id="keywords" rows="5" cols="60" name="keywords"><?php echo $k_keywords;?></textarea></td>

                            </tr><tr>

                                <td class="right" width="120px">页面描述： </td>

                                <td><textarea id="description" rows="5" cols="60" name="description"><?php echo $k_description;?></textarea></td>

                            </tr><tr>

                                <td class="right" width="120px">规则： </td>

                                <td><?php echo $k_rule;?></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px"></td>

                                <td><input type="submit" class="tjzx" value="提&nbsp;交" name="">

                                    &nbsp;&nbsp;

                                    <input type="button" onclick="javascript:history.back();" class="fhlb" value="返回列表" name="upload">

                                </td>

                            </tr>

                            <?php if ($k_page == 'ehc' || $k_page == 'expo') { ?>

                            <tr><td colspan="5" style="text-align:left;padding-left:5px;"><h2>注意事项：</h2></td></tr>

                           <tr>

                            <td colspan="5" style="text-align:left;padding-left:5px;">您可以在此页面添加{cityname}标签</td>

                             <?php } ?>

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

<script>



//submit操作

$("#keywordsform").submit(function(){

	if($('#pagename').val() == ""){

	   alert("请填写页面名称！");   

	   $('#pagename').focus();	   

	   return(false);

   	}

    if($('#title').val() == ""){

	   alert("请填写页面标题！");   

	   $('#title').focus();	   

	   return(false);

   	}

    if($('#keywords').val() == ""){

	   alert("请填写页面关键字！");   

	   $('#keywords').focus();	   

	   return(false);

   	}

    if($('#description').val() == ""){

	   alert("请填写页面描述！");   

	   $('#description').focus();	   

	   return(false);

   	}

})

</script>

</body>

</html>