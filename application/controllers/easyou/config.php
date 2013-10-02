<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID config.php
 * 携行酒店分销联盟（后台系统配置参数）模块
 * @date 2013-3-7 
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */
 
class Config extends CI_Controller
{

    private $userinfo;
    private $tablefunc = 'config';
	
    function __construct ()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_sysconfig');
        $this->load->model('model_city');
        $this->load->helper('form');
        $this->load->model('model_admin');
    }

    /**
     * 后台系统配置 首页
     */
    public function index()
    {
        $data = array();
        
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;
        $data['operate'] = array('isedit'=>$isedit);
        
        $config = $this->model_sysconfig->getConfigList();
        
        $data['method'] = $this->uri->segment(2) ;      
        $data['config'] = $config ; 
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_config',$data);
    }
    
    /**
     * 后台系统配置调用城市ajax方法
     */
    public function getCity()
    {
        $pid = intval($_GET['pid']);
        $cityArr = $this->model_city->getCityByPid($pid);   
        echo $cityArr = json_encode($cityArr); 
    }

    
    /**
     * @author zhaojianjun
     * 保存网站配置
     */
    public function save_config()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        
    	$_POST["cfg_statcode"]=str_replace("'", '"', stripcslashes($_POST["cfg_statcode"]));
    	$post = $_POST;
        $post['cfg_rewrite'] = 1; 
    	
    	if(count($_POST) < 4) show_error('请不要非法操作');
    	//参数白名单
    	$allow_args = array('cfg_cmspath','cfg_indexurl','cfg_webname','cfg_powerby', 'cfg_state', 'cfg_state_reason','cfg_templets_style','cfg_templets_layout'
				    ,'cfg_agentid', 'cfg_agentmd','cfg_key', 'cfg_rewrite', 'cfg_statcode','cfg_indexCitylist','cfg_cache','cfg_admin_mobile','cfg_admin_email','cfg_sms_kaiguan');

        				    
		//逐个保存配置	
        $constants = ROOTPATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'zhuna_config.php';
        if(!is_really_writable($constants)){
        	show_error($constants.'不可写请检查目录权限');
        }
        $fp = fopen($constants, 'w+');
        flock($fp, 3);
        fwrite($fp, "<" . "?php\r\n");     				    
	    foreach ($post as $key => $value) {
	    	if(in_array($key,$allow_args)){
	    		$info = array('value' => htmlspecialchars($post[$key])) ;
	    		$where = array('varname' => $key) ;
	    		$this->model_sysconfig->saveConfig('update',$info,$where);
	    		//生成配置文件
                fwrite($fp, "define('".strtoupper($key)."','".$value."');\r\n");
	    	}
	    }
	    fwrite($fp, "define('CFG_ADMINURL','".CFG_ADMINURL."');\r\n");
	    fclose($fp); 

	        
        $alertMsg = '修改成功';
        $redirectUrl = site_url('/'.CFG_ADMINURL.'/config/index');
        echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';	
        die;    
	    
	     
    }

}