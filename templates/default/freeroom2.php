<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<title><?php echo $metainfo['k_title']?></title>

<meta name="keywords" content="<?php echo $metainfo['k_keywords']?>" />

<meta name="description" content="<?php echo $metainfo['k_description']?>" />

<script src="<?php echo base_url();?>public/js/simplefoucs/simplefoucs.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/simplefoucs/simplefoucs_lrtk.css" type="text/css" rel="stylesheet" />
</head>



<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

<div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy">试住中心</span>

             
           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
                <div class="zxpd_top" style="border-bottom:solid #CCC 1px">

<h1><font class="f_b_f00"><?php if($type==2){echo "订七";}else {echo "订六";}?></font><font style="color:#494949;">送一</font></h1>

                    </div>
                <div class="zhu7 main-Box" style="padding:10px; border:none">
                
                <div >
                <h3 style="text-align:left; font-style:normal; font-size:18px; color:#F60"><?php if($type==2){echo "累计预订7间夜并入住赠送一间";}else {echo "连续预订六天并入住赠送一天";}?></h3>
  <div id="focus" style="border:solid #CCC 1px" >
    <ul>
      <li><a href="http://www.lanrentuku.com/" target="_blank">
        <img src="<?php echo base_url();?>public/js/simplefoucs/images/bn1.jpg" alt="" height="300" /></a></li>
      <li><a href="http://www.lanrentuku.com/" target="_blank">
        <img src="<?php echo base_url();?>public/js/simplefoucs/images/bn2.jpg" alt="" height="300" /></a></li>
      <li><a href="http://www.lanrentuku.com/" target="_blank">
        <img src="<?php echo base_url();?>public/js/simplefoucs/images/bn3.jpg" alt="" height="300"  /></a></li>
      <li><a href="http://www.lanrentuku.com/" target="_blank">
        <img src="<?php echo base_url();?>public/js/simplefoucs/images/bn4.jpg" alt="" height="300"  /></a></li>
      </ul>
  </div> 
 
  <div class="main main-text">
 <div id="J_Property" class="try-property start" itemlifecycle="3">
    	
    	<ul class="try-meta">
    	   <li class="first">价格 : <span class="price"><i>￥</i><em>0</em></span><i class="split"></i></li>
    	   <li class="second">城市 : <em>全国</em></li>
    	</ul>
     <div class="try-buy">
       <div class="try-buy-wrap">
           <div qa_type="2" id="J_Question" class="question">
          <form action="/ebook/index/?" method="get"> 
          <input name="type" type="hidden" value="<?php echo $type; ?>" />
         <?php if($type==2){echo "您是否已通过携行累计入住7日间？";}else {echo "您是否已通过携行连续入住6日间？";}?> <br />
是<input name="iszhu7" type="radio" value="1" /> 否<input name="iszhu7" type="radio" value="0" /></div>
           <div id="J_Answer" class="answer"><input  type="submit" value="免费领取" style="width:95px; height:60px; background-color:#FF6600; color:#FFF; font-size:16px"></form>
       </div> 
           </div></div>
		   <div class="condition"><span class="tip">领取条件：</span>
									1. 通过携行网预定并累计入住7日间<br>
									2. <?php if($type==2){echo "不同城市不同酒店均可累计";}else {echo "不同城市不同酒店均可累计";}?>
	              </div>
       
    
      <div class="try-state">
    	<h3>最近已赠送<em><?php echo $sqnum2 ?></em>日间，快来领取吧！</h3>
       
    </div>
    </div>
</div>
 <div class="clear"></div>
 </div></div>
  <div class="jianju10"></div>
  <img src="<?php echo base_url();?>public/images/sz<?php echo $type; ?>.jpg" width="720" height="63" />
<div class="jianju10"></div>


                    <div class="zhpd_bottom">

<div class="" >

   <div class="jdfx">
          <div class="hotinfo_top">
            <ul>
              <li class="current" id="freeroom_sq_tab"><a href="javascript:void(0)" >领取记录</a></li>
              <li id="freeroom_sz_tab"><a href="javascript:void(0)" >入住记录</a></li>
            </ul>
          </div>
          <div class="jdfx_bottom">
          
          <div id="freeroom_sq_info" class="hotinfo_bottom">
              <div class="dp_b_infoleft">
  <?php  
  
    $pattern = "/(1\d{1,2})\d\d(\d{0,2})/";
$replacement = "\$1****\$4";

  if (!empty($hotelorder)){ ?>
                <?php foreach ($hotelorder as $key=>$val){ ?>
                <dl style="background-position:-1396px -50px">
                  <dt> <span><img src="<?php echo base_url();?>public/images/zhu7<?php echo $type; ?>.gif" width="66" height="55" /></span> <span><font class="f_b2_f00"><?php echo preg_replace($pattern,$replacement,$val['phone']) ?></font></span> </dt>
                  <dd>
                    <ul>
                      
                        <li>
                        <div class="bt"> 我领取了一天赠送客房<span class="right">领取时间：<?php echo date("Y年m月d日H:i:s",$val['addtime']) ?></span><span><?php echo $val['comment_pic_text'] ?></span> </div>
                      </li>
                      <li>
                        <div class="dp_nr">
                          <div class="jiao"></div>
                          <div class="xinxi"><?php if($type==2){echo "你是否累计住了七天？ 答：是";}else{ echo "你是否连续住了六天？ 答：是";} ?></div>
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
                  <dt> <span><img src="<?php echo base_url();?>public/images/zhu7<?php echo $type; ?>.gif" width="66" height="55" /></span> <span><font class="f_b2_f00"><?php echo preg_replace($pattern,$replacement,$val['phone']) ?></font></span> </dt>
                  <dd>
                    <ul>
                      
                      <li>
                        <div class="bt"> 我已领取，于<?php echo date("Y年m月d日",$val['CheckInDate']) ?>入住<span class="right">入住时间：<?php echo date("Y年m月d日",$val['CheckInDate']) ?></span><span><?php echo $val['comment_pic_text'] ?></span> </div>
                      </li>
                      <li>
                        <div class="dp_nr">
                          <div class="jiao"></div>
                          <div class="xinxi"><?php if($type==2){echo "你是否累计住了七天？ 答：是";}else{ echo "你是否连续住了六天？ 答：是";} ?></div>
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
  </div>
      <div class="fy">

		                              <?php echo $pagenav;?>

	     </div>
              
                    
                    
                    
                         </div>

                    </div>


                <div class="m_b_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

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

<script type="text/javascript">
	$("#freeroom_sq_tab").click(function(){divclass3($(this),'freeroom_sq_info');}) ;
	$("#freeroom_sz_tab").click(function(){divclass3($(this),'freeroom_sz_info');}) ;
function divclass3(divclass,divid){

    $('#freeroom_sq_tab').removeClass(); 

    $('#freeroom_sz_tab').removeClass();

    $(divclass).addClass('current');

    

    $("#freeroom_sq_info").hide();

    $("#freeroom_sz_info").hide();

    $("#"+divid).show();   

}


</script>


</body>

</html>