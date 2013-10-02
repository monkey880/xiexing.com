<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 


/**
 * 
 * @ID tool.php
 * 携行酒店分销联盟常用函数
 * @date 2013-1-23 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Tool {

	/**
	 * 酒店图片组合成数组
	 * @param string $hotelpictures 酒店图片文本
	 * @return array 图片数组
	 */ 
	function hpicshow($hotelpictures,$limit=5)
	{
	    $limit = 5;
	    $hotelpictures_array = explode('@_@', $hotelpictures);
	    $pic_ary = explode(',', $hotelpictures_array[0]);
	    $result = array();
	    foreach ($pic_ary AS $k => $v) {
	        if ($k >= $limit)
	            continue;           
	        $pic_array = explode(':', $v);
	        $pic_all_array = explode('|', $pic_array[1]);
	        $result[$k]['pic_name'] = $pic_array[0];
	        $result[$k]['pic_thumb_url'] = 'http://p.zhuna.cn'.$pic_all_array[0];
	        $result[$k]['pic_url'] = 'http://p.zhuna.cn'.$pic_all_array[1];
	
	    }
	    return $result;
	}
	
	function hpicshow2($hotelpictures,$hotelname)
	{
	    $limit = 5;
	   
	    $pic_ary = explode(',', $hotelpictures);
	    $result = array();
	    foreach ($pic_ary AS $k => $v) {
	        if ($k >= $limit)
	            continue;           
	        if($v){
	        $result[$k]['pic_name'] = $hotelname;
	        $result[$k]['pic_thumb_url'] = $v;
	        $result[$k]['pic_url'] = $v;
			}
	
	    }
	    return $result;
	}
	
	/**
	 * 酒店客人印象标签
	 * @param string $tags
	 * @return array
	 */
	function tags_ary($tags)
	{
	    if (!empty($tags)) {
	        $tags = rtrim($tags,',');
	        $tags = str_replace('$', ',', $tags);
	        $tags_ary = explode(',', $tags);
	    } else {
	        $tags_ary = '';
	    }
	    return $tags_ary;
	}
	
	
	/**
	 * 格式化服务设施
	 * @param string $idstr 服务设施文本
	 * @return string
	 */
	function Select_Info($idstr)
	{
	    $str_count = strlen($idstr);
	    $find_str = strrpos($idstr, ",");
	    if ($find_str + 1 == $str_count) {
	        $idstr = substr($idstr, 0, $str_count - 1);
	    }
	    $idstr = str_replace(",,", "", $idstr);
	    $idstr = str_replace(",", "、", $idstr);
	    return $idstr;
	}
	
	
	/**
	 * 取星级
	 * @param int $rank 星级数据
	 * @return 星级数字 
	 */ 
	function hotelranknamenum($rank)
	{
	    if ($rank > 6 and $rank < 17) {
	        $hotelranknamenum = 2; //经济型
	    } elseif ($rank > 4 and $rank < 7) {
	        $hotelranknamenum = 3; //舒适型
	    } elseif ($rank > 2 and $rank < 5) {
	        $hotelranknamenum = 4; //高档型
	    } elseif ($rank > 0 and $rank < 3) {
	        $hotelranknamenum = 5; //豪华型
	    } else {
	    	$hotelranknamenum = 0; 
	    }
	    return $hotelranknamenum;
	}
	
	
	/**
	*取星级名称
	*/
	function hotelrankname($rank)
	{
	        If ($rank > 6 and $rank < 17) {
	            $hotelrankname = "二星级"; //经济型
	        } ElseIf ($rank > 4 and $rank < 7) {
	            $hotelrankname = "三星级"; //舒适型
	        } ElseIf ($rank > 2 and $rank < 5) {
	            $hotelrankname = "四星级"; //高档型
	        } ElseIf ($rank > 0 and $rank < 3) {
	            $hotelrankname = "五星级"; //豪华型
	        } Else {
	           $hotelrankname = "暂无星级信息";  
	        }
            
            
	        return $hotelrankname;
	 }
	
	 
	/**
	 * 取得常用价格区间
	 * @return multitype:string
	 */
	function get_price_array()
	{
	    return array('0-200' => '￥200元以下', '200-300' => '￥200-￥300', '300-400' => '￥300-￥400', '400-500' => '￥400-￥500', '500-0' => '￥500元以上');
	}
	
	
	 /**
	  * 获取用户访问过的酒店列表
	  */
	function get_user_hotel_history()
	{
	    $hotel_str = '';
	    $hote_list = array();
	    if(isset($_COOKIE['zhuna_union_hotel_history']) && !empty($_COOKIE['zhuna_union_hotel_history'])){
	        
	        $list = explode('|',$_COOKIE['zhuna_union_hotel_history']);
	        foreach ($list as $key => $v){
	            if($key > 10)
	                break;
	            $hotel_str = explode(',',$v);
	            $hotel_list[$hotel_str[0]] = $hotel_str[1];
	        }
	    }
	    
	    return $hotel_list;
	}
	 
	 /**
	 * 截取中文字符串
	 * Utf-8、gb2312都支持的汉字截取函数
	 * cut_str(字符串, 截取长度, 开始长度, 编码);
	 * 编码默认为 utf-8
	 * 开始长度默认为 0
	 */
	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
	{
	    if ($code == 'UTF-8') {
	        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	        preg_match_all($pa, $string, $t_string);
	
	        if (count($t_string[0]) - $start > $sublen)
	            return join('', array_slice($t_string[0], $start, $sublen)) . "...";
	        return join('', array_slice($t_string[0], $start, $sublen));
	    }
	    else {
	        $start = $start * 2;
	        $sublen = $sublen * 2;
	        $strlen = strlen($string);
	        $tmpstr = '';
	
	        for ($i = 0; $i < $strlen; $i++) {
	            if ($i >= $start && $i < ($start + $sublen)) {
	                if (ord(substr($string, $i, 1)) > 129) {
	                    $tmpstr.= substr($string, $i, 2);
	                } else {
	                    $tmpstr.= substr($string, $i, 1);
	                }
	            }
	            if (ord(substr($string, $i, 1)) > 129)
	                $i++;
	        }
	        if (strlen($tmpstr) < $strlen)
	            $tmpstr.= "...";
	        return $tmpstr;
	    }
	}
	  
	
	
    /**
     * 创建缓存文件
     * @param unknown_type $remote
     * @param unknown_type $cachepath
     * @param unknown_type $cachename
     * @param unknown_type $checktime
     */
    function create_cache($remote, $cachepath, $cachename, $checktime = 259200)
    {
        $rs = "" ;
        $cache = $cachepath . $cachename;  //xml接口的本地路径+文件全名
        if (CFG_CACHE) {
            if (self::check_cache($cache, $checktime)) {
                self::CreateFolder($cachepath);
                $content = file_get_contents($remote);
                if (strlen($content) > 1024) {
                   file_put_contents($cache, $content);
                }
                $rs = $content;
            }else{
                $rs = file_get_contents($cache);
            }
        } else {
            $rs = file_get_contents($remote);    
        }
        
        return $rs;
    }
	
	
	/**
	 * 检查缓存文件是否过期
	 * @param unknown_type $cache_file
	 * @param unknown_type $time
	 * @return string|string|string|string
	 */
	function check_cache($cache_file, $time)
	{
	    if (file_exists($cache_file)) {
	        if (filesize($cache_file) == 0)
	            return true;
	            $creat_time = filemtime($cache_file);    //查看本地xml接口文件的修改时间            
	            $time_diff = time() - $creat_time;         //与现在时间的时差
	            //如果时间差大于2592000 (1个月)就重新生成一下
	            if ($time_diff > $time) {
	                return true;
	            } else {
	                return false;
	            }
	        } else {
	            return true;
	       }
	}
	
	/**
	 * 循环创建目录创建目录 递归创建多级目录
	 * @param $dir 要创建的目录
	 * @param $mode 文件属性
	 */
	function CreateFolder($dir, $mode = 0777)
	{
	    if (is_dir($dir) || @mkdir($dir, $mode))
	        return true;
	        if (!self::CreateFolder(dirname($dir), $mode))
	            return false;
	        return @mkdir($dir, $mode);
	}
	
    /**
     * 获取页面分页信息
     *
     * @param int $page 当前页面编号
     * @param int $record_count 记录总数
     * @return array
     * @author testYang
     */
    public function get_page_info($page, $record_count, $page_size = 10)
    {
        $num = $page * $page_size;
        $start = $num - $page_size;
        $page_count = ceil($record_count / $page_size);
        return array(
                'page_size'     => $page_size,
                'num'           => $num,
                'start'         => $start,
                'page_count'    => $page_count > 0 ? $page_count : 1,
                'record_count'  => $record_count,
                'current_page'  => $page);
    }
    /**
     * 处理点评信息
     *
     * @param $dianping,$sort返回类型:1返回好中差的数组,2返回好评率,3
     * @return mixed $rt
     */
    public function hoteldianping ($dianping,$sort = 1)
    {
        $dianpingArr = explode('$',$dianping);  
        $totaldanping = (int) array_sum($dianpingArr);
        $dianpingArr [3] = $totaldanping; 
        $haoping = 0;       
        if ($sort == 1 ) {
            return $rt = $dianpingArr;  
        } else if($sort == 2) {
            if ($totaldanping != 0) {
                $haoping = floor($dianpingArr[0]*100/$totaldanping).'%';     
            } 
            return $rt = array($haoping,$dianpingArr);   
        } else if($sort == 3) {
            if ($totaldanping != 0) {
                $haoping = floor(($dianpingArr[0]+$dianpingArr[1])*50/$totaldanping)*0.1;   
            }
            return $rt = array($haoping,$dianpingArr);  
        }
    }
    
    /**
     * 替换页面中有指定关键词的链接
     * @param unknown_type $isrewrite
     */
    function zhuna_rewrite($isrewrite)
    {
        if($isrewrite ){
            $content = ob_get_contents();
            
            $rewrite_org = array("/allcity/","/allcity.html","/onecity/","/onecity.html","/newsinfo/","/newsinfo.html","/news/","/news.html","/expo/","/expo.html","/expoinfo/","/expoinfo.html","/hotelinfo/","/hotelinfo.html","/lable/","/lable.html","/ehc/","/ehc.html","/help/","/help.html","/comment/","/comment.html","/ask/","/ask.html","/member/","/member.html","/hotellist/","/hotellist.html");
            $rewrite_new = array("/allcity/","/allcity.html","/onecity/","/onecity.html","/newsinfo/","/newsinfo.html","/news/","/news.html","/expo/","/expo.html","/expoinfo/","/expoinfo.html","/hotelinfo/","/hotelinfo.html","/lable/","/lable.html","/ehc/","/ehc.html","/help/","/help.html","/comment/","/comment.html","/ask/","/ask.html","/member/","/member.html","/hotellist/","/hotellist.html");
            
            $html = str_replace($rewrite_org, $rewrite_new, $content);     
            ob_end_clean();
            echo $html;  

        }else{
            return ;
        }
    }
    
   
    /**
     * 处理问答中的相关字符串
     * @param array $arr
     */
    function change_array($questionList)
    {
   		foreach ($questionList as $key=>$val) {
        	$questionList[$key] = str_replace(array('住哪网','http://www.zhuna.cn/','www.zhuna.cn','http://www.zhuna.cn','hotel-','400-666-5511'),array(CFG_WEBNAME,CFG_INDEXURL,CFG_INDEXURL,CFG_INDEXURL,'hotelinfo/','400-600-2069'),$val);
			
        	$questionList[$key] = preg_replace('/\.html([^，]*)/','',$questionList[$key]);
        }
        return $questionList;
    }  
      
}

