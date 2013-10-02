<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * @ID Model_city.php

 * 城市model

 * @date 2013-2-17

 * @author yuhailong zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 * 

 */



class Model_member extends CI_Model

{


	

	function __construct()

	{

        parent::__construct();
		
		$this->load->database();
        
		$db = (array) $this->db;

        $this->member_table = $db['dbprefix'].'users';
		
		$this->explog_table = $db['dbprefix'].'user_explog';
		
		$this->comment_table = $db['dbprefix'].'comment';
		
		$this->jiangjin_table = $db['dbprefix'].'JiangJin';
		
		$this->tixian_table = $db['dbprefix'].'tixian';
		
		$this->hotelorder_table = $db['dbprefix'].'hotelorder';
		
		$this->load->library('session');


    }

    

    /**

     * 会员注册

     * @param $int $num  得到城市的数目

     * @return array $hotCArray 热门城市列表

     */

    public function regedit()

    {
		$mobile = $this->input->post('mobile');
		$password = $this->input->post('password');
		$password2 = $this->input->post('password2');
		$Email = $this->input->post('Email');
		
		if(!$mobile){
			echo '<script>alert("'.'手机号不能为空'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	    die();   

		}
		if($password!=$password2){
			echo '<script>alert("'.'两次输入的密码不一样，请重试'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	    die();   

		}
		
		if(!$Email){
			echo '<script>alert("'.'邮箱不能为空'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
    	    die();   

		}
		
		$data=array();
		$data['mobile_phone']=$mobile;
		$data['password']=md5(md5($password.'qingqing'));
		$data['email']=$Email;
		
		$query = $this->db->insert($this->member_table, $data);
		return $query;
    }
	
	
	
    /**

     * 会员注册

     * @param $int $num  得到城市的数目

     * @return array $hotCArray 热门城市列表

     */

    public function login($uid,$pass,$expires='false')

    {
		$pass=md5(md5($pass.'qingqing'));
		$query = $this->db->query("SELECT * FROM $this->member_table WHERE mobile_phone='$uid'");
		if($query->num_rows ){
			$query = $this->db->query("SELECT * FROM $this->member_table WHERE mobile_phone=$uid and password='$pass'");
			if($query->num_rows){
				$res=1;
				$userdata = array('id'=>$query->result_array['user_id'],'username'=>$query->result_array['mobile_phone']);
    			$this->session->set_userdata('xexinguserinfo',$userdata);
			}
			else{
				$res=-2;
			}
		}
		else{
			$res=-1;
		}
		return $res;
    }
	
	  /**

     * 会员注册

     * @param $int $num  得到城市的数目

     * @return array $hotCArray 热门城市列表

     */

    public function checkmobile($val)

    {
		
		$query = $this->db->query("SELECT * FROM $this->member_table WHERE mobile_phone='$val'");
		if($query->row_array()){ 
		return 1;
		}
		else{
			return 0;
		}
		
		
    }
	
	
	 /**

     * 保存省份数据

     * @return <array> $cityinfo 

     */

	 function save_userinfo($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->member_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('user_id',$data['user_id'])->update($this->member_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->member_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	function changeruzhu($date,$type='1'){
		
		if($type=='1'){
			$sql="update $this->member_table set $date[ziduan]=$date[ziduan]+$date[num] where user_id=$date[user_id]";
		}
		else{
			$sql="update $this->member_table set lianxufang_num=lianxufang_num+$date[num],endrzdate=$date[endrzdate] where user_id=$date[user_id]";
		}
		
		$query=$this->db->query($sql);
		
		return $query;
		
		
	}
	
	
	 function save_explog($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->explog_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('LogID',$data['LogID'])->update($this->explog_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->explog_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	
	
	
	 public function get_explog_list($start=10,$nums=2,$order='LogID desc',$where='')

    {

    	$query = $this->db->query("select * from $this->explog_table $where order by $order,LogID desc limit $start,$nums")->result_array() ;


        return $query;

        

    }
	
	 public function get_comment_list($start=10,$nums=2,$order='CommentID desc',$where='')

    {

    	$query = $this->db->query("select * from $this->comment_table $where order by $order,CommentID desc limit $start,$nums")->result_array() ;


        return $query;

        

    }
	
	// [cityid] => 0101
//            [hid] => 14418
//            [hotelname] => 北京丽亭酒店
//            [time] => 1359218134
//            [username] => 137****1348
//            [content] => 地理位置在王府井附近，出行比较方便，特别是在首堵这个地方。服务就是四星的标准，没啥特别的。第一天住的房间隔壁居然在装修，吵不说还有很浓的香蕉水味道，毒气啊，嚓，打电话才让换了房间！酒店门口有家starbucks，和咖啡比较方便，赞！酒店早餐很差，品种少味道也很差劲，还159一个人。
//            [df_haoping] => 1
//            [df_jiangjin] => 280
//            [yinxiang] => 舒适$优雅$繁华地区$一般$很干净$隔音太差
//            [renqun] => 单独旅行者,商务旅客,夫妇/情侣,携带儿童的家庭,与客户同行
//            [yinxiang_show] => Array
//                (
//                    [0] => 舒适
//                    [1] => 优雅
//                    [2] => 繁华地区
//                    [3] => 一般
//                )
//
//            [comment_pic_text] => 单独旅行者
//            [comment_pic] => dianping_04.gif
			
	public function getcomment($hid,$num=10){
		$this->load->model('model_config');
		$query=$this->get_comment_list('0',$num,'CommentID desc'," where hotel_id='$hid'");
		
    $pattern = "/(1\d{1,2})\d\d(\d{0,2})/";
$replacement = "\$1****\$4";
		foreach($query as $comment){
			$query2['hid']=$comment['hotel_id'];
			$query2['time']=$comment['UpdateTime'];
			$query2['content']=$comment['Content'];
			$query2['username']=preg_replace($pattern,$replacement,$comment['user_name']);
			$query2['comment_pic_text']=$this->model_config->renqun_ary($comment['renqun']);
			$query2['yinxiang_show']=explode(',',$comment['yinxiang']);
			switch($query2['comment_pic_text']){

    			case '其他':

    				$query2['comment_pic'] = 'dianping_01.gif';

    				break;

    			case '携带儿童的家庭':

    				$query2['comment_pic'] = 'dianping_02.gif';

    				break;

    			case '商务旅客':

    				$query2['comment_pic'] = 'dianping_03.gif';

    				break;

    			case '单独旅行者':

    				$query2['comment_pic'] = 'dianping_04.gif';

    				break;

    			case '户外探险旅行者':

    				$query2['comment_pic'] = 'dianping_05.gif';

    				break;

    			case '夫妇情侣':

    				$query2['comment_pic'] = 'dianping_06.gif';

    				break;

    			case '与朋友同行':

    				$query2['comment_pic'] = 'dianping_07.gif';

    				break;

    			case '与客户同行':

    				$query2['comment_pic'] = 'dianping_08.gif';

    				break;

    			case '家族旅游':

    				$query2['comment_pic'] = 'dianping_09.gif';

    				break;

    			case '带宠物':

    				$query2['comment_pic'] = 'dianping_10.gif';

    				break;

    			default :

    				$query2['comment_pic'] = 'dianping_01.gif';

    				$query2['comment_pic_text'] = '其他';

    		}
			
			$query3[]=$query2;
		}
		return $query3;
	}
	
	 public function get_user_list($start=10,$nums=2,$order='user_id desc',$where='')

    {

    	$query = $this->db->query("select * from $this->member_table $where order by $order,user_id desc limit $start,$nums")->result_array() ;


        return $query;

        

    }
	
	
	 public function get_jiangjin_list($start=10,$nums=2,$order='jj.id desc',$where='')

    {

    	$query = $this->db->query("select * from $this->jiangjin_table as jj left join $this->hotelorder_table as ho on jj.orderid=ho.orderID $where order by $order,jj.id desc limit $start,$nums")->result_array() ;


        return $query;

        

    }
	
	 function getjiangjinCount($where=array())
    {
    	$count = $this->db->where($where)->count_all_results($this->jiangjin_table);
    	return $count;
    }
	
	/**
     * 根据条件获取会员记录数
     * @param array $where 条件
     * @return int $count 记录数
     */
    function getMemberCount($where=array())
    {
    	$count = $this->db->where($where)->count_all_results($this->user_table);
    	return $count;
    }
	
	 /**

     * 获得管理员信息

     * @param int $username  管理员用户名

     * @return array $query 管理员信息数组

     */

    function get_userinfo($id,$type=1)

    {
		if($type==1){

    	$data = array('mobile_phone'=>$id);
		}
		else if($type==2){
			$data = array('user_id'=>$id);
		}

        $query = $this->db->where($data)->get($this->member_table)->row_array();



        return $query;

      

    }
	
	function get_explog_orderid($orderid,$IncomePayout)

    {
		
			$data = array('order_id'=>$orderid);
			$data = array('IncomePayout'=>$IncomePayout);
		
        $query = $this->db->where($data)->get($this->explog_table)->row_array();



        return $query;

      

    }
	
	function get_jiangjin_orderid($orderid)

    {
		
			$data = array('orderid'=>$orderid);
		
		
        $query = $this->db->where($data)->get($this->jiangjin_table)->row_array();



        return $query;

      

    }
	
	 function save_comment($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->comment_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('orderID',$data['orderID'])->update($this->comment_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->comment_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	
	 function save_jiangjin($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->jiangjin_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('id',$data['id'])->update($this->jiangjin_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->jiangjin_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	 function save_tixian($data,$method="insert",$where = '')

    {

    	if($method == 'insert'){

    		$query = $this->db->insert($this->tixian_table, $data);

    	}elseif ($method == 'update'){

    	    if (!$where) {

    	       $query = $this->db->where('id',$data['id'])->update($this->tixian_table, $data);   

    	    } else {

    	       $query = $this->db->where($where)->update($this->tixian_table, $data);      

    	    }

    		

    	}else{

    		return FALSE;

    	}

    	 

    	return $query;

    }
	
	public function get_tixian_list($start=10,$nums=2,$order='id desc',$where='')

    {

    	$query = $this->db->query("select * from $this->tixian_table $where order by $order,id desc limit $start,$nums")->result_array() ;


        return $query;

        

    }
	
	  function delmember($id)
    {
    	$result = $this->db->delete($this->member_table, "user_id in ($id)");
    	return $result;
    }

}

?>