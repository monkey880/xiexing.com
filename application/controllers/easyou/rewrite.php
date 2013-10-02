<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID rewrite.php
 * 携行联盟分销程序 后台伪静态设置
 * @date 2013-3-21 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */



class Rewrite extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'rewrite';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        $this->load->model('model_rewrite');
        $this->load->library('tool');
        $this->load->model('model_admin');
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
        $data['operate'] = array('isedit'=>$isedit);
        
        $where = 'where is_show = 1 ';
        $rewrite_list = $this->model_rewrite->get_list('rewrite_id',$where);

        $data['method'] = $this->uri->segment(2) ;      
        $data['list'] = $rewrite_list ;        
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_rewrite',$data);
    }

    function test(){
    	$old_rewrite = $this->model_rewrite->get_one('2');
    	print_r($old_rewrite);
    }
    /**
     * 保存规则
     */
    public function save_rewrite()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        
    	$rewrite_id = (int) $this->input->post('rewrite_id', TRUE);
    	$rewrite_new = stripcslashes($this->input->post('rule', TRUE));
    	$rewrite_org = stripcslashes($this->input->post('rule_org', TRUE));

    	$old_rewrite = $this->model_rewrite->get_one($rewrite_id);
    	/**
    	 * 1修改数据库
    	 * 2修改routes
    	 * 3修改tool中的规则
    	 */
    	$data = array();
    	$data['rewrite_id'] = $rewrite_id;
    	$data['rewrite_new'] = $rewrite_new;

        
        
        if ( $rewrite_id > 0 ) {
            $result = $this->model_rewrite->save_rewrite($data,'update');
            $this->model_rewrite->replace_routes();
            $this->model_rewrite->replace_nav($old_rewrite['rewrite_new'],$rewrite_new);
            $this->model_rewrite->replace_lib($rewrite_org,$rewrite_new);
            if ($result) {
            	$alertMsg = '修改成功';
            	exit(json_encode(array("status"=>1,"msg"=>$alertMsg ))) ;
            } else {
            	$alertMsg = '修改失败';
            	exit(json_encode(array("status"=>0,"msg"=>$alertMsg ))) ;
            }
        }
    }

        
}