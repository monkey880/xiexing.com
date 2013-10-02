
<div class="bottom">
   <div class="bottom_nav">
       <ul>
         <li><a href="<?php echo base_url() ?>">网站首页</a>   | <a href="<?php echo site_url("/help/29") ?>">关于携行网</a> | <a href="<?php echo site_url("/help/40") ?>">六大优势</a> | <a href="<?php echo site_url("/help/34") ?>">关于订7送一</a> |  <a href="<?php echo site_url("/questions") ?>">帮助中心</a> | <a href="<?php echo site_url('/help/1')?>">联系我们</a> </li>
       </ul>
   </div>
   <div class="ilinks">
   <a href="#"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/links_01.jpg" width="82" height="30" /></a>
   <a href="#"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/links_02.jpg" width="82" height="30" /></a>
   <a href="#"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/links_03.jpg" width="82" height="30" /></a>
   <a href="#"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/links_05.jpg" width="82" height="30" /></a>
   <a href="#"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/links_06.jpg" width="82" height="30" /></a>
   </div>
   <div id="copyright" style="margin:5px;text-align:center;"><?php echo CFG_POWERBY?></div>
</div>
<?php
    if (CFG_STATCODE == '51啦|百度|google统计代码') {
        $statcode_css =  'style="display:none;"';   
    } else {
        $statcode_css = '';    
    }
?>
<div <?php echo $statcode_css ?>><?php echo CFG_STATCODE ?></div>
