<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo base_url('public/js/ueditor')?>/editor_all.js"></script>

<script>window.UEDITOR_HOME_URL = '<?php echo base_url();?>'+"public/js/ueditor/";var imgpath_me = "<?php echo base_url();?>";</script>

<script type="text/javascript" charset="utf-8" src="<?php echo base_url('public/js/ueditor')?>/editor_config.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/js/ueditor/themes/default')?>/ueditor.css" />

<!--选择时间用到的js-->

<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/dialog/dialog.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/swfupload/swfupload/swfupload.js"></script>
<link href="<?php echo base_url();?>public/js/swfupload/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>public/js/swfupload/js/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/swfupload/js/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/swfupload/js/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "<?php echo base_url();?>public/js/swfupload/swfupload/swfupload.swf",
				upload_url: "<?php echo base_url();?>upload/do_upload",	
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "100 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 10,  //配置上传个数
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "images/TestImageNoText_65x29.png",
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">浏览</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	
			};

			swfu = new SWFUpload(settings);
	     };
		 var picurl='';
		var uploadSuccess = function (file, server_data, receivedResponse) {
			if(picurl!=''){
				picurl+=",/public/uploadfiles/upload/"+server_data;
			}
			else{
				picurl="/public/uploadfiles/upload/"+server_data;
			}
	document.getElementById('roomimg').value=picurl;
	document.getElementById('hotel_imgDiv').innerHTML+="<img name='' src='/public/uploadfiles/upload/"+server_data+"' width='200' height='200' alt='' />";
		}
	</script>


<title>携行网酒店后台管理系统</title>

<style>

#content {

	width: 750px;

}

label {
	display: inline;
}
</style>

</head>

<body>

	<div class="container">

    <?php $this->load->view('admin/admin_header');?>

    <div class="box">

        <?php $this->load->view('admin/admin_left');?>

<div class="box_right">

				<table width="100%" cellpadding="0" cellspacing="0" class="ym_bk">

					<tr>

						<td><div class="wzdh">

								<h2>后台管理>>酒店管理</h2>

							</div></td>

					</tr>

					<tr>

						<td><div class="zhuti">

								<ul>

									<li class="current">添加担保规则</li>

								</ul>

							</div></td>

					</tr>

					<tr>

					  <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/hotel/save_rule'),array('id'=>'hotelform','accept-charset'=>'utf-8'));?>

                        <input type="hidden" name="hid" value="<?php echo $hid ?>" />
        

                       

                 
                      
                        <table width="100%" cellpadding="0"  cellspacing="5" class="xx">

								<tr style="background: #fffef2;">

									<td colspan="4" class="left"

										style="height: 30px; line-height: 30px; width: 120px; padding-left: 20px; border: #f9d8b4 1px solid; color: #e86f0d;"><h2 style="float:left"><?php if ($rid > 0) {echo '修改';} else {echo '添加';} ?>担保规则</h2>  </td>

								</tr>

								<tr>

									<td class="right" width="91">担保规则标题：</td>

									<td width="788" colspan="3"><span style="color: #999;">
									  <input name="ruletitle" type="text" id="ruletitle" value="<?php echo $ruletitle;?>" size="30"  style="float:left"/>
									</span></td>

								</tr>

								<tr>

									<td class="right" width="91">房间数担保：</td>

									<td colspan="3">
									  <input name="rooms" type="text" id="rooms" value="<?php echo $rooms;?>" size="10"  style="float:left"/>
					间以上需要担保				</td>

								</tr>

								<tr>

									<td class="right" width="91">时间担保：</td>

									<td colspan="3"><label for="endtime"></label>
									  <select name="startime" id="startime">
									    <?php for($i=0;$i<24;$i++){ ?>
									    <option value="<?php echo $i?>" <?php  if($startime==$i){echo "selected='selected'" ;} ?>><?php echo $i.'点' ?></option>
									    <?php }?>
								      </select>
									  点 至
									  <select name="endtime" id="endtime">
									    <?php for($i=0;$i<24;$i++){ ?>
									     <option value="<?php echo $i?>" <?php  if($endtime==$i){echo "selected='selected'" ;} ?>><?php echo $i.'点' ?></option>
									    <?php }?>
								      </select>
									  点&nbsp;需要担保</td>

								</tr>

							
								<tr>
								  <td class="right">规则描述：</td>
								  <td colspan="3" class="td_left"><span style="color: #999;">
								    <textarea name="carddesc" cols="60" rows="5" id="carddesc"><?php echo $carddesc;?></textarea>
								  </span></td>
						  </tr>
							

								<tr>

									<td class="right" width="91"></td>

									<td colspan="3"><input type="submit" class="tjzx" value="提&nbsp;交" name="">

											&nbsp;&nbsp; <input type="button"  onclick="javascript:history.back();" class="fhlb"  value="返回列表" name="upload"></td>

								</tr>

						  </table>

						  </form>

					  </td>

					</tr>

				</table>

			</div>

		</div>
    <?php $this->load->view('admin/admin_footer');?>

</div>
<script>

    $(function(){

        //全选,取消全选
		
        $("#class_province").change(get_city);
		
    })
	function selectcbd(obj){
		$('#cbd_name').val($(obj).find('span').html());
		$('#cbd_id').val($(obj).find('p').html());
		$('#cbd_list').hide();
		
		}
    function get_cbd(){
		$('#cbd_list').show();
		
		var cityid = $("#CityID").val();
		
		$.ajax({

			type: "GET",

			url: "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel/ajax_select_cbd?cityid="+cityid,


			success: function(msg)

			{
	            $("#cbd_list").html(msg); 

	         },	
			 timeout:20000,

			error: function () 

			{	
			alert("请求超时请重试!");
			}
			});

	}

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
	
	function changeArea(){
		$('#eareaid').val($("#class_area option:selected").val());
		$('#eareaname').val($("#class_area option:selected").text());
		$('#earecon').html($("#class_area option:selected").text());
	}
	
	function getarea(){

        var class_area_val = $("#class_city").val();
		$('#CityID').val(class_area_val);
		$('#CityName').val($("#class_city option:selected").text());
		$('#citycon').html($("#class_city option:selected").text());
		
		$('#eareaid').val('');
		$('#eareaname').val('');
		$('#earecon').html('');
		
		$.ajax({

			type: "GET",

			url: "<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/hotel/ajax_select_area?cityid="+class_area_val,


			success: function(msg)

			{
	            $("#sle_area").html(msg); 

	         },	
			 timeout:20000,

			error: function () 

			{	
			alert("请求超时请重试!");
			}
			});

    }

</script>
<script>

	var editor_a = new baidu.editor.ui.Editor();

	

	

	//submit操作

	$("#newsform").submit(function(){

	    if ($('#title').val() == ""){

		   alert("请填写文章标题！");   

		   $('#title').focus();

		   return false;

	   	}

	    if($('#author').val() == ""){

		   alert("请填写作者！");   

		   $('#author').focus();

		   return false;

	   	}

	    if($('#cityid').val() == ""){

		   alert("请填写关联城市！");   

		   $('#cityid').focus();

		   return false;

	   	}

	    if($('input:radio[name="state_radio"]:checked').val() == 4 && $('#userfile').val() == '' && $("#thumb_preview").html()==''){

		   alert('请上传图片！')

	  	   $('#userfile').focus();	

		   return false;		

		}

	   	if($('#smallcontent').val() == ""){

		   alert("请填写文章简介！");   

		   $('#smallcontent').focus();

		   return false;

	   	}

		//var oEditor = FCKeditorAPI.GetInstance('content');   

	    //var checkContent = oEditor.GetXHTML();

	    //alert(checkContent);

		if($('#Content').val() == ""){

		    //if( checkContent == '' )

			//{

				//alert('填写文章正文！');	

				//return(false);		

			//}

	   	} 

	    if($('#order').val() == ""){

		   alert("请填写文章排序！");  

		   return false;

	   	}  

	})

	function typechange(v)

	{

		if (v == '4') {

		$('#changetype2').css('display','block');	

	} else {

		$('#changetype2').css('display','none');

	}

}

</script>

<!--选择城市用到的js-->



</body>

</html>