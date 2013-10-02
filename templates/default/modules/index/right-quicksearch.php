<?php

$ci = & get_instance ();

$ci->load->model ( 'model_common' );



$cityInfo = $ci->model_common->initCityinfo ();

$cityid = $cityInfo ['cityid'];

$cityname = $cityInfo ['cityname'];

$cityJson = json_encode ( array ('id' => $cityid, 'cityname' => $cityname ) );

?>

<div class="kscz" id="right_quick_search">

    <div class="kscz_top">

		<div class="zt">

			<h3>快捷查找</h3>

		</div>

		<div class="cityname">

			<a href="javascript:void(0)"> 

				<input type="hidden" id="right_quick_cityid" /></span>

				<strong><input type="button" id="right_quick_txtCity"  onclick = "change_city()" class="city_name" /></span></strong>

			</a>

		</div>

	</div>

    <div class="kscz_bottom">

        <div class="k_b_t">

            <div class="kjc">
<ul class="fast_search_mod">
<li onclick="right_ajax_get_lable(170,1,this)" class="cate-1"><a  href="javascript:void(0)">地铁附近</a></li>
<li onclick="right_ajax_get_lable(135,1,this)" class="cate-2"><a  href="javascript:void(0)">机场酒店</a></li>
<li onclick="right_ajax_get_lable(166,0,this)" class="cate-3"><a  href="javascript:void(0)">火车站附近</a></li>
<li onclick="right_ajax_get_lable(83,0,this)" class="cate-4"><a  href="javascript:void(0)">学校附近</a></li>
<li onclick="right_ajax_get_lable(70,0,this)" class="cate-5"><a  href="javascript:void(0)">展馆会场</a></li>
<li onclick="right_ajax_get_lable(119,1,this)" class="cate-6"><a  href="javascript:void(0)">医院附近</a></li>
<li onclick="right_ajax_get_lable(65,1,this)" class="cate-7"><a  href="javascript:void(0)">景点附近</a></li>
<li onclick="right_ajax_get_lable(163,0,this)" class="cate-8"><a  href="javascript:void(0)">汽车站</a></li></ul>
               <!-- <ul>

                    <li><a href="javascript:void(0)" onclick="right_ajax_get_lable(135,1,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_01.jpg" width="79" height="72"/></a></li>

					<li><a href="javascript:void(0)" onclick="right_ajax_get_lable(163,0,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_02.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="right_ajax_get_lable(170,1,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_03.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="right_ajax_get_lable(166,0,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_04.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="right_ajax_get_lable(119,1,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_05.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="right_ajax_get_lable(83,0,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_06.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="right_ajax_get_lable(65,1,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_07.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="right_ajax_get_lable(70,0,this)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_08.jpg" width="79" height="72" /></a></li>

                </ul>-->

            </div>

            <div class="xz1" id="xz1">

				<div class="xz_jiao" id="right_xz_jiao"></div>

				<div class="<?php if (CFG_TEMPLETS_LAYOUT == 1) {echo "xz_top";} else {echo "xz_top1";} ?>"></div>

				<div class="xz_middle" id="right_xz_middle_loading1">

					<div id="close_xz_middle" class='right_div_middle' onclick="$('#xz1').hide()"><a href="javascript:void(0)" ><font class="f_right555">关闭</font></a></div>

					<ul class="xz_m_top" id="right_div_title">

                          

                    </ul>

                    <div id="right_div_middle">

					

					</div>

					<div class="seach_xz">

						查找：<input id="right_pointsearchinput" value="输入关键字查找酒店..." class="srh_input1 gray">&nbsp;&nbsp;<input type="button" id="right_pointsearchbutton" class="btn_50" value="查找">

					</div>

				</div>

				<div class="xz_middle" id="right_xz_middle_loading2">

					<p style="text-align:center;"><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>

				</div>

				<div class="xz_bottom"></div>

			</div>

        </div>

    </div>

</div>



<!--选择城市用到的js-->

<script type="text/javascript" src="http://tp1.znimg.com/javascript/public/js/city_ca_main.min.js"></script>

<script language="javascript">

//选择城市

var def= <?php echo $cityJson ?> ;

new cityCA("#right_quick_txtCity",function(data){

    $("#right_quick_cityid").val(data&&data["eid"]||"");

    if(data){

        var id=data["id"];

    }else{

    	$("#right_quick_cityid").val(def.id);

    	$("#right_quick_txtCity").val(def.cityname); 

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



var i = '';var subwanglingsum = 0;

function right_ajax_get_lable(type,m,obj){

	var cityid = $("#right_quick_cityid").val();

	var xz1_display = $("#xz1").css("display");

	if (i!=type || xz1_display=='none') {

		$("#xz1").css("display","block");

		layout = "<?php echo CFG_TEMPLETS_LAYOUT ?>";



		var isie =  document.all ? 'IE' : 'others'

		if (layout == 1) {

			if (isie == 'IE') {

				t = document.documentElement.scrollTop;

				if (!document.documentMode || document.documentMode < 8) {

					var top = $(obj).offset().top-25;	

				} else {

					var top = $(obj).position().top-95;

				}

			} else {

				var top = $(obj).position().top-85;

			}

			$("#xz1").css("top",top+"px");

			var left = $(obj).position().left-10;

			$("#xz1").css("left",left+"px");

		} else {

			if (isie == 'IE') {

				t = document.documentElement.scrollTop;

				if (!document.documentMode || document.documentMode < 8) {

					var top = $(obj).offset().top-32;	

				} else {

					var top = $(obj).offset().top-105;	

				}

			} else {

				var top = $(obj).position().top-90;

			}

			$("#xz1").css("top",top+"px");

			var left = $(obj).position().left-622;

			$("#right_xz_jiao").hide();	

			$("#xz1").css("background","url(<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/xz_top_bg_r.gif) no-repeat");

		    $("#xz1").css("left",left+"px");

			$("#xz1").css("top",top+"px");

		}

	    

	    

    	$.ajax({

			type: "GET",

			url: "<?php echo base_url() ?>index/ajax_get_lable?type="+type+"&cityid="+cityid,

			beforeSend : function(data)

			{

				$("#right_xz_middle_loading1").hide();

				$("#right_xz_middle_loading2").show();

			},

			success: function(msg)

			{

				var msg = $.parseJSON(msg); 

	            $("#xz1_middle").html(''); 



	            $("#right_div_middle").html("<ul id='xz1_middle'></ul>");

				var n = 0;

				$("#right_div_title").html('');

	            $.each(msg,function(i){

		            n++;

		            subwanglingsum ++;

	                var textinfo = '';

	                if (type == 170) {

	                	$("#right_div_title").show();

	                	$("#right_div_title").append("<li><a href='javascript:void(0)' onclick='change_subwayline("+n+")'>"+i+"</a></li>");

		                if (n == 1) {

		                	$("#right_div_middle").append("<ul id='div_"+n+"' style='display:block;'></ul>");

				        } else {

				        	$("#right_div_middle").append("<ul id='div_"+n+"' style='display:none;'></ul>");

					    }



		                $.each(msg[i],function(j){

	                		var textinfo = '';

		                	textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cityid+"-keyid-"+msg[i][j]['mapid']+"<?php echo $this->config->item('url_suffix') ?>' target='_blank'>"+msg[i][j]['title']+"</a></li>";

		                	

			                $("#div_"+n).append(textinfo); 

	                	});	

			        } else {

			        	$("#right_div_title").hide();

			        	textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cityid+"-keyid-"+msg[i]['id']+"<?php echo $this->config->item('url_suffix') ?>' target='_blank'>"+msg[i]['name']+"</a></li>";

		                

		                $("#xz1_middle").append(textinfo); 

					}

					

	            });



	            $("#right_xz_middle_loading1").show();

	        	$("#right_xz_middle_loading2").hide();	

				

	        },

			timeout:20000,

			error: function () 

			{	

				$("#xz1").css("display","none");

				alert("请求超时请重试!");

			}

		});

	    	

	}else{

		$("#xz1").css("display","none");

	}

	i = type;

}

function change_city(){

	$("#xz1").css("display","none");		

}

function change_subwayline(n){

	for (ii=0;ii<subwanglingsum;ii++) {

		$("#div_"+(ii+1)).hide();	

    }	

	$("#div_"+n).show();	

}



</script>

<script>

	$(function(){

		$("#right_pointsearchbutton").click(right_a);

		$("#right_pointsearchinput").focus(right_aa);

	})

	function right_a(){

		var cityid = $("#right_quick_cityid").val();

		var key = $("#right_pointsearchinput").val();

		if(key==''||key=='输入关键字查找酒店...'){

			$('#right_pointsearchinput').val('');		

			$('#right_pointsearchinput').focus();		

		}else{

			window.location = "<?php echo base_url() ?>hotellist/cityid-"+cityid+"-key-"+encodeURI(key)+"<?php echo $this->config->item('url_suffix') ?>";

		}	

	}

	function right_aa(){

		var key = $("#right_pointsearchinput").val();

		if(key==''||key=='输入关键字查找酒店...'){

			$('#right_pointsearchinput').val('');		

		}

	}

	

	

</script>