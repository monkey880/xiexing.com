       <div class="nav">

           <div class="nav_main">

              <ul>

                 <li <?php if ($method == 'index') {?>class="current"<?php }?>><a href="<?php echo base_url();?>">酒店预订</a></li>

                 

                 <li <?php if ($method == 'lable') {?>class="current"<?php }?>><a href="<?php echo site_url('lable')?>">城市地标</a></li>
                  <li class="nav_line"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/nav_line.jpg" width="cityinfo" height="40" /></li>

                 <li <?php if ($method == 'freeroom') {?>class="current"<?php }?>><span class="popman"><span class="bg bg_l"></span><span class="bg bg_r"></span><span class="pop_txt">新</span></span><a href="<?php echo site_url('freeroom')?>">订七送一</a></li>

                 <li class="nav_line"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/nav_line.jpg" width="cityinfo" height="40" /></li>


                

                 <li <?php if ($method == 'ehc') {?>class="current"<?php }?>><a href="<?php echo site_url('ehc')?>">会馆/展馆</a></li>

                 <li class="nav_line"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/nav_line.jpg" width="cityinfo" height="40" /></li>

                 <li <?php if ($method == 'expo') {?>class="current"<?php }?>><a href="<?php echo site_url('expo')?>">展会频道</a></li>

                 <li class="nav_line"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/nav_line.jpg" width="cityinfo" height="40" /></li>

              <li <?php if ($method == 'shizhu') {?>class="current"<?php }?>><span class="popman"><span class="bg bg_l"></span><span class="bg bg_r"></span><span class="pop_txt">新</span></span><a href="<?php echo site_url('freeroom/shizhu')?>">试住中心</a></li>

                 <li class="nav_line"><img src="<?php echo base_url();?>public/www/<?php echo CFG_TEMPLETS_STYLE;?>/images/nav_line.jpg" width="cityinfo" height="40" /></li>    
  <li <?php if ($method == 'gift') {?>class="current"<?php }?>><span class="popman"><span class="bg bg_l"></span><span class="bg bg_r"></span><span class="pop_txt">热</span></span><a href="<?php echo site_url('gift')?>">免费礼品</a></li>
                

                 

              </ul>

            </div>

       </div>