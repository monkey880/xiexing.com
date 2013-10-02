<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID usergroup.php
 * 携行酒店分销联盟（后台用户组）模块
 * @date 2013-3-7
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Usergroup extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'usergroup';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_admin');
        $this->load->model('model_config');
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
        
    	$usergrouparr = $this->model_admin->getusergroupList(array(),'listorder');
        foreach($usergrouparr as $key=>$item) {
    		$usergrouparr[$key]['status']=$item['status'] == 1 ? $this->model_config->status_ary(1) : $this->model_config->status_ary(0);
    	}
        $data['usergroupList'] = $usergrouparr;
        $data = array_merge($data,$this->userinfo);
    	
        $data['method'] = $this->uri->segment(2) ;  
        $this->load->view('admin/admin_usergrouplist',$data);
    }

    /**
     * 显示添加或修改管理员界面
     */
    public function add_usergroup()
    {    
    	$id = intval($this->uri->segment(4));
        
    	if ($id > 0 ) {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    		$info = $this->model_admin->getUsergroupInfo($id);
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
	        $info = array();
            
            $info['id'] = '';
            $info['varname'] = '';
            $info['title'] = '';  
            $info['status'] = '';   
            $info['listorder'] = '';                 
    	}
        $id = $info['id'];
        
        //构造权限页面状态
        if ($info['status'] !== '') {
            $optionsStatus = $info['status'];    
        } else {
            $optionsStatus = 1;    
        }
        $radio = $this->model_config->status_ary();
        $info['radio'] = form_radio('status', $radio,$optionsStatus);
        //构造权限菜       
		$view = $this->model_admin->getUsergroupInfo($id);
		$purview = unserialize($view['purview']);
		$arr = $this->model_admin->getpurviewList(array('status'=>1));
		foreach($arr as $item) {
			$item['checkid'] = '<input type=checkbox '.(isset($purview[0])&&$purview[0]&&@in_array($item['id'],$purview[0])?'checked':'').' name=\'purviewid[]\' value='.$item['id'].'>';
			if($item['method']!=''){
				$item['methodcheck'] = '<input type="checkbox"  name="'.$item['class'].'_method[]"  onclick="checkAll(this,\''.$item['class'].'_method[]\')">全选';
				$item['method'] = explode(',',$item['method']);
				foreach($item['method'] as $methodview){
					$item['methodcheck'] .= '<input type="checkbox" '.(isset($purview[1][$item['class']]['method'])&&$purview[1][$item['class']]['method']&&in_array($methodview,$purview[1][$item['class']]['method'])?'checked':'').'  name="'.$item['class'].'_method[]" value="'.$methodview.'">'.$this->model_config->operate_ary('btn_'.$methodview);
				}
            }else{
				$item['methodcheck']  = '';
			}
			$newarr[] = $item;
            
		}
		$str = "<tr>" .
				"<td width=30>\$checkid</td>" .
				"<td width=150>\$spacer \$title</td>" .
				"<td>\$methodcheck</td>";
		$arr = array('listarr'=>$newarr,'liststr'=>$str);
		$this->load->library('tree', $arr);
		$data['liststr'] = $this->tree->getlist();
		
        
        
        $data['info'] = $info;
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_usergroup_add',$data);
    }
    
    /**
     * 新增/修改管理员
     */
    public function save_usergroup()
    {
        /* 初始化变量 */
        $id = (int) $this->input->post('id', TRUE);
        $title = $this->input->post('title', TRUE);
        $status = (int) $this->input->post('status', TRUE);
        $listorder = (int) $this->input->post('listorder', TRUE);
        
        //修改用户组权限
	    $purviewids = $this->input->post('purviewid');  
        $arr = $this->model_admin->getpurviewList(array('status'=>1),$order='listorder',$extWhere = array('id'=>$purviewids));
		$newpurviewid = array();
		$newpurviewarr = array();
		foreach($arr as $key=>$item){
			$newpurviewid[] = $item['id'];
			$newpurviewarr[$item['class']]['id'] = $item['id'];
			$newpurviewarr[$item['class']]['class'] = $item['class'];
			$newpurviewarr[$item['class']]['method'] = $this->input->post($item['class'].'_method');
			$grouppurview[$item['parent']][] = $item;
			if($item['parent']==0){
				$parentpurview[$item['id']] = $item;	
			}
		}
		$purview = array(0=>$newpurviewid,1=>$newpurviewarr,2=>$grouppurview,3=>$parentpurview);
		$purview = serialize($purview);

        $info = array(
            'id' => $id,
            'title' => $title,
            'status' => $status,
            'listorder' => $listorder,
            'isupdate' => 1,
            'purview' => $purview
        );
        
        if ($id > 0) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            
            $where = array('id'=>$id);
            $rs = $this->model_admin->addusergroup('update',$info,$where);
            if ($rs) {
                $this->model_admin->resetPurview();
                $alertMsg = '修改用户组成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/usergroup/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '修改用户组失败';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/usergroup/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            }
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $rs = $this->model_admin->addUsergroup('insert',$info);
            if ($rs) {
                $this->model_admin->resetPurview();
                $alertMsg = '添加用户组成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/usergroup');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '添加用户组失败';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/usergroup');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            }
        }
    }
    
    /**
     * 删除一条/多条管理员
     */
    public function del_usergroup ()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
    	$usergroupid = $this->uri->segment(4);
        if ($usergroupid == 1) {
            exit();   
        }
    	if (!empty($usergroupid)) {
    		$result = $this->model_admin->delUsergroup($usergroupid);
    		if ($result) {
    		    $this->model_admin->resetPurview();
    			redirect(CFG_ADMINURL.'/usergroup');
    		} else {
    			redirect(CFG_ADMINURL.'/usergroup');
    		}
    	}
    }
        
}