<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID data.php
 * 携行酒店分销联盟（后台数据备份/还原）模块
 * @date 2013-3-7
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Data extends CI_Controller 
{
    
	private $userinfo;
    private $backDir;
    private $tablefunc = 'data';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('userinfo')){
        	redirect(CFG_ADMINURL.'/login');
        }
        $this->userinfo = $this->session->userdata('userinfo');
        
        $this->load->model('model_data');
        $this->load->helper('form');
        $this->load->model('model_admin');
        
        $this->backDir = ROOTPATH.DIRECTORY_SEPARATOR."data/backup";
        
    }
    
    public function index()
    {  
        $data = array();
        
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        $isadd = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;
        $data['operate'] = array('isadd'=>$isadd);
        
        $tableList = $this->model_data->getTableList();
        $mysql_version = $this->db->version();//数据库版本
        
        $data['method'] = $this->uri->segment(2) ;      
        $data['tableList'] = $tableList ;   
        $data['mysql_version'] = $mysql_version ;
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_databack',$data);
    }
    
    /**
     * 执行备份
     */
    public function doback()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'add')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        @set_time_limit(0);
        $tableArr = $this->input->post('tablearr', TRUE);  //选择的表名数组
        $startpos = !$this->input->post('startpos', TRUE) ? '0' : $this->input->post('startpos', TRUE);  //startpos一个表的分表娄
        $isstruct = !$this->input->post('isstruct', TRUE) ? '0' : $this->input->post('isstruct', TRUE);  //isstruct
        $fsize = !$this->input->post('fsize', TRUE) ? '2048' : $this->input->post('fsize', TRUE);  //fsize
        $datatype = !$this->input->post('datatype', TRUE) ? '4.1' : $this->input->post('datatype', TRUE);  //datatype
        $start_count = !$this->input->post('start_count', TRUE) ? '0' : $this->input->post('start_count', TRUE);  //start_count
        $limit_do_count = !$this->input->post('limit_do_count', TRUE) ? '0' : $this->input->post('limit_do_count', TRUE);  //limit_do_count
        
        if (empty($tableArr)) {
        	echo "<script>alert('你没选中任何表！')</script>";
        	exit;
        }
        $rt = $this->model_data->doBackupData($tableArr, $startpos, $isstruct, $fsize, $datatype, $start_count, $limit_do_count);
        $this->dump($rt);
    }
    
    /**
     * 还原页面
     */
    public function revert()
    {
        $data = array();
        
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;
        $data['operate'] = array('isdel'=>$isedit);
        
        $filelists = Array();
        
        $this->dh = @dir($this->backDir);
        $filename = @$this->dh->read();
        while (($filename = @$this->dh->read()) !== false) {
            if ($filename != '.' && $filename != '..')
                $filelists[] = $filename;
        }
        $this->dh->close();
        
        $data['method'] = $this->uri->segment(3) ; 
        $data['action'] = '';     
        $data['filelists'] = $filelists ;   
        $data = array_merge($data,$this->userinfo);
        
        $this->load->view('admin/admin_datarevert',$data);
    }
    
    /**
     * 还原表list
     */
    public function revertlist()
    {
        $data = array();
        
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc)?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        $isedit = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;
        $data['operate'] = array('isedit'=>$isedit);
        
        $path = $this->uri->segment(4);
        $backDir = $this->backDir . '/' . $path;
        if ($path == "") {
            echo "<script>alert('请选择还原日期')</script>";
            exit;
        }
        if (!$dh = @dir($backDir)) {
            echo "<script>alert('没找到{$path}的备份数据')</script>";
            exit;
        }
        $structfile = "没找到数据结构文件";
        $filelists = array();
        while (($filename = $dh->read()) !== false) {
            if (!preg_match('/txt$/', $filename)) {
                continue;
            }
            if (preg_match('/tables_struct/', $filename)) {
                $structfile = $filename;
            } else if (filesize("$backDir/$filename") > 0) {
                $filelists[] = $filename;
            }
        }
        $dh->close();
        $data['path'] = $path;
        $data['filelists'] = $filelists;
        $data['action'] = 'do';
        $data['structfile'] = $structfile;
        $data = array_merge($data,$this->userinfo);
        $this->load->view('admin/admin_datarevert',$data);
    }
    
    /**
     * 执行还原
     */
    public function dorevert()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'edit')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        
        @set_time_limit(0);
        $this->model_data->doRevertData();
        $rt = $this->dump($this->model_data->doRevertData());
        $this->dump($rt);        
    }
    
            
    /**
     * 执行删除
     */
    public function delete()
    {
        $isoperate = $this->model_admin->checkPurviewFunc($this->tablefunc,'del')?true:false;   
	    if (!$isoperate) {
           echo '<script>alert("'.'没有权限'.'");location = "'.site_url('/'.CFG_ADMINURL.'/main').'";</script>';
	       die();   
	    }
        $backfile = !empty($_POST['backfile']) ? $_POST['backfile'] : '';
        if ($backfile == '') {
            echo "<script>alert('没指定任何要删除的备份文件！')</script>";
            exit;
        }
    	if (!empty($backfile)) {
    		$result = $this->model_data->delData($backfile);;
    		if ($result) {
    			redirect(CFG_ADMINURL.'/data/revert');
    		} else {
    			redirect(CFG_ADMINURL.'/data/revert');
    		}
    	}
        
        
    } 

}