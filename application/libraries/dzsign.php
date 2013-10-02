<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 



class Dzsign {

	

	static function mySign($para)
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = self::paraFilter($para);
    
        //对待签名参数数组排序
        $para_sort = self::argSort($para_filter);
    
        //生成签名结果
        $mysign = self::buildMysign($para_sort);
    
        return $mysign;
    
    }
    static function paraFilter($para) {
        $para_filter = array();
        foreach($para as $key=>$value){
            if($key == "appkey" || $value='')continue;
            else    $para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }
    static function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
    static function buildMysign($sort_para) {
        //把数组所有元素，按照"参数=参数值"的模式用"&"字符拼接成字符串
        $prestr = self::createLinkstring($sort_para);
        //把拼接后的字符串再与安全校验码直接连接起来
        $prestr = DZ_APPKEY.$prestr.DZ_APPSECRET;
        //把最终的字符串签名，获得签名结果
        $mysign = strtoupper(sha1($prestr));
		$myurl=self::createqueryString($sort_para);
        return $mysign.$myurl;
    }
	
    static function createLinkstring($para) {
        $arg  = "";
        foreach ($para as $key=>$value){
            $arg .= $key.$value;
			$queryString .=('&'.$key.'='.urlencode($val));
        }
       
        return $arg;
    }
	
	static function createqueryString($para) {
        $queryString  = "";
        foreach ($para as $key=>$value){
            
			$queryString .=('&'.$key.'='.urlencode($value));
        }
       
        return $queryString;
    }
	
	
}
	

	



