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

								<h2>后台管理>>资讯管理</h2>

							</div></td>

					</tr>

					<tr>

						<td><div class="zhuti">

								<ul>

									<li class="current">资讯管理</li>

								</ul>

							</div></td>

					</tr>

					<tr>

						<td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/news/save_news'),array('id'=>'newsform'));?>

                        <input type="hidden" name="aid" value="<?php echo $aid ?>" />

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <table width="100%" cellpadding="0"  cellspacing="5" class="xx">

								<tr style="background: #fffef2;">

									<td colspan="2" class="left"

										style="height: 30px; line-height: 30px; width: 120px; padding-left: 20px; border: #f9d8b4 1px solid; color: #e86f0d;"><h2><?php if ($aid > 0) {echo '修改';} else {echo '添加';} ?>资讯</h2></td>

								</tr>

								<tr>

									<td class="right" width="120px">文章标题：</td>

									<td><input name="title" id="title" type="text" value="<?php echo $title;?>" /></td>

								</tr>

                                <tr>

									<td class="right" width="120px">关联城市：</td>

									<td>

										<input name="cityid" id="cityid" type="hidden" autocomplete="off" value="<?php echo '' ?>" />

                            			<input name="txtCity" id="txtCity" type="text" autocomplete="off" value="<?php echo '' ?>" class="input_city"/>

                                    </td>

								</tr>

								<tr>

									<td class="right" width="120px">作者：</td>

									<td><input name="author" id="author" type="text" value="<?php echo $author;?>" /></td>

								</tr>

								<tr>

									<td class="right" width="120px">所属类别：</td>

									<td><?php echo $newsclass_select?>&nbsp;&nbsp;<a

										href="<?php echo site_url(CFG_ADMINURL.'/newsclass') ?>">管理类别</a></td>

								</tr>

								<tr>

	                                <td class="right" width="120px">显示状态：</td>

	                                <td class="td_left">

	                                <?php foreach ($state_radio_data as $key=>$val) { ?>

	                                    <input type='radio' name='state_radio' value='<?php echo $key ?>' <?php if ($state_radio == $key) {?>checked<?php } ?>  onclick="typechange(this.value);" /><?php echo $val ?>&nbsp;

	                                <?php } ?>

	                                <div style="display:<?php if ($state_radio == 4) { echo 'block'; } else { echo 'none'; } ?>;" id="changetype2">

		                                <div><span id="thumb_preview"><?php if ($img != '') { ?><img src="<?php echo base_url();?>public/uploadfiles/upload/<?php echo $img ?>" width="150" height="120" style="margin-bottom:6px"><?php } ?></span></div>

		                        		文章标题图片：<input type="file" name="userfile" id="userfile" size="20" /> 

	                                </div>        

	                                </td>

	                            </tr>

                            	<tr>

									<td class="right" width="120px">文章简介：</td>

									<td style="color: #999;"><textarea name="smallcontent" id="smallcontent" cols="" rows="" class="nr" style="height:170px;width:600px"><?php echo $smallcontent;?></textarea>

									</td>

								</tr>

								<tr>

									<td class="right" width="120px">文章正文：</td>

									<td style="color: #999;"><textarea name="content" id="content"><?php echo $content;?></textarea>

									</td>

								</tr>

								<tr>

									<td class="right" width="120px">&nbsp;</td>

									<td>文章正文支持特定标签：如标签”{中关村#10}“，代表调用该新闻关联城市下”中关村“附近的”10“个酒店的数据

									</td>

								</tr>

								<tr>

									<td class="right" width="120px">文章排序：</td>

									<td style="color: #999;"><input name="order" id="order"  type="text" value="<?php echo $order;?>" /></td>

								</tr>

								<tr>

									<td class="right" width="120px"></td>

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

	editor_a.render('content');

	

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

		if($('#content').val() == ""){

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

<script type="text/javascript" src="http://tp1.znimg.com/javascript/public/js/city_ca_main.min.js"></script>

<script language="javascript" >

//选择城市

var def= <?php echo $cityJson ?> ;

new cityCA("#txtCity",function(data){

    $("#cityid").val(data&&data["eid"]||"");

    if(data){

        var id=data["id"];

    }else{

    	$("#cityid").val(def.id);

    	$("#txtCity").val(def.cityname);  

    }

},{

    "ca":{"border":"1px solid #1364a9"},//最外层边框颜色

    "title":{"color":"#000","background":"#E6F0FD"},//标题

    "hotCity":{"over":{"color":"#ff0000"},"out":{"color":"#FFF"}},//导航鼠标选择

    "seleNav":{"border":"1px solid #1364a9","background":"red"},//导航选择

    "seleContent":{"border":"1px solid #1364a9","background":"#E6F0FD"},//城市选择

    "navFrame":{"border-bottom":"1px solid #1364a9","background":"#1776c6"},//导航外框

    "city":{"color":"#1776c6","z-index":5},//城市

    "content":{}//城市选择框

});

</script>

</body>

</html>