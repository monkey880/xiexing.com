<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_layout.php
 * 页面布局model
 * @date 2013-1-25
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_layout extends CI_Model
{

	private $layout_table;
	private $zhuna_module;
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->layout_table = $db['dbprefix'].'layout';
        $this->zhuna_module = $db['dbprefix'].'module';
    }
    
    /**
     * 获取当前页面的布局
     * @param string $page 要显示布局的页面
     * @return array $layout 布局数租 
     */
    public function get_layout($page)
    {
        $sql = " select layout_module,layout_page,layout_pagename from {$this->layout_table} where layout_page='$page' limit 1 ";
        $query = $this->db->query($sql)->result_array();
        $layout = rtrim($query[0]['layout_module'],'|');
        $layout = explode('|',$layout);
        $layout_array = array();
        foreach ($layout as $key => $v )
        {
            $layout_array[$key] = explode('_',$v);
            $locationArr  = explode('-',$layout_array[$key][1]);
            $layout_array[$key]['location'] = $locationArr['0'];
            $layout_array[$key]['layout_module'] = $v;
        }
        
        return $layout_array;
        
    } 

    /**
     * 获取当前页面的布局
     * @param string $page 要显示布局的页面
     * @return array $layout 布局数租
     */
    public function getModel($location)
    {
    	if ($location == 'hotelinfo|expo') {
    		$layoutList = $this->db->where('page !=','index')->order_by('id','asc')->get($this->zhuna_module)->result_array() ;
    		return $layoutList;
    	} else {
    		$layoutList = $this->db->where($location)->order_by('id','asc')->get($this->zhuna_module)->result_array() ;
    		return $layoutList;
    	}
	}

    /**
     * 获得页面布局列表
     * @return array $layoutList 页面布局列表
     */
    public function getLayoutList()
    {
    	$layoutList = $this->db->order_by('layout_id','asc')->get($this->layout_table)->result_array() ;
    	return $layoutList;
    }
    
    /**
     * 修改
     * @param string $mode
     * @param array $info 添加的数据
     * @param array $where 修改条件
     * @return $rs
     */
    public function saveLayout($info,$where=array())
    {
    	$rs = $this->db->update($this->layout_table,$info,$where);
    	return $rs;
    }
}
?>