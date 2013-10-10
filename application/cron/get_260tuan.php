<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 


/**
 * 
 * @ID tool.php
 * 260团购API采集
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
$areainfo= $this->model_tuangou->tuan260_get_deals();
print_r($areainfo);
break;
	$i=0;
		foreach($areainfo->url as $key=>$url){
			//if($i>10) break;
			
			if($url->data->display->subcategory=='酒店'){
				$loc=''.$url->loc;
				$info=$this->model_tuangou->get_tuaninfo_byurl($loc);
			
			if(!$info){
				
				$data['dealsid']='';
				$data['loc']= ''.$url->loc ;
				
				$data['waploc']= ''.$url->wapLoc ;
				$data['website']= '260团' ;
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
				$data['name']='';
				
				
				$data['spendEndTime']=0;
				$data['refund']='';
				$data['reservation']='';
				
				$data['tips']= ''.$url->data->display->tips;
				
				
				$data['seller']= ''.$url->data->display->seller ;
				
				$data['phone']= ''.$url->data->display->phone ;
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
				//添加团购信息
				
					
				$id=$this->model_tuangou->addTuangou('insert',$data);
				$result='';
				//商家信息存入百度LBS
				if($url->data->display->shops->shop->name){
					
					$datashop['dealsid']=$id;
					$datashop['title']=$url->data->display->shops->shop->shopSeller;
					$zhuobiao=explode(',',$url->data->display->shops->shop->shopCoords);
					$datashop['longitude']=$zhuobiao[0];
					$datashop['latitude']=$zhuobiao[1];
					$datashop['address']=$url->data->display->shops->shop->shopAddress;
					$datashop['phone']=$url->data->display->shops->shop->shopPhone;
					$datashop['coord_type']='3';
					
					$result = $this->model_hotel->post_baidu('',$datashop,'create',34835);
				
				}
				else{
					
				foreach($url->data->display->shops->shop as $shop){
					
					$datashop2['dealsid']=$id;
					$datashop2['title']=$shop->name;
					$zhuobiao=explode(',',$shop->shopCoords);
					$datashop2['longitude']=$zhuobiao[0];
					$datashop2['latitude']=$zhuobiao[1];
					$datashop2['address']=$shop->addr;
					$datashop2['phone']=$shop->tel;
					$datashop2['coord_type']='3';
					$result = $this->model_hotel->post_baidu('',$datashop2,'create',34835);
					
					}
				}
				
				$result = json_decode($result['response_body']);		
				$baiduid=$result->id;
				
				//print_r($result);
				
				$api_list=file_get_contents("http://api.map.baidu.com/geosearch/v2/detail?id=$baiduid&geotable_id=34835&ak=85654a7702d8b2163b85f87e6585b4f5");
				$api_list=json_decode($api_list);
				
				$data2['areaname']= $api_list->contents[0]->district ;
				
				$id=$this->model_tuangou->addTuangou('update',$data2,array('tid'=>$id));
				$i++;
				
				
			}
			else
			{
				
				$data3['bought']= ''.$url->data->display->bought ;
				$id=$this->model_tuangou->addTuangou('update',$data3,array('tid'=>$info['tid']));
				
			}
				
				//print_r(''.$url->loc);
				sleep(0.1);
				
				
			}
				
		//	}
//		sleep(5);	
}
		