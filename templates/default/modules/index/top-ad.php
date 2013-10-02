<?php 

    $ci = & get_instance();

	$ci->load->model('model_ad');

	$adNameArr = "'index_focus_1','index_focus_2','index_focus_3','index_focus_4','index_top_5'";

    $ad = $ci->model_ad->getAdListByAd_cid($adNameArr);

?>

<div class="i_s_right">

<?php foreach ($ad as $val) {  
	$imglist.='<item><img>'.rtrim(base_url(),'/').$val['ad_uploadfile'].'</img><url>'.$val['ad_link'].'</url></item>';
	

	 } ?> 
<div class="main_side">
          <div class="banner_img"> 
            <script type="text/javascript" src="<?php echo base_url();?>public/js/swfobject.js"></script>
            <object width="650" height="307" type="application/x-shockwave-flash" data="<?php echo base_url();?>public/www/blue/images/focuse.swf" id="swfContent" style="visibility: visible;">
              <param name="menu" value="false">
              <param name="wmode" value="opaque">
              <param name="flashvars" value="xmlData=<list><?php echo $imglist; ?></list>">
            </object>
            <script type="text/javascript">
	var xmlData="<list>"
	<?php foreach ($ad as $val) { ?>
		xmlData=xmlData+"<item><img><?php echo rtrim(base_url(),'/').$val['ad_uploadfile']; ?></img><url><?php echo $val['ad_link'] ?></url></item>";
		<?php }?>
	   xmlData=xmlData+"</list>";
	var flashvars = {xmlData:xmlData};
	var params = {menu:false,wmode:"opaque"};
	var attributes = {};
	swfobject.embedSWF("<?php echo base_url();?>public/www/blue/images/focuse.swf", "swfContent", "650", "307", "9","expressInstall.swf", flashvars, params, attributes);
	</script> 
          </div>
          <div class="index_moneyf">
            <div class="fxj_link"><a target="_blank" href="#">返现金,送客房</a></div>
            <div class="money_but">
              <ul class="money_butul">
               
                <li><a href="/help/42">如何获得返现>></a></li>
                <li><a href="/help/43">如何提取现金>></a></li>
				<li style="width:200px;"><a href="/help/44">如何获得赠送一天客房>></a></li>
              </ul>
            </div>
            <div class="marquee"> 
              <script language="javascript">
	var marqueeContent=new Array();
			marqueeContent[0]='<p class=nav_marquee>139091****在1分钟前预订了<a href=/hotelinfo/18852 target=_blank>三亚君澜度假酒店</a>可获得112元现金</p>';
	marqueeContent[1]='<p class=nav_marquee>139893****在1分钟前预订了<a href=/hotelinfo/25907 target=_blank>上海瑞金宾馆太原别墅</a>可获得54元现金</p>';
	marqueeContent[2]='<p class=nav_marquee>138905****在1分钟前预订了<a href=/hotelinfo/34103 target="_blank">青岛塞纳河国际商务会馆</a>可获得23元现金</p>';
	marqueeContent[3]='<p class=nav_marquee>186058****在1分钟前预订了<a href=/hotelinfo/32776 target=_blank>杭州西湖饭店</a>可获得17元现金</p>';
	marqueeContent[4]='<p class=nav_marquee>186880****在1分钟前预订了<a href=/hotelinfo/46855 target=_blank>昆明祺阳商务酒店</a>可获得15元现金</p>';
	marqueeContent[5]='<p class=nav_marquee>158162****在2分钟前预订了<a href=/hotelinfo/112996 target=_blank>北京如家旅馆</a>可获得9元现金</p>';
	marqueeContent[6]='<p class=nav_marquee>150387****在2分钟前预订了<a href=/hotelinfo/113055 target=_blank>北京鑫福海宾馆</a>可获得15元现金</p>';
	marqueeContent[7]='<p class=nav_marquee>135887****在3分钟前预订了<a href=/hotelinfo/10710 target=_blank>景德镇文苑大酒店</a>可获得16元现金</p>';
	var marqueeDelay=2000;
	var marqueeHeight=20;  
</script> 
              <script src="<?php echo base_url();?>public/js/gundong.js" language="javascript"></script>
              <div onmouseout="marqueeInterval[0]=setInterval('startMarquee()',marqueeDelay)" onmouseover="clearInterval(marqueeInterval[0])" style="overflow:hidden;height:20px" id="marqueeBox">
               
               
              </div>
               </div>
			   
             </div>
        </div>

  
</div>

