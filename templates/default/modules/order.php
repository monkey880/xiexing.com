





<!--最新订单  -->

<div class="kscz">

    <div class="kscz_top">

    <span class="zt"><h3>最新订单</h3></span>

    </div>

      <div class="kscz_bottom">

      <div class="k_b_t" style="overflow:hidden;height:308px;">

         <div class="newdd" id="divNewOrder">

              <?php 

                $ci = & get_instance();

                $ci->load->model('model_common');

                $orderList = $ci->model_common->getOderList(5);

                foreach ($orderList as $key=>$val){

              ?>  

              <dl>

                  <dt>

                  <span><font class="f_666"><?php echo $val['tel']; ?></font><font class="f_999">预订了</font></span>

                  <font class="f_999"><?php echo $val['time']; ?></font> 

                  </dt>

                  <dd> 

                    <span class="jiage">¥<?php echo $val['jiang']; ?>元</span><a href="<?php  echo site_url("/hotelinfo/{$val['hotelid']}") ?>" title="<?php echo $val['hotelname'] ?>"><?php echo $val['hotelname']; ?></a>    </dd>

              </dl>

              <?php } ?>

         </div>

      </div>

    </div>

</div>

<script type="text/javascript">

$(function(){

    var scrtime;

    $("#divNewOrder").hover(

    	function()

    	{

    	    clearInterval(scrtime);

    	},

    	function()

    	{

    		scrtime = setInterval(function(){

    	    var ul = $("#divNewOrder");

    	    var liHeight = ul.find("dl:last").height();

    	    ul.animate({marginTop : liHeight+40 +"px"},1000,function(){

    		    ul.find("dl:last").prependTo(ul)

    		    ul.find("dl:first").hide();

    		    ul.css({marginTop:0});

    		    ul.find("dl:first").fadeIn(400);

    		    }); 

    	    },2500);

    

    }).trigger("mouseleave");

});

</script>