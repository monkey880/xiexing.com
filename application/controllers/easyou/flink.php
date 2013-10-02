<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID flink.php
 * 携行酒店分销联盟（后台友情链接管理）模块
 * @date 2013-3-7
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Flink extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'flink';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_flink');
        $this->load->library('pagination');
        $this->load->model('model_config');
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
        
        $flinkCount = $this->model_flink->getFlinkCount();
        $pageinfo = $this->tool->get_page_info($page,$flinkCount,$pagesize);   
        $flinkList = $this->model_flink->getFlinkList($pageinfo['start'],$pagesize);
        //分页
        $config['base_url'] = base_url(CFG_ADMINURL.'/flink/index/');
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $flinkCount ;
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
        $data['flinkList'] = $flinkList ;          
        $data['pagenav'] = $pagnav ; 
        $data['page'] = $page;
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_flinklist',$data);
    }

    /**
     * 显示添加或修改友情链接界面
     */
    public function add_flink()
    {    
    	$flinkid = intval($this->uri->segment(4));
    	if ($flinkid > 0 ) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    		$info = $this->model_flink->getFlinkInfo($flinkid);
    	} else {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
	        $info = array();
            
            $info['flink_id'] =  0;
            $info['flink_title'] = '';
            $info['flink_link'] = 'http://';
            $info['flink_uploadfile'] = '';
            $info['flink_order'] = '0';      
            $info['flink_externallinks'] = '';    
            $info['flink_type_radio'] = '';                        
    	}
       
        $flink_type_radio_arr = $this->model_config->flink_type_radio_ary();
        $info['flink_type_radio_arr'] = $flink_type_radio_arr;
        $data = array_merge($info,$this->userinfo);
        $this->load->view('admin/admin_flink_add',$data);
    }
    
    /**
     * 新增/修改友情链接
     */
    public function save_flink()
    {
        /* 初始化变量 */
        $flink_id = (int) $this->input->post('flink_id', TRUE);  
        $page = (int) $this->input->post('page', TRUE);
        $flink_title = $this->input->post('title', TRUE);         
        $flink_link = $this->input->post('link', TRUE);
        $flink_type_radio = (int) $this->input->post('type_radio', TRUE);
        $flink_externallinks = stripcslashes($this->input->post('externallinks', TRUE));
        $flink_order = (int) $this->input->post('order', TRUE);
        $img = '';
        if ($flink_type_radio == 2) {
        	$config['upload_path'] = ROOTPATH.DIRECTORY_SEPARATOR.'public/uploadfiles/flink/';
        	$config['allowed_types'] = 'gif|jpg|png';
        	$config['encrypt_name'] = TRUE; // 上传的文件将被重命名为随机的加密字符串
        	$config['max_size'] = '2048'; // 允许上传文件大小的最大值(以K为单位).该参数为0则不限制。
        	$this->load->library('upload', $config);
        	$do = $this->upload->do_upload();
        	$imageData = array('upload_data' => $this->upload->data());
        	$img = $imageData['upload_data']['file_name'];
        	if (!$do && !($flink_id > 0 && $img == '')){
        		$error = array('error' => $this->upload->display_errors());
        		echo "<script>alert('{$error['error']}')</script>";
        		exit;
        	}
        }
        
        /* 验证不能为空 */
        if (!$flink_title) {
            echo "<script>alert('友情链接标题不能为空')</script>";
            exit;
        }
        if (!$flink_link) {
            echo "<script>alert('友情链接不能为空')</script>";
            exit;
        }
        if (!$flink_type_radio) {
            echo "<script>alert('请选择友情链接类型')</script>";
            exit;
        }
        
        $info = array(
            'flink_title' => $flink_title,
            'flink_link' => $flink_link,
            'flink_type_radio' => $flink_type_radio,
            'flink_externallinks' => $flink_externallinks,
            'flink_order' => $flink_order,
            'flink_addusername' => $this->userinfo['username'],
            'flink_addtime' => time()
        );
        if ($img) {
        	$info['flink_uploadfile'] = $img;
        }
        
        if ($flink_id > 0) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $where = array('flink_id'=>$flink_id);
            $rs = $this->model_flink->addFlink('update',$info,$where);
            if ($rs) {
                $alertMsg = '修改友情链接成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/flink/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '修改友情链接失败';
                echo '<script>alert("'.$alertMsg.'");</script>';
            }
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $rs = $this->model_flink->addFlink('insert',$info);
            if ($rs) {
                $alertMsg = '添加友情链接成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/flink');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '添加友情链接失败';
                echo '<script>alert("'.$alertMsg.'");</script>';
            }
        }
    }
    
    /**
     * 删除一条/多条友情链接
     */
    public function del_flink ()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
    	$urlflinkid = $this->uri->segment(4);
        $flinkidArr = explode('-',$urlflinkid);
        $flinkidStr = '';
        foreach ($flinkidArr as $val) {
            $flinkid = intval($val); 
            $flinkidStr .= $flinkid.',';      
        }
        $flinkid = rtrim($flinkidStr,',');
    	if (!empty($flinkid)) {
    		$result = $this->model_flink->delFlink($flinkid);
    		if ($result) {
    			redirect(CFG_ADMINURL.'/flink');
    		} else {
    			redirect(CFG_ADMINURL.'/flink');
    		}
    	}
    }
        
}