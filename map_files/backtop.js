//回到顶部按钮
$(document).ready(function(){
	var obj = $("#back-to-top");
	//$(window).scrollTop(0); //刷新页面时滚动条至顶部；
	$("html, body").animate({ scrollTop: 0 }, 100);
	var offset = 300;//偏移量
	if($(window).scrollTop() < offset+obj.height()){
		obj.hide(); //初始化时隐藏
	}
	obj.click(function(){
		backtop();
	});
})
/**/
$(window).scroll(function(){
	var obj = $("#back-to-top");
	var offset = 20;//偏移量
	var showH = 100; //显示隐藏的高度
	//高度大于底部高度时不再滚动
	var _maxH = $(document).height()-$("footer").parent().height()-obj.height(); //最大高度
	var _H = $(window).scrollTop()+$(window).height();
	if(_H > _maxH){
		//$("#to-top").attr("style","bottom:"+($("footer").parent().height()+obj.height())+"px;");
		obj.attr("style","bottom:"+($("footer").parent().height()+obj.height())+"px;");
	}else{
		//$("#to-top").attr("style","bottom:"+(offset)+"px;");
		obj.attr("style","bottom:"+(offset)+"px;");
	}
	
	//alert($(window).scrollTop() >= showH);
	if($(window).scrollTop() >= showH){
		obj.show();
	}else{
		obj.hide();
	}
})

function setBacktopButtonSite()
{
	var obj = $("#backtop");
	var winH = $(window).scrollTop();//滚动条位置
	var offset = 20;//偏移量
	if(winH < offset+obj.height()){
		obj.hide(); //隐藏
	}else{
		obj.show();
		//页面右下角
		var y2 = $(window).scrollTop() + $(window).height() - obj.height();
		var x2 = $(window).width() -  obj.width(); 
		//最高高度，不与底部重叠;
		var yMax = $("footer").parent().offset().top - obj.height();
		if(yMax <= y2) y2 = yMax;
		//偏移
		x2 = x2 - offset;
		y2 = y2 - offset;
		//定位
		obj.attr("style","position:absolute;top:"+y2+"px;left:"+x2+"px;");	
	}
}

function backtop()
{
	//$(window).scrollTop(0); //滚动至顶部
	$("html, body").animate({ scrollTop: 0 }, 200);
}