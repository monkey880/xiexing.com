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

class Api_meituan extends CI_Controller 
{
    
	private $userinfo;
    private $tablefunc = 'news';
	
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
        $this->load->model('model_city');
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
    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;
        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;
        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);
        
        $page = intval($this->uri->segment(5)) ;
        $page = $page <= 0 ? 1 : $page ;
        $pagesize = 10 ;
        
        $class_id = intval($this->uri->segment(4)) ;
        $whereSql = '';
        if ($class_id) {
            $whereSql = array('class_id'=>$class_id); 
            $whereSqlList = "where class_id=$class_id";   
        } else {
            $whereSql = array('class_id !='=>$class_id); 
            $whereSqlList = "where class_id!=$class_id";          
        }
        $newscount = $this->model_news->get_count($whereSql);
        $pageinfo = $this->tool->get_page_info($page,$newscount,$pagesize);
        $newsdata = $this->model_news->get_list($pageinfo['start'],$pagesize,'aid desc',$whereSqlList);
        $newslist = array();
        foreach ($newsdata as $key => $news){
        	
        	$cityname = $this->model_city->get_local_city_byid($news['CityID']);
        	$citname = empty($cityname) ? '未关联 ' : $cityname['cName'];
        	$newslist[$key] = $news;
        	$newslist[$key]['cityname'] = $citname;
        	
        }
        //生成新闻分类的select菜单
        $newsclass = $this->model_news_category->get_category();
        $newsclass[0] = '不限';
        $newsclass_select = form_dropdown('category',$newsclass,$class_id,'id=class_news');
        
        //生成修改资讯分类的select菜单
        $change_newsclass_select = form_dropdown('change_class_news',$newsclass,$class_id,'id=change_class_news');
        
        //分页
        $config['base_url'] = base_url(CFG_ADMINURL.'/news/index/'.$class_id);
        $config['suffix'] = $this->config->item('url_suffix');
        $config['total_rows'] = $newscount ;
        $config['uri_segment'] = 5;
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
        $data['newslist'] = $newslist ;      
        $data['newscount'] = $newscount ;      
        $data['pagenav'] = $pagnav ;  
        $data['page'] = $page;
        $data['class_id'] = $class_id;
        $data['newsclass_select'] = $newsclass_select ;  
        $data['change_newsclass_select'] = $change_newsclass_select ;  
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_newslist',$data);
    }

    /**
     * 显示添加或修改新闻界面
     */
    public function add_news()
    {    
    	$newsid = intval($this->uri->segment(4));
    	if($newsid > 0 ){
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    } 
    		$info = $this->model_news->get_newsinfo($newsid);
    		$cityInfo = $this->model_city->get_local_city_byid($info['CityID']);
    		$cityJson = json_encode(array('id'=>$cityInfo['cid'],'cityname'=>$cityInfo['cName']));
    	}else{
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
	        $info = array();
	        $info['title'] = '';
	        $info['aid'] = 0;
	        $info['content'] = '';
	        $info['author'] = '';
	        $info['smallcontent'] = '';
	        $info['class_id'] = '';
	        $info['state_radio'] = 1;
	        $info['img'] = '';
            $info['CityID'] = '';
            $info['order'] = '0';
            
            $cityInfo = $this->model_city->getInitCityList();
            $cityJson = json_encode(array('id'=>$cityInfo[0]['cityid'],'cityname'=>$cityInfo[0]['cityname']));
    	}
    	$newsclass = $this->model_news_category->get_category();
    	//生成新闻分类的select菜单
    	$newsclass_select = form_dropdown('category',$newsclass,$info['class_id']);
    	//生成显示状态的radio单选按钮
    	$state_radio_data = $this->model_config->state_radio_ary();
    	
    	$info['newsclass_select'] = $newsclass_select;
    	$info['state_radio_data'] = $state_radio_data;
    	$data = array_merge($info,$this->userinfo);
    	$data['cityJson'] = $cityJson;
        $this->load->view('admin/admin_news_add',$data);
    }
    
    /**
     * 保存新闻
     */
    public function save_news()
    {
    	$aid = (int) $this->input->post('aid', TRUE);
    	$page = (int) $this->input->post('page', TRUE);
    	$title = $this->input->post('title', TRUE);
    	$content = stripcslashes($_POST['content']);   
    	$category = (int) $this->input->post('category', TRUE);
    	$state_radio = (int) $this->input->post('state_radio', TRUE);
    	$cityid = $this->input->post('cityid', TRUE);
    	$smallcontent = $this->input->post('smallcontent', TRUE);
    	$order = (int) $this->input->post('order', TRUE);
    	$author = $this->input->post('author', TRUE);
    	// 定义上传类upload的上传规则
    	$img = '';
    	if ($state_radio == 4) {
    		$config['upload_path'] = ROOTPATH.DIRECTORY_SEPARATOR.'public/uploadfiles/upload/';
    		$config['allowed_types'] = 'gif|jpg|png';
    		$config['encrypt_name'] = TRUE; // 上传的文件将被重命名为随机的加密字符串
    		$config['max_size'] = '2048'; // 允许上传文件大小的最大值(以K为单位).该参数为0则不限制。
    		$this->load->library('upload', $config);
    		$do = $this->upload->do_upload();
    		$imageData = array('upload_data' => $this->upload->data());
    		$img = $imageData['upload_data']['file_name'];
    		if (!$do && !($aid > 0 && $img == '')){
    			$error = array('error' => $this->upload->display_errors());
    			echo "<script>alert('{$error['error']}')</script>";
    			exit;
    		} 
    	} 
    	
    	$data = array();
    	$data['aid'] = $aid;
    	$data['title'] = $title;
    	$data['content'] = $content;
    	$data['author'] = $author;
    	$data['smallcontent'] = $smallcontent;
    	$data['class_id'] = intval($category);
    	$data['state_radio'] = intval($state_radio);
    	$data['CityID'] = $cityid;
    	if ($img) {
    		$data['img'] = $img;
    	}
    	$data['order'] = $order;
        $data['time'] = time();
        $data['view_num'] = 0;
        
        if ( $aid > 0 ) {
            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $result = $this->model_news->save_news($data,'update');
            if ($result) {
            	$alertMsg = '修改资讯成功';
            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/news/index/0/'.$page);
            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
            	$alertMsg = '修改资讯失败';
            	echo '<script>alert("'.$alertMsg.'");</script>';
            }
    	}else {
    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
    	    if (!$isoperate) {
               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	       die();   
    	    }
            $result = $this->model_news->save_news($data,'insert');
            if ($result) {
            	$alertMsg = '添加资讯成功';
            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/news');
            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
            	$alertMsg = '添加资讯失败';
            	echo '<script>alert("'.$alertMsg.'");</script>';
            }
    	}
    	
    }
    
    /**
     * 保存新闻
     */
    public function changeNewsclass()
    {
    	$isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
    	$urlNewsid = $this->uri->segment(4);
    	$urlClassid = $this->uri->segment(5);
        $newsidArr = explode('-',$urlNewsid);
        $newsidStr = '';
        foreach ($newsidArr as $val) {
            $newsid = intval($val); 
            $newsidStr .= $newsid.',';      
        }
        $newsid = rtrim($newsidStr,',');
        $data = array('class_id'=>$urlClassid);
    	if(!empty($newsid)){
    		$result = $this->model_news->save_news($data,'update',"aid in ($newsid)");
            if ($result) {
            	$alertMsg = '修改资讯分类成功';
            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/news/index/0/'.$page);
            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            } else {
            	$alertMsg = '修改资讯分类失败';
            	echo '<script>alert("'.$alertMsg.'");</script>';
            }
    	}
    	
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
    	$urlClassid = $this->uri->segment(5);
        $newsidArr = explode('-',$urlNewsid);
        $newsidStr = '';
        foreach ($newsidArr as $val) {
            $newsid = intval($val); 
            $newsidStr .= $newsid.',';      
        }
        $newsid = rtrim($newsidStr,',');
    	
    	if(!empty($newsid)){
    		$result = $this->model_news->del_news($newsid);
    		if($result){
    			redirect(CFG_ADMINURL.'/news/index/'.$urlClassid);
    		}else{
    			redirect(CFG_ADMINURL.'/news/index/'.$urlClassid);
    		}
    	}
    }
        
}