<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID Model_admin.php
 * 管理员model
 * @date 2013-1-29 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_tuangou extends CI_Model
{
	private $admin_table;
	
	function __construct()
	{
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->admin_table = $db['dbprefix'].'admin';
        $this->tuangou_table = $db['dbprefix'].'tuan';
		$this->tuangou_buess_table = $db['dbprefix'].'tuan_businesses';
       $this->load->library('dzsign');
	   $this->nearbyurl="http://api.map.baidu.com/geosearch/v2/nearby?ak=49f486cee7d86ebfde42cad8566f5576&geotable_id=";
    }
    
    /**
     * 获得大众点订团购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
    function dazhong_get_all_id_list($city,$category='')
    {
		
		$para['city']=$city;
		
		$para['category']=$category;
		
		$sign=$this->dzsign->mySign($para);
		
    	$apiUrl = CFG_DZ_URL."deal/get_all_id_list?appkey=".DZ_APPKEY."&sign=$sign";
		
		$api_list=file_get_contents($apiUrl);
			$api_list=	json_decode($api_list,true);
        return $api_list;
      
    }
	 function dazhong_get_daily_new_id_list($city,$category='',$date='')
    {
		
		$para['city']=$city;
		$para['date']=$date;
		$para['category']=$category;
		
		$sign=$this->dzsign->mySign($para);
		
    	$apiUrl = CFG_DZ_URL."deal/get_daily_new_id_list?appkey=".DZ_APPKEY."&sign=$sign";
		
		$api_list=file_get_contents($apiUrl);
			$api_list=	json_decode($api_list,true);
        return $api_list;
      
    }
	
	 function dazhong_get_single_deal($deal_id)
    {
		
		$para['deal_id']=$deal_id;
		
		
		$sign=$this->dzsign->mySign($para);
		
    	$apiUrl = CFG_DZ_URL."deal/get_single_deal?appkey=".DZ_APPKEY."&sign=$sign";
		
		$api_list=file_get_contents($apiUrl);
			$api_list=	json_decode($api_list,true);
        return $api_list;
      
    }
	
	 function dazhong_get_regions_with_deals($city)
    {
		
		$para['city']=$city;
		
		
		$sign=$this->dzsign->mySign($para);
		
    	$apiUrl = CFG_DZ_URL."metadata/get_regions_with_deals?appkey=".DZ_APPKEY."&sign=$sign";
		
		$api_list=file_get_contents($apiUrl);
			$api_list=	json_decode($api_list,true);
        return $api_list;
      
    }
	
	 function dazhong_get_cities()
    {
		$sign=$this->dzsign->mySign($para);
		
    	$apiUrl = CFG_DZ_URL."metadata/get_cities_with_businesses?appkey=".DZ_APPKEY."&sign=$sign";
		
		$api_list=file_get_contents($apiUrl);
			$api_list=	json_decode($api_list,true);
        return $api_list;
      
    }
	
	 /**
     * 获得拉手团购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 
	  function lashou_get_cities()
    {
		
		
    	$apiUrl = "http://open.lashou.com/opendeals/lashou/city.xml";
		
		$api_list=simplexml_load_file($apiUrl);
			
        return $api_list;
      
    }
	
	  function lashou_get_deals($cityid)
    {
		
		
    	$apiUrl = "http://open.lashou.com/opendeals/lashou/$cityid.xml";
		
		$api_list=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);
			
        return $api_list;
      
    }
	
		 /**
     * 获得美团购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 
	  function meituan_get_cities()
    {
		
		
    	$apiUrl = "http://www.meituan.com/api/v1/divisions";
		
		$api_list=simplexml_load_file($apiUrl);
			
        return $api_list;
      
    }
	
	  function meituan_get_deals($cityid)
    {
		
		
    	$apiUrl = "http://www.meituan.com/api/v2/$cityid/deals";
		
		$api_list=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);
			
        return $api_list;
      
    }
	
		 /**
     * 获得糯米购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 
	  function nuomi_get_cities()
    {
		
		
    	$apiUrl = "http://www.meituan.com/api/v1/divisions";
		
		$api_list=simplexml_load_file($apiUrl);
			
        return $api_list;
      
    }
	
	  function nuomi_get_deals($city)
    {
		
		
    	$apiUrl = "http://www.nuomi.com/api/dailydeal?version=v1&city=$city";
		
		$api_list=simplexml_load_file($apiUrl);
			
        return $api_list;
      
    }
	
		 /**
     * 获得窝窝购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 

	
	  function wowotuan_get_deals($city)
    {
		
		
    	$apiUrl = "http://www.55tuan.com/partner/partnerApi?partner=wowo&city=$city";
		
		$api_list=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);
			
        return $api_list;
      
    }
	
		 /**
     * 获得窝窝购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 

	
	  function didatuan_get_deals($city)
    {
		
		
    	$apiUrl = "http://www.didatuan.com/api/openapi?city=$city";
		
		$api_list=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);
			
        return $api_list;
      
    }

		 /**
     * 获得团购王信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 

	
	  function gocn_get_deals($city)
    {
		
		
    	$apiUrl = "http://www.go.cn/api/detail.php?city=$city";
		
		$api_list=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);
			
        return $api_list;
      
    }
	
	
		 /**
     * 获得260团购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 

	
	  function tuan260_get_deals()
    {
		
		
    	$apiUrl = "http://api.260tuan.com/api/baiduapi.xml";
		
		$api_list=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);
			
        return $api_list;
      
    }
	
	
		 /**
     * 获得260团购信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
	 

	
	  function uutuan_get_deals()
    {
		
		
    	$apiUrl = "http://www.51uutuan.com/api/hao123.xml";
		
		$api_list=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);
			
        return $api_list;
      
    }



     /**
     * 获取新闻详情
     * @param $newsid
     * @return array
     */
    function get_tuaninfo_bytid($tid)
    {
        $query = $this->db->where("dealsid = '$tid' ")->get($this->tuangou_table)->row_array();
        return $query;
    }
	
	function get_tuaninfo_byurl($url)
    {
        $query = $this->db->where("loc = '$url' ")->get($this->tuangou_table)->row_array();
        return $query;
    }
	
	 function get_tuaninfo($tid)
    {
        $query = $this->db->where("tid = '$tid' ")->get($this->tuangou_table)->row_array();
        return $query;
    }
  
    function get_tuanbuess($tid,$buessid)
    {
        $query = $this->db->where("tid = '$tid'  and businessesid='$buessid'")->get($this->tuangou_buess_table)->row_array();
        return $query;
    }

	public function get_guantoulist($start=10,$nums=2,$order='tid desc',$where='')

    {

    	$query = $this->db->query("select * from $this->tuangou_table $where order by $order,tid desc limit $start,$nums")->result_array() ;


        return $query;
    }	
	
	public function get_guantoulist_by_ids($ids)

    {

    	$query = $this->db->query("select * from $this->tuangou_table where dealsid in ($ids) ")->result_array() ;


        return $query;
    }	
    
  	function get_tuangou_count($condition=array())
    {

    	$count = $this->db->where($condition)->count_all_results($this->tuangou_table);

    	return $count;
		
    }
	
	function get_tuangou_count2($wheresql)
    {

    	$count = $this->db->query("select tid from $this->tuangou_table ".$wheresql)->num_rows();
		
		

    	return $count;
		
    }

    public function addTuangou($mode = 'insert',$info,$where=array())
    {
    	if ($mode == 'insert') {
    		$rs = $this->db->insert($this->tuangou_table,$info);
			$id=$this->db->insert_id();
    	} else {
    		$rs = $this->db->update($this->tuangou_table,$info,$where);
			$id=$this->db->insert_id();
    	}
    	return $id;
    }
	 public function addTuanBuess($mode = 'insert',$info,$where=array())
    {
    	if ($mode == 'insert') {
    	 $rs=$this->db->insert($this->tuangou_buess_table,$info);
			
    	} else {
    		$rs=$this->db->update($this->tuangou_buess_table,$info,$where);
				
		}
    	return $rs;
    }
	
	 public function uptuanby($data,$shop,$tuanname='')
    {
		
		if($tuan=$this->get_tuaninfo_byurl($data['loc'])){
    	$this->db->update($this->tuangou_table,$data,array('tid'=>$tuan['tid']));
		$id=$tuan['tid'];
		}else{
    	
			$this->db->insert($this->tuangou_table,$data);
			$id=$this->db->insert_id();
		
		
		//商家信息存入百度LBS
		
		if($tuanname=='55tuan'){
			
			//商家信息存入百度LBS
				if($url->data->shops->shop->name){
					
					$datashop['dealsid']=$id;
					$datashop['title']=$url->data->shops->shop->name;
					$datashop['longitude']=$url->data->shops->shop->longitude;
					$datashop['latitude']=$url->data->shops->shop->latitude;
					$datashop['address']=$url->data->shops->shop->addr;
					$datashop['phone']=$url->data->shops->shop->tel;
					$datashop['coord_type']='3';
					
					$result = $this->model_hotel->post_baidu('',$datashop,'create',34835);
					
				}else{
					
				foreach($url->data->shops as $shop){
					
					$datashop2['dealsid']=$id;
					$datashop2['title']=$shop->name;
					$datashop2['longitude']=$shop->longitude;
					$datashop2['latitude']=$shop->latitude;
					$datashop2['address']=$shop->addr;
					$datashop2['phone']=$shop->tel;
					$datashop2['coord_type']='3';
					$result = $this->model_hotel->post_baidu('',$datashop2,'create',34835);
					$result = json_decode($result['response_body']);		
					
					//print_r($result);
				}
			
		}
		}
		else{
			
				if($shop->shop->name){
					
					$datashop['dealsid']=$id;
					$datashop['title']=$url->data->display->shops->shop->shopSeller;
					$zhuobiao=explode(',',$url->data->display->shops->shop->shopCoords);
					$datashop['longitude']=$zhuobiao[0];
					$datashop['latitude']=$zhuobiao[1];
					$datashop['address']=$url->data->display->shops->shop->shopAddress;
					$datashop['phone']=$url->data->display->shops->shop->shopPhone;
					$datashop['coord_type']='3';
					
					$result = $this->model_hotel->post_baidu('',$datashop,'create',34835);
				
				}
				else{
					
					foreach($shop->shop as $shop){
						
						$datashop2['dealsid']=$id;
						$datashop2['title']=$shop->shopSeller;
						$zhuobiao=explode(',',$shop->shopCoords);
						$datashop2['longitude']=$zhuobiao[0];
						$datashop2['latitude']=$zhuobiao[1];
						$datashop2['address']=$shop->shopAddress;
						$datashop2['phone']=$shop->shopPhone;
						$datashop2['coord_type']='3';
						$result = $this->model_hotel->post_baidu('',$datashop2,'create',34835);
						
						}
				}
			}
			
				//更新行政区信息
				$result = json_decode($result['response_body']);		
				$baiduid=$result->id;
				
				$api_list=file_get_contents("http://api.map.baidu.com/geosearch/v2/detail?id=$baiduid&geotable_id=34835&ak=85654a7702d8b2163b85f87e6585b4f5");
				$api_list=json_decode($api_list);
				
				$data2['areaname']= $api_list->contents[0]->district ;
				
				$this->model_tuangou->addTuangou('update',$data2,array('tid'=>$id));
			}	
		
		
		
    }
	
    public function geosearchnearby($location,$filter,$databoxid=34599){
		
		$api_list=file_get_contents($this->nearbyurl."$databoxid&sortby=distance:1&scope=2&location=".$location."&filter=".$filter);
			$api_list=	json_decode($api_list,true);
        return $api_list;
		
	}
	
	public function isxexingtuan($tuaninfo){
		
		$class_arr=array('酒店','景点','旅游','门票','公园');
		foreach($class_arr as $class){
			if(substr_count(''.$tuaninfo,$class)){
				$res= 1;
			}
		}
		
		return $res;
		
	}

}
?>