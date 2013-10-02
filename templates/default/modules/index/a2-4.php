<div class="a2_2">
   <div class="dp_b_right">
        <div class="ksa1_2_top">
         	<span class="zt"><font class="f_right"><a href="javascript:void(0)">更多&gt;&gt;</a></font><h3>预订排行</h3></span>
   		</div>
        <div class="phb">
    		<?php 
			    $ci = & get_instance();
			    $ci->load->model('model_common');
			    $orderList = $ci->model_common->getRankList(6);
			?>
			<ul>
			    <?php 
					$i = 0;
					foreach ($orderList as $key=>$val){ 
						$i++;
				?>
			    <li class="<?php if ($i<=3) { echo "current";}else{ echo "sz" ; } ?>"><span class="sz"><?php echo $i; ?></span><span class="jiage"> ¥<?php echo $val['jiang']; ?><font class="gray">起</font></span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname']; ?></a> </li>
			    <?php } ?>    
			</ul>
   		</div>
   </div>
</div>

