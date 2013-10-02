<!--展会资讯  -->

<div class="zh_right">

    <div class="zh_r_top"><h2>展会热门新闻</h2></div>

    <div class="zh_r_bottom1">

         <div class="phb">

            <ul>

                 <?php 

                    $ci = & get_instance();

                    $ci->load->model('model_common');

                    $hotExpoNews = $ci->model_common->getHotExpoNews();

                    $hotExpoNewsShow = array_slice($hotExpoNews,0,3) ;

                    $i = 0 ;

                    foreach ($hotExpoNewsShow as $val){ 

                        $i++ ;    

                  ?>  

                 <li class="current"><span class="sz"><?php echo $i ?></span><a href="<?php  echo site_url("/exponews/index/{$val['newsid']}") ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>

                 <?php } ?>

                 <?php 

                    $hotExpoNewsShow = array_slice($hotExpoNews,3,6) ;

                    foreach ($hotExpoNewsShow as $key=>$val){ 

                        $i++;

                 ?> 

                 <li><span class="sz"><?php echo $i ?></span><a href="<?php  echo site_url("/exponews/index/{$val['newsid']}") ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>

                 <?php } ?>

                 

          </ul>

         </div>

    </div>

</div>