<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID ehc.php
 * 携行酒店分销联盟（会馆/展馆）模块
 * @date 2013-2-25 
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Ehc extends CI_Controller 
{

    private $data;
    private $cachePath;
    private $current; //当前城市信息数组
    
    function __construct()
    {
        parent::__construct();
        $this->data = array();
        
        $this->load->model('model_common');
        $this->load->model('model_city');
        $this->load->library('tool');
        $this->load->library('pagination');
        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path'];//缓存存放目录
    }
    
	public function index()
	{ 	   
        //搜索块默认值
        $searchArray = $this->model_common->setLeftSearch();
        $cityJson = json_encode(array('id'=>$searchArray['cityid'],'cityname'=>$searchArray['cityname']));
        $this->data['searchArray'] = $searchArray;
        $this->data['cityJson'] = $cityJson;
        
        //处理url参数
        $getPara = $this->uri->rsegment(3);
		$getPara = explode('-',$getPara);
        
        $pid = !empty($getPara[0])? $getPara[0] : '';
        $cid = !empty($getPara[1]) ? $getPara[1] : '';
        $scroll = !empty($getPara[1]) ? 1 : '';
        $nowPage = !empty($getPara[2]) ? (int) $getPara[2] : 1;
        
        if (!$pid) {
        	$cityInfo1 = $this->model_common->initCityinfo();
        	$cid = $cityInfo1['cityid'];
        	$cityInfo2 = $this->model_city->get_local_city_byid($cid);
        	$pid = $cityInfo2['pid'];
        }
        
        //初始化当前城市信息
        $this->current['cid'] = $cid; 
        $this->current['pid'] = $pid;
        $this->current['cName'] = '';
        $this->current['pName'] = '';
        //获取页面各部分数据
        $hotCityList = $this->model_city->getHotCity(19);
        $cArray = $this->getCity($pid ,$this->current['cid']);
        $pArray = $this->model_city->getProvinceList($pid);
        $ehcList= $this->getEhcList($this->current['cid'],$nowPage);
        //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('ehc');
        $keywords_array = str_replace(array('{doname}','{classname}','{cityname}'),array(CFG_WEBNAME,'会馆/展馆信息',$this->current['cName']),$keywords_array); 
         
        //给页面传递参数
        $this->data['scroll'] = $scroll ;  
        $this->data['current'] = $this->current ; 
        $this->data['hotCityList'] = $hotCityList ;   
        $this->data['keywords_array'] = $keywords_array;
        $this->data['pArray'] = $pArray;
        $this->data['cArray'] = $cArray;
        $this->data['ehcList'] = $ehcList;
        $this->data['method'] = $this->uri->segment(1) ;  
		$this->load->view('ehc',$this->data);
	}
	
    function getCity($pid,$cid)
    {
        $reqdata = $this->model_city->getCity();
        $cArrayOper = array("A"=>'',"B"=>'',"C"=>'',"D"=>'',"E"=>'',"F"=>'',"G"=>'',"H"=>'',"I"=>'',"J"=>'',"K"=>'',"L"=>'',
            "M"=>'',"N"=>'',"O"=>'',"P"=>'',"Q"=>'',"R"=>'',"S"=>'',"T"=>'',"U"=>'',"V"=>'',"W"=>'',"X"=>'',"Y"=>'',"Z"=>'');
        foreach ($reqdata as $key=>$val) {
            if($val['pid'] == $pid){
                if($cid == $val['cid']){
                    $class = 'current';  
                    $this->current['pName'] = $val['pName'];  
                    $this->current['cName'] = $val['cName']; 
                    $this->current['cid'] = $val['cid'];    
                }else{
                    $class = '';    
                }
                $cArrayOper[$val['abcd']][] = array('cid'=>$val['cid'],'pid'=>$val['pid'],'cName'=>$val['cName'],
                                            'pName'=>$val['pName'],'abcd'=>$val['abcd'],'class'=>$class);
            }
        }
        
        foreach($cArrayOper as $val) {
            if(!empty($val)){
                foreach($val as $val2) {
                	if (!isset($defaultCityname)) {
                		$defaultCityname = $val2 ['cName'];
                	}
                    $val2 ['cNameTitle'] = $val2['cName'];
                	$val2 ['cName'] = substr($val2['cName'],0,6);
                	$cArray[] = $val2;        
                }
            }
        }
        if($this->current['cid'] == ''){
            $this->current['cName'] = $defaultCityname;
            $this->current['pName'] = $cArray[0]['pName'];  
            $this->current['cid'] = $cArray[0]['cid'];      
            $cArray[0]['class'] = 'current';     
        }   
        return  $cArray;        
    }
    
    function getEhcList($cid,$nowPage)
    {
        $cityArr = $this->model_city->get_local_city_byid($cid);
        $areaid = $cityArr['areaid'];
        if($nowPage<1){
        	$nowPage = 1;
        }
        $per_page = 96;
        $start = ($nowPage - 1) * $per_page;
        $apiUrl = CFG_INTERFACE_API."lable&cityid=$areaid&classid=70&rows=$per_page&start=".$start;
        if ($nowPage<=5) {
            $cacheName = "lable_{$cid}_70_".$nowPage.".json";
        	$lableJSON = $this->tool->create_cache($apiUrl,$this->cachePath."lable/{$cid}/",$cacheName);
        } else {
        	$lableJSON = file_get_contents($apiUrl);
        }
        $lableJSON = json_decode($lableJSON,true);  
        $lableList = $lableJSON['reqdata'];
        $config['base_url'] = base_url().'/ehc/'.$this->current['pid'].'-'.$this->current['cid'];
        $config['suffix'] = $this->config->item('url_suffix');
        $config['page_tag_prefix'] = '-';
        $config['firstpage_query_string'] = FALSE;
        $config['total_rows'] = $lableJSON['retHeader']['totalput'];
        $config['per_page'] = $per_page;
        $config['page_tag_now'] = $nowPage;
        $config['num_links'] = 4;
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_link'] = '<<';
		$config['last_link'] = '>>';
        $config['prev_link'] = '&lt';
        $config['next_link'] = '&gt';
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $page = $this->pagination->create_links();
        
        return  array($lableList,$page); 
    }
    
 }
 