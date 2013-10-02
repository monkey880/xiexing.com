<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_news_category.php
 * 资讯分类model
 * @date 2013-1-29 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_news_category extends CI_Model
{
	private $category_table;
    private $article_table;
    private $article_class_table;
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $this->load->library('tool');
        $db = (array) $this->db;
        $this->article_class_table = $db['dbprefix'].'article_class';
        $this->article_table = $db['dbprefix'].'article';
        $this->category_table = $db['dbprefix'].'article_class';
    }
    
    /**
     * 获得资讯分类信息
     * @param int $article_classId  资讯分类id
     * @return array $article_classInfo 资讯分类数组
     */
    public function getNewsClassInfo($class_id)
    {
    	$newsClassInfo = $this->db->where('class_id',$class_id)->get($this->article_class_table)->row_array();
        return $newsClassInfo;
    }
    
     /**
     * 获取资讯分类：以class_id为键值class_name为值的数组
     * @param array $where  查询条件数组
     * @return array $newsclass_data 资讯分类数组
     */
    function get_category($where=array())
    {
        $query = $this->db->select('class_id,class_name')->where($where)->get($this->category_table)->result_array();
        $newsclass_data = array();
        foreach ($query as $class){
            $newsclass_data[$class['class_id']] = $class['class_name'];
        }        
        return $newsclass_data ;
    }
    
    /**
     * 获得资讯分类列表
     * @param int $start  从第几条记录开始
     * @param int $num 要调用的条数
     * @param string $order 要排序的字段
     * @return array $article_classList 资讯分类列表数组
     */
    public function getNewsClassList($start=0,$nums=10,$order='class_id')
    {
        $article_classList = $this->db->limit($nums,$start)->order_by($order,'desc')->get($this->article_class_table)->result_array() ;
        return $article_classList;
    }
    
    /**
     * 根据条件获取资讯分类记录数 
     * @param array $where 条件
     * @return int $count 记录数
     */
    function getNewsClassCount($where=array())
    {
    	$count = $this->db->where($where)->count_all_results($this->article_class_table);
    	return $count;
    }
    
    /**
     * 删除一条或几条资讯分类：删除分类的同时输出该分类的的所有资讯
     * @param int $article_classId 资讯id
     * @return int $resultNews 受影响行数
     */
    function delNewsClass($class_id)
    {
    	$resultNewsClass = $this->db->delete($this->article_class_table, "class_id in ($class_id)");
        $resultNews = $this->db->delete($this->article_table, "class_id in ($class_id)");
        return $resultNews; 
    }
    
    /**
     * 添加/修改
     * @param string $mode 
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function addNewsClass($mode = 'insert',$info,$where=array())
    {
        if ($mode == 'insert') {
            $rs = $this->db->insert($this->article_class_table,$info);        
        } else {
            $rs = $this->db->update($this->article_class_table,$info,$where);      
        }
        return $rs;
    }   
   
}