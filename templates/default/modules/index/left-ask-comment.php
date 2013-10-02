 <?php 

    $ci = & get_instance();

    $ci->load->model('model_hotel');

    $ci->load->model('model_common');

    

    $cityInfo = $ci->model_common->initCityinfo();

    $cityid = $cityInfo['cityid'];

    

    //酒店点评

    $commentList = $ci->model_hotel->getCommentListByCiytid($cityid); 

    $commentList = $commentList['reqdata']; 

    $commentList = array_slice($commentList,0,3);

    //酒店问答

    $questionList = $ci->model_hotel->getQuestionListByCityid($cityid); 

    $questionList = $questionList['reqdata'];     

    $questionList = array_slice($questionList,0,5);

?>

<div class="tjjd">

  <div class="dianping"><font style="color:#f60;">问答</font>点评

  </div>

  <div class="dp_botma9">

      <div class="dp_b_right">

          <span class="jddp"><a href="<?php  echo site_url("/ask") ?>">更多>></a><h2><font style="color:#f60;">酒店问答</font></h2></span>

           <?php 

	           //酒店问答

	           $i = 0;

	           if (!empty($questionList)) {

		           foreach($questionList as $val){ 

		               $i++;

           ?>

	           <dl>

	               <dt><font class="f_b1_f00">0<?php echo $i ?></font></dt>

	               <dd>

	                   <ul>

	                       <li>

	                       	<?php if(!empty($val['hotelname'])) { ?>

	                       		<a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" ><font style="color:#7b9cc4; font-size:14px;" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname'] ?></font></a>

	                       	<?php } else { ?>

	                       		<a href="javascript:void(0)"><font style="color:#7b9cc4; font-size:14px;"><?php echo CFG_WEBNAME ?></font></a>

	                       	<?php } ?>

	                       </li>

	                       <li><?php echo $val['question'] ?></li>

	                   </ul>

	               </dd>

	           </dl>

           <?php 

		        	}

	           } else {

	           		echo "<font color='red'>您选择的城市没有酒店问答!</font>";

	           }

           ?> 

      </div>

      <div class="dp_b_left">

           <span class="jddp"><a href="<?php  echo site_url("/comment") ?>">更多>></a><h2><font style="color:#f60;">酒店点评</font></h2></span>

           <?php 

	           if (!empty($commentList)) {

	           		foreach($commentList as $val){ 

           ?>

	            <dl>

	              <dt>

	                <span><img src="<?php echo base_url();?>public/images/<?php echo $val['comment_pic'] ?>" width="66" height="55" /></span>

	                <span><font class="f_b2_f00"><?php echo $val['username'] ?></font></span>

	            </dt>

	              <dd>

	               <span class="bt"><span class="right"><font class="f1_b1_f00" ><?php echo $val['date_show'] ?></font></span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname'] ?></a>

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

  </div>

</div>