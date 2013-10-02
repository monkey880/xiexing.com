<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID expoinfo.php
 * 携行酒店分销联盟（展会详情）模块
 * @date 2013-2-16
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Expoinfo extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        
        $this->load->model('model_common');
        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path'];//缓存存放目录
    }
    
	public function index()
	{
        //载入布局模型
        $layout = $this->model_layout->get_layout('expoinfo');
        $data = array();
        
        //当前展会
        $now_exhid = $this->uri->segment(2);
        $apiUrl = CFG_INTERFACE_API."expo.info&exhid=$now_exhid";
        $cacheName = "expo_{$now_exhid}.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."expo/",$cacheName);
        $list = json_decode($api_list,true);
        $now_exh_list = $list['reqdata'][0];
        $cityid = $now_exh_list['exhcityid'];
        $_GET['cityid'] = $cityid;
        $cityname= $now_exh_list['exhcity'];
        //得到上一个展会和下一个展会
        $apiUrl = CFG_INTERFACE_API."expo.next.up&exhid=$now_exhid";
        $cacheName = "expo_next_up.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."expo/",$cacheName);
        $list = json_decode($api_list,true);
        $nest_up_exh_list = $list['reqdata'];
        
        $data['now_exh_list'] = $now_exh_list;
        $data['nest_up_exh_list'] = $nest_up_exh_list;
        
        //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('expoinfo');
        $keywords_search = array('{doname}','{classname}','{cityname}','{title}');
        $keywords_replace = array(CFG_WEBNAME,'展会信息',$cityname,$now_exh_list['exhname']);
        $keywords_array = str_replace($keywords_search, $keywords_replace, $keywords_array);
        $data['keywords_array'] = $keywords_array;
        
        //侧边栏周边酒店用到的参数
        $roundhotel['x'] = $now_exh_list['ehcmapx'];
        $roundhotel['y'] = $now_exh_list['ehcmapy'];
        $roundhotel['sort'] = 'expoinfo';
        $data['roundhotel'] = $roundhotel;
        $data['cityid'] = $cityid;
        $data['cityname'] = $cityname;
        
        $data['layout'] = $layout ; 
        $data['method'] = $this->uri->segment(1) ;    
		$this->load->view('expoinfo',$data);
	}
}