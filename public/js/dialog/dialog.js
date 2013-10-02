// JavaScript Document
var DIALOGIMGPATH = '/public/js/dialog/';
var DIALOGBGIMG = '/public/js/dialog/tbtbg.gif'; //背景图片
var WINDOWIMG = '/public/js/dialog/window.gif'; //小图标
var BUTTONIMG = '/public/js/dialog/toolbutton.gif'; //关闭按钮
var CONFIRMIMG = '/public/js/dialog/icon_query.gif'; //询问框小图标
var ALERTIMG = '/public/js/dialog/icon_alert.gif'; //确认框小图标
var CANCELBUTTONIMG = '/public/js/dialog/cancelbutton.gif'//取消图标
var OKBUTTONIMG = '/public/js/dialog/okbutton.gif'//取消图标
var BORDERCOLOR = '#666'//边框颜色
var DIALOG_INDEX = 1000;
var DIALOG_IDARRAY = new Array();
function Dialog(strID){
		if(!strID){
			alert("错误的Dialog ID！");
			return;
		}
		this.ID = strID; //ID号
		this.isModal = false; //模态
		this.Width = 400; 
		this.Height = 500;
		this.Top = 0;
		this.Left = 0;		
		this.Title = "";		
		this.bgdivID=null;
		this.Alpha = 0.8; //透明度
		this.CancelEvent = null;
		this.OKEvent = null;
		this.MaxTool = false;
		this.MinTool = false;
		
}
Dialog.maxScreen = function(id){
		$('#'+id+'_dialog').animate({ 
			width: $(window).width()+'px',
			height: $(window).height()+'px',
			top:'0px',
			left:'0px'
		  }, 500 );
		
	}
Dialog.prototype.show = function(){
	if(this.Top == 0){
		if($(window).height()>this.Height+12){
			this.Top = ($(window).height() - this.Height - 12) / 2 +$(document).scrollTop();		
		}else{
			this.Top = $(document).scrollTop()+100;
		}
		
	}
	if(this.Left == 0){
		if($(window).width()>this.Width + 12){
			this.Left = ($(window).width() - this.Width - 12) / 2 +$(document).scrollLeft();
		}else{
			this.Left = $(document).scrollLeft()+100;
		}
	}
	DIALOG_INDEX +=3;
	DIALOG_IDARRAY.push(this.ID);
	if(this.isModal){		
		this.bgdivID = this.ID+'_DIALOG_BGDIV';
		Dialog.creatBgDiv(this.bgdivID);
	}	
	var panelHTML = '<div style="width:'+this.Width+'px; background-color:#FFF; position:absolute; top:'+this.Top+'px; left:'+this.Left+'px; z-index:'+(DIALOG_INDEX+1)+'; " id="'+this.ID+'_dialog"><table cellpadding="0" cellspacing="0" width="100%" border="0" style="border:3px solid '+BORDERCOLOR+';"><tr><td><div style="width:100%;border-bottom:1px solid #aaa; background-image:url('+DIALOGBGIMG+'); height:34px;cursor:move;" id="'+this.ID+'_dialog_title"><div style="float:left; cursor:pointer;"><img src="'+WINDOWIMG+'" style="float:left; margin-left:10px; margin-top:7px;" width="18"/><div style="float:left; margin-left:10px; padding-top:8px;">'+this.Title+'</div></div><div style="float:right; margin-right:10px;margin-top:10px;">'
	if(this.MinTool){		
		panelHTML +='&nbsp;<img src="'+DIALOGIMGPATH+'btn_min_auto.gif" id="'+this.ID+'_MINBUTTON" onclick="Dialog.maxScreen(\''+this.ID+'\')" onmouseover="this.src=\''+DIALOGIMGPATH+'btn_min_over.gif\'" onmouseout="this.src=\''+DIALOGIMGPATH+'/btn_min_auto.gif\'" style="cursor:auto"/>'				
	}
	if(this.MaxTool){		
		panelHTML +='&nbsp;<img src="'+DIALOGIMGPATH+'btn_tomax_auto.gif" id="'+this.ID+'_MAXBUTTON" onclick="Dialog.maxScreen(\''+this.ID+'\')" onmouseover="this.src=\''+DIALOGIMGPATH+'/btn_tomax_over.gif\'" onmouseout="this.src=\''+DIALOGIMGPATH+'btn_tomax_auto.gif\'" style="cursor:auto"/>'				
	}
	panelHTML +='&nbsp;<img src="'+DIALOGIMGPATH+'btn_close_auto.gif" id="'+this.ID+'_CLOSEBUTTON" onclick="Dialog.close(\''+this.ID+'\')" onmouseover="this.src=\''+DIALOGIMGPATH+'btn_close_over.gif\'" onmouseout="this.src=\''+DIALOGIMGPATH+'/btn_close_auto.gif\'" style="cursor:auto"/>'
		
	
	panelHTML +='</div></div></td></tr><tr><td height="'+(this.Height-34)+'" valign="top" id="'+this.ID+'_dilog_content" bgcolor="#FFFFFF"></td></tr></table>';
    
	$('body').append(panelHTML);
	//$('#'+this.ID+'_dialog').css('width','0px');
	//$('#'+this.ID+'_dialog').css('height','0px');
	//$('#'+this.ID+'_dialog').slideDown('slow')
	$('#'+this.ID+'_dialog').show();
  	//$("#"+this.ID+"_dialog").easydrag(false);
  	//$("#"+this.ID+"_dialog").setHandler(this.ID+"_dialog_title");
	
	//$("#"+this.ID+"_dialog").anyDrag({obj:"#"+this.ID+"_dialog_title",maxTop:false,alpha:this.Alpha});
	
}

	
Dialog.close = function(id){
	
	$('#'+id+'_DIALOG_BGDIV').fadeOut('2000',function(){$('#'+id+'_DIALOG_BGDIV').remove()});
	$('#'+id+'_dialog').hide('fast',function(){$('#'+id+'_dialog').remove();});	
	for(i=0;i<DIALOG_IDARRAY.length;i++){
		if(DIALOG_IDARRAY[i] == id) DIALOG_IDARRAY.splice(i,1);
	}
	if(DIALOG_IDARRAY.length<1){
	$('body').css('overflow','auto')
	}
	
}

Dialog.creatBgDiv = function (id){
	var bodyheight = $(document).height();
	var bodywidth = $(document).width()+20;
	$('body').css('overflow','hidden');
	$('body').append('<div id="'+id+'" style="display:none;background:#000;position:absolute;left:0px;top:0px;filter: Alpha(opacity=60);-moz-opacity:.6; opacity:0.6;z-index:'+DIALOG_INDEX+';width:'+bodywidth+'px; height:'+bodyheight+'px;"></div>');
	$('#'+id).fadeIn();
}

Dialog.confirm = function(msg,func1,func2,w,h){
	var ConfirmID = '_DialogConfirm'+DIALOG_INDEX;
	var diag = new Dialog(ConfirmID);
	w = parseInt(w);
	h = parseInt(h);
	diag.isModal = true;
	diag.Width = w?w:300;
	diag.Height = h?h:140;
	diag.Title = "信息确认";
	diag.AlertFlag = true;
	diag.CancelEvent = function(){
		Dialog.close(ConfirmID)
		if(func2){
			func2();
		}
	};
	diag.OKEvent = function(){
		Dialog.close(ConfirmID)
		if(func1){
			func1();
		}
	};
	diag.show();	
	var arr = [];
	arr.push("<table height='98%' border='0' align='center' cellpadding='5' cellspacing='0'>");
	arr.push("<tr><td align='right'><img id='Icon' src='"+CONFIRMIMG+"' width='34' height='34' align='absmiddle'></td>");
	arr.push("<td align='left' id='Message' style='font-size:9pt'>"+msg+"</td></tr>");
	arr.push('<tr><td colspan="2"  height="50" align="center"><img src='+OKBUTTONIMG+' id="'+ConfirmID+'_OKBUTTON" style=" cursor:pointer"/>&nbsp;<img src='+CANCELBUTTONIMG+' id="'+ConfirmID+'_CancelBUTTON" style=" cursor:pointer"/></td></tr></table>');
	
	var innerHTML = arr.join('');
	$('#'+ConfirmID+'_dilog_content').append(innerHTML);
	$('#'+ConfirmID+'_OKBUTTON').bind('click',diag.OKEvent);
	$('#'+ConfirmID+'_CancelBUTTON').bind('click',diag.CancelEvent);
	
}

Dialog.alert = function(msg,func1,time,w,h){
	var ConfirmID = '_DialogAlert'+DIALOG_INDEX;
	var diag = new Dialog(ConfirmID);
	w = parseInt(w);
	h = parseInt(h);
	diag.isModal = true;
	diag.Width = w?w:300;
	diag.Height = h?h:140;
	diag.Title = "系统提示";
	diag.AlertFlag = true;
	diag.OKEvent = function(){
		Dialog.close(ConfirmID)
		if(func1){
			func1();
		}
	};
	diag.show();	
	var arr = [];
	arr.push("<table height='98%' border='0' align='center' cellpadding='5' cellspacing='0'>");
	arr.push("<tr><td align='right'><img id='Icon' src='"+ALERTIMG+"' width='34' height='34' align='absmiddle'></td>");
	arr.push("<td align='left' id='Message' style='font-size:9pt'>"+msg+"</td></tr>");
	arr.push('<tr><td colspan="2" height="50" align="center"><img src='+OKBUTTONIMG+' id="'+ConfirmID+'_OKBUTTON" style=" cursor:pointer"/></td></tr></table>');
	
	var innerHTML = arr.join('');
	$('#'+ConfirmID+'_dilog_content').append(innerHTML);
	$('#'+ConfirmID+'_OKBUTTON').bind('click',diag.OKEvent);
	
	if(time){
		setTimeout(diag.OKEvent,time)
	}
	
}

Dialog.frame = function(id,url,title,w,h,m){
	var diag = new Dialog(id);
	w = parseInt(w);
	h = parseInt(h);
	diag.id=id;
	diag.isModal = m;
	diag.Width = w?w:500;
	diag.Height = h?h:400;
	diag.Title = title;
	diag.show();	
	var arr = [];
	arr.push("          <iframe src='");
	arr.push(url);
	arr.push("' id='_DialogFrame_"+diag.id+"' allowTransparency='true'  width='100%' height='100%' frameborder='0' style=\"background-color: #transparent; border:none;\"></iframe>");
	
	var innerHTML = arr.join('');
	$('#'+diag.id+'_dilog_content').append(innerHTML);
		
}

Dialog.html = function(id,html,title,w,h,m){
	var diag = new Dialog(id);
	w = parseInt(w);
	h = parseInt(h);
	diag.id=id;
	diag.isModal = m;
	diag.Width = w?w:500;
	diag.Height = h?h:400;
	diag.Title = title;
	diag.show();	
	$('#'+diag.id+'_dilog_content').append(html);
		
}
Dialog.element = function(id,elementID,title,w,h,m){
	var diag = new Dialog(id);
	w = parseInt(w);
	h = parseInt(h);
	diag.id=id;
	diag.isModal = m;
	diag.Width = w?w:500;
	diag.Height = h?h:400;
	diag.Title = title;
	diag.show();	
	$('#'+elementID).prependTo('#'+diag.id+'_dilog_content');
		
}

//拖动
eval((function(a,b){return a.replace(/\w+/g, function(ss){ return b[parseInt(ss, 36)]; }); })("(0($) {\r$.1.2 = 0(3){\r3 = 4.5({\r6: \"7\",\r8: 9 ,\ra:b\r},3);\rc d = e;\rc f = $(d).g;\rc h = i;\rc j = d;\r0 k(){\r$(d).l({m:\"n\"});\ro(!p($(d).l(\"q\"))){\r$(d).l(\"q\",\"i\");\r};\ro(!p($(d).l(\"r\"))){\r$(d).l(\"r\",\"i\");\r};\rs();\r};\r0 s(){\ro(3.6 != \"7\"){\rj = $(d).t(3.6);\r}\rc u=b;\rc v,w;\r$(j).x(0(){\r}).y(0(z){\ro(3.6 == \"7\"){\r10 = $(e);\r}11{\r10 = $(e).12(f);\r}\rh = $(f).13(10);\ru=14;\rv=z.15-p($(f+\":16(\"+h+\")\").l(\"q\"));\rw=z.17-p($(f+\":16(\"+h+\")\").l(\"r\"));\r$(f+\":16(\"+h+\")\").18(19, 3.8);\ro(3.a){$(f+\":16(\"+h+\")\").l(\"1a-13\",1b()+9)}\r});\r$(1c).1d(0(z){\ro(u){\rc 1e=z.15-v;\rc 1f=z.17-w;\r$(f+\":16(\"+h+\")\").l({r:1f,q:1e});\r}\r}).1g(0(){\ru=b;\r$(f+\":16(\"+h+\")\").18(\"1h\", 9);\r});\r};\r0 1b(){\rc 1i = i;\r$(\"*\").1j(0(){\ro( 1i < p($(e).l(\"1a-13\"))){\r1i = p($(e).l(\"1a-13\"));\r}\r})\r1k 1i;\r};\r1k k();\r};\r})(4);", "function|fn|anyDrag|settings|jQuery|extend|obj|self|alpha|1|maxTop|false|var|anyDrag_BoxObject|this|anyDrag_BoxObjectSelector|selector|dragIndex|0|DragObj|anyDrag_initialize|css|position|absolute|if|parseInt|left|top|anyDrag_start|children|_move|_x|_y|click|mousedown|e|eventObj|else|parent|index|true|pageX|eq|pageY|fadeTo|20|z|get_max_zIndex|document|mousemove|x|y|mouseup|fast|maxZ|each|return".split("|")));