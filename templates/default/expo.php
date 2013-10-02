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

                <span class="wzdt"></span><span class="sy"><?php echo $cityname ?>展会</span>

           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                    <div class="zhpd_top"><font class="f_right">展会新闻共<font class="f_b1_f00"><?php echo $allnums ?></font>篇</font>

                       <h1><font class="f_b_f00">展会</font><font style="color:#494949;">频道</font></h1>

                    </div>

                    <div class="zhpd_bottom">

                         <div class="zhpd_plate">

                               <div class="d_p_top">请选择展会城市</div>

                               <div class="d_p_bottom">

                                   <?php foreach ($hotCityList as $val) { ?>

                                   <dl <?php if($val['cid'] == $cityid){ ?>class="current"<?php } ?>>

                                      <dt><?php echo $val['abcd'] ?></dt>

                                      <dd>

	                                      <a href="<?php echo site_url("/expo/{$order}-{$val['cid']}-{$nowPage}") ?>   ">

	                                      	<?php echo $val['cName'] ?>

	                                      </a> 

                                      </dd> 

                                   </dl>

                                   <?php }  ?>

                         </div>

                         </div>

                         <div class="zh_pu"></div>

                         <div class="zh_plate">

                             <div class="zhpd_dh">

                                 <ul>

                                     <li <?php if($order <= 1){ ?>class="current"<?php } ?> ><a href="<?php echo site_url("/expo/1-$cityid-1") ?>">全部展会</a></li>

                                     <li <?php if($order == 3){ ?>class="current"<?php } ?> ><a href="<?php echo site_url("/expo/3-$cityid-1") ?>">即开展会</a></li>

                                     <li <?php if($order == 2){ ?>class="current"<?php } ?> ><a href="<?php echo site_url("/expo/2-$cityid-1") ?>">月内展会</a></li>

                                 </ul>

                             </div>

                             <div class="zhlist">

                             	  <?php if (!empty($list)) { ?>	

                                  <?php foreach ($list as $val) { ?>

                                  <dl>

                                      <dt>

                                      	<?php if (!empty($val['exhlogo'])) { ?>

                                      	<img src="http://www.haozhanhui.com/<?php echo $val['exhlogo'] ?>" width="95" height="78" onerror="change_error_image(this)" />

                                      	<?php } else { ?>

                                      	<img src="<?php echo base_url();?>public/images/nophoto.gif" width="95" height="78" />

                                      	<?php } ?>

                                      </dt>

                                      <dd>

                                          <ul>

                                              <li><a href="<?php echo site_url("/expoinfo/{$val['exhid']}") ?>" title="<?php echo $val['exhname'] ?>"><?php echo $val['exhname'] ?></a></li>

                                              <li>简介：<?php echo $val['exhdetail'] ?></li>

                                              <li>展会时间：(<?php echo date("Y年m月d日",$val['exhbtime']) ?>-<?php echo date("Y年m月d日",$val['exhetime']) ?>)</li>

                                              <li>

                                                <span>举办场馆：</span><span class="zhcg"><?php if(!$val['ehcmapx'] == 0){ ?><a href="<?php echo site_url("/hotellist/cityid-{$val['exhcityid']}-x-{$val['ehcmapx']}-y-{$val['ehcmapy']}") ?>" title="<?php echo $val['ehcname'] ?>"><?php echo $val['ehcname'] ?></a><?php }else{echo "暂无坐标";} ?></span>

                                                <span class="look_bg"><a href="<?php echo site_url("/expoinfo/{$val['exhid']}") ?>">去看看</a></span>

                                                <span class="fj_bg"><?php if(!$val['ehcmapx'] == 0){ ?><a href="<?php echo site_url("/hotellist/cityid-{$val['exhcityid']}-x-{$val['ehcmapx']}-y-{$val['ehcmapy']}") ?>">附近酒店</a><?php }else{echo "暂无坐标";} ?></span>

                                              </li>

                                          </ul>

                                      </dd>

                                      <dd class="zh_city">

                                          <ul>

                                             <li><?php echo $val['exhcity'] ?></li>

                                             <li class="zhlx"><?php echo $val['exhmtrade'] ?></li>

                                          </ul>

                                      </dd>

                                  </dl>

                                  <?php }} else { echo "<center class='warning1'>未找到{$cityname}的展会信息!</center>"; }  ?>

                                  <div class="fy">

                                    <?php echo $page ?>

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

<script>

function  change_error_image(obj){

	$(obj).attr('src','<?php echo base_url() ?><?php echo base_url();?>public/images/nophoto.gif');	

}

</script>

</body>

</html>