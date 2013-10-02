<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<title><?php echo $title;?></title>

</head>



<body>

<div class="login">

     <div class="login_main">

         <div class="logo"></div>

         <div class="log_top">

             <div class="login_box">

             <?php echo form_open(site_url(CFG_ADMINURL.'/login/chklogin'),array('id'=>'loginform','method'=>'post'));?>

                 <div class="search_box">

                    <ul>

                       <li>

                       <span>

                         <input id="username" name="username" type="text" class="srk" value=""/>

                       </span>

                       <span>

                         <input id="password" name="password" type="password" class="srk" value=""/>

                       </span>

                       <span>

                       <input id="captcha" name="captcha" type="text" class="yzm" value="验证码" title="不区分大小写！" onclick="value=''"/>

                       </span>

                       <span class="yzm"><img width="82" id="captcha_img" onclick="refresh_captcha();" height="36" alt="点击刷新验证码" src="<?php echo base_url('data/captcha').'/'.$time.'.jpg'?>" /></span>

                       </li>

                       <li><input id="loginsubmit"  type="submit" class="delu" value="" /></li>

                    </ul>

                 </div>              

              </form>  

              </div>

         </div>

         <div class="yw">

            <ul>

               <li><?php echo htmlspecialchars_decode(CFG_POWERBY);?></li>

            </ul>

         </div>

     </div>

</div>

<script>

$(function(){

$("#loginsubmit").click(function(){

    var username = $.trim($("#username").val());

    var password = $.trim($("#password").val());

    var captcha = $.trim($("#captcha").val());

        

    if(username == '' || username == '用户名'){

        alert('请填写用户名');

        $('#username').focus();

        $("#username").val('');

        return false;   

    }



    if(password == '' || password == '密码'){

        alert('密码必填哟！');

        $('#password').focus();

        $("#password").val('');

        return false;

    }   



    if(captcha == '' || captcha == '验证码'){

        alert('为了证明你是人类请填写验证码！');

        $('#captcha').focus();

        $("#captcha").val('');

        return false;

    }

});	

});



function refresh_captcha()

{

	var url = "<?php echo site_url(CFG_ADMINURL.'/login/refresh_captcha')?>?"+Math.random(1); 

	

	$.get(url, function(data){

		var dataObj=eval('('+ data +')'); 

		var picurl = '<?php echo base_url('data/captcha').'/'?>'+dataObj.time+'.jpg';

	    $('#captcha_img').attr('src',picurl);

	});	

}

</script>

</body>

</html>