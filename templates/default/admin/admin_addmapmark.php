<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=85654a7702d8b2163b85f87e6585b4f5 "></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>

<title>携行网后台管理系统</title>
<style>
#content{
    width:750px;
}
</style>
</head>
<body style="width:100%; height:100%">
<div style="width:100%;height:600px;border:1px solid gray" id="allmap"></div>
</body>
</html>

<script type="text/javascript">
document.domain ='xexing.com';

var map = new BMap.Map("allmap");
var lng;
var lat;
var gpsxy=new Array();
map.centerAndZoom("<?php echo $cityName; ?>",12);
var center = map.getCenter();
var point = new BMap.Point(center.lng, center.lat);
// 创建地址解析器实例
var myGeo = new BMap.Geocoder();
// 将地址解析结果显示在地图上,并调整地图视野
myGeo.getPoint("<?php echo $keywords; ?>", function(point){
  if (point) {
    map.centerAndZoom(point, 20);
	var marker = new BMap.Marker(point);
    map.addOverlay(marker);
	marker.enableDragging();
  }
}, "<?php echo $cityName; ?>");

map.enableScrollWheelZoom(true);
map.addEventListener('click', showInfo);
function showInfo(e){
	
	lng=e.point.lng;
	lat=e.point.lat;
	window.parent.getpoint(e.point);
	BMap.Convertor.translate(e.point,0,translateCallback);
	
}
function translateCallback(point2){
	
	lng2=2*lng-point2.lng;
	lat2=2*lat-point2.lat;
	
	gpsxy=[lng2,lat2];
	
	alert('已标注');
	window.parent.getpoint2(gpsxy);
	
	
}
</script>