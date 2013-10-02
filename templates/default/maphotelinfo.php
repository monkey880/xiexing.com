<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />
<!--日历js和css-->
<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.tinyscrollbar.js"></script>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/dialog/dialog.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url();?>public/js/room.utf8.js" type="text/javascript"></script>
<link href="<?php echo $order_api ?>room.utf8.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>public/css/map.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>public/css/mapbase.css" rel="stylesheet" type="text/css" />
<!--百度地图js和css-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<title><?php echo $keywords_array['k_title'] ?></title>
<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />
<meta name="description" content="<?php echo $keywords_array['k_description'] ?>" />
</head>
<body>
<div class="hotellist">
  
  <div class="maplistside">
    <dl>
      <dt><a target="_blank" href="/booking/info_11465/"><img width="116" height="87" src="http://tp1.znimg.com/Hotel_Images/11465/120x90_a1929b06-8e8b-4cb6-87dd-126c660b32ac.jpg" class="hotelpic" style="width: 116px; height: 87px; margin: 0px;"></a></dt>
      <dd>
        <ul>
          <li style="visibility: visible;">星级：<img width="1" height="1" class="star star0" src="images/bank.gif"></li>
          <li style="visibility: visible;">好评：<span class="c_8e9">73% (来自41篇评论)</span></li>
          <li style="visibility: visible;">价格：<span class="c_f60" style="color: rgb(229, 111, 15);">￥180</span>起</li>
          <li class="h_add" style="visibility: visible;">地址：民主路58号（近漕宝路）</li>
          <li><a target="_blank" class="details" href="/booking/info_11465/">查看详情&gt;&gt;</a></li>
        </ul>
      </dd>
    </dl>
  </div>
  <div class="maplistmain">
    <div class="listmian_nav">
      <ul>
        <li><a class="cur">房型价格</a></li>
        <li><a>住客点评</a></li>
        <li><a>酒店图片</a></li>
        <li><a>服务设施</a></li>
        <li><a>酒店周边</a></li>
      </ul>
    </div>
    <div style="width:437px;z-index:1;background:#ffffff;" class="tsbar_1">
     <div class="scrollbar" style="height: 198px;"><div class="track" style="height: 198px;"><div class="thumb" style="top: 0px; height: 82.7089px;"><div class="scroll_top" style="height:4px;"></div><div class="scroll_bottom" style="height:4px;"></div></div></div></div>
      <div style="width: 437px; " class="viewport">
        <div class="overview" style="top: 0px;">
          <div class="hotel_list_right" style="width:437px;padding-bottom:20px;">
            <div class="hotel_room_list_info tab_content" style="display: block;">
              <div id="list_srh_top">
                <div style="width:170px;" class="srh_box_tm1">
                  <label for="tm1">入住时间</label>
                  <div style="width:116px;" class="qcbox">
                    <div style="position: relative; z-index: 1;" id="Wrapper">
                      <div style="cursor: pointer;height: 19px;overflow: hidden;padding-left:4px;position:absolute;right:-1px;_right: 2px;top:2px;z-index:1;" id="Container"><span class="sinfo"></span><span class="sicon"></span></div>
                    </div>
                    <input type="text" value="" id="tm1" class="input_txt2" name="tm1" initdate="true">
                  </div>
                </div>
                <div style="width:170px;" class="srh_box_tm1">
                  <label for="tm2">离店时间</label>
                  <div style="width:116px;" class="qcbox">
                    <div style="position: relative; z-index: 1;" id="Wrapper">
                      <div style="cursor: pointer;height: 19px;overflow: hidden;padding-left:4px;position:absolute;right:-1px;_right: 2px;top:2px;z-index:1;" id="Container"><span class="sinfo"></span><span class="sicon"></span></div>
                    </div>
                    <input type="text" value="" id="tm2" class="input_txt2" name="tm2" initdate="true">
                  </div>
                </div>
                <div class="srh_box_btn"><a class="" href="#"></a></div>
              </div>
              <div class="clearfloat"></div>
             <div id="h<?php echo $hotelInfo['hotel_id']; ?>">
                                        <p style="text-align:center;"><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>
                                    </div>
            </div>
            <div class="hotel_room_list_dianping tab_content" style="display: none;"></div>
            <div class="hotel_room_list_tupian tab_content mappic" style="display: none;"></div>
            <div class="hotel_room_list_sheshi tab_content" style="display: none;">
              <div class="mapserve">
                <div class="serve1"><span>酒店特色</span>
                  <div class="serve_line"></div>
                  <p>位于七宝古镇中心，毗邻闵行体育公园、汇宝购物广场，环境舒适的经济型酒店。</p>
                </div>
              </div>
              <div class="mapserve">
                <div class="serve1"><span>服务设施</span>
                  <div class="serve_line"></div>
                  <p>叫醒服务、洗衣服务、免费停车场、大床、双床、上网、停车场、刷卡</p>
                </div>
              </div>
              <div class="mapserve">
                <div class="serve1"><span>餐饮服务</span>
                  <div class="serve_line"></div>
                  <p>美林小厨：只提供早餐。</p>
                </div>
              </div>
            </div>
            <div class="hotel_room_list_zhoubian tab_content" style="display: none;">
              <div class="tiafficnav"><a class="cur">交通路线</a><a>周边搜索</a></div>
              <div class="tiafficcon" style="display:none">
                <ul>
                  <li><span>景点</span><a href="#">公园</a>|<a href="#">博物馆</a>|<a href="#">游乐场</a>|<a href="#">动物园</a>|<a href="#">名胜古迹</a>|<a href="#">场馆建筑</a></li>
                  <li><span class="tiaico1">餐饮</span><a href="#">中餐</a>|<a href="#">西餐</a>|<a href="#">快餐</a>|<a href="#">咖啡厅</a>|<a href="#">日本菜</a>|<a href="#">火锅</a>|<a href="#">甜点</a></li>
                  <li><span class="tiaico2">生活</span><a href="#">银行</a>|<a href="#">超市</a>|<a href="#">医院</a>|<a href="#">加油站</a>|<a href="#">公交车站</a>|<a href="#">火车票代售点</a></li>
                  <li><span class="tiaico3">休闲</span><a href="#">网吧</a>|<a href="#">健身房</a>|<a href="#">KTV</a>|<a href="#">电影院</a>|<a href="#">购物商场</a>|<a href="#">酒吧</a></li>
                  <li class="tia4">
                    <input type="text" name="">
                    <a href="#"></a></li>
                </ul>
              </div>
              <div class="tiafficmain">
                <ul>
                  <li><img width="1" height="1" src="images/bank.gif" class="gooutimg1">到酒店去</li>
                  <li class="goout1">
                    <input type="text" name="">
                    <a href="#"></a></li>
                  <li><img width="1" height="1" src="images/bank.gif" class="gooutimg2">到酒店出发</li>
                  <li class="goout2">
                    <input type="text" name="">
                    <a href="#"></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
loadPrice("<?php echo $hotelInfo['hotel_id']; ?>",'<?php echo $sk_array['tm1']; ?>','<?php echo $sk_array['tm2']; ?>');
//地图开始
var map = new BMap.Map("DP_Map_Show");
var point=new BMap.Point(<?php echo $hotelInfo['baidu_lng']; ?>,<?php echo $hotelInfo['baidu_lat']; ?>);
map.setMinZoom(9);
map.centerAndZoom(point, 17);
var marker = new BMap.Marker(point);  // 创建标注
map.addOverlay(marker);              // 将标注添加到地图中
map.addControl(new BMap.NavigationControl());

$(function(){
    //酒店介绍，酒店图片，周边地表，tab切换
    $("#hotel_info_div").show();
    $("#hotel_picture_div").hide();
    $("#hotel_lable_div").hide();
    $("#hotel_info_tab").click(function(){divclass($(this),'hotel_info_div');}) ;
    $("#hotel_picture_tab").click(function(){divclass($(this),'hotel_picture_div');}) ;
    $("#hotel_lable_tab").click(function(){divclass($(this),'hotel_lable_div');}) ;
    //评论，问答，tab切换
    $("#hotel_comment_div").show();
    $("#hotel_question_div").hide();
    $("#comment_tab").click(function(){divclass2($(this),'hotel_comment_div');}) ;
    $("#question_tab").click(function(){divclass2($(this),'hotel_question_div');}) ;
    //轮播图片
    var len  = $("#numeric > li").length;var index = 0;
    var isie =  document.all ? 'IE' : 'others';
    if (isie == 'IE') {
		if (!document.documentMode || document.documentMode < 8) {
			var lunbolen = 156;	
		} else {
			var lunbolen = 154;	
		}
	} else {
		var lunbolen = 155;	
	}
    
    	
    var interval = setInterval(function(){rotatorimg(index,232,lunbolen);index++;if(index==len){index=0;}},1000);
    $("#numeric li").mouseover(function(){index= $("#numeric li").index(this);rotatorimg(index,232,154);}); 
    
    //酒店图片
    $('.hotel_picture_small').mousemove(change_hotel_picture_small);

    $("#Map_Show").fancybox({
        'width'             : 580,
        'height'            : 480,
        'autoScale'         : false,
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'type'              : 'iframe',
        'overlayOpacity' : '0.8',
        'overlayColor' : '#000'        
    });
	
	$(".tsbar_1").tinyscrollbar({axis:"y"});

    
})
function divclass(divclass,divid){
    $('#hotel_info_tab').removeClass(); 
    $('#hotel_picture_tab').removeClass();
    $('#hotel_lable_tab').removeClass();
    $(divclass).addClass('current');  
    
    $("#hotel_info_div").hide();
    $("#hotel_picture_div").hide();
    $("#hotel_lable_div").hide();
    $("#"+divid).show();
     
}
function divclass2(divclass,divid){
    $('#comment_tab').removeClass(); 
    $('#question_tab').removeClass();
    $(divclass).addClass('current');
    
    $("#hotel_comment_div").hide();
    $("#hotel_question_div").hide();
    $("#"+divid).show();   
}
function change_hotel_picture_small (){
    var src = $(this).attr("src");
    current = $(this).attr("id").substring('8');
	$("#hotelpic_list").attr('current',current);
    $('.hotel_picture_big').attr('src',src);  
}

function set_nexpic(sort)
{
	var hotelpic_num = $("#hotelpic_list").attr('total');
	var current = $("#hotelpic_list").attr('current');
	if (sort == 'right') {
		var nextid = current < hotelpic_num ? parseInt(current)+1 : 1;
	} else {
		var nextid = current > 1 ? parseInt(current)-1 : 5;	
	} 
	 
	$("#hotelpic_list").attr('current',nextid);
	var src = $("#current_"+nextid).attr('src');
 	$('.hotel_picture_big').attr('src',src); 
}
</script>
</body>
</html>