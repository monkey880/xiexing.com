<?php 

    $ci = & get_instance();

    $ci->load->model('model_common');

    $orderList = $ci->model_common->getRankList(8);

?>

<div class="tjjd">

    <div class="dianping"><font style="color:#f60;">预订</font>资讯 </div>

    <div class="dp_botma9">

        <div class="dp_b_right"> <span class="jddp"><a href="<?php  echo site_url("/hotellist") ?>">更多>></a>

            <h2><font style="color:#f60;">预订排行</font></h2>

            </span>

            <div class="phb">

                <ul>

                	<?php 

						$i = 0;

						foreach ($orderList as $key=>$val){ 

							$i++;

					?>

                    <li class="<?php if ($i<=3) { echo "current";}else{ echo "sz" ; } ?>"><span class="sz"><?php echo $i;?></span><span class="jiage"> ¥180<font class="gray">起</font></span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname']; ?></a></li>

                    <?php } ?>

                </ul>

            </div>

        </div>

        <div class="dp_b_left"> <span class="jddp"><a href="<?php  echo site_url("/news") ?>">更多>></a>

            <h2><font style="color:#f60;">最新资讯</font></h2>

            </span>

            <div class="phb">

                <ul>

				<?php

				$ci = & get_instance();

				$ci->load->model('model_news');

				$newslist = $ci->model_news->get_list(0,8);

				$i = 0 ;

				foreach ($newslist as $news) {

					$i++;

					if ($i<=3) {

			    ?>

				<li class="current"><span class="sz"><?php echo $i;?></span><a href="<?php  echo site_url("/newsinfo/{$news['aid']}") ?>" title="<?php echo $news['title'] ?>"><?php echo $news['title'] ?></a></li>

				<?php } else { ?>

				<li class=""><span class="sz"><?php echo $i;?></span><a href="<?php  echo site_url("/newsinfo/{$news['aid']}") ?>" title="<?php echo $news['title'] ?>"><?php echo $news['title'] ?></a></li>			

				<?php }}?>

                </ul>

            </div>

        </div>

    </div>

</div>





