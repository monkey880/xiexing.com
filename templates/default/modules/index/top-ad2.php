<?php 

    $ci = & get_instance();

	$ci->load->model('model_ad');

	$adNameArr = "'index_focus_1','index_focus_2','index_focus_3','index_focus_4'";

    $ad = $ci->model_ad->getAdListByAd_cid($adNameArr);

?>

<div class="i_s_right" id="comImgList">

    <ul>

	<?php foreach ($ad as $val) {  ?>

	<li><a href='<?php echo $val['ad_link']?>' target='_blank' title='<?php echo $val['ad_title']?>'><img width='395' height='237' src='<?php echo rtrim(base_url(),'/');?><?php echo $val['ad_uploadfile']?>' border='0' alt='<?php echo $val['ad_title']?>' /></a></li>

	<?php  } ?> 

	</ul>

</div>

<script src="<?php echo base_url();?>public/js/jquery.nbspSlider.min.js" type="text/javascript"></script>

<script type="text/javascript">

	$(function(){

		$("#comImgList").nbspSlider({

            widths:           "395px",

            heights:          "237px",

            effect:          "horizontal",

            autoplay:        1,

            speeds:          500,

            delays:          5000,

            altOpa:          0.5,            // ALT区块透明度

            altBgColor:      '#ccc',        // ALT区块背景颜色

            altHeight:       '40px',        // ALT区块高度

            altShow:         0,             // ALT区块是否显示(1为是0为否)

            altFontColor:    'blue',        // ALT区块内的字体颜色

            btnFontColor:    'red',        // 数字按钮的数字颜色

            btnBorderColor:  '#ccc',        // 数字按钮边框颜色

            btnBgColor:      'yellow',      // 数字按钮背景颜色

            btnActBgColor:   'green',        // 数字按钮选中的背景

            numBtnSty:        "num",        // num、square、circle、roundness、rectangle == 数字、正方形、圆圈、圆形、长方形

            numBtnShow:       "1"          // 是否显示数字按钮(1为是0为否)                

        });





	});

</script>