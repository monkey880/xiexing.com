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

            <div class="wzdh"><h2>后台管理>>数据备份管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">数据备份管理</li>

               </ul>

            </div>

            </td></tr>

            <tr>

                <td>

                   <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/data/doback'),array('id'=>'dataform'));?> 

                   <input name="tablearr" type="hidden" id="tablearr" value="" /> 

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="6">

                            <input name="" type="checkbox" value="" id="btn_all_selected_table" />全选/取消&nbsp;&nbsp;

                            <input name="" type="checkbox" value="" id="btn_all_re_selected_table" />反选&nbsp;&nbsp;

                        </td>

                       </tr>

                       <tr class="">

                        <td width="5%">选择</td>

                        <td style="border-left:none;">表名</td>

                        <td style="border-left:none;">记录数</td>

                        <td width="5%">选择</td>

                        <td style="border-left:none;">表名</td>

                        <td style="border-left:none;">记录数</td>

                       </tr>

                       <?php

	                       $count= count($tableList);

	                       if($count > 0 ) {

                           	for ($i=0;$i<$count;$i++){ 

                       ?>

                       <tr>

                        <td class=""><input name="table_name" type="checkbox" value="<?php echo $tableList[$i]['tableName'];?>" /></td>

                       	<td class=""><?php echo $tableList[$i]['tableName'] ;?></td>

                       	<td class=""><?php echo $tableList[$i]['tableCount'] ;?></td>

                       	<?php $j=$i+1;$i++; if($j<$count) {  ?>

                       	<td class=""><input name="table_name" type="checkbox" value="<?php echo $tableList[$j]['tableName'];?>" /></td>

                       	<td class=""><?php echo $tableList[$j]['tableName'] ;?></td>

                       	<td class=""><?php echo $tableList[$j]['tableCount'] ;?></td>	

                        <?php }else { ?>

                        	<td class="">&nbsp;</td>

                       		<td class="">&nbsp;</td>

                       		<td class="">&nbsp;</td>

                        <?php } ?>

                 	   </tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="3">还没有表，赶紧添加吧!</td></tr>';

                       } ?>

                       <tr><td colspan="6" class="left"><h2>数据备份选项：</h2></td></tr>

                       <tr>

                        <td colspan="6" class="left">

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        	当前数据库版本： <?php echo $mysql_version ?>

                        </td>

                       </tr>

                       <tr>

                        <td colspan="6" class="left">

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                       	指定备份数据格式：

                        <input name="datatype" type="radio" class="np" value="4.0" />

                        MySQL3.x/4.0.x 版本

                        <input type="radio" name="datatype" value="4.1" class="np" checked='1' />

                        MySQL4.1.x/5.x 版本

                        </td>

                       </tr>

                       <tr>

                        <td colspan="6" class="left">

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        分卷大小：

                        <input name="fsize" type="text" id="fsize" value="1024" size="6" />

                        K&nbsp;，

                        <input name="isstruct" type="checkbox" class="np" id="isstruct" value="1" checked='1' />

                       备份表结构信息

                       <?php if ($operate['isadd']) { ?>

                      <input type="submit" value="提交" class="coolbg np" />

                      <?php } ?>

                        </td>

                       </tr>                     

                   </table>

            </td></form></tr>

            </table>

        </div>

    </div>

<?php $this->load->view('admin/admin_footer');?>

</div>

<script>

    $(function(){

        //全选,取消全选

        $("#btn_all_selected_table").click(selected_button);

        //反选

        $("#btn_all_re_selected_table").click(re_selected_button);

        

        $("#dataform").submit(checkSubmit);

    })

    

    function selected_button()

    {

    	var but_checked = $("#btn_all_selected_table").attr("checked");

        if (but_checked == 'checked') {

            $("[name=table_name]:checkbox").each(function() {

        		$(this).attr("checked","checked");

        	});    

        } else {

            $("[name=table_name]:checkbox").each(function() {

        		$(this).attr("checked",false);

        	});

        }

        

    }

    function re_selected_button()

    {

        $("[name=table_name]:checkbox").each(function() {

    		if ($(this).attr("checked") == 'checked') {

                $(this).attr("checked",false);    

            } else {

                $(this).attr("checked","checked"); 

            }

    	});   

    }

    function checkSubmit () 

    {

        var tablearr = getCheckboxItem();

		if (tablearr == '') {

			alert("你没选中任何表！"); 

			return false;	

		}

        

        $("#tablearr").val(tablearr);

        

    	return true;

    }

    function getCheckboxItem(){

        var arr_to_delete_ids=new Array();

    	$("[name=table_name]:checkbox:checked").each(function() {

    		arr_to_delete_ids.push($(this).val());

    	});

    	var tablearr=arr_to_delete_ids.join(',');

        return  tablearr;

    }

</script>

</body>

</html>