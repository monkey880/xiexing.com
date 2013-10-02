<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID member.php

 * 住哪酒店分销联盟（会员登录页面）模块

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
		
		$this->load->library('session');

        if(!$this->session->userdata('xexinguserinfo')){

        	redirect('/user');

        }
		
		$this->userinfo = $this->session->userdata('xexinguserinfo');
		
		

        $this->data = array();


        $this->load->model('model_common');
		
		$this->load->model('model_config');
		
		$this->load->model('model_member');
		
		$this->load->model('model_product');
		
		$this->load->model('model_hotel');
		
		
		
		$this->load->library('sendsms');
		
		$this->load->helper('cookie');
		
        $this->load->helper('captcha');
		
		$this->userinfo=$this->model_member->get_userinfo($this->userinfo['id'],2);
		
		

    }

    public function index()

	{

          //处理网页中的seo信息
		

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;
		
		$condition=array('state'=>2);
		$condition=array('user_id'=>$this->userinfo['user_id']);
        $pingjia_order=$this->model_hotel->get_ordercount($condition);
		
		$condition2=array('state'=>1);
		$condition2=array('user_id'=>$this->userinfo['user_id']);
        $weiruzhu_order=$this->model_hotel->get_ordercount($condition2);
		
		$leiji=$this->userinfo['leijifang_num'];
		
		$leiji_sq=$this->userinfo['leijishenqing'];
		
		$lianxu=$this->userinfo['lianxufang_num'];
		
		
		
		$zhu6_keling=$lianxu>=6?floor($lianxu/6):0;
		
		$zhu6_sz=$lianxu<6?(6-$lianxu):fmod($lianxu,6);
		
		$zhu7_keling=floor(($leiji-$leiji_sq*7)/7);
		
		$zhu7_hx=fmod(($leiji-$leiji_sq*7),7);
		$zhu7_hx = $zhu7_hx==0?7:$zhu7_hx;
		
		//订单信息
		$this->data['zhu6_keling'] =$zhu6_keling;
		
		$this->data['zhu6_sz'] =$zhu6_sz;
		
		$this->data['zhu7_keling'] =$zhu7_keling;
		
		$this->data['zhu7_hx'] =$zhu7_hx;
		
		
		$this->data['pingjia_order'] =$pingjia_order;
		
		$this->data['weiruzhu_order'] =$weiruzhu_order;
		
		
		
		$this->data['user_name'] =$this->userinfo['user_name']?$this->userinfo['user_name']:$this->userinfo['mobile_phone'];
		
		$this->data['mobile_phone'] =$this->userinfo['mobile_phone'];
		
		$this->data['email'] =$this->userinfo['email'];
		
		
		//积分信息
		$this->data['dhExp'] =$this->userinfo['dhExp'];
		
		$this->data['UserExp'] =$this->userinfo['UserExp'];
		
		$this->data['title'] ='';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('myxexing',$this->data);

	}
	
	 public function addcomment()

	{

        //处理网页中的seo信息
		
		$orderid=$this->uri->segment(3);
		
		$hotelid=$this->uri->segment(4);
		
		$hotelinfo=$this->model_hotel->get_hotelinfo($hotelid);

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        $this->data['method'] = $this->uri->segment(1) ; 
		
		$this->data['orderid'] = $orderid;
		
		$this->data['hotelid'] = $hotelid;
		
		$this->data['renqun_ary'] = $this->model_config->renqun_ary();
		
		$this->data['comment_ary'] = $this->model_config->comment_ary();
		
		$this->data['hotelname'] = $hotelinfo['HotelName'];
		
		$this->data['title'] ='酒店点评';  

		$this->load->view('addcomment',$this->data);

	}
	
	
	 public function myorder()

	{

        //处理网页中的seo信息
		
		$type=$this->uri->segment(3);
		
		$type=$type?$type:0;

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        $orderlist=$this->model_hotel->get_orderlist('0','10','orderID desc','where type='.$type.' and user_id='.$this->userinfo['user_id']);
		$this->data['orderlist'] =$orderlist;
		
		$this->data['title'] ='酒店订单';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('myorder',$this->data);

	}
	
	 public function mygift()

	{

        //处理网页中的seo信息
		
		$type=$this->uri->segment(3);
		
		$type=$type?$type:0;

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        $orderlist=$this->model_product->get_order_list('0','10','poid desc','where  user_id='.$this->userinfo['user_id']);
		$this->data['orderlist'] =$orderlist;
		
		$this->data['title'] ='我的礼品';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('mygift',$this->data);

	}
	
	 public function myfanxian()

	{

        //处理网页中的seo信息
		
		

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        $orderlist=$this->model_member->get_jiangjin_list('0','10','jj.id desc','where  ho.user_id='.$this->userinfo['user_id']);
		$this->data['orderlist'] =$orderlist;
		
		 $fanxianlist=$this->model_member->get_tixian_list('0','10','id desc','where  user_id='.$this->userinfo['user_id']);
		$this->data['fanxianlist'] =$fanxianlist;
		
		$this->data['leijifanxian'] =$this->userinfo['fanxian'];
		
		$this->data['title'] ='我的返现';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('myfanxian',$this->data);

	}
	
		 public function myexp()

	{

        //处理网页中的seo信息
		
		$type=$this->uri->segment(3);
		
		$type=$type?$type:0;

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        $orderlist=$this->model_member->get_explog_list('0','10','LogID desc','where  user_id='.$this->userinfo['user_id']);
		
		$this->data['orderlist'] =$orderlist;
		
		$this->data['dhExp'] =$this->userinfo['dhExp'];
		
		$this->data['UserExp'] =$this->userinfo['UserExp'];
		
		$this->data['title'] ='我的积分';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('myexplog',$this->data);

	}
	
			 public function myxexing()

	{

        //处理网页中的seo信息
		

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;
		
		$condition=array('state'=>2);
        $pingjia_order=$this->model_hotel->get_ordercount($condition);
		
		$condition2=array('state'=>1);
        $weiruzhu_order=$this->model_hotel->get_ordercount($condition2);
		
		$leiji=$this->userinfo['leijifang_num'];
		
		$leiji_sq=$this->userinfo['leijishenqing'];
		
		$lianxu=$this->userinfo['lianxufang_num'];
		
		
		
		$zhu6_keling=$lianxu>=6?floor($lianxu/6):0;
		
		$zhu6_sz=$lianxu<6?fmod($lianxu,6):(6-$lianxu);
		
		$zhu7_keling=floor(($leiji-$leiji_sq*7)/7);
		
		$zhu7_hx=fmod(($leiji-$leiji_sq*7)/7);
		
		//订单信息
		$this->data['zhu6_keling'] =$zhu6_keling;
		
		$this->data['zhu6_sz'] =$zhu6_sz;
		
		$this->data['zhu7_keling'] =$zhu7_keling;
		
		$this->data['zhu7_hx'] =$zhu7_hx;
		
		
		$this->data['pingjia_order'] =$pingjia_order;
		
		$this->data['weiruzhu_order'] =$weiruzhu_order;
		
		
		
		$this->data['user_name'] =$this->userinfo['user_name']?$this->userinfo['user_name']:$this->userinfo['mobile_phone'];
		
		$this->data['mobile_phone'] =$this->userinfo['mobile_phone'];
		
		$this->data['email'] =$this->userinfo['email'];
		
		
		//积分信息
		$this->data['dhExp'] =$this->userinfo['dhExp'];
		
		$this->data['UserExp'] =$this->userinfo['UserExp'];
		
		$this->data['title'] ='';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('myexplog',$this->data);

	}

	
	 public function freeroomorder()

	{

        //处理网页中的seo信息
		
		$type=$this->uri->segment(3);
		
		$type=$type?$type:0;

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;
		
		if($type){
			$wheresql=' type='.$type.' and';
		}

        $orderlist=$this->model_hotel->get_orderlist('0','10','orderID desc','where '.$wheresql.' user_id='.$this->userinfo['user_id']);
		$this->data['orderlist'] =$orderlist;
		
		$this->data['title'] ='免费房订单';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('myorder',$this->data);

	}
	
	 public function mycomment()

	{

        //处理网页中的seo信息
		
		$type=$this->uri->segment(3);
		
		$type=$type?$type:0;

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        $orderlist=$this->model_member->get_comment_list('0','10','CommentID desc','where  user_id='.$this->userinfo['user_id']);
		$this->data['orderlist'] =$orderlist;
		
		$this->data['title'] ='我的点评';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('mycomment',$this->data);

	}
	
	 public function tixian()

	{

        //处理网页中的seo信息
		
		
		$bank_name=$this->userinfo['bank_name'];
		
		$bank_num=$this->userinfo['bank_num'];
		
		$bank_renname=$this->userinfo['bank_renname'];
		
		
		
		$this->data['mobile_phone'] = $this->userinfo['mobile_phone'];
		
		if($bank_name && $bank_num && $bank_renname){
			$this->data['isbank'] =1;
			$this->data['bank_num']=$bank_num;
			$this->data['bank_name']=$bank_name;
			$this->data['bank_renname']=$bank_renname;
		}
		
		if($this->input->post('action',TRUE)=='tixian'){
			
			$jiner=$this->input->post('jiner',TRUE);
			if($jiner<50){
				
				$alertMsg = '提现金额不能小于50元';
            $redirectUrl = site_url('member/tixian');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
				
			}
			$yzm=$this->input->post('yzm',TRUE);
			$checkma=$this->input->cookie($this->config->item('cookie_prefix').'checkma',TRUE);
			if($yzm!=$checkma){
				$alertMsg = '您输入的验证码不正确';
            $redirectUrl = site_url('member/tixian');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
			}
			
			
			$tixian['user_id']=$this->userinfo['user_id'];
			$tixian['jiner']=$jiner;
			$tixian['addtime']=time();
			$tixian['ip']=$_SERVER["HTTP_CLIENT_IP"];
			
			if($quer=$this->model_member->save_tixian($tixian)){
			
			$userinfo['user_id']=$this->userinfo['user_id'];
			$userinfo['fanxian']=$this->userinfo['fanxian']-$jiner;
			
			if($quer=$this->model_member->save_userinfo($userinfo,'update')){
				
					$alertMsg = '提现申请成功';
            $redirectUrl = site_url('member/tixian');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
			}
			
			}
			
		}
		if($this->input->post('action',TRUE)=='bank'){
			
			$yzm=$this->input->post('yzm',TRUE);
			$checkma=$this->input->cookie($this->config->item('cookie_prefix').'checkma',TRUE);
			if($yzm!=$checkma){
				$alertMsg = '您输入的验证码不正确';
            $redirectUrl = site_url('member/tixian');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
			}
			
			$bank_name=$this->input->post('bank_name',TRUE);
			$bank_num=$this->input->post('bank_num',TRUE);
			$bank_renname=$this->input->post('bank_renname',TRUE);
			
			if(!$bank_num || !$bank_renname){
				$alertMsg = '帐号和姓名不能为空'.$bank_num.$bank_renname;
            $redirectUrl = site_url('member/tixian');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
			}
			
			$userinfo['bank_name']='建设银行';
			$userinfo['bank_num']=$bank_num;
			$userinfo['bank_renname']=$bank_renname;
			$userinfo['user_id']=$this->userinfo['user_id'];
			
			if($quer=$this->model_member->save_userinfo($userinfo,'update')){
				
					$alertMsg = '银行卡信息绑定成功';
            $redirectUrl = site_url('member/tixian');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
			}
			
		}
		
		

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        $orderlist=$this->model_member->get_comment_list('0','10','CommentID desc','where  user_id='.$this->userinfo['user_id']);
		$this->data['orderlist'] =$orderlist;
		
		$this->data['title'] ='我的提现';

        $this->data['method'] = $this->uri->segment(2) ;    

		$this->load->view('tixian',$this->data);

	}
	
	 public function cancelorder()

	{
		$orderid=$this->uri->segment(3);
		$state=$this->uri->segment(4);
		
		$data=array();
		$data['orderID']=$orderid;
		$data['state']=$state;
		
		if($query=$this->model_hotel->save_order($data,'update')){
			$alertMsg = '订单已经取消';
            $redirectUrl = site_url('member/myorder');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
		}

        

	}
	
	public function cancel_gift_order()

	{
		$orderid=$this->uri->segment(3);
		$state=$this->uri->segment(4);
		
		$data=array();
		$data['poid']=$orderid;
		$data['state']=$state;
		
		if($query=$this->model_product->save_product_order($data,'update')){
			$alertMsg = '订单已经取消';
            $redirectUrl = site_url('member/myorder');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
		}

        

	}
	
	
	 public function orderinfo()

	{

        //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

         $this->data=$this->model_hotel->get_orderinfo($this->uri->segment(3));
		

        $this->data['method'] = $this->uri->segment(1) ;    

		$this->load->view('orderinfo',$this->data);

	}
	
	 public function gift_orderinfo()

	{

        //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

         $this->data=$this->model_product->get_gift_orderinfo($this->uri->segment(3));
		

        $this->data['method'] = $this->uri->segment(1) ;   
		
		$this->data['action'] ='gift';  

		$this->load->view('orderinfo',$this->data);

	}


	
	public function userlogin()

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
		
		$res=$this->model_member->login($username,$password);
		
		if($res==-1){
			$alertMsg = '用户不存在，请注册后再登录';
            $redirectUrl = site_url('member/userlogin');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;  
		}
		else if($res==-2){
			$alertMsg = '登录名或密码错误';
            $redirectUrl = site_url('member/userlogin');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
		}
		else if($res==1){
			
			
			
    			redirect('member');
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
	
		public function save_comment()

	{
		$renqun=$this->input->post('renqun',TRUE);
		$comment=$this->input->post('comment',TRUE);
		$CommentTitle=$this->input->post('CommentTitle',TRUE);
		$Content=$this->input->post('Content',TRUE);
		$order_id=$this->input->post('order_id',TRUE);
		$hotel_id=$this->input->post('hotel_id',TRUE);
		$yinxiang=$this->input->post('yinxiang',TRUE);
		
		
		
		$data=array();
		$data['order_id']=$order_id;
		$data['hotel_id']=$hotel_id;
		$data['CommentTitle']=$CommentTitle;
		$data['Content']=$Content;
		$data['user_id']=$this->userinfo['user_id'];
		$data['user_name']=$this->userinfo['user_name']?$this->userinfo['user_name']:$this->userinfo['mobile_phone'];
		$data['renqun']=$renqun;
		$data['yinxiang']=$yinxiang;
		$data['Position']=$comment;
		$data['UpdateTime']=time();
		
		$query=$this->model_member->save_comment($data);
		
		$date2['orderID']=$order_id;
		$date2['state']='3';
		
		$query=$this->model_hotel->save_order($date2,'update');
		
		if($query){
			$alertMsg = '评价已成功提交';
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
	
	
		public function modifypassword()

	{

        //处理网页中的seo信息
		
		

        $keywords_array = $this->model_common->getKeywords('member');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);
		
		$cap = $this->get_captcha();  
		
        $cap['keywords_array'] = $keywords_array;
		
		$cap['title'] ='修改密码';

        $cap['method'] = $this->uri->segment(1) ;  

		$this->load->view('modifypassword',$cap);

	}
		public function modifypassword2()

	{
		$oldpassword=$this->input->post('oldpassword',TRUE);
		$password = $this->input->post('password');
		$password2 = $this->input->post('password2');
		
		if(!$oldpassword||!$password||$password2){
			$alertMsg = '信息输入不完整';
            $redirectUrl = site_url('/user/modifypassword');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;  
		}
		if($password!=$password2){
			
			$alertMsg = '两次输入的密码不相同';
            $redirectUrl = site_url('/user/modifypassword');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;  
		}
		$oldpass=$this->userinfo['password'];
		$oldpass2=md5(md5($oldpassword.'qingqing'));
		if($oldpass!=$oldpass2){
			$alertMsg = '输入的原密码不正确';
            $redirectUrl = site_url('/user/modifypassword');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;  
		}
		$date['user_id']=$this->userinfo['user_id'];
		$date['password']=md5(md5($password.'qingqing'));
		
		if($quer=$this->model_member->save_userinfo($date,'update')){
			$alertMsg = '密码修改成功';
            $redirectUrl = site_url('/user/modifypassword');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;  
		}
		
		
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