<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $keywords_array['k_title'] ?></title>
<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />
<meta name="description" content="<?php echo $keywords_array['k_description'] ?>" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />
<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/jquery.min.js"></script><!--点击预订时候用到-->
<link href="<?php echo ZHUNA_ORDER_API;?>room.utf8.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>public/js/room.utf8.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/dialog/dialog.js" type="text/javascript"></script>
</head>
<body>
<?php $this->load->view('inc/header');?>
<div class="middle">
       <?php $this->load->view('inc/nav');?>
		<div class="main">
		           <div class="xdh">
		                <span class="bg"></span><span class="sy"><a title="携行网首页" href="<?php echo base_url();?>">首页</a></span>
		                <span class="wzdt"></span><span class="sy"><a title="携行网所有城市酒店" href="<?php echo site_url("/allcity") ?>">城市酒店</a></span>
		                <span class="wzdt"></span><span class="sy"><a title="<?php echo $cityname ?>酒店预订" href="<?php echo site_url("/onecity/$cityid") ?>"><?php echo $cityname ?>酒店</a></span>
		                <span class="wzdt"></span><span class="sy">
		                <?php  
		                	$condition = $cityname;
		                	if (!empty($searchArray['key'])) {
		                		$condition .= $searchArray['key']."附近" ;
		                	}	
		                	if (!empty($searchArray['hn'])) {
		                		$searchArray['hn'] = str_replace('酒店','',$searchArray['hn']);
		                	}
		                	$condition .= $searchArray['hn']."酒店" ;
		                	echo $condition = $condition.'预订';
		                ?>
		                </span>
		           </div>
		           <div class="main_bottom">
		                <div class="jdcity">
                            <div style="float:right;" id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
                                <span class="bds_more">分享到：</span>
                                <a class="bds_qzone"></a>
                                <a class="bds_tsina"></a>
                                <a class="bds_tqq"></a>
                                <a class="bds_renren"></a>
                                <a class="shareCount"></a>
                            </div>
                            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=234336" ></script>
                            <script type="text/javascript" id="bdshell_js"></script>
                            <script type="text/javascript">document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();</script>
                            <!-- Baidu Button END -->  
                          </span>
                          <span><h1><?php echo $cityname?>酒店<font class="f_b_f00">预订</font></h1></span>
		                  <span class="jdsz"><font class="f_b1_f00"><?php echo $allnums ?></font>家酒店满足筛选条件 <!--共有<font class="f_b1_f00">123654 </font>家酒店&nbsp;&nbsp;<font class="f_b1_f00">5324 </font>条入住客人点评--></span>
		                  
		                </div>    
		                <!--载入搜索内容-->
                        <?php $this->load->view('inc/search');?>
                        <div class="search_jd" id="list_filter">
		                   <div class="s_j_top">
		                   </div>
		                   <div class="s_j_plate">
		                       <div class="sj_p_top"></div>
		                       <div class="sj_p_middle">
                                <dl>
		                               <dt>
		                               酒店位置
		                               </dt>
		                               <dd id="list_filter_wz" >
		                                  <span <?php if($type == '' ){?> class="s_j_bx" <?php } ?>><a href="<?php echo site_url("{$list_url['area']}") ?>">不限</a></span>
		                                  <ul> 
                                           <li><span <?php if ($type == 100000) { echo "style='background-color:#F08200'"; } ?> ><a title="以行政区查找酒店"  href="javascript:void(0)" onclick="right_ajax_get_lable(100000,1,this)">行政区</a></span></li>
                                           <li><span <?php if ($type == 135 || $type == 166) { echo "style='background-color:#F08200'"; } ?> ><a title="<?php echo $cityname ?>机场附近酒店预订" style="float:left" href="javascript:void(0)" onclick="right_ajax_get_lable(135,1,this)">机场</a><a title="火车站附近酒店预订" style="float:left" href="javascript:void(0)" onclick="right_ajax_get_lable(166,1,this)">火车站</a></span></li>
                                         
                                           <li><span <?php if ($type == 83) { echo "style='background-color:#F08200'"; } ?> ><a title="<?php echo $cityname ?>学校周边酒店预订" href="javascript:void(0)" onclick="right_ajax_get_lable(83,0,this)">学校周边</a></span></li>
                                           <li><span <?php if ($type == 65) { echo "style='background-color:#F08200'"; } ?> ><a title="<?php echo $cityname ?>景点周边酒店预订" href="javascript:void(0)" onclick="right_ajax_get_lable(65,1,this)">景点周边</a></span></li>
                                           <li><span <?php if ($type == 170) { echo "style='background-color:#F08200'"; } ?> ><a title="<?php echo $cityname ?>地铁周边酒店预订" href="javascript:void(0)" onclick="right_ajax_get_lable(170,1,this)">地铁周边</a></span></li>   
                                             <li><span <?php if ($type == 119) { echo "style='background-color:#F08200'"; } ?> ><a title="<?php echo $cityname ?>医院附近酒店预订" href="javascript:void(0)" onclick="right_ajax_get_lable(119,1,this)">医院附近</a></span></li>
                                            
		                                  </ul>
		                               </dd>         
		                           </dl>
		                           <dl>
		                               <dt>
		                               著名商圈
		                               </dt>
		                               <dd id="list_filter" >
                                          <em class="more" ><a href="javascript:void(0)" id="cbd">更多</a></em>
		                                  <span <?php if($cbd_id == ''){?> class="s_j_bx" <?php } ?>><a href="<?php echo site_url("{$list_url['cbd']}") ?>">不限</a></span>
		                                  <ul>    
                                             <?php foreach ($cbd_list as $key=>$val){ ?>  
		                                     <li><span <?php if ($cbd_id == $val['cbd_id']) { echo "class='s_j_bx'"; } ?> ><a title="<?php echo $cityname ?><?php echo $val['CBD_Name'] ?>附近酒店预订" href="<?php echo site_url("{$list_url['cbd']}-cbd_id-{$val['cbd_id']}") ?>"><?php echo $val['CBD_Name'] ?></a></span></li>
                                             <?php } ?>
		                                  </ul>
		                               </dd>         
		                           </dl>
		                           <dl>
		                               <dt>
		                               酒店级别
		                               </dt>
		                               <dd>
		                                  <span <?php if($rank == ''){?> class="s_j_bx" <?php } ?>><a href="<?php echo site_url("{$list_url['rank']}") ?>">不限</a></span>
                                          <ul>
                                            <li><span 
                                            <?php if ($rank ==  2){ ?>
                                            class = "s_j_bx"
                                            <?php } ?> ><a title="<?php echo $cityname ?>二星级/经济型酒店预订" href="<?php echo site_url("{$list_url['rank']}-rank-2") ?>">二星级/经济型</a></span></li>
                                            <li><span 
                                            <?php if ($rank ==  3){ ?>
                                            class = "s_j_bx"
                                            <?php } ?> ><a title="<?php echo $cityname ?>三星级/舒适型酒店预订" href="<?php echo site_url("{$list_url['rank']}-rank-3") ?>">三星级/舒适型</a></span></li>
                                            <li><span 
                                            <?php if ($rank ==  4){ ?>
                                            class = "s_j_bx"
                                            <?php } ?> ><a title="<?php echo $cityname ?>四星级/高档型酒店预订" href="<?php echo site_url("{$list_url['rank']}-rank-4") ?>">四星级/高档型</a></span></li>
                                            <li><span
                                            <?php if ($rank ==  5){ ?>
                                            class = "s_j_bx"
                                            <?php } ?> ><a title="<?php echo $cityname ?>五星级/豪华型酒店预订" href="<?php echo site_url("{$list_url['rank']}-rank-5") ?>">五星级/豪华型</a></span></li>
		                                  </ul>
		                               </dd>
		                           </dl>
		                           <dl>
		                               <dt>
		                               酒店价格
		                               </dt>
		                               <dd>
		                                  <span <?php if($maxprice == ''){?> class="s_j_bx" <?php } ?>><a href="<?php echo site_url("{$list_url['hotelprice']}") ?>">不限</a></span>
		                                  <ul>
                                             <?php
                                             	$i = 0; 
                                             	foreach ($price_array as $key=>$val){ 
                                             		$i++;
                                             ?>   
		                                     <li><span <?php $price_array = explode('-', $key); if($minprice==$price_array[0] && $maxprice==$price_array[1]){echo "class='s_j_bx'";} ?>><a title="<?php echo $cityname ?><?php echo $val ?>酒店预订" href="<?php echo site_url("{$list_url['hotelprice']}-priceid-{$i}") ?>"><?php echo $val ?></a></span></li>
		                                     <?php } ?>
		                                  </ul>
		                               </dd>
		                           </dl>
		                           <dl>
		                               <dt>
		                               品牌连锁
		                               </dt>
		                               <dd>
		                                  <em class="more"><a href="javascript:void(0)" id="chain">更多</a></em>
		                                  <span <?php if($chain_id == ''){?> class="s_j_bx" <?php } ?>><a href="<?php echo site_url("{$list_url['chain']}") ?>">不限</a></span>
		                                  <ul>
                                             <?php foreach ($chain_list as $key=>$val){ ?>   
		                                     <li><span <?php if ($chain_id ==  $val['id']){echo "class='s_j_bx'"; } ?>><a title="<?php echo $cityname ?><?php echo $val['lsname']; ?>预订" href="<?php echo  site_url("{$list_url['chain']}-chain_id-{$val['id']}") ?>"><?php echo $val['lsname']; ?></a></span></li>
		                                     <?php } ?>
		                                  </ul>
		                               </dd>
		                           </dl>
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
					
				</div>
				<div class="xz_middle" id="right_xz_middle_loading2">
					<p style="text-align:center;"><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>
				</div>
				<div class="xz_bottom"></div>
			</div>
		                       <div class="sj_p_bottom"></div>
		                   </div>
		                </div>
		                <div class="jdlist">
		                    <div class="jdlist_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
		                        <div class="jdplate_dh">
                                    <span <?php if($px == 1){echo "class='current'";} ?>><a href="javascript:void(0)" onclick = "change_page('<?php echo "{$list_url['px']}-px-1" ?>')">默认</a></span>
		                            <span <?php if($px == 3){echo "class='current'";} ?>><a href="javascript:void(0)" onclick = "change_page('<?php echo "{$list_url['px']}-px-3" ?>')">人气</a></span>
		                            <span <?php if($px == 2){echo "class='current'";} ?>><a href="javascript:void(0)" onclick = "change_page('<?php echo "{$list_url['px']}-px-2" ?>')">价格</a></span>
		                            <span <?php if($px == 4){echo "class='current'";} ?>><a href="javascript:void(0)" onclick = "change_page('<?php echo "{$list_url['px']}-px-4" ?>')">好评</a></span>
		                        </div>
                                
		                        <div class="hotel_list" id = "hotel_list">
                                    <?php 
                                    if(count($list) > 0 ) {
                                        foreach ($list as $val){
                                              
                                    ?>
		                            <div class="hot_li_plate">
			                            	<div class="hot_li_p_top">
    		                                    <span class="right"><dfn>¥</dfn><em><?php echo $val['min_jiage']; ?><font class="yuan_f00">元</font></em>起</span>
    		                                    <span class="kuang"></span>
    		                                    <span><strong><a href="<?php echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName']; ?>预订" target="_blank"><?php echo $val['HotelName']; ?></a></strong></span>
    		                                    <span><?php if ($val['xingji']>1) { ?><img width="86" height="16" src="<?php echo base_url();?>public/www/blue/images/xj<?php echo $val['xingji']; ?>.gif"><?php } ?></span>
    		                                </div>
    		                                <div class="hot_li_p_bottom">
    		                                    <div class="hot_li_top">
    		                                        <dl>
    		                                            <dt>
    		                                            <span><a href="<?php echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName']; ?>预订" target="_blank"><img src="<?php echo $val['Picture']; ?>" width="134" height="100" alt="<?php echo $val['HotelName']; ?>预订" /></a></span><span class="yy"></span>
    		                                            </dt>
    		                                            <dd>
    		                                               <ul>
    		                                                  <li>
    		                                                  		酒店位置：
    		                                                  		<?php if ($val['place_id'] != '') { ?>
    		                                                  		<font style="color:#6f7c99;"><a href="<?php echo site_url("{$list_url['cbd']}-cbd_id-{$val['place_id']}") ?>"><?php echo $val['place']; ?></a></font>
    		                                                  		<?php } else { ?>
    		                                                  			<?php echo $val['place']; ?>	
    		                                                  		<?php } ?>
    		                                                  		<a id="Map_Show<?php echo $val['ID'];?>" href="<?php echo site_url("/map/index?lng={$val['baidu_lng']}&lat={$val['baidu_lat']}");?>">
    		                                                  			<img class="le_20" src="<?php echo base_url();?>public/www/blue/images/mag_img.gif" width="16" height="16" />查看地图
    		                                                  		</a>
    		                                                  </li>
    		                                                  <li>提供服务：<font style="color:#6f7c99;"><?php if (!empty($val['service_pic'])) { foreach ($val['service_pic'] as $key1=>$val1) { ?><img title="<?php echo $val1[1] ?>" src="<?php echo base_url();?>public/images/<?php echo $val1[0] ?>" width="16" height="16" /><?php } } else { ?>服务信息未知<?php } ?></font>
    		                                                  <li>酒店地址：<font style="color:#6f7c99;"><?php echo $val['Address']; ?></font></li>
    		                                                  <li><font class="f_999"><?php if (!empty($val['juli'])) { ?><font class="f_b1_f00"><?php echo $val['juli']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</font><?php } ?>最近有点评<font class="f_b1_f00"><?php echo $val['df_haoping'][1][3]; ?>条</font></font></li>
    		                                               </ul>
    		                                            </dd>
    		                                            <dd class="pingfen"><span class="pf01"><font style="font-size:16px;"><?php echo $val['df_haoping'][0]; ?></font>分</span><span class="f_hui">5分</span>
    		                                            </dd>
    		                                        </dl>
    		                                    </div>
    		                                </div>
    		                                <div class="hot_li_bottom">
    		                                    <div id="h<?php echo $val['ID']; ?>">
                                                    <p style="text-align:center;"><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>
                                                </div>
    		                                </div>
    		                        </div>
                                    <?php } ?>
                                    <?php } else { echo '<div align="center" style="color:red;"><img src="'.base_url().'public/images/nohotel.jpg" /></div>'; }?>
		                            <div class="fy" id="page">
		                              <?php echo $page ?>          
		                            </div>
		                        </div>
		                    </div>
		                    <div class="jdlist_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
			                    <?php $this->load->view('modules/'.$layout[0][1]);?>
			                    <?php $this->load->view('modules/'.$layout[1][1]);?>
			                    <?php $this->load->view('modules/'.$layout[2][1]);?>
			                    <?php $this->load->view('modules/'.$layout[3][1]);?>   
		                    </div>
		                </div>
		           </div>
		  </div>       
</div>
<div class="inbz"><img src="<?php echo base_url();?>public/www/default/images/inbz.jpg" width="950" height="57" /></div>

<form action="<?php echo base_url(); ?>ebook/index" method="get" target="_blank" name="doBook" id="doBook" >
    <input name="hid" type="hidden"/>
    <input name="rid" type="hidden" />
    <input name="pid" type="hidden" />
    <input name="tm1" type="hidden" value="<?php echo $searchArray['tm1'] ?>" />
    <input name="tm2" type="hidden" value="<?php echo $searchArray['tm2'] ?>" />
    <input name="loginstate" type="hidden" value="<?php echo $loginsate; ?>" />
</form>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script>
$(function(){
	//更多默认展开和点击展开
	var cbd_id = "<?php echo $cbd_id ?>";
	if (cbd_id > 0) {
		$("#cbd").parent().parent().attr("style","height:26px");	
		$("#cbd").attr("class",'more');
		$("#cbd").parent().attr("class",'more');
	}
	var chain_id = "<?php echo $chain_id ?>";
	if (chain_id >0 ) {
		$("#chain").parent().parent().attr("style","height:26px");	
		$("#chain").attr("class",'more');
		$("#chain").parent().attr("class",'more');
	}
	$("#list_filter dl dd a em[class!='more'][class!='more1']").click(function(){$(this).loading({div:"#mainContent"})});
	$("#list_filter dl dd em a").click(function(){
		var s=($(this).attr("class")=="more1")?"more":"more1";
		if(s=="more1"){
		$(this).parent().parent().attr("style","height:auto");}else{$(this).parent().parent().css("height","26px");}
		$(this).attr("class",s);
		$(this).parent().attr("class",s);
	});
    show_map();
});
</script>
<script type="text/javascript">

var i = '';var subwanglingsum = 0;
function right_ajax_get_lable(type,m,obj){
	var cityid = '<?php echo $cityid; ?>';
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
		                	textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cityid+"-keyid-"+msg[i][j]['mapid']+"-type-"+type+"<?php echo $this->config->item('url_suffix') ?>' target='_blank'>"+msg[i][j]['title']+"</a></li>";
		                	
			                $("#div_"+n).append(textinfo); 
	                	});	
			        } 
					else if(type==100000){
							$("#right_div_title").hide();
			        	textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cityid+"-areaid-"+msg[i]['id']+"-type-"+type+"<?php echo $this->config->item('url_suffix') ?>' target='_blank'>"+msg[i]['name']+"</a></li>";
		                
		                $("#xz1_middle").append(textinfo); 
					}
					
					else {
			        	$("#right_div_title").hide();
			        	textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cityid+"-keyid-"+msg[i]['id']+"-type-"+type+"<?php echo $this->config->item('url_suffix') ?>' target='_blank'>"+msg[i]['name']+"</a></li>";
		                
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

function change_page (ajax_url) {
	$.ajax({
		type: "GET",
		url: '<?php echo base_url() ?>'+ajax_url,
		beforeSend : function(data)
		{
			$('html').animate({scrollTop:$("#list_filter").offset().top}, 'slow');
            $('body').animate({scrollTop:$("#list_filter").offset().top}, 'slow');
            $("#hotel_list").html('<p style="text-align:center;" ><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>');
		},
		success: function(data)
		{
			var data = $.parseJSON(data); 
			
            var textinfo = '';
            $.each(data['list'],function(i){
                textinfo+="<div class='hot_li_plate'>";   
                 	textinfo+="<div class='hot_li_p_top'>";   
                         textinfo+="<span class='right'><dfn>¥</dfn><em>"+data['list'][i]['min_jiage']+"<font class='yuan_f00'>元</font></em>起</span>";   
                         textinfo+="<span class='kuang'></span>";   
                         textinfo+="<span><strong><a href='<?php echo base_url() ?>hotelinfo/"+data['list'][i]['ID']+"<?php echo $this->config->item('url_suffix') ?>' title='"+data['list'][i]['HotelName']+"' target='_blank'>"+data['list'][i]['HotelName']+"</a></strong></span>";   
                         if (data['list'][i]['xingji'] > 1) {
                            textinfo+="<span><img width='86' height='16' src='<?php echo base_url();?>public/www/blue/images/xj"+data['list'][i]['xingji']+".gif'></span>";    
                         }
                     textinfo+="</div>";   
                     textinfo+="<div class='hot_li_p_bottom'>";   
                         textinfo+="<div class='hot_li_top'>";   
                             textinfo+="<dl>";   
                                 textinfo+="<dt>";   
                                 textinfo+="<span><a href='<?php echo base_url() ?>hotelinfo/"+data['list'][i]['ID']+"<?php echo $this->config->item('url_suffix') ?>' title='"+data['list'][i]['HotelName']+"' target='_blank'><img src='"+data['list'][i]['Picture']+"' width='134' height='100' /></a></span><span class='yy'></span>";   
                                 textinfo+="</dt>";   
                                 textinfo+="<dd>";   
                                    textinfo+="<ul>";   
                                       textinfo+="<li>";   
                                       		textinfo+="酒店位置："; 
                                            if (data['list'][i]['place_id']) {
                                                textinfo+="<font style='color:#6f7c99;'><a href='<?php echo rtrim(base_url(),'/').$list_url['cbd'] ?>-cbd_id-"+data['list'][i]['place_id']+"<?php echo $this->config->item('url_suffix') ?>'>"+data['list'][i]['place']+"</a></font>";    
                                            } else {
                                                textinfo+="未知";       
                                            }  
                                            textinfo+="<a id='Map_Show"+data['list'][i]['ID']+"' href='<?php echo base_url() ?>map/index?lng="+data['list'][i]['baidu_lng']+"&lat="+data['list'][i]['lat']+"'>";   
                                       			textinfo+="<img class='le_20' src='<?php echo base_url();?>public/www/blue/images/mag_img.gif' width='16' height='16' />查看地图";   
                                       		textinfo+="</a>";   
                                       textinfo+="</li>";   
                                       textinfo+="<li>提供服务：<font style='color:#6f7c99;'>";  
                                       
                                       if (data['list'][i]['service_pic']) {
                                            $.each(data['list'][i]['service_pic'],function(j){
                                                textinfo+="<img title='"+data['list'][i]['service_pic'][j][1]+"' src='<?php echo base_url();?>public/images/"+data['list'][i]['service_pic'][j][0]+"' width='16' height='16' /></font>";     
                                            });
                                       } else {
                                            textinfo+="服务信息未知</font>";    
                                       }
                                       textinfo+="</li>";   
                                       textinfo+="<li>酒店地址：<font style='color:#6f7c99;'>"+data['list'][i]['Address']+"</font></li>";   
                                       textinfo+="<li><font class='f_999'>"; 
                                       if (data['list'][i]['juli']) {
                                            textinfo+="<font class='f_b1_f00'>"+data['list'][i]['juli']+"&nbsp;&nbsp;&nbsp;&nbsp;</font>";   
                                       }
                                       textinfo+="最近有点评<font class='f_b1_f00'>"+data['list'][i]['df_haoping'][1][3]+"条</font></font></li>";   
                                    textinfo+="</ul>";   
                                 textinfo+="</dd>";   
                                 textinfo+="<dd class='pingfen'><span class='pf01'><font style='font-size:16px;'>"+data['list'][i]['df_haoping'][0]+"</font>分</span><span class='f_hui'>5分</span>";   
                                 textinfo+="</dd>";   
                             textinfo+="</dl>";   
                         textinfo+="</div>";   
                     textinfo+="</div>";   
                     textinfo+="<div class='hot_li_bottom'>";   
                         textinfo+="<div id='h"+data['list'][i]['ID']+"'>";   
                             textinfo+="<p style='text-align:center;'><img src='<?php echo base_url();?>public/www/default/images/loadprice.gif' /></p>";   
                         textinfo+="</div>";   
                     textinfo+="</div>";   
                 textinfo+="</div>";     	
            });
            
            $("#hotel_list").html('');
			$("#hotel_list").append(textinfo);
            
			$("#hotel_list").append('<div class="fy" id="page">'+data['page']+'</div>');
            loadPrice(data['hoteIdStr'],data['tm1'],data['tm2']);
            
            ids = data['hoteIdStr'];
            show_map ();
        },
		timeout:20000,
		error: function () 
		{	
			alert("请求超时请重试!");
		}
	});	
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

ids = "<?php echo $hoteIdStr; ?>";
function show_map()
{
    var id_array = new Array();
    id_array = ids.split(',');
    for(i=0;i<id_array.length;i++){
        $("#Map_Show"+id_array[i]).fancybox({
            'width'             : 580,
            'height'            : 480,
            'autoScale'         : false,
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'type'              : 'iframe',
            'overlayOpacity' : '0.8',
            'overlayColor' : '#000'        
        });
    }	
}


loadPrice('<?php echo $hoteIdStr; ?>','<?php echo $searchArray['tm1'] ?>','<?php echo $searchArray['tm2'] ?>');
</script>
<?php $this->load->view('inc/footer');
$ci = & get_instance();
$ci->load->library('tool');
$ci->tool->zhuna_rewrite(CFG_REWRITE);?>
</body>
</html>
