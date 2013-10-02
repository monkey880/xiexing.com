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

class Model_tags extends CI_Model
{
	private $data;
    private $tags_table;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->load->model('model_config');
        $this->tags_table = $db['dbprefix'].'tags';
    }
    
  
    public function gettagList($type,$nums)
    {
    	$adList = $this->db->where('type',$type)->limit($nums,0)->get($this->tags_table)->result_array() ;
        
        
        return $adList;
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