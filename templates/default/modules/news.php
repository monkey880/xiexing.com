<!--最新资讯  -->

<div class="zh_right">

    <div class="zh_r_top"><h2>热门新闻</h2></div>

    <div class="zh_r_bottom1">

         <div class="phb">

            <ul>

			<?php

				$ci = & get_instance();

				$ci->load->model('model_news');

				$newslist = $ci->model_news->get_list(0,9,'view_num desc',' where class_id not in(5,6)');

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