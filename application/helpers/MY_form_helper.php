<?php








/**
 * 生成单选按钮
 * @param string $name radio names
 * @param array $data all radio data
 * @param string $select_data current select data
 */
function form_radio($name='',$data=array(),$select_data='')
{
	$radiolist = "" ;
	foreach ($data AS $key => $value) {
	   $checked = $select_data == $key ? 'checked' : null;
	   $radiolist .= "<input type='radio' name='{$name}' value='{$key}' $checked/>{$value}&nbsp;";
	}  

	return $radiolist;
}

