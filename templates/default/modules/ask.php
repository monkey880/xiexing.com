<!--酒店问答  -->

<div class="kscz">

  <div class="kscz_top">

     <span class="zt"><h3>酒店问答</h3></span>

  </div>

  <div class="kscz_bottom">

      <div class="k_b_t">

          <div class="dp_b_right">

            <?php

                //酒店问答

                $ci = & get_instance();

                $ci->load->model('model_common');

                $ci->load->model('model_hotel');

                

                $cityInfo = $ci->model_common->initCityinfo();

                $cityid = $cityInfo['cityid'];

                

                $questionList = $ci->model_hotel->getQuestionListByCityid($cityid); 

                $questionList = $questionList['reqdata'];     

                $questionList = array_slice($questionList,0,5);

            ?>           

            <?php 

				//酒店问答

				$i = 0;

				if (!empty($questionList)) {

					foreach($questionList as $val){ 

						$i++;

			?> 

            <dl>

               <dt><font class="f_b1_f00">0<?php echo $i ?></font></dt>

               <dd>

                   <ul>

                       <li>

                       	<?php if(!empty($val['hotelname'])) { ?>

                       		<a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>"  ><font style="color:#7b9cc4; font-size:14px;" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname'] ?></font></a>

                       	<?php } else { ?>

                       		<a href="javascript:void(0)"><font style="color:#7b9cc4; font-size:14px;"><?php echo CFG_WEBNAME ?></font></a>

                       	<?php } ?>

                       </li>

                       <li><?php echo $val['question'] ?></li>

                   </ul>

               </dd>

            </dl>

            <?php 

					}

				} else {

					echo "<font color='red'>您选择的城市没有酒店问答!</font>";

				}

			?> 

          </div>

      </div>

  </div>

</div>



