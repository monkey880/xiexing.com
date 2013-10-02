<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<!--选择时间用到的js-->

<script language="javascript">var webpath="<?php echo base_url();?>public/";</script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/Date.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>public/js/calendar/calendar.js"></script>

<title>携行网酒店后台管理系统</title>

<style>

#content{

    width:750px;

}

</style>

</head>

<body>

<div class="container">

    <?php $this->load->view('admin/admin_header');?>

    <div class="box">

        <?php $this->load->view('admin/admin_left');?>

        <div class="box_right">

            <table width="100%" cellpadding="0" cellspacing="0" class="ym_bk">

                <tr>

                    <td><div class="wzdh">

                            <h2>后台管理>>快捷导航</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">快捷导航</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <div class="maincont">

			            	<div class="maincontwrap">

			                    <h1 class="ui-heading1">快捷导航</h1>

			                    <div class="ui-box">

			                        <dl class="ui-list-txt">

			                            <dt class="ui-list-txt-title">内容管理</dt>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/news') ?>">资讯管理</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/newsclass') ?>">资讯分类</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/flink') ?>">友情链接</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/ad') ?>">广告管理</a></dd>

			                        </dl>

			                        <dl class="ui-list-txt">

			                            <dt class="ui-list-txt-title">网站管理</dt>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/config') ?>">网站设置</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/keywords') ?>">页面关键字管理</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/manager') ?>">帐户管理</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/data') ?>">数据备份</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/data/revert') ?>">数据还原</a></dd>

			                        </dl>

			                        <dl class="ui-list-txt">

			                            <dt class="ui-list-txt-title">页面定制</dt>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/templates') ?>">页面管理</a></dd>

			                            <dd class="ui-list-txt-item"><a target="_blank" href="<?php echo site_url(CFG_ADMINURL.'/rewrite') ?>">伪静态设置</a></dd>

			                        </dl>

			                    </div>

			            	</div>

			            </div>

                     </td>

                </tr>

            </table>

        </div>

    </div>

    <?php $this->load->view('admin/admin_footer');?>

</div>

</body>

</html>