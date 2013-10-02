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

                   <li class="current">酒店订单</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="9">

                            <input name="" type="checkbox" value="" id="btn_all_selected_hotel" />全选&nbsp;&nbsp;

                            <?php if ($operate['isdel']) { ?><a href="javascript:void(0)" id="delete_hotel">删除</a>&nbsp;&nbsp;&nbsp;<?php } ?>

                            名称：<input name="hotelName" type="text" />&nbsp;&nbsp;&nbsp;<?php echo $provinceclass_select?><span id="sle_city"></span>
                            &nbsp;&nbsp;&nbsp;<input  name="btn_search" type="button" value="搜索酒店" class="tjzx" id="btn_search" />
                            &nbsp;&nbsp;&nbsp;<input  name="btn_tongbu" type="button" value="同步酒店" class="tjzx" id="btn_tongbu" />

                        </td>

                        <td colspan="1" style="text-align:right; border-left:none; padding-right:20px;"><?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/hotel/add_rule/'.$hid)?>'" name="" type="button" value="添加担保规则" class="tjzx" /><?php } ?></td>

                       </tr>

                       <tr class="bt">

                       	<td width="5%">&nbsp;</td>

                        <td>房型名称</td>

                        <td style="border-left:none;">酒店名称</td>

                        <td style="border-left:none;">宽带</td>

                        <td style="border-left:none;">床型</td>

                        <td style="border-left:none;">面积</td>
                        
                        <td style="border-left:none;">楼层</td>
                        
                        <td style="border-left:none;">价格</td>
                        
                        <td style="border-left:none;">状态</td>
                        
                         

                        <td style="border-left:none; width:250px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($hotellist) > 0 ) {

                            foreach ($hotellist as $hotel) { ?>

                       <tr>

                        <td class=""><input name="hotel_box" type="checkbox" value="<?php echo $hotel['rid'] ;?>" /></td>

                        <td class="left"><?php echo $hotel['title'] ;?></td>

                        <td class="f_f60"><?php 
						
						 $hotelname=$this->model_hotel->get_hotelinfo($hotel['hid']);
						echo $hotelname['HotelName'];
						?></td>

                        <td><?php echo $hotel['adsl'];?></td>

                        <td class="f_f60"><?php echo $hotel['bed'];?></td>
                        
                        <td class="f_f60"><?php echo $hotel['area'];?></td>
                        
                         <td class="f_f60"><?php echo $hotel['floor'];?></td>
                        
                        <td class="f_f60"><?php echo $hotel['price']?>
                        
                        </td>
                        
                        <td class="f_f60"><?php echo $hotel['state'];?></td>

                       <td><?php if ($operate['isdel']) { ?><a class="sc" href="javascript:void(0)" <?php if ($hotel['hid'] > 1){?>onclick="delete_one_hotel('<?php echo $hotel['hid'] ?>',<?php echo $cityid ?>)"<?php }?>>删除</a><?php } ?><?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/hotel/add_roomtype/'.$hotel['hid'].'/'.$hotel['rid']); ?>">修改</a><?php } ?>  <a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/hotel/plan/'.$hotel['rid']); ?>">看计划</a> <a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/hotel/add_plan/'.$hotel['rid']); ?>">加计划</a></td></tr>

                       <?php } 

                       }else{

                       	    echo '<tr><td colspan="7">还没有信息，赶紧添加吧!</td></tr>';

                       } ?>

                       <tr><td colspan="10" class="left" style="height:60px;" >

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

        
		$("#btn_tongbu").click(tongbu);
        $("#class_province").change(get_city);


       

    })

    

    function tongbu(){
		if($('#class_city').val()==''||$('#class_city').val()=='undefined'){
			alert('请先选择城市，再点同步');
			return;
		}
		window.location.href='<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel/tongbu?cityid='+$('#class_city').val();
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

    


    

   

</script>

</body>

</html>