<!--浏览记录 -->

<div class="kscz">

                          <div class="kscz_top">

                             <span class="zt"><h3>浏览记录</h3></span>

                          </div>

                          <div class="kscz_bottom">

                             <div class="k_b_t">

                                <div class="newdd">

                                  <?php 

                                    $ci = & get_instance();

                                    $ci->load->model('model_common');

                                    $historyHotel = $ci->model_common->getHistoryHotel();

                                    if(!empty($historyHotel)){

                                        foreach ($historyHotel as $key=>$val){ 

                                  ?>  

                                  <dl>

                                      <dd> 

                                        <span class="jiage">¥<?php echo $val['minprice'] ?>元</span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelId']}") ?> " title="<?php echo $val['hotelName'] ?>"><?php echo $this->tool->cut_str($val['hotelName'],11);  ?></a>

                                      </dd>

                                  </dl>

                                  <?php }}else{ ?> 

                                  <dl>

                                    <dd><font color="red"><?php echo '还没有浏览过的酒店!';  ?></font></dd>

                                  </dl>  

                                  <?php } ?>

                               </div>

                             </div>

                          </div>

                       </div>