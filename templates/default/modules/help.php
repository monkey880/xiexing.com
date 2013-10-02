<!--酒店帮助 -->

<div class="kscz" style="width:180px">

  <div class="kscz_top" style="width:180px;height:50px">

     <span class="zt" style="font-size:28px;padding-top:10px;">帮助中心</span>
 
  </div>


      <div class="k_b_t">

         <div class="jd_help">
          <ul class="nav_ul">
          <li><a <?php if($method=='questions') echo "class=on"?> href="/questions/">常见问题</a></li>
         <?php

				$ci = & get_instance();

				$ci->load->model('model_news');

				$newslist = $ci->model_news->get_list(0,9,'`order` desc',' where class_id=5');

				$i = 0 ;

				foreach ($newslist as $news) {

					

				

			?>

             

                <li><a <?php  if($id==$news['aid']) echo "class=on"; ?> href="<?php  echo site_url("/help/{$news['aid']}") ?>" title="<?php echo $news['title'] ?>"><?php echo $news['title'] ?></a></li>

                

       

            <?php }?>
</ul>
         </div>

      </div>



</div> 



  <div class="kscz_top" style="width:180px;height:50px">

     <span class="zt" style="font-size: 28px;padding-top: 10px;">关于我们</span>

  </div>



      <div class="k_b_t">

         <div class="jd_help">
<ul class="nav_ul">
             <?php

				$ci = & get_instance();

				$ci->load->model('model_news');

				$newslist = $ci->model_news->get_list(0,9,'`order` desc',' where class_id=6');

				$i = 0 ;

				foreach ($newslist as $news) {

					

				

			?>

             

                <li><a <?php  if($id==$news['aid']) echo "class=on"; ?> href="<?php  echo site_url("/help/{$news['aid']}") ?>" title="<?php echo $news['title'] ?>"><?php echo $news['title'] ?></a></li>

                

          
            <?php }?>
</ul>

         </div>

      </div>

