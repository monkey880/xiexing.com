<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID purview.php
 * 携行酒店分销联盟（后权限菜单）模块
 * @date 2013-3-7
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Purview extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'purview';
	
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
        $this->load->library('tool');
        $this->load->helper('form');
    }
    
    public function index()
    { 
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        $purviewarr = $this->model_admin->getpurviewList(array(),'listorder');
    	$isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;
    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;
        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;
    	foreach($purviewarr as $item) {
    		$item['status']=$item['status'] == 1 ? $this->model_config->status_ary(1) : $this->model_config->status_ary(0);
    		$item['func'] = '';
    		$item['title'] = $item['title'];
            $item['func'] .= $isdel ? "<a class='sc' href='javascript:void(0)' onclick='delete_one_purview(".$item['id'].")'>删除</a>" : '';
	        $item['func'] .= $isedit ? "<a class='xg' href='".site_url(CFG_ADMINURL.'/purview/add_purview/'.$item['id'])."'>修改</a>" : '';
    		$newarr[] = $item;
    	}
    	$str = "<tr id='id_\$id'>
    			<td width=40>\$id</td>
    			<td class='left' width=200>\$spacer <input type='hidden' name='ids[]' value='\$id'>\$title</td>
                <td class='left'>\$class</td>
    			<td class='left'>\$method</td>
                <td  width=50 align='left'>\$status</td>
    			<td width=50 >\$func</td></tr>";
    	$arr = array('listarr'=>$newarr,'liststr'=>$str);
    	$this->load->library('tree', $arr);
    	$data = array(
    		'liststr'=>$this->tree->getlist(),
            'purview'=>array('isadd'=>$isadd)
    	);
    	
        $data['method'] = $this->uri->segment(2) ;  
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_purviewlist',$data);
    }

    /**
     * 显示添加或修改管理员界面
     */
    public function add_purview()
    {    
    	$id = intval($this->uri->segment(4));
        
    	if ($id > 0 ) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    		$info = $this->model_admin->getPurviewInfo($id);
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
	        $info = array();
            
            $info['id'] = '';
            $info['parent'] = '';
            $info['title'] = '';  
            $info['class'] = '';  
            $info['method'] = '';  
            $info['status'] = '';   
            $info['listorder'] = '';                 
    	}
        //构造权限页面顶级菜单select 
        $purviewarr = $this->model_admin->getpurviewList(array('parent'=>0),'listorder');
        foreach($purviewarr as $key=>$item) {
    		$options[$item['id']] = $item['title'];
    	}
        $options[0] = '顶级菜单';
        if ($info['parent'] != '') {
            $selectedParent = $info['parent'];    
        } else {
            $selectedParent = 0;    
        }
        $info['options'] = form_dropdown('parent', $options ,$selectedParent);
        //构造权限页面状态
        if ($info['status'] !== '') {
            $optionsStatus = $info['status'];    
        } else {
            $optionsStatus = 1;    
        }
        $radio = $this->model_config->status_ary();
        $info['radio'] = form_radio('status', $radio,$optionsStatus);
        
        $data['info'] = $info;
        
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_purview_add',$data);
    }
    
    /**
     * 新增/修改管理员
     */
    public function save_purview()
    {
        /* 初始化变量 */
        $id = (int) $this->input->post('id', TRUE);
        $parent = $this->input->post('parent', TRUE);
        $title = $this->input->post('title', TRUE);
        $class = $this->input->post('class', TRUE);
        $method = $this->input->post('method', TRUE);
        $status = (int) $this->input->post('status', TRUE);
        $listorder = (int) $this->input->post('listorder', TRUE);

        $info = array(
            'id' => $id,
            'parent' => $parent,
            'title' => $title,
            'class' => $class,
            'method' => $method,
            'status' => $status,
            'listorder' => $listorder,
        );
        
        if ($id > 0) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $where = array('id'=>$id);
            $rs = $this->model_admin->addpurview('update',$info,$where);
            if ($rs) {
                $this->model_admin->resetPurview();
                $alertMsg = '修改权限页面成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/purview/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '修改权限页面失败';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/purview/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            }
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $rs = $this->model_admin->addPurview('insert',$info);
            if ($rs) {
                $this->model_admin->resetPurview();
                $alertMsg = '添加权限页面成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/purview');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '添加权限页面失败';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/purview');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            }
        }
    }
    
    /**
     * 删除一条/多条管理员
     */
    public function del_purview ()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        
    	$purviewid = $this->uri->segment(4);
    	if (!empty($purviewid)) {
    		$result = $this->model_admin->delPurview($purviewid);
    		if ($result) {
    		    $this->model_admin->resetPurview();
    			redirect(CFG_ADMINURL.'/purview');
    		} else {
    			redirect(CFG_ADMINURL.'/purview');
    		}
    	}
    }
        
}