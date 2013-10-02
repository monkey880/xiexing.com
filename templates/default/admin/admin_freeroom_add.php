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

<title>携行网酒店后台管理系统</title>

<style>

#content {

	width: 750px;

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

									<li class="current">免费房管理</li>

								</ul>

							</div></td>

					</tr>

					<tr>

					  <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/freeroom/save_freeroom'),array('id'=>'freeroomform'));?>

                        <input type="hidden" name="fid" value="<?php echo $fid ?>" />

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <table width="100%" cellpadding="0"  cellspacing="5" class="xx">

								<tr style="background: #fffef2;">

									<td colspan="2" class="left"

										style="height: 30px; line-height: 30px; width: 120px; padding-left: 20px; border: #f9d8b4 1px solid; color: #e86f0d;"><h2 style="float:left"><?php if ($id > 0) {echo '修改';} else {echo '添加';} ?>免费房</h2>  </td>

								</tr>

								<tr>

									<td class="right" width="120">标题：</td>

									<td><input name="R_Title" id="R_Title" type="text" value="<?php echo $R_Title;?>" /></td>

								</tr>

                                <tr>

									<td class="right" width="120">所属酒店：</td>

									<td>
                                    
                                    <input name="R_HotelID" type="hidden" value="<?php echo $R_HotelID?>" />
                                     <input name="R_HotelName" type="hidden" value="<?php echo $R_HotelName?>" />
                                    

										<?php echo $R_HotelName?>  
                                        
                                        选择房型：<select name="R_RoomID" id="R_RoomID">
										  <option value="-1" >选择房型</option>
                                          <?php foreach($roomtype_data as $val){?>
                                          <option value="<?php echo $val['rid'].','.$val['title'] ?>" <?php if($R_RoomID==$val['rid']){ echo "selected='selected'" ;} ?>><?php echo $val['title'].'--'.$val['price']."元" ?></option>
                                          <?php }?>
										</select>

                                    </td>

								</tr>

								<tr>

									<td class="right" width="120">入住日期：</td>

									<td>
                                    <div class="srh_box">

                        <div class="input_01">

                             <div class="input_001">

                                <span class="sicon_02" onclick="javascript:event.cancelBubble=true;showCalendar('txtComeDate',false,'txtComeDate','txtOutDate','txtOutDate','<?php echo $R_Checkintime ?>','','','','','text','')"></span>

                             </div>

                        </div>

                        <input name="R_Checkintime" type="text" value="<?php echo date('Y-m-d H:i:s',$R_Checkintime) ?>" id="R_Checkintime" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('R_Checkintime',false,'R_Checkintime','R_Checkouttime','R_Checkouttime','<?php echo $R_Checkintime ?>','','','','','text','')"/>

                  </div>
                                    
                   <div class="srh_box">

                        <div class="input_01">

                             <div class="input_001">

                                <span class="sicon_03" onclick="javascript:event.cancelBubble=true;showCalendar('txtOutDate',false,'txtOutDate','','','<?php echo $searchArray['tm2'] ?>','','','','','text','')"></span>

                             </div>

                        </div>

                        <input name="R_Checkouttime" type="text" value="<?php echo date('Y-m-d H:i:s',$R_Checkouttime) ?>" id="R_Checkouttime" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('R_Checkouttime',false,'R_Checkouttime','','','<?php echo $R_Checkouttime ?>','','','','','text','')"/>

                  </div>                 
                                    
                                </td>

								</tr>

								

                         
                            	<tr>

									<td class="right" width="120">
                                    介绍：</td>

									<td style="color: #999;"><textarea name="R_Content" id="R_Content" cols="" rows="" class="nr" style="width:600px"><?php echo $R_Content;?></textarea>

								  </td>

								</tr>
                                
                                 <tr>

									<td class="right" width="120">状态：</td>

									<td>
                                    

									  <p>
										  <label>
										    <input name="R_states" type="radio" id="states_0" value="1" checked="checked" />
										    可申请</label>
										   
								      <label>
										    <input type="radio" name="R_states" value="0" id="states_1" />
										    不可申请</label>
										  <br />
								    </p></td>

								</tr>

								<tr>

									<td class="right" width="120"></td>

									<td><input type="submit" class="tjzx" value="提&nbsp;交" name="">

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

	var editor_a = new baidu.editor.ui.Editor();

	editor_a.render('R_Content');

	

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



</body>

</html>