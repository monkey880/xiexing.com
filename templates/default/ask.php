<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $keywords_array['k_title'] ?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />

<meta name="description" content="><?php echo $keywords_array['k_description'] ?>" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

       

       <div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy">城市酒店</span>

           </div>

           <!--载入搜索内容-->

           <?php $this->load->view('inc/search');?>

           <div class="dp_wd">

               <div class="dp_box">

                    <div class="wd_b_top"><h1>全部<font class="f_b_f00">问答</font></h1></div>

                    <div class="dp_b_bottom">

                    <div class="wd_b_infoleft">

                    			 <?php 

                    			 	if (!empty($list)) {

                    			 		$i = 1 ;

                    			 		foreach ($list as $key=>$val) {	

                    			 ?>	

                                 <dl onmouseover="this.style.backgroundColor='#f7f7f7'" onmouseout="this.style.backgroundColor='#ffffff'">

                                   <dt><span class="f_b1_f00"><?php if ($i<10) { echo 0; } ?><?php echo $i ?></span></dt>

                                   <dd>

                                       <ul>

                                          <li class="wdbt">

                                          	<?php if(!empty($val['hotelname'])) { ?>

                                          	<a href="<?php echo site_url("/hotelinfo/{$val['hotelid']}") ?>"><?php echo $val['hotelname'] ?></a>

					                      	<?php } else { ?>

					                      	<a href="javascript:void(0)"><?php echo CFG_WEBNAME ?></a>

					                      	<?php } ?>

                                          </li>

										  <li><font class="ql1"><?php echo $val['question'] ?></font></li>

										  <li>来自于：  <img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/wd_img1.gif" width="10" height="12" /> <?php echo $val['username'] ?>   <?php echo date('Y年m月d日 H:i:s',$val['time']) ?></li>  

										  <li class="anwser"><font class="f_999">回答：</font><?php echo $val['answercontent'] ?></li>

                                       </ul>

                                   </dd>

                                 </dl>

                                 <?php 

                    			 			$i++;

                    			 		}

                    			 	} else {

                    			 		echo "<center class='warning1'>未找到{$cityname}的问答!</center>";

                    			 	}

		                         ?>

		                         <div class="fy">

                                 <?php echo $page ?>

		                         </div>

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