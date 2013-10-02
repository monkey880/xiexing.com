<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$route['default_controller'] = 'index';

$route['allcity'] = 'allcity/index/';

$route['onecity/([0-9]+)'] = 'onecity/index/$1';

$route['newsinfo/([0-9]+)'] = 'newsinfo/index/$1';

$route['help/([0-9]+)'] = 'help/index/$1';

$route['news'] = 'news/index/';

$route['news/([0-9a-zA-Z\-]+)'] = 'news/index/$1';

$route['expo'] = 'expo/index/';

$route['expo/([0-9a-zA-Z\-]+)'] = 'expo/index/$1';

$route['expoinfo/([0-9]+)'] = 'expoinfo/index/$1';

$route['hotelinfo/([0-9A\-]+)'] = 'hotelinfo/index/$1';

$route['freeroominfo/([0-9]+)'] = 'freeroominfo/index/$1';

$route['freeroom/([0-9]+)'] = 'freeroom/index/$1';

$route['404_override'] = '';

$route['lable'] = 'lable/index/';

$route['lable/([0-9a-zA-Z\-]+)'] = 'lable/index/$1';

$route['ehc'] = 'ehc/index';

$route['ehc/([0-9a-zA-Z\-]+)'] = 'ehc/index/$1';

$route['help'] = 'help/index/';

$route['comment'] = 'comment/index/';

$route['comment/([0-9]+)'] = 'comment/index/$1';

$route['comment/([0-9]+)/([0-9]+)'] = 'comment/index/$1$2';

$route['ask'] = 'ask/index/';

$route['ask/([0-9]+)'] = 'ask/index/$1';

$route['ask/([0-9]+)/([0-9]+)'] = 'ask/index/$1$2';

$route['member'] = 'member/index/';

$route['hotellist'] = 'hotellist/index';

$route['hotellist/(.+)'] = 'hotellist/index/$1';
//$route['tuangou/info/(.+)'] = 'tuangou/info/$1';
$route['tuangou/(.+)'] = 'tuangou/index/$1';
$route['tuangouinfo/(.+)'] = 'tuangouinfo/index/$1';

$route['lbsmap'] = 'lbsmap/index.html';

