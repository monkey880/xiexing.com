<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>
<title><?php echo $metainfo['k_title']?></title>
<meta name="keywords" content="<?php echo $metainfo['k_keywords']?>" />
<meta name="description" content="<?php echo $metainfo['k_description']?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>public/css/map.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>public/css/mapbase.css">

<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=85654a7702d8b2163b85f87e6585b4f5"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/DistanceTool/1.2/src/DistanceTool_min.js"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/MarkerTool.js"></script>
<script type="text/javascript">
var isFullScreen=false;
var topHeight=108+35;
 var filter = []; //过滤条件
var isRightHide=false;		
var customLayer;
 var keyword     = "",   //检索关键词
        page        = 0,    //当前页码
        points      = []; //存储检索出来的结果的坐标数组


$(document).ready(function(){
    autoSize();
	$('.nav8').click(function(){
		if(isFullScreen){
		$(this).removeClass('nav8cur');
			
		$('.wrap_header_find').show();
		isFullScreen=false;
		topHeight=143;
		autoSize();
		
		}else{
			$('.wrap_header_find').hide();
			$(this).addClass('nav8cur');
			isFullScreen=true;
			topHeight=35;
			autoSize();
		}
		});
		
	$('.select_control').hover(function(){
		$(this).find('.select_list').show();},
		function(){
		$(this).find('.select_list').hide();}
	);
	
	
	$('.select_list li').hover(function(){
		$(this).find('dl').show();},
		function(){
		$(this).find('dl').hide();}
	);
	
	$('#ditie > dd ').hover(function(){
		$(this).find('span').show();},
		function(){
		$(this).find('span').hide();}
	);
	
	$('.navprice > li').click(function(){
	
	filter.push('price:' + $(this).find('a:first').attr('minprice')+','+ $(this).find('a:first').attr('maxprice'));
	searchAction();
	}
	);
	
	$('.navlevel > li').click(function(){
	
	filter.push('hotellevel:' + $(this).find('a:first').attr('rank')+','+ $(this).find('a:first').attr('rank'));
	searchAction();
	}
	);
	
	$('.navhotel > li').click(function(){
	
	filter.push('eareaid:' + $(this).find('a:first').attr('lsid')+','+ $(this).find('a:first').attr('lsid'));
	searchAction();
	}
	);
	
	$('.navwz > li > dl > a').click(function(){
	
	
	searchnearbydb($(this).attr('lsid'),2000);
	}
	);
	
	$('.nav1').click(function(){
	
	var mkrTool = new BMapLib.MarkerTool(map, {followText: "打点",autoClose:true});
	mkrTool.open();
	mkrTool.addEventListener("markend", function(e) {
		
	var point=e.marker.getPosition();
	searchnearby('',point,2000);
	var circle = new BMap.Circle(point,2000,{
							strokeColor:'#0033FF',
							fillColor:'#CC3300',
							fillOpacity:0.08,
							strokeOpacity:0.4,
							strokeWeight:2
						});
						circle.enableEditing();
						map.addOverlay(circle);
		
	});
	}
	);
	
	$('.shouqi').click(function(){
		
		$(this).find('div').toggleClass('unfold');
		$('.conside').toggle();
		$('.mainmap').width(function (n,c){
			if(c==$(window).width()){
			return ($(window).width()-325);
			
			}
			else{
				return $(window).width();
				
			}
		});
		$('#e_map').width(function (n,c){
			if(c==$(window).width()){
			return ($(window).width()-325);
			
			}
			else{
				return  $(window).width();
				
			}
		});
		
	});
	
	
	
	//列表tab
	$('.sidenav a').click(function(){
		var index=$(this).index()-1;
		$('.sidenav a').each(function(i){
			if(index==i){
			$(this).addClass('cur');
			}
			else{
				$(this).removeClass('cur');
			}
			});
			var action=$(this).attr('t');
			if(action=='tj'){
				searchAction(keyword, page,'hotellevel:-1')
			}
			else if(action=='jg'){
				searchAction(keyword, page,'price:1')
			}
			else if(action=='pj'){
				searchAction(keyword, page,'price:1')
			}
			else if(action=='jl'){
				searchAction(keyword, page,'distance:-1')
			}
		});
		
		//测距
		$('.zool0').click(function(){
			var myDis = new BMapLib.DistanceTool(map);
			 myDis.open();
			
			});
	
});


$(window).bind("resize",autoSize);
function autoSize(){
	var windowWidth=$(window).width();
var windowHeight=$(window).height();
var leftWidth=windowWidth-$('.conside').width();
var bottomHeight=windowHeight-topHeight;
$('.mainbody').css({"width":windowWidth,"height":windowHeight});
$('.main').css({"width":windowWidth,"height":bottomHeight});
$('.mainmap').css({"width":leftWidth,"height":bottomHeight});
$('#e_map').css({"width":leftWidth,"height":bottomHeight});

$('.side_left').css({"height":bottomHeight-12});
$('.tsbar_1').css("height",bottomHeight);
$('.viewport').css("height",bottomHeight);
$('.conside').css("height",bottomHeight);
		
}
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('.wt-good-item-n').hover(
  
  function () {
    $(this).addClass("wt-good-item-n-hover");
  }
  ,
  function () {
    $(this).removeClass("wt-good-item-n-hover");
  }
  );
  
  $('#city-border-mid').click(
  
  function () {
    $('#wt-city-list-new').show();
  }
  
  );
  $('#wt-city-list-new').hover(
  
  function () {
    
  },
  function () {
    $(this).hide();
  }
  
  );
  
  $(".letter").each(function(){
   $(this).hover(
   function(){
	   $(".all-city-con").each(function(){$(this).hide()});
	   $('#city-con'+$(this).html()).show();
   }
   )
 });
 var i=0;
 $('#TipArea').click(function(){
	 if(i==0){
	 $('.tuan-box-content').removeClass('hide-area');
	 i=1;
	 }
	 else{
		 $('.tuan-box-content').addClass('hide-area');
		 i=0;
	 }
	 });
  
});
</script>


<style type="text/css">
body, html, #mapsearch {
	width: 100%;
	height: 100%;
	overflow: hidden;
	margin:0;
}
</style>
</head>

<body>
<div class="mainbody" style="background-color: rgb(255, 255, 255); width: 1600px; height: 481px;">
  <div class="wrap_header_find clearfix">
    <div class="header">
      <div class="logo"><a href="http://www.xexing.com/"><img alt="携行网订酒店" src="<?php echo base_url();?>public/www/default/images/logo3.png"></a></div>
      <div class="topseach">
        <div>
          <ul>
            <li style=" width:50px;">
            
            <div class="wt-city float-left" style="margin-top:0px">
          <div class="city-border"  style="position:absolute;">
            <div id="city-border-left" class="city-border-left hide"></div>
            <div id="city-border-mid"><a id="wt-city-title" rel="nofollow" class="city-current" title="当前团购城市"><?php echo $cityinfo['cName'] ?></a><span id="wt-city-other" class="downtip"></span></div>
            <div id="city-border-right" class="city-border-right hide"></div>
          </div>
          <div  class="city-div-new hide" id="wt-city-list-new" style="left: 0px; top: 38px; ">
            <div class="title">热门城市</div>
            <span class="city-close"></span>
            <div class="city-con clearfix">
              <?php if($hotelcity){
				foreach($hotelcity as $cname){
				?>
              <span class="city-span"><a  href="/tuangou/<?php echo $cname['pinyin'] ?>" rel="<?php echo $cname['pinyin'] ?>" class="city-a"><?php echo $cname['cName'] ?></a></span>
              <?php }}?>
              <div class="clear"></div>
            </div>
            <div class="title"><span class="float-left">全部城市</span></div>
            <div id="all-letter" class="all-letter"> <a href="javascript:void(0)" letter="A" class="letter">A</a> <a href="javascript:void(0)" letter="B" class="letter">B</a> <a href="javascript:void(0)" letter="C" class="letter">C</a> <a href="javascript:void(0)" letter="D" class="letter">D</a> <a href="javascript:void(0)" letter="E" class="letter">E</a> <a href="javascript:void(0)" letter="F" class="letter">F</a> <a href="javascript:void(0)" letter="G" class="letter">G</a> <a href="javascript:void(0)" letter="H" class="letter">H</a> <a href="javascript:void(0)" letter="J" class="letter">J</a> <a href="javascript:void(0)" letter="K" class="letter">K</a> <a href="javascript:void(0)" letter="L" class="letter">L</a> <a href="javascript:void(0)" letter="M" class="letter">M</a> <a href="javascript:void(0)" letter="N" class="letter">N</a> <a href="javascript:void(0)" letter="P" class="letter">P</a> <a href="javascript:void(0)" letter="Q" class="letter">Q</a> <a href="javascript:void(0)" letter="R" class="letter">R</a> <a href="javascript:void(0)" letter="S" class="letter">S</a> <a href="javascript:void(0)" letter="T" class="letter">T</a> <a href="javascript:void(0)" letter="W" class="letter">W</a> <a href="javascript:void(0)" letter="X" class="letter">X</a> <a href="javascript:void(0)" letter="Y" class="letter">Y</a> <a href="javascript:void(0)" letter="Z" class="letter">Z</a> </div>
            <div id="all-city" class="city-con clearfix">
              <?php if($abccity){
				foreach($abccity as $abc=>$city){
				?>
              <div id="city-con<?php echo $abc; ?>" class="all-city-con <?php if($abc!='A') {echo 'hide';}?>">
                <?php foreach($city as $ci){?>
                <span class="city-span"><a  href="/tuangou/<?php echo $ci['pinyin'] ?>" rel="<?php echo $ci['pinyin'] ?>" class="city-a"><?php echo $ci['cName'] ?></a></span>
                <?php }?>
              </div>
              <?php }}?>
            </div>
          </div>
        </div>
        
        </li>
            <li style="display: list-item;" class="sea_in">
              <input style="color: rgb(0, 0, 0);" inputend="true" name="" autocomplete="off" value="北京站酒店" type="text" id="searchword">
            </li>
            <li class="sea_in2" style="display:none">
              <input style="color: rgb(184, 190, 195);" inputend="false" value="请输入起点" autocomplete="off" name="" type="text">
              <span></span>
              <input style="color: rgb(184, 190, 195);" inputend="false" value="请输入终点" autocomplete="off" name="" type="text">
            </li>
            <li class="sea_put">
              <input name="" type="button" id="searchBtn">
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="nav">
    <div class="sidemenu"> <span class="search_result_info" style="">共找到&nbsp;<span class="c_ff0">202</span>&nbsp;家酒店</span> <span style="display: none;" class="search_hot_title">搜索热门区域酒店</span> </div>
    <ul>
      <li> <a class="nav8" href="javascript:;">全屏</a> </li>
      <li class="select_control tools">
        <div class="select_control_name"> <a class="tool_ico tool_ico1" href="javascript:;">工具</a> </div>
        <ol class="select_list navzool" style="display:none">
          <li t="ceju"><a class="zool0 zool1" href="javascript:;">测距</a><span class="select_list_show"><a class="tool_ico tool_ico2 " href="javascript:;">测距</a></span></li>
          <li style="display:none"><a class="zool0 zool2" href="javascript:;">截图</a></li>
          <li style="display:none"><a class="zool0 zool3" href="javascript:;">分享</a></li>
          <li style="display:none"><a class=" bb_none zool0 zool4" href="javascript:;">打印</a></li>
        </ol>
      </li>
      <li style="display:none"> <a class="nav6" href="javascript:;">工具</a>
        <div class="navzool" style="display:none"> <a class="zool0 zool1" href="javascript:;">测距</a> <a class="zool0 zool2" style="display:none" href="javascript:;">截图</a> <a class="zool0 zool3" style="display:none" href="javascript:;">分享</a> <a class=" bb_none zool0 zool4" style="display:none" href="javascript:;">打印</a> </div>
      </li>
      <li> <a class="nav1" href="javascript:;">周边搜索</a> </li>
      <li id="zn_jdjb" class="select_control zn_jdjb" style="">
        <div class="select_control_name"> <a class="nav3" href="javascript:;">酒店级别</a> </div>
        <ol class="select_list navlevel" style="display:none">
          <li select_handle="cancel"><a rank="0" href="javascript:;">级别不限</a></li>
          <li><a class="level_ico" rank="2" href="javascript:;">二星/经济</a></li>
          <li><a class="level_ico" rank="3" href="javascript:;">三星/舒适</a></li>
          <li><a class="level_ico" rank="4" href="javascript:;">四星/高档</a></li>
          <li><a class="level_ico" rank="5" href="javascript:;">五星/豪华</a></li>
        </ol>
      </li>
      <li id="zn_jgfw" class="select_control zn_jgfw" style="">
        <div class="select_control_name"> <a class="nav2" href="javascript:;">价格范围</a> </div>
        <ol class="select_list navprice" style="display:none">
          <li select_handle="cancel"><a minprice="0" maxprice="0" class="zero_h" href="javascript:;">价格不限</a></li>
          <li><a minprice="0" maxprice="150" class="one_h" href="javascript:;">150元以下</a><span class="select_list_show"><a class="pirce_ico pirce_ico2 " href="javascript:;">150元以下</a></span></li>
          <li><a minprice="150" maxprice="300" class="two_h" href="javascript:;">150-300元</a><span class="select_list_show"><a class="pirce_ico pirce_ico3 " href="javascript:;">150元以下</a></span></li>
          <li><a minprice="300" maxprice="450" class="thr_h" href="javascript:;">300-450元</a><span class="select_list_show"><a class="pirce_ico pirce_ico4 " href="javascript:;">300-450元</a></span></li>
          <li><a minprice="450" maxprice="600" class="four_h" href="javascript:;">450-600元</a><span class="select_list_show"><a class="pirce_ico pirce_ico5 " href="javascript:;">450-600元</a></span></li>
          <li><a minprice="600" maxprice="0" class="five_h" href="javascript:;">600元以上</a><span class="select_list_show"><a class="pirce_ico pirce_ico6 " href="javascript:;">600元以上</a></span></li>
        </ol>
      </li>
      <li id="zn_ppsz" class="select_control zn_ppsz" style="">
        <div class="select_control_name"> <a class="nav4" href="javascript:;">行政区选择</a> </div>
        <ol class="select_list navhotel" style="display:none">
          <li select_handle="cancel"><a lsid="0" ls="" href="javascript:;">不限</a></li>
          
          <?php if($area_arr){
				  foreach($area_arr as $key=>$val){
				  ?>
                   <li><a class="hotelname_ico" lsid="<?php echo $key ?>" ls="<?php echo $val ?>" href="javascript:;"><?php echo $val ?></a></li>
               
                <?php }}?>
          
         
        </ol>
      </li>
      <li id="zn_ppsz" class="select_control zn_ppsz" style="">
        <div class="select_control_name"> <a class="nav4" href="javascript:;">位置选择</a> </div>
        <ol class="select_list navwz" style="display:none">
          <li select_handle="cancel"><a lsid="0" ls="" href="javascript:;">商业区域</a>
            <dl style="display: none;" t="qy" tid="2">
               <?php foreach ($cbd_list as $key=>$val){ ?>  
		                                     <a lsid="<?php echo ($val['x']/100000).','.$val['y']/100000?>" href="javascript:;"><?php echo $val['CBD_Name'] ?></a>
                                             <?php } ?>
            </dl>
          </li>
          <li><a class="hotelname_ico" lsid="1" ls="如家快捷" href="javascript:;">火车/机场</a>
            <dl style="display: none;" t="qy" tid="2">
             <?php foreach ($TrainLable as $key=>$val){ ?>  
		                                     <a lsid="<?php echo ($val['x']/100000).','.$val['y']/100000?>" href="javascript:;"><?php echo $val['name'][0] ?></a>
                                             <?php } ?>
            </dl>
          </li>
          <li><a class="hotelname_ico" lsid="2" ls="汉庭连锁" href="javascript:;">地铁周边</a>
            <dl style="display: none; width:100px;" id="ditie" >
           <?php foreach ($SubwayLable as $key=>$val){ ?>  
           <dd style="position:relative"><a  href="javascript:;"><?php echo $key ?></a>
                                            <span style="display:none">
                                            <?php foreach ($val as $zhan){ ?>  
                                            <a  href="javascript:;"><?php echo $zhan->title; ?></a>
                                            <?php } ?>
                                            </span>
                                            </dd>
                                             <?php } ?>
            </dl>
          </li>
          <li><a class="hotelname_ico" lsid="2" ls="锦江之星" href="javascript:;">大学周边</a>
            <dl style="display: none;" t="qy" tid="2">
              <?php foreach ($daxue as $key=>$val){ ?>  
		                                     <a lsid="<?php echo ($val['x']/100000).','.$val['y']/100000?>" href="javascript:;"><?php echo $val['name'][0] ?></a>
                                             <?php } ?>
            </dl>
          </li>
          <li><a class="hotelname_ico" lsid="6" ls="莫泰168" href="javascript:;">景点周边</a>
            <dl style="display: none;" t="qy" tid="2">
            <?php foreach ($jingdian as $key=>$val){ ?>  
		                                     <a lsid="<?php echo ($val['x']/100000).','.$val['y']/100000?>" href="javascript:;"><?php echo $val['name'][0] ?></a>
                                             <?php } ?>
            </dl>
          </li>
          <li><a class="hotelname_ico" lsid="4" ls="速8连锁" href="javascript:;">医院附近</a>
            <dl style="display: none;" t="qy" tid="2">
              <?php foreach ($yiyuan as $key=>$val){ ?>  
		                                     <a  lsid="<?php echo ($val['x']/100000).','.$val['y']/100000?>" href="javascript:;"><?php echo $val['name'][0] ?></a>
                                             <?php } ?>
            </dl>
          </li>
        </ol>
      </li>
    </ul>
    <div class="navright">中心位置：北京市东城区</div>
  </div>
  <div class="clearfloat"> </div>
  <div class="main" style="width: 1600px; height: 635px;">
    <div class="mainmap" style="width: 1275px; height: 635px;">
      <div style="width: 1275px; height: 635px; overflow: hidden; position: relative; z-index: 0; background-color: rgb(243, 241, 236); color: rgb(0, 0, 0); text-align: left;" class="map_con" id="e_map"> 
        
        <!-- 地图开始-->
        <div id="mapsearch"></div>
        <!--    地图结束--> 
        
        <script type="text/javascript">
// 百度地图API功能
var map = new BMap.Map("mapsearch");                        // 创建Map实例
map.centerAndZoom("上海");     // 初始化地图,设置中心点坐标和地图级别
map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
map.enableScrollWheelZoom();                            //启用滚轮放大缩小
map.addControl(new BMap.MapTypeControl());          //添加地图类型控件
map.setCurrentCity("上海");          // 设置地图显示的城市 此项是必须设置的




var gc = new BMap.Geocoder();    
map.addEventListener('moveend',getcenter);

function getcenter(e){
	var addComp;
	var center=map.getCenter();
	
	gc.getLocation(center, function(rs){
     addComp = rs.addressComponents;
	 $('.navright').html('当前中心点：'+addComp.district+addComp.street+addComp.streetNumber);
	});
	
}






function addCustomLayer(keyword) {
    if (customLayer) {
        map.removeTileLayer(customLayer);
    }
    customLayer=new BMap.CustomLayer({geotableId:'34599',ak:'85654a7702d8b2163b85f87e6585b4f5'});
    map.addTileLayer(customLayer);
    customLayer.addEventListener('hotspotclick',callback);
}
addCustomLayer();








 //绑定检索按钮事件
    $('#searchBtn').bind('click', function(){
        keyword = $('#searchword').val();
        searchAction(keyword);
    });
	
	
	

    /**
     * 进行检索操作
     * @param 关键词
     * @param 当前页码
     */
    function searchAction(keyword, page,sortby) {
		
	//	var local = new BMap.LocalSearch(map, {
//  renderOptions:{map: map}
//});
//local.search(keyword);
		
		
        page = page || 0;
       
       
        var url = "http://api.map.baidu.com/geosearch/v2/local?callback=?";
        $.getJSON(url, {
            'q'          : keyword, //检索关键字
            'page_index' : page,  //页码
            'filter'     : filter.join('|'),  //过滤条件
            'region'     : '289',  //北京的城市id
            'scope'      : '2',  //显示详细信息
			'sortby'     : sortby,
            'geotable_id': 34599,
            'ak'         : '85654a7702d8b2163b85f87e6585b4f5'  //用户ak
        },function(e) {
            
            renderMap(e, page + 1);
        });
    }
	
	 function searchnearby(keyword, point,radius) {
		
	//	var local = new BMap.LocalSearch(map, {
//  renderOptions:{map: map}
//});
//local.search(keyword);
		
		
        page = page || 0;
       
       
        var url = "http://api.map.baidu.com/geosearch/v2/nearby?callback=?";
        $.getJSON(url, {
            'q'          : keyword, //检索关键字
            'page_index' : page,  //页码
            'location'     : point.lng+','+point.lat,  //过滤条件
            'radius'     : radius,  //北京的城市id
            'scope'      : '2',  //显示详细信息
            'geotable_id': 34599,
            'ak'         : '85654a7702d8b2163b85f87e6585b4f5'  //用户ak
        },function(e) {
            
            renderMap(e, page + 1);
        });
    }


var poi;
	 function searchnearbydb( point,radius) {
		page = page || 0;
		var tempPoint = point.split(',')
		var gpsPoint = new BMap.Point(tempPoint[0],tempPoint[1]);	
		
		
		BMap.Convertor.translate(gpsPoint,0,function(point){
			
			 poi=new BMap.Point(point.lng,point.lat);	
			
			});
		
		
        
       
       
        var url = "http://api.map.baidu.com/geosearch/v2/nearby?callback=?";
        $.getJSON(url, {
            'q'          : keyword, //检索关键字
            'page_index' : page,  //页码
            'location'     : poi.lng+','+poi.lat,  //过滤条件
            'radius'     : radius,  //北京的城市id
            'scope'      : '2',  //显示详细信息
            'geotable_id': 34599,
            'ak'         : '85654a7702d8b2163b85f87e6585b4f5'  //用户ak
        },function(e) {
            
            renderMap(e, page + 1);
        });
    }

function callback(e)//单击热点图层
{
  var customPoi = e.customPoi,
		  str = [];
		str.push("address = " + customPoi.address);
		str.push("phoneNumber = " + customPoi.phoneNumber);
		alert(customPoi.address);
        var content="<iframe src=\"/maphotelinfo/\" width=\"570\" height=\"237\" scrolling=\"Auto\" frameborder=\"0\"></iframe>";
        var searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
            title: customPoi.title, //标题
            width: 576, //宽度
            height: 250, //高度
            panel : "panel", //检索结果面板
            enableAutoPan : true, //自动平移
            enableSendToPhone: true, //是否显示发送到手机按钮
            searchTypes :[
                BMAPLIB_TAB_SEARCH,   //周边检索
                BMAPLIB_TAB_TO_HERE,  //到这里去
                BMAPLIB_TAB_FROM_HERE //从这里出发
            ]
        });


        var point = new BMap.Point(customPoi.point.lng, customPoi.point.lat);
        searchInfoWindow.open(point);
}
    /**
     * 渲染地图模式
     * @param result
     * @param page
     */
    function renderMap(res, page) {
        var content = res.contents;
        $('#mapList').html('');
        map.clearOverlays();
		map.removeTileLayer(customLayer);
        points.length = 0;

        if (content.length == 0) {
            $('#mapList').append($('<p style="border-top:1px solid #DDDDDD;padding-top:10px;text-align:center;text-align:center;font-size:18px;" class="text-warning">抱歉，没有找到您想要的酒店信息，请重新查询</p>'));
            return;
        }
		
        $.each(content, function(i, item){
            var point = new BMap.Point(item.location[0], item.location[1]),
                marker = new BMap.Marker(point);
            points.push(point);
			
			var str='<dl class="">';
                 str+='<dt><span class="color2">'+i+'</span></dt>';
                  str+='<dd>';
                   str+='<table border="0" cellpadding="0" cellspacing="0" width="259">'
                    str+='<tbody>';
                   str+=' <tr>';
                   str+='<td width="185"><div class="hotelname"><a>'+item.title+'</a></div>';
                    str+='<a class="details" href="http://www.9tour.cn/booking/info_12905/" target="_blank">详情&gt;&gt;</a></td>';
                       str+='     <td width=""><a href="#" class="sidemobile" style="display:none"></a><a href="#" class="sidemsg"></a><span class="sidejuli"></span></td>';
                        str+='  </tr>  <tr>';
                         str+='<td>星级：<img src="map_files/bank.gif" class="star star2" height="1" width="1"></td>';
                        str+='    <td rowspan="3"><img src="'+item.images+'" class="hotelpic" height="41" width="56"></td>';
                          
                         str+=' <tr>';
                          str+='  <td>价格：<span style="color: rgb(229, 111, 15);" class="c_f60">￥'+item.price+'</span>起</td>';
                          str+='</tr> <tr>';
                          str+='  <td class="address" colspan="2" style="line-height: 16px;_padding-top:3px">'+item.address+'</td>';
                          str+='</tr>';
                       str+=' </tbody> </table>    </dd>       </dl>';
                  
			
			
			
         
            $('#mapList').append(str);;
            marker.addEventListener('click', showInfo);
            function showInfo() {
                var content = "<img src='" + item.picture+ "' style='width:111px;height:83px;float:left;margin-right:5px;'/>" +
                              "<p>名称：" + item.title + "</p>" +
                              "<p>地址：" + item.address + "</p>" +
                              "<p>价格：" + item.price + "</p>";
                //创建检索信息窗口对象
                var searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
                    title  : item.title,       //标题
                    width  : 290,             //宽度
                    panel  : "panel",         //检索结果面板
                    enableAutoPan : true,     //自动平移
                    searchTypes   :[
                        BMAPLIB_TAB_SEARCH,   //周边检索
                        BMAPLIB_TAB_TO_HERE,  //到这里去
                        BMAPLIB_TAB_FROM_HERE //从这里出发
                    ]
                });
                searchInfoWindow.open(marker);
            };
            map.addOverlay(marker);
        });


        /**
         * 分页
         */
        var pagecount = Math.ceil(res.total / 10);
        if (pagecount > 76) {
            pagecount = 76; //最大页数76页
        }
        function PageClick (pageclickednumber) {
            pageclickednumber = parseInt(pageclickednumber);
            $("#pager").pager({ pagenumber: pageclickednumber, pagecount: pagecount, showcount: 3, buttonClickCallback: PageClick });
            searchAction(keyword, pageclickednumber -1);
        }
        //$("#mapPager").pager({ pagenumber: page, pagecount: pagecount, showcount:3, buttonClickCallback: PageClick });

        map.setViewport(points);
    };
</script> 
      </div>
      <div style="height: 323px;" class="side_left">&nbsp;</div>
      <div class="shouqi">
        <div class=""><a class=""></a></div>
      </div>
    </div>
    <div class="conside" style="width: 325px; height: 335px; visibility: visible;">
      <div class="tsbar_1" style="width: 325px; height: 335px; z-index: 1; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
        <div style="height: 335px;" class="scrollbar">
          <div style="height: 335px;" class="track">
            <div style="top: 0px; height: 100.29px;" class="thumb">
              <div style="height:4px;" class="scroll_top"></div>
              <div style="height:4px;" class="scroll_bottom"></div>
            </div>
          </div>
        </div>
        <div class="viewport" style="width: 325px; height: 335px;">
          <div style="top: 0px;" class="overview">
            <div style="" class="sidecon">
              <div class="sidesearch" style="top: 10px; left: -325px; display: none;"> <a class="side_s_1" t="qy" tid="2" href="http://www.9tour.cn/findhotel/%E5%8C%BA%E5%9F%9F.html"></a> <a class="side_s_2" t="sq" tid="1" href="#"></a> <a class="side_s_3" t="jt" tid="3" href="#"></a> <a class="side_s_4" t="dtzb" tid="7" href="#"></a> <a class="side_s_5" t="dxzb" tid="4" href="#"></a> <a class="side_s_6" t="jdzb" tid="5" href="#"></a> <a class="side_s_7" t="yyzb" tid="6" href="#"></a> </div>
              <div class="sidemess" style="top: 2px; left: 0px; display: none;"> <a class="sidereturn" href="#"><img src="map_files/bank.gif" height="1" width="1">返回</a>
                
                <dl style="display: none;" t="sq" tid="1">
                </dl>
                
              </div>
              <div style="display: block;" class="zhuna_result">
                <div class="sidenav">
                  <div class="nav_b"></div>
                  <a class="cur" t='tj'>推荐<img class="sidehot" src="map_files/bank.gif" height="1" width="1"></a><a t='jg' class="price">价格<img src="map_files/bank.gif" height="1" width="1"></a><a t='pj'>评价<img src="map_files/bank.gif" class="sidenav_ico1" height="1" width="1"></a><a t="jl">距离<img class="sidenav_ico" src="map_files/bank.gif" height="1" width="1"></a> </div>
                <div class="sidelist" id="mapList" style="height:100%"> </div>
                
                 <div id="Pager" class="pagination text-center"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer"></div>
</div>
</body>
</html>