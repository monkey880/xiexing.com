<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/base.css" type="text/css" rel="stylesheet" />
<title><?php echo $keywords_array['k_title'] ?></title>
<script type="text/javascript">
var url='<?php echo $url ?>';
function geturl(){
	if(url){
window.location.href=url;
	}
	
	
}

</script>
</head>

<body>

<?php 
print_r($res);
?>
</body>
</html>

<script type="text/javascript">
window.onload=geturl();
</script>