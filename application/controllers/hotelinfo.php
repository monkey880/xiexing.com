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



class Hotelinfo extends CI_Controller 

{

    private $data;

    function __construct()

    {

        parent::__construct();

        $this->load->model('model_common');

        

        $this->load->model('model_layout');

        $this->load->library('tool');

        $this->load->model('model_hotel');
		
		$this->load->model('model_member');

        $this->load->library('pagination');

        $this->data = array();
		

    }

    

	public function index()

	{

        //载入布局模型

        $layout = $this->model_layout->get_layout('hotelinfo');

        

        $hotelId = $this->uri->segment(2)!='' ? $this->uri->segment(2) : 7225; 

        //酒店详细信息
		if(strchr($hotelId,"A"))
		{
        $hotelInfo = $this->model_hotel->get_hotelinfo($hotelId);
		//$hotelInfo['star']=$hotelInfo['star']-1;
		
		}
		else{
			 $hotelInfo = $this->model_hotel->getHotelInfo($hotelId);
		
		$hotelInfo2 = $this->model_hotel->get_hotelinfo($hotelId);
			
		}
        //酒店所在城市id和城市名称


        $cityid = $hotelInfo['CityID'];

        $ecityid = $hotelInfo['ecityid'];

        $_GET['cityid'] =  $ecityid;

        $cityname = $hotelInfo['CityName'];

        $hotelName = $hotelInfo['HotelName'];

        $this->data['cityid'] = $ecityid;
		if($hotelInfo2['youhui']){
		$this->data['youhui'] = explode(',',$hotelInfo2['youhui']);
		}

        $this->data['cityname'] = $cityname;

        $this->data['hotelId'] = $hotelId;

        $this->data['hotelName'] = $hotelName;

        //处理酒店标签字段并赋值给$hotelInfo

        $hotelInfo['Tags'] = $this->tool->tags_ary($hotelInfo['Tags']) ;

        //酒店评论信息

        $this->getComment($hotelId,5);

        //酒店问答信息

        $this->getQuestion($hotelId,5);

        //处理酒店图片并赋值给$hotelInf
		
		if(strchr($hotelId,"A"))
		{

        $hpicshow = $this->tool->hpicshow2($hotelInfo['Hotelpictures']);
		}
		else
		{
			$hpicshow = $this->tool->hpicshow($hotelInfo['Hotelpictures'],$hotelName);
		}
		
		
		

        $hotelInfo['hpicshow'] = $hpicshow;

        $hotelInfo['hpicshowNumber'] = count($hpicshow);

        //处理服务信息并赋值给$hotelInfo

        $Service = $this->tool->Select_Info($hotelInfo['Service']);

        $hotelInfo['Service'] = explode("、",rtrim($Service,'、')); 

        //处理地理位置并赋值给$hotelInfo

        $hotelInfo['Traffic'] =  $this->model_hotel->trafficShow($hotelInfo['Traffic']);

        //处理酒店星级
		if(!strchr($hotelId,"A"))
		{
        $hotelInfo['star'] = $this->tool->hotelranknamenum($hotelInfo['star']);
		}

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

        $keywords_array = $this->model_common->getKeywords('hotelinfo');

        $keywords_array = str_replace(array('{doname}','{hotelnames}','{cityname}'),array(CFG_WEBNAME,$hotelInfo['HotelName'],$hotelInfo['CityName']),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;

        

        //侧边栏周边酒店用到的参数

        $roundhotel['sort'] = 'hotelinfo';

        $this->data['roundhotel'] = $roundhotel;
		
		$this->load->library('session');
		
      if($this->session->userdata('xexinguserinfo')){

        	$this->data['loginsate']=1;

        }

        

        $this->data['hotelInfo'] = $hotelInfo;

        $this->data['method'] = $this->uri->segment(1) ; 

        $this->load->view('hotelinfo',$this->data);
		

	}




	public function getroom(){
		$hid=$this->input->get_post("hid");
		$tm1=$this->input->get_post("tm1");
		$tm2=$this->input->get_post("tm2");
		$hotelInfo = $this->model_hotel->get_hotelinfo($hid);
		$hid=explode(',',$hid);
		$myhid=array();
		$apihid='';
		foreach($hid as $hotelid){
			if(strchr($hotelid,"A"))
			{
				$myhid[]=$hotelid;
			}
			else
			{
				if($apihid){
					$apihid.=','.$hotelid;
				}
				else
				{
					$apihid=$hotelid;
				}
			}
		}
		
		
		$apiroom=$this->model_hotel->getroom($apihid,$tm1,$tm2);
		
		
	
		
		
		
		
		$res='var _Data=[';
       // '"zid": "'.$hid.'",'.
//        '"eid": "0",'.
//        '"tm1": "'.$tm1.'",'.
//        '"tm2": "'.$tm2.'",'.
//        '"status": "0",'.
//        '"Promotion": "","rooms":[';
		$n=0;
		foreach($myhid as $hid){
			$rm = $this->model_hotel->get_roomtype_list('0','10','rid desc',"where hid='".$hid."'");
		$roomtai['zid']=$hid;
		$roomtai['eid']='786556';
		$roomtai['tm1']=$tm1;
		$roomtai['tm2']=$tm2;
		$roomtai['status']=0;
		$roomtai['Promotion']='';
		
		
		foreach($rm as $r){
			
			
			$room=array();
			$room['rid']=(int)$r['rid'];
			$room['title']=$r['title'];
			$room['adsl']=$r['adsl'];
			$room['bed']=$r['bed'];
			$room['area']=$r['area'];
			$room['floor']=$r['floor'];
			$room['status']=(int)$r['status'];
			$room['notes']=$r['notes'];
			$room['AvailableAmount']='';
			
			$img=explode(',',$r['roomimg']);
			foreach($img as $p){
					if($p){
						$roompic['spic']=$p;
						$roompic['type']='99';
						$roompic['title']=$r['title'];
						$roompic['imgurl']=$p;
						$room['img'][]=$roompic;
					}
			}
			
			
			$plan=$this->model_hotel->get_plan_list($r['rid'],'-1',strtotime($tm1),strtotime($tm2));
			$temp_plan=array();
			foreach($plan as $p){
				$temp_plan['planid']=$p['planid'];
				$temp_plan['planname']=$p['planname'];
				
				$temp_plan['priceCode']='RMB';
				$temp_plan['iscard']=$p['iscard'];
				
				$rule=$this->model_hotel->get_rule($p['ruleid']);
				
				$temprule['romms']=$rule['romms'];
				$temprule['status']=$rule['status'];
				$temprule['norule']='0';
				$temprule['stattime']=$rule['stattime'];
				$temprule['endtime']=$rule['endtime'];
				
				$temp_plan['cardrule']=$temprule;
				
				$temp_plan['carddesc']=$p['carddesc'];
				$temp_plan['jiangjin']='0';
				
				
				$stardate=strtotime($tm1);
				$enddate=strtotime($tm2);
				$temp_plan['date']='';
				$temp_plan['totalprice']='';
				for($i=$stardate;$i<$enddate;$i=$i+3600*24){
					$tmprice=array();
					$price=$this->model_hotel->get_dayprice($i,$r['rid'],$p['planid']);
					$tmprice['day']=date('Y-m-d',$i);
					$dayarr=getdate($i);
					$tmprice['week']=$dayarr['wday'];
					if($price){
						if($price['week']){
							if(strpos($price['week'],(string)$dayarr['wday'])>-1){
								$tmprice['price']=$price['dayprice'];
								$temp_plan['totalprice']+=$price['dayprice'];
								$tmprice['menshi']=$price['menshi'];
								$tmprice['jiangjin']=$price['jiangjin'];
								
							}
							else{
								
								
									$tmprice['price']=$p['dayprice'];
						$temp_plan['totalprice']+=$p['dayprice'];
					$tmprice['menshi']='----';
					$tmprice['jiangjin']=$r['jiangjin'];
								
								}
						}
						else{
					$tmprice['price']=$price['dayprice'];
					$temp_plan['totalprice']+=$price['dayprice'];
					$tmprice['menshi']=$price['menshi'];
					$tmprice['jiangjin']=$price['jiangjin'];
						}
					}
					
					else{
						$tmprice['price']=$p['dayprice'];
						$temp_plan['totalprice']+=$p['dayprice'];
					$tmprice['menshi']='----';
					$tmprice['jiangjin']=$r['jiangjin'];
					}
					
					$temp_plan['date'][]=$tmprice;
				}
				
				
				$temp_plan['description']=array('AddValues'=>$rule['descption'],'Promotion'=>'','GaranteeRule'=>'');
				$temp_plan['menshi']='0';
				$temp_plan['status']='0';
				$room['plans'][]=$temp_plan;
			}
			$roomtai['rooms'][]=$room;
		}
		
		 $res.=json_encode($roomtai);
		$n++;
		}
		if($n){
			$res.=',';
		}
		$res.=$apiroom;
      $res.= '];if(callback){
    callback(_Data)
}else{
    alert("Err: callback")
};';
		
		
		

		echo $res;
		
	}

    public function getComment($hotelId,$limit)

    {

        $getCommentList = $this->model_hotel->getCommentList($hotelId);
		
		$getCommentList2 = $this->model_member->getcomment($hotelId);

        $this->data['commentNumber'] = $getCommentList['retHeader']['totalput'];//评论数量 
		
		$getCommentList = array_slice($getCommentList['reqdata'],0,$limit);//评论列表

        $this->data['commentList'] =$getCommentList;//array_merge($getCommentList2,$getCommentList); 
		
		
		

    }

    

    public function getQuestion($hotelId,$limit)

    {

        $getQuestionList = $this->model_hotel->getQuestionList($hotelId,$limit);

        $questionList = $getQuestionList['reqdata'];
		
		if(strchr($hotelId,"A"))
		{
			$this->data['questionNumber']=0;
		}
		else{

        $this->data['questionNumber'] = $getQuestionList['retHeader']['totalput'];//问答数量
		}
        $this->data['questionList'] = $questionList;

    }

}