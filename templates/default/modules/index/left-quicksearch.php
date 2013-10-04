<?php

$ci = & get_instance ();

$ci->load->model ( 'model_common' );



$cityInfo = $ci->model_common->initCityinfo ();

$cityid = $cityInfo ['cityid'];

$cityname = $cityInfo ['cityname'];

$cityJson = json_encode ( array ('id' => $cityid, 'cityname' => $cityname ) );

?>

<div class="kscz_left" id="quick_search">

	<div class="kscz_top">

		<div class="zt">

			<h3>快捷查找</h3>

		</div>

		<div>

			<a href="javascript:void(0)"> 

				<input type="hidden" id="quick_cityid" /></span>

				<strong><input type="button" id="quick_txtCity"  onclick = "right_change_city()" class="city_name" /></span></strong>

			</a>

		</div>

	</div>

	<div class="kscz_bottom">

		<div class="k_b_t">

			<div class="kjc">
<ul class="fast_search_mod">
<li class="cate-1"><a title="地铁附近酒店预订" onclick="right_ajax_get_lable(170,1,this)" href="javascript:void(0)">地铁附近</a></li>
<li  class="cate-2"><a title="机场酒店预订" onclick="right_ajax_get_lable(135,1,this)" href="javascript:void(0)">机场酒店</a></li>
<li  class="cate-3"><a title="火车站附近酒店预订" onclick="right_ajax_get_lable(166,0,this)" href="javascript:void(0)">火车站附近</a></li>
<li  class="cate-4"><a title="学校附近酒店预订" onclick="right_ajax_get_lable(83,0,this)" href="javascript:void(0)">学校附近</a></li>
<li class="cate-5"><a title="展馆会场附近酒店预订" onclick="right_ajax_get_lable(70,0,this)" href="javascript:void(0)">展馆会场</a></li>
<li  class="cate-6"><a title="医院附近酒店预订" onclick="right_ajax_get_lable(119,1,this)" href="javascript:void(0)">医院附近</a></li>
<li  class="cate-7"><a title="景点附近酒店预订" onclick="right_ajax_get_lable(65,1,this)" href="javascript:void(0)">景点附近</a></li>
<li  class="cate-8"><a title="汽车站附近酒店预订" onclick="right_ajax_get_lable(163,0,this)" href="javascript:void(0)">汽车站</a></li></ul>

				<!--<ul>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(135,0)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_01.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(163,1)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_02.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(170,2)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_03.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(166,3)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_04.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(119,4)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_05.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(83,5)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_06.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(65,6)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_07.jpg" width="79" height="72" /></a></li>

					<li><a href="javascript:void(0)" onclick="ajax_get_lable(70,7)"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/cx_08.jpg" width="79" height="72" /></a></li>

				</ul>-->

			</div>

			<div class="xz" id="xz">

				<div class="xz_jiao" id="xz_jiao"></div>

				<div class="xz_top"></div>

				<div class="xz_middle" id="xz_middle_loading1">

					<ul class="xz_m_top" id="left_div_title">

                          

                    </ul>

                    <div id="left_div_middle">

					

					</div>

					<div class="seach_xz">

						查找：<input id="pointsearchinput" value="输入关键字查找酒店..." class="srh_input1 gray">&nbsp;&nbsp;<input type="button" id="pointsearchbutton" class="btn_50" value="查找">

					</div>

				</div>

				<div class="xz_middle" id="xz_middle_loading2">

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

new cityCA("#quick_txtCity",function(data){

    $("#quick_cityid").val(data&&data["eid"]||"");

    if(data){

        var id=data["id"];

    }else{

    	$("#quick_cityid").val(def.id);

    	$("#quick_txtCity").val(def.cityname); 

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

function ajax_get_lable(type,n){

	$('html').animate({scrollTop:$("#quick_search").offset().top}, 'slow');

    $('body').animate({scrollTop:$("#quick_search").offset().top}, 'slow');



    var cityid = $("#quick_cityid").val();

     

	var xz_display = $("#xz").css("display");

	if ((i!=n || xz_display=='none')  ) {

		$("#xz").css("display","block");

	    var xz_jiao_left = 25+n*87;

	    $("#xz_jiao").css("left",xz_jiao_left+"px");

	    

    	$.ajax({

			type: "GET",

			url: "<?php echo base_url() ?>index/ajax_get_lable?type="+type+"&cityid="+cityid,

			beforeSend : function(data)

			{

				$("#xz_middle_loading1").hide();

				$("#xz_middle_loading2").show();

			},

			success: function(msg)

			{

				var msg = $.parseJSON(msg); 

	            $("#xz_middle").html(''); 



	            $("#left_div_middle").html("<ul id='xz_middle'></ul>");

				var n = 0;

				$("#left_div_title").html('');

	            $.each(msg,function(i){

					n++;

					subwanglingsum ++;

	                var textinfo = '';

	                if (type == 170) {

	                	$("#left_div_title").show();

	                	$("#left_div_title").append("<li><a href='javascript:void(0)' onclick='left_change_subwayline("+n+")'>"+i+"</a></li>");

		                if (n == 1) {

		                	$("#left_div_middle").append("<ul id='left_div_"+n+"' class='left_div_middle' style='display:block;'></ul>");

				        } else {

				        	$("#left_div_middle").append("<ul id='left_div_"+n+"' class='left_div_middle' style='display:none;'></ul>");

					    }



		                $.each(msg[i],function(j){

	                		var textinfo = '';

		                	textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cityid+"-keyid-"+msg[i][j]['mapid']+"<?php echo $this->config->item('url_suffix') ?>' target='_blank'>"+msg[i][j]['title']+"</a></li>";

		                	

			                $("#left_div_"+n).append(textinfo); 

	                	});	

			        } else {

			        	$("#left_div_title").hide();

			        	textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cityid+"-keyid-"+msg[i]['id']+"<?php echo $this->config->item('url_suffix') ?>' target='_blank'>"+msg[i]['name']+"</a></li>";

		                

		                $("#xz_middle").append(textinfo); 

					}

					

	            });	



	            $("#xz_middle_loading1").show();

	            $("#xz_middle_loading2").hide();

	        },

			timeout:20000,

			error: function () 

			{	

				$("#xz").css("display","none");

				alert("请求超时请重试!");

			}

		});

	    	

	}else{

		$("#xz").css("display","none");

	}

	i = n;

}

function right_change_city(){

	$("#xz").css("display","none");		

}

function left_change_subwayline(n){

	for (ii=0;ii<subwanglingsum;ii++) {

		$("#left_div_"+(ii+1)).hide();	

    }

	$("#left_div_"+n).show();	

}

</script>

<script>

	$(function(){

		$("#pointsearchbutton").click(a);

		$("#pointsearchinput").focus(aa);

	})

	function a(){

		var cityid = $("#quick_cityid").val();

		var key = $("#pointsearchinput").val();

		if(key==''||key=='输入关键字查找酒店...'){

			$('#pointsearchinput').val('');	

			$('#pointsearchinput').focus();	

		}else{

			window.location = "<?php echo base_url() ?>hotellist/cityid-"+cityid+"-key-"+encodeURI(key)+"<?php echo $this->config->item('url_suffix') ?>";

		}	

	}

	function aa(){

		var key = $("#pointsearchinput").val();

		if(key==''||key=='输入关键字查找酒店...'){

			$('#pointsearchinput').val('');		

		}	

	}



	

</script>