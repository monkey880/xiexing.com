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
#book_con {border: 6px solid #e0f5fc; border-width:0 6px 0 6px;}
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
$(function(){	
	if(!window.location.hash){

		window.location.hash = guid;		
	}else{
		guid = window.location.hash.substr(1);
		np = 1;
	}
	//cookie
	var _cFrm = readCookie(_cookie);
	if(_cFrm){
		_cFrm = _cFrm.split('_');
			if(np){			
				if(_cFrm[1]!='0'){s.rid = _cFrm[1].split(',')[0];s.pid = _cFrm[1].split(',')[1];}
				s.tm1 = _cFrm[3]?_cFrm[3]:s.tm1;
				s.tm2 = _cFrm[4]?_cFrm[4]:s.tm2;
			}
			if(_cFrm[2]){
				$('option','#roomnum').each(function(){$(this).remove('selected');});
				$('option[value="'+_cFrm[2]+'"]','#roomnum').attr('selected',true);					
			}
			reSetUser();		
			
			if(_cFrm[5]){
				var u = _cFrm[5].split(',');				
				for(var i=0;i<u.length;i++){
					if(u[i]){$(':input[name="g_name[]"]').eq(i).val(u[i]);}
				}
			}
			if(_cFrm[6]){$('#c_mobile').val(_cFrm[6])}	
			if(_cFrm[7]){$('#c_email').val(_cFrm[7])}
	
	}
	sh();
	
	var r = new roomDataRequest();	
	r.setArgsObj('hotelId',s.hid).setArgsObj('hotelId',s.hid).setArgsObj('roomId',s.rid).setArgsObj('planId',s.pid).setArgsObj('checkInDate',s.tm1).setArgsObj('checkOutDate',s.tm2).setArgsObj('agent_id',s.agent_id).setArgsObj('union_id',s.union_id).request();	
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
	$('#rid_pid').change(function(){
		$('Err').remove();
		var v = $(this).val().split(',');
		r.setArgsObj('roomId',v[0]).setArgsObj('planId',v[1]).request();
	})
	
	//房间数量发生变化后重新计算费用统计信息
	$('#roomnum').change(function(){
		$('Err').remove();
		reSetUser();
		//alert($.json.encode(r));
		new createForm(r.roomData[r.rdN]).chkRoomNum().innitCost().innitDb();		
	});
	
	//订单提交
	$('#btn1').click(function(){
		_order = new order();
		_order.subOrder();
	})
	
	
	//获取常用入住人
	//guser();
	//自动填写用户
	autoUser();
	//信用卡有效期下拉菜单
	inniMonthSelect();
	//死锁表单
	avFrm();
	//隐藏担保信息
	$('#hotels_po,#question_card,#card_safe').hide();
	//提示信息
	$('.needTips,.needTips1').each(function(){
		$(this).hover(
		  function () {
			smartTips($(this));
		  },
		  function () {			
			$(_tips_arrow).fadeOut(200);
			$(_tips).fadeOut(200,function(){
			 });			 
		  }
		);
	});
	
	
	re = function(){r.setArgsObj('checkInDate',$('#eTm1').val()).setArgsObj('checkOutDate',$('#eTm2').val()).request();}
	
	
	//全角转半角
	$('#c_mobile,#pu_cardno,#pu_idno,#pu_code').each(function(){
		var mobile = /(\d{3})?(\d{4})?(\d{4})?/;
		var idno = /(\d{3})?(\d{3})?(\d{4})?(\d{4})?(\d{4})?/;
		var cardno = /(\d{4})/g;
		$(this).keyup(function(){	
			var o = $(this);		
			var a = 0;
			if(o.attr('name')=='pu_idno') a = 1;
			var str = numTrans(o.val(),a);
			o.val(str);
			if(o.attr('name')=='pu_idno'){numTips(o,idno,'$1 $2 $3 $4 $5');}
			if(o.attr('name')=='c_mobile'){numTips(o,mobile,'$1 $2 $3');}
			if(o.attr('name')=='pu_cardno'){numTips(o,cardno,'$1 ');}
		
		})
		$(this).focus(function(){			
			var o = $(this);
			if(o.attr('name')=='pu_idno'){numTips(o,idno,'$1 $2 $3 $4 $5');}
			if(o.attr('name')=='c_mobile'){numTips(o,mobile,'$1 $2 $3');}
			if(o.attr('name')=='pu_cardno'){numTips(o,cardno,'$1 ');}						
		})
		$(this).blur(function(){
			$('#tishi').remove();
			
		})		
	});
	
	
	$(document).click(function(e){
		$('#CalFrame')[0].contentWindow.wp.hideCalendar();
		var o = e.target || window.event.srcElement;
		o = $(o);
		if(o.attr('name')!='g_name[]'){
			if($('#se')){
				$('#se').remove();
			}
		}
	});
	var _collect = {};
	if($.browser.msie){ _collect.nav = 'msie'}
	if($.browser.safari) { _collect.nav = 'safari'}
	if($.browser.opera){ _collect.nav = 'opera'}
	if($.browser.mozilla) { _collect.nav = 'mozilla'}
	_collect.nv = $.browser.version;
	_collect.arriveTime = new Date().pattern("yyyy-MM-dd HH:mm:ss");
	_collect.ip = ip;
	_collect.guid = guid;
	_collect.act = 'arrive';
	_collect.aid = s.agent_id;
	_collect.hid = s.hid;
	_collect.rid = s.rid;
	_collect.pid = s.pid;
	_collect.rd = r_domain;
	gs(_collect);

	
})



$(window).resize(function(){
	var _o = $('#dialog');
	if(_o.length){
		var h = $('#dialog').height();
		var w = $('#dialog').width();
		$('#bigFrame').css('height',document.body.scrollHeight);
		$('#bigFrame').css('width',document.body.scrollWidth);
		var b = (document.documentElement||document.body);
		var _top   = b.clientHeight > h ? ((b).clientHeight-h)/2 : 0;
		var _left  = b.clientWidth  > w  ? ((b).clientWidth -w) /2+b.scrollLeft: 0;
		if($.browser.msie && $.browser.version=='6.0'){
			_top   = b.clientHeight > h ? (b.clientHeight-h)/2 +b.scrollTop: 0;			
		}
		_top -=80;
		$('#dialog').css({'left':_left,'top':_top});
	}
});
window.onbeforeunload = keepCookie;



avFrm = function(k){
	var _o = $(':input');
	if(!k){
		_o.each(function(){$(this).attr('disabled','disabled');});		
		$('#eTm1').click(function(){return false;});
		$('#eTm2').click(function(){return false;});
	}else{
		_o.each(function(){$(this)[0].disabled = false;});
		$('#eTm1').click(function(){showCalendar('eTm1','eTm2','re')});
		$('#eTm2').click(function(){showCalendar('eTm2','','re');});
	}	
}

inniMonthSelect = function(){
	//初始化信用卡日期下拉菜单
	var n = new Date();
	var ny = n.getFullYear ()*1;
	var nm = n.getMonth()+3;
	var k;
	if(nm>12){ny++;nm=nm-12;}
	for(var i=0;i<20;i++){
		$('<option value="'+(ny+i)+'">'+(ny+i)+'年</option>').appendTo('#pu_year');
	}
	for(var i=nm;i<13;i++){
		if(i<10){k = '0'+i;}else{k=i;}
		$('<option value="'+k+'">'+i+'月</option>').appendTo('#pu_month');
	}
	$('#pu_year').change(function(){
		if($(this).val()>ny){
			$('option','#pu_month').remove();
			for(var i=1;i<13;i++){
				if(i<10){k = '0'+i;}else{k=i;}
				$('<option value="'+k+'">'+i+'月</option>').appendTo('#pu_month');
			}
		}else{
			$('option','#pu_month').remove();
			for(var i=nm;i<13;i++){
				if(i<10){k = '0'+i;}
				$('<option value="'+k+'">'+i+'月</option>').appendTo('#pu_month');
			}
		}
	});
}


numTips = function(o,reg,s){
	var str = o.val();
	if(str){
		var ts = $('#tishi').length==0?$('<div>').attr({'class':'tishi',id:'tishi'}).appendTo('body'):$('#tishi');
		ts.html(str.replace(reg,s));
		var offset = o.offset();			
		var _left = offset.left;
		var _top = offset.top-ts.height()-15;
		ts.css({top:_top,left:_left});			
	}else{
		$('#tishi').remove();
	}
}




reSetUser = function(){
	//移除所有表单错误提醒
	$('#Err').remove();	
	var l = $('#roomnum').val();
	var k = $('input[name="g_name[]"]').length;	
	if(l>k){		
		for(var i=k;i<l;i++){
			var len = $('input[name="g_name[]"]').length+1;
			var o = $('input[name="g_name[]"]:last');
			o.clone().attr('index',len).val('客人姓名'+len);
			o.after(o.clone().attr('index',len).val('客人姓名'+len));
		}
	}else if(l<k){
		for(var i=k;i>l;i--){
			$('input[name="g_name[]"]:last').remove();
		}
	}
	
	$('input[name="g_name[]"]').each(function(){$(this).unbind();});
	setFocusClass();
	autoUser();
}

setFocusClass = function(){
	$(':input[type="text"]').each(function(){
		$(this).focus(function(){
			i_class = $(this).attr('name')=='pu_cardno' || $(this).attr('name')=='pu_idno' ? 'onfocus1':'onfocus';
			$(this).addClass(i_class);
		});
		$(this).blur(function(){
			i_class = $(this).attr('name')=='pu_cardno' || $(this).attr('name')=='pu_idno' ? 'onfocus1':'onfocus';
			$(this).removeClass(i_class);
		});
	})	
}


//获取用户数据
function guser(){
	$.ajax({
		type: "GET",
		url: 'http://www.zhuna.cn/api/guestlist.php?r='+Math.random(),
		dataType: 'jsonp',
		jsonp:"callback", 	
		success:function(msg){
			if(msg.isok==0){
				$('#usinfo').html(msg.mobile+',欢迎来到住哪预订酒店');
				$('input[name="UserID"]').val(msg.uid);
				if(msg.rzr){user = msg.rzr.split(',');}
			}
		}
	});	
}

//用户表单下拉
autoUser = function(){
	$(':input[name="g_name[]"]').each(function(){
		$(this).focus(function(){	
			$('#se').remove();		
			var o  = $(this);
			if(o.val().indexOf('客人姓名')!=-1){o.val('')}
			$(this).select();
			var offset = o.offset();
			var str = '';
			if(user && user.length>0){
				for(var i=0;i<user.length;i++){
					if($(':input[name="g_name[]"][value='+user[i]+']').length==0){
						str += '<li>'+user[i]+'</li>';
					}						
				}
				if(str){
					str  = '<ul id="se">'+str+'</ul>';
					$(str).appendTo('body');
				}				
			}			
			$("#se").css({'left':offset.left,'top':offset.top+24});			
			$("#se").children('li').each(function(){
				$(this).hover(
					function () {
						$(this).css({"background-color":"blue",'color':'#FFF'});
					},
					function () {
						$(this).css({"background-color":"#FFF",'color':'#000'});
					}
				);	
				$(this).click(function(){
					var _u = o.val($(this).text());
					$('#se').remove();
				})
			})
		})
	});
}


//提示信息
function smartTips(o){
	var w = parseInt(o.attr('msg_w'));
	var tips = o.attr('msg');
	var s = Math.random().toString().substr(2);
	$('<div class="com_way" id="k_'+s+'"><div class="com_way_son">'+tips+'</div></div><div class="com_arrow1" id="a_'+s+'"></div>').appendTo('body');
	$('#k_'+s).css('width',w+'px');
	var k = $('#k_'+s);
	_tips = k;
	var a = $('#a_'+s);
	_tips_arrow = a;
	var osl = -50;
	var ost = 10;
	var osa = -5;
	var offset = o.offset();
	var b = (document.documentElement||document.body);	
	var _left  = offset.left+osl;
	var _top = offset.top+o[0].clientHeight+ost;
	if(_top+k[0].clientHeight>b.scrollTop+b.clientHeight){
		if(offset.top-b.scrollTop>k[0].clientHeight){
			_top = offset.top - k[0].clientHeight - ost;
			a.removeAttr('class');
			a.attr('class','com_arrow2');
			osa = k[0].clientHeight-2;
		}	
	}	
	while(offset.left+osl+w>(b.clientWidth+b.scrollLeft)){osl -= 10;}
	_left  = offset.left+osl;
	if(b.clientWidth<w){_left = b.scrollLeft}			
	k.css({top:_top,left:_left});
	a.css({top:_top+osa,left:offset.left});
	_tips.hover(
		function () {
			_tips.stop();
			_tips_arrow.stop();
			_tips_arrow.show();
			_tips.show();
		  },
		function () {			
		  $(_tips_arrow).fadeOut(200);
		  $(_tips).fadeOut(200,function(){
			 $(_tips).remove();
			 $(_tips_arrow).remove();
		   });		   
		}
	)	
}
//全角数字转半角
function numTrans(n,a){
	var t='';
	with(n){
		for (var i = 0; i < length; i++){
			if(charCodeAt(i)<48 || charCodeAt(i)>57){
				if(a){
					t +=(65296 <= charCodeAt(i) && charCodeAt(i) <= 65305) ? String.fromCharCode(charCodeAt(i) - 65248) : charAt(i);
				}else{
					t +=(65296 <= charCodeAt(i) && charCodeAt(i) <= 65305) ? String.fromCharCode(charCodeAt(i) - 65248) : '';
				}
			}else{
				t += charAt(i);
			}
		}		
	}
	return t;
}

function gs(d){
	var url = "http://count.zhuna.cn/e/t2.php?o=";
	$.ajax({			
		type: "GET",
		async: true,
		url: url+$.json.encode(d).replace(/&/g,'@')+'&id='+guid,
		dataType: 'script',
		jsonp:"callback", 	
		success:function(msg){}});
	
}

var roomDataRequest = function(){
	this.argObj = {hid:'',rid:'',pid:'',tm1:'',tm2:'',agent_id:'',union_id:''};
	this.QueryString			=	'';
	this.priceServer			=	new Array('www','b','www','b','www','b');										//价格服务器
	this.orderServer			=	new Array(6,7,8);																//订单服务器
	this.priceTimer				=	8000;																			//价格加载超时时间
	this.currServer				= 	new Array();																	//随机排序后的房型数据服务器数组
	this.iterator				= 	0;																				//当前房型数据服务器的下标
	this.roomRequestSwitch		= 	1;																				//房型数据加载开关
	this.roomData				=	[];																				//房型数据
	this.timer					= 	''
	this.rdN					=	0;																				//当前使用的数据下标
	this.setArgsObj = function(k,v){
		if (k=='hotelId') this.argObj.hid = v;
		if (k=='roomId') this.argObj.rid = v;
		if (k=='planId') this.argObj.pid = v;
		if (k=='agent_id') this.argObj.agent_id = v;
		if (k=='union_id') this.argObj.union_id = v;
		if (k=='checkInDate'){
			var c = v.split('-');
			c = new Date(c[0],c[1]-1,c[2]);		
			this.argObj.tm1 = c.pattern("yyyy-MM-dd");}

		if (k=='checkOutDate'){var c = v.split('-');
			c = new Date(c[0],c[1]-1,c[2]);		
			this.argObj.tm2 = c.pattern("yyyy-MM-dd");}
		return this;
	}	
	this.setQueryString = function(){
		this.QueryString = '';
		for (key in this.argObj){this.QueryString += key+'='+this.argObj[key]+'&';}
		return this;
	}
	
	this.request = function(){
		$('#_rate').html('');
		$('#loading').show();				
		$('#yd_info').hide();
		this.roomRequestSwitch = 1;
		this.iterator = 0;
		this.setQueryString();
		this.currServer = new Array();
		var curr = this.priceServer.concat([]);	
		var s = '';
		for(var i=0;i<this.priceServer.length;i++){
			var d = i==0?0:Math.floor(Math.random()*curr.length);
			this.currServer[i] = curr[d];
			curr.splice(d,1);
		}
		this.g();
	}
	
	this.g = function(d){	
		var n = this.argObj.rid+"_"+this.argObj.pid+"_"+this.argObj.tm1+"_"+this.argObj.tm2;
		this.rdN = n;
		if(this.roomRequestSwitch){
			if(this.roomData[n]){				 
				 new createForm(this.roomData[n]).innit();
				 this.roomRequestSwitch = 0;
			}else{
				if(this.iterator<this.priceServer.length){
					var timestamp = new Date();
					var f = new Array();				
					var o = this;				
					var url = '/ebook/get_orertemp/?'+this.QueryString;				
					var _server = o.currServer[this.iterator];
					$.ajax({	
						type: "GET",
						url: url,
						dataType: 'jsonp',
						jsonp:"callback", 	
						success:function(msg,d){
							window.clearTimeout(o.timer); 
							var _av = msg.yuding?1:0;
							//统计
							o.collect({s:_server,guid:guid,ctime:new Date()-timestamp,status:d,isorder:_av,augs:o.QueryString,act:'rResponse',rt:timestamp.pattern("yyyy-MM-dd HH:mm:ss")});						
							//保存数据到本地变量	
							o.rdN = n;
							if(o.argObj.rid==msg.ordertmp.RoomTypeId){
								o.roomData[n] = msg;
							}else{
								o.roomData[n] = msg;
								o.roomData[msg.ordertmp.RoomTypeId+"_"+o.argObj.pid+"_"+o.argObj.tm1+"_"+o.argObj.tm2] = msg;								
							}
							o.roomData[n] = msg;
							//加载页面
							if(o.roomRequestSwitch){								
								new createForm(o.roomData[n]).innit();
							}
							//关闭房型数据加载开关
							o.roomRequestSwitch = 0;																	
						},
						error:function(d){
							if($.browser.msie && $.browser.version=='6.0'){window.location.reload();}
							o.collect({s:_server,guid:guid,ctime:new Date()-timestamp,status:d.statusText,isorder:0,augs:o.QueryString,act:'rResponse',rt:timestamp.pattern("yyyy-MM-dd HH:mm:ss")});								  
							o.iterator++;
							o.g();
						}
					});	
					var oo = this;
					this.timer = setTimeout(function(){oo.g()},oo.priceTimer);
				}else{
					
				}				
			}
		}
		this.iterator++;								
	}
	
	this.collect = function(d){
		$.ajax({			
			type: "GET",
			async: true,
			url: "http://count.zhuna.cn/e/t2.php?o="+$.json.encode(d).replace(/&/g,'@')+'&id='+guid,
			dataType: 'script',
			jsonp:"callback", 	
			success:function(msg){}
		});
	}
}

var createForm = function(d){
	this.data = d;
	this.checkInDate = this.data.ordertmp.CheckInDate;						//入住时间
	this.yuding = d.yuding?1:0;												//满房状态
	this.firstDayPrice = d.prices.fistDayPrice								//首日房费

	this.innit = function(){										
		this.initRoomSelect();		
		this.innitCost();
		this.innitDb();
		this.formValue();
		if(!this.yuding){			
			$('#yd_info').html('<div id="errMsg" class="errMsg"> 很抱歉，部分日期内没有空余房间了，您可以重新 <span class="sbtn" onclick="$(\'#eTm1\').focus();">选择时间</span> 或 <span class="sbtn" onclick="$(\'#rid_pid\').focus();">修改房型</span> </div>').show();	
			avFrm();
			$('#btn1').attr('class','btn1');
			$('#eTm1,#eTm2,#rid_pid').each(function(){$(this)[0].disabled = false;})			
		}else{
			$('#yd_info').html('');			
			avFrm(1);
			$('#btn1').attr('class','btn');
		}
	}
	
	this.formValue = function(){
		//表单赋值		
		var d = this.data;
		for(key in d.ordertmp){		
			ob = $('input[name="ordertmp['+key+']"]');
			if(ob){
				ob.val(d.ordertmp[key]);
			}
		}
		//如果货币符号非RMB，对应表单赋值为0
		if(d.prices.CurrencyCode!='RMB'){
			$('input[name="ordertmp[TotalJiangjin]"]').val(0);
		}
		$('input[name="z[rid]"]').val(d.zh.rid);
		$('input[name="z[hotelname]"]').val(d.zh.hotelname);
		$('input[name="z[roomname]"]').val(d.zh.room.roomname);
		$('input[name="z[pid]"]').val(d.zh.pid);
	}
	
	this.initRoomSelect = function(){
		//重写房型下拉菜单		
		var d = this.data.rooms_opts;
		var o = this.data;
		$('option','#rid_pid').remove();
		for (k in d){
			var ts = d[k]['selected']?'selected':'';
			$('<option value="'+d[k]['rid']+','+d[k]['pid']+'"'+ts+' >'+d[k]['roomname']+' ['+d[k]['planName']+',均价'+parseInt(d[k]['junjia'])+']</option>').appendTo('#rid_pid');
		}
		//左侧房型信息
		var r = '';
		r += o.zh.room.roomname?'<li>房   型：'+o.zh.room.roomname+'</li>':'';
		r += o.zh.room.bed?'<li>床   型：'+o.zh.room.bed+'</li>':'';
		r += o.ordertmp.RatePlanName?'<li>早   餐：'+o.ordertmp.RatePlanName+'</li>':'';
		r += o.zh.room.adsl?'<li>宽   带：'+o.zh.room.adsl+'</li>':'';
		r += o.zh.room.area?'<li>面   积：'+o.zh.room.area+'平方米</li>':'';
		r += o.zh.room.floor?'<li>楼   层：'+o.zh.room.floor+'层</li>':'';
		$('#roomDes').html(r);
		//隐藏loading图片
		$('#loading').hide();
		//价格信息
		$('#_rate').html('');
		$('#_rate').show();
		$(o.ratedaill).appendTo('#_rate');
		//到离店日期
		$('#eTm1').val(o.CheckInDate);
		$('#eTm2').val(o.CheckOutDate);					
	}
	
	//费用总计
	this.innitCost = function(){		
		var yuding = this.data.yuding;
		d = this.data.prices;
		var p0 = !this.yuding?'----':d.CurrencyCode+' '+d.TotalPrice*$('#roomnum').val();
		var p1 = !this.yuding?'---':d.CurrencyCode+' '+d.TotalJiangjin;
		var p2 = !this.yuding?'---':'RMB '+d.TotalJiangjin*$('#roomnum').val();
		var p3 = !this.yuding?'---':d.TotalJiangjin*$('#roomnum').val();
		if($('#fx').length){
			var p4 = $('#fx').attr('msg').replace(/<font color=red>(\d+)|---<\/font>/,'<font color=red>'+p3+'</font>');
			$('#fx').attr('msg',p4);
		}
		$('#TotalAmount').text(p0);
		$('#Payback').text(p1);
		$('#PaybackTotal').text(p2);
		return this;
	}
	
	//担保设置	
	this.innitDb = function(){
		var r = this.data.GaranteeRule;
		var ndb = 0;
		var n = 0;
		var o = this;
		var s = '<input type="radio" name="ArriveTime" id="radio1" value="14:00-20:00" checked /> <label for="radio1">20:00</label>' + '&nbsp;&nbsp;<input type="radio" name="ArriveTime" id="radio2" value="20:00-23:59" /> <label for="radio2">24:00</label>&nbsp;&nbsp;<input type="radio" name="ArriveTime" id="radio3" value="23:59-06:00" /> <label for="radio3">次日06:00</label>';
		try{
			var _s = r.desc.replace('担保条件：','');
			_s = _s.replace(/(\d{2})\.(\d{2})\.(\d{2})/g,'20$1-$2-$3');			
			_s = dbtjformat(_s);		
			_s = _s.replace('第一晚房费','第一晚房费(<b><font id="_dbp" color=#FF6600>'+(this.firstDayPrice*$('#roomnum').val())+'元</font></b>)');
			$('#DbDes').html(_s);	
			//alert($('#DbDes').html());
		}catch(e){}
		
		if(r['romms']>0){$('#roomnum>option').each(function(){
			if($(this).val()>=r['romms']){$(this).attr('db',r['romms'])}else{$(this).attr('db','0')};		
			});
		}
		
		db = r['norule']?1:0;
		
		if(r['norule']||(r['romms']>0&&r['romms']<=$('#roomnum').val())){
			ndb = 1;
			$('#hotels_po,#question_card,#card_safe').show();
			$('#rkTime').html(s);		         
		}else if(r['stattime']!=''&&r['endtime']!=''){
			ndb = 0;
			n = 1;
			var dbstr='';
			var val = '';
			if(this.yuding){dbstr = '(<font color=#FF6600>需要信用卡担保首晚房费'+(this.firstDayPrice*$('#roomnum').val())+'元</font>)';}
			var _ddd = setArriveTime(r['stattime'],r['endtime'],this.data.uptime);

			if(_ddd.length==3){
				val = int2time(_ddd[0])+'-'+int2time(_ddd[1]);	
				str_html = '<input type="radio" name="ArriveTime" id="radio2" value="'+val+'" checked/><label for="radio1">'+int2time(_ddd[0])+'至'+int2time(_ddd[1])+'</label>' + '&nbsp;&nbsp;<font color="green">(无需担保，建议选择此项)</font>';
				if(_ddd[2]<_ddd[1]){
					val = int2time(_ddd[1])+'-23:59';
					str_html += '<br>'+'<input type="radio" name="ArriveTime" id="radio2" value="'+val+'" /><label for="radio2">'+int2time(_ddd[1]) +' 至 23:59 </label>'+dbstr;
					val = '23:59-'+int2time(_ddd[2]);
					str_html += '<br>'+'<input type="radio" name="ArriveTime" id="radio2" value="'+val+'" /><label for="radio2">23:59 至 '+int2time(_ddd[2])+' </label>'+dbstr;
					$('#rkTime').html(str_html);

					$(':input[name="ArriveTime"]').eq(0).click(function(){o.ckiTips($(this).val(),0);$('#Err').remove()});
					$(':input[name="ArriveTime"]').eq(1).click(function(){o.ckiTips($(this).val(),1);$('#Err').remove()});
					$(':input[name="ArriveTime"]').eq(2).click(function(){o.ckiTips($(this).val(),1);$('#Err').remove()});					
				}else{
					val = int2time(_ddd[1])+'-'+int2time(_ddd[2]);
					str_html += '<br>'+'<input type="radio" name="ArriveTime" id="radio2" value="'+val+'" /><label for="radio2">'+int2time(_ddd[1]) +' 至 '+int2time(_ddd[2])+' </label>'+dbstr;
					$('#rkTime').html(str_html);
					$(':input[name="ArriveTime"]').eq(0).click(function(){o.ckiTips($(this).val(),0);$('#Err').remove()});
					$(':input[name="ArriveTime"]').eq(1).click(function(){o.ckiTips($(this).val(),1);$('#Err').remove()});
				}
				
		}else{
				
				if(_ddd[1]<_ddd[0]){
					ndb = 1;
					val = int2time(_ddd[0])+'-23:59';					
					str_html = '<br>'+'<input type="radio" name="ArriveTime" id="radio2" value="'+val+'" checked/><label for="radio2">'+int2time(_ddd[0]) +' 至 23:59 期间</label>'+dbstr;
					val = '23:59-'+int2time(_ddd[1]);
					str_html += '<br>'+'<input type="radio" name="ArriveTime" id="radio2" value="'+val+'" /><label for="radio2">00:00 至 '+int2time(_ddd[1])+' 期间</label>'+dbstr;
					$('#rkTime').html(str_html);
					$(':input[name="ArriveTime"]').eq(0).click(function(){o.ckiTips($(this).val(),1);$('#Err').remove()});
					$(':input[name="ArriveTime"]').eq(1).click(function(){o.ckiTips($(this).val(),1);$('#Err').remove()});

				}
				
			}
			
		}else{
			$('#rkTime').html(s);
		}
		this.ckiTips($('input[name="ArriveTime"]:first').val(),ndb);	
		if(!n){
			$(':input[name="ArriveTime"]').each(function(){
				$(this).click(function(){o.ckiTips($(this).val(),ndb);
				$('#Err').remove();})
			});	
		}
		this.chkRoomNum();
		return this;
	}
	
	this.chkRoomNum = function(){
		var n = $('#roomnum>option[selected]="selected"').attr('db');
		var o  = $('#suggestion');
		if(n>0){
			if(n>1){			
				o.html('<div class="suggest"><span style="color:#f60;">酒店要求预订房量超过'+n+'间（含'+n+'间）时需使用信用卡担保</span>，如果您没有信用卡，建议您每次预订'+(n-1)+'间，分多次预订。</div>');
				o.show();
			}							
			this.ckiTips($('input[name="ArriveTime"]:first').val(),1);		
		}else{
			o.html('');
			o.hide();
		}
		return this;
	}

	this.ckiTips = function(d,t){
		if(this.firstDayPrice){
			var e = d.split('-')[1];
			d = d.replace(/:/g,'');
			d = d.split('-');	
			var c = this.checkInDate.split('-');
			c = new Date(c[0],c[1]-1,c[2]);
			
			switch(t){
				case 0:
					if(d[0]>d[1]){	c = c.dateAdd('d',1);}					
					$('#hotels_po,#question_card,#card_safe').hide();
					break;
				case 1:
					//if(d[0]>d[1]){	c = c.dateAdd('d',1); e='12:00'}
					c = c.dateAdd('d',1); e='12:00';
					$('#hotels_po,#question_card,#card_safe').show();
					break;
			}	
			
			var cd = c.getMonth()+1+'月'+c.getDate()+'日';
			var s = cd+e;	
			if($('#checkinTips').length==0){$('<div class="tips" id="checkinTips"></div>').prependTo('#citips');}
			s = '<div>·&nbsp;房间保留至<b><font color="#FF6600">'+s+'</font></b>，如不能在<b color="#FF6600"><font color="#FF6600">'+e+'</font></b>前到酒店，请及时与酒店联系。</div><div>·&nbsp;通常14点办理入住，早到可能需要等待</div>';
			$('#checkinTips').html(s);			
		}
		sh();
	}
}

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
	
	this.collect = function(){		
		$.ajax({			
			type: "GET",
			async: true,
			url: "http://count.zhuna.cn/e/t2.php?o="+$.json.encode(this.oi).replace(/&/g,'@')+'&id='+guid,
			dataType: 'script',
			jsonp:"callback", 	
			success:function(msg){}
		});
	}
}



function _ul(){
	var thisDialog = new dialog().setClose(true).setWidth(600).setHeight(450).setUrl('http://www.zhuna.cn/login.asp?purl=back').show();
}
function loginback(){
	$('#bigFrame').remove();$('#dialog').remove();
	//guser();
}

function guser(){
	$.ajax({
		type: "GET",
		url: 'http://www.zhuna.cn/api/guestlist.php?r='+Math.random(),
		dataType: 'jsonp',
		jsonp:"callback", 	
		success:function(msg){
			if(msg.isok==0){
				$('#usinfo').html(msg.mobile+',欢迎来到住哪预订酒店');
				$('input[name="UserID"]').val(msg.uid);
				if(msg.rzr){user = msg.rzr.split(',');}
			}
		}
	});	
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
  <form name="bookform" id="bookform" action="save_order" method="POST" >
    <div id="book_con">
      <div id="side">
        <div id="hotel_info">
          <dl>
            <dt><img src="<?php echo $Picture ?>  " width="60" height="60"  /></dt>
            <dd>
              <h2>
                <?php echo $HotelName ?>                </h2>
             <?php echo $Address ?>            </dd>
          </dl>
          <ul id="roomDes">
          </ul>
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
            <dl>
              <dt>房型名称：</dt>
              <dd>
              <?php if($type){echo $freeroom['R_RoomName'];} else {?>
                <select name="rid_pid" id="rid_pid" >
                  <option value="0">正在加载房型信息...</option>
                </select>
                <?php }?>
              </dd>
            </dl>
            <dl>
              <dt>房间数量：</dt>
              <dd>
              <?php if($type){echo '1间';} else {?>
                <select id="roomnum" name="roomnum" class="fi_s1">
                  <option value="1" selected="selected">1间</option>
                  <option value="2">2间</option>
                  <option value="3">3间</option>
                  <option value="4">4间</option>
                  <option value="5">5间</option>
                  <option value="6">6间</option>

                </select>
                 <?php }?>
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
              <dt>价格明细：</dt>
              <dd id="loading"><img src="http://tp1.znimg.com/images/new/loading2.gif" width="160" height="39" /></dd>
              <dd>
                <table cellspacing="0" cellpadding="0" border="0" class="price_list">
                  <tbody id="_rate">
                  </tbody>
                </table>
              </dd>
              <dd id="yd_info"></dd>
            </dl>
           
          </div>
          <div class="sale">
            <dl>
             <?php if($type){ ?>
              <dt>应付金额：0元</dt>
              <?php }else {?>
              <dt>应付金额：</dt>
              <dd><span id="TotalAmount" class="cny"> </span>&nbsp;<span class="warning">(预订免费，酒店前台付款 ， 如需发票，请从酒店前台索取)</span></dd>
              <?php }?>
            </dl>
                      </div>
        </div>
        <div class="box">
          <h3>入住信息</h3>
          <div class="box_con">
            <dl>
              <dt class="text_down">客人姓名：</dt>
              <dd>
                <input name="g_name[]" type="text" class="input_text" id="g_name" style="margin-right:10px;margin-bottom:10px;" value="客人姓名" index="1" />
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
              <dd id="rkTime"> </dd>
             
            </dl>
            <dl>
              <dt>&nbsp;</dt>
              <dd id="citips">
                <!--<div class="tips" id='checkinTips'>房间保留至7月8日20:00，如不能在20:00前到酒店，请及时通知住哪或与酒店联系。</div>-->
              </dd>
            </dl>
          </div>
          <div id="hotels_po" style="display:none">
            <h3>信用卡担保</h3>
            <div class="box_con">
              <div id="DbDes"></div>
              <dl style="display:none;">
                <dt class="text_down"><img src="http://tp1.znimg.com/images/new/icon2.gif" name='needTips' align="absmiddle" msg="因酒店剩余房间数量紧张，需要冻结您信用卡中部分费用作为担保，以便保留房间。请您放心，使用信用卡绝对安全。 了解更多" msg_w='100' />担保说明：</dt>
                <dd></dd>
              </dl>
              <dl>
                <dt class="text_down">信用卡号：</dt>
                <dd>
                  <input name="pu_cardno" type="text" class="input_card" id="pu_cardno" value="" size="40" maxlength="20" />
                  <span></span> </dd>
              </dl>
              <dl>
                <dt class="text_down">有效期至：</dt>
                <dd><span class="sw280">
                  <select style="width:70px;" name="pu_year" id="pu_year">
                  </select>
                  <select style="width:53px;" name="pu_month" id="pu_month">
                  </select>
                  </span><span class="warning">(只接受有效期为当前月份之后的信用卡  )</span></dd>
              </dl>
              <dl>
                <dt>CVV2码：</dt>
                <dd>
                  <input name="pu_code" type="text" class="input_text1" id="pu_code" value="" size="4" maxlength="3" />
                  <span class="warning"><span class="needTips" name='needTips' msg="<img src=http://www.zhuna.cn/help/xyk.jpg>" msg_w='520'></span> 信用卡背面紧跟在卡号末四位号码的后面印刷的3位数字</span>  </dd>
              </dl>
              <dl>
                <dt>持卡人姓名：</dt>
                <dd>
                  <input name="pu_name" type="text" class="input_text1" id="pu_name" value=""/>
                  <span></span> </dd>
              </dl>
                            <dl>
                <dt>证件类型：</dt>
                <dd>
                  <select style="width:126px;" name="pu_idtype" id="pu_idtype">
                    <option value="0">身份证</option>
                    <option value="1">护照</option>
                    <option value="2">其他</option>
                  </select>
                  <span class="warning">(信用卡开卡使用的证件类型)</span></dd>
              </dl>
              <dl>
                <dt>证件号码：</dt>
                <dd>
                  <input name="pu_idno" type="text" class="input_card" id="pu_idno" value="" size="40"/>
                  <span></span> </dd>
              </dl>
                          </div>
          </div>
          <div class="submit">
            <dl style="padding:15px 0;">
              <dt>&nbsp;</dt>
              <dd id="subbtn">
                <input type="button" class="btn" name="btn1" id="btn1" value="提交订单"/>
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
    <input type="hidden" name="z[roomname]"  id="z[roomname]"value="<?php echo $hotelid ?>" />
    <input type="hidden" name="z[pid]" id="z[pid]" value="<?php echo $pid ?>" />
    <input type="hidden" name="z[agent_id]" id="z[agent_id]" value="<?php echo $agent_id ?>" />
    <input type="hidden" name="z[union_id]" id="z[union_id]" value="" />
    <input type="hidden" name="z[referer]" id="z[referer]" value="http://www.xexing.com/" />
    <input type="hidden" name="ordertmp[guid]" value="" />
    <input type="hidden" name="ordertmp[HotelId]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[RoomTypeId]" value="<?php echo $rid ?>" />
    <input type="hidden" name="ordertmp[RoomName]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[RatePlanID]" value="<?php echo $pid ?>" />
    <input type="hidden" name="ordertmp[RatePlanCode]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[RatePlanName]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[CheckInDate]" value="<?php echo $tm1 ?>" />
    <input type="hidden" name="ordertmp[CheckOutDate]" value="<?php echo $tm2 ?>" />
    <input type="hidden" name="ordertmp[GuestTypeCode]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[TotalPrice]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[dateline]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[TotalJiangjin]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="ordertmp[CurrencyCode]" value="<?php echo $hotelid ?>" />
    <input type="hidden" name="nAuth" value="" />
	<input type="hidden" name="ConfirmTypeCode" value="sms" />
	
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