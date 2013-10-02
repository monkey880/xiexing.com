<div class="tjjd">

                       <div class="dianping">

                         <span class="more"><a href="<?php  echo site_url("/allcity") ?>">更多</a></span>

                         <ul class="citybg">

                            <?php 

                            	$ci = & get_instance();

                                $ci->load->model('model_common');

                                $ci->load->model('model_city');

                                

                                $cityInfo = $ci->model_common->initCityinfo();

    							$cityid = $cityInfo['cityid'];

        

                                //搜索块到热门城市列表

                                $listNum = 6;                

                                $hotCityList = $ci->model_city->getInitCityList($listNum);

                                

                                $welcomeHotel_1 = $ci->model_common->getWelcomeHotel($cityid,1,6);//经济型酒店

                                $welcomeHotel_2 = $ci->model_common->getWelcomeHotel($cityid,5,6);//豪华型酒店

                                

                                $getHotCBD = $ci->model_common->getCBD($cityid,1,18);//热门商圈

                                $getHotLable = $ci->model_common->getLable($cityid,1,18);//热门景点

                                

                                $i = 0;

                                foreach($hotCityList as $val){ 

                                    $i++ ;

                            ?>                                          

                            

                            <?php } ?>

                         </ul>

                         <span><font style="color:#f60;">热门</font>酒店</span>

                       </div>

                       <div class="hotbotm" id="hothotel_div_loading1">

                         <div class="hot_box">

                             <div class="hot_plate">

                                <div class="hot_bt">经济型酒店</div>

                                <div class="more"><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-rank-2") ?>">更多>></a></div>

                             </div>

                             <div class="hot_list">

                                    <ul id="welcomeHotel_1">

                                       <?php 

                                       	if (!empty($welcomeHotel_1)) {

                                        $i = 0;

                                        foreach($welcomeHotel_1 as $val){ 

                                            $i++;

                                            $yushu = $i%2;

                                            

                                       ?>

                                       <li><font class="f_b_f00" style="float:right;">¥<?php echo $val['min_jiage'] ?></font>

                                           <span class="hotname"><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName'] ?></a></span>

                                           <span class="weiz"><?php if(trim($val['esdname'],' ') != ''){ ?>位于：<a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>" title="<?php echo $val['esdname'] ?>附近酒店"><?php echo  $val['esdname'] ?></a><?php }else{ ?><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>">未知</a><?php } ?></span>

                                       </li>

                                       <?php if($yushu != 0){ ?><li class="line"></li><?php }} ?>

                                       <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的经济型酒店!</center>"; } ?>

                                    </ul>

                         </div>

                         </div>

                         <div class="hot_box">

                             <div class="hot_plate">

                                <div class="hot_bt">豪华型酒店</div>

                                <div class="more"><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-rank-5") ?>">更多>></a></div>

                             </div>

                             <div class="hot_list" >

                                    <ul id="welcomeHotel_2">

                                       <?php 

                                        if (!empty($welcomeHotel_2)) {

                                        $i = 0;

                                        foreach($welcomeHotel_2 as $val){ 

                                            $i++;

                                            $yushu = $i%2;

                                            

                                       ?>

                                       <li><font class="f_b_f00" style="float:right;">¥<?php echo $val['min_jiage'] ?></font>

                                           <span class="hotname"><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName'] ?></a></span>

                                           <span class="weiz"><?php if(trim($val['esdname'],' ') != ''){ ?>位于：<a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>" title="<?php echo $val['esdname'] ?>附近酒店"><?php echo  $val['esdname'] ?></a><?php }else{ ?><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>">未知</a><?php } ?></span>

                                       </li>

                                       <?php if($yushu != 0){ ?><li class="line"></li><?php }} ?>

                                       <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的豪华型酒店!</center>"; } ?>

                                    </ul>

                           </div>

                         </div>

                         <div class="hot_box">

                             <div class="hot_plate">

                                <div class="hot_bt">最热门地标</div>

                                <div class="more"></div>

                             </div>

                             <div class="hot_db">

                                 <dl>

                                   <dt>

                                      商圈

                                   </dt>

                                   <dd>

                                         <ul id='hotcbd'>

                                            <?php 

                                            	if (!empty($getHotCBD)) {

                                                	foreach($getHotCBD as $val){ 

                                                    

                                            ?>

                                            <li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['cbd_id']}") ?>"  title="<?php echo $val['CBD_Name'] ?>附近酒店"><?php echo $val['CBD_Name'] ?></a></li>

                                            <?php } ?>

                                            <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的商圈信息!</center>"; } ?>

                                         </ul>

                                   </dd>

                                 </dl>

                                 <div class="lines"></div>

                                 <dl>

                                   <dt>

                                      景点

                                   </dt>

                                   <dd>

                                         <ul id="hotlable">

                                            <?php 

                                           	 if (!empty($getHotLable)) {

                                                foreach($getHotLable as $val){ 

                                                    

                                            ?>

                                            <li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-keyid-{$val['id']}-pinyin-{$val['pinyin']}") ?>" title="<?php echo $val['name'][0] ?>附近酒店"><?php echo $val['name'][0] ?></a></li>

                                            <?php } ?>

                                            <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的景点信息!</center>"; } ?>

                                         </ul>

                                   </dd>

                                 </dl>    

                             </div>

                         </div>

                       </div>

                       <div class="" id="hothotel_div_loading2" style="display:none;">

							<p style="text-align:center;" ><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>

					   </div>

                   </div>