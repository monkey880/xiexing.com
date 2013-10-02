<?php

    //酒店点评

    $ci = & get_instance();

    $ci->load->model('model_common');

    $ci->load->model('model_hotel');

    

    $cityInfo = $ci->model_common->initCityinfo();

    $cityid = $cityInfo['cityid'];

    

    //酒店点评

    $commentList = $ci->model_hotel->getCommentListByCiytid($cityid); 

    $commentList = $commentList['reqdata']; 

    $commentList = array_slice($commentList,0,2);

?>

<div class="dp_b_left">

    <div class="ksa1_2_top">

        <span class="zt"><font class="f_right"><a href="<?php  echo site_url("/comment") ?>">更多&gt;&gt;</a></font><h3>酒店点评</h3></span>

    </div>

       <?php 

		   if (!empty($commentList)) {

		   		foreach($commentList as $val){ 

       ?>

       <dl>

          <dt>

            <span><img src="<?php echo base_url();?>public/images/<?php echo $val['comment_pic'] ?>"" width="66" height="55" /></span>

            <span><font class="f_b2_f00"><?php echo $val['username'] ?></font></span>

        </dt>

          <dd>

           <span class="bt"><span class="right"><font class="f_b1_f00"><?php echo $val['date_show'] ?></font></span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname'] ?></a>

           </span>

           <span class="dp_nr">

               <span class="jiao"></span>

               <span class="xinxi"><?php echo $val['content'] ?></span>

           </span>

         </dd>

     </dl>



     <?php 

			}

		} else {

			echo "<font color='red'>您选择的城市没有酒店点评!</font>";

		}

	 ?> 

</div>



