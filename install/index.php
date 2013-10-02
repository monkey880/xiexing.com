<?php
/**
 * 
 * @ID index.php
 * 住哪联盟酒店分销 x4 在线版 安装程序
 * @date 2013-2-20 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */
header("Content-type:text/html;charset=utf-8");
$system_path = dirname(dirname(__FILE__));
define('BASEPATH', $system_path . DIRECTORY_SEPARATOR);
include BASEPATH.'application/config/constants.php';
include 'install.inc.php';

$_POST['action'] = empty($_POST['action']) ? '' : $_POST['action'];
$_GET['action'] = empty($_GET['action']) ? '' : $_GET['action'];
$action = empty($_GET['action']) ? $_POST['action'] : $_GET['action'];
$step = empty($_GET['step']) ? '1' : (int) $_GET['step'];

$dbhost = empty($_POST['dbhost']) ? '' : $_POST['dbhost'];
$dbuser = empty($_POST['dbuser']) ? '' : $_POST['dbuser'];
$dbpwd = empty($_POST['dbpwd']) ? '' : $_POST['dbpwd'];
$dbname = empty($_POST['dbname']) ? '' : $_POST['dbname'];
$dbprefix = empty($_POST['dbprefix']) ? '' : $_POST['dbprefix'];
    

$lockfile = BASEPATH . 'data/install.lock';
if (file_exists($lockfile)) {
    exit(" 程序已运行安装，如果你确定要重新安装，请先从FTP中删除 install.lock 文件");
}


//查询有多少数据库
if ($action == 'sdname') {
    $rs = get_db_list($dbhost, $dbuser, $dbpwd);
    if ($rs === false)
        exit('errorpwd');
    foreach ($rs AS $k => $v) {
        $json[] = $v;
    }
    $a = json_encode($json);
    exit($a);
}
//检测数据库连接是否正确
elseif ($action == 'chkdname') {
    $conn = @mysql_connect($dbhost, $dbuser, $dbpwd);

    if ($conn === false) {
        exit('0');
    } else {
        exit('1');
    }
}
//创建配置文件
elseif ($action == 'createConfigFile') {
    $info = create_config_file($dbhost, $dbuser, $dbpwd, $dbname,$dbprefix);
    $json['rs'] = $info['rs'];
    $json['info'] = $info['msg'];
    $jsons = json_encode($json);
    exit($jsons);
    die;
}
//初始化数据库
elseif ($action == 'createDatabase') {
    global $errinfo;
    $rs = create_database($dbhost, $dbuser, $dbpwd, $dbname);
    if ($rs) {
        $rs = 1;
        $info = '数据库创建';
    } else {
        $rs = 0;
        $info = $errinfo;
    }

    $json['rs'] = $rs;
    $json['info'] = $info;
    $jsons = json_encode($json);
    exit($jsons);
    die;
}
//安装表节构
elseif ($action == 'installBaseData') {
	$conn = mysql_connect($dbhost,$dbuser,$dbpwd);
    if(!$conn) {
            $error = '数据库连接失败';
    }else{
        if(mysql_select_db($dbname,$conn)){
            mysql_query("set names utf8");
            $sql = file_get_contents('./db/install.sql');
            $sql = Rpdbprefix($sql);
            $sqlarr = explode(";\n",$sql);
            foreach($sqlarr as $query){
                mysql_query($query,$conn);
            }  
        }       
    }
	$json['rs'] = 1;
	$json['msg'] = '数据库安装完成!';
	$jsons = json_encode($json);
	exit($jsons);    
}





/* ------------------------
  环境测试
  function _1_TestEnv()
  ------------------------ */
if ($step == 1) {
    $phpv = phpversion();
    $sp_os = @getenv('OS');
    $sp_gd = gdversion();
    $sp_server = $_SERVER['SERVER_SOFTWARE'];
    $sp_host = (empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_HOST'] : $_SERVER['REMOTE_ADDR']);
    $sp_name = $_SERVER['SERVER_NAME'];
    $sp_max_execution_time = ini_get('max_execution_time');
    $sp_allow_reference = (ini_get('allow_call_time_pass_reference') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
    $sp_allow_url_fopen = (ini_get('allow_url_fopen') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
    $sp_safe_mode = (ini_get('safe_mode') ? '<font color=red>[×]On</font>' : '<font color=green>[√]Off</font>');
    $sp_gd = ($sp_gd > 0 ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
    $sp_mysql = (function_exists('mysql_connect') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');

    if ($sp_mysql == '<font color=red>[×]Off</font>') {
        $sp_mysql_err = true;
    } else {
        $sp_mysql_err = false;
    }

    $sp_testdirs = array(
        '/*',
        'application/*',
        'data/*',
        'install/*',
        'public/*',
        'system/*',
        'templates/*'
    );
    include('./templates/step-1.html');
    exit();
}
/* ------------------------
  数据库测试安装
  function _2_TestEnv()
  ------------------------ */ 
else if ($step == 2) {
    if (empty($_SERVER['HTTP_HOST'])) {
        $baseurl = 'http://' . $_SERVER['HTTP_HOST'];
    } else {
        $baseurl = "http://" . $_SERVER['SERVER_NAME'];
    }

    include('./templates/step-2.html');
    exit();
}

/* ------------------------
  普通安装
  function _3_Setup()
  ------------------------ */ 
else if ($step == 3) {
    include('./templates/step-3.html');
    exit();
}

/* ------------------------
  保存安装数据
  function _4_Setup()
  ------------------------ */ 
else if ($step == 4) {
    
    if (empty($_POST['agent_id'])) {
        redirect('请填写联盟ID！');
    }
    if (empty($_POST['agent_md'])) {
        redirect('请填写联盟加密字符串！');
    }
    if (empty($_POST['agent_postmd'])) {
        redirect('请填写订单保存KEY！');
    }
    if (empty($_POST['cfg_webname'])) {
        redirect('请填写设置网站名称！');
    }
    if (empty($_POST['cfg_indexurl'])) {
        redirect('请填写网站域名！');
    }
    if (empty($_POST['cfg_adminurl'])) {
        redirect('请填写网站后台地址！');
    }    
    if (empty($_POST['username'])) {
        redirect('请填写用户名！');
    }
    if (empty($_POST['password'])) {
        redirect('请填写密码！');
    }
    $agent_id = trim(intval($_POST['agent_id']));
    $agent_md = trim($_POST['agent_md']);
    $agent_postmd = trim($_POST['agent_postmd']);
    $cfg_webname = trim($_POST['cfg_webname']);
    $cfg_indexurl = trim($_POST['cfg_indexurl']);
    $cfg_indexurl = rtrim($_POST['cfg_indexurl'], '/');
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $adminfoder = trim($_POST['cfg_adminurl']);
    $adminurl = $cfg_indexurl.'/'.$adminfoder.'/login';
    if (!checkAgent($agent_id, $agent_md,$cfg_webname)) {
        echo('联盟ID或加密字符串不正确！');
    }

    //开始插入config
    $rs = saveConfig($agent_id, $agent_md, $agent_postmd, $cfg_webname, $cfg_indexurl);

    if (!$rs) {
        echo ('保存不成功,请重试！');
        die;
    }

    $rs = saveAdmin($username, $password, $agent_id);
    if (!$rs) {
        echo ('账号密码信息保存失败,请重试！');
    }
    ReWriteConfig($adminfoder,$cfg_indexurl);
    $rs_write = writeInstallLock();
    if ($rs_write) {
        include('./templates/step-4.html');
    } else {
        echo('安装出错了,请重试');
    }
    exit();
}
?>
