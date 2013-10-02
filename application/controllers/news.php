<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID news.php
 * 携行酒店分销联盟（咨询）模块
 * @date 2013-1-24
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class News extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_keywords');
        $this->load->model('model_sysconfig');
        $this->load->model('model_news');
        $this->load->model('model_news_category');
        $this->load->library('pagination');
        $this->load->library('tool');
        
    }
    
	public function index()
	{
        //载入布局模型
        $layout = $this->model_layout->get_layout('news');
        
        //处理url参数
        $getPara = $this->uri->rsegment(3);
        $getPara = explode('-',$getPara);
        
        $newclass = isset($getPara[1]) ? (int) $getPara[1] : 0;
        $newsclassName = '';
        $where = 'WHERE state_radio != 2 and class_id not in(5,6) ';
        $where1 = array('state_radio !=' => 2);
		$where1 = array('class_id not in' => '(5,6)');
        if ($newclass != 0) {	
        	$classinfo = $this->model_news_category->get_category();
        	$newsclassName = $classinfo[$newclass];
        	$where .= "AND class_id = $newclass";
        	$where1['class_id'] = $newclass;
        } 
        
        $page = isset($getPara[2]) ? (int) $getPara[2] : 0; ;
        $page = $page <= 0 ? 1 : $page ;
        $pagesize = 20 ;
        $order =  isset($getPara[0]) ? (int) $getPara[0] : 0; ;
        $orderfiled = "";
        if($order === 2){
        	$orderfiled = 'view_num desc';
        }else if ($order === 1){
        	$orderfiled = 'aid desc' ;
        }else{
        	$orderfiled = '`order` asc' ;
        }
        
        $newscount = $this->model_news->get_count($where1);
        $pageinfo = $this->tool->get_page_info($page,$newscount,$pagesize);
        $newslist = $this->model_news->get_list($pageinfo['start'],$pagesize,$orderfiled,$where);

        //分页
		$config['base_url'] = base_url()."/news/$order-$newclass-";
		$config['page_tag_prefix'] = '-';
		$config['page_tag_now'] = $page;
		$config['firstpage_query_string'] = FALSE;
        $config['suffix'] = $this->config->item('url_suffix');
		$config['total_rows'] = $newscount ;
		$config['num_links'] = 4;
		$config['per_page'] = $pagesize;
		$config['use_page_numbers'] = true;
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
        $config['prev_link'] = '&lt;';
        $config['next_link'] = '&gt;';
		$this->pagination->initialize($config); 
		$pagnav = $this->pagination->create_links();
        
        //替换meta信息
        $meta = $this->model_keywords->getKeywords('news');
        $sysconfig = $this->model_sysconfig->getSysconfig();
 
        $search = array('{doname}','{classname}');
        $meta_replace = array($sysconfig['cfg_webname'],'资讯频道');
        $meta_array = str_replace($search, $meta_replace, $meta);

        $data = array();
        $data['layout'] = $layout ; 
        $data['method'] = $this->uri->segment(1) ;      
        $data['newslist'] = $newslist ;      
        $data['newscount'] = $newscount ;      
        $data['pagenav'] = $pagnav ;  
        $data['metainfo'] = $meta_array ; 
        $data['newsclassName'] = $newsclassName ;
        $data['newclass'] = $newclass;
		$this->load->view('news',$data);
	}
}
