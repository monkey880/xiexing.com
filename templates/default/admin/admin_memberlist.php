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
            <div class="wzdh"><h2>后台管理>>管理员管理</h2></div>
            </td></tr>
            <tr><td>
            <div class="zhuti">
               <ul>
                   <li class="current">管理员管理</li>
               </ul>
            </div>
            </td></tr>
            <tr><td>
                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">
                       <tr class="top">
                        <td class="left" colspan="2">
                            <input name="" type="checkbox" value="" id="btn_all_selected_manager" />全选&nbsp;&nbsp;
                            <?php if ($operate['isdel']) { ?>
                            <a href="javascript:void(0)" id="delete_manager">删除</a>&nbsp;&nbsp;&nbsp;
                            <?php } ?>
                        </td>
                        <td colspan="6" style="text-align:right; border-left:none; padding-right:20px;"><?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/manager/add_manager')?>'" name="" type="button" value="添加管理员" class="tjzx" /><?php } ?></td>
                       </tr>
                       <tr class="bt">
                        <td width="5%">&nbsp;</td>
                        <td style="border-left:none;">用户名</td>
                        <td style="border-left:none;">邮箱</td>
                        <td style="border-left:none;">手机</td>
                        <td style="border-left:none;">积分</td>
                        <td style="border-left:none;">累计入住</td>
                        <td style="border-left:none;">注册时间</td>
                        <td style="border-left:none; width:261px; _width:100px; text-align:center;">操作</td>
                       </tr>
                       <?php
                       if(count($managerList) > 0 ) {
                            foreach ($managerList as $key=> $manager) { ?>
                       <tr>
                       	<td class=""><input name="manager_box" type="checkbox" value="<?php echo $manager['user_id'] ;?>" /></td>
                       	<td class=""><?php echo $manager['user_name'] ;?></td>
                       	<td class=""><?php echo $manager['email'] ;?></td>
                       	<td class="f_f60"><?php echo $manager['mobile_phone'] ;?></td>
                        <td class="f_f60"><?php echo $manager['UserExp'] ;?></td>
                        <td class="f_f60"><?php echo $manager['leijifang_num'] ;?></td>
                        <td class="f_f60"><?php echo date('Y-m-d H:i:s',$manager['reg_time']) ;?></td>
                       	<td>
                           
                           <a class="sc" href="javascript:void(0)" onclick="delete_one_manager('<?php echo $manager['user_id'] ?>')">删除</a>
                           <a class="sc" href="<?php echo site_url(CFG_ADMINURL.'/member/info/'.$manager['user_id'].'/'.$page); ?>">详情</a>
                           <a class="sc" href="<?php echo site_url(CFG_ADMINURL.'/hotel/order/0/'.$manager['user_id'].'/0'); ?>">查单</a>
                           
                        </td>
                       </tr>
                       <?php } 
                       }else{
                       	    echo '<tr><td colspan="6">还没有管理员，赶紧添加吧!</td></tr>';
                       } ?>
                       <tr><td colspan="6" class="left" style="height:60px;" >
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
<script>
    $(function(){
        //全选,取消全选
        $("#btn_all_selected_manager").click(all_selected_manager);
        $("#delete_manager").click(delete_manager);
    })
    
    function all_selected_manager()
    {
    	var but_checked = $("#btn_all_selected_manager").attr("checked");
        if (but_checked == 'checked') {
            $("[name=manager_box]:checkbox").each(function(index, element) {
        		$(this).attr("checked","checked");
        	});    
        } else {
            $("[name=manager_box]:checkbox").each(function(index, element) {
        		$(this).attr("checked",false);
        	});
        }
        
    }
    
    function delete_manager()
    {
    	var aid_array=new Array();
        $("[name=manager_box]:checkbox:checked").each(function() {
        	aid_array.push($(this).val());
        });
        var aid_str=aid_array.join('-');
        if (!aid_str) {
    	   alert('好像您没有选择任何要删除会员吧?:-(');
           return;
    	}
        if (confirm ('确定删除选中的会员吗？')) {
            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/member/del_member/"+aid_str+"/";      
    	}
    }

    function delete_one_manager(id) { 
    	if (confirm ('确定删除选中的会员吗？')) {
            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/member/del_member/"+id+"/"; 
    	}
    }
</script>
</body>
</html>