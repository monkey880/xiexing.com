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

include 'data/city/gocn.php';
foreach($city as $key=>$ci){
$areainfo= $this->model_tuangou->gocn_get_deals($key);

	$i=0;
		foreach($areainfo->url as $key=>$url){
			
			if($url->data->display->cate=='旅游住宿'){
				$loc=''.$url->loc;
				$info=$this->model_tuangou->get_tuaninfo_byurl($loc);
			
			if(!$info){
				
				$data['dealsid']=$url->data->display->gid;
				$data['loc']= ''.$url->loc ;
				
				$data['waploc']= '' ;
				$data['website']= '团购王' ;
				$data['siteurl']= ''.$url->data->display->siteurl ;
				$data['city']= ''.$url->data->display->city ;
				$data['category']=1;
				$data['subcategory']= '';
				
				$data['characteristic']='';
				$data['destination']='';
				
				$data['thrcategory']='';
				$data['major']='';
				$data['title']= ''.$url->data->display->title ;
				$data['shortTitle']= '' ;
				$data['image']=''. $url->data->display->image ;
				$data['startTime']= $url->data->display->startTime ;
				
				$data['endTime']= $url->data->display->endTime ;
				$data['value']= $url->data->display->value ;
				$data['price']= $url->data->display->price ;
				$data['rebate']= ''.$url->data->display->rebate ;
				$data['bought']= ''.$url->data->display->bought ;
				$data['name']='';
				
				
				$data['spendEndTime']=0;
				$data['refund']='';
				$data['reservation']='';
				
				$data['tips']= '';
				
				
				$data['seller']= ''.$url->data->shops->shop->name ;
				
				$data['phone']= ''.$url->data->shops->shop->tel ;
				$data['address']= ''.$url->data->shops->shop->addr ;
				$data['longitude']=''. $url->data->shops->shop->longitude ;
				$data['latitude']= ''.$url->data->shops->shop->latitude ;
				
				$data['range']= '' ;
				if($url->data->shops->shop->area){
				$areainfo= $this->model_city->get_resgoin_byname($url->data->shops->shop->area );
			}
				$data['locationName']='';
				$data['dpshopid']=0;
				$data['uptime']=time();
				$data['hits']=0;
				
				$id=$this->model_tuangou->addTuangou('insert',$data);
				
				//商家信息存入百度LBS
				if($url->data->shops->shop->name){
					
					$datashop['dealsid']=$id;
					$datashop['title']=$url->data->shops->shop->name;
					$datashop['longitude']=$url->data->shops->shop->longitude;
					$datashop['latitude']=$url->data->shops->shop->latitude;
					$datashop['address']=$url->data->shops->shop->addr;
					$datashop['phone']=$url->data->shops->shop->tel;
					$datashop['coord_type']='3';
					
					$result = $this->model_hotel->post_baidu('',$datashop,'create',34835);
					
				}
				else{
					
				foreach($url->data->shops as $shop){
					
					$datashop2['dealsid']=$id;
					$datashop2['title']=$shop->name;
					$datashop2['longitude']=$shop->longitude;
					$datashop2['latitude']=$shop->latitude;
					$datashop2['address']=$shop->addr;
					$datashop2['phone']=$shop->tel;
					$datashop2['coord_type']='3';
					$result = $this->model_hotel->post_baidu('',$datashop2,'create',34835);
					$result = json_decode($result['response_body']);		
					$baiduid=$result->id;
					print_r($result);
			}
				}
				$i++;
				
				$api_list=file_get_contents("http://api.map.baidu.com/geosearch/v2/detail/$baiduid?geotable_id=34835&ak=85654a7702d8b2163b85f87e6585b4f5");
				$api_list=json_decode($api_list);
				
				$data['areaname']= $api_list->contents[0]->district ;
				
				$id=$this->model_tuangou->addTuangou('update',$data,array('tid'=>$id));
			}
			else
			{
				$data['bought']= ''.$url->data->display->bought ;
				$id=$this->model_tuangou->addTuangou('update',$data,array('tid'=>$info['tid']));
				
				}
				
				
				sleep(0.1);
				
				
			}
				
			}
		sleep(5);	
}
		