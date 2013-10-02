<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo base_url();?>public/admin/default/style/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>public/admin/default/style/base.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>public/js/jquery-1.7.2.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>public/admin/default/drag_drop.js" type=text/javascript></script>

<script language="javascript">

window.onload = function(){CreateDragContainer(document.getElementById('cityList'));}

</script>

<title>携行网酒店后台管理系统</title>

</head>

<body>

<div class="container">

    <?php $this->load->view('admin/admin_header');?>

    <div class="box">

        <?php $this->load->view('admin/admin_left');?>

        <div class="box_right">

            <table width="100%" cellpadding="0" cellspacing="0" class="ym_bk">

                <tr>

                    <td><div class="wzdh">

                            <h2>后台管理>>网站设置</h2>

                        </div></td>

                </tr>

                <tr>

                    <td><div class="zhuti">

                            <ul>

                                <li class="current">网站设置</li>

                            </ul>

                        </div></td>

                </tr>

                <tr>

                    <td>

                        <?php echo form_open_multipart(site_url(CFG_ADMINURL.'/config/save_config'),array('id'=>'configform','onsubmit'=>'return fillcitylist();'));?>

                        <table width="100%" cellpadding="0" cellspacing="5" class="xx">

                           <tr style="background:#fffef2;">

                                <td colspan="2" class="left" style="height:30px; line-height:30px; width:120px; padding-left:20px; border:#f9d8b4 1px solid; color:#e86f0d;"><h2>修改网站设置</h2></td>

                            </tr>

                           <?php foreach($config as $k=>$v) {  ?>

                           <tr>

                            <td class="right"><?php echo $v['info'] ?>：</td>

                            <td class="left">

                            <?php if ($v['type'] == 'string') {?><input type="text" size="40" value="<?php echo $v['value'] ?>" id="<?php echo $v['varname'] ?>" name="<?php echo $v['varname'] ?>">

                            <?php } elseif ($v['type'] == 'bstring') { ?><textarea name="<?php echo $v['varname'] ?>" id="<?php echo $v['varname'] ?>" rows="6" cols="62"><?php echo $v['value'] ?></textarea>

                            <?php } elseif ($v['type'] == 'select') { ?><?php echo $v['select'] ?>

                            <?php } elseif ($v['type'] == 'radio') { ?><?php echo $v['radio'] ?>

                            <?php } ?>

                            <?php echo $v['help'] ?>

                            </td>

                          </tr>  

                          <?php } ?>

                          <tr>

                                <td class="right" width="120px"></td>

                                <td>

                                <?php if ($operate['isedit']) { ?>

                                <input type="submit" class="tjzx" value="提&nbsp;交" name="">

                                <?php } ?>

                                </td>

                            </tr>

                       </table>

                        </form>

                     </td>

                </tr>

            </table>

        </div>

    </div>

    <?php $this->load->view('admin/admin_footer');?>

</div>



<script>

function rplCity(pid)

{

	var cid = arguments[1]?arguments[1]:0;

	if (pid!='0'){ 

        $.ajax({

    		type: "GET",

    		url: "<?php echo site_url(CFG_ADMINURL.'/config/getCity'); ?>?pid="+pid,

    		success: function(msg)

    		{

    		    var msg = $.parseJSON(msg);  

                $("#city").html("<option selected='selected' value='0'>--请先选择城市--</option>"); 

                $.each(msg,function(i){

                    var textinfo = '';

            	    textinfo+="<option  value='"+msg[i]['cid']+'|'+msg[i]['cName']+"'>"+msg[i]['cName']+"</option>";

                    

                    $("#city").append(textinfo); 

                });	

            }

    	});			

	}

}





function changtag(val)

{

	CreateDragContainer(document.getElementById('cityList'));

	var root=document.getElementById("cityList")

	var oNote=root.getElementsByTagName("span");

	var isthere=false;

	for(i=0;i<oNote.length;i++){

    	if(oNote[i].attributes.getNamedItem("id"))

    	   var id=oNote[i].attributes.getNamedItem("id").value;

    	if(oNote[i].attributes.getNamedItem("value"))

    	   var value=oNote[i].attributes.getNamedItem("value").value;

    	if((id+"|"+value)==val)    isthere=true;

	}

	if(!isthere){

        var val=val.split('|');

        document.getElementById("cityList").innerHTML+="<span ondblclick=\"return updatename(this,'"+val[1]+"');\" style=\"border:#CCC solid 1px; padding:3px;cursor:move;\" value=\""+val[1]+"\" id=\""+val[0]+"\">"+val[1]+"<em style=\"cursor:pointer\" onclick=\"return delCity("+val[0]+");\">×</em></span>";

	}	

}



function delCity(val)

{

	document.getElementById(val).parentNode.removeChild(document.getElementById(val));

}



function chkForm()

{

	return true;	



}



function updatename(val,itemval)

{

    if(val.innerHTML.indexOf("input")==-1)

    val.innerHTML=val.innerHTML.replace(itemval,"<input onblur='return changvals(this);' style='' size=4 value="+itemval+">");

}



var dragHelper = document.createElement('DIV');

dragHelper.style.cssText = 'position:absolute;display:none;';

document.getElementById("cityList").appendChild(dragHelper);



function changtag(val)

{

    CreateDragContainer(document.getElementById('cityList'));

    var root=document.getElementById("cityList")

    var oNote=root.getElementsByTagName("span");

    var isthere=false;

    for(i=0;i<oNote.length;i++){

    if(oNote[i].attributes.getNamedItem("id"))

    var id=oNote[i].attributes.getNamedItem("id").value;

    if(oNote[i].attributes.getNamedItem("value"))

    var value=oNote[i].attributes.getNamedItem("value").value;

    if((id+"|"+value)==val)isthere=true;

    }

    if(!isthere){

    var val=val.split('|');

        document.getElementById("cityList").innerHTML+="<span ondblclick=\"return updatename(this,'"+val[1]+"');\" style=\"border:#CCC solid 1px; padding:3px;cursor:move;\" value=\""+val[1]+"\" id=\""+val[0]+"\">"+val[1]+"<em style=\"cursor:pointer\" onclick=\"return delCity("+val[0]+");\">×</em></span>";

    }   

}



function fillcitylist()

{

    var root = document.getElementById("cityList")

    var oNote = root.getElementsByTagName("span");

    var liststr = "";

    for(i=0;i<oNote.length;i++){

        if(oNote[i].parentNode.style.display!="none"){

        if(oNote[i].attributes.getNamedItem("id")){

            var id=oNote[i].attributes.getNamedItem("id").nodeValue;

            liststr+=id+"|";

        }

        if(oNote[i].attributes.getNamedItem("value")){

            var value=oNote[i].attributes.getNamedItem("value").nodeValue;

            liststr+=value+",";

        }

        }

    }



    if(liststr.length >0 ){

        document.getElementById("cfg_indexCitylist").value = liststr.substr(0,liststr.length-1);

    }else{

        alert("首页城市选项卡不能为空！");

    return false;

    }

}





function changvals(val)

{

    val.parentNode.setAttribute("value",val.value);

}

</script>

</body>

</html>