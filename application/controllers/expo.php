<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID expo.php
 * 携行酒店分销联盟（展会）模块
 * @date 2013-2-16
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Expo extends CI_Controller 
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('model_layout');
        
        $this->load->model('model_common');
        $this->load->library('tool');
        $this->load->library('pagination');
        $this->load->model('model_city');
        $this->load->model('model_expo');
        
        $this->cachePath = $this->config->config['cache_path'];//缓存存放目录
    }
    
	public function index()
	{
        //载入布局模型
        $layout = $this->model_layout->get_layout('expo');
        $data = array();
        
        //处理url参数
        $getPara = $this->uri->rsegment(3);
        $getPara = explode('-',$getPara);
        
        //展会列表
        $nowPage = isset($getPara[2]) ? (int) $getPara[2] : 1;
        $nowPage = $nowPage <= 0 ? 1 : $nowPage ;
        $perPage = 6 ;
        $order = intval($getPara['0']) ;
        $order = !empty($order) ? $order : 1;
        $cityid = isset($getPara[1]) ? $getPara[1] : '';
        if (empty($cityid)) {
            $cityInfo = $this->model_common->initCityinfo();
            $cityid = $cityInfo['cityid'];  
            $cityname = $cityInfo['cityname'];
        } else {
        	$cityinfo = $this->model_city->get_local_city_byid($cityid);
        	$cityname = $cityinfo['cName'];
        } 
        $_GET['cityid'] =  $cityid;
        if ($order == 1) {
        	$day = '';
        } else if ($order == 2) {
        	$day = 30;
        } else {
            $day = 7;    
        }
        $listresult = $this->model_expo->getExpo($cityid,$nowPage,$perPage,$day,$order);
        $list = $listresult['reqdata'];
        
        foreach($list as $key=>$val){
            $expo_ehc_api = file_get_contents(CFG_INTERFACE_API."expo.ehc&ehcid={$val['ehcid']}");
            $expo_ehc_result = json_decode($expo_ehc_api,true);
            $list[$key]['ehcmapx'] = isset($expo_ehc_result['reqdata'][0]['ehcmapx']) ? $expo_ehc_result['reqdata'][0]['ehcmapx'] : 0 ;
            $list[$key]['ehcmapy'] = isset($expo_ehc_result['reqdata'][0]['ehcmapy']) ? $expo_ehc_result['reqdata'][0]['ehcmapy'] : 0 ;          
        }
        $allnums = $listresult['retHeader']['totalnum']; 
        //生成页码
        $config['base_url'] = base_url()."/expo/$order-$cityid-";
        $config['page_tag_prefix'] = '-';
        $config['page_tag_now'] = $nowPage;
        $config['firstpage_query_string'] = FALSE;
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $allnums;
        $config['per_page'] = $perPage;
        $config['num_links'] = 4;
        $config['first_link'] = '<<';
		$config['last_link'] = '>>';
        $config['prev_link'] = '&lt';
        $config['next_link'] = '&gt';
        $config['use_page_numbers'] = TRUE;
        //$config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'pg';
        $this->pagination->initialize($config);
        $page = $this->pagination->create_links();
        $data['list'] = $list;
        $data['page'] = $page ; 
        $data['allnums'] = $allnums ;
        
        //得到热门城市列表
        $hotCityList = $this->model_city->getHotCity();
        $data['hotCityList'] = $hotCityList;
        
        //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('expo');
        $keywords_search = array('{doname}','{classname}','{cityname}');
        $keywords_replace = array(CFG_WEBNAME,'展会信息',$cityname);
        $keywords_array = str_replace($keywords_search, $keywords_replace, $keywords_array);
        $data['keywords_array'] = $keywords_array;
        
        $data['cityid'] = $cityid;
        $data['cityname'] = $cityname;
        $data['nowPage'] = $nowPage;
        $data['order'] = $order;
        $data['layout'] = $layout ; 
        $data['method'] = $this->uri->segment(1) ;      
		$this->load->view('expo',$data);
	}
}