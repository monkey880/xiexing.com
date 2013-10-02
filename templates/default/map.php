<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>

</head>

<body>

<div id="DP_Map_Show" style="width:550px;height:450px;border:0px #CCC solid;margin-left:5px;"></div>                           

<script type="text/javascript">

//地图开始

var map = new BMap.Map("DP_Map_Show");

var point=new BMap.Point(<?php echo $lng; ?>,<?php echo $lat; ?>);

map.setMinZoom(9);

map.centerAndZoom(point, 17);

var marker = new BMap.Marker(point);  // 创建标注

map.addOverlay(marker);              // 将标注添加到地图中

map.addControl(new BMap.MapTypeControl({anchor: BMAP_ANCHOR_TOP_RIGHT}));    //左上角，默认地图控件

map.addControl(new BMap.NavigationControl());

</script>

</body>

</html>

