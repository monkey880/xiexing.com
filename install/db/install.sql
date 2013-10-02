-- phpMyAdmin SQL Dump
-- version 3.3.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 03 月 25 日 10:10
-- 服务器版本: 5.5.17
-- PHP 版本: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `x4`
--

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_ad`
--

CREATE TABLE IF NOT EXISTS `zhuna_ad` (
  `ad_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ad_cid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '广告位所属ad_cid',
  `ad_title` varchar(60) NOT NULL DEFAULT '',
  `ad_link` varchar(255) NOT NULL DEFAULT '',
  `ad_width` varchar(10) NOT NULL DEFAULT '',
  `ad_height` varchar(10) NOT NULL DEFAULT '',
  `ad_type_radio` tinyint(2) NOT NULL DEFAULT '0',
  `ad_uploadfile` varchar(255) NOT NULL DEFAULT '',
  `ad_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ad_starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `ad_endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ad_state_radio` tinyint(2) NOT NULL DEFAULT '0',
  `ad_addtime` int(11) NOT NULL DEFAULT '0',
  `ad_externallinks` text NOT NULL,
  `ad_area` varchar(60) NOT NULL DEFAULT '' COMMENT '广告位名称',
  `ad_name` varchar(60) NOT NULL DEFAULT '' COMMENT '广告位名称代码',
  PRIMARY KEY (`ad_id`),
  KEY `ad_cid` (`ad_cid`),
  KEY `ad_order` (`ad_order`),
  KEY `ad_state_radio` (`ad_state_radio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `zhuna_ad`
--

INSERT INTO `zhuna_ad` (`ad_id`, `ad_cid`, `ad_title`, `ad_link`, `ad_width`, `ad_height`, `ad_type_radio`, `ad_uploadfile`, `ad_order`, `ad_starttime`, `ad_endtime`, `ad_state_radio`, `ad_addtime`, `ad_externallinks`, `ad_area`, `ad_name`) VALUES
(1, 1, '首页焦点图1', 'http://www.zhuna.cn', '720', '210', 2, '/public/uploadfiles/ad/default_ad1.jpg', 1, 1326038400, 1390492800, 1, 1326093816, '', '首页焦点图1', 'index_focus_1'),
(2, 1, '首页焦点图2', 'http://www.zhuna.cn', '720', '210', 2, '/public/uploadfiles/ad/default_ad2.jpg', 2, 1326038400, 1390492800, 1, 1326093816, '', '首页焦点图2', 'index_focus_2'),
(3, 1, '首页焦点图3', 'http://www.zhuna.cn', '720', '210', 2, '/public/uploadfiles/ad/default_ad3.jpg', 3, 1326038400, 1516809600, 1, 1326093772, '', '首页焦点图3', 'index_focus_3'),
(4, 1, '首页焦点图4', 'http://www.zhuna.cn', '720', '210', 2, '/public/uploadfiles/ad/default_ad4.jpg', 4, 1326038400, 1516809600, 1, 1326093772, '', '首页焦点图4', 'index_focus_4');

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_admin`
--

CREATE TABLE IF NOT EXISTS `zhuna_admin` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `name` char(20) NOT NULL DEFAULT '',
  `rank` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `logintime` int(11) unsigned NOT NULL DEFAULT '0',
  `loginip` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `rank` (`rank`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `zhuna_admin`
--

INSERT INTO `zhuna_admin` (`id`, `username`, `password`, `name`, `rank`, `logintime`, `loginip`) VALUES
(1, 'admin', '358dd8bcd5b82caafad306f5ce9656dd', '系统管理员', 1, 1363140910, '127.0.0.1'),
(2, 'edit', '48ce2cb179ebedc84b7f05b863ca1b53', '网站编辑', 6, 1298442089, '127.0.0.1'),
(4, 'shuoding', '48ce2cb179ebedc84b7f05b863ca1b53', '测试', 7, 1362973260, '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_adminlog`
--

CREATE TABLE IF NOT EXISTS `zhuna_adminlog` (
  `logid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rank` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `id` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `name` char(20) NOT NULL DEFAULT '',
  `logip` char(15) NOT NULL DEFAULT '',
  `logtime` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`),
  KEY `id` (`id`),
  KEY `rank` (`rank`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- 转存表中的数据 `zhuna_adminlog`
--

INSERT INTO `zhuna_adminlog` (`logid`, `rank`, `id`, `name`, `logip`, `logtime`) VALUES
(1, 1, 0, '', '192.168.0.108', 1323226837),
(2, 1, 0, '', '192.168.0.108', 1323234338),
(3, 1, 0, '', '127.0.0.1', 1323253049);

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_admintype`
--

CREATE TABLE IF NOT EXISTS `zhuna_admintype` (
  `rank` mediumint(5) unsigned NOT NULL,
  `typename` varchar(30) NOT NULL DEFAULT '',
  `system` smallint(6) unsigned NOT NULL DEFAULT '0',
  `purviews` text NOT NULL,
  PRIMARY KEY (`rank`),
  KEY `system` (`system`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zhuna_admintype`
--

INSERT INTO `zhuna_admintype` (`rank`, `typename`, `system`, `purviews`) VALUES
(1, '超级管理员', 1, 'zhuna_admin'),
(9, '网站编辑', 0, 'zhuna_editor'),
(10, '锁定', 0, 'zhuna_lock');

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_article`
--

CREATE TABLE IF NOT EXISTS `zhuna_article` (
  `aid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` char(60) NOT NULL DEFAULT '',
  `smallcontent` text NOT NULL,
  `content` mediumtext NOT NULL,
  `author` char(20) NOT NULL DEFAULT '',
  `order` int(11) unsigned NOT NULL DEFAULT '0',
  `state_radio` tinyint(2) unsigned NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `view_num` int(11) unsigned NOT NULL,
  `img` varchar(200) NOT NULL DEFAULT '',
  `CityID` varchar(21) NOT NULL default '0',
  PRIMARY KEY (`aid`),
  KEY `class_id` (`class_id`),
  KEY `order` (`order`),
  KEY `state_radio` (`state_radio`),
  KEY `CityID` (`CityID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 导出表中的数据 `zhuna_article`
--

INSERT INTO `zhuna_article` (`aid`, `class_id`, `title`, `smallcontent`, `content`, `author`, `order`, `state_radio`, `time`, `view_num`, `img`, `CityID`) VALUES
(1,2,'关于我们','关于我们','<p><strong>酒店签约加盟<br /></strong>住哪网和艺龙网是战略合作伙伴关系，住哪网委托艺龙网负责酒店签约工作；签约后，您的酒店将会在住哪网同步显示。<br />联系电话：010-58602288-6104(周女士)<br />电子邮箱：psgts01#corp.elong.com请把（#）改成@<br />QQ: &nbsp; 1787613887<br /><br /><strong>网站联盟合作<br /></strong>欢迎各位站长加入住哪网网站联盟，如有网站联盟相关疑问请直接与我们联系，住哪网网站联盟期待与您共同成长。<br />联系电话： 010-61136100（王先生）<br />电子邮箱： tengjiao.wang#zhuna.cn 请把（#）改成@<br />联盟网址：http://union.zhuna.cn<br /><br /><br /></p><p><br /></p>','默认管理员',1,3,1364804806,5,'','0101'),
(3, 2, '天堂——九寨沟', '<p><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530111_min.jpg" /><br />东川红土地</p><p>　　有人说，去云南旅游，西双版纳、大理和丽江是最初级的旅行，喧嚣而浮华，东川红土地则是深入一级的旅游景点，这绝对是个神奇的地方，你难以想象，在这些崇山峻岭当中，人们是怎样耕作片片梯田的。从山顶看去，漫山遍野，层层叠叠都是梯田，哪怕在深深的峡谷当中，也不见减少。</p><p><strong>　　四季皆有气势的红土地</strong></p><p>　　东川红土地是云南红土高原上最集中、最典型、最具特色的红土地，被专家认为是全世界除巴西里约热内卢外最有气势的红土地，景象比巴西红土地更为壮美。云南地处温暖湿润的环境，土壤里的铁质经过氧化慢慢沉积下来，逐渐形成了这炫目的色彩。东川主要产马铃薯、青稞和小麦，常年都是部分红土歇耕，部分红土栽种，形成五彩缤纷的图案，红绿色块的对比是常年的一种景观。如果遇上小麦夏收季节，除去红绿颜色之外，还要添上碧蓝的天以及明黄的麦浪，那时的视觉最为丰富和震撼。可以说，东川的红土地每年的每个季节都有不同的风景等待你，春季是百花的海洋，夏季是麦田的浪潮，秋季是玉米的欢唱……</p><p style="text-align: center;"><strong><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530112_min.jpg" /><br /></strong>东川红土地</p><p style="text-align: left;"><strong>　　摄影发烧友的创作基地 </strong></p><p>　　东川红土地主要的景致是以花石头村为中心，方圆几十公里的范围，集中在七彩坡、锦绣园、落霞沟、红土地大观、千年龙树、水平子、打马坎、螺丝湾、乐普凹、瓦梁房子等，景点虽多，但大多数都比较集中，一般情况下，单纯地游览一天之内基本可以看尽当地风景，但对于摄影发烧友来说，一般都要几天甚至一个星期才能满足需要。</p><p>　　由于红土地是乌蒙山山系，属高原山区地貌，山岭纵横山峦起伏，红土丘陵一望无际。而且属于气候温和、四季温差小、干湿季分明的高原季风型气候，又因其地处低纬度高原，所以空气稀薄清晰，光质极好，彩云常现。加上红土地在不同的时间段又会有不同的景观和视觉冲击，所有的这些都非常有利于摄影创作。因此，东川成为摄影家摄之不尽、拍之不绝的创作基地。</p><p style="text-align: center;"><strong><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530113_min.jpg" /><br /></strong>日出和日落同样动人 </p><p style="text-align: left;"><strong>　　日出和日落同样动人 </strong></p><p>　　到东川必须要早出晚归，因为这里的日出和日落一样的动人。打马坎是一个村子的名字，早晨日出前后在公路边的高坡上俯瞰打马坎村，红土围绕的村子里炊烟缭绕，村子四周杨树在朝阳斜射下泛着光辉，一派宁静动人的田园风光。运气好的时候可以欣赏到梦幻般的日出和朝霞。而观赏晚霞和日落的最佳地点当属瓦梁房子，这里地势高，而且能把乐普凹一带的风景尽收眼底，等待日落之前，还可以先到附近的螺丝湾看一看，非常方便。水平子也是一个较远的景点，原名月亮田，这是一个层层叠叠的梯田，最特别之处在于其中一块水田看起来仿佛一把玉琵琶，让人怀疑是否上天遗落于人间，如此神奇。</p><p>　　最美的景致还应属落霞沟，也叫陷塘地，这是在崇山环抱中突然下陷的一块洼地，斑斓的色彩突然扑面而来，让人瞬间忘记了呼吸，又让人不得不感叹劳动人民的伟大。</p><p style="text-align: center;"><strong><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530114_min.jpg" /><br /></strong>东川红土地 </p><p style="text-align: left;"><strong>　　旅行贴士</strong></p><p>　　交通：从广州飞昆明，在昆明市区的两个客运站（东菊客运站和南窖客运站）乘班车，2.5~3小时到东川区，在东川区客运站有前往红土地所在的“花沟”、  “花石头”等地的车。或者在昆明汽车客运北站直接乘车到红土地，不过班车较少。如果是摄影发烧友建议租车比较方便。</p><p>　　住宿：当地家庭旅馆较多，大多聚集在出租车停车场和客运站附近，价格从20元一个床位到120元一个标间都有。</p><p>　　美食：东川与红土地景区的口味以辣为主，米线比较常见，特色菜有“红焖牛肉”、“清汤煮羊肉”、“干辣椒炒牛肉干巴”、“清炒菜心”等。</p><p>　　衣着：景区在山上，温度比山下东川低4~8℃，早晚较凉，很多地方风比较大，除了7-10月备一件长袖风衣，其他季节最好多带一件抓绒衣。</p><p>　　提醒：最佳摄影月份是5、9、11月份，那时的色块比较多，主要有红色、黄色、绿色和白色。</p>\r\n{中关村#10}', '<p><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530111_min.jpg" /><br />东川红土地</p><p>　　有人说，去云南旅游，西双版纳、大理和丽江是最初级的旅行，喧嚣而浮华，东川红土地则是深入一级的旅游景点，这绝对是个神奇的地方，你难以想象，在这些崇山峻岭当中，人们是怎样耕作片片梯田的。从山顶看去，漫山遍野，层层叠叠都是梯田，哪怕在深深的峡谷当中，也不见减少。</p><p><strong>　　四季皆有气势的红土地</strong></p><p>　　东川红土地是云南红土高原上最集中、最典型、最具特色的红土地，被专家认为是全世界除巴西里约热内卢外最有气势的红土地，景象比巴西红土地更为壮美。云南地处温暖湿润的环境，土壤里的铁质经过氧化慢慢沉积下来，逐渐形成了这炫目的色彩。东川主要产马铃薯、青稞和小麦，常年都是部分红土歇耕，部分红土栽种，形成五彩缤纷的图案，红绿色块的对比是常年的一种景观。如果遇上小麦夏收季节，除去红绿颜色之外，还要添上碧蓝的天以及明黄的麦浪，那时的视觉最为丰富和震撼。可以说，东川的红土地每年的每个季节都有不同的风景等待你，春季是百花的海洋，夏季是麦田的浪潮，秋季是玉米的欢唱……</p><p style="TEXT-ALIGN: center"><strong><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530112_min.jpg" /><br /></strong>东川红土地</p><p style="TEXT-ALIGN: left"><strong>　　摄影发烧友的创作基地 </strong></p><p>　　东川红土地主要的景致是以花石头村为中心，方圆几十公里的范围，集中在七彩坡、锦绣园、落霞沟、红土地大观、千年龙树、水平子、打马坎、螺丝湾、乐普凹、瓦梁房子等，景点虽多，但大多数都比较集中，一般情况下，单纯地游览一天之内基本可以看尽当地风景，但对于摄影发烧友来说，一般都要几天甚至一个星期才能满足需要。</p><p>　　由于红土地是乌蒙山山系，属高原山区地貌，山岭纵横山峦起伏，红土丘陵一望无际。而且属于气候温和、四季温差小、干湿季分明的高原季风型气候，又因其地处低纬度高原，所以空气稀薄清晰，光质极好，彩云常现。加上红土地在不同的时间段又会有不同的景观和视觉冲击，所有的这些都非常有利于摄影创作。因此，东川成为摄影家摄之不尽、拍之不绝的创作基地。</p><p style="TEXT-ALIGN: center"><strong><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530113_min.jpg" /><br /></strong>日出和日落同样动人&nbsp;</p><p style="TEXT-ALIGN: left"><strong>　　日出和日落同样动人 </strong></p><p>　　到东川必须要早出晚归，因为这里的日出和日落一样的动人。打马坎是一个村子的名字，早晨日出前后在公路边的高坡上俯瞰打马坎村，红土围绕的村子里炊烟缭绕，村子四周杨树在朝阳斜射下泛着光辉，一派宁静动人的田园风光。运气好的时候可以欣赏到梦幻般的日出和朝霞。而观赏晚霞和日落的最佳地点当属瓦梁房子，这里地势高，而且能把乐普凹一带的风景尽收眼底，等待日落之前，还可以先到附近的螺丝湾看一看，非常方便。水平子也是一个较远的景点，原名月亮田，这是一个层层叠叠的梯田，最特别之处在于其中一块水田看起来仿佛一把玉琵琶，让人怀疑是否上天遗落于人间，如此神奇。</p><p>　　最美的景致还应属落霞沟，也叫陷塘地，这是在崇山环抱中突然下陷的一块洼地，斑斓的色彩突然扑面而来，让人瞬间忘记了呼吸，又让人不得不感叹劳动人民的伟大。</p><p style="TEXT-ALIGN: center"><strong><img alt="" src="http://img.lotour.com/test/outdoor/201011/img530114_min.jpg" /><br /></strong>东川红土地&nbsp;</p><p style="TEXT-ALIGN: left"><strong>　　旅行贴士</strong></p><p>　　交通：从广州飞昆明，在昆明市区的两个客运站（东菊客运站和南窖客运站）乘班车，2.5~3小时到东川区，在东川区客运站有前往红土地所在的“花沟”、 “花石头”等地的车。或者在昆明汽车客运北站直接乘车到红土地，不过班车较少。如果是摄影发烧友建议租车比较方便。</p><p>　　住宿：当地家庭旅馆较多，大多聚集在出租车停车场和客运站附近，价格从20元一个床位到120元一个标间都有。</p><p>　　美食：东川与红土地景区的口味以辣为主，米线比较常见，特色菜有“红焖牛肉”、“清汤煮羊肉”、“干辣椒炒牛肉干巴”、“清炒菜心”等。</p><p>　　衣着：景区在山上，温度比山下东川低4~8℃，早晚较凉，很多地方风比较大，除了7-10月备一件长袖风衣，其他季节最好多带一件抓绒衣。</p><p>　　提醒：最佳摄影月份是5、9、11月份，那时的色块比较多，主要有红色、黄色、绿色和白色。</p>', '默认管理员', 0, 3, 1340009456, 195, 'Public/uploadfiles/article/2011-11/20111101111333.jpg', '0101'),
(4, 2, '京城五大赏枫佳境', '金秋十月，正是红叶开始漫山遍野的季节。在热闹挤人的国庆黄金周过后，外出赏枫更添一分宁静，事实上宁静也正是看红叶最佳的状态。很多人都说，秋天是北京最美的季节。每到秋季，满树的叶片就成了主角，红彤彤漫山浸染的枫叶，让人心生无限美好。', '<p><span style="font-family:Verdana;">金秋十月，正是红叶开始漫山遍野的季节。在热闹挤人的国庆黄金周过后，外出赏枫更添一分宁静，事实上宁静也正是看红叶最佳的状态。很多人都说，秋天是北京最美的季节。每到秋季，满树的叶片就成了主角，红彤彤漫山浸染的枫叶，让人心生无限美好。</span></p><p><span style="font-family:Verdana;">　　如今，秋天外出赏红叶已成为北京人民的传统，香山红叶不再独领风骚，各大景区的山林披上红妆争相斗艳。让</span><span style="font-family:Verdana;">我们整理好心情，背上背包，带上家人，利用周末时间去捕捉秋色，参加这一秋季的火红盛典。</span></p><p align="center"><span style="font-family:Verdana;"><img alt="" src="http://www.9tour.cn/UploadFile/TravelNews/2010-10-20/0125119449.jpg" border="0" /> <br /></span><span style="font-family:Verdana;">香山公园</span></p><p align="left"><span style="font-family:Verdana;"><strong>1、香山红叶显妖娆</strong></span></p><p align="left"><span style="font-family:Verdana;">　　秋天，是香山最鼎盛之时。深秋的黄护红叶；似团团殷红的火焰，漫山遍野、这红叶经霜一打，在荷尽菊残的季</span><span style="font-family:Verdana;">节，越发红得妖烧。游人穿行其间，周围弥漫着红叶的芳菲，加上林间清幽典雅的气氛,欣喜之情油然而生。 </span></p><p><span style="font-family:Verdana;">　　电话：010-62599886/1264 　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana;">门票：淡季5元，旺季10元，索道30元，65周岁及以上老年人凭本人老年优待证游览公园免收门票费（不含园中</span><span style="font-family:Verdana;">园，大型活动期间除外） 　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana;">地址：北京市海淀区西山脚下（买卖街40号） 　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana;">交通路线：乘318、331、360、634、714、696、698路到香山公园下车。　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana;">周边景点：北京植物园 李大钊墓园 </span></p><p align="center"><img alt="" src="http://www.9tour.cn/UploadFile/TravelNews/2010-10-20/0125620582.jpg" border="0" height="375" width="500" /> <br /><span style="font-family:Verdana;">八大处公园 </span></p><p><span style="font-family:Verdana;"><strong>2、求佛品茗赏红叶</strong></span></p><p><span style="font-family:Verdana;">　　八大处公园是由西山余脉翠微山、平坡山、卢师山所环抱，三山形似座椅，八座古刹星罗棋布分布在三山之中，</span><span style="font-family:Verdana;">自然天成的“十二景观”更是闻名遐迩，古人即赞曰“三山如华屋，八刹如屋中古董，十二景则如屋外花园”又</span><span style="font-family:Verdana;">有云“香山之美在于人工，八大处之美在于天然，其天然之美又有过于西山诸胜。</span></p><p><span style="font-family:Verdana;">　　电话：010-88964661 　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 门票：10元，学生5元　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 地址：北京西山风景区南麓八大处公园　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 交通路线：乘389、958、709、972、622、347路公交车至八大处站下车即到。　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 周边景点：希望公园 四海公园 法海寺 </span></p><p align="center"><span style="font-family:Verdana;"><img alt="" src="http://www.9tour.cn/UploadFile/TravelNews/2010-10-20/2012589913.jpg" border="0" height="375" width="500" /><br />八达岭国家森林公园</span></p><p align="left"><span style="font-family:Verdana;"><strong>3、红叶辉映残长城</strong></span></p><p align="left"><span style="font-family:Verdana;">　　八达岭国家森林公园位于万里长城八达岭和居庸关之间，总面积4.4万亩，最高峰海拔1238米，分布植物539种、</span><span style="font-family:Verdana;">动物158种、林木绿化率达到96%，为中国首家通过FSC国际认证的生态公益林区。公园主要景区有红叶岭风景区、</span><span style="font-family:Verdana;">青龙谷风景区、丁香谷风景区、石峡风景区。詹天佑修建的中华第一条铁路——“人”字形铁路也在公园境内。</span></p><p><span style="font-family:Verdana;">　　电话：010-81181458 　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 门票：全票25元/张；出示学生证、老年证半票 　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 地址：北京市八达岭林场 　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 交通路线：</span><span style="font-family:Verdana;">公交车：从德胜门乘919直达八达岭区间车，在公园站下车抵达。　　　　　　　　　　　　　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 自驾车：经八达岭高速公路，由水关长城（第20出口）高速口出，前行50米到路左侧水关长城停车场，即达。　　<br /></span><span style="font-family:Verdana;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 周边景点：八达岭长城　水关长城 </span></p><p align="center"><span style="font-family:Verdana;"><img alt="" src="http://www.9tour.cn/UploadFile/TravelNews/2010-10-20/0201309564.jpg" border="0" height="375" width="500" /> <br />慕田峪长城</span></p><p><span style="font-family:Verdana;"><strong>4、万里长城慕田峪独秀</strong></span></p><p><span style="font-family:Verdana;">　　慕田峪长城的红叶红了。秋天是慕田峪长城风情最浓郁的时节，从10月中旬到11月下旬，称得上是赏红叶的最佳</span><span style="font-family:Verdana;">时机。您可以欣赏到元宝枫、五角菱枫、火炬树等红叶树种。现在，慕田峪长城数十里枫树的树叶色彩逐渐变浓</span><span style="font-family:Verdana;">，从浅黄、金黄再到深红和鲜红，具有非常明显的层次感。</span></p><p><span style="font-family:Verdana;">　　电话：010-61626022 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 门票：内外宾成人40元/人，学生20元/人 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 地址：北京市怀柔区慕田峪村 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 交通路线：公交：东直门乘916路公交车至怀柔会议中心，换乘蓝色小巴即可到达。 　　　　　　　 </span><span style="font-family:Verdana;">　　　　　　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 自驾车：京乘高速进怀柔城区延青</span><span style="font-family:Verdana;">春路西行奔慕田峪村方向。 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 周边景点：红螺寺 黄花城长城 </span></p><p align="center"><span style="font-family:Verdana;"><img alt="" src="http://www.9tour.cn/UploadFile/TravelNews/2010-10-20/2013220429.jpg" border="0" height="375" width="500" />&nbsp;<br /></span><span style="font-family:Verdana;">云蒙山国家森林公园 </span></p><p><span style="font-family:Verdana;"></span></p><p align="left"><strong>5、云蒙山赏红叶摘红果</strong></p><p align="left">　　被称为“小黄山”的云蒙山位于密云县和怀柔县交界处，古称“云梦山”，是京郊著名的风景名胜区，也是北京</p><p align="left"><span style="font-family:Verdana;">　　电话：010-61622481/61622381 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 门票：成人36元/人，学生18元/人 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 地址：北京丰宁公路81公里处 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 交通路线：公交：<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1、东直门、西直门、木樨园、广渠门马圈、马甸等长途站班车去丰宁(途经云蒙山公园站） 　　　　　　　　　　　　　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2、东直门-</span><span style="font-family:Verdana;">喇叭沟门936专线班车（途经云蒙山公园站） 　　　　　　　　　　　　　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3、宣武门教堂前、东大桥双休日节假日有专线车（途经云蒙山公园</span><span style="font-family:Verdana;">站）　　　　　　　　　　　　　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 自驾车：东直门至怀柔县城沿怀丰（怀柔-丰宁）公路35公里处即到。 </span><span style="font-family:Verdana;">　　<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 周边景点：天池峡谷旅游风景区</span></p><span style="font-family:Verdana;">市著名的国家级森林公园。金秋时节硕果累累，景区内满山遍野的红叶、黄叶、各种色彩的野花与翠松相互辉映</span><span style="font-family:Verdana;">，呈现出红叶层林尽染的壮观景象，正是游客赏红叶、采摘秋收果实之时。</span><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', '默认管理员', 0, 3, 1331015551, 61, 'Public/uploadfiles/article/2011-11/20111101111322.jpg', '0101'),
(5, 2, '如家快捷正进军豪华酒店市场 已取得初步成功', '如家快捷酒店管理公司去年在上海推出了首家和颐酒店，档次相当于喜达屋酒店及度假酒店国际集团(Starwood Hotels & Resorts Worldwide Inc., 简称：喜达屋，又名：仕达屋)的W连锁酒店。尽管取得了初步的成功，分析人士却说，如家还需要走很长的路才能在中国的豪华酒店市场上占据相当大的份额。如家在中国有583家经济型酒店。', '<p>如家快捷酒店管理公司去年在上海推出了首家和颐酒店，档次相当于喜达屋酒店及度假酒店国际集团(Starwood Hotels &amp; Resorts Worldwide Inc., 简称：喜达屋，又名：仕达屋)的W连锁酒店。尽管取得了初步的成功，分析人士却说，如家还需要走很长的路才能在中国的豪华酒店市场上占据相当大的份额。如家在中国有583家经济型酒店。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 如家由携程旅行(Ctrip International Ltd.)联合创始人沈南鹏于2002年创立，目前已经成为中国市场占有率最大的经济型连锁酒店。该公司2006年在纳斯达克上市。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2008年底，如家在上海推出了首家和颐酒店试点，目标客户群是中高级商务旅客，房价为每日人民币600元至900元（合88至132美元），与万豪国际集团(Marriott International Inc.)在中国的平均价格相当。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 如家拒绝提供业务扩张计划的详情，不过有媒体最近援引该公司首席执行长孙坚的话说，高档酒店市场拥有最大的增长潜力，公司很可能会在其他城市陆续推出和颐酒店，包括浙江省会杭州。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IBISWorld分析师范霍恩(George Van Horn)说，全球化使得中国的豪华酒店市场竞争非常激烈，既有中国本土公司，也有国际公司，包括香格里拉（亚洲）有限公司(Shangri-La Asia Ltd., 简称：香格里拉)和凯悦酒店集团(Hyatt Hotels Corp.)。在中国，以游客为目标的星级酒店去年总数为1.41万家，其中两三星酒店占了绝大部分。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Oppenheimer分析师姜彦仁(Paul Keung)说，如家仍在发展、试验、调整自己的四星级和颐酒店的概念。他还说，和颐酒店的目标客户群是寻求超值服务的传统型四五星级酒店客户和寻求升级的三星级酒店客户。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 他说，和颐酒店不会寻求星级酒店评级，这个战略和经济型连锁酒店是一样的。不过他说，房价和包括高速网络接口在内的服务将以高档商务旅客为目标。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 在去年的下挫之后，如家美国存托凭证从52周低点的略高于7美元升至周二午盘的约36美元。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 如家首席财务长亦泓最近在电话会议上说，如家不会公布和颐酒店的业绩，不过我们能向你们公布的是和颐酒店继续逐步改善；这是略高档酒店范畴里的首家雏形酒店，我们仍在调整模式、积累运营经验。</p><br />', '默认管理员', 0, 1, 1331015223, 1, '', '0101'),
(6, 2, '解码如家快捷酒店制胜秘诀 五大策略正确实施', '　　如家已成为中国经济型酒店大众住宿业第一品牌，而且第一品牌的位置从2006年收入囊中一直保持到现在从未被动摇过。从如家年报上的信息显示在经济危机的大环境下，如家业绩表现仍超出预期。如家为何能够取得这样不凡的业绩，为何能够持续保持第一，而且还能够持续保持增长，难道它所取得的成就仅仅是中国的土壤适合经济型酒店发展吗？', '1997年，锦江之星投资了中国的第一家经济型酒店，由此开始了中国经济型酒店的领跑之舞。<p>　　5年之后，2002年，一家名不见经传的经济型酒店——如家快捷开始了自己的第一声啼哭。</p><p>　　4年后的2006年10月26日，如家在美国纳斯达克成功登陆，融资超过1亿美元，市值超过8亿美元，从零起步到第一品牌，如家只用了四年时间！</p><p>　　如家为什么能够成为众多中国老百姓的旅居首选，而曾经的第一品牌锦江之星，却似乎被人遗忘？</p><p>　　如家会成为中国的宜必思吗？还是会超越宜必思成为全球的如家？</p><p>　　四年从零起步到纳斯达克第一股，从跟随到领跑，如家到底做了什么？</p><p>　　如家已成为中国经济型酒店大众住宿业第一品牌，而且第一品牌的位置从2006年收入囊中一直保持到现在从未被动摇过。从如家年报上的信息显示在经济危机的大环境下，如家业绩表现仍超出预期。如家为何能够取得这样不凡的业绩，为何能够持续保持第一，而且还能够持续保持增长，难道它所取得的成就仅仅是中国的土壤适合经济型酒店发展吗？</p><p>　　答案勿容置疑是否定的，解码如家制胜秘诀问题还需从解析如家发展历程、如家管理模式、如家营销法则开始，《如家模式》一书清晰、详细地解读了如家的发展历程、如家的管理内幕、如家的营销之法，从如家发展历程、管理模式、营销之法的解析中我们不难看出如家制胜的秘诀离不开五大策略的正确实施，四大管理法则的正确运行，三大营销之法的有效应用。</p><p>　　回顾如家的发展历程，从如家发展脉络上我们可以清晰地看出如家五大策略的正确实施，而且每一个策略的出现都是一幅经典的王牌，且是恰到好处的王牌。</p><p>　　第一：优良的基因。2002年6月，携程与首旅集团联姻催生了如家，两家投资方将各自的优势资源进行嫁接整合，共同赋予了如家高起点的优良基因，为未来如家的成功演义打下了坚实的基础。同时携程和首旅谈判就谁占绝对控股问题最终达成一致意见，携程占绝对控股，创始人就这个问题在谈判时的成功坚持为如家未来利用资本的发展、扩张提供了有利的条件，也为如家未来的快速发展创造了绝对的优势条件。这就是如家的第一策略——“基础王牌”。</p><p>　　第二：资本的注入。如家优良的基因基础以及中国经济型酒店的巨大市场，为如家的发展提供了良好的机遇，再加上其良好的经营状况，立刻引来了不少风投的关注。资本的注入犹如为如家的发展插上了腾飞的翅膀，使得如家在短短的几年时间内迅速完成跑马圈地，同时为其成功上市、成为中国经济型酒店第一品牌埋下了伏笔。这就是如家的第二策略——“资本王牌”。</p><p>　　第三：如家的慢跑。如家资本的成功运作，让投资者看到了中国经济型酒店有着丰厚的利润，并纷纷开始向经济型酒店注入资本，快速发展，使得经济型酒店飞速膨胀，并迎来了经济型酒店的泡沫、拐点论的大讨论。而此时的如家开始了慢跑，专注内部的管理机制的打造，为如家再次腾飞奠定坚实的基础。这就是如家的第三策略——“慢跑王牌”</p><p>&nbsp;&nbsp;&nbsp; 第四：如家的快跑。如家经过一段时间的内部服务建设、培训及标准化管理体系建设后，打造了一张标准化、人性化的无形之网，为其布局全国、掌控全国市场做好了充分的准备。随后如家开始了快跑，制定了全国战略布局计划，在规模上实现了翻一番。这就是如家的第四策略——“快跑王牌”。</p><p>　　第五：如家的文化。如家在向1000家店冲刺之时，发现其随着店面的扩张，管理效率以及服务质量在逐渐下降，此时的如家开始重点抓企业的文化的建设，让服务成为每一位如家员工自觉行为，让每一位员工自然而然的为客人服务，这是目前如家面临和必须解决的一件大问题，只有这个问题解决了，大如家才能够再次腾飞、再次创造辉煌。这就是如家的第五策略——“文化建设”。</p><p>　　如家在策略上的正确实施为如家的发展创造了一个又一个奇迹，但这些奇迹的取得离不开管理法则、营销之法的支撑。</p><p>　　如家四大管理法则：</p><p>　　第一：自然法则。如家倡导并力行的自然法则和自然管理之道是所为所不为，多为少为，通过剔除、减少、增加、创造的自然法则让如家能够很好地踩准行业的发展节拍和节奏，让如家适应了自然的运行规律和市场的运行规律，使如家成为经济型酒店的王者。</p><p>　　第二：系统打造。如家为何能够复制并实现快速发展，最核心的关键就是如家系统的打造，如家从刚开始成立就按照标准化的规则对每一个作业都进行了标准化制定，并不断对这些标准化进行优化和完善，以实现标准化的尽善尽美。如家系统的成功打造，造就了今天的如家。</p><p>　　第三：人才工程。常言道：看一个企业发展首先要看它的人才，可见人才对一个企业的发展是多么的重要，如家在人才管理方面采用多管齐下的方针对人才进行培养，管理学校的培训，每年举行的大比武活动，不定时的抽查考试等等策略，为如家培养了一批有一批合格的管理和服务人才。</p><p>　　第四：产品和服务的精致化。如家精致化的产品让顾客住着舒服、安心，精致化的服务让顾客感到贴心和温暖，这也是如家为何入住率很高的根本所在。</p><p>　　如家的三大营销法则：</p><p>　　第一：首创经济型酒店呼叫中心和会员制营销之法，如家呼叫中心的建立成为了链接了如家和顾客桥梁，为客人提供入住之前和离店之后服务。完善的呼叫中心功能，贴心的为顾客提供服务是营销的上乘境界。如家会员制的建立为如家积累了庞大的顾客资源。</p><p>　　第二：软传播之法，软传播是最有效、最持久、影响力最强的一种营销方式，它以非硬性非强制非知觉的方式潜入消费者和公众头脑，并进而长久占据消费者的心智和心位，使品牌传播内容达到“随风潜入夜，润物细无声”的效果。如家通过如家心晴、故事、口碑、企业家品牌、新闻等软传播方式，让如家的品牌在“润物细无声”中深入到每一位顾客的心中。</p><p>　　第三：品牌联盟之法，如家通过与旅游、银行、航空等多个品牌的联合发展，不仅增加了如家的客源，提高了如家在异业中的影响力，同时也提高了如家品牌的知名度，达到几方共赢的局面。</p><br />', '默认管理员', 0, 1, 1331015231, 1, '', '0101'),
(7, 2, '如家快捷酒店', '如家快捷酒店青岛山东路店是如家酒店连锁的直营店。酒店拥有布置温馨的标准房、单人房等各类房型133间。', ' 如家快捷酒店青岛山东路店是如家酒店连锁的直营店。酒店拥有布置温馨的标准房、单人房等各类房型133间。客房内提供免费宽带上网、24小时热水淋浴、空调、电视、电话、有标准的席梦思床具及配套家具。酒店秉承如家酒店连锁的特色三大“统一”性：统一建筑设施、统一服务、统一硬件设施。酒店内外由名家设计，风格简约、别致，设施齐全舒适，展现“干净、温馨”的`住宿环境。 酒店位于青岛迎宾大道——山东路中段，西靠山东路家乐福，东邻家世界大卖场，南面紧临青岛市北区政府，在青岛市市北区拟打造的中央商务区内。距离青岛新建火车站四公里,汽车站三公里,会展中心六公里,交通十分便利.<br />&nbsp;&nbsp;&nbsp; 地址：青岛市吴石路88号（山东路家乐福对面）<br />', '默认管理员', 0, 1, 1331015239, 0, '', '0101'),
(8, 2, '如家快捷酒店:酝酿收购“行业老五”莫泰168', '如家快捷酒店集团首席财务官颜惠萍在北京一次会议上的言论，让如家考虑收购莫泰168连锁酒店的想法提前曝光。', '如家快捷酒店集团首席财务官颜惠萍在北京一次会议上的言论，让如家考虑收购莫泰168连锁酒店的想法提前曝光。<br />据悉，莫泰是上海美林阁酒店及餐饮管理有限公司于2002年创立的一家经济型酒店，目前规模排名第五。根据上海盈蝶酒店管理咨询有限公司提供的最新统计数据，目前莫泰在全国共拥有276家门店，拥有43801间客房。<br />然而自去年开始，莫泰股权将被出售的传闻就一直不断。有知情人士表示，2005年美国投行摩根士丹利以2000万美元入股莫泰约占20%股权，并谋划2年后将莫泰拿去美国上市。然而5年过去了，莫泰进军资本市场的步伐仍然停滞不前。上海世博会结束后，大摩有意退出。据悉，包括如家、锦江之星在内的经济型酒店都对莫泰出售的股权表示出兴趣，但如家C E O孙坚表示，目前仍在考虑，收购计划尚未进入实质性阶段。<br />如家不久前刚刚发布了2011年门店扩张计划显示，将在今年新开260-280家门店。如果能够落实这一交易，这无疑将使其在中国经济型酒店的地位更加牢固，与其它竞争对手拉开更大的差距。而与此同时，近年扩张速度一直在业界排名前列的7天酒店企图在1-2年赶超如家的计划也可能落空。<br />不过，有业内分析人士表示，目前经济型酒店的收购并不容易。此前如家收购七斗星并不顺利。当年收购完成后，对七斗星的整合一度造成2007年第四季度的亏损。“相比较收购来说，目前在中国内地自己开设门店的成本还更低。”为此，能否最终落实收购莫泰，现在还言之过早。<br />', '默认管理员', 0, 1, 1331015289, 0, '', '0101'),
(9, 2, '如家快捷酒店拟今年至少新开260家连锁店', '北京时间1月7日消息，据国外媒体报道，如家快捷酒店管理公司今天宣布，计划在今年新开260至280家连锁酒店，其中100至110家为自营店，160至170家为加盟店。', '北京时间1月7日消息，据国外媒体报道，如家快捷酒店管理公司今天宣布，计划在今年新开260至280家连锁酒店，其中100至110家为自营店，160至170家为加盟店。<br />此外，正如之前所宣布的那样，如家已制定了进军中国中高端商务酒店领域的计划，今年将新开3至4家和颐酒店。和颐酒店是如家的第二大品牌。<br />2010年，如家新开了208家连锁酒店，其中67家为自营店，141家为加盟店，截至去年底如家共经营酒店818家。<br />如家今年的目标计划创下了中国经济型酒店单独一年新开酒店数量的纪录。据此计算，至今年年底如家连锁酒店的数量总和将达到近1100家。<br />如家首席执行官孙坚评论说：“现在正是我们进入新增长阶段的时机。在最近的经济复苏期间，我们重组了一支强大的开发团队，实施了行之有效的发展计划。基于当前强劲的经济发展预期，以及我们的经济实力和管理能力，我们相信，现在是如家对未来进行投资以及实现长期移步增长的大好时机。”<br />如家计划利用中国有利的整体经济环境加速实现增长，并在国内商务和休闲旅游领域实现持续增长。<br />', '默认管理员', 0, 1, 1331015309, 3, '', '0101'),
(10, 2, '闲置多年电子大厦变身全国连锁快捷酒店', '邢台市电子器材计算机公司电子大厦1993年建成后就未能正常营业，自1998年全面停业至今资产闲置。为盘活国有资产，解决职工安置问题，市政府以及市国资委积极招商引资，引进上海如家酒店管理有限公司投资2000万元，租赁建设“邢台如家快捷酒店”。', '邢台市电子器材计算机公司电子大厦1993年建成后就未能正常营业，自1998年全面停业至今资产闲置。为盘活国有资产，解决职工安置问题，市政府以及市国资委积极招商引资，引进上海如家酒店管理有限公司投资2000万元，租赁建设“邢台如家快捷酒店”。<p>&nbsp;&nbsp;&nbsp; 上海如家酒店集团创立于2002年，是美国纳斯达克上市公司。该集团旗下有经济型连锁酒店如家快捷酒店、中高端商务酒店和颐酒店两大品牌，现已在全国30多个省（市、自治区）的190多个城市设立连锁网点1000多家，形成业内全国最大的连锁酒店体系。</p><p>&nbsp;&nbsp;&nbsp; 该项目于2010年8月动工建设，12月26日开始试营业。该项目的投用，盘活了我市国有资产，实现部分下岗职工再就业。<br />&nbsp;<br /></p><br />', '默认管理员', 0, 1, 1331015345, 2, '', '0101');
INSERT INTO `zhuna_article` (`aid`, `class_id`, `title`, `smallcontent`, `content`, `author`, `order`, `state_radio`, `time`, `view_num`, `img`, `CityID`) VALUES
(11, 2, '快捷酒店数量繁多为何依然吃香', '近几年来，随着我国快捷酒店的迅猛发展，酒店业市场一度达到饱和状态。由于快捷酒店的异军突起，整个酒店业市场的发展方向都有所改变，传统意义上的“多星”酒店已经逐步脱离消费者的主要选择视线，快捷酒店正在以成倍的速度占据着整个酒店行业市场。那么究竟是什么原因让快捷酒店在各类酒店数量繁多的境况下依然屹立不倒？快捷酒店把握市场命脉的发展之道又是什么呢？记者走访了多家快捷酒店，为你解读这一行情。', '<span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;"><span></span>近几年来，随着我国快捷酒店的迅猛发展，酒店业市场一度达到饱和状态。由于快捷酒店的异军突起，整个酒店业市场的发展方向都有所改变，传统意义上的“多星”酒店已经逐步脱离消费者的主要选择视线，快捷酒店正在以成倍的速度占据着整个酒店行业市场。那么究竟是什么原因让快捷酒店在各类酒店数量繁多的境况下依然屹立不倒？快捷酒店把握市场命脉的发展之道又是什么呢？记者走访了多家快捷酒店，为你解读这一行情。<br /></span><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">【选对消费人群是基础】</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">“与星级酒店相比较，快捷酒店所针对的人群不一样，一般来说快捷酒店的消费人群还是偏低龄一些的。”七天快捷酒店人民路店的总经理李堃对记者说。酒店的发展离不开顾客的支持，而针对不同年龄层则会有不同的营销手段和策略。</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 记者通过对郑州多家快捷酒店的走访了解到，很多快捷酒店吸引顾客的方式在细节上都不相同，但是他们的营销手段却有着一个共性，那就是偏重青年人群的消费喜好方式。就像李堃所说：“星级酒店的消费市场已经饱和，说白了去星级酒店消费的房客占整体消费群体的少数，而这部分群体已经被郑州市林立的星级酒店瓜分殆尽。普通的消费人群还有很多，特别是青年消费群体。而快捷酒店就是抓住这一点来开拓市场的。因为针对的消费人群不一样，故而发展方向、营销策略自然也跟星级酒店不同了。”</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">【创新是快捷酒店的“命脉”】</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 在营销策略方面，快捷酒店有着自己的一套独有政策，那就是创新策略。李堃表示，一家酒店的客房设施能给人留下最为直观的第一印象，很多快捷酒店正是抓住了这一点，让自己的客房变得独特、鲜亮。能让房客一进到房间内就永远记住这家酒店。</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 位于郑州市金水区经六路的喜鹊愉家快捷酒店在这一方面可以说功夫做到家了。在酒店内记者注意到，房间设施尽管跟其他快捷酒店一样，重点突出了方便、整洁和卫生。但不同的是在一些细节方面，该酒店也有所动作，比如在没有窗户的房间里会有一扇自制窗棂，窗棂内有日光灯，打开后给人的视觉感受就像在清晨感受到第一缕阳光一样。另外有的房间还设计有高低台阶。很多消费者表示，这样的设计很新潮，很多设计都深深印在消费者脑海中。</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 而与之相类似的如家快捷酒店可以说是酒店业创新思路的一面旗帜，酒店的风格特别吸引年轻消费群体。</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 此外，如家快捷酒店一位管理层人士表示说：“酒店业发展到现阶段再也不是看谁家的电视大，谁家的地毯厚了。硬件上比拼的就是创新，软件上比拼的就是服务。”</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">【“零缺陷”服务是制胜关键】</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 在奠定良好硬件基础的同时，如何才能更好地体现出快捷酒店特有的“高端软服务”是每个快捷酒店都要面对的问题。有业内人士曾表示：酒店感动和吸引人的地方，不是高大的建筑和良好的设施，而是润物细无声的用心服务，酒店的竞争关键是特色，特色的核心是品牌，品牌的保障就是优质服务，所以只有得到消费者肯定的服务才能使酒店持续发展，酒店的发展必须以优质的“零缺陷”服务为基础。</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 在对几家快捷酒店的采访中，记者深有体会，有些快捷酒店的服务属于“主动式”服务，会主动与客人交流，帮助客人解决一些住宿期间所遇到的问题；还有一种则属于“被动式”服务。看到消费者有问题要帮忙时表现出不情不愿，迫不得已才出手帮助。试想，如果酒店方采用这种“闭关自守”的方式发展的话，又能在本行业内矗立多久？</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">■ 记者手记</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 近几年，郑州的快捷酒店发展迅猛，由于财富效应引来了众多效仿者，纷纷“跑马圈地”布局开店。从数量上看，目前已经可以满足郑州市的需求。但从质量上看，远远不够。酒店数量的增加将带来该行业的优胜劣汰，星级、经济型以及零散的个体小旅店，必须找到准确的目标定位。通过竞争，未来可能会出现3～5个品牌鼎足而立的情况。</span><br style="font: 14px/20px 宋体; color: rgb(51, 51, 51); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;" /><span style="color:#333333;font: 14px/20px 宋体; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; float: none; display: inline !important; white-space: normal; orphans: 2; widows: 2; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">&nbsp;&nbsp;&nbsp; 据记者了解，目前郑州市场上加盟的连锁快捷酒店众多，而这些强势快捷酒店品牌，拥有强大的品牌影响力、统一的管理、完善的服务，以及数量巨大的会员，构成了这些快捷酒店成功运营的基础，反观如家、七天、锦江之星等品牌的成功历程无一不是如此，而快捷酒店的品牌化运作和规模化扩张，无疑又反过来为酒店的发展提供了强大助力。选择一个强势品牌加盟，成为投资快捷酒店的捷径。</span><br />', '默认管理员', 0, 1, 1331015367, 7, '', '0101'),
(12, 2, '连锁快捷酒店实施百店布局战略', '随着旅游市场的快速发展，酒店行业也紧随其后。游客对于物美价廉的酒店更为青睐，尤其是连锁型快捷酒店。据了解，目前多家全国连锁快捷酒店大打“扩张牌”，相信不久以后，经济型连锁酒店将成为出行的首选酒店。', ' 随着旅游市场的快速发展，酒店行业也紧随其后。游客对于物美价廉的酒店更为青睐，尤其是连锁型快捷酒店。据了解，目前多家全国连锁快捷酒店大打“扩张牌”，相信不久以后，经济型连锁酒店将成为出行的首选酒店。<p style="font: 14px/22px 宋体, 黑体, 微软雅黑; margin: 0px; padding: 0px; color: rgb(0, 0, 0); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; font-size-adjust: none; font-stretch: normal; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">　　据了解，9月28日，汉庭在上海的第100家门店汉庭快捷恒隆广场店正式开门营业。至此，汉庭在上海已经完成了百店布局。据了解，目前在上海的经济型酒店品牌中，只有两家达到了百店以上规模：一个是刚被如家收购的莫泰，一个就是汉庭。9月底如家将正式开始接管莫泰，可以预见，上海作为重要的商旅城市，未来各大经济型酒店在上海的争夺将更加激烈。</p><p style="font: 14px/22px 宋体, 黑体, 微软雅黑; margin: 0px; padding: 0px; color: rgb(0, 0, 0); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; font-size-adjust: none; font-stretch: normal; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">　　据悉，汉庭酒店集团在上海的门店数占到全国的近六分之一，在各区县和各大主要商圈都有分布，并且多集中在交通便利和商务活动集中区域。汉庭公关部相关人士表示，从长远来看，汉庭希望在上海这样的单一城市能达到500家门店的目标。“目前上海城市仍处于大发展之中，在新兴城市副中心和周边郊区新城建设中，汉庭还有很多机会优化布局。”</p><p style="font: 14px/22px 宋体, 黑体, 微软雅黑; margin: 0px; padding: 0px; color: rgb(0, 0, 0); text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; font-size-adjust: none; font-stretch: normal; background-color: rgb(255, 255, 255); -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;">　　汉庭在上海发力的同时，其它经济型酒店也没有放慢发展的速度，如家表示希望在8-10年，将整个如家旗下的酒店规模扩张到4000-5000家。锦江之星和7天则紧随其后。并购莫泰使得如家在上海的酒店数量跃居第一，但评论普遍分析，如家能否在上海站稳，关键还要看未来对莫泰的整合效果。</p><br />', '默认管理员', 0, 1, 1331015388, 7, '', '0101'),
(13, 2, '星级酒店、快捷酒店 年初三起入住率达90%', '据如家快捷酒店工作人员介绍，初三、初四入住率都超过90%。平日商务客人占绝大部分，春节期间游客成为主要消费群体。', '<p>据如家快捷酒店工作人员介绍，初三、初四入住率都超过90%。平日商务客人占绝大部分，春节期间游客成为主要消费群体。</p><p>　　在旅游景区附近的宾馆格外紧俏。黄金大酒店因大年夜天宁寺的撞钟祈福活动和年初五迎财神习俗，吸引了不少上海、苏州、无锡游客前来，初四入住率近95%。和平假日饭店客房部负责人则说，春节期间，本地市民和外地游客各占一半，平均入住率比去年同期增长10%左右。</p><p>　　今年春节期间，除了外地游客，本地市民也开始成为快捷酒店的主力军。</p><p>　　“我们从年初三开始就很忙，入住率达到90%，如果算上钟点房，入住率远超过100%。”如家快捷酒店通江太湖路店岳店长说，“就我们单店情况来说，本地市民占到60%左右。”</p><p>　　“今年的本地市民入住率比往年高，每天下午5点钟左右，标准间就售卖一空了。”市中心一快捷酒店介绍说。另外，今年春节期间，气温较低，不少家中有老人、小孩的市民在家洗澡不方便，在比较洗浴场所的价格和酒店钟点房的房价后，选择了后者。</p><p>　　记者从莫泰168、汉庭快捷等酒店了解到，本地市民入住率也比往年有提高，工作人员预计在元宵节前还会有入住小高峰出现。</p><br />', '默认管理员', 0, 1, 1331015408, 15, '', '0101'),
(14, 2, '如家CEO:人力资源是快捷酒店未来主要挑战', '新华08网纽约2月17日电（记者俞靓 纪振宇）随着近年来中国经济的快速发展，快捷经济型酒店行业也得到快速发展。对此，如家酒店首席执行官孙坚接受新华社记者专访时表示，目前快捷经济型酒店行业仍处在初步发展阶段，品牌建设将是将来核心竞争力所在，人力资源则是未来行业面临的主要挑战。', '新华08网纽约2月17日电（记者俞靓 纪振宇）随着近年来中国经济的快速发展，快捷经济型酒店行业也得到快速发展。对此，如家酒店首席执行官孙坚接受新华社记者专访时表示，目前快捷经济型酒店行业仍处在初步发展阶段，品牌建设将是将来核心竞争力所在，人力资源则是未来行业面临的主要挑战。<p>自2006年在纽约纳斯达克交易所上市以来，如家的股票价格一直比较稳定，在中国概念股中表现较为优异。孙坚表示，作为一家上市公司，虽然没法控制整个市场的大势，但是完全可以做好作为公司应该做的事情，兑现对投资者的承诺，这样自然容易获得投资者信任。</p><p><br />新华08网纽约2月17日电（记者俞靓 纪振宇）随着近年来中国经济的快速发展，快捷经济型酒店行业也得到快速发展。对此，如家酒店首席执行官孙坚接受新华社记者专访时表示，目前快捷经济型酒店行业仍处在初步发展阶段，品牌建设将是将来核心竞争力所在，人力资源则是未来行业面临的主要挑战。</p><p>自2006年在纽约纳斯达克交易所上市以来，如家的股票价格一直比较稳定，在中国概念股中表现较为优异。孙坚表示，作为一家上市公司，虽然没法控制整个市场的大势，但是完全可以做好作为公司应该做的事情，兑现对投资者的承诺，这样自然容易获得投资者信任。</p><p>自2002年创办以来，如家已从上市之初的82家酒店发展到目前在全国200个城市的1400多家酒店。其实，这也是整个快捷经济型酒店行业发展的缩影。短短几年，各类经济型酒店如雨后春笋般出现在各个城市的街头巷尾。</p><p>对此，孙坚表示，尽管近年来国内经济型酒店行业发展迅速，但还是处于起步阶段，未来发展潜力非常大。他说:“对如家来说，我们已经占据了先发优势。他介绍说，未来5-10年时间内，将把如家酒店数由目前的1400多家扩展到5000家。</p><p>此外，孙坚表示，未来还将考虑把如家业务逐渐拓展至东亚、欧洲以及美洲地区。他说，如今越来越多中国人出境旅游，如家将抓住这个机会发展世界版图。</p><p>谈到未来的挑战，孙坚认为，随着中国劳动力成本增加，人力资源是未来面临的最大挑战。他说，按照每一家店30-40人的规模来计算，未来如家员工数最多可能达到20万人。</p>孙坚说:“数量本身是一个挑战，第二是质量，是不是有合适的人提供好的服务。”为此，企业已成立了如家大学，给每一个员工学习的机会，提高生产效率，缓解用工成本上升压力。”(完)<br />', '默认管理员', 0, 1, 1331015428, 49, '', '0101'),
(15, 2, '“如家快捷酒店”的启示', ' “如家”从创建到现在已经进入了第十个年头，作为中国经济型酒店的先驱，它发端于豪华酒店如林的边缘，如今，“如家”的牌匾已经在上千家饭店高悬，这个在国际上尚且生疏的名字已居全球最大饭店集团排行榜的第十三位。这一局面，恐怕在十年之前很少人曾经想到的事情。', '<p> “如家”从创建到现在已经进入了第十个年头，作为中国经济型酒店的先驱，它发端于豪华酒店如林的边缘，如今，“如家”的牌匾已经在上千家饭店高悬，这个在国际上尚且生疏的名字已居全球最大饭店集团排行榜的第十三位。这一局面，恐怕在十年之前很少人曾经想到的事情。</p><p>{虹桥#10}</p><p> &nbsp; &nbsp;2011年9月世界权威行业杂志《饭店》(HOTEL)发布《世界饭店325排行榜》的时候，使用了这样一个醒目的标题：《排行榜上，中国公司扶摇而上》。标题下的提示词中说到，“在以往十年大部分的时间中，中国饭店具有极大的发展机会一直是这个行业谈论的话题，而2010年则是这个潜能变现实的拐点之年”。文中特别提到，“尽管325榜单上十大国际饭店公司强烈而持续地推动着中国饭店规模的扩大，然而，近来真正吸引投资商所关注的则是中国国内经济型酒店品牌。四个原本名不见经传的品牌，已经跃升到世界50大品牌名单之中，它们是如家、锦江之星、七天和莫泰。值得注意的是，5月份上海莫泰被如家以4.7亿美元所收购，这一兼并的结果使合并后的公司客房数超过10万间，在明年，它将是在最近5年中挤进世界十强的第一个新公司”。中国的“如家”在崛起，如家的崛起引起了世界的关注。</p><p> &nbsp; &nbsp;面对强手如林的激烈竞争，在短短十年的时间，如家做出了如此让世界关注、同行羡慕的成绩，这给了我们很多有益的启示。</p><p> &nbsp; &nbsp;一、产业的发展在天作，企业的发展在人为</p><p> &nbsp; &nbsp;饭店业是个古老的行业，它的出现远远早于现代旅游业。然而，囿于社会经济发展的特殊过程及其复杂的历史原因，中国的现代饭店业姗姗而至，蹒跚而行。它真正的发展应从上个世纪70年代末改革开放算起。但在相当长的一段时间里，非常规的旅游发展模式使中国的饭店业首先以满足入境旅游者需求而兴起，并随着旅游发展的模式变化而变化。但就总体而言，在进入新世纪以前，一直是高星级饭店引导着中国现代饭店业的潮流，国际饭店集团占据着优先地位，虽然国内非星级饭店数量也不算少，但没有一个国内知名的品牌，更不用说世界知名了。</p><p> &nbsp; &nbsp;上个世纪90年代中期以后，随着改革开放的深入，国民收入的普遍提高、政府假期制度的改革和旅游发展政策的调整，国民旅游需求不断提高，国内旅游的迅速发展对大众旅游住宿设施的需求与日俱增。着眼于满足入境旅游和商务旅行市场需求的星级饭店与过于陈旧落后的社会旅馆之间，出现了一个很大空档。于是，这个不断扩大的大众旅游市场需求为经济型酒店这一新业态的发展创造了机会，现实的市场需求催生了一个新业态，而新业态的发展又引导与刺激着市场的需求。这就是本世纪初中国经济型酒店发展的大背景。</p><p> &nbsp; &nbsp;发展的机会是客观存在的，也是平等的。对于企业来说，关键在于是否能敏锐地发现机会，并有胆识和能力抓住机会。大家都清楚，自上个世纪80年代旅游大发展以来，中国的高星级饭店建造的热潮此起彼伏，逐浪而兴。从大城市到小城镇，从沿海到边陲，从经济发达地区到欠发达地区，席卷全国各地。投资商与经营商，更是从国内到海外，趋之若鹜，试比高下。尽管一些地方尚没有足够的市场，尽管一些地方尚无吸引高消费访客能力，大家都会千方百计地找出这样或那样的理由，来说服别人和自己，大兴土木，尽力建造豪华饭店，尽量想法冠上一个体面的洋牌子，难以摆脱“形象工程”的陷阱和误区。</p><p> &nbsp; &nbsp;然而，其间，有一批企业家，敏锐地发现了这个成长的市场，并能很快地抓住机会，努力拼搏，闯出了一条自己发展的道路。如家的创始人就在其中。先行者的艰辛是可想而知的，也许在发展之初，更多的是借鉴国际经验和已知的发展模式，这是必须的，是有益的，据此迈开了重要的第一步。但像如家这样的企业，能够得以快速的发展，还在于它对本国国情的了解与认知。诚然，如何保证让“淮南之橘”不蜕变成“淮北之枳”，成为一个真正具有生命力的“中国制造”，这还将会是一个长期要面临的挑战。</p><p>上千家饭店高悬，这个在国际上尚且生疏的名字已居全球最大饭店集团排行榜的第十三位。这一局面，恐怕在十年之前很少人曾经想到的事情。<br /></p>', '默认管理员', 0, 1, 1364441006, 0, '', '0101');

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_article_class`
--

CREATE TABLE IF NOT EXISTS `zhuna_article_class` (
  `class_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` char(30) NOT NULL DEFAULT '',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `orderid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`class_id`),
  KEY `pid` (`pid`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `zhuna_article_class`
--

INSERT INTO `zhuna_article_class` (`class_id`, `class_name`, `pid`, `orderid`) VALUES
(1, '旅游特产(购物)', 0, 2),
(2, '旅游游记', 0, 15);

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_flink`
--

CREATE TABLE IF NOT EXISTS `zhuna_flink` (
  `flink_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `flink_title` char(30) NOT NULL DEFAULT '',
  `flink_link` char(60) NOT NULL DEFAULT '',
  `flink_type_radio` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `flink_uploadfile` varchar(255) NOT NULL DEFAULT '',
  `flink_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `flink_starttime` int(11) unsigned NOT NULL DEFAULT '0',
  `flink_endtime` int(11) unsigned NOT NULL DEFAULT '0',
  `flink_state_radio` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `flink_addtime` int(11) unsigned NOT NULL DEFAULT '0',
  `flink_addusername` varchar(20) NOT NULL DEFAULT '',
  `flink_externallinks` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`flink_id`),
  KEY `flink_type_radio` (`flink_type_radio`),
  KEY `flink_order` (`flink_order`),
  KEY `flink_state_radio` (`flink_state_radio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `zhuna_flink`
--

INSERT INTO `zhuna_flink` (`flink_id`, `flink_title`, `flink_link`, `flink_type_radio`, `flink_uploadfile`, `flink_order`, `flink_starttime`, `flink_endtime`, `flink_state_radio`, `flink_addtime`, `flink_addusername`, `flink_externallinks`) VALUES
(1, '艺程网', 'http://phpv2.be88.cn/', 1, '', 0, 0, 0, 2, 1323221729, 'admin', ''),
(2, '艺游网', 'http://phpv3.be88.cn', 1, '', 0, 0, 0, 2, 1323222410, 'admin', ''),
(3, '北京酒店团购', 'http://jiudian138.com', 1, '', 0, 0, 0, 2, 1323222410, 'admin', ''),
(4, '酒店分销', 'http://union.zhuna.cn', 1, '', 0, 0, 0, 2, 1323222410, 'admin', '');

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_keywords`
--

CREATE TABLE IF NOT EXISTS `zhuna_keywords` (
  `k_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `k_pagename` varchar(30) NOT NULL DEFAULT '',
  `k_page` varchar(60) NOT NULL DEFAULT '',
  `k_title` varchar(250) NOT NULL DEFAULT '',
  `k_keywords` text NOT NULL,
  `k_description` text NOT NULL,
  `k_time` int(11) unsigned NOT NULL,
  `k_rule` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`k_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `zhuna_keywords`
--

INSERT INTO `zhuna_keywords` (`k_id`, `k_pagename`, `k_page`, `k_title`, `k_keywords`, `k_description`, `k_time`, `k_rule`) VALUES
(1, '首页', 'index', '酒店预订_酒店价格查询_酒店住宿信息-{doname}', '酒店预订,酒店价格查询,酒店住宿信息', '{doname}为您提供酒店预订,宾馆预定等服务', 1363938042, '{doname}=网站名称'),
(2, '城市酒店', 'city', '全国特价酒店预订_全国酒店城市大全_{doname}', '酒店,酒店分布,国内酒店', '{doname}为您提供国内酒店预订,国内宾馆预定等服务', 1294283940, '{doname}=网站名称'),
(3, '酒店点评', 'comment', '{cityname}酒店点评_{cityname}哪个酒店好？_{cityname}酒店怎么样？{doname}', '酒店预订,酒店点评,{cityname}哪个酒店好', '{doname}为您提供最权威,最新的酒店点评数据,国内酒店预订,国内宾馆预定等服务', 1294283980, '{cityname}=城市名 {doname}=网站名'),
(4, '酒店问答', 'question', '{cityname}酒店问答_{cityname}酒店提问_{doname}', '酒店提问,酒店问答', '{doname}为您提供最权威,最新的酒店问答数据,国内酒店预订,国内宾馆预定等服务', 1294284086, '{cityname}=城市名 {doname}=网站名'),
(5, '出行资讯', 'news', '{classname}_{doname}', '{classname}', '{doname}为您提供最权威的{classname}', 1320820187, '{classname}=类别名称 {doname}=网站名称'),
(6, '城市地标', 'lable', '{cityname}酒店查询_{cityname}宾馆查询_{doname}', '{cityname}酒店查询,{cityname}宾馆查询', '{doname}为您提供最可信,最权威的{cityname}酒店查询,{cityname}宾馆查询', 1294284531, '{cityname}=城市名 {doname}=网站名'),
(7, '酒店搜索', 'hotellist', '{cityname}{key?附近}{bidname}{lsname}{star?星级}{minjiage?元}{maxjiage?元}{hn}酒店宾馆预订_{cityname}{key}{bidname}{lsname}{star?星级}{minjiage?元}{maxjiage?元}{hn}便宜住宿信息价格查询_{cityname}{key}{bidname}{lsname}{star?星级}{minjiage?元}{maxjiage?元}{hn}_{doname}', '{cityname}{key?附近}{bidname}{lsname}{star?星级}{minjiage?元}{maxjiage?元}{hn}酒店预订,{cityname}酒店', '{doname}为您提供最可信,最权威的{cityname}{key?附近}{bidname}{lsname}{star?星级}{minjiage?元}{maxjiage?元}{hn}酒店,{cityname}{key}{bidname}{lsname}{star?星级}{minjiage?元}{maxjiage?元}{hn}宾馆预订,{cityname}{key}{bidname}{lsname}{star?星级}{minjiage?元}{maxjiage?元}{hn}等服务', 1363938593, '{doname}=网站名称 {key}=搜索关键字 {bidname}=商业区名称 {lsname}=连锁名称 {cityname}=城市名称  {star}=星级 {minjiage}=最低价 {maxjiage}=最高价 {hn}=酒店名'),
(8, '酒店详细页面', 'hotelinfo', '{hotelnames}免费预订_点评_怎么样_地图_{doname}', '{hotelnames}酒店预定,{hotelnames}酒店价格, {hotelnames}酒店酒店信息, {cityname}酒店预订', '{doname}酒店预订频道为你提供全面的{hotelnames}预订信息,包括{hotelnames}地址、{hotelnames}附近环境、{hotelnames}价格、{hotelnames}点评、{hotelnames}地图、{hotelnames}电话等详细信息！订该酒店返现金.\r\n ', 1298457519, '{hotelnames}=酒店名称 {doname}=网站名称 {cityname}=城市名称'),
(9, '客人点评', 'hotelcomment', '{hotelnames}酒店评论_{cityname}酒店预订_{doname}', '{hotelnames}酒店评论,{cityname}酒店预订', '{doname}为您提供最可信,最权威的{hotelnames}酒店评论,{cityname}酒店预订', 1294284720, '{hotelnames}=酒店名称 {doname}=网站名称 {cityname}=城市名称'),
(10, '酒店问答', 'hotelquestion', '{hotelnames}酒店问答_{cityname}酒店预订_{doname}', '{hotelnames}酒店问答,{cityname}酒店预订', '{doname}为您提供最可信,最权威的{hotelnames}酒店问答,{cityname}酒店预订', 1294284784, '{hotelnames}=酒店名称 {doname}=网站名称 {cityname}=城市名称'),
(11, '展会', 'expo', '{classname}_{doname}', '{classname}', '{doname}为您提供最权威的{classname}', 1320820187, '{classname}=类别名称 {doname}=网站名称'),
(12, '展会详细', 'expoinfo', '{title}_{classname}_{cityname}酒店_{doname}', '{classname},{cityname}酒店', '{doname}为您提供信息量最大,信心最可信的{classname}信息:{title};{cityname}酒店', 1294284899, '{title}=文章标题 {doname}=网站名称 {cityname}=城市名称 {classname}=文章类别名'),
(13, '展会资讯详细', 'exponews', '{title}_{classname}_{cityname}酒店_{doname}', '{classname},{cityname}酒店', '{doname}为您提供信息量最大,信心最可信的{classname}信息:{title};{cityname}酒店', 1294284899, '{title}=文章标题 {doname}=网站名称 {cityname}=城市名称 {classname}=文章类别名'),
(14, '帮助中心', 'help', '{doname}帮助中心', '{doname}帮助中心', '{doname}帮助中心', 1330507820, '{doname}=网站名'),
(15, '全国展馆', 'ehc', '{classname}_{doname}', '{classname}', '{doname}为您提供最权威的{classname}', 131115478, '{classname}=类别名称 {doname}=网站名称'),
(16, '会员登录页面', 'member', '酒店预订_酒店价格查询_酒店住宿信息-{doname}', '酒店预订,酒店价格查询,酒店住宿信息', '{doname}为您提供酒店预订,宾馆预定等服务', 1363938042, '{doname}=网站名称'),
(17, '出行资讯详细', 'newsinfo', '{title}_{classname}_{cityname}酒店_{doname}', '{classname},{cityname}酒店', '{doname}为您提供信息量最大,信心最可信的{classname}信息:{title};{cityname}酒店', 1294284899, '{title}=文章标题 {doname}=网站名称 {cityname}=城市名称 {classname}=文章类别名'),
(18, '城市酒店', 'onecity', '{cityname}酒店预订_{cityname}酒店价格查询_{cityname}住宿信息-{doname}', '{cityname}酒店预订_{cityname}酒店价格查询_{cityname}住宿信息', '{doname}为您提供网上2-7折优惠{cityname}酒店预订、{cityname}宾馆预订、{cityname}住宿信息、{cityname}酒店价格查询,包含各类星级酒店（包括各类城市经济型商务酒店）订房服务，价格信息，房间数量实时更新，订{cityname}酒店返现金！', 1366189354, '{cityname}=城市名 {doname}=网站名');

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_layout`
--

CREATE TABLE IF NOT EXISTS `zhuna_layout` (
  `layout_id` smallint(8) NOT NULL AUTO_INCREMENT,
  `layout_module` text,
  `layout_page` varchar(255) NOT NULL DEFAULT '',
  `layout_pagename` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`layout_id`),
  KEY `layout_page` (`layout_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `zhuna_layout`
--

INSERT INTO `zhuna_layout` (`layout_id`, `layout_module`, `layout_page`, `layout_pagename`) VALUES
(1, '1_a1-1_a1搜索|7_a2-1_a2幻灯广告|13_a3-1_a3推荐酒店|70_a4-6_a4快速查找|21_a5-1_a5热门酒店|26_a6-3_a6预定排行|29_a7-1_a7品牌连锁|32_a8-1_a8最新订单|38_a9-2_a9问答和点评|41_a10-1_a10最新资讯|46_a11-1_a11广告|48_a12-1_a12友情连接', 'index', '首页'),
(2, '1_a1-1_a1搜索|7_a2-1_a2幻灯广告|13_a3-1_a3推荐酒店|70_a4-6_a4快速查找|21_a5-1_a5热门酒店|26_a6-3_a6预定排行|29_a7-1_a7品牌连锁|32_a8-1_a8最新订单|38_a9-2_a9问答和点评|41_a10-1_a10最新资讯|46_a11-1_a11广告|48_a12-1_a12友情连接', 'onecity', '城市酒店'),
(3, '72_newsclass_资讯分类|54_news_最新资讯|62_exponews_展会新闻|61_besthotel_推荐酒店', 'news', '新闻列表页'),
(4, '52_order_最新订单|58_hothotel_热门酒店|57_lable_北京地标|56_history_浏览记录', 'hotellist', '酒店列表页'),
(5, '65_roundhotel_附近酒店|58_hothotel_热门酒店|57_lable_北京地标|56_history_浏览记录', 'hotelinfo', '酒店详情页'),
(6, '61_besthotel_推荐酒店|62_exponews_展会新闻|54_news_最新资讯|58_history_浏览记录', 'newsinfo', '新闻详情页'),
(7, '61_besthotel_推荐酒店|62_exponews_展会新闻|54_news_最新资讯|56_history_浏览记录', 'expo', '展会列表页'),
(8, '65_roundhotel_附近酒店|62_exponews_展会新闻|54_news_最新资讯|56_history_浏览记录', 'expoinfo', '展会详情页'),
(9, '61_besthotel_推荐酒店|57_lable_城市地标|54_news_最新资讯|58_history_浏览记录', 'help', '帮助页'),
(10, '61_besthotel_推荐酒店|57_lable_城市地标|54_news_最新资讯|58_history_浏览记录', 'exponews', '展会新闻详情页'),
(11, '51_comment_酒店点评|57_lable_城市地标|61_besthotel_推荐酒店|58_history_浏览记录', 'ask', '酒店问答页'),
(12, '50_ask_酒店问答|57_lable_城市地标|61_besthotel_推荐酒店|58_history_浏览记录', 'comment', '酒店点评页');


-- --------------------------------------------------------

--
-- 表的结构 `zhuna_module`
--

CREATE TABLE IF NOT EXISTS `zhuna_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(30) NOT NULL DEFAULT '',
  `title` varchar(30) DEFAULT NULL,
  `remark` varchar(255) DEFAULT '',
  `page` varchar(255) NOT NULL DEFAULT '',
  `location` char(10) NOT NULL DEFAULT '',
  `order` smallint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `module_order` (`order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- 转存表中的数据 `zhuna_module`
--

INSERT INTO `zhuna_module` (`id`, `filename`, `title`, `remark`, `page`, `location`, `order`) VALUES
(1, 'a1-1', 'a1搜索', 'a1搜索', 'index', 'a1', 1),
(2, 'a1-2', 'a1预定排行', 'a1预定排行', 'index', 'a1', 2),
(3, 'a1-3', 'a1最新资讯', 'a1最新资讯', 'index', 'a1', 3),
(4, 'a1-4', 'a1最新订单', 'a1最新订单', 'index', 'a1', 4),
(5, 'a1-5', 'a1酒店问答', 'a1酒店问答', 'index', 'a1', 5),
(6, 'a1-6', 'a1酒店点评', 'a1酒店点评', 'index', 'a1', 6),
(7, 'a2-1', 'a2幻灯广告', 'a2幻灯广告', 'index', 'a2', 1),
(8, 'a2-2', 'a2酒店点评', 'a2酒店点评', 'index', 'a2', 2),
(9, 'a2-3', 'a2酒店问答', 'a2酒店问答', 'index', 'a2', 3),
(10, 'a2-4', 'a2预定排行', 'a2预定排行', 'index', 'a2', 4),
(11, 'a2-5', 'a2最新资讯', 'a2最新资讯', 'index', 'a2', 5),
(12, 'a2-6', 'a2最新订单', 'a2最新订单', 'index', 'a2', 6),
(13, 'a3-1', 'a3推荐酒店', 'a3推荐酒店', 'index', 'a3', 1),
(14, 'a3-2', 'a3热门酒店', 'a3热门酒店', 'index', 'a3', 2),
(15, 'a3-3', 'a3品牌连锁', 'a3品牌连锁', 'index', 'a3', 3),
(16, 'a4-1', 'a4酒店点评', 'a4酒店点评', 'index', 'a4', 1),
(17, 'a4-2', 'a4酒店问答', 'a4酒店问答', 'index', 'a4', 2),
(18, 'a4-3', 'a4预定排行', 'a4预定排行', 'index', 'a4', 3),
(19, 'a4-4', 'a4最新资讯', 'a4最新资讯', 'index', 'a4', 4),
(20, 'a4-5', 'a4最新订单', 'a4最新订单', 'index', 'a4', 5),
(21, 'a5-1', 'a5品牌连锁', 'a5品牌连锁', 'index', 'a5', 1),
(22, 'a5-2', 'a5热门酒店', 'a5热门酒店', 'index', 'a5', 2),
(23, 'a5-3', 'a5推荐酒店', 'a5推荐酒店', 'index', 'a5', 3),
(24, 'a6-1', 'a6酒店点评', 'a6酒店点评', 'index', 'a6', 1),
(25, 'a6-2', 'a6酒店问答', 'a6酒店问答', 'index', 'a6', 2),
(26, 'a6-3', 'a6预定排行', 'a6预定排行', 'index', 'a6', 3),
(27, 'a6-4', 'a6最新资讯', 'a6最新资讯', 'index', 'a6', 4),
(28, 'a6-5', 'a6最新订单', 'a6最新订单', 'index', 'a6', 5),
(29, 'a7-1', 'a7热门酒店', 'a7热门酒店', 'index', 'a7', 1),
(30, 'a7-2', 'a7推荐酒店', 'a7推荐酒店', 'index', 'a7', 2),
(31, 'a7-3', 'a7品牌连锁', 'a7品牌连锁', 'index', 'a7', 3),
(32, 'a8-1', 'a8最新订单', 'a8最新订单', 'index', 'a8', 1),
(33, 'a8-2', 'a8酒店点评', 'a8酒店点评', 'index', 'a8', 2),
(34, 'a8-3', 'a8酒店问答', 'a8酒店问答', 'index', 'a8', 3),
(35, 'a8-4', 'a8预定排行', 'a8预定排行', 'index', 'a8', 4),
(36, 'a8-5', 'a8最新资讯', 'a8最新资讯', 'index', 'a8', 5),
(37, 'a9-1', 'a9点评问答', 'a9点评和问答', 'index', 'a9', 1),
(38, 'a9-2', 'a9问答点评', 'a9问答和点评', 'index', 'a9', 2),
(39, 'a9-3', 'a9预定排行资讯', 'a9预定排行和资讯', 'index', 'a9', 3),
(40, 'a9-4', 'a9资讯预定排行 ', 'a9资讯和预定排行 ', 'index', 'a9', 4),
(41, 'a10-1', 'a10最新资讯', 'a10最新资讯', 'index', 'a10', 1),
(42, 'a10-2', 'a10酒店点评', 'a10酒店点评', 'index', 'a10', 2),
(43, 'a10-3', 'a10酒店问答', 'a10酒店问答', 'index', 'a10', 3),
(44, 'a10-4', 'a10预定排行', 'a10预定排行', 'index', 'a10', 4),
(45, 'a10-5', 'a10最新订单', 'a10最新订单', 'index', 'a10', 5),
(46, 'a11-1', 'a11广告', 'a11广告', 'index', 'a11', 1),
(47, 'a11-2', 'a11友情连接', 'a11友情连接', 'index', 'a11', 2),
(48, 'a12-1', 'a12友情连接', 'a12友情连接', 'index', 'a12', 0),
(49, 'a12-2', 'a12广告', 'a12广告', 'index', 'a12', 0),
(50, 'ask', '酒店问答', '酒店问答', 'list|info|newsl', '', 0),
(51, 'comment', '酒店点评', '酒店点评', 'list|info|newsl', '', 0),
(52, 'order', '最新订单', '最新订单', 'list|info|newsl', '', 0),
(53, 'ranklist', '预定排行', '预定排行', 'list|info|newsl', '', 0),
(54, 'news', '最新资讯', '最新资讯', 'list|info|newsl', '', 0),
(55, 'help', '酒店帮助', '酒店帮助', 'list|info|newsl', '', 0),
(56, 'history', '浏览记录', '浏览记录', 'list|info|newsl', '', 0),
(57, 'lable', '城市地标', '北京地标', 'list|info|newsl', '', 0),
(58, 'hothotel', '热门酒店', '热门酒店', 'list|info|newsl', '', 0),
(59, 'expo', '展会信息', '展会信息', 'list|info|newsl', '', 0),
(61, 'besthotel', '推荐酒店', '推荐酒店', 'list|info|newsl', '', 0),
(62, 'exponews', '展会新闻', '展会新闻', 'list|info|newsl', '', 0),
(65, 'roundhotel', '附近酒店', '附近酒店', 'hotelinfo|expo', '', 0),
(66, 'a3-4', 'a3快速查找', 'a3快速查找', 'index', 'a3', 4),
(68, 'a5-4', 'a5快捷查找', 'a5快捷查找', 'index', 'a5', 4),
(70, 'a4-6', 'a4快速查找', 'a4快速查找', 'index', 'a4', 6),
(71, 'a7-4', 'a7快速查找', 'a7快速查找', 'index', 'a7', 4),
(72, 'newsclass', '资讯分类', '资讯分类', 'list|info|newsl', '', 0),
(73, 'picnews', '图片资讯', '图片资讯', 'list|info|newsl', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_rewrite`
--

CREATE TABLE IF NOT EXISTS `zhuna_rewrite` (
  `rewrite_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `rewrite_org` varchar(255) NOT NULL,
  `rewrite_new` varchar(255) NOT NULL,
  `rewrite_mark` varchar(200) NOT NULL DEFAULT '',
  `is_show` smallint(2) NOT NULL,
  PRIMARY KEY (`rewrite_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `zhuna_rewrite`
--


INSERT INTO `zhuna_rewrite` (`rewrite_id`, `rewrite_org`, `rewrite_new`, `rewrite_mark`, `is_show`) VALUES
(1, 'index', 'default_controller', '', 0),
(2, 'allcity/index/', 'allcity', '城市酒店', 1),
(3, 'onecity/index/$1', 'onecity/([0-9]+)', '城市详情', 1),
(4, 'newsinfo/index/$1', 'newsinfo/([0-9]+)', '新闻详情', 1),
(5, 'news/index/', 'news', '资讯频道', 1),
(6, 'news/index/$1', 'news/([0-9a-zA-Z\\-]+)', '资讯频道', 1),
(7, 'expo/index/', 'expo', '展会', 1),
(8, 'expo/index/$1', 'expo/([0-9a-zA-Z\\-]+)', '展会', 1),
(9, 'expoinfo/index/$1', 'expoinfo/([0-9]+)', '展会详情', 1),
(10, 'hotelinfo/index/$1', 'hotelinfo/([0-9]+)', '酒店详情', 1),
(11, '', '404_override', '', 0),
(12, 'lable/index/', 'lable', '地标', 1),
(13, 'lable/index/$1', 'lable/([0-9a-zA-Z\\-]+)', '地标', 1),
(14, 'ehc/index', 'ehc', '展馆', 1),
(15, 'ehc/index/$1', 'ehc/([0-9a-zA-Z\\-]+)', '展馆', 1),
(16, 'help/index/', 'help', '帮助', 1),
(17, 'comment/index/', 'comment', '酒店点评', 1),
(18, 'comment/index/$1', 'comment/([0-9]+)', '酒店点评', 1),
(19, 'comment/index/$1$2', 'comment/([0-9]+)/([0-9]+)', '酒店点评', 1),
(20, 'ask/index/', 'ask', '酒店问答', 1),
(21, 'ask/index/$1', 'ask/([0-9]+)', '酒店问答 ', 1),
(22, 'ask/index/$1$2', 'ask/([0-9]+)/([0-9]+)', '酒店问答 ', 1),
(23, 'member/index/', 'member', '会员中心', 1),
(24, 'hotellist/index', 'hotellist', '酒店列表', 1),
(25, 'hotellist/index/$1', 'hotellist/(.+)', '酒店列表', 1);




-- --------------------------------------------------------

--
-- 表的结构 `zhuna_sysconfig`
--

CREATE TABLE IF NOT EXISTS `zhuna_sysconfig` (
  `sysid` smallint(8) NOT NULL AUTO_INCREMENT,
  `varname` varchar(30) NOT NULL,
  `info` varchar(150) NOT NULL,
  `type` varchar(10) NOT NULL,
  `value` text NOT NULL,
  `item` text NOT NULL,
  `nameaction` varchar(255) NOT NULL,
  `help` varchar(255) DEFAULT NULL,
  `order` smallint(8) unsigned NOT NULL,
  PRIMARY KEY (`sysid`),
  KEY `order` (`order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `zhuna_sysconfig`
--

INSERT INTO `zhuna_sysconfig` (`sysid`, `varname`, `info`, `type`, `value`, `item`, `nameaction`, `help`, `order`) VALUES
(1, 'cfg_templets_style', '网站颜色', 'radio', 'default', '绿色:default{|}红色:red{|}蓝色:blue{|}黄色:yellow', '', '点击切换网站风格', 0),
(2, 'cfg_templets_layout', '网站布局', 'radio', '0', '左右:0{|}右左:1', '', '点击切换网站布局', 0),
(3, 'cfg_cmspath', '安装目录', 'string', '/', '', '', '', 0),
(4, 'cfg_indexurl', '网站域名', 'string', 'http://ol.zjj.cn', '', '', '', 0),
(5, 'cfg_webname', '网站名称', 'string', '酒店预订网', '', '', '', 0),
(6, 'cfg_powerby', '版权信息', 'bstring', ' 版权：住哪网 联盟事业部  Copyright 2009-2013 Corporation, All Rights Reserved', '', '', '支持html代码', 0),
(7, 'cfg_indexCitylist', '首页选项卡城市', 'select', '0101|北京,0201|上海,2001|广州', '', ' ', ' ', 0),
(8, 'cfg_agentid', '推广ID', 'string', '1232380', '', '', '', 0),
(9, 'cfg_agentmd', '加密字符', 'string', '9ea95c8bcfb34776', '', '', '', 0),
(10, 'cfg_key', '订单保存KEY', 'string', '4fe3db7787fedfa8', '', '', '', 0),
(11, 'cfg_rewrite', '伪静态开关', 'radio', '1', '打开:1{|}关闭:0','','', '0'),
(12, 'cfg_statcode', '统计代码', 'bstring', '51啦|百度|google统计代码', '', '', '请输入统计代码：代码中不允许出现单引号', 0),
(13, 'cfg_cache', '缓存开关', 'radio', '1', '打开:1{|}关闭:0', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_purview`
--

CREATE TABLE IF NOT EXISTS `zhuna_purview` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `parent` mediumint(8) unsigned NOT NULL default '0',
  `class` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `listorder` tinyint(4) unsigned NOT NULL default '99',
  `status` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 导出表中的数据 `zhuna_purview`
--

INSERT INTO `zhuna_purview` (`id`, `parent`, `class`, `title`, `method`, `listorder`, `status`) VALUES
(1, 0, 'content', '内容页面', '', 1, 1),
(2, 1, 'news', '资讯管理', 'add,edit,del', 1, 1),
(3, 1, 'newsclass', '资讯分类', 'add,edit,del', 2, 1),
(4, 1, 'flink', '友情链接', 'add,edit,del', 3, 1),
(17, 16, 'config', '网站设置', 'edit', 1, 1),
(5, 1, 'ad', '广告管理', 'add,edit,del', 4, 1),
(16, 0, 'config', '网站管理', '', 2, 1),
(7, 6, 'config', '网站设置', 'edit', 1, 1),
(8, 6, 'keywords', '页面关键字管理', 'edit', 2, 1),
(9, 6, 'manager', '帐户管理', 'add,edit,del', 3, 1),
(10, 6, 'purview', '权限菜单', 'add,edit,del', 4, 1),
(11, 6, 'usergroup', '用户组', 'add,edit,del', 5, 1),
(12, 6, 'data', '数据备份', 'add,edit,del', 6, 1),
(13, 0, 'module', '页面定制', '', 3, 1),
(14, 13, 'templates', '页面管理', 'edit', 1, 1),
(15, 13, 'rewrite', '伪静态设置', 'edit', 2, 1),
(18, 16, 'keywords', '页面关键字管理', 'edit', 2, 1),
(19, 23, 'manager', '帐户管理', 'add,edit,del', 1, 1),
(20, 23, 'purview', '权限菜单', 'add,edit,del', 2, 1),
(21, 23, 'usergroup', '用户组', 'add,edit,del', 3, 1),
(22, 16, 'data', '数据备份/数据还原', 'add,edit,del', 3, 1),
(23, 0, 'useradmin', '管理员管理', '', 4, 1);

-- --------------------------------------------------------

--
-- 表的结构 `zhuna_usergroup`
--

CREATE TABLE IF NOT EXISTS `zhuna_usergroup` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `listorder` tinyint(4) unsigned NOT NULL default '99',
  `purview` text NOT NULL,
  `isupdate` tinyint(1) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 导出表中的数据 `zhuna_usergroup`
--

INSERT INTO `zhuna_usergroup` (`id`, `title`, `listorder`, `purview`, `isupdate`, `status`) VALUES
(1, '系统管理员', 1, 'a:4:{i:0;a:16:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:2:"17";i:3;s:2:"14";i:4;s:2:"19";i:5;s:1:"3";i:6;s:2:"16";i:7;s:2:"15";i:8;s:2:"18";i:9;s:2:"20";i:10;s:1:"4";i:11;s:2:"21";i:12;s:2:"22";i:13;s:2:"23";i:14;s:1:"5";i:15;s:2:"13";}i:1;a:15:{s:7:"content";a:3:{s:2:"id";s:1:"1";s:5:"class";s:7:"content";s:6:"method";b:0;}s:4:"news";a:3:{s:2:"id";s:1:"2";s:5:"class";s:4:"news";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:6:"config";a:3:{s:2:"id";s:2:"16";s:5:"class";s:6:"config";s:6:"method";a:2:{i:0;s:2:"on";i:1;s:4:"edit";}}s:9:"templates";a:3:{s:2:"id";s:2:"14";s:5:"class";s:9:"templates";s:6:"method";a:2:{i:0;s:2:"on";i:1;s:4:"edit";}}s:7:"manager";a:3:{s:2:"id";s:2:"19";s:5:"class";s:7:"manager";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:9:"newsclass";a:3:{s:2:"id";s:1:"3";s:5:"class";s:9:"newsclass";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:7:"rewrite";a:3:{s:2:"id";s:2:"15";s:5:"class";s:7:"rewrite";s:6:"method";a:2:{i:0;s:2:"on";i:1;s:4:"edit";}}s:8:"keywords";a:3:{s:2:"id";s:2:"18";s:5:"class";s:8:"keywords";s:6:"method";a:2:{i:0;s:2:"on";i:1;s:4:"edit";}}s:7:"purview";a:3:{s:2:"id";s:2:"20";s:5:"class";s:7:"purview";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:5:"flink";a:3:{s:2:"id";s:1:"4";s:5:"class";s:5:"flink";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:9:"usergroup";a:3:{s:2:"id";s:2:"21";s:5:"class";s:9:"usergroup";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:4:"data";a:3:{s:2:"id";s:2:"22";s:5:"class";s:4:"data";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:8:"personal";a:3:{s:2:"id";s:2:"23";s:5:"class";s:8:"personal";s:6:"method";b:0;}s:2:"ad";a:3:{s:2:"id";s:1:"5";s:5:"class";s:2:"ad";s:6:"method";a:4:{i:0;s:2:"on";i:1;s:3:"add";i:2;s:4:"edit";i:3;s:3:"del";}}s:6:"module";a:3:{s:2:"id";s:2:"13";s:5:"class";s:6:"module";s:6:"method";b:0;}}i:2;a:5:{i:0;a:4:{i:0;a:7:{s:2:"id";s:1:"1";s:6:"parent";s:1:"0";s:5:"class";s:7:"content";s:5:"title";s:12:"内容页面";s:6:"method";s:0:"";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"16";s:6:"parent";s:1:"0";s:5:"class";s:6:"config";s:5:"title";s:12:"网站管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"23";s:6:"parent";s:1:"0";s:5:"class";s:8:"personal";s:5:"title";s:12:"用户管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}i:3;a:7:{s:2:"id";s:2:"13";s:6:"parent";s:1:"0";s:5:"class";s:6:"module";s:5:"title";s:12:"页面定制";s:6:"method";s:0:"";s:9:"listorder";s:1:"4";s:6:"status";s:1:"1";}}i:1;a:4:{i:0;a:7:{s:2:"id";s:1:"2";s:6:"parent";s:1:"1";s:5:"class";s:4:"news";s:5:"title";s:12:"资讯管理";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:1:"3";s:6:"parent";s:1:"1";s:5:"class";s:9:"newsclass";s:5:"title";s:12:"资讯分类";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:1:"4";s:6:"parent";s:1:"1";s:5:"class";s:5:"flink";s:5:"title";s:12:"友情链接";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}i:3;a:7:{s:2:"id";s:1:"5";s:6:"parent";s:1:"1";s:5:"class";s:2:"ad";s:5:"title";s:12:"广告管理";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"4";s:6:"status";s:1:"1";}}i:16;a:3:{i:0;a:7:{s:2:"id";s:2:"17";s:6:"parent";s:2:"16";s:5:"class";s:6:"config";s:5:"title";s:12:"网站设置";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"18";s:6:"parent";s:2:"16";s:5:"class";s:8:"keywords";s:5:"title";s:21:"页面关键字管理";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"22";s:6:"parent";s:2:"16";s:5:"class";s:4:"data";s:5:"title";s:25:"数据备份/数据还原";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}}i:13;a:2:{i:0;a:7:{s:2:"id";s:2:"14";s:6:"parent";s:2:"13";s:5:"class";s:9:"templates";s:5:"title";s:12:"页面管理";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"15";s:6:"parent";s:2:"13";s:5:"class";s:7:"rewrite";s:5:"title";s:15:"伪静态设置";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}}i:23;a:3:{i:0;a:7:{s:2:"id";s:2:"19";s:6:"parent";s:2:"23";s:5:"class";s:7:"manager";s:5:"title";s:12:"帐户管理";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"20";s:6:"parent";s:2:"23";s:5:"class";s:7:"purview";s:5:"title";s:12:"权限菜单";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"21";s:6:"parent";s:2:"23";s:5:"class";s:9:"usergroup";s:5:"title";s:9:"用户组";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}}}i:3;a:4:{i:1;a:7:{s:2:"id";s:1:"1";s:6:"parent";s:1:"0";s:5:"class";s:7:"content";s:5:"title";s:12:"内容页面";s:6:"method";s:0:"";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:16;a:7:{s:2:"id";s:2:"16";s:6:"parent";s:1:"0";s:5:"class";s:6:"config";s:5:"title";s:12:"网站管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:23;a:7:{s:2:"id";s:2:"23";s:6:"parent";s:1:"0";s:5:"class";s:8:"personal";s:5:"title";s:12:"用户管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}i:13;a:7:{s:2:"id";s:2:"13";s:6:"parent";s:1:"0";s:5:"class";s:6:"module";s:5:"title";s:12:"页面定制";s:6:"method";s:0:"";s:9:"listorder";s:1:"4";s:6:"status";s:1:"1";}}}', 1, 1),
(6, '网站编辑', 2, 'a:4:{i:0;a:16:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:2:"17";i:3;s:2:"14";i:4;s:2:"19";i:5;s:1:"3";i:6;s:2:"16";i:7;s:2:"15";i:8;s:2:"18";i:9;s:2:"20";i:10;s:1:"4";i:11;s:2:"13";i:12;s:2:"21";i:13;s:2:"22";i:14;s:1:"5";i:15;s:2:"23";}i:1;a:15:{s:7:"content";a:3:{s:2:"id";s:1:"1";s:5:"class";s:7:"content";s:6:"method";b:0;}s:4:"news";a:3:{s:2:"id";s:1:"2";s:5:"class";s:4:"news";s:6:"method";b:0;}s:6:"config";a:3:{s:2:"id";s:2:"16";s:5:"class";s:6:"config";s:6:"method";b:0;}s:9:"templates";a:3:{s:2:"id";s:2:"14";s:5:"class";s:9:"templates";s:6:"method";b:0;}s:7:"manager";a:3:{s:2:"id";s:2:"19";s:5:"class";s:7:"manager";s:6:"method";b:0;}s:9:"newsclass";a:3:{s:2:"id";s:1:"3";s:5:"class";s:9:"newsclass";s:6:"method";b:0;}s:7:"rewrite";a:3:{s:2:"id";s:2:"15";s:5:"class";s:7:"rewrite";s:6:"method";b:0;}s:8:"keywords";a:3:{s:2:"id";s:2:"18";s:5:"class";s:8:"keywords";s:6:"method";b:0;}s:7:"purview";a:3:{s:2:"id";s:2:"20";s:5:"class";s:7:"purview";s:6:"method";b:0;}s:5:"flink";a:3:{s:2:"id";s:1:"4";s:5:"class";s:5:"flink";s:6:"method";b:0;}s:6:"module";a:3:{s:2:"id";s:2:"13";s:5:"class";s:6:"module";s:6:"method";b:0;}s:9:"usergroup";a:3:{s:2:"id";s:2:"21";s:5:"class";s:9:"usergroup";s:6:"method";b:0;}s:4:"data";a:3:{s:2:"id";s:2:"22";s:5:"class";s:4:"data";s:6:"method";b:0;}s:2:"ad";a:3:{s:2:"id";s:1:"5";s:5:"class";s:2:"ad";s:6:"method";b:0;}s:9:"useradmin";a:3:{s:2:"id";s:2:"23";s:5:"class";s:9:"useradmin";s:6:"method";N;}}i:2;a:5:{i:0;a:4:{i:0;a:7:{s:2:"id";s:1:"1";s:6:"parent";s:1:"0";s:5:"class";s:7:"content";s:5:"title";s:12:"内容页面";s:6:"method";s:0:"";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"16";s:6:"parent";s:1:"0";s:5:"class";s:6:"config";s:5:"title";s:12:"网站管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"13";s:6:"parent";s:1:"0";s:5:"class";s:6:"module";s:5:"title";s:12:"页面定制";s:6:"method";s:0:"";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}i:3;a:7:{s:2:"id";s:2:"23";s:6:"parent";s:1:"0";s:5:"class";s:9:"useradmin";s:5:"title";s:15:"管理员管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"4";s:6:"status";s:1:"1";}}i:1;a:4:{i:0;a:7:{s:2:"id";s:1:"2";s:6:"parent";s:1:"1";s:5:"class";s:4:"news";s:5:"title";s:12:"资讯管理";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:1:"3";s:6:"parent";s:1:"1";s:5:"class";s:9:"newsclass";s:5:"title";s:12:"资讯分类";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:1:"4";s:6:"parent";s:1:"1";s:5:"class";s:5:"flink";s:5:"title";s:12:"友情链接";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}i:3;a:7:{s:2:"id";s:1:"5";s:6:"parent";s:1:"1";s:5:"class";s:2:"ad";s:5:"title";s:12:"广告管理";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"4";s:6:"status";s:1:"1";}}i:16;a:3:{i:0;a:7:{s:2:"id";s:2:"17";s:6:"parent";s:2:"16";s:5:"class";s:6:"config";s:5:"title";s:12:"网站设置";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"18";s:6:"parent";s:2:"16";s:5:"class";s:8:"keywords";s:5:"title";s:21:"页面关键字管理";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"22";s:6:"parent";s:2:"16";s:5:"class";s:4:"data";s:5:"title";s:25:"数据备份/数据还原";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}}i:13;a:2:{i:0;a:7:{s:2:"id";s:2:"14";s:6:"parent";s:2:"13";s:5:"class";s:9:"templates";s:5:"title";s:12:"页面管理";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"15";s:6:"parent";s:2:"13";s:5:"class";s:7:"rewrite";s:5:"title";s:15:"伪静态设置";s:6:"method";s:4:"edit";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}}i:23;a:3:{i:0;a:7:{s:2:"id";s:2:"19";s:6:"parent";s:2:"23";s:5:"class";s:7:"manager";s:5:"title";s:12:"帐户管理";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"20";s:6:"parent";s:2:"23";s:5:"class";s:7:"purview";s:5:"title";s:12:"权限菜单";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"21";s:6:"parent";s:2:"23";s:5:"class";s:9:"usergroup";s:5:"title";s:9:"用户组";s:6:"method";s:12:"add,edit,del";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}}}i:3;a:4:{i:1;a:7:{s:2:"id";s:1:"1";s:6:"parent";s:1:"0";s:5:"class";s:7:"content";s:5:"title";s:12:"内容页面";s:6:"method";s:0:"";s:9:"listorder";s:1:"1";s:6:"status";s:1:"1";}i:16;a:7:{s:2:"id";s:2:"16";s:6:"parent";s:1:"0";s:5:"class";s:6:"config";s:5:"title";s:12:"网站管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"2";s:6:"status";s:1:"1";}i:13;a:7:{s:2:"id";s:2:"13";s:6:"parent";s:1:"0";s:5:"class";s:6:"module";s:5:"title";s:12:"页面定制";s:6:"method";s:0:"";s:9:"listorder";s:1:"3";s:6:"status";s:1:"1";}i:23;a:7:{s:2:"id";s:2:"23";s:6:"parent";s:1:"0";s:5:"class";s:9:"useradmin";s:5:"title";s:15:"管理员管理";s:6:"method";s:0:"";s:9:"listorder";s:1:"4";s:6:"status";s:1:"1";}}}', 0, 1),
(7, '测试', 3, 'a:0:{}', 1, 1);
