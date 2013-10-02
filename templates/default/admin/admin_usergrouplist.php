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

            <div class="wzdh"><h2>后台管理>>权限列表</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">权限列表</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="2">

                            

                        </td>

                        <td colspan="4" style="text-align:right; border-left:none; padding-right:20px;"><?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/usergroup/add_usergroup')?>'" name="" type="button" value="添加用户组" class="tjzx" /><?php } ?></td>

                       </tr>

                       <tr class="bt">

                        <td width="5%">ID</td>

                        <td class="border-left:none;">用户组</td>

                        <td style="border-left:none;">状态</td>

                        <td style="border-left:none; width:141px; _width:100px; text-align:center;">操作</td>

                       </tr>

                        <?php

                       if(count($usergroupList) > 0 ) {

                            foreach ($usergroupList as $usergroup) { ?>

                       <tr>

                       	<td class=""><?php echo $usergroup['id'] ;?></td>

                       	<td class=""><?php echo $usergroup['title'] ;?></td>

                       	<td class="f_f60"><?php echo $usergroup['status'] ;?></td>

                       	<td>

                           <?php if ($usergroup['id'] == 1 && $operate['isdel']) { ?><a class="scc" href="javascript:void(0)">删除</a><?php } ?>

                           <?php if ($usergroup['id'] != 1 && $operate['isdel']) { ?><a class="sc" href="javascript:void(0)" onclick="delete_one_usergroup('<?php echo $usergroup['id'] ?>')">删除</a><?php } ?>

                           <?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/usergroup/add_usergroup/'.$usergroup['id']); ?>">修改</a><?php } ?>

                        </td>

                       </tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="6">还没有用户组，赶紧添加吧!</td></tr>';

                       } ?>

                    

            </td></tr>

            </table>

        </div>

    </div>

<?php $this->load->view('admin/admin_footer');?>

</div>

<script>



    function delete_one_usergroup(id) { 

    	if (confirm ('确定删除选中的数据吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/usergroup/del_usergroup/"+id+"/"; 

    	}

    }

</script>

</body>

</html>