<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID member.php

 * 携行酒店分销联盟（会员登录页面）模块

 * @date 2013-1-24 

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Member extends CI_Controller 

{

    private $data ;

    

    function __construct()

    {

        parent::__construct();

        $this->data = array();


        $this->load->model('model_common');
		
		$this->load->model('model_config');
		
		$this->load->model('model_member');
		
		$this->load->model('model_hotel');
		
		$this->load->library('sendsms');
		
		$this->load->helper('cookie');
		
		$this->load->library('session');
        $this->load->helper('captcha');
                

    }

    public function index()

	{

  //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        

        $this->data['method'] = $this->uri->segment(0) ;    

		$this->load->view('userlogin',$this->data);

	}
	
	
	public function regedit()

	{

        //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        

        $this->data['method'] = $this->uri->segment(1) ;    

		$this->load->view('regedit',$this->data);

	}
	
	public function login()

	{
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$expires2=$this->input->post('expires2');
		
		$truepassword=md5(md5($password.'qingqing'));
		
		$userinfo=$this->model_member->get_userinfo($username);
		
		if(!isset($userinfo['mobile_phone'])){
            $alertMsg = '此用户不存在';
            $redirectUrl = site_url('/user/login');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';      		
    	}else{
    		if($truepassword === $userinfo['password']){
    			$userdata = array('id'=>$userinfo['user_id'],'username'=>$userinfo['mobile_phone']);
    			$this->session->set_userdata('xexinguserinfo',$userdata);
    			redirect('/member');
    		}else{
	            $alertMsg = '密码错误';
	            $redirectUrl = site_url('/user/login');
	            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';       			
    		}
    	}

        

	}
	
	public function lostpassword()

	{

        //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);
		
		$cap = $this->get_captcha();  
		
        $cap['keywords_array'] = $keywords_array;

        $cap['method'] = $this->uri->segment(1) ;  

		$this->load->view('lostpassword',$cap);

	}
	
	public function lostpassword2()

	{
		$mobile=$this->input->post('username',TRUE);
		$captcha = $this->input->post('captcha');
		
		if( strtolower($captcha) !=  $this->session->userdata('captcha_code')){
            $alertMsg = '验证码错误';
            $redirectUrl = site_url('/member/lostpassword');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;    		
    	}
		
		if($res=$this->model_member->checkmobile($mobile)){
			
			redirect('/member/lostpassword3?mobile='.$mobile);
		}
		else{
			 $alertMsg = '你输入的手机号不存在';
            $redirectUrl = site_url('/member/lostpassword');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;  
		}
		
	}
	
	public function lostpassword3()

	{

        //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);
		
		$cap = $this->get_captcha();  
		
        $cap['keywords_array'] = $keywords_array;

        $cap['method'] = $this->uri->segment(1) ;  
		
		$checkma=random_string('numeric', 4);
		
		$cookie = array('name'=>'checkma','value'=> $checkma,'expire' => '3600');
		$checkma="尊敬的用户，您的验证码是：$checkma , www.xexing.com";
		$mobile=$this->input->get('mobile',TRUE);
		
		$res=$this->sendsms->get_message($mobile,iconv('utf-8','gb2312',$checkma));
	
		$this->input->set_cookie($cookie);
		$cap['mobile']=$mobile;
		$this->load->view('lostpassword3',$cap);

	}
	
	public function lostpassword4()

	{
		$mobile=$this->input->post('mobile',TRUE);
		$password=$this->input->post('password',TRUE);
		$yanma=$this->input->post('yanma',TRUE);
		
		$password=md5(md5($password.'qingqing'));
		
		$checkma=$this->input->cookie($this->config->item('cookie_prefix').'checkma',TRUE);
		if($yanma==$checkma){
		$data=array();
		$data['mobile_phone']=$mobile;
		$data['password']=$password;
		
		$query=$this->model_member->save_userinfo($data,'update');
		
		if($query){
			$alertMsg = '密码已更改';
            $redirectUrl = site_url('member');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
		}
		}
		else{
			$alertMsg = '短信验证码不正确';
            $redirectUrl = site_url('member/lostpassword');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
			
		}
		
		
	}
	
	public function regedit_save()

	{
		$mobile=$this->input->post('mobile',TRUE);
		$password=$this->input->post('password',TRUE);
		$Email=$this->input->post('Email',TRUE);
		
		$password=md5(md5($password.'qingqing'));
		
		$data=array();
		$data['mobile_phone']=$mobile;
		$data['password']=$password;
		$data['email']=$Email;
		$data['reg_time']=time();
		
		$query=$this->model_member->save_userinfo($data);
		
		if($query){
			$alertMsg = '注册已成功';
            $redirectUrl = site_url('member');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
		}

       

	}
	
	public function checkuserinfo(){
		
		$type=$this->input->get('type',TRUE);
		
		
		if($type=='1'){
		$mobile=$this->input->get('mobile',TRUE);
		$res=$this->model_member->checkmobile($mobile);
		echo $res;
		}
	}
	
	public function sendSmsCheck(){
		
		$checkma=random_string('numeric', 4);
		
		$cookie = array('name'=>'checkma','value'=> $checkma,'expire' => '3600');
		$this->input->set_cookie($cookie);
		
		$checkma="尊敬的用户，您的注册验证码是：$checkma ,请输入验证码完成注册。 www.xexing.com";
		$mobile=$this->input->get('mobile',TRUE);
		
		$res=$this->sendsms->get_message($mobile,iconv('utf-8','gb2312',$checkma));
		echo $res;
		
		
		
		
	}
	
	public function checksms(){
		$mobile4=$this->input->get('mobile4',TRUE);
		$checkma=$this->input->cookie($this->config->item('cookie_prefix').'checkma',TRUE);
		if($mobile4==$checkma){
			echo 0;
		}
		else{
			echo 1;
		}
		
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