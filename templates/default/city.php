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

<script>

    function abcd(abcd){

        var abcd = abcd ;

        comment(abcd);

    }   

    function comment(divId){

        $('html').animate({scrollTop:$("#"+divId).offset().top}, 'slow');

        $('body').animate({scrollTop:$("#"+divId).offset().top}, 'slow'); 

    }

</script>

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

           <div class="db_box">

                <div class="c_j_top">

                     <h1><font style="color:#515151;">全国城市</font><font class="f_b_f00">酒店</font></h1>

                </div>

                <div class="d_b_bottom">

                     <div class="db_hot">

                          <span class="hot_bg">热门城市</span>

                          <span class="citydb">

                              <ul>

                                  <?php foreach($hotCityList as $val){ ?>

                                  <li><a href="<?php echo site_url("/onecity/{$val['cid']}") ?>" title="<?php echo $val['cName'] ?>酒店"><?php echo $val['cName'] ?></a></li>

                                  <?php } ?>

                              </ul>

                          </span>

                     </div>

                     <div class="db_plate">

                         <div class="d_p_top">快速选择城市</div>

                         <div class="c_j_bottom">

                             <ul>

                             <?php foreach ($cityArray as $cityArray_key => $cityArray_val){ ?>                      

                             <li class="current" onclick="abcd('<?php echo $cityArray_key ?>')"><?php echo $cityArray_key ?></li>

                             <?php } ?>    

                             </ul> 

                         </div>

                     </div>

                     <div class="db_pu"></div>

                     <div class="ci_jd">

                         <?php foreach ($cityArray as $cityArray_key => $cityArray_val){ ?>

                         <dl id="<?php echo $cityArray_key ?>">

                             <dt><?php echo $cityArray_key ?></dt>

                             <dd>

                                <ul>

                                   <?php foreach ($cityArray_val as $val){ ?>

                                   <li><a href="<?php echo site_url("/onecity/{$val['cid']}") ?>" title="<?php echo $val['cName'] ?>酒店"><?php echo $val['cName'] ?>酒店</a></li>

                                   <?php } ?> 

                                </ul>

                             </dd>

                         </dl>

                         <?php } ?>

                     </div>

                     

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