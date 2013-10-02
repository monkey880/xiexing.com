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

								<h2>后台管理>>礼品管理</h2>

							</div></td>

					</tr>

					<tr>

						<td><div class="zhuti">

								<ul>

									<li class="current">礼品管理</li>

								</ul>

							</div></td>

					</tr>

					<tr>

					  <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/product/save_product'),array('id'=>'product'));?>

                        <input type="hidden" name="ProductID" value="<?php echo $ProductID ?>" />

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <table width="100%" cellpadding="0"  cellspacing="5" class="xx">

								<tr style="background: #fffef2;">

									<td colspan="2" class="left"

										style="height: 30px; line-height: 30px; width: 120px; padding-left: 20px; border: #f9d8b4 1px solid; color: #e86f0d;"><h2 style="float:left"><?php if ($id > 0) {echo '修改';} else {echo '添加';} ?>礼品</h2>  </td>

								</tr>

								<tr>

									<td class="right" width="120">名称：</td>

									<td><input name="ProductName" id="ProductName" type="text" value="<?php echo $ProductName;?>" /></td>

								</tr>

                                <tr>

									<td class="right" width="120">编号：</td>

									<td>
                                  <input name="ProductNum" id="ProductNum" type="text" value="<?php echo $ProductNum;?>" />

                                    </td>

								</tr>
                                 <tr>

									<td class="right" width="120">价格：</td>

									<td>
                                  <input name="Price" id="Price" type="text" value="<?php echo $Price;?>" />

                                    </td>

								</tr>
                                
                                 <tr>

									<td class="right" width="120">兑换积分：</td>

									<td>
                                  <input name="PresentExp" id="PresentExp" type="text" value="<?php echo $PresentExp;?>" />

                                    </td>

								</tr>
                                
                                 <tr>

									<td class="right" width="120">库存：</td>

									<td>
                                  <input name="Stocks" id="Stocks" type="text" value="<?php echo $Stocks;?>" />

                                    </td>

								</tr>



								<tr>

									<td class="right" width="120">类型：</td>

									<td>
                                      <form id="form1" name="form1" method="post" action="">
                                        <p>
                                          <label>
                                            <input name="ProductType" type="radio" id="ProductType_0" value="3" <?php if($ProductType==3){ ?>checked="checked" <?php }?>/>
                                            免费礼品</label>
                                         
                                          <label>
                                            <input type="radio" name="ProductType" value="4" id="ProductType_1" <?php if($ProductType==4){ ?>checked="checked" <?php }?>/>
                                            积分</label>
                                          <br />
                                        </p>
                                  </form></td>

								</tr>

								

                         
                            	<tr>

									<td class="right" width="120">
                                  重量：</td>

									<td style="color: #999;"> <input name="Weight" id="Weight" type="text" value="<?php echo $Weight;?>" />

								  </td>

								</tr>
                                
                                 <tr>

									<td class="right" width="120">缩略图：</td>

									<td>
                                    

									  <div><span id="thumb_preview"><?php if ($ProductThumb != '') { ?><img src="<?php echo base_url();?>public/uploadfiles/upload/<?php echo $ProductThumb ?>" width="150" height="120" style="margin-bottom:6px"><?php } ?></span></div>

		                        		<input type="file" name="userfile" id="userfile" size="20" /> </td>

								</tr>
                                
                                 <tr>

									<td class="right" width="120">高清图：</td>

									<td>
                                    

									  <div><span id="thumb_preview"><?php if ($ProductPic != '') { ?><img src="<?php echo base_url();?>public/uploadfiles/upload/<?php echo $ProductPic ?>" width="150" height="120" style="margin-bottom:6px"><?php } ?></span></div>

		                        		<input type="file" name="userfile" id="userfile" size="20" /> </td>

								</tr>
                                
                                   <tr>

									<td class="right" width="120">描述：</td>

									<td>
                                    
<textarea name="ProductExplain" id="ProductExplain"><?php echo $ProductExplain;?></textarea> 
</td>

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

	editor_a.render('ProductExplain');

	

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