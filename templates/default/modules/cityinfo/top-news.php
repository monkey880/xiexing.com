<ul>

    <?php

    $ci = & get_instance();

    $ci->load->model('model_news');

    $newslist = $ci->model_news->get_list(0,6);

    $i = 0 ;

    foreach ($newslist as $news) {

    $i++;?>

    <li class="current"><span class="sz"><?php echo $i;?></span><a href="<?php  echo site_url("/newsinfo/{$news['aid']}") ?>" title="<?php echo $news['title'] ?>"><?php echo $news['title'] ?></a></li>

    <?php }?>



</ul>