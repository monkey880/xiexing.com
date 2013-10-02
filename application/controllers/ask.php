<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID ask.php
 * 携行酒店分销联盟（酒店问答）模块
 * @date 2013-2-16
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Ask extends CI_Controller 
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_common');
        $this->load->model('model_hotel');
        $this->load->library('pagination');
        
        /*
        $this->load->library('tool');
        $this->load->model('model_city');
        $this->load->model('model_ask');
        */
        
        $this->cachePath = $this->config->config['cache_path'];//缓存存放目录
    }
    
	public function index()
	{
        //载入布局模型
        $layout = $this->model_layout->get_layout('ask');
        $data = array();
        
        //搜索块默认值
        $cityid = $this->uri->segment(2);
        $searchArray = $this->model_common->setLeftSearch(array('cityid'=>$cityid));
        $cityid = $searchArray['cityid'];
        $cityname = $searchArray['cityname'];
        $cityJson = json_encode(array('id'=>$cityid,'cityname'=>$cityname));
        $data['searchArray'] = $searchArray;
        $data['cityJson'] = $cityJson;
        $data['cityid'] = $cityid;
        $data['cityname'] = $cityname;
        
        //酒店问答列表
        $nowPage = (int) $this->uri->segment(3);
        $nowPage = $nowPage <= 0 ? 1 : $nowPage ;
        $perPage = 10 ;
        $listresult = $this->model_hotel->getQuestionListByCityid($cityid,10,$perPage,$nowPage);
        $list = $listresult['reqdata'];
        $allnums = $listresult['retHeader']['totalput'];
        //生成页码
        $config['base_url'] = base_url("ask/$cityid");
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $allnums;
        $config['per_page'] = $perPage;
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['prev_link'] = '&lt';
        $config['next_link'] = '&gt';
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'pg';
        $this->pagination->initialize($config);
        $page = $this->pagination->create_links();
        $data['list'] = $list;
        $data['page'] = $page ;
        $data['allnums'] = $allnums ;
        //给data赋值
        $data['list'] = $list;
        $data['page'] = $page ;
        $data['allnums'] = $allnums ;
        
        
         //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('question');
        $keywords_search = array('{doname}','{classname}','{cityname}');
        $keywords_replace = array(CFG_WEBNAME,'酒店问答信息',$cityname);
        $keywords_array = str_replace($keywords_search, $keywords_replace, $keywords_array);
        $data['keywords_array'] = $keywords_array;
        
        
        $data['layout'] = $layout ; 
        $data['method'] = $this->uri->segment(1) ;      
		$this->load->view('ask',$data);
	}
}