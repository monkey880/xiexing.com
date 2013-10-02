<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


//-------------------------------zhuna begin
define('ZHUNA_SOFT_VERSION','20130603');
define('ZHUNA_SOFT_NAME','携行网酒店联盟分销程序');
define('ZHUNA_SOFT_ENAME','ZhunaCMS X4');
define('ZHUNA_SOFT_TEAM','携行网联盟技术组PHP版本团队');
define('ZHUNA_ORDER_API','http://www.api.zhuna.cn/');
define('ZHUNA_PICTURE_API','http://tp1.znimg.com');
define('ZHUNA_SOFT_DBPREFIX','zhuna_');//接口url

include 'zhuna_config.php';

define('CFG_INTERFACE_API','http://open.zhuna.cn/api/gateway.php?agent_id='.CFG_AGENTID.'&agent_md='.CFG_AGENTMD.'&method=');//接口url


/* End of file constants.php */
/* Location: ./application/config/constants.php */