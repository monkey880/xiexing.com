<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID model_hotel.php

 * 酒店信息 model

 * @date 2013-1-30 

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Model_hotel extends CI_Model

{

    private $cachePath;

    

    function __construct()

    {

        parent::__construct();

        $this->load->database();
		
		$db = (array) $this->db;

        $this->hotel_table = $db['dbprefix'].'hotel';
		
		 $this->hotelorder_table = $db['dbprefix'].'hotelorder';
		 $this->comment_table = $db['dbprefix'].'comment';
		 
		 $this->roomtype_table = $db['dbprefix'].'roomtype';
		 
		  $this->rule_table = $db['dbprefix'].'cardrule';
		  
		  $this->plan_table = $db['dbprefix'].'plan';
		 
		 


        $this->load->model('model_keywords'); 

        $this->load->model('model_sysconfig');

        $this->load->library('tool');

        

        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path'];//缓存存放目录

    }

    

    /**

     * 获取酒店详细信息

     * @param <int> $hotelId

     * return <array> $info

     */

    function getHotelInfo($hotelId)

    {

        $apiUrl = "http://union.api.zhuna.cn/hotel/json/hotel_$hotelId.json";

        $cacheName = "hotel_hid{$hotelId}.json";

        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."hotel/hotel/",$cacheName);

        return $list = json_decode($api_list,true);  

    }  
	
	/**

     * 获取房型信息

     * @param <int> $hotelId

     * return <array> $info

     */

    function getroomtype($hotelId)

    {

        $apiUrl = "http://www.api.zhuna.cn/e/jsbook.php?hid=$hotelId";
		
		 $cacheName = "roomtype_hid{$hotelId}.json";

        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."hotel/roomtype/",$cacheName);
		

        $api_list = json_decode($api_list,true);

        return $list = $api_list['rooms_opts'];  

    }  
	
	

  function getroom($hotelId,$tm1,$tm2)

    {

        $apiUrl = "http://www.api.zhuna.cn/e/json.php?hid=$hotelId&tm1=$tm1&tm2=$tm2&orderfrom=0&call=callback";
		
		 $cacheName = "room_hid{$hotelId}.json";
			$api_list = file_get_contents($apiUrl);
        //$api_list = $this->tool->create_cache($apiUrl,$this->cachePath."hotel/room/",$cacheName);


        //$api_list = json_decode($api_list,true);
		$api_list =str_replace('var _Data=[','',$api_list);
		$api_list =str_replace('];','',$api_list);
		$api_list =str_replace('if(callback){callback(_Data)}else{alert(\'Err:callback\')};','',$api_list);
        return $list = $api_list;  

    }  
	


    /**

     * 获取酒店评论

     * @param <int> $hotelId

     * @param <int> $nums

     * return <array> $list

     */

    public function getCommentList($hotelId = '',$nums = 5, $pagesize = 10)

    {

        $apiUrl = CFG_INTERFACE_API."hotel.comment&hid=$hotelId&pagesize=$pagesize";

        $cacheName = "hotel_comment_hid{$hotelId}.json";

        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."comment/comment/",$cacheName);

        $list = json_decode($api_list,true);

        //截取相应的返回数目，处理数据方便显示

    	foreach ($list['reqdata'] as $key=>$val) {

    		$yingxiang_show = $this->tool->tags_ary($val['yinxiang']);

    		$list['reqdata'][$key]['yinxiang_show'] = array_slice($yingxiang_show,0,4);

    		$renqun = explode(',',$val['renqun']);

    		$list['reqdata'][$key]['comment_pic_text'] = $renqun[0];

    		switch($renqun[0]){

    			case '其他':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_01.gif';

    				break;

    			case '携带儿童的家庭 ':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_02.gif';

    				break;

    			case '商务旅客':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_03.gif';

    				break;

    			case '单独旅行者':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_04.gif';

    				break;

    			case '户外探险旅行者':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_05.gif';

    				break;

    			case '夫妇情侣':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_06.gif';

    				break;

    			case '与朋友同行':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_07.gif';

    				break;

    			case '与客户同行':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_08.gif';

    				break;

    			case '家族旅游':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_09.gif';

    				break;

    			case '带宠物出行':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_10.gif';

    				break;

    			default :

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_01.gif';

    				$list['reqdata'][$key]['comment_pic_text'] = '其他';

    		}

    	}

    	$list['reqdata'] = array_slice($list['reqdata'],0,$nums);

    	return $list;

    }

    

    /**

     * 根据城市id获取酒店评论

     * @param <int> $cityid

     * @param <int> $nums

     * return <array> $list

     */

    public function getCommentListByCiytid($cityid = '0101',$nums = 5, $pagesize = 10, $page = 1)

    {

    	$apiUrl = CFG_INTERFACE_API."comment.list&cityid=$cityid&pagesize=$pagesize&page=$page";

    	//缓存前几页

    	if ($page<5) {

    		$cacheName = "hotel_comment_cid{$cityid}_page{$page}.json";

    		$api_list = $this->tool->create_cache($apiUrl,$this->cachePath."comment/comment/",$cacheName);

    	} else {

    		$api_list = file_get_contents($apiUrl);

    	}

    	$list = json_decode($api_list,true);

    	//截取相应的返回数目，处理数据方便显示

    	foreach ($list['reqdata'] as $key=>$val) {

    		$list['reqdata'][$key]['date_show'] = date("y/m/d",$val['time']);

    		$yingxiang_show = $this->tool->tags_ary($val['yinxiang']);

    		$list['reqdata'][$key]['yinxiang_show'] = array_slice($yingxiang_show,0,4);

    		$renqun = explode(',',$val['renqun']);

    		$list['reqdata'][$key]['comment_pic_text'] = $renqun[0];

    		switch($renqun[0]){

    			case '其他':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_01.gif';

    				break;

    			case '携带儿童的家庭 ':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_02.gif';

    				break;

    			case '商务旅客':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_03.gif';

    				break;

    			case '单独旅行者':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_04.gif';

    				break;

    			case '户外探险旅行者':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_05.gif';

    				break;

    			case '夫妇情侣':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_06.gif';

    				break;

    			case '与朋友同行':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_07.gif';

    				break;

    			case '与客户同行':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_08.gif';

    				break;

    			case '家族旅游':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_09.gif';

    				break;

    			case '带宠物':

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_10.gif';

    				break;

    			default :

    				$list['reqdata'][$key]['comment_pic'] = 'dianping_01.gif';

    				$list['reqdata'][$key]['comment_pic_text'] = '其他';

    		}

    	}

    	$list['reqdata'] = array_slice($list['reqdata'],0,$nums);

    	return $list;

    }

    

    /**

     * 获取酒店问答

     * @param <int> $hotelId 

     * @param <int> $nums  

     * @return array $list

     */

    public function getQuestionList($hotelId = '',$nums = 5, $pagesize = 10)

    {

    	$apiUrl = CFG_INTERFACE_API."hotel.question&hid=$hotelId&pagesize=$pagesize";

        $cacheName = "hotel_question_hid{$hotelId}.json";

        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."comment/question/",$cacheName);

        $list = json_decode($api_list,true);

        //截取相应的返回数目，处理数据方便显示

        foreach($list['reqdata'] as $key=>$val){

            $val = explode('{un}',$val['content']);

            $list['reqdata'][$key]['question'] = $val['0'];  

            $list['reqdata'][$key]['answer'] = $val['1'];                            

        }

        $questionList = array_slice($list['reqdata'],0,$nums);

        $list['reqdata'] = $this->tool->change_array($questionList);

        

        return $list;

    }

    

    /**

     * 根据城市id获取获取酒店问答

     * @param <int> $cityid 

     * @param <int> $nums  

     * @return array $list

     */

    public function getQuestionListByCityid($cityid = '', $num= 5, $pagesize = 10, $page = 1)

    {

    	$apiUrl = CFG_INTERFACE_API."question.list&cityid=$cityid&pagesize=$pagesize&page=$page";

    	//缓存前几页

    	if ($page<5) {

    		$cacheName = "hotel_question_cid{$cityid}_page{$page}.json";

    		$api_list = $this->tool->create_cache($apiUrl,$this->cachePath."comment/question/",$cacheName);

    	} else {

    		$api_list = file_get_contents($apiUrl);

    	}

    	$list = json_decode($api_list,true);

    	//截取相应的返回数目，处理数据方便显示

    	$questionList = array_slice($list['reqdata'],0,$num);

    	$list['reqdata'] = $this->tool->change_array($questionList);

    	

    	return $list;

    }

    

    /**

     * 酒店交通指南组合成数组

     * @param <mixed> $traffic

     * @return <array> $result

     */

    public function trafficShow($traffic)

    {

        $traffic_array = explode('-', $traffic);

        $title = $traffic_array[0];

        unset($traffic_array[0]);

        $content = $traffic_array; 

        return $traffic_array = array('title'=>$title,'content'=>$content);

        

    }

    

    /**

     * 得到周边酒店：根据经纬度

     * @param <mixed> $lat,$lng,$limit

     * @return <array> $welcome_hotel 

     */

    public function getRoundHotel($lat,$lng,$limit)

    {	

    	$field = "ID,HotelName,min_jiage,juli,Picture";

        $welcome_hotel_api = file_get_contents(CFG_INTERFACE_API."hotel.search.nearby&lat=$lat&lng=$lng&pagesize=$limit&field=$field");

        return $welcome_hotel = json_decode($welcome_hotel_api,true);      

    }

    

    /**

     * 得到周边酒店：根据xy

     * @param <mixed> $lat,$lng,$limit

     * @return <array> $welcome_hotel

     */

    public function getRoundHotelByXY($x,$y,$limit)

    {

    	$field = "ID,HotelName,min_jiage,juli,Picture";

    	$welcome_hotel_api = file_get_contents(CFG_INTERFACE_API."search&x=$x&y=$y&pagesize=$limit&field=$field");

    	return $welcome_hotel = json_decode($welcome_hotel_api,true);

    }

    

    /**

     * 得到附近地标

     * @param <mixed> 

     * @return <array> 

     */

    public function getLableByHotelXY($cityid,$lat,$lng)

    {

    	$api = file_get_contents(CFG_INTERFACE_API."lable.search.nearby&cityid=$cityid&lat=$lat&lng=$lng");

    	$lableListJson = json_decode($api,true);

    	return $lableList = $lableListJson['reqdata'];

    }
	
	 /**

     * 数据库操作开始


     */
	 
	 
	 
	  /**

     * 酒店列表

     * @param $int $start  从第几条记录开始

     * @param $int $num 要调用的条数

     * @param $string $order 要排序的字段

     * @return array $query 酒店数组列表

     */

    public function get_list($start=10,$nums=2,$order='hid desc',$where='')

    {

    	$query = $this->db->query("select hid,hotel_id,HotelName,star,CityName,Min_price,soure from $this->hotel_table $where order by $order,hid desc limit $start,$nums")->result_array() ;


        return $query;
    }
	
	public function get_roomtype($rid)

    {

    	$query = $this->db->where('rid',$rid)->get($this->roomtype_table)->row_array() ;


        return $query;
    }
	
	function get_roomtype_count($condition=array())

    {

    	$count = $this->db->where($condition)->count_all_results($this->roomtype_table);

    	return $count;

    	

    }
	
	  public function get_roomtype_list($start=10,$nums=2,$order='rid desc',$where='')

    {

    	$query = $this->db->query("select * from $this->roomtype_table $where order by $order,rid desc limit $start,$nums")->result_array() ;
		
        return $query;
    }
	
	 /**

     * 酒店详情

     * @param $int $start  从第几条记录开始

     * @param $int $num 要调用的条数

     * @param $string $order 要排序的字段

     * @return array $query 酒店数组列表

     */

    public function get_hotelinfo($hid)

    {

    	$query = $this->db->where("hotel_id = '$hid' ")->get($this->hotel_table)->row_array();


        return $query;

        

    }

	 public function get_hotelinfo_byid($hid)

    {

    	$query = $this->db->where("hid = $hid ")->get($this->hotel_table)->row_array();


        return $query;

        

    }
	  /**

     * 根据条件获取酒店记录数 

     * @param array $condition 条件

     * @return int 记录数

     */

    function get_count($condition=array())

    {

    	$count = $this->db->where($condition)->count_all_results($this->hotel_table);

    	return $count;

    	

    }
	
	 /**

     * 增加酒店 

     * @param array $data 新闻数据

     * @return unknown

     */

    function save_hotel($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->hotel_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('hid',$data['hid'])->update($this->hotel_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->hotel_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	    function save_roomtype($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->roomtype_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('rid',$data['rid'])->update($this->roomtype_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->roomtype_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 /**

     * 保存订单 

     * @param array $data 新闻数据

     * @return unknown

     */

    function save_order($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->hotelorder_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('orderID',$data['orderID'])->update($this->hotelorder_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->hotelorder_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 function save_comment($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->comment_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('orderID',$data['orderID'])->update($this->comment_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->comment_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 public function get_orderlist($start=10,$nums=2,$order='orderID desc',$where='')

    {

    	$query = $this->db->query("select * from $this->hotelorder_table $where order by $order,orderID desc limit $start,$nums")->result_array() ;
		

        return $query;
    }
	
	function get_ordercount($condition=array())

    {

    	$count = $this->db->where($condition)->count_all_results($this->hotelorder_table);

    	return $count;

    	

    }
	 public function get_orderinfo($oid)

    {

    	$query = $this->db->where("orderID = $oid ")->get($this->hotelorder_table)->row_array();


        return $query;

        

    }
	
	
		 public function get_rule($rid)

    {

    	$query = $this->db->where("ruleid = $rid ")->get($this->rule_table)->row_array();


        return $query;

        

    }
	
		 public function get_plan($pid)

    {

    	$query = $this->db->where("planid = $pid ")->get($this->plan_table)->row_array();


        return $query;

        

    }
	
	 public function get_dayprice($date,$rid,$fid)

    {

    	$query = $this->db->query("select * from $this->plan_table where $date>=startdate and $date<=enddate and rid=$rid and fid=$fid order by priority desc")->row_array();


        return $query;

        

    }
	
	 function save_rule($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->rule_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('ruleid',$data['ruleid'])->update($this->rule_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->rule_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 function save_plan($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->plan_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('planid',$data['planid'])->update($this->plan_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->plan_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 public function get_rule_list($hid)

    {

    	$query = $this->db->where("hid = $hid ")->get($this->rule_table)->result_array();


        return $query;

        

    }
	
		 public function get_plan_list($rid,$fid,$tm1,$tm2)

    {
		if($fid){
			$wheresql=" and fid=$fid";
		}
		if($tm1&&$tm2){
			$wheresql.=" and $tm1>=startdate and $tm2<=enddate";
		}

    	$query = $this->db->where("rid = $rid $wheresql ")->get($this->plan_table)->result_array();


        return $query;

        

    }

	
	  /**

     * 根据条件获取酒店记录数 

     * @param array $condition 条件

     * @return int 记录数

     */
	 
	
	
	 /**
     * 删除一条或几条新闻
     * @param int $newsid 新闻id
     */
    function del_hotel($newsid)
    {
    	$result = $this->db->delete($this->hotel_table, "hid in ($newsid)");
    	return $result; 
    	
    }
	
	function post_baidu($id,$data,$action,$databoxid='34599'){
		
		$data['ak']='85654a7702d8b2163b85f87e6585b4f5';
		$data['geotable_id']=$databoxid;
		if(strchr($id,',')){
		$data['ids']=$id;
		}
		else{
		
		$data['id']=$id;
		}
		$content = '';
        foreach ($data as $k => &$v) 
        {
            $v = urlencode($v);
            $content .= $k . '=' . $v . '&';
        }
        $content = substr($content, 0, strlen($content) - 1);
		$params = array('url' => 'http://api.map.baidu.com/geodata/v2/poi/'.$action);
		$this->load->library('baidu_lbs',$params);
		$this->baidu_lbs->set_method("POST");
		$this->baidu_lbs->set_useragent("Baidu_LbsYun_Sdk");
		$this->baidu_lbs->set_body($content);
		
		$res=$this->baidu_lbs->send_request(1);
		return $res;
	}

  


	

}



?>