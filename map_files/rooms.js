// JavaScript Document
var _v1=null,dn=0,tb1='',wks='',d,hotels=null,n1=0,agent_id=0,hid_='',tm1_='',tm2_='',_timer1=null,reNum=0,jsPrice=null,p_c = new __cache__(500),fangxing_='',zhaocan_='',kuandai_='',pc_='',minprice_='',maxprice_='';
var hosts = new Array('www'),hostspool = new Array(),_timer1;
//Math.floor(Math.random()*10);,'bj51','bj53','bj54','bj55','bj56','bj57','bj58','bj115'  
//window.onerror=function(){return true;}
function loadPrice(hid,tm1,tm2,fid,CB,showall){//CB: HOTELMAP.ASP callback function       showall = false 全部显示房型;  showall = true 部分显示房型
	var host;
	if(!hosts.length&&hostspool.length){
		hosts = hostspool;
		hostspool = [];
	}
	function randomain(v){
		if(hosts[v]){
			var h = hosts[v];
			if(h!="www"){
				var aa = new Array();
				for(var a in hosts){
					if(hosts[a]!=h){aa.push(hosts[a]);}else{hostspool.push(h);}
				}
				hosts = aa;
				aa = null;
			}
			return h;
		}else{
			return 'www';
		}
	}
	
	host=randomain((reNum==0?0:Math.floor(hosts.length*Math.random())));
	
	this.trys = 0;
	hid_ = hid||hid_;
	tm1_ = tm1||tm1_;
	tm2_ = tm2||tm2_;
	fid_ = fid;
	agent_id = fid_;
	if(showall == undefined)showall = true;
	this.callID = "ZN_"+GLOB++;
	if(!(p_c.tm2&&p_c.tm1)){
		p_c.tm1 = tm1_;p_c.tm2 = tm2_;
	}else{
		if(p_c.tm1!=tm1_||p_c.tm2!=tm2_){
			p_c.revoke(1);
		}
	}
	var hid_n = new Array(),hid_t;

	if(isNaN(hid_)&&hid_.indexOf(',')!=-1){
		hid_t = hid_.split(",");
		for(var i=0;i<=hid_t.length;i++){
			var id = hid_t[i];
			if(id){
				if(p_c.get(id)){
					vhotel(p_c.get(id),true,showall);
				}else{
					hid_n.push(id);	
				}
			}
		}
		hid_ = hid_n.join(",");
	}
	if(host=="www"){
		this.url = 'http://js1.znimg.com/e/json.php?hid='+hid_+'&tm1='+tm1_+'&tm2='+tm2_+'&orderfrom='+fid_+'&r='+Math.random();
	}else{
		this.url = 'http://'+host+'.api.zhuna.cn/e/json.php?hid='+hid_+'&tm1='+tm1_+'&tm2='+tm2_+'&orderfrom='+fid_+'&r='+Math.random();
	}
	var aa = hid_+"_"+tm1+"_"+tm2+"_"+fid, T = this;
	//alert(CACHE_[aa]);
	if(hid_){
		try{
			$.ajax({type:"get",dataType:"jsonp",jsonp:"call",url:this.url,success:function(data){
				callback(data,showall);
				if(CB&&CB.mapcall){
					CB.mapcall(hid_);
					window._display=function(id){
						if($.trim(_g(id).style.display)!='block'){_g(id).style.display='block';}else{_g(id).style.display='none'}
						CB.mapcall(hid_);
						var s = $("#"+id).find("img[s]");
						s.each(function(){
							var ss =  $(this),sss=ss.attr('s'),img = new Image();img.onload=function(){ss.attr('src',sss);ss.removeAttr("s");};img.src = sss;
						});
					}
				}
				if(CB&&CB.emapcall){
					CB.emapcall();
				}
			}});
		}catch(e){alert(e)}
		window.clearTimeout(_timer1);_timer1=window.setTimeout(function(){
			_jsout(hid,tm1,tm2,fid,CB);	
		},2000*(reNum+2));
	}
}
function _reLoad(){
	var ids=hid_.split(',');
	for(var i=0;i<ids.length;i++){
		if(_g('h'+ids[i]))_g('h'+ids[i]).innerHTML='<img src="http://www.api.zhuna.cn/price/default/loading.gif" alt="加载中"  style="padding:15px;" />';
	}
	new loadPrice();
}
function _jsout(hid,tm1,tm2,fid,CB){
	if(reNum<5){reNum++;new loadPrice(hid,tm1,tm2,fid,CB);return;}
	var ids=hid.split(','),isv=false;
	for(var i=0;i<ids.length;i++){
		isv=true;
		if(_g('h'+ids[i]))_g('h'+ids[i]).innerHTML='<div style="background-color:#FF9; border:1px solid #F30; width:500px; height:30px; line-height:30px; text-align:center; margin-bottom:10px ;height:40px; line-height:40px; color:#f30" > 在查询实时房态信息过程中出现异常!请<a href="javascript:_reLoad()">重试</a></div>';
	}	
	reNum=0;
	if(isv)send_error();
}
function send_error(){
		var tj_Img= document.createElement('img');
		tj_Img.src = 'http://img.users.51.la/4410022.asp';
		tj_Img.style.display='none';
		document.body.appendChild(tj_Img);	
}
function callback(jsData,showall){dn=0;window.clearTimeout(_timer1);reNum=0;var _Hide=true;hotels=jsData;if(hotels.length==1 && (showall == false)){_Hide=false};for(k in hotels){vhotel(hotels[k],_Hide,showall);/*cache*/p_c.set(hotels[k].zid,hotels[k]);/*cache*/}}

function RefreshHotel(hid,Hide,showall){dn=0;var k;for(k in hotels){if(hotels[k].zid==hid){vhotel(hotels[k],Hide,showall);return;}}
/*cache*/if(p_c.get(hid)){vhotel(p_c.get(hid),Hide,showall);}/*cache*/}

//get plans 
function gPlan(a,b,c){
	this.p = function(v){
		for(var m=0;m<v.rooms.length;m++){
			if(v.rooms[m].rid==b){
				for(var n=0;n<v.rooms[m].plans.length;n++){
					if(v.rooms[m].plans[n].planid==c){
						return v.rooms[m].plans[n];
					}
				}
				return null;
			}
		}
		return null;	
	}
	for(var k=0;k<hotels.length;k++){
		if(hotels[k].zid==a){
			return this.p(hotels[k]);
		}
	}
	if(p_c.get(a)){
		return this.p(p_c.get(a));
	}
	return null;
}
  
//hotel room
function no_room(hid,tm1,tm2,flag){
	url = "http://www.zhuna.cn/V5/ajax/a_getroundhotel_price.asp?hid="+hid+"&tm1="+tm1+"&tm2="+tm2+"&flag="+flag;
	$.ajax({type:"get",url:url,success:function(data){
		if(flag == 2){
			$("#h"+hid).html($("#h"+hid).html()+data);
		}else{
			$("#h"+hid).html(data);	
		}
	}});
}
function vhotel(hotel,Hide,showall){
	var no_return = true;
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
            html+='      <span class="row8">房量</span>';
			html+='      <span class="row6">&nbsp;</span>';
			html+='      <span class="row7">到店付款</span>';
			html+='    </div>';
			html+='    房型名称';
			html+='  </div>';
			html+='  <div class="room_all">';
		//room start
	var rNum=0, showlimite = false;
	if(showall == "map"){
		showlimite = true;	
	}else if(showall == "emap"){
		Hide=false;
	}
	if(hotel.rooms&&hotel.rooms.length>0){
		rNum=hotel.rooms.length;
	}else{
			html+='    <div class="no_room">\u5BF9\u4E0D\u8D77\uFF0C\u8BE5\u9152\u5E97\u5728<font color="#f60">'+hotel.tm1+'</font>\u81F3<font color="#f60">'+hotel.tm2+'</font>\u671F\u95F4\u6682\u65F6\u4E0D\u80FD\u9884\u8BA2\u3002\u60A8\u53EF\u4EE5\u9884\u8BA2\u9644\u8FD1<a href="http://www.zhuna.cn/search___0_0_0_0_0_1.html?hid='+hotel.zid+'">\u5176\u4ED6\u9152\u5E97</a></div>';
			$.getScript("http://js1.znimg.com/e/sx.php?zid="+hotel.zid);
			if(showall==false){
				no_room(hotel.zid,hotel.tm1,hotel.tm2,1);
				return;
			}
	}
	var dingwang = 0,dingdang = 0,minprice = 0,a;
	for(a=0;a<rNum;a++){
		var room=hotel.rooms[a];
		var _idv1='ri_'+room.rid;
		//plan
		for(var b=0;b<room.plans.length;b++){
			var plan=room.plans[b];
            var junjia=Math.round(plan.totalprice/plan.date.length);
                if(minprice > junjia || minprice == 0) {
                    minprice = junjia;
                } 
            if(Hide&&a>2){continue;}
			var rmd=(plan.priceCode=='RMB'||plan.priceCode=='')?'¥':'<i>'+plan.priceCode.replace(/HKD/gi,'HK$')+'</i>';
			html+='    <div class="room_row">';
			if(plan.jiangjin>0){no_return = false;}
			if(b==0){
				if(showlimite){
					html+='      <div class="room_name" style="width:110px;">';
				}else{
					html+='      <div class="room_name" >';
				}
				var _css=(room.img)?'rn_pic':'rn_pic1';
                _css = (/限时/g.test(room.title))?'rn_pic2':_css;
				html+='          <a href="javascript:void(\''+_idv1+'\');" onclick="_display(\''+_idv1+'\');" class="'+_css+'">'+room.title+'</a>';		
				if(plan.description.Promotion)
				html+='          <img class="icon_room_sale" src="/v5/images/blank.gif" width="12" height="12" onmouseover="tips(this,\'v0\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')" />';
				html+='      </div>';		
			}
			html+='      <div class="row">';			
            html+='          <span class="row1" title="'+plan.planname+'">'+plan.planname+'</span>';
			if(b==0){html+='          <span class="row3" >'+room.adsl+'</span>'}else{html+='          <span class="row3">&nbsp;</span>'};
				var moreprice = "";
                if(room.plans.length>1&&b==0){
                    moreprice = '<img src=\"http://tp1.znimg.com/v5/images/blank.gif\" width=\"1\" title=\"更多价格\" onmouseover="_display_cur(event,\''+_idv1+'\');" onmouseout="_display_cur(event,\''+_idv1+'\');" onclick="_display_cur(event,\''+_idv1+'\');" height=\"1\"></span>';
                }
                if(dn>1){
					html+='          <span class="row4">'+rmd+'<strong onmouseover="tips(this,\'v1\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')" >'+junjia+'</strong>'+moreprice+'</span>';
				}else{
					html+='          <span class="row4">'+rmd+'<strong>'+junjia+'</strong>'+moreprice+'</span>';
				}
				if(plan.jiangjin>0){
					html+='          <span class="row5">¥<strong  onmouseover="tips(this,\'v2\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')">'+plan.jiangjin+'</strong></span>';
				}else{
					html+='          <span class="row5"></span>';
				}
                var fangliang = room.AvailableAmount;
                if(fangliang == "有房"){
                    html+='        <span class="row8">'+fangliang+'</span>';
                }else if(fangliang == "订完"){
                    html+='        <span class="row8"><font color="#999">'+fangliang+'</font></span>';
                }else if(/\d+/g.test(fangliang)){
                    html+='        <span class="row8">'+'<font color="red">仅剩'+fangliang+'</font>'+'</span>';
                }
				var _css='';
				if(plan.iscard&&plan.iscard==1)_css=' room_danbao1';
				//if(plan.iscard&&plan.iscard==3)_css=' room_danbao3';
				if(_css==''){
					html+='          <span class="row6">&nbsp;</span>';
				}else{
					html+='          <span class="row6'+_css+'" onmouseover="tips(this,\'v3\',\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')">&nbsp;</span>';
				}				
				html+='          <span class="row7">';
				dingdang++;//房型加一
				if(plan.status=='0'){
					html+='        <input type="button" class="btn_yd" onclick="dobook(\''+hotel.zid+'\',\''+room.rid+'\',\''+plan.planid+'\')"  value="预订">';
				}else{
					html+='      <input type="button" value="订完" class="btn_mf">';
					dingwang++;//订完房型加一
				}	
				html+='          </span>';
				html+='      </div>';
				html+='    </div>';
				if((!Hide)&&(a==0)){
					var _css='room_row_son1';
				}else{
					var _css='room_row_son';
				}
			if(b==0){html+=' <div class="'+_css+'" id="'+_idv1+'">';}
		}
		//end plan
        if(Hide&&a>2){continue;}
		var s_="s";
			html+='    <div class="room_info" >';
			html+='      <div class="room_info_arrow"></div>';
			html+='      <div class="room_info_con">';
			
			if(room.img){
				html+='      	<div class="room_info_pic">'; 
				for(var p1=0;p1<room.img.length;p1++){
					if(a==0&&(!Hide)){s_="src"}
					if(room.img[p1]){
						hashurl = "";
						try{hashurl = room.img[p1].spic.split("500x375_")[1];}catch(e){}
						if(room.img[p1].type==2){
							html+='      		 <div><img style="cursor:pointer;" onclick="F.moreimg('+hotel.zid+',null,event,1,'+room.rid+',\''+hashurl+'\')" '+s_+'="http://tp1.znimg.com'+room.img[p1].imgurl.replace('d:\\wwwroot\\p.zhuna.cn','')+'" src="http://tp1.znimg.com/v5/images/loading100_75.gif" width="100" height="75" alt="'+room.img[p1].title+'[客人实拍]"  /><em title="客人实拍照片"></em></div>';
						}else{
							html+='      		 <div><img '+s_+'="http://tp1.znimg.com'+room.img[p1].imgurl.replace('d:\\wwwroot\\p.zhuna.cn','')+'" src="http://tp1.znimg.com/v5/images/loading100_75.gif" width="100" height="75" alt="'+room.img[p1].title+'" /></div>';
						}
					}
					if(p1>1)p1=999;
				}
				html+='    		</div>';
				html+='			<div class="room_info_list1"><div>床型：'+room.bed+'</div><div>楼层：'+room.floor+'层</div><div>面积：'+room.area+'平米</div></div> ';
			}else{
				html+='			<div class="room_info_list2"><div>床型：'+room.bed+'</div><div>楼层：'+room.floor+'层</div><div>面积：'+room.area+'平米</div></div> ';
			}			
			if(room.notes)html+='<div class="room_info_note">其他：'+room.notes+' </div>';
			html+='    </div>';	
			html+=' </div>';
			html+=' </div>';
	}
		//room end
			html+='  </div>';
		if(showlimite){
			if(hotel.rooms&&hotel.rooms.length>3){
				html+='  <div class="room_more">';
				html+='    <a href="http://www.zhuna.cn/hotel-'+hotel.zid+'.html" target="_blank">所有房型('+rNum+')</a>';
				html+='  </div>';
			}
		}else{
			if(hotel.rooms&&hotel.rooms.length>3){
			    html += '  <div class="room_more">';
			    if (typeof showall == "string") {
			        showall_str = "\'"+showall+"\'";
			    } else {
			        showall_str = showall;
			    }
					if(Hide){
					    html += '    <a href="javascript:RefreshHotel(' + hotel.zid + ',false,' + showall_str + ')" class="r_more">所有房型(' + rNum + ')</a>';
					}else{
					    html += '    <a href="javascript:RefreshHotel(' + hotel.zid + ',true,' + showall_str + ')" class="r_more1">部分房型(' + rNum + ')</a>';
					}				
					html+='  </div>';
			}
		}
			html+='</div>';
		if(no_return){
			//html = html.replace(/<span class=\"row5\">[^</]+<\/span>/g,'');
			html = html.replace(/<span class=\"row5\">([^</span>]+)?<\/span>/g,'')
		}
	if(_g('h'+hotel.zid))_g('h'+hotel.zid).innerHTML=html;
    var hotel_div = $('#h'+hotel.zid),room_tuan = hotel_div.prev("div.room_tuan");
    hotel_div.removeClass("list_padding");
    if(room_tuan){
        room_tuan = room_tuan.removeClass("hidden");
        hotel_div.find("div.room_title").after(room_tuan);
    }
    //设置最低价
    if(minprice){
        $('em#price'+hotel.zid).html(minprice);
    }
	if((dingwang>=dingdang) && (showall==false)){
		no_room(hotel.zid,hotel.tm1,hotel.tm2,2);
	}
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
			mhtml=_plan.description.Promotion.replace(/\n/g,'<br/>');
		}
		if(v1=='v1'){
			mWidth=18;
			var wk1='',wk2='';
			for(c in _plan.date){
				var dt=_plan.date[c];
				if(mWidth<368){mWidth+=50;wk1+='<dt>'+sToDate(dt.day).format('EE')+'</dt>';}
				if(dt.price=='×')dt.price = '满房';
				wk2+='<dd>'+sToDate(dt.day).format('d日')+'<em>'+dt.price+'</em></dd>';				
			}	
			mhtml='<div class="room_price"><dl>'+wk1+wk2+'</dl></div>';
		}
		if(v1=='v2'){
			mWidth=200
			if(agent_id==20){
				mhtml='预订并成功入住后，每间夜可获得<span>'+_plan.jiangjin+'</span>元奖金，离店后1-60天内登录住哪网会员中心“提取奖金”，住哪网将于您提现后的七个工作日内汇款至您提供的银行卡中。';
			}else{
				mhtml='该奖金在您入住离店后60日内登陆住哪网对酒店发表点评，<span>'+_plan.jiangjin+'/晚</span>的奖金会充值到您会员中心账户，满200元可提现到您的银行卡里。';
				//您入住酒店并结帐，在离店后60天内登录住哪网点评后，我们将会返还每晚<span>'+_plan.jiangjin+'</span>元至您的住哪网帐户中。预订并成功入住后，每间夜可获得<span>'+_plan.jiangjin+'</span>元奖金，离店后1-60天内登录住哪网会员中心申请提现，住哪网将于您提现的七个工作日内汇款至您指定的银行卡中。
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


function _display(id){
	if(_g(id).style.display!='block'){_g(id).style.display='block'}else{_g(id).style.display='none'}
	var s = $("#"+id).find("img[s]");
	s.each(function(){
			var ss =  $(this),sss=ss.attr('s'),img = new Image();img.onload=function(){ss.attr('src',sss);ss.removeAttr("s");};img.src = sss;
	});
}
function _display_cur(e,id){
    if(e.type == "click"){
        _display(id);
    }else if(e.type == "mouseout"){
        if($("#"+id)[0].style.display!='block'){
            $(e.target).removeClass("cur");
        }
    }else if(e.type == "mouseover"){
        $(e.target).addClass("cur");
    }
    
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
    }         
    for(var k in o){         
        if(new RegExp("("+ k +")").test(fmt)){         
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));         
        }         
    }         
    return fmt;         
}    