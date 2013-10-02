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

                            <h2>后台管理>>友情链接管理</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">友情链接管理</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/flink/save_flink'),array('id'=>'flinkform'));?>

                        <input name="page" type="hidden" type="title" value="<?php echo $this->uri->segment(5);?>"/>

                        <input name="flink_id" type="hidden" type="title" value="<?php echo $flink_id;?>"/>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx" onSubmit="return checkForm();>

                            <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2><?php if ($flink_id > 0) {echo '修改';} else {echo '添加';} ?>友情链接</h2></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">标题： </td>

                                <td>

                                    <input size="40" name="title" id="title" type="title" value="<?php echo $flink_title;?>"/>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">链接： </td>

                                <td><input size="40" name="link" id="link" type="text" value="<?php echo $flink_link;?>" /></td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">类型： </td>

                                <td class="td_left">

                                <?php foreach ($flink_type_radio_arr as $key=>$val) { ?>

                                    <input type='radio' name='type_radio' value='<?php echo $key ?>' <?php if ($key == $flink_type_radio) { ?> checked <?php  } ?>  onclick="typechange(this.value);" /><?php echo $val ?>&nbsp;

                                <?php } ?>

                                <div style="display:<?php if ($flink_type_radio == 2) { echo 'block'; } else { echo 'none'; } ?>;" id="changetype2">

                                <div><span id="thumb_preview"><?php if ($flink_uploadfile != '') { ?><img src="<?php echo base_url();?>public/uploadfiles/flink/<?php echo $flink_uploadfile ?>" width="150" height="120" style="margin-bottom:6px"><?php } ?></span></div>

                        		上传：<input type="file" name="userfile" id="userfile" size="20" /> 

                                </div>        

                                <div style="display:<?php if ($flink_type_radio == 3) { echo 'block'; } else { echo 'none'; } ?>;" id="changetype3">广告代码：<textarea id="externallinks" rows="5" cols="60" name="externallinks"><?php echo $flink_externallinks ?></textarea>&nbsp;&nbsp;当您的密码泄露时此处可能被挂马！</div>

                                </td>

                            </tr>

                            <tr>

                                <td class="right" width="120px">排序： </td>

                                <td><input name="order" id="order" type="text" value="<?php echo $flink_order;?>" /></td>

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

$("#flinkform").submit(function(){

    	if($('#title').val() == ""){

    	   alert("请填写标题！");   

    	   $('#title').focus();	   

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

    			if($('#userfile').val() == '' && $("#thumb_preview").html() == ''){

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

        

        if($('#order').val() == ""){

    	   alert("请填写排序！");   

    	   $('#order').focus();	   

    	   return(false);

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

		alert("好像您没有选择任何要删除友情链接吧?:-(");	

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