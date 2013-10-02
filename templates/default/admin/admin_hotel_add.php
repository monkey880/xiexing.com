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



<title>携行网－后台管理系统</title>

<style>

#content {

	width: 750px;

}
.litpic_span {
  cursor: pointer;
  height: 21px;
  margin-left: -60px;
  overflow: hidden;
  width: 77px;
}
#litpic {
  cursor: pointer;
  height: 20px;
  margin-left: -20px;
  opacity: 0;
  width: 85px;
}

</style>
<script type="text/javascript">
var picurl='';
function uploadSuccess(file,obj){
	document.getElementById(obj).value='';
	if(obj=='picture'){
		picurl="/public/uploadfiles/upload/"+file;
	}else{
		picurl+="/public/uploadfiles/upload/"+file+",";
	}
	
	document.getElementById(obj).value=picurl;
	document.getElementById(obj+'_img').innerHTML+="<img name='' src='/public/uploadfiles/upload/"+file+"' width='200' height='200' alt='' />";
}
function getpoint(point){
	$('#baidu_lng').val(point['lng']);
	$('#baidu_lat').val(point['lat']);
	
	
}
function getpoint2(point){
	
	$('#lng').val(point[0]);
	$('#lat').val(point[1]);
	
}
</script>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.easing-1.3.pack.js" type="text/javascript"></script>

<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$(function(){
	$("a.iframe").fancybox({
			'width':'90%',
			'height':'90%',
			'autoDimensions':'false'
			
		});
});
</script>
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

									<li class="current">酒店管理</li>

								</ul>

							</div></td>

					</tr>

					<tr>

					  <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/hotel/save_hotel'),array('id'=>'hotelform','accept-charset'=>'utf-8'));?>

                        <input type="hidden" name="hid" value="<?php echo $hid ?>" />
                       
                        

                       <input type="hidden" value="save" name="dopost">

                 
                        <table width="100%" cellpadding="0"  cellspacing="5" class="xx">

								<tr style="background: #fffef2;">

									<td colspan="4" class="left"

										style="height: 30px; line-height: 30px; width: 120px; padding-left: 20px; border: #f9d8b4 1px solid; color: #e86f0d;"><h2 style="float:left"><?php if ($hid > 0) {echo '修改';} else {echo '添加';} ?>酒店</h2>  <span style="float:right;"><input onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/freeroom/add/'.$hid)?>'" name="" type="button" value="添加免费房" class="tjzx" /></span></td>

								</tr>

								<tr>

									<td class="right" width="32">酒店名称：</td>

									<td colspan="3"><input name="HotelName" type="text" id="HotelName" value="<?php echo $HotelName;?>" size="60" /></td>

								</tr>

                                <tr>

									<td class="right" width="32">区域：</td>

									<td colspan="2">
                                    <input name="CityID" type="hidden" id="CityID" value="<?php echo $CityID;?>" />
                                    <input name="CityName" type="hidden" id="CityName" value="<?php echo $CityName;?>" />
                                    <input name="eareaid" type="hidden" id="eareaid" value="<?php echo $eareaid;?>" />
                                    <input name="eareaname" type="hidden" id="eareaname" value="<?php echo $eareaname;?>" />
<span id="citycon"><?php echo $CityName;?></span>,<span id="earecon"><?php echo $eareaname;?></span><br />

										<?php echo $provinceclass_select?><span id="sle_city"></span><span id="sle_area"></span>

                                    </td>
									<td>
                        <input type="type" name="baidu_lng" value="<?php echo $baidu_lng ?>" id="baidu_lng" />
                        <input type="type" name="baidu_lat" value="<?php echo $baidu_lat ?>" id="baidu_lat" />
                        <input type="type" name="lng" value="<?php echo $lng ?>" id="lng" />
                        <input type="type" name="lat" value="<?php echo $lat ?>" id="lat" /></td>

								</tr>

								<tr>

									<td class="right" width="32">地址：</td>

									<td colspan="3"><input name="Address" type="text" id="Address" value="<?php echo $Address;?>" size="60" /><a id="addmap" class="iframe" href="/easyou/addmapmark?city=上海">地图标注</a></td>

								</tr>

								<tr>

									<td class="right" width="32">商圈：</td>

									<td colspan="3"><input name="cbd_name" type="text" id="cbd_name" value="<?php echo $cbd_name;?>" size="30"  style="float:left"/>
                                      <div class="select_cbd">
                                        <input type="button" value="选择"  onclick="get_cbd();"/>
                                        <div id="cbd_list" style="display:none"></div>
                                      </div>
                                     <input name="cbd_id" type="hidden" id="cbd_id" value="<?php echo $cbd_id;?>" />
                                    </td>

								</tr>

								<tr>
								  <td class="right">图片：</td>
								  <td colspan="2" class="td_left"> <input name="picture" type="text" id="picture" size="60" value="<?php echo $picture;?>"/><br /><iframe src="<?php echo base_url();?>public/uploadfiles/index.php?t=picture" width="500" height="200" scrolling="Auto" frameborder="0"></iframe> 
                                  
                                 
                                 </td>
								  <td class="td_left"> <div id="picture_img"></div></td>
								  </tr>
								<tr>
								  <td class="right">酒店图库：</td>
								  <td colspan="3" class="td_left">	
                              <input name="Hotelpictures" type="text" id="Hotelpictures" size="60" value="<?php echo $Hotelpictures;?>"/><br /><iframe src="<?php echo base_url();?>public/uploadfiles/index.php?t=Hotelpictures" width="500" height="200" scrolling="Auto" frameborder="0"></iframe> 
                              
                              <div id="Hotelpictures_img"></div>
                                  </td>
								  </tr>
								<tr>
								  <td class="right">最低价格：</td>
								  <td class="td_left"><span style="color: #999;">
								    <input name="Min_price" type="text" id="Min_price" value="<?php echo $Min_price;?>" size="30"  style="float:left"/>
								  </span></td>
								  <td class="td_left">最高价格：</td>
								  <td class="td_left"><span style="color: #999;">
								    <input name="Max_price" type="text" id="Max_price" value="<?php echo $Max_price;?>" size="30"  style="float:left"/>
								  </span></td>
				          </tr>
								<tr>
								  <td class="right">早餐价格：</td>
								  <td class="td_left"><span style="color: #999;">
								    <input name="ZaocanPrice" type="text" id="ZaocanPrice" value="<?php echo $ZaocanPrice;?>" size="30"  style="float:left"/>
								  </span></td>
								  <td class="td_left">加床价格：</td>
								  <td class="td_left"><span style="color: #999;">
								    <input name="BedPrice" type="text" id="BedPrice" value="<?php echo $BedPrice;?>" size="30"  style="float:left"/>
								  </span></td>
				          </tr>
								<tr>

	                                <td class="right" width="32">来源：</td>

	                                <td colspan="3" class="td_left">

	                                <?php foreach ($soure_radio_data as $key=>$val) { ?>

	                                    <input type='radio' name='soure_radio' value='<?php echo $key ?>' <?php if ($soure == $key) {?>checked<?php } ?>  /><?php echo $val ?>&nbsp;

	                                <?php } ?>
   

	                                </td>

	                            </tr>
<tr>

									<td class="right" width="32">星级：</td>

									<td colspan="3">
                                    
	                                <?php foreach ($rank_ary as $key=>$val) { ?>

	                                    <input type='radio' name='star' value='<?php echo $key ?>' <?php if ($star == $key) {?>checked<?php } ?>  /><?php echo $val ?>&nbsp;

	                                <?php } ?>
                                    </td>

						  </tr>
                          <tr>

	                                <td class="right" width="32">优惠：</td>

	                                <td colspan="3" class="td_left">

	                                <?php 
									$youhui = explode(',',$youhui);
									
									foreach ($youhui_radio_data as $key=>$val) { 
									
												
									?>

	                                    <input name='youhui_radio[]' type='checkbox' value='<?php echo $key ?>' <?php if (in_array($key,$youhui)) {?>checked<?php } ?>  /><?php echo $val ?>&nbsp;

	                                <?php 
												}?>
   

	                                </td>

	                            </tr>
                            	<tr>
                            	  <td class="right">服务：</td>
                            	  <td colspan="3" >
                                  	<?php foreach($server_ary as $fw){
									?>

	                                    <input name='Service[]' type='checkbox' value='<?php echo $fw ?>' <?php if (substr_count($Service,$fw)>0) {?>checked<?php } ?>  /><?php echo $fw ?>&nbsp;

	                                <?php 
												}?>
                                  </td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">银行卡：</td>
                            	  <td colspan="3" >
                          <?php foreach($card_ary as $fw){
									?>

	                                    <input name='Card[]' type='checkbox' value='<?php echo $fw ?>' <?php if (substr_count($Card,$fw)>0) {?>checked<?php } ?>  /><?php echo $fw ?>&nbsp;

	                                <?php 
												}?>        
                                  </td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">开业时间：</td>
                            	  <td width="468" style="color: #999;"><input name="kaiye" type="text" id="kaiye" value="<?php echo $kaiye;?>" size="30"  style="float:left"/>&nbsp;&nbsp;</td>
                            	  <td width="16" >装修时间： </td>
                            	  <td width="358" style="color: #999;"><input name="zhuangxiu" type="text" id="zhuangxiu" value="<?php echo $zhuangxiu;?>" size="30"  style="float:left"/></td>
                          	    </tr>
                            	<tr>
                            	  <td class="right">连锁品牌：</td>
                            	  <td colspan="3" style="color: #999;"><input name="chain_name" type="text" id="chain_name" value="<?php echo $chain_name;?>" size="30"  style="float:left"/>
         <input name="chain_id" type="hidden" value="<?php echo $chain_id;?>" />                         
                                  </td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">Tags:</td>
                            	  <td colspan="3" style="color: #999;"><input name="Tags" type="text" id="Tags" value="<?php echo $Tags;?>" size="60" /></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">餐饮：</td>
                            	  <td colspan="3" style="color: #999;"><textarea name="Canyin" cols="60" rows="2" id="Canyin"><?php echo $Canyin;?></textarea></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">娱乐健身：</td>
                            	  <td colspan="3" style="color: #999;"><textarea name="yulejianshen" cols="60" rows="2" id="yulejianshen"><?php echo $yulejianshen;?></textarea></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">客房设施：</td>
                            	  <td colspan="3" style="color: #999;"><textarea name="kefangsheshi" cols="60" rows="2" id="kefangsheshi"><?php echo $kefangsheshi;?></textarea></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">酒店荣誉（特色）</td>
                            	  <td colspan="3" style="color: #999;"><textarea name="Rongyu" cols="60" rows="5" id="Rongyu"><?php echo $Rongyu;?></textarea></td>
                          	  </tr>
                            	<tr>
                            	  <td class="right">交通：</td>
                            	  <td colspan="3" style="color: #999;"><textarea name="Traffic" cols="60" rows="5" id="Traffic"><?php echo $Traffic;?></textarea></td>
                          	  </tr>
                            
                            	<tr>

									<td class="right" width="32">
                                    酒店简介：</td>

									<td colspan="3" style="color: #999;"><textarea name="Content" id="Content" cols="" rows="" class="nr" style="width:600px"><?php echo $Content;?></textarea>

								  </td>

								</tr>
                                <tr>

	                                <td class="right" width="32">显示：</td>

	                                <td colspan="3" class="td_left">

	                                  <p>
	                                    <label>
	                                      <input name="isShow" type="radio" id="isShow_0" value="1" <?php if($isShow){?> checked="checked"<?php }?> />
	                                      显示</label>
	                                   
	                                    <label>
	                                      <input type="radio" name="isShow" value="0" id="isShow_1"  <?php if(!$isShow){?> checked="checked"<?php }?> />
	                                      不显示</label>
	                                    <br />
                                    </p></td>

	                            </tr>
                                 <tr>

	                                <td class="right" width="32">排序：</td>

	                                <td colspan="3" class="td_left">
                                    <input name="paixu" type="text" value="<?php echo $paixu;?>" />

	                                 </td>

	                            </tr>

								<tr>

									<td class="right" width="32"></td>

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
	$('#Address').focusout(function(){
		$('#addmap').attr('href','<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/addmapmark?city='+$("#CityName").val()+'&keywords='+$("#Address").val());
		
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

	editor_a.render('Content');

	

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