<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<title>携行网酒店后台管理系统</title>

<style>

#gonggao ul { padding:10px 10px 25px 10px; font-family:"微软雅黑"; width:100%;}

#gonggao ul li { padding:2px 10px 2px 5px; color:#1b5ba2; width:535px; line-height:20px;float:left;border-bottom:1px solid #EAEAEA; 

text-align:left; background:url(<?php echo base_url();?>public/admin/default/images/xdfzdf.gif) no-repeat; padding-left:15px; background-position:left center;}

#gonggao ul li span{ float:right;color:#999999;}

</style>



<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<link href="<?php echo base_url();?>public/css/page_pop.css" rel="stylesheet" type="text/css" />

<script>

$(function(){

    check_new_version();

})



function show_TB (msg) 

{

	TB_OUT_show('',msg,'460','200');		

}



function TB_OUT_show(caption, url,w,h)

{

	TB_remove();

	TB_show(caption, url,w,h);

}



function TB_show(caption, url,w,h) { 

	try {

		$("body")

		.append("<div id='TB_overlay'></div><div id='TB_window'></div>");

		$("#TB_overlay").css("opacity","0.6");

		$("#TB_overlay").css("filter","alpha(opacity=60)");

		$("#TB_overlay").css("-moz-opacity","0.6");

		$(window).resize(TB_position);

		

		//

		$("body").append("<div id='TB_load'><div id='TB_loadContent'>&nbsp;</div></div>");

		$("#TB_overlay").show();

		//

	

		var queryString = url.replace(/^[^\?]+\??/,'');

		var params = parseQuery( queryString );

		

		

		TB_WIDTH = parseInt(w) + 30;

		TB_HEIGHT = parseInt(h) + 40;

		

		ajaxContentW = TB_WIDTH - 30;

		ajaxContentH = TB_HEIGHT - 45;

		$("#TB_window").append("<div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton'>关闭</a></div><div id='TB_ajaxContent' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px;'></div>");

		$("#TB_closeWindowButton").click(TB_remove);

		

        $("#TB_ajaxContent").append("<br /><br /><center>"+url+"<center>");

		TB_position();

		$("#TB_load").remove();

		$("#TB_window").show();

		

	} catch(e) {

		alert( e );

	}

}



function TB_remove() {

	$('#TB_window,#TB_overlay,#TB_load').remove(); 

	return false;

}



function TB_position() {

	var de = document.documentElement;

	var w = self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;

	var h = self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;

  

  	if (window.innerHeight && window.scrollMaxY) {	

		yScroll = window.innerHeight + window.scrollMaxY;

	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac

		yScroll = document.body.scrollHeight;

	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari

		yScroll = document.body.offsetHeight;

  	}

	

	$("#TB_window").css({width:TB_WIDTH+"px",height:TB_HEIGHT+"px",

	left: ((w - TB_WIDTH)/2)+"px", top: ((h - TB_HEIGHT)/2)+"px" });

	$("#TB_overlay").css("height",yScroll +"px");

}



function parseQuery ( query ) {

	   var Params = new Object ();

	   if ( ! query ) return Params; // return empty object

	   var Pairs = query.split(/[;&]/);

	   for ( var i = 0; i < Pairs.length; i++ ) {

		  var KeyVal = Pairs[i].split('=');

		  if ( ! KeyVal || KeyVal.length != 2 ) continue;

		  var key = unescape( KeyVal[0] );

		  var val = unescape( KeyVal[1] );

		  val = val.replace(/\+/g, ' ');

		  Params[key] = val;

	   }

	   return Params;

}

function check_new_version()

{

	var chkurl = 'http://union.api.zhuna.cn/api/utf-8/ver.php?softname=x4&ver=<?php echo ZHUNA_SOFT_VERSION ?>&callback=?';

    $.getJSON(chkurl,

		function(data){

		    if(data.status == 1){

			     show_TB(data.msg);               

		    }                

		}

    )     

}



</script>





</head>



<body>



<div class="container">

    <?php $this->load->view('admin/admin_header');?>

    <div class="box">

        <?php $this->load->view('admin/admin_left');?>

        <div class="box_right">

            <table width="100%" cellpadding="0" cellspacing="0">

            <tr><td>

            <div class="wzdh"><h2>后台管理首页</h2></div>

            </td></tr>

            <tr><td>

            <div class="zhuti" style="margin-bottom:0;">

               <ul>

                   <li class="current">系统信息</li>

               </ul>

            </div>

            </td></tr>

            <tr><td>

            <table width="100%" class="ym_list" cellpadding="0" cellspacing="0">

                       <tr><td>PHP版本：</td><td class="f_f60"><?php echo phpversion();?></td><td>GD版本：</td><td class="f_f60"><?php echo function_exists('imagecreate') ? '支持' : '不支持'?></td><td>Register_Globals：</td><td class="f_f60"><?php echo ini_get('register_globals')?></td></tr>

                       <tr><td>Web服务器：</td><td class="f_f60"><?php echo $_SERVER['SERVER_SOFTWARE']?></td><td>服务器IP：</td><td class="f_f60"><?php echo isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '127.0.0.1' ;?></td><td>支持上传的最大文件：</td><td class="f_f60"><?php echo ini_get('upload_max_filesize');?></td></tr>



                   </table>

            </td></tr>

            <tr><td class="center">

            <div class="zhuti" style="margin-bottom:0;">

               <ul>

                   <li class="current">联盟公告</li>

               </ul>

            </div>

            </td></tr>

            <tr><td class="center">

            <div id="gonggao">

            <ul><script language="javascript" src="http://union.zhuna.cn/api/union_news.js"></script></ul>

            </div>

            </td></tr>

            <tr><td class="center">

            <div class="zhuti" style="margin-bottom:0;">

               <ul>

                   <li class="current">论坛新贴</li>

               </ul>

            </div>

            </td></tr>

            <tr><td class="center">

            <div id="gonggao">

            <ul><script type="text/javascript" src="http://bbs.union.zhuna.cn/api.php?mod=js&bid=7"></script></ul>

            </div>

            </td></tr>

            </table>

        </div>

    </div>

<?php $this->load->view('admin/admin_footer');?>

</div>

</body>

</html>