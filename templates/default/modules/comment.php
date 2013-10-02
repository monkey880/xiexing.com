<!--酒店点评  -->

<div class="kscz">

      <div class="kscz_top">

                         <span class="zt"><h3>酒店点评</h3></span>

                      </div>

      <div class="kscz_bottom">

          <div class="k_b_t">

              <div class="dp_b_left">

	                <?php

	                    //酒店点评

	                    $ci = & get_instance();

	                    $ci->load->model('model_common');

	                    $ci->load->model('model_hotel');

	                    

	                    $cityInfo = $ci->model_common->initCityinfo();

	                    $cityid = $cityInfo['cityid'];

	                    

	                    //酒店点评

	                    $commentList = $ci->model_hotel->getCommentListByCiytid($cityid);

	                    $commentList = $commentList['reqdata'];

	                    $commentList = array_slice($commentList,0,3);

	                ?>

                 	<?php 

					   if (!empty($commentList)) {

					   		foreach($commentList as $val){ 

			       	?>

                  <dl>

                      <dt>

                                   <span class="bt"><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname'] ?></a><span class="right"><font class="f_b1_f00"><?php echo $val['date_show'] ?></font></span><span class="left"><?php echo $val['username'] ?></span>

                                   </span>

                                   </dt>

                      <dd>

                                   <div class="dp_nr">

                                       <span class="jiao"></span>

                                       <span class="xinxi"><?php echo $val['content'] ?></span>

                                   </div>

                                 </dd>

                  </dl>

                   	<?php 

							}

						} else {

							echo "<font color='red'>您选择的城市没有酒店点评!</font>";

						}

					?> 

              </div>

          </div>

      </div>

  </div>