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

class Model_news extends CI_Model
{
	private $news_table;
	private $category_table;
	
	
    function __construct(){
        parent::__construct();
        $this->load->database();
        
        $this->load->model('model_news_category');
        $this->load->model('model_config');
        
        $db = (array) $this->db;
        $this->news_table = $db['dbprefix'].'article';
        $this->category_table = $db['dbprefix'].'article_class';
    }
    
    /**
     * 新闻模块
     * @param $int $start  从第几条记录开始
     * @param $int $num 要调用的条数
     * @param $string $order 要排序的字段
     * @return array $query 新闻数组列表
     */
    public function get_list($start=10,$nums=2,$order='aid desc',$where='')
    {
    	$query = $this->db->query("select * from $this->news_table $where order by $order,aid desc limit $start,$nums")->result_array() ;
        
        //取所有的资讯栏目 不用LEFT JOIN取class_name
        $classArr = $this->model_news_category->get_category();
        
        //推荐状态数组
        $state_radio_ary = $this->model_config->state_radio_ary();
        
        
        //遍历通过class_id取class_name
        foreach ($query AS $k => $v) {
            $query[$k]['class_name'] = $classArr[$v['class_id']];
            $query[$k]['state_name'] = $state_radio_ary[$v['state_radio']];
            $query[$k]['time_show'] = date('Y-m-d H:i:s', $v['time']);
        }

        return $query;
        
    }

    /**
     * 根据条件获取新闻记录数 
     * @param array $condition 条件
     * @return int 记录数
     */
    function get_count($condition=array())
    {
    	$count = $this->db->where($condition)->count_all_results($this->news_table);
    	return $count;
    	
    }
    
    /**
     * 获取新闻详情
     * @param $newsid
     * @return array
     */
    function get_newsinfo($newsid)
    {
        $query = $this->db->where("aid = $newsid ")->get($this->news_table)->row_array();
        return $query;
    }
    
    /**
     * 获取下一条新闻
     * @param unknown_type $newsid
     */
    function get_nextnews($newsid)
    {
        $query = $this->db->query("select aid,title from $this->news_table where aid > $newsid  limit 1 ")->row_array();
        return $query;    	
    }
    
    /**
     * 上一条新闻
     * @param $newsid
     */
    function get_prenews($newsid)
    {
        $query = $this->db->query("select aid,title from $this->news_table where aid < $newsid order by aid desc limit 1 ")->row_array();
        return $query;     	
    }
    
    /**
     * 更新新闻阅读次数 
     * @param unknown_type $newsid
     */
    function update_newshit($newsid)
    {
    	$query = $this->db->query("update $this->news_table set view_num=view_num+1 where aid=$newsid");
    	if($this->db->affected_rows() === 0 )
    	{
    		return;
    	}
    }
    
    /**
     * 增加新闻
     * @param array $data 新闻数据
     * @return unknown
     */
    function save_news($data,$method="insert",$where = '')
    {
    	if($method == 'insert'){
    		$query = $this->db->insert($this->news_table, $data);
    	}elseif ($method == 'update'){
    	    if (!$where) {
    	       $query = $this->db->where('aid',$data['aid'])->update($this->news_table, $data);   
    	    } else {
    	       $query = $this->db->where($where)->update($this->news_table, $data);      
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
    	$result = $this->db->delete($this->news_table, "aid in ($newsid)");
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