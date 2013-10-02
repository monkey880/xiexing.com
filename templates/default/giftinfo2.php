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

                <span class="wzdt"></span><span class="sy"><a href="<?php echo site_url("/gift/info/{$hotelInfo['ProductID']}") ?>">礼品详情</a></span>

                <span class="wzdt"></span><span class="sy"><?php echo $hotelInfo['ProductName']; ?></span>

           </div>

           <div class="hot_info_xx">

                    
                    <div class="hot_info_bottom free" style=" width:720px; float:left">

              <div class="g_i_b_left " >

                                <img alt="<?php echo $hotelInfo['ProductName']; ?>" src='/public/uploadfiles/upload/<?php echo $hotelInfo['ProductPic']; ?>' width="250" height="250" border='0' />
                         

                </div>

                        <div class=" try-property start">
                        
                        <h3><span> <?php echo $hotelInfo['ProductName']; ?></span><i class="type"></i></h3>
                        
                        <ul class="try-meta">
    	   <li class="first">价值 : <span class="price"><i>￥</i><em><?php echo $hotelInfo['Price']; ?></em></span><i class="split"></i></li>
    	   <li class="second">免费提供 : <em><?php echo $hotelInfo['Stocks']; ?></em>&nbsp;份</li>
    	</ul>
        <div class="try-buy">
       <div class="try-buy-wrap">
         

           
		   <div class="condition"><span class="tip">发放条件</span>
									1. 所有会员都可以免费申请，申请成功无需支付邮费<br>2. 申请成功需要提交真实原创的试用报告
				           </div>
		   <div class="sq_frm" style="padding:10px"> <form id="form1" name="form1" method="post" action="/gift/get">
		     <table width="450" border="0">
		       <tr>
		         <td width="64">联系人：</td>
		         <td width="253"><label for="name"></label>
		           <input name="name" type="text" id="name" size="11" />
		           电话：
		           <input name="phone" type="text" id="phone" size="11" /></td>
		         <td width="119" rowspan="2"><input type="submit"  style="width:95px; height:60px; background-color:#FB6220; color:#FFF; font-size:16px" value="免费申请"/></a>&nbsp;</td>
		         </tr>
		       <tr>
		         <td>详细地址：</td>
		         <td><textarea name="address" cols="30" rows="2" id="address" style="height:40px; width:244px"></textarea></td>
		         </tr>
		       </table>
		    <input name="product_id" type="hidden" value="<?php echo $hotelInfo['ProductID']; ?>" />
             <input name="ProductType" type="hidden" value="<?php echo $hotelInfo['ProductType']; ?>" />
              <input name="ProductName" type="hidden" value="<?php echo $hotelInfo['ProductName']; ?>" />
		       </form>
           </div>
             <div class="try-state">
    	<h3><em><?php echo $hotelInfo['GetTimes']; ?></em>人已申请，赶快去申请吧！</h3>
        
    </div>
        </div>
    </div>
                        
                       

                          

                        </div>

                       

                    </div>
                    <div class="gift_right">
  <?php $this->load->view('modules/'.$layout[1][1]);?>
                    </div>
                    

                 </div>    

           <div class="jdlist">

                    <div >
                    
                    <?php echo $hotelInfo['ProductExplain']; ?>

                        </div>

               <div class="jdlist_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

				

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