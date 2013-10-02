<?php 

    $ci = & get_instance();

    $ci->load->model('model_common');

    $orderList = $ci->model_common->getOderList(6);

?>

<div class="a2_2">

                   <div class="a2_6">

                         <div class="ksa1_2_top">

                         <span class="zt"><font class="f_right"><a href="javascript:void(0)">更多&gt;&gt;</a></font><h3>最新订单</h3></span>

                   </div>

                               <div class="k_b_t">

                               <div class="newdd">

                     <?php $this->load->view('modules/index/top-order');?>

                     

                   </div>

                   </div>

                               

                               

                   </div>

</div>

