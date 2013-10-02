<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID news.php

 * 携行酒店分销联盟（后台新闻管理）模块

 * @date 2013-2-27 

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Freeroom extends CI_Controller 

{

    

	private $userinfo;

    private $tablefunc = 'news';

	

    function __construct()

    {

        parent::__construct();

        $this->load->library('session');

        if(!$this->session->userdata('userinfo')){

        	redirect(CFG_ADMINURL.'/login');

        }

        $this->userinfo = $this->session->userdata('userinfo');

        $this->load->model('model_hotel');
		
		$this->load->model('model_freeroom');


        $this->load->library('tool');

        $this->load->library('pagination');

        $this->load->helper('form');

        $this->load->model('model_city');

        $this->load->model('model_admin');
		$this->output->enable_profiler(TRUE);

    }

    

    /**

     * 后台新闻列表

     */

    public function index()

    {    

        $data = array();

        

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

	       die();   

	    }

        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;

    	$isdel = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;

        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;

        $data['operate'] = array('isedit'=>$isedit,'isdel'=>$isdel,'isadd'=>$isadd);

        

        $page = intval($this->uri->segment(5)) ;

        $page = $page <= 0 ? 1 : $page ;

        $pagesize = 10 ;

        

        $cityid = intval($this->uri->segment(3)) ;

        $whereSql = array('fid <>'=>'0');


		

        $hotelcount = $this->model_freeroom->get_count($whereSql);

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->model_freeroom->get_list($pageinfo['start'],$pagesize,'fid desc',$whereSqlList);

        

        


        


        

        //分页

        $config['base_url'] = base_url(CFG_ADMINURL.'/freeroom/index/'.$cityid);

        $config['suffix'] = $this->config->item('url_suffix');

        $config['total_rows'] = $hotelcount ;

        $config['uri_segment'] = 5;

        $config['num_links'] = 8;

        $config['per_page'] = $pagesize;

        $config['use_page_numbers'] = true;

        $config['first_link'] = '<<';

        $config['last_link'] = '>>';

        $config['prev_link'] = '&lt;';

        $config['next_link'] = '&gt;';

        $this->pagination->initialize($config); 

        $pagnav = $this->pagination->create_links();



        $data['method'] = $this->uri->segment(2) ;      

        $data['hotellist'] = $hotellist ;      

        $data['hotelcount'] = $hotelcount ;      

        $data['pagenav'] = $pagnav ;  

        $data['page'] = $page;

        $data['cityid'] = $cityid;

       


        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_freeroomlist',$data);

    }



    /**

     * 显示添加或修改免费房界面

     */

    public function add()

    {    

    	$hotelid = intval($this->uri->segment(4));
		
		$freeroomid = intval($this->uri->segment(5));
		
		$hotelinfo = $this->model_hotel->get_hotelinfo_byid($hotelid);
		
		


    	if($freeroomid > 0 ){

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    } 
			
			$info = $this->model_freeroom->get_freeroominfo($freeroomid);


    	}else{
			
			

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    }

	        $info = array();

	        $info['R_HotelName'] = $hotelinfo['HotelName'];
			
			$info['R_HotelID'] = $hotelinfo['hotel_id'];

    	}

    	//生成显示状态的radio单选按钮

    	$roomtype_data = $this->model_hotel->get_roomtype_list('0','15','rid desc',' where hid='.$hotelid);
		
    	$info['roomtype_data'] = $roomtype_data;
		
		
    	$data = array_merge($info,$this->userinfo);
		

        $this->load->view('admin/admin_freeroom_add',$data);

    }

      /**

     * 保存免费房

     */

    public function save_freeroom()

    {

    	$fid = (int) $this->input->post('fid', TRUE);

    	$R_Title = $this->input->post('R_Title', TRUE);

    	$R_Content = stripcslashes($_POST['R_Content']);   

    	$R_HotelID = $this->input->post('R_HotelID', TRUE);

    	$R_HotelName = $this->input->post('R_HotelName', TRUE);
		
		$R_RoomID = $this->input->post('R_RoomID', TRUE);
		
		$R_Checkintime = $this->input->post('R_Checkintime', TRUE);
		
		$R_Checkouttime = $this->input->post('R_Checkouttime', TRUE);
		
		$R_states = $this->input->post('R_states', TRUE);
		
		$roomdata=explode(',',$R_RoomID);
		
		$hotelinfo=$this->model_hotel->get_hotelinfo($R_HotelID);

    	$data = array();

    	$data['fid'] = $fid;

    	$data['R_Title'] = $R_Title;

    	$data['R_Content'] = $R_Content;

    	$data['R_HotelID'] = $R_HotelID;

    	$data['R_HotelName'] = $R_HotelName;

    	$data['R_RoomID'] = $roomdata[0];
		
		$data['R_RoomName'] = $roomdata[1];

    	$data['R_Checkintime'] = strtotime($R_Checkintime);
		
		$data['R_Checkouttime'] = strtotime($R_Checkouttime);
		
		$data['R_states'] = $R_states;
		
		$data['R_Adder'] = $hotelinfo['Address'];
		
		$data['R_pic'] = $hotelinfo['picture'];
		
		$data['R_City'] = $hotelinfo['CityName'];
		
		$data['R_Area'] = $hotelinfo['eareaname'];
		
		$data['R_AddTime'] = time();
		
		


        if ( $fid > 0 ) {

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/freeroom').'";</script>';

    	       die();   

    	    }

            $result = $this->model_freeroom->save_freeroom($data,'update');

            if ($result) {

            	$alertMsg = '修改免费房成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/freeroom/'.$page);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '修改免费房失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}else {

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/freeroom').'";</script>';

    	       die();   

    	    }

            $result = $this->model_freeroom->save_freeroom($data,'insert');

            if ($result) {

            	$alertMsg = '添加免费房成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/freeroom');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '添加免费房失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}

    	

    }

    



    /**

     * 删除新闻

     */

    public function del_freeroom()

    {

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/freeroom').'";</script>';

	       die();   

	    }

    	$urlNewsid = $this->uri->segment(4);

    	$urlClassid = $this->uri->segment(5);

        $newsidArr = explode('-',$urlNewsid);

        $newsidStr = '';

        foreach ($newsidArr as $val) {

            $newsid = intval($val); 

            $newsidStr .= $newsid.',';      

        }

        $newsid = rtrim($newsidStr,',');

    	

    	if(!empty($newsid)){

    		$result = $this->model_freeroom->del_freeroom($newsid);

    		if($result){

    			redirect(CFG_ADMINURL.'/freeroom');

    		}else{

    			redirect(CFG_ADMINURL.'/freeroom/');

    		}

    	}

    }

        

}