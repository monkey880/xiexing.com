<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $metainfo['k_title']?></title>

<meta name="keywords" content="<?php echo $metainfo['k_keywords']?>" />

<meta name="description" content="<?php echo $metainfo['k_description']?>" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

</head>



<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

<div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

               

                <span class="wzdt"></span><span class="sy"><?php echo $info['title']?></span>

           </div>

           

           

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                  
                    <div class="zxxx_bottom">

                       <dl>

                           

                           <dd><?php echo $info['content']?></dd>

                       </dl>    

                  </div>

                     

                    

                </div>

                <div class="m_b_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>" style="width:180px">

                    <?php $this->load->view('modules/help.php');?>

                   

                </div>

           

           

           </div>

           

           

       </div>       

</div>

<div class="inbz"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/inbz.jpg" width="950" height="57" /></div>

<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);

?>

</body>

</html>