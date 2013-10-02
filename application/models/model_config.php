<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 *

 * @ID model_config.php

 * 整个网站的Utility  Option Radio Checkbox 数组Config文件 Model

 * @date 2013-1-25

 * @author yuhailong zjj008@gmail.com

 * @copyright zhuna Inc , all rights reserved

 *

 */



class Model_config extends CI_Model

{

    /**

     * hotellist 酒店预定搜索价格范围

     */

    public function price_ary()

    {

        $rs = array('1-200' => '￥200元以下', '200-300' => '￥200-￥300', '300-400' => '￥300-￥400', '400-500' => '￥400-￥500', '500-3000' => '￥500元以上');

        return $rs;

    }



    /**

     * hotellist 酒店搜索星级档次

     */

    public function rank_ary()

    {

        $rs = array('2'=>'经济型', '3'=>'三星级', '4'=>'四星级', '5'=>'五星级');

        return $rs;

    }
	
	public function server_ary()

    {

        $rs = array('商务中心','叫醒服务','洗衣服务','前台贵重物品保险柜','免费停车场','公共区域免费Wi-Fi','大床','双床','三床','套房','上网','停车场','刷卡');

        return $rs;

    }


public function card_ary()

    {

        $rs = array('Visacard','牡丹卡','金穗卡','长城卡','龙卡','太平洋卡');

        return $rs;

    }
    

    /**

     * 文章中推荐

     * return Boole

     */

    public function state_radio_ary()

    {

    	$rs = array('1' => '正常', '2' => '停止', '3' => '推荐', '4' => '图片推荐');

    	return $rs;

    }

    

    /**

     * 广告类型

     */

    public function ad_type_radio_ary()

    {

    	$rs = array('1' => '文字', '2' => '上传图片', '3' => 'Google百度等广告代码');

    	return $rs;

    }

    

    /**

     * 广告状态

     */

    public function ad_state_radio_ary()

    {

    	$rs = array('1' => '正常', '2' => '永久', '3' => '停止');

    	return $rs;

    }

    

     /**

     * 友情链接类型

     */

    public function flink_type_radio_ary()

    {

    	$rs = array('1' => '文字', '2' => '上传图片', '3' => '外部图片链接');

    	return $rs;

    }

      /**

     * 酒店来源类型

     */

    public function soure_radio_ary()

    {

    	$rs = array('1' => '住那网', '9' => '本站');

    	return $rs;

    }
	
	 /**

     * 优惠类型

     */

    public function youhui_radio_ary($youhui='')

    {

    	$rs = array('1' => '住七送一', '2' => '住六送一','3'=>'免费接送');

    	 if ($youhui !== '') {

            return  $rs[$youhui] ;       

        }

    	return $rs;

    }
	
	 public function fanxian_status_ary($youhui='')

    {

    	$rs = array('0' => '处理中', '1' => '失败','2'=>'成功','3'=>'已退');

    	 if ($youhui !== '') {

            return  $rs[$youhui] ;       

        }

    	return $rs;

    }
	
	 public function order_type_ary($status)

    {

    	$rs = array('0' => '酒店订单', '1' => '试住房订单');
		
		 if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }
	
	
	 public function get_gift_ary($status)

    {

    	$rs = array('0' => '审核中', '1' => '审核通过', '2' => '已发货', '3' => '已领取', '4' => '审核不通过', '5' => '无效');
		
		 if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }
	
		 public function explog_type_ary($status)

    {

    	$rs = array('1' => '收入', '2' => '支出');
		
		 if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }
	
	 public function product_type_ary($status)

    {

    	$rs = array('0' => '普通商品', '3' => '免费礼品', '2' => '积分礼品');
		
		 if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }
	
	 public function product_order_state($status)

    {

    	$rs = array('0' => '审核中', '1' => '审核通过', '2' => '已发货', '3' => '已领取', '9' => '已失效');
		
		 if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }




    /**

     * 启用状态

     */

    public function status_ary($status = '')

    {

    	$rs = array('1' => '启用', '0' => '<font color="red">禁用</font>');

        if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }

    /**

     * 启用状态

     */

    public function hotelorder_status_ary($status = '')

    {

    	$rs = array('0' => '处理中', '1' => '预定成功', '2' => '已入住','3' => '已结束', '4' => '客人未到','9' => '无效订单');

        if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }
	
	 public function renqun_ary($status = '')

    {

    	$rs = array('0' => '商务旅客', '1' => '单独旅行者', '2' => '夫妇情侣', '3' => '与朋友同行', '4' => '家族旅游', '5' => '带宠物', '6' => '携带儿童的家庭', '7' => '其他');

        if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }
	
	public function comment_ary($status = '')

    {

    	$rs = array('0' => '好评', '1' => '中评', '2' => '差评');

        if ($status !== '') {

            return  $rs[$status] ;       

        }

    	return $rs;

    }



public function yinxiang_ary()

    {

    	$rs = array('近市中心','安静','舒适','出行方便','经济','繁华地区','破旧','一般','有点难找','隔音太差','设施陈旧','优质服务','高性价比','很干净','温馨','超值','拥挤','服务欠佳','年久待修','不推荐住','喜欢','','个性','惊喜','优雅','宽敞','时尚');

       

    	return $rs;

    }

     /**

     * 常用操作

     */

    public function operate_ary($operate = '')

    {

    	$rs = array('btn_add' => '添加', 'btn_edit' => '编辑','btn_del' => '删除',);

        if ($operate !== '') {

            return  $rs[$operate] ;       

        }

    	return $rs;

    }
	
	 public function categor_pinyin_ary($operate = '')

    {

    	$rs = array('jiudian' => '酒店', 'lvyou' => '旅游','jingdiangongyuan' => '公园',);

        if ($operate !== '') {

            return  $rs[$operate] ;       

        }

    	return $rs;

    }
	public function star_pinyin_ary($operate = '')

    {

    	$rs = array('kuaijiejiudian' => '快捷酒店', 'dujiacun' => '度假村','wuxingji' => '五星级','sixingji' => '四星级','sanxingji' => '三星级','qingnianlvshe' => '青年旅社','qita' => '其他',);

        if ($operate !== '') {

            return  $rs[$operate] ;       

        }

    	return $rs;

    }
	public function fangxing_pinyin_ary($operate = '')

    {

    	$rs = array('shangwufang' => '商务房', 'zhongdianfang' => '钟点房','dachuangfang' => '大床房','biaozhunjian' => '标准间','shuangrenfang' => '双人房','danrenfang' => '单人房','qita' => '其他',);

        if ($operate !== '') {

            return  $rs[$operate] ;       

        }

    	return $rs;

    }
	public function tuan_jiage_ary($operate = '')

    {

    	$rs = array('50' => '50元以下', '100' => '50－100元','150' => '100－150元','200' => '150－200元','500' => '200－500元','510' => '500元以上',);

        if ($operate !== '') {

            return  $rs[$operate] ;       

        }

    	return $rs;

    }




}

