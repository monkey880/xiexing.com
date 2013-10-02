<div class="ksa1_2">

  <div class="ksa1_2_top">

     <span class="zt"><h3>最新资讯</h3></span>

  </div>

  <div class="ksa1_2_bottom">

      <div class="ka1_2_t">

        <div class="phb">

	         <ul>

			    <?php

			    $ci = & get_instance();

			    $ci->load->model('model_news');

			    $newslist = $ci->model_news->get_list(0,12);

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