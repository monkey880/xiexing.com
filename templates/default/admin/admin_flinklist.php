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

            <div class="wzdh"><h2>后台管理>>友情链接管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">友情链接管理</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="2">

                            <input name="" type="checkbox" value="" id="btn_all_selected_flink" />全选&nbsp;&nbsp;

                            <?php if ($operate['isdel']) { ?>

                            <a href="javascript:void(0)" id="delete_flink">删除</a>&nbsp;&nbsp;&nbsp;

                            <?php } ?>

                        </td>

                        <td colspan="5" style="text-align:right; border-left:none; padding-right:20px;"><?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/flink/add_flink')?>'" name="" type="button" value="添加友情链接" class="tjzx" /><?php } ?></td>

                       </tr>

                       <tr class="bt">

                       	<td>&nbsp;</td>

                        <td>链接名称</td>

                        <td style="border-left:none;">链接地址</td>

                        <td style="border-left:none;">类型</td>

                        <td style="border-left:none;">添加日期</td>

                        <td style="border-left:none; width:141px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($flinkList) > 0 ) {

                            foreach ($flinkList as $flink) { ?>

                       <tr>

                       	<td class=""><input name="flink_box" type="checkbox" value="<?php echo $flink['flink_id'] ;?>" /></td>

                       	<td class="left"><?php echo $flink['flink_title'] ;?></td>

                       	<td class=""><?php echo $flink['flink_link'] ;?></td>

                       	<td class="f_f60"><?php echo $flink['type_name'] ;?></td>

                       	<td class=""><?php echo $flink['time'] ;?></td>

                       	<td><?php if ($operate['isdel']) { ?><a class="sc" href="javascript:void(0)" onclick="delete_one_flink('<?php echo $flink['flink_id'] ?>')">删除</a><?php } ?><?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/flink/add_flink/'.$flink['flink_id'].'/'.$page); ?>">修改</a><?php } ?></td>

                       </tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="6">还没有友情链接，赶紧添加吧!</td></tr>';

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

<script>

    $(function(){

        //全选,取消全选

        $("#btn_all_selected_flink").click(all_selected_flink);

        $("#delete_flink").click(delete_flink);

    })

    

    function all_selected_flink()

    {

    	var but_checked = $("#btn_all_selected_flink").attr("checked");

        if (but_checked == 'checked') {

            $("[name=flink_box]:checkbox").each(function(index, element) {

        		$(this).attr("checked","checked");

        	});    

        } else {

            $("[name=flink_box]:checkbox").each(function(index, element) {

        		$(this).attr("checked",false);

        	});

        }

        

    }

    

    function delete_flink()

    {

    	var aid_array=new Array();

        $("[name=flink_box]:checkbox:checked").each(function() {

        	aid_array.push($(this).val());

        });

        var aid_str=aid_array.join('-');

        if (!aid_str) {

    	   alert('好像您没有选择任何要删除友情链接吧?:-(');

           return;

    	}

        if (confirm ('确定删除选中的友情链接吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/flink/del_flink/"+aid_str+'/';      

    	}

    }



    function delete_one_flink(flink_id) { 

    	if (confirm ('确定删除该友情链接吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/flink/del_flink/"+flink_id+'/'; 

    	}

    }

</script>

</body>

</html>