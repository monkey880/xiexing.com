<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_common.php
 * 基类 model
 * @date 2013-1-23 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_common extends CI_Model
{
    private $cachePath;
    private $keywords_table;
    
    /**
     * 初始化变量　定义私有变量
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $this->load->library('tool');
        $this->load->helper('cookie');
        $this->load->model('model_city');
        $db = (array) $this->db;
        $this->keywords_table = $db['dbprefix'].'keywords';            
        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path'];//缓存存放目录
    }

    /**
     * 得到受欢迎的酒店
     * @param <mixed> $cityid,$rank酒店星级,$pagesize记录数
     * @return <array> $welcome_lable 
     */
    public function getWelcomeHotel($cityid,$rank=1,$num=6,$pagesize=10)
    {   
        $field = "HotelName,min_jiage,esdid,ID,esdname,Address,Picture,xingji";
    	$apiUrl = CFG_INTERFACE_API."search&cid=$cityid&pg=1&px=4&pagesize=$pagesize&rank=$rank&field=$field";
        $cacheName = "hotel_welcome_cid{$cityid}_px4_rank{$rank}.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."hotel/{$cityid}/",$cacheName);
        $list = json_decode($api_list,true);
        return $list = array_slice($list['reqdata'],0,$num);         
    }
    
    /**
     * 得到推荐酒店
     * @param <mixed> $cityid,$pagesize记录数
     * @return <array> $welcome_lable 
     */
    public function getTuijianHotel($cityid,$num=6,$pagesize=10)
    {   
    	$field = "HotelName,min_jiage,esdid,ID,cbd,Address,Picture,xingji,df_haoping";
    	$inserfaceUrl = CFG_INTERFACE_API."search&cid=$cityid&pg=1&px=1&pagesize=$pagesize&field=$field";
        $cacheName = "hotel_tuijian_cid{$cityid}_px1.json";
        $tuijian_lable_api = $this->tool->create_cache($inserfaceUrl,$this->cachePath."hotel/{$cityid}/",$cacheName);
        $tuijiant_lable_tmp = json_decode($tuijian_lable_api,true);
        return $tuijian_lable = $list = array_slice($tuijiant_lable_tmp['reqdata'],0,$num); 
    }
    
    /**
     * 得到热门地标
     * @param <mixed> $cityid,$rows
     * @return <array> $hot_lable 
     */
    public function getLable($cityid,$px=1,$rows=14)
    {
        $cityArr = $this->model_city->get_local_city_byid($cityid);
        $areaid = $cityArr['areaid'];
        $apiUrl = CFG_INTERFACE_API."lable&cityid=$areaid&rows=$rows&px=$px";
        $cacheName = "hotel_lable_{$cityid}_{$px}_{$rows}.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
        $list = json_decode($api_list,true);
        return $list = $list['reqdata'];   
    }
    
    /**
     * 得到热门商圈
     * @param <mixed> $cityid,$rows
     * @return <array> $hot_lable 
     */
    public function getCBD($cityid,$px=0,$limit=14)
    {
        $apiUrl = CFG_INTERFACE_API."cbd&cityid=$cityid&px=$px";
        $cacheName = "cbd_{$cityid}_{$px}.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
        $list = json_decode($api_list,true);
        $list = $list['reqdata'];
        if (!empty($limit)) {
            $list = array_slice($list,0,$limit);   
        }
        return $list;
    }
    
    /**
     * 得到地铁站站地标
     * @param <mixed> $cityid,$rows
     * @return <array> $rt 
     */
    public function getSubwayLable($cityid,$rows = 12)
    {
        $cityArr = $this->model_city->get_local_city_byid($cityid);
        $areaid = $cityArr['areaid'];
        $apiUrl = CFG_INTERFACE_API."lable&cityid=$areaid&rows=$rows&classid=170";
        $cacheName = "lable_subway_{$cityid}_$rows.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
        $list = json_decode($api_list,true);
        return $list = $list['reqdata']; 
    }
    
    /**
     * 得到火车站地标
     * @param <mixed> $cityid,$rows
     * @return <array> $rt 
     */
    public function getTrainLable($cityid,$rows = 12)
    {
        $cityArr = $this->model_city->get_local_city_byid($cityid);
        $areaid = $cityArr['areaid'];
        $apiUrl = CFG_INTERFACE_API."lable&cityid=$areaid&rows=$rows&classid=166";
        $cacheName = "lable_train_{$cityid}_$rows.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
        $list = json_decode($api_list,true);
        return $list = $list['reqdata']; 
        
    }

    /**
     * 得到汽车站地标
     * @param <mixed> $cityid,$rows
     * @return <array> $rt 
     */
    public function getBusLable($cityid,$rows = 12)
    {
        $cityArr = $this->model_city->get_local_city_byid($cityid);
        $areaid = $cityArr['areaid'];
        $apiUrl = CFG_INTERFACE_API."lable&cityid=$areaid&rows=$rows&classid=163";
        $cacheName = "lable_bus_{$cityid}_$rows.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."lable/{$cityid}/",$cacheName);
        $list = json_decode($api_list,true);
        return $list = $list['reqdata']; 
        
    }
    
    /**
     * 获取用户访问过的酒店
     * @return <array> $historyHotel 
     */
    public function getHistoryHotel()
    {
        $historyHotel = array(); 
        $cookie_history = $this->input->cookie($this->config->item('cookie_prefix').'history');
        if($cookie_history){
            $cookie_history = explode('|',$cookie_history);
            foreach($cookie_history as $key=>$val){
                $oneHistoryHotel = explode(",",$val); 
                $historyHotel[$key]['hotelId'] = $oneHistoryHotel[0];  
                $historyHotel[$key]['hotelName'] = $oneHistoryHotel[1];
                $historyHotel[$key]['minprice'] = $oneHistoryHotel[2];  
            } 
        }
        return $historyHotel;
                
    }
	
	 public function getHistoryTuan()
    {
        $historyHotel = array(); 
        $cookie_history = $this->input->cookie($this->config->item('cookie_prefix').'historytuan');
        if($cookie_history){
            $cookie_history = explode('|',$cookie_history);
            foreach($cookie_history as $key=>$val){
                $oneHistoryHotel = explode(",",$val); 
                $historyHotel[$key]['tid'] = $oneHistoryHotel[0];  
                $historyHotel[$key]['title'] = $oneHistoryHotel[1];
                $historyHotel[$key]['price'] = $oneHistoryHotel[2];  
            } 
        }
        return $historyHotel;
                
    }
    
    /**
     * 更新用户访问的的酒店cookie
     * @param <mixed> $hotelId,$hotelName,$minprice
     * @return <mixed> 1
     */
    public function setHistoryHotel($hotelId,$hotelName,$minprice)
    {
        $n = true;
        $cookie_history = $this->input->cookie($this->config->item('cookie_prefix').'history');
        if($cookie_history){
            $cookie_history_arr = explode('|',$cookie_history);
            foreach($cookie_history_arr as $key=>$val){
                $oneHistoryHotel = explode(",",$val); 
                if($oneHistoryHotel[0] == $hotelId){
                    $n = false;    
                }
            } 
        }
        if($n){
            $curr_cookies = $hotelId.','.$hotelName.','.$minprice;
            if($cookie_history){
            	$new_history_cookies = $curr_cookies . '|' .$cookie_history;
                $historyCookie = array(
                    'name'   => 'history',
                    'value'  => $new_history_cookies,
                    'expire' => '3600',
                );
                $this->input->set_cookie($historyCookie);
            }else{
                $historyCookie = array(
                    'name'   => 'history',
                    'value'  => $curr_cookies,
                    'expire' => '3600',
                );
                $this->input->set_cookie($historyCookie);
            }  
        }
        
        return 1; 
    }
	
	public function setHistoryTuan($hotelId,$hotelName,$minprice)
    {
        $n = true;
        $cookie_history = $this->input->cookie($this->config->item('cookie_prefix').'historytuan');
        if($cookie_history){
            $cookie_history_arr = explode('|',$cookie_history);
            foreach($cookie_history_arr as $key=>$val){
                $oneHistoryHotel = explode(",",$val); 
                if($oneHistoryHotel[0] == $hotelId){
                    $n = false;    
                }
            } 
        }
        if($n){
            $curr_cookies = $hotelId.','.$hotelName.','.$minprice;
            if($cookie_history){
            	$new_history_cookies = $curr_cookies . '|' .$cookie_history;
                $historyCookie = array(
                    'name'   => 'history',
                    'value'  => $new_history_cookies,
                    'expire' => '3600',
                );
                $this->input->set_cookie($historyCookie);
            }else{
                $historyCookie = array(
                    'name'   => 'history',
                    'value'  => $curr_cookies,
                    'expire' => '3600',
                );
                $this->input->set_cookie($historyCookie);
            }  
        }
        
        return 1; 
    }
    
    /**
     * 根据页面名取页面keywords_info信息
     * @param <type> $k_id
     * @return <type>
     */
    public function getKeywords($page)
    {
        $sql = " SELECT k_title,k_keywords,k_description FROM {$this->keywords_table} WHERE k_page='$page' LIMIT 1 ";
        $query = $this->db->query($sql)->row_array();   
        return $query;
        
        /*
        $keywords_info = $this->db->cacheGetRow($sql, 86400);
        */
    }
    
    /**
     * 取最新酒店订单
     * @param <int> $limit
     * @return <array>  $orderlist 
     */
    public function getOderList($limit = 5)
    {
        $tel_a = array('150', '153', '152', '151', '186');
        for ($j = 0; $j <= 9; $j++) {
            $tel_a[] = '13' . $j;
        }
        $hotel_arr = array(
                           array('hotelname'=>'北京右安门速8酒店','hotelid'=>'21673'),
                           array('hotelname'=>'上海静安宾馆','hotelid'=>'6584'),
                           array('hotelname'=>'上海延安饭店','hotelid'=>'6181'),
                           array('hotelname'=>'深圳富临大酒店','hotelid'=>'5830'),
                           array('hotelname'=>'深圳大梅沙芭堤雅酒店','hotelid'=>'7565'),
                           array('hotelname'=>'杭州卡地亚大酒店','hotelid'=>'7903'),
                           array('hotelname'=>'惠州江景商务酒店','hotelid'=>'9479'),
                           array('hotelname'=>'武汉新龙商务酒店','hotelid'=>'5670'),
                           array('hotelname'=>'武汉纽宾凯国际酒店','hotelid'=>'4521'),
                           array('hotelname'=>'广州南方毅源大酒店','hotelid'=>'4379'), 
			        		array('hotelname'=>'上海安徒生文化酒店','hotelid'=>'20350'),
			        		array('hotelname'=>'起 青岛海天e家商务酒店','hotelid'=>'9342'),
			        		array('hotelname'=>'杭州海岸假日酒店','hotelid'=>'7892'),
			        		array('hotelname'=>'上海吉泰连锁酒店','hotelid'=>'13602'),
        );
        $orderlist = array();
        for ($i = 0; $i < $limit; $i++) {
            $rand_a = rand(0, count($tel_a) - 1);  
            $hotel = rand(0, count($hotel_arr) - $i+1);
            if($hotel > 9)
                $hotel = 0 + $i;
            $tel_b = rand(10, 99);
            $tel_c = rand(10, 99);
            $jiang = rand(80, 250);
            
            $tel = $tel_a[$rand_a] . $tel_b . $tel_c . '****';
            $time = date('m-d', time());
            $orderlist[$i]['tel'] = $tel;
            $orderlist[$i]['jiang'] = $jiang;;
            $orderlist[$i]['time'] = $time;
            $orderlist[$i]['hotelid'] = $hotel_arr[$hotel]['hotelid'];
            $orderlist[$i]['hotelname'] = $hotel_arr[$hotel]['hotelname'];
        }
        $date = date('Y-m-d');

        return $orderlist;
    }
    
    /**
     * 取最新酒店订单
     * @param <int> $limit
     * @return <array>  $orderlist
     */
    public function getRankList($limit = 5)
    {
    	$hotel_arr = array(
    			array('hotelname'=>'北京右安门速8酒店','hotelid'=>'21673'),
    			array('hotelname'=>'上海静安宾馆','hotelid'=>'6584'),
    			array('hotelname'=>'上海延安饭店','hotelid'=>'6181'),
    			array('hotelname'=>'深圳富临大酒店','hotelid'=>'5830'),
    			array('hotelname'=>'深圳大梅沙芭堤雅酒店','hotelid'=>'7565'),
    			array('hotelname'=>'杭州卡地亚大酒店','hotelid'=>'7903'),
    			array('hotelname'=>'惠州江景商务酒店','hotelid'=>'9479'),
    			array('hotelname'=>'武汉新龙商务酒店','hotelid'=>'5670'),
    			array('hotelname'=>'武汉纽宾凯国际酒店','hotelid'=>'4521'),
    			array('hotelname'=>'广州南方毅源大酒店','hotelid'=>'4379'),
    			array('hotelname'=>'上海安徒生文化酒店','hotelid'=>'20350'),
    			array('hotelname'=>'青岛海天e家商务酒店','hotelid'=>'9342'),
    			array('hotelname'=>'杭州海岸假日酒店','hotelid'=>'7892'),
    			array('hotelname'=>'上海吉泰连锁酒店','hotelid'=>'13602'),
    	);
    	
    	for ($i = 0; $i < $limit; $i++) {
	    	$hotel = rand(0, count($hotel_arr)-1);
	    	$jiang = rand(80, 250);
	    
	    	$orderlist[$i]['jiang'] = $jiang;;
	    	$orderlist[$i]['hotelid'] = $hotel_arr[$hotel]['hotelid'];
	    	$orderlist[$i]['hotelname'] = $hotel_arr[$hotel]['hotelname'];
	    
	    	unset($hotel_arr[$hotel]);
	    	$hotel_arr = array_values($hotel_arr);
	    }
    
    	return $orderlist;
    }
    
   
    
     /**
     * 取搜索块中的cookie:search
     * @return array   $searchCookie
     */
    public function getSearchCookie ()
    {
        $cookie = $this->input->cookie($this->config->item('cookie_prefix').'search');
    	if ($cookie) {
    		$cookie =explode('|',$cookie) ;
    		foreach ($cookie as $val) {
    			$oneCookie = explode(',',$val);
    			$searchCookie[$oneCookie[0]] = $oneCookie[1];
    		}
    	} else {
    		$searchCookie = array('cityid' => '','cityname' => '','tm1' => '','tm2' => '','key' => '','minprice' => '','maxprice' => '','hn' => '');
    	}
        return $searchCookie; 
    }
    
    /**
     * 初始化cityid
     * @return array
     */
    public function initCityinfo ()
    {
        $cityid = $this->input->get_post('cityid');     
        $city = array();
        if (!empty($cityid)) { 
            $cityArr = $this->model_city->get_local_city_byid($cityid);
            $cityname = $cityArr['cName'];//城市名称
            $city['cityid'] = $cityid;
            $city['cityname'] = $cityname;
        } else {
            //取默认配置文件中的cityinfo
            $initCityList = $this->model_city->getInitCityList();
            $city['cityid'] = $initCityList[0]['cityid'];
            $city['cityname'] = $initCityList[0]['cityname'];
        } 
        if (!$city['cityname']) {
            //取默认配置文件中的cityinfo
            $initCityList = $this->model_city->getInitCityList();
            $city['cityid'] = $initCityList[0]['cityid'];
            $city['cityname'] = $initCityList[0]['cityname'];   
        }
        return $city;
    }
    
    
    /**
     * 设置左上搜索块默认值
     * @return $Searchinfo
     */
    public function setLeftSearch($getPara = array())
    {
		if (isset($getPara['key'])) {
			$getPara['key'] = urldecode($getPara['key']);    
		}
        if (isset($getPara['hn'])) {
            $getPara['hn'] = urldecode($getPara['hn']);    
        }
        $_GET = $getPara;
        $searchCookie = $this->getSearchCookie();
        //得到cityid和cityname
        $cityinfo = $this->initCityinfo();
        //得到开始和结束时间
        $tm1 = $this->getTms($searchCookie);
        $tm2 = $this->getTme($searchCookie);
        $key = $this->getKey();
        $hn = $this->getHN();
        $minprice = $this->getMinprice();
        $maxprice = $this->getMaxprice();
        
        if ($maxprice <= $minprice) {
            $minprice = '';
            $maxprice = '';
        }
        
        $searchInfo = array(
            'cityid' => $cityinfo['cityid'],
            'cityname' => $cityinfo['cityname'],
            'tm1' => $tm1,
            'tm2' => $tm2,
            'key' => $key,
            'minprice' => $minprice,
            'maxprice' => $maxprice,
            'hn' => $this->keyword_replace($hn)
        );
        $cookieInfo = array(
            'tm1' => $tm1,
            'tm2' => $tm2,
        ); 
        
        //设置cookie
        $cookieStr = '';
        foreach ($cookieInfo as $key=>$val) {
             $cookieStr .=  $key.','.$val.'|';    
        }
        $cookieStr = rtrim($cookieStr,'|');
        $searchCookie = array(
            'name'   => 'search',
            'value'  => $cookieStr,
            'expire' => '3600',
        );
        $this->input->set_cookie($searchCookie); 
        
        return $searchInfo;
    }
    
    
    /**
     * 替换按酒店名称搜索时的关键字
     * @author zhaojianjun
     * @param string $hn 酒店关键字
     * @return string
     */
    function keyword_replace($hn)
    {
        $keyword_org = array("/七天/","/rujia/","/速八/");
        $keyword_new = array("7天","如家","速8");
        return preg_replace($keyword_org,$keyword_new,$hn);
    }

    
    /**
     * 取入店时间 默认时间是今天后的3天
     * @param <date> $tm
     * @return <date> $rstime
     */
    public function getTms($searchCookie)
    {
        $tm = $this->input->get_post('tm1');
        if (empty($tm)) { //如果tm1 POST值为空就默认是今天的
            $time_now = date('Y-m-d', time());
            $time_default = date('Y-m-d', time() + 0);
            $tm1_cookies = $searchCookie['tm1'];
            if (empty($tm1_cookies) || ($tm1_cookies < $time_now)) {  //检测是否有cookies时间 并且时间要大于等于今天
                $rstime = $time_default;    //如果没有cookes tm1 就等于现在的时间
            } else {
                $rstime = $tm1_cookies;     //如果有cookes tm1 就用cookies 里的时间
            }
        } else {
        	$rstime = $tm;
        }
        return $rstime;
    }

    /**
     * 取 离店时间 默认时间是今天后的6天
     * @param <date> $tm
     * @return <date> $rstime
     */
    public function getTme($searchCookie)
    {
        $tm = $this->input->get_post('tm2');
        if (empty($tm)) { //如果tm1 POST值为空就默认是今天的
            $time_now = date('Y-m-d', time());
            $time_default = date('Y-m-d', time() + 259200);
            $tm2_cookies = $searchCookie['tm2'];
            if (empty($tm2_cookies) || ($tm2_cookies < $time_now)) {  //检测是否有cookies时间 并且时间要大于等于今天
                $rstime = $time_default;    //如果没有cookes tm1 就等于现在的时间
            } else {
                $rstime = $tm2_cookies; //如果有cookes tm1 就用cookies 里的时间
            }
        } else {
        	$rstime = $tm;
        }
        return $rstime;
    }
    
    /**
     * 取酒店地标
     * @return <string> $key
     */
	public function getKey()
    {
        $key = $this->input->get_post('key');
        return $key = $key ? $key : '';
    }
    
    /**
     * 取酒店名称
     * @return <string> $hn
     */
    public function getHN()
    {
        $hn = $this->input->get_post('hn');
        return $hn = $hn ? $hn : '';
    }
    
    /**
     * 取最低价
     * @return <int> $minprice
     */
    public function getMinprice()
    { 
        $minprice = $this->input->get_post('minprice');
        return $minprice = is_numeric($minprice) ? $minprice : '';
    }
    
    /**
     * 取最高价
     * @return <int> $maxprice
     */
    public function getMaxprice()
    { 
        $maxprice = $this->input->get_post('maxprice');
        return $maxprice = is_numeric($maxprice) ? $maxprice : '';
    }
    
    /**
     * 取展会热门新闻
     * @return array
     */
    public function getHotExpoNews()
    {
        $apiUrl = CFG_INTERFACE_API."expo.news.list&fields=newsid,title";
        $cacheName = "expo_hot_news.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."expo/",$cacheName);
        $list = json_decode($api_list,true);
        return $list = $list['reqdata'];
    }
    
     /**
     * 取酒店连锁
     * param maxed $cityid,$jibie:0经济型1豪华型,$limit
     * @return array $list
     */
    public function getChainHotel($cityid,$jibie = 0,$limit = 8)
    { 
        $apiUrl = CFG_INTERFACE_API."chain&cityid=$cityid&jibie=$jibie";
        $cacheName = "chain_{$cityid}_{$jibie}.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."hotel/{$cityid}/",$cacheName);
        $list = json_decode($api_list,true);
        $list = $list = $list['reqdata'];
        if (!empty($limit) && !empty($list)) {
            $list = array_slice($list,0,$limit);   
        }
        return  $list;
    }
    
}
?>