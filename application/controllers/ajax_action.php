<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID ajax_action.php
 * 住哪酒店分销联盟（ajax调用）
 * @date 2013-1-24
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Ajax_action extends CI_Controller 
{
    
    function __construct()
    {
        parent::__construct();
    }
    
	public function ajax_set_time()
	{
		$tm1 = $_GET['tm1'];
		$tm2 = $_GET['tm2'];
		
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
	}
	
	public function ajax_change_page()
	{
		$db = (array) $this->db;
		$this->load->library ( 'tool' );
		$this->load->library ( 'ME_Pagination' );
        $this->load->model ( 'model_common' );
		$this->hotel_table = $db['dbprefix'].'hotel';
		//处理get参数
		$getPara = $this->uri->rsegment(3);
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
		
        //搜索块默认值
		$searchArray = $this->model_common->setLeftSearch ($getPara);
		$cityid = $searchArray ['cityid']; //城市id
		$tm1 = $searchArray ['tm1']; //入住日期
		$tm2 = $searchArray ['tm2']; //退房日期
		$lable = $searchArray ['key']; //地标  
		$hn = $searchArray ['hn']; //酒店名称
		$minprice = $searchArray ['minprice']; //最低价
		$maxprice = $searchArray ['maxprice']; //最高价
        
		$cityid = isset($getPara['cityid']) ? $getPara['cityid'] : '' ;
		$pg = isset($getPara['pg']) ? $getPara['pg'] : '' ;
		$px = isset($getPara['px']) ? $getPara['px'] : '' ;
		$cbd_id = isset($getPara['cbd_id']) ? $getPara['cbd_id'] : '' ;
		$areaid = isset($getPara['areaid']) ? $getPara['areaid'] : '' ;
		$rank = isset($getPara['rank']) ? $getPara['rank'] : '' ;
		$chain_id = isset($getPara['chain_id']) ? $getPara['chain_id'] : '' ;
		$keyid = isset($getPara['keyid']) ? $getPara['keyid'] : '' ;
		$pinyin = isset($getPara['pinyin']) ? $getPara['pinyin'] : '' ;
		$x = isset($getPara['x']) ? $getPara['x'] : '' ;
		$y = isset($getPara['y']) ? $getPara['y'] : '' ;
		$priceid = isset($getPara['priceid']) ? $getPara['priceid'] : '' ;
		
		//生成url
		$list_url = $this->baseUrl ( $cityid, $pg, $px, $cbd_id, $rank, $chain_id ,$minprice ,$maxprice ,$keyid, $hn, $lable, $pinyin ,$x ,$y ,$priceid,$areaid);
		//搜索结果
		$api = file_get_contents ( CFG_INTERFACE_API . "search&cid=$cityid&pg=$pg&key=$lable&hn=$hn&lsid=$chain_id&rank=$rank&px=$px&minprice=$minprice&maxprice=$maxprice&bid=$cbd_id&x=$x&y=$y&areaid=$areaid" );
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
		$start=$pg==1?0:((int)$pg-1)*5;
		$nums=5;
		//$query = $this->db->query("select hotel_id as ID,HotelName,star as xingji,Address,Service,baidu_lat,baidu_lng,e_sdname as esdname,esdid,picture as Picture,Min_price as min_jiage,Haoping as df_haoping from $this->hotel_table $wheresql and isShow=1 order by paixu desc, hotel_id desc limit $start,$nums")->result_array() ;
		$api=0;
		//$list=array_merge($query,$list);
		//处理酒店列表数组
		
		
		
		
        //著名商圈
		$cbd_list = $this->model_common->getCBD ( $cityid, '0', '' );
		foreach ( $cbd_list as $cbd_val ) {
			if ($cbd_id == $cbd_val ['cbd_id']) {
				$cbd_name = $cbd_val ['CBD_Name']; break;
			}
		}
		//处理酒店列表数组
		foreach ( $list as $key => $val ) {
			$list [$key] ['xingji'] = $this->tool->hotelranknamenum ( $val ['xingji'] );
            $list [$key] ['df_haoping'] = $this->tool->hoteldianping($val['df_haoping'],3);
			if (isset ( $list [$key] ['juli'] )) {
				$juli = $list [$key] ['juli'];
				if(!empty($lable)){
					$list [$key] ['juli'] = "距离\"".$lable."\"" . round ( $juli / 1000, 2 ) . "公里";
				}else{
					$list [$key] ['juli'] = "" ;
				}
			}
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
		$config ['base_url'] = $list_url  . '-pg-';
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
		$data ['list'] = $list;
		$data ['page'] = $page;
		$data ['hoteIdStr'] = $hoteIdStr;
        $data ['tm1'] = $tm1;
        $data ['tm2'] = $tm1;
		
		echo  json_encode($data);
		
	}
	private function baseUrl($cityid, $pg, $px, $cbd_id, $rank, $chain_id, $minprice ,$maxprice ,$keyid, $hn, $lable, $pinyin ,$x ,$y ,$priceid,$areaid)
	{
		$list_url = "/ajax_action/ajax_change_page/cityid-$cityid";
			
		if ($hn) {
			$list_url .= "-hn-".urlencode($hn);
		}
		if ($lable) {
			$list_url .= "-key-".urlencode($lable);
		}
		if ($cbd_id) {
			$list_url .= "-cbd_id-$cbd_id";
		}
		if ($areaid) {
			$list_url .= "-areaid-$areaid";
		}
		if ($rank) {
			$list_url .= "-rank-$rank";
		}
		if ($chain_id) {
			$list_url .= "-chain_id-$chain_id";
		}
		if ($minprice) {
			$list_url .= "-minprice-$minprice";
		}
		if ($maxprice) {
			$list_url .= "-maxprice-$maxprice";
		}
		if ($priceid) {
			$list_url .= "-priceid-$priceid";
		}
		if ($px) {
			$list_url .= "-px-$px";
		}
		if ($keyid) {
			$list_url .= "-keyid-$keyid";
		}
		if ($pinyin) {
			$list_url .= "-pinyin-$pinyin";
		}
		if ($x) {
			$list_url .= "-x-$x";
		}
		if ($y) {
			$list_url .= "-y-$y";
		}
		return $list_url;
	}
}