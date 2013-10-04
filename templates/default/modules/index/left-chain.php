<div class="pinpai">

  <ul class="pipa_jinji">

    <li class="current" id="chain_tab_1"><a title="品牌连锁酒店预订" href="javascript:void(0)" >品牌连锁</a></li>

    <li class="lines"></li>

    <li id="chain_tab_2"><a title="经济连锁酒店预订" href="javascript:void(0)" >经济连锁</a></li>

  </ul>

  <ul class="pipa_plates" id="chain_1" >

    <?php 

        //品牌连锁

        $ci = & get_instance();

        $ci->load->library('tool');

        $ci->load->model('model_common');

        

        $cityInfo = $ci->model_common->initCityinfo();

        $cityid = $cityInfo['cityid'];

            

        $chain_list = $ci->model_common->getChainHotel($cityid,0);

        if (!empty($chain_list)) {

        	foreach($chain_list as $val){ 

    ?>

    		<li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-chain_id-{$val['lsid']}") ?>" title="<?php echo $val['lsname'] ?>"><img src="<?php echo $val['tupian'] ?>" width="50" height="40" alt="<?php echo $val['lsname'] ?>酒店预订" /><?php echo $val['lsname'] ?></a></li>

    <?php 

        	}

        } else {

        	echo "<center class='warning1'>未找到{$cityInfo['cityname']}品牌连锁酒店!</center>";

        } 

        

    ?>

 </ul>

 <ul class="pipa_plates" id ="chain_2">

    <?php 

        $chain_list = $ci->model_common->getChainHotel($cityid,1);

        if (!empty($chain_list)) {

        	foreach($chain_list as $val){ 

    ?>

    		<li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-chain_id-{$val['lsid']}") ?>" title="<?php echo $val['lsname'] ?>"><img src="<?php echo $val['tupian'] ?>" width="50" height="40" alt="<?php echo $val['lsname'] ?>酒店预订" /><?php echo $val['lsname'] ?></a></li>

    <?php 

        	}

        } else {

        	echo "<center class='warning1'>未找到{$cityInfo['cityname']}经济连锁酒店!</center>";

        } 

        

    ?>

 </ul>

</div>

<script>

$(function(){

    $("#chain_1").show();

    $("#chain_2").hide();

    

    $("#chain_tab_1").click(function(){show_chain($(this),'chain_1');}) ; 

    $("#chain_tab_2").click(function(){show_chain($(this),'chain_2');}) ;     

})

   

function show_chain(divclass,chain_content_id){

    $('#chain_tab_1').removeClass(); 

    $('#chain_tab_2').removeClass();

    $(divclass).addClass('current');  

    

    $("#chain_1").hide();

    $("#chain_2").hide();

    $("#"+chain_content_id).show();

 

}  



</script>