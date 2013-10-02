<?php
//图片路径text ID号
$imgID = $_REQUEST['imgID'];
//缩略图
$smallImgID = $_REQUEST['smallImgID'];
//弹出框ID号
$dialogID = $_REQUEST['dialogID'];
//缩略图宽度
$width = $_REQUEST['width'];
if(!$width)$width = 160;
//剪裁比例
$bili = $_REQUEST['bili'];
if(!$bili) $bili=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>图片上传</title>

<link href="/public/js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/public/js/uploadify/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/public/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="/public/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>

<script src="/public/js/uploadify/jquery.Jcrop.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/js/uploadify/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader'  : '/public/js/uploadify/uploadify.swf',
    'script'    : '/public/js/uploadify/uploadify.php',
    'cancelImg' : '/public/js/uploadify/cancel.png',
	 'hideButton' : false,
	 'width':90,
	 'height':26,
	 'buttonImg'  : '/public/js/uploadify/upload.png',	 
	 'wmode' : 'transparent',
    'folder'    : '/public/uploadfiles/upload',
    'auto'      : true,
	'onComplete': upComplete
  });
  $('#cropButton img').bind('click',function(){
	  		
	  		$.post("/public/js/uploadify/upSave.php","filename="+$('#filename').val()+"&filewidth="+$('#filewidth').val()+"&resize_width="+$('#resize_width').val()+"&x1="+$('#x1').val()+"&x2="+$('#x2').val()+"&y1="+$('#y1').val()+"&y2="+$('#y2').val(),function(msg){
				 $('#smallPicPath').html(msg);
				 $('#smallPicDiv').fadeIn(500);
				 $('#smallfilename').val(msg);
			   }
			   );
	  })
  var jcrop_api;
  function upComplete(event,queueId,fileObj,response,data){
	$('#filename').val(response);
	$('#preview').attr('src',response);
  	$('#imgTd').html('<img src='+response+' id="target" width="300" style="border:1px solid #ccc; padding:3px;">');
	$('#imgTd').css("border","1px solid #ccc");
	$('#imgTd').css("padding","3px");
	$('#bigPicPath').html(response);
	$('#bigPicDiv').fadeIn(500);
	$('#cropDiv').fadeIn(500);	
	$('#okButton').show();
	clearCoords();
	$('#target').Jcrop({
		onChange:   showCoords,
        onSelect:   showCoords,
        onRelease:  clearCoords,
		aspectRatio : <?php echo $bili?>
		},function(){
			jcrop_api = this;	
		});
  }
  function showCoords(c)
    {
      $('#x1').val(c.x);
      $('#y1').val(c.y);
      $('#x2').val(c.x2);
      $('#y2').val(c.y2);
      $('#w').val(c.w);
      $('#h').val(c.h);
	  
	  $('#resize_height').html(parseInt(((c.y2-c.y)/(c.x2-c.x))*$('#resize_width').val()));
	  $('#cropButton').show();
	  
	 
    };

    function clearCoords()
    {
      $('#x1').val('');
      $('#y1').val('');
      $('#x2').val('');
      $('#y2').val('');
      $('#w').val('');
      $('#h').val('');
	  $('#cropButton').hide();
  
    };

	$('input[name="crop"]').bind('click',function(e){
			jcrop_api.setOptions({aspectRatio:parseFloat(this.value)});
			jcrop_api.focus();
		});
	$('#upTool').bind('click',function(){
			$('#upTool').removeClass();
			$('#upTool').addClass('curTool');
			$('#ycTool').removeClass();
			$('#ycTool').addClass('tool');
			$('#ycTable').hide();
			$('#upTable').show();
		})
	$('#ycTool').bind('click',function(){
			$('#upTool').removeClass();
			$('#upTool').addClass('tool');
			$('#ycTool').removeClass();
			$('#ycTool').addClass('curTool');
			$('#ycTable').show();
			$('#upTable').hide();
		})
  
});

function over(){
	<?php
	if($smallImgID){
	?>
	parent.document.getElementById('<?php echo $smallImgID?>').value=$('#smallfilename').val();
	<?php
	}
	?>
	parent.document.getElementById('<?php echo $imgID?>').value=$('#filename').val();
	parent.Dialog.close('<?php echo $dialogID?>')
}



</script>
</head>
<body >
<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center"  style="margin-top:10px">
	<tr>
    	<td width="20" style="border-bottom:1px solid #CCC">&nbsp;</td>
    	<td width="75" height="30" id="upTool" align="center" class="curTool">上传图片</td>
        <td width="5" style="border-bottom:1px solid #CCC">&nbsp;</td>
        <td width="75" id="ycTool" align="center" class="tool">远程图片</td>
        <td width="449" style="border-bottom:1px solid #CCC"></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="margin-top:20px; display:none" id="ycTable">
    <tr>
        <td align="center" height="35">
        图片地址：<input type="text" size="60" name="yc_filename" id="yc_filename" />
        </td>
    </tr>
    <tr>
    	<td align="center"><input type="button" value="确 定" onclick="parent.document.getElementById('<?php echo $imgID?>').value=$('#yc_filename').val();parent.Dialog.close('<?php echo $dialogID?>')"/> <input type="button" value="取 消" onclick="parent.Dialog.close('<?php echo $dialogID?>')"/></td>
    </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="margin-top:10px;" id="upTable">
    <form id="coords"  class="coords" method="post"  action="upSave.php">
    <tr>
    	<td height="35" colspan="2" style="padding-left:5px;"><div style="float:left"><input id="file_upload" name="file_upload" type="file" /></div>
        <div style="float:left; margin-left:5px; display:none" id="cropButton"><img src="/uploadify/crop.png" style="cursor:pointer"/></div>
        <div style="float:left; margin-left:5px; display:none" id="okButton"><img src="/uploadify/ok.png" style="cursor:pointer" onclick="over()"/></div>
         <div style="float:left; margin-left:5px;" id="noButton"><img src="no.png" style="cursor:pointer" onclick="parent.Dialog.close('<?php echo $dialogID?>')"/></div>
        </td>
    </tr>
    <tr>
    	 <td style="padding-left:5px; padding-right:5px;" valign="top">
        	<input type="hidden" size="4" id="x1" name="x1" />
            <input type="hidden" size="4" id="y1" name="y1" />
            <input type="hidden" size="4" id="x2" name="x2" />
            <input type="hidden" size="4" id="y2" name="y2" />
            <input type="hidden" size="4" id="w" name="w" />
            <input type="hidden" size="4" id="h" name="h" />
            <input type="hidden" size="20" id="filename" name="filename" />
            <input type="hidden" size="20" id="smallfilename" name="smallfilename" />
            <input type="hidden" size="4" id="filewidth" name="filewidth" value="300"/>
            
            <div style="border:1px solid #ccc; display:none; background-color:#f5f5f5; padding:5px;" id="cropDiv">
            <div style=" margin-top:5px; margin-bottom:5px; font-weight:600;">缩略图宽度： <input type="text" size="4" id="resize_width" name="resize_width" value="<?php echo $width?>"/> 像素，高度：<span id="resize_height"></span>像素</div>
            <div style=" margin-top:5px; margin-bottom:5px; font-weight:600;">图片剪裁比例：</div>
            <input type="radio" name="crop" value="1" <?php if($bili == 1) echo 'checked'?>/> 1:1 比例
            <input type="radio" name="crop" value="1.33" <?php if($bili == 1.33) echo 'checked'?>/> 4:3 比例<br />
            <input type="radio" name="crop" value="1.5" <?php if($bili == 1.5) echo 'checked'?>/> 3:2 比例
            <input type="radio" name="crop" value="1.25" <?php if($bili == 1.25) echo 'checked'?>/> 5:4 比例<br />
            <input type="radio" name="crop" value="1.2" <?php if($bili == 1.2) echo 'checked'?>/> 6:5 比例
            <input type="radio" name="crop" value="0" <?php if($bili === '0') echo 'checked'?>/> 任意比例
            
           
            </div>
            <div style="border:1px solid #ccc;display:none; background-color:#f5f5f5; padding:5px; margin-top:5px;" id="bigPicDiv">
            	<div style=" margin-top:5px; margin-bottom:5px; font-weight:600;">大图路径：</div>
                <div id="bigPicPath"></div>
            </div>
            <div style="border:1px solid #ccc;display:none; background-color:#f5f5f5; padding:5px; margin-top:5px;" id="smallPicDiv">
            	<div style=" margin-top:5px; margin-bottom:5px; font-weight:600;">小图路径：</div>
                <div id="smallPicPath"></div>
            </div>
        </td>
        <td rowspan="3" width="300"  valign="top" style="padding-right:5px;"><div id="imgTd"></div></td>
       
    </tr>  
    </form> 
</table>



</body>
</html>