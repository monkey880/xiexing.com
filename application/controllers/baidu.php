<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @ID news.php
 * 携行酒店分销联盟（咨询）模块
 * @date 2013-1-24
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 *
 */

class Baidu extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('model_layout');
        $this->load->model('model_keywords');
        $this->load->model('model_sysconfig');
        $this->load->model('model_tuangou');
        $this->load->model('model_city');
		$this->load->helper('text');
        $this->load->library('pagination');
        $this->load->library('tool');
        $this->output->enable_profiler(TRUE);
    }
    
	public function index()
	{
        
        
       require_once('/baidu/phplib/console/Console.php');
		require_once('/baidu/search/NearbySearch.php');
		require_once('/baidu/search/LocalSearch.php');
		require_once('/baidu/search/BoundSearch.php');
		require_once('/baidu/search/DetailSearch.php');
		
		$console = new Console();
		$console->setServerAK('4b905df3330121f4382299f18cfc2462', '9E050DAfce0ca5861a01bda20bc8c234');
		
		$search = new NearbySearch(31958, $console, '120.734879,31.288689', 100);
		$nearby = $search->search();
		var_dump($nearby);
		
		$search = new LocalSearch(31958, $console, 1);
		$search->setSortBy('ClickCount', BasicSearch::DESCEND);
		$search->addFilter('ClickCount', 1, 100);
		$search->addTags('华北');
		$local = $search->search();
		
		var_dump($local);
		
		$search = new BoundSearch(31958, $console, '116.383801,39.90112', '116.412475,39.916451');
		$bound = $search->search();
		
		$search = new DetailSearch(31958, $console, 18460245);
		$detail = $search->search();
		
		var_dump($detail);

		//$this->load->view('tuangou',$data);
	}
	
	private function baseUrl($cityid, $page, $order, $area, $range, $star ,$fangxing ,$price,$category) 

	{

		$aTag = array ("area", 'range', 'star', 'fangxing','price', 'order', 'page','category' );

		foreach ( $aTag as $val ) {

			

			$list_url = "/tuangou/$cityid/p-1";
			
			if ($category&&$val!='category') {

				$list_url .= "-category-".urlencode($category);

			}


			if ($area&&$val!='area') {

				$list_url .= "-area-".urlencode($area);

			}
			if ($page&&$val!='page') {

				$list_url .= "-page-".urlencode($page);

			}

			if ($range &&$val!='range') {

				$list_url .= "-range-".urlencode($range);

			}
			
			if ($star&& $val!='star' ) {

				$list_url .= "-star-".urlencode($star);

			}

			if ($fangxing &&$val!='fangxing') {

				$list_url .= "-fangxing-$fangxing";

			}

			if ($price &&$val!='price') {

				$list_url .= "-price-$price";

			}


			if ($val != 'order') {

				$list_url .= "-order-$order";

			}

			$rt [$val] = $list_url;

		}

		return $rt;

	}

	


}
