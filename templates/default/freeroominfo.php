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
<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script src="<?php echo $order_api ?>room.utf8.js" type="text/javascript"></script>
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
    <div class="xdh"> <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span> <span class="wzdt"></span><span class="sy"><a href="<?php  echo site_url("/allcity") ?>">试住中心</a></span> </div>
    <div class="hot_info_xx">
      <div class="hot_info_top" style="height:44px"> <span class="right" style="width:245px"><a  href="/hotelinfo/<?php echo $roominfo['R_HotelID']; ?>"><img src="/public/images/btn_yd.jpg" width="245"  /></a></span> <span>
        <h1><?php echo $roominfo['R_Title']; ?></h1>
        </span> </div>
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
            <!--<li>酒店：<?php echo $hotelInfo['HotelName']  ?></li>-->
			<li>酒店：<a  href="/hotelinfo/<?php echo $roominfo['R_HotelID']; ?>"><?php echo $hotelInfo['HotelName']; ?></a></li>
            <!--<li>房型：<?php echo $roominfo['R_RoomName']; ?></li>-->
            <li>价格：<font color="#FF0000">0元</font></li>
            <li>入住日期：<?php echo date('Y-m-d',$roominfo['R_Checkintime'])?> </li>
			<li>申请时间：<?php echo date('Y-m-d',$roominfo['R_Checkintime']-950400).'至'.date('Y-m-d',$roominfo['R_Checkintime']-86400) ?></li>
            <li style="height:36px; line-height:45px; margin-top:10px"><a style="margin-right:10px; float:left" class="btn_sqsz" href="/ebook/index/?freeroomid=<?php echo $roominfo['fid']; ?>&hid=<?php echo $roominfo['R_HotelID']; ?>&rid=<?php echo $roominfo['R_RoomID']; ?>&tm1=<?php echo date('Y-m-d',$roominfo['R_Checkintime']); ?>&tm2=<?php echo date('Y-m-d',$roominfo['R_Checkouttime']); ?>&type=1">申请试住</a>共有<font class="f_b1_f00"><?php echo $sqnum; ?>人</font>已申请,<font class="f_b1_f00"><?php echo $sqnum2; ?>人</font>已试住
      </li>
            <li></li>
          </ul>
        </div>
        <div class="h_i_b_right">
          <dl>
            <dd style="height:153px">
              <div  id="DP_Map_Show" style="width:237px;height:153px;border:0px #CCC solid;margin-left:0;"></div>
            </dd>
            <dd> 
              
              <!-- Baidu Button BEGIN -->
              
              <div style="float:right;" id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"> <span class="bds_more">分享到：</span> <a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="shareCount"></a> </div>
              <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=234336" ></script> 
              <script type="text/javascript" id="bdshell_js"></script> 
              <script type="text/javascript">document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();</script> 
              
              <!-- Baidu Button END --> 
              
            </dd>
          </dl>
        </div>
        <div class="clear"></div>
        <ul style="color:#838282; width:297px; float:left">
          <?php if(trim($hotelInfo['esdid'],' ') != ''){ ?>
          <li>区域：<strong><?php echo $hotelInfo['eareaname']; ?></strong> &nbsp;<a id="Map_Show" href="<?php echo site_url("/map/index?lng={$hotelInfo['baidu_lng']}&lat={$hotelInfo['baidu_lat']}") ?>"><img class="le_20" src="<?php echo base_url();?>public/www/blue/images/mag_img.gif" width="16" height="16">查看地图</a></li>
          <?php } ?>
          <li>地址：<?php echo $hotelInfo['Address']; ?></li>
        </ul>
        
      </div>
    </div>
    <div class="jdlist">
      <div class="jdlist_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
        <div class="jdfx">
        <img src="<?php echo base_url();?>public/images/sz1.jpg" width="716" />
        <div class="jianju10"></div>
<div class="hotinfo_top">
            <ul>
              <li class="current" id="freeroom_sq_tab"><a href="javascript:void(0)" >申请记录</a></li>
              <li id="freeroom_sz_tab"><a href="javascript:void(0)" >试住记录</a></li>
            </ul>
          </div>
          <div class="jdfx_bottom">
            <div id="freeroom_sq_info" class="hotinfo_bottom">
              <div class="dp_b_infoleft">
  <?php  
  
    $pattern = "/^(1\d{1,2})\d\d(\d{0,2})/";
$replacement = "\$1****\$4";

  if (!empty($hotelorder)){ ?>
                <?php foreach ($hotelorder as $key=>$val){ ?>
                <dl style="background-position:-1396px -50px">
                  <dt> <span><img src="<?php echo base_url();?>public/images/zhu7.gif" width="66" height="55" /></span> <span><font class="f_b2_f00"><?php echo preg_replace($pattern,$replacement,$val['phone']) ?></font></span> </dt>
                  <dd>
                    <ul>
                      
                      <li>
                        <div class="bt">我申请了该试住客房 <span class="right">申请时间：<?php echo date("Y年m月d日H:i:s",$val['addtime']) ?></span><span><?php echo $val['comment_pic_text'] ?></span> </div>
                      </li>
                      <li>
                        <div class="dp_nr">
                          <div class="jiao"></div>
                          <!--<div class="xinxi">理由：<?php echo $val['liyou'] ?></div>-->
						  <div class="xinxi">理由：隐藏>></div>
                        </div>
                      </li>
                    </ul>
                  </dd>
                  </dl>
                <?php } ?>
                <?php }else{ echo '暂无申请记录';} ?>
              </div>
            </div>
            <div id="freeroom_sz_info" class="hotinfo_bottom" style="display:none">
            
            
            <div class="dp_b_infoleft">
  <?php  
  
  
  
  if (!empty($hotelorder2)){ ?>
                <?php foreach ($hotelorder2 as $key=>$val){ ?>
                <dl style="background-position:-1396px -50px">
                  <dt> <span><img src="<?php echo base_url();?>public/images/zhu7.gif" width="66" height="55" /></span> <span><font class="f_b2_f00"><?php echo preg_replace($pattern,$replacement,$val['phone']) ?></font></span> </dt>
                  <dd>
                    <ul>
                      
                      <li>
                        <div class="bt"> 我试住了该客房<span class="right">试住时间：<?php echo date("Y年m月d日",$val['CheckInDate']) ?></span><span><?php echo $val['comment_pic_text'] ?></span> </div>
                      </li>
                      <li>
                        <div class="dp_nr">
                          <div class="jiao"></div>
                          <!--<div class="xinxi">理由：<?php echo $val['liyou'] ?></div>-->
						  <div class="xinxi">理由：隐藏>></div>
                        </div>
                      </li>
                    </ul>
                  </dd>
                  </dl>
                <?php } ?>
                <?php }else{ echo '暂无试住记录';} ?>
              </div>
             </div>
          </div>
        </div>
         <?php echo $roominfo['R_Content'] ?>
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
         <!--<div class="infojs_top">
				<span class="js_t_1"><strong>简介</strong></span><span class="js_t_2"></span></div>-->
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
				
				
				<?php echo $hotelInfo['Content']; ?></div>
              </div>
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
                  <ul class="jtwz">
                    <li><?php echo $hotelInfo['Traffic']['title']; ?></li>
                    <?php foreach ($hotelInfo['Traffic']['content'] as $key=>$val){ ?>
                    <li><font style="color:#368e29;">⊙</font><?php echo $val; ?></li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
            
            <!-- 酒店图片 -->
            
            <div class="infojs_bottom" id="hotel_picture_div">
              <dl style="margin-left:15px;">
                <dt class="fjtu"> <span class="left"><a href="javascript:void(0)" onclick="set_nexpic('left')"></a></span> <span style="width:350px; height:260px;overflow: hidden;"><img class="hotel_picture_big" src="<?php echo $hotelInfo['hpicshow'][0]['pic_url']; ?>" height="290" alt="<?php echo $hotelInfo['HotelName']; ?>"/></span> <span class="right2"><a href="javascript:void(0)" onclick="set_nexpic('right')"></a></span> </dt>
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
<div class="inbz"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/inbz.jpg" width="950" height="57" /></div>
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
	
	
	
	$("#freeroom_sq_tab").click(function(){divclass3($(this),'freeroom_sq_info');}) ;
	$("#freeroom_sz_tab").click(function(){divclass3($(this),'freeroom_sz_info');}) ;

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

function divclass3(divclass,divid){

    $('#freeroom_sq_tab').removeClass(); 

    $('#freeroom_sz_tab').removeClass();

    $(divclass).addClass('current');

    

    $("#freeroom_sq_info").hide();

    $("#freeroom_sz_info").hide();

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