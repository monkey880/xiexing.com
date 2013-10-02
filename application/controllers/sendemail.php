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



class Test extends CI_Controller 

{



    function __construct()

    {

        parent::__construct();

        $this->load->model('model_layout');

        $this->load->model('model_keywords');

        $this->load->model('model_sysconfig');

        $this->load->model('model_hotel');
		$this->load->model('model_common');
		$this->load->library('email');

        $this->load->library('pagination');

        $this->load->library('tool');
		
		$this->output->enable_profiler(TRUE);
        

    }

    

	public function index()

	{


$this->email->from('kerry100124@sina.com', '携行 专业酒店预订网');
$this->email->to('1145525313@qq.com'); 
$this->email->cc(''); 
$this->email->bcc(''); 

$this->email->subject('我爱青青');
$this->email->message('我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，我爱青青，'); 

$this->email->send();

echo $this->email->print_debugger();
		
	}
	
	

}

