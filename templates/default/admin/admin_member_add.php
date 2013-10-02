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
                            <h2>后台管理>>会员管理</h2>
                        </div></td>
                </tr>
                <tr>
                    <td><div class="zhuti">
                            <ul>
                                <li class="current">会员管理</li>
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
                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2><?php if ($info['user_id'] > 0) {echo '修改';} else {echo '添加';} ?>会员</h2></td>
                            </tr>
                            <tr>
                                <td class="right" width="120">手机：</td>
                                <td>
                                    <input name="username" id="username" type="title" value="<?php echo $info['mobile_phone'];?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="right" width="120">用户名：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['user_name'];?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="right" width="120">email：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['email'];?>"/>
                                </td>
                            </tr>
                             <tr>
                                <td class="right" width="120">性别：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['sex'];?>"/>
                                </td>
                            </tr>
                             <tr>
                                <td class="right" width="120">生日：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['birthday'];?>"/>
                                </td>
                            </tr>
                             <tr>
                                <td class="right" width="120">积分：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['UserExp'];?>"/>
                                    &nbsp; 冻结积分：<input name="name" id="name" type="title" value="<?php echo $info['dhExp'];?>"/>
                                </td>
                            </tr>
                             <tr>
                                <td class="right" width="120">累计入住：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['leijifang_num'];?>"/>
                                    &nbsp; 已申请：<input name="name" id="name" type="title" value="<?php echo $info['eijishenqing'];?>"/>
                                </td>
                            </tr>
                             <tr>
                                <td class="right" width="120">连续入住：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['lianxufang_num'];?>"/>
                                    &nbsp; 最后入住日期:<input name="name" id="name" type="title" value="<?php echo $info['endrzdate'];?>"/>
                               &nbsp; &nbsp;已申请：<input name="name" id="name" type="title" value="<?php echo $info['lianxushengqing'];?>"/></td>
                            </tr>
                             <tr>
                                <td class="right" width="120">状态：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['Status'];?>"/>
                                </td>
                            </tr>
                             <tr>
                                <td class="right" width="120">注册时间：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo date('Y-m-d H:i:s',$info['reg_time']);?>"/>
                                </td>
                            </tr>
                             <tr>
                                <td class="right" width="120">最后登录时间：</td>
                                <td>
                                    <input name="name" id="name" type="title" value="<?php echo $info['last_login'];?>"/>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="right" width="120">权限：</td>
                                <td>
                                    <?php if ($info['id'] != 1 && $id==1) {echo $info['select'];} else {echo $info['typename'];} ?>
                                </td>
                            </tr>
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