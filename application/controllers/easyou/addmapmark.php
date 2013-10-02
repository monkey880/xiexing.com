<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID help.php
 * 携行酒店分销联盟（使用手册）模块
 * @date 2013-2-27 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Addmapmark extends CI_Controller 
{
    
	private $userinfo;
	
    function __construct ()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
    }
    
    public function index ()
    {    
        
        $data['cityName'] = $this->input->get('city') ;  
		$data['keywords'] = $this->input->get('keywords') ;  
        $this->load->view('admin/admin_addmapmark',$data);
    }
}