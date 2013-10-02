<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID ad.php
 * 携行酒店分销联盟（后台广告管理）模块
 * @date 2013-2-27 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Ad extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'ad';
	
    function __construct ()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_ad');
        $this->load->model('model_config');
        $this->load->library('tool');
        $this->load->library('pagination');
        $this->load->helper('form');
        $this->load->model('model_admin');
    }
    
    public function index ()
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
        
        $adCount = $this->model_ad->getAdCount();
        $pageinfo = $this->tool->get_page_info($page,$adCount,$pagesize);   
        $adList = $this->model_ad->getAdList($pageinfo['start'],$pagesize);
        $adidStr = '';
        foreach ($adList as $key) {
        	$adidStr .= $key['ad_id'].',';
        }
        $adidStr = rtrim($adidStr,',');
        //分页
        $config['base_url'] = base_url(CFG_ADMINURL.'/ad/index/');
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

        $data['adidStr'] = $adidStr;
        $data['method'] = $this->uri->segment(2) ;      
        $data['adList'] = $adList ;          
        $data['pagenav'] = $pagnav ; 
        $data['page'] = $page;   
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_adlist',$data);
    }
    
    /**
     * 显示添加或修改广告界面
     */
    public function ad_add()
    {    
    	$adid = intval($this->uri->segment(4));
    	if ($adid > 0 ) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
    		$info = $this->model_ad->getAdInfo($adid);
    		//处理显示信息
    		$info['ad_starttime_show'] = !empty($info['ad_starttime']) ? date('Y-m-d', $info['ad_starttime']) : '';
    		$info['ad_endtime_show'] = !empty($info['ad_endtime']) ? date('Y-m-d', $info['ad_endtime']) : '';
    	} else {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
	        $info = array();
            
            $info['ad_id'] =  0;
            $info['ad_title'] = '';
            $info['ad_link'] = 'http://';
            $info['ad_width'] = '';
            $info['ad_height'] = '';
            $info['ad_type_radio'] = '';
            $info['ad_uploadfile'] = '';
            $info['ad_order'] = '0';
            $info['ad_starttime'] = '';   
            $info['ad_endtime'] = '';
            $info['ad_starttime_show'] = '';    
            $info['ad_endtime_show'] = '';    
            $info['ad_state_radio'] = '';
            $info['ad_addtime'] =  0;                
            $info['ad_externallinks'] = '';
            $info['ad_area'] = '';
            $info['ad_name'] = '';                      
    	}
       
        $ad_type_radio_arr = $this->model_config->ad_type_radio_ary();
        $info['ad_type_radio_arr'] = $ad_type_radio_arr;
        $ad_state_radio_arr = $this->model_config->ad_state_radio_ary();
        $info['ad_state_radio_arr'] = $ad_state_radio_arr;
        
        $data = array_merge($info,$this->userinfo);
        $this->load->view('admin/admin_ad_add',$data);
    }
    
    /**
     * 保存广告
     */
    public function save_ad ()
    {    
        /* 初始化变量 */
        $ad_id = (int) $this->input->post('ad_id', TRUE);
        $page = (int) $this->input->post('page', TRUE);
        $area = $this->input->post('area', TRUE);
        $title = $this->input->post('title', TRUE);
        $sizewidth = (int) $this->input->post('sizewidth', TRUE);
        $sizeheight = (int) $this->input->post('sizeheight', TRUE);
        $link = $this->input->post('link', TRUE);
        $ad_type_radio = (int) $this->input->post('type_radio', TRUE);
		$ad_externallinks = stripcslashes($this->input->post('externallinks', TRUE));
        $ad_order = (int)$this->input->post('order', TRUE);
        $ad_state_radio = (int) $this->input->post('state_radio', TRUE);
        $ad_starttime = (int) strtotime($this->input->post('start_date', TRUE));
        $ad_endtime = (int) strtotime($this->input->post('end_date', TRUE));
        $ad_name = $this->input->post('ad_name', TRUE);
    	$img = '';
        if ($ad_type_radio == 2) {
        	$config['upload_path'] = ROOTPATH.DIRECTORY_SEPARATOR.'public/uploadfiles/ad/';
        	$config['allowed_types'] = 'gif|jpg|png';
        	$config['encrypt_name'] = TRUE; // 上传的文件将被重命名为随机的加密字符串
        	$config['max_size'] = '2048'; // 允许上传文件大小的最大值(以K为单位).该参数为0则不限制。
        	$this->load->library('upload', $config);
        	$do = $this->upload->do_upload();
        	$imageData = array('upload_data' => $this->upload->data());
        	$img = $imageData['upload_data']['file_name'];
        	if (!$do && !($ad_id > 0 && $img == '')){
        		$error = array('error' => $this->upload->display_errors());
        		echo "<script>alert('{$error['error']}')</script>";
        		exit;
        	}
        	if ($img) {
        		$img = '/public/uploadfiles/ad/'.$img;
        	}
        }
        
        //判断ad_name已经存在
        $check_ad_id = $this->model_ad->checkAdName($ad_name);
        if ($check_ad_id && ($ad_id != $check_ad_id['ad_id'])) {
            echo '<script>alert("别名'.$ad_name.'已经存在！")</script>';
            exit;
        }  
        
        /* 验证不能为空 */
        if (!$area) {
            echo "<script>alert('广告位置不能为空')</script>";
            exit;
        }
        if (!$title) {
            echo "<script>alert('广告标题不能为空')</script>";
            exit;
        }
        if (!$ad_name) {
            echo "<script>alert('广告位置代号不能为空')</script>";
            exit;
        }
        if (!$link) {
            echo "<script>alert('广告链接不能为空')</script>";
            exit;
        }
        // TODO goon to verify

        $info = array(
            'ad_title' => $title,
            'ad_width' => $sizewidth,
            'ad_height' => $sizeheight,
            'ad_link' => $link,
            'ad_type_radio' => $ad_type_radio,
            'ad_order' => $ad_order,
            'ad_state_radio' => $ad_state_radio,
            'ad_starttime' => $ad_starttime,
            'ad_endtime' => $ad_endtime,
            'ad_area' => $area,            
            'ad_externallinks' => $ad_externallinks,
            'ad_addtime' => time(),
            'ad_area' => $area,
            'ad_name' => $ad_name            
        );
        if ($img) {
        	$info['ad_uploadfile'] = $img;
        }

        if ($ad_id > 0) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $where = array('ad_id'=>$ad_id);
            $rs = $this->model_ad->addAd('update',$info,$where);
            if ($rs) {
                $alertMsg = '修改广告成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/ad/index/'.$page);
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '修改广告失败';
                echo '<script>alert("'.$alertMsg.'");</script>';
            }
        } else {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $rs = $this->model_ad->addAd('insert',$info);
            if ($rs) {
                $alertMsg = '添加广告成功';
                $redirectUrl = site_url('/'.CFG_ADMINURL.'/ad');
                echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
                $alertMsg = '添加广告失败';
                echo '<script>alert("'.$alertMsg.'");</script>';
            }
        }
    }
    
    /**
     * 删除
     */
    public function del_ad ()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
    	$urlAdid = $this->uri->segment(4);
        $adidArr = explode('-',$urlAdid);
        $adidStr = '';
        foreach ($adidArr as $val) {
            $adid = intval($val); 
            $adidStr .= $adid.',';      
        }
        $adid = rtrim($adidStr,',');
    	if (!empty($adid)) {
    		$result = $this->model_ad->delAd($adid);
    		if ($result) {
    			redirect(CFG_ADMINURL.'/ad/index');
    		} else {
    			redirect(CFG_ADMINURL.'/ad/index');
    		}
    	}
    }
    
    /**
     * 生成代码引入js
     */
    public function ajax_make_link () 
    {
    	$ad_id = (int) $this->uri->segment(4);
    	$data['ad_id'] = $ad_id;
    	$this->load->view('admin/admin_makelink',$data);
    }
    /**
     * 生成js代码
     */
    public function ajax_make_code () 
    {
    	$ad_id = (int) $this->uri->segment(4);
    	$adinfo = $this->model_ad->getAdInfo($ad_id) ;
    	if ($adinfo['ad_type_radio'] == 1) {
    		$rs = "<a href='".base_url()."{$adinfo['ad_link']}'>{$adinfo['ad_title']}</a>";
    	} else if ($adinfo['ad_type_radio'] == 2) {
    		$rs = "<img src='".base_url()."{$adinfo['ad_uploadfile']}'>";
    	} else {
    		$rs = $adinfo['ad_externallinks'];
    	}
    	$data['rs']= $rs;
        echo 'document.writeln('.'"'.$rs.'"'.')';

    }
}