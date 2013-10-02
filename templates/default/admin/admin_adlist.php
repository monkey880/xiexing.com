<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>

<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />

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

            <div class="wzdh"><h2>后台管理>>广告管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">广告管理</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="2">

                            <input name="" type="checkbox" value="" id="btn_all_selected_ad" />全选&nbsp;&nbsp;

                            <?php if ($operate['isdel']) { ?>

                            <a href="javascript:void(0)" id="delete_ad">删除</a>&nbsp;&nbsp;&nbsp;

                            <?php } ?>

                        </td>

                        <td colspan="6" style="text-align:right; border-left:none; padding-right:20px;"> <?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/ad/ad_add')?>'" name="" type="button" value="添加广告" class="tjzx" /><?php } ?></td>

                       </tr>

                       <tr class="bt">

                        <td width="5%">&nbsp;</td>

                        <td style="border-left:none;">位置</td>

                        <td style="border-left:none;">链接名称</td>

                        <td style="border-left:none;">链接地址</td>

                        <td style="border-left:none;">状态</td>

                        <td style="border-left:none;">类型</td>

                        <td style="border-left:none;">添加日期</td>

                        <td style="border-left:none; width:141px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($adList) > 0 ) {

                            foreach ($adList as $ad) { ?>

                       <tr>

                       	<td class=""><input name="ad_box" type="checkbox" value="<?php echo $ad['ad_id'] ;?>" /></td>

                       	<td class=""><?php echo $ad['ad_area'] ;?> | <?php echo $ad['ad_name'] ;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url(CFG_ADMINURL.'/ad/ajax_make_link/'.$ad['ad_id']) ?>" id="Code_Show<?php echo $ad['ad_id'] ;?>">生成代码</a></td>

                       	<td class=""><a  href="javascript:void(0)"><?php echo $ad['ad_title'] ;?></a></td>

                       	<td class=""><?php echo $ad['ad_link'] ;?></td>

                       	<td class="f_f60"><?php echo $ad['state_name'] ;?></td>

                       	<td class="f_f60"><?php echo $ad['type_name'] ;?></td>

                       	<td class=""><?php echo $ad['time'] ;?></td>

                       	<td><?php if ($operate['isdel']) { ?><a class="sc" href="javascript:void(0)" onclick="delete_one_ad('<?php echo $ad['ad_id'] ?>')">删除</a><?php } ?><?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/ad/ad_add/'.$ad['ad_id'].'/'.$page); ?>">修改</a><?php } ?></td>

                       </tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="7">还没有广告，赶紧添加吧!</td></tr>';

                       } ?>

                       <?php if ($pagenav) { ?>

                       <tr><td colspan="8" class="left" style="height:60px;" >

                       <div class="fy">

                            <?php echo $pagenav;?>

                         </div>

                       </td></tr>

                       <?php } ?>

                       <tr><td colspan="8" style="text-align:left;padding-left:5px;"><h2>注意事项：</h2></td></tr>

                       <tr>

                       	<td class="left" colspan="8">

                           首页（index）和城市页（onecity）默认调用的是类型为上传图片位置代号为：index_focus_1，index_focus_2，index_focus_3，index_focus_4的四条广告；</br>

                           首页请修改templates\default\modules\index\top_ad.php文件第四行：$adNameArr = "'index_focus_1','index_focus_2','index_focus_3','index_focus_4'"，按这种格式修改即可；</br>

                           城市页请修改templates\default\modules\onecity\top_ad.php文件第四行：$adNameArr = "'index_focus_1','index_focus_2','index_focus_3','index_focus_4'"，按这种格式修改即可；

                        </td>

             	       </tr>

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

        $("#btn_all_selected_ad").click(all_selected_ad);

        $("#delete_ad").click(delete_ad);



        show_make_code();

    })

    

    function all_selected_ad()

    {

    	var but_checked = $("#btn_all_selected_ad").attr("checked");

        if (but_checked == 'checked') {

            $("[name=ad_box]:checkbox").each(function(index, element) {

        		$(this).attr("checked","checked");

        	});    

        } else {

            $("[name=ad_box]:checkbox").each(function(index, element) {

        		$(this).attr("checked",false);

        	});

        }

        

    }

    

    function delete_ad()

    {

    	var aid_array=new Array();

        $("[name=ad_box]:checkbox:checked").each(function() {

        	aid_array.push($(this).val());

        });

        var aid_str=aid_array.join('-');

        if (!aid_str) {

    	   alert('好像您没有选择任何要删除广告吧?:-(');

           return;

    	}

        if (confirm ('确定删除该广告吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/ad/del_ad/"+aid_str+"/";  

    	}

    }



    function delete_one_ad(ad_id) { 

    	if (confirm ('确定删除选中的广告吗？')) {

            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/ad/del_ad/"+ad_id+"/";

    	}

    }

    function show_make_code()

    {

        var ids = "<?php echo $adidStr; ?>";

        var id_array = new Array();

        id_array = ids.split(',');

        for(i=0;i<id_array.length;i++){

            $("#Code_Show"+id_array[i]).fancybox({

                'width'             : 550,

                'height'            : 250,

                'autoScale'         : false,

                'transitionIn'      : 'none',

                'transitionOut'     : 'none',

                'type'              : 'iframe',

                'overlayOpacity' : '0.8',

                'overlayColor' : '#000'        

            });

        }	

    }

    

</script>

</body>

</html>