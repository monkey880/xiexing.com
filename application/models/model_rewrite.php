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

class Model_rewrite extends CI_Model
{
	private $rewrite_table;
	private $dirpath;
	
	
    function __construct(){
        parent::__construct();
        $this->load->database();
        $db = (array) $this->db;
        $this->rewrite_table = $db['dbprefix'].'rewrite';
        $this->dirpath = ROOTPATH.DIRECTORY_SEPARATOR;
    }
    
    public function get_list($order='rewrite_id',$where='')
    {
    	$query = $this->db->query("select * from $this->rewrite_table $where order by $order asc")->result_array() ;
        

        return $query;
        
    }
    function get_one($id)
    {
        $query = $this->db->where("rewrite_id = $id ")->get($this->rewrite_table)->row_array();
        return $query;
    }
    
    /**
     * 保存伪静态
     * @param array $data 数据
     * @return unknown
     */
    function save_rewrite($data,$method="insert")
    {
    	if($method == 'insert'){
    		$query = $this->db->insert($this->rewrite_table, $data);
    	}elseif ($method == 'update'){
    		$query = $this->db->where('rewrite_id',$data['rewrite_id'])->update($this->rewrite_table, $data);
    	}else{
    		return FALSE;
    	}
    	 
    	return $query;
    }
    
    /**
     * 重写路由规则
     */
    function replace_routes()
    {
    	
    	$routes = $this->get_list();
        $routes_file = $this->dirpath.'application/config/routes.php';
        $fp = fopen($routes_file, 'w+');
        flock($fp, 3);
        fwrite($fp, "<" . "?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); \r\n");  
        foreach ($routes as $route){
            fwrite($fp, '$route[\''.$route['rewrite_new']."'] = '".$route['rewrite_org']."';\r\n");
        }    
        fclose($fp);
        
    }
    

    /**
     * 修改函数库中的伪静态规则
     * @param unknown_type $old_rules
     * @param unknown_type $new_rules
     */
    function replace_lib($old_rules,$new_rules)
    {
    	
    	$lib_file = $this->dirpath.'application/libraries/tool.php';
    	$lib_content = file_get_contents($lib_file);

        $rewrite_org_str = 'rewrite_org = array(';
        $rewrite_new_str = 'rewrite_new = array(';
        
        $where = 'where is_show = 1 ';
        $rules = $this->model_rewrite->get_list('rewrite_id',$where);

        //从数据库中读取规则
        $url_suffix = $this->config->item('url_suffix');
        foreach($rules as $rule){
        	$old_rule = explode('/',$rule['rewrite_org']);
        	$new_rule = explode('/',$rule['rewrite_new']);
            if (!in_array($old_rule[0],$old_rule_array)) {
                $rewrite_org_str .= '"/' .$old_rule[0] .'/",'.'"/' .$old_rule[0].$url_suffix.'",';    
            }
            if (!in_array($new_rule[0],$new_rule_array)) {
                $rewrite_new_str .= '"/' .$new_rule[0] .'/",'.'"/' .$new_rule[0].$url_suffix.'",';
            }
            $old_rule_array[] = $old_rule[0];
            $new_rule_array[] = $new_rule[0];
        }
        $rewrite_org_str = rtrim($rewrite_org_str, ',') . ');';
        $rewrite_new_str = rtrim($rewrite_new_str, ',') . ');'; 
        
    	/**
    	 * 1、找到规则数组
    	 * 2、替换规则
    	 * 3、重新将数据放到规则中
    	 */
    	preg_match("/rewrite_org = array\([\s\S]*?\);/i", $lib_content, $rewrite_org);
        preg_match("/rewrite_new = array\([\s\S]*?\);/i", $lib_content, $rewrite_new);
        
        $filecontent = str_replace($rewrite_org[0], $rewrite_org_str, $lib_content);
        $filecontent = str_replace($rewrite_new[0], $rewrite_new_str, $filecontent);
        $result = file_put_contents($lib_file,$filecontent);
        return !$result ? true:false;


    }
    
    function replace_nav($old_rules,$new_rules)
    {
        $templets_nav_file = $this->dirpath.'templates/default/inc/nav.php';
        $templets_content = file_get_contents($templets_nav_file);
        
        $new_nav = explode('/',$new_rules);
        $old_nav = explode('/',$old_rules);
        
        $templets_new_content = str_replace($old_nav[0], $new_nav[0], $templets_content);
        return file_put_contents($templets_nav_file,$templets_new_content);    	
    }
   
}
?>