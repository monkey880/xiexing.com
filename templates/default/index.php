<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $keywords_array['k_title'] ?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />

<meta name="description" content="<?php echo $keywords_array['k_description'] ?>" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

</head>

<body>

<DIV class=head_ad style="margin:0 auto; width:950px;">
	<DIV id=adv_forum_home_full></DIV>
</DIV>
<SCRIPT type=text/javascript src="<?php echo base_url();?>public/js/loadalladv.js"></SCRIPT>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

       <div class="main">
<div id="demo" style="overflow:hidden;height:20px;width:950px;">
<table cellpadding="0" cellspace="0" border="0">
<tr>
<td id="demo1"><table width="950" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
	  喜讯：史无前例，订7送一，订六送一，全国首推，不同城市不同酒店均可累计！
	  </td>
     </tr>
</table></td>
<td id="demo2"></td>
</tr>
</table>
</div>
<script>
var speed=30
var MyMar=setInterval(Marquee,speed)
demo2.innerHTML=demo1.innerHTML
demo.onmouseover=function() {clearInterval(MyMar)}
demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
function Marquee(){
if(demo2.offsetWidth-demo.scrollLeft<=0)
   demo.scrollLeft-=demo1.offsetWidth
else{
   demo.scrollLeft++
}
}
</script>
           <div class="in_search">

                <?php $this->load->view('modules/index/'.$layout[0][1]);?>

                <?php $this->load->view('modules/index/'.$layout[1][1]);?>

          </div>

         

           <div class="main_bottom">

              <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                   <?php $this->load->view('modules/index/'.$layout[2][1]);?>

                   <div class="clearfloat"></div>

                   <?php $this->load->view('modules/index/'.$layout[4][1]);?>

                   <div class="clearfloat"></div>

                   <?php $this->load->view('modules/index/'.$layout[6][1]);?>

                   <div class="clearfloat"></div>

                   <?php $this->load->view('modules/index/'.$layout[8][1]);?>

              </div>

              <div class="m_b_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
<?php $this->load->view('modules/index/'.$layout[7][1]);?>
                  <?php $this->load->view('modules/index/'.$layout[3][1]);?>

                  <?php $this->load->view('modules/index/'.$layout[5][1]);?>

                  

                  <?php $this->load->view('modules/index/'.$layout[9][1]);?>

              </div>

         </div>

         

       </div>

</div>

<?php $this->load->view('modules/index/'.$layout[10][1]);?>
<table width="955" cellspacing="0" cellpadding="0" border="0" bgcolor="#F5F5F5" align="center" style="margin-top:10px; border:#F5F5F5 1px solid;">
  <tbody><tr>
   
  </tr>
  <tr>
    <td style="padding:10px;"><table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr>
          <td width="50"><img src="<?php echo base_url();?>public/images/t1.gif" alt="订酒店，酒店预订，低价高返现"></td>
           <td><span class="col_org">低价高返现：</span>
            保证预订价格低于前台现付价，返现无需点评</td>
          <td width="50"><img src="http://www.xexing.com/public/images/t2.gif" alt="订酒店，酒店预订，订七天送一天"></td>
          <td><span class="col_org">订七送一：</span>
            累计预订七间夜并已入住赠送一天，连续预订六天并已入住赠送一天</td>
          <td width="50"><img src="http://www.xexing.com/public/images/t3.gif" alt="携行网订酒店，酒店预订，免费试住"></td>
          <td><span class="col_org">0元试住：</span>
            0元试住客房无门槛试住，真正免费住酒店，最多可提前十天申请预订</td>
          <td width="50"><img src="http://www.xexing.com/public/images/t4.gif" alt="携行网酒店预订领免费礼品"></td>
          <td><span class="col_org">免费礼品：</span>
           凡预订者皆有礼品，不需要积分兑换</td>
          <td width="50"><img src="http://www.xexing.com/public/images/t5.gif" alt="携行网酒店预订免费接送"></td>
          <td><span class="col_org">免费接送：</span>
            订酒店免费接送，限机场和火车站，待开通</td>
        </tr>
      </tbody></table></td>
  </tr>
</tbody></table>
<?php $this->load->view('modules/index/'.$layout[11][1]);?>

<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

</body>

</html> 