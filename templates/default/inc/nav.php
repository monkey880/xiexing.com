
<div class="nav-area">
  <div class="nav-container" id="nav">
    <div class="shadow"></div>
    <div alog-group="tuan-nav-navbar" alog-alias="tuan-nav-navbar" mon="type=mainnav&amp;action=click" class="navbar clearfix">
    <div class="nav">
  <div class="nav_main">
    <div class="navcon">
      <ul>
        <li <?php if ($method == 'index') {?>class="current"<?php }?>><a href="<?php echo base_url();?>">酒店预订</a></li>
        <li <?php if ($method == 'lable') {?>class="current"<?php }?>><a href="<?php echo site_url('lable')?>">城市地标</a></li>
        <li <?php if ($method == 'tuangou') {?>class="current"<?php }?>><span class="popman"><span class="bg bg_l"></span><span class="bg bg_r"></span><span class="pop_txt">新</span></span><a href="<?php echo site_url('tuangou')?>">团购</a></li>
        <li <?php if ($method == 'ehc') {?>class="current"<?php }?>><a href="<?php echo site_url('ehc')?>">会馆/展馆</a></li>
        <li <?php if ($method == 'expo') {?>class="current"<?php }?>><a href="<?php echo site_url('expo')?>">展会频道</a></li>
        <li <?php if ($method == 'shizhu') {?>class="current"<?php }?>><span class="popman"><span class="bg bg_l"></span><span class="bg bg_r"></span><span class="pop_txt">新</span></span><a href="<?php echo site_url('freeroom/shizhu')?>">试住中心</a></li>
        <li <?php if ($method == 'gift') {?>class="current"<?php }?>><span class="popman"><span class="bg bg_l"></span><span class="bg bg_r"></span><span class="pop_txt">热</span></span><a href="<?php echo site_url('gift')?>">免费礼品</a></li>
      </ul>
      <?php $this->load->library('session');
	$userinfo = $this->session->userdata('xexinguserinfo');
	$userinfo=$this->model_member->get_userinfo($userinfo['id'],2); ?>
      <div method="dvAccount" class="account">
        <div method="myaccount" class="box"> <span method="myaccount" class="name"><a  class="myacclink" href="/?/member"  <?php if($method==''){echo 'id="user_curr"';}?>> 会员中心</a></span> 
          <!--弹出-->
          <div style="z-index: 4500" class="pt links none" id="myaccbox">
            <ul>
              <li><a href="/?/member/myorder" <?php if($method=='myorder'){echo 'id="user_curr"';}?>>酒店订单</a></li>
              <li><a href="/?/member/freeroomorder/1" <?php if($method=='freeroomorder'){echo 'id="user_curr"';}?>>试住订单</a></li>
              <li><a href="/?/member/freeroomorder/2" <?php if($method=='freeroomorder'){echo 'id="user_curr"';}?>>我的订七送一</a></li>
              <li><a href="/?/member/freeroomorder/3" <?php if($method=='freeroomorder'){echo 'id="user_curr"';}?>>我的订六送一</a></li>
              <li><a href="/?/member/myfanxian" <?php if($method=='myfanxian'){echo 'id="user_curr"';}?>>我的返现</a></li>
              <li><a href="/?/member/mygift" <?php if($method=='mygift'){echo 'id="user_curr"';}?>>我的礼品</a></li>
              <li><a href="/?/member/myexp" <?php if($method=='myexp'){echo 'id="user_curr"';}?>>我的积分</a></li>
              <li><a href="/member/modifypassword">个人设置</a></li>
              <?php if($userinfo){ ?>
              <li><a href="/user/loginout">退出</a></li>
              <?php }?>
            </ul>
          </div>
          <!--弹出 end--> 
        </div>
        <?php 
	
	
	if($userinfo){
	?>
        <div style="display:block" method="reg" class="box"> <span class="name normal">欢迎您，
          <?php  if($userinfo['user_name']){ echo $userinfo['user_name'];} else {echo $userinfo['mobile_phone'];}?>
          </span></div>
        <?php } else {?>
        <div style="display:block" method="reg" class="box"> <span class="name normal"><a rel="nofollow" title="快速预订并享受积分回赠" href="/user/regedit">免费注册</a></span></div>
        <div  method="mylogin" class="box" style="z-index:6000" > <span method="mylogin" class="log"><a class="login_a"  href="/user">登录</a></span>
          <div style="display: none;" class="loginbox" id="loginbox">
            <form action="/user/login" method="post">
              <div class="logon" method="dvlogin">
                <ol>
                  <li class="clx">
                    <label>手机：</label>
                    <input type="text" class="login_text" value="" id="zn_nav_user_name" autocomplete="off" name="username">
                  </li>
                  <li class="clx">
                    <label>密码：</label>
                    <input type="password" id="zn_nav_password" value="" name="password" class="login_text">
                  </li>
                  <li style="display:none;" class="clx zn_verify_box nav_verify_box">
                    <label></label>
                    <input type="input" id="zn_nav_verify" value="" name="verify" class="login_text head_yz_input">
                    <img align="absmiddle" class="head_yz_tip" id="zn_nav_verify_img" src="http://tp1.znimg.com/v5/images/blank.gif"><a class="regist_yzm_ts1 head_yz_but" href="#" title="看不清楚点击更换"></a>
                    <div class="clear_1"></div>
                  </li>
                  <li class="clx" style=" height:80px"><a href="/user/cardlogin" class="forget">会员卡登录</a><a href="/user/lostpassword" class="forget">忘记密码</a><a href="/user/regedit" class="">注册账号</a>
                    <input name="" type="submit" class="login_put" value="提交" method="login">
                    <input type="checkbox" style="display: none;" class="checkbox zn_nav_expires" id="expires" name="expires">
                  </li>
                  <!-- <li class="clx1">使用合作网站账号登录</li>
                <li style="margin-bottom:5px;" class="l_share"><a class="sina_share" onclick="zn_member.login.oAuthTemp('WEIBOSN',this,'self');" href="javascript:;" title="新浪微博登录">新浪微博登录</a><a class=" qq_share " onclick="zn_member.login.oAuthTemp('QQ',this,'self');" href="javascript:;" title="QQ登录">QQ登录</a><a class="rr_share" onclick="zn_member.login.oAuthTemp('RENREN',this,'self');" href="javascript:;" title="人人网登录">人人网登录</a><a class=" kj_share" onclick="zn_member.login.oAuthTemp('WEIBOTX',this,'self');" href="javascript:;" title="腾讯微博登录">腾讯微博登录</a><a class="login_ico_alipay" onclick="zn_member.login.oAuthTemp('ALIPAY',this,'self');" href="javascript:;" title="支付宝登录">支付宝登录</a>
                  <div class="clear_1"></div>
                </li>-->
                  <div class="clear_1"></div>
                </ol>
                <div class="clear_1"></div>
              </div>
            </form>
          </div>
        </div>
        <?php }?>
        <!--弹出--> 
        <!--登录前 end--> 
      </div>
    </div>
  </div>
</div>
    
    
    </div>
    
  </div>
</div>


<script type="text/javascript">
$('.login_a').parent('span').parent('div').hover(function(){
				$(this).children('span').addClass('on2');
				$('#loginbox').show();
			},function(){
				$(this).children('span').removeClass('on2');
				$('#loginbox').hide();
			});
$('.myacclink').parent('span').parent('div').hover(function(){
				$(this).children('span').addClass('on');
				$('#myaccbox').show();
			},function(){
				$(this).children('span').removeClass('on');
				$('#myaccbox').hide();
			});
			
</script> 