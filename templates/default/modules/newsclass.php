<?php

	$ci = & get_instance();

	$ci->load->model('model_news_category');

	$news_category_list = $ci->model_news_category->get_category();

?>

<div class="zh_right">

	<div class="zh_x_top">

		<h2>资讯分类</h2>

	</div>

	<div class="zh_r_bottom1">

		<div class="zhlx">

			<ul>

				<?php foreach ($news_category_list as $key=>$val) { ?>

                <li><a href="<?php echo site_url("/news/0-$key-1") ?>" title="<?php echo $val ?>"><?php echo $val ?></a></li>

				<?php } ?>

			</ul>

		</div>

	</div>

</div>

