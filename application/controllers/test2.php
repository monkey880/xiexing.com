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

        

        $this->load->library('tool');
		
		$this->output->enable_profiler(TRUE);
        

    }
	
    

	public function index()

	{
		
		$api_list=file_get_contents("http://api.map.baidu.com/geodata/v2/poi/list?geotable_id=34599&ak=85654a7702d8b2163b85f87e6585b4f5&page_size=200&city=上海");
		$api_list=json_decode($api_list);
		foreach($api_list->pois as $key=> $list){
		
		$params['ak']='85654a7702d8b2163b85f87e6585b4f5';
		$params['geotable_id']='34599';
		$params['id']=$list->id;
		$content = '';
        foreach ($params as $k => &$v) 
        {
            $v = urlencode($v);
            $content .= $k . '=' . $v . '&';
        }
        $content = substr($content, 0, strlen($content) - 1);
		$params = array('url' => 'http://api.map.baidu.com/geodata/v2/poi/delete');
		$this->load->library('baidu_lbs',$params);
		$this->baidu_lbs->set_method("POST");
		$this->baidu_lbs->set_useragent("Baidu_LbsYun_Sdk");
		$this->baidu_lbs->set_body($content);
		
		$res=$this->baidu_lbs->send_request();
print_r($list->id.',');
$data['url']="/test2/";
 $this->load->view('admin/admin_hotel_tongbu',$data);
}
       //$response = $this->load->library('baidu_responsecore',$this->baidu_lbs->get_response_header(), 
//                $this->baidu_lbs->get_response_body(), $this->baidu_lbs->get_response_code());
//        if (!$response->isOK()) {
//            return false;
//        }
//
//        $res= json_decode($response->body, true);
		//print_r($api_list);
	}
	
	public function getcity()
	{
		$city=$this->model_city->getCity();
		print_r($city);
	}
	
	public function lbs()
	{
		$cronfile="application/cron/get_didatuan.php";
		include $cronfile;
		
		}
	public function scr2()
	{
		$str=$this->input->get('str');
		$type=$this->input->get('type');
		$arr_str=array('0'=>'10','1'=>'11','2'=>'12','3'=>'13','4'=>'14','5'=>'15','6'=>'16','7'=>'17','8'=>'18','9'=>'19','a'=>'20','b'=>'21','c'=>'22','d'=>'23','e'=>'24','f'=>'25','g'=>'26','h'=>'27','i'=>'28','j'=>'29','k'=>'30','l'=>'31','m'=>'32','n'=>'33','o'=>'34','p'=>'35','q'=>'36','r'=>'37','s'=>'38','t'=>'39','u'=>'40','v'=>'41','w'=>'42','x'=>'43','y'=>'44','z'=>'45',);
		if($type=='2'){
			$in_arr=str_split($str,2);
		foreach($in_arr as $val)
		{
			echo array_search($val,$arr_str);
		}
		}
		else
	
		{
			$in_arr=str_split($str,1);
		foreach($in_arr as $val)
		{
			echo $arr_str[$val];
		}
		
			
		}
	}
	
	public function add()
	{
		$data['dealsid']=123456 ;
				$data['loc']= '2222222' ;
				
				$data['waploc']= '2222222';
				$data['website']= '2222222';
				$data['siteurl']= '2222222';
				$data['city']= '';
				$res=$this->model_tuangou->addTuangou('insert',$data);
				echo $res;
	}
	
	public function getcityarr()
	{
		$apiUrl = "http://www.go.cn/api/citys.php";
		
		$api_list=simplexml_load_file($apiUrl);
		
		
		
		$city_arr="<?php\r\n";
		foreach($api_list as $city){
			$city_arr.="\$city['$city->id']='$city->name'; \r\n";
		}
		$city_arr.="?>";
		$res=file_put_contents('data/city/gocn.php',$city_arr);
		print_r($res);
	}
}

