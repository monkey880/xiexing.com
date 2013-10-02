<?php 

    $ci = & get_instance();

    $ci->load->model('model_common');

    

    $cityInfo = $ci->model_common->initCityinfo();

    $cityid = $cityInfo['cityid'];

    $cityname = $cityInfo['cityname'];

    

    $tuijianHotelList = $ci->model_common->getTuijianHotel($cityid,8);

?>  

<!--推荐酒店  -->

<div class="zh_right">

    <div class="zh_r_top"><h2><?php echo $cityname ?>推荐酒店</h2></div>

    <div class="zh_r_bottom">

       <ul>

          <?php 

          	if (!empty($tuijianHotelList)) {

	            $i = 0;

	            foreach($tuijianHotelList as $val){ 

	                $i++;

          ?>  

          <li><span class="right"><font class="f_b1_f00"><?php echo $val['min_jiage'] ?>元</font><font class="gray">起</font></span><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName'] ?></a> </li>

          <?php 

          		}

			}  else {

				echo '<font color="red">未找到'.$cityname.'的推荐酒店</font>';

			}

          ?>

       </ul>

    </div>

</div>