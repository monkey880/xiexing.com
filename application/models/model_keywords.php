<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_keywords.php
 * 网站关键字model
 * @date 2013-1-25 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_keywords extends CI_Model
{
    private $keywords_table ;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $this->load->library('tool');
        $db = (array) $this->db;
        $this->keywords_table = $db['dbprefix'].'keywords';
    }
    
    /**
     * 获得当前页面的meta信息
     * @param string $page 要显示的页面
     * @return array $query 页面meta数组
     */
    function getKeywords($page){
        $sql = " SELECT k_title,k_keywords,k_description FROM {$this->keywords_table} WHERE k_page='$page' LIMIT 1 ";
        $query = $this->db->query($sql)->row_array();   
        return $query;
    } 
    
    /**
     * 获得页面关键字信息
     * @param int $keywordsId  页面关键字id
     * @return array $keywordsInfo 页面关键字数组
     */
    public function getKeywordsInfo($k_id)
    {
    	$keywordsInfo = $this->db->where('k_id',$k_id)->get($this->keywords_table)->row_array();
        return $keywordsInfo;
    }
    
    /**
     * 获得页面关键字列表
     * @param int $start  从第几条记录开始
     * @param int $num 要调用的条数
     * @param array $where 查询条件数组
     * @param string $order 要排序的字段
     * @return array $keywordsList 页面关键字列表数组
     */
    public function getKeywordsList($start=0,$nums=10,$where=array(),$order='k_id')
    {
        $keywordsList = $this->db->where($where)->limit($nums,$start)->order_by($order,'asc')->get($this->keywords_table)->result_array() ;

        foreach ($keywordsList AS $k => $v) {
            $keywordsList[$k]['time_show'] = date('Y-m-d H:i:s', $v['k_time']);
        }
        
        return $keywordsList;
    }
    
    /**
     * 根据条件获取页面关键字记录数 
     * @param array $where 条件
     * @return int $count 记录数
     */
    function getKeywordsCount($where=array())
    {
    	$count = $this->db->where($where)->count_all_results($this->keywords_table);
    	return $count;
    }
    
    /**
     * 添加/修改
     * @param string $mode 
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function addKeywords($mode = 'insert',$info,$where=array())
    {
        if ($mode == 'insert') {
            $rs = $this->db->insert($this->keywords_table,$info);        
        } else {
            $rs = $this->db->update($this->keywords_table,$info,$where);      
        }
        return $rs;
    }
}
?>