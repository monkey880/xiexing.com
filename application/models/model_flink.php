<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_flink.php
 * 友情链接model
 * @date 2013-3-6
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_flink extends CI_Model
{
	private $data;
    private $flink_table;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $this->load->model('model_config');
        $this->load->library('tool');
        $db = (array) $this->db;
        $this->flink_table = $db['dbprefix'].'flink';
    }
    
    /**
     * 获得友情链接信息
     * @param int $flinkId  友情链接id
     * @return array $flinkInfo 友情链接数组
     */
    public function getFlinkInfo($flinkId)
    {
    	$flinkInfo = $this->db->where('flink_id',$flinkId)->get($this->flink_table)->row_array();
        return $flinkInfo;
    }
    
    /**
     * 获得友情链接列表
     * @param int $start  从第几条记录开始
     * @param int $num 要调用的条数
     * @param array $where 查询条件数组
     * @param string $order 要排序的字段
     * @return array $flinkList 友情链接列表数组
     */
    public function getFlinkList($start=0,$nums=10,$where=array(),$order='flink_id desc')
    {
    	$flinkList = $this->db->where($where)->limit($nums,$start)->order_by($order)->get($this->flink_table)->result_array() ;
        if (!empty($flinkList)) {
            //友情链接状态数组
            $flink_state_radio_ary = $this->model_config->ad_state_radio_ary();
            //友情链接类型数组
            $flink_type_radio_ary = $this->model_config->flink_type_radio_ary();
            //遍历通过class_id取class_name
            foreach ($flinkList AS $k => $v) {
                $flinkList[$k]['type_name'] = $flink_type_radio_ary[$v['flink_type_radio']];
                $flinkList[$k]['time'] = date('Y-m-d H:i:s', $v['flink_addtime']);
            }
        }
        
        return $flinkList;
    }
    
    /**
     * 根据条件获取友情链接记录数 
     * @param array $where 条件
     * @return int $count 记录数
     */
    function getFlinkCount($where=array())
    {
    	$count = $this->db->where($where)->count_all_results($this->flink_table);
    	return $count;
    }
    
    /**
     * 删除一条或几条友情链接
     * @param int $flinkId 新闻id
     * @return int $result 受影响行数
     */
    function delFlink($flinkId)
    {
    	$result = $this->db->delete($this->flink_table, "flink_id in ($flinkId)");
    	return $result; 
    }
    
    /**
     * 添加/修改
     * @param string $mode 
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function addFlink($mode = 'insert',$info,$where=array())
    {
        if ($mode == 'insert') {
            $rs = $this->db->insert($this->flink_table,$info);        
        } else {
            $rs = $this->db->update($this->flink_table,$info,$where);      
        }
        return $rs;
    }
}
?>