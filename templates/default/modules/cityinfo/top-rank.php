<?php 

    $ci = & get_instance();

    $ci->load->model('model_common');

    $orderList = $ci->model_common->getRankList(12);

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