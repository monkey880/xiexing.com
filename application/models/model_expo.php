<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_expo.php
 * 展会,展馆model
 * @date 2013-3-1 
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_expo extends CI_Model
{
	function __construct()
	{
        parent::__construct();
        
        $this->load->library('tool');
        $this->cachePath = ROOTPATH.DIRECTORY_SEPARATOR.$this->config->config['cache_path'];//缓存存放目录
    }
    
    /**
     * 获得展会
     * @param $int cityid  
     * @param $int $page 
     * @param $string $pagesize 
     * @param $string $day 
     * @return array $listresult 
     */
    public function getExpo($cityid,$page,$pagesize,$day = '',$px=1)
    {
        $fields = "exhid,exhname,ehcname,exhcityid,ehcid,exhlogo,exhcity,exhmtrade,exhdetail,exhbtime,exhetime";
    	$apiUrl = CFG_INTERFACE_API."expo.list&cityid=$cityid&pagesize=$pagesize&page=$page&day=$day&px=$px&fields=$fields";
        $cacheName = "expo_{$cityid}_{$page}_{$pagesize}_{$day}.json";
        $api_list = $this->tool->create_cache($apiUrl,$this->cachePath."expo/{$cityid}/",$cacheName);
        return $listresult = json_decode($api_list,true);
        
    }
    /**
     * 获得展会新闻
     * @param $int $newsid  展会新闻id
     * @return array $query 展会新闻信息数组
     */
    public function getExponews($newsid)
    {
    	$apiUrl = CFG_INTERFACE_API."expo.news.detail&newsid=$newsid";
    	$cacheName = "expo_exponews_{$newsid}.json";
    	$api_list = $this->tool->create_cache($apiUrl,$this->cachePath."expo/exponews/{$newsid}",$cacheName);
    	$listresult = json_decode($api_list,true);
    	return $listresult = $listresult['reqdata'][0];
    
    }
   
}
?>