<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID news.php
 * 携行酒店分销联盟（咨询）模块
 * @date 2013-1-24
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Tuangouinfo extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_keywords');
        $this->load->model('model_sysconfig');
        $this->load->model('model_tuangou');
		$this->load->model('model_hotel');
        $this->load->model('model_city');
		$this->load->model('model_website');
		$this->load->model('model_tags');
		$this->load->model('model_common');
		$this->load->helper('text');
        $this->load->library('pagination');
        $this->load->library('tool');
       // $this->output->enable_profiler(TRUE);
    }
    
	public function index()
	{
        
         $layout = $this->model_layout->get_layout('hotelinfo');
		 
        $newsid = $this->uri->segment(2);
		$info = $this->model_tuangou->get_tuaninfo($newsid);
		if(empty($info)) {
		  show_error('很抱歉，您所访问的内容已被删除或不存在！',404);	
		}
		$city=$this->model_city->get_city_byname($info['city']);
		$weblist=$this->model_website->getwebList(1,10);
		$taglist=$this->model_tags->gettagList(1,10);
		
		//print_r($city);
		$info['LableByHotelXY']=$this->model_hotel->getLableByHotelXY('0201','3124169','12148193');
		$info['nearbyHotel']=$this->model_tuangou->geosearchnearby($info['longitude'].",".$info['latitude']);
		$info['nearbyTuan']=$this->model_tuangou->geosearchnearby($info['longitude'].",".$info['latitude'],'',"34835");
		
		foreach($info['nearbyTuan']['contents'] as $key=>$val){
			if($ids){
				$ids.=','.$val['dealsid'];
			}
			else{
				$ids=$val['dealsid'];
			}
			
		}
		if($ids){
		$info['nearbyTuan']=$this->model_tuangou->get_guantoulist_by_ids($ids);
		}
		else{
			$info['nearbyTuan']='';
		}
		//print_r($info['nearbyTuan']);
		
		
		$info['hotelyd']=$this->model_hotel->getHotelInfo($info['nearbyHotel']['contents'][0]['api_id']);
		
		 $Service = $this->tool->Select_Info($info['hotelyd']['Service']);

        $info['hotelyd']['Service'] = explode("、",rtrim($Service,'、')); 
		
		//处理好评

        $info['hotelyd']['HaoPing'] = $this->tool->hoteldianping($info['hotelyd']['HaoPing'],3);

        $info['hotelyd']['HaoPing'] = $info['hotelyd']['HaoPing'][0];
		
		//print_r($info['hotelyd']['HaoPing']);
		
		 //更新浏览记录的cookie

        $this->model_common->setHistoryTuan($info['tid'],$info['shortTile'],$info['price']);
		//print_r($info['hotelyd']);
		
		$info['layout']= $layout ;
		$info['city']=$city;
		$info['weblist']=$weblist;
		$info['taglist']=$taglist;
		$this->load->view('tuangouinfo',$info);
	}
	
	private function baseUrl($cityid, $page, $order, $area, $range, $star ,$fangxing ,$price,$category) 

	{

		$aTag = array ("area", 'range', 'star', 'fangxing','price', 'order', 'page','category' );

		foreach ( $aTag as $val ) {

			

			$list_url = "/tuangou/$cityid/p-1";
			
			if ($category&&$val!='category') {

				$list_url .= "-category-".urlencode($category);

			}


			if ($area&&$val!='area') {

				$list_url .= "-area-".urlencode($area);

			}
			if ($page&&$val!='page') {

				$list_url .= "-page-".urlencode($page);

			}

			if ($range &&$val!='range') {

				$list_url .= "-range-".urlencode($range);

			}
			
			if ($star&& $val!='star' ) {

				$list_url .= "-star-".urlencode($star);

			}

			if ($fangxing &&$val!='fangxing') {

				$list_url .= "-fangxing-$fangxing";

			}

			if ($price &&$val!='price') {

				$list_url .= "-price-$price";

			}


			if ($val != 'order') {

				$list_url .= "-order-$order";

			}

			$rt [$val] = $list_url;

		}

		return $rt;

	}

	
	public function add_buy(){
		echo "ok";
	}

}
