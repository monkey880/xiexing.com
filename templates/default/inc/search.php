<div class="se_search">

   <form id="form_hotel" name="form_hotel" method="post" action="<?php  echo site_url("/hotellist") ?>">

             <div class="ser_con">

                

                <ul class="cd">

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

                    

                </ul>

                <ul class="an">

                    <li>

                       <input onclick="hotel_get()" type="button"  class="src_btn" value="" />

                    </li>

                </ul>

             </div>

   </form>

</div>

<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>

<!--选择时间用到的js-->

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

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

function hotel_get() {

	var cityid = $("#cityid").val();

	var tm1 = $("#txtComeDate").val();

	var tm2 = $("#txtOutDate").val();

	var key = $.trim($("#key").val());

	var hn  = $.trim($("#hn").val());

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