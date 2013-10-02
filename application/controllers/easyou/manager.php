<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID manager.php
 * 携行酒店分销联盟（后台管理员管理）模块
 * @date 2013-3-7
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Manager extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'manager';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_admin');
        $this->load->library('pagination');
        $this->load->library('tool');
        $this->load->helper('form');
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
        
        $managerCount = $this->model_admin->getManagerCount();
        $pageinfo = $this->tool->get_page_info($page,$managerCount,$pagesize);   
        $managerList = $this->model_admin->getManagerList($pageinfo['start'],$pagesize);
        //分页
        $config['base_url'] = base_url(CFG_ADMINURL.'/manager/index/');
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $managerCount ;
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
        $data['managerList'] = $managerList ;          
        $data['pagenav'] = $pagnav ; 
        $data['page'] = $page;
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_managerlist',$data);
    }

    /**
     * 显示添加或修改管理员界面
     */
    public function add_manager()
    {    
    	$id = intval($this->uri->segment(4));
    	if ($id > 0 ) {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    		$info = $this->model_admin->getManagerInfo($id);
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
	        $info = array();
            
            $info['id'] = '';
            $info['username'] = '';
            $info['name'] = '';
            $info['password'] = '';  
            $info['rank'] = '';                     
    	}
        //构造管理员类型select
        $options = $this->model_admin->getAdminType(2);
        if ($info['rank'] !== '') {
            $optionsSelected = $info['rank'];    
        } else {
            $optionsSelected = 1;    
        }
        $select = form_dropdown('rank',$options,$optionsSelected,'id=rank');
        $info['select'] = $select;
        
        $data = $this->userinfo;
        $data['info'] = $info;
        $this->load->view('admin/admin_manager_add',$data);
    }
    
    /**
     * 新增/修改管理员
     */
    public function save_manager()
    {
        /* 初始化变量 */
        $page = (int) $this->input->post('page', TRUE);
        $id = (int) $this->input->post('id', TRUE);
        $username = $this->input->post('username', TRUE);
        $name = $this->input->post('name', TRUE);
        $password = $this->input->post('password', TRUE);
        $rank = (int) $this->input->post('rank', TRUE);
        /* 验证不能为空 */
        if (!$username) {
            echo "<script>alert('管理员登录名不能为空')</script>";
            exit;
        }
        if (!$name) {
            echo "<script>alert('管理员真实姓名不能为空')</script>";
            exit;
        }
        //验证id和admin不能重复
        $usernameCount = $this->model_admin->checkManageName($username, $id);
        if ($usernameCount > 0) {
            $alertMsg = '用户名已经存在';
            $redirectUrl = site_url('/'.CFG_ADMINURL.'/manager/add_manager/'.$id.'/'.$page);
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>'; 
            exit;     
        }

        $info = array(
            'username' => $username,
            'name' => $name,
            'rank' => $rank,
            'logintime' => $_SERVER['REQUEST_TIME']
        );
        if (!empty($password)) { //如果修改时密码为空 就不用改
        	$info['password'] = md5(md5($password.CFG_AGENTID));
        }
        if ($id > 0) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $userinfo = $this->userinfo;
            if ($id != $userinfo['id']&&$userinfo['id'] != 1 ) {
                exit();    
            }
            if ($id == 1 || $userinfo['id'] != 1) {
                unset($info['rank']) ;    
            }
            $where = array('id'=>$id);
            $rs = $this->model_admin->addManager('update',$info,$where);
            if ($rs) {
                $alertMsg = '修改管理员成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/manager/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '修改管理员失败';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/manager/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            }
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $rs = $this->model_admin->addManager('insert',$info);
            if ($rs) {
                $alertMsg = '添加管理员成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/manager');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '添加管理员失败';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/manager');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            }
        }
    }
    
    /**
     * 删除一条/多条管理员
     */
    public function del_manager ()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
    	$urlmanagerid = $this->uri->segment(4);
        $manageridArr = explode('-',$urlmanagerid);
        $manageridStr = '';
        foreach ($manageridArr as $val) {
            $managerid = intval($val); 
            if ($managerid == 1) {
                exit();    
            }
            $manageridStr .= $managerid.',';      
        }
        $managerid = rtrim($manageridStr,',');
    	if (!empty($managerid)) {
    		$result = $this->model_admin->delManager($managerid);
    		if ($result) {
    			redirect(CFG_ADMINURL.'/manager');
    		} else {
    			redirect(CFG_ADMINURL.'/manager');
    		}
    	}
    }
        
}