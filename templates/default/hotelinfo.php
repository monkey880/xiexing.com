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
<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/dialog/dialog.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url();?>public/js/room.utf8.js" type="text/javascript"></script>
<link href="<?php echo $order_api ?>room.utf8.css" rel="stylesheet" type="text/css" />
<!--百度地图js和css-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<title><?php echo $keywords_array['k_title'] ?></title>
<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />
<meta name="description" content="<?php echo $keywords_array['k_description'] ?>" />
</head>
<body>
<?php $this->load->view('inc/header');?>
<div class="middle">
       <?php $this->load->view('inc/nav');?>
<div class="main">
           <div class="xdh">
                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>
                <span class="wzdt"></span><span class="sy"><a href="<?php  echo site_url("/allcity") ?>">城市酒店</a></span>
                <span class="wzdt"></span><span class="sy"><a href="<?php echo site_url("/onecity/{$hotelInfo['ecityid']}") ?>"><?php echo $hotelInfo['CityName'] ?>酒店</a></span>
                <span class="wzdt"></span><span class="sy"><?php echo $hotelInfo['HotelName']; ?></span>
           </div>
           <div class="hot_info_xx">
                    <div class="hot_info_top">
                        <span class="right"><dfn>¥</dfn><em><?php echo $hotelInfo['Min_price']; ?></em>起</span>
                        <span><h1><?php echo $hotelInfo['HotelName']; ?></h1></span>
                        <span class="xiimg"><?php if ($hotelInfo['star']>1) { ?><img width="86" height="16" src="<?php echo base_url();?>public/www/blue/images/xj<?php echo $hotelInfo['star']; ?>.gif"><?php } ?></span>
                        <span class="i_youhui">
                        <?php if ($youhui){
							
						$n=1;
						foreach($youhui as $yh){
						echo "<span class='note".$n."'><em>";
						
						echo $this->model_config->youhui_radio_ary($yh);
						
						echo "</em></span>";
						$n++;
						}}?>
                        </span>
                    </div>
                    <div class="hot_info_bottom">
                        <div class="h_i_b_left" >
                           <div class="h_i_d">
                            <ul class="Slider" id="Slider" style="top: 1px;">
                                <?php foreach (array_slice($hotelInfo['hpicshow'],0,4) as $key=>$val){ ?>
                                <li><img alt="<?php echo $hotelInfo['HotelName']; ?>" src='<?php echo $val['pic_url']; ?>' width="232px" height="174px" border='0' /></li>
                                <?php } ?>
                            </ul>
                           </div>
                           <div class="h_i_x">
                               <ul class="rotatorNumber" id="numeric">
                                <?php foreach (array_slice($hotelInfo['hpicshow'],0,4) as $key=>$val){ ?>
                                <li><img alt="<?php echo $hotelInfo['HotelName']; ?>" src='<?php echo $val['pic_url']; ?>' width="56px" height="42px" border='0' /></li>
                                <?php } ?>
                               </ul>  
                           </div>
                        </div>
                        <div class="h_i_b_middle">
                           <ul>
                               <?php if(trim($hotelInfo['esdid'],' ') != ''){ ?> 
                               <li>地标：<strong><a href="<?php  echo site_url("/hotellist/cityid-{$hotelInfo['ecityid']}-cbd_id-{$hotelInfo['esdid']}") ?>" title="<?php echo $hotelInfo['e_sdname'] ?>附近酒店"><?php echo $hotelInfo['e_sdname'] ?></a></strong>   &nbsp;<a id="Map_Show" href="<?php echo site_url("/map/index?lng={$hotelInfo['baidu_lng']}&lat={$hotelInfo['baidu_lat']}") ?>"><img class="le_20" src="<?php echo base_url();?>public/www/blue/images/mag_img.gif" width="16" height="16">查看地图</a></li> 
                               <?php } ?>
                               <li>行政区：<?php echo $hotelInfo['eareaname']."区&nbsp;&nbsp;&nbsp;"; ?>地址：<?php echo $hotelInfo['Address']; ?></li> 
                               <li>
                                   <span class="bq">标签：</span>
                                   <div class="bqleft">
                                       <?php if ($hotelInfo['Tags'] != ''){  foreach ($hotelInfo['Tags'] as $key=>$val){ ?>   
                                       <span class="note<?php echo $key+1 ?>"><em><?php echo $val ?></em></span>
                                       <?php }} else { ?><span class="note1"><em>暂无标签</em></span><?php } ?>
                                    </div>
                               </li>

                               <li>共有<font class="f_b1_f00"><?php echo $commentNumber; ?>条</font>真实入住客户点评,<font class="f_b1_f00"><?php echo $questionNumber; ?>条</font>问答</li>
                               <li>此酒店有<font class="f_b1_f00"><?php echo $hotelInfo['hpicshowNumber']; ?>张</font>真实照片供您参考</li>
                           </ul>
                        </div>
                        <div class="h_i_b_right">
                           <dl>
                              <dt><span class="pingfen"><span class="pf01"><font style="font-size:16px;"><?php echo $hotelInfo['HaoPing']; ?></font>分</span><span class="f_hui">5分</span>
                                            </span><span>好评总分数：</span></dt>
                              <dd>
                                <div  id="DP_Map_Show" style="width:237px;height:113px;border:0px #CCC solid;margin-left:0;"></div>
                              </dd>
                              <dd>
                                <!-- Baidu Button BEGIN -->
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
                              
                              </dd>
                           </dl>
                        </div>
                    </div>
                 </div>    
           <div class="jdlist">
                    <div class="jdlist_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
                        <div class="jdfx">
                           <div class="jdfx_top">
                             <div class="fxyd"><strong>房型预订</strong></div>
                             <div class="se_search">
                   <form action="" method="get">
                             <div class="ser_con">
                                
                                <ul class="cd">
                                    <li>
                                      <label for="city"><font style="color:#ff0000;">*</font>入住日期：</label>
                                      <div class="srh_box">
                                            <div class="input_01">
                                                 <div class="input_001">
                                                    <span class="sicon_02"></span>
                                                 </div>
                                            </div>
                                            <input name="txtComeDate" type="text" value="<?php echo $sk_array['tm1'] ?>" id="txtComeDate" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('txtComeDate',false,'txtComeDate','txtOutDate','txtOutDate','<?php echo $sk_array['tm1'] ?>','','','','','text','')"/>
                                      </div>
                                    </li>
                                    <li>
                                      <label for="city"><font style="color:#ff0000;">*</font>退房日期：</label>
                                      <div class="srh_box">
                                            <div class="input_01">
                                                 <div class="input_001">
                                                    <span class="sicon_03"></span>
                                                 </div>
                                            </div>
                                            <!--<input name="txtCity" type="text" value="2012-09-06" class="input_city" />-->
                                            <input name="txtOutDate" type="text" value="<?php echo $sk_array['tm2'] ?>" id="txtOutDate" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('txtOutDate',false,'txtOutDate','','','<?php echo $sk_array['tm2'] ?>','','','','','text','')"/>

                                      </div>
                                    </li>
                                    <li>
                                    <input name="ebooking" type="button" value="修改" onClick="refreshprice('<?php echo $hotelInfo['hotel_id']; ?>','<?php echo $order_api ?>');" class="src_btn1" />
                                    </li>
                                </ul>
                                
                             </div>
                   </form>
           </div>
                           </div>
                           <div class="jdfx_bottom">
                            <div class="fangxingnr">
                                <div style="padding-left:8px;" class="fang_news">
                                    <div id="h<?php echo $hotelInfo['hotel_id']; ?>">
                                        <p style="text-align:center;"><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>
                                    </div>
                                </div>
                            </div>
                           </div>
                        </div>
                        <div class="hotinfo_plate">
                           <div class="hotinfo_top">
                               <ul>
                                  <li class="current" id="hotel_info_tab"><a href="javascript:void(0)" >酒店介绍</a></li>
                                  <li id="hotel_picture_tab"><a href="javascript:void(0)" >酒店图片</a></li>
                                  <li id="hotel_lable_tab"><a href="javascript:void(0)" >周边地标</a></li>
                               </ul>
                           </div>
                           <div class="hotinfo_bottom">
                           	   <!-- 酒店介绍 -->
	                           <div id="hotel_info_div">
	                               <div class="infojs"> 
	                                   <div class="infojs_bottom">
									   <dl>
	                                  <dt class="fjtu">
		                                  <span class="left"><a href="javascript:void(0)" onclick="set_nexpic('left')"></a></span>
		                                  <span style="width:350px; height:260px;overflow: hidden;"><img class="hotel_picture_big" src="<?php echo $hotelInfo['hpicshow'][0]['pic_url']; ?>" height="290" alt="<?php echo $hotelInfo['HotelName']; ?>"/></span>
		                                  <span class="right2"><a href="javascript:void(0)" onclick="set_nexpic('right')"></a></span>
	                                  </dt>
	                                  <dd id="hotelpic_list" total="<?php echo count($hotelInfo['hpicshow'])?>" current="1">
	                                  <?php $i=0; foreach ($hotelInfo['hpicshow'] as $key=>$val){$i++; ?>
	                                    <span><a href="javascript:void(0)"><img class="hotel_picture_small" src="<?php echo $val['pic_url']; ?>" width="100" height="75"  id="current_<?php echo $i ?>" alt="<?php echo $hotelInfo['HotelName']; ?>" /></a></span>
	                                  <?php } ?>  
	                                  </dd>
	                               </dl>
									   
									   
									   <?php echo $hotelInfo['Content']; ?></div> </div>
	                                   <!--<div class="infojs_top"><span class="js_t_1"><strong>简介</strong></span><span class="js_t_2"></span></div>--> 
								   
								   
								   
	                              
	                               <div class="infojs"  >
	                                   <div class="infojs_top"><span class="js_t_3"><strong>服务设施</strong></span><span class="js_t_4"></span></div>
	                                   <div class="infojs_bottom">
	                                       <ul class="jdss">
	                                          <?php foreach ($hotelInfo['Service'] as $key=>$val){ ?>
	                                            <li class="you"><?php echo $val; ?> </li>
	                                          <?php } ?>   
	                                       </ul>
	                                   </div>
	                               </div>
	                               <div class="infojs">
	                                   <div class="infojs_top"><span class="js_t_3"><strong>交通位置</strong></span><span class="js_t_4"></span></div>
	                                   <div class="infojs_bottom">
	                                   <ul class="jtwz"><li><?php echo $hotelInfo['Traffic']['title']; ?></li>
	                                    <?php foreach ($hotelInfo['Traffic']['content'] as $key=>$val){ ?>
	                                    <li><font style="color:#368e29;">⊙</font><?php echo $val; ?></li>
	                                    <?php } ?>
	                                   </ul>
	
	                                   </div>
	                               </div>
                               </div>
                               <!-- 酒店图片 -->
                               <div class="infojs_bottom" id="hotel_picture_div">
	                               <dl style=" margin-left:15px;">
	                                  <dt class="fjtu">
		                                  <span class="left"><a href="javascript:void(0)" onclick="set_nexpic('left')"></a></span>
		                                  <span style="width:350px; height:260px;overflow: hidden;"><img class="hotel_picture_big" src="<?php echo $hotelInfo['hpicshow'][0]['pic_url']; ?>" height="290" alt="<?php echo $hotelInfo['HotelName']; ?>"/></span>
		                                  <span class="right2"><a href="javascript:void(0)" onclick="set_nexpic('right')"></a></span>
	                                  </dt>
	                                  <dd id="hotelpic_list" total="<?php echo count($hotelInfo['hpicshow'])?>" current="1">
	                                  <?php $i=0; foreach ($hotelInfo['hpicshow'] as $key=>$val){$i++; ?>
	                                    <span><a href="javascript:void(0)"><img class="hotel_picture_small" src="<?php echo $val['pic_url']; ?>" width="100" height="75"  id="current_<?php echo $i ?>" alt="<?php echo $hotelInfo['HotelName']; ?>" /></a></span>
	                                  <?php } ?>  
	                                  </dd>
	                               </dl>
	                           </div>
	                           <!-- 周边地标 -->
	                           <div class="infojs_bottom" id="hotel_lable_div">
	                              <ul class="zbdb">
	                                <?php if (!empty($hotelInfo['NearbyPoints'])){ ?>   
	                                <?php foreach ($hotelInfo['NearbyPoints'] as $key=>$val){ ?>    
	                                <li><span class="f_right"><font class="f_b1_f00"><?php echo round ( $val['juli'] / 1000, 2 ); ?></font>公里</span><font style="color:#368e29;">⊙</font>距<a href="<?php  echo site_url("/hotellist/cityid-{$hotelInfo['ecityid']}-keyid-{$val['id']}-pinyin-{$val['pinyin']}") ?>"><?php echo $val['lable'] ?></a></li>
	                                <?php } ?>
	                                <?php }else{ echo '该酒店附近没有地标';} ?>
	                              </ul>
	                           </div>
                           </div>
                           
                           
                           
                           
                        </div>
                        
                        <div class="hotinfo_plate" >
                           <div class="hotinfo_top">
                               <ul>
                                  <li class="current" id="comment_tab"><a href="javascript:void(0)" >酒店点评</a></li>
                                  <li id="question_tab"><a href="javascript:void(0)">酒店问答</a></li>
                               </ul>
                           </div>
                           <div class="hotinfo_bottom" id="hotel_comment_div">
                                <div class="infodp_botm">
                                <div class="dp_b_infoleft">
                             <?php  if (!empty($commentList)){ ?>   
                             <?php foreach ($commentList as $key=>$val){ ?>   
                             <dl>
                                  <dt>
                                  	<span><img src="<?php echo base_url();?>public/images/<?php echo $val['comment_pic'] ?>" width="66" height="55" /></span>
                                    <span><font class="f_b2_f00"><?php echo $val['username'] ?></font></span>
                                  </dt>
                                  <dd>
                                  <ul>
                                  <li> <div class="bqleft">
                                       <?php if ($val['yinxiang_show'] != ''){  foreach ($val['yinxiang_show'] as $key1=>$val1){ ?>   
                                       	<span class="note<?php echo $key1+1 ?>"><em><?php echo $val1 ?></em></span>
                                   	   <?php }} ?>
                                    </div>
                                    
                                   </li>
                                  <li> <div class="bt">
                                   		<span class="right">点评时间：<?php echo date("Y年m月d日H:i:s",$val['time']) ?></span><span><?php echo $val['comment_pic_text'] ?></span>
                                   </div></li>
                                  <li> <div class="dp_nr">
                                       <div class="jiao"></div>
                                       <div class="xinxi"><?php echo $val['content'] ?></div>
                                   </div></li>
                                   </ul>
                                 </dd>
                                 
                             </dl>
                             <?php } ?>
                             <?php }else{ echo '该酒店暂无评论';} ?>
                             
                          </div>
                            </div>
                           </div>
                           <div class="hotinfo_bottom" id="hotel_question_div">
                               <div class="wd_b_infoleft">
                                 <?php if (!empty($questionList)){ ?>   
                                 <?php 
                                 	$i = 0;
                                 	foreach ($questionList as $key=>$val){
                                 		$i++;
                                 ?>    
                                 <dl onmouseover="this.style.backgroundColor='#f7f7f7'" onmouseout="this.style.backgroundColor='#ffffff'">
                                   <dt><span class="f_b1_f00">0<?php echo $i ?></span></dt>
                                   <dd>
                                       <ul>
                                          <li><font class="ql"><?php echo $val['question'] ?></font></li>
<li>来自于：   <?php echo $val['username']; ?>   <?php echo date("Y年m月d日H:i:s",$val['updatetime']) ?></li>  
<li class="anwser"><font class="f_999">回答：</font><?php echo $val['answer'] ?></li>
                                       </ul>
                                   </dd>
                                 </dl>
                                 <?php } ?>
                                 <?php }else{ echo '该酒店暂无问答';} ?>
                             </div>
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
<div class="inbz"><img src="<?php echo base_url();?>public/www/default/images/inbz.jpg" width="950" height="57" /></div>


<?php $this->load->view('inc/footer');
$ci = & get_instance();
$ci->load->library('tool');
$ci->tool->zhuna_rewrite(CFG_REWRITE);?>
<form action="<?php echo site_url('ebook/index')?>" method="get" target="_blank" name="doBook" id="doBook">
    <input name="hid" type="hidden"/>
    <input name="rid" type="hidden" />
    <input name="pid" type="hidden" />
    <input name="tm1" type="hidden" value="<?php echo $sk_array['tm1']; ?>" />
    <input name="tm2" type="hidden" value="<?php echo $sk_array['tm2']; ?>" />
    <input name="loginstate" type="hidden" value="<?php echo $loginsate; ?>" />
</form>
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