<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/css/tuan1.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/css/tuan2.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/css/tuaninfo.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>
<!--日历js和css-->
<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/dialog/dialog.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url();?>public/js/room.utf8.js" type="text/javascript"></script>
<link href="http://www.api.zhuna.cn/room.utf8.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<title><?php echo $metainfo['k_title']?></title>
<meta name="keywords" content="<?php echo $metainfo['k_keywords']?>" />
<meta name="description" content="<?php echo $metainfo['k_description']?>" />
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
	   
	   //标记购买
   $('#bjgm').click(function(){
	   $.ajax({
   type: "POST",
   url: $(this).attr('info'),
   data: "",
   success: function(msg){
	   
     $('#bjgm').html("<i class='cur'></i>已标记");
   }
});});

   //收藏
   $('#sc').click(function(){
	   $.ajax({
   type: "POST",
   url: $(this).attr('info'),
   data: "",
   success: function(msg){
     $('#sc').html("<i class='cur'></i>已收藏");
   }
});});


 //消费提醒
   $('#xfjx').click(function(){
	   $('.details .con').toggle();
	   $(this).toggleClass('open');
	  });



$('.product .box').hover(
function(){
	$(this).find('.b_pop').show()
}
,
function(){
	$(this).find('.b_pop').hide()
}

);


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
function shoucang(id,type){
	  $.ajax({
   type: "POST",
   url: '/command/add_concern/'+id+'/'+type,
   data: "",
   success: function(msg){
     $('#sc').html("<i class='cur'></i>已收藏");
   }
});
}
</script>
<style type="text/css">
 .blockC {
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	border-color: #F3F3F3;
	border-image: none;
	border-right: 1px solid #F3F3F3;
	border-style: solid;
	border-width: 4px 1px 1px;
	color: #333333;
	line-height: 20px;
	margin-bottom: 10px;
	padding: 10px;
	text-align: left;
	background-color: #FFF;
}
 .blockC h3 {
  color: #666666;
  font-size: 14px;
  font-weight: bold;
  padding-bottom: 5px;
}
.blockC p {
  line-height: 20px;
}
</style>
</head>

<body>
<noscript>
<p class="div-980">您的浏览器不支持javascript，请开启javascript支持或者更换浏览器。</p>
</noscript>
<div class="header-wrap">
  <div class="userbar" mon="action=click&amp;type=userBar"> 
  </div>
  <div id="head-search-box-area" class="header div-980 clearfix ">
    <div class="header-top">
      <div class="div-980 clearfix">
        <div class="wt-logo logo float-left"><a href="http://www.xexing.com/tuangou/" mon="#action=click&amp;type=logo&amp;content=logo"><img src="http://www.xexing.com/public/www/default/images/logo-2.png" alt="携行酒店团购" title="携行酒店团购" height="80"></a></div>
        <div class="wt-city float-left">
          <div class="city-border">
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
        <div class="wt-search search float-left">
          <form id="ssform" class="search-form" data-position="local" method="get" action="/tuangou/<?php echo $cityinfo['pinyin'] ?>/search" onkeydown="if(event.keyCode==13&amp;&amp;document.getElementById('ssinput').value==''){return false;}">
            <span class="s_ipt_wr">
            <input id="ssinput" class="input-search float-left prompt-default" style="*padding-top:0;*line-height:22px;" name="wd" value="" maxlength="256" autocomplete="off" type="text">
            </span><span class="s_btn_wr">
            <input id="ssbutton" class="button-search submit" onmousedown="this.className='input submit s_btn_h'" onmouseout="this.className='input submit'" value="搜一下" type="submit">
            </span>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('inc/nav');?>
<div class="div-980" id="main" mon="action=click">
  <div class="list_nav">
    <ul>
      <li><a href="http://www.xexing.com/">捷行网</a></li>
      <li><a href="/tuangou/<?php echo $city['pinyin']?>"><?php echo $city['cName']?>酒店团购大全</a></li>
    </ul>
  </div>
  <div class="goods-hd-wrap w981 h44 goods-hd-wrap-new" mon="section=banner&amp;type=sortbar">
    <div class="area">
      <div class="col_ml">
        <div class="shangpin">
          <div class="s_title">
            <h1><?php echo $shortTitle?></h1>
            <p><a id="share_title" rel="nofollow" target="_blank" href="<?php echo $loc?>"><?php echo $title?></a></p>
          </div>
          <div class="dealinfo">
            <div class="info_l"> <a id="share_title" rel="nofollow" target="_blank" href="<?php echo $loc?>"> <img width="450" height="300" src="<?php echo $image?>"></a>
          
            </div>
            <div class="info_r">
              <div class="buy"> <a id="share_title" rel="nofollow" target="_blank" href="<?php echo $loc?>">￥<?php echo $price?> 去看看</a>
                <p><span>原价:¥<?php echo $value?></span>/<span>折扣:<?php echo $rebate?></span>/<span>节省:¥<?php echo $value-$price?></span></p>
              </div>
              <table width="253" cellspacing="1" cellpadding="0" border="0" class="pro_store">
                <tbody>
                  <tr>
                    <td colspan="2" class="td_title"><?php echo $bought?>人已购买</td>
                  </tr>
                  <tr>
                    <td class="td_title">到期时间</td>
                    <td><?php echo date('Y-m-d',$endTime)?></td>
                  </tr>
                  <tr>
                    <td class="td_title">来源</td>
                    <td><a target="_blank" href="<?php echo $siteurl?>"><?php echo $website?></a></td>
                  </tr>
                  <tr>
                    <td class="td_title">电话</td>
                    <td><?php echo $phone?></td>
                  </tr>
                 
                </tbody>
              </table>
              
            </div>
            <div class="details">
    <div>
      <span class="l item1"><a id="bjgm" title="标记购买" href="javascript:void(0)" info="/command/add_buy/<?php echo $tid?>"><i></i>标记购买</a></span>
      <span class="l item2"><a href="javascript:void(0)" info="/command/add_concern/<?php echo $tid?>" title="收藏" id="sc">
          <i class=""></i>收藏</a>
      </span>
      <dl class="l item3 hy">
      <dt><a class="bshareDiv"  href="javascript:void(0)"><em></em><i></i>分享</a></dt>
  <div class="bshare-custom"><div class="bsPromo bsPromo2"><a  href="javascript:void(0)"><em></em><i></i>分享</a></div><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=dba5a563-f312-458c-9bf7-321ff6b7c33a&amp;pophcol=1&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
      </dl>
      <span class="r" id="xfjx"><a href="javascript:;"><i></i>消费提醒</a></span>
    </div>
    <?php if($tips){  ?>
    <div class="con" style="display:none">消费提醒：<br>
     <?php echo $tips?>
     
        </div>
        <?php }?>
  </div>
            <span class="clear"></span> </div>
        </div>
        <span class="blank15"></span>
        <div class="col_shop_tab"><a class="hover" href="javascript:void(0);">商家位置</a></div>
        <div class="col_shop">
          <div class="col_shop_map">
            <h2>商家位置</h2>
            <div style="width:400px;height:220px; float:left" id="DP_Map_Show" class="shop_map"></div>
            <div class="shop_info">
              <dl>
                <dt>
                  <h2><?php echo $seller?></h2>
                </dt>
                <dd>地址：<?php echo $address?></dd>
                <dd>电话：<?php echo $phone?></dd>
              </dl>
            </div>
            <span class="clear"></span> </div>
          <span class="clear"></span> </div>
          <span class="blank15"></span>
            <!--该团购的酒店预订开始-->
            <div class="col_title nobg">
          <h3>直接预订该酒店或最近酒店</h3>
        </div>
        <div class="product">
        <?php if($hotelyd){?>
           <div class="hot_li_plate">
			                            	<div class="hot_li_p_top">
    		                                    <span class="right"><dfn>¥</dfn><em><?php echo $hotelyd['Min_price']; ?><font class="yuan_f00">元</font></em>起</span>
    		                                    <span class="kuang"></span>
    		                                    <span><strong><a href="<?php echo site_url("/hotelinfo/{$hotelyd['hotel_id']}") ?>" title="<?php echo $hotelyd['HotelName']; ?>" target="_blank"><?php echo $hotelyd['HotelName']; ?></a></strong></span>
    		                                    <span><?php if ($hotelyd['xingji']>1) { ?><img width="86" height="16" src="<?php echo base_url();?>public/www/blue/images/xj<?php echo $hotelyd['xingji']; ?>.gif"><?php } ?></span>
    		                                </div>
    		                                <div class="hot_li_p_bottom">
    		                                    <div class="hot_li_top">
    		                                        <dl>
    		                                            <dt>
    		                                            <span><a href="<?php echo site_url("/hotelinfo/{$hotelyd['hotel_id']}") ?>" title="<?php echo $hotelyd['HotelName']; ?>" target="_blank"><img src="http://p.zhuna.cn/<?php echo $hotelyd['picture']; ?>" width="134" height="100" alt="<?php echo $hotelyd['HotelName']; ?>" /></a></span><span class="yy"></span>
    		                                            </dt>
    		                                            <dd>
    		                                               <ul>
    		                                                  <li>
    		                                                  		酒店位置：
    		                                                  		<?php if ($hotelyd['place_id'] != '') { ?>
    		                                                  		<font style="color:#6f7c99;"><a href="<?php echo site_url("{$list_url['cbd']}-cbd_id-{$hotelyd['place_id']}") ?>"><?php echo $hotelyd['place']; ?></a></font>
    		                                                  		<?php } else { ?>
    		                                                  			<?php echo $hotelyd['place']; ?>	
    		                                                  		<?php } ?>
    		                                                  		<a id="Map_Show" href="<?php echo site_url("/map/index?lng={$hotelyd['baidu_lng']}&lat={$hotelyd['baidu_lat']}");?>">
    		                                                  			<img class="le_20" src="<?php echo base_url();?>public/www/blue/images/mag_img.gif" width="16" height="16" />查看地图
    		                                                  		</a>
    		                                                  </li>
    		                                                  <li>提供服务：<font style="color:#6f7c99;"><?php if (!empty($hotelyd['service_pic'])) { foreach ($hotelyd['service_pic'] as $key1=>$hotelyd1) { ?><img title="<?php echo $hotelyd1[1] ?>" src="<?php echo base_url();?>public/images/<?php echo $hotelyd1[0] ?>" width="16" height="16" /><?php } } else { ?>服务信息未知<?php } ?></font>
    		                                                  <li>酒店地址：<font style="color:#6f7c99;"><?php echo $hotelyd['Address']; ?></font></li>
    		                                                  <li><font class="f_999"><?php if (!empty($hotelyd['juli'])) { ?><font class="f_b1_f00"><?php echo $hotelyd['juli']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</font><?php } ?>最近有点评<font class="f_b1_f00"><?php echo $hotelyd['df_haoping'][1][3]; ?>条</font></font></li>
    		                                               </ul>
    		                                            </dd>
    		                                            <dd class="pingfen"><span class="pf01"><font style="font-size:16px;"><?php echo $hotelyd['df_haoping'][0]; ?></font>分</span><span class="f_hui">5分</span>
    		                                            </dd>
    		                                        </dl>
    		                                    </div>
    		                                </div>
    		                                <div class="hot_li_bottom">
    		                                    <div id="h<?php echo $hotelyd['hotel_id']; ?>">
                                                    <p style="text-align:center;"><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>
                                                </div>
    		                                </div>
    		                        </div> 
                                    
                                    <?php }?>
                                    </div>
           <!--该团购的酒店预订结束-->
           
          
        <span class="blank15"></span>
        <div class="col_title nobg">
          <h3>周边酒店团购</h3>
        </div>
        <div class="product">
        
        <?php if($nearbyTuan){
			
			foreach($nearbyTuan as $key=>$tuan){
				
			?>
          <div class="box w240"><a href="/tuangouinfo/<?php echo $tuan['tid']?>"><img width="230" height="150" alt=""  src="<?php echo $tuan['image']?>"></a>
            <h3> <a class="hit_title" href="/tuangouinfo/<?php echo $tuan['tid']?>"><?php echo $tuan['shortTitle']?></a></h3>
            <div class="b_jiage_sub">
              <p class="jiage"><span class="xian"><i>¥</i><?php echo $tuan['price']?></span></p>
              <p class="sub"><a rel="nofollow" target="_blank" href="<?php echo $tuan['loc']?>">去看看</a></p>
            </div>
            <div class="b_db_tool">
              <p class="db"><?php echo $tuan['locationName']?><em>|</em><?php echo $tuan['range']?></p>
              <p class="tool"><a id="<?php echo $tuan['api_id']?>" class="cgreen" href="javascript:shoucang(<?php echo $tuan['api_id']?>,1);">收藏</a></p>
            </div>
            <div class="b_pop w232">
              <p>商家：<?php echo $tuan['seller']?></p>
              <p>地址：<?php echo $tuan['address']?></p>
            </div>
          </div>
         <?php }}?>
          
        </div>
        <span class="blank15"></span>
        <div class="col_title nobg">
          <h3>周边酒店预订</h3>
        </div>
        <div class="product">
          
         <?php if($nearbyHotel){
			
			foreach($nearbyHotel['contents'] as $key=>$hotel){
				
			?>
          <div class="box w240"><a href="/hotelinfo/<?php echo $hotel['api_id']?>/2"><img width="230" height="150" alt="窝窝团-上海团购"  src="<?php echo $hotel['picture']?>"></a>
            <h3> <a class="hit_title" href="//hotelinfo/<?php echo $hotel['api_id']?>/2"><?php echo $hotel['title']?></a></h3>
            <div class="b_jiage_sub">
              <p class="jiage"><span class="xian"><i>¥</i><?php echo $hotel['min_jiage']?>起</span></p>
              <p class="sub"><a rel="nofollow" target="_blank" href="/hotelinfo/<?php echo $hotel['api_id']?>/2">去看看</a></p>
            </div>
            <div class="b_db_tool">
              <p class="db"><?php echo $hotel['district']?><em>|</em><?php echo $hotel['esdname']?></p>
              <p class="tool"><a id="<?php echo $hotel['api_id']?>" class="cgreen" href="javascript:shoucang(<?php echo $hotel['api_id']?>,1);">收藏</a></p>
            </div>
            <div class="b_pop w232">
              <p>商家：<?php echo $hotel['esdname']?></p>
              <p>地址：<?php echo $hotel['address']?></p>
            </div>
          </div>
         <?php }}?>
          
          
        </div>
        <span class="blank15"></span>
        <div class="col_title_more"><a target="_blank" href="/shanghai/lvyoujiudian/">上海酒店旅游团购 <span class="corange">查看全部</span></a></div>
      </div>
      <div class="col_r" style="margin-bottom:-10px">
        <?php $this->load->view('modules/'.$layout[1][1]);?>
        <?php $this->load->view('modules/'.$layout[2][1]);?>
        <?php $this->load->view('modules/historytuan');?>
         
        <span class="blank15"></span>
        <div class="prolist labels">
          <h2><a target="_blank" href="/shanghai//lvyoujiudian/">上海酒店旅游团购</a></h2>
          <ul>
            <li> 
            <?php 
			if($taglist){
			foreach($taglist as $tag){?>
            <a target="_blank" href="/hotellist/cityid-<?php echo $city['cid']?>-hn-<?php echo $tag['tagname']?>/"><?php echo $tag['tagname']?></a> 
            <?php }} ?>
            
            
            </li>
            <li> </li>
          </ul>
          <span class="blank10"></span> </div>
        <span class="blank15"></span>
        <div class="prolist rsite">
          <h2><a href="#">团购网站推荐</a></h2>
          <ul>
            <li> 
            <?php 
			if($weblist){
			foreach($weblist as $web){?>
            <a target="_blank" href="<?php echo $web['url']?>"><img width="80" height="41" src="<?php echo $web['logo']?>"></a> 
            <?php }} ?>
             <span class="clear"></span> </li>
          </ul>
        </div>
        <span class="blank15"></span>
        <div id="baidu_ad_160x600">
          <div id="baidu_clb_slot_743426">
            <div class="blockC">
      <h3>3.15特别提示</h3>
      <p style="height: auto;">目前国内的团购网站良莠不齐，为了避免上当受骗，团800提醒您注意：

              1. 确保您去的团购网站是您了解和信任的，请查看它过往的团购记录和商家合作情况。

              2. 可以通过网络搜索等方式查看网友们对此团购网站以及合作商家活动的口碑评价。

              3. 确认交易流程中不要随意泄漏您的账号、密码，保留好您的支付及消费凭证。

              4. 如果您在消费后能回到团800这里留下您对本次团购的经历评价，会帮助其他许多和您一样的网友！

              注： 作为中立客观的团购导航网站，团800无法监控团购网站中的不实宣传，也没有行政处罚的权利，但我们希望可以网聚消费者的力量让大家 团的放心，用的开心！
<a onclick="$.fn.sq()" style="color:#007e8c" href="javascript:void(0);">[收起]</a></p>
    </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="collectSuc" style="display:none;position: absolute; z-index: 99999; padding: 0px; margin: 0px;height:0;">
    <div class="popup_content alert"><span id="collectSuc_close">span>
      <div class="popup_message">收藏成功</div>
      <div class="popup_panel">
        <p>查看&nbsp;&nbsp;<a target="_blank" href="#" mon="type=tg-popclick" class="gocollectman" id="goCollect">我的收藏&gt;&gt;</a></p>
      </div>
    </div>
    <span class="shadow"></span></div>
  <div class="tuan-goods div-984 goods-n" id="main-center" alog-alias="tuan-local-itemarea" alog-group="tuan-local-itemarea">
    <div id="tuan_statistics_1_all" alog-alias="tuan-local-itemlist" alog-group="tuan-local-itemlist">
      <div class="goods-wrap" id="content" mon="type=item&amp;pageindex=1&amp;order=0&amp;qa_test_type=2"></div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div><a style="bottom: 142px;" class="common-code-big-ctn" id="common-code-big-ctn" href="#" target="_blank" hidefocus="true"><i class="common-code-close" id="common-code-close-btn" title="关闭"></i>扫一扫手机继续看<i class="common-code-big-img"><img src="<?php echo base_url();?>public/images/erweima.png" width="87" height="87" /></i></i></a></div>
<div class="groupon-backtop-wrapper"><a style="left:50%; margin-left:500px; bottom:87px;" href="#" id="groupon-backtop" title="返回顶部"></a></div>
<?php $this->load->view('inc/footer');

$ci = & get_instance();
$ci->load->library('tool');
$ci->tool->zhuna_rewrite(CFG_REWRITE);?>
<script type="text/javascript">

loadPrice("<?php echo $hotelyd['hotel_id']; ?>",'<?php echo date('Y-m-d',time()); ?>','<?php echo date('Y-m-d',time()+86400); ?>');
//地图开始
var map = new BMap.Map("DP_Map_Show");
var point=new BMap.Point(<?php echo $longitude; ?>,<?php echo $latitude; ?>);
map.setMinZoom(9);
map.centerAndZoom(point, 17);
var marker = new BMap.Marker(point);  // 创建标注
map.addOverlay(marker);              // 将标注添加到地图中
map.addControl(new BMap.NavigationControl());

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
</script>
</body>
</html>