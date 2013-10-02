<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Main extends CI_Controller 
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
    }
    
    public function index()
    {    
    	$userinfo = $this->session->userdata('userinfo');
        $this->load->view('admin/admin_index',$userinfo);
    }
        
}