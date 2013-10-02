<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

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

                            <h2>后台管理>>权限页面管理</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">权限页面管理</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/purview/save_purview'),array('id'=>'purviewform'));?>

                        <input name="id" id="id" type="hidden" type="title" value="<?php echo $info['id'];?>"/>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx" onSubmit="return checkForm();>

                            <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2><?php if ($info['id'] > 0) {echo '修改';} else {echo '添加';} ?>权限页面</h2></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">上级：</td>

                                <td>

                                    <?php echo $info['options']; ?>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">页面名称：</td>

                                <td>

                                    <input name="title" id="title" type="text" value="<?php echo $info['title'];?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">页面变量：</td>

                                <td>

                                    <input name="class" id="class" type="text" value="<?php echo $info['class'];?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">页面权限：</td>

                                <td>

                                    <input name="method" id="method" type="text" value="<?php echo $info['method'];?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">状态：</td>

                                <td>

                                    <?php echo $info['radio']; ?>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">顺序：</td>

                                <td>

                                    <input name="listorder" id="listorder" type="text" value="<?php echo $info['listorder'];?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px"></td>

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

$("#purviewform").submit(function(){

    if($('#title').val() == ""){

	   alert("请填写页面名称！");   

	   $('#title').focus();

	   return(false);

   	}

	if($('#class').val() == ""){

	   alert("请填写页面变量！");   

	   $('#title').focus();

	   return(false);

   	}	

	

	if($('#listorder').val() == ""){

	   alert("请填写顺序！");   

	   $('#listorder').focus();

	   return(false);

	}

})

</script>

</body>

</html>