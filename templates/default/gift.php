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

                <span class="wzdt"></span><span class="sy">免费礼品</span>

             
           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                    <div class="zxpd_top">

                       <h1><font class="f_b_f00">免费</font><font style="color:#494949;">礼品</font></h1>

                    </div>

                    <div class="zhpd_bottom">

                          
					
                    
                    <ul class="gift_list" >

    <?php 

        foreach ($freeroomlist as $key=>$val){

    ?>
        <li><a class="pic" href="<?php  echo site_url("/gift/info/{$val['ProductID']}") ?>" title="<?php echo $val['ProductName']; ?>"><img src="/public/uploadfiles/upload/<?php echo $val['ProductThumb']  ?>" width="160" height="160" alt="<?php echo $val['ProductName']; ?>" /></a>

           <a class="title" href="<?php  echo site_url("/gift/info/{$val['ProductID']}") ?>" title="<?php echo $val['ProductName']; ?>"><?php echo $val['ProductName']  ?></a>

           <span class="price"><?php echo $val['Price']; ?>元</span>
           <span class="btn"><a href="<?php  echo site_url("/gift/get/{$val['ProductID']}") ?>">免费申领</a></span>
</li>
            <?php } ?>

      

    </ul>
 

  </div>
      <div class="fy">

		                              <?php echo $pagenav;?>

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