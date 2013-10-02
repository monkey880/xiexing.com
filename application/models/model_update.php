<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_update.php
 * 升级model
 * @date 2013-1-25
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */


class Model_update extends CI_Model
{
    private $config_table;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->dbprefix = $db['dbprefix'];
    }
    
    public function insert_zhuna_sysconfig()
    {
        $sql = "REPLACE INTO `".$this->dbprefix."sysconfig` (`sysid`, `varname`, `info`, `type`, `value`, `item`, `nameaction`, `help`, `order`) VALUES (13, 'cfg_cache', '缓存开关', 'radio', '1', '打开:1{|}关闭:0', '', '', 0);";
        return  $query = $this->db->query($sql);
    }
}
?>