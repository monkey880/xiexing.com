<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID help.php
 * 携行酒店分销联盟（帮助）模块
 * @date 2013-1-24
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Help extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_common');
    }
    
	public function index()
	{
		//载入布局模型
        $layout = $this->model_layout->get_layout('help');

        //处理网页中的seo信息
        $keywords_array = $this->model_common->getKeywords('help');
        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array); 
        
        $data = array();  
		$data['layout'] = $layout ;
        $data['method'] = $this->uri->segment(1) ;
        $data['keywords_array'] = $keywords_array ;
        
		$this->load->view('help',$data);
	}
}

