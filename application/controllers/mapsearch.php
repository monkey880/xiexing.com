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

class Mapsearch extends CI_Controller 
{
    
    private $data ;
    
    function __construct()
    {
        parent::__construct();
        $this->data = array();
        
        $this->load->model('model_common');
        $this->load->model('model_city');
		$this->load->model('model_lable');
                
    }
    
	public function index()
	{
		$cityid = $this->uri->rsegment(3);
		if(!$cityid){
			$cityid='shanghai';
		}
		$cityinfo=$this->model_city->get_city_bypinxin($cityid);
		
		$hotelcity=$this->model_city->getHotCity(12);
		$abccity=$this->model_city->getCityToABCD();
		$area_arr=$this->model_city->get_area($cityinfo['cid']);
		//著名商圈

		$cbd_list = $this->model_common->getCBD ($cityinfo['cid'], '0', '' );
		
		$TrainLable = $this->model_common->getTrainLable ($cityinfo['cid'],20 );
		$SubwayLable = $this->model_lable->getSubwayLable($cityinfo['cid']);
		$daxue = $this->model_lable->getLable2($cityinfo['cid'],83,20 );
		$jingdian = $this->model_lable->getLable2($cityinfo['cid'],65,20 );
		$yiyuan = $this->model_lable->getLable2($cityinfo['cid'],119,20 );
		
		$SubwayLable =json_decode($SubwayLable);
		
	

		foreach ( $cbd_list as $cbd_val ) {

			if ($cbd_id == $cbd_val ['cbd_id']) {

				$cbd_name = $cbd_val ['CBD_Name']; break;

			}

		}

		$cbd_name = ! empty ( $cbd_name ) ? $cbd_name : '';
		
		$data['area_arr'] = $area_arr ;  
		$data['star_arr'] = $star_arr ;
		$data['cbd_list'] = $cbd_list;
		$data['TrainLable'] = $TrainLable;
		$data['SubwayLable'] = $SubwayLable;
		$data['daxue'] = $daxue;
		
		$data['jingdian'] = $jingdian;
		$data['yiyuan'] = $yiyuan;
		
		
		$data['hotelcity'] = $hotelcity ;  
		$data['abccity'] = $abccity ;  
		$data['cityinfo'] = $cityinfo ;  
      
		$this->load->view('mapsearch',$data);
	}
}