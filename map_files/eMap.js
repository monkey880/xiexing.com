var httpUrl={zhuna:"http://www.zhuna.cn",tp1:"http://tp1.znimg.com",map:window.location.href.replace(/[\/\\][^\/\\]*?(?:\?[\s\S]*){0,1}$/,"")};//map：使用了当前目录，映射时用"http://www.zhuna.cn/findhotel"
httpUrl.DataURL=/www.zhuna.cn/i.test(httpUrl.map)?'http://www.zhuna.cn/v5/Ajax/A_hotpoint.asp':httpUrl.map+'/point.asp';
httpUrl.base=httpUrl.map.replace(/^([^:]+[:]\/\/[^\/]+)[\s\S]*$/,"$1");
httpUrl.searchNote=httpUrl.zhuna+"/gongjiao/search_note.asp";
httpUrl.mapPoints="http://mappoints.zhuna.cn";
(function () {
var d = document;
var _=window._=function(e){return typeof(e)=="string"?d.getElementById(e):e};
var ie = !!(window.attachEvent && !window.opera);   
var wk = /webkit\/(\d+)/i.test(navigator.userAgent) && (RegExp.$1 < 525);
var fn = [];
var run = function () { for (var k in fn) fn[k](); };
_.note=function(w){
	$.ajax({
		"url":httpUrl.zhuna+"/findhotel/tongji/",
		"cache":false,
		"data":{"w":w},
		"success":function(d){}
	});
};
_.ready = function (f) {
	if (!ie && !wk && d.addEventListener)
		return d.addEventListener('DOMContentLoaded', f, false);
	if (fn.push(f) > 1) return;
	if (ie)
		(function () {
			try { d.documentElement.doScroll('left'); }
			catch (err) { setTimeout(arguments.callee, 0); return;}
			run();
		})();
	else if (wk)
		var t = setInterval(function () {
				if (/^(loaded|complete)$/.test(d.readyState))
				clearInterval(t), run();
			}, 0);
};

_.hashParameter=function(callback){
	if($.type(callback)=="function"){
		var nowUrl="";
		var intervalRun=null;
		var checkChange=function(){
			if(nowUrl!=window.location.hash){
				nowUrl=window.location.hash;
				var cbJson={};
				String(nowUrl).replace(/_/g,"%").replace(/([a-z\d%.,]+)\=([a-z\d%.,]+)/ig,function(a,b,c){
					try{
						cbJson[decodeURIComponent(b).toLowerCase()]=decodeURIComponent(c);
					}catch(e){}
					return "";
				});
				//decodeURIComponent 
				callback.call(this,cbJson);
			}
		};
		intervalRun=window.setInterval(checkChange,200);
	}
};
_.copyJson=function(json){
	var tempJson;
	if(typeof(json)!="undefined"){
		if(json==null){
			tempJson=null;
		}else if(json instanceof Array){
			tempJson=[];
			for(var i=0;i<json.length;i++){
				tempJson.push(arguments.callee(json[i]));
			}
		}else{
			if(typeof(json)!="object"){
				tempJson=json;
			}else{
				try{
					tempJson={};
					var over=true;
					for(var k in json){
						over=false;
						tempJson[k]=arguments.callee(json[k]);
					}
					if(over){
						tempJson=json;
					}
				}catch(e){
					tempJson=json;
				}
			}
		}
	}
	return tempJson;
};
_.jsCallback=function(jsName){
	if(typeof(jsName)=="string"){
		jsName=jsName.toLowerCase();
		var s=d.getElementsByTagName("script");
		for(var i=0;i<s.length;i++){
			var src=s.item(i).src;
			var index=src.toLowerCase().indexOf(jsName);
			if(index>-1){
				var b=false;
				if(/[?&][\s]*callback[\s]*=[\s]*([._$a-z0-9]+)/i.test(s.item(i).src.substr(index))){
					if(eval("typeof("+RegExp.$1+")=='function'")){
						eval(RegExp.$1+"()");
						b=true;
					}
				}
				return b;
			}
		}
	}
	return false;
};
_.Date=function(_date){
		var self=this;
		var date=(_date instanceof Date)&&_date || null;
		var funcName={"y":"FullYear","M":"Month","d":"Date","h":"Hours","m":"Minutes","s":"Seconds","S":"Milliseconds","w":"Day"};
		this.isDate=function(){return date instanceof Date};
		this.getDate=function(){return date;};
		this.setDate=function(_date){date=(_date instanceof Date)&&_date || null;return self;};
		this.getVal=function(type){
			var val;
			if(!self.isDate())return null;
			eval("val=date.get"+funcName[type]+"()");
			if(type==="M"){
				++val;
			}
			return val;
		};
		this.setVal=function(type,val){
			if(self.isDate()&&(!isNaN(val))){
				if(type=="M"){
					--val;
				}
				eval("date.set"+funcName[type]+"(val)");
			}
			return self;
		};
		var defFmStr="yyyy-MM-dd hh:mm:ss";
		//yyyy.MM.dd hh:mm:ss.S
		this.format=function(fmStr){
			return self.isDate()&&(fmStr||defFmStr).replace(/yyyy|(?:M|d|h|m|s){1,2}|S/g,function(k){var rs=self.getVal(k.charAt(0));if(k.length==2){if(rs<10)return "0"+rs}return rs})||null;
		};
		//y.m.d h:m:s.S
		this.addVal=function(type,val){
			if(self.isDate()){
				with(date){
					eval("set"+funcName[type]+"(get"+funcName[type]+"()+val)");
				}
			}
			return self;
		};
		//克隆
		this.clone=function(){
			return new _.Date(self.isDate()&&new Date(date.getTime())||null);
		};
		this.toString=function(){
			return self.isDate()&&self.format()||"";
		};
	};
_.now=function(){return new _.Date(new Date())};
_.Date.parseDate=function(str){
	var time=Date.parse(str);
	var date=null;
	if(time>0){
		date=new Date(time);
	}else if(typeof(str)=="string"){
		if(/^\s*\d{4,4}(?:(?:\D\s*\d{1,2}){0,5}|(?:\D\s*\d{1,2}){5}\D\s*\d+\D{0,1})\D{0,1}\s*$/.test(str)){
			var d=str.match(/\d+/g);
			var f=[1,1,0,0,0,0];
			d=d.concat(f.slice(f.length-(7-d.length),f.length));
			--d[1];
			date=new Date(d[0],d[1],d[2],d[3],d[4],d[5],d[6],d[7]);
		}
	}
	return new _.Date(date);
};
_.unify=function(name){
	var self=this;
	this.name=name;
	this.key;
	this.run=function(){
		self.key=(new Date().getTime())+"_"+Math.random();
		return new function(){
			var key=self.key;
			this.check=function(){
				return (key==self.key);
			};
		}();
	};
};

_.isNumeric=function (obj) {
	return !isNaN(parseFloat(obj)) && isFinite(obj);
};
_.RegExpEncode=function(sVal){
	//\、*、+、?、|、{、[、(、)、^、$、.、# 
	return (sVal&&typeof(sVal)=="string")?sVal.replace(/([\\*+?|\{\}\[\(\)\^\$\.\#])/g,"\\$1"):sVal;
};
_.isNull=function(obj){
	return obj===undefined||obj===null;
};
_.numAddZero=function(num,count){
	if(/^\s*0*(\d+)([\d\D]*)$/.test(num)){
		var zs=RegExp.$1;
		var addNum=count-zs.length;
		if(addNum>0){
			return (Math.pow(10,addNum)+""+zs+RegExp.$2).substr(1);
		}
	}
	return num;
};
_.rFalse=function(){return false};
_.parseInt=function(s,def){
	return s&&(!isNaN(s))&&parseInt(s)||def||0;
};
_.tab=function(json){
	/*
		ui.zhunaResultTab=new _.tab({
			elems:ele.zhunaResultTab.children("a"),
			elemsType:[0,{typeClass:"price",max:1},0,0,0],
			hoverClass:"hover",
			seleClass:"cur"
		});
	*/
	var me=this;
	var tabJson=$.extend({},json);
	this.nowSelect=0;
	tabJson.defClass=tabJson.defClass||"";
	tabJson.seleClass=tabJson.seleClass||"";
	tabJson.hoverClass=tabJson.hoverClass||"";
	this.callback=null;
	var removeLastClass=function(elem){
		if(elem.data("lastClass")){
			elem.removeClass(elem.data("lastClass"));
		}
	};
	var selectClass=function(elem,className){
		removeLastClass(elem);
		var o=tabJson.elemsType[elem.data("indexTab")];
		var tabType=elem.data("tabType")||"";
		var baseName=o&&(o.typeClass)||"";
		var classAllName=baseName+(className||"")+tabType;
		if(classAllName){
			elem.addClass(classAllName);
			elem.data(elem.data("lastClass",classAllName));
		}else{
			elem.data(elem.removeData("lastClass"));
		}
		return elem;
	};
	this.panel=function(tabCode,isBack){
		var t=tabJson.elems.eq(tabCode);
		var o=tabJson.elemsType[tabCode];
		if(o){
			var tabType=t.data("tabType");
			if(t.data("isSelected")){
				tabType++;
			}
			if(tabType>t.data("tabMax")){
				tabType=0;
			}
			t.data("tabType",tabType);
		}
		//全部选择默认class，并删除选择
		for(var i=0;i<tabJson.elems.length;i++){
			var elem=tabJson.elems.eq(i);
			selectClass(elem,tabJson.defClass);
			elem.data("isSelected",false);
		}
		t.data("isSelected",true);
		selectClass(t,tabJson.seleClass);
		me.nowSelect=tabCode;
		if(isBack!==false&&$.type(me.callback)=="function"){
			me.callback.call(me,t);
		}
	};
	this.selectPanel=function(tabCode,isBack){
		var t=tabJson.elems.eq(tabCode);
		var o=tabJson.elemsType[tabCode];
		//全部选择默认class，并删除选择
		for(var i=0;i<tabJson.elems.length;i++){
			var elem=tabJson.elems.eq(i);
			selectClass(elem,tabJson.defClass);
			elem.data("isSelected",false);
		}
		t.data("isSelected",true);
		selectClass(t,tabJson.seleClass);
		me.nowSelect=tabCode;
	};
	if(tabJson.hoverClass){
		tabJson.elems.hover(function(){
			var t=$(this);
			if(!t.data("isSelected")){
				selectClass(t,tabJson.hoverClass);
			}
		},function(){
			var t=$(this);
			if(!t.data("isSelected")){
				selectClass(t,tabJson.defClass);
			}
		});
	}
	tabJson.elems.l_click(function(){
		var t=$(this);
		me.panel(t.data("indexTab"));
		t[0].blur&&t[0].blur();
		return false;
	});
	this.init=function(isBack){
		for(var i=0;i<tabJson.elems.length;i++){
			var t=tabJson.elems.eq(i);
			var o=tabJson.elemsType[i];
			t.data({"indexTab":i,"typeClass":"","isSelected":false});
			if(o){
				//document.title=t.text()+"|"+new Date().getTime();
				t.data({"tabType":0,"tabMax":o.max,"typeClass":o.typeClass});
			}
			selectClass(t,tabJson.defClass);
			t.data({"lastClass":""});
		}
		this.panel(0,isBack||false);
	};
	this.init();
};
_.selectControl=function(json){
	var self=this;
	var parentElem=$(json.elem);
	var nameElem=$(".select_control_name:first",parentElem);
	var listParent=$(".select_list:first",parentElem);
	var list=$("> li",listParent);
	var defaultNameHTML=nameElem.html();
	this.selectLi=null;
	this.selectElemByIndex=function(index){
		list.removeClass("cur");
		if(arguments.length>0){
			list.eq(index).addClass("cur");
		}
	};
	this.selectIndex=function(index){
		listParent.hide();
		list.removeClass("cur");
		var li=list.eq(index);
		if(/cancel/i.test(li.attr("select_handle"))){
			self.init(false);
			return false;
		}
		self.selectLi=li;
		li.addClass("cur");
		nameElem.addClass("cur");
		var rTag=$(".select_list_show:first",li);
		nameElem.html(rTag.length>0?rTag.html():li.html());
	};
	var hideTimeout=null;
	var stopTime=function(){
		if(hideTimeout){
			window.clearTimeout(hideTimeout);
			hideTimeout=null;
		}
	};
	var hide=function(){
		stopTime();
		hideTimeout=window.setTimeout(function(){
			nameElem.removeClass("h_over");
			listParent.hide();
		},200);
	},show=function(){
		stopTime();
		nameElem.addClass("h_over");
		listParent.show();
	};
	nameElem.hover(show,hide);
	listParent.hover(show,hide);
	this.select=function(li){
		listParent.hide();
		if(/cancel/i.test(li.attr("select_handle"))){
			self.init();
			return false;
		}
		self.selectLi=li;
		li.addClass("cur");
		nameElem.addClass("cur");
		var rTag=$(".select_list_show:first",li);
		nameElem.html(rTag.length>0?rTag.html():li.html());
		return false;
	};
	list.hover(function(){
		$(this).addClass("h_over");
	},function(){
		$(this).removeClass("h_over");
	}).l_mousedown(function(){
		var t=$(this);
		if((!json.allowRepeat)&&t.is(".cur")){
			//已选择，则在init里取消
			self.init();
			listParent.hide();
			return false;
		}else{
			//未选择
			self.init(json.isAutoCancel);
			self.select(t);
		}
		if(typeof(json.callbackSelect)=="function")
		{
			var result={li:t};
			json.callbackSelect.call(self,result);
		}
		return false;
	});
	nameElem.l_mousedown(function(){
		if($(this).is(".cur")){
			self.init();
		}
		return false;
	});
	this.init=function(isCancel){
		if((isCancel!==false)&&self.selectLi&&typeof(json.callbackSelect)=="function")
		{
			var result={li:self.selectLi,"isCancel":(isCancel!==false)};
			json.callbackSelect.call(self,result);
		}
		self.selectLi=null;
		nameElem.removeClass("cur");
		nameElem.html(defaultNameHTML);
		self.selectElemByIndex();
	};
};
//数据数组，每页数量
_.pageTool=function(json){
	var self=this;
	//当前页数
	var nowPageCode=0;
	//页总数
	var pageCount=0;
	//数据总数
	var dataCount=0;
	//每页数量
	var num=10;
	//当前位置
	var pos=-1;
	var isInit=false;
	var datas=null;
	this.callback=null;
	this.callbackPos=null;
	var autoCallback=function(isPos){
		if($.type(self.callback)=="function"){
			var nowData=self.getNowPageData();
			self.callback.call(self,nowData);
			if(!isPos){
				self.setPos(nowData.start);
			}
		}
	};
	var autoCallbackPos=function(){
		if($.type(self.callbackPos)=="function"){
				self.callbackPos.call(self,datas[pos],pos);
		}
	};
	//获取数据集合
	this.getDatas=function(){
		return datas;
	};
	//获取数据集合
	this.getPos=function(){
		return pos;
	};
	this.setPos=function(_pos,isLoop){
		if(_.isNumeric(_pos)&&dataCount){
			if(_pos>=0&&_pos<dataCount){
				pos=_pos;
			}else if(isLoop){
				if(_pos<0){
					pos=dataCount-1;
				}else{
					pos=0;
				}
			}else{
				return false;
			}
			var showPageCode=parseInt(pos/num);
			if(isInit||nowPageCode!=showPageCode){
				self.setPageCode(showPageCode,true);
			}
			autoCallbackPos();
			return true;
		}
		return false;
	};
	//获取每页数
	this.getNum=function(){
		return num;
	};
	//isRepeat是否循环
	this.back=function(isLoop){
		if(pageCount){
			if(nowPageCode>0){
				nowPageCode--;
				autoCallback();
				return true;
			}else if(isLoop&&pageCount){
				nowPageCode=pageCount-1;
				autoCallback();
				return true;
			}
		}
		return false;
	};
	//下一页
	this.next=function(isLoop){
		if(pageCount){
			if(nowPageCode<pageCount-1){
				nowPageCode++;
				autoCallback();
				return true;
			}else if(isLoop){
				nowPageCode=0;
				autoCallback();
				return true;
			}
		}
		return false;
	};
	this.setPageCode=function(code,isPos){
		if(_.isNumeric(code)&&code>=0&&code<pageCount){
			nowPageCode=code;
			autoCallback(isPos);
		}
	};
	//获取数据索引所在页
	this.indexInPageCode=function(index){
		var inCode=Math.ceil((index+1)/num)-1;
		if(_.isNumeric(inCode)&&inCode>=0&&inCode<pageCount){
			return inCode;
		}
		return 0;
	};
	//获取当前是第几页
	this.getNowPageCode=function(){
		return nowPageCode;
	};
	//获取当前页数据
	this.getNowPageData=function(){
		var nowData={start:0,datas:null};
		if(dataCount){
			nowData.start=nowPageCode*num;
			nowData.datas=datas.slice(nowData.start,nowData.start+num);
		}
		return nowData;
	};
	//获取页总数
	this.getPageCount=function(){
		return pageCount;
	};
	//获取按钮数据,showLength表示显示按钮个数
	this.getBtnData=function(showLength){
		var start=0,end=1;
		if(pageCount){
			var sLength=_.isNumeric(showLength)&&showLength>0&&showLength||3;
			var left=Math.floor(sLength/2),right=sLength-left;
			start=nowPageCode-left;
			if(start<0){
				right-=start;
			}
			end=nowPageCode+right+1;
			if(end>pageCount){
				start-=(end-pageCount);
			}
			if(start<0){
				start=0;
			}
			if(end>pageCount){
				end=pageCount;
			}
		}
		return {"start":start,"end":end};
	};
	this.init=function(json){
		isInit=true;
		nowPageCode=0;
		//页总数
		pageCount=0;
		//数据总数
		dataCount=0;
		//每页数量
		num=10;
		datas=null;
		if(json){
			if(_.isNumeric(json.num)&&json.num>0){
				num=json.num;
			}
			if($.type(json.datas)=="array"){
				datas=json.datas;
				dataCount=datas.length;
				pageCount=Math.ceil(datas.length/num);
			}
			self.callback=json.callback;
			self.callbackPos=json.callbackPos;
			self.setPos(0);
		}
		isInit=false;
	};
	this.init(json);
};
//自动载入数据到自定义滚动条
_.autoLoadDataInScrollDiv=function(scrollbarObject){
	var autoInterval=null;
	var argu=arguments;
	var self=this;
	var frameHeight=scrollbarObject.height();
	var viewport=$(".viewport:first",scrollbarObject);
	var overview=$(".overview:first",viewport);
	var position=0;
	var oneView=false;
	var checkIsStop=function(){
		return false;
	};
	var getTsbarHeight=function(overview,viewport){
		var top=Math.abs(overview.position().top);
		var max=overview[0].scrollHeight-viewport.height();
		max=max>0?max:0;
		return top>max?max:top;
	};
	//距离底部什么时候执行更新
	var loadMinPx=200;
	this.setLoadMinPx=function(px){
		loadMinPx=px;
	};
	var allowAutoLoad=true;
	//允许自动检测高度更新
	this.openAutoLoad=function(){
		allowAutoLoad=true;
	};
	this.closeAutoLoad=function(){
		allowAutoLoad=false;
	};
	//允许一次视图
	this.oneView=function(){
		oneView=true;
		return self;
	};
	//设置检测方法
	this.setCheck=function(func){
		if(typeof(func)=="function"){
			checkIsStop=func;
		}
		return self;
	};
	var loadCallback=function(){};
	//设置加载数据回调 回调后判断是否
	this.setLoadCallback=function(func){
		if(typeof(func)=="function"){
			loadCallback=func;
		}
		return self;
	};
	var viewCallback=function(){};
	this.setViewCallback=function(func){
		if(typeof(func)=="function"){
			viewCallback=func;
		}
		return self;
	};
	var loadIndex=0;
	//检测是否显示列表视图,0为未显示，1为显示，2为已显示
	this.getListViewStatus=function(element){
		var elementTop=element.position().top;
		var elementButtomPos=elementTop+element.height();
		var endHeight=position+frameHeight;
		var status=0;
		if(elementButtomPos>position){
			if(elementTop>endHeight){
				status=2
			}else{
				status=1;
			}
		}
		return status;
	};
	var isFirst=true;
	this.start=function(){
		self.stop();
		autoInterval=window.setInterval(function(){
			if(!checkIsStop.apply(self,argu)){
				self.stop();
				return;
			}
			//document.title=""+new Date().getTime();
			var pos=getTsbarHeight(overview,viewport);
			var tempFrameHeight=scrollbarObject.height();
			if(oneView||position!=pos||tempFrameHeight!=frameHeight){
				position=pos;
				oneView=false;
				frameHeight=tempFrameHeight;
				var listHeight=overview.height();
				if(allowAutoLoad&&(listHeight-position-frameHeight<loadMinPx)){
					allowAutoLoad=false;
					loadCallback.call(self,loadIndex);
					loadIndex++;
				}
				viewCallback.call(self);
			}
		},200);
		if(isFirst){
			isFirst=false;
			loadCallback.call(this,loadIndex);
			loadIndex++;
		}
	};
	this.stop=function(){
		if(autoInterval){
			window.clearInterval(autoInterval);
		}
		autoInterval=null;
	};
};
})();
(function($){
	var names=["mouseover","mouseout","mousemove"];
	for(var k in names){
		var n=names[k];
		eval("$.fn.ns_"+n+"=function(func){return this."+n+"(function(e){if(this.contains&&e.relatedTarget&&this.contains(e.relatedTarget))return;return func.apply(this,arguments);});}");
	}
	var l_names=["click","mousedown","mouseup","dblclick"];
	for(var k in l_names){
		var n=l_names[k];
		eval("$.fn.l_"+n+"=function(func,retu){return this."+n+"(function(e){if(e.which!=3){return func.apply(this,arguments);}else{return retu}});}");
	}
	$.fn.keyenter=function(callback){
		var o=$(this);
		if(typeof(callback)=="function"){
			o.bind("keypress",function(e){
				if(e.keyCode==13){
					return callback.apply(this,arguments);
				}
			});
		}
		return o;
	};
	$.fn.dragElement=function(json){
		if(json){
			//json.start;
			//json.ing;
			//json.end;
			var t=$(this);
			var move=function(e){
				document.title=e.pageX +","+e.pageY;
			};
			var end=function(){
				if(this.releaseCapture){this.releaseCapture();}
				$(document).unbind("mousemove",move);
				return false;
			};
			var down=function(e){
				if(e.button==2)return;
				end.apply(this,arguments);
				if(this.setCapture){this.setCapture();}
				$(document).bind("mousemove",move);
				$(document).one("mouseup",end);
				return false;
			};
			t.mousedown(down);
			t.bind("losecapture",end);
		}
		return this;
	};
	$.fn.loadImg=function(url){
		var urlTemp=url;
		var o=$(this);
		if(o.is("img")){
			o.attr({"urladdr":url,"src":httpUrl.map+"/images/bank.gif"}).css({"background":'url("'+httpUrl.map+'/images/ajaxLoader.gif") no-repeat scroll 50% 50% transparent'});
			var rCount=0;
			var argu=arguments;
			var me=this;
			var isLoad=true;
			var newImg=$("<img\/>").bind("load",function(){
				o.attr("src",'').attr("src",urlTemp).css("background","");
			}).bind("error",function(){
				if(isLoad){
					isLoad=false;
					urlTemp=urlTemp+(/[?][\s\S]*$/.test(urlTemp)?"&":"?")+"r=1";
					newImg.attr("src",urlTemp);
				}else{
					o.attr("src",'').css("background","");
				}
			}).attr("src",urlTemp);
		}
	};
	$.fn.inputAutoWord=function(json){
		var o=this;
		if(o.is("input")){
			var tJson=$.extend(true,{},json);
			if(tJson){
				if(o.val()==tJson["word"]){o.val("")}//防止刷新不能使用自动删除
				var defaultVal=$.trim(o.val());
				o.attr("inputend","false");
				var addAttrs=function(){
					if(tJson["beforeClass"]){
						o.removeClass(tJson["beforeClass"]);
					}
					if(tJson["afterStyle"]){
						o.css(tJson["afterStyle"]);
					}
					if(tJson["afterClass"]){
						o.addClass(tJson["afterClass"]);
					}
					o.attr("inputend","true");
				};
				var removeAttrs=function(){
					if(tJson["afterClass"]){
						o.removeClass(tJson["afterClass"]);
					}
					if(tJson["beforeClass"]){
						o.addClass(tJson["beforeClass"]);
					}
					if(tJson["beforeStyle"]){
						o.css(tJson["beforeStyle"]);
					}
					o.attr("inputend","false");
				};
				if(defaultVal){
					if(tJson["afterStyle"]){
						o.css(tJson["afterStyle"]);
					}
					if(tJson["afterClass"]){
						o.addClass(tJson["afterClass"]);
					}
					o.attr("inputend","true");
				}else{
					o.val(tJson["word"]||"");
					if(tJson["beforeClass"]){
						o.addClass(tJson["beforeClass"]);
					}
					if(tJson["beforeStyle"]){
						o.css(tJson["beforeStyle"]);
					}
				}
				o.bind("focus",function(){
					if(o.attr("inputend")=="false"&&tJson["word"]){
						o.val("");
					}
					addAttrs();
					o.select();
				});
				o.bind("keydown mousedown",function(){
					if(o.attr("inputend")=="false"){
						setTimeout(function(){
						o.val("");
						addAttrs();
						o.select();
						},0);
					}
				});
				o.data("inputVal",function(val){
					if($.trim(val)==""){
						o.val(tJson["word"]||"");
						removeAttrs();
					}else{
						o.val(val);
						addAttrs();
					}
				});
				o.data("getInputVal",function(){
					var nVal=$.trim(o.val());
					if(tJson["word"]&&(nVal==""||nVal==tJson["word"])){
						return "";
					}
					return nVal;
				});
				o.bind("blur",function(){
					var nVal=$.trim(o.val());
					if(tJson["word"]&&(nVal==""||nVal==tJson["word"])){
						o.val(tJson["word"]||"");
						removeAttrs();
					}else{
						o.attr("inputend","true");
					}
				});
			}
			this.blur&&this.blur();
		}
		return this;
	};
	$.fn.autoScrollBarTop=function(json){
		var t=$(this);
		if(!t.data("tsb")){
			t.tinyscrollbar.apply(this,arguments);
		}
		if(t.data("autoIV")){
			clearInterval(t.data("autoIV"));
		}
		var viewport=t.find(".viewport:first");
		var overview=viewport.find(".overview:first");
		var nowHeight=overview.height();
		var nowOuterHeight=viewport.height();
		//遮罩层
		//var zhe=$(".map_zhe:first",t);
		var getTsbarHeight=function(overview,viewport){
			var top=Math.abs(overview.position().top);
			var max=overview[0].scrollHeight-viewport.height();
			max=max>0?max:0;
			return top>max?max:top;
		};
		var autoIV=setInterval(function(){
			var tHeight=overview.height();
			var tOouterHeight=viewport.height();
			if(nowHeight!=tHeight||nowOuterHeight!=tOouterHeight){
				var top=getTsbarHeight(overview,viewport);
				t.tinyscrollbar_update(top);
				nowHeight=tHeight;
				nowOuterHeight=tOouterHeight;
			}
			/*
			if(tHeight>tOouterHeight){
				zhe.show();
			}else{
				zhe.hide();
			}*/
		},200);
		t.data("autoIV",autoIV);
	};
	$.fn.styleTitle=function(json){
		if(!window._mouseMsgDiv){
			//自动鼠标提示
			window._mouseMsgDiv=$('<div class="mobile_notebass" style="visibility: hidden;"><span>鼠标提示</span></div>');
			window._msgText=$("span:first",window._mouseMsgDiv);
			$("body:first").append(window._mouseMsgDiv);
		}
		var ts=this;
		json=json||{};
		//搜索 data("title")  替换
		ts.each(function(){
			var t=$(this);
			var stData={offset:{left:0,top:0}};
			if(t.data("stData")){
				stData=t.data("stData");
			}
			if(t.is("[title]")){
				stData.title=t.attr("title");
				t.removeAttr("title");
			}
			if(stData.move){
				t.unbind("mousemove",stData.move);
			}
			if(stData.over){
				t.unbind("mouseover",stData.over);
			}
			if(stData.out){
				t.unbind("mouseout",stData.out);
			}
			stData=$.extend(true,stData,json);
			t.data("stData",stData);
			if(stData.title){
				if(t.data("isOver")==true){
					setTimeout(function(){
						window._msgText.text(stData.title);
					},1);
				}
				stData.move=function(e){
					var position={left:e.pageX,top:e.pageY};
					var overflowX=$(window).width()-(position.left+stData.offset.left)-window._msgText.width()-30,addX=0;
					//document.title="winWidth:"+$(window).width()+",msgWidth:"+window._mouseMsgDiv.width()+",_msgTextWidth:"+window._msgText.width()+",e.x:"+position.left+",overflowX:"+overflowX;
					if(overflowX<5){
						addX=overflowX;
					}
					window._mouseMsgDiv.css({"left":position.left+stData.offset.left+addX,"top":position.top+stData.offset.top+25});
				};
				stData.over=function(e){
					t.data("isOver",true);
					window._mouseMsgDiv.stop(true,true).css({"opacity":0.2}).animate({"opacity":1},200);
					window._mouseMsgDiv.css({"visibility":"visible"});
					window._msgText.text(stData.title);
					stData.move(e);
				};
				stData.out=function(){
					t.data("isOver",false);
					window._mouseMsgDiv.stop(true,true).animate({"opacity":0.2},200,function(){
						window._mouseMsgDiv.css("visibility","hidden");
					});
				};
				
				t.ns_mousemove(stData.move);
				t.ns_mouseover(stData.over);
				t.ns_mouseout(stData.out);
			}
		});
		return this;
	};
})(jQuery);
(function(){
	window.SERVERURL=httpUrl.map;//日历跨域
	var loadingString='<div class="loading_share">数据加载中...</div>';
	var ui={ele:{}};
	var ele=ui.ele;
	var service={zhuna:{},baidu:{},backHandle:{}};
	service.baidu.checkPoint=function(p){
		return (p&&p.lng>0&&p.lat>0)||false;
	};
	//返回上一步
	var backHandle=service.backHandle;
	backHandle.backDatas=[];
	backHandle.addBack=function(json){
		backHandle.backDatas.push(json);
	};
	backHandle.back=function(){
		//json={argu:,ref:}
		//backHandle.addBack({argu:arguments,ref:this});
		if(backHandle.backDatas.length>1){
			backHandle.backDatas.pop();
			var gotoData=backHandle.backDatas.pop();
			switch(gotoData.type){
				case "showLayer":
					ui.showLayer(gotoData.data);
				break;
				case "baiduSearch":
					service.baidu.search.apply(this,gotoData.data);
				break;
				case "zhunaSearch":
					service.zhuna.search.apply(this,gotoData.data);
				break;
			}
			//gotoData.argu.callee.apply(gotoData.ref,gotoData.argu);
		}else{
			ui.showLayer("home");
		}
	};
	service.zhuna.qufenSearchWord={};
	service.zhuna.isShouSuo=false;
	service.zhuna.isFullScreen=false;
	var sys={"ui":ui,"service":service};
	var map = null;
	var unifyFrame=new _.unify("统一返回框");
	ui.getTsbarHeight=function(overview,viewport){
		var top=Math.abs(overview.position().top);
		var max=overview[0].scrollHeight-viewport.height();
		max=max>0?max:0;
		return top>max?max:top;
	};
	ui.autoSize=function(){
		var windowWidth=$(window).width();
		var windowHeight=$(window).height();
		var topHeight=ele.nav.height();
		if(!service.zhuna.isFullScreen){
			topHeight+=ele.login.height()+ele.header.height()+20;
		}
		var bottomHeight=windowHeight-topHeight;
		var leftWidth=windowWidth-ele.conside.width();
		ele.mainbody.css({"width":windowWidth,"height":windowHeight});
		ele.main.css({"width":windowWidth,"height":bottomHeight});
		if(service.zhuna.isShouSuo){
			ele.mainmap.css({"width":,"height":bottomHeight});
			ele.e_map.css({"width":windowWidth,"height":bottomHeight});
			ele.conside.css("visibility","hidden");
		}else{
			ele.mainmap.css({"width":leftWidth,"height":bottomHeight});
			ele.e_map.css({"width":leftWidth,"height":bottomHeight});
			ele.conside.css("visibility","visible").css("height",bottomHeight);
		}
        ele.side_left.css({"height":bottomHeight-12});
		ele.tsbar_1.css("height",bottomHeight);
		ele.viewport.css("height",bottomHeight);
	};
	ui.showLayer_now_name=null;
	ui.showLayer=function(name){
		ui.showLayer_now_name=name;
		var list={
			"sidesearch":ele.sidesearch,
			"resetBun":ele.resetBun,
			"hotOptions":ele.hotOptions,
			"lineResult":ele.lineResult,
			"zhunaResult":ele.zhunaResult,
			"baiduResult":ele.baiduResult,
			"lineTop":ele.lineTop,
			"drivePolicy":ele.drivePolicy,
			"driveResult":ele.driveResult,
			"transitPolicy":ele.transitPolicy,
			"transitResult":ele.transitResult,
			"mapResetSelect":ele.mapResetSelect,
			"searchResultInfo":ele.searchResultInfo,
			"hotTitle":ele.hotTitle,
			"backBun":ele.backBun,
			"lineNav":ele.lineNav,
			"ppsz":$("#zn_ppsz"),//品牌选择
			"jdjb":$("#zn_jdjb"),//酒店级别
			"jgfw":$("#zn_jgfw")//价格范围
		};
		var show=function(){
			for(var k in list){
				list[k].hide();
			}
			for(var i=0;i<arguments.length;i++){
				var elem=list[arguments[i]];
				elem&&elem.show();
			}
		};
		var backFirst=function(){
			ele.backBun.text("返回上一步");
		};
		switch(name){
			case "home":
				backHandle.backDatas=[];
				ui.searchEnd();
				ele.viewSearchBtn.removeClass("nav5cur");
				show("baiduResult");
				map.clearOverlays();
				service.baidu.closeHotelTileLayer();
				arguments.callee.call(this,"hot");
				unifyFrame.run();
			break;
			case "hot":
				show("sidesearch","hotOptions","hotTitle");
				ele.sidecon.css("height",ele.sidesearch.height()+80);
				ele.sidesearch.clearQueue().animate({"left":0},500);
				ele.hotOptions.clearQueue().animate({"left":ele.conside.width()},500,function(){
					ele.tsbar_1.tinyscrollbar_update();
				});
			break;
			case "select_hot":
				show("sidesearch","hotOptions","hotTitle");
				ele.sidecon.css("height",ele.hotOptions.height()+80);
				ele.sidesearch.clearQueue().animate({"left":-1*ele.conside.width()},500,function(){
					ele.tsbar_1.tinyscrollbar_update();
				});
				ele.hotOptions.clearQueue().animate({"left":0},500);
				backHandle.addBack({"type":"showLayer","data":"select_hot"});
			break;
			case "baidu_result":
				ele.sidecon.css("height","");
				show("baiduResult","resetBun","backBun");
			    ele.tsbar_1.tinyscrollbar_update();
			break;
			case "zhuna_result":
				ele.sidecon.css("height","");
				show("zhunaResult","ppsz","searchResultInfo","jdjb","jgfw","resetBun","backBun");
			    ele.tsbar_1.tinyscrollbar_update();
			break;
			case "drive":
				ele.sidecon.css("height","");
				show("lineResult","lineTop","lineNav","driveResult","resetBun","drivePolicy","backBun");
			    ele.tsbar_1.tinyscrollbar_update();
			break;
			case "transit":
				ele.sidecon.css("height","");
				show("lineResult","lineTop","lineNav","transitResult","resetBun","transitPolicy","backBun");
			    ele.tsbar_1.tinyscrollbar_update();
			break;
			case "reselectInput":
				ele.sidecon.css("height","");
				show("lineResult","lineTop","lineNav","mapResetSelect","resetBun","backBun");
			    ele.tsbar_1.tinyscrollbar_update();
			break;
			case "shouqi":
				var point=map.getCenter();
				service.zhuna.isShouSuo=true;
				ui.autoSize();
				map.checkResize();
				map.setCenter(point);
				$("a",ele.shouqi).styleTitle({title:"展开右侧栏"});
			break;
			case "zhankai":
				var point=map.getCenter();
				service.zhuna.isShouSuo=false;
				ui.autoSize();
				map.checkResize();
				map.setCenter(point);
				$("a",ele.shouqi).styleTitle({title:"收起右侧栏"});
			break;
			case "openFullScreen":
				ele.login.hide();
				ele.header.hide();
				var point=map.getCenter();
				service.zhuna.isFullScreen=true;
				ui.autoSize();
				map.checkResize();
				map.setCenter(point);
			break;
			case "exitFullScreen":
				ele.login.show();
				ele.header.show();
				var point=map.getCenter();
				service.zhuna.isFullScreen=false;
				ui.autoSize();
				map.checkResize();
				map.setCenter(point);
			break;
		}
	};
	ui.init=function(){
		ele.mainbody=$(".mainbody:first");
		ele.main=ele.mainbody.find(".main:first");
		ele.mainmap=ele.main.find(".mainmap:first");
        ele.shouqi=ele.mainmap.find(".shouqi:first");
        ele.side_left=ele.mainmap.find(".side_left:first");
		ele.e_map=ele.mainmap.find("#e_map");
		ele.conside=ele.main.find(".conside:first");
		ele.sidesearch=ele.conside.find(".sidesearch:first");
		ele.searchInputTxt=$(".topseach:first .sea_in:first input:first");
		ele.searchBtn=$(".topseach:first .sea_put:first input:first");
		ele.searchLineStart=$(".topseach:first .sea_in2:first input:eq(0)");
		ele.searchLineEnd=$(".topseach:first .sea_in2:first input:eq(1)");
		ele.searchTabBtn=$(".topseach:first .topline");
		ele.login=$(".login:first",ele.mainbody);
		ele.header=$(".header:first",ele.mainbody);
		ele.nav=$(".nav:first",ele.mainbody);
		ele.backBun=$(".nav:first .sidemenu:first .search_back:first",ele.mainbody);
		ele.hotTitle=$(".nav:first .sidemenu:first .search_hot_title:first",ele.mainbody);
		ele.resetBun=$(".nav:first .sidemenu:first .search_reset:first",ele.mainbody);
		ele.searchResultInfo=$(".nav:first .sidemenu:first .search_result_info:first",ele.mainbody);
		ele.addrInfo=$(".nav:first .navright:first",ele.mainbody);
		ele.hots=ele.sidesearch.find("a");
		ele.hotOptions=ele.conside.find(".sidemess:first");
		ele.viewSearchBtn=$(".nav:first li a.nav5:first",ele.mainbody);
		ele.hotOptionsBack=ele.hotOptions.find(".sidereturn:first");
		ele.tsbar_1=ele.conside.find(".tsbar_1:first");
		ele.sidecon=ele.tsbar_1.find(".sidecon:first");
		ele.baiduResult=$(".baidu_result:first",ele.sidecon);
		ele.zhunaResult=$(".zhuna_result:first",ele.sidecon);
		ele.lineResult=$(".line_result:first",ele.sidecon);
		ele.lineNav=$(".line_nav:first",ele.sidecon);
		ele.lineTop=$(".search_taxi:first",ele.lineResult);
		ele.driveResult=$(".bus_way:first",ele.lineResult);
		ele.transitResult=$(".dir_line:first",ele.lineResult);
		ele.mapResetSelect=$(".map_reset_select:first",ele.lineResult);
		ele.zhunaResultList=$(".sidelist:first",ele.zhunaResult);
		ele.drivePolicy=$(".drive_single:first",ele.lineTop);
		ele.transitPolicy=$(".single:first",ele.lineTop);
		ele.zhunaResultTab=$(".sidenav:first",ele.zhunaResult);
		ele.zhunaResultTabJl=$("[t='jl']:first",ele.zhunaResultTab);
		ele.sidelist=ele.sidecon.find(".sidelist:first");
		ele.viewport=ele.tsbar_1.find(".viewport");
		ele.overview=ele.viewport.find(".overview:first");
		ele.tsbar_1.autoScrollBarTop({axis:"y"});
		ele.searchPrompt=$(".prompt",ele.mainmap);
		ele.hotel_room_list_info=$('<div class="hotel_room_list_info tab_content"><div id="list_srh_top"><div class="srh_box_tm1" style="width:170px;"><label for="tm1">入住时间<\/label><div class="qcbox" style="width:116px;"><input type="text" name="tm1" class="input_txt2" id="tm1" value=""\/><\/div><\/div><div class="srh_box_tm1" style="width:170px;"><label for="tm2">离店时间<\/label><div class="qcbox" style="width:116px;"><input type="text" name="tm2" class="input_txt2" id="tm2" value=""\/><\/div><\/div><div class="srh_box_btn"><a href="#" class=""><\/a><\/div><\/div><div class="clearfloat"><\/div><div class="room"> <\/div><\/div>');
		ele.hotel_room_list_room=$(".room:first",ele.hotel_room_list_info);
		ele.hotel_room_list_dianping=$('<div class="hotel_room_list_dianping tab_content"></div>');
		ele.hotel_room_list_tupian=$('<div class="hotel_room_list_tupian tab_content mappic"></div>');
		ele.hotel_room_list_sheshi=$('<div class="hotel_room_list_sheshi tab_content"></div>');
		ele.hotel_room_list_zhoubian=$('<div class="hotel_room_list_zhoubian tab_content"><div class="tiafficnav"><a class="cur">交通路线</a><a>周边搜索</a></div><div style="display:none" class="tiafficcon"><ul><li><span>景点</span><a href="#">公园</a>|<a href="#">博物馆</a>|<a href="#">游乐场</a>|<a href="#">动物园</a>|<a href="#">名胜古迹</a>|<a href="#">场馆建筑</a></li><li><span class="tiaico1">餐饮</span><a href="#">中餐</a>|<a href="#">西餐</a>|<a href="#">快餐</a>|<a href="#">咖啡厅</a>|<a href="#">日本菜</a>|<a href="#">火锅</a>|<a href="#">甜点</a></li><li><span class="tiaico2">生活</span><a href="#">银行</a>|<a href="#">超市</a>|<a href="#">医院</a>|<a href="#">加油站</a>|<a href="#">公交车站</a>|<a href="#">火车票代售点</a></li><li><span class="tiaico3">休闲</span><a href="#">网吧</a>|<a href="#">健身房</a>|<a href="#">KTV</a>|<a href="#">电影院</a>|<a href="#">购物商场</a>|<a href="#">酒吧</a></li><li class="tia4"><input type="text" name=""><a href="#"></a></li></ul></div><div class="tiafficmain"><ul><li><img width="1" height="1" class="gooutimg1" src="images/bank.gif">到酒店去</li><li class="goout1"><input type="text" name=""><a href="#"></a></li><li><img width="1" height="1" class="gooutimg2" src="images/bank.gif">到酒店出发</li><li class="goout2"><input type="text" name=""><a href="#"></a></li></ul></div></div>');
		ele.tsbar_1.tinyscrollbar({axis:"y"});//sizethumb
		$(window).bind("resize",ui.autoSize);
		ele.city_txt=$(".city_txt:first");
		ele.cityInput=$('.city_input:first');
		var ctof=ele.city_txt.offset();
		ui.autoSize();
		ele.main.show();
		$(".tsbar_1").tinyscrollbar({axis:"y"});
		//event
		ui.initEvent();
	};
	ui.getListSelectIndex=function(id,data,keys){
		var elem=$(id);
		var index=0;
		var selectIndex=0;
		$(".select_list li",elem).each(function(){
			var a=$("a:first",$(this));
			var isIndex=true;
			for(var i in keys){
				var key=keys[i];
				if(data[key]!=a.attr(key)){
					isIndex=false;
					break;
				}
			}
			if(isIndex){
				selectIndex=index;
			}
			index++;
		});
		return selectIndex;
	};
	ui.drawZhunaSearch=function(data){
		var showTabData={0:0,1:1,2:1,4:2,6:3,5:4};
		ui.zhunaResultTab.selectPanel(showTabData[data.Px]||0,false);
		var gjfw=ui.getListSelectIndex("#zn_jgfw",data,["maxprice","minprice"]);
		var jdjb=ui.getListSelectIndex("#zn_jdjb",data,["rank"]);
		var ppxz=ui.getListSelectIndex("#zn_ppsz",data,["lsid","ls"]);
		//alert("gjfw:"+gjfw+",jdjb:"+jdjb+",ppxz:"+ppxz);
		service.zhuna.selectGJFW.selectIndex(gjfw);
		service.zhuna.selectJDJB.selectIndex(jdjb);
		service.zhuna.selectPPXZ.selectIndex(ppxz);
	};
	ui.drawBaiduSearch=function(data){
		switch(data.type){
			case "drive":
				ui.baiduLineTab.selectPanel(0,false);
			break;
			case "transit":
				ui.baiduLineTab.selectPanel(1,false);
			break;
		}
	};
	ui.initEvent=function(){
		//给所有元素添加样式标题
		$("[title]").styleTitle();
		ele.searchTabBtn.styleTitle();
		//热门区域事件
		ele.hots.click(function(){
			ele.hotOptions.find("[t]").hide();
			ele.hotOptions.find("[t="+$(this).attr("t")+"]").show();
			service.zhuna.autoCityDibiao(null,service.zhuna.nowCity.areaid,service.zhuna.nowCity.id,$(this).attr("tid"));
			ui.showLayer("select_hot");
			return false;
		});
		//返回热门
		ele.hotOptionsBack.click(function(){
			ui.showLayer("hot");
			return false;
		});
		//住哪搜索返回列表选项卡
		ui.zhunaResultTab=new _.tab({
			elems:ele.zhunaResultTab.children("a"),
			elemsType:[0,{typeClass:"price",max:1},0,0,0],
			hoverClass:"hover",
			seleClass:"cur"
		});//ele.zhunaResultTab
		//百度搜索公交切换选项卡
		ui.baiduLineTab=new _.tab({
			elems:$("a",ele.lineNav),
			elemsType:[{typeClass:"taxi",max:0},{typeClass:"bus",max:0}],
			seleClass:"cur"
		});
		ui.baiduLineTab.callback=function(){
			service.baidu.contextSearch(service.baidu.searchData.start,service.baidu.searchData.end,"inputText");
			return false;
		};
		//选择公交为默认搜索
		ui.drawBaiduSearch({type:"transit"});
		var re_sec=$(".re_sec:first",ele.lineTop).children();
		//返回线路
		re_sec.eq(0).l_click(function(){
			service.baidu.contextSearch(service.baidu.searchData.end,service.baidu.searchData.start,"inputText");
			return false;
		});
		//重选地点
		re_sec.eq(1).l_click(function(){
			service.baidu.reselectInput();
			return false;
		});
		ele.backBun.l_click(function(){
			backHandle.back();
			return false;
		});
		ele.resetBun.l_click(function(){
			ui.showLayer("home");
			return false;
		});
		$(".nav:first li a",ele.mainbody).bind("focus",function(){
			this.blur&&this.blur();
		});
		$(".nav:first li > a",ele.mainbody).l_click(function(){
			var t=$(this);
			var defClass=$.trim((/\w+/.exec(t.attr("class"))+"").replace(/cur/ig,""));
			if(!/cur/i.test(t.attr("class"))){
				switch($.trim(t.text())){
					case "打点":
						service.baidu.mkrTool.open();
					break;
					case "视野内搜索":
						service.zhuna.searchView();
					break;
					case "卫星":
					case "地图":
						if($.trim(t.text())=="卫星"){
							map.setMapType(BMAP_HYBRID_MAP);
							t.text("地图");
							t.styleTitle({title:"切换到普通地图"});
						}else{
							map.setMapType(BMAP_NORMAL_MAP);
							t.text("卫星");
							t.styleTitle({title:"切换到卫星地图"});
						}
					return false;
					break;
					case "全屏":
						//打开全屏
						ui.showLayer("openFullScreen");
					break;
					default:
					return false;
				}
				t.attr("class",defClass+" "+defClass+"cur");
			}else{
				switch($.trim(t.text())){
					case "打点":
						service.baidu.mkrTool.close();
					break;
					case "视野内搜索":
						ui.showLayer("home");
					break;
					case "卫星":
					case "地图":
					return false;
					break;
					case "全屏":
						//关闭全屏
						ui.showLayer("exitFullScreen");
					break;
					default:
					return false;
				}
				t.attr("class",defClass);
			}
			return false;
		});
		ui.searchTabAlert=function(isSearchLine,isNotSelect){
			var t=ele.searchTabBtn;
			$(".topseach:first .sea_in,.topseach:first .sea_in2").hide();
			if(isSearchLine){
				$(".topseach:first .sea_in2").show();
				t.text("搜酒店");
				ele.searchLineStart.focus();
				ele.searchLineStart.select();
				t.styleTitle({title:"切换到酒店搜索"});
			}else{
				$(".topseach:first .sea_in").show();
				t.text("搜线路");
				t.styleTitle({title:"切换到线路搜索"});
				if(isNotSelect!==false){
					ele.searchInputTxt.focus();
					ele.searchInputTxt.select();
				}
			}
		};
		//搜索类型切换按钮
		ele.searchTabBtn.l_mousedown(function(){
			ui.searchTabAlert($.trim($(this).text())=="搜线路");
			return false;
		});
		//切换起终点
		var qhqzd=$(".topseach:first .sea_in2:first span:first").l_mousedown(function(){
			var startVal=ele.searchLineStart.data("getInputVal")();
			var endVal=ele.searchLineEnd.data("getInputVal")();
			ele.searchLineStart.data("inputVal")(endVal);
			ele.searchLineEnd.data("inputVal")(startVal);
			return false;
		}).hover(function(){
			$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
		});
		var unifyCaCityFrame=new _.unify("统一价格框");
		var yibanAdd=function(elem,title,data,pushType){
			elem.html("");
			if(data){
				if(data.length<1){
					elem.text("暂无“"+title+"”");
					return;
				}
				elem.append('<dt><img height="1" width="1" class="mess_ico1" src="images/bank.gif">'+title+'</dt><dd><ul class="clear"></ul></dd>');
				var ul=$("ul:first",elem);
				for(var i=0;i<data.length;i++){
					(function(){
						var obj=data[i];
						if(pushType){
							service.zhuna.qufenSearchWord[$.trim(obj.title)]=obj;
							service.zhuna.qufenSearchWord[$.trim(obj.title)]._type=pushType;
							ul.append($('<li></li>').append($('<a href="#"></a>').text(obj.title).styleTitle({title:obj.title}).l_click(function(){
								var key=$.trim($(this).text());
								var val=key+"酒店";
								service.zhuna.search({"cityid":service.zhuna.nowCity.id,"hn":key,"_hn":val});
								return false;
							})));
						}else{
							ul.append($('<li></li>').append($('<a href="#"></a>').text(obj.title).styleTitle({title:obj.title}).l_click(function(){
								service.baidu.search({"content":$(this).text(),inputType:"inputText",type:"txt"});
								return false;
							})));
						}
					})();
				}
			}else{
				elem.text("暂无“"+title+"”");
			}
		};
		var cacheAutoCidyDiBiao={};
		service.zhuna.autoCityDibiao=function(isRun,areaid,cityid,type){
			var hoChild={1:"[t='sq']:first",2:"[t='qy']:first",3:"[t='jt']:first",4:"[t='dxzb']:first",5:"[t='jdzb']:first",6:"[t='yyzb']:first",7:"[t='dtzb']:first"};
			var childElem=$(hoChild[type],ele.hotOptions);
			var CB=function(d){
				if((!_.isNull(isRun))&&(!isRun.check())){return;}
				if(d){
					try{
						var dibiao=$.parseJSON(d);
						switch(parseInt($.trim(type))){
							case 2://行政区域
								yibanAdd(childElem,"行政区域",dibiao.value,type);
							break;
							case 1://商业区域
								yibanAdd(childElem,"商业区域",dibiao.value,type);
							break;
							case 3://火车站/机场
							var jt=ele.hotOptions.find("[t='jt']:first").html("");
							if(dibiao.value){
								jt.append('<dt><img height="1" width="1" class="mess_ico1" src="images/bank.gif">火车/机场</dt><dd></dd>');
								var dd=$("dd:first",jt);
								var isNullData=true;
								for(var k in dibiao.value){
									isNullData=false;
									var obj=dibiao.value[k];
									if(obj&&obj.length>0){
										dd.append($('<h3></h3>').text(k));
										var ul=$('<ul></ul>');
										dd.append(ul);
										for(var i=0;i<obj.length;i++){
											(function(){
												var objData=obj[i];
												service.zhuna.qufenSearchWord[$.trim(objData.title)]=objData;
												service.zhuna.qufenSearchWord[$.trim(objData.title)]._type=type;
												ul.append($('<li></li>').append($('<a href="#"></a>').text(obj[i].title).styleTitle({title:obj[i].title}).l_click(function(){
													//service.baidu.search({"content":$(this).text(),inputType:"inputText",type:"txt"});
													var key=$.trim($(this).text());
													var val=key+"酒店";
													service.zhuna.search({"cityid":service.zhuna.nowCity.id,"hn":key,"_hn":val});
													return false;
												})));
											})();
										}
									}
								}
								if(isNullData){
									jt.html("暂无“火车\/机场”");
								}
							}
							break;
							case 7://地铁周边
								var dtzb=childElem.html("");
								if(dibiao.value){
									dtzb.append('<dt><img height="1" width="1" class="mess_ico1" src="images/bank.gif">地铁周边</dt><dd></dd>');
									var dd=$("dd:first",dtzb);
									var isNullData=true;
									for(var k in dibiao.value){
										isNullData=false;
										var obj=dibiao.value[k];
										if(obj&&obj.length>0){
											dd.append($('<h3></h3>').text(k));
											var ul=$('<ul></ul>');
											dd.append(ul);
											for(var i=0;i<obj.length;i++){
												(function(){
													var objData=obj[i];
													service.zhuna.qufenSearchWord[$.trim(objData.title)]=objData;
													service.zhuna.qufenSearchWord[$.trim(objData.title)]._type=type;
													ul.append($('<li></li>').append($('<a href="#"></a>').text(obj[i].title).styleTitle({title:obj[i].title}).l_click(function(){
														//service.baidu.search({"content":$(this).text(),inputType:"inputText",type:"txt"});
														var key=$.trim($(this).text());
														var val=key+"酒店";
														service.zhuna.search({"cityid":service.zhuna.nowCity.id,"hn":key,"_hn":val});
														return false;
													})));
												})();
											}
										}
									}
									if(isNullData){
										dtzb.html("暂无“地铁周边”");
									}
								}
							break;
							case 4://大学周边
								yibanAdd(childElem,"大学周边",dibiao.value,type);
							break;
							case 5://景点周边
								yibanAdd(childElem,"景点周边",dibiao.value,type);
							break;
							case 6://医院附近
								yibanAdd(childElem,"医院附近",dibiao.value,type);
							break;
						}
					}catch(ex){}
				}
				if(ui.showLayer_now_name=="select_hot"){
					ele.sidecon.css("height",ele.hotOptions.height()+80);
				}
			};
			
			var cacheKey=areaid+"_"+cityid+"_"+type;
			if(cacheAutoCidyDiBiao[cacheKey]){
				childElem.html("");
				CB(cacheAutoCidyDiBiao[cacheKey]);
			}else{
				childElem.html(loadingString);
				$.ajax({
					"url":httpUrl.DataURL,
					"type":'POST',
					"data":{"areaid":areaid,"cityid":cityid,"types":type},
					"success":function(d){
						cacheAutoCidyDiBiao[cacheKey]=d;
						CB(d);
					},
					error:function(){CB.call(this)}
				});
			}
			/*
			childElem.html(loadingString);
			$.ajax({
				"url":httpUrl.DataURL,
				"type":'POST',
				"data":{"areaid":areaid,"cityid":cityid,"types":type},
				"success":CB,
				error:function(){CB.call(this)}
			});
			*/
		};
		new cityCA(ele.cityInput,function(data){
			//data->{"id":53,"name":"\u5317\u4eac","py":"Beijing","suoxie":"BJ","num":1763,"eid":"0101","bid":131,"lat":39.914889,"lng":116.403874,"bname":"\u5317\u4eac\u5e02"}
			if(data){
				if(map){
					var isRun=unifyCaCityFrame.run();
					service.zhuna.alterCity(data,isRun);
					ele.cityInput.hide();
					var cityName = service.zhuna.nowCity.name;
					map.setCenter(cityName);
					map.setCurrentCity(cityName);
					map.setZoom(14);
					var myGeo = new BMap.Geocoder();
					myGeo.getPoint(cityName, function(point){
						if(!isRun.check()){return;}
						map.setCenter(point);//设定地图的中心点和坐标并将地图显示在地图容器中
						setTimeout(function(){
						map.setZoom(14);
						},10);
					}, cityName);
					//ui.showLayer("home");
				}
			}
		});
		ele.city_txt.l_click(function(){
			ele.cityInput.show();
			ele.cityInput.select();
			ele.cityInput.mousedown();
			return false;
		});
		ele.cityInput.blur(function(){
			setTimeout(function(){
				ele.cityInput.val(ele.city_txt.text());
			},10);
			$(this).hide();
		});
		$(".search_taxi:first .single:first input,.search_taxi:first .drive_single:first input").click(function(){
			service.baidu.contextSearch(service.baidu.searchData.start,service.baidu.searchData.end,"mouse");
		});
		//收起展开按钮
		$("a",ele.shouqi).l_mousedown(function(){
			if(service.zhuna.isShouSuo){
				$(this).parent().removeClass("unfold");
				ui.showLayer("zhankai");
			}else{
				$(this).parent().addClass("unfold");
				ui.showLayer("shouqi");
			}
			return false;
		}).hover(function(){
			$(this).addClass("h_over");
		},function(){
			$(this).removeClass("h_over");
		});
		//新工具
		service.zhuna.selectControlTools=new _.selectControl({
			elem:".select_control:first.tools:first",
			callbackSelect:function(result){
				switch(result.li.attr("t")){
					case "ceju":
						if(result.isCancel){
							//取消
							service.baidu.myDis.close();
						}else{
							//选择
							service.baidu.myDis.open();
						}
					break;
				}
			}
		});
		//新价格范围
		service.zhuna.selectGJFW=new _.selectControl({
			elem:"#zn_jgfw",
			isAutoCancel:false,
			allowRepeat:true,
			callbackSelect:function(result){
				if(result.isCancel){
					service.zhuna.searchData.minprice=0;
					service.zhuna.searchData.maxprice=0;
					service.zhuna.search(service.zhuna.searchData,true);
				}else{
					var elem=$("a:first",result.li);
					service.zhuna.searchData.minprice=elem.attr("minprice");
					service.zhuna.searchData.maxprice=elem.attr("maxprice");
					service.zhuna.search(service.zhuna.searchData,true);
				}
			}
		});
		//新品牌选择
		service.zhuna.selectPPXZ=new _.selectControl({
			elem:"#zn_ppsz",
			isAutoCancel:false,
			allowRepeat:true,
			callbackSelect:function(result){
				if(result.isCancel){
					service.zhuna.searchData.lsid=0;
					service.zhuna.searchData.ls="";
					service.zhuna.search(service.zhuna.searchData,true);
				}else{
					var elem=$("a:first",result.li);
					service.zhuna.searchData.lsid=elem.attr("lsid");
					service.zhuna.searchData.ls=elem.attr("lsid")&&elem.text()||"";
					service.zhuna.search(service.zhuna.searchData,true);
				}
			}
		});
		//新酒店级别
		service.zhuna.selectJDJB=new _.selectControl({
			elem:"#zn_jdjb",
			isAutoCancel:false,
			allowRepeat:true,
			callbackSelect:function(result){
				if(result.isCancel){
					service.zhuna.searchData.rank=0;
					service.zhuna.search(service.zhuna.searchData,true);
				}else{
					var elem=$("a:first",result.li);
					service.zhuna.searchData.rank=elem.attr("rank");
					service.zhuna.search(service.zhuna.searchData,true);
				}
			}
		});
		service.zhuna.initLogin();
	};
	ui.iniDefaultUI=function(){
		ui.searchEnd();
	};
	ui.initCItyList=function(){
	};
	ui.searchIng=function(){ele.searchPrompt.show();};
	ui.searchEnd=function(){ele.searchPrompt.hide();};
	service.zhuna.getPriceRank=function(price){
        var p=_.parseInt(price);
        return (price<150)&&1||(price<300)&&2||(price<450)&&3||(price<600)&&4||5;
    };
	//service.zhuna.chke
	service.zhuna.shoucang=function(hid,title,marker){
		$.ajax({
			"url":httpUrl.zhuna+'/user/favoriteadd.asp',
			"type":'GET',
			"data":{"hid":hid,"hotelname":title},
			"cache":false,
			"success":function(d){
					//chongfu  ok nologin
				switch($.trim(d)){
					case "chongfu":
					alert("重复收藏");
					break;
					case "nologin":
					alert("请登陆后收藏");
					break;
					case "ok":
					alert("收藏成功");
					break;
				}
			},
			error:function(){
				alert((title?title+"，":"")+"收藏失败请稍后再试");
			}
		});
    };
	service.zhuna.xingjiData=["未评级","一星级","二星级","三星级","四星级","五星级"];
	service.zhuna.RankUIData={"class":[],"color":["","#368204","#e56f0f","#d52d00","#b00000","#0e58bb"],"xingji":[{n:"未评级"},{n:"一星级"},{n:"二星级"},{n:"三星级"},{n:"四星级"},{n:"五星级"}]};
	service.zhuna.xingji=function(num){
		if(isNaN(num)){
			return 0;
		}
		return  (num>10)&&1 || (num>6)&&2 || (num>4)&&3 || (num>2)&&4 || (num>0)&&5 || 0;
	};
	service.zhuna.comment=function(str){
		var pinglun={h:0,z:0,c:0,all:0};
		if(/(\d+)\$(\d+)\$(\d+)/.test(str)){
			pinglun.h=parseInt(RegExp.$1);
			pinglun.z=parseInt(RegExp.$2);
			pinglun.c=parseInt(RegExp.$3);
			pinglun.all=pinglun.h+pinglun.z+pinglun.c;
		}
		return pinglun;
	};
	var selectElement=null;
	service.zhuna.getHotelUrlByID=function(id){
		return "/booking/info_"+id+"/";
	};
	service.zhuna.getImgUrlByPicture=function(picture){
		return httpUrl.tp1+picture;
	};
	service.zhuna.searchData=null;
	service.zhuna.checkLogin=function(){
		return /ZhuNaUserName[=](\d+)/i.exec(document.cookie);
	};
	service.zhuna.initLogin=function(){
		var loginLayer=$("span",ele.login);
		loginLayer.hide();
		var logined=service.zhuna.checkLogin();
		//alert(document.cookie)
		if(logined){
			var ZhuNaNickName=/ZhuNaNickName[=]([^;]+)/i.exec(document.cookie);
			var showName=ZhuNaNickName&&decodeURI(ZhuNaNickName[1])||logined[1];
			loginLayer.eq(1).html('Hi!<a href="http://www.zhuna.cn/user/">'+$("<div\/>").text(showName).html()+'</a><a href="http://tuan.zhuna.cn/account/logout.php">退出</a>').show();
		}else{
			loginLayer.eq(0).show();
		}
	};
	service.zhuna.nowCity={id:"0101",name:"北京"};
	service.zhuna.defaultSearchData={r:2000};
	service.baidu.poiTypeNames={};
	service.baidu.poiTypeNames[BMAP_POI_TYPE_NORMAL]="地址";
	service.baidu.poiTypeNames[BMAP_POI_TYPE_BUSSTOP]="途经公交";
	service.baidu.poiTypeNames[BMAP_POI_TYPE_SUBSTOP]="途经地铁";
	service.zhuna.searchView=function(isHoldData){
		var bs=map.getBounds();
		var sw=bs.getSouthWest();//西南
		var ne=bs.getNorthEast();//东北
		if(isHoldData){
			service.zhuna.searchData.cityid=service.zhuna.nowCity.id;
			service.zhuna.search($.extend(service.zhuna.searchData,{rx:ne.lng,ry:sw.lat,lx:sw.lng,ly:ne.lat}),true);
		}else{
			service.zhuna.search({"cityid":service.zhuna.nowCity.id,rx:ne.lng,ry:sw.lat,lx:sw.lng,ly:ne.lat});
		}
		//r:东南 l:西北
	};
	service.zhuna.checkViewSearch=function(){
		if(ele.viewSearchBtn.is(".nav5cur")){
			service.zhuna.searchView(true);
		}
	};
	service.zhuna.search=function(data,isHoldData){
		//建立运行检测种子
		var isRun=unifyFrame.run();
		ui.searchTabAlert(false);
		backHandle.addBack({"type":"zhunaSearch","data":[$.extend({},data),isHoldData]});
		ui.searchIng();
		var bdCenterPoint=null;
		//区分是否视图搜索进入
		if(!data.rx){
			ele.viewSearchBtn.removeClass("nav5cur");
		}
		var qufenWord=service.zhuna.qufenSearchWord[data.hn];
		if(qufenWord){
			//bid	010119 商圈
			//canton	0005 行政区
			delete data.hn;
			data.key=qufenWord.title;
			//行政区域:2 商圈:1
			switch(parseInt(qufenWord._type)){
				case 1:
					//商圈
					data.bid=qufenWord.id;
				break;
				case 2:
					//行政区
					data.canton=qufenWord.id;
				break;
				default:
					if(_.isNumeric(qufenWord.baidu_lng)&&_.isNumeric(qufenWord.baidu_lat)&&qufenWord.baidu_lng!=0&&qufenWord.baidu_lat!=0){
						if(!_.isNumeric(data.r)){
							data.r=service.zhuna.defaultSearchData.r;
						}
						//alert("baidu_lng:"+qufenWord.baidu_lng+"|baidu_lat:"+qufenWord.baidu_lat);
						data.x=qufenWord.baidu_lng;
						data.y=qufenWord.baidu_lat;
					}else{
						data.n=qufenWord.id;
					}
				break;
			}
		}
		if(!isHoldData){
			ele.searchInputTxt.data("inputVal")(data["_hn"]||data["hn"]||"");
			service.zhuna.selectPPXZ.init(false);
			service.zhuna.selectJDJB.init(false);
			service.zhuna.selectGJFW.init(false);
		}
		if(_.isNumeric(data.x)&&_.isNumeric(data.y)){
			bdCenterPoint=new BMap.Point(data.x,data.y);
		}
		service.zhuna.searchData=data;
		service.zhuna.getHotelData(data,function(json){
			if(!isRun.check()){return;}//不是当前运行的结果，则结束
			if(json){
				var pageNum=10;
				var isFirst=true;
				var dataList=[];
				var position=0;
				var allowLoad=true;
				var searchEnd=false;
				var idsArr=json.ids&&json.ids.split(",")||[];
				ele.searchResultInfo.html('共找到&nbsp;<span class="c_ff0"></span>&nbsp;家酒店').find(".c_ff0:first").text(idsArr.length);
				if(idsArr.length>=1){
					ele.zhunaResultTab.show();
				}else{
					if((!qufenWord)&&(!isHoldData)&&$.trim(data["_hn"])){
						service.baidu.search({"content":data["_hn"],inputType:"inputText",type:"txt"});
						return;
					}
					ele.zhunaResultList.html("");
					ele.searchResultInfo.html('<span class="c_ff0">对不起，没有找到酒店</span>');
					ele.zhunaResultTab.hide();
					ui.showLayer("zhuna_result");
					ui.searchEnd();
				}
				service.baidu.openHotelTileLayer(isRun,data);
				var autoLoad=new _.autoLoadDataInScrollDiv(ele.tsbar_1);
				autoLoad.setCheck(function(){return isRun.check()});
				autoLoad.setViewCallback(function(){
					map.clearOverlays();
					var ph=[];
					for(var i=0;i<dataList.length;i++){
						var element=dataList[i].element;
						var marker=dataList[i].marker;
						if(this.getListViewStatus(element)>0){
							map.addOverlay(marker);
							if(selectElement==element){
								service.baidu.hotelWindow.openPriceMarker(marker);
							}
							ph.push(marker._json.point);
						}
						if(ph.length>9){
							break;
						}
					}
					//添加中心点
					if(_.isNumeric(data.x)&&_.isNumeric(data.y)&&_.isNumeric(data.r)){
						var point=new BMap.Point(data.x,data.y);
						var marker=new BMap.Marker(point, {icon: service.baidu.createPointIcon()});
						marker._json={title:"中心点",addr:"",point:marker.getPosition()};
						var dl=$("<dl\/>");
						marker.setTop(true);
						marker.addEventListener("click", function(e) {
							if(selectElement==dl){
								selectElement=null;
								service.baidu.pointWindow.close();
							}else{
								if(selectElement&&$.type(selectElement.data("out"))=="function"){
									selectElement.data("out")(true);
								}
								selectElement=dl;
								service.baidu.pointWindow.openNormalMarker(marker);
							}
						});
						new BMap.Geocoder().getLocation(marker._json.point, function(rs){
							var addComp = rs.addressComponents;
							marker._json.addr="地址："+rs.address;
							marker.setTitle(rs.address);
						});
						var circle = new BMap.Circle(point,data.r,{
							fillOpacity:0.01,
							strokeOpacity:0.4,
							strokeWeight:2
						});
						circle.enableEditing();
						map.addOverlay(circle);
						
						service.baidu.addCircleOverExec(function(){
							var tempaVs=circle.addVertexs;
							circle.addVertexs=function(){
								tempaVs.apply(this,arguments);
								circle.vertexMarkers[0].hide();
							};
							circle.clearVertexs=function(){};
							circle.addVertexs();
							circle.vertexMarkers[1].setTitle("拖动此点改变半径");
							circle.vertexMarkers[1].addEventListener("mouseup",function(){
								if(data.r!=circle.getRadius()){
									data.r=circle.getRadius();
									service.zhuna.search(data);
								}
							}); 
						});
						circle.addEventListener("mouseout",function(){setTimeout(function(){circle.addVertexs},51)}); 
						map.addOverlay(marker);
						var rightPoint=new BMap.Point(circle.getBounds().getNorthEast().lng,data.y);
						var marker2=service.baidu.radiusMarker({meter:parseInt(data.r),point:rightPoint});
						map.addOverlay(marker2);
						var pLine=new BMap.Polyline([point,rightPoint],{
							fillOpacity:0.4,
							strokeOpacity:0.4,
							strokeWeight:2
						});
						map.addOverlay(pLine);
						map.setViewport(circle.getBounds());
						ele.zhunaResultTabJl.show();
					}else{
						if(ph.length>0&&(!data.rx)){
							map.setViewport(ph);
						}
						ele.zhunaResultTabJl.hide();
					}
				});
				//转到第几页
                var gotoPage=function(num){
					ui.searchIng();
                    var startNum=pageNum*(_.parseInt(num));
                    var ids="";
                    if(idsArr.length>startNum){
                        var endNum=startNum+pageNum;
                        ids=idsArr.slice(startNum,(idsArr.length>endNum?endNum:idsArr.length)).join(",").replace(/\|\d*/g,"");
						var pageData={};
						$.extend(pageData,data,{"ids":ids});
						service.zhuna.getHotelData(pageData,function(rJson){
							if(!isRun.check()){return;}
							if(isFirst){
								ele.zhunaResultList.html("");
							}
							if(rJson){
								if(rJson.hotels&&rJson.hotels.length>0){
									//添加到页
									for(var i=0;i<rJson.hotels.length;i++){
										(function(){
											var hotelData=rJson.hotels[i];
											var rank=service.zhuna.getPriceRank(hotelData.price);
											var dl=$('<dl class=""><dt><span><\/span><\/dt><dd><table width="259" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td width="185"><div class="hotelname"><a><\/a><\/div>&nbsp;-&nbsp;<a class="details" href="#" target="_blank">详情&gt;&gt;<\/a><\/td><td width=""><a href="#" class="sidemobile" style="display:none"><\/a><a href="#" class="sidemsg" title="收藏"><\/a><span class="sidejuli">924米<\/span><\/td><\/tr><tr><td>星级：<img width="1" height="1" src="images\/bank.gif" class="star"><\/td><td rowspan="3"><img width="56" height="41" src="images\/img.jpg" class="hotelpic"><\/td><\/tr><tr><td>好评：<span class="c_8e9">98%<\/span><\/td><\/tr><tr><td>价格：<span class="c_f60">￥<\/span>起<\/td><\/tr><tr><td class="address" colspan="2" style="line-height: 16px;_padding-top:3px">地址：<\/td><\/tr><\/tbody><\/table><\/dd><\/dl>');
											var code=_.numAddZero(dataList.length+1,2);
											$("dt:first span:first",dl).text(code).attr("class","color"+rank);
											var title=hotelData.name||"";
											$(".hotelname:first a:first",dl).text(title).styleTitle({"title":title});
											$(".details:first",dl).attr({"href":service.zhuna.getHotelUrlByID(hotelData.id)}).l_mousedown(function(e){
												e.stopPropagation();
											}).styleTitle({"title":"进入酒店页面"});
											var rankStar=service.zhuna.xingji(hotelData.star);
											var xingji=service.zhuna.RankUIData.xingji[rankStar];
											var addr=hotelData.address&&("地址："+hotelData.address)||"";
											$(".address:first",dl).text(addr);
											$(".sidejuli:first",dl).text((data.point)?"米":"");
											var comment=service.zhuna.comment(hotelData.comment);
											$(".c_8e9:first",dl).text(comment.all==0?"暂无":Math.round(comment.h*100.0/comment.all)+"% (来自"+comment.all+"篇评论)").styleTitle({offset:{top:-8},title:comment.all==0?"":"好评:"+comment.h+"  中评:"+comment.z+"  差评:"+comment.c});
											$(".c_f60:first",dl).text("￥"+hotelData.price).css("color",service.zhuna.RankUIData.color[rank]);
											$(".hotelpic:first",dl).attr("src",service.zhuna.getImgUrlByPicture(service.zhuna.alterPicSize(hotelData.picture,"56x42")));
											$(".star:first",dl).addClass("star"+rankStar).styleTitle({"title":xingji.n});
											ele.zhunaResultList.append(dl);
											var point=new BMap.Point(hotelData.baidu_lng,hotelData.baidu_lat);
											if(false&&bdCenterPoint){
												var juli=parseInt(map.getDistance(bdCenterPoint,point));
												if(juli>0){
													if(juli<1000){
														$(".sidejuli:first",dl).text(juli+"米");
													}else{
														juli=parseInt(juli/1000);
														//juli=((juli/1000)+"").replace(/(\.\d{1,1})\d+/,"$1");
														$(".sidejuli:first",dl).text(juli+"千米");
													}
												}
											}
											var markerJson={};
											$.extend(markerJson,hotelData,{"point":point,"code":code,"price":hotelData.price,"title":title,"addr":addr});
											var marker=service.baidu.priceMarker(markerJson);
											var over=function(){
												dl.attr("class","cur");
												marker._json.element.css({"z-index":9999}).addClass("cur");
											},out=function(isAllow){
												if(isAllow===true||selectElement!=dl){
													dl.attr("class","");
													marker._json.element.css({"z-index":""}).removeClass("cur");
												}
											},mousedown=function(){
												if(selectElement==dl){
													selectElement=null;
													service.baidu.hotelWindow.close();
													return;
												}else{
													if(selectElement&&$.type(selectElement.data("out"))=="function"){
														selectElement.data("out")(true);
													}
													selectElement=dl;
												}
												over();
												service.baidu.hotelWindow.openPriceMarker(marker);
												return false;
											};
											dataList.push({
												"marker":marker,
												"element":dl,
												"hotelData":hotelData
											});
											var shoucangBtn=$(".sidemsg:first",dl);
											shoucangBtn.styleTitle();
											shoucangBtn.l_mousedown(function(e){
												if(!$(this).is(".cur")){
													service.zhuna.shoucang(hotelData.id,hotelData.name);
													if(service.baidu.hotelWindow._nowMarker==marker){
														var pDiv=$(service.baidu.hotelWindow._div);
														$(".mapshoucang:first a",pDiv).addClass("cur");
													}
													$(this).addClass("cur");
												}
												e.stopPropagation();
												return false;
											});
											dl.data("out",out);
											dl.data("over",over);
											dl.ns_mouseover(over);
											dl.ns_mouseout(out);
											dl.l_mousedown(mousedown);
											marker._elemDl=dl;
											marker._json.element.bind("dblclick",_.rFalse);
											marker._json.element.l_mousedown(mousedown);
											marker._json.element.hover(over,out);
										})();
									}
									autoLoad.openAutoLoad();
								}
							}
							if(isFirst){
								ui.showLayer("zhuna_result");
							}
							isFirst=false;
							ui.searchEnd();
							searchEnd=true;
							autoLoad.oneView();
						});
                    }else{
						autoLoad.oneView();
						//结束
						ui.searchEnd();
					}
                };
				autoLoad.setLoadCallback(function(index){
					gotoPage(index);
				});
				autoLoad.start();
			}else{
				//服务器异常
				ui.searchEnd();
			}
			if(!isHoldData){
				delete ui.zhunaResultTab.callback;
				ui.zhunaResultTab.init();
				var jiageEleme=$("a:eq(1)",MapHandle.ui.ele.zhunaResultTab);
				jiageEleme.styleTitle({title:"价格从低到高排序"});
				ui.zhunaResultTab.callback=function(elem){
					var elemType=$.trim(elem.text());
					if(elemType!="价格"){
						if(jiageEleme.data("tabType")){
							jiageEleme.styleTitle({title:"价格从高到低排序"});
						}else{
							jiageEleme.styleTitle({title:"价格从低到高排序"});
						}
					}
					switch(elemType){
						case "推荐":
							data.Px=0;
							break;
						case "价格":
							if(elem.data("tabType")==0){
								//低到高
								data.Px=1;
								elem.styleTitle({title:"切换到价格从高到低排序"});
							}else{
								//高到低
								data.Px=2;
								elem.styleTitle({title:"切换到价格从低到高排序"});
							}
							break;
						case "评价":
							data.Px=4;
							break;
						case "距离":
							data.Px=6;
							break;
						case "奖金":
							data.Px=5;
							break;
					}
					service.zhuna.search(data,true);
				}
			}
		});
		ui.drawZhunaSearch(data);
	};
	service.zhuna.alterPicSize=function(url,size){
		return typeof(url)=="string"?url.replace(/(?:\d+x\d+_){0,1}([^\/]+)$/i,(size&&(size+"_")||"")+"$1"):"";
	};
	service.zhuna.getHotelData=function(data,callback){
		if((!data)||(!data.cityid)||typeof(callback)!="function"){
			return false;
		}
		if((!data.tm1)||(!data.tm2)){
			var d=new _.Date(new Date()).addVal("d",2);
			data.tm1=d.format("yyyy-M-d");
			data.tm2=d.addVal("d",2).format("yyyy-M-d");
		}
		$.ajax({
			"url":httpUrl.zhuna+'/v5/Ajax/A_hotellist3.asp?callback=?',
			"type":'GET',
			"data":data,
			"dataType":"jsonp",
			"cache":false,
			"success":callback,
			error:function(){callback.call(this)}
		});
	};
	service.zhuna.alterCity=function(data,isRun){
		if(!data){return}
		service.zhuna.qufenSearchWord={};
		ele.city_txt.text(data["name"]);
		service.zhuna.nowCity.id=data["eid"];
		service.zhuna.nowCity.name=data["name"];
		service.zhuna.nowCity.areaid=data["id"];
		ele.cityInput.val(service.zhuna.nowCity.name);
		var hoChild={1:"[t='sq']:first",2:"[t='qy']:first",3:"[t='jt']:first",4:"[t='dxzb']:first",5:"[t='jdzb']:first",6:"[t='yyzb']:first",7:"[t='dtzb']:first"};
		var childElem=$('[tid]:visible',ele.hotOptions);
		if(childElem.length>0){
			service.zhuna.autoCityDibiao(isRun,service.zhuna.nowCity.areaid,service.zhuna.nowCity.id,childElem.attr("tid"));
		}
	};
	service.baidu.hotelTileLayer = new BMap.TileLayer({isTransparentPng: true});
	service.baidu.hotelTileLayer.getTilesUrl = function(tileCoord, zoom) {
		return httpUrl.mapPoints+'/Map.aspx?block_zoom=' + zoom + '&block_x=' + tileCoord.x + '&block_y=' + tileCoord.y + service.baidu.hotelTileLayer.appendUrl;
	};
	service.baidu.hotelTileLayer.getRequestAdd=function(data){
		if(!data){return ""}
		var keys=["cityid","tm1","tm2","city","areaid","lsid","canton","bid","rank", "ser", "sales", "vidio", "photo", "quanjing", "assure", "tuangou","n","key","minprice","maxprice","hn","Pg","ls","pmode","pinyin","kw1","kw2","hid","min","max","room","tky","mapbarid","tiaoshi","showaddress","x","y","r","types"];
		var result="";
		for(var i=0;i<keys.length;i++){
			var key=keys[i];
			if(data.hasOwnProperty(key)){
				result+="&"+encodeURIComponent(key)+"="+encodeURIComponent(data[key]);
			}
		}
		return result;
	}
	service.baidu.createHotelHotspots=function(){
		var hotelDatas=service.baidu.hotelTileLayer.hotelDatas;
		if(!(hotelDatas&&service.baidu.hotelTileLayer.isOpen)){return}
		var zoom = map.getZoom();
		var hotspotOffsets=[13,5,0,5];
		map.clearHotspots();
		for(var i=0;i<hotelDatas.length;i++){
			var hotel=hotelDatas[i];
			if((hotel["s"].toString(2)+" ").slice(-1*zoom-2,-1*zoom-1)=="1"){
				//创建热区
				var point = new BMap.Point(hotel["x"],hotel["y"]);
				var hotspot = new BMap.Hotspot(point, {userData:hotel,offsets:hotspotOffsets});
				map.addHotspot(hotspot);
			}
		}
	};
	service.baidu.openHotelTileLayer=function(isRun,data){
		var checkIsRun=isRun;
		if(!(data&&checkIsRun.check())){return}
		var tempAppUrl=service.baidu.hotelTileLayer.getRequestAdd(data);
		if(service.baidu.hotelTileLayer.isOpen){
			if(service.baidu.hotelTileLayer.appendUrl==tempAppUrl){
				return;
			}
		}
		service.baidu.closeHotelTileLayer();
		service.baidu.hotelTileLayer.isOpen=true;
		service.baidu.hotelTileLayer.appendUrl=tempAppUrl;
		$.ajax({
			url:httpUrl.mapPoints+"/GetDatas.aspx?callback=?",
			type:'GET',
			"dataType":"jsonp",
			"data":data,
			success: function(hotelDatas) {
				if(checkIsRun.check()){
					service.baidu.hotelTileLayer.hotelDatas=hotelDatas;
					service.baidu.createHotelHotspots();
					//添加图层
					map.addTileLayer(service.baidu.hotelTileLayer);
				}
			}
		});
	};
	service.baidu.closeHotelTileLayer=function(){
		service.baidu.hotelTileLayer.isOpen=false;
		map.clearHotspots();
		map.removeTileLayer(service.baidu.hotelTileLayer);
	};
	service.baidu.myLayer=function(json){
		this._json = json;
	};
	service.baidu.myLayer.prototype = new BMap.Overlay();
	service.baidu.myLayer.prototype.initialize = function(map){
		this._map = map;
		this._element=$(this._json.element);
		this._element.css({
			position:"absolute"
		});
		if(isNaN(this._element.css("z-index"))){
			this._element.css("z-index",this._json.point.lat);
		}
		map.getPanes().labelPane.appendChild(this._element[0]);
		return this._element[0];
	};
	service.baidu.myLayer.prototype.draw = function(){
	  if(typeof(this._json.draw)=="function"){
		return this._json.draw.apply(this,arguments);
	  }else{
		  var map = this._map;
		  var pixel = map.pointToOverlayPixel(this._json.point);
		  this._element.css({
			left: pixel.x - (this._json.offsetX||0),
			top: pixel.y - (this._json.offsetY||0)
		  });
	  }
	};
	service.baidu.normalMarker=function(json){
		var element=$("<div></div>");
		element.text(json.text);
		element.attr({"title":json.title,"class":"emap_baidu_icon"}).styleTitle();
		$.extend(json,{point:json.point,offsetX:13,offsetY:30,"element":element});
		return new service.baidu.myLayer(json);
	};
	service.baidu.radiusMarker=function(json){
		var element=$('<div class="map_editline" style="width:70px;"><div class="map_editline1"><span title="拖动小方块可改变半径">1000m</span><a class="map_close" title="关闭" > x</a></div></div>');
		element.find(".map_editline1:first span:first").text(json.meter+"m");
		element.find(".map_close").styleTitle().click(function(){
			element.hide();
			return false;
		});
		$.extend(json,{point:json.point,offsetX:-5,offsetY:10,"element":element});
		return new service.baidu.myLayer(json);
	};
	service.baidu.priceMarker=function(json){
		var element=$('<div class="list_msg1"><div class="position1"><a><span>5<\/span><strong><small>￥<\/small><b><\/b><\/strong>起<\/a><\/div><\/div>');
		$(".position1:first a:first span:first",element).text(json.code);
		$(".position1:first strong:first b:first",element).text(json.price);
		element.attr({"class":"list_msg list_msg"+service.zhuna.getPriceRank(json.price)}).styleTitle({title:json.title});
		$.extend(json,{point:json.point,"element":element,draw:function(){
		  var map = this._map;
		  var pixel = map.pointToOverlayPixel(this._json.point);
		  this._element.css({
			left: pixel.x - (this._element.width()/2) + 1,
			top: pixel.y - this._element.height() - 7
		  });
		}});
		return new service.baidu.myLayer(json);
	};
	service.baidu.poiTypeNames={};
	service.baidu.poiTypeNames[BMAP_POI_TYPE_NORMAL]="地址";
	service.baidu.poiTypeNames[BMAP_POI_TYPE_BUSSTOP]="途经公交";
	service.baidu.poiTypeNames[BMAP_POI_TYPE_SUBSTOP]="途经地铁";
	var cancelSelectElement=function(){
		if(selectElement&&$.type(selectElement.data("out"))=="function"){
			selectElement.data("out")(true);
		}
		selectElement=null;
	};
	service.baidu.autoCreateTitle=function(argu){
		var self=this;
		if(argu&&argu.length>0){
			var alter=function(obj){
				var arguTemp=argu;
				new BMap.Geocoder().getLocation(obj.point,function(rs){
					obj.title=rs.addressComponents&&$.trim(rs.addressComponents.street)||"未知路段";//||rs.addressComponents.district
					arguTemp.callee.apply(self,arguTemp);
				});
			};
			var start=argu[0].start,end=argu[0].end;
			if(typeof(start)=="object"){
				if(!start.title){
					alter(start);
					return true;
				}
			}
			if(typeof(end)=="object"){
				if(!end.title){
					alter(end);
					return true;
				}
			}
		}
		return false;
	};
	service.baidu.addMarkerFun=function(point,imgType,index,title){
		var url;
		var width;
		var height;
		var myIcon;
		// imgType:1的场合，为起点和终点的图；2的场合为过程的图形
		if(imgType == 1){
			url = httpUrl.tp1+"/v5/map/2/img/dest_markers.png";
			width = 42;
			height = 34;
			myIcon = new BMap.Icon(url,new BMap.Size(width, height),
					{
						anchor:new BMap.Size(14, 32),
						imageOffset:new BMap.Size(0, 0 - index * height)
					});
		}else{
			url = "http://openapi.baidu.com/map/images/trans_icons.png";
			width = 22;
			height = 25;
			var d = 25;
			var cha = 0;
			var jia = 0;
			if(index == 2){
				d = 21;
				cha = 5;
				jia = 1;
			}
			myIcon = new BMap.Icon(url,new BMap.Size(width, d),{offset: new BMap.Size(10, (11 + jia)),imageOffset: new BMap.Size(0, 0 - index * height - cha)});
		}
		 
		var marker = new BMap.Marker(point, {icon: myIcon});
		if(title != null && title != ""){
			marker.setTitle(title);
		}
		// 起点和终点放在最上面
		if(imgType == 1){
			marker.setTop(true);
		}
		map.addOverlay(marker);
		return marker;
	};
	service.baidu.setStartEndTitle=function(start,end){
		var startVal=start,endVal=end;
		if($.type(startVal)=="object"){
			startVal=start.title;
		}
		if($.type(endVal)=="object"){
			endVal=end.title;
		}
		ele.searchLineStart.data("inputVal")(startVal);
		ele.searchLineEnd.data("inputVal")(endVal);
	};
	service.baidu.setStartAndEndPoint=function(result){
		var startMarker=service.baidu.addMarkerFun(result.getStart().point,1,0,"拖动以更改线路");
		var endMarker=service.baidu.addMarkerFun(result.getEnd().point,1,1,"拖动以更改线路");
		service.baidu.startMarker=startMarker;
		service.baidu.endtMarker=endMarker;
		startMarker.enableDragging();//开启起点拖拽功能
		endMarker.enableDragging();//开启终点拖拽功能
		startMarker.addEventListener("dragend",function(e){
			service.baidu.searchData.start={point:e.point,title:""};
			service.baidu.searchData.inputType="mouse";
			service.baidu.searchData.isDragPointSearch=true;
			service.baidu.search(service.baidu.searchData);
		});
		endMarker.addEventListener("dragend",function(e){
			service.baidu.searchData.end={point:e.point,title:""};
			service.baidu.searchData.inputType="mouse";
			service.baidu.searchData.isDragPointSearch=true;
			service.baidu.search(service.baidu.searchData);
		});
	};
	
	var addBGCur=function(ele){
		ele.ns_mouseover(function(){
			$(this).addClass("gb_cur");
		});
		ele.ns_mouseout(function(){
			$(this).removeClass("gb_cur");
		});
	};
	var addLineLabel=function(p,path){
		(function(){
			var polyline = new BMap.Polyline(path,{strokeColor:"red", strokeWeight:6, strokeOpacity:0.5});
			p.ns_mouseover(function(){
				map.addOverlay(polyline);
			});
			p.ns_mouseout(function(){
				map.removeOverlay(polyline);
			});
			var ph=path;
			p.click(function(){
				map.setViewport(ph);
				return false;
			});
		})();
	};
	service.baidu.equalsOffsetPoint=function(point1,point2,offset){
		offset=offset||0.000005;
		try{
			return Math.abs(point1.lng-point2.lng)<=offset&&Math.abs(point1.lat-point2.lat)<=offset;
		}catch(e){
			return false;
		}
	};
	service.baidu.addStartMarker=function(p){
		service.baidu.searchData = service.baidu.addMarkerFun(p,1,0,"拖动可改变起点");
		service.baidu.startMarker.enableDragging();
		map.addOverlay(service.baidu.startMarker);
		return service.baidu.startMarker;
	};
	service.baidu.addEndMarker=function(p){
		service.baidu.endMarker = service.baidu.addMarkerFun(p,1,1,"拖动可改变终点");
		service.baidu.endMarker.enableDragging();
		map.addOverlay(service.baidu.endMarker);
		return service.baidu.endMarker;
	};
	service.baidu.getHandleType=function(){
		var className=/[^"=\s]+cur/.exec(ele.lineNav.html());
		return className=="taxicur"?"drive":"transit";
	};
	//获取操作类型方案，公交和驾车查询使用
	service.baidu.getHandlePolicy=function(h){
		var policy=0;
		var handleType=h||service.baidu.getHandleType();
		if(handleType=="drive"){
			policy=$("input:checked",ele.drivePolicy).val();
		}else{
			policy=$("input:checked",ele.transitPolicy).val();
		}
		return policy;
	};
	service.baidu.contextSearch=function(startPos,endPos,inputType){
		var hType=service.baidu.getHandleType();
		var p=service.baidu.getHandlePolicy(hType);
		service.baidu.search({"start":startPos,"end":endPos,policy:p,"inputType":inputType,type:hType});
	};
	var getReselectTitle=function(obj){
		return $.trim(typeof(obj)=="object"&&obj.title||obj||"");
	};
	service.baidu.reselectInfoWindow=new BMap.InfoWindow('',{offset:new BMap.Size(0, -27)});
	service.baidu.reselectInfoWindow.addEventListener("close",function(){
		service.baidu.resetPoiContext();
	});
	service.baidu.setReselectPoint=function(refPoi){
		var myPoi=refPoi||this.reselectNowPoi;
		if(myPoi){
			//var parent=myPoi.cell.parents(".rel_msg:first");
			//alert(myPoi.isStart+"|"+refPoi)
			if(myPoi.isStart){
				var parent=$("#reselectStart");
				if(service.baidu.endMarker){
					var tit=service.baidu.endMarker.getTitle();
					if(tit=="拖动可改变终点"){tit="";}
					service.baidu.contextSearch(
						myPoi,
						{point:service.baidu.endMarker.getPosition(),title:tit},
						"mouse"
					);
				}else{
					service.baidu.startMarker=service.baidu.addMarkerFun(myPoi.point,1,0,myPoi.title);
					parent.attr("class","finish");
					var title=parent.children(":eq(0)");
					title.html(title.html().replace(/^(.+?：)[\s\S]*$/,"$1")+myPoi.title);
					$("#reselectEnd h4:first").click();
				}
			}else{
				var parent=$("#reselectEnd");
				if(service.baidu.startMarker){
					var tit=service.baidu.startMarker.getTitle();
					if(tit=="拖动可改变起点"){tit="";}
					service.baidu.contextSearch(
						{point:service.baidu.startMarker.getPosition(),title:tit},
						myPoi,
						"mouse"
					);
				}else{
					service.baidu.endMarker=service.baidu.addMarkerFun(myPoi.point,1,1,myPoi.title);
					parent.attr("class","finish");
					var title=parent.children(":eq(0)");
					title.html(title.html().replace(/^(.+?：)[\s\S]*$/,"$1")+myPoi.title);
					$("#reselectStart h4:first").click();
				}
			}
			service.baidu.resetPoiContext();
		}
	};
	///////////////////////
	////////结束文本搜索
	////////////////////
	//添加重选结果
	var addReselectResult=function(pois,reselectPanel,json){
		service.baidu.reselectInput.reselectNowPoi=null;
		var p=$("<p>&nbsp;</p>");
		reselectPanel.append(p);
		var isStart=pois==json.resetStart;
		if(pois&&pois.length>0){
			var points=[];
			p.text("找到"+pois.length+"个地点，请从以下列表中选择");
			reselectPanel.append('<div class="msg_list"><div class="list_lf"></div></div>');
			var div=reselectPanel.find(".list_lf:first");
			for(var i=0;i<pois.length;i++){
				(function(){
					var poi=pois[i];
					poi.isStart=isStart;
					points.push(poi.point);
					var cell=$('<div class="list"><dl><dt></dt><dd><p><strong></strong></p><p>&nbsp;</p></dd></dl><input class="cur_bot" type="button" value="设为'+(poi.isStart?"起点":"终点")+'" /></div>');
					div.append(cell);
					var name=cell.find("strong:first");
					name.text(poi.title);
					var addr=cell.find("p:eq(1)");
					if(poi.address&&poi.address.length>0){
						addr.text((typeof(service.baidu.poiTypeNames[poi.type])!="undefined"?service.baidu.poiTypeNames[poi.type]+":":"")+poi.address);
					}
					var ico=cell.find("dt:first");
					var icoWidth=i*-25;
					ico.css("background-position",icoWidth+"px 4px");
					var myIcon= new BMap.Icon(httpUrl.tp1+"/v5/map/2/img/member_ico.png",new BMap.Size(23, 27),{anchor: new BMap.Size(11, 27),imageOffset: new BMap.Size(icoWidth, 1)});
					var marker = new BMap.Marker(poi.point,{icon: myIcon,title:poi.title});
					map.addOverlay(marker);
					var over=function(){
						marker.setIcon(new BMap.Icon(httpUrl.tp1+"/v5/map/2/img/member_ico.png",new BMap.Size(23, 27),{anchor: new BMap.Size(11, 27),imageOffset: new BMap.Size(icoWidth, -29)}));
						marker.setTop(true);
					};
					var out=function(){
						//if(service.baidu.reselectInput.reselectNowPoi==poi)return;
						//resetOpenMarker&&alert(resetOpenMarker.m)
						marker.setIcon(new BMap.Icon(httpUrl.tp1+"/v5/map/2/img/member_ico.png",new BMap.Size(23, 27),{anchor: new BMap.Size(11, 27),imageOffset: new BMap.Size(icoWidth, 1)}));
						marker.setTop(false);
					};
					marker.addEventListener("mouseover",over);
					marker.addEventListener("mouseout",out);
					//设置起始点
					cell.click(function(){
						service.baidu.setReselectPoint(poi);
						return false;
					});
					cell.mouseover(function(e){
						if(this.contains&&e.relatedTarget&&this.contains(e.relatedTarget)||service.baidu.reselectInput.reselectNowPoi==poi)return;
						over();
						service.baidu.reselectInfoWindow.setTitle("<span>"+ poi.title +"</span>");
						service.baidu.reselectInfoWindow.setContent('<span class="set_opint_addr">'+poi.cell.find("p:eq(1)").text()+'</span>'+'<input class="set_opint"  type="button" onclick="MapHandle.service.baidu.setReselectPoint()"  value="设为'+(poi.isStart?"起点":"终点")+'" />');
						marker.openInfoWindow(service.baidu.reselectInfoWindow);
						cell.addClass("cur");
						cell.find("dt:first").css("background-position",marker.getIcon().imageOffset.width+"px -40px");
						marker.setTop(true);
						service.baidu.reselectInput.reselectNowPoi=poi;
						return false;
					});
					marker.addEventListener("click",function(){
						cell.click();
					});
					poi.marker=marker;
					poi.cell=cell;
				})();
			}
			map.setViewport(points);
		}else{
			p.text("没找到相关的地点");
			reselectPanel.append("<p>您可以更换关键字，或在地图上右键选择起点</p>");
		}
	};
	service.baidu.resetPoiContext=function(){
		if(service.baidu.reselectInput.reselectNowPoi){
			var markerNote=service.baidu.reselectInput.reselectNowPoi.marker;
			var cellNote=service.baidu.reselectInput.reselectNowPoi.cell;
			var icon=null;
			if(cellNote){
				var left=markerNote.getIcon().imageOffset.width;
				cellNote.removeClass("cur");
				cellNote.find("dt:first").css("background-position",left+"px 4px");
				icon=new BMap.Icon(httpUrl.tp1+"/v5/map/2/img/member_ico.png",new BMap.Size(23, 27),{anchor: new BMap.Size(11, 27),imageOffset: new BMap.Size(left, 1)});
			}else{
				icon=new BMap.Icon(httpUrl.tp1+"/v5/map/2/img/member_ico.png",new BMap.Size(14, 16),{anchor: new BMap.Size(7, 16),imageOffset: new BMap.Size(-674, -32)});
			}
			
			markerNote.setIcon(icon);
			markerNote.setTop(false);
			service.baidu.reselectInput.reselectNowPoi=null;
		}
	};
	service.baidu.reselectInput=function(){
		var isRun=service.baidu.searchRun;
		if(!isRun.check()){return;}
		var json=service.baidu.searchData;
		var startTitle=getReselectTitle(json.start);
		var endTitle=getReselectTitle(json.end);
		var resetContent=function(o,t){
				var obj=$(o);
				obj.attr("class","rel_msg");
				var title=obj.children(":eq(0)");
				title.html(title.html().replace(/^(.+?：)[\s\S]*$/,"$1")+t);
				obj.children(":gt(0)").remove();
		};
		resetContent("#reselectStart",startTitle);
		resetContent("#reselectEnd",endTitle);
		var startSelect=function(){
			if(!isRun.check()){return;}
			var title=$("#reselectStart h4:first");
			var parent=title.parent();
			var childGt=parent.children(":gt(0)");
			var argu=arguments;
			map.clearOverlays();
			if(service.baidu.endMarker){
				map.addOverlay(service.baidu.endMarker);
			}
			if(!json.resetStart){
				var local = new BMap.LocalSearch(map,
					{
						pageCapacity:20,
						onSearchComplete: function(result){
							if(!isRun.check()){return;}
							var resetStart=[];
							//设置结果
							var num=result.getCurrentNumPois();
							var isPoi=typeof(json.start)=="object";
							if(isPoi){json.start.type=BMAP_POI_TYPE_NORMAL;}
							var addPoi=true;
							json.start.isStart=true;
							for(var i=0;i<num;i++){
								var startPoi=result.getPoi(i);
								startPoi.isStart=true;
								if(isPoi&&startPoi.point.equals(json.start.point)){
									resetStart.push(json.start);
									addPoi=false;
								}else{
									resetStart.push(startPoi);
								}
							}
							if(addPoi&&isPoi){
								resetStart=[json.start].concat(resetStart);
							}
							json.resetStart=resetStart;
							argu.callee();
							ui.searchEnd();
						}
					});
				ui.searchIng();
				local.search(getReselectTitle(startTitle));
				return;
			}
			//判断是否展开
			if(childGt.length==0){
				service.baidu.resetPoiContext();
				//没有展开:
				title.html(title.html().replace(/^(.+?：)[\s\S]*$/,"$1")+getReselectTitle(json.start));
				$(title).parent().attr("class","rel_msg");
				//连续点击后保留标注
				//显示mapSystem.lastReselectJson.resetStart，并绑定事件
				addReselectResult(json.resetStart,parent,json);
				$("#reselectEnd > :gt(0)").remove();
			}else{
				if(childGt.children(":first:hidden").length){
					childGt.show();
				}else{
					childGt.hide();
				}
			}
			return false;
		};
		var endSelect=function(){
			if(!isRun.check()){return;}
			var title=$("#reselectEnd h4:first");
			var parent=title.parent();
			var childGt=parent.children(":gt(0)");
			var argu=arguments;
			map.clearOverlays();
			if(service.baidu.startMarker){
				map.addOverlay(service.baidu.startMarker);
			}
			if(!json.resetEnd){
				var local = new BMap.LocalSearch(map,
				{
					pageCapacity:20,
					onSearchComplete: function(result){
						if(!isRun.check()){return;}
						var resetEnd=[];
						//设置结果
						var num=result.getCurrentNumPois();
						var isPoi=typeof(json.end)=="object";
						if(isPoi){json.end.type=BMAP_POI_TYPE_NORMAL;}
						var addPoi=true;
						json.end.isStart=false;
						for(var i=0;i<num;i++){
							var endPoi=result.getPoi(i);
							endPoi.isStart=false;
							if(isPoi&&endPoi.point.equals(json.end.point)){
								resetEnd.push(json.end);
								addPoi=false;
							}else{
								resetEnd.push(endPoi);
							}
						}
						if(addPoi&&isPoi){
							resetEnd=[json.end].concat(resetEnd);
						}
						json.resetEnd=resetEnd;
						argu.callee();
						ui.searchEnd();
					}
				});
				ui.searchIng();
				local.search(getReselectTitle(json.end));
				return;
			}
			//判断是否展开
			if(childGt.length==0){
				service.baidu.resetPoiContext();
				//没有展开:
				title.html(title.html().replace(/^(.+?：)[\s\S]*$/,"$1")+getReselectTitle(json.end));
				$(title).parent().attr("class","rel_msg");
				//连续点击后保留标注
				//显示mapSystem.lastReselectJson.resetStart，并绑定事件
				addReselectResult(json.resetEnd,parent,json);
				$("#reselectStart > :gt(0)").remove();
			}else{
				if(childGt.children(":first:hidden").length){
					childGt.show();
				}else{
					childGt.hide();
				}
			}
			return false;
		};
		$("#reselectStart h4:first").unbind("click").bind("click",startSelect);
		$("#reselectEnd h4:first").unbind("click").bind("click",endSelect);
		startSelect();
		ui.showLayer("reselectInput");
	};
	
	service.baidu.selectPolicyInput=function(handleType,val){
		if(_.isNumeric(val)){
			var policy=(handleType=="drive")?ele.drivePolicy:ele.transitPolicy;
			var inp=$("input[value='"+parseInt(val)+"']:first",policy);
			if(inp.length>0){
				inp.attr("checked","true");
			}
		}
	};
	var cacheSaveNoteToServer={};
	service.baidu.saveNoteToServer=function(json,handle,start,end){
		try{
			if((json.inputType!="url")&&(!json.isDragPointSearch)){
				//bd_cid=131&start=%E5%8C%97%E5%AE%AB%E9%97%A8&start_x=116.283986&start_y=40.008677&end=%E6%9C%9D%E9%98%B3%E9%97%A8
				var data={
					bd_cid:handle._json.current_city.code,
					start:start.title,
					start_x:start.point.lng,
					start_y:start.point.lat,
					end:end.title,
					end_x:end.point.lng,
					end_y:end.point.lat,
					operator:1
				};
				//var cacheKey=data.start_x+"_"+data.start_y+"_"+data.end_x+"_"+data.end_y;
				var cacheKey=start.title+"__"+end.title;
				if(!cacheSaveNoteToServer[cacheKey]){
					cacheSaveNoteToServer[cacheKey]=true;
				}else{
					return;
				}
				/*
				$.ajax({
					url:httpUrl.searchNote,
					type:'GET',
					cache:false,
					"data":data
				});
				*/
				// window.test_json=json;
				// window.test_handle=handle;
				// window.test_start=start;
				// window.test_end=end;
			}
		}catch(ex){}
	};
	service.baidu.search=function(json){
		if(!json){return;}
		var isRun=unifyFrame.run();
		service.baidu.searchRun=isRun;
		backHandle.addBack({"type":"baiduSearch","data":[json]});
		ele.viewSearchBtn.removeClass("nav5cur");
		ui.searchIng();
		service.baidu.searchData=json;
		ui.drawBaiduSearch(json);
		var handle;
		switch(json.type){
			case "drive":
				//service.baidu.search({"start":{point:null,title:seartVal},"end":{point:null,title:endVal},policy:0,type:"drive"});
				//service.baidu.search({"start":seartVal,"end":endVal,policy:0,type:"drive"});
				(function(){
					service.baidu.selectPolicyInput(json.type,json.policy);
					ui.searchTabAlert(true);
					if(service.baidu.autoCreateTitle(arguments)){
						return;
					}
					if(!isRun.check()){return;}
					var policys=[
						BMAP_DRIVING_POLICY_LEAST_TIME,// 最少时间。  
						BMAP_DRIVING_POLICY_LEAST_DISTANCE,// 最短距离。  
						BMAP_DRIVING_POLICY_AVOID_HIGHWAYS// 避开高速。  
					];
					handle=new BMap.DrivingRoute(map);
					handle.setPolicy(policys[json.policy]||0);
					handle.setSearchCompleteCallback(function(result){
						if(!isRun.check()){return;}
						map.clearOverlays();
						service.baidu.closeHotelTileLayer();
						//ele.lineResult
						var sendEle=$(".drive:first .bus_way_cur:first a:first",ele.lineResult);
						sendEle[0].onclick=null;
						var dcfy=$(".taxi",ele.lineTop);
						if(result.taxiFare&&result.taxiFare.day.totalFare){
							dcfy.show();
							dcfy.html('<img class="icon note" align="absmiddle" src="'+httpUrl.tp1+'/v5/map/2/img/bank.gif" alt="打车费用" />打车费用: '+result.taxiFare.day.totalFare+'元 (按驾车最短路程算)');
						}else{
							dcfy.hide();
						}
						var drive=$(".drive:first",ele.driveResult);
						var showLayer=drive.find("ul").eq(1);
						showLayer.html("");
						if (handle.getStatus() == BMAP_STATUS_SUCCESS){
							if(result.getNumPlans()>0){
								var startName=result.getStart().title;
								var endName=result.getEnd().title;
								service.baidu.setStartEndTitle(startName,endName);
								service.baidu.setStartAndEndPoint(result);
								//第一条方案
								//alert(result.getNumPlans())==1
								var mapPlan=result.getPlan(0);
								var topShow=$('<li><p class="juli_p"></p></li>');
								addBGCur(topShow);
								topShow.find("p:first").text("约"+mapPlan.getDuration(true)+"/"+mapPlan.getDistance(true));
								showLayer.append(topShow);
								var li_start=$('<li class="start1"><span class="start_ico"></span><font></font></li>');
								li_start.find("font:first").text(startName);
								showLayer.append(li_start);
								var sendContent="";
								//遍历线路，也只有1？
								for(var i=0;i<mapPlan.getNumRoutes();i++){
									//指定线路
									var route=mapPlan.getRoute(i);
									//线路地理坐标点数组
									var paths=route.getPath();
									//140paths.length 全部路径
									//点击路程显示全部路径
									addLineLabel(topShow,paths);
									topShow.click();
									var pathIndex=0;
									map.addOverlay(new BMap.Polyline(paths, {strokeColor: "#0030ff",strokeOpacity:0.45,strokeWeight:6,enableMassClear:true}));
									var lastPoint=result.getStart().point;
									//从第二个关键点开始
									for(var j=1;j<route.getNumSteps();j++){
										var step=route.getStep(j);
										//<li>1.从起点向正北方向出发，行驶80米，过左侧的<strong><a href="#">首都医科大学中医药学院</a></strong>，右转进入<strong>和平里北街</strong></li>
										var li=$("<li></li>");
										addBGCur(li);
										li.html("<em>"+(j)+".</em><p>"+(j==1?route.getStep(0).getDescription()+"，":"")+step.getDescription()+"</p>");
										sendContent+=(j)+"."+(j==1?route.getStep(0).getDescription(false)+"，":"")+step.getDescription(false);
										var addPath=new Array();
										//接着遍历
										for(;pathIndex<paths.length;pathIndex++){
											//"("+step.getPosition().lng+","+step.getPosition().lat+"|"+paths[pathIndex].lng+","+paths[pathIndex].lat+")\r\n";
											addPath.push(paths[pathIndex]);
											if(service.baidu.equalsOffsetPoint(step.getPosition(),paths[pathIndex])){
												//alert("("+step.getPosition().lng+","+step.getPosition().lat+")("+paths[pathIndex].lng+","+paths[pathIndex].lat+")")
												break;
											}
										}
										//添加鼠标移动上去显示标注
										addLineLabel(li,addPath);
										showLayer.append(li);
									}
								}
								var li_end=$('<li class="end1"><span class="end_ico"></span><font></font></li>');
								li_end.find("font:first").text(endName);
								showLayer.append(li_end);
								(function(){
									var content=("从“"+li_start.find("font:first").text()+"”起"+sendContent+"“"+li_end.find("font:first").text()+"”").replace("当前酒店-","");
									sendEle.html("路线发送至手机");
									sendEle[0].onclick=function(){
										var logined=/ZhuNaUserName[=](\d+)/i.exec(document.cookie);
										if(logined!=null){
											if(this.innerHTML!="正在发送请求.."){
												this.innerHTML="正在发送请求..";
													//ZhuNaUserName
													var obj=this;
													$.ajax({
														url:httpUrl.zhuna+'/v5/ajax/A_sendsms.asp?mobile='+logined[1]+'&content='+escape(content),
														type:'GET',
														cache:false,
														success: function(data) {
															alert(data);
															obj.innerHTML="重发路线至手机";
														},
														error:function(){
															alert("请求失败，请重试");
															obj.innerHTML="重发路线至手机";
														}
													});
											}
										}else{
											var selfArg=arguments;
											window.callback_login_success=function(){
												ZN.login();
												selfArg.callee();
												Tips.removeAll();
												service.zhuna.initLogin();
											};
											Tips({_title:"\u767B\u5F55", _content: "iframe:"+httpUrl.zhuna+"/v5/user/login_ajax.asp?purl=callback_login_success", _width: "450", _height: "300", _drag: "_boxTitle", _showbg: true});
										}
										return false;
									};
								})();
								//发送记录到后台
								service.baidu.saveNoteToServer(json,handle,result.getStart(),result.getEnd());
							}
						}else{
							//区分是否由点进入，和搜索文字进入
							if(json.inputType=="mouse"){
								var msg=service.baidu.equalsOffsetPoint(json.start.point,json.end.point,0.00021)?"与目的地较近，您可以选择步行至终点":"找不到往目的地路线，请重新选择。";
								showLayer.html("<li><div style='padding:5px;font-weight:blod;background:#ffffff;border:1px solid #5b7bcb;'></div></li>");
								var div=showLayer.find("div:first");
								if(typeof(msg)=="string"){
									div.text(msg);
								}
								service.baidu.addStartMarker(json.start.point);
								service.baidu.addEndMarker(json.end.point);
								service.baidu.startMarker.addEventListener("dragend",function(e){
									json.start={point:e.point,title:""};
									service.baidu.contextSearch(json.start,json.end,"mouse");
								});
								service.baidu.endMarker.addEventListener("dragend",function(e){
									json.end={point:e.point,title:""};
									service.baidu.contextSearch(json.start,json.end,"mouse");
								});
							}else{
								service.baidu.reselectInput();
								return;
							}
						}
						ui.searchEnd();
						ui.showLayer(json.type);
						ele.tsbar_1.tinyscrollbar_update();
					});
					service.baidu.setStartEndTitle(json.start,json.end);
					handle.search(json.start,json.end);
				}).apply(this,arguments);
			break;
			case "transit":
				//service.baidu.search({"start":{point:null,title:seartVal},"end":{point:null,title:endVal},inputType:"mouse",policy:0,type:"transit"});
				//service.baidu.search({"start":seartVal,"end":endVal,policy:0,type:"transit"});
				(function(){
					service.baidu.selectPolicyInput(json.type,json.policy);
					ui.searchTabAlert(true);
					if(service.baidu.autoCreateTitle(arguments)){
						return;
					}
					if(!isRun.check()){return;}
					var policys=[
						BMAP_TRANSIT_POLICY_LEAST_TIME,// 最少时间。  
						BMAP_TRANSIT_POLICY_LEAST_TRANSFER,// 最少换乘。  
						BMAP_TRANSIT_POLICY_LEAST_WALKING,// 最少步行。  
						BMAP_TRANSIT_POLICY_AVOID_SUBWAYS// 不乘地铁。 
					];
					handle=new BMap.TransitRoute(map);
					handle.setPolicy(policys[json.policy]||0);
					var handleResult=null;
					var taxiResult=null;
					var show=function(){
						//搜索完成
						if((!handleResult)||(!taxiResult)||(!isRun.check())){return;}
						map.clearOverlays();
						service.baidu.closeHotelTileLayer();
						var dcfy=$(".taxi",ele.lineTop);
						if(taxiResult.taxiFare&&taxiResult.taxiFare.day.totalFare){
							dcfy.show();
							dcfy.html('<img class="icon note" align="absmiddle" src="'+httpUrl.tp1+'/v5/map/2/img/bank.gif" alt="出租车" />打车费用: '+taxiResult.taxiFare.day.totalFare+'元 (按驾车最短路程算)');
						}else{
							dcfy.hide();
						}
						var showLayer=ele.transitResult.find("div:first > ol:first");
						showLayer.html("");
						if (handle.getStatus() == BMAP_STATUS_SUCCESS){
							var addBx=function(ele,bx,name){
								if(bx.getDistance(false)>0){
									var pBx=$('<p><img class="footcn" align="absmiddle" src="'+httpUrl.tp1+'/v5/map/2/img/bank.gif" alt="步行" /><a class="frg clo_6d w_50">'+bx.getDistance(true)+'</a><em>步行至</em></p>');
									addBGCur(pBx);
									pBx.click(function(){
										map.setViewport(polyline.getPath());
									});
									var polyline=new BMap.Polyline(bx.getPath(),{strokeStyle:"dashed",strokeColor: "red",strokeOpacity:0.75,strokeWeight:4,enableMassClear:true});
									pBx.ns_mouseover(function(){
										map.addOverlay(polyline);
									});
									pBx.ns_mouseout(function(){
										map.removeOverlay(polyline);
									});
									var a=$("<a href='javascript:;'></a>");
									a.text(name);
									pBx.append(a);
									ele.append(pBx);
								}
							};
							var startName=handleResult.getStart().title;
							var endName=handleResult.getEnd().title;
							service.baidu.setStartEndTitle(startName,endName);
							for(var i=0;i<handleResult.getNumPlans();i++){
								var mapPlan=handleResult.getPlan(i);
								//li
								var li=$("<li class='list_hid list_cur'></li>");
								showLayer.append(li);
								var div=$("<div></div>");
								li.append(div);
								var a=$("<a href='javascript:;' class=\"frg pr10 c_f_bg\">收起</a>");
								div.append(a);
								(function(){
									var aTag=a;
									var index=i;
									var opacity = 0.45;
									var planObj = mapPlan;
									var bounds = new Array();
									var polyline=null;
									var addPoints = function(points){
										for(var i = 0; i < points.length; i++){
											bounds.push(points[i]);
										}
										polyline.push(new BMap.Polyline(points,{strokeColor:"red", strokeWeight:6, strokeOpacity:0.5}));
									};
									var checkBounds=function(){
										if(polyline==null){
											polyline=new Array();
											for (var i = 0; i < planObj.getNumRoutes(); i ++){
												var route = planObj.getRoute(i);
												if (route.getDistance(false) > 0){
													addPoints(route.getPath());
												}
											}
											for (i = 0; i < planObj.getNumLines(); i ++){
												var line = planObj.getLine(i);
												addPoints(line.getPath());
											}
										}
									};
									div.ns_mouseover(function(e){
										checkBounds();
										for(var k in polyline){
											map.addOverlay(polyline[k]);
										}
									});
									div.ns_mouseout(function(e){
										for(var k in polyline){
											map.removeOverlay(polyline[k]);
										}
									});
									div.click(function(){
										var this_li=$(this).parent();
										if(this_li.attr("class")!=""){
											this_li.parent().children("li").attr("class","list_hid list_cur");
											this_li.parent().children("li").find("a:first").text("详情");
											this_li.removeAttr("class");
											aTag.text("收起");
											map.clearOverlays();
											checkBounds();
											// 绘制驾车步行线路
											for (var i = 0; i < planObj.getNumRoutes(); i ++){
												var route = planObj.getRoute(i);
												if (route.getDistance(false) > 0){
													// 步行线路有可能为0
													map.addOverlay(new BMap.Polyline(route.getPath(), {strokeStyle:"dashed",strokeColor: "#30a208",strokeOpacity:0.75,strokeWeight:4,enableMassClear:true}));
												}
											}
											// 绘制公交线路
											for (i = 0; i < planObj.getNumLines(); i ++){
												var line = planObj.getLine(i);
												// 公交
												if(line.type == BMAP_LINE_TYPE_BUS){
													// 上车
													service.baidu.addMarkerFun(line.getGetOnStop().point,2,2,line.getGetOnStop().title);
													// 下车
													service.baidu.addMarkerFun(line.getGetOffStop().point,2,2,line.getGetOffStop().title);
													
													// 地铁
												}else if(line.type == BMAP_LINE_TYPE_SUBWAY){
													// 上车
													service.baidu.addMarkerFun(line.getGetOnStop().point,2,3,line.getGetOnStop().title);
													// 下车
													service.baidu.addMarkerFun(line.getGetOffStop().point,2,3,line.getGetOffStop().title);
												}
												map.addOverlay(new BMap.Polyline(line.getPath(), {strokeColor: "#0030ff",strokeOpacity:opacity,strokeWeight:6,enableMassClear:true}));
											}
											//设置起点和终点到地图
											service.baidu.setStartAndEndPoint(handleResult);
										}
										//alert($("#map_container .overview:first").position().top)
										//显示范围
										map.setViewport(bounds);
									});
									li.mouseover(function(){
										if($(this).attr("class")){
											$(this).attr("class","list_hid");
										}
									});
									li.mouseout(function(){
										if($(this).attr("class")){
											$(this).attr("class","list_hid list_cur");
										}
									});
									a.click(function(e){
										var obj=$(this);
										if(obj.text()=="收起"){
											e.stopPropagation();
											obj.text("详情");
											obj.parent().parent().attr("class","list_hid");
											return false;
										}
									});
									div.append("<span class=\"min_ico\">"+(i+1)+"</span>");
									var h6=$("<h6></h6>");
									div.append(h6);
									var font=$("<font></font>");
									li.append(font);
									font.text("约"+mapPlan.getDuration(true)+"/"+mapPlan.getDistance(true));
									var qidian=$('<p class="start1"><span class="start_ico"></span><strong></strong></p>');
									qidian.find("strong:first").text(startName);
									li.append(qidian);
									//标题
									var linesTitle="";
									//循环公交
									for(var j=0,bxIndex=0;j<mapPlan.getNumLines();j++){
										var line=mapPlan.getLine(j);
										var title=line.title.replace(/\([^(]*?\)/,"");
										if(line.type==BMAP_LINE_TYPE_BUS&&/^\d+$/.test(title)){
											title+="路";
										}
										linesTitle+="→"+title;
										addBx(li,mapPlan.getRoute(bxIndex++),line.getGetOnStop().title);
										
										var p=$("<p></p>");
										addBGCur(p);
										var typeName=line.type==BMAP_LINE_TYPE_BUS&&"公交车"||line.type==BMAP_LINE_TYPE_SUBWAY&&"地铁"||line.type==BMAP_LINE_TYPE_FERRY&&"渡轮";
										p.append('<img class="startcn" align="absmiddle" src="'+httpUrl.tp1+'/v5/map/2/img/bank.gif" alt="乘坐'+typeName+'" /><a href="#" class="frg clo_6d w_50">'+line.getNumViaStops()+'站</a>');//line.getDistance(true)
										var a1=$("<a href='javascript:;'></a>");
										a1.text(title);
										p.append("乘坐");
										p.append(a1);
										p.append(typeName+",在");
										var a2=$("<a href='javascript:;'></a>");
										a2.text(line.getGetOffStop().title);
										p.append(a2);
										p.append("下车");
										
										//添加鼠标移动上去显示标注
										addLineLabel(p,line.getPath());
										li.append(p);
									}
									//结束的步行
									addBx(li,mapPlan.getRoute(bxIndex++),endName);
									linesTitle=linesTitle.length>0?linesTitle.substr(1):"";
									h6.text(linesTitle);
									var zhongdian=$('<p class="end1"><span class="end_ico"></span><strong></strong></p> <p class="root"></p>');
									zhongdian.find("strong:first").text(endName);
									li.append(zhongdian);
									(function(){
										var content=("从“"+qidian.find("strong:first").text()+"”"+mapPlan.getDescription(false)+"“"+zhongdian.find("strong:first").text()+"”").replace("当前酒店-","");
										//发送线路到手机
										zhongdian.find(".send_mp:first").click(function(){
											var logined=/ZhuNaUserName[=](\d+)/i.exec(document.cookie);
											if(logined!=null){
												if(this.innerHTML!="正在发送请求.."){
													this.innerHTML="正在发送请求..";
														//ZhuNaUserName
														var obj=this;
														$.ajax({
															url:httpUrl.zhuna+'/v5/ajax/A_sendsms.asp?mobile='+logined[1]+'&content='+escape(content),
															type:'GET',
															cache:false,
															success: function(data) {
																alert(data);
																obj.innerHTML="重发路线至手机";
															},
															error:function(){
																alert("请求失败，请重试");
																obj.innerHTML="重发路线至手机";
															}
														});
												}
											}else{
												var selfArg=arguments;
												window.callback_login_success=function(){
													ZN.login();
													selfArg.callee();
													Tips.removeAll();
													service.zhuna.initLogin();
												};
												Tips({_title:"\u767B\u5F55", _content:"iframe:"+httpUrl.zhuna+"/v5/user/login_ajax.asp?purl=callback_login_success", _width: "450", _height: "300", _drag: "_boxTitle", _showbg: true});
											}
											return false;
										});
									})();
									
								})();
								//发送记录到后台
								service.baidu.saveNoteToServer(json,handle,handleResult.getStart(),handleResult.getEnd());
							}
							showLayer.find("li:first > div:first").click();
						}else{
							//区分是否由点进入，和搜索文字进入
							if(json.inputType=="mouse"){
								//开始或结束带有字符串
								var showMsg=function(msg){
									var ol=showLayer;
									ol.html("<li><div style='padding:5px;font-weight:blod;background:#ffffff;border:1px solid #5b7bcb;'></div></li>");
									var div=ol.find("div:first");
									if(typeof(msg)=="string"){
										div.text(msg);
									}
									return div;
								};
								if(dRoute.getStatus()==BMAP_STATUS_SUCCESS){
									var plan=taxiResult.getPlan(0);
									var paths=plan.getRoute(0).getPath();
									service.baidu.setStartAndEndPoint(taxiResult);
									if(plan.getDistance(false)<3000){
										showMsg("起点与终点较近，约"+plan.getDistance(true)+"，您可选择步行前往。");
									}else{
										var div=showMsg();
										var a=$("<a href='javascript:;'>驾车或打车</a>");
										a.click(function(){
											$(".mapside:first .nav:first .taxi:first").click();
											return false;
										});
										div.append("找不到公交线路，您可选择");
										div.append(a);
										div.append("到达目的地，约"+plan.getDistance(true)+"。");
									}
								}else{
									service.baidu.addStartMarker(searchJson.start.point);
									service.baidu.addEndMarker(searchJson.end.point);
									service.baidu.startMarker.addEventListener("dragend",function(e){
										searchJson.start={point:e.point,title:""};
										service.baidu.contextSearch(searchJson.start,searchJson.end,"mouse");
									});
									service.baidu.endMarker.addEventListener("dragend",function(e){
										searchJson.end={point:e.point,title:""};
										service.baidu.contextSearch(searchJson.start,searchJson.end,"mouse");
									});
									showMsg("找不到往目的地公交路线，请重新选择。");
								}
							}else{
								service.baidu.reselectInput();
								return;
							}
						}
						ui.searchEnd();
						ui.showLayer(json.type);
						ele.tsbar_1.tinyscrollbar_update();
					};
					var dRoute=new BMap.DrivingRoute(map, {onSearchComplete:function(result){
						taxiResult=result;
						show();
					}});
					handle.setSearchCompleteCallback(function(result){
						handleResult=result;
						show();
					});
					var zoom=map.getZoom();
					//防止等级小于9的时候不能显示公交查询，因为此时转入长途公交
					if(zoom<9&&json.start.point&&json.end.point){
						var centerPoint=map.getCenter();
						var p=json.start.point&&json.end.point;
						map.setViewport([json.start.point,json.end.point]);
						handle.search(json.start,json.end);
						map.setCenter(centerPoint);
						map.setZoom(zoom);
					}else{
						handle.search(json.start,json.end);
					}
					service.baidu.setStartEndTitle(json.start,json.end);
					dRoute.search(json.start,json.end);
				}).apply(this,arguments);
			break;
			default://文本搜索
				(function(){
					ui.searchTabAlert();
					handle=new BMap.LocalSearch(map,{pageCapacity:20});
					var isFirst=true;
					var div=$('<div class="sidelistname"><\/div>');
					var dataList=[];
					var position=0;
					var updateView=true;
					var allowLoad=true;
					var frameHeight=ele.tsbar_1.height();
					var next=0;
					var searchEnd=false;
					selectElement=null;
					handle.setSearchCompleteCallback(function(result){
						if(!isRun.check()){return;}
						service.baidu.closeHotelTileLayer();
						if(isFirst){
							ele.baiduResult.html("");
						}
						//map.addOverlay(marker);
						if (handle.getStatus() == BMAP_STATUS_SUCCESS){
							//'<dl class="cur"><dt><span>01<\/span><\/dt><dd><a href="#">国贸招商局大厦<\/a><p>地址：<\/p><p>电话：(010)65810532<\/p><\/dd><\/dl>'
							for(var i=0;i<result.getCurrentNumPois();i++){
									var resultPoi=result.getPoi(i);
									(function(){
										var poi=resultPoi;
										var dl=$('<dl><dt><span>01<\/span><\/dt><dd><a><\/a><p><\/p><\/dd><\/dl>');
										var code=_.numAddZero(i+(next*20)+1,2);
										$("span:first",dl).text(code);
										var title=poi.title;
										$("a:first",dl).text(title);
										var addrObj=$("p:first",dl);
										var addr="";
										if(poi.address&&poi.address.length>0){
											addr=(typeof(service.baidu.poiTypeNames[poi.type])!="undefined"?service.baidu.poiTypeNames[poi.type]+":":"")+poi.address;
											addrObj.text(addr);
										}
										var marker=service.baidu.normalMarker({"point":poi.point,"text":code,"title":title,"addr":addr});
										var over=function(){
											dl.attr("class","cur");
											marker._json.element.addClass("baidu_icon_hover").css({"z-index":9999});
										},out=function(isAllow){
											if(isAllow===true||selectElement!=dl){
												dl.attr("class","");
												marker._json.element.removeClass("baidu_icon_hover").css({"z-index":""});
											}
										},mousedown=function(){
											if(selectElement==dl){
												selectElement=null;
												service.baidu.pointWindow.close();
												return;
											}else{
												if(selectElement&&$.type(selectElement.data("out"))=="function"){
													selectElement.data("out")(true);
												}
												selectElement=dl;
											}
											over();
											service.baidu.pointWindow.openNormalMarker(marker);
											return false;
										};
										dl.data("out",out);
										dl.data("over",over);
										dl.ns_mouseover(over);
										dl.ns_mouseout(out);
										dl.l_mousedown(mousedown);
										dl.bind("dblclick",_.rFalse);
										marker._json.element.bind("dblclick",_.rFalse);
										marker._json.element.l_mousedown(mousedown);
										marker._json.element.hover(over,out);
										dataList.push({
											"marker":marker,
											"element":dl
										});
										div.append(dl);
									})();
							}
							if(result.getCurrentNumPois()<=0){
								allowLoad=false;
							}
							ele.baiduResult.append(div);
							updateView=true;
						}else if(isFirst){
							ele.baiduResult.html('找不到“<span class="c_ff0">'+$('<div\/>').text(json.content).html()+"<\/span>” ");
							allowLoad=false;
						}else{
							allowLoad=false;
						}
						if(isFirst){
							ui.showLayer("baidu_result");
						}
						isFirst=false;
						ui.searchEnd();
						searchEnd=true;
					});
					//测试是否自动停止
					var autoIconView=setInterval(function(){
						if(!isRun.check()){
							clearInterval(autoIconView);
							return;
						}
						var pos=ui.getTsbarHeight(ele.overview,ele.viewport);
						var tempFrameHeight=ele.tsbar_1.height();
						if(updateView||position!=pos||tempFrameHeight!=frameHeight){
							position=pos;
							updateView=false;
							frameHeight=tempFrameHeight;
							var listHeight=ele.overview.height();
							var endHeight=position+frameHeight;
							map.clearOverlays();
							var ph=[];
							for(var i=0;i<dataList.length;i++){
								var element=dataList[i].element;
								var marker=dataList[i].marker;
								var elementTop=element.position().top;
								var elementButtomPos=elementTop+element.height();
								if(elementButtomPos>position){
									map.addOverlay(marker);
									if(selectElement==element){
										service.baidu.pointWindow.openNormalMarker(marker);
									}
									ph.push(marker._json.point);
									if(ph.length>9&&elementTop>endHeight){
										break;
									}
								}
							}
							if(json.marker){
								var marker=new BMap.Marker(json.marker.point, {icon: service.baidu.createPointIcon()});
								if(dataList.length){
									ph.push(json.marker.point);
								}
								marker.setTitle(json.marker.title);
								marker.setTop(true);
								map.addOverlay(marker);
								var dl=$("<div\/>");
								marker.addEventListener("click", function(){
									if(selectElement==dl){
										selectElement=null;
										service.baidu.hotelWindow.close();
										return;
									}else{
										if(selectElement&&$.type(selectElement.data("out"))=="function"){
											selectElement.data("out")(true);
										}
										selectElement=dl;
									}
									marker._json=json.marker;
									service.baidu.hotelWindow.openPriceMarker(marker);
									return false;
								});
							}
							if(ph.length>0){
								map.setViewport(ph);
							}
							if(allowLoad&&(listHeight-position-frameHeight<200)){
								//alert(listHeight+"-"+position+"-"+frameHeight)
								//执行下次更新
								if(searchEnd){
									searchEnd=false;
									ui.searchIng();
									handle.gotoPage(++next);
								}
							}
						}
					},200);
					if(json.marker){
						json.radius=json.radius||5000;
						handle.searchNearby(json.content,json.marker.point,json.radius);
						ele.searchInputTxt.data("inputVal")(json.marker.title);
					}else{
						handle.search(json.content);
						ele.searchInputTxt.data("inputVal")(json.content);
					}
				}).apply(this,arguments);
			break;
		}
	};
	service.baidu.createPointIcon=function(){
		return new BMap.Icon(httpUrl.tp1+"/v5/map/2/img/hotel_ico.png",new BMap.Size(35, 28),{
			anchor: new BMap.Size(8, 26),//顶点位置
			imageOffset: new BMap.Size(0, 0)//相当于背景position
		});
	};
	service.baidu.createOverMarkPoint=function(){
		return new BMap.Icon(httpUrl.map+"/images/markpoint.png",new BMap.Size(15, 17),{
			anchor: new BMap.Size(6, 16),//顶点位置
			imageOffset: new BMap.Size(0, 0)//相当于背景position
		});
	};
	var ZN_city_BD_index={};
	var nowBDCityid=null;
	var firstCenter=null;
	var unifyNowPosAddr=new _.unify("统一当前位置");
	service.baidu.showNowPosAddr=function(){
		var centerPoint=map.getCenter();
		if(firstCenter&&service.baidu.equalsOffsetPoint(firstCenter,centerPoint)){
			return;
		}
		var run=unifyNowPosAddr.run();
		firstCenter=centerPoint;
		ele.addrInfo.text("中心位置：加载中..").styleTitle({title:"加载中.."});
		var projection=map.getMapType().getProjection();
		//转换为像素点
		var xpPoint=projection.lngLatToPoint(centerPoint);
		$.ajax({
			"url":'http://api.map.baidu.com/?qt=rgc&dis_poi=100&poi_num=10&ie=utf-8&oue=1&res=api&callback=?',
			"type":'GET',
			"data":{"x":xpPoint.x,"y":xpPoint.y},
			"dataType":"jsonp",
			"cache":false,
			"success":function(data){
				if(!run.check()){return}
				if(data&&data.content&&data.content.address_detail){
					var ac=data.content.address_detail;
					var addr=(ac.province==ac.city?ac.city:ac.province+ac.city)+(ac.district||"")+(ac.street||"")+(ac.streetNumber||"");
					ele.addrInfo.text("中心位置："+addr).styleTitle({title:addr});
					var nowCityData=ZN_city_BD_index[ac.district]||ZN_city_BD_index[ac.city];
					if(nowCityData){
						if(nowBDCityid!=nowCityData){
							//切换城市
							service.zhuna.alterCity(nowCityData);
							nowBDCityid=nowCityData;
							service.zhuna.checkViewSearch();
						}
					}
				}
			},
			"error":function(data){
				if(!run.check()){return}
			}
		});
	};
	service.initMap=function(){
		try{
			if(zn_city_datas){
				for(var k in zn_city_datas){
					var data=zn_city_datas[k];
					ZN_city_BD_index[data.bname]=data;
				}
			}
		}catch(e){}
		var defCityName = "北京市";
		map=new BMap.Map("e_map");
		service.zhuna.alterCity(ZN_city_BD_index[defCityName]);
		service.baidu.map=map;
		map.setCenter(defCityName);
		map.setCurrentCity(defCityName);
		var unifySetCity=new _.unify("统一设置城市");
		var initSetCity=unifySetCity.run();
		var myGeo = new BMap.Geocoder();
		// 将地址解析结果显示在地图上,并调整地图视野
		new BMap.LocalCity().get(function(result){
			if(initSetCity.check()){
				var cityName = result.name;
				map.setCenter(cityName);
				map.setCurrentCity(cityName);
				myGeo.getPoint(cityName, function(point){
					map.centerAndZoom(point,14);//设定地图的中心点和坐标并将地图显示在地图容器中
					service.baidu.showNowPosAddr();
				}, cityName);
			}
		});
		//地图事件设置函数：
			service.myDis = new BMapLib.DistanceTool(map);//测距
			service.traffic = new BMap.TrafficLayer();// 创建交通流量图层实例
			map.enableInertialDragging();//启用地图惯性拖拽，默认禁用。
			map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
			//map.enableScrollWheelZoom();//启用地图滚轮放大缩小
			map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
			map.enableKeyboard();//启用键盘上下左右键移动地图
			map.enableContinuousZoom();//启动缩放效果
		//地图控件添加函数：
			//map.addControl(new BMap.MapTypeControl());
			//向地图中添加缩放控件
			var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
			map.addControl(ctrl_nav);
			//向地图中添加缩略图控件
			map_ctrl_ove = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:0});
			map.addControl(map_ctrl_ove);
			//向地图中添加比例尺控件
			var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
			map.addControl(ctrl_sca);
			service.baidu.pointMarkerAutoContent=function(marker){
				//marker.enableDragging();
				//marker.disableMassClear();
				marker._json={title:"自定义点",addr:"地址：加载中...",point:marker.getPosition()};
				var dl=$("<dl\/>");
				var over=function(){
					marker.setTop(true);
				},out=function(isAllow){
					if(isAllow===true||selectElement!=dl){
						marker.setTop(false);
					}else{
						marker.setTop(true);
					}
				};
				marker.addEventListener("mouseover",over);
				marker.addEventListener("mouseout",out);
				dl.data({"over":over,"out":out});
				marker.setTitle(marker._json.title);
				var clickEvent=function(e) {
					if(selectElement==dl){
						selectElement=null;
						service.baidu.pointWindow.close();
					}else{
						if(selectElement&&$.type(selectElement.data("out"))=="function"){
							selectElement.data("out")(true);
						}
						selectElement=dl;
						service.baidu.pointWindow.openNormalMarker(marker);
					}
				};
				marker.addEventListener("click", clickEvent);
				marker._clickEvent=clickEvent;
				new BMap.Geocoder().getLocation(marker._json.point, function(rs){
					var addComp = rs.addressComponents;
					marker._json.addr="地址："+rs.address;
					marker.setTitle(rs.address);
					if(marker.domElement){
						$(marker.domElement).styleTitle();
					}
					if(selectElement==dl){
						$(".listnav:first p:first",marker._div).text(marker._json.addr);
						service.baidu.pointWindow._panBox(true);
					}
				});
				return marker;
			};
			service.baidu.mkrTool = new BMapLib.MarkerTool(map, {autoClose: false, followText: "打点", icon:service.baidu.createPointIcon() ,autoClose:true});
			service.baidu.mkrTool.addEventListener("markend", function(e) {
				//打点
				var marker=service.baidu.pointMarkerAutoContent(e.marker);
				marker._clickEvent();
				$(".nav:first li .nav1",ele.mainbody).attr("class","nav1");
			});
			map.addEventListener("clearoverlays", function(e) {
			
			});
			var hotspotoverMark=new BMap.Marker(new BMap.Point(0,0), {icon: service.baidu.createOverMarkPoint()});
			hotspotoverMark.addEventListener("click", function(e) {
				var addMark=new BMap.Marker(hotspotoverMark.getPosition(), {icon: service.baidu.createOverMarkPoint()});
				addMark._infoAutoHide=true;
				var hhd=hotspotoverMark.hotelData;
				addMark._json={
					isLoadData:true,
					id:hhd.h,
					title:hhd.n,
					point:hotspotoverMark.getPosition()
				};
				//$.extend(markerJson,hotelData,{"point":point,"code":code,"price":hotelData.price,"title":title,"addr":addr});
				service.baidu.hotelWindow.openPriceMarker(addMark);
				map.addOverlay(addMark);
			});
			//service.baidu.hotelWindow.openPriceMarker
			map.addEventListener("hotspotover", function(e) {
				if(e.spots&&e.spots.length>0){
					//取第一个
					var spot=e.spots[0];
					var hotelData=spot.getUserData();//{h,n,x,y}
					map.removeOverlay(hotspotoverMark);
					hotspotoverMark.hotelData=hotelData;
					hotspotoverMark.setPosition(spot.getPosition());
					map.addOverlay(hotspotoverMark);
					$(hotspotoverMark.domElement).styleTitle({title:hotelData["n"]});
					//alert(e.spots.length)
				}
			});
			map.addEventListener("hotspotout", function(e) {
				map.removeOverlay(hotspotoverMark);
			});
			map.addEventListener("load", function(e) {
				var strToPoint=function(str){
					if(/([\d.]+)\s*\,\s*([\d.]+)/.test(str)){
						return new BMap.Point(RegExp.$1,RegExp.$2);
					}
				};
				/*
					//encodeURIComponent("长城").replace(/%/g,"_")
					//定位坐标
					#center=116.236968,39.902538&zoom=11
					//搜索长城:
					#center=116.236968,39.802130&zoom=11&stype=txt&content=_E9_95_BF_E5_9F_8E
					//驾车最短距离搜索:朝阳门到北宫门
					#center=116.236968,39.802130&zoom=11&stype=drive&policy=1&sname=_E6_9C_9D_E9_98_B3_E9_97_A8&ename=_E5_8C_97_E5_AE_AB_E9_97_A8
					#center=116.236968,39.802130&zoom=11&stype=drive&policy=1&sname=_E6_9C_9D_E9_98_B3_E9_97_A8&spoint=116.236968,39.802130&ename=_E5_8C_97_E5_AE_AB_E9_97_A8
					#center=116.236968,40.652130&zoom=11&stype=drive&policy=1&sname=_E6_9C_9D_E9_98_B3_E9_97_A8&spoint=116.441638,39.972465&ename=_E5_8C_97_E5_AE_AB_E9_97_A8&epoint=116.236968,40.652130
					#center=116.302959,39.976395&stype=findhotel&cityid=0101
				*/
				//alert("stype=drive"+"&sname="+encodeURIComponent("朝阳门").replace(/%/g,"_")+"&ename="+encodeURIComponent("北宫门").replace(/%/g,"_"))
				//添加#传参执行
				_.hashParameter(function(p){
					//中心坐标
					var center=strToPoint(p["center"]);
					//搜索类型
					var stype=p["stype"];
					//搜索文本
					var content=$.trim(p["content"]);
					//搜索起点名字
					var sname=$.trim(p["sname"]);
					//起点坐标
					var spoint=strToPoint(p["spoint"]);
					//搜索终点名字
					var ename=$.trim(p["ename"]);
					//终点坐标
					var epoint=strToPoint(p["epoint"]);
					//zoom
					var zoom=p["zoom"];
					//方案
					var policy=p["policy"];
					if(_.isNumeric(policy)){
						policy=parseInt(policy);
					}else{
						policy=0;
					}
					if(_.isNumeric(zoom)){
						map.setZoom(parseInt(zoom));
					}
					//设置中心
					if(service.baidu.checkPoint(center)){
						var initSetCity=unifySetCity.run();
						map.setCenter(center);
					}
					var inputType=(p["handle"]=="save"?"inputText":"url");
					switch(stype){
						case "txt":
							if(content){
								service.baidu.search({"content":content,"inputType":inputType,type:stype});
							}
						break;
						case "transit":
						case "drive":
							ui.searchTabAlert(true);
							var startPos=service.baidu.checkPoint(spoint)?{point:spoint,title:sname}:sname;
							var endPos=service.baidu.checkPoint(epoint)?{point:epoint,title:ename}:ename;
							if(startPos&&endPos){
								service.baidu.search({"start":startPos,"end":endPos,"policy":policy,"inputType":inputType,type:stype});
							}else{
								service.baidu.setStartEndTitle(startPos,endPos);
							}
						break;
						case "findhotel":
							if(service.baidu.checkPoint(center)&&p["cityid"]){
								service.zhuna.search({"cityid":p["cityid"],"x":center.lng,"y":center.lat,"r":service.zhuna.defaultSearchData.r});
							}
						break;
					}
				});
			});
			 
			map.addEventListener("zoomend", function(e) {
				service.baidu.createHotelHotspots();
				service.zhuna.checkViewSearch();
				service.baidu.showNowPosAddr();
			});
			map.addEventListener("dragend", function(e) {
				service.zhuna.checkViewSearch();
			});
			//移动包括拖拽
			map.addEventListener("moveend", function(e) {
				service.baidu.showNowPosAddr();
			});
			//标点信息窗口
			var pointWindowContent='<div class="hotelmsg"><div class="hotelnote"><div class="listnav"><h2><a>酒店<\/a><\/h2><p>地址：<\/p><div class="mapclose"><a href="#" title="关闭"><\/a><\/div><\/div><div class="note_nav clear:after"><a class="note1"  t="surrounding"><\/a><a class="note2" t="here"><\/a><a class="note3" t="there"><\/a><\/div><div class="pointsearch clear:after"><a class="hotelput" href="#"><\/a><\/div><div class="note_nav2" style="display:none"><span>终点</span><input type="text" name=""><a href="#"></a><a href="#"></a></div><\/div><div style=" margin-left:-20px;" class="hotellistico"><\/div><\/div>';
			service.baidu.pointWindow=new BMapLib.InfoBox(map,pointWindowContent,{enableAutoPan:false,align:INFOBOX_AT_TOP,width:0,height:0,offset:new BMap.Size(20,55)
			,shadow:new service.baidu.myLayer({offsetX:120,offsetY:180,"element":$('<div class="hotellistbg1"><\/div>').css("z-index",-200)})
			,exec:function(){
				var div=$(this._div);
				div.bind("contextmenu",function(e){
					e.stopPropagation();
					return false;
				});
				div.find(".mapclose:first a:first").click(function(){
					service.baidu.pointWindow.hide();
					if(selectElement&&$.type(selectElement.data("over"))=="function"){
						selectElement.data("over")();
						cancelSelectElement();
					}
					return false;
				}).styleTitle();
				
				$(".hotellistico:first",div).css("z-index","9");
				//百度地标信息框选项卡
				ui.pointWindowTab=new _.tab({
					elems:$(".note_nav a",div),
					elemsType:[{typeClass:"note1",max:0},{typeClass:"note2",max:0},{typeClass:"note3",max:0}],
					hoverClass:"hover",
					seleClass:"cur"
				});
				ele.jtPointsearchTabLayer=$(".note_nav2:first",div);
				ele.pointsearchTabLayer=$(".pointsearch:first",div);
				ele.pointsearchTabInput=$("input:first",ele.jtPointsearchTabLayer);
				var btns=$("a",ele.jtPointsearchTabLayer);
				var searchExec=function(){
					var toHere=ui.pointWindowTab.nowSelect===1;
					var point={"point":service.baidu.pointWindow._useMarker._json.point};
					var seartVal=toHere?($.trim(ele.pointsearchTabInput.val())||""):point;
					if(!seartVal){
						ele.pointsearchTabInput.focus();
						return false;
					}
					var endVal=toHere?point:($.trim(ele.pointsearchTabInput.val())||"");
					if(!endVal){
						ele.pointsearchTabInput.focus();
						return false;
					}
					//默认驾车drive  //可切换公交transit
					service.baidu.contextSearch(seartVal,endVal,"inputText");
				};
				//公交搜索
				btns.eq(0).l_click(function(){
					ui.baiduLineTab.panel(1,false);
					searchExec();
				});
				//驾车搜索
				btns.eq(1).l_click(function(){
					ui.baiduLineTab.panel(0,false);
					searchExec();
				});
				ele.pointsearchTabInput.keyenter(searchExec);
				ui.pointWindowTab.callback=function(elem){
					//note1cur  //note2cur  //note3cur
					ele.jtPointsearchTabLayer.hide();
					ele.pointsearchTabLayer.hide();
					switch($.trim(elem.attr("t"))){
						case "surrounding":
							ele.pointsearchTabLayer.show();
						break;
						case "here":
							$("span:first",ele.jtPointsearchTabLayer).text("起点");
							ele.jtPointsearchTabLayer.show();
							ele.pointsearchTabInput.select();
						break;
						case "there":
							$("span:first",ele.jtPointsearchTabLayer).text("终点");
							ele.jtPointsearchTabLayer.show();
							ele.pointsearchTabInput.select();
						break;
					}
				};
				$(".hotelput:first",div).l_click(function(){
					var marker=service.baidu.pointWindow._useMarker;
					service.zhuna.search({"cityid":service.zhuna.nowCity.id,"x":marker._json.point.lng,"y":marker._json.point.lat,"r":service.zhuna.defaultSearchData.r});
					return false;
				});
				
			}});
			service.baidu.pointWindow.openNormalMarker=function(marker){
				service.baidu.hotelWindow.close();
				service.baidu.pointWindow._useMarker=marker;
				service.baidu.pointWindow.open(marker._json.point);
				ui.pointWindowTab.init(true);
				var pDiv=$(service.baidu.pointWindow._div);
				$(".listnav:first h2:first a:first",pDiv).text(marker._json.title).styleTitle({"title":marker._json.title});
				$(".listnav:first p:first",pDiv).text(marker._json.addr);
				service.baidu.pointWindow._panBox(true);
			};
			var checkRemoveHotMark=function(){
				if(service.baidu.hotelWindow._nowMarker&&service.baidu.hotelWindow._nowMarker._infoAutoHide){
					map.removeOverlay(service.baidu.hotelWindow._nowMarker);
				}
			};
			//酒店信息窗口
			var hotelWindowContent='<div class="hotelmain"><div class="hotellist"><div class="listnav"><h2><a href="#"  target="_blank">酒店<\/a><\/h2><div class="mapfankui" style="display:none" title="反馈错误信息"><a href="#"><\/a><\/div><div class="mapshoucang" title="收藏"><a href="#"><\/a><\/div><div class="mapmobile" style="display:none" title="发送到手机"><a href="#"><\/a><\/div><div class="mapclose" title="关闭"><a href="#"><\/a><\/div><\/div><div class="maplistside"><dl><dt><a target="_blank"><img width="116" height="87" class="hotelpic" src="images\/img1.jpg"></a><\/dt><dd><ul><li>星级：<img width="1" height="1" src="images\/bank.gif" class="star"><\/li><li>好评：<span class="c_8e9">98%<\/span><\/li><li>价格：<span class="c_f60">￥638<\/span>起<\/li><li class="h_add">地址：<\/li><li><a href="#" class="details" target="_blank">查看详情&gt;&gt;<\/a><\/li><\/ul><\/dd><\/dl><\/div><div class="maplistmain"><div class="listmian_nav"><ul><li><a class="cur">房型价格<\/a><\/li><li><a>住客点评<\/a><\/li><li><a>酒店图片<\/a><\/li><li><a>服务设施<\/a><\/li><li><a>酒店周边<\/a><\/li><\/ul><\/div><div class="tsbar_1" style="width:437px;height:198px;z-index:1;background:#ffffff;"><div class="scrollbar"><div class="track"><div class="thumb"><div style="height:4px;" class="scroll_top"><\/div><div style="height:4px;" class="scroll_bottom"><\/div><\/div><\/div><\/div><div class="viewport" style="width:437px;height:198px;"><div class="overview"><div style="width:437px;padding-bottom:20px;" class="hotel_list_right"><\/div><\/div><\/div><\/div><\/div><\/div><div class="hotellistico"><\/div><\/div>';
			service.baidu.hotelWindow=new BMapLib.InfoBox(map,hotelWindowContent,{enableAutoPan:true,align:INFOBOX_AT_TOP,width:0,height:0,offset:new BMap.Size(30,55)//-275,340
			,shadow:new service.baidu.myLayer({offsetX:170,offsetY:260,"element":$('<div class="hotellistbg"><\/div>').css("z-index",-200)})
			,exec:function(){
				var wDiv=$(this._div);
				wDiv.bind("contextmenu",function(e){
					e.stopPropagation();
					return false;
				});
				var rightlist=$(".hotel_list_right:first",wDiv);
				rightlist.append(ele.hotel_room_list_info);
				rightlist.append(ele.hotel_room_list_dianping);
				rightlist.append(ele.hotel_room_list_tupian);
				rightlist.append(ele.hotel_room_list_sheshi);
				rightlist.append(ele.hotel_room_list_zhoubian);
				wDiv.find(".mapclose:first a:first").click(function(){
					service.baidu.hotelWindow.hide();
					if(selectElement&&$.type(selectElement.data("over"))=="function"){
						selectElement.data("over")();
						cancelSelectElement();
					}
					return false;
				});
				$("div[title]",wDiv).each(function(){
					$(this).styleTitle();
				});
				$(".mapshoucang:first a",wDiv).l_mousedown(function(e){
					if(!$(this).is(".cur")){
						var _hotelData=service.baidu.hotelWindow._hotelData;
						service.zhuna.shoucang(_hotelData.id,_hotelData.name);
						if(service.baidu.hotelWindow._nowMarker._elemDl){
							service.baidu.hotelWindow._nowMarker._elemDl.find(".sidemsg:first").addClass("cur");
						}
						$(this).addClass("cur");
					}
					e.stopPropagation();
					return false;
				});
				//酒店详细信息框选项卡
				ui.zhunaHotelInfoTab=new _.tab({
					elems:$(".listmian_nav li a",wDiv),
					elemsType:[0,0,0,0,0],
					hoverClass:"hover",
					seleClass:"cur"
				});
				ele.hotelInfoScroll=$(".tsbar_1:first",$(this._div));
				ele.hotelInfoScroll.autoScrollBarTop({axis:"y"});
				$("#tm1,#tm2",ele.hotel_room_list_info).each(function(){
					if($(this).attr("initdate")=="true"){return}
					function c(e){
						var t = e.target.id;
						if(!t){
							t=$(e.target).closest("#Wrapper").siblings()[0].id
						}
						if(t=="tm1"){
							return showCalendarZN(t,false,t,'tm2','tm2',''+ZNDate.format(ZNDate.today())+'',''+ZNDate.format(ZNDate.plus(ZNDate.today(),60))+'','','','','text','','','');
						}else{
							return SelHotelCalMethod(e,'out','tm1','tm2',''+ZNDate.format(ZNDate.plus(ZNDate.today(),60))+'','');
						}
					};
					var s=WP.c(80,19,c);
					$(this).before(s).attr("initdate","true").blur(function(){
						this.value=this.value.replace(/[^\d\-]/g,'');
					}).l_click(function(e){e.stopPropagation();c(e);});
				});
				var tm1=$("#tm1",ele.hotel_room_list_info);
				var tm2=$("#tm2",ele.hotel_room_list_info);
				$(".srh_box_btn:first a",ele.hotel_room_list_info).click(function(){
					$("#doBook input[name=tm1]").val(tm1.val());
					$("#doBook input[name=tm2]").val(tm2.val());
					ele.hotel_room_list_room.html('<img style="margin:40px 116px;width:160px;height:39px;"src="'+httpUrl.tp1+'/images/new/loading2.gif">');
					loadPrice(ele.hotel_room_list_room.attr("id").substr(1),tm1.val(),tm2.val(),"",null,"emap");
				});
				$(".tiafficnav:first a",rightlist).l_mousedown(function(){
					$(".tiafficnav:first a",rightlist).removeClass("cur");
					$(this).addClass("cur");
					if($.trim($(this).text())=="交通路线"){
						$(".tiafficcon:first",rightlist).hide();
						$(".tiafficmain:first",rightlist).show().find("input:first").select();

					}else{
						$(".tiafficmain:first",rightlist).hide();
						$(".tiafficcon:first",rightlist).show().find("input:first").select();
					}
					return false;
				});
				var toInpElem=$(".tiafficmain:first .goout1:first input:first",rightlist);
				var fromInpElem=$(".tiafficmain:first .goout2:first input:first",rightlist);
				var toSearch=function(){
					var hotelData=service.baidu.hotelWindow._hotelData;
					var point={"point":hotelData.point,"title":hotelData.title};
					var seartVal=$.trim(toInpElem.val())||"";
					if(!seartVal){
						toInpElem.focus();
						return false;
					}
					service.baidu.contextSearch(seartVal,point,"inputText");
					return false;
				};
				var fromSearch=function(){
					var hotelData=service.baidu.hotelWindow._hotelData;
					var point={"point":hotelData.point,"title":hotelData.title};
					var endVal=$.trim(fromInpElem.val())||"";
					if(!endVal){
						fromInpElem.focus();
						return false;
					}
					service.baidu.contextSearch(point,endVal,"inputText");
					return false;
				};
				toInpElem.keyenter(toSearch);
				$(".tiafficmain:first .goout1:first a:first",rightlist).l_click(toSearch);
				fromInpElem.keyenter(fromSearch);
				$(".tiafficmain:first .goout2:first a:first",rightlist).l_click(fromSearch);
				$(".tiafficcon:first li[class!='tia4'] a",rightlist).l_click(function(){
					service.baidu.search({"content":$.trim($(this).text()),"marker":service.baidu.hotelWindow._hotelData,inputType:"inputText",type:"txt"});
					return false;
				});
				var rSearchInput=$(".tiafficcon:first li[class='tia4'] input",rightlist);
				var rSearch=function(){
					var content=$.trim(rSearchInput.val())||"";
					if(content){
						service.baidu.search({"content":content,"marker":service.baidu.hotelWindow._hotelData,inputType:"inputText",type:"txt"});
					}else{
						rSearchInput.select();
					}
					return false;
				};
				rSearchInput.keyenter(rSearch);
				$(".tiafficcon:first li[class='tia4'] a",rightlist).l_click(rSearch);
			},
			hidecall:function(){
				$("#CalFrame").hide();
				checkRemoveHotMark();
			}
			});
			
			var unifyPriceFrame=new _.unify("统一价格框");
			service.baidu.hotelWindow.openPriceMarker=function(marker,isNew){
				var isPriceRun=unifyPriceFrame.run();
				service.baidu.pointWindow.close();
				checkRemoveHotMark();
				service.baidu.hotelWindow._nowMarker=marker;
				var hotelData=marker._json;
				service.baidu.hotelWindow._hotelData=hotelData;
				service.baidu.hotelWindow.open(hotelData.point);
				var childrens=ele.hotel_room_list_info.parent().children(".tab_content");
				childrens.hide();
				ele.hotel_room_list_info.show();
				ui.zhunaHotelInfoTab.callback=null;
				ui.zhunaHotelInfoTab.init();
				var pDiv=$(service.baidu.hotelWindow._div);
				var url=service.zhuna.getHotelUrlByID(hotelData.id);
				var shoucanBtn=$(".mapshoucang:first a",pDiv);
				shoucanBtn.removeClass("cur");
				if(marker._elemDl){
					if(marker._elemDl.find(".sidemsg:first").is(".cur")){
						shoucanBtn.addClass("cur");
					}
				}
				var addOtherInfo=function(hotelData){
					var pDiv=$(service.baidu.hotelWindow._div);
					var rank=service.zhuna.getPriceRank(hotelData.price);
					var rankStar=service.zhuna.xingji(hotelData.star);
					var xingji=service.zhuna.RankUIData.xingji[rankStar];
					$(".h_add:first",pDiv).text(hotelData.addr);
					$(".h_add:first",pDiv).styleTitle({"title":hotelData.addr});
					var comment=service.zhuna.comment(hotelData.comment);
					$(".c_8e9:first",pDiv).text(comment.all==0?"暂无":Math.round(comment.h*100.0/comment.all)+"% (来自"+comment.all+"篇评论)").styleTitle({"title":comment.all==0?"":"好评:"+comment.h+"  中评:"+comment.z+"  差评:"+comment.c});
					$(".hotelpic:first",pDiv).css({width:116,height:87,margin:"0px"}).attr("src","").attr("src",service.zhuna.getImgUrlByPicture(service.zhuna.alterPicSize(hotelData.picture,"120x90"))).parent().attr({"href":url}).styleTitle({"title":"查看详情"});
					$(".c_f60:first",pDiv).text("￥"+hotelData.price).css("color",service.zhuna.RankUIData.color[rank]);
					$(".star:first",pDiv).attr({"class":"star "+"star"+rankStar}).styleTitle({"title":xingji.n});
				};
				if(hotelData.isLoadData){
					pDiv.css("margin-bottom","-15px");
					$(".hotelpic:first",pDiv).attr("src","").css({width:60,height:60,margin:"10px 0 0 30px"}).attr("src",httpUrl.map+"/images/ajaxLoader.gif").parent().attr({"href":url}).styleTitle({"title":"查看详情"});
					$(".details:first",pDiv).parent().prevAll().css("visibility","hidden");
					$.ajax({
						"url":httpUrl.zhuna+'/v5/Ajax/A_hotellist3.asp?callback=?&ids='+hotelData.id,
						"type":'GET',
						"dataType":"jsonp",
						"cache":false,
						"success":function(rdata){
							if(!isPriceRun.check()){return;}
							if(rdata&&rdata.hotels&&rdata.hotels.length>0){
								hotelData.isLoadData=false;
								var tempPoint=hotelData.point;
								$.extend(hotelData,rdata.hotels[0]);
								hotelData.point=tempPoint;
								hotelData.addr=hotelData.address&&("地址："+hotelData.address)||"";
								addOtherInfo(hotelData);
								var pDiv=$(service.baidu.hotelWindow._div);
								$(".details:first",pDiv).parent().prevAll().css("visibility","visible");
							}
						}
					});
				}else{;
					$(".details:first",pDiv).parent().prevAll().css("visibility","visible");
					addOtherInfo(hotelData);
					pDiv.css("margin-bottom",0);
				}
				$(".listnav:first h2:first a:first",pDiv).text(hotelData.title).attr({"href":url}).styleTitle({"title":hotelData.title});
				$(".details:first",pDiv).attr({"href":url}).styleTitle({"title":hotelData.title});
				ele.hotel_room_list_room.attr("id","h"+hotelData.id).html('<img style="margin:40px 116px;width:160px;height:39px;"src="'+httpUrl.tp1+'/images/new/loading2.gif">');
				var tm1=$("#tm1",ele.hotel_room_list_info);
				var tm2=$("#tm2",ele.hotel_room_list_info);
				var bookTm1=$("#doBook input[name=tm1]");
				var bookTm2=$("#doBook input[name=tm2]");
				var startDate=_.Date.parseDate(bookTm1.val());
				var endDate=_.Date.parseDate(bookTm2.val());
				if(!startDate.isDate()){
					startDate=_.now().addVal("d",2);
				}
				if(!endDate.isDate()){
					endDate=startDate.clone().addVal("d",2);
				}
				var startDateStr=startDate.format("yyyy-MM-dd");
				var endDateStr=endDate.format("yyyy-MM-dd");
				tm1.val(startDateStr);
				tm2.val(endDateStr);
				bookTm1.val(startDateStr);
				bookTm2.val(endDateStr);
				loadPrice(hotelData.id,startDateStr,endDateStr,"",null,"emap");
				service.baidu.hotelWindow._panBox(true);
				ele.hotel_room_list_dianping.html("");
				var autoLoad=new _.autoLoadDataInScrollDiv(ele.hotelInfoScroll);
				autoLoad.setCheck(function(){return isPriceRun.check()&&ele.hotel_room_list_dianping.is(":visible")});
				autoLoad.setLoadCallback(function(index){
					var loading=$(loadingString);
					ele.hotel_room_list_dianping.append(loading);
					$.ajax({
						"url":httpUrl.zhuna+'/v5/ajax/a_hotelinfo_comment_map.asp?call=?',
						"type":'GET',
						"data":{"hid":hotelData.id,"pg":index},
						"dataType":"jsonp",
						"cache":false,
						"success":function(data){
							if(!isPriceRun.check()){return}
							loading.remove();
							if(data&&$.type(data.value)=="array"&&data.value.length>0){
								for(var i=0;i<data.value.length;i++){
									var dianpingInfo=data.value[i];
									var dplist=$('<div class="dplist"></div>');
									dplist.append($('<h3></h3>').text("“"+(dianpingInfo.yinxiang+"").replace(/、$/,"")+"”"));
									dplist.append($('<p></p>').text((dianpingInfo.content+"").replace(/<[^>]+>/g,"")));
									var dpbottom=$('<p class=" c_999"></p>');
									dpbottom.append($('<span></span>').text(dianpingInfo.user+" 于 "+dianpingInfo.date+"前 点评"));
									if(dianpingInfo.jiangjin>0){
										dpbottom.append('已获得<strong>'+$("<div/>").text(dianpingInfo.jiangjin).html()+'</strong>元奖金');
									}
									ele.hotel_room_list_dianping.append(dplist.append(dpbottom));
								}
								autoLoad.openAutoLoad();
							}else{
								if(index==0){
									ele.hotel_room_list_dianping.html('<div class="not_pinglun">暂无评论</div>');
								}
							}
						},
						error:function(){
							if(!isPriceRun.check()){return}
							loading.remove();
						}
					});
				});
				var addServerElement=function(title,data){
					var data=$.trim(data);
					if(data){
						var elem=$('<div class="mapserve"><div class="serve1"><span><\/span><div class="serve_line"><\/div><p><\/p><\/div><\/div>');
						$(".serve1:first span:first",elem).text(title);
						$(".serve1:first p:first",elem).text(data);
						ele.hotel_room_list_sheshi.append(elem);
					}
				};
				ele.hotel_room_list_sheshi.html(loadingString);
				$.ajax({
					"url": httpUrl.map+'/api.asp?method=hotel.info',//&_callback=?
					"type":'GET',
					"data":{"hid":hotelData.id},
					"success":function(data){
						if(!isPriceRun.check()){return}
						ele.hotel_room_list_sheshi.html("");
						try{
							if(!isPriceRun.check()){return;}
							var apiHotelData=$.parseJSON(data);
							if(apiHotelData&&apiHotelData.reqdata){
								//添加服务设施
								addServerElement("酒店特色",apiHotelData.reqdata.teshe);
								addServerElement("服务设施",apiHotelData.reqdata.service);
								addServerElement("餐饮服务",apiHotelData.reqdata.canyin);
							}else{
								ele.hotel_room_list_sheshi.append("暂无数据");
							}
						}catch(ex){}
					},
					error:function(){
						if(!isPriceRun.check()){return}
						ele.hotel_room_list_sheshi.html("");
					}
				});
				//酒店照片
				var isLoadPic=true;
				var loadPic=function(){
					if(isLoadPic){
						//loading..
						ele.hotel_room_list_tupian.html(loadingString);
						$.ajax({
							"url": httpUrl.map+'/api.asp?method=hotel.pic',//&_callback=?
							"type":'GET',
							"data":{"hid":hotelData.id},
							"success":function(data){
								if(!isPriceRun.check()){return}
								//try{
									var pageDatas=[];
									var picData=$.parseJSON(data);
									if(picData&&picData.reqdata){
										var index=0;
										for(var k in picData.reqdata){
											var o=picData.reqdata[k];
											o.id=k;
											o.index=index;
											pageDatas.push(o);
											index++;
										}
										var picFrame=$('<div class="mappic_left"><ul><li><a class="pica cur_left"></a></li><li><a class="title_name"></a></li><li class="description"></li></ul></div><div class="mappic_right"><div class="picr_list"></div><div class="mappages"></div></div>');
										var picr_list=$(".picr_list:first",picFrame);
										var ul=$("ul:first",picFrame);
										var pica=$(".pica:first",ul);
										var title_name=$(".title_name:first",ul);
										var description=$(".description:first",ul);
										var mappages=$(".mappages:first",picFrame);
										//var 
										var pt=new _.pageTool({
											datas:pageDatas,
											num:9,
											callbackPos:function(pd,pos){
												var ptHandle=this;
												var picCell=ul;
												pica.html('<img width="187" height="138" src="">');
												//<img width="187" height="138" src="">
												var bigImg=service.zhuna.alterPicSize(pd["pic500"],"160x120");
												var aImg=service.zhuna.alterPicSize(pd["pic500"]);
												$("img:first",pica).loadImg(bigImg);
												title_name.text(pd.title).attr({title:pd.title}).styleTitle();
												/*
												"href":aImg,
												.unbind("mousedown").l_mousedown(function(e){
													return false;
														Tips({
														  _title:'',
														  _closeID:"colseTipsLayer",
														  _content:"img:"+aImg,
														  _width:300,
														  _height:500,
														  _showbg:true
														});
													var a=$("<a><img/></a>");
													$("img:first",a).attr("src",aImg);
													Tips({_bordercss:{borderWidth:"5px",borderStyle:"solid",borderColor:"#666","border-radius":"10px"},_width:"600", _height:"500",_content:"text:<div class=\"cur_left\" id=\"box_image_div\"style=\"position:relative\"><div id=\"rel_loading\" ><img src=\"/v5/images/ajaxLoader.gif\"><\/div><img id=\"lightboxImage\" \/><\/div><em class=\"colseBtn2\" id=\"colseTipsLayer\">X</em>",_showbg:true,_showTitle:false,_closeID:"colseTipsLayer",_rel:"picshow",_this:a,_windowBgOpacity:"0.7"});
													//Tips({_bordercss:{borderWidth:"5px",borderStyle:"solid",borderColor:"#666","border-radius":"10px"},_width:"550", _height:"490",_content:"img:"+$(T).attr("s"),_showbg:true,_showTitle:false,_closeID:"colseTipsLayer"});
													ZN.F.stopEvent(e);
													return false;
												});
												*/
												$("a",picr_list).removeClass("cur");
												$("a[pos="+pos+"]",picr_list).addClass("cur");
											},
											callback:function(json){
												var ptHandle=this;
												picr_list.html("");
												if(json&&json.datas&&json.datas.length>0){
													//小图片
													for(var i=0;i<json.datas.length;i++){
														(function(){
															var pd=json.datas[i];
															var a=$('<a><img width="55" height="41" src=""></a>)').attr("title",pd.title).styleTitle();
															$("img:first",a).loadImg(service.zhuna.alterPicSize(pd["pic160"],"56x42"));
															var pos=json.start+i;
															a.attr("pos",pos);
															a.l_mousedown(function(){
																ptHandle.setPos(pos);
																return false;
															});
															a.hover(function(){
																a.addClass("hover");
															},function(){
																a.removeClass("hover");
															});
															picr_list.append(a);
														})();
													}
													mappages.html("");
													if(ptHandle.getPageCount()>1){
														//上一页
														mappages.append($('<a class="homepage" title="上一页">上一页</a>').styleTitle().l_click(function(){
															ptHandle.back(true);
															return false;
														}));
														var pbd=ptHandle.getBtnData();
														var nowPageCode=ptHandle.getNowPageCode();
														for(var i=pbd.start;i<pbd.end;i++){
															(function(){
																var tempI=i;
																var a=$('<a href="#"></a>').attr("title","第"+(tempI+1)+"页").text(tempI+1).styleTitle().l_click(function(){
																	if(nowPageCode!=tempI){
																		ptHandle.setPageCode(tempI);
																	}
																	return false;
																});
																if(i==nowPageCode){
																	a.addClass("cur");
																}
																mappages.append(a);
															})();
														}
														//下一页
														mappages.append($('<a class="endpage" title="下一页">下一页</a>').styleTitle().l_click(function(){
															ptHandle.next(true);
															return false;
														}));
													}
													//
													//$("a",picr_list).eq(pos).mousedown();
													//.append;
												}else{
													
												}
											}
										});
										pica.mousemove(function(e){
											var t=$(this);
											if(e.pageX-t.offset().left-(t.width()/2)>0){
												if(t.hasClass("cur_left")){
													t.removeClass("cur_left");
													t.addClass("cur_right");
												}
											}else{
												if(t.hasClass("cur_right")){
													t.removeClass("cur_right");
													t.addClass("cur_left");
												}
											}
										}).l_mousedown(function(e){
											var t=$(this);
											var nowPos=pt.getPos();
											if(e.pageX-t.offset().left-(t.width()/2)>0){
												pt.setPos(nowPos+1,true);
											}else{
												pt.setPos(nowPos-1,true);
											}
											return false;
										});
										ele.hotel_room_list_tupian.html("");
										ele.hotel_room_list_tupian.append(picFrame);
									}
									isLoadPic=false;
								//}catch(e){}
							},
							error:function(){
								if(!isPriceRun.check()){return}
							}
						});
					}
				};
				//酒店信息tab切换
				ui.zhunaHotelInfoTab.callback=function(elem){
					childrens.hide();
					switch($.trim(elem.text())){
						case "房型价格":
							ele.hotel_room_list_info.show();
						break;
						case "住客点评":
							ele.hotel_room_list_dianping.show();
							autoLoad.start();
						break;
						case "酒店图片":
							loadPic();
							ele.hotel_room_list_tupian.show();
						break;
						case "服务设施":
							ele.hotel_room_list_sheshi.show();
						break;
						case "酒店周边":
							ele.hotel_room_list_zhoubian.show();
							if($(".tiafficmain:first",ele.hotel_room_list_zhoubian).is(":visible")){
								$(".tiafficmain:first input:first",ele.hotel_room_list_zhoubian).select();
							}else{
								$(".tiafficcon:first input:first",ele.hotel_room_list_zhoubian).select();
							}
						break;
					}
					ele.hotelInfoScroll.tinyscrollbar_update();
				};
			};
			//右键菜单
			service.baidu.contextMenu = new BMap.ContextMenu();
			service.baidu.contextMenu.items ={};
			var txtMenuItem = [/*{
					text:'以此为起点',
					callback:function(p){
					}
				},
				{
					text:'以此为终点',
					callback:function(p){
					}
				},
				{
				  text:'-'
				},*/
				{
					text:'在此点附近找...',
					callback:function(p){
						var marker=new BMap.Marker(p, {icon: service.baidu.createPointIcon()});
						service.baidu.pointMarkerAutoContent(marker);
						map.addOverlay(marker);
						//alert(0)
						marker._clickEvent();
						//service.zhuna.search({"cityid":service.zhuna.nowCity.id,"x":p.lng,"y":p.lat,"r":service.zhuna.defaultSearchData.r});
					}
				}];
			for(var i=0; i < txtMenuItem.length; i++){
				if(txtMenuItem[i].text=="-"){
				  //添加分割线
				  service.baidu.contextMenu.addSeparator();
				}else{
					var mItem=new BMap.MenuItem(txtMenuItem[i].text,txtMenuItem[i].callback,{width:88});
					service.baidu.contextMenu.items[txtMenuItem[i].text]=mItem;
					service.baidu.contextMenu.addItem(mItem);
				}
			}
			service.baidu.contextMenu.addEventListener("open",function(){
				//service.baidu.contextMenu.removeItem(service.baidu.contextMenu.items[0]);
				//service.baidu.contextMenu.items[1].disable();
				//service.baidu.contextMenu.items[2].disable();
			});
			map.addContextMenu(service.baidu.contextMenu);
			service.baidu.myDis = new BMapLib.DistanceTool(map);//测距
			service.baidu.myDis.addEventListener("drawend", function(e) {service.zhuna.selectControlTools.init();});
	};
	//自动检测搜索
	sys.autoCheckSearch=function(){
		if($(".topseach:first .sea_in:first").is(":visible")){
			//搜酒店
			var val=$.trim(ele.searchInputTxt.data("getInputVal")());
			if(val){
				_.note(val);
				var regex=/(?:酒店|饭店|宾馆|旅馆)\s*$/;
				if(regex.test(val)){
					var key=val.replace(regex,"")||val;
					//"cityid":"0101",service.zhuna.nowCity.id
					service.zhuna.search({"cityid":service.zhuna.nowCity.id,"hn":key,"_hn":val});
					return false;
				}
				service.baidu.search({"content":val,inputType:"inputText",type:"txt"});
			}else{
				ele.searchInputTxt.focus();
			}
		}else{
			//搜线路
			var seartVal=$.trim(ele.searchLineStart.data("getInputVal")());
			if(!seartVal){
				ele.searchLineStart.focus();
				return false;
			}
			var endVal=$.trim(ele.searchLineEnd.data("getInputVal")());
			if(!endVal){
				ele.searchLineEnd.focus();
				return false;
			}
			//默认驾车drive  //可切换公交transit
			service.baidu.contextSearch(seartVal,endVal,"inputText");
		}
		return false;
	};
	sys.initEvent=function(){
		ele.searchInputTxt.inputAutoWord({
			"word":"请输入酒店名称\\地标\\街道","beforeStyle":{color:"#B8BEC3"},"afterStyle":{color:"#000000"},"beforeClass":"","afterClass":""
		}).keyenter(sys.autoCheckSearch);
		ele.searchLineStart.inputAutoWord({
			"word":"请输入起点","beforeStyle":{color:"#B8BEC3"},"afterStyle":{color:"#000000"},"beforeClass":"","afterClass":""
		}).keyenter(sys.autoCheckSearch);
		ele.searchLineEnd.inputAutoWord({
			"word":"请输入终点","beforeStyle":{color:"#B8BEC3"},"afterStyle":{color:"#000000"},"beforeClass":"","afterClass":""
		}).keyenter(sys.autoCheckSearch);
		ele.searchBtn.l_click(sys.autoCheckSearch);
		service.baidu.addBMapInnerFunction=function(func){
			_jsload&&_jsload("myInnerFunction","("+func+")()");
		};
		service.baidu.addBMapInnerFunction(function(){
			var innerName=/(\w+)\.call/.test(BMap.Circle)&&RegExp.$1;
			window.MapHandle.service.baidu.circleInnerLoadName=(/(\w+)\.load/.test((eval(innerName)+""))&&RegExp.$1)+"";
		});
		service.baidu.addBMapInnerFunction('function(){window.MapHandle.service.baidu.addCircleOverExec=function(callback){'+
		'var poly='+service.baidu.circleInnerLoadName+'.current("poly");'+
		'if(poly._status=='+service.baidu.circleInnerLoadName+'.Request.COMPLETED){callback&&callback.call();}else{'+
		'poly._callbacks.push(callback);}}}');
	};
	sys.init=function(){
		ui.init();
		sys.initEvent();
		service.initMap();
		ui.showLayer("home");
	};
	window.MapHandle=sys;
})();

//回调函数
_.ready(function(){
	_.jsCallback("eMap.js");
});