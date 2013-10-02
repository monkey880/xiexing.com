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

            <div class="wzdh"><h2>后台管理>>礼品管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">礼品管理</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

                   <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr class="top">

                        <td class="left" colspan="6">

                            <input name="" type="checkbox" value="" id="btn_all_selected_hotel" />全选&nbsp;&nbsp;

                            <?php if ($operate['isdel']) { ?><a href="javascript:void(0)" id="delete_hotel">删除</a>&nbsp;&nbsp;&nbsp;<?php } ?>

                            名称：<input name="hotelName" type="text" />&nbsp;&nbsp;&nbsp;
                           

                        </td>

                        <td colspan="1" style="text-align:right; border-left:none; padding-right:20px;"><?php if ($operate['isadd']) { ?><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/product/add')?>'" name="" type="button" value="添加礼品" class="tjzx" /><?php } ?></td>

                       </tr>

                       <tr class="bt">

                       	<td width="5%">&nbsp;</td>

                        <td>名称</td>

                        <td style="border-left:none;">类型</td>

                        <td style="border-left:none;">价格</td>

                        <td style="border-left:none;">库存</td>

                        <td style="border-left:none;">兑换积分</td>

                        <td style="border-left:none; width:141px; _width:100px; text-align:center;">操作</td>

                       </tr>

                       <?php

                       if(count($hotellist) > 0 ) {

                            foreach ($hotellist as $hotel) { ?>

                       <tr>

                        <td class=""><input name="hotel_box" type="checkbox" value="<?php echo $hotel['ProductID'] ;?>" /></td>

                        <td class="left"><a href="<?php echo site_url('/product/'.$hotel['ProductID']) ;?>"><img src="/public/uploadfiles/upload/<?php echo $hotel['ProductThumb'] ;?>" width="80" height="80" alt="" /><br />
<?php echo $hotel['ProductName'] ;?></a></td>

                        <td class="f_f60"><?php 
						echo $hotel['ProductType'];
						
						?></td>

                        <td><?php echo $hotel['Price'];?></td>

                        <td class="f_f60"><?php echo $hotel['Stocks'];?>

                        </td>

                       <td><?php echo $hotel['PresentExp'];?></td>

                       <td><?php if ($operate['isdel']) { ?><a class="sc" href="javascript:void(0)" <?php if ($hotel['ProductID'] > 0){?>onclick="delete_one_hotel('<?php echo $hotel['ProductID'] ?>')"<?php }?>>删除</a><?php } ?><?php if ($operate['isedit']) { ?><a class="xg" href="<?php echo site_url(CFG_ADMINURL.'/product/add/'.$hotel['ProductID'].'/'.$page); ?>">修改</a><?php } ?></td></tr>

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

    

function delete_hotels(){
    	var aid_array=new Array();
        $("[name=hotel_box]:checkbox:checked").each(function() {
        	aid_array.push($(this).val());
        });
        var aid_str=aid_array.join('-');
        if (!aid_str) {
    	   alert('好像您没有选择任何要删除的信息吧?:-(');
           return;
    	}
        if (confirm ('确定删除选中的信息吗？')) {
            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/product/del_product/"+aid_str;     
    	}
    }
    function delete_one_hotel(aid) { 
		if (confirm ('确定删除该信息吗？')) {
            window.location = "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/product/del_product/"+aid; 
    	}
    }

    

   

</script>

</body>

</html>