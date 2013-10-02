<?php

    $ci = & get_instance();

    $ci->load->model('model_common');

    

    $cityInfo = $ci->model_common->initCityinfo();

    $cityid = $cityInfo['cityid'];

    $cityname = $cityInfo['cityname'];

            

    $welcomeHotel = $ci->model_common->getWelcomeHotel($cityid,1,8);

    $welHotelShow = array_slice($welcomeHotel,0,3) ;

?> 

<!--热门酒店  -->

<div class="kscz">

  <div class="kscz_top">

    <span class="zt"><h3><?php echo $cityname  ?>热门酒店</h3></span>

  </div>

  <div class="kscz_bottom">

    <div class="k_b_t">

       <div class="phb">

      <ul>

         <?php 

         	if (!empty($welHotelShow)) {

            	foreach ($welHotelShow as $key=>$val) {

         ?>  

         <li class="current"><span class="sz"><?php echo $key+1  ?></span><span class="jiage">¥<?php echo $val['min_jiage']  ?>元<font class="gray">起</font></span><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName']  ?></a></li>

         <?php } ?>

         <?php 

            $welcomeHotelShow = array_slice($welcomeHotel,3,7) ;

            foreach ($welcomeHotelShow as $key=>$val) { 

         ?>  

         <li><span class="sz"><?php echo $key+4  ?></span><span class="jiage">¥<?php echo $val['min_jiage']  ?>元<font class="gray">起</font></span><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName']  ?></a></li>

         <?php 

          		}

			}  else {

				echo '<li><font color="red">未找到'.$cityname.'的热门酒店</font></li>';

			}

         ?>

      </ul>

     </div>

    </div>

  </div>

</div>