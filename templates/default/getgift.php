<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />


<title><?php echo $keywords_array['k_title'] ?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />

<meta name="description" content="<?php echo $keywords_array['k_description'] ?>" />
</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

<div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy"><a href="<?php  echo site_url("/gift") ?>">免费礼品</a></span>

                <span class="wzdt"></span><span class="sy"><a href="<?php echo site_url("/gift/get/{$giftInfo['ProductID']}") ?>">申请礼品</a></span>

           </div>

           <div class="hot_info_xx">

                    <div class="hot_info_top">

                        <span><h1><?php echo $hotelInfo['ProductName']; ?></h1></span>

                    </div>

                   

                 </div>    

           

           

       </div>       

</div>



<div class="inbz"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/inbz.jpg" width="950" height="57" /></div>

<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

<form action="<?php echo site_url('ebook/index')?>" method="get" target="_blank" name="doBook" id="doBook">

    <input name="hid" type="hidden"/>

    <input name="rid" type="hidden" />

    <input name="pid" type="hidden" />

    <input name="tm1" type="hidden" value="<?php echo $sk_array['tm1']; ?>" />

    <input name="tm2" type="hidden" value="<?php echo $sk_array['tm2']; ?>" />

</form>

<script type="text/javascript">


$(function(){

    //轮播图片

    var len  = $("#numeric > li").length;var index = 0;

    var isie =  document.all ? 'IE' : 'others';

    if (isie == 'IE') {

		if (!document.documentMode || document.documentMode < 8) {

			var lunbolen = 176;	

		} else {

			var lunbolen = 174;	

		}

	} else {

		var lunbolen = 179;	

	}

    

    	

    var interval = setInterval(function(){rotatorimg(index,232,lunbolen);index++;if(index==len){index=0;}},1000);

    $("#numeric li").mouseover(function(){index= $("#numeric li").index(this);rotatorimg(index,232,174);}); 

    

    //酒店图片

    $('.hotel_picture_small').mousemove(change_hotel_picture_small);



    $("#Map_Show").fancybox({

        'width'             : 580,

        'height'            : 480,

        'autoScale'         : false,

        'transitionIn'      : 'none',

        'transitionOut'     : 'none',

        'type'              : 'iframe',

        'overlayOpacity' : '0.8',

        'overlayColor' : '#000'        

    });

    

})

function divclass(divclass,divid){

    $('#hotel_info_tab').removeClass(); 

    $('#hotel_picture_tab').removeClass();

    $('#hotel_lable_tab').removeClass();

    $(divclass).addClass('current');  

    

    $("#hotel_info_div").hide();

    $("#hotel_picture_div").hide();

    $("#hotel_lable_div").hide();

    $("#"+divid).show();

     

}

function divclass2(divclass,divid){

    $('#comment_tab').removeClass(); 

    $('#question_tab').removeClass();

    $(divclass).addClass('current');

    

    $("#hotel_comment_div").hide();

    $("#hotel_question_div").hide();

    $("#"+divid).show();   

}

function change_hotel_picture_small (){

    var src = $(this).attr("src");

    current = $(this).attr("id").substring('8');

	$("#hotelpic_list").attr('current',current);

    $('.hotel_picture_big').attr('src',src);  

}



function set_nexpic(sort)

{

	var hotelpic_num = $("#hotelpic_list").attr('total');

	var current = $("#hotelpic_list").attr('current');

	if (sort == 'right') {

		var nextid = current < hotelpic_num ? parseInt(current)+1 : 1;

	} else {

		var nextid = current > 1 ? parseInt(current)-1 : 5;	

	} 

	 

	$("#hotelpic_list").attr('current',nextid);

	var src = $("#current_"+nextid).attr('src');

 	$('.hotel_picture_big').attr('src',src); 

}

</script>

</body>

</html>