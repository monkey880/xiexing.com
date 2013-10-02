<div class="kscz">

                          <div class="kscz_top">

                            <span class="zt"><h3>周边推荐酒店</h3></span>

                          </div>

                          <div class="kscz_bottom">

                            <div class="k_b_t">

                              <div class="zx_b_bottom1">

                              

                                <?php 

                                	if ($roundhotel['sort'] == 'hotelinfo') {

                                		$ci = & get_instance();

	                                    $ci->load->model('model_hotel');

	                                                

	                                    $roundHotel = $ci->model_hotel->getRoundHotel($hotelInfo['lat'],$hotelInfo['lng'],'7');

	                                    $roundHotel = $roundHotel['reqdata'];

                                        if ($roundHotel) {

	                                    foreach ($roundHotel as $key=>$val){ 

	                                        if($val['ID'] != $hotelInfo['hotel_id']){

	                             ?>

	                                <dl>

	                               <dt><span><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><img src="<?php echo $val['Picture']; ?>" width="86" height="64" alt="<?php echo $val['HotelName'] ?>" /></a></span><span class="yy1"></span></dt>

	                               <dd>

	                                   <ul>

	                                      <li><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $this->tool->cut_str($val['HotelName'],7)   ?></a></li>

	                                      <li><font class="f_b1_f00">￥<?php echo $val['min_jiage']; ?>元</font>起</li>

	                                      <li>距离：<font class="f_b1_fh0"><?php echo  round ( $val['juli'] / 1000, 2 ); ?>公里</font></li>

	                                   </ul>

	                               </dd>

	                            </dl>

	                             <?php 

									 	}} }else {echo '<font color="red">未找到附近的酒店</font>';} 

									} else if ($roundhotel['sort'] == 'expoinfo'){

	                                    $ci = & get_instance();

	                                    $ci->load->model('model_hotel');

	                                                

	                                    $roundHotel = $ci->model_hotel->getRoundHotelByXY($roundhotel['x'],$roundhotel['y'],'7');

	                                    $roundHotel = $roundHotel['reqdata'];

                                        if ($roundHotel) {

	                                    foreach ($roundHotel as $key=>$val){ 

	                             ?>

	                                <dl>

	                               <dt><span><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><img src="<?php echo $val['Picture']; ?>" width="86" height="64" alt="<?php echo $val['HotelName'] ?>" /></a></span><span class="yy1"></span></dt>

	                               <dd>

	                                   <ul>

	                                      <li><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $this->tool->cut_str($val['HotelName'],7)   ?></a></li>

	                                      <li><font class="f_b1_f00">￥<?php echo $val['min_jiage']; ?>元</font>起</li>

	                                      <li>距离：<font class="f_b1_fh0"><?php echo  round ( $val['juli'] / 1000, 2 ) ?>公里</font></li>

	                                   </ul>

	                               </dd>

	                            </dl>

	                             <?php 

	                                   }}else {echo '<font color="red">未找到附近的酒店</font>';} 

									}

	                             ?>

                              

                              </div> 

                            </div>

                          </div>

                          

                       </div>