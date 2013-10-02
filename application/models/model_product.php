<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID model_hotel.php

 * 酒店信息 model

 * @date 2013-1-30 

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Model_product extends CI_Model

{

    private $cachePath;

    

    function __construct()

    {

        parent::__construct();

        $this->load->database();
		
		$db = (array) $this->db;

        $this->product_table = $db['dbprefix'].'product';
		
		$this->product_order_table = $db['dbprefix'].'product_order';


        $this->load->model('model_keywords'); 

        $this->load->model('model_sysconfig');

        $this->load->library('tool');

        

        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path'];//缓存存放目录

    }

    

    
	 
	  /**

     * 商品列表

     * @param $int $start  从第几条记录开始

     * @param $int $num 要调用的条数

     * @param $string $order 要排序的字段

     * @return array $query 酒店数组列表

     */

    public function get_list($start=10,$nums=2,$order='ProductID desc',$where='')

    {

    	$query = $this->db->query("select ProductID,ProductName,ProductType,ProductThumb,Price,PresentExp,BuyTimes from $this->product_table $where order by $order,ProductID desc limit $start,$nums")->result_array() ;


        return $query;

        

    }
	
	 public function get_order_list($start=10,$nums=2,$order='poid desc',$where='')

    {

    	$query = $this->db->query("select * from $this->product_order_table $where order by $order,poid desc limit $start,$nums")->result_array() ;


        return $query;

        

    }
	
	 /**

     * 酒店详情

     * @param $int $start  从第几条记录开始

     * @param $int $num 要调用的条数

     * @param $string $order 要排序的字段

     * @return array $query 酒店数组列表

     */

    public function get_productinfo($pid)

    {

    	$query = $this->db->where("ProductID = $pid ")->get($this->product_table)->row_array();


        return $query;

        

    }
	
	
    public function get_gift_orderinfo($pid)

    {

    	$query = $this->db->where("poid = $pid ")->get($this->product_order_table)->row_array();


        return $query;

        

    }


	
	  /**

     * 根据条件获取酒店记录数 

     * @param array $condition 条件

     * @return int 记录数

     */

    function get_count($condition=array())

    {

    	$count = $this->db->where($condition)->count_all_results($this->product_table);

    	return $count;

    	

    }
	
	 function get_order_count($condition=array())

    {

    	$count = $this->db->where($condition)->count_all_results($this->product_order_table);

    	return $count;

    	

    }
	
	 /**

     * 增加酒店 

     * @param array $data 新闻数据

     * @return unknown

     */

    function save_product($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->product_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('ProductID',$data['ProductID'])->update($this->product_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->product_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	function save_product_order($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->product_order_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('poid',$data['poid'])->update($this->product_order_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->product_order_table, $data);      

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
    function del_product($newsid)
    {
    	$result = $this->db->delete($this->product_table, "ProductID in ($newsid)");
    	return $result; 
    	
    }

}



?>