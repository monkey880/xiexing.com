<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />

<title><?php echo $keywords_array['k_title'] ?></title>

<meta name="keywords" content="<?php echo $keywords_array['k_keywords'] ?>" />

<meta name="description" content="><?php echo $keywords_array['k_description'] ?>" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/fancybox/jquery.easing-1.3.pack.js" type="text/javascript"></script>

<link href="<?php echo base_url();?>public/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$(function(){
	$("a.iframe").fancybox({
			'width':'50%',
			'height':'60%',
			'autoDimensions':'false'
			
		});
});
</script>


</head>

<body>

<?php $this->load->view('inc/header');?>

<div class="middle">

	<?php $this->load->view('inc/nav');?>

	<div class="main"><br /> 

		<div id="maincontent" style=";">
     
        
 <div class="user">
<?php $this->load->view('inc/user_nav');?>
  <div class="user_main">
    <h2><span><?php echo $title ?></span></h2>
<div class="user_list"> <form id="form1" name="form1" method="post" action="/member/save_comment">
  <table width="600" border="0" cellpadding="8">
  <tr>
    <td colspan="2" bgcolor="#F0F0F0"><?php echo $hotelname ?>的点评</td>
    </tr>
  <tr>
    <td width="62" bgcolor="#EEEEFF">人群：</td>
    <td width="500" bgcolor="#EEEEFF">
	                                <?php foreach ($renqun_ary as $key=>$val) { ?>

	                                    <input type='radio' name='renqun' value='<?php echo $key ?>'  /><?php echo $val ?>&nbsp;

	                                <?php } ?></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEFF">评分：</td>
    <td bgcolor="#EEEEFF">
	                                <?php foreach ($comment_ary as $key=>$val) { ?>

	                                    <input type='radio' name='comment' value='<?php echo $key ?>'  /><?php echo $val ?>&nbsp;

	                                <?php } ?></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEFF">印象：</td>
    <td bgcolor="#EEEEFF"><p>
      <textarea name="yinxiang" id="yinxiang" style="width:350px"></textarea>
      </p><br />


      <p class="yinxiang">
        <?php 
		foreach($this->model_config->yinxiang_ary() as $yinxiang){
			
			?>
            <a href="#" onclick="addYinXiang(this);"><?php echo $yinxiang ?></a>
            
            <?php
		}
		
		?>
        
        </p>
        <script type="text/javascript">
function addYinXiang(obj){
	if($('#yinxiang').val()==''){
		$('#yinxiang').val(obj.innerHTML)
	}
	else{
		$('#yinxiang').val($('#yinxiang').val()+','+obj.innerHTML)
	}
}
</script>

        
        </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#EEEEFF">点评内容：</td>
    <td bgcolor="#EEEEFF"><label for="Content"></label>
      <textarea name="Content" cols="40" rows="5" id="Content" style="width:350px"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <input name="order_id" type="hidden" value="<?php echo $orderid ?>" />
    <input name="hotel_id" type="hidden" value="<?php echo $hotelid ?>" />
    <input type="submit" name="button" id="button" value="提交" /></td>
  </tr>
</table>
 
  </form>
</div>
</div>
		</div>

	</div>

</div>

<div class="inbz"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/inbz.jpg" width="950" height="57" /></div>

<?php $this->load->view('inc/footer');

$ci = & get_instance();

$ci->load->library('tool');

$ci->tool->zhuna_rewrite(CFG_REWRITE);?>

</body>

</html>