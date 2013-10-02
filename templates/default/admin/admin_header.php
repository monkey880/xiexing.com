    <div class="header">

      <span class="right"><input name="loginout" onclick="window.location.href='<?php echo site_url(CFG_ADMINURL.'/login/loginout')?>'" type="button" class="login_out" value="退出登录"/></span><span class="left"><img src="<?php echo base_url();?>public/admin/default/images/bg_ziji.jpg"  /></span>
    </div>

    <div class="nav">

       <ul>

          <li><a href="<?php echo CFG_INDEXURL?>" target="_blank">网站首页</a></li>

          <li><a href="<?php echo site_url(CFG_ADMINURL.'/main');?>">管理首页</a></li>

          <li><a href="http://union.zhuna.cn" target="_blank">合作</a></li>

<!--          <li><a href="<?php echo site_url(CFG_ADMINURL.'/cache');?>">清理硬盘缓存</a></li>
-->
          <li><a href="<?php echo site_url(CFG_ADMINURL.'/help');?>">快捷导航</a></li>

       </ul>

       <span class="f_left">尊敬的&nbsp;<font class="f_b_f00"><?php echo $username?></font>&nbsp;现在的时间为<?php echo date('Y年m月d日 H:i:s')?></span>

    </div>

    <script>var base_url = "<?php echo base_url();?>";</script>