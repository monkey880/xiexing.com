<div class="tjjd">

                       <div class="dianping">

                         <span class="more"><a title="全国城市酒店预订" href="<?php  echo site_url("/allcity") ?>">更多</a></span>

                         <ul class="citybg">

                            <?php 

                            	$ci = & get_instance();

                                $ci->load->model('model_common');

                                $ci->load->model('model_city');

                                

                                $cityInfo = $ci->model_common->initCityinfo();

    							$cityid = $cityInfo['cityid'];

        

                                //搜索块到热门城市列表

                                $listNum = 6;                

                                $hotCityList = $ci->model_city->getInitCityList($listNum);

                                

                                $welcomeHotel_1 = $ci->model_common->getWelcomeHotel($cityid,1,6);//经济型酒店

                                $welcomeHotel_2 = $ci->model_common->getWelcomeHotel($cityid,5,6);//豪华型酒店

                                

                                $getHotCBD = $ci->model_common->getCBD($cityid,1,18);//热门商圈

                                $getHotLable = $ci->model_common->getLable($cityid,1,18);//热门景点

                                

                                $i = 0;

                                foreach($hotCityList as $val){ 

                                    $i++ ;

                            ?>                                          

                            <li <?php if($val['cityid'] == $cityid){ ?>class="current"<?php } ?> onclick="ajax_get_hothotel('<?php echo $val['cityid'] ?>',<?php echo $i ?>)" id="hothotel_<?php echo $i ?>"><a href="javascript:void(0)" ><?php echo $val['cityname'] ?></a></li>

                            <?php } ?>

                         </ul>

                         <span><font style="color:#f60;">热门</font>酒店</span>

                       </div>

                       <div class="hotbotm" id="hothotel_div_loading1">

                         <div class="hot_box">

                             <div class="hot_plate">

                                <div class="hot_bt">经济型酒店</div>

                                <div class="more"><a title="经济酒店预订" href="<?php  echo site_url("/hotellist/cityid-{$cityid}-rank-2") ?>">更多>></a></div>

                             </div>

                             <div class="hot_list">

                                    <ul id="welcomeHotel_1">

                                       <?php 

                                       	if (!empty($welcomeHotel_1)) {

                                        $i = 0;

                                        foreach($welcomeHotel_1 as $val){ 

                                            $i++;

                                            $yushu = $i%2;

                                            

                                       ?>

                                       <li><font class="f_b_f00" style="float:right;">¥<?php echo $val['min_jiage'] ?></font>

                                           <span class="hotname"><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>预订"><?php echo $val['HotelName'] ?></a></span>

                                           <span class="weiz"><?php if(trim($val['esdname'],' ') != ''){ ?>位于：<a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>" title="<?php echo  $val['esdname'] ?>附近酒店"><?php echo  $val['esdname'] ?></a><?php }else{ ?><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>">未知</a><?php } ?></span>

                                       </li>

                                       <?php if($yushu != 0){ ?><li class="line"></li><?php }} ?>

                                       <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的经济型酒店!</center>"; } ?>

                                    </ul>

                         </div>

                         </div>

                         <div class="hot_box">

                             <div class="hot_plate">

                                <div class="hot_bt">豪华型酒店</div>

                                <div class="more"><a title="豪华型酒店预订" href="<?php  echo site_url("/hotellist/cityid-{$cityid}-rank-5") ?>">更多>></a></div>

                             </div>

                             <div class="hot_list" >

                                    <ul id="welcomeHotel_2">

                                       <?php 

                                        if (!empty($welcomeHotel_2)) {

                                        $i = 0;

                                        foreach($welcomeHotel_2 as $val){ 

                                            $i++;

                                            $yushu = $i%2;

                                            

                                       ?>

                                       <li><font class="f_b_f00" style="float:right;">¥<?php echo $val['min_jiage'] ?></font>

                                           <span class="hotname"><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName'] ?>"><?php echo $val['HotelName'] ?></a></span>

                                           <span class="weiz"><?php if(trim($val['esdname'],' ') != ''){ ?>位于：<a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>" title="<?php echo  $val['esdname'] ?>附近酒店"><?php echo  $val['esdname'] ?></a><?php }else{ ?><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['esdid']}") ?>">未知</a><?php } ?></span>

                                       </li>

                                       <?php if($yushu != 0){ ?><li class="line"></li><?php }} ?>

                                       <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的豪华型酒店!</center>"; } ?>

                                    </ul>

                           </div>

                         </div>

                         <div class="hot_box">

                             <div class="hot_plate">

                                <div class="hot_bt">最热门地标</div>

                                <div class="more"></div>

                             </div>

                             <div class="hot_db">

                                 <dl>

                                   <dt>

                                      商圈

                                   </dt>

                                   <dd>

                                         <ul id='hotcbd'>

                                            <?php 

                                            	if (!empty($getHotCBD)) {

                                                	foreach($getHotCBD as $val){ 

                                                    

                                            ?>

                                            <li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-cbd_id-{$val['cbd_id']}") ?>" title="<?php echo  $val['CBD_Name'] ?>附近酒店"><?php echo $val['CBD_Name'] ?></a></li>

                                            <?php } ?>

                                            <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的商圈信息!</center>"; } ?>

                                         </ul>

                                   </dd>

                                 </dl>

                                 <div class="lines"></div>

                                 <dl>

                                   <dt>

                                      景点

                                   </dt>

                                   <dd>

                                         <ul id="hotlable">

                                            <?php 

                                           	 if (!empty($getHotLable)) {

                                                foreach($getHotLable as $val){ 

                                                    

                                            ?>

                                            <li><a href="<?php  echo site_url("/hotellist/cityid-{$cityid}-keyid-{$val['id']}-pinyin-{$val['pinyin']}") ?>" title="<?php echo $val['name'][0] ?>附近酒店"><?php echo $val['name'][0] ?></a></li>

                                            <?php } ?>

                                            <?php } else {echo "<center class='warning1'>未找到{$cityInfo['cityname']}的景点信息!</center>"; } ?>

                                         </ul>

                                   </dd>

                                 </dl>    

                             </div>

                         </div>

                       </div>

                       <div class="" id="hothotel_div_loading2" style="display:none;">

							<p style="text-align:center;" ><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>

					   </div>

                   </div>



<script>

$(function(){

    var cid = "<?php echo $cityid; ?>";  

})

function ajax_get_hothotel(cid,$i){  

    var cid = cid;

    

    var listNum = "<?php echo $listNum ?>";    

    for (var i=1; i<=listNum; i++) {

        $('#hothotel_'+i).attr('class','');     

    }

    $('#hothotel_'+$i).attr('class','current');

    $.ajax({

		type: "GET",

		url: "<?php echo base_url() ?>index/ajax_get_hothotel?cid="+cid,

		beforeSend : function(msg)

		{

			$("#hothotel_div_loading1").hide();

			$("#hothotel_div_loading2").show();

		},

		success: function(msg)

		{

            var msg = $.parseJSON(msg); 

            $("#welcomeHotel_1").html(''); 

            $("#welcomeHotel_2").html(''); 

            $("#hotcbd").html(''); 

            $("#hotlable").html(''); 



            if (msg[0] != '') {

	            $.each(msg[0],function(i){

	            	var yushu = (i+1)%2;

	                var textinfo = '';

	                textinfo+="<li><font class='f_b_f00' style='float:right;'>¥"+msg[0][i]['min_jiage']+"</font>";

	                var welcomeHotel_a1 = 

	                textinfo+="<span class='hotname'><a href='<?php echo base_url() ?>hotelinfo/"+msg[0][i]['ID']+"<?php echo $this->config->item('url_suffix'); ?>' title='"+msg[0][i]['HotelName']+"'>"+msg[0][i]['HotelName']+"</a></span>";

	                if (msg[0][i]['esdname'].replace(/(^\s*)/g, "") == '') {

	                	textinfo+="<span class='weiz'><a href='<?php echo base_url() ?>hotellist/cityid-"+cid+"-cbd_id-"+msg[0][i]['esdid']+"<?php echo $this->config->item('url_suffix'); ?>'>"+'未知'+"</a></span>";

	                } else {

	                	var esdname = msg[0][i]['esdname'];

	                	textinfo+="<span class='weiz'>位于：<a href='<?php echo base_url() ?>hotellist/cityid-"+cid+"-cbd_id-"+msg[0][i]['esdid']+"<?php echo $this->config->item('url_suffix'); ?>' title='"+esdname+"附近酒店'>"+esdname+"</a></span>";

	                }

	                

	                textinfo+="</li>";

	                if(yushu != 0){ textinfo+="<li class='line'></li>" }; 

	                $("#welcomeHotel_1").append(textinfo); 

	            });

            } else {

            	$("#welcomeHotel_1").append("<center class='warning1'>未找到<?php echo $cityInfo['cityname'] ?>的经济型酒店!</center>"); 

            }



            if (msg[1] != '') {

	            $.each(msg[1],function(i){

	            	var yushu = (i+1)%2;

	                var textinfo = '';

	                textinfo+="<li><font class='f_b_f00' style='float:right;'>¥"+msg[1][i]['min_jiage']+"</font>";

	                textinfo+="<span class='hotname'><a href='<?php echo base_url() ?>hotelinfo/"+msg[1][i]['ID']+"<?php echo $this->config->item('url_suffix'); ?>'title='"+msg[1][i]['HotelName']+"'>"+msg[1][i]['HotelName']+"</a></span>";

	                if (msg[1][i]['esdname'].replace(/(^\s*)/g, "") == '') {

	                	textinfo+="<span class='weiz'><a href='<?php echo base_url() ?>hotellist/cityid-"+cid+"-cbd_id-"+msg[1][i]['esdid']+"<?php echo $this->config->item('url_suffix'); ?>'>"+'未知'+"</a></span>";

	                } else {

	                	var esdname = msg[1][i]['esdname'];

	                	textinfo+="<span class='weiz'>位于：<a href='<?php echo base_url() ?>hotellist/cityid-"+cid+"-cbd_id-"+msg[1][i]['esdid']+"<?php echo $this->config->item('url_suffix'); ?>' title='"+esdname+"附近酒店'>"+esdname+"</a></span>";

	                }

	                textinfo+="</li>";

	                if(yushu != 0){ textinfo+="<li class='line'></li>" }; 

	                $("#welcomeHotel_2").append(textinfo); 

	            });

            } else {

            	$("#welcomeHotel_2").append("<center class='warning1'>未找到<?php echo $cityInfo['cityname'] ?>的豪华型酒店!</center>"); 

            }



            if (msg[2] != '') {

	            $.each(msg[2],function(i){

	                var textinfo = '';

	        	    textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cid+"-keyid-"+msg[2][i]['cbd_id']+"<?php echo $this->config->item('url_suffix'); ?>' title='"+msg[2][i]['CBD_Name']+"附近酒店'>"+msg[2][i]['CBD_Name']+"</a></li>";

	                $("#hotcbd").append(textinfo); 

	            });

            } else {

            	$("#hotcbd").append("<center class='warning1'>未找到<?php echo $cityInfo['cityname'] ?>的商圈信息!</center>"); 

            }



            if (msg[3] != '') {

	            $.each(msg[3],function(i){

	                var textinfo = '';

	        	    textinfo+="<li><a href='<?php echo base_url() ?>hotellist/cityid-"+cid+"-keyid-"+encodeURI(msg[3][i]['id'])+"-pinyin-"+encodeURI(msg[3][i]['pinyin'])+"<?php echo $this->config->item('url_suffix'); ?>' title='"+msg[3][i]['name'][0]+"附近酒店'>"+msg[3][i]['name'][0]+"</a></li>";

	                $("#hotlable").append(textinfo); 

	            });	 

            } else {

            	$("#hotlable").append("<center class='warning1'>未找到<?php echo $cityInfo['cityname'] ?>的景点信息!</center>"); 

            }

            $("#hothotel_div_loading1").show();

        	$("#hothotel_div_loading2").hide();

        },

		timeout:20000,

		error: function () 

		{	

			alert("请求超时请重试!");

		}

	});	 

     

}

</script>