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

</head>



<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

<div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy">资讯频道</span>

                <?php if ($newclass != 0) { ?>

                <span class="wzdt"></span><span class="sy"><?php echo $newsclassName ?></span>	

                <?php } ?>

           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                    <div class="zxpd_top"><font class="f_right">新闻共<font class="f_b1_f00"><?php echo $newscount ;?></font>篇<font class="f_b1_f00"></font></font>

                       <h1><font class="f_b_f00">资讯</font><font style="color:#494949;">频道</font></h1>

                    </div>

                    <div class="zhpd_bottom">

                          <div class="zh_plate">

                             <div class="zhpd_dh">

                                 <ul>

                                     <li <?php if($this->uri->segment(2) == 0){ ?>class="current"<?php } ?>><a href="<?php  echo site_url("news/0-$newclass-1") ?>">全部资讯</a></li>

                                     <li <?php if($this->uri->segment(2) == 1){ ?>class="current"<?php } ?>><a href="<?php  echo site_url("news/1-$newclass-1") ?>">最新资讯</a></li>

                                     <li <?php if($this->uri->segment(2) == 2){ ?>class="current"<?php } ?>><a href="<?php  echo site_url("news/2-$newclass-1") ?>">热门资讯</a></li>

                                 </ul>

                             </div>

                             <div class="zxlist">

                             <ul>

                             <?php if (!empty($newslist)) { ?>	

                             <?php foreach ($newslist as $news) { ?>

                                <li title="<?php echo $news['title'] ;?>" onmouseover="this.style.backgroundColor='#f8f8f8'" onmouseout="this.style.backgroundColor='#ffffff'"><span class="f_b2_f00"><?php echo date('Y-m-d',$news['time'] );?></span><a href="<?php echo site_url('newsinfo/'.$news['aid']);?>"><?php echo $news['title'] ;?></a></li>

                             <?php }} else { echo "<center class='warning1'>暂无{$newsclassName}资讯!</center>"; }  ?>

                             </ul>     

	                            <div class="fy">

		                              <?php echo $pagenav;?>

	                            </div>

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