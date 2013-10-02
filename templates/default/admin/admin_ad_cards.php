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

                            <h2>后台管理>>生成会员卡</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">生成会员卡</li>

                            </ul>

                  </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/cards/add_cards'),array('id'=>'adform'));?>

                        <input type="hidden" name="action" value="add" />

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx" onSubmit="return checkForm();>

                            <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2>生成会员卡</h2></td>

                            </tr>

                            <tr>

                                <td class="right" width="120">开始值： </td>

                                <td><input size="40" name="startid" id="startid" type="text" value=""/></td>

                            </tr>

                            <tr>

                                <td class="right" width="120">数量： </td>

                                <td><input size="20" name="num" id="num" type="text" value="" />&nbsp;</td>

                            </tr> 

                            <tr>


                            <tr>

                                <td class="right" width="120"></td>

                                <td><input type="submit" class="tjzx" value="提&nbsp;交" name="">

                                    &nbsp;&nbsp;

                                    <input type="button" onclick="javascript:history.back();" class="fhlb" value="返回列表" name="upload">

                                </td>

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

$("#adform").submit(function(){

    	if($('#startid').val() == ""){

    	   alert("请填写开始值！");   

    	   $('#startid').focus();

    	   return(false);

       	}

    	

        if($('#num').val() == ""){

    	   alert("请填写数量！");   

    	   $('#num').focus();	   

    	   return(false);

       	}



       

})



</script>

</body>

</html>