<?php

/**
 * 
 * @ID MY_Loader.php
 * 加载配置文件，修改默认模板路径
 * @date 2013-1-23 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */


class MY_Loader extends CI_Loader {
	function __construct()
	{
		parent::__construct();
		$ci = & get_instance();
		$config = $ci->config;
		$templets_dir = $config->config['templets_dir'];
		//TODO 目前为一个模板方便扩展
        $path = str_replace("\\", "/", FCPATH);
        $this->_ci_view_paths = array($path.'templates/'.$templets_dir.'/' => TRUE);
        		
	}
	
}
