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

            <tr>

                <td>

                    <div class="wzdh"><h2>后台管理>>数据还原管理</h2></div>

                </td>

            </tr>

            <tr>

                <td>

                    <div class="zhuti">

                       <ul>

                           <li class="current">数据还原管理</li>

                       </ul>

                    </div>

                </td>

            </tr>

            <?php if ($action == 'do') { ?>

            <tr>

                <td>

                    <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/data/dorevert'),array('id'=>'dorevertform'));?> 

                    <input type='hidden' name='path' value=<?php echo $path ?> />

                    <input type='hidden' name='backfiles' id="backfiles" value='' />

                    <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                        <tr class="top">

                            <td class="left" colspan="4">

                                <input name="" type="checkbox" value="" id="btn_all_selected_backfiles" />全选/取消&nbsp;&nbsp;

                                <input name="" type="checkbox" value="" id="btn_all_re_selected_backfiles" />反选&nbsp;&nbsp;

                            </td>

                        </tr>

                        <tr class="bt">

                            <td class="left"  colspan='4'>

                              	<h3>发现<?php echo $path; ?>的备份文件</h2>

                                <?php if (count($filelists)==0) { ?> 没找到任何备份文件...<?php } ?>

                            </td>

                        </tr>

                        <?php

	                       $count= count($filelists);

	                       if($count > 0 ) {

                           	for ($i=0,$j=0;$i<$count;$i++){ 

                        ?>

                        <tr>                 

                            <td width="5%" class=""><input name="backfile" type="checkbox" value="<?php echo $filelists[$i];?>" /></td>

                            <td class=""><?php echo $filelists[$i] ;?></td>

                        <?php $j=$i+1;$i++; if($j<$count) {  ?>

                       		<td width="5%" class=""><input name="backfile" type="checkbox" value="<?php echo $filelists[$j];?>" /></td>

                            <td class=""><?php echo $filelists[$j] ;?></td>

                        <?php }else { ?>

                        	<td width="5%" class="">&nbsp;</td>

                            <td class="">&nbsp;</td>

                        <?php } ?>

                 	   </tr>

                        <?php 

                            }}else{

                                echo '<tr><td colspan="3">没找到任何备份文件!</td></tr>';

                            } 

                        ?>  

                        <tr>

                            <td class="left"  colspan='4'>

                              	<h2>附加参数：</h2>

                            </td>

                        </tr>

                        <tr>                 

                            <td colspan='4' class="left">    

                                <input name="structfile" type="checkbox" class="" id="structfile" value="<?php echo $structfile ?> "/>

                                还原表结构信息<?php echo $structfile ?> (此选项被选中则该备份文件夹下所有备份的表数据将被清空，如果不选择此选项；请确保要还原的数据表被清空或者没有主键冲突)

                                <input name="delfile" type="checkbox" class="np" id="delfile" value="1" />

                                还原后删除备份文件 (谨慎操作)

                            </td>

                        </tr> 

                        <tr>                 

                            <td colspan='4' class="left">    

                                &nbsp; 

                                <?php if ($operate['isedit']) { ?>

                                <input type="submit"  id="submit_backfile" value="开始还原数据" class="" /> 

                                <?php } ?>     

                            </td>

                        </tr>                    

                    </table>

                    </form>

                </td>

            </tr>

            <?php } else { ?>

            <tr>

                <td>

                    <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/data/delete'),array('id'=>'delform'));?> 

                    <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                        <tr class="top">

                            <td class="left" colspan="4">

                                &nbsp;&nbsp;

                                <?php if ($operate['isdel']) { ?>

                                <a href="javascript:void(0)" id="delete_backfile" >删除</a>&nbsp;&nbsp;&nbsp;

                                <?php } ?>

                            </td>

                        </tr>

                        <tr class="bt">

                            <td class="left" style="border-left:none;" colspan='4'>

                              	<strong>发现的备份日期：		请选择一个要还原的日期</strong>

                                <?php if (count($filelists)==0) { ?> 没找到任何备份文件...<?php } ?>

                            </td>

                        </tr>

                        <?php

	                       $count= count($filelists);

	                       if($count > 0 ) {

                           	for ($i=0,$j=0;$i<$count;$i++){ 

                        ?>

                        <tr>                 

                            <td width="5%" class=""><input name="backfile[]" type="checkbox" value="<?php echo $filelists[$i];?>" /></td>

                            <td class=""><a class="" href="<?php echo site_url(CFG_ADMINURL.'/data/revertlist/'.$filelists[$i]); ?>"><?php echo $filelists[$i] ;?></a></td>

                            <?php $j=$i+1;$i++; if($j<$count) {  ?>

                            <td width="5%" class=""><input name="backfile[]" type="checkbox" value="<?php echo $filelists[$j];?>" /></td>

                            <td class=""><a class="" href="<?php echo site_url(CFG_ADMINURL.'/data/revertlist/'.$filelists[$j]); ?>"><?php echo $filelists[$j] ;?></a></td>

	                        <?php }else { ?>

	                        <td width="10%" class="">&nbsp;</td>

                            <td class="">&nbsp;</td>

	                        <?php } ?>

                        </tr>

                        <?php 

                            }}else{

                                echo '<tr><td colspan="3">没找到任何备份文件!</td></tr>';

                            } 

                        ?>                      

                    </table>

                </td>

            </tr>

            <?php } ?>

            </table>    

            </form>

        </div>

    </div>

<?php $this->load->view('admin/admin_footer');?>

</div>

<script>

    $(function(){

        //全选,取消全选

        $("#btn_all_selected_backfiles").click(selected_all);

        //反选

        $("#btn_all_re_selected_backfiles").click(re_selected_all);

        

        $("#delete_backfile").click(delete_backfile);

        

        $("#submit_backfile").click(checkSubmit);

    })

    function selected_all()

    {

    	var but_checked = $("#btn_all_selected_backfiles").attr("checked");

        if (but_checked == 'checked') {

            $("[name=backfile]:checkbox").each(function() {

        		$(this).attr("checked","checked");

        	});    

        } else {

            $("[name=backfile]:checkbox").each(function() {

        		$(this).attr("checked",false);

        	});

        }

        

    }

    function re_selected_all()

    {

        $("[name=backfile]:checkbox").each(function() {

    		if ($(this).attr("checked") == 'checked') {

                $(this).attr("checked",false);    

            } else {

                $(this).attr("checked","checked"); 

            }

    	});   

    }

    function delete_backfile () 

    {

        $("#delform").submit();

    }

    

    function checkSubmit () 

    {

        var backfiles = getCheckboxItem();

        if (backfiles == '') {

			alert("没指定任何要还原的文件！"); 

			return false;	

		}

        $("#backfiles").val(backfiles);

    	return true;

    }

    function getCheckboxItem(){

        var arr_to_delete_ids=new Array();

    	$("[name=backfile]:checkbox:checked").each(function() {

    		arr_to_delete_ids.push($(this).val());

    	});

    	var bakfiles=arr_to_delete_ids.join(',');

        return  bakfiles;

    }

</script>

</body>

</html>