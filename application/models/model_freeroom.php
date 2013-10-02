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



class Model_freeroom extends CI_Model

{

	private $freeroom_table;

	

    function __construct(){

        parent::__construct();

        $this->load->database();


        $this->load->model('model_config');

        

        $db = (array) $this->db;

        $this->freeroom_table = $db['dbprefix'].'freeroom';

        

    }

    

    /**

     * 免费房

     * @param $int $start  从第几条记录开始

     * @param $int $num 要调用的条数

     * @param $string $order 要排序的字段

     * @return array $query 免费房数组列表

     */

    public function get_list($start=10,$nums=2,$order='R_ID desc',$where='')

    {

    	$query = $this->db->query("select * from $this->freeroom_table $where order by $order,fid desc limit $start,$nums")->result_array() ;

        

        

        

        //遍历通过class_id取class_name

       // foreach ($query AS $k => $v) {
//
//            $query[$k]['class_name'] = $classArr[$v['class_id']];
//
//            $query[$k]['state_name'] = $state_radio_ary[$v['state_radio']];
//
//            $query[$k]['time_show'] = date('Y-m-d H:i:s', $v['time']);
//
//        }



        return $query;

        

    }



    /**

     * 根据条件获取新闻记录数 

     * @param array $condition 条件

     * @return int 记录数

     */

    function get_count($condition=array())

    {

    	$count = $this->db->where($condition)->count_all_results($this->freeroom_table);

    	return $count;

    	

    }

    

    /**

     * 获取免费房详情

     * @param $newsid

     * @return array

     */

    function get_freeroominfo($freeroomid)

    {

        $query = $this->db->where("fid = $freeroomid ")->get($this->freeroom_table)->row_array();

        return $query;

    }


    

    /**

     * 增加新闻

     * @param array $data 新闻数据

     * @return unknown

     */

    function save_freeroom($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->freeroom_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('fid',$data['fid'])->update($this->freeroom_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->freeroom_table, $data);      

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

    function del_freeroom($newsid)

    {

    	$result = $this->db->delete($this->freeroom_table, "fid in ($newsid)");

    	return $result; 

    	

    }

    

  

   

}

?>