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

            <div class="wzdh"><h2>后台管理>>资讯管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">资讯管理</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="6">

                            <input name="" type="checkbox" value="" id="btn_all_selected_news" />全选&nbsp;&nbsp;

                            <?php if ($operate['isdel']) { ?><a href="javascript:void(0)" id="delete_news">删除</a>&nbsp;&nbsp;&nbsp;<?php } ?>

                            查看分类：<?php echo $newsclass_select?>&nbsp;&nbsp;&nbsp;更改类别为：<?php echo $change_newsclass_select?>

                        </td>

                        <td colspan="1" style="text-align:right; border-left:none; padding-right:20px;"><?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/news/add_news')?>'" name="" type="button" value="添加新资讯" class="tjzx" /><?php } ?></td>

                       </tr>

                       <tr class="bt">

                       	<td width="5%">&nbsp;</td>

                        <td>资讯标题</td>

                        <td style="border-left:none;">资讯类别</td>

                        <td style="border-left:none;">关联城市</td>

                        <td style="border-left:none;">显示状态</td>

                        <td style="border-left:none;">发布时间</td>

                        <td style="border-left:none; width:141px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($newslist) > 0 ) {

                            foreach ($newslist as $news) { ?>

                       <tr>

                        <td class=""><input name="news_box" type="checkbox" value="<?php echo $news['aid'] ;?>" /></td>

                        <td class="left"><a href="<?php echo site_url('/newsinfo/'.$news['aid']) ;?>"><?php echo $news['title'] ;?></a></td>

                        <td class="f_f60"><?php echo $news['class_name'];?></td>

                        <td><?php echo $news['cityname'];?></td>

                        <td class="f_f60"><?php echo $news['state_name'];?>

                        </td>

                       <td><?php echo $news['time_show'];?></td>

                       <td><?php if ($operate['isdel']) { ?><a class="sc" href="javascript:void(0)" <?php if ($news['aid'] > 1){?>onclick="delete_one_news('<?php echo $news['aid'] ?>',<?php echo $class_id ?>)"<?php }?>>删除</a><?php } ?><?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/news/add_news/'.$news['aid'].'/'.$page); ?>">修改</a><?php } ?></td></tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="7">还没有信息，赶紧添加吧!</td></tr>';

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

        $("#btn_all_selected_news").click(all_selected_news);

        $("#class_news").change(change_class_news);

        $("#change_class_news").change(change_newsclass);

        $("#delete_news").click(delete_news);

    })

    

    function all_selected_news(){

    	var but_checked = $("#btn_all_selected_news").attr("checked");

        if (but_checked == 'checked') {

            $("[name=news_box]:checkbox").each(function(index, element) {

        		$(this).attr("checked","checked");

        	});    

        } else {

            $("[name=news_box]:checkbox").each(function(index, element) {

        		$(this).attr("checked",false);

        	});

        }

        

    }

    

    function change_class_news(){

        var class_news_val = $("#class_news").val();

        window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/news/index/"+class_news_val+"/"; 

    }

    

    function change_newsclass(){

        var class_news_val = $("#change_class_news").val();

        if (class_news_val == 0) {

            return;        

        }

        var aid_array=new Array();

        $("[name=news_box]:checkbox:checked").each(function() {

        	aid_array.push($(this).val());

        });

        var aid_str=aid_array.join('-');

        if (!aid_str) {

           $("#change_class_news").val(0);

    	   alert('好像您没有选择任何要修改的资讯吧?:-(');

           return;

    	}

        if (confirm ('确定修改选中资讯的分类吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/news/changeNewsclass/"+aid_str+'/'+class_news_val+"/";     

    	}

    }

    

    function delete_news(){

    	var aid_array=new Array();

        $("[name=news_box]:checkbox:checked").each(function() {

        	aid_array.push($(this).val());

        });

        var aid_str=aid_array.join('-');

        if (!aid_str) {

    	   alert('好像您没有选择任何要删除资讯吧?:-(');

           return;

    	}

        if (confirm ('确定删除选中的资讯吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/news/del_news/"+aid_str+'/'+<?php echo $class_id ?>+"/";     

    	}

    }

    function delete_one_news(aid,class_id) { 

		if (confirm ('确定删除该资讯吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/news/del_news/"+aid+'/'+class_id+"/"; 

    	}

    }

</script>

</body>

</html>