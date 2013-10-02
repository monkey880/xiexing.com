<?php 

    $ci = & get_instance();

    $ci->load->model('model_common');

    $orderList = $ci->model_common->getRankList(8);

?>



 <div class="kscz">

                      <div class="kscz_top">

                         <span class="zt"><h3>预订排行榜</h3></span>

                      </div>

                      <div class="kscz_bottom">

                          <div class="k_b_t">

                            <div class="phb">

                              <ul>

                              	<?php 

                              		$i = 0;

                              		foreach ($orderList as $key=>$val){ 

                              			$i++;

                              	?>

                                <li class="<?php if ($i<=3) { echo "current";}else{ echo "sz" ; } ?>"><span class="sz"><?php echo $i; ?></span><span class="jiage"> ¥<?php echo $val['jiang']; ?>元<font class="gray">起</font></span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname']; ?></a> </li>

                                <?php } ?>

                              </ul>

                             </div>

                          </div>

                      </div>

                  </div>