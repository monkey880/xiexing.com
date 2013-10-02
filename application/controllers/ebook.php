<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID ebook.php 

 * 住哪酒店分销联盟（下单）模块

 * @date 2013-2-18 

 * @author yuhailong zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Ebook extends CI_Controller 

{

    

    private $data;

    

    function __construct()

    {

        parent::__construct();
		
		$this->load->library('session');
		
      //if(!$this->session->userdata('xexinguserinfo')){
//
//        	redirect('/user?url='.urlencode(current_url().'?'.rtrim($_SERVER['QUERY_STRING'],'/')));
//
//        }

	     $this->userinfo = $this->session->userdata('xexinguserinfo');


        $this->data = array();
		
		$db = (array) $this->db;

        $this->hotel_table = $db['dbprefix'].'hotel';
		
		$this->load->model('model_hotel');
		
		
		$this->load->model('model_member');
		$this->load->model('model_freeroom');
		
		$this->load->library('guid');
		//$this->output->enable_profiler(TRUE);

    }

    

	public function index()

	{

        $this->data['method'] = $this->uri->segment(1) ; 

  		

        $hotelid = empty($_GET['hid']) ? 0 : $_GET['hid'];

        $agent_id = CFG_AGENTID;

        $agent_md = CFG_AGENTMD;

        $pid = !empty($_GET['pid']) ? (int) $_GET['pid'] : 0;

        $uid = !empty($_GET['uid']) ? (int) $_GET['uid'] : 0;

        $rid = !empty($_GET['rid']) ? (int) $_GET['rid'] : 0;

        $tm1 = !empty($_GET['tm1']) ? $_GET['tm1'] : 0;

        $tm2 = !empty($_GET['tm2']) ? $_GET['tm2'] : 0;
		
		$type = !empty($_GET['type']) ? $_GET['type'] : 0;
		
		$freeroomid = !empty($_GET['freeroomid']) ? $_GET['freeroomid'] : 0;
		
		$this->data['type']=$type;

        $site_url = $_SERVER['HTTP_HOST'];

        

        $navtitle = "提交订单";
		
		if(strchr($hotelid,"A"))
		{
        $hotelinfo=$this->model_hotel->get_hotelinfo($hotelid);
		}
		else{
		
		$hotelinfo=$this->model_hotel->getHotelInfo($hotelid);
		}
		if($type==1){
			$freeroom=$this->model_freeroom->get_freeroominfo($freeroomid);
			$this->data['freeroom'] = $freeroom;
		}
		
		$userinfo=$this->model_member->get_userinfo($this->userinfo['id'],2);
		
        $this->data['hotelid'] = $hotelid;
		
		$this->data['HotelName'] = $hotelinfo['HotelName'];
		
		$this->data['Address'] = $hotelinfo['Address'];
		
		$this->data['Picture'] = $hotelinfo['picture'];
		
		$this->data['userinfo'] = $userinfo;

        $this->data['agent_id'] = $agent_id;

        $this->data['agent_md'] = $agent_md;

        $this->data['pid'] = $pid;

        $this->data['uid'] = $uid;

        $this->data['rid'] = $rid;

        $this->data['tm1'] = $tm1;

        $this->data['tm2'] = $tm2;
		
		$computer_name = $_SERVER["SERVER_NAME"];
		$ip = $_SERVER["SERVER_ADDR"];
		$guid = $this->guid->Guid($computer_name, $ip);
		
		$this->data['guid'] = $guid;

        $this->data['site_url'] = $site_url;

        $this->data['navtitle'] = $navtitle;
		
		if($hotelinfo['soure']==9 ){
			$this->load->view('ebook2',$this->data);
		}
		else if($type==1){
			   if(!$this->userinfo){

        	redirect('/user');

        }
			$this->load->view('ebook3',$this->data);
		}
		else if($type>1){
			
			if(!$this->userinfo){

        	redirect('/user');

        }
			$this->load->view('ebook4',$this->data);
		}
		else{
			$this->data['Picture'] ='http://tp1.znimg.com/'.$this->data['Picture'] ;
		$this->load->view('ebook',$this->data);
		}

        

        

	}
	
	public function save_order(){
		
		$this->load->library('sendsms');
		$this->load->library('sendemail');
		
		$roomnum=$this->input->post('roomnum');
		$eTm1=$this->input->post('eTm1');
		$eTm2=$this->input->post('eTm2');
		$g_name=$this->input->post('g_name');
		foreach($g_name as $name){
			$Customername.=$name.',';
		}
		$c_mobile=$this->input->post('mobile');
		$c_email=$this->input->post('email');
		$c_liyou=$this->input->post('c_liyou');
		$ArriveTime=$this->input->post('ArriveTime');
		
		
		$z=$this->input->post('z');
		$ordertmp=$this->input->post('ordertmp');
		
		if(!$this->session->userdata('xexinguserinfo')){
			if(!$res=$this->model_member->checkmobile($c_mobile)){
				
				$pass=random_string('numeric', 8);
				$password=md5(md5($pass.'qingqing'));
		
			$user=array();
			$user['mobile_phone']=$c_mobile;
			$user['password']=$password;
			$user['email']=$c_email;
			$user['reg_time']=time();
			
			$query=$this->model_member->save_userinfo($user);
			
			$checkma="尊敬的客户，欢迎您成为携行注册会员，您的用户名为".$c_mobile.",密码为".$pass.",您可登录 www.xexing.com 进行密码修改.订酒店累计住7天送1天，24小时热线：4006002069或02124208963，低价返现，0元试住，更多礼品等你来拿.订酒店用携行";
			$res=$this->sendsms->get_message($c_mobile,iconv('utf-8','gb2312',$checkma));
			
			if($c_email){
			$res2=$this->send($c_email,"携行网注册信息",$checkma);
			}
			
			$this->userinfo=$this->model_member->get_userinfo($c_mobile);
			
			}
		}
		
		
		$data=array();
		$data['orderNum']=date('ymd').substr(time(),-5).substr(microtime(),2,5);
		$data['hotel_id']=$z['hid'];
		$data['hotel_name']=$z['hotelname'];
		$data['Customername']=$Customername;
		$data['phone']=$c_mobile;
		$data['user_id']=$this->userinfo['id'];
		$data['email']=$c_email;
		$data['roomid']=$z['rid'];
		$data['roomtitle']=$z['roomname'];
		$data['roomallprice']=$ordertmp['TotalPrice'];
		$data['TotalJiangjin']=$ordertmp['TotalJiangjin'];
		$data['roomnumber']=$roomnum;
		$data['rkTime']=$ArriveTime;
		$data['CheckInDate']=$eTm1?strtotime($eTm1):strtotime($ordertmp['CheckInDate']);
		$data['CheckOutDate']=$eTm2?strtotime($eTm2):strtotime($ordertmp['CheckOutDate']);
		$data['addtime']=time();
		$data['type']=$ordertmp['type']?$ordertmp['type']:0;
		$data['liyou']=$c_liyou;
		$data['tian_num']=round((strtotime($ordertmp['CheckOutDate'])-strtotime($ordertmp['CheckInDate']))/3600/24);
		
		$query=$this->model_hotel->save_order($data);
		
		if($ordertmp['type']){
			$alertMsg = '申请已提交';
            $redirectUrl = site_url('/');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
		}
		else{
		$data['Address']=$ordertmp['address'];
		
		
		$sysconfig = $this->model_sysconfig->getSysconfig();
		
		$checkma="客户$Customername $c_mobile 已预订 $z[hotelname]，$z[roomname] 请及时处理订单";
		if($sysconfig['cfg_sms_kaiguan']){
		$res=$this->sendsms->get_message($sysconfig['cfg_admin_mobile'],iconv('utf-8','gb2312',$checkma));
		}
		$res2=$this->send($sysconfig['cfg_admin_email'],"新订单提醒",$checkma);
		
		$smscon="您预订的".date('m月d日',$data['CheckInDate'])."入住 ".date('m月d日',$data['CheckOutDate'])."离店".$z['hotelname'].$z['roomname'].$roomnum."间".$data['tian_num']."晚，订单已提交。请登录会员中心查看订单处理结果，会员名为你的手机号。24小时热线4006002069,www.xexing.com ";
		$res=$this->sendsms->get_message($c_mobile,iconv('utf-8','gb2312',$smscon));
		$res2=$this->send($c_email,"您的订单已成功提交【".$z['hotelname']."】",$smscon);
		$this->load->view('ebook_ok',$data);
		}
		
	}
	
	public function save_order2(){
		$roomnum=$this->input->post('roomnum');
		$eTm1=$this->input->post('eTm1');
		$eTm2=$this->input->post('eTm2');
		$g_name=$this->input->post('g_name');
		foreach($g_name as $name){
			$Customername.=$name.',';
		}
		$c_mobile=$this->input->post('c_mobile');
		$c_email=$this->input->post('c_email');
		$c_liyou=$this->input->post('c_liyou');
		$ArriveTime=$this->input->post('ArriveTime');
		
		
		$z=$this->input->post('z');
		$ordertmp=$this->input->post('ordertmp');
		
		
		$data=array();
		$data['orderNum']=date('ymd').substr(time(),-5).substr(microtime(),2,5);
		$data['hotel_id']=$z['hid'];
		$data['hotel_name']=$z['hotelname']." 200000000";
		$data['Customername']=$Customername;
		$data['phone']=$c_mobile;
		$data['user_id']=$this->userinfo['id'];
		$data['email']=$c_email;
		$data['roomid']=$z['rid'];
		$data['roomtitle']=$z['roomname'];
		$data['roomallprice']=$ordertmp['TotalPrice'];
		$data['roomnumber']=$roomnum;
		$data['rkTime']=$ArriveTime;
		$data['CheckInDate']=$eTm1?strtotime($eTm1):strtotime($ordertmp['CheckInDate']);
		$data['CheckOutDate']=$eTm2?strtotime($eTm2):strtotime($ordertmp['CheckOutDate']);
		$data['addtime']=time();
		$data['type']=$ordertmp['type']?$ordertmp['type']:0;
		$data['liyou']=$c_liyou;
		$data['tian_num']=round((strtotime($ordertmp['CheckOutDate'])-strtotime($ordertmp['CheckInDate']))/3600/24);
		
		$query=$this->model_hotel->save_order($data);
		if($ordertmp['type']){
			$alertMsg = '申请已提交';
            $redirectUrl = site_url('/');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
		}
		else{
		$data['Address']=$z['Address'];
		$this->load->view('ebook_ok',$data);
		}
	}
	
	public function get_orertemp(){
		
		
		$hotelid = empty($_GET['hid']) ? 0 : $_GET['hid'];

        $pid = !empty($_GET['pid']) ? (int) $_GET['pid'] : 0;

        $uid = !empty($_GET['uid']) ? (int) $_GET['uid'] : 0;

        $rid = !empty($_GET['rid']) ? (int) $_GET['rid'] : 0;

        $tm1 = !empty($_GET['tm1']) ? $_GET['tm1'] : 0;

        $tm2 = !empty($_GET['tm2']) ? $_GET['tm2'] : 0;
		
		$callback = !empty($_GET['callback']) ? $_GET['callback'] : 0;
		
		
		$hotelinfo=$this->model_hotel->get_hotelinfo($hotelid);
		$room_list=$this->model_hotel->get_roomtype_list('0','10','rid desc','where hid='.$hotelinfo['hid']);
		$roominfo=$this->model_hotel->get_roomtype($rid);
		$planinfo=$this->model_hotel->get_plan($pid);
		
		$res="var_Data=";
		
		$datearr=array();
		
		$ordertmp['guid']='7028fb52-af5f-a491-633b-e599947e20cc';
		$ordertmp['HotelId']=$hotelid;
		$ordertmp['RoomTypeId']=$rid;
		$ordertmp['RoomName']=$roominfo['title'];
		$ordertmp['RatePlanID']=$pid;
		$ordertmp['RatePlanCode']='';
		$ordertmp['RatePlanName']=$planinfo['planname'];
		$ordertmp['CheckInDate']=$tm1;
		$ordertmp['CheckOutDate']=$tm2;
		$ordertmp['GuestTypeCode']='1';
		$ordertmp['TotalPrice']='';
		$ordertmp['CurrencyCode']='';
		$ordertmp['dateline']='';
		$ordertmp['TotalJiangjin']='';
		
		$datearr['ordertmp']=$ordertmp;
		$datearr['HotelName']=$hotelinfo['HotelName'];
		$datearr['CheckInDate']=$tm1;
		$datearr['CheckOutDate']=$tm2;
		
		foreach($room_list as $room){
			$plan=$this->model_hotel->get_plan_list($room['rid'],'-1',strtotime($tm1),strtotime($tm2));
			foreach($plan as $p){
				$rmop['rid']=$room['rid'];
				$rmop['pid']=$p['c'];
				$rmop['roomname']=$room['title'];
				$rmop['planName']=$p['planname'];
				
				$totleprice='';
				
				for($i=$stardate;$i<$enddate;$i=$i+3600*24){
					$tmprice=array();
					$price=$this->model_hotel->get_dayprice($i,$r['rid'],$p['planid']);
					$tmprice['day']=date('Y-m-d',$i);
					$dayarr=getdate($i);
					$tmprice['week']=$dayarr['wday'];
					//计算均价
					if($price){
						if($price['week']){
							if(strpos($price['week'],(string)$dayarr['wday'])>-1){
								
								$totleprice+=$price['dayprice'];
							}
							else{
								
								$totleprice+=$p['dayprice'];
							
								}
						}
						else{
							$totleprice+=$price['dayprice'];
						}
					}
					
					else{
						$totleprice+=$p['dayprice'];
					}
					//计算均价结束
				
				}
				$rmop['junjia']=$totleprice/(strtotime($tm2)-strtotime($tm1))/3600*24;
				if($pid==$p['$totleprice']){
				$rmop['selected']=1;
				}
				else{
					$rmop['selected']=0;
				}
			
			
			}
			}
			$datearr['rooms_opts'][]=$rmop;
			$datearr['roomsInfo']='';
			$datearr['ratedaill']='<tr><td><h4>07-26<\/h4>255<\/td><\/tr>';
			
			$zh['tm1']=$tm1;
			$zh['tm2']=$tm2;
			$zh['hid']=$hid;
			$zh['rid']=$rid;
			$zh['pid']=$pid;
			$zh['agent_id']='';
			$zh['union_id']='';
			$zh['eid']='';
			$zh['hotelname']=$hotelinfo['HotelName'];
			$zh['roomtypeid']=$rid;
			
			$room2['roomtypeid']=$roominfo['rid'];
			$room2['roomname']=$roominfo['rid'];
			$room2['roomtypenum']=$roominfo['rid'];
			$room2['area']=$roominfo['rid'];
			$room2['floor']=$roominfo['rid'];
			$room2['note']=$roominfo['rid'];
			$room2['beddescription']=$roominfo['rid'];
			$room2['bedtype']=$roominfo['rid'];
			$room2['zid']=$roominfo['rid'];
			$room2['bed']=$roominfo['rid'];
			$room2['adsl']=$roominfo['rid'];
			
			$img=explode(',',$roominfo['roomimg']);
			foreach($img as $p){
					if($p){
						$roompic['spic']=$p;
						$roompic['type']='99';
						$roompic['title']=$roominfo['title'];
						$roompic['imgurl']=$p;
						$room2['img'][]=$roompic;
					}
			}
			$room2['AvailableAmount']='11';
			//房型信息
			$zh['room']=$room2;
			
			$datearr['zh']=$zh;
			
			$pricearr['fistDayPrice']='34';
			$pricearr['TotalJiangjin']='34';
			$pricearr['TotalPrice']='34';
			$pricearr['CurrencyCode']='34';
			$pricearr['daydiff']='1';
			
			
			$datearr['prices']=$pricearr;
			$datearr['yuding']='true';
			
			
			$garan['romms']=0;
			$garan['status']=0;
			$garan['norule']=0;
			$garan['stattime']=0;
			$garan['endtime']=0;
			$garan['desc']=0;
			
			
			$datearr['GaranteeRule']=$garan;
			
			$datearr['servername']='www.xexing.com';
			$datearr['uptime']=date("Y-m-d-H-m-s",time());
			
		
		$res.=json_encode($datearr);
		
		$res.=";if($callback){
    $callback(_Data)
}else{
    alert('Err: $callback')
}";
		
		echo $res;
		
	



	
	}
	
	public function send($to,$titel,$content)
{
	
$this->load->library('email');	
$this->email->from('kerry100124@sina.com', '携行 专业酒店预订网');
$this->email->to($to); 
$this->email->cc(''); 
$this->email->bcc(''); 

$this->email->subject($titel);
$this->email->message($content); 

$this->email->send();


	
}

}