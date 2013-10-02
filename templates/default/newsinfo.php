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

                <span class="wzdt"></span><span class="sy"><a href="<?php  echo site_url("/news") ?>">资讯频道</a></span>

                <span class="wzdt"></span><span class="sy"><?php echo $info['title']?></span>

           </div>

           

           

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                    <div class="zxpd_top">

                       <h1><font class="f_b_f00">资讯</font><font style="color:#494949;">信息</font></h1>

                    </div>

                    <div class="zxxx_bottom">

                       <dl>

                           <dt><strong><?php echo $info['title']?></strong>

</dt>

                           <dd class="wzly">作者：<?php echo $info['author']?>  发布时间：<font><?php echo date('Y-m-d',$info['time'])?></font>  点击数：<?php echo $info['view_num']?></dd>

                           <dd><?php echo $info['content']?></dd>

                       </dl>    

                  </div>

                    <div class="next_zh">

                       <div class="nx_zh">

                           <span>上一篇：<?php if (count($prenews) > 0) {?><a href="<?php  echo site_url("/newsinfo/{$prenews['aid']}") ?>" title="<?php echo $prenews['title']?>"><?php echo $prenews['title']?></a><?php }else {echo '没有了:('; }?></span>

                           <span>下一篇：<?php if (count($nextnews) > 0) {?><a href="<?php  echo site_url("/newsinfo/{$nextnews['aid']}") ?>" title="<?php echo $nextnews['title']?>"><?php echo $nextnews['title']?> </a><?php }else {echo '没有了:('; }?></span>

                       </div>

                    </div> 

                    <div class="hot_jd">

                        <div class="h_j_top"><strong><?php echo $cityname ?>热门酒店</strong><span><a href="<?php  echo site_url("/hotellist/cityid-$cityid") ?>">更多>></a></span>

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

                            <div class="h_j_plate"><strong><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName']  ?></a></strong><img src="<?php echo base_url();?>public/www/blue/images/xj<?php echo $this->tool->hotelranknamenum ( $val ['xingji'] ); ?>.gif" width="86" height="16" /> </div>

                            <div class="h_p_bottom">

                                 <dl>

                                    <dt><span><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><img src="<?php echo $val['Picture']  ?>" width="134" height="100" /></a></span><span class="yy"></span></dt>

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

$ci->tool->zhuna_rewrite(CFG_REWRITE);

?>

</body>

</html>