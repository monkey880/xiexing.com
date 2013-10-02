<?php

/**
 * 
 * @ID install.inc.php
 * 住哪联盟安装程序 函数库
 * @date 2013-2-21 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */






/**
 * 获取gd版本
 * @return string|number|number
 */
function gdversion()
{
    //没启用php.ini函数的情况下如果有GD默认视作2.0以上版本
    if (!function_exists('phpinfo')) {
        if (function_exists('imagecreate'))
            return '2.0';
        else
            return 0;
    }
    else {
        ob_start();
        phpinfo(8);
        $module_info = ob_get_contents();
        ob_end_clean();
        if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info, $matches)) {
            $gdversion_h = $matches[1];
        } else {
            $gdversion_h = 0;
        }
        return $gdversion_h;
    }
}

/**
 * 检测目录是否可写
 * @param string $d 目录
 * @return bool 
 */
function TestWrite($d)
{
    $tfile = '_dedet.txt';
    $d = preg_replace('/\/$/', '', $d);
    $fp = @fopen($d . '/' . $tfile, 'w');
    if (!$fp)
        return false;
    else {
        fclose($fp);
        $rs = @unlink($d . '/' . $tfile);
        if ($rs)
            return true;
        else
            return false;
    }
}

/**
 * 获得数据库列表
 *
 * @access  public
 * @param   string      $db_host        主机
 * @param   string      $db_port        端口号
 * @param   string      $db_user        用户名
 * @param   string      $db_pass        密码
 * @return  mixed       成功返回数据库列表组成的数组，失败返回false
 */
function get_db_list($db_host, $db_user, $db_pass)
{
    $databases = array();
    $filter_dbs = array('information_schema', 'mysql');
    $conn = @mysql_connect($db_host, $db_user, $db_pass);

    if ($conn === false) {
        return false;
    }

    $result = mysql_query('SHOW DATABASES', $conn);
    if ($result !== false) {
        while (($row = mysql_fetch_assoc($result)) !== false) {
            if (in_array($row['Database'], $filter_dbs)) {
                continue;
            }
            $databases[] = $row['Database'];
        }
    } else {
        $err->add($_LANG['query_failed']);
        return false;
    }
    @mysql_close($conn);

    return $databases;
}


/**
 * 修改ci配置文件
 * @param string $db_host 数据库地址
 * @param string $db_user 数据库用户名
 * @param string $db_pass 数据库密码
 * @param unknown_type $db_name 数据库名称 
 * @return string
 */
function create_config_file($db_host,$db_user,$db_pass,$db_name,$dbprefix)
{

    $dataconfig = BASEPATH . 'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
    // 确定database.config.php文件存在并且可写
    if (is_writable($dataconfig)) {
        $str = file_get_contents($dataconfig);
        $str = str_replace('$db[\'default\'][\'hostname\'] = \'localhost\';','$db[\'default\'][\'hostname\'] = \''.$db_host.'\';',$str);
        $str = str_replace('$db[\'default\'][\'username\'] = \'root\';','$db[\'default\'][\'username\'] = \''.$db_user.'\';',$str);
        $str = str_replace('$db[\'default\'][\'password\'] = \'root\';','$db[\'default\'][\'password\'] = \''.$db_pass.'\';',$str);
        $str = str_replace('$db[\'default\'][\'database\'] = \'x4\';','$db[\'default\'][\'database\'] = \''.$db_name.'\';',$str);   
        $str = str_replace('$db[\'default\'][\'dbprefix\'] = \'x4_\';','$db[\'default\'][\'dbprefix\'] = \''.$dbprefix.'\';',$str);   
         
        file_put_contents($dataconfig,$str);   
        $msg = "数据库配置文件已成功创建";
        $rs = '1';        
    } else {
        $msg = "配置文件  $dataconfig 不可写,请赋其可写权限";
        $rs = '0';
    }    
    $write_info['msg'] = $msg;
    $write_info['rs'] = $rs;
    return $write_info;
    exit();
}

/**
 * 创建指定名字的数据库
 *
 * @access  public
 * @param   string      $db_host        主机
 * @param   string      $db_port        端口号
 * @param   string      $db_user        用户名
 * @param   string      $db_pass        密码
 * @param   string      $db_name        数据库名
 * @return  boolean     成功返回true，失败返回false
 */
function create_database($db_host, $db_user, $db_pass, $db_name )
{
    global $errinfo;
    $conn = mysql_connect($db_host, $db_user, $db_pass);

    if ($conn === false) {
        $errinfo = '连接 数据库失败，请检查您输入的 数据库帐号 是否正确。';
        return false;
    }

    $mysql_version = mysql_get_server_info($conn);
    keep_right_conn($conn, $mysql_version);
    if (mysql_select_db($db_name, $conn) === false) {
        $sql = "CREATE DATABASE $db_name";
        if (mysql_query($sql, $conn) === false) {
            $errinfo = '无法创建数据库';
            return false;
        }
    }
    @mysql_close($conn);

    return true;
}

/**
 * 保证进行正确的数据库连接（如字符集设置）
 *
 * @access  public
 * @param   string      $conn                      数据库连接
 * @param   string      $mysql_version        mysql版本号
 * @return  void
 */
function keep_right_conn($conn, $mysql_version='')
{
    if ($mysql_version === '') {
        $mysql_version = mysql_get_server_info($conn);
    }

    if ($mysql_version >= '4.1') {
        mysql_query('SET character_set_connection = utf8, character_set_results = utf8, character_set_client=binary', $conn);

        if ($mysql_version > '5.0.1') {
            mysql_query("SET sql_mode=''", $conn);
        }
    }
}




/**
 * 检测住哪联盟uid和mid的
 * @param <type> $agent_id
 * @param <type> $agent_md
 * @return <type>
 */
function checkAgent($agent_id, $agent_md,$cfg_webname='')
{
    $host = $_SERVER['HTTP_HOST'];
    $ver = ZHUNA_SOFT_VERSION;
    $apiUrl = "http://m.api.zhuna.cn/count/setup.php?v=x4&var=$ver&uid=$agent_id&mk=$agent_md&host=$host&title=$cfg_webname";
    $dom = new DomDocument;
    $dom_load = $dom->load($apiUrl);
    $rs = $dom->getElementsByTagName('result');
    $rs = $rs->item(0)->nodeValue;
    $insertUrl = "http://union.api.zhuna.cn/index.php?m=count.setup&v=x4&var=$ver&uid=$agent_id&mk=$agent_md&host=$host";
    $insert_result = file_get_contents($insertUrl);
    $open_api = file_get_contents("http://w.api.zhuna.cn/utf-8/open.union.user.add.php?userid=$agent_id");
    if ($rs == 0 && $insert_result == 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * 更新后台一些配置文件
 * @global  $db
 * @param <type> $agent_id
 * @param <type> $agent_md
 * @param <type> $agent_postmd
 * @param <type> $cfg_webname
 * @param <type> $cfg_indexurl
 * @return <type>
 */
function saveConfig($agent_id, $agent_md, $agent_postmd, $cfg_webname, $cfg_indexurl)
{
    include BASEPATH . 'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
    mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']) or
    die("Could not connect: " . mysql_error());
    $prefix = $db['default']['dbprefix'];
    mysql_select_db($db['default']['database']);
    mysql_query("set names utf8");
    $result = mysql_query("update {$prefix}sysconfig set `value`='$cfg_indexurl' where varname = 'cfg_indexurl' ");
		      mysql_query("update {$prefix}sysconfig set `value`='$cfg_webname' where varname = 'cfg_webname' ");    
		      mysql_query("update {$prefix}sysconfig set `value`='$agent_id' where varname = 'cfg_agentid' ");    
		      mysql_query("update {$prefix}sysconfig set `value`='$agent_md' where varname = 'cfg_agentmd' ");    
		      mysql_query("update {$prefix}sysconfig set `value`='$agent_postmd' where varname = 'cfg_key' ");    
    if ($result) {
        return true;
    } else {
        return false;
    }    
}

/**
 * 更新账号和密码信息
 * @global <type> $db
 * @param <type> $username
 * @param <type> $password
 * @param <type> $agent_md
 * @return <type>
 */
function saveAdmin($username, $password, $agent_id)
{
	$password = md5(md5($password.$agent_id));
	include BASEPATH . 'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
    mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']) or
    die("Could not connect: " . mysql_error());
    $prefix = $db['default']['dbprefix'];
    mysql_select_db($db['default']['database']);
    mysql_query("set names utf8");
    $result = mysql_query("update {$prefix}admin set username='$username',password='$password' where id = 1 ");
    if ($result) {
        return true;
    } else {
        return false;
    }
}

/**
 * 写静态配置文件config.cache.php
 */
function ReWriteConfig($admin_folder="admin",$site_url)
{
	
	$config_path = BASEPATH . 'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
	$constants_path = BASEPATH . 'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'zhuna_config.php';
	
    if (!is_writeable($config_path) || !is_writeable($constants_path)) {
        echo "配置文件'{$config_path},{$constants_path}'不支持写入，无法修改系统配置参数！";
        exit();
    }

    
    $configstr = file_get_contents($config_path);
    $configstr = str_replace('http://dev.x4.cn',$site_url,$configstr);
    file_put_contents($config_path,$configstr);
    
    $default_admin = BASEPATH.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'admin';
    $new_admin = BASEPATH.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$admin_folder;
    
    @rename($default_admin,$new_admin);	
    
    //读取常用信息写到常量中
    include BASEPATH . 'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
    mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']) or
    die("Could not connect: " . mysql_error());
    $prefix = $db['default']['dbprefix'];
    mysql_select_db($db['default']['database']);
    mysql_query("set names utf8");
    $result = mysql_query("SELECT varname,`value` FROM {$prefix}sysconfig");

    $fp = fopen($constants_path, 'w+');
    fwrite($fp, "<" . "?php\r\n");     
    flock($fp, 3);
    while($configlist = mysql_fetch_array($result, MYSQL_ASSOC)){
    	$getconfig[] = $configlist ;
    }
    fwrite($fp, "\r\n");
    //生成住哪配置文件
    foreach ($getconfig as $k => $v) {
        fwrite($fp, "define('".strtoupper($v['varname'])."','".$v['value']."');\r\n");
    }
    fwrite($fp, "define('CFG_ADMINURL','".$admin_folder."');\r\n");
    fclose($fp);
    
}

/**
 * 安装成功写install.lock
 */
function writeInstallLock()
{
    /* 写入安装锁定文件 */
    $fp = fopen(BASEPATH . 'data/install.lock', 'wb+');
    if (!$fp) {
        redirect('打开install.lock文件失败,请检查是否有文件读写权限');
        return false;
    }
    if (!@fwrite($fp, "TRADE SHOP INSTALLED")) {
        redirect('写入install.lock文件失败,请检查是否有文件读写权限');
        return false;
    }
    @fclose($fp);
    return true;
}


/**
 * ajax提交时用于查看错误信息
 * @param unknown_type $info
 */
function debugAjax($info)
{
    $file_info = var_export($info, true);
    $ok = file_put_contents("./file_info.txt", $file_info);
    if ($ok)
        exit('true');
    exit('false');
}


function  Rpdbprefix($sql){
	include BASEPATH . 'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
	$prefix = $db['default']['dbprefix'];
    $prefix_search = array('INSERT INTO `zhuna_', 'CREATE TABLE IF NOT EXISTS `zhuna_', 'DROP TABLE IF EXISTS `zhuna_');
    $prefix_replace = array("INSERT INTO `" . $prefix . "", "CREATE TABLE IF NOT EXISTS `" . $prefix . "", "DROP TABLE IF EXISTS `" . $prefix . "");
    $prefix_sql = str_replace($prefix_search, $prefix_replace, $sql);
    return $prefix_sql;	
}
?>