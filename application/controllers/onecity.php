<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID onecity.php
 * 携行酒店分销联盟（前台城市详情）模块
 * @date 2013-1-24
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Onecity extends CI_Controller 
{
    
    private $data;
    
    function __construct()
    {
        parent::__construct();
        $this->data = array();
        
        $this->load->model('model_common');
        $this->load->model('model_city');
        $this->load->model('model_layout');
        $this->load->model('model_hotel');
        
    }
    
	public function index()
	{
		//载入布局模型
		$layout = $this->model_layout->get_layout('onecity');
		$this->data = array();
        $method = $this->uri->segment(1);
        //初始化cityid
        $this->model_common->initCityinfo();
        
        $cityid = $this->uri->segment(2);
        if (empty($cityid)) {
        	$cityInfo = $this->model_common->initCityinfo();
        	$cityid = $cityInfo['cityid'];
        	$cityname = $cityInfo['cityname'];
        } else {
        	$cityinfo = $this->model_city->get_local_city_byid($cityid);
        	$cityname = $cityinfo['cName'];
        }
        $_GET['cityid'] = $cityid;
        
        //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('onecity');
        $keywords_array = str_replace(array('{doname}','{cityname}'),array(CFG_WEBNAME,$cityname),$keywords_array);
        $this->data['keywords_array'] = $keywords_array;
        
        $this->data['layout'] = $layout ;	
        $this->data['method'] =  empty($method) ? 'index' : $method ;	
		$this->load->view('onecity',$this->data);
	}
	
    //快速搜索地标用到的ajax方法
    public function ajax_get_lable()
    {
    	$this->load->model('model_lable');
    	
    	$type = $this->input->get_post('type');
    	$cityid = $this->input->get_post('cityid');
    	if ($type == 170) {
    		echo $lable = $this->model_lable->getSubwayLable($cityid);
    	} else {
    		echo $lable = $this->model_lable->getLable($cityid,$type,'52');
    	}
    }
}