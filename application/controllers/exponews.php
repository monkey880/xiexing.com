<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID exponews.php
 * 携行酒店分销联盟（展会新闻新闻详情）模块
 * @date 2013-2-16
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Exponews extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_expo');
        $this->load->model('model_common');
        $this->cachePath = $this->config->config['cache_path'];//缓存存放目录
    }
    
	public function index()
	{
        //载入布局模型
        $layout = $this->model_layout->get_layout('exponews');
        $data = array();
        
        //当前展会新闻
        $exponewsid = $this->uri->segment(3);
        $list = $this->model_expo->getExponews($exponewsid);
        $data['list'] = $list ;
        
        //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('exponews');
        $keywords_search = array('{doname}','{classname}','{cityname}','{title}');
        $keywords_replace = array(CFG_WEBNAME,'展会资讯信息','',$list['title']);
        $keywords_array = str_replace($keywords_search, $keywords_replace, $keywords_array);
        $data['keywords_array'] = $keywords_array;
        
        $data['layout'] = $layout ; 
        $data['method'] = $this->uri->segment(1) ;    
		$this->load->view('exponews',$data);
	}
}