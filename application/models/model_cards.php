<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_news.php
 * 新闻model
 * @date 2013-1-29 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_cards extends CI_Model
{
	private $news_table;
	private $category_table;
	
	
    function __construct(){
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->card_table = $db['dbprefix'].'card';
       
    }
    
    /**
     * 新闻模块
     * @param $int $start  从第几条记录开始
     * @param $int $num 要调用的条数
     * @param $string $order 要排序的字段
     * @return array $query 新闻数组列表
     */
    public function get_list($start=10,$nums=2,$order='cid desc',$where='')
    {
    	$query = $this->db->query("select * from $this->card_table $where order by $order,cid desc limit $start,$nums")->result_array() ;
        
       

        return $query;
        
    }

    /**
     * 根据条件获取新闻记录数 
     * @param array $condition 条件
     * @return int 记录数
     */
    function get_count($condition=array())
    {
    	$count = $this->db->where($condition)->count_all_results($this->card_table);
    	return $count;
    	
    }
    
  
    
  
    /**
     * 增加新闻
     * @param array $data 新闻数据
     * @return unknown
     */
    function save_cards($data,$method="insert",$where = '')
    {
    	if($method == 'insert'){
    		$query = $this->db->insert($this->card_table, $data);
    	}elseif ($method == 'update'){
    	    if (!$where) {
    	       $query = $this->db->where('cid',$data['cid'])->update($this->card_table, $data);   
    	    } else {
    	       $query = $this->db->where($where)->update($this->card_table, $data);      
    	    }
    		
    	}else{
    		return FALSE;
    	}
    	 
    	return $query;
    }
    
    /**
     * 删除一条或几条新闻
     * @param int $newsid 新闻id
     */
    function del_news($newsid)
    {
    	$result = $this->db->delete($this->card_table, "cid in ($newsid)");
    	return $result; 
    	
    }
    
    /**
     * 替换content
     * @param <type> $content
     */
    public function replaceTag($content,$cityid,$cityname)
    {
    
    	preg_match_all("/{([^#]*)\#([0-9]*)}/", $content, $out);
    	$search_str = isset($out[0][0]) ? $out[0][0] : '';
    	$lable =  isset($out[1][0]) ? $out[1][0] : '';
    	$pagesize =  isset($out[2][0]) ? $out[2][0] : 10 ;
        //搜索结果
        $field = "HotelName,Address,juli,ID,Picture,min_jiage";
        $api = file_get_contents ( CFG_INTERFACE_API . "search&cid=$cityid&key=".urlencode($lable)."&pagesize=$pagesize&field=$field&pagesize=$pagesize" );
        $listresult = json_decode ( $api, true );
        $totalput = $listresult['retHeader']['totalput'];
        $list = $listresult['reqdata'] ;
        if ($list) {
        	$content1 = "<div class='Article_hotel'>";
        	foreach ($list as $key=>$val) {
        		$content1 .="<dl>";
        		$content1 .="<dt>";
        		$content1 .="<a href='".site_url("/hotelinfo/{$val['ID']}")."'><img width='100'";
        		$content1 .="height='75' alt='{$val['HotelName']}'";
        		$content1 .="src='{$val['Picture']}'></a>";
        		$content1 .="</dt>";
        		$content1 .="<dd>";
        		$content1 .="<a href='".site_url("/hotelinfo/{$val['ID']}")."'><strong>{$val['HotelName']}</strong></a>";
        		$content1 .="<span>{$val['Address']}</span>最低{$val['min_jiage']}元";
        		$juli = !empty($val['juli']) ? $val['juli'] : '';
        		if ($juli) {
        			$content1 .="<br>距<a href='".site_url("/hotellist/cityid-{$cityid}-key-{$lable}")."'><b>{$lable}</b></a>约<b style='color: red;'>".round ( $val['juli'] / 1000, 2 )."</b>公里";
        		} 
        		$content1 .="</dd>";
        		$content1 .="</dl>";
        	}
        	if ($totalput>$pagesize ) {
        		$lableContent = !empty($juli) ? $lable.'附近' : '';
        		$content1 .="<dl><a href='".site_url("/hotellist/cityid-{$cityid}-key-{$lable}")."'><b>查看更多{$cityname}{$lableContent}酒店&gt;&gt;</b></a></dl>";
        	}
        	$content1 .="</div>";
        } else {
        	$content1 = "";
        }
        $rs = str_replace($search_str,$content1,$content);
        return $rs;
        
    }
   
}
?>