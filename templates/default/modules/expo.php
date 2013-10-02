<!--最新展会  -->

<div class="zh_right">

    <div class="zh_r_top"><h2>最新展会</h2></div>

    <div class="zh_r_bottom1">

         <div class="phb">

            <ul>

                <?php 

                    $ci = & get_instance();

                    $ci->load->model('model_common');

                    $ci->load->model('model_expo');

                    

                    $cityInfo = $ci->model_common->initCityinfo();

                    $cityid = $cityInfo['cityid'];

                    

                    $listresult = $ci->model_expo->getExpo($cityid,1,9,'');

                    $list = $listresult['reqdata'];

                ?> 

                 <?php 

                    $i = 0;

                    $listShow = array_slice($list,0,3) ;

                    foreach ($listShow as $val) {

                        $i++;

                 ?>  

                 <li class="current"><span class="sz"><?php echo $i ?></span><a href="<?php  echo site_url("/expoinfo/{$val['exhid']}") ?>" title="<?php echo $val['exhname'] ?>"><?php echo $val['exhname'] ?></a></li>

                 <?php } ?>

                 <?php 

                    $listShow = array_slice($list,3,7) ;

                    if (!empty($listShow)) {

	                    foreach ($listShow as $val) { 

	                        $i++;

                 ?>  

                 <li><span class="sz"><?php echo $i ?></span><a href="<?php  echo site_url("/expoinfo/{$val['exhid']}") ?>" title="<?php echo $val['exhname'] ?>"><?php echo $val['exhname'] ?></a></li>

                 <?php 

                 		}

					} else {

						echo '<font color="red">未找到'.$cityname.'的展会信息</font>';

					}

                 ?>

                 

          </ul>

         </div>

    </div>

</div>