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



class Freeroom extends CI_Controller 

{



    function __construct()

    {

        parent::__construct();

        $this->load->model('model_layout');

        $this->load->model('model_keywords');

        $this->load->model('model_sysconfig');

        $this->load->model('model_freeroom');
		
		

        $this->load->library('pagination');

        $this->load->library('tool');
		
		//$this->output->enable_profiler(TRUE);
        

    }

    

	public function index()

	{

        //载入布局模型

        $layout = $this->model_layout->get_layout('news');

        

        //处理url参数

        $getPara = $this->uri->rsegment(3);

        //$getPara = explode('-',$getPara);


        $page = isset($getPara) ? (int) $getPara : 0; ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 14 ;

        $order =  isset($getPara[0]) ? (int) $getPara[0] : 0; ;

        $orderfiled = "";

        if($order === 2){

        	$orderfiled = 'R_Sort asc';

        }else if ($order === 1){

        	$orderfiled = 'fid desc' ;

        }else{

        	$orderfiled = 'R_Checkintime desc' ;

        }
			$now=time();
         $where = " WHERE  R_states=1 and R_Checkintime > $now";

        $where1 = array('R_states =' => 1);
		$where1 = array('R_Checkintime >' => $now);
		
		

        $freeroomcount = $this->model_freeroom->get_count($where1);

        $pageinfo = $this->tool->get_page_info($page,$freeroomcount,$pagesize);

        $freeroomlist = $this->model_freeroom->get_list($pageinfo['start'],$pagesize,$orderfiled,$where);
		


        //分页

		$config['base_url'] = base_url()."/freeroom/";

		$config['page_tag_prefix'] = '';

		$config['page_tag_now'] = $page;

		$config['firstpage_query_string'] = FALSE;

        $config['suffix'] = $this->config->item('url_suffix');

		$config['total_rows'] = $freeroomcount ;

		$config['num_links'] = 4;

		$config['per_page'] = $pagesize;

		$config['use_page_numbers'] = true;

		$config['first_link'] = '<<';

		$config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

		$this->pagination->initialize($config); 

		$pagnav = $this->pagination->create_links();

        

        //替换meta信息

        $meta = $this->model_keywords->getKeywords('freeroom');

        $sysconfig = $this->model_sysconfig->getSysconfig();

 

        $search = array('{doname}','{classname}');

        $meta_replace = array($sysconfig['cfg_webname'],'订七送一');

        $meta_array = str_replace($search, $meta_replace, $meta);



        $data = array();

        $data['layout'] = $layout ; 

        $data['method'] = $this->uri->segment(1) ;      

        $data['freeroomlist'] = $freeroomlist ;      

        $data['freeroomcount'] = $freeroomcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['metainfo'] = $meta_array ; 

		
		$this->load->view('freeroom',$data);

	}
	
	public function shizhu()

	{

        //载入布局模型

        $layout = $this->model_layout->get_layout('news');

        

        //处理url参数

        $getPara = $this->uri->rsegment(4);
		
		$type = $this->uri->rsegment(3);
		
        

      $type = $type ? (int) $type : 1; ;

        

        $page = isset($getPara) ? (int) $getPara : 0; ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 16 ;

        $order =  isset($getPara[0]) ? (int) $getPara[0] : 0; ;

        $orderfiled = "";

       $now=time();
		if($type==2){
			
			$orderfiled = 'R_Checkintime desc' ;

       
         $where = " WHERE  R_states=1 and R_Checkintime < $now";

        $where1 = array('R_states =' => 1);
		$where1 = array('R_Checkintime <' => $now);
       
		}
		else{
			
		 $orderfiled = 'R_Checkintime asc' ;

       
		
         $where = " WHERE  R_states=1 and R_Checkintime > $now";

        $where1 = array('R_states =' => 1);
		$where1 = array('R_Checkintime >' => $now);

		}

        $freeroomcount = $this->model_freeroom->get_count($where1);

        $pageinfo = $this->tool->get_page_info($page,$freeroomcount,$pagesize);

        $freeroomlist = $this->model_freeroom->get_list($pageinfo['start'],$pagesize,$orderfiled,$where);
		
		
      
		


        //分页

		$config['base_url'] = base_url()."/freeroom/shizhu/$type/";

		$config['page_tag_prefix'] = '';

		$config['page_tag_now'] = $page;
		
		$config['uri_segment'] = 4;

		$config['firstpage_query_string'] = FALSE;

        $config['suffix'] = $this->config->item('url_suffix');
		
		
			$config['total_rows'] = $freeroomcount ;
		

		$config['num_links'] = 4;

		$config['per_page'] = $pagesize;

		$config['use_page_numbers'] = true;

		$config['first_link'] = '<<';

		$config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

		$this->pagination->initialize($config); 

		$pagnav = $this->pagination->create_links();
		
        

        //替换meta信息

        $meta = $this->model_keywords->getKeywords('zhu75');

        $sysconfig = $this->model_sysconfig->getSysconfig();

 

        $search = array('{doname}','{classname}');

        $meta_replace = array($sysconfig['cfg_webname'],'订七送一');

        $meta_array = str_replace($search, $meta_replace, $meta);



        $data = array();

        $data['layout'] = $layout ; 

        $data['method'] = $this->uri->segment(2) ;      

        $data['freeroomlist'] = $freeroomlist ;   
		

        $data['freeroomcount'] = $freeroomcount ;      
		$data['type'] = $type ;      

        $data['pagenav'] = $pagnav ;  
		
		$data['page'] = $page ;  

        $data['metainfo'] = $meta_array ; 
	
		$this->load->view('freeroom3',$data);

	}

}

