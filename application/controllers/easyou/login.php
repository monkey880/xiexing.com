<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID login.php
 * 携行酒店分销联盟（后台登陆）模块
 * @date 2013-2-21 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Login extends CI_Controller 
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->model('model_admin');
        $this->load->helper('form');
    }
    
    public function index()
    {    

		$cap = $this->get_captcha();
		$title = "管理员登陆-".CFG_WEBNAME;
		$cap['title'] = $title;
        $this->load->view('admin/login',$cap);
        
    }
    
    /**
     * 检查登陆
     */
    function chklogin()
    {
    	$username = $this->input->post('username');
    	$password = $this->input->post('password');
    	$captcha = $this->input->post('captcha');
    	$truepassword = md5(md5($password.CFG_AGENTID));
    	
    	if( strtolower($captcha) !=  $this->session->userdata('captcha_code')){
            $alertMsg = '验证码错误';
            $redirectUrl = site_url('/'.CFG_ADMINURL.'/login');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;    		
    	}
    	
    	
    	if(empty($username) || empty($password)){
    		$alertMsg = '请填写用户名和密码后提交';
            $redirectUrl = site_url('/'.CFG_ADMINURL.'/login');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;     		
    	}
    	
    	$userinfo = $this->model_admin->get_userinfo($username);
    	if(!isset($userinfo['username'])){
            $alertMsg = '此用户不存在';
            $redirectUrl = site_url('/'.CFG_ADMINURL.'/login');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';      		
    	}else{
    		if($truepassword === $userinfo['password']){
    			$userdata = array('id'=>$userinfo['id'],'username'=>$userinfo['username']);
    			$this->session->set_userdata('userinfo',$userdata);
				
    			redirect(CFG_ADMINURL.'/main');
    		}else{
	            $alertMsg = '密码错误';
	            $redirectUrl = site_url('/'.CFG_ADMINURL.'/login');
	            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';       			
    		}
    	}
    }
    
     /**
     * 退出登陆
     */
    function loginout()
    {
        $this->session->sess_destroy();
        redirect(CFG_ADMINURL.'/login');
        	
    }
    
     /**
     * 生成验证码
     */    
    function get_captcha()
    {
         $vals=array( 'img_path'=> '/data/captcha/',
                      'img_url'=> '/data/captcha/',
                      'img_width'=>'82',
                      'img_height'=>'36',
                      'expiration'=>60
               );
        
        $cap = create_captcha($vals); 
        $this->session->set_userdata('captcha_code',strtolower($cap['word'])); 
        return $cap ;	
    }
    
    /**
     * 刷新验证码
     */
    public function refresh_captcha()
    {
    	$code = $this->get_captcha();
    	echo json_encode($code);die;
    }
}