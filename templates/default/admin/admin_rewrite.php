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

            <div class="zhuti">

               <ul>

                   <li class="current">伪静态管理</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="4">

                        </td>

                        <td colspan="1" style="text-align:right; border-left:none; padding-right:20px;"></td>

                       </tr>

                       <tr class="bt">

                        <td style="width:161px;">编号</td>

                        <td style="border-left:none;width:161px;">功能页面</td>

                        <td style="border-left:none;">伪静态地址</td>

                        <td style="border-left:none;">真实地址</td>

                        <td style="border-left:none; width:141px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($list) > 0 ) {

                       	    $i = 0 ;

                            foreach ($list as $rewrite) { 

                            $i++;?>

                       <tr>

                        

                        <td class="left"><?php echo $i ;?></td>

                        <td class="f_f60"><?php echo $rewrite['rewrite_mark'];?></td>

                        <td class="left"><input size="50" readonly id="o<?php echo $rewrite['rewrite_id'];?>" type="input" value="<?php echo $rewrite['rewrite_org'];?>" /></td>

                        <td class="f_f60"><input size="50"  id="r<?php echo $rewrite['rewrite_id'];?>" type="input" value="<?php echo $rewrite['rewrite_new'];?>" /></td>

                        <td><?php if ($operate['isedit']) { ?><a class="sc" href="javascript:void(0)" onclick="edit_rewrite('<?php echo $rewrite['rewrite_id'] ?>')">修改</a><?php } ?></td></tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="7">还没有信息，赶紧添加吧!</td></tr>';

                       } ?>

                       <tr><td colspan="5" style="text-align:left;padding-left:5px;"><h2>注意事项：</h2></td></tr>

                       <tr>

                        <td colspan="5" style="text-align:left;padding-left:5px;">

                        1、修改规则只需修改前缀即可如newsinfo/([0-9]+)中，只需修改newsinfo，即可！<br />

                        2、修改规则需把功能页面中相同名称的都修改，如要修改展馆中的地址则同时需要修改编号为14，15，16，17中的规则<br />

                        3、x4程序伪静态功能不能关闭</td>

                        

                      </tr>

                   </table>

            </td></tr>

            </table>

        </div>

    </div>

<?php $this->load->view('admin/admin_footer');?>

</div>

<script>

    function edit_rewrite(rewrite_id){

        if (!rewrite_id) {

    	   alert('好像您没有要修改的规则!');

           return;

    	}

       var rewrite_rule = $("#r"+rewrite_id).val();

       var rewrite_org = $("#o"+rewrite_id).val();

       

	   $.post("<?php echo site_url(CFG_ADMINURL.'/rewrite/save_rewrite'); ?>",

			   {rewrite_id:rewrite_id,rule:rewrite_rule,rule_org:rewrite_org},

				function(result){

		        var obj = $.parseJSON(result);

		        if(obj.status){

			        alert(obj.msg);

			    }

	   });     

           	



    }



</script>

</body>

</html>