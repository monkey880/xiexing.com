<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $keywords_array['k_title']?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords']?>" />

<meta name="description" content="<?php echo $keywords_array['k_description']?>" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

</head>



<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

       <div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy"><a href="<?php  echo site_url("/expo") ?>">展会频道</a></span>

                <span class="wzdt"></span><span class="sy"><a href="<?php  echo site_url("/expo/1-$cityid-1") ?>"><?php echo $cityname ?>展会</a></span>

                <span class="wzdt"></span><span class="sy"><?php echo $now_exh_list['exhname'] ?></span>

           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                    <div class="zhpd_top">

                       <h1><font class="f_b_f00">展会</font><font style="color:#494949;">信息</font></h1>

                    </div>

                    <div class="zhxx_bottom">

                        <dl>

                            <dt><strong><?php echo $now_exh_list['exhname'] ?></strong></dt>

                            <dd>

                                <ul>

                                   <li class="current"><strong>展会类别：</strong></li>

                                   <li><strong><font class="blue"><?php echo $now_exh_list['exhmtrade'] ?></font></strong></li>

                                   <li class="current"><strong>展会时间：</strong></li>

                                   <li><?php echo date("Y年m月d日",$now_exh_list['exhbtime']); ?>到<?php echo date("Y年m月d日",$now_exh_list['exhetime']); ?></li>

                                   <li class="current"><strong>主办单位：</strong></li>

                                   <li><strong><font class="blue"><?php echo $now_exh_list['exhorginfo'] ?></font></strong></li>

                                   <li class="current"><strong>地点电话：</strong></li>

                                   <li><?php echo $now_exh_list['exhlinkinfo'] ?></li>

                                   <li class="current"><strong>展会内容：</strong></li>

                                   <li><?php echo $now_exh_list['exhdetail'] ?></li>

                                </ul>

                            </dd>

                        </dl> 

                    </div>

                    <div class="next_zh">

                       <div class="nx_zh">

                           <span>上一篇：<?php if ($nest_up_exh_list['upexpo'] != '') {?><a href="<?php  echo site_url("/expoinfo/{$nest_up_exh_list['upexpo']['exhid']}") ?>"><?php echo $nest_up_exh_list['upexpo']['exhname'] ?></a><?php }else {echo '没有了:('; }?></span>

                           <span>下一篇：<?php if ($nest_up_exh_list['nextexpo'] != '') {?><a href="<?php  echo site_url("/expoinfo/{$nest_up_exh_list['nextexpo']['exhid']}") ?>  "><?php echo $nest_up_exh_list['nextexpo']['exhname'] ?></a><?php }else {echo '没有了:('; }?></span>

                       </div>

                    </div> 

                    <div class="hot_jd">

                        <div class="h_j_top"><strong><?php echo $cityname ?>热门酒店</strong><span><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}") ?>">更多>></a></span>

                        </div>

                        <div class="h_j_bottom">

                            <?php 

                                $ci = & get_instance();

                                $ci->load->model('model_common');

                                

                                $hotHotel = $ci->model_common->getWelcomeHotel($cityid);

                                $hotHotelShow = array_slice($hotHotel,0,2) ;

                                foreach ($hotHotelShow as $key=>$val){

                             ?>

                            <dl class="rmjd">

                            <div class="h_j_plate"><strong><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName']  ?>"><?php echo $val['HotelName']  ?></a></strong><img src="<?php echo base_url();?>public/www/blue/images/xj<?php echo $this->tool->hotelranknamenum ( $val ['xingji'] ); ?>.gif" width="86" height="16" /> </div>

                            <div class="h_p_bottom">

                                 <dl>

                                    <dt><span><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>"><img src="<?php echo $val['Picture']  ?>" width="134" height="100" /></a></span><span class="yy"></span></dt>

                                    <dd>

                                        <ul>

                                            <?php if(trim($val['cbd']) != ''){ ?><li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>"><?php echo $val['cbd'] ?></a>附近</li><?php } ?>

                                            <li>最低<font class="f_b1_f00"><?php echo $val['min_jiage']  ?>元</font>起订</li>

                                            <li><?php echo $val['Address'] ?></li>

                                        </ul>

                                    </dd>

                                 </dl>

                            </div>

                            </dl>

                            <?php } ?>

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