<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID city.php
 * 携行酒店分销联盟（城市酒店）模块
 * @date 2013-1-24 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Allcity extends CI_Controller 
{
    
    private $data ;
    
    function __construct()
    {
        parent::__construct();
        $this->data = array();
        
        $this->load->model('model_common');
        $this->load->model('model_city');
                
    }
    
	public function index()
	{
        //搜索块默认值
        $searchArray = $this->model_common->setLeftSearch();
        $cityJson = json_encode(array('id'=>$searchArray['cityid'],'cityname'=>$searchArray['cityname']));
        $this->data['searchArray'] = $searchArray;
        $this->data['cityJson'] = $cityJson;
        
        
        //得到热门城市列表
        $hotCityList = $this->model_city->getHotCity(19);
        $this->data['hotCityList'] = $hotCityList;
        
        //根据城市abcd得到城市列表
        $ABCD = $this->model_city->getABCD();      
        $this->data['ABCD'] = $ABCD;                       
        
        //根据城市abcd得到城市列表
        $cityArray = $this->model_city->getCityToABCD();      
        $this->data['cityArray'] = $cityArray;
        
        //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('city');
        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);
        $this->data['keywords_array'] = $keywords_array;
        
        $this->data['method'] = $this->uri->segment(1) ;    
		$this->load->view('city',$this->data);
	}
}