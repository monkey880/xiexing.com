<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID news.php

 * 住哪酒店分销联盟（后台新闻管理）模块

 * @date 2013-2-27 

 * @author zhaojianjun zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Product extends CI_Controller 

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

        $this->load->model('model_product');
		

        $this->load->library('tool');

        $this->load->library('pagination');

        $this->load->helper('form');


        $this->load->model('model_admin');
		//$this->output->enable_profiler(TRUE);

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

        

        $type = intval($this->uri->segment(4)) ;

        $whereSql = '';

        if ($type) {

            $whereSql = array('ProductType'=>$type); 

            $whereSqlList = "where ProductType=$type";   

        }  else {

            $whereSql = array('ProductType !='=>$type); 

            $whereSqlList = "where ProductType!=$type";          

        }

		

        $hotelcount = $this->model_product->get_count($whereSql);

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->model_product->get_list($pageinfo['start'],$pagesize,'ProductID desc',$whereSqlList);

        

        


        

        //分页

        $config['base_url'] = base_url(CFG_ADMINURL.'/product/index/'.$cityid);

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

        $data['type'] = $type;

        $data['provinceclass_select'] = $provinceclass_select ;  


        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_productlist',$data);

    }
	
	public function order()

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

        

        $type = intval($this->uri->segment(4))?intval($this->uri->segment(4)):0 ;


		

        $hotelcount = $this->model_product->get_order_count();

        $pageinfo = $this->tool->get_page_info($page,$hotelcount,$pagesize);

        $hotellist = $this->model_product->get_order_list($pageinfo['start'],$pagesize,'poid desc',$whereSqlList);

        //生成新闻分类的select菜单
        
        $config['base_url'] = base_url(CFG_ADMINURL.'/product/order/'.$type);

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

        $data['type'] = $type;

        


        $data = array_merge($data,$this->userinfo);

        $this->load->view('admin/admin_product_order_list',$data);

    }
	
	
public function orderinfo()

    {    

    	$orderid = intval($this->uri->segment(4));

    	$info = $this->model_product->get_gift_orderinfo($orderid);
		
		
        $this->load->view('admin/admin_productorder',$info);

    }



    /**

     * 显示添加或修改新闻界面

     */

    public function add()

    {    

    	$hotelid = intval($this->uri->segment(4));

    	if($hotelid > 0 ){

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    } 

    		$info = $this->model_product->get_productinfo($hotelid);
			
    		

    	}else{

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    }

	        $info = array();

	        $info['title'] = '';

	        $info['aid'] = 0;

	        $info['content'] = '';

	        $info['author'] = '';

	        $info['smallcontent'] = '';

	        $info['class_id'] = '';

	        $info['state_radio'] = 1;

	        $info['img'] = '';

            $info['CityID'] = '';

            $info['order'] = '0';

            

           

    	}

    	//生成显示状态的radio单选按钮

    	$soure_radio_data = $this->model_config->soure_radio_ary();
		
		$youhui_radio_data = $this->model_config->youhui_radio_ary();

    	


    	$info['soure_radio_data'] = $soure_radio_data;
		
		$info['youhui_radio_data'] = $youhui_radio_data;

		
    	$data = array_merge($info,$this->userinfo);
		

        $this->load->view('admin/admin_product_add',$data);

    }
	
	
	
	

    /**

     * 保存新闻

     */

    public function save_product()

    {

    	$ProductID = (int) $this->input->post('ProductID', TRUE);

    	$ProductName = $this->input->post('ProductName', TRUE);

    	$ProductExplain = stripcslashes($_POST['ProductExplain']);   

    	$ProductNum = $this->input->post('ProductNum', TRUE);

    	$Price = $this->input->post('Price', TRUE);
		
		$PresentExp = $this->input->post('PresentExp', TRUE);
		
		$Stocks = $this->input->post('Stocks', TRUE);
		
		$ProductType = $this->input->post('ProductType', TRUE);
		
		$Weight = $this->input->post('Weight', TRUE);
		
			// 定义上传类upload的上传规则

    	$img = '';

    	

		$config['upload_path'] = ROOTPATH.DIRECTORY_SEPARATOR.'public/uploadfiles/upload/';

		$config['allowed_types'] = 'gif|jpg|png';

		$config['encrypt_name'] = TRUE; // 上传的文件将被重命名为随机的加密字符串

		$config['max_size'] = '2048'; // 允许上传文件大小的最大值(以K为单位).该参数为0则不限制。

		$this->load->library('upload', $config);

		$do = $this->upload->do_upload();

		$imageData = array('upload_data' => $this->upload->data());
		$img = $imageData['upload_data']['file_name'];

		if (!$do && !($ProductID > 0 && $img == '')){

			$error = array('error' => $this->upload->display_errors());

			echo "<script>alert('{$error['error']}')</script>";

			exit;

		} 
		
    	$data = array();

    	$data['ProductID'] = $ProductID;

    	$data['ProductName'] = $ProductName;

    	$data['ProductExplain'] = $ProductExplain;

    	$data['ProductNum'] = $ProductNum;
		
    	$data['Price'] = $Price;

    	$data['PresentExp'] = intval($PresentExp);

    	$data['Stocks'] = intval($Stocks);
		
		$data['ProductType'] = intval($ProductType);
		
		$data['Weight'] = $Weight;
		
		$data['AddTime'] = time();
		if($img){
		$data['ProductThumb'] = $img;
		
		$data['ProductPic'] = $img;
		}

        if ( $ProductID > 0 ) {

            $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/hotel').'";</script>';

    	       die();   

    	    }

            $result = $this->model_product->save_product($data,'update');

            if ($result) {

            	$alertMsg = '修改资讯成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/product/index/0/'.$page);

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '修改礼品失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}else {

    	    $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   

    	    if (!$isoperate) {

               echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

    	       die();   

    	    }

            $result = $this->model_product->save_product($data,'insert');

            if ($result) {

            	$alertMsg = '添加礼品成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/news');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';

            } else {

            	$alertMsg = '添加礼品失败';

            	echo '<script>alert("'.$alertMsg.'");</script>';

            }

    	}

    	

    }
	
	public function order_state()

    {    

    	$id = intval($this->uri->segment(4));
		$state = intval($this->uri->segment(5));
		
		$date['poid']=$id;
		$date['state']=$state;
		

    	 $this->model_product->save_product_order($date,'update');
		 
		 $alertMsg = '订单状态更改成功';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/product/order');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
		
    }
	
	public function save_order()

    {    

    	$date['poid']=$this->input->post('poid', TRUE);
		$date['wuli_company']=$this->input->post('wuli_company', TRUE);
		$date['wuli_num']=$this->input->post('wuli_num', TRUE);
		$date['state']='2';
		
		

    	 $this->model_product->save_product_order($date,'update');
		 
		 $alertMsg = '物流信息已提交';

            	$redirectUrl = site_url('/'.CFG_ADMINURL.'/product/order');

            	echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
		
    }


    /**

     * 删除新闻

     */

    public function del_product()

    {

        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   

	    if (!$isoperate) {

           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';

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

    		$result = $this->model_product->del_product($newsid);

    		if($result){

    			redirect(CFG_ADMINURL.'/product/index/'.$urlClassid);

    		}else{

    			redirect(CFG_ADMINURL.'/product/index/'.$urlClassid);

    		}

    	}
 
    }
	
	public function getProductType($type){
		
		switch ($type)
		{
			case 3:
			return "免费礼品";
			break;
			
			case 4:
			return "积分礼品";
			break;
			
			default :
			return "普通商品";
			break;
			
		}
		
			
		
	}

        

}