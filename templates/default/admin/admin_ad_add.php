<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<!--选择时间用到的js-->

<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<title>携行网酒店后台管理系统</title>

<style>

#content{

    width:750px;

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

                            <h2>后台管理>>广告管理</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">广告管理</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/ad/save_ad'),array('id'=>'adform'));?>

                        <input type="hidden" name="ad_id" value="<?php echo $ad_id ?>" />

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx" onSubmit="return checkForm();>

                            <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2><?php if ($ad_id > 0) {echo '修改';} else {echo '添加';} ?>广告</h2></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">位置： </td>

                                <td><input size="40" name="area" id="area" type="text" value="<?php echo $ad_area;?>"/></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">位置代号： </td>

                                <td><input size="20" name="ad_name" id="ad_name" type="text" value="<?php echo $ad_name;?>" />&nbsp;请用英文,调用的时候用得着（如首页上部第一个的广告位可以这样写index_top_1)</td>

                            </tr> 

                            <tr>

                                <td class="right" width="120px">标题： </td>

                                <td><input size="40" name="title" id="title" type="text" value="<?php echo $ad_title;?>" /></td>

                            </tr>     

                            <tr>

                                <td class="right" width="120px">广告大小： </td>

                                <td>

                                    宽：<input type="text" size="10" value="<?php echo $ad_width;?>" id="sizewidth" name="sizewidth">&nbsp;&nbsp;&nbsp;

                                    高：<input type="text" size="10" value="<?php echo $ad_height;?>" id="sizeheight" name="sizeheight">

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">链接： </td>

                                <td><input size="40" name="link" id="link" type="text" value="<?php echo $ad_link;?>" /></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">类型： </td>

                                <td class="td_left">

                                <?php foreach ($ad_type_radio_arr as $key=>$val) { ?>

                                    <input type='radio' name='type_radio' value='<?php echo $key ?>' <?php if ($ad_type_radio == $key) {?>checked<?php } ?>  onclick="typechange(this.value);" /><?php echo $val ?>&nbsp;

                                <?php } ?>

                                <div style="display:<?php if ($ad_type_radio == 2) { echo 'block'; } else { echo 'none'; } ?>;" id="changetype2">

                                <div><span id="thumb_preview"><?php if ($ad_uploadfile != '') { ?><img src="<?php echo rtrim(base_url(),'/');?><?php echo $ad_uploadfile ?>" width="150" height="120" style="margin-bottom:6px"><?php } ?></span></div>

                        		上传：<input type="file" name="userfile" id="userfile" size="20" /> 

                                </div>        

                                <div style="display:<?php if ($ad_type_radio == 3) { echo 'block'; } else { echo 'none'; } ?>;" id="changetype3">广告代码：<textarea id="externallinks" rows="5" cols="60" name="externallinks"><?php echo $ad_externallinks ?></textarea>&nbsp;&nbsp;当您的密码泄露时此处可能被挂马！</div>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">排序： </td>

                                <td><input name="order" id="order" type="text" value="<?php echo $ad_order;?>" /></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">期限： </td>

                                <td>

                                    <?php foreach ($ad_state_radio_arr as $key=>$val) { ?>

                                        <input type='radio' name='state_radio' value='<?php echo $key ?>' <?php if ($ad_state_radio == $key) {?>checked<?php } ?>  onclick="statechange(this.value);" /><?php echo $val ?>&nbsp;

                                    <?php } ?>

                                    <div id="changestate" style="display:<?php if ($ad_state_radio == 1) { echo 'block'; } else { echo 'none'; } ?>;">

                                    开始日期：<input  name="start_date"  type="text" value="<?php echo $ad_starttime_show; ?>" id="txtComeDate" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('txtComeDate',false,'txtComeDate','txtOutDate','txtOutDate','','','','','','text','')"/>&nbsp;&nbsp;&nbsp;

                                    结束日期：<input  name="end_date"  type="text" value="<?php echo $ad_endtime_show; ?>" id="txtOutDate" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('txtOutDate',false,'txtOutDate','','','','','','','','text','')"/>

                                    </div>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px"></td>

                                <td><input type="submit" class="tjzx" value="提&nbsp;交" name="">

                                    &nbsp;&nbsp;

                                    <input type="button" onclick="javascript:history.back();" class="fhlb" value="返回列表" name="upload">

                                </td>

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



//submit操作

$("#adform").submit(function(){

    	if($('#area').val() == ""){

    	   alert("请填写位置！");   

    	   $('#area').focus();

    	   return(false);

       	}

    	

        if($('#ad_name').val() == ""){

    	   alert("请填写位置代号！");   

    	   $('#ad_name').focus();	   

    	   return(false);

       	}

        

    	if($('#title').val() == ""){

    	   alert("请填写标题！");   

    	   $('#title').focus();	   

    	   return(false);

       	}	

    	

    	if($('#sizewidth').val() == ""){

    	   alert("请填写广告宽度！");   

    	   $('#sizewidth').focus();

    	   return(false);

       	}

    	

    	if($('#sizeheight').val() == ""){

    	   alert("请填写广告高度！");   

    	   $('#sizeheight').focus();

    	   return(false);

       	}

    	

        if(!IsURL($('#link').val()))

    	{

    		alert("请填写正确广告链接！");

    		return false;	

    	}			

    	

        var type_radio_val=$('input:radio[name="type_radio"]:checked').val();

    	if(!type_radio_val){

    	   alert("请选择广告类型！");   

      	   return(false);

    	} else {

    		if(type_radio_val == 2){

    			if($('#userfile').val() == '' && $("#thumb_preview").html()==''){

    				alert('请上传图片！')

    		  	    $('#userfile').focus();	

    				return false;		

    			}

    		}	

    		if(type_radio_val == 3){				

    			if($('#externallinks').val() == ''){

    				alert('请填写广告代码！')

    		  	    $('#externallinks').focus();	

    				return false;		

    			}			

    		}

    	}				

    	

        var state_radio_val=$('input:radio[name="state_radio"]:checked').val();

    	if(!state_radio_val){

    	   alert("请选择广告期限！");   

      	   return(false);

    	} else {

    		if(state_radio_val == 1){

    			if($('#txtComeDate').val() == ''){

    				alert('请选择开始日期！')

    		  	    $('#txtComeDate').focus();	

    				return false;		

    			}

    			if($('#txtOutDate').val() == ''){

    				alert('请选择结束日期！')

    		  	    $('#txtOutDate').focus();	

    				return false;		

    			}					

    		}

    	}

})

function IsURL(str_url){ 

    var strRegex = "^((https|http|ftp|rtsp|mms)?://)"  

    + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@  

    + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184  

    + "|" // 允许IP和DOMAIN（域名） 

    + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.  

    + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名  

    + "[a-z]{2,6})" // first level domain- .com or .museum  

    + "(:[0-9]{1,4})?" // 端口- :80  

    + "((/?)|" // a slash isn't required if there is no file name  

    + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";  

    var re=new RegExp(strRegex);  

//re.test() 

    if (re.test(str_url)){ 

        return (true);  

     }else{  

        return (false);  

     } 

 }

 function checkDelForm(){

	var check = GetCheckboxValue('id_a[]');

	if( check == '' )

	{

		alert("好像您没有选择任何要删除广告吧?:-(");	

		return false;

	}

}



function typechange(v)

{

	if(v == '1'){

		$('#changetype2').css('display','none');

		$('#changetype3').css('display','none');		

	} 

	if(v == '2'){

		$('#changetype2').css('display','block');

		$('#changetype3').css('display','none');		

	} 

	if(v == '3') {

		$('#changetype2').css('display','none');

		$('#changetype3').css('display','block');		

	}

}



function statechange(v){

	if(v == '1'){

		$('#changestate').css('display','block');

	} else {

		$('#changestate').css('display','none');		

	}

}

</script>

</body>

</html>