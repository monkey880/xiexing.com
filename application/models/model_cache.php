<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_cache.php
 * 清理缓存model
 * @date 2013-3-6
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_cache extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->cacheDir = ROOTPATH.DIRECTORY_SEPARATOR."data\cache";
    }
    
    /**
     * 获得清理缓存信息
     * @return array $result 缓存文件数组
     */
    public function getCacheList()
    {
        $filesize_count = 0;
        $filesize_size = 0;
        $cache_array = array(
            'comment文件夹' => $this->cacheDir . '\comment',
            'expo文件夹' => $this->cacheDir . '\expo',
            'hotel文件夹' => $this->cacheDir . '\hotel',
            'lable文件夹' => $this->cacheDir . '\lable',
        );
        foreach ($cache_array AS $k => $v) {
            $dir_array = $this->getDirSize($v);
            $rs[$k]['dir_size'] = round($dir_array[0] / 1024 / 1024, 3);
            $rs[$k]['dir_count'] = $dir_array[1];
            $rs[$k]['dir_name'] = $k;
            $rs[$k]['dir_dir'] = $v;
            $filesize_count += $dir_array[1];
            $filesize_size += $rs[$k]['dir_size'];
        }
        $result = array('filesize_count' => $filesize_count, 'filesize_size' => $filesize_size, 'cache_array' => $rs);
        return $result;
    }
    
    
    /**
     * 取文件夹内文件大小
     * @param <type> $dir
     * @return <type>
     */
    public function getDirSize($dir)
    {
        $size = 0;
        $count = 0;
        $ardir = @scandir($dir);
        if (is_array($ardir)) {
            foreach ($ardir as $i) {
                if (is_file($dir . "/" . $i)) {
                    $size+=filesize($dir . "/" . $i);
                    $count += 1;
                }

                if ($i != "." && $i != ".." && is_dir($dir . "/" . $i)) {
                    $dir_info_array = $this->getDirSize($dir . "/" . $i);
                    $size+=$dir_info_array[0];
                    $count+=$dir_info_array[1];
                }
            }
        }
        return array($size, $count);
    }
    
    public function delCacheList($dir)
    {
        $del = true;
        foreach ($dir AS $v) {
            if (is_dir($this->cacheDir.$v)) {
                $del .= $this->deldir($this->cacheDir.$v).'&&';        
            }
        }
        return rtrim($del,'&&');
        if (rtrim($del,'&&')) {
            return 1;
        } else {            
            return 0;
        }
    }
    
    /**
     * 删除非空文件夹
     * @param $dir;
     * return
     */
    public static function deldir($dir)
    {
        $dh = opendir($dir);
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..' && $file != '.svn') {
                is_dir($dir . '/' . $file) ?
                                self::deldir($dir . '/' . $file) :
                                unlink($dir . '/' . $file);
            }
        }
        if (readdir($dh) == false) {
            closedir($dh);
            if (rmdir($dir)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>