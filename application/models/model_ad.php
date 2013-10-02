<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_ad.php
 * 广告model
 * @date 2013-2-20
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_ad extends CI_Model
{
	private $data;
    private $ad_table;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->load->model('model_config');
        $this->ad_table = $db['dbprefix'].'ad';
    }
    
    /**
     * 获得广告信息
     * @param int $adId  广告id
     * @return array $adInfo 广告数组
     */
    public function getAdInfo($adId)
    {
    	$adInfo = $this->db->where('ad_id',$adId)->get($this->ad_table)->row_array();
        
        return $adInfo;
    }
    
    /**
     * 获得广告列表
     * @param $int $start  从第几条记录开始
     * @param $int $num 要调用的条数
     * @param $string $order 要排序的字段
     * @return array $adList 广告列表数组
     */
    public function getAdList($start=1,$nums=10,$order='ad_id')
    {
    	$adList = $this->db->limit($nums,$start)->order_by($order,'desc')->get($this->ad_table)->result_array() ;
        if (!empty($adList)) {
            //广告状态数组
            $ad_state_radio_ary = $this->model_config->ad_state_radio_ary();
            //广告类型数组
            $ad_type_radio_ary = $this->model_config->ad_type_radio_ary();
            foreach ($adList AS $key => $val) {
                $adList[$key]['state_name'] = $ad_state_radio_ary[$val['ad_state_radio']];
                $adList[$key]['type_name'] = $ad_type_radio_ary[$val['ad_type_radio']];
                $adList[$key]['time'] = date('Y-m-d H:i:s', $val['ad_addtime']);
            }
        }
        
        return $adList;
    }
    
    /**
     * 获得广告列表
     * @param $int $adNameStr  
     * @param $string $order 要排序的字段
     * @return array $adList 广告列表数组
     */
    public function getAdListByAd_cid($adNameStr,$order='ad_order asc')
    {
    	$adList = $this->db->query("SELECT * FROM $this->ad_table WHERE ad_name IN ($adNameStr) AND (ad_state_radio = 2 OR (ad_state_radio = 1 AND ad_endtime>".time()."))  ORDER BY $order,ad_id desc")->result_array() ;
    	return $adList;
    }
    
    /**
     * 根据条件获取广告记录数 
     * @param array $where 条件
     * @return int $count 记录数
     */
    function getAdCount($where=array())
    {
    	$count = $this->db->where($where)->count_all_results($this->ad_table);
    	return $count;
    }
    
    /**
     * 删除一条或几条广告
     * @param int $adId 新闻id
     * @return int $result 
     */
    function delAd($adId)
    {
    	$result = $this->db->delete($this->ad_table, "ad_id in ($adId)");
    	return $result; 
    }
    
    /**
     * 判断ad_name唯一性的
     * @param type $ad_name
     * @return type 
     */
    public function checkAdName($ad_name)
    {
        $ad_id = $this->db->select('ad_id')->where('ad_name',$ad_name)->get($this->ad_table)->row_array();
        return $ad_id;
    }
    
    /**
     * 添加/修改
     * @param string $mode 
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function addAd($mode = 'insert',$info,$where=array())
    {
        if ($mode == 'insert') {
            $rs = $this->db->insert($this->ad_table,$info);        
        } else {
            $rs = $this->db->update($this->ad_table,$info,$where);      
        }
        return $rs;
    } 
}
?>