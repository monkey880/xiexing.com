<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 *

 * @ID index.php

 * 住哪酒店分销联盟（前台首页）模块

 * @date 2013-1-24

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 *

 */



class Index extends CI_Controller 

{

    

    private $data;

    

    function __construct()

    {

        parent::__construct();

        $this->data = array();

        

        $this->load->model('model_common');

        $this->load->model('model_city');

        $this->load->model('model_layout');

        $this->load->model('model_hotel');
		
		$this->load->helper('file');
		$this->load->driver('cache');
        

    }

    

	public function index()

	{

		//载入布局模型
		

		$layout = $this->model_layout->get_layout('index');

		$this->data = array();

        $method = $this->uri->segment(1);

        //初始化cityid

        $this->model_common->initCityinfo();

        

        //处理网页中的seo信息

        $keywords_array = $this->model_common->getKeywords('index');

        $keywords_array = str_replace(array('{doname}'),array(CFG_WEBNAME),$keywords_array);

        $this->data['keywords_array'] = $keywords_array;


        $this->data['layout'] = $layout ;	

        $this->data['method'] =  empty($method) ? 'index' : $method ;	
		
	//	if(!$foo = $this->cache->memcached->get('foo')){
//			$this->cache->memcached->save('foo', $this->data, 100);
//		}
//		$foo = $this->cache->memcached->get('foo');
//		$this->load->view('index',$foo);

		$this->load->view('index',$this->data);

	}

	

    //推荐酒店用到的ajax方法

    public function ajax_get_tuijian()

    {

        $cid = $this->input->get_post('cid');

        $tuijian_lable = $this->model_common->getTuijianHotel($cid);

        foreach($tuijian_lable as $key=>$val){

            $tuijian_lable[$key]['df_haoping']=$this->tool->hoteldianping($val['df_haoping'],2);    

            $tuijian_lable[$key]['xingji']=$this->tool->hotelrankname($val['xingji']);    

        }

        $tuijian_lable = json_encode($tuijian_lable); 

        echo $tuijian_lable;

    }

    

    //热门酒店用到的ajax方法

    public function ajax_get_hothotel()

    {

        $cid = $this->input->get_post('cid');

        

        $welcomeHotel_1 = $this->model_common->getWelcomeHotel($cid,1,6);//经济型酒店

        $welcomeHotel_2 = $this->model_common->getWelcomeHotel($cid,5,6);//豪华型酒店

        foreach($welcomeHotel_1 as $key=>$val){

        	$welcomeHotel_1[$key]['cbd'] = trim($val['cbd']) ;

        }

        foreach($welcomeHotel_2 as $key=>$val){

            $welcomeHotel_2[$key]['cbd'] = trim($val['cbd']) ;

        }

        

        $getHotCBD = $this->model_common->getCBD($cid,1,18);//热门商圈

        $getHotLable = $this->model_common->getLable($cid,1,18);//热门景点

        

        echo $rt = json_encode(array($welcomeHotel_1,$welcomeHotel_2,$getHotCBD,$getHotLable));    

    }

    //快速搜索地标用到的ajax方法

    public function ajax_get_lable()

    {

    	$this->load->model('model_lable');

    	

    	$type = $this->input->get_post('type');

    	$cityid = $this->input->get_post('cityid');

    	if ($type == 170) {

    		echo $lable = $this->model_lable->getSubwayLable($cityid);
		
    	} 
		
		else if($type == 100000){
			$area_list = $this->model_city->get_area ( $cityid );
			$res_area=array();
			foreach($area_list as $key=>$val){
				$ar['classname']=array('行政区');
				$ar['classid']='-1';
				$ar['name']=array($val);
				$ar['cityid']=$cityid;
				$ar['ecityid']=$cityid;
				$ar['roundhotel']=Null;
				$ar['x']='';
				$ar['y']='';
				$ar['id']=$key;
				$ar['pinyin']='';
				$res_area[]=$ar;
			}
			echo $res=json_encode($res_area);
		}
		else {

    		echo $lable = $this->model_lable->getLable($cityid,$type,'52');

    	}

    }

}