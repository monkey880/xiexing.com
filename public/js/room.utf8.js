// JavaScript Document
var _v1=null,dn=0,tb1='',wks='',d,hotels=null,n1=0,agent_id=0,_hid='',_tm1='',_tm2='',_fid=0,_timer1=null,reNum=0;
if(window.location.hostname=='hotel.nanjings.com'){window.location='http://www.zhuna.cn';}
function loadPrice(hid,tm1,tm2,fid){
	if(typeof(hid)!= 'undefined'){_hid=hid;}if(typeof(tm1)!= 'undefined'){_tm1=tm1;}if(typeof(tm2)!= 'undefined'){_tm2=tm2;}if(typeof(fid)!= 'undefined'){_fid=fid;}
	var jsPrice = document.createElement('script');
	jsPrice.type = 'text/javascript';
	//if(hid.indexOf("A")>-1){
		
		jsPrice.src = '/hotelinfo/getroom?hid='+_hid+'&tm1='+_tm1+'&tm2='+_tm2;
	//}else{
//	jsPrice.src = 'http://www.api.zhuna.cn/e/json.php?hid='+_hid+'&tm1='+_tm1+'&tm2='+_tm2+'&orderfrom='+_fid+'&call=callback';
//	}
	document.body.appendChild(jsPrice);
	window.clearTimeout(_timer1);_timer1=window.setTimeout('_jsout()',5000);
}
function _reLoad(){
	var ids=_hid.split(',');
	for(var i=0;i<ids.length;i++){
		if(_g('h'+ids[i]))_g('h'+ids[i]).innerHTML='<img src="http://www.api.zhuna.cn/price/default/loading.gif" alt="加载中"  style="padding:15px;" />';
	}
	loadPrice();	
}
function _jsout(){
	if(reNum<5){reNum++;loadPrice();return;}
	var ids=_hid.split(','),isv=false;
	for(var i=0;i<ids.length;i++){
		isv=true;
		if(_g('h'+ids[i]))_g('h'+ids[i]).innerHTML='<div style="background-color:#FF9; border:1px solid #F30; width:500px; height:30px; line-height:30px; text-align:center; margin-bottom:10px ;height:40px; line-height:40px; color:#f30" > 在查询实时房态信息过程中出现异常!请<a href="javascript:_reLoad()">重试</a></div>';
	}	
	reNum=0;
}
function callback(jsData){window.clearTimeout(_timer1);reNum=0;var _Hide=true;hotels=jsData;if(hotels.length==1){_Hide=false};for(k in hotels){vhotel(hotels[k],_Hide);}}
function RefreshHotel(hid,Hide){var k;for(k in hotels){if(hotels[k].zid==hid){vhotel(hotels[k],Hide);return;}}}
//get plans 
function gPlan(a,b,c){
	for(var k=0;k<hotels.length;k++){
		if(hotels[k].zid==a){
			for(var m=0;m<hotels[k].rooms.length;m++){
				if(hotels[k].rooms[m].rid==b){
					for(var n=0;n<hotels[k].rooms[m].plans.length;n++){
						if(hotels[k].rooms[m].plans[n].planid==c){
							return hotels[k].rooms[m].plans[n];
						}
					}
					return null;
				}
			}
			return null;
		}
	}
	return null;
}
//hotel room
function vhotel(hotel,Hide){
	if(dn==0){
		//init
		dn=DateDiff('d',sToDate(hotel.tm1),sToDate(hotel.tm2));
		tb1=(dn>1)?'日均价':sToDate(hotel.tm1).format('MM\u6708dd\u65E5');
	}
	var html='';
			html+='<div class="room">';
			html+='  <div class="room_title">';
			html+='    <div class="row">';
			html+='      <span class="row1">早餐</span>';
			html+='      <span class="row3">宽带</span>';
			html+='      <span class="row4">'+tb1+'</span>';
			html+='      <span class="row5">返现</span>';
			html+='      <span class="row6">&nbsp;</span>';
			html+='      <span class="row7">前台付款</span>';
			html+='    </div>';
			html+='    房型名称';
			html+='  </div>';
			html+='  <div class="room_all">';
		//room start
	var rNum=0;
	if(hotel.rooms&&hotel.rooms.length>0){
		rNum=hotel.rooms.length;
	}else{
			html+='    <div class="no_room">\u5BF9\u4E0D\u8D77\uFF0C\u8BE5\u9152\u5E97\u5728<font color="#f60">'+hotel.tm1+'</font>\u81F3<font color="#f60">'+hotel.tm2+'</font>\u671F\u95F4\u6682\u65F6\u4E0D\u80FD\u9884\u8BA2\u3002</div>';
	}
	for(var a=0;a<rNum;a++){
		var room=hotel.rooms[a];
		var _idv1='ri_'+room.rid;
		
		//plan
		for(var b=0;b<room.plans.length;b++){
			var plan=room.plans[b];	
			var rmd=(plan.priceCode=='RMB'||typeof(plan.priceCode)=='undefined')?'¥':'<i>'+plan.priceCode+'</i>';
			html+='    <div class="room_row">';
			if(b==0){
				
				html+='      <div class="room_name" >';
				var _css=(room.img)?'rn_pic':'rn_pic1';
				html+='          <a href="javascript:void(\''+_idv1+'\');" onclick="_display(\''+_idv1+'\');" class="'+_css+'">'+room.title+'</a>';		
				if(plan.description.Promotion)
				html+='          <img class="icon_room_sale" src="http://www.api.zhuna.cn/images/blank.gif" width="12" height="12" onmouseover="tips(this,\'v0\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')" />';
				html+='      </div>';		
			}
				html+='      <div class="row">';
			if(room.plans.length>1&&b==0){
				html+='          <span class="row1">'+plan.planname+'(<a href="javascript:void(\''+_idv1+'\');" onclick="_display(\''+_idv1+'\');" >更多价格</a>)</span>';
			}else{
				html+='          <span class="row1" title="'+plan.planname+'">'+plan.planname+'</span>';
			}				
			if(b==0){html+='          <span class="row3" >'+room.adsl+'</span>'}else{html+='          <span class="row3">'+room.adsl+'</span>'};
				var junjia=parseInt(plan.totalprice/plan.date.length);
				if(dn>1){
					html+='          <span class="row4">'+rmd+'<strong onmouseover="tips(this,\'v1\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')" >'+junjia+'</strong></span>';
				}else{
					html+='          <span class="row4">'+rmd+'<strong>'+junjia+'</strong></span>';
				}				
				html+='          <span class="row5">¥<strong  onmouseover="tips(this,\'v2\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')">'+Math.floor(junjia*0.07)+'</strong></span>';
				var _css='';
				if(plan.iscard&&plan.iscard==1)_css=' room_danbao1';
				//if(plan.iscard&&plan.iscard==3)_css=' room_danbao3';
				if(_css==''){
					if(typeof(room.AvailableAmount)!= 'undefined')html+='          <span class="row6"  style="color:#00AF00">'+room.AvailableAmount+'</span>';
				}else{
					html+='          <span class="row6'+_css+'" onmouseover="tips(this,\'v3\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')">&nbsp;</span>';
				}				
				html+='          <span class="row7">';
				if(plan.status=='0'){
					html+='        <input type="button" class="btn_yd" onclick="dobook(\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')"  value="预订">';
				}else{
					html+='      <input type="button" value="订完" class="btn_mf">';
				}	
				html+='          </span>';
				html+='      </div>';
				html+='    </div>';
			//var _css=(Hide)?'room_row_son':'room_row_son1';
			if(b==0)html+=' <div class="room_row_son" id="'+_idv1+'">';
		}
		//end plan
			html+='    <div class="room_info" >';
			html+='      <div class="room_info_arrow"></div>';
			html+='      <div class="room_info_con">';
			html+='      	<div class="room_info_pic">'; 
			if(room.img){
			for(var p1=0;p1<room.img.length;p1++){
				if(room.img[p1]){				
					if(room.img[p1].type==2){
						html+='      		 <div><img src="http://tp1.znimg.com/'+room.img[p1].imgurl.replace('d:\\wwwroot\\p.zhuna.cn','')+'" width="100" height="75" alt="'+room.img[p1].title+'[客人实拍]"  /><em title="客人实拍照片"></em></div>';
					}
					else if(room.img[p1].type==99){
						html+='      		 <div><img src="'+room.img[p1].imgurl+'" width="100" height="75" alt="'+room.img[p1].title+'" /></div>';
					}
					
					else{
						html+='      		 <div><img src="http://tp1.znimg.com/'+room.img[p1].imgurl.replace('d:\\wwwroot\\p.zhuna.cn','')+'" width="100" height="75" alt="'+room.img[p1].title+'" /></div>';
					}
				}
				if(p1>1)p1=999;
			}	
			}
			html+='    		</div>';
			html+='			<div class="room_info_list"><div class="room_info_list_li">床型：'+room.bed+'</div>  <div class="room_info_list_li">楼层：'+room.floor+'  </div>  <div class="room_info_list_li">面积：'+room.area+' </div></div>';			
			if(room.notes)html+='<div class="room_info_note">其他：'+room.notes+' </div>';
			html+='    </div>';	
			html+=' </div>';
			html+=' </div>';
		if(Hide&&a>1){a=9999;}		
	}
		//room end
			html+='  </div>';	
		if(hotel.rooms&&hotel.rooms.length>3){
				html+='  <div class="room_more">';
				if(Hide){
					html+='    <a href="javascript:RefreshHotel('+hotel.zid+',false)" class="r_more">所有房型('+rNum+')</a>';
				}else{
					html+='    <a href="javascript:RefreshHotel('+hotel.zid+',true)" class="r_more1">部分房型('+rNum+')</a>';
				}				
				html+='  </div>';
		}
		
			html+='</div>';
	if(_g('h'+hotel.zid))_g('h'+hotel.zid).innerHTML=html;
}

var mdiv=document.createElement("div"),timeOut=null;
function rmtips(){
	try {
		if(timeOut){window.clearTimeout(timeOut);timeOut=null}
		if(mdiv){document.body.removeChild(mdiv);}
	}catch(e){
		//alert(e);
	}
		
}
function ycrmtips(){
	window.clearTimeout(timeOut);
	timeOut=window.setTimeout('rmtips()',100);
}
function _xy(obj){
		for(var y=0,x=0; obj!=null; y+=obj.offsetTop, x+=obj.offsetLeft, obj=obj.offsetParent);
		return new Array(x,y);
}
function tips(obj,v1,a,b,c){
		window.clearTimeout(timeOut);
		var mhtml='',_plan=gPlan(a,b,c),mWidth=300;
		if(v1=='v0'){
			mWidth=400;
			mhtml=_plan.description.Promotion.replace(/\n/g,'<br/>').replace(/住哪网|住哪/g,'本站');
		}
		if(v1=='v1'){
			mWidth=18;
			var wk1='',wk2='';
			for(c in _plan.date){
				var dt=_plan.date[c];
				if(mWidth<368){mWidth+=50;wk1+='<dt>'+sToDate(dt.day).format('EE')+'</dt>';}
				if(dt.price=='×')dt.price='满房';
				wk2+='<dd>'+sToDate(dt.day).format('d日')+'<em>'+dt.price+'</em></dd>';				
			}	
			mhtml='<div class="room_price"><dl>'+wk1+wk2+'</dl></div>';
		}
		if(v1=='v2'){
			mWidth=200
			if(agent_id==20){
				mhtml='预订并成功入住后，每间夜可获得<span>'+Math.floor(_plan.junjia*0.07)+'</span>元奖金，离店后1-60天内登录携行网会员中心申请提现，携行网将于您提现的七个工作日内汇款至您指定的银行卡中。';
			}else{
				mhtml='您入住酒店并结帐，在离店后60天内登录携行网点评后，我们将会返还每晚<span>'+Math.floor(_plan.junjia*0.07)+'</span>元至您的携行网帐户中。';
			}
		}
		if(v1=='v3'){
			mhtml=_plan.carddesc.replace(/(\d{2})\.(\d{2})\.(\d{2})/g,'20$1-$2-$3');
		}
		var vhtml='\
		<div class="com_arrow1" id="com_arrow"></div>\
		<div class="com_way"  id="com_way" style="width: '+mWidth+'px;">\
			<div class="com_way_son">'+mhtml+'</div>\
		</div>\
		';
		mdiv.innerHTML=vhtml;
		document.body.appendChild(mdiv);
		var xy=_xy(obj);
		var L1=xy[0]+obj.offsetWidth/2-6.5,T1=xy[1]+obj.offsetHeight+6;
		var T2=T1+5,L2=(document.body.offsetWidth<L1+mWidth/2)?(document.body.offsetWidth-mWidth-10):L1-mWidth/2+6.5;
		if(L2<10)L2=10;
		var T4=document.body.scrollTop||document.documentElement.scrollTop;
		var H4=document.documentElement.clientHeight||document.body.clientHeight;
		if((T2+_g('com_way').offsetHeight)>(T4+H4)){
			T1=xy[1]-6-5;
			T2=T1-_g('com_way').offsetHeight+4;
			_g('com_arrow').className='com_arrow2';			
		}
		_g('com_arrow').style.top=T1+'px';
		_g('com_arrow').style.left=L1+'px';
		_g('com_way').style.top=T2+'px';
		_g('com_way').style.left=L2+'px';
		_g('com_way').onmouseover=function(){window.clearTimeout(timeOut);};
		_g('com_way').onmouseout=ycrmtips;
		obj.onmouseout=ycrmtips;

}
function tj(){
	//var tj=document.createElement("div")
//	tj.innerHTML='<img src="http://img.users.51.la/11791758.asp" width="0" height="0" border="0" />';
//	document.body.appendChild(tj);
}
setTimeout('tj()',2000);

function _display(id){
	if(_g(id).style.display!='block'){_g(id).style.display='block'}else{_g(id).style.display='none'}
}
function _g(id){return document.getElementById(id)};
function sToDate(d){var ds = d.toString().split("-");return (new Date(parseFloat(ds[0]),parseFloat(ds[1])-1,parseFloat(ds[2])))}
function DateAdd(interval,number,date){
    switch(interval.toLowerCase()){
        case "y": return new Date(date.setFullYear(date.getFullYear()+number));
        case "m": return new Date(date.setMonth(date.getMonth()+number));
        case "d": return new Date(date.setDate(date.getDate()+number));
        case "w": return new Date(date.setDate(date.getDate()+7*number));
        case "h": return new Date(date.setHours(date.getHours()+number));
        case "n": return new Date(date.setMinutes(date.getMinutes()+number));
        case "s": return new Date(date.setSeconds(date.getSeconds()+number));
        case "l": return new Date(date.setMilliseconds(date.getMilliseconds()+number));
    } 
}
function DateDiff(interval,date1,date2){
    var long = date2.getTime() - date1.getTime();
    switch(interval.toLowerCase()){
        case "y": return parseInt(date2.getFullYear() - date1.getFullYear());
        case "m": return parseInt((date2.getFullYear() - date1.getFullYear())*12 + (date2.getMonth()-date1.getMonth()));
        case "d": return parseInt(long/1000/60/60/24);
        case "w": return parseInt(long/1000/60/60/24/7);
        case "h": return parseInt(long/1000/60/60);
        case "n": return parseInt(long/1000/60);
        case "s": return parseInt(long/1000);
        case "l": return parseInt(long);
    }
}
Date.prototype.format=function(fmt) {         
    var o = {         
    "M+" : this.getMonth()+1,        
    "d+" : this.getDate(),        
    "h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12,      
    "H+" : this.getHours(),         
    "m+" : this.getMinutes(),        
    "s+" : this.getSeconds(),          
    "q+" : Math.floor((this.getMonth()+3)/3),       
    "S" : this.getMilliseconds()       
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
    }         1480705
    for(var k in o){         
        if(new RegExp("("+ k +")").test(fmt)){         
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));         
        }         
    }         
    return fmt;         
} 
/*
var o = document.createElement("script");
o.setAttribute('src','http://count.zhuna.cn/IF_account/gr.php');
document.getElementsByTagName("body").item(0).appendChild(o);
*/
