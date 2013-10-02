<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID newsclass.php
 * 携行酒店分销联盟（后台新闻分类管理）模块
 * @date 2013-2-16
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Newsclass extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'newsclass';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        $this->load->model('model_news_category');
        $this->load->library('tool');
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
        $pagesize = 10;
        
        $adCount = $this->model_news_category->getNewsClassCount();
        $pageinfo = $this->tool->get_page_info($page,$adCount,$pagesize);   
        $newsClassList = $this->model_news_category->getNewsClassList($pageinfo['start'],$pagesize);
        //分页
        $config['base_url'] = base_url(CFG_ADMINURL.'/newsclass/index/');
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $adCount ;
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
        $data['newsClassList'] = $newsClassList ;          
        $data['pagenav'] = $pagnav ;    
        $data['page'] = $page;
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_newsclasslist',$data);
    }
    
    /**
     * 显示添加或修改资讯分类界面
     */
    public function add_newsclass()
    {    
    	$class_id = intval($this->uri->segment(4));
    	if ($class_id > 0 ) {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    		$info = $this->model_news_category->getNewsClassInfo($class_id);
    	} else {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
	        $info = array();
            
            $info['class_id'] =  0;      
            $info['class_name'] =  '';                 
    	}
        
        $data = array_merge($info,$this->userinfo);
        $this->load->view('admin/admin_newsclass_add',$data);
    }
    
    /**
     * 新增/修改资讯分类
     */
    public function save_newsclass()
    {
        /* 初始化变量 */
        $class_id = (int) $this->input->post('class_id', TRUE);
        $class_name = $this->input->post('class_name', TRUE);
        $page = (int) $this->input->post('page', TRUE);
        /* 验证不能为空 */
        if (!$class_name) {
            echo "<script>alert('资讯分类标题不能为空')</script>";
            exit;
        }
        $info = array(
            'class_name' => $class_name,
        );
        if ( $class_id > 0 ) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $where = array('class_id'=>$class_id);
            $rs = $this->model_news_category->addNewsClass('update',$info,$where);
            if ($rs) {
                $alertMsg = '修改资讯分类成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/newsclass/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '修改资讯分类失败';
                echo '<script>alert("'.$alertMsg.'");</script>';
            }
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $rs = $this->model_news_category->addNewsClass('insert',$info);
            if ($rs) {
                $alertMsg = '添加资讯分类成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/newsclass');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '添加资讯分类失败';
                echo '<script>alert("'.$alertMsg.'");</script>';
            }
        }
    }
    
    /**
     * 删除一条/多条资讯分类
     */
    public function del_newsclass ()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    	$urlnewsclassid = $this->uri->segment(4);
        $newsclassidArr = explode('-',$urlnewsclassid);
        $newsclassidStr = '';
        foreach ($newsclassidArr as $val) {
            $newsclassid = intval($val); 
            $newsclassidStr .= $newsclassid.',';      
        }
        $newsclassid = rtrim($newsclassidStr,',');
    	if (!empty($newsclassid)) {
    		$result = $this->model_news_category->delNewsClass($newsclassid);
    		if ($result) {
    			redirect(CFG_ADMINURL.'/newsclass');
    		} else {
    			redirect(CFG_ADMINURL.'/newsclass');
    		}
    	}
    }
        
}