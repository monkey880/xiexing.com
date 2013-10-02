<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID newsinfo.php
 * 携行酒店分销联盟（资讯详情）模块
 * @date 2013-1-24
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Newsinfo extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_news');
        $this->load->model('model_common');
        $this->load->model('model_city');
        $this->load->model('model_news_category');
    }
    
	public function index()
	{
		$newsid = $this->uri->segment(2);
		$info = $this->model_news->get_newsinfo($newsid);
		if(empty($info)) {
		  show_error('很抱歉，您所访问的内容已被删除或不存在！',404);	
		}
		$next_news = $this->model_news->get_nextnews($newsid);
		$pre_news = $this->model_news->get_prenews($newsid);
		$this->model_news->update_newshit($newsid);
		
        //载入布局模型
        $layout = $this->model_layout->get_layout('newsinfo');
        
        $cityid = $info['CityID'];
        $_GET['cityid'] = $cityid;
        $cityInfo = $this->model_city->get_local_city_byid($cityid);
        $cityname = $cityInfo['cName'];
        $classname = $this->model_news_category->get_category();
        //替换特殊标签：如{中关村#10}
       // $content = $this->model_news->replaceTag($info['content'],$cityid,$cityname);
        $info['content'] = $info['content'];
        
        //处理网页中的seo信息
        $meta_array = $this->model_common->getKeywords('newsinfo');
        $meta_array = str_replace(array('{doname}','{title}','{classname}','{cityname}'),array(CFG_WEBNAME,$info['title'],$classname[$info['class_id']],$cityname),$meta_array);
        
        $data = array();
        $data['layout'] = $layout ; 
        $data['method'] = $this->uri->segment(1) ;      
        $data['info'] = $info ;      
        $data['nextnews'] = $next_news ;      
        $data['prenews'] = $pre_news ;      
        $data['metainfo'] = $meta_array ;  
        $data['cityid'] = $cityid;
        $data['cityname'] = $cityname;
          if($info['class_id']==5||$info['class_id']==6){
		$this->load->view('newsinfo2',$data);
		  }
		  else{
			  $this->load->view('newsinfo',$data);
		  }
	}
	
}
