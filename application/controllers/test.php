<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 *

 * @ID freeroom.php

 * 住哪酒店分销联盟（咨询）模块

 * @date 2013-1-24

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 *

 */



class Test extends CI_Controller 
{



    function __construct()

    {

        parent::__construct();
		
		$db = (array) $this->db;

       // $this->load->model('model_layout');
//
//        $this->load->model('model_keywords');
//
//        $this->load->model('model_sysconfig');
//
//        $this->load->model('model_lable');
//		$this->load->model('model_common');
//		
//		$this->load->model('model_tuangou');
//		
//		$this->load->library('email');
//
//        $this->load->library('dzsign');
//
        $this->load->library('lbs_requestcore');
//		
//		$this->output->enable_profiler(TRUE);
        

    }
	
	
    

	public function index()

	{
		
		$url="http://api.map.baidu.com/geodata/v2/poi/list?ak=85654a7702d8b2163b85f87e6585b4f5&geotable_id=32632";
		$api_list = file_get_contents($url);
		$api_list=json_decode($api_list);
		foreach($api_list->pois as $key=> $poi){
			$data=array();
			$url2="http://api.map.baidu.com/geodata/v2/poi/delete";
			$data['ak']='85654a7702d8b2163b85f87e6585b4f5';
			$data['geotable_id']='32632';
			$data['id']=$poi->id;
			
		$content = '';
        foreach ($data as $k => &$v) 
        {
            $v = urlencode($v);
            $content .= $k . '=' . $v . '&';
        }
        $content = substr($content, 0, strlen($content) - 1);

        
        if ($this->method_ === 'GET') { 
            $url2 .= '?' . $content;
        }
        
        $this->request_ = $this->Lbs_RequestCore;
        $this->request_->set_method('POST');
        $this->request_->set_useragent('Baidu_LbsYun_Sdk');

        $this->request_->set_body($content);
        
		
		}

	}
	function getArrfile($data){
		$res='';
		foreach($data as $val){
			if($val){
				if($res){
					$res.=",".$val;
				}
				else{
					$res=$val;
				}
				
			}
		}
		return $res;
	}
	
	public function getregions(){
		
		$this->load->model('model_city');
		$city= $this->model_tuangou->dazhong_get_cities();
		foreach($city['cities'] as $cname){
			print_r($cname);
			$regions=$this->model_tuangou->dazhong_get_regions_with_deals($cname);
			$i=1;
			foreach($regions['cities'][0]['districts'] as $area){
				
			//$areainfo= $this->model_city->get_areainfo_byname($area['district_name'],$cityid);
			
			
			foreach($area['neighborhoods'] as $key=> $res){
				if($i<10){
					$j='0'.$i;
				}
				else{
					$j=$i;
				}
				$data['cityname']=$cname;
				$data['areaname']=$area['district_name'];
				$data['regionid']=$j;
				$data['regionname']=$res;
				$this->model_city->save_resgoin($data);
				echo $res;
				$i++;
			}
		}
		}
		
	}
	
	public function gethotcity(){
		
		$areainfo= $this->model_city->getCityToABCD();
		print_r($areainfo);
	}
	public function getlashoucity()
	{
		$areainfo= $this->model_tuangou->lashou_get_cities();
		$city_arr="<?php\r\n";
		foreach($areainfo->url as $url){
			$city_arr.="\$city[$url->city_id]='$url->city_name'; \r\n";
		}
		$city_arr.="?>";
		$res=file_put_contents('data/city/lashou.php',$city_arr);
		print_r($res);
	}
	public function get_lashou_deals(){
		
		$areainfo= $this->model_tuangou->lashou_get_deals(2421);
		foreach($areainfo->url as $url){
			if($url->data->display->class=='酒店'){
				$data['dealsid']= $url->data->display->identifier ;
				$data['loc']= ''.$url->loc ;
				
				$data['waploc']= ''.$url->wapLoc ;
				$data['website']= ''.$url->data->display->website ;
				$data['siteurl']= ''.$url->data->display->siteurl ;
				$data['city']= ''.$url->data->display->city ;
				$data['category']=1;
				$data['subcategory']= ''.$url->data->display->subClass ;
				
				$data['characteristic']='';
				$data['destination']='';
				
				$data['thrcategory']='';
				$data['major']='';
				$data['title']= ''.$url->data->display->title ;
				$data['shortTitle']= ''.$url->data->display->shortTitle ;
				$data['image']=''. $url->data->display->image ;
				$data['startTime']= $url->data->display->startTime ;
				
				$data['endTime']= $url->data->display->endTime ;
				$data['value']= $url->data->display->value ;
				$data['price']= $url->data->display->price ;
				$data['rebate']= ''.$url->data->display->rebate ;
				$data['bought']= ''.$url->data->display->bought ;
				$data['name']='';
				
				
				$data['spendEndTime']=strtotime($url->data->display->merchantEndTime);
				$data['refund']='';
				$data['reservation']='';
				
				$data['tips']= ''.$url->data->display->tip ;
				
				
				$data['seller']= ''.$url->data->shops->shop->name ;
				
				$data['phone']= ''.$url->data->shops->shop->tel ;
				$data['address']= ''.$url->data->shops->shop->addr ;
				$data['longitude']=''. $url->data->shops->shop->longitude ;
				$data['latitude']= ''.$url->data->shops->shop->latitude ;
				
				$data['range']= ''.$url->data->shops->shop->area ;
				$areainfo= $this->model_city->get_resgoin_byname($url->data->shops->shop->area );
				$data['locationName']=$areainfo['areaname'];
				$data['dpshopid']=0;
				$data['uptime']=time();
				$data['hits']=0;
			
				
				
				$this->model_tuangou->addTuangou('insert',$data);
				echo $data['title']."添加成功<br>";	
				
				
				sleep(0.1);
				
				
				
				
			}
		}
	}
	
	public function test(){
		
		$url="http://api.map.baidu.com/geodata/v2/poi/list?ak=85654a7702d8b2163b85f87e6585b4f5&geotable_id=32632";
		$api_list = file_get_contents($url);
		print_r($api_list);
		
	}
	
	public function scr2()
	{
		echo  bin2hex('1');
	}
	
	
}






