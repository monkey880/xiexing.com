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

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy">会馆/展馆</span>

           </div>

           <!--载入搜索内容-->

           <?php $this->load->view('inc/search');?>

           <div class="db_box">

                <div class="d_b_top">

                     <h1><font style="color:#515151;">全国城市</font><font class="f_b_f00">地标</font></h1>

                </div>

                <div class="d_b_bottom">

                     <div class="db_hot">

                          <span class="hot_bg">热门城市</span>

                          <span class="citydb">

                              <ul>

                                  <?php foreach ($hotCityList as $hotC_val){ ?><li><a href="<?php echo site_url("/ehc/{$hotC_val['pid']}-{$hotC_val['cid']}") ?>" title="<?php echo $hotC_val['cName'] ?>"><?php echo $hotC_val['cName'] ?></a></li><?php } ?> 

                              </ul>

                          </span>

                     </div>

                     <div class="db_plate">

                         <div class="d_p_top">请选择省份</div>

                         <div class="d_p_bottom">

                             <?php foreach ($pArray as $p_val){ ?>  

                             <dl class="<?php echo $p_val['class'] ?>">

                                <dt><?php echo $p_val['abcd'] ?></dt>

                                <dd><a href="<?php echo site_url("/ehc/{$p_val['province_id']}") ?>" title="<?php echo $p_val['province_name'] ?>"><?php echo $p_val['province_name'] ?></a></dd>

                             </dl>

                             <?php } ?>

                         </div>

                     </div>

                     <div class="db_plate">

                         <div class="d_p_top">请选择城市</div>

                         <div class="d_p_bottom">

                             <?php foreach ($cArray as $c_val){ ?>  

                             <dl class="<?php echo $c_val['class'] ?>">

                                <dt><?php echo $c_val['abcd'] ?></dt>

                                <dd><a href="<?php echo site_url("/ehc/{$c_val['pid']}-{$c_val['cid']}") ?>" title="<?php echo $c_val['cNameTitle'] ?>"><?php echo $c_val['cName'] ?></a></dd>

                             </dl>

                             <?php } ?>

                         </div>

                     </div>

                     <div class="db_plate" id="labledetail_div">

                         <div class="d_p_top"><?php echo $current['cName'] ?>展馆附近酒店</div>

                         <div class="dbfl">

                             <ul>

                                <?php if(!empty($ehcList[0])){ ?>

                                <?php foreach ($ehcList[0] as $ehc_val){ ?>  

                                <li ><a href="<?php echo site_url("/hotellist/cityid-{$ehc_val['ecityid']}-keyid-{$ehc_val['id']}-pinyin-{$ehc_val['pinyin']}") ?>" title="<?php echo $ehc_val['name'][0] ?>"><?php echo $ehc_val['name'][0] ?></a></li>

                                <?php } ?>

                                <?php }else{echo "抱歉该城市没有展馆信息";} ?>

                             </ul>

                         </div>

                         <div class="fy">

                            <?php echo $ehcList[1] ?>        

                         </div>

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

<script>

    $(function(){

        if("<?php echo $scroll ?>" > 0){

            comment("labledetail_div");    

        }

    })

    function comment(divId){

        $('html').animate({scrollTop:$("#"+divId).offset().top}, 'slow');

        $('body').animate({scrollTop:$("#"+divId).offset().top}, 'slow'); 

    } 

</script>

</body>

</html>