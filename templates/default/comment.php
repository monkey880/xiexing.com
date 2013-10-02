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

                    <div class="dp_b_top"><h1>全部<font class="f_b_f00">点评</font></h1></div>

                    <div class="dp_b_bottom">

                    <div class="dp_b_infoleft">

                             	<?php 

                    			 	if (!empty($list)) {

                    			 		foreach ($list as $key=>$val) {	

                    			 ?>	

                             <div class="jdna"><span class="right"><font class="f_b_f00"></font></span><span class="jdname"><a href="<?php echo site_url("/hotelinfo/{$val['hotelid']}") ?>"><?php echo $val['hotelname'] ?></a></span></div>

                             <dl>

                                  <dt>

                                    <span><img src="<?php echo base_url();?>public/images/<?php echo $val['comment_pic'] ?>" width="66" height="55" /></span>

                                    <span><font class="f_b2_f00"><?php echo $val['username'] ?></font></span>

                                </dt>

                                  <dd>

                                   <div class="bqleft">

                                       <?php if ($val['yinxiang_show'] != ''){  foreach ($val['yinxiang_show'] as $key1=>$val1){ ?>   

                                       	<span class="note<?php echo $key1+1 ?>"><em><?php echo $val1 ?></em></span>

                                   	   <?php }} ?>

                                    </div><div class="bt"><span class="right">点评时间：<?php  ?><?php echo date('Y年m月d日 H:i:s',$val['time']) ?></span><span><?php echo $val['comment_pic_text'] ?></span>

                                   </div>

                                   <div class="dp_nr">

                                       <div class="jiao"></div>

                                       <div class="xinxi"><?php echo $val['content'] ?></div>

                                   </div>

                                 </dd>

                             </dl>

                             	<?php 	

                    			 		}

                    			 	} else {

                    			 		echo "<center class='warning1'>未找到{$cityname}的点评!</center>";

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