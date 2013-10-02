<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID member.php
 * 携行酒店分销联盟（会员登录页面）模块
 * @date 2013-1-24 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Map extends CI_Controller 
{
    
    private $data ;
    
    function __construct()
    {
        parent::__construct();
        $this->data = array();
        
        $this->load->model('model_common');
        $this->load->model('model_city');
                
    }
    
	public function index()
	{
        $lat = floatval($this->input->get('lat'));    
        $lng = floatval($this->input->get('lng'));    
        $this->data['lat'] = $lat;
        $this->data['lng'] = $lng;
		$this->load->view('map',$this->data);
	}
}