<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID news.php
 * 携行酒店分销联盟（后台新闻管理）模块
 * @date 2013-2-27 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Cards extends CI_Controller 
{
    
	
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
     
        $this->load->library('tool');
        $this->load->library('pagination');
        $this->load->helper('form');
		$this->load->model('model_admin');
        $this->load->model('model_cards');
        
    }
    
    /**
     * 后台新闻列表
     */
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
        
       
        $whereSql = '';
		
       
            $whereSql = array('status'=>0); 
            $whereSqlList = "where status=0";   
       
        $newscount = $this->model_cards->get_count($whereSql);
        $pageinfo = $this->tool->get_page_info($page,$newscount,$pagesize);
       $newsdata = $this->model_cards->get_list($pageinfo['start'],$pagesize,'cid desc',$whereSqlList);
		
        
        
        //分页
        $config['base_url'] = base_url(CFG_ADMINURL.'/cards/index');
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $newscount ;
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
        $data['newslist'] = $newsdata ;      
        $data['newscount'] = $newscount ;      
        $data['pagenav'] = $pagnav ;  
        $data['page'] = $page;
        
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_cardslist',$data);
    }

    /**
     * 显示添加或修改新闻界面
     */
    public function add_cards()
    {    
	
		$action=$this->input->post('action');
		if($action=='add'){
		$startid=$this->input->post('startid');
		$num=$this->input->post('num');
		
		$endid=$startid+$num;
	
    	 for(;$startid<$endid;$startid++)
		  {
			  if(!strchr($startid,'4')){
			  $data['cardnum']=$startid;
			 $this->model_cards->save_cards($data);
			  
			  }
		  }
		  $alertMsg = '生成会员卡成功';
            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/cards');
            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
		}
        $this->load->view('admin/admin_ad_cards');
    }
    
   
    /**
     * 删除新闻
     */
    public function del_news()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
    	$urlNewsid = $this->uri->segment(4);
    	
        $newsidArr = explode('-',$urlNewsid);
        $newsidStr = '';
        foreach ($newsidArr as $val) {
            $newsid = intval($val); 
            $newsidStr .= $newsid.',';      
        }
        $newsid = rtrim($newsidStr,',');
    	
    	if(!empty($newsid)){
    		$result = $this->model_cards->del_news($newsid);
    		if($result){
    			redirect(CFG_ADMINURL.'/cards');
    		}else{
    			redirect(CFG_ADMINURL.'/cards');
    		}
    	}
    }
        
}