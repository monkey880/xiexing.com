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

            <div class="wzdh"><h2>后台管理>>酒店管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">酒店管理</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="6">

                            <input name="" type="checkbox" value="" id="btn_all_selected_hotel" />全选&nbsp;&nbsp;

                            <?php if ($operate['isdel']) { ?><a href="javascript:void(0)" id="delete_hotel">删除</a>&nbsp;&nbsp;&nbsp;<?php } ?>

                            名称：<input name="hotelName" type="text" id="hotelName" />&nbsp;&nbsp;&nbsp;<?php echo $provinceclass_select?><span id="sle_city"></span>
                            &nbsp;&nbsp;&nbsp;<input  name="btn_search" type="button" value="搜索酒店" class="tjzx" id="btn_search" />
                            &nbsp;&nbsp;&nbsp;<input  name="btn_tongbu" type="button" value="同步酒店" class="tjzx" id="btn_tongbu" onclick="tongbu()" />

                        </td>

                        <td colspan="1" style="text-align:right; border-left:none; padding-right:20px;"><?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/hotel/add_hotel')?>'" name="" type="button" value="添加新酒店" class="tjzx" /><?php } ?></td>

                       </tr>

                       <tr class="bt">

                       	<td width="5%">&nbsp;</td>

                        <td>酒店名称</td>

                        <td style="border-left:none;">所在城市</td>

                        <td style="border-left:none;">星级</td>

                        <td style="border-left:none;">来源</td>

                        <td style="border-left:none;">最低价格</td>

                        <td style="border-left:none; width:260px; _width:260px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($hotellist) > 0 ) {

                            foreach ($hotellist as $key=> $hotel) { ?>

                       <tr>

                        <td class=""><input name="hotel_box" type="checkbox" value="<?php echo $hotel->id ;?>" /></td>

                        <td class="left"><a target="_blank" href="<?php echo site_url('/hotelinfo/'.$hotel->id) ;?>"><?php echo $hotel->title ;?></a></td>

                        <td class="f_f60"><?php echo $hotel->city;?></td>

                        <td><?php echo $hotel->xingji;?></td>

                        <td class="f_f60"><?php echo $hotel->websiteid;?>

                        </td>

                       <td><?php echo $hotel->min_jiage;?></td>

                       <td></td></tr>

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

        $("#btn_all_selected_hotel").click(all_selected_news);
		
        $("#class_province").change(get_city);
		
		$('#btn_search').click(searchhotel);
		$('#delete_hotel').click(delete_hotels);


       

    })
	
	function searchhotel(){
		var keywords=$('#hotelName').val();
		window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel?keywords="+keywords;  
	}
	
	function all_selected_news(){
    	var but_checked = $("#btn_all_selected_hotel").attr("checked");
        if (but_checked == 'checked') {
            $("[name=hotel_box]:checkbox").each(function(index, element) {
        		$(this).attr("checked","checked");
        	});    
        } else {
            $("[name=hotel_box]:checkbox").each(function(index, element) {
        		$(this).attr("checked",false);
        	});
        }
        
    }

    

    function tongbu(){
		if($('#class_city').val()==''||$('#class_city').val()=='undefined'){
			alert('请先选择城市，再点同步');
			return;
		}
		window.location.href='<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel/tongbu_lbs?cityid='+$('#class_city').val();
	}

    function get_city(){

        var class_province_val = $("#class_province").val();
		
		
		$.ajax({

			type: "GET",

			url: "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel/ajax_select_city?provinceid="+class_province_val,


			success: function(msg)

			{
	            $("#sle_city").html(msg); 

	         },	
			 timeout:20000,

			error: function () 

			{	
			alert("请求超时请重试!");
			}
			});

    }

    
function delete_hotels(){
    	var aid_array=new Array();
        $("[name=hotel_box]:checkbox:checked").each(function() {
        	aid_array.push($(this).val());
        });
        var aid_str=aid_array.join('-');
        if (!aid_str) {
    	   alert('好像您没有选择任何要删除资讯吧?:-(');
           return;
    	}
        if (confirm ('确定删除选中的资讯吗？')) {
            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel/del_baidu/"+aid_str;     
    	}
    }
    function delete_one_hotel(aid,class_id) { 
		if (confirm ('确定删除该资讯吗？')) {
            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel/del_hotel/"+aid; 
    	}
    }

    

   

</script>

</body>

</html>