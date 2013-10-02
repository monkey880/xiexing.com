  <div class="user_nav">
    <ul>
     <li><a href="/?/member"  <?php if($method==''){echo 'id="user_curr"';}?>>会员中心</a></li>
      <li><a href="/?/member/myorder" <?php if($method=='myorder'){echo 'id="user_curr"';}?>>酒店订单</a></li>
      <li><a href="/?/member/freeroomorder" <?php if($method=='freeroomorder'){echo 'id="user_curr"';}?>>免费房订单</a></li>
      <li><a href="/?/member/mygift" <?php if($method=='mygift'){echo 'id="user_curr"';}?>>我的礼品</a></li>
      <li><a href="/?/member/myfanxian" <?php if($method=='myfanxian'){echo 'id="user_curr"';}?>>我的返现</a></li>
      <li><a href="/?/member/myexp" <?php if($method=='myexp'){echo 'id="user_curr"';}?>>我的积分</a></li>
      <li><a href="/?/member/mycomment" <?php if($method=='mycomment'){echo 'id="user_curr"';}?>>我的点评</a></li>
     
      <li><a href="/member/modifypassword">修改密码</a></li>
      <li><a href="/user/loginout">退出系统</a></li>
    </ul>
  </div>