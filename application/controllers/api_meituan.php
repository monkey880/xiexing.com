<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 *

 * @ID freeroom.php

 * 住哪酒店分销联盟（咨询）模块

 * @date 2013-1-24

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 *

 */



class Test2 extends CI_Controller 

{



    function __construct()

    {

        parent::__construct();

        $this->load->model('model_layout');

        $this->load->model('model_keywords');

        $this->load->model('model_sysconfig');

        $this->load->model('model_lable');
		$this->load->model('model_common');
		
		$this->load->model('model_tuangou');
		
		$this->load->library('email');

        $this->load->library('dzsign');

        $this->load->library('tool');
		
		$this->output->enable_profiler(TRUE);
        

    }
	
    

	public function index()

	{
		$api=$this->model_tuangou->meituan_get_cities();
		$cityarr="<?php\r\n";
		foreach($api->divisions->division as $val){
			$cityarr.="\$city['$val->id']='$val->name'; \r\n";
		}
		$cityarr.="?>";
		
		$res=file_put_contents('data/city/meituan.php',$cityarr);
		print_r($res);
	}
	
	
}

