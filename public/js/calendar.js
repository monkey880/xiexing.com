document.domain = 'xexing.com';
document.write('<iframe id=CalFrame name=CalFrame src="/public/js/calendar.htm" frameborder=0 style="display:none;position:absolute;z-index:110" onload="loadCalendarHtm();"></iframe>');
function loadCalendarHtm(){}
function showCalendar(sFld1,sNextD,sCallback,sFld2)
{
	//1.sFld1取得日期的控件名称,
	//2.sNextD选取日期后新日历弹出从中取值的控件名称		
	//3.sCallback
	//4.sFld2,弹出日历默认日期
	var fld1,fld2;
	var cf=document.getElementById("CalFrame");
	if (cf!=null && cf!="undefine" && cf.src=="") 
	{		 
	    loadCalendarHtm = function(){showCalendar(sFld1,sNextD,sCallback,sFld2)};cf.src = "/public/js/calendar.htm";	   	    	
	    return;	    
	}	
	var wcf=window.frames.CalFrame;
	if(!sFld1){alert("输入控件未指定！");return;}
	fld1=document.getElementById(sFld1);
	fld1.focus();
	if(!fld1){alert("输入控件不存在！");return;}
	if(fld1.tagName!="INPUT"||fld1.type!="text"){alert(fld1.tagName+','+fld1.type+"输入控件类型错误！");return;}
	if(sFld2){fld2=document.getElementById(sFld2);if(!fld2){alert("参考控件不存在！");return;}if(fld2.tagName!="INPUT"||(fld2.type!="text"&&fld2.type!="hidden")){alert("参考控件类型错误！");return;}	}
	if(!wcf.bCalLoaded){alert("日历未成功装载！请刷新页面！");return;}
	wcf.n_textdate=sNextD;
	if(cf.style.display=="block"){cf.style.display="none";}
	cf.style.top= gT(fld1)+24 + " px";	
	cf.style.left=gL(fld1) + " px";	
//控件位置更新
	var eT=4,eL=0,p=fld1;
	var sT=(document.body.scrollTop > document.documentElement.scrollTop)? document.body.scrollTop:document.documentElement.scrollTop;
	var sL=(document.body.scrollLeft > document.documentElement.scrollLeft )? document.body.scrollLeft:document.documentElement.scrollLeft;
	var h1 = document.body.clientHeight;
	var h2 = document.documentElement.clientHeight;
	var isXhtml = (h2<=h1&&h2!=0)?true:false;
	while(p&&p.tagName.toLowerCase() != "body"){eT+=p.offsetTop;eL+=p.offsetLeft;p=p.offsetParent;}
	cf.style.top= (eT+20).toString() + "px";
	cf.style.left= ((isXhtml?document.documentElement.clientWidth:document.body.clientWidth-(eL-sL)>=cf.width)?eL:eL-cf.width).toString() + "px";
//
	wcf.openbound=false;
	wcf.fld1=fld1;
	wcf.fld2=fld2;
	wcf.callback=sCallback;
	wcf.initCalendar();
	cf.style.display="block";
}
function hideCalendar(){var cf=document.getElementById("CalFrame");cf.style.display="none";}
function _g(id){return document.getElementById(id)};
function gL(x){var l=0;while(x){l+=x.offsetLeft;x=x.offsetParent;}return l};
function gT(x){var t=0;while(x){t+=x.offsetTop;x=x.offsetParent;}return t};



