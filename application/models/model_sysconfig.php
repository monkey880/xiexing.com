<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_sysconfig.php
 * 网站信息model
 * @date 2013-1-25
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */


class Model_sysconfig extends CI_Model
{
    private $config_table;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $db = (array) $this->db;
        $this->config_table = $db['dbprefix'].'sysconfig';
        $this->load->model('model_config');
    }
    
    /**
     * 获取网站信息
     * @return array $query 网站信息数组:varname字段的值为键,value字段的值为值的数组
     */
    public function getSysconfig()
    {
        $sql = " SELECT varname,value FROM {$this->config_table}";
        $query = $this->db->query($sql)->result_array();
        $returnArray = array();
        foreach($query as $key=>$val){  
            $returnArray[$val['varname']] = $val['value'];      
        }
        
        return $returnArray;
    }
    
    /**
     * 添加/修改
     * @param string $mode 
     * @param array $info 添加或者修改的数据\
     * @param array $where 查询条件
     * @return $rs
     */
    public function saveConfig($mode = 'insert',$info,$where=array())
    {
        if ($mode == 'insert') {
            $rs = $this->db->insert($this->config_table,$info);        
        } else {
            $rs = $this->db->update($this->config_table,$info,$where);      
        }
        return $rs;
    }
    
    /**
     * 获取一个系统配置参数信息
     * @param int $id  配置id
     * return array
     */
    public function getConfigInfo($id)
    {
        $rs = $this->db->query("SELECT * FROM $this->config_table WHERE sysid = $id LIMIT 0,1")->row_array();
        return $rs;
    }

    /**
     * 获取所有资讯
     * return article_class,pages
     */
    public function getConfigList()
    {
        $rs = $this->db->order_by('order DESC,sysid ASC')->get($this->config_table)->result_array();
        foreach ($rs AS $k => $v) {
            if ($v['type'] == 'select') {
                $select_option = null;
                    if ($v['varname'] == 'cfg_indexCitylist') {
                        $this->load->model('model_city');
                        //取省级名字
                        $province_ary = $this->model_city->getProvinceList();
                        //print_r($province_ary);return;
                        //把缩写和名字组合在一起
                        $province_array = array();
                        $select_option = '';
                        foreach ($province_ary AS $kkk => $vvv) {
                            $select_option .= '<option value="'.$vvv['province_id'].'">'.$vvv['province_name'].'</option>';
                        }
                        $rs[$k]['select'] = '<select id="province" onchange="rplCity(this.value)"><option value="0">--请选择--</option>' . $select_option . '</select>';
                        $rs[$k]['select'] .= ' 省/直辖市&nbsp;&nbsp;&nbsp;&nbsp;';
                        $rs[$k]['select'] .= "<select id='city' onchange='return changtag(this.value);'>";
                        $rs[$k]['select'] .= "<option selected='selected' value='0'>--请先选择城市--</option>";
                        $rs[$k]['select'] .= "</select> 城市/区域";
                        $citylist = explode(',', $v['value']);
                        $citylist_count = count($citylist);
                        $citylist_rs = null;
                        if ($citylist_count > 0) {
                            for ($i = 0; $i < $citylist_count; $i++) {
                                $cityitem = explode("|", $citylist[$i]);
                                $citylist_rs .= "<span ondblclick=\"return updatename(this,'$cityitem[1]')\" style='border:#CCC solid 1px;padding:3px;cursor:move;' value='{$cityitem[1]}' id='{$cityitem[0]}'>$cityitem[1]<em style='cursor:pointer' onclick=\"return delCity('".$cityitem[0]."');\">×</em></span>";
                            }
                        } else {
                            $cityitem = explode("|", $citylist[0]);
                            $citylist_rs = "<span ondblclick='return updatename(this,'{$cityitem[1]}')' style='border:#CCC solid 1px;padding:3px;cursor:move;' value='{$cityitem[1]}' id='{$cityitem[0]}'>{$cityitem[1]}<em style='cursor:pointer' onclick='return delCity({$cityitem[0]});'>×</em></span>";
                        }
                        $rs[$k]['select'] .= "<div id='cityList'>$citylist_rs</div>";
                        $rs[$k]['select'] .= "<input type='hidden' value='{$v['value']}' name='{$v['varname']}' id='{$v['varname']}' />";
                    }
                    if ($v['varname'] == 'cfg_apiurl') {
                        //接口地址
                        $cfg_apiurl_ary = $this->model_config->cfg_apiurl_ary();
                        $select_option = '';
                        foreach ($cfg_apiurl_ary as $key=>$val) {
                            $select_option .= '<option value="'.$key.'">'.$val.'</option>';   
                        }
                        $rs[$k]['select'] = '<select name="' . $v['varname'] . '" id="' . $v['varname'] . '">' . $select_option . '</select>';
                    }
                
            } elseif ($v['type'] == 'radio') {
                if ($v['varname'] != 'cfg_rewrite') {
                    $radio_option_ary = explode('{|}', $v['item']);
                    $cbox = null;
                    //遍历item值
                    foreach ($radio_option_ary AS $kk => $vv) {
                        $radio_option_array = explode(':', $vv);
                        $checked = $radio_option_array[1] == $v['value'] ? 'checked' : null;
                        if($v['varname'] == 'cfg_servertype')
                        {
                        	$cbox .= "<input type='radio' name='{$v['varname']}' id='{$v['varname']}' onclick='getrewrite({$radio_option_array[1]})' value='{$radio_option_array[1]}' {$checked} {$v['nameaction']} />&nbsp;{$radio_option_array[0]}";
                        }else{
                        	$cbox .= "<input type='radio' name='{$v['varname']}' value='{$radio_option_array[1]}' {$checked} {$v['nameaction']} />&nbsp;{$radio_option_array[0]}";
                        }
                        
                    }
                    $rs[$k]['radio'] = $cbox;    
                } else {
                    unset($rs[$k]);
                }
                
            }
        }
        return $rs;
    }

}
?>