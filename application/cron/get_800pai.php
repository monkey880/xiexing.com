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
	
	$apiUrl = "http://www.800pai.com/api/hao123.php";
	$areainfo=simplexml_load_file($apiUrl,'SimpleXMLElement', LIBXML_NOCDATA);

//print_r($areainfo);
//break;
//	$i=0;
		foreach($areainfo->url as $key=>$url){
			
			if($url->data->display->subcategory=='酒店'){
				$loc=''.$url->loc;
				$info=$this->model_tuangou->get_tuaninfo_byurl($loc);
			
			if(!$info){
				
				$data['dealsid']='';
				$data['loc']= ''.$url->loc ;
				
				$data['waploc']= ''.$url->wapLoc ;
				$data['website']= '可可团购' ;
				$data['siteurl']= ''.$url->data->display->siteurl ;
				$data['city']= ''.$url->data->display->city ;
				$data['category']=1;
				$data['subcategory']= ''.$url->data->display->subcategory ;
				
				$data['characteristic']='';
				$data['destination']='';
				
				$data['thrcategory']='';
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
				
				
				$data['spendEndTime']=0;
				$data['refund']='';
				$data['reservation']='';
				
				$data['tips']= ''.$url->data->display->tips;
				
				
				$data['seller']= ''.$url->data->display->Seller ;
				
				$data['phone']= ''.$url->data->display->Phone ;
				$data['address']= ''.$url->data->display->address ;
				
				
				$data['longitude']=''. $url->data->shops->shop->longitude ;
				$data['latitude']= ''.$url->data->shops->shop->latitude ;
				
				$data['range']= ''.$url->data->shops->shop->area ;
				if($url->data->shops->shop->area){
				$areainfo= $this->model_city->get_resgoin_byname($url->data->shops->shop->area );
			}
				$data['locationName']=$areainfo['areaname'];
				$data['dpshopid']=0;
				$data['uptime']=time();
				$data['hits']=0;
				
				$id=$this->model_tuangou->addTuangou('insert',$data);
				
				//商家信息存入百度LBS
				if($url->data->shops->shop->name){
					
					$datashop['dealsid']=$id;
					$datashop['title']=$url->data->shops->shop->shopSeller;
					$zhuobiao=explode(',',$url->data->shops->shop->shopCoords);
					$datashop['longitude']=$zhuobiao[0];
					$datashop['latitude']=$zhuobiao[1];
					$datashop['address']=$url->data->shops->shop->shopAddress;
					$datashop['phone']=$url->data->shops->shop->shopPhone;
					$datashop['coord_type']='3';
					
					$result = $this->model_hotel->post_baidu('',$datashop,'create',34835);
					
				}
				else{
					
				foreach($url->data->shops as $shop){
					
					$datashop2['dealsid']=$id;
					$datashop2['title']=$shop->name;
					$zhuobiao=explode(',',$shop->shopCoords);
					$datashop['longitude']=$zhuobiao[0];
					$datashop['latitude']=$zhuobiao[1];
					$datashop2['address']=$shop->addr;
					$datashop2['phone']=$shop->tel;
					$datashop2['coord_type']='3';
					$result = $this->model_hotel->post_baidu('',$datashop2,'create',34835);
					//print_r($result);
					}
				}
				$i++;
				
				
			}
				
				else
			{
				$data['bought']= ''.$url->data->display->bought ;
				$id=$this->model_tuangou->addTuangou('update',$data,array('tid'=>$info['tid']));
				
				}
				sleep(0.1);
				
				
			}
				
		//	}
//		sleep(5);	
}
		