<?php

	$ci = & get_instance();

	$ci->load->model('model_news');

	$newslist = $ci->model_news->get_list(0,6,'view_num desc','where state_radio = 4');

	

?>

<div class="zh_right">

    <div class="zh_r_top"><h2>图片资讯</h2></div>

    <div class="zh_img_bottom">

        <?php if($newslist) {

            foreach ($newslist as $news) {  ?> 

       <dl>

          <dt><a href="<?php  echo site_url("/newsinfo/{$news['aid']}") ?>" title="<?php echo $news['title'] ?>" ><img src="<?php echo rtrim(base_url(),'/');?>/public/uploadfiles/upload/<?php echo $news['img'] ?>" alt="<?php echo $news['title'] ?>" width="80" height="60" /></a></dt>

          <dd><a href="<?php  echo site_url("/newsinfo/{$news['aid']}") ?>" title="<?php echo $news['title'] ?>"><?php echo $news['title'] ?></a></dd>

       </dl>

       <?php }}else{echo '<dl>还没有图片资讯，请添加！</dl>';} ?> 

    </div>

</div>

