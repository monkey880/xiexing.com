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
                <div class="zxpd_top">

<h1><font class="f_b_f00">订七</font><font style="color:#494949;">送一</font></h1>

                    </div>
                <div class="zhu7 main-Box" style="padding:10px">
                
                <div >
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
  <table width="100%" border="0" cellpadding="3" >
  <tr>
    <td colspan="2">城市&nbsp;：全国</td>
  </tr>
  <tr>
    <td colspan="2">价格：0元</td>
  </tr>
  <tr>
    <td colspan="2">您是否已累计住7天？ 是
      <input type="radio" name="radio" id="radio" value="radio" />
      <label for="radio"></label>
      <label for="checkbox">否
        <input type="radio" name="radio2" id="radio2" value="radio2" />
      </label>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table style="background:url(<?php echo base_url();?>public/images/z7_bg.gif) none bottom" width="98%" border="0" align="center">
      <tr>
    <td bgcolor="#CCCCCC" style="width:60px">入住日期：
      <label for="textfield"></label></td>
    <td bgcolor="#CCCCCC"><input name="textfield" type="text" id="textfield" size="10" /></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" >姓名：      </td>
    <td bgcolor="#CCCCCC"  ><input name="textfield2" type="text" id="textfield2" size="10" /></td>
    </tr>
  <tr>
    <td bgcolor="#CCCCCC" ><span style="width:150px">手机：</span></td>
    <td bgcolor="#CCCCCC"  ><span style="width:150px">
      <input name="textfield3" type="text" id="textfield3" size="10" />
    </span></td>
    </tr>
    </table></td>
  </tr>
  
  </table>

</div>
 <div class="clear"></div>
 </div></div>
  <div class="jianju10"></div>

                
                
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
                        <div class="bt"> 我获得了一天赠送客房<span class="right">领取时间：<?php echo date("Y年m月d日H:i:s",$val['CheckInDate']) ?></span><span><?php echo $val['comment_pic_text'] ?></span> </div>
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
  
  
  
  if (!empty($hotelorder)){ ?>
                <?php foreach ($hotelorder as $key=>$val){ ?>
                <dl style="background-position:-1396px -50px">
                  <dt> <span><img src="<?php echo base_url();?>public/images/zhu7<?php echo $type; ?>.gif" width="66" height="55" /></span> <span><font class="f_b2_f00"><?php echo preg_replace($pattern,$replacement,$val['phone']) ?></font></span> </dt>
                  <dd>
                    <ul>
                      
                      <li>
                        <div class="bt"> 我获得了一天赠送客房<span class="right">入住时间：<?php echo date("Y年m月d日H:i:s",$val['CheckInDate']+3600*24) ?></span><span><?php echo $val['comment_pic_text'] ?></span> </div>
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