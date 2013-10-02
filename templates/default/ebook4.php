 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title>提交订单 -  <?PHP ECHO CFG_WEBNAME ?>住7送一-最实惠酒店预订平台</title>

<meta name="keywords" content="" />

<meta name="description" content="" />

<link href="<?php echo base_url();?>public/css/un_orderpage.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<style>
#book { width:950px;}
#book_top { background:#e0f5fc; color:#295574;}
#book_con {border: 6px solid #e0f5fc; border-width:0 6px 0 6px;}
#book_bot { background:#e0f5fc;}
</style>

<script src="<?php echo base_url();?>public/js/calendar.js" type="text/javascript"></script>
<script language="javascript">

$(function(){	
//加载日期控件	
	$('#eTm1,#eTm2').each(function(){
		$(this).focus(function(){
			if($(this).attr('id')=='eTm1'){
				showCalendar('eTm1','eTm2','re');
			}else{
				showCalendar('eTm2','','re');
			}
		})
		$(this).change(function(){
			
		})
	})
})


	 function checkfrm(){
		var a = false;
		$('#Err').remove();
		o = $('input[name="g_name[]"]');
		if(o.length==1){
			if($.trim(o.val())=='' || o.val().indexOf('客人姓名')!=-1){
				return new Array(o,'请填写实际入住客人的姓名，确保顺利入住');
			}
		}else{
			o.each(function(e){
				if($.trim($(this).val())=='' || $(this).val().indexOf('客人姓名')!=-1){								
					a = new Array($(this),"请填写实际入住客人的姓名，确保顺利入住");

					return false
				}else{
					var n = $('input[name="g_name[]"][value="'+$(this).val()+'"]');
					if(n.length>1){
						var room = '';
						n.each(function(){room += '房间'+$(this).attr('index')+' ';});
						err=room+'客人姓名重复，将给您的入住带来不便，请重新填写';
						var _o = $(n).eq(1).attr('index');
						_o = $('input[name="g_name[]"][index="'+_o+'"]');
						a = new Array(_o,err);
						return false;
					}			
				}								
			})
		}
		
		if(a){return a};
		
		o = $('#c_mobile');
		if (!new RegExp(/^1(3|4|5|8)\d{9}$/).test(o.val())){
			return new Array(o,'请输入有效的手机号码，方便您接收订单信息');
		}			
		o = $('#c_email');
		if(o.val()!=''&&!new RegExp(/^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/gi).test($('input[name="c_email"]').val())){
			return new Array(o,'请填写正确的联系人邮件地址');
		}		
		
		return true;			
	}
</script>
</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

    <?php $this->load->view('inc/nav');?>

    <div class="main">

        <div id="maincontent">

            <div id="content">

               
               <div id="book">
  <div id="book_top"><?php if($type==2){echo '订七送一领取';}else if($type==3){echo '订六送一领取';}?>
    <div class="corner1"></div>
    <div class="corner2"></div>
  </div>
  <form name="bookform" id="bookform" action="/ebook/save_order" method="POST"  >
    <div id="book_con">
      <div id="side">
        <div id="why_us">
          <h3>为什么选择我们？</h3>
                    <dl>
            <dt>低价高返现</dt>
            <dd>保证预订价绝不高于前台现付价，否则赔付您三倍差额；返现无需点评，最高返18%</dd>
          </dl>
          <dl>
            <dt>订七送一</dt>
            <dd>通过携行累计预订七间夜并入住赠送一天，通过携行连续预订六天并入住赠送一天，不同城市不同酒店均可累计</dd>
          </dl>
          <dl> 
            <dt>0元试住</dt>
            <dd>0元试住无门槛，真正免费住酒店，最多可提前十天申请预订</dd>
          </dl>
		    <dl> 
            <dt>免费接送</dt>
            <dd>通过携行订酒店，携行官方车辆免费接送，限机场和火车站（待开通）</dd>
          </dl>
		  <dl> 
            <dt>赠礼品</dt>
            <dd>礼品无需积分兑换，无需支付快递费，携行网帮您快递到家</dd>
          </dl>
        </div>
        
        
      	
        
      </div>
      <div id="main">
        <div class="box">
<div class="sq_con"><?php if($type==2){?><strong>住七送一</strong>：您已累计入住<font color="#FF0000"><?php echo $userinfo['leijifang_num'] ?></font>日间，成功获得赠送房<font color="#FF0000"><?php echo $userinfo['leijishenqing'] ?></font>日间，还可以领取<font color="#FF0000"><?php echo floor(($userinfo['leijifang_num']-$userinfo['leijishenqing']*7)/7) ?></font>日间免费房<?php }else{?>
  <strong>住六送一</strong>：您已连续入住<font color="#FF0000"><?php echo $userinfo['lianxufang_num'] ?></font>日间，<?php if($userinfo['lianxufang_num']<6){?>再续住<font color="#FF0000"><?php echo 6-$userinfo['lianxufang_num'] ?></font>日间您就可以领取<font color="#FF0000">1</font>日间赠送房<?php }else{?>可以领取<font color="#FF0000"><?php echo floor($userinfo['lianxufang_num']/6) ?></font>日间赠送房<?php }?><?php }?></div>
<div class="box">
          <h3>入住信息</h3>
          <div class="box_con">
           <dl>
              <dt>房间数量：</dt>
              <dd>
              
                <select id="roomnum" name="roomnum" class="fi_s1">
                  <option value="1" selected="selected">1间</option>
                  <option value="2">2间</option>
                  <option value="3">3间</option>
                  <option value="4">4间</option>
                  <option value="5">5间</option>
                  <option value="6">6间</option>

                </select>
                
               </dd>
              <dd id='suggestion' style="display:none"></dd>
            </dl>
            <dl>
              <dt>入住时间：</dt>
              <dd>
               
                <input name="eTm1" type="text"  id="eTm1" class="input_time" size="16" readonly="readonly" />
                入住　
                <input name="eTm2" type="text"  id="eTm2" class="input_time" size="16" readonly="readonly" />
                退房
               
                </dd>
            </dl>
            <dl>
              <dt class="text_down">客人姓名：</dt>
              <dd>
                <input name="g_name[]" type="text" class="input_text" id="g_name" style="margin-right:10px;margin-bottom:10px;" value="" index="1" />
                <br />
                <span class="warning" style="position:relative; top:-6px;">每个房间只填写一个入住人姓名即可<span class="needTips" name='needTips' msg="如果您是两个人入住一间房，每个房间只需填写一个入住人的姓名。<br />如果您是帮朋友订的，请填写您朋友的姓名。" msg_w='380'></span></span>
                <div id="g_nametips"></div>
              </dd>
            </dl>
            <dl>
              <dt class="text_down">联系手机：</dt>
              <dd>
                <input name="mobile" type="text" class="input_text1" id="mobile" maxlength="11">
                <span class="warning">(用于接收订单确认短信)</span> </dd>
            </dl>
            <dl>
              <dt class="text_down">Email：</dt>
              <dd>
                <input name="c_email" type="text" class="input_card1" id="c_email" value="" size="30" />
                <span class="warning"> (建议填写)</span> </dd>
            </dl>
            
                        <dl>
                     
               <dt>房间保留时间：</dt>
              <dd style="line-height:22px"> 18:00</dd>
             
            </dl>
            <dl>
              <dt>&nbsp;</dt>
              <dd id="citips">
                <div class="tips" id='checkinTips'>务必在18：00之前到达酒店，如不能请及时到达通知携行或与酒店联系</div>
              </dd>
            </dl>
          </div>
          
          <div class="submit">
            <dl style="padding:15px 0;">
              <dt>&nbsp;</dt>
              <dd id="subbtn">
             <?php if(($type==2 &&floor(($userinfo['leijifang_num']-$userinfo['leijishenqing']*7)/7)<1)||($type==3 && floor($userinfo['lianxufang_num']/6)<1)){?>
                <input type="submit" class="btn1" name="btn1" id="btn1" value="立即领取" disabled="disabled"/>
                <span style=" position:relative; top:5px; color:#666;">您还未达到领取条件，继续努力吧</span></dd>
                <?php }else {?>
                   <input type="submit" class="btn" name="btn1" id="btn1" value="立即领取"/>
                <span style=" position:relative; top:-10px; color:#666;"></span></dd>
                <?php }?>
            </dl>            
            <dl>
              <dt>&nbsp;</dt>
              <dd> </dd>
			  <dd> </dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
     <input type="hidden" name="type" id="type" value="<?php echo $this->input->get('type'); ?>" />
    <input type="hidden" name="z[hid]" id="z[hid]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="z[Address]" id="z[Address]" value="<?php echo $Address ?>" />
    <input type="hidden" name="z[rid]" id="z[rid]" value="<?php echo $rid ?>" />
    <input type="hidden" name="z[hotelname]"  id="z[hotelname]" value="<?php echo $HotelName ?>" />
    <input type="hidden" name="z[roomname]"  id="z[roomname]"value="<?php echo $freeroom['R_RoomName'] ?>" />
    <input type="hidden" name="z[pid]" id="z[pid]" value="<?php echo $pid ?>" />
    <input type="hidden" name="ordertmp[HotelId]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[RoomTypeId]" value="<?php echo $rid ?>" />
    <input type="hidden" name="ordertmp[RoomName]" value="<?php echo $freeroom['R_RoomName']  ?>" />
    <input type="hidden" name="ordertmp[CheckInDate]" value="<?php echo $tm1 ?>" />
    <input type="hidden" name="ordertmp[CheckOutDate]" value="<?php echo $tm2 ?>" />
    <input type="hidden" name="nAuth" value="" />
	<input type="hidden" name="ConfirmTypeCode" value="sms" />
    <input type="hidden" name="ArriveTime" value="18：00" />
    <input type="hidden" name="ordertmp[type]" value="<?php echo $type ?>" />
	
    <input type="hidden" id="UserID" name="UserID" value="<?php echo $hotelid ?>"/>
  </form>


  <div id="book_bot"><div class="corner3"></div><div class="corner4"></div></div>
</div>

            </div>

        </div>   

    </div>

</div>
<div id="test"></div>
<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

</body>

</html>