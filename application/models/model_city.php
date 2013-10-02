<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID Model_city.php

 * 城市model

 * @date 2013-2-17

 * @author yuhailong zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Model_city extends CI_Model
{

	private $cachePath ;

	

	function __construct()

	{

        parent::__construct();
		
		$this->load->database();
        
		$db = (array) $this->db;

        $this->city_table = $db['dbprefix'].'city';

        $this->province_table = $db['dbprefix'].'province';
		
		$this->area_table = $db['dbprefix'].'area';
		$this->cbd_table = $db['dbprefix'].'cbd';
		$this->resgoins_table = $db['dbprefix'].'resgions';

        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path']."list/";//缓存存放目录

    }

    

    /**

     * 得到热门城市

     * @param $int $num  得到城市的数目

     * @return array $hotCArray 热门城市列表

     */

    public function getHotCity($num = 12)

    {

        $cityList = $this->getCity();

        $i = 0;

        foreach($cityList as $key=>$val) {

            $i++;

            if($i>$num){

                break;    

            }

            $hotCArray[] = array('cid'=>$val['cid'],'pid'=>$val['pid'],'cName'=>$val['cName'],'pinyin'=>$val['pinyin'],'abcd'=>$val['abcd']);

        }

        return $hotCArray; 

    }

    

    /**

     * 根据pid得到城市

     * @param $int $pid  省份id

     * @return array $hotCArray 热门城市列表

     */

    public function getCityByPid($pid)

    {

        $reqdata = $this->getCity();

        $cityArr = array();

        foreach($reqdata as $key=>$val) {

            if($val['pid'] == $pid){   

                $cityArr[] = array('cid'=>$val['cid'],'cName'=>$val['cName']);

            }

        }

        return  $cityArr;   

    }

    

    /**

     * 得到ABCD为索引的城市列表

     * @return array $cityArray 城市列表

     */

    public function getCityToABCD()

    {

        $reqdata = $this->getCity();

        $cityArray = $this->getABCD();

        foreach($reqdata as $key=>$val) {

            $oneCity = array('cid'=>$val['cid'],'pid'=>$val['pid'],'cName'=>$val['cName'],'pinyin'=>$val['pinyin'],'abcd'=>$val['abcd']);

            $cityArray[$val['abcd']][] = $oneCity ;  

        }

        foreach($cityArray as $key=>$val) {

            if(empty($val)){

                unset($cityArray[$key]);    

            }

        }

        return  $cityArray;

    }

    

    /**

     * 得到城市列表

     * @return array $cityList 城市列表

     */

    public function getCity()

    {

        $cacheName = 'city.json';

        $cityJSON =json_decode(file_get_contents($this->cachePath.$cacheName),true);  

        return $cityList = $cityJSON['reqdata'];    

    }

        

    /**

     * 构造ABCD的数组

     * @return array $cityList 城市列表

     */

    public function getABCD()

    {

        return $ABCD = array("A"=>'',"B"=>'',"C"=>'',"D"=>'',"E"=>'',"F"=>'',"G"=>'',"H"=>'',"I"=>'',"J"=>'',"K"=>'',"L"=>'',"M"=>'',"N"=>'',"O"=>'',"P"=>'',"Q"=>'',"R"=>'',"S"=>'',"T"=>'',"U"=>'',"V"=>'',"W"=>'',"X"=>'',"Y"=>'',"Z"=>'');       

    }

    

    /**

     * @author zhaojianjun

     * 得到城市列表

     * @param $cityid 

     * @return array $city 城市id

     */

    public function get_local_city_byid($cityid)

    {

        $cityList = $this->model_city->getCity();

        foreach ($cityList as $key => $city){

        	if($cityid == $city['cid']){

        		return $city;

        	}

        } 

    }    

    /**

     * 得到全国省份列表

     * @return <array> $cityinfo 

     */

    function getProvinceList($pid = '')

    {

        //得到省份数组

        $cacheName = 'eprovince.json';

        $provinceList =json_decode(file_get_contents($this->cachePath.$cacheName),true);

        foreach($provinceList as $key=>$val){

            $pid == $val['province_id'] ? $provinceList[$key]['class'] = 'current' : $provinceList[$key]['class'] = '';   

        } 

        return  $provinceList;  

    }
	
	  function getarea_api($cityid)

    {

        $apiUrl = CFG_INTERFACE_API."cityarea&cityid=$cityid";
		
		 $cacheName = "area_id{$cityid}.json";

        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."city/area/",$cacheName);


        $api_list = json_decode($api_list,true);

        return $list = $api_list['reqdata'];  

    }  


    

    /**

     * 得到默认城市

     * @return <array> $cityinfo 

     */

    function getInitCityList()

    {

        $cityArr = explode(',',CFG_INDEXCITYLIST); 

        $rt = array();

        foreach ($cityArr as $val) {

            $oneCity = explode('|',$val); 

            $rt[] = array('cityid'=>$oneCity[0],'cityname'=>$oneCity[1]);           

        }

        return $rt;

    }
	
	/**

     * 获取省份列表

     * @param $newsid

     * @return array

     */

    function get_province()

    {

        $query = $this->db->select('province_id,province_name')->get($this->province_table)->result_array();
		
		$province_list=array();
		
		foreach($query as $val){
			$province_list[$val['province_id']]=$val['province_name'];
		}

        return $province_list;

    }
	
	
	/**

     * 获取城市列表

     * @param $newsid

     * @return array

     */

    function get_city($pid)

    {
		if($pid){
			$where=" where pid='$pid'";
		}

        $query = $this->db->query("select cid,cName from $this->city_table $where")->result_array();
		
		$city_list=array();
		
		foreach($query as $val){
			$city_list[$val['cid']]=$val['cName'];
		}

        return $city_list;

    }
	
	 function get_city_bypinxin($pinyin)
    {
		
        $query = $this->db->where("pinyin = '$pinyin' ")->get($this->city_table)->row_array();
        return $query;
    }
	
	 function get_city_byname($name)
    {
		
        $query = $this->db->where("cName = '$name' ")->get($this->city_table)->row_array();
        return $query;
    }
	
		
	/**

     * 获取城市列表

     * @param $newsid

     * @return array

     */

    function get_area($cid)

    {
		
        $query = $this->db->query("select areaid,areaname from $this->area_table where cityid='".$cid."'")->result_array();
		
		$city_list=array();
		
		foreach($query as $val){
			$city_list[$val['areaid']]=$val['areaname'];
		}

        return $city_list;

    }
	
	 function get_cbd($cid)

    {

        $query = $this->db->query("select cbd_id,CBD_Name from $this->cbd_table where CityID='".$cid."'")->result_array();
		
        return $query;

    }
	
	 /**

     * 保存省份数据

     * @return <array> $cityinfo 

     */

	 function save_province($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->province_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('id',$data['id'])->update($this->province_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->province_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	
	 function get_areainfo_byname($name,$cityid='')
    {
		$name=str_replace('区','',$name);
		if($cityid){
			$whrestr=" and cityid=$cityid";
		}
        $query = $this->db->where("areaname like '%$name%' $whrestr ")->get($this->area_table)->row_array();
        return $query;
    }
	
	 function get_areaname_byid($id,$cityid='')
    {
		
		
        $query = $this->db->where("areaid = '$id' and cityid='$cityid' ")->get($this->area_table)->row_array();
        return $query;
    }
	
	
	
		 function save_area($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->area_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('id',$data['id'])->update($this->area_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->area_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }

     /**

     * 保存城市数据

     * @return <array> $cityinfo 

     */

	 function save_city($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->city_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('id',$data['id'])->update($this->city_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->city_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 /**

     * 保存商圈数据

     * @return <array> $cityinfo 

     */

	 function save_cbd($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->cbd_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('id',$data['id'])->update($this->cbd_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->cbd_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 function get_resgoin_list($area,$city)
    {
		
		$query = $this->db->query("select * from $this->resgoins_table where areaname like '%$area%' and cityname like '%$city%'")->result_array();
       
        return $query;
    }
	
	 function get_resgoin($areaid)

    {

        $query = $this->db->query("select * from $this->resgoins_table where rid='".$areaid."'")->row_array();
		
        return $query;

    }
	 function get_resgoin_byname($range)

    {

        $query = $this->db->query("select * from $this->resgoins_table where regionname='".$range."'")->row_array();
		
        return $query;

    }
	
	 function save_resgoin($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->resgoins_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('rid',$data['rid'])->update($this->resgoins_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->resgoins_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }


}

?>