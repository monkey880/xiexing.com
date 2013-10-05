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
    public function geosearchnearby($location,$filter,$databoxid=34599){
		
		$api_list=file_get_contents($this->nearbyurl."$databoxid&sortby=distance:1&scope=2&location=".$location."&filter=".$filter);
			$api_list=	json_decode($api_list,true);
        return $api_list;
		
	}

}
?>