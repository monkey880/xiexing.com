<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<title><?php echo $metainfo['k_title']?></title>

<meta name="keywords" content="<?php echo $metainfo['k_keywords']?>" />

<meta name="description" content="<?php echo $metainfo['k_description']?>" />

<script src="<?php echo base_url();?>public/js/simplefoucs/simplefoucs.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>public/js/simplefoucs/simplefoucs_lrtk.css" type="text/css" rel="stylesheet" />

</head>



<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

       <?php $this->load->view('inc/nav');?>

<div class="main">

           <div class="xdh">

                <span class="bg"></span><span class="sy"><a href="<?php echo base_url();?>">首页</a></span>

                <span class="wzdt"></span><span class="sy">礼品</span>
                
                <span class="wzdt"></span><span class="sy">免费礼品</span>

             
           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
                <div class="zxpd_top" style="border-bottom:solid #CCC 1px">

<h1><font class="f_b_f00">免费</font><font style="color:#494949;">礼品</font></h1>

                    </div>
      <div class="hot_info_bottom free" style=" width:720px; float:left">

              <div class="g_i_b_left " >

                                <img alt="<?php echo $hotelInfo['ProductName']; ?>" src='/public/uploadfiles/upload/<?php echo $hotelInfo['ProductPic']; ?>' width="250" height="262" border='0' />
                         

                </div>

                        <div class=" try-property start">
                        
                        <h3><span> <?php echo $hotelInfo['ProductName']; ?></span><i class="type"></i></h3>
                        
                        <ul class="try-meta">
    	   <li class="first" style=" line-height:30px;">价值 : <span class="price"><i>￥</i><em><?php echo $hotelInfo['Price']; ?></em></span><i class="split"></i></li>
    	   <li class="second" style=" line-height:30px">免费提供 : <em><?php echo $hotelInfo['Stocks']; ?></em>&nbsp;份</li>
    	</ul>
        <div class="try-buy">
       <div class="try-buy-wrap">
         

           
		   <div class="condition"><span class="tip">发放条件</span>
									1. 入住酒店并提交真实原创的酒店点评<br>2. 申领成功后无需支付邮费
				           </div>
		   <div class="sq_frm" style="padding:10px"> <form id="form1" name="form1" method="post" action="/gift/get">
		     <table width="450" border="0">
		       <tr>
		         <td width="64">联系人：</td>
		         <td width="253"><label for="name"></label>
		           <input name="name" type="text" id="name" size="11" />
		           电话：
		           <input name="phone" type="text" id="phone" size="11" /></td>
		         <td width="119" rowspan="2"><input type="submit"  style="width:95px; height:60px; background-color:#FB6220; color:#FFF; font-size:16px" value="免费申领"/></a>&nbsp;</td>
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
    	<h3><em><?php echo $hdlognum; ?></em>人已申领，赶快去申领吧！</h3>
        
    </div>
        </div>
    </div>
                        
                       

                          

                        </div>

                       

                    </div>          

<div class="jdlist">
<div class="hotinfo_top">
            <ul>
              <li class="current" id="freeroom_sq_tab"><a href="javascript:void(0)" >礼品描述</a></li>
              <li id="freeroom_sz_tab"><a href="javascript:void(0)" >申领记录</a></li>
              <li id="freeroom_hq_tab"><a href="javascript:void(0)" >领取记录</a></li>
            </ul>
          </div>
                    <div id="tab_box1">
                    
                    <?php echo $hotelInfo['ProductExplain']; ?>

                        </div>
                        <div id="tab_box2" style="display:none">
                    <ul class="lq_log">
                    <?php  
  
    $pattern = "/^(1\d{1,2})\d\d(\d{0,2})/";
$replacement = "\$1****\$4";

  if (!empty($sqlog)){ ?>
                <?php foreach ($sqlog as $key=>$val){ ?>
                
                <li><span><?php echo preg_replace($pattern,$replacement,$val['phone']) ?></span><div class="dp_nr">
                          <div class="jiao"></div>
                          <div class="xinxi">我申领了该礼品<span><?php echo date("Y-m-d H:i:s",$val['addTime'])?></span></div>
                        </div></li>
                
  <?php } ?>
                <?php }else{ echo '暂无申领记录';} ?>
                </ul>
                        </div>
                        <div id="tab_box3" style="display:none">
                    <ul class="lq_log">
                     <?php  
  
    $pattern = "/^(1\d{1,2})\d\d(\d{0,2})/";
$replacement = "\$1****\$4";

  if (!empty($hdlog)){ ?>
                <?php foreach ($hdlog as $key=>$val){ ?>
                
                <li><span><?php echo preg_replace($pattern,$replacement,$val['phone']) ?></span><div class="dp_nr">
                          <div class="jiao"></div>
                          <div class="xinxi">我领取了该礼品<span><?php echo date("Y-m-d H:i:s",$val['lingqutime'])?></span></div>
                        </div></li>
                
  <?php } ?>
                <?php }else{ echo '暂无领取记录';} ?>
</ul>
                        </div>

               <div class="jdlist_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

				

			  </div>

        </div>
                    

                    </div>


                <div class="m_b_right<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">

                    <?php $this->load->view('modules/'.$layout[0][1]);?>

                    <?php $this->load->view('modules/'.$layout[1][1]);?>

                    <?php $this->load->view('modules/'.$layout[2][1]);?>

                    <?php $this->load->view('modules/'.$layout[3][1]);?>   

                </div>

           </div>

           

           

       </div>       

</div>

<div class="inbz"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/inbz.jpg" width="950" height="57" /></div>

<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

<script type="text/javascript">
	$("#freeroom_sq_tab").click(function(){divclass3($(this),'tab_box1');}) ;
	$("#freeroom_sz_tab").click(function(){divclass3($(this),'tab_box2');}) ;
	$("#freeroom_hq_tab").click(function(){divclass3($(this),'tab_box3');}) ;
function divclass3(divclass,divid){

    $('#freeroom_sq_tab').removeClass(); 

    $('#freeroom_sz_tab').removeClass();
	
	$('#freeroom_hq_tab').removeClass();

    $(divclass).addClass('current');

    

    $("#tab_box1").hide();

    $("#tab_box2").hide();
	$("#tab_box3").hide();

    $("#"+divid).show();   

}


</script>


</body>

</html>