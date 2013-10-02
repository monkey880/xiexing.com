        <div class="box_left">

            <div class="b_l_top"></div>

            <div class="b_l_bottom">

                <dl>

                   <?php

                   	$method = isset($method) ? $method : '';

                   ?>
                     <dt class="bottom">酒店管理</dt>

                   <dd <?php if ($method == 'hotel') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/hotel')?>">酒店管理</a></dd>
                   <dd <?php if ($method == 'hotel') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/hotel/baidu_lbs_list')?>">百度LBS</a></dd>
                   

                   <dd <?php if ($method == 'freeroom') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/freeroom')?>">试住管理</a></dd>
				    <dd <?php if ($method == 'product') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/product')?>">礼品管理</a></dd>

             
                    <dt class="bottom">订单管理</dt>
					<dd <?php if ($method == 'order') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/hotel/order')?>">酒店订单</a></dd>
                   <dd <?php if ($method == 'productorder') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/product/order')?>">礼品订单</a></dd>
					<dd <?php if ($method == 'jiangjin') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/hotel/jiangjin_list')?>">返现记录</a></dd>
                    <dd <?php if ($method == 'tixian') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/hotel/tixian_list')?>">提现记录</a></dd>
                    
                    
                        <dt class="bottom">团购管理</dt>

                   <dd <?php if ($method == 'tuan') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/tuan')?>">团购管理</a></dd>
                   
                   


                 <dt class="bottom">会员管理</dt>
                   
                    <dd <?php if ($method == 'member') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/member')?>">会员管理</a></dd>

                   <dd <?php if ($method == 'manager') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/manager')?>">管理员管理</a></dd>

                   <dd <?php if ($method == 'purview') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/purview')?>">权限菜单</a></dd>

                   <dd <?php if ($method == 'usergroup') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/usergroup')?>">用户组</a></dd>

					 <dd <?php if ($method == 'cards') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/cards')?>">会员卡管理</a></dd>	
                   <dt class="bottom">内容管理</dt>

                   <dd <?php if ($method == 'news') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/news')?>">资讯管理</a></dd>

                   <dd <?php if ($method == 'newsclass') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/newsclass')?>">资讯分类</a></dd>

                   <dd <?php if ($method == 'flink') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/flink')?>">友情链接</a></dd>

                   <dd <?php if ($method == 'ad') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/ad')?>">广告管理</a></dd>

                   <dt class="bottom">网站管理</dt>

                   <dd <?php if ($method == 'config') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/config')?>">网站设置</a></dd>

                   <dd <?php if ($method == 'keywords') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/keywords')?>">页面关键字管理</a></dd>

                   <dd <?php if ($method == 'data') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/data')?>">数据备份</a></dd>

                   <dd <?php if ($method == 'revert') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/data/revert')?>">数据还原</a></dd>

                   
                   <dt class="bottom">页面定制</dt>

                   <dd <?php if ($method == 'templates') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/templates')?>">页面管理</a></dd>

                   <dd <?php if ($method == 'rewrite') {?> class="current" <?php }?>><a href="<?php echo site_url(CFG_ADMINURL.'/rewrite')?>">伪静态设置</a></dd>

                </dl>

            </div>

        </div>