<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID news.php

 * 住哪酒店分销联盟（后台新闻管理）模块

 * @date 2013-2-27 

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Tuan extends CI_Controller 

{

    

	private $userinfo;

    private $tablefunc = 'news';

	

    function __construct()

    {

        parent::__construct();
		
		$this->load->database();
        
		$db = (array) $this->db;
		
		
		
		$this->users_table = $db['dbprefix'].'users';

        $this->load->library('session');

        if(!$this->session->userdata('userinfo')){

        	redirect(CFG_ADMINURL.'/login');

        }

        $this->userinfo = $this->session->userdata('userinfo');

       
        $this->load->library('tool');

        $this->load->library('pagination');

        $this->load->helper('form');
		$this->load->model('model_tuangou');
        $this->load->model('model_city');
        $this->load->model('model_admin');
		//$this->output->enable_profiler(TRUE);

    }

    

    /**

     * 后台新闻列表

     */

    public function index()

    {    

        $data = array();

        $keywords=$this->input->get_post('keywords');

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;

    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;

        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;

        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);

        

        $page = intval($this->uri->segment(5)) ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 10 ;

        

        $cityid = intval($this->uri->segment(4)) ;

        
		$whereSql = array('status'=>1);
		$whereSqlList = "where status=1";   
       

        $hotelcount = $this->model_tuangou->get_tuangou_count($whereSql);

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->model_tuangou->gettuanList($pageinfo['start'],$pagesize,'tid desc',$whereSqlList);

        

        

        //生成新闻分类的select菜单
        

        


        

        //分页

        $config['base_url'] = base_url(CFG_ADMINURL.'/hotel/index/'.$cityid);

        $config['suffix'] = $this->config->item('url_suffix');

        $config['total_rows'] = $hotelcount ;

        $config['uri_segment'] = 5;

        $config['num_links'] = 8;

        $config['per_page'] = $pagesize;

        $config['use_page_numbers'] = true;

        $config['first_link'] = '<<';

        $config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

        $this->pagination->initialize($config); 

        $pagnav = $this->pagination->create_links();



        $data['method'] = $this->uri->segment(2) ;      

        $data['hotellist'] = $hotellist ;      

        $data['hotelcount'] = $hotelcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['page'] = $page;

        $data['cityid'] = $cityid;

        
		$provinceclass = $this->model_city->get_province();
		$provinceclass['-1']='选择省份';
        

        $provinceclass_select = form_dropdown('province',$provinceclass,'-1','id=class_province');
		$data['provinceclass_select'] = $provinceclass_select;

        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_tuanlist',$data);

    }
	
	    public function order()

    {    

        $data = array();

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;

    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;

        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;

        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);

        $userid = intval($this->uri->segment(5))?intval($this->uri->segment(5)):0 ;

        $page = intval($this->uri->segment(6)) ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 10 ;

        

        $type = intval($this->uri->segment(4))?intval($this->uri->segment(4)):0 ;

        $whereSql = '';

       

            $whereSql = array('type'=>$type); 

            $whereSqlList = "where type=$type"; 
			
		if($userid){
			
			 $whereSql = array('user_id'=>$userid); 

            $whereSqlList .= " and user_id=$userid"; 
			
		}

       

		

        $hotelcount = $this->model_hotel->get_ordercount($whereSql);

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->model_hotel->get_orderlist($pageinfo['start'],$pagesize,'orderID desc',$whereSqlList);

        //生成新闻分类的select菜单
        
        $config['base_url'] = base_url(CFG_ADMINURL.'/hotel/order/'.$type.'/'.$userid);

        $config['suffix'] = $this->config->item('url_suffix');

        $config['total_rows'] = $hotelcount ;

        $config['uri_segment'] = 6;

        $config['num_links'] = 8;

        $config['per_page'] = $pagesize;

        $config['use_page_numbers'] = true;

        $config['first_link'] = '<<';

        $config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

        $this->pagination->initialize($config); 

        $pagnav = $this->pagination->create_links();



        $data['method'] = $this->uri->segment(2) ;      

        $data['hotellist'] = $hotellist ;      

        $data['hotelcount'] = $hotelcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['page'] = $page;
		
		$data['userid'] = $userid;

        $data['type'] = $type;

        


        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_hotels_order_list',$data);

    }
	
	
	    public function jiangjin_list()

    {    

        $data = array();

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;

    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;

        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;

        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);

        $page = intval($this->uri->segment(6)) ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 10 ;

        $whereSql = '';

       

            $whereSql = array('status'=>0); 

            $whereSqlList = "where status=0"; 
			
		


        $hotelcount = $this->model_member->getJiangJinCount($whereSql);

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->model_member->get_jiangjin_list($pageinfo['start'],$pagesize,'id desc',$whereSqlList);

        //生成新闻分类的select菜单
        
        $config['base_url'] = base_url(CFG_ADMINURL.'/hotel/order/'.$type.'/'.$userid);

        $config['suffix'] = $this->config->item('url_suffix');

        $config['total_rows'] = $hotelcount ;

        $config['uri_segment'] = 6;

        $config['num_links'] = 8;

        $config['per_page'] = $pagesize;

        $config['use_page_numbers'] = true;

        $config['first_link'] = '<<';

        $config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

        $this->pagination->initialize($config); 

        $pagnav = $this->pagination->create_links();



        $data['method'] = $this->uri->segment(2) ;      

        $data['hotellist'] = $hotellist ;      

        $data['hotelcount'] = $hotelcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['page'] = $page;
		
		$data['userid'] = $userid;

        $data['type'] = $type;

        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_jiangjin_list',$data);

    }
	
	
	 public function tixian_list()

    {    
		

        $data = array();

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;

    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;

        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;

        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);

        $page = intval($this->uri->segment(6)) ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 10 ;

       
		


       $hotelcount= $this->db->count_all_results($this->tixian_table);

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->db->query("select * from $this->tixian_table h left join  $this->users_table u on h.user_id=u.user_id order by id desc limit $pageinfo[start],$pagesize")->result_array() ;

        //生成新闻分类的select菜单
        
        $config['base_url'] = base_url(CFG_ADMINURL.'/hotel/order/'.$type.'/'.$userid);

        $config['suffix'] = $this->config->item('url_suffix');

        $config['total_rows'] = $hotelcount ;

        $config['uri_segment'] = 6;

        $config['num_links'] = 8;

        $config['per_page'] = $pagesize;

        $config['use_page_numbers'] = true;

        $config['first_link'] = '<<';

        $config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

        $this->pagination->initialize($config); 

        $pagnav = $this->pagination->create_links();



        $data['method'] = $this->uri->segment(2) ;      

        $data['hotellist'] = $hotellist ;      

        $data['hotelcount'] = $hotelcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['page'] = $page;
		
		$data['userid'] = $userid;

        $data['type'] = $type;

        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_tixian_list',$data);

    }
	
	
	 public function tongbu()

    {    

    	$cityid =  $this->input->get('cityid', TRUE);
		
		$page = (int) $this->input->get('page', TRUE);
		$page=$page?$page:1;
    	$api = file_get_contents ( CFG_INTERFACE_API . "search&cid=$cityid&pg=$page&key=&hn=&lsid=0&rank=0&px=1&minprice=&maxprice=&bid=0&areaid=0" );

		$listresult = json_decode ( $api, true );
		$totalpg=$listresult['retHeader']['totalpg'];
		$list = $listresult ['reqdata'];
		
		
		foreach($list as $hotel){
			$ohotel=$this->model_hotel->get_hotelinfo($hotel['ID']);
		
			$data = array();
	
			$data['hotel_id'] = $hotel['ID'];
	
			$data['HotelName'] = $hotel['HotelName'];
			
			$data['CityID'] = $hotel['ecityid'];
			
			$data['CityName'] = $hotel['cityname'];
			
			$data['eareaid'] = $hotel['esdid'];
			
			$data['eareaname'] = $hotel['esdname'];
					
			$data['Min_price'] = $hotel['min_jiage'];
			
			$data['ZaocanPrice'] = $hotel['ZaocanPrice'];
			
			
			
			$data['Content'] = $hotel['content'];
	
			$data['Address'] = $hotel['Address'];
	
			$data['cbd_name'] = $hotel['cbd'];
			
			$data['cbd_id'] = $hotel['cid'];
	
			$data['soure'] = 1;
	
			$data['star'] = $hotel['xingji'];
			
			$data['Service'] = $hotel['Service'];
			
			
			$data['Card'] = $hotel['Card'];
			
			$data['HaoPing'] = $hotel['df_haoping'];
			
			$data['kaiye'] = $hotel['kaiye'];
			
			$data['zhuangxiu'] = $hotel['zhuangxiu'];
			
		
			
			$data['Tags'] = $hotel['tags'];
	
			$data['Traffic'] = $hotel['Traffic'];
			$data['picture'] = $hotel['Picture'];
			
			
			$data['baidu_lng'] = $hotel['baidu_lng'];
			
			$data['baidu_lat'] = $hotel['baidu_lat'];
			
			$data['lng'] = $hotel['x'];
			
			$data['lat'] = $hotel['y'];
			$data['isShow'] = 1;
			$data['uptime'] = time();
			$data['fuwu'] = $hotel['fuwu'];
			$data['liansuo'] = $hotel['liansuo'];
			$data['liansuoid'] = $hotel['liansuoid'];
			
			
			
	
	
			if ( $ohotel['hotel_id']>0 ) {
	
			   
				$result = $this->model_hotel->save_hotel($data,'update');
	
				if ($result) {
	
					$res.= $data['HotelName'].',修改酒店成功<br>';
	
					
	
				} else {
	
					$res.=  $data['HotelName'].',修改酒店失败<br>';
	
					
	
				}
	
			}else {
	
			   
				$result = $this->model_hotel->save_hotel($data,'insert');
				
				
				if ($result) {
					
					$res.=  $data['HotelName'].',添加酒店成功<br>';
	
					
	
				} else {
	
					
					$res.=  $data['HotelName'].',添加酒店失败<br>';
	
					
	
				}
	
			}
		}
		
		$data['res']=$res;
		if($page<$totalpg){
		$page++;
		$data['url']="/easyou/hotel/tongbu/?cityid=$cityid&page=$page";
		}
        $this->load->view('admin/admin_hotel_tongbu',$data);

    }






    /**

     * 显示添加或修改新闻界面

     */

    public function add_hotel()

    {    

    	$hotelid = intval($this->uri->segment(4));

    	if($hotelid > 0 ){

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    } 

    		$info = $this->model_hotel->get_hotelinfo_byid($hotelid);
			
    		

    	}else{

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    }

	        $info = array();

	        $info['title'] = '';

	        $info['aid'] = 0;

	        $info['content'] = '';

	        $info['author'] = '';

	        $info['smallcontent'] = '';

	        $info['class_id'] = '';

	        $info['state_radio'] = 1;

	        $info['img'] = '';

            $info['CityID'] = '';

            $info['order'] = '0';

            

           

    	}

    	//生成显示状态的radio单选按钮

    	$soure_radio_data = $this->model_config->soure_radio_ary();
		
		$youhui_radio_data = $this->model_config->youhui_radio_ary();
		
		$rank_ary = $this->model_config->rank_ary();
		
		$card_ary = $this->model_config->card_ary();
		
		$server_ary = $this->model_config->server_ary();
		
    	$provinceclass = $this->model_city->get_province();
		$provinceclass['-1']='选择省份';
        

        $provinceclass_select = form_dropdown('province',$provinceclass,'-1','id=class_province');

    	$info['soure_radio_data'] = $soure_radio_data;
		
		$info['youhui_radio_data'] = $youhui_radio_data;
		
		
		$info['rank_ary'] = $rank_ary;
		
		$info['server_ary'] = $server_ary;
		
		$info['card_ary'] = $card_ary;
		
		$info['provinceclass_select'] = $provinceclass_select ;  
		
		

		
    	$data = array_merge($info,$this->userinfo);
		

        $this->load->view('admin/admin_hotel_add',$data);

    }
	
	public function orderinfo()

    {    

    	$orderid = intval($this->uri->segment(4));

    	$info = $this->model_hotel->get_orderinfo($orderid);
		$info2 = $this->model_hotel->get_hotelinfo($info['hotel_id']);
		$jiangjin = $this->model_member->get_jiangjin_orderid($orderid);
		
		$info['yifanxian']=$jiangjin['TotalJiangjin'];
		$data = array_merge($info,$info2);
		
        $this->load->view('admin/admin_hotelorder',$data);

    }
	
	public function jiangjin()

    {    

    	$orderid = intval($this->uri->segment(4));
		$TotalJiangjin = intval($this->uri->segment(5));
		$orderinfo =$this-> model_hotel->get_orderinfo($orderid);
    	$userinfo=$this->model_member->get_userinfo($orderinfo['user_id'],2);
		
		$jiangjin['orderid']=$orderid;
		$jiangjin['TotalJiangjin']=$TotalJiangjin;
		$jiangjin['addtime']=time();
		
        $query=$this->model_member->save_jiangjin($jiangjin);
		
		$user_date['user_id']=$orderinfo['user_id'];
		$user_date['fanxian']=$userinfo['fanxian']+(int)$TotalJiangjin;
		
		$query=$this->model_member->save_userinfo($user_date,'update');
		
		 $alertMsg = '订单状态更改成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/orderinfo/'.$orderid);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

    }
	
	
	public function order_state()

    {    

    	$id = intval($this->uri->segment(4));
		$state = intval($this->uri->segment(5));
		
		$date['orderID']=$id;
		$date['state']=$state;
		
		$orderinfo=$this->model_hotel->get_orderinfo($id);
		$hotelinfo=$this->model_hotel->get_hotelinfo($orderinfo['hotel_id']);
		$userinfo=$this->model_member->get_userinfo($orderinfo['user_id'],2);
		$bltime=explode('-',$orderinfo['rkTime']);
		//已入住
		if($state==1){
			$smscon="携行网确认：您预订的".date('m月d日',$orderinfo['CheckInDate'])."入住 ".date('m月d日',$orderinfo['CheckOutDate'])."离店".$orderinfo['hotel_name'].$orderinfo['roomtitle'].$orderinfo['roomnumber']."间".$orderinfo['tian_num']."晚总价".$orderinfo['roomallprice']."元，已预订成功，酒店地址：".$hotelinfo['Address']."。保留到".$bltime."点，如不能准时到店或行程有变请联系021-24208963或24小时热线4006002069,www.xexing.com ";
		$res=$this->sendsms->get_message($c_mobile,iconv('utf-8','gb2312',$smscon));
		$res2=$this->send($c_email,"您已成功预定【".$z['hotelname']."】",$smscon);
		
		}
		else if($state==2){
			
			//订单送积分
			if($orderinfo['type']==0){
				
				if(!$query=$this->model_member->get_explog_orderid($orderinfo['order_id'],1)){
				
				$date2['user_id']=$orderinfo['user_id'];
				$date2['ExpNum']=(int)$orderinfo['roomallprice'];
				$date2['IncomePayout']=1;
				$date2['LogTime']=time();
				$date2['soure']='订单';
				
				$date2['hotel_name']=$orderinfo['hotel_name'];
				$date2['orderNum']=$orderinfo['orderNum'];
				$date2['order_id']=$orderinfo['order_id'];
				
				$query=$this->model_member->save_explog($date2);
				
				
				$user_date['user_id']=$orderinfo['user_id'];
				$user_date['UserExp']=$userinfo['UserExp']+(int)$orderinfo['roomallprice'];

				$query=$this->model_member->save_userinfo($user_date,'update');
				}
			
			
			//累计入住
			$date3['user_id']=$orderinfo['user_id'];
			$date3['num']=$orderinfo['roomnumber']*floor(($orderinfo['CheckOutDate']-$orderinfo['CheckInDate'])/3600/24);
			$date3['ziduan']='leijifang_num';
			
			$query=$this->model_member->changeruzhu($date3);
			
			//连续入住
			
			if($orderinfo['CheckOutDate']-$userinfo['endrzdate']<=3600*24){
			$date3['num']=floor(($orderinfo['CheckOutDate']-$orderinfo['CheckInDate'])/3600/24);
			$date3['ziduan']='lianxufang_num';
			$date3['endrzdate']=$orderinfo['CheckOutDate'];
			
			$query=$this->model_member->changeruzhu($date3,0);
			}
			}
		}
		else if($state==4){
			
			$date2['user_id']=$orderinfo['user_id'];
				$date2['ExpNum']=(int)$orderinfo['roomallprice'];
				$date2['IncomePayout']=2;
				$date2['LogTime']=time();
				$date2['soure']='未入住';
				
				$date2['hotel_name']=$orderinfo['hotel_name'];
				$date2['orderNum']=$orderinfo['orderNum'];
				$date2['order_id']=$orderinfo['order_id'];
				
				$query=$this->model_member->save_explog($date2);
				
				
				$user_date['user_id']=$orderinfo['user_id'];
				$user_date['UserExp']=$userinfo['UserExp']-(int)$orderinfo['roomallprice'];
				
				if($user_date['UserExp']<0){
					$user_date['UserExp']=0;
				}

				$query=$this->model_member->save_userinfo($user_date,'update');
			
		}

    	 $this->model_hotel->save_order($date,'update');
		 
		 $alertMsg = '订单状态更改成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/order');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
		
    }
	
	 /**

     * 显示添加或修改免费房界面

     */

    public function add_freeroom()

    {    

    	$hotelid = intval($this->uri->segment(4));
		
		$freeroomid = intval($this->uri->segment(5));
		
		$hotelinfo = $this->model_hotel->get_hotelinfo_byid($hotelid);
		
		


    	if($freeroomid > 0 ){

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    } 


    	}else{
			
			

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    }

	        $info = array();

	        $info['R_HotelName'] = $hotelinfo['HotelName'];
			
			$info['R_HotelID'] = $hotelinfo['hotel_id'];

    	}

    	//生成显示状态的radio单选按钮

    	$roomtype_data = $this->model_hotel->getroomtype($hotelinfo['hotel_id']);
		
    	$info['roomtype_data'] = $roomtype_data;
		
		
    	$data = array_merge($info,$this->userinfo);
		

        $this->load->view('admin/admin_freeroom_add',$data);

    }
	
	 public function add_roomtype()

    {    

    	$hotelid = intval($this->uri->segment(4));
		
		$rid = intval($this->uri->segment(5));
		
		

    	if($rid > 0 ){

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel').'";</script>';

    	       die();   

    	    } 
			$roomtypeinfo = $this->model_hotel->get_roomtype($rid);
			


    	}else{
			
			$roomtypeinfo['hid'] = $hotelid;
			
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel').'";</script>';

    	       die();   

    	    }



    	}

    	//生成显示状态的radio单选按钮

		
    	
		
		
		

        $this->load->view('admin/admin_roomtype_add',$roomtypeinfo);

    }


      /**

     * 保存免费房

     */

    public function save_freeroom()

    {

    	$fid = (int) $this->input->post('fid', TRUE);

    	$R_Title = $this->input->post('R_Title', TRUE);

    	$R_Content = stripcslashes($_POST['R_Content']);   

    	$R_HotelID = $this->input->post('R_HotelID', TRUE);

    	$R_HotelName = $this->input->post('R_HotelName', TRUE);
		
		$R_RoomID = $this->input->post('R_RoomID', TRUE);
		
		$R_Checkintime = $this->input->post('R_Checkintime', TRUE);
		
		$R_Checkouttime = $this->input->post('R_Checkouttime', TRUE);
		
		$R_states = $this->input->post('R_states', TRUE);
		
		$roomdata=explode(',',$R_RoomID);
		
		$hotelinfo=$this->model_hotel->get_hotelinfo($R_HotelID);

    	$data = array();

    	$data['fid'] = $fid;

    	$data['R_Title'] = $R_Title;

    	$data['R_Content'] = $R_Content;

    	$data['R_HotelID'] = $R_HotelID;

    	$data['R_HotelName'] = $R_HotelName;

    	$data['R_RoomID'] = $roomdata[0];
		
		$data['R_RoomName'] = $roomdata[1];

    	$data['R_Checkintime'] = strtotime($R_Checkintime);
		
		$data['R_Checkouttime'] = strtotime($R_Checkouttime);
		
		$data['R_states'] = $R_states;
		
		$data['R_Adder'] = $hotelinfo['Address'];
		
		$data['R_pic'] = $hotelinfo['picture'];
		
		$data['R_City'] = $hotelinfo['CityName'];
		
		$data['R_Area'] = $hotelinfo['eareaname'];
		
		$data['R_AddTime'] = time();
		
		


        if ( $fid > 0 ) {

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/freeroom').'";</script>';

    	       die();   

    	    }

            $result = $this->model_freeroom->save_freeroom($data,'update');

            if ($result) {

            	$alertMsg = '修改免费房成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/freeroom/'.$page);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '修改免费房失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}else {

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/freeroom').'";</script>';

    	       die();   

    	    }

            $result = $this->model_freeroom->save_freeroom($data,'insert');

            if ($result) {

            	$alertMsg = '添加免费房成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/freeroom');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '添加免费房失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}

    	

    }
	
	 public function save_roomtype()

    {

    	$rid = (int) $this->input->post('rid', TRUE);
		
		$hid = (int) $this->input->post('hid', TRUE);

    	$title = $this->input->post('title', TRUE);

    	$notes = stripcslashes($_POST['notes']);   

    	$bed = $this->input->post('bed', TRUE);

    	$adsl = $this->input->post('adsl', TRUE);
		
		$area = $this->input->post('area', TRUE);
		
		$floor = $this->input->post('floor', TRUE);
		
		$price = $this->input->post('price', TRUE);
		
		$roomimg = $this->input->post('roomimg', TRUE);
		
		

    	$data = array();

    	$data['rid'] = $rid;

    	$data['hid'] = $hid;

    	$data['title'] = $title;

    	$data['bed'] = $bed;

    	$data['notes'] = $notes;

    	$data['adsl'] = $adsl;
		
		$data['area'] = $area;

    	$data['floor'] = $floor;
		
		$data['status'] = 0;
		
		$data['price'] = $price;
		
		$data['roomimg'] = $roomimg;
		

        if ( $rid > 0 ) {

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/roomtype/'.$hid).'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_roomtype($data,'update');

            if ($result) {

            	$alertMsg = '修改房型成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/roomtype/'.$hid);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '修改房型失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}else {

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/roomtype/'.$hid).'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_roomtype($data,'insert');

            if ($result) {

            	$alertMsg = '添加房型成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/roomtype/'.$hid);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '添加房型失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}

    	

    }


    /**

     * 保存新闻

     */

    public function save_hotel()

    {

    	$hid = (int) $this->input->post('hid', TRUE);

    	$HotelName = $this->input->post('HotelName', TRUE);
		
		$CityID = $this->input->post('CityID', TRUE);
		
		$CityName = $this->input->post('CityName', TRUE);
		
		$eareaid = $this->input->post('eareaid', TRUE);
		
		$eareaname = $this->input->post('eareaname', TRUE);
		
		$cbd_name = $this->input->post('cbd_name', TRUE);
		
		$Min_price = $this->input->post('Min_price', TRUE);
		
		$Max_price = $this->input->post('Max_price', TRUE);
		
		$ZaocanPrice = $this->input->post('ZaocanPrice', TRUE);
		
		$BedPrice = $this->input->post('BedPrice', TRUE);
		
    	$Content = stripcslashes($_POST['Content']);   

    	$Address = $this->input->post('Address', TRUE);

		
		$soure = $this->input->post('soure_radio', TRUE);
		
		$star = $this->input->post('star', TRUE);
		
		$youhui = $this->input->post('youhui_radio', TRUE);
		
		$Service = $this->input->post('Service', TRUE);
		
		$Card = $this->input->post('Card', TRUE);
		
		$kaiye = $this->input->post('kaiye', TRUE);
		
		$zhuangxiu = $this->input->post('zhuangxiu', TRUE);
		
		$chain_name = $this->input->post('chain_name', TRUE);
		
		$chain_id = $this->input->post('chain_id', TRUE);
		
		$Tags = $this->input->post('Tags', TRUE);
		
		$Canyin = $this->input->post('Canyin', TRUE);
		$yulejianshen = $this->input->post('yulejianshen', TRUE);
		$kefangsheshi = $this->input->post('kefangsheshi', TRUE);
		$Rongyu = $this->input->post('Rongyu', TRUE);
		$Traffic = $this->input->post('Traffic', TRUE);
		
		$picture = $this->input->post('picture', TRUE);
		$Hotelpictures = $this->input->post('Hotelpictures', TRUE);
		
		$baidu_lng = $this->input->post('baidu_lng', TRUE);
		
		$baidu_lat = $this->input->post('baidu_lat', TRUE);
		
		$lng = $this->input->post('lng', TRUE);
		
		$lat = $this->input->post('lat', TRUE);
		
		$isShow = $this->input->post('isShow', TRUE);
		
		$paixu = $this->input->post('paixu', TRUE);
		

    	$data = array();

    	$data['hid'] = $hid;

    	$data['HotelName'] = $HotelName;
		
		$data['CityID'] = $data['ecityid']=$CityID;
		
		$data['CityName'] = $CityName;
		
		$data['eareaid'] = $eareaid;
		
		$data['eareaname'] = $eareaname;
				
		$data['Min_price'] = $Min_price;
		
		$data['Max_price'] = $Max_price;
		
		$data['ZaocanPrice'] = $ZaocanPrice;
		
		$data['BedPrice'] = $BedPrice;
		
    	$data['Content'] = $Content;

    	$data['Address'] = $Address;

    	$data['cbd_name'] = $cbd_name;

    	$data['soure'] = intval($soure);

    	$data['star'] = intval($star);
		
		foreach($youhui as $val){
			$data['youhui'] .= $val.",";
		}
		
		foreach($Service as $val){
			$data['Service'] .= $val."、";
		}
		
		foreach($Card as $val){
			$data['Card'] .= $val."、";
		}
		
		$data['kaiye'] = $kaiye;
		
		$data['zhuangxiu'] = $zhuangxiu;
		
		$data['chain_name'] = $chain_name;
		
		$data['chain_id'] = $chain_id;
		
		$data['Tags'] = $Tags;

		
		$data['yulejianshen'] = $yulejianshen;
		
		$data['kefangsheshi'] = $kefangsheshi;
		
		$data['Rongyu'] = $Rongyu;
		
		$data['Traffic'] = $Traffic;
		$data['picture'] = $picture;
		$data['Hotelpictures'] = $Hotelpictures;
		
		$data['baidu_lng'] = $baidu_lng;
		
		$data['baidu_lat'] = $baidu_lat;
		
		$data['lng'] = $lng;
		
		$data['lat'] = $lat;
		$data['isShow'] = $isShow;
		$data['paixu'] = $paixu;
		
		


        if ( $hid > 0 ) {

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel').'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_hotel($data,'update');

            if ($result) {

            	$alertMsg = '修改酒店成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/index/0/'.$page);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '修改酒店失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}else {

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel').'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_hotel($data,'insert');
			if($this->db->insert_id()){
				$sqlid['hid']=$this->db->insert_id();
				$sqlid['hotel_id']="A".$this->db->insert_id();
				$this->model_hotel->save_hotel($sqlid,'update');
			}
			
            if ($result) {

            	$alertMsg = '添加酒店成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '添加酒店失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}

    	

    }

    

    /**

     * 保存新闻

     */

    public function ajax_select_city()

    {
		$provinceid = $this->input->get_post('provinceid');
		$val = $this->input->get_post('val')?$this->input->get_post('val'):-1;


    	$citylist=$this->model_city->get_city($provinceid);
		
    	$citylist['-1']='选择城市';
        

        echo $citylist_select = form_dropdown('city',$citylist,$val,'onchange="getarea()" id=class_city');


    }
	
	public function ajax_select_area()

    {
		$cityid = $this->input->get_post('cityid');
		$val = $this->input->get_post('val')?$this->input->get_post('val'):-1;


    	$arealist=$this->model_city->get_area($cityid);
		$arealist['-1']='选择区域';
        echo $citylist_select = form_dropdown('area',$arealist,$val,'onchange="changeArea()" id=class_area');


    }
	
	public function ajax_select_cbd()
    {
		$cityid = $this->input->get_post('cityid');

    	$arealist=$this->model_city->get_cbd($cityid);
		$res='<ul id="cbd_list_con">';
    	foreach($arealist as $area){
			$res.="<li onclick='selectcbd(this)'><span>".$area['CBD_Name']."</span><p>".$area['cbd_id']."</p></li>";
		}
		$res.="</ul>";
		
		echo $res;
    }
	
	    public function roomtype()

    {    

        $data = array();

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;

    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;

        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;

        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);

        

        $page = intval($this->uri->segment(5)) ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 10 ;

        

        $hid = intval($this->uri->segment(4))?intval($this->uri->segment(4)):0 ;


        $hotelcount = $this->model_hotel->get_roomtype_count(array('hid'=>$hid));

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->model_hotel->get_roomtype_list('0','20','rid desc',' where hid='.$hid);

        //生成新闻分类的select菜单
        
        $config['base_url'] = base_url(CFG_ADMINURL.'/hotel/roomtype/'.$hid);

        $config['suffix'] = $this->config->item('url_suffix');

        $config['total_rows'] = $hotelcount ;

        $config['uri_segment'] = 5;

        $config['num_links'] = 8;

        $config['per_page'] = $pagesize;

        $config['use_page_numbers'] = true;

        $config['first_link'] = '<<';

        $config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

        $this->pagination->initialize($config); 

        $pagnav = $this->pagination->create_links();



        $data['method'] = $this->uri->segment(2) ;      

        $data['hotellist'] = $hotellist ;      

        $data['hotelcount'] = $hotelcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['page'] = $page;
		
		$data['hid'] = $hid;

        $data['type'] = $type;

        


        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_roomtype_list',$data);

    }



    

    /**

     * 删除新闻

     */

    public function del_hotel()

    {

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

    	$urlNewsid = $this->uri->segment(4);

    	$urlClassid = $this->uri->segment(5);

        $newsidArr = explode('-',$urlNewsid);

        $newsidStr = '';

        foreach ($newsidArr as $val) {

            $newsid = intval($val); 

            $newsidStr .= $newsid.',';      

        }

        $newsid = rtrim($newsidStr,',');

    	

    	if(!empty($newsid)){

    		$result = $this->model_hotel->del_hotel($newsid);

    		if($result){

    			redirect(CFG_ADMINURL.'/hotel/index/'.$urlClassid);

    		}else{

    			redirect(CFG_ADMINURL.'/hotel/index/'.$urlClassid);

    		}

    	}

    }
	
	 public function add_plan()

    {    

    	$rid = intval($this->uri->segment(4));
		
		$pid = intval($this->uri->segment(5));
		
		$roomtype=$this->model_hotel->get_roomtype($rid);
		
		$plan=$this->model_hotel->get_plan_list($rid,'-1');

    	if($pid > 0 ){

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/plan/'.$rid).'";</script>';

    	       die();   

    	    } 
			$roomtypeinfo = $this->model_hotel->get_plan($pid);
			


    	}else{
			
			$roomtypeinfo['rid'] = $rid;
			
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/plan/'.$rid).'";</script>';

    	       die();   

    	    }



    	}

    	//生成显示状态的radio单选按钮

		$roomtypeinfo['hid'] = $roomtype['hid'];
		$roomtypeinfo['plan'] = $plan;
    	$roomtypeinfo['rule'] = $roomtype=$this->model_hotel->get_rule_list($roomtype['hid']);
		$roomtypeinfo['arr_week'] = array('1'=>'周一','2'=>'周二','3'=>'周三','4'=>'周四','5'=>'周五','6'=>'周六','7'=>'周日');

		
		

        $this->load->view('admin/admin_plan_add',$roomtypeinfo);

    }
	
	
	
	
		 public function add_rule()

    {    

    	$hid = intval($this->uri->segment(4));
		
		$ruleid = intval($this->uri->segment(5));
		
		

    	if($ruleid > 0 ){

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel').'";</script>';

    	       die();   

    	    } 
			$roomtypeinfo = $this->model_hotel->get_rule($rid);
			


    	}else{
			
			$roomtypeinfo['hid'] = $hid;
			
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/add_rule').'";</script>';

    	       die();   

    	    }



    	}

    	//生成显示状态的radio单选按钮


        $this->load->view('admin/admin_rule_add',$roomtypeinfo);

    }
	
		 public function save_rule()

    {
		
		$data = array();

		$data['ruleid'] = (int) $this->input->post('ruleid', TRUE);
		
		$data['hid'] = (int) $this->input->post('hid', TRUE);

    	$data['ruletitle'] = $this->input->post('ruletitle', TRUE);

    	$data['rooms'] = $this->input->post('rooms', TRUE);
		
		$data['startime'] = $this->input->post('startime', TRUE);
		
		$data['endtime'] = $this->input->post('endtime', TRUE);
		
		$data['carddesc'] = $this->input->post('carddesc', TRUE);

		
		

    
		

        if ( $data['ruleid'] > 0 ) {

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/rule/'.$data['hid']).'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_rule($data,'update');

            if ($result) {

            	$alertMsg = '修改担保规则成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/rule/'.$data['hid']);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '修改担保规则失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}else {

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/rule/'.$data['hid']).'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_rule($data,'insert');

            if ($result) {

            	$alertMsg = '添加担保规则成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/rule/'.$data['hid']);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '添加担保规则失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}

    	

    }
	
	
	
	
			 public function save_plan()

    {
		
		$data = array();
		
		$data['planid'] = (int) $this->input->post('planid', TRUE);
		$data['rid'] = (int) $this->input->post('rid', TRUE);
		
		$data['fid'] = (int) $this->input->post('fid', TRUE);

		$data['planname'] =  $this->input->post('planname', TRUE);
		$data['priority'] = (int) $this->input->post('priority', TRUE);

    	$data['totalprice'] = $this->input->post('totalprice', TRUE);

    	$data['dayprice'] = $this->input->post('dayprice', TRUE);
		
		$data['startdate'] =strtotime( $this->input->post('startdate', TRUE));
		
		$data['enddate'] = strtotime($this->input->post('enddate', TRUE));
		
		$week = $this->input->post('week', TRUE);
		
		foreach($week as $wk){
			$data['week'].=$wk.',';
		}
		
		$data['ruleid'] = $this->input->post('ruleid', TRUE);
		
		$data['descption'] = $this->input->post('descption', TRUE);
		
		$data['addvalues'] = $this->input->post('addvalues', TRUE);
		
		$data['promotion'] = $this->input->post('promotion', TRUE);
		
		$data['menshi'] = $this->input->post('menshi', TRUE);
			
		$data['status'] = $this->input->post('status', TRUE);
		
		
		

    
		

        if ( $data['planid'] > 0 ) {

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/plan/'.$data['rid']).'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_plan($data,'update');

            if ($result) {

            	$alertMsg = '修改价格计划成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/plan/'.$data['rid']);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '修改价格计划失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}else {

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel/plan/'.$data['rid']).'";</script>';

    	       die();   

    	    }

            $result = $this->model_hotel->save_plan($data,'insert');

            if ($result) {

            	$alertMsg = '添加价格计划成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/plan/'.$data['rid']);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '添加价格计划失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}

    	

    }
	
	
	 public function plan()

    {    

        $data = array();

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;

    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;

        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;

        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);

        

        $page = intval($this->uri->segment(5)) ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 10 ;

        

        $rid = intval($this->uri->segment(4))?intval($this->uri->segment(4)):0 ;




        $hotellist = $this->model_hotel->get_plan_list($rid);

        //生成新闻分类的select菜单
        
        $config['base_url'] = base_url(CFG_ADMINURL.'/hotel/plan/'.$rid);

        $config['suffix'] = $this->config->item('url_suffix');

        $config['total_rows'] = $hotelcount ;

        $config['uri_segment'] = 5;

        $config['num_links'] = 8;

        $config['per_page'] = $pagesize;

        $config['use_page_numbers'] = true;

        $config['first_link'] = '<<';

        $config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

        $this->pagination->initialize($config); 

        $pagnav = $this->pagination->create_links();



        $data['method'] = $this->uri->segment(2) ;      

        $data['hotellist'] = $hotellist ;      


        $data['pagenav'] = $pagnav ;  

        $data['page'] = $page;

        $data['type'] = $type;

        


        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_plan_list',$data);

    }



	public function setTixianStatus()

    {    

    	$id = intval($this->uri->segment(5));
		$state = intval($this->uri->segment(4));
		
		$date['id']=$id;
		$date['status']=$state;
		

    	 $this->model_member->save_tixian($date,'update');
		 
		 $alertMsg = '订单状态更改成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/hotel/tixian_list');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
		
    }



        

}