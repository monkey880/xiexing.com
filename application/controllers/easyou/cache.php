<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID cache.php
 * 携行联盟分销程序 后台清理缓存
 * @date 2013-3-21 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */



class Cache extends CI_Controller 
{
	function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_cache');
        $this->load->helper('form');
    }
    
    /**
     * 后台缓存列表
     */
    public function index()
    {   
        @set_time_limit(0);
        //取出所有缓存情况
        $rs = $this->model_cache->getCacheList();

        $data['method'] = $this->uri->segment(2) ;      
        $data['list'] = $rs ; 
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_cache',$data);
    }
    /**
     * ajax调用删除缓存方法
     */
    public function del_cache()
    {  
        $folder = array('\comment','\expo','\hotel','\lable');
        $rs = $this->model_cache->delCacheList($folder);
        $redirectUrl = site_url('/'.CFG_ADMINURL.'/cache');
        if ($rs) {
            $alertMsg = '清理完成';
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
        } else {
            $alertMsg = '好像未删除干净,请重试';
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
        }
    }

    
        
}