<?php 

    $ci = & get_instance();

    $ci->load->model('model_common');

    $ci->load->model('model_city');

    

    $cityInfo = $ci->model_common->initCityinfo();

    $cityid = $cityInfo['cityid'];

    

    //搜索块默认值

    $searchArray = $ci->model_common->setLeftSearch(array('cityid'=>$cityid));

    $cityJson = json_encode(array('id'=>$searchArray['cityid'],'cityname'=>$searchArray['cityname']));

    //搜索块酒店数目

    $api = file_get_contents("http://union.api.zhuna.cn/hotel/json/index.json");

    $listresult = json_decode($api,true);

    $allnums = count($listresult);

    //搜索块到热门城市列表

    $hotCityList = $ci->model_city->getHotCity(6);

?>

<div class="i_s_left">

<div class="dp">

  全国<font class="f_b1_f00">共有<?php echo $allnums ?></font>&nbsp;<font class="gray">家酒店</font>

  <!--&nbsp;&nbsp;<font class="f_b1_f00">271151</font>&nbsp;<font class="gray">条入住客人点评</font>-->

</div>

<div class="ser_plates">

      <form id="form_hotel" name="form_hotel" method="post" action="<?php  echo site_url("/hotellist") ?>">

         <div class="srh_con">

            <ul>

                <li>

                  <label for="city"><font style="color:#ff0000;">*</font>选择城市：</label>

                  <div class="srh_box">

                        <div class="input_01">

                             <div class="input_001">

                                <span class="sicon" onclick="focus_txtCity()"></span>

                             </div>

                        </div>

                        <input name="cityid" id="cityid" type="hidden" autocomplete="off" value="<?php echo $searchArray['cityid'] ?>" />

                        <input name="txtCity" id="txtCity" type="text" autocomplete="off" value="<?php echo $searchArray['cityname'] ?>" class="input_city"/>

                  </div>                                                                                    

                </li>

                <li>

                  <label for="city"><font style="color:#ff0000;">*</font>入住日期：</label>

                  <div class="srh_box">

                        <div class="input_01">

                             <div class="input_001">

                                <span class="sicon_02" onclick="javascript:event.cancelBubble=true;showCalendar('txtComeDate',false,'txtComeDate','txtOutDate','txtOutDate','<?php echo $searchArray['tm1'] ?>','','','','','text','')"></span>

                             </div>

                        </div>

                        <input name="tm1" type="text" value="<?php echo $searchArray['tm1'] ?>" id="txtComeDate" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('txtComeDate',false,'txtComeDate','txtOutDate','txtOutDate','<?php echo $searchArray['tm1'] ?>','','','','','text','')"/>

                  </div>

                </li>

                <li>

                  <label for="city"><font style="color:#ff0000;">*</font>退房日期：</label>

                  <div class="srh_box">

                        <div class="input_01">

                             <div class="input_001">

                                <span class="sicon_03" onclick="javascript:event.cancelBubble=true;showCalendar('txtOutDate',false,'txtOutDate','','','<?php echo $searchArray['tm2'] ?>','','','','','text','')"></span>

                             </div>

                        </div>

                        <input name="tm2" type="text" value="<?php echo $searchArray['tm2'] ?>" id="txtOutDate" class="input_city" onClick="javascript:event.cancelBubble=true;showCalendar('txtOutDate',false,'txtOutDate','','','<?php echo $searchArray['tm2'] ?>','','','','','text','')"/>

                  </div>

                </li>

                <li>

                  <label for="city">酒店位置：</label>

                  <div class="srh_box">

                        <div class="input_01">

                             <div class="input_001">

                                <span class="sicon_05"></span>

                             </div>

                        </div>

                        <input name="key" id="key" type="text"  value="<?php if($searchArray['key'] != ''){ echo $searchArray['key']; }else{ echo "街道/地标/建筑物"; } ?>" class="input_city" />

                  </div>

                </li>

                <li>

                  <label for="city">酒店名称：</label>

                  <div class="srh_box">

                        <div class="input_01">

                             <div class="input_001">

                                <span class="sicon_05"></span>

                             </div>

                        </div>

                        <input name="hn" id="hn" type="text"  value="<?php if($searchArray['hn'] != ''){ echo $searchArray['hn']; }else{ echo "如：如家"; } ?>" class="input_city" />

                  </div>

                </li>

                <li>

                  <label for="city">价格范围：</label>

                  <div class="srh_box1">

                        <input type="text"  class="srh_input2" name="minprice" id="minprice" value="<?php echo $searchArray['minprice'] ?>">&nbsp;至&nbsp;<input type="text"  class="srh_input2" name="maxprice" id="maxprice" value="<?php echo $searchArray['maxprice'] ?>">

                        

                  </div>

                 

                </li>

                <li>

                   <input onclick="hotel_get()" type="button"  class="src_btn" value="" />

                </li>

            </ul>

         </div>

      </form>

</div>

<div class="inhot_city">

<font style="color:#979797;">热门城市：</font>

<?php foreach($hotCityList as $val){ ?>

<a href="<?php  echo site_url("/hotellist/cityid-{$val['cid']}") ?>"><?php echo $val['cName'] ?></a>

<?php } ?>

<a href="<?php echo site_url('allcity') ; ?>">更多>></a> 

</div>

</div>



<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>

<!--选择时间用到的js-->

<?php $order_api = 'http://price.un.zhuna.cn/'; ?>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<script src="<?php echo $order_api ?>room.utf8.js" type="text/javascript"></script>

<link href="<?php echo $order_api ?>room.utf8.css" rel="stylesheet" type="text/css" />

<!--选择城市用到的js-->

<script type="text/javascript" src="http://tp1.znimg.com/javascript/public/js/city_ca_main.min.js"></script>

<script language="javascript" >

//选择城市

var def= <?php echo $cityJson ?> ;

new cityCA("#txtCity",function(data){

    $("#cityid").val(data&&data["eid"]||"");

    if(data){

        var id=data["id"];

    }else{

    	$("#cityid").val(def.id);

    	$("#txtCity").val(def.cityname);  

    }

},{

    "ca":{"border":"1px solid #1364a9"},//最外层边框颜色

    "title":{"color":"#000","background":"#E6F0FD"},//标题

    "hotCity":{"over":{"color":"#ff0000"},"out":{"color":"#FFF"}},//导航鼠标选择

    "seleNav":{"border":"1px solid #1364a9","background":"red"},//导航选择

    "seleContent":{"border":"1px solid #1364a9","background":"#E6F0FD"},//城市选择

    "navFrame":{"border-bottom":"1px solid #1364a9","background":"#1776c6"},//导航外框

    "city":{"color":"#1776c6","z-index":5},//城市

    "content":{}//城市选择框

});

function focus_txtCity() {

	$("#txtCity").focus();

}

//处理地标和酒店名称js

$("#key").click(function(){

    if ($("#key").val() === "街道/地标/建筑物") {

        $("#key").attr("value","");

    }  

});

$("#hn").click(function(){

    if ($("#hn").val() === "如：如家") {

        $("#hn").attr("value","");

    } 

});

$("#hotelSubmit").click(function(){

    if ($("#hn").val() === "如：如家") {

        $("#hn").attr("value","");

    }

    if ($("#key").val() === "街道/地标/建筑物") {

        $("#key").attr("value","");

    }  

});

function hotel_get() {

	var cityid = $("#cityid").val();

	var tm1 = $("#txtComeDate").val();

	var tm2 = $("#txtOutDate").val();

	var key = $("#key").val();

	var hn  = $("#hn").val();

	var minprice = $("#minprice").val();

	var maxprice = $("#maxprice").val();

	

	var urlpara = 'cityid-'+cityid;

	if (key != "街道/地标/建筑物" && key != '') {

		urlpara += "-key-"+encodeURI(key);

	} 

	if (hn != '如：如家' && hn != '') {

		urlpara += "-hn-"+encodeURI(hn);

	} 

	if (minprice != '') {

		urlpara += "-minprice-"+minprice;

	}

	if (maxprice != '') {

		urlpara += "-maxprice-"+maxprice;

	}

	$.ajax({

		type: "GET",

		url: "<?php echo base_url() ?>ajax_action/ajax_set_time?tm1="+tm1+"&tm2="+tm2,	

		success: function(data)

		{

			window.location = "<?php echo base_url() ?>hotellist/"+urlpara+"<?php echo $this->config->item('url_suffix') ?>";	

        }

	});	

}

</script>

                

                