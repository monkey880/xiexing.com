<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 


/**
 * 
 * @ID tool.php
 * 携行酒店分销联盟常用函数
 * @date 2013-1-23 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */


$this->load->model('model_tuangou');
$this->load->model('model_hotel');
$this->load->model('model_city');

//include 'data/city/nuomi.php';
//foreach($city as $key=>$ci){
	
	$apiUrl = "http://www.baikutuan.com/api/baidu2.xml";
	$areainfo=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);

//print_r($areainfo);
//break;
//	$i=0;
		foreach($areainfo->url as $key=>$url){
			
					if($this->model_tuangou->isxexingtuan($url->data->display->subcategory)){
				
				$data['dealsid']='';
				$data['loc']= ''.$url->loc ;
				
				$data['waploc']= ''.$url->wapLoc ;
				$data['website']= ''.$url->website ;
				$data['siteurl']= ''.$url->data->display->siteurl ;
				$data['city']= ''.$url->data->display->city ;
				$data['category']=''.$url->data->display->category;
				$data['subcategory']= ''.$url->data->display->subcategory ;
				
				
				$data['destination']=''.$url->data->display->destination;
				
				$data['thrcategory']=''.$url->data->display->thrcategory;
				$data['major']=''.$url->data->display->major;
				$data['title']= ''.$url->data->display->title ;
				$data['shortTitle']= ''.$url->data->display->shortTitle ;
				$data['image']=''. $url->data->display->image ;
				$data['startTime']= $url->data->display->startTime ;
				
				$data['endTime']= $url->data->display->endTime ;
				$data['value']= $url->data->display->value ;
				$data['price']= $url->data->display->price ;
				$data['rebate']= ''.$url->data->display->rebate ;
				$data['bought']= ''.$url->data->display->bought ;
				$data['name']=''.$url->data->display->name;
				
				
				$data['spendEndTime']=''.$url->data->display->reservation;
				$data['refund']=''.$url->data->display->refund;
				$data['reservation']=''.$url->data->display->reservation;
				
				$data['tips']= ''.$url->data->display->tips;
				
				
				$data['seller']= ''.$url->data->display->seller ;
				
				$data['phone']= ''.$url->data->display->phone ;
				$data['address']= ''.$url->data->display->address ;
				
				//$zhuobiao=explode(',',$url->data->display->shops->shop->shopCoords);
//				$data['longitude']=$zhuobiao[0] ;
//				$data['latitude']= $zhuobiao[1] ;
				
				$data['range']= ''.$url->data->display->range  ;
				
				$data['dpshopid']=''.$url->data->display->dpshopid;
				$data['uptime']=time();
				$data['hits']=0;
				//添加团购信息
				
				$this->model_tuangou->uptuanby($data,$url->data->display->shops);
				sleep(0.1);
				
				
			}
				
		//	}
//		sleep(5);	
}
		