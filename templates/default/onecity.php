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

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

       <div class="main">

           <div class="in_search">

                <?php $this->load->view('modules/cityinfo/'.$layout[0][1]);?>

                <?php $this->load->view('modules/cityinfo/'.$layout[1][1]);?>

          </div>

         

           <div class="main_bottom">

              <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                   <?php $this->load->view('modules/cityinfo/'.$layout[2][1]);?>

                   <div class="clearfloat"></div>

                   <?php $this->load->view('modules/cityinfo/'.$layout[4][1]);?>

                   <div class="clearfloat"></div>

                   <?php $this->load->view('modules/cityinfo/'.$layout[6][1]);?>

                   <div class="clearfloat"></div>

                   <?php $this->load->view('modules/cityinfo/'.$layout[8][1]);?>

              </div>

              <div class="m_b_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                  <?php $this->load->view('modules/cityinfo/'.$layout[3][1]);?>

                  <?php $this->load->view('modules/cityinfo/'.$layout[5][1]);?>

                  <?php $this->load->view('modules/cityinfo/'.$layout[7][1]);?>

                  <?php $this->load->view('modules/cityinfo/'.$layout[9][1]);?>

              </div>

         </div>

         

       </div>

</div>

<?php $this->load->view('modules/cityinfo/'.$layout[10][1]);?>

<?php $this->load->view('modules/cityinfo/'.$layout[11][1]);?>

<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

</body>

</html> 