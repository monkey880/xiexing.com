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

                            <h2>后台管理>>管理员管理</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">管理员管理</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/manager/save_manager'),array('id'=>'managerform'));?>

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <input name="id" id="id" type="hidden" type="title" value="<?php echo $info['id'];?>"/>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx" onSubmit="return checkForm();>

                            <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2><?php if ($info['id'] > 0) {echo '修改';} else {echo '添加';} ?>管理员</h2></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">用户名：</td>

                                <td>

                                    <input name="username" id="username" type="title" value="<?php echo $info['username'];?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">真实姓名：</td>

                                <td>

                                    <input name="name" id="name" type="title" value="<?php echo $info['name'];?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">密码：</td>

                                <td>

                                    <input name="password" id="password" type="password" value=""/>&nbsp;<?php if ($id>0) { ?>不修改就留空<?php } ?>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">权限：</td>

                                <td>

                                    <?php if ($info['id'] != 1 && $id==1) {echo $info['select'];} else {echo $info['typename'];} ?>

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

$("#managerform").submit(function(){

    if($('#username').val() == ""){

	   alert("请填写用户名！");   

	   $('#username').focus();

	   return(false);

   	}

	

	if($('#name').val() == ""){

	   alert("请填写真实姓名！");   

	   $('#name').focus();	   

	   return(false);

   	}	



	if($('#id').val() == ""){	

		if($('#password').val() == ""){

		   alert("请填写密码！");   

		   $('#password').focus();

		   return(false);

		}

	}

})

</script>

</body>

</html>