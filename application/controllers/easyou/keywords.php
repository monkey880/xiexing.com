<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID keywords.php
 * 携行酒店分销联盟（后台关键字管理）模块
 * @date 2013-3-7
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Keywords extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'keywords';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_keywords');
        $this->load->library('pagination');
        $this->load->helper('form');
        $this->load->model('model_admin');
    }
    
    public function index()
    {  
        $data = array();
        
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;
    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;
        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;
        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);
        
        $page = intval($this->uri->segment(4)) ;
        $page = $page <= 0 ? 1 : $page ;
        $pagesize = 10 ;
        
        $keywordsCount = $this->model_keywords->getKeywordsCount();
        $pageinfo = $this->tool->get_page_info($page,$keywordsCount,$pagesize);   
        $keywordsList = $this->model_keywords->getKeywordsList($pageinfo['start'],$pagesize);
        //分页
        $config['base_url'] = base_url(CFG_ADMINURL.'/keywords/index/');
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $keywordsCount ;
        $config['uri_segment'] = 4;
        $config['num_links'] = 8;
        $config['per_page'] = $pagesize;
        $config['use_page_numbers'] = true;
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['prev_link'] = '&lt;';
        $config['next_link'] = '&gt;';
        $this->pagination->initialize($config); 
        $pagnav = $this->pagination->create_links();

        $data['method'] = $this->uri->segment(2) ;      
        $data['keywordsList'] = $keywordsList ;          
        $data['pagenav'] = $pagnav ; 
        $data['page'] = $page;
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_keywordslist',$data);
    }

    /**
     * 显示添加或修改页面关键字界面
     */
    public function add_keywords()
    {    
    	$keywordsid = intval($this->uri->segment(4));
    	if ($keywordsid > 0 ) {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    		$info = $this->model_keywords->getKeywordsInfo($keywordsid);
    	} 
        
        $data = array_merge($info,$this->userinfo);
        $this->load->view('admin/admin_keywords_add',$data);
    }
    
    /**
     * 新增/修改页面关键字
     */
    public function save_keywords()
    {
        /* 初始化变量 */
        $k_id = (int) $this->input->post('k_id', TRUE);   
        $k_pagename = $this->input->post('pagename', TRUE);         
        $k_title = $this->input->post('title', TRUE);
        $k_keywords = $this->input->post('keywords', TRUE);
        $k_description = $this->input->post('description', TRUE);
        $page = (int) $this->input->post('page', TRUE);
        /* 验证不能为空 */
        if (!$k_pagename) {
            echo "<script>alert('页面名不能为空!')</script>";
            exit;
        }
        if (!$k_keywords) {
            echo "<script>alert('页面关键字不能为空!')</script>";
            exit;
        }
        if (!$k_description) {
            echo "<script>alert('页面描述不能为空!')</script>";
            exit;
        }
        
        $info = array(
            'k_pagename' => $k_pagename,
            'k_title' => $k_title,
            'k_keywords' => $k_keywords,
            'k_description' => $k_description,
            'k_time' => time()
        );
        
        if ($k_id > 0) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            
            $where = array('k_id'=>$k_id);
            $rs = $this->model_keywords->addKeywords('update',$info,$where);
            if ($rs) {
                $alertMsg = '修改页面关键字成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/keywords/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '修改页面关键字失败';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/keywords/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            }
        } 
    }      
}