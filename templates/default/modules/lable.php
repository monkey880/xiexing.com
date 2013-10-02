<!--地标页面  -->

<div class="kscz">

                          <div class="kscz_top">

                            <span class="zt"><h3>热门地标</h3></span>

                          </div>

                          <div class="kscz_bottom">

                            <div class="k_b_t">

                              <div class="bjdb">

                                  

                                  <dl>

                                     <dt><strong>地铁站</strong></dt>

                                     <dd>

                                         <ul>

                                            <?php 

                                                $ci = & get_instance();

                                                $ci->load->model('model_common');

                                                

                                                $cityInfo = $ci->model_common->initCityinfo();

                                                $cityid = $cityInfo['cityid'];

                                                $cityname = $cityInfo['cityname']; 

                                                

                                                $subwayLable = $ci->model_common->getSubwayLable($cityid);

                                                $subwayLable = array_slice($subwayLable,0,15) ;

                                                if (!empty($subwayLable)) {

                                                	foreach ($subwayLable as $key=>$val){ 

                                             ?> 

                                            <li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-keyid-{$val['id']}-pinyin-{$val['pinyin']}") ?>" title="<?php echo $val['name'][0] ?>附近酒店"><?php echo $val['name'][0] ?></a></li>

                                            <?php 

                                                	}

												}  else {

													echo '<font color="red">未找到'.$cityname.'的地铁信息</font>';

												}

                                            ?>

                                         </ul>

                                     </dd>

                                  </dl>

                                  <dl>

                                     <dt><strong>火车站</strong></dt>

                                     <dd>

                                         <ul>

                                            <?php 

                                                $trainLable = $ci->model_common->getTrainLable($cityid);

                                                $trainLable = array_slice($trainLable,0,15) ;

                                                if (!empty($trainLable)) {

                                                	foreach ($trainLable as $key=>$val){ 

                                             ?> 

                                            <li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-keyid-{$val['id']}-pinyin-{$val['pinyin']}") ?>" title="<?php echo $val['name'][0] ?>附近酒店"><?php echo $val['name'][0] ?></a></li>

                                            <?php 

                                                	}

												}  else {

													echo '<font color="red">未找到'.$cityname.'的火车站信息</font>';

												}

                                            ?>

                                         </ul>

                                     </dd>

                                  </dl>  

                                  <dl>

                                     <dt><strong>汽车站</strong></dt>

                                     <dd>

                                         <ul>

                                            <?php 

                                                $busLable = $ci->model_common->getBusLable($cityid);

                                                $trainLable = array_slice($busLable,0,15) ;

                                                if (!empty($busLable)) {

                                                	foreach ($busLable as $key=>$val){ 

                                             ?> 

                                            <li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-keyid-{$val['id']}-pinyin-{$val['pinyin']}") ?>" title="<?php echo $val['name'][0] ?>附近酒店"><?php echo $val['name'][0] ?></a></li>

                                            <?php 

                                                	}

												}  else {

													echo '<font color="red">未找到'.$cityname.'的汽车站信息</font>';

												}

                                            ?>

                                         </ul>

                                     </dd>

                                  </dl>                                    

                             </div> 

                            </div>

                          </div>

                          

                       </div>