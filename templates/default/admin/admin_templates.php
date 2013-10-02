<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<title>携行网酒店后台管理系统</title>

<link href="<?php echo base_url();?>public/css/page_pop.css" rel="stylesheet" type="text/css" />

<script>



function show_TB (remark) 

{

	TB_OUT_show('登录',"<?php echo base_url() ?><?php echo CFG_ADMINURL; ?>/templates/show_TB/"+remark+"/<?php echo $layoutPage ?>",'460','260');		

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

		

		$("#TB_ajaxContent").load(url, function(){

			TB_position();

			$("#TB_load").remove();

			$("#TB_window").show();

		});

		

		

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

            <div class="wzdh"><h2>后台管理>>网站定制>>页面管理</h2></div>

            </td></tr>

            <tr><td>

            <div class="ymbt">

                 <div class="bqleft">

					<?php foreach ($layoutList as $val) { ?>

					<span class="<?php echo $val['class_show'] ?>"><em><a href="<?php echo site_url(CFG_ADMINURL.'/templates/index/'.$val['layout_page']); ?>"><?php echo $val['layout_pagename'] ?></a></em></span>	

					<?php } ?> 	        

                 </div> 

            </div>

            </td></tr>

            <tr><td>

            <div class="zhuti">

               <ul>

                   <li class="current">模板修改</li>

               </ul>

            </div>

            </td></tr>

            <tr><td class="center">

            </td></tr>

            <tr><td class="center">

            <div class="nrkk">

                 <div class="bknr">

                         <span class="note1"><em>页面布局图解</em></span>                

                 </div>

                 <span>

                 	<?php

	                 	if(CFG_TEMPLETS_LAYOUT != 1) {

	                 		$colspan1=1;$colspan2=3;

	                 		$width1 =25;$width2 =75;

	                 		$begin = "";$end = 1;

	                 	} else {

	                 		$colspan1=3;$colspan2=1;

	                 		$width1 =75;$width2 =25;

	                 		$begin = 1;$end = "";

	                 	}

                 	?>

                    <table  class="mb" width="800px" align="center"  valign="middle">

                    	<?php echo form_open_multipart(site_url(CFG_ADMINURL.'/templates/save_templates'),array('id'=>'adform'));?>	

			            <input name="layoutId" value="<?php echo $layout['layout_id'] ?>" type="hidden"  />

			            <input name="layoutPage" value="<?php echo  $layout['layout_page'] ?>" type="hidden"  />

			            <input name="layoutPageName" value="<?php echo $layout['layout_pagename'] ?>" type="hidden"  />

						<?php 

                    		if ($layout['layout_page'] == 'index' || $layout['layout_page'] == 'onecity') { 

                    	?>

                        <tr><td colspan="4" width="100%">头部</td></tr> 

                        

                        <tr>

                        	<td class="red" width="50%" colspan='2'>

                        		<a href="javascript:void(0)" onclick="show_TB('<?php echo $layoutInfo[0]['location'] ?>')" id="<?php echo $layoutInfo[0]['location'] ?>_a"><?php echo $layoutInfo[0][2] ?></a>

                        		<input name='a0' type='hidden' value="<?php echo $layoutInfo[0]['layout_module'] ?>" id="<?php echo $layoutInfo[0]['location'] ?>_input" />

                        	</td>

                        	<td class="red" width="50%" colspan='2'>

                        		<a href="javascript:void(0)" onclick="show_TB('<?php echo $layoutInfo[1]['location'] ?>')" id="<?php echo $layoutInfo[1]['location'] ?>_a"><?php echo $layoutInfo[1][2] ?></a>

                        		<input name='a1' type='hidden' value="<?php echo $layoutInfo[1]['layout_module'] ?>" id="<?php echo $layoutInfo[1]['location'] ?>_input" />

                        	</td>

                        </tr>

                        <?php 

	                        for ($i=2;$i<=9;$i++) { 

                        		$td_begin = $i + $begin;

                        		$td_end = $i + $end;

                        ?>

                        <tr>

                        	<td class="red" width="<?php echo $width2 ?>%" colspan=<?php echo $colspan2 ?>>

                        		<a href="javascript:void(0)" onclick="show_TB('<?php echo $layoutInfo[$td_begin]['location'] ?>')" id="<?php echo $layoutInfo[$td_begin]['location'] ?>_a"><?php echo $layoutInfo[$td_begin][2] ?></a>

                        		<input name='a<?php echo $td_begin; ?>' type='hidden' value="<?php echo $layoutInfo[$td_begin]['layout_module'] ?>" id="<?php echo $layoutInfo[$td_begin]['location'] ?>_input" />

                        	</td>

                        	<td class="red" width="<?php echo $width1 ?>%" colspan=<?php echo $colspan1 ?>>

                        		<a href="javascript:void(0)" onclick="show_TB('<?php echo $layoutInfo[$td_end]['location'] ?>')" id="<?php echo $layoutInfo[$td_end]['location'] ?>_a"><?php echo $layoutInfo[$td_end][2] ?></a>

                        		<input name='a<?php echo $td_end; ?>' type='hidden' value="<?php echo $layoutInfo[$td_end]['layout_module'] ?>" id="<?php echo $layoutInfo[$td_end]['location'] ?>_input" />

                        	</td>

                        </tr>

                        <?php $i++;} ?>

                        

                        <tr>

                        	<td class="red" width="100%" colspan="4">

                        		<a href="javascript:void(0)" onclick="show_TB('<?php echo $layoutInfo[10]['location'] ?>')" id="<?php echo $layoutInfo[10]['location'] ?>_a"><?php echo $layoutInfo[10][2] ?></a>

                        		<input name='a10' type='hidden' value="<?php echo $layoutInfo[10]['layout_module'] ?>" id="<?php echo $layoutInfo[10]['location'] ?>_input" />

                        	</td>

                        </tr>

                        <tr>

                        	<td class="" width="100%" colspan="4">

                        		<a href="javascript:void(0)" onclick="show_TB('<?php echo $layoutInfo[11]['location'] ?>')" id="<?php echo $layoutInfo[11]['location'] ?>_a"><?php echo $layoutInfo[11][2] ?></a>

                        		<input name='a11' type='hidden' value="<?php echo $layoutInfo[11]['layout_module'] ?>" id="<?php echo $layoutInfo[11]['location'] ?>_input" />

                        	</td>

                        </tr>

                        <tr><td width="100%" colspan="4" >底部</td></tr>

                        <?php  } else { ?>

                        <tr><td colspan="4"  width="100%"  >头部</td></tr>

                        <tr>

                        	<td class="red" colspan="<?php echo $colspan2 ?>"width="<?php echo $width2 ?>%">

                        		<a href="javascript:void(0)" onclick="show_TB('b0')" id="b0_a"><?php echo $layoutInfo[0][2] ?></a>

                        		<input name='b0' type='hidden' value="<?php echo $layoutInfo[0]['layout_module'] ?>" id="b0_input" />

                        	</td>

                        	<td class="red" colspan="<?php echo $colspan1 ?>"  rowspan="4" width="<?php echo $width1 ?>%">固定模块</td>

                        </tr>

                        <?php 

	                        for ($i=1;$i<=3;$i++) { 

                        ?>

                        <tr>

                        	<td class="red" colspan="<?php echo $colspan2 ?>" width="<?php echo $width2 ?>%">

                        		<a href="javascript:void(0)" onclick="show_TB('b<?php echo $i ?>')" id="b<?php echo $i ?>_a"><?php echo $layoutInfo[$i][2] ?></a>

                        		<input name='b<?php echo $i ?>' type='hidden' value="<?php echo $layoutInfo[$i]['layout_module'] ?>" id="b<?php echo $i ?>_input" />

                        	</td>

                        </tr>

                        <?php } ?>

                        <tr><td colspan="4"  width="100%">底部</td></tr>

                        <?php } ?>

                    </table>

                 </span>

            </div>

            </td></tr>

            <?php if ($operate['isedit']) { ?>

            <tr><td class="center">

            <table width="100%" style="height:70px;">

               <tr><td style="width:120px;"></td><td><input type="submit" class="tjzx" value="提&nbsp;交" name=""></td></tr>

            </table>

            </td></tr>

            <?php } ?>

            </table>

            </form>

        </div>

    </div>

    <?php $this->load->view('admin/admin_footer');?>

</div>

</body>

</html>