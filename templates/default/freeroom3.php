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

                <span class="wzdt"></span><span class="sy">试住中心</span>

             
           </div>

           <div class="main_bottom">

                <div class="m_b_left<?php if(CFG_TEMPLETS_LAYOUT) echo 1 ;?>">
              
 <div class="jianju10"></div>

<div class="hotinfo_top">
                               <ul>
                                  <li <?php if($type==1){echo "class='current'";}?> ><a href="/freeroom/shizhu/1/1" ><font class="f_b_f00">试住中</font></a></li>
                                  <li <?php if($type==2){echo "class='current'";}?>  ><a href="/freeroom/shizhu/2/1" >已过期</a></li>
                                  
                               </ul>
                           </div>



                    <div class="zhpd_bottom">

<div class="tjbotm" >

    <?php 

        foreach ($freeroomlist as $key=>$val){

    ?>

    <div class="tjplate">

       <dl>

        <dt><a href="<?php  echo site_url("/freeroominfo/".$val['fid']) ?>" title="<?php echo $val['R_Title']; ?>"><img src="<?php if(!strchr($val['R_HotelID'],"A")){ echo "http://p.zhuna.cn/";}?><?php echo $val['R_Pic']  ?>" width="147" height="112" alt="<?php echo $val['R_Title']; ?>" /></a></dt>

        <dd>

          <ul>

            <li class="tjbt"><a href="<?php  echo site_url("/freeroominfo/".$val['fid']) ?>" title="<?php echo $val['R_Title']; ?>"><?php echo $val['R_Title']  ?></a></li>

            <li>酒店：<?php echo $val['R_HotelName']  ?></li>

            <li>申请时间：<font class="f_b1_f00"><?php echo date('m-d',$val['R_Checkintime']-950400).'至'.date('m-d',$val['R_Checkintime']-86400)  ?></font></li>

            <li>入住日期：<font class="f_b1_f00"><?php echo date('Y-m-d ',$val['R_Checkintime'])  ?></font></li>

            <li>位置：<?php echo $val['R_City'].'，'.$val['R_Area']  ?></li>

          </ul>

        </dd>

      </dl>

       <div class="yinying"></div>

    </div>

    <?php } ?>

  </div>
  
  
  
      <div class="fy">

		                              <?php echo $pagenav;?>

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
<?php if($type==1){?>
    $("#hotel_info_div").show();
    $("#hotel_picture_div").hide();
	<?php }else{?>
	 $("#hotel_info_div").hide();
    $("#hotel_picture_div").show();
	
	$("#hotel_info_div").hide();
    $("#hotel_picture_div").show();
	
	<?php }?>
    $("#hotel_lable_div").hide();
    $("#hotel_info_tab").click(function(){divclass($(this),'hotel_info_div');}) ;
    $("#hotel_picture_tab").click(function(){divclass($(this),'hotel_picture_div');}) ;
    $("#hotel_lable_tab").click(function(){divclass($(this),'hotel_lable_div');}) ;
	
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

</script>


</body>

</html>