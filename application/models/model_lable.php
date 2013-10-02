<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID model_lable.php

 * 地标model

 * @date 2013-2-20

 * @author yuhailong zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Model_lable extends CI_Model

{

	private $cachePath;

	

	function __construct()

    {

        parent::__construct();

        $this->load->database();
        
		$db = (array) $this->db;
		
		$this->lable_table = $db['dbprefix'].'lable';
		
		$this->Subwayline_table = $db['dbprefix'].'Subwayline';
		

        $this->labletype_table = $db['dbprefix'].'labletype';

        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path'];//缓存存放目录

    }

    

    /**

     * 首页ajax获得地标信息

     * @param int $cityid  城市id

     * @param int $type  地标类型

     * @return array $lableInfo 地标数组

     */

    public function getLable($cityid,$type,$rows,$start=0)

    {

    	$cityArr = $this->model_city->get_local_city_byid($cityid);

    	$areaid = $cityArr['areaid'];

    	$inserfaceUrl = CFG_INTERFACE_API."lable&cityid={$areaid}&classid={$type}&rows={$rows}&start={$start}";

    	$cacheName = 'lable_'.$cityid.'_'.$type.'.json';

    	//$lableJSON = $this->tool->create_cache($inserfaceUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
		
		$lableJSON=file_get_contents($inserfaceUrl);

    	$lableJSON = json_decode($lableJSON,true);
		
		

    	return $inserfaceUrl = json_encode($lableJSON['reqdata']);

    }
	
	public function getLable2($cityid,$type,$rows,$start=0)

    {

    	$cityArr = $this->model_city->get_local_city_byid($cityid);

    	$areaid = $cityArr['areaid'];

    	$inserfaceUrl = CFG_INTERFACE_API."lable&cityid={$areaid}&classid={$type}&rows={$rows}&start={$start}";

    	$cacheName = 'lable_'.$cityid.'_'.$type.'.json';

    	//$lableJSON = $this->tool->create_cache($inserfaceUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
		
		$lableJSON=file_get_contents($inserfaceUrl);

    	$lableJSON = json_decode($lableJSON,true);
		
		

    	return $inserfaceUrl = $lableJSON['reqdata'];

    }
	
	 public function Subwayline($cityid)
    {


    	$inserfaceUrl = CFG_INTERFACE_API."subway.line&cityid={$cityid}";

    	$cacheName = 'lable_'.$cityid.'_'.$type.'.json';
		
    	//$lableJSON = $this->tool->create_cache($inserfaceUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
		
		$lableJSON=file_get_contents($inserfaceUrl);

    	$lableJSON = json_decode($lableJSON,true);
		
		

    	return $inserfaceUrl = json_encode($lableJSON['reqdata']);
    }
	
	 public function Subwaystation($lineid)
    {


    	$inserfaceUrl = CFG_INTERFACE_API."subway.station&lineid={$lineid}";

    	$cacheName = 'lable_'.$cityid.'_'.$type.'.json';
		
    	//$lableJSON = $this->tool->create_cache($inserfaceUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
		
		$lableJSON=file_get_contents($inserfaceUrl);

    	$lableJSON = json_decode($lableJSON,true);
		
		

    	return $inserfaceUrl = json_encode($lableJSON['reqdata']);
    }


    
    /**

     * 首页ajax获得地标信息

     * @param int $cityid  城市id

     * @param int $type  地标类型

     * @return array $lableInfo 地标数组

     */

    public function getlableType()

    {

    	 //检测生成lable.type缓存

        $inserfaceUrl = CFG_INTERFACE_API.'lable.type';

        $cacheName = 'lable.type.json';

        $labletypeJSON = $this->tool->create_cache($inserfaceUrl,$this->cachePath."lable/",$cacheName);//cache

        $labletypeJSON = json_decode($labletypeJSON,true);  

        $labletypeArray = $labletypeJSON['reqdata'];

    	return $labletypeArray;

    }
	
	    public function getlable_name($line,$ecityid)
    {
    	$adList = $this->db->query("SELECT * FROM $this->lable_table WHERE name LIKE '%$line%' and ecityid='$ecityid'")->row_array() ;
    	return $adList;
    }



    /**

     * 首页ajax获得地标信息：地铁

     * @param int $cityid  城市id

     * @param int $type  地标类型

     * @return array $lableInfo 地标数组

     */

    public function getSubwayLable($cityid)

    {

    	$rs = "" ;

    	$cacheName = 'lable_'.$cityid.'_subway.json';

    	$cachepath = $this->cachePath."lable/{$cityid}/";

    	$cache = $cachepath . $cacheName;  //xml接口的本地路径+文件全名

    	$checktime = 259200;

    	if ($this->tool->check_cache($cache, $checktime)) {

    		$this->tool->CreateFolder($cachepath);

    		

    		$getLineUrl = CFG_INTERFACE_API."subway.line&cityid=$cityid";

    		$subwaylineJSON = file_get_contents($getLineUrl);

    		$subwayline = json_decode($subwaylineJSON,true);

    		$subwayline = $subwayline['reqdata'];

    		

    		$subwayUrl = CFG_INTERFACE_API."subway.station&lineid=";

    		$rs = array();

    		foreach ($subwayline as $key=>$val) {
				
    			$subwayJSON = file_get_contents($subwayUrl.$val['zhuantiid']);

    			$subway = json_decode($subwayJSON,true);

    			$subway = $subway['reqdata'];
				$subway2=array();
				foreach($subway as $sub){
				
				$lable=$this->getlable_name($sub['title'],$cityid);
				$sub['mapid']=$lable['zhunaid'];
				$subway2[]=$sub;
				}

    			$rs[$val['title']] = $subway2;

    		}

    		

    		$content = json_encode($rs);

    		if (strlen($content) > 0) {

    			file_put_contents($cache, $content);

    		}

    		$rs = $content;

    	}else{

    		$rs = file_get_contents($cache);

    	}

    	

    	return $rs;

    }
	
	 public function getSubwayline()
    {
    	$adInfo = $this->db->get($this->Subwayline_table)->result_array();
        
        return $adInfo;
    }
	
	 /**

     * 保存地保类型数据

     * @return <array> $cityinfo 

     */

	 function save_LableType($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->labletype_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('id',$data['id'])->update($this->labletype_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->labletype_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 function save_Lable($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->lable_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('lableid',$data['lableid'])->update($this->lable_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->lable_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 function save_Subwayline($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->Subwayline_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('zhuantiid',$data['zhuantiid'])->update($this->Subwayline_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->Subwayline_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }


}

?>