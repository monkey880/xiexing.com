 <div class="tjjd">

  <div class="dianping"> <span class="more"><a href="<?php  echo site_url("/allcity") ?>">更多</a></span>

    <ul class="citybg">

      <?php 

        $ci = & get_instance();

        $ci->load->model('model_common');

        $ci->load->model('model_city');

        $ci->load->library('tool');

        

        $cityInfo = $ci->model_common->initCityinfo();

        $cityid = $cityInfo['cityid'];

        

        //热门城市列表

        $hotCityList = $ci->model_city->getInitCityList();

        $listNum = count($hotCityList);

        

        $tuijianHotelList = $ci->model_common->getTuijianHotel($cityid);

        foreach($tuijianHotelList as $key=>$val){

            $tuijianHotelList[$key]['df_haoping']=$this->tool->hoteldianping($val['df_haoping'],2);    

            $tuijianHotelList[$key]['xingji']=$this->tool->hotelrankname($val['xingji']);    

        }

        

        $i = 0;

        foreach($hotCityList as $val){ 

            $i++;

      ?>                                          

      <li <?php if($val['cityid'] == $cityid){ ?>class="current"<?php } ?> onclick="ajax_get_tuijianhotel('<?php echo $val['cityid'] ?>',<?php echo $i ?>)" id="tuijian_<?php echo $i ?>"><a href="javascript:void(0)" ><?php echo $val['cityname'] ?></a></li>

      <?php } ?>

      <!--<li class="current">北京</li>-->

    </ul>

    <span><font style="color:#f60;">推荐</font>酒店</span>

  </div>

  

  <div class="tjbotm" id="tuijianhotel_div_loading1">

    <?php 

        foreach ($tuijianHotelList as $key=>$val){

    ?>

    <div class="tjplate">

       <dl>

        <dt><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName']; ?>"><img src="<?php echo $val['Picture']  ?>" width="147" height="112" alt="<?php echo $val['HotelName']; ?>" /></a></dt>

        <dd>

          <ul>

            <li class="tjbt"><a href="<?php  echo site_url("/hotelinfo/{$val['ID']}") ?>" title="<?php echo $val['HotelName']; ?>"><?php echo $val['HotelName']  ?></a></li>

            <li>类型：<?php echo $val['xingji']  ?></li>

            <li>价格：<font class="f_b1_f00">￥<?php echo $val['min_jiage']  ?></font>起</li>

            <li>好评：<font class="f_b1_f00"><?php echo $val['df_haoping'][0]  ?></font></li>

            <li>位置：<?php echo $val['Address']  ?></li>

          </ul>

        </dd>

      </dl>

       <div class="yinying"></div>

    </div>

    <?php } ?>

  </div>

  <div class="" id="tuijianhotel_div_loading2" style="display:none;">

	<p style="text-align:center;" ><img src="<?php echo base_url();?>public/www/default/images/loadprice.gif" /></p>

  </div>

  

</div>

<script>

function ajax_get_tuijianhotel(cid,$i){

    

    var listNum = "<?php echo $listNum ?>";    

    for (var i=1; i<=listNum; i++) {

        $('#tuijian_'+i).attr('class','');     

    }

    $('#tuijian_'+$i).attr('class','current');

    

    $.ajax({

		type: "GET",

		url: "<?php echo base_url() ?>index/ajax_get_tuijian?cid="+cid,

		beforeSend : function(msg)

		{

			$("#tuijianhotel_div_loading1").hide();

			$("#tuijianhotel_div_loading2").show();

		},

		success: function(msg)

		{

		    var msg = $.parseJSON(msg);  

            $("#tuijianhotel_div_loading1").html(''); 

            $.each(msg,function(i){

                var textinfo = '';

        	    textinfo+="<div class='tjplate'>";

                textinfo+="   <dl>";

                textinfo+="    <dt><a href='<?php echo base_url() ?>hotelinfo/"+msg[i]['ID']+"<?php echo $this->config->item('url_suffix'); ?>' title='"+msg[i]['HotelName']+"'><img src="+msg[i]['Picture']+" width='147' height='112' alt='"+msg[i]['HotelName']+"' /></a></dt>";

                textinfo+="    <dd>";

                textinfo+="      <ul>";

                textinfo+="        <li class='tjbt'><a href='<?php echo base_url() ?>hotelinfo/"+msg[i]['ID']+"<?php echo $this->config->item('url_suffix'); ?>' title='"+msg[i]['HotelName']+"'>"+msg[i]['HotelName']+"</a></li>";

                textinfo+="        <li>类型："+msg[i]['xingji']+"</li>";

                textinfo+="        <li>价格：<font class='f_b1_f00'>￥"+msg[i]['min_jiage']+"</font>起</li>";

                textinfo+="        <li>好评：<font class='f_b1_f00'>"+msg[i]['df_haoping'][0]+"</font></li>";

                textinfo+="        <li>位置："+msg[i]['Address']+"</li>";

                textinfo+="      </ul>";

                textinfo+="    </dd>";

                textinfo+="  </dl>";

                textinfo+="   <div class='yinying'></div>";

                textinfo+="</div>";

                

                $("#tuijianhotel_div_loading1").append(textinfo); 



                $("#tuijianhotel_div_loading1").show();

	        	$("#tuijianhotel_div_loading2").hide();

            });	

        },

		timeout:20000,

		error: function () 

		{	

			alert("请求超时请重试!");

		}

	});	 

     

}

</script>