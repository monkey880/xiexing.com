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

                <span class="wzdt"></span><span class="sy">订七送一</span>

             
           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
              
 <div class="jianju10"></div>
                <div class="zxpd_top">

<h1 style="width:340px; float:left"><font class="f_b_f00">订七</font><font style="color:#494949;">送一</font></h1>
<h1 class="z7s1" style="width:300px; float:left"><font class="f_b_f00">订六</font><font style="color:#494949;">送一</font></h1>
                    </div>
                <div class="zhu7 main-Box tjbotm" style="padding-bottom:0">
                
                <div class="tjplate" style="margin-left:28px; margin-top:18px">

       <dl>

        <dt><a href="/freeroominfo/zengsong/2" title="超级优惠房"><img src="<?php echo base_url();?>public/images/z1.jpg" width="289" height="112" alt="超级优惠房" /></a></dt>

        

      </dl>

       <div class="yinying"></div>
       <div class="btn"><h3>累计预订7间夜并入住赠送一间</h3><a href="/freeroominfo/zengsong/2"><img src="<?php echo base_url();?>public/images/show.gif" width="85" height="32" /></a>
       </div>
                </div>
                <div style="width:1px; float:left; background-color:#D7D7D7; margin-left:14px; margin-right:14px; height: 219px;"></div>
<div class="tjplate" style="margin-left:0px; margin-top:18px">
  
  <dl>

        <dt><a href="/freeroominfo/zengsong/3" title="超级优惠房"><img src="<?php echo base_url();?>public/images/z2.jpg" width="289" height="112" alt="超级优惠房" /></a></dt>

        

      </dl>

       <div class="yinying"></div>
       <div class="btn"><h3>连续预订六天并入住赠送一天</h3><a href="/freeroominfo/zengsong/3"><img src="<?php echo base_url();?>public/images/show.gif" width="85" height="32" /></a>
       </div>
              </div>
                </div>
 
                 
              
                <div class="jianju10"></div>
                <div class="jianju10"></div>
<div class="zxpd_top">

<h1><font class="f_b_f00">试住</font><font style="color:#494949;">中心</font></h1>

                    </div>

                    <div class="zhpd_bottom">

<div class="tjbotm" >

    <?php 

        foreach ($freeroomlist as $key=>$val){

    ?>

    <div class="tjplate">

       <dl>

        <dt><a href="<?php  echo site_url("/freeroominfo/".$val['fid']) ?>" title="<?php echo $val['R_Title']; ?>"><img src="<?php if(!strchr($val['R_HotelID'],"A")){ echo "http://p.zhuna.cn/";}?><?php echo $val['R_Pic']  ?>" width="147" height="112" alt="<?php echo $val['R_Title']; ?>" /></a></dt>

        <dd>

          <ul>

            <li class="tjbt"><a href="<?php  echo site_url("/freeroominfo/".$val['fid']) ?>" title="<?php echo $val['R_Title']; ?>"><?php echo $val['R_Title']  ?></a></li>

            <li>酒店：<?php echo $val['R_HotelName']  ?></li>

            <li>申请时间：<font class="f_b1_f00"><?php echo date('m-d',$val['R_Checkintime']-950400).'至'.date('m-d',$val['R_Checkintime']-86400)  ?></font></li>

            <li>入住日期：<font class="f_b1_f00"><?php echo date('Y-m-d ',$val['R_Checkintime'])  ?></font></li>

            <li>位置：<?php echo $val['R_City'].'，'.$val['R_Area']  ?></li>

          </ul>

        </dd>

      </dl>

       <div class="yinying"></div>

    </div>

    <?php } ?>

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

</body>

</html>