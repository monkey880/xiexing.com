<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $keywords_array['k_title']?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords']?>" />

<meta name="description" content="<?php echo $keywords_array['k_description']?>" />

</head>



<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

       <div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy">展会新闻信息</span>

           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                    <div class="zhpd_top">

                       <h1><font class="f_b_f00">展会新闻</font><font style="color:#494949;">信息</font></h1>

                    </div>

                    <div class="zhxx_bottom">

                        <dl>

                            <dt><strong><?php echo $list['title'] ?></strong></dt>

                            <dd>

                                <ul>

                                   <li class="current"><strong>展会新闻类别：</strong></li>

                                   <li><strong><font class="blue"><?php echo $list['project'] ?></font></strong></li>

                                   <li class="current"><strong>展会新闻内容：</strong></li>

                                   <li><strong><font class="blue"><?php echo $list['content'] ?></font></strong></li>

                                </ul>

                            </dd>

                        </dl> 

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