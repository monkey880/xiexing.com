<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<title>携行网酒店后台管理系统</title>

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

                            <h2>后台管理>>清理文件缓存</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">清理文件缓存</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/cache/del_cache'));?>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx">

                           <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2>清理文件缓存</h2></td>

                            </tr>

                           <tr>

                            <td class="right">缓存文件总数：</td>

                            <td class="left"><?php echo $list['filesize_count'] ?></td>

                           </tr>  

                           <tr>

                            <td class="right">缓存文件所占空间：</td>

                            <td class="left"><?php echo $list['filesize_size'] ?>MB</td>

                           </tr> 

                           <?php $i = 0 ; foreach ($list['cache_array'] AS $k=>$v) { $i++; ?>

                           <tr>

                            <td class="right"><?php if ($i == 1) { ?>缓存文件：<?php } ?></td>

                            <td class="left"><?php echo $k ?> —— 路径：<?php echo $v['dir_dir'] ?>；文件总数：<?php echo $v['dir_count'] ?>；文件总大小：<?php echo $v['dir_size'] ?>MB</td>

                           </tr>

                           <?php } ?>

                          <tr>

                                <td class="right" width="120px"></td>

                                <td>

                                <input type="submit" class="tjzx" value="清&nbsp;理" name="" onclick="">

                                </td>

                            </tr>

                       </table>

                       </form>

                     </td>

                </tr>

            </table>

        </div>

    </div>

<?php $this->load->view('admin/admin_footer');?>

</div>

<script>

    function del_cache(){

        $.post(

            "<?php echo site_url(CFG_ADMINURL.'/cache/del_cache'); ?>",

    		function(result){

    		  if (result == 0) {

    		      alert('好像未删除干净,请重试');    

    		  } else {

    		      alert('清理完成');       

    		  }

            }

        );     

    }



</script>

</body>

</html>