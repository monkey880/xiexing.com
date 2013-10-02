<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID Model_admin.php
 * 管理员model
 * @date 2013-1-29 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_admin extends CI_Model
{
	private $admin_table;
	
	function __construct()
	{
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->admin_table = $db['dbprefix'].'admin';
        $this->purview_table = $db['dbprefix'].'purview';
        $this->usergroup_table = $db['dbprefix'].'usergroup';
    }
    
    /**
     * 获得管理员信息
     * @param int $username  管理员用户名
     * @return array $query 管理员信息数组
     */
    function get_userinfo($username)
    {
    	$data = array('username'=>$username);
        $query = $this->db->where($data)->get($this->admin_table)->row_array();

        return $query;
      
    }
    
    /**
     * 获得管理员信息
     * @param int $managerId  管理员id
     * @return array $managerInfo 管理员信息数组
     */
    public function getManagerInfo($id)
    {
    	$managerInfo = $this->db->where('id',$id)->get($this->admin_table)->row_array();
    	//处理显示信息
    	$admintype_array = $this->getAdminType(2);
    	$managerInfo['typename'] = $admintype_array[$managerInfo['rank']];
    	$managerInfo['time'] = date('Y-m-d H:i:s', $managerInfo['logintime']);
    
    	return $managerInfo;
    }
    
    /**
     * 获得管理员列表
     * @param int $start  从第几条记录开始
     * @param int $num 要调用的条数
     * @param array $where 查询条件数组
     * @param string $order 要排序的字段
     * @return array $managerList 管理员列表数组
     */
    public function getManagerList($start=0,$nums=10,$where=array(),$order='id')
    {
    	$managerList = $this->db->where($where)->limit($nums,$start)->order_by($order,'desc')->get($this->admin_table)->result_array() ;
    	//处理显示信息
    	$admintype_array = $this->getAdminType(2);
    	foreach ($managerList AS $key => $val) {
    		$managerList[$key]['typename'] = $admintype_array[$val['rank']];
    		$managerList[$key]['time'] = date('Y-m-d H:i:s', $val['logintime']);
    	}
    
    	return $managerList;
    }
    
    /**
     * 获得管理员级别
     * @param int $returnType返回类型：1-管理员级别列表；2-管理员级别为键，管理员名称为值的关联数组
     * @return array $adminList 管理员列表数组
     */
    public function getAdminType($returnType = 1)
    {
    	$adminList = $this->db->order_by('id','ASC')->get($this->usergroup_table)->result_array();
    	if ($returnType == 2) {
    		$admintype_array = array();
    		foreach ($adminList as $val) {
    			$admintype_array[$val['id']] = $val['title'];
    		}
    		$adminList = $admintype_array;
    	}
    
    	return $adminList;
    }
    
    /**
     * 根据条件获取管理员记录数
     * @param array $where 条件
     * @return int $count 记录数
     */
    function getManagerCount($where=array())
    {
    	$count = $this->db->where($where)->count_all_results($this->admin_table);
    	return $count;
    }
    
    /**
     * 删除一条或几条管理员
     * @param int $managerId 新闻id
     * @return int $result 受影响行数
     */
    function delManager($id)
    {
    	$result = $this->db->delete($this->admin_table, "id in ($id)");
    	return $result;
    }
    
    /**
     * 添加/修改
     * @param string $mode
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function addManager($mode = 'insert',$info,$where=array())
    {
    	if ($mode == 'insert') {
    		$rs = $this->db->insert($this->admin_table,$info);
    	} else {
    		$rs = $this->db->update($this->admin_table,$info,$where);
    	}
    	return $rs;
    }
    
    /**
     * 验证用户名
     * @param string $username  用户名
     * @param string $id 用户id
     * @return $count
     */
    public function checkManageName($username,$id)
    {
    	$where = array('username'=>$username);
    	if ($id != 0) {
    		$where['id <>'] = $id;
    	}
    
    	return $count = $this->db->where($where)->count_all_results($this->admin_table);
    }
   
   /**
     * 获得权限菜单列表
     * @param array $where 查询条件数组
     * @param string $order 要排序的字段
     * @return array $purviewList 管理员列表数组
     */
    public function getpurviewList($where=array(),$order='listorder',$extWhere = '')
    {
        if($extWhere){
            foreach ($extWhere as $key=>$val) {
                $this->db->where_in($key, $val);   
            }    
        }
    	return $purviewList = $this->db->where($where)->order_by($order,'asc')->get($this->purview_table)->result_array() ;
    }
    
    /**
     * 获得菜单详情
     * @param int $id 
     * @return array $managerInfo 
     */
    public function getPurviewInfo($id)
    {
    	return $purviewInfo = $this->db->where('id',$id)->get($this->purview_table)->row_array();
    }
    
    /**
     * 删除权限列
     * @param int $id 
     * @return int $result
     */
    function delPurview($id)
    {
    	$result = $this->db->delete($this->purview_table, "id in ($id)");
    	return $result;
    }
    
    function getSingleFunc($url,$func,$extra=false)
    {
		$extra = $extra?',\''.$extra.'\'':'';
		$resstr='<a href="javascript:submitTo(\''.$url.'\',\''.$func.'\''.$extra.')" class=\''.$func.'\'></a>';
		return $resstr;
	}
    
    /**
     * 添加/修改
     * @param string $mode
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function addPurview($mode = 'insert',$info,$where=array())
    {
    	if ($mode == 'insert') {
    		$rs = $this->db->insert($this->purview_table,$info);
    	} else {
    		$rs = $this->db->update($this->purview_table,$info,$where);
    	}
    	return $rs;
    }
    
    /*          用户组用到的方法          */
    /**
     * 获得权限菜单列表
     * @param array $where 查询条件数组
     * @param string $order 要排序的字段
     * @return array $usergroupList 管理员列表数组
     */
    public function getusergroupList($where=array(),$order='listorder')
    {
    	return $usergroupList = $this->db->where($where)->order_by($order,'asc')->get($this->usergroup_table)->result_array() ;
    }
    
    /**
     * 获得菜单详情
     * @param int $id 
     * @return array $managerInfo 
     */
    public function getUsergroupInfo($id)
    {
    	return $usergroupInfo = $this->db->where('id',$id)->get($this->usergroup_table)->row_array();
    }
    
    /**
     * 删除权限列
     * @param int $id 
     * @return int $result
     */
    function delUsergroup($id)
    {
    	$result = $this->db->delete($this->usergroup_table, "id in ($id)");
    	return $result;
    }
    
    /**
     * 添加/修改
     * @param string $mode
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function addUsergroup($mode = 'insert',$info,$where=array())
    {
    	if ($mode == 'insert') {
    		$rs = $this->db->insert($this->usergroup_table,$info);
    	} else {
    		$rs = $this->db->update($this->usergroup_table,$info,$where);
    	}
    	return $rs;
    }
    
    ////////////权限验证///////////////////
    function checkPurviewFunc($class,$method='index'){
		if($this->isPurview($class,$method)==200){
			return true;
		}else{
			return false;
		}
	}
	
	function isPurview($class,$method){
		$CI =& get_instance();
		$CI->load->library('session');
            
		$userinfo_session=$CI->session->userdata('userinfo');
        $userid = $userinfo_session['id'];
        
        $userinfo = $this->getManagerInfo($userid) ;
        $usergroupid = $userinfo['rank'];
        
		if($usergroupid==1){
			return 200;
		}
		if(!$usergroupid){
			return 201;
		}
        
        $adminTypeArr = $this->getUsergroupInfo($usergroupid);
        if ($adminTypeArr['status'] != 1) {
            return 205; 
        }
		$purview = $this->getPurview($usergroupid);

		if(!isset($purview[1][$class])){
			return 202;
		}
		if($method=='index'){
			return 200;
		}
		if(in_array($method,$purview[1][$class]['method'])){
			return 200;
		}
		return 202;
	}
	
	function getPurview($usergroupid){
		$row = $this->getUsergroupInfo($usergroupid);
		$purview = unserialize($row['purview']);
		if($row['isupdate']==1){
			if($purview[0]){
				$arr = $this->getpurviewList(array('status'=>1),'listorder',array('id'=>$purview[0]));
				$newpurviewid = array();
				$newpurviewarr = array();
				foreach($arr as $key=>$item){
					$newpurviewid[] = $item['id'];
					$newpurviewarr[$item['class']]['id'] = $item['id'];
					$newpurviewarr[$item['class']]['class'] = $item['class'];
					$newpurviewarr[$item['class']]['method'] = $purview[1][$item['class']]['method'];
					$grouppurview[$item['parent']][] = $item;
					if($item['parent']==0){
						$parentpurview[$item['id']] = $item;
					}
				}
				$purview = array(0=>$newpurviewid,1=>$newpurviewarr,2=>$grouppurview,3=>$parentpurview);
				$data = array('purview'=>serialize($purview),'isupdate'=>0);
                $this->addUsergroup($mode = 'update',$data,array('id'=>$usergroupid));
				return $purview;
			}else{
				return $purview;
			}
		}else{
			return $purview;
		}
	}
    
    function resetPurview(){
		$upgroupdata = array('isupdate'=>1);
		$this->addUsergroup($mode = 'update',$upgroupdata,$where=array());
	}
    
}
?>