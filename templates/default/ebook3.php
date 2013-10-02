 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title>提交订单 -  <?PHP ECHO CFG_WEBNAME ?>住7送一-最实惠酒店预订平台</title>

<meta name="keywords" content="" />

<meta name="description" content="" />

<link href="http://tp1.znimg.com/css/un_orderpage.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<style>
#book { width:950px;}
#book_top { background:#e0f5fc; color:#295574;}
#book_con {border: 6px solid #e0f5fc; border-width:6px 6px 6px 6px;}
#book_bot { background:#e0f5fc;}
</style>


<script language="javascript">

var s = {agent_id:'<?php echo $agent_id ?>',agent_md:'<?php echo $agent_md ?>',uid:'<?php echo $uid ?>',hid:'<?php echo $hotelid ?>',rid:'<?php echo $rid ?>',pid:'<?php echo $pid ?>',tm1:'<?php echo $tm1 ?>',tm2:'<?php echo $tm2 ?>',style:'950%2Caacbee%2Ce0f5fc%2C295574',webpath:'www.xexing.com'};
var ip = '222.64.15.158';var r_domain = 'http://www.xexing.com/';var pUrl = 'post.php?webpath=www.xexing.com/&style=950,aacbee,e0f5fc,295574';
var guid ='01c310ea-3746-fce4-841d-b693c974ec2f';
</script>
<script src="http://tp1.znimg.com/javascript/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="http://tp1.znimg.com/javascript/json.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/calendar.js" type="text/javascript"></script>
<script language="javascript">
var timer = 0;
var _order,joke;
var user = '';
var _cookie = 'z_'+s.hid+'_'+s.rid+'_'+s.pid;
var db = 0;
var np = 0;
var _7dayhotel = 0;



var order = function(){
	//this.subStatus = 0;
	this.uSub = new Array();
	this.subCnt = 0; 
	this.maxSubT = 7;
	this.subAg = 1;
	this.OrderServer = new Array('www','b','www','b','www','b','www','b');											//订单服务器

	this.timer = '';
	this.oi	= '';																					//订单统计信息
	this.orderTimer = 60000;																		//订单超时间隔
	
		
	this.subOrder = function(){
		var chk = this.chkfrm();
		if(chk!==true){
			showErr(chk[0],chk[1]);
		}else{
			this.order();
			var thisDialog = new dialog();
			thisDialog.title = '正在提交您的订单...请稍候';
			thisDialog.msg = '<div class="loading"><img src="http://tp1.znimg.com/images/new/pbar-ani.gif"></div><div id="loaddes"></div>';
			thisDialog.width = 550;
			thisDialog.showJoke = true;
			thisDialog.show();
		}
	}
		
	
	this.chkfrm = function(){
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
		if($('#hotels_po:hidden').length==0){
			o = $('#pu_cardno');
			tips = o.next('span');	
			if (o.val().length<10){
				return new Array(o,'请填写用于担保使用的信用卡卡号');
			}		
			o = $('#pu_code');
			tips = o.next('span');	
			if (o.val().length!=3){
				return new Array(o,'CVV2码是在信用卡背面的签名栏上紧跟在卡号末四位号码的后面印刷的3位数字');
			}					
			o = $('#pu_name');
			tips = o.next('span');
			if ($.trim(o.val())==''){
				return new Array(o,'请填写信用卡开卡人的姓名');
			}					
			o = $('#pu_idno');
			tips = o.next('span');
			if ($.trim(o.val())==''){
				return new Array(o,'请填写信用卡开卡使用的证件号码');
			}else{
				if($('#pu_idtype').val()==0){
					if($.trim(o.val()).length!=18&&$.trim(o.val()).length!=15){
						return new Array(o,'请检查身份证号码是否填写正确');
					}
				}
			}
		}else{
			if(_7dayhotel==1){
				o = $('#pu_idno');
				tips = o.next('span');
				if ($.trim(o.val())==''){
					return new Array(o,'请填写证件号码');
				}else{
					if($('#pu_idtype').val()==0){
						if($.trim(o.val()).length!=18&&$.trim(o.val()).length!=15){
							return new Array(o,'请检查身份证号码是否填写正确');
						}
					}
				}
			}
		}		
		return true;			
	}
	
	this.getInfo = function(){		
		if(this.oi){			
			this.oi.status = 'timeout';
			//提交统计数据
			this.collect();
			this.oi.t1 = new Date().pattern("yyyy-MM-dd HH:mm:ss");		
			this.oi.server = this.OrderServer[Math.floor(Math.random()*this.OrderServer.length)];
			$('#bookform').attr('action','/ebook/save_order');
			this.oi.n += 1;
		}else{
			$('#bookform').attr('action','/ebook/save_order');
			this.oi = {n:1,status:'',rp:$('#rid_pid').val()};
			var _u = '';
			$('input[name="g_name[]"]').each(function(){_u+=$(this).val()+','});
			this.oi.user = encodeURI(_u);
			this.oi.arr = $('input[name="ArriveTime"]:checked').val();
			this.oi.t1 = new Date().pattern("yyyy-MM-dd HH:mm:ss");
			this.oi.mobile = $('#c_mobile').val();
			this.oi.guid = guid;
			this.oi.server = this.OrderServer[0];
			this.oi.ip = ip;
			this.oi.act = 'oSub';
			this.oi.db = db?1:$('#hotels_po:hidden').length==0?2:0;
		}
	}
	
	this.order = function(){
		if(this.subCnt < this.maxSubT && this.subAg){
			this.subCnt ++;
			this.getInfo();
			$('#bookform').submit();
			var o = this;	
			//window.clearTimeout(this.timer);		
//			this.timer = window.setTimeout(function(){o.order()},this.orderTimer);			
		}else{
			if(this.subAg){
				var msg = "非常抱歉，您的订单未能成功提交，请拨打免费电话400-600-2069进行预订";
				var thisDialog = new dialog('订单提交失败',msg);
				thisDialog.setWidth(550).setButton('返回修改订单信息',function(){thisDialog.close()}).setClose(true).show();
			}
		}
	}	
	
	
}





function _su(d){
	_order.result = d;
	if(d.eid){
		_order.oi.status = 'OK';
		_order.oi.eid = d.eid;
		_order.oi.key = d.key;
		//提示成功
		//var thisDialog = new dialog('提交成功','您的订单(<span>订单号：'+d.eid+'</span>)已经提交成功，预订成功后我们会以短信形式向您告知，请保持您的手机开机，或者您可以 <a href="isok.php?fid='+d.eid+'&md='+d.key+'">点击此处查看订单处理详情</a><br>正在跳转至订单详情页面...');
		//thisDialog.setWidth(550).setButton('查看订单处理详情',function(){top.location='isok.php?fid='+d.eid+'&md='+d.key;}).show();
		window.clearTimeout(_order.timer);				
	}else{
		if(d.repost){
			_order = new order();
			_order.subOrder();
		}else{
			//提示错误
			_order.oi.status = d.errid;
			_order.oi.errMsg = d.msg;
			var msg = d.errid == 99?'非常抱歉，您的订单由于"'+d.msg+'"原因没有提交成功，建议您拨打免费电话400-600-2069进行预订或咨询':d.errmsg;
			var thisDialog = new dialog('订单提交失败',msg);
			thisDialog.setWidth(550).setButton('返回修改订单信息',function(){thisDialog.close()}).setClose(true).show();
			window.clearTimeout(_order.timer);
		}		
	}	
	_order.collect();
	_order.subAg = 0;
	if(d.eid){
		var _wp = s.webpath?s.webpath:'';
		window.setTimeout(function(){location.href='/e/isok.php?fid='+d.eid+'&md='+d.key+'&webpath='+_wp},2000);
	}
	
}


var dialog = function (title,des){
	this.title = title;
	this.msg = des;
	this.url = '';
	this.closeButton = false;
	this.showJoke = false;
	this.width = 0;
	this.height = 0;
	this.button = [];
	this.buttonAction= '';
	this.setAugs = function(title,msg,showjoke){
		this.title = title?title:'';
		this.msg = msg?msg:'';
		this.showjoke = showjoke?true:false;
		return this;
	}
	this.setTitle = function(title,msg,showjoke){
		this.title = title?title:'';
		return this;
	}
	this.setDes = function(msg){
		this.msg = msg?msg:this.msg;
		return this
	}
	this.setJoke = function(joke){
		this.showjoke = joke?true:false;
		return this;
	}	
	this.setWidth = function(w){
		this.width = w?w:this.width;
		return this;
	}
	this.setHeight = function(h){
		this.height = h?h:this.height;
		return this;
	}
	this.setUrl = function(u){
		this.url = u?u:this.url;
		return this;
	}
	this.setClose = function(Close){

		this.closeButton = Close?true:false;
		return this;
	}
	this.setButton = function(d,fn){
		if(d){
			this.button.push(new Array(d,fn));
		}
		return this;
	}
	this.show = function(){
		this.close();
		$('<div>').attr({'class':'transparent','id':'bigFrame'}).css({height:document.body.scrollHeight,width:document.body.scrollWidth}).appendTo('body').bgiframe();
		var _dialog = $('<div>').attr('id','dialog');		
		if(this.title) $('<div>').attr('id','dialogtitle').html(this.title).appendTo(_dialog);
		if(this.msg) $('<div>').attr('id','des').html(this.msg).appendTo(_dialog);
		_dialog.appendTo('body');		
		this.width?_dialog.css({'width':this.width}):function(){};
		this.height?_dialog.css({'height':this.height}):function(){};
		if(this.showJoke){
			var o = this;
			if(!joke){
				jQuery.getScript("http://www.zhuna.cn/javascript/joke.php",function(){
					o.ostats();
				});
			}else{
				o.ostats();
			}			
		}		
		if(this.closeButton){
			var o = this;
			$('<div>').css({position:'absolute',top:6,right:6,float:'right',cursor:'pointer'}).html('关闭').click(function(){o.close()}).appendTo(_dialog);
		}
		if(this.url){
			$('<iframe>').attr({id:'if1',marginwidth:'0',name:'if1',marginheight:'0',frameborder:'0',width:this.width,height:this.height,scrolling:'no',src:this.url,hspace:'0'}).appendTo(_dialog);
		}
		
		if(this.button.length>0){
			var ota = $('<div>').attr('id','otherAct');
			ota.appendTo(_dialog);
			for(i=0;i<this.button.length;i++){
				$('<span>').attr('class','otherAct_btn').click(this.button[i][1]).html('<em>'+this.button[i][0]+'</em>').appendTo(ota);
			}
			//alert(this.button.length);
			//$('#otherAct').html(btnstr);		
		}
		this.setPos();
		return this;
	}
	this.close = function(){
		$('#bigFrame').remove();$('#dialog').remove();
	}
	this.ostats = function(){
		var o = this;
		try{	
			var _ns = Math.floor(Math.random()*joke.length);
			$('#loaddes').fadeOut(1000,function(){				
			$('#loaddes').html(joke[_ns]);
			$('#loaddes').fadeIn(1000);			
			});
		}catch(e){}
	
		setTimeout(function(){o.ostats()},10000);	
	}	
	this.setPos = function(){
		var o = $('#dialog');
		var b = (document.documentElement||document.body);
		var w = o.width();		
		var h = o.height();		
		var _top = b.clientHeight>h?(b.clientHeight-h)/2:0;		
		if($.browser.msie && $.browser.version=='6.0'){ _top= b.clientHeight>h?(b.clientHeight-h)/2+b.scrollTop:0;}
		var _left  = b.clientWidth>w?(b.clientWidth-w)/2+b.scrollLeft: 0;
		if(_top>80){_top = _top-80}
		o.css({'left':_left,'top':_top});
	}	
}

function readCookie(n){var cookieValue = "";var search = n + "=";if(document.cookie.length > 0){ offset = document.cookie.indexOf(search);if (offset != -1){ offset += search.length;end = document.cookie.indexOf(";", offset);if (end == -1) end = document.cookie.length;cookieValue = unescape(document.cookie.substring(offset, end))}}return cookieValue;};
function writeCookie(n,v,h){var expire = "";if(h != null){expire = new Date((new Date()).getTime() + h * 3600000);expire = "; expires=" + expire.toGMTString();}document.cookie = n + "=" + escape(v) + expire;}
function keepCookie(){
	var a = '_';
	$('#rid_pid,#roomnum,#eTm1,#eTm2,#c_mobile,#c_email,[name="g_name[]"]').each(function(i){		
		if($(this).attr('name')=='g_name[]'){
			if($(this).val()!='' && $(this).val().indexOf('客人')==-1){
				s = $(this).val();
				var _uk = $(this).next().attr('name')=='g_name[]'?',':'_';				
				a += s+_uk;
			}else{
				a += '_';
			}			
		}else{
			a += $(this).val()+'_';
		}
	});
	writeCookie(_cookie,a,1);
}
Date.prototype.dateAdd = function(interval,number){
	var d = this;
	var k={"y":"FullYear", "q":"Month", "m":"Month", "w":"Date", "d":"Date", "h":"Hours", "n":"Minutes", "s":"Seconds", "ms":"MilliSeconds"};
	var n={"q":3, "w":7};
	eval("d.set"+k[interval]+"(d.get"+k[interval]+"()+"+((n[interval]||1)*number)+")");
	return d;
};

Date.prototype.pattern=function(fmt) {        
    var o = {        
    "M+" : this.getMonth()+1, //月份        
    "d+" : this.getDate(), //日        
    "h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12, //小时        
    "H+" : this.getHours(), //小时        
    "m+" : this.getMinutes(), //分        
    "s+" : this.getSeconds(), //秒        
    "q+" : Math.floor((this.getMonth()+3)/3), //季度        
    "S" : this.getMilliseconds() //毫秒        
    };        
    var week = {        
    "0" : "\u65e5",        
    "1" : "\u4e00",        
    "2" : "\u4e8c",        
    "3" : "\u4e09",        
    "4" : "\u56db",        
    "5" : "\u4e94",        
    "6" : "\u516d"       
    };        
    if(/(y+)/.test(fmt)){        
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));        
    }        
    if(/(E+)/.test(fmt)){        
        fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "\u661f\u671f" : "\u5468") : "")+week[this.getDay()+""]);        
    }        
    for(var k in o){        
        if(new RegExp("("+ k +")").test(fmt)){        
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));        
        }        
    }        
    return fmt;        
};

function dbtjformat(s) {
	 var test = /((\d+)\.(\d+)\.(\d+))|((\d+):(\d+))/g;    // 初始化模式。
  	 return(s.replace(test,function($0,$1,$2) {return ('<b>'+$0+'</b>');}));
}

function showErr(o,str){
	$("#Err").remove();
	var offset = o.offset();
	$('<div class="errArrow" id="Err"><div class="errdes">'+str+'</div></div>').appendTo('body');
	$('#Err').bgiframe();
	$("#Err").css({'left':offset.left,'top':offset.top-35});
	window.setTimeout(function(){$('#Err').fadeOut(1000)},3000);
	o.focus();
}

//jquery bigframe
(function($){

$.fn.bgiframe = ($.browser.msie && /msie 6\.0/i.test(navigator.userAgent) ? function(s) {
    s = $.extend({
        top     : 'auto', // auto == .currentStyle.borderTopWidth
        left    : 'auto', // auto == .currentStyle.borderLeftWidth
        width   : 'auto', // auto == offsetWidth
        height  : 'auto', // auto == offsetHeight
        opacity : true,
        src     : 'javascript:false;'
    }, s);
    var html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+s.src+'"'+
                   'style="display:block;position:absolute;z-index:-1;'+
                       (s.opacity !== false?'filter:Alpha(Opacity=\'0\');':'')+
                       'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+
                       'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+
                       'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+
                       'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+
                '"/>';
    return this.each(function() {
        if ( $(this).children('iframe.bgiframe').length === 0 )
            this.insertBefore( document.createElement(html), this.firstChild );
    });
} : function() { return this; });

// old alias
$.fn.bgIframe = $.fn.bgiframe;

function prop(n) {
    return n && n.constructor === Number ? n + 'px' : n;
}

})(jQuery);

function sh(){
	try{
		var b_height = $('#book').height()+20;
		var b_width = $('#book').width();
		var c_iframe = document.getElementById("c_iframe");
		if(c_iframe){
			c_iframe.src = 'http://www.xexing.com/inc/iframe.html'+'?'+Math.random()+"#"+b_width+"|"+b_height; 
		}
	}catch(e){}
}



function strtotime(strtime){
	if(strtime){
		_time = strtime.split(':');
		return (_time[0]*60+_time[1]*1);
	}
}
function int2time(i){
	var hour = parseInt(i/60);
	var minutes = (i%60);
	minutes = minutes<10?'0'+minutes:minutes;
	minutes = '00';
	return hour+':'+minutes;
}

function getseTime(stime,etime){
	intS = strtotime(stime);
	intE = strtotime(etime);
	intE = intE<intS?24*60+intE:intE;
	intM = intS
}


function setArriveTime(startTime,endTime,nowDate){
	var intS,intE,intM,_db;
	var htmlstr='';
	var _ret = new Array();
	var _t = nowDate.split('-');
	var _et = $('#eTm1').val().split('-');
	var d1 = new Date(_t[0],_t[1],_t[2]);
	var d2 = new Date(_et[0],_et[1],_et[2]);
	intS = strtotime(startTime);
	intE = strtotime(endTime);
	//判断服务器日期是否等于用户选择日期，即当天
	if(d1.getDate()==d2.getDate()&&d1.getFullYear()==d2.getFullYear()&&d1.getDay()==d2.getDay()){
		var _date = new Date();
		var ntime = _date.getHours()*60+_date.getMinutes()*1;
		//如果客户端当前时间大于服务端提供的担保时间前1小时
		if(ntime>intS-60){
			intS = ntime;
			_timeArr = new Array(intS,intE);
		}else{
			ntime = intS<=14*60?intS-120:14*60;
			_timeArr = new Array(ntime,intS,intE);
		}
	}else{
		db = 0;
		ntime = intS<=14*60?intS-120:14*60;
		_timeArr = new Array(ntime,intS,intE);
	}
	return _timeArr;
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
  <div id="book_top"><?php if($type==1){ echo '试住房申请';} else{ echo '填写订单';}?>
    <div class="corner1"></div>
    <div class="corner2"></div>
  </div>
  <form name="bookform" id="bookform" action="/ebook/save_order" method="POST" >
    <div id="book_con">
      <div id="side">
        <div id="hotel_info">
          <dl style="border:none">
            <dt><img src="http://tp1.znimg.com/<?php echo $Picture ?>  " width="60" height="60"  /></dt>
            <dd>
              <h2>
                <?php echo $HotelName ?>                </h2>
             <?php echo $Address ?>            </dd>
          </dl>
        
        </div>
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
          <h3>客房信息</h3>
          <div class="box_con">
            <!--<dl>
              <dt>房型名称：</dt>
              <dd>
              <?php if($type){echo $freeroom['R_RoomName'];} ?>
                
              </dd>
            </dl>-->
            <dl>
              <dt>酒店名称：</dt>
              <dd>
              <?php echo $HotelName ?>
               </dd>
            </dl>
			<dl>
              <dt>酒店地址：</dt>
              <dd>
              <?php echo $Address ?>
               </dd>
            </dl>
			<dl>
              <dt>酒店类型：</dt>
              <dd>
              <?php echo '免费' ?>
               </dd>
            </dl>
			<dl>
              <dt>应付金额：</dt>
              <dd style="line-height:22px">
              0元
                </dd>
               
            </dl>
			<dl>
              <dt>房间数量：</dt>
              <dd>
              <?php if($type){echo '1间';} ?>
               
               </dd>
              <dd id='suggestion' style="display:none"></dd>
            </dl>
            <dl>
              <dt>入住时间：</dt>
              <dd style="line-height:22px">
               <?php echo date('Y-m-d',$freeroom['R_Checkintime']); ?> 
               &nbsp;&nbsp;
               退房时间： <?php echo date('Y-m-d',$freeroom['R_Checkouttime']); ?>
                </dd>
               
            </dl>
       
          </div>
          
        <div class="box">
          <h3>入住信息</h3>
          <div class="box_con">
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
              <dt class="text_down">申请理由：</dt>
              <dd>
                <textarea name="c_liyou" cols="30" rows="5" class="input_card1" id="c_liyou" style="height:auto"></textarea>
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
                <input type="submit" class="btn" name="btn1" id="btn1" value="提交申请"/>
                <span style=" position:relative; top:-10px; color:#666;"></span></dd>
            </dl>            
            <dl>
              <dt>&nbsp;</dt>
              <dd> </dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
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