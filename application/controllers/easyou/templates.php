<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID templates.php
 * 携行酒店分销联盟（后台页面管理）模块
 * @date 2013-3-12
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Templates extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'templates';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_layout');
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
        $data['operate'] = array('isedit'=>$isedit);
        
        //获得页面列表
    	$layoutList = $this->model_layout->getLayoutList();
        //处理选中标签的classname
        $layoutPage = $this->uri->segment(4);
        if($layoutPage != '') {
        	foreach ($layoutList as $key=>$val) {
        		if ($val['layout_page'] == $layoutPage) {
        			$layout['layout_pagename'] = $layoutList[$key]['layout_pagename'];
        			$layout['layout_id'] = $layoutList[$key]['layout_id'];
        			$layoutList[$key]['class_show'] = 'note1';
        		} else {
        			$layoutList[$key]['class_show'] = 'note2';
        		}
        	}	
        } else {
        	foreach ($layoutList as $key=>$val) {
        		if ($key == 0) {
        			$layoutList[$key]['class_show'] = 'note1';
        		} else {
        			$layoutList[$key]['class_show'] = 'note2';
        		}
        	}
        	$layoutPage = $layoutList[0]['layout_page'];
        	$layout['layout_pagename'] = $layoutList[0]['layout_pagename'];
        	$layout['layout_id'] = $layoutList[0]['layout_id'];
        }
        $layout['layout_page'] =	$layoutPage;
        //获取选中页面信息
        $layoutInfo = $this->model_layout->get_layout($layoutPage);
        
        $data['method'] = $this->uri->segment(2) ;  
        $data['layoutList'] = $layoutList;    
        $data['layoutInfo'] = $layoutInfo;
        $data['layout'] = $layout;
        $data['layoutPage'] = $layoutPage;
        
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_templates',$data);
    }
    
    //遮罩层
    public function show_TB ()
    {
    	$uri = $this->uri->segment(4);
    	$action = $this->uri->segment(5);
    	
    	$location = !empty($uri) ? $uri : '';
    	
    	if(substr($location,0,1) == 'a') {
    		$condition = array('location'=>$uri);
    	} else if ($action == 'hotelinfo' || $action == 'expoinfo' ) {
    		$condition = 'hotelinfo|expo';
    	} else {
    		$condition = array('page'=>'list|info|newsl');
    		
    	}
    	//获得页面各部分可以用的模块
    	$model = $this->model_layout->getModel($condition);
    	
    	$data = array();	
    	$data['model'] = $model;
    	$data['uri'] = $uri;
    	$this->load->view('admin/admin_templates_showtb',$data);
    }
    
    /**
     * 修改页面布局
     */
    public function save_templates()
    {   
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
    	/* 初始化变量 */
        $layout_pagename = $this->input->post('layoutPageName', TRUE);         
        $layout_page = $this->input->post('layoutPage', TRUE);
        $layout_id = (int) $this->input->post('layoutId', TRUE);
        
        $layout_module = '';
        if ($layout_page == 'index' || $layout_page == 'onecity') {
        	for ($i=0;$i<=11;$i++) {
        		$layout_module .= $_POST["a$i"]."|";
        	}
        } else {
        	for ($i=0;$i<=3;$i++) {
        		$layout_module .= $_POST["b$i"]."|";
        	}	
        }
        $layout_module = rtrim($layout_module,'|');
       
    	$info = array(
    			'layout_page' => $layout_page,
    			'layout_pagename' => $layout_pagename,
    			'layout_module' => $layout_module
    	);
    	
    	$where = array('layout_id'=>$layout_id);
    	$rs = $this->model_layout->saveLayout($info,$where);
    	if ($rs) {
	    	$alertMsg = '修改页面布局成功';
	    	$redirectUrl = site_url('/'.CFG_ADMINURL.'/templates/index/'.$layout_page);
	    	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
    	} else {
	    	$alertMsg = '修改页面布局失败';
	    	$redirectUrl = site_url('/'.CFG_ADMINURL.'/templates/index/'.$layout_page);
	    	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
    	}
    }
        
}