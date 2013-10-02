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



class Gift extends CI_Controller 

{



    function __construct()

    {

        parent::__construct();
		
		$this->load->model('model_common');

        $this->load->model('model_layout');

        $this->load->model('model_keywords');

        $this->load->model('model_sysconfig');

        $this->load->model('model_product');

        $this->load->library('pagination');

                $this->load->library('tool');

        $this->load->model('model_hotel');
		
		//$this->output->enable_profiler(TRUE);
        

    }

    

	public function index()

	{

        //载入布局模型

        $layout = $this->model_layout->get_layout('news');

        

        //处理url参数

        $getPara = $this->uri->rsegment(4);

        $getPara = explode('-',$getPara);
		
		$type = $this->uri->rsegment(3);
		
		$where=" WHERE Status=0";
		$where1=array('Status' => 0);
		if($type){

        $where .= " AND  ProductType=  $type ";

        $where1 .= array('ProductType =' => $type);
		}

        

        $page = isset($getPara[1]) ? (int) $getPara[1] : 0; ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 20 ;

        $order =  isset($getPara[0]) ? (int) $getPara[0] : 0; ;

        $orderfiled = "";

        if($order === 2){

        	$orderfiled = 'R_Sort asc';

        }else if ($order === 1){

        	$orderfiled = 'fid desc' ;

        }else{

        	$orderfiled = 'ProductID desc' ;

        }

        

        $freeroomcount = $this->model_product->get_count($where1);

        $pageinfo = $this->tool->get_page_info($page,$freeroomcount,$pagesize);

        $freeroomlist = $this->model_product->get_list($pageinfo['start'],$pagesize,$orderfiled,$where);
		


        //分页

		$config['base_url'] = base_url()."/freeroom/$order-";

		$config['page_tag_prefix'] = '-';

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

        $meta = $this->model_keywords->getKeywords('gift');

        $sysconfig = $this->model_sysconfig->getSysconfig();

 

        $search = array('{doname}','{classname}');

        $meta_replace = array($sysconfig['cfg_webname'],'免费礼品');

        $meta_array = str_replace($search, $meta_replace, $meta);



        $data = array();

        $data['layout'] = $layout ; 

        $data['method'] = $this->uri->segment(1) ;      

        $data['freeroomlist'] = $freeroomlist ;      

        $data['freeroomcount'] = $freeroomcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['metainfo'] = $meta_array ; 

		
		$this->load->view('gift',$data);

	}
	
	public function info(){
		 //载入布局模型

        $layout = $this->model_layout->get_layout('news');

        

        $hotelId = $this->uri->segment(3)!='' ? $this->uri->segment(3) : 1; 
		
		
		
		 $meta = $this->model_keywords->getKeywords('giftinfo');

        $sysconfig = $this->model_sysconfig->getSysconfig();
		
		

 

        $search = array('{doname}','{classname}');

        $meta_replace = array($sysconfig['cfg_webname'],'免费礼品');

        $meta_array = str_replace($search, $meta_replace, $meta);

 

        $search = array('{doname}','{classname}');

        $meta_replace = array($sysconfig['cfg_webname'],'免费礼品');

        $meta_array = str_replace($search, $meta_replace, $meta);

        //酒店详细信息

        $hotelInfo = $this->model_product->get_productinfo($hotelId);
        $sqlog = $this->model_product->get_order_list(0,20,'poid desc',$where=' where   product_id='.$hotelId);
		$hdlog = $this->model_product->get_order_list(0,20,'poid desc',$where=' where state=2 and  product_id='.$hotelId);
		
		$where=array('product_id'=>$hotelId);
		$hdlognum = $this->model_product->get_order_count($where);

        $this->data['hotelInfo'] = $hotelInfo;
		$this->data['sqlog'] = $sqlog;
		$this->data['hdlog'] = $hdlog;
		
		$this->data['hdlognum'] = $hdlognum;
		
		$this->data['layout'] = $layout ; 
		 $this->data['metainfo'] = $meta_array ; 


        $this->load->view('giftinfo',$this->data);
	}
	
	public function get(){
		
		$this->load->library('session');

        if(!$this->session->userdata('xexinguserinfo')){

        	redirect('/user');

        }
		
		$this->userinfo = $this->session->userdata('xexinguserinfo');

		
		$name=$this->input->post('name');
		$phone=$this->input->post('phone');
		$address=$this->input->post('address');
		$product_id=$this->input->post('product_id');
		$ProductType=$this->input->post('ProductType');
		$ProductName=$this->input->post('ProductName');
		
		$data=array();
		
		$data['poNum']=date('ymd').substr(time(),-5).substr(microtime(),2,5);
		$data['name']=$name;
		$data['phone']=$phone;
		$data['address']=$address;
		$data['product_id']=$product_id;
		$data['ProductType']=$ProductType;
		$data['ProductName']=$ProductName;
		$data['addTime']=time();
		$data['user_id']=$this->userinfo['id'];
		
		$this->model_product->save_product_order($data);
		
		$alertMsg = '您的申请已经提交，可以在会员中心查看申请状态';
            $redirectUrl = site_url('/gift/');
            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
            exit;
        
	}

}

