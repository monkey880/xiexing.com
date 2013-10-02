<?php



if (! defined ( 'BASEPATH' ))

	exit ( 'No direct script access allowed' );



/**

 * 

 * @ID hotellist.php

 * 住哪酒店分销联盟（酒店列表）模块

 * @date 2013-1-24 

 * @author yuhailong zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Hotellist extends CI_Controller {

	

	private $data;

	

	function __construct() {

		

		parent::__construct ();

		$this->data = array ();

		

		$this->load->model ( 'model_common' );

		$this->load->model ( 'model_layout' );

		$this->load->model ( 'model_keywords' );

		$this->load->model ( 'model_sysconfig' );

		$this->load->library ( 'ME_Pagination' );

		$this->load->library ( 'tool' );

		$this->load->model ( 'model_config' );
		
		$db = (array) $this->db;

        $this->hotel_table = $db['dbprefix'].'hotel';
		
		//$this->output->enable_profiler(TRUE);


	}

	

	public function index() 

	{

		//载入布局模型

		$layout = $this->model_layout->get_layout ( 'hotellist' );

		

		//处理get参数

        header("Content-Type: text/html; charset=utf-8");

		$getPara = $this->uri->rsegment(3);

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

		

		//价格

		$price_array = $this->model_config->price_ary ();

		$priceid = ! empty ( $getPara ['priceid'] ) ? intval ( $getPara ['priceid'] ) : '';

		if ($priceid) {

			$priceArrTmp = array_keys($price_array);

			$priceArr = $priceArr = explode('-',$priceArrTmp[$priceid-1]);

 			$getPara['minprice'] = $priceArr[0];

 			$getPara['maxprice'] = $priceArr[1];

		}

		

		//当选择cbd时，去掉地标相关参数（用户输入的地标名称；其他页面传递的地标id，地标拼音，xy坐标）

		$selField = '';

		if (!isset($getPara ['cbd_id'])) {

			//有x，y坐标时

			if (isset ( $getPara ['x'] )) {

				$selField = "&x={$getPara['x']}&y={$getPara['y']}";

				$x = $getPara['x'];

				$y = $getPara['y'];

			}

			if (!empty ( $getPara ['keyid'] )) {

				$keyid = $getPara ['keyid'];

				$pinyin = ! empty ( $getPara ['pinyin'] ) ? $getPara ['pinyin'] : '';;

				$lableApi = file_get_contents ( CFG_INTERFACE_API . "lable.get.xy&lableid=$keyid" );

				$lableApi = json_decode($lableApi,true);

				$selField = "&x={$lableApi['reqdata']['x']}&y={$lableApi['reqdata']['y']}";

				$lable = $lableApi['reqdata']['name'];

				$getPara['key'] = $lable;

				$x = $lableApi['reqdata']['x'];

				$y = $lableApi['reqdata']['y'];

			}

		}

		$x = ! empty ( $x ) && empty($keyid) ? $x : '';

		$y = ! empty ( $y ) && empty($keyid) ? $y : '';

		$pinyin = ! empty ( $pinyin ) ? $pinyin : '';

		$keyid = ! empty ( $keyid ) ? $keyid : '';

		

		//搜索块默认值

		$searchArray = $this->model_common->setLeftSearch ($getPara);

		$cityid = $searchArray ['cityid']; //城市id

		$cityname = $searchArray ['cityname']; //城市名称

		$tm1 = $searchArray ['tm1']; //入住日期

		$tm2 = $searchArray ['tm2']; //退房日期

		$lable = $searchArray ['key']; //地标  

		$hn = $searchArray ['hn']; //酒店名称

		$minprice = $searchArray ['minprice']; //最低价

		$maxprice = $searchArray ['maxprice']; //最高价

		$cityJson = json_encode ( array ('id' => $cityid, 'cityname' => $cityname ) );//选择城市插件默认值使用

		//搜索块以外的参数

		$pg = ! empty ( $getPara ['pg'] ) ? $getPara ['pg'] : 1; //页码

		$cbd_id = ! empty ( $getPara ['cbd_id'] ) ? $getPara ['cbd_id'] : 0; //商圈id
		
		$areaid = ! empty ( $getPara ['areaid'] ) ? $getPara ['areaid'] : 0; //商圈id
		
		$type = ! empty ( $getPara ['type'] ) ? $getPara ['type'] : 0; //商圈id

		$rank = ! empty ( $getPara ['rank'] ) ? intval ( $getPara ['rank'] ) : 0; //星级档次

		$chain_id = ! empty ( $getPara ['chain_id'] ) ? intval ( $getPara ['chain_id'] ) : 0; //连锁酒店id

		$px = ! empty ( $getPara ['px'] ) ? intval ( $getPara ['px'] ) : 1; //排序


		//生成url

		$list_url = $this->baseUrl ( $cityid, $pg, $px, $cbd_id, $rank, $chain_id ,$minprice ,$maxprice ,$keyid, $hn, $lable, $pinyin ,$x ,$y ,$priceid,$areaid);

		

		$this->data ['cityid'] = $cityid;

		$this->data ['cityname'] = $cityname;

		$this->data ['cityJson'] = $cityJson;

		$this->data ['list_url'] = $list_url;

		$this->data ['lable'] = $lable;
		
		$this->data ['type'] = $type;

		$this->data ['hn'] = $hn;

		$this->data ['rank'] = $rank;

		$this->data ['cbd_id'] = $cbd_id;
		
		$this->data ['areaid'] = $areaid;

		$this->data ['minprice'] = $minprice;

		$this->data ['maxprice'] = $maxprice;

		$this->data ['px'] = $px;

		$this->data ['chain_id'] = $chain_id;

		
		//行政区

		$area_list = $this->model_city->get_area ( $cityid );


		foreach ( $area_list as $area_val ) {

			if ($area_id == $area_val ['areaid']) {

				$areaname = $area_val ['areaname']; break;

			}

		}
		$this->data ['area_list'] = $area_list;

		$areaname = ! empty ( $areaname ) ? $areaname : '';

		//著名商圈

		$cbd_list = $this->model_common->getCBD ( $cityid, '0', '' );

		$cbd_list = $this->sort_cbd($cbd_list,$cbd_id);

		foreach ( $cbd_list as $cbd_val ) {

			if ($cbd_id == $cbd_val ['cbd_id']) {

				$cbd_name = $cbd_val ['CBD_Name']; break;

			}

		}

		$cbd_name = ! empty ( $cbd_name ) ? $cbd_name : '';

        //酒店品牌：

		$chain_list = $this->model_common->getChainHotel ( $cityid, '0', '' );

		$chain_list = $this->sort_chain($chain_list,$chain_id);

		foreach ( $chain_list as $chain_val ) {

			if ($chain_id == $chain_val ['lsid']) {

				$chain_name = $chain_val ['liansuo']; break;

			}

		}

		$chain_name = ! empty ( $chain_name ) ? $chain_name : '';

		//星级      

		$rank_array = $this->model_config->rank_ary ();

		$this->data ['chain_list'] = $chain_list;

		$this->data ['cbd_list'] = $cbd_list;

		$this->data ['price_array'] = $price_array;

		$this->data ['rank_array'] = $rank_array;

		

		//搜索结果

		$api = file_get_contents ( CFG_INTERFACE_API . "search&cid=$cityid&pg=$pg&key=$lable&hn=$hn&lsid=$chain_id&rank=$rank&px=$px&minprice=$minprice&maxprice=$maxprice&bid=$cbd_id{$selField}&areaid=$areaid" );

		$listresult = json_decode ( $api, true );
		$list = $listresult ['reqdata'];
		
		$wheresql="where ecityid='$cityid'";
		
		if($areaid){
			$wheresql.=" and eareaid=$areaid";
		}
		
		if($hn){
			$wheresql.=" and HotelName LIKE '%".$hn."%'";
		}
		
		if($lsid){
			$wheresql.=" and esdid=$lsid";
		}
		
		if($chain_id){
			$wheresql.=" and chain_id=$chain_id";
		}
		
		if($rank){
			$wheresql.=" and star=$rank";
		}
		
		if($minprice){
			$wheresql.=" and Min_price=$minprice";
		}
		if($maxprice){
			$wheresql.=" and Max_price=$maxprice";
		}
		
		if($cbd_id{$selField}){
			$wheresql.=" and cbd_id=$cbd_id{$selField}";
		}
		$api=1;
		$start=$pg==1?0:(int)$pg*5;
		$nums=5;
		$query = $this->db->query("select hotel_id as ID,HotelName,star as xingji,Address,Service,baidu_lat,baidu_lng,e_sdname as esdname,esdid,picture as Picture,Min_price as min_jiage,Haoping as df_haoping from $this->hotel_table $wheresql and isShow=1 order by paixu desc, hid desc limit $start,$nums")->result_array() ;
		$api=0;
		$list=array_merge($query,$list);
		//处理酒店列表数组
		
		

		foreach ( $list as $key => $val ) {

			$list [$key] ['xingji'] = $this->tool->hotelranknamenum ( $val ['xingji'] );

            $list [$key] ['df_haoping'] = $this->tool->hoteldianping($val['df_haoping'],3);  
			
			$list [$key] ['Picture'] = $val['Picture'];  
			

			if (isset ( $list [$key] ['juli'] )) {

				$juli = $list [$key] ['juli'];

				if(!empty($lable)){

				    $list [$key] ['juli'] = "距离\"".$lable."\"" . round ( $juli / 1000, 2 ) . "公里";

				}else{

					 $list [$key] ['juli'] = "" ;

				}

			}
			if($api){
			foreach ( $cbd_list as $cbd_val ) {

				$esdid = $list [$key] ['esdid'];

				if (trim($esdid)) {

					if ($esdid == $cbd_val ['cbd_id']) {

						$list [$key] ['place'] = $cbd_val ['CBD_Name'];

						$list [$key] ['place_id'] = $esdid;

					}	

				} else {

					$list [$key] ['place'] = '未知所在区域';

					$list [$key] ['place_id'] = '';

				}

			}
			}
			else{
				$list [$key] ['place'] = $val ['esdname'];
				$list [$key] ['place_id'] = $val ['esdid'];
			}

			$service = $val['Service'];

			$i = 0;

			if ( is_int(strpos($service,'停车场'))) {

				$list [$key] ['service_pic'][$i]['0'] = 'ss_tingche.gif';

				$list [$key] ['service_pic'][$i]['1'] = '停车场';

				$i++;

			} 

			if ( is_int(strpos(strtolower($service),'WIFI')) || is_int(strpos($service,'网')) ) {

				$list [$key] ['service_pic'][$i]['0']= 'ss_wifi.gif';

				$list [$key] ['service_pic'][$i]['1'] = '宽带上网';

				$i++;

			}

			if ( is_int(strpos(strtolower($service),'早餐')) || is_int(strpos(strtolower($service),'含早')) ) {

				$list [$key] ['service_pic'][$i]['0'] = 'ss_zaocan.gif';

				$list [$key] ['service_pic'][$i]['1'] = '早餐';

				$i++;

			}

			if ( is_int(strpos(strtolower($service),'商务中心'))) {

				$list [$key] ['service_pic'][$i]['0'] = 'ss_huiyishi.gif';

				$list [$key] ['service_pic'][$i]['1'] = '商务会议室';

				$i++;

			}

			if ( is_int(strpos(strtolower($service),'商店'))) {

				$list [$key] ['service_pic'][$i]['0'] = 'ss_shangdian.gif';

				$list [$key] ['service_pic'][$i]['1'] = '商店';

			}

		}

		$allnums = $listresult ['retHeader'] ['totalput'];

		$allpage = $listresult ['retHeader'] ['totalpg'];

		$pagesize = $listresult ['retHeader'] ['pagesize'];

		$perpage = $listresult ['retHeader'] ['pagesize'];

		//分页页码

		$config ['base_url'] = $list_url ['page'] . '-pg-';

        $config['suffix'] = $this->config->item('url_suffix');

		$config ['total_rows'] = $allnums;

		$config ['per_page'] = $perpage;

		$config['num_links'] = 4;

		$config ['page_tag_now'] = $pg;

		$config ['first_link'] = false;

		$config ['last_link'] = false;

		$config['first_link'] = '<<';

		$config['last_link'] = '>>';

        $config['prev_link'] = '&lt';

        $config['next_link'] = '&gt';

		$config ['use_page_numbers'] = TRUE;

		$config ['firstpage_query_string'] = FALSE;

		$config ['query_string_segment'] = 'pg';

		$config ['page_tag_prefix'] = '-';

		$this->me_pagination->initialize ( $config );

		$page = $this->me_pagination->create_links ();

		//分页信息列表信息

		$hoteIdStr = "";

		$nums = count ( $list ) - 1;

		foreach ( $list as $k => $v ) {
			

			if ($k < $nums)

				$hoteIdStr .= $v ['ID'] . ',';

			else

				$hoteIdStr .= $v ['ID'];
	

		}

		$this->data ['allnums'] = $allnums;

		$this->data ['list'] = $list;

		$this->data ['page'] = $page;

		$this->data ['hoteIdStr'] = $hoteIdStr;

		

		//处理网页中的seo信息

		$keywords_array = $this->model_common->getKeywords ( 'hotellist' );

		$s_lable = ! empty ( $lable ) ? $lable . '附近' : '';

		$s_rank = ! empty ( $rank ) ? $rank . '星级' : '';

		$s_minprice = ! empty ( $minprice ) ? $minprice . '元' : '';

		$s_maxprice = ! empty ( $maxprice ) ? $maxprice . '元' : '';

		$pg = '第'.$pg.'页';

		$keywords_search = array ('{doname}', '{cityname}', '{key?附近}', '{star?星级}', '{minjiage?元}', '{maxjiage?元}', '{hn}', '{pg}', '{key}', '{bidname}', '{lsname}' );

		$keywords_replace = array (CFG_WEBNAME, $cityname, $s_lable, $s_rank, $s_minprice, $s_maxprice, $hn, $pg, $lable ,$cbd_name ,$chain_name);

		$keywords_array = str_replace ( $keywords_search, $keywords_replace, $keywords_array );

		$this->data ['keywords_array'] = $keywords_array;

		if($this->session->userdata('xexinguserinfo')){

        	$this->data['loginsate']=1;

        }


		$this->data ['searchArray'] = $searchArray;

		$this->data ['layout'] = $layout;

		$this->data ['method'] = $this->uri->rsegment ( 1 );

		$this->load->view ( 'hotellist', $this->data );

	}

	

	private function baseUrl($cityid, $pg, $px, $cbd_id, $rank, $chain_id, $minprice ,$maxprice ,$keyid, $hn, $lable, $pinyin ,$x ,$y ,$priceid,$areaid) 

	{

		$aTag = array ("cbd", 'rank', 'chain', 'hotelprice', 'px', 'page' );

		foreach ( $aTag as $val ) {

			if ($val != 'page' && $val != 'px') {

				$list_url = "/hotellist/cityid-$cityid";

			} else {

				$list_url = "/ajax_action/ajax_change_page/cityid-$cityid";

			}

			

			if ($hn) {

				$list_url .= "-hn-".urlencode($hn);

			}

			if ($lable && $val != 'cbd') {

				$list_url .= "-key-".urlencode($lable);

			}
			
			if ($areaid && $val != 'cbd') {

				$list_url .= "-areaid-".urlencode($areaid);

			}

			if ($cbd_id && $val != 'cbd') {

				$list_url .= "-cbd_id-$cbd_id";

			}

			if ($rank && $val != 'rank' && $val != 'chain') {

				$list_url .= "-rank-$rank";

			}

			if ($chain_id && $val != 'chain' && $val != 'rank') {

				$list_url .= "-chain_id-$chain_id";

			}

			if ($minprice && $val != 'hotelprice') {

				$list_url .= "-minprice-$minprice";

			}

			if ($maxprice && $val != 'hotelprice') {

				$list_url .= "-maxprice-$maxprice";

			}

			if ($priceid && $val != 'hotelprice') {

				$list_url .= "-priceid-$priceid";

			}

			if ($val != 'px') {

				$list_url .= "-px-$px";

			}

			if ($keyid && $val != 'cbd') {

				$list_url .= "-keyid-$keyid";

			}

			if ($pinyin && $val != 'cbd') {

				$list_url .= "-pinyin-$pinyin";

			}

			if ($x && $val != 'cbd') {

				$list_url .= "-x-$x";

			}

			if ($y && $val != 'cbd') {

				$list_url .= "-y-$y";

			}

			$rt [$val] = $list_url;

		}

		return $rt;

	}

	

	

	/**

	 * 如果当前页面有cbd那么就把cbd排到最前面

	 * @param array $cbdlist 商圈数组

	 * @param int $cbd_id 商圈id

	 * @return array

	 */

	function sort_cbd($cbdlist,$cbd_id)

	{

		if($cbd_id == ''){

			return $cbdlist ;

		}else{

			$cbdlist_new = array();

			foreach ($cbdlist as $key => $cbd){

				$kk = $key + 1;

				if($cbd_id == $cbd['cbd_id'])

				{

					$cbdlist_new[0] = $cbd;

				}else{

					$cbdlist_new[$kk] = $cbd;

				}

			}

			ksort($cbdlist_new);

			return $cbdlist_new;

		}

	}

	

	

    /**

     * 如果当前页面有连锁id那么就把连锁排到最前面

     * @author zhaojianjun

     * @param array $chains 连锁数组

     * @param int $chain_id 连锁id

     * @return array

     */	

	function sort_chain($chains,$chain_id)

	{

	    if($chain_id == ''){

            return $chains;

        }else{

            $chainlist_new = array();

            foreach ($chains as $key => $chain){

            	$kk = $key + 1;

                if($chain_id == $chain['id'])

                {

                    $chainlist_new[0] = $chain;

                }else{

                    $chainlist_new[$kk] = $chain;

                }

            }

            ksort($chainlist_new);

            return $chainlist_new;

        }		

	}

}