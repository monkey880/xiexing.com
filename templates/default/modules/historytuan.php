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

                                    $historyHotel = $ci->model_common->getHistoryTuan();

                                    if(!empty($historyHotel)){

                                        foreach ($historyHotel as $key=>$val){ 

                                  ?>  

                                  <dl>

                                      <dd> 

                                        <span class="jiage">¥<?php echo $val['price'] ?>元</span><a href="<?php  echo site_url("/tuangouinfo/{$val['tid']}") ?> " title="<?php echo $val['shortTitle'] ?>"><?php echo $this->tool->cut_str($val['shortTitle'],11);  ?></a>

                                      </dd>

                                  </dl>

                                  <?php }}else{ ?> 

                                  <dl>

                                    <dd><font color="red"><?php echo '还没有浏览过的团购!';  ?></font></dd>

                                  </dl>  

                                  <?php } ?>

                               </div>

                             </div>

                          </div>

                       </div>