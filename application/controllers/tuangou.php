<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID news.php
 * 携行酒店分销联盟（咨询）模块
 * @date 2013-1-24
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Tuangou extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_keywords');
        $this->load->model('model_sysconfig');
        $this->load->model('model_tuangou');
        $this->load->model('model_city');
		$this->load->helper('text');
        $this->load->library('pagination');
        $this->load->library('tool');
        //$this->output->enable_profiler(TRUE);
    }
    
	public function index()
	{
        
        
        //处理get参数

        header("Content-Type: text/html; charset=utf-8");
		$cityid = $this->uri->rsegment(3);
		if(!$cityid){
			$cityid='shanghai';
		}
		$cityinfo=$this->model_city->get_city_bypinxin($cityid);
		
		$getPara = $this->uri->rsegment(4);

        $getPara = iconv("GB2312","UTF-8",$getPara);

        if ($getPara) {

            $getPara = explode('-',$getPara);

    		$paraNum = count($getPara);

    		for($i=0;$i<$paraNum;$i++) {

    			$j = $i + 1;

    			$paraArr[$getPara[$i]] = $getPara[$j];

    			$i++;

    		}

    		$getPara = $paraArr;    

        } else {

            $getPara = array();    

        }

        $category=$getPara['category'];
		$area=$getPara['area'];
		$range=$getPara['range'];
		$star=$getPara['star'];
		$fangxing=$getPara['fangxing'];
		$price=$getPara['price'];
		
		
        $page = isset($getPara['page']) ? (int) $getPara['page'] : 0; ;
        $page = $page <= 0 ? 1 : $page ;
        $pagesize = 21 ;
        $order =  isset($getPara['order']) ? (int) $getPara['order'] : 0; ;
        $orderfiled = "";
        if($order === 2){
        	$orderfiled = 'bought desc';
        }else if ($order === 3){
        	$orderfiled = 'price asc' ;
      
		
		}else if ($order === 5){
        	$orderfiled = 'price desc' ;
      
		}
		else if ($order === 1){
        	$orderfiled = 'rebate asc' ;
        }
		else{
        	$orderfiled = ' rand()' ;
        }
		$now=time();
		$whereSql = array('status'=>1);
		$whereSql['endTime >']=$now;
		$whereSqlList = "where status=1 and endTime> $now";   
		 if($category){
			 if($category=='jiudian'){
				 $category2=1;
			 }
			 else if($category=='lvyou'){
				 $category2=2;
			 }
			 else if($category=='jingdiangongyuan'){
				 $category2=3;
			 }
			 
		   $whereSql['category']=$category2;
		$whereSqlList .= " and  category='$category2'";  
	   }
       if($cityinfo){
		   $whereSql['city']=$cityinfo['cName'];
		$whereSqlList .= " and  city='$cityinfo[cName]'";  
	   }
	   if($area){
		   $areainfo=$this->model_city->get_areaname_byid($area,$cityinfo['cid']);
		   if(!$range){
		 $whereSql['locationName like']='%'.$areainfo['areaname'].'%';
		$whereSqlList .= " and  locationName like '%$areainfo[areaname]%'";  
		   }
		$range_list=$this->model_city->get_resgoin_list($areainfo['areaname'],$cityinfo['cName']);
		
	   }
	  
	    if($range){
			$rangeinfo=$this->model_city->get_resgoin($range);
			
		    $whereSql['range like ']='%'.$rangeinfo['regionname'].'% ';
		$whereSqlList .= " and  `range` like '%$rangeinfo[regionname]%' ";  
	   }
	    if($star){
			$star2 = $this->model_config->star_pinyin_ary($star);
			
		    $whereSql['subcategory']=$star2;
			$whereSqlList .= " and  subcategory='$star2'";  
	   }
	   
	     if($fangxing){
			$fangxing2 = $this->model_config->fangxing_pinyin_ary($fangxing);
		    $whereSql['fangxing']=$fangxing2;
			$whereSqlList .= " and  fangxing='$fangxing2'";  
			
	   }
	    if($price){
			if($price=='50'){
		    $whereSql['price <= ']=50;
			$whereSqlList .= " and  price<='50'";  
			}
			else if($price==100){
				$whereSql['price >= ']='50';
				$whereSql['price <= ']='100';
				$whereSqlList .= " and  price<='100' and price>=50";  
			}
			else if($price==150){
				$whereSql['price >= ']='100';
				$whereSql['price <=']='150';
				$whereSqlList .= " and  price<='150' and price>=100";  
			}
			else if($price==200){
				$whereSql['price >=']='150';
				$whereSql['price <=']='200';
				$whereSqlList .= " and  price<='200' and price>=150";  
			}
			else if($price==500){
				$whereSql['price >=']='200';
				$whereSql['price <=']='500';
				$whereSqlList .= " and  price<='500' and price>=200";  
			}
			else if($price==510){
				$whereSql['price >=']='500';
				
				$whereSqlList .= "  and price>='500'";  
			}
			else{
					$whereSql['price >=']='100';
				$whereSql['price <=']='150';
				$whereSqlList .= " and  price<='150' and price>=100";  
			}
	   }

		$newscount=0;
        $newscount = $this->model_tuangou->get_tuangou_count($whereSql);
		
        $pageinfo = $this->tool->get_page_info($page,$newscount,$pagesize);

        $newslist = $this->model_tuangou->get_guantoulist($pageinfo['start'],$pagesize,$orderfiled,$whereSqlList);
       
	    $list_url = $this->baseUrl ( $cityid, $page, $order, $area, $range, $star ,$fangxing ,$price,$category );
       

        //分页
		$config['base_url'] = base_url().$list_url['page'].'-page';
		$config['page_tag_prefix'] = '-';
		$config['page_tag_now'] = $page;
		$config['firstpage_query_string'] = FALSE;
        $config['suffix'] = $this->config->item('url_suffix');
		$config['total_rows'] = $newscount ;
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
        $meta = $this->model_keywords->getKeywords('news');
        $sysconfig = $this->model_sysconfig->getSysconfig();
 
        $search = array('{doname}','{classname}');
        $meta_replace = array($sysconfig['cfg_webname'],'资讯频道');
        $meta_array = str_replace($search, $meta_replace, $meta);
		
		$hotelcity=$this->model_city->getHotCity(12);
		$abccity=$this->model_city->getCityToABCD();
		
		$area_arr=$this->model_city->get_area($cityinfo['cid']);
		$star_arr = $this->model_config->star_pinyin_ary();
		$fangxing_arr = $this->model_config->fangxing_pinyin_ary();
		$pricelist_arr = $this->model_config->tuan_jiage_ary();
		$categor_arr = $this->model_config->categor_pinyin_ary();
		
        $data = array();
        $data['layout'] = $layout ; 
        $data['method'] = $this->uri->segment(1) ;      
        $data['newslist'] = $newslist ;      
        $data['newscount'] = $newscount ;      
        $data['pagenav'] = $pagnav ;  
		$data['hotelcity'] = $hotelcity ;  
		$data['abccity'] = $abccity ;  
		$data['cityinfo'] = $cityinfo ;  
		$data['area_arr'] = $area_arr ;  
		$data['star_arr'] = $star_arr ;
		$data['list_url'] = $list_url ;
		$data['fangxing_arr'] = $fangxing_arr ;
		$data['categor_arr'] = $categor_arr ;
		
		$data['cityid'] = $cityid ;  
		$data['area'] = $area ;  
		$data['areaname'] = $areainfo['areaname'] ; 
		$data['star'] = $star;
		$data['fangxing'] = $fangxing;
		$data['category'] = $category ;
		$data['price'] = $price ;
		$data['range'] = $range ;
		$data['orderfiled']=$order;
		$data['range_list'] = $range_list;
		
		$data['pricelist_arr'] = $pricelist_arr ;
        $data['metainfo'] = $meta_array ; 
        $data['newsclassName'] = $newsclassName ;
        $data['newclass'] = $newclass;
		$this->load->view('tuangou',$data);
	}
	
	private function baseUrl($cityid, $page, $order, $area, $range, $star ,$fangxing ,$price,$category) 

	{

		$aTag = array ("area", 'range', 'star', 'fangxing','price', 'order', 'page','category' );

		foreach ( $aTag as $val ) {

			

			$list_url = "/tuangou/$cityid/p-1";
			
			if ($category&&$val!='category') {

				$list_url .= "-category-".urlencode($category);

			}


			if ($area&&$val!='area') {

				$list_url .= "-area-".urlencode($area);

			}
			if ($page&&$val!='page') {

				$list_url .= "-page-".urlencode($page);

			}

			if ($range &&$val!='range') {

				$list_url .= "-range-".urlencode($range);

			}
			
			if ($star&& $val!='star' ) {

				$list_url .= "-star-".urlencode($star);

			}

			if ($fangxing &&$val!='fangxing') {

				$list_url .= "-fangxing-$fangxing";

			}

			if ($price &&$val!='price') {

				$list_url .= "-price-$price";

			}


			if ($val != 'order') {

				$list_url .= "-order-$order";

			}

			$rt [$val] = $list_url;

		}

		return $rt;

	}

	
	


}
