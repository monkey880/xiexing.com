<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 *

 * @ID hotelinfo.php

 * 住哪酒店分销联盟（酒店详情）模块

 * @date 2013-2-18

 * @author yuhailong zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 *

 */



class Freeroominfo extends CI_Controller 

{

    private $data;

    function __construct()

    {

        parent::__construct();

        $this->load->model('model_common');

        

        $this->load->model('model_layout');

        $this->load->library('tool');

        $this->load->model('model_hotel');
		
		$this->load->model('model_freeroom');
		
		$this->load->model('model_member');

        $this->load->library('pagination');
		
		//$this->output->enable_profiler(TRUE);

                

        

        $this->data = array();

    }

    

	public function index()

	{

        //载入布局模型

        $layout = $this->model_layout->get_layout('hotelinfo');

        

        $fid = $this->uri->segment(2)!='' ? $this->uri->segment(2) : 770; 

        //酒店详细信息

        $roominfo = $this->model_freeroom->get_freeroominfo($fid);
		$hotelInfo = $this->model_hotel->get_hotelinfo($roominfo['R_HotelID']);
		$hotelorder = $this->model_hotel->get_orderlist('0','10','addtime desc','where type=1  and hotel_id="'.$roominfo['R_HotelID'].'"');
		
		$where=array('type'=>1,'hotel_id'=>$roominfo['R_HotelID']);
		$sqnum=$this->model_hotel->get_ordercount($where);
		
		 $this->data['sqnum'] = $sqnum;
		 
		 
		 $hotelorder2 = $this->model_hotel->get_orderlist('0','10','CheckInDate desc','where type=1 and state=1 and hotel_id="'.$roominfo['R_HotelID'].'"');
		
		$where2=array('type'=>1,'state'=>1,'hotel_id'=>$roominfo['R_HotelID']);
		$sqnum2=$this->model_hotel->get_ordercount($where2);
		
		 $this->data['sqnum2'] = $sqnum2;
		
        //酒店所在城市id和城市名称
		$hotelId=$roominfo['R_HotelID'];

        $cityid = $hotelInfo['CityID'];

        $ecityid = $hotelInfo['ecityid'];

        $_GET['cityid'] =  $ecityid;

        $cityname = $hotelInfo['CityName'];

        $hotelName = $hotelInfo['HotelName'];

        $this->data['cityid'] = $ecityid;

        $this->data['cityname'] = $cityname;

        $this->data['hotelId'] = $hotelId;

        $this->data['hotelName'] = $hotelName;

        //处理酒店标签字段并赋值给$hotelInfo

        $hotelInfo['Tags'] = $this->tool->tags_ary($hotelInfo['Tags']) ;

      //  //酒店评论信息
//
//        $this->getComment($hotelId,5);
//
//        //酒店问答信息
//
//        $this->getQuestion($hotelId,5);

        //处理酒店图片并赋值给$hotelInfo

        $hpicshow = $this->tool->hpicshow($hotelInfo['Hotelpictures']);

        $hotelInfo['hpicshow'] = $hpicshow;

        $hotelInfo['hpicshowNumber'] = count($hpicshow);

        //处理服务信息并赋值给$hotelInfo

        $Service = $this->tool->Select_Info($hotelInfo['Service']);

        $hotelInfo['Service'] = explode("、",rtrim($Service,'、')); 

        //处理地理位置并赋值给$hotelInfo

        $hotelInfo['Traffic'] =  $this->model_hotel->trafficShow($hotelInfo['Traffic']);

        //处理酒店星级

        $hotelInfo['star'] = $this->tool->hotelranknamenum($hotelInfo['star']);

        //处理好评

        $hotelInfo['HaoPing'] = $this->tool->hoteldianping($hotelInfo['HaoPing'],3);

        $hotelInfo['HaoPing'] = $hotelInfo['HaoPing'][0];

        //处理酒店附近地标

        $hotelInfo['NearbyPoints'] = $this->model_hotel->getLableByHotelXY($ecityid,$hotelInfo['lat'],$hotelInfo['lng']);

        //$this->dump($hotelInfo['NearbyPoints']);

        //初始化日期

        $tm1 = date("Y-m-d",mktime());   

        $tm2 = date("Y-m-d",(mktime()+345600)); 

        $this->data['sk_array'] =  array('tm1'=>$tm1,'tm2'=>$tm2);

        $this->data['order_api'] = ZHUNA_ORDER_API;

        //酒店模板

        $this->data['layout'] = $layout ;

        

        //更新浏览记录的cookie

        $this->model_common->setHistoryHotel($hotelId,$hotelName,$hotelInfo['Min_price']);

        

        //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('zhu72');

        $keywords_array = str_replace(array('{doname}','{hotelnames}','{cityname}'),array(CFG_WEBNAME,$hotelInfo['HotelName'],$hotelInfo['CityName']),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        

        //侧边栏周边酒店用到的参数

        $roundhotel['sort'] = 'hotelinfo';

        $this->data['roundhotel'] = $roundhotel;
		
		$this->data['roominfo'] = $roominfo;
		
		$this->data['hotelorder'] = $hotelorder;
		
		$this->data['hotelorder2'] = $hotelorder2;

        

        $this->data['hotelInfo'] = $hotelInfo;

        $this->data['method'] = $this->uri->segment(1) ; 

        $this->load->view('freeroominfo',$this->data);
		

	}
	
	public function zengsong(){
		 //载入布局模型

        $layout = $this->model_layout->get_layout('news');
		
		 $type = $this->uri->segment(3)!='' ? $this->uri->segment(3) : 2; 
		
		$hotelorder = $this->model_hotel->get_orderlist('0','10','addtime desc','where type='.$type.'  ');
		
		$where=array('type'=>$type,'state'=>0);
		$sqnum=$this->model_hotel->get_ordercount($where);
		
		 $data['sqnum'] = $sqnum;
		 
		 
		 $hotelorder2 = $this->model_hotel->get_orderlist('0','10','CheckInDate desc','where type='.$type.' and state=1 ');
		
		$where2=array('type'=>$type,'state'=>1);
		$sqnum2=$this->model_hotel->get_ordercount($where2);
		
		 $data['sqnum2'] = $sqnum2;
		
		$this->pagination->initialize($config); 

		$pagnav = $this->pagination->create_links();

        

        //替换meta信息

        $meta = $this->model_keywords->getKeywords('zhu74');

        $sysconfig = $this->model_sysconfig->getSysconfig();

 

        $search = array('{doname}','{classname}');

        $meta_replace = array($sysconfig['cfg_webname'],'住七送一');

        $meta_array = str_replace($search, $meta_replace, $meta);



        $data = array();
		
		$data['layout'] = $layout ; 
		
		$data['type'] = $type ; 
		
		$data['sqnum2'] = $sqnum2;
		
		$data['hotelorder'] = $hotelorder;
		
		$data['hotelorder2'] = $hotelorder2;
		
		$this->load->view('freeroom2',$data);
	}

}