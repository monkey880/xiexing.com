<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/css/tuan1.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/css/tuan2.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>
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
</head>

<body>
<noscript>
<p class="div-980">您的浏览器不支持javascript，请开启javascript支持或者更换浏览器。</p>
</noscript>
<div class="header-wrap">
  <div class="userbar" mon="action=click&amp;type=userBar"> 
    <!--<ul>
      <li class="relative"><a class="uname login_uname" href="http://tuan.baidu.com/selftg/order/list?status=0&amp;p=1" rel="nofollow" mon="#content=我的团购" id="J_mytuanorder">我的团购</a>
        <div class="user-tip" id="J_mylist">
          <ul class="user-more">
            <li><a href="http://tuan.baidu.com/selftg/order/list?status=0&amp;p=1" rel="nofollow" mon="#content=我的订单">我的订单</a></li>
            <li><a href="http://tuan.baidu.com/user/records/myorder" rel="nofollow" mon="#content=购买记录">购买记录</a></li>
            <li><a href="http://tuan.baidu.com/user/collection/collectman" rel="nofollow" mon="#content=我的收藏">我的收藏</a></li>
            <li><a href="http://tuan.baidu.com/user/user/admin" rel="nofollow" mon="#content=账户设置">账户设置</a></li>
          </ul>
        </div>
      </li>
      <li class="sep">|</li>
      <li><a class="float-left" href="http://tuan.baidu.com/user/custom/index" rel="nofollow" mon="#content=定制团购">定制团购</a></li>
      <li class="sep">|</li>
      <li><a class="float-left favor-btn" href="javascript:void(0)" rel="nofollow" mon="#content=addfav">收藏本页</a></li>
      <li class="sep">|</li>
    
      <li class="sep">|</li>
      <li><a href="http://tuan.baidu.com/user/user/login?u=http://tuan.baidu.com/local/quanzhou/jiudian-tg" class="login-name-dialog" rel="nofollow" mon="#content=login">登录</a><a href="http://tuan.baidu.com/user/user/reg?u=http://tuan.baidu.com/local/quanzhou/jiudian-tg" rel="nofollow" mon="#content=register">注册</a></li>
    </ul>--> 
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
  <div class="tuan-wrap w979">
    <div class="tuan-absorb" alog-alias="tuan-filter" alog-group="tuan-filter">
      <div class="sort-select cp"></div>
      <div class="tuan-catg-info clearfix">
        <div class="filter" style="border:none;">
          <div class="filter-container" mon="section=select">
            <div class="tuan-box clearfix" alog-alias="tuan-filter-sort" alog-group="tuan-filter-sort">
              <div class="fl mt10" style="margin-right: 17px">分类：</div>
              <div class="tuan-box-content fl w800" mon="type=subcategory"> <a <?php if(!$category){echo "class='tuan-current'";}?> href="<?php echo site_url("{$list_url['category']}") ?>" class="mr20 mark" mon="#content=全部" id=""> 全部 </a>
                <?php foreach($categor_arr as $key=>$val){?>
                <a class="mr20 mark <?php if($category==$key){echo 'tuan-current';}?>"   href="<?php echo site_url("{$list_url['category']}-category-$key") ?>"> <?php echo $val; ?> <!--<i class="num">19345</i> --></a>
                <?php }?>
              </div>
            </div>
            <div class="tuan-box clearfix bt pr control-button" style="z-index:10;" mon="type=range" alog-alias="tuan-filter-area" alog-group="tuan-filter-area">
              <div class="fl mr17 mt10">区域：</div>
              <div class="tuan-box-content deal-hide-display fl w800 area-number hide-area"> <a <?php if(!$area){echo "class='tuan-current'";}?> mon="#content=全部" href="<?php echo site_url("{$list_url['area']}") ?>"> 全部 </a>
                <?php if($area_arr){
				  foreach($area_arr as $key=>$val){
				  ?>
                <a <?php if($area==$key){echo "class='tuan-current'";}?> href="<?php echo site_url("{$list_url['area']}-area-$key") ?>" class="mr20 mark"> <?php echo $val ?> <!--<i class="num">5</i>--> </a>
                <?php }}?>
              </div>
              <div class="icon-area fr mt10"> <span class="tip-info" id="TipArea"> 展开 </span> <a mon="#content=更多区域" id="IconArea" class=" default-button"></a> </div>
            </div>
            <!--商圈开始-->
            <?php if($range_list){?>
            <div alog-group="tuan-filter-hotarea" alog-alias="tuan-filter-hotarea" mon="type=hotRange" id="pl20" style="padding-bottom: 7px;margin-top: -10px;padding-top: 2px;" class="tuan-box border-box border-box-background mb20 w840 clearfix pb10">
              <div class="fl mr10 mt10"> <a  class="mr20 mark <?php if(!$range){echo "tuan-current";}?>" href="<?php echo site_url("{$list_url['range']}") ?>"> <?php echo $areaname; ?> : </a> </div>
              <div class="tuan-box-content fl w760">
                <?php foreach($range_list as $val){?>
                <a  class="mr20 mark <?php if($range==$val['rid']){echo "tuan-current";}?>" href="<?php echo site_url("{$list_url['range']}-range-$val[rid]") ?>"> <?php echo $val['regionname'] ?> </a>
                <?php }?>
              </div>
            </div>
            <?php }?>
            <!--  商圈结束  -->
            
            <div class="tuan-box pt5 clearfix bt">
              <div class="fl mr17 mt10">档次：</div>
              <div class="tuan-box-content fl w800" mon="type=level" alog-alias="tuan-filter-level" alog-group="tuan-filter-level"> <a <?php if(!$star){echo "class='tuan-current'";}?> href="<?php echo site_url("{$list_url['star']}") ?>"> 全部 </a>
                <?php foreach($star_arr as $key=>$val){?>
                <a <?php if($star==$key){echo "class='tuan-current'";}?> href="<?php echo site_url("{$list_url['star']}-star-$key") ?>" class="mr20 mark" mon="#content=快捷酒店"> <?php echo $val ?><!-- <i class="num">3039</i>--> </a>
                <?php }?>
              </div>
            </div>
            <div class="tuan-box clearfix bt">
              <div class="fl mr17 mt10">房型：</div>
              <div class="tuan-box-content fl w800" mon="type=houseType" alog-alias="tuan-filter-houseType" alog-group="tuan-filter-houseType"> <a <?php if(!$fangxing){echo "class='tuan-current'";}?> href="<?php echo site_url("{$list_url['fangxing']}") ?>"> 全部 </a>
                <?php foreach($fangxing_arr as $key=>$val){?>
                <a href="<?php echo site_url("{$list_url['fangxing']}-fangxing-$key") ?>" class="mr20 mark <?php if($fangxing==$key){echo "tuan-current";}?> " > <?php echo $val ?><!-- <i class="num">3039</i>--> </a>
                <?php }?>
              </div>
            </div>
            <div class="tuan-box clearfix bt" alog-alias="tuan-filter-priceinternal" alog-group="tuan-filter-priceinternal">
              <div class="fl mr17 mt10">价格：</div>
              <div class="tuan-box-content fl" mon="type=price"> <a <?php if(!$price){echo "class='tuan-current'";}?> href="<?php echo site_url("{$list_url['price']}") ?>"> 全部 </a>
                <?php foreach($pricelist_arr as $key=>$val){?>
                <a <?php if($price==$key){echo "class='tuan-current'";}?> href="<?php echo site_url("{$list_url['price']}-price-$key") ?>" class="mr20 mark" mon="#content=快捷酒店"> <?php echo $val ?><!-- <i class="num">3039</i>--> </a>
                <?php }?>
              </div>
            </div>
            <div class="subfilter-div price-filter filter-row clearfix pb10">
              <div class="subfilter-left float-left">其他：</div>
              <div class="subfilter-right float-left  clearfix">
                <p class="subfilter-p" id="other" mon="type=other" alog-alias="tuan-filter-other" alog-group="tuan-filter-other"> <a class="newOrder cp dealClick absorb-click" href="#" mon="#content=支持WIFI" style="color: #333">支持WIFI</a> <a class="newOrder cp dealClick ml20 absorb-click" href="#" mon="#content=支持宽带" style="color: #333">支持宽带</a> </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="goods-hd-wrap w981 h44 mt20 goods-hd-wrap-new" mon="section=banner&amp;type=sortbar">
    <div class="goods-hd clearfix" alog-alias="tuan-sortbar" alog-group="tuan-sortbar">
      <div class="sort">
        <div class="sort-content">
        <a class="sort-default <?php if($orderfiled=='4'){echo "current";}?>" data-order="0" href="<?php echo site_url("{$list_url['order']}-order-4") ?>">默认</a>
        <a class="<?php if($orderfiled=='2'){echo "sort-des2";}else{echo "sort-des";}?> <?php if($orderfiled=='2'){echo "current";}?>" rel="nofollow" href="<?php  echo site_url("{$list_url['order']}-order-2"); ?>" title="点击按购买人数降序排序" mon="#content=购买人数" data-order="4">销量</a>
        <a class="<?php 
		if($orderfiled=='3'){ 
		echo "price3 current"; 
		} 
     elseif($orderfiled=='5'){
		echo "price2 current";
	 }
	else 
	{
		echo "price current";
			}
			?>" rel="nofollow" href="<?php if($orderfiled=='5'){ echo site_url("{$list_url['order']}-order-3");}else{echo site_url("{$list_url['order']}-order-5");} ?>" title="点击按价格升序排序" mon="#content=价格" data-order="1">价格</a>
        <a class="<?php if($orderfiled=='1'){echo "sort-des2";}else{echo "sort-des";}?> <?php if($orderfiled=='1'){echo "current";}?>" rel="nofollow" href="<?php echo site_url("{$list_url['order']}-order-1") ?>" title="点击按折扣升序排序" mon="#content=折扣" data-order="3">折扣</a> </div>
        <span class="vertical-separator"></span></div>
      <div class="page-bar hide" id="J-pagebar"><a class="page-prev" id="J-pageprev" href="javascript:void(0)" mon="#content=prev">上一页</a>
        <p class="page-num"><span class="page-cur">1</span>/<span class="page-sum">430</span></p>
        <a class="page-next" id="J-pagenext" href="javascript:void(0)" mon="#content=next">下一页</a></div>
    </div>
  </div>
  <div id="collectSuc" style="display:none;position: absolute; z-index: 99999; padding: 0px; margin: 0px;height:0;">
    <div class="popup_content alert"><span id="collectSuc_close"></span>
      <div class="popup_message">收藏成功</div>
      <div class="popup_panel">
        <p>查看&nbsp;&nbsp;<a target="_blank" href="#" mon="type=tg-popclick" class="gocollectman" id="goCollect">我的收藏&gt;&gt;</a></p>
      </div>
    </div>
    <span class="shadow"></span></div>
  <div class="tuan-goods div-984 goods-n" id="main-center" alog-alias="tuan-local-itemarea" alog-group="tuan-local-itemarea">
    <div id="tuan_statistics_1_all" alog-alias="tuan-local-itemlist" alog-group="tuan-local-itemlist">
      <div class="goods-wrap" id="content" mon="type=item&amp;pageindex=1&amp;order=0&amp;qa_test_type=2">
        <div class="goods-con clearfix goods">
          <?php
		$num=1;
		 foreach($newslist as $tuan){?>
          <div id="tuan_statistics_1_<?php echo $num; ?>" class="mb20 wt-good-item-n <?php if($num % 3==0){echo "wt-good-n-last";}else{ echo "mr19";}?>" > <a href="/tuangouinfo/<?php echo $tuan['tid'] ?>" style="display: block" target="_blank" >
            <div class="good-item-n-border"></div>
            </a>
            <div class="good-n-meta clearfix">
              <div class="good-n-img">
                <div class="good-indication"> </div>
                <a href="/tuangouinfo/<?php echo $tuan['tid'] ?>" style="display: block" target="_blank" > <img alt="<?php echo $tuan['title'].$tuan['description'] ?>" src="<?php echo $tuan['image'] ?>"> </a>
                <div class="good-loc clearfix">
                  <div class="good-loc-bg"></div>
                  <span class="opn"> 商圈：<?php echo character_limiter($tuan['range'],50) ?> </span> <span class="opa"> 地址：<?php echo $tuan['address'] ?> </span> </div>
              </div>
              <div class="good-n-title"> <a class="fcb" mon="#outsite=1&amp;content=title" href="/tuangouinfo/<?php echo $tuan['tid'] ?>"><?php echo $tuan['shortTitle'].$tuan['title'] ?></a> </div>
            </div>
            <div class="good-n-price">
              <div class="good-value"><small>&#165;</small><?php echo $tuan['price'] ?> </div>
              <div class="good-pre">原价： <span>&#165;<?php echo $tuan['value'] ?></span></div>
              <span class="good-rebate"><?php echo $tuan['rebate'] ?>折</span> </div>
            <div class="good-n-foot"> <a class="n-sitename" mon="#content=sitename" href="#" target="_blank" title="<?php echo $tuan['website'] ?>"> <?php echo $tuan['website'] ?> </a>
              <div class="n-bought"> <?php echo $tuan['bought'] ?>人购买 </div>
              <a class="favor favor-ico" href="javascript:void(0);" id="15190298">收藏</a> </div>
            <div class="msg clearfix"><a class="close-ico" href="javscript:void%280%29;"></a><b>收藏成功!</b>&nbsp;查看<a class="go-collectMan" href="" target="_blank">我的收藏</a></div>
          </div>
          <?php $num++;}?>
        </div>
      </div>
    </div>
    <div id="pagelist" class="wt-pagelist tang-pager" mon="type=paging" alog-alias="tuan-pagelist" alog-group="tuan-pagelist"> <?php echo $pagenav;?> </div>
  </div>
</div>
<div><a style="bottom: 142px;" class="common-code-big-ctn" id="common-code-big-ctn" href="#" target="_blank" hidefocus="true"><i class="common-code-close" id="common-code-close-btn" title="关闭"></i>扫一扫手机继续看<i class="common-code-big-img"><img src="<?php echo base_url();?>public/images/erweima.png" width="87" height="87" /></i></i></a></div>
<div class="groupon-backtop-wrapper"><a style="left:50%; margin-left:500px; bottom:87px;" href="#" id="groupon-backtop" title="返回顶部"></a></div>
<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>
</body>
</html>