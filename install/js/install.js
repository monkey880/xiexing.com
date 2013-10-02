// JavaScript Document
function DoInstall()
{
	  	var dbhost = $('dbhost').value;
		var dbuser = $('dbuser').value;
		var dbpwd = $('dbpwd').value;
		var _url = 'index.php';	
		var _para = {};
		_para['action'] = 'chkdname';	
		_para['dbhost'] = dbhost;	
		_para['dbuser'] = dbuser;	
		_para['dbpwd'] = dbpwd;	
		var Ajax = new classAjax();
		Ajax.setRequest(_url, _para, function(data){			
				if(data == '0'){
					alert('数据库账号密码信息错误!');
					$('dbpwd').focus();
					return false;
				} else {
					popshow();	
				}
		});				
}


function popshow(){
	var title = '程序安装进度监视器';
	var strHtml = '<img src="images/loading.gif"><div class="install_title">程序安装中,请不要刷新耐心等侍一小会儿! 根据网速的不同安装时间大约在3~5分钟内完成!如果失败请重试</div><div id="install_info"></div>';
	var pop=new Popup({ contentType:2,isReloadOnClose:false,width:500,height:320});
	pop.setContent("contentHtml",strHtml);
	pop.setContent("title",title);
	pop.build();
	pop.show();
	$('install_info').innerHTML = '程序已开始运行安装中,请稍候......<br/>';	
	createConfigFile();
}

//创建配置文件
function createConfigFile(){	
	var _url = 'index.php';	
	var _para = {};
	_para['action'] = 'createConfigFile';
	_para['dbhost'] = $('dbhost').value;
	_para['dbuser'] = $('dbuser').value;
	_para['dbpwd'] = $('dbpwd').value;
	_para['dbname'] = $('dbname').value;
	_para['dbprefix'] = $('dbprefix').value;
	var Ajax = new classAjax();
	Ajax.setRequest(_url, _para, function(data){
		var json = eval('['+data+']');		
		var rs = json[0]['rs'];
		var info = json[0]['info']; 		
		if(rs == '1'){
			$('install_info').innerHTML = info+'......<font color="green">成功</font><br/>'+$('install_info').innerHTML;		
			createDatabase();	
		} else {
			$('install_info').innerHTML = info+'......<font color="red">失败!</font><br/>'+$('install_info').innerHTML;		
		}
	});
	
}

//初始化数据库
function createDatabase(){
	var _url = 'index.php';	
	var _para = {};
	_para['action'] = 'createDatabase';
	_para['dbhost'] = $('dbhost').value;
	_para['dbuser'] = $('dbuser').value;
	_para['dbpwd'] = $('dbpwd').value;
	_para['dbname'] = $('dbname').value;
	_para['dbprefix'] = $('dbprefix').value;
	var Ajax = new classAjax();
	Ajax.setRequest(_url, _para, function(data){
		var json = eval('['+data+']');		
		var rs = json[0]['rs'];
		if(rs == '1'){
			$('install_info').innerHTML = json[0]['info']+'......<font color="green">成功</font><br/>'+$('install_info').innerHTML;		
			installBaseData();	//写入初始数据库
		} else {
			$('install_info').innerHTML = json[0]['info']+'......<font color="red">失败</font><br/>'+$('install_info').innerHTML;		
		}
	});
}

//写入初始数据
function installBaseData(){
	var _url = 'index.php';	
	var _para = {};
	_para['action'] = 'installBaseData';	
	_para['dbhost'] = $('dbhost').value;
	_para['dbuser'] = $('dbuser').value;
	_para['dbpwd'] = $('dbpwd').value;
	_para['dbname'] = $('dbname').value;	
	_para['dbprefix'] = $('dbprefix').value;
	var Ajax = new classAjax();
	Ajax.setRequest(_url, _para, function(data){
		var json = eval('['+data+']');		
		var rs = json[0]['rs'];
		if(rs == 0){
			$('install_info').innerHTML = json[0]['msg']+'......<font color="red">失败</font><br>'+$('install_info').innerHTML;		
		} else {
			$('install_info').innerHTML = json[0]['msg']+'......<font color="green">成功</font><br>'+$('install_info').innerHTML;		
			goToDone();
		}
	});	
}




/**
 * 转到完成页
 */
function goToDone() {
	$('install_info').innerHTML = '正在跳转......<br/>'+$('install_info').innerHTML;	
    window.setTimeout(function () {
        location.href = "index.php?step=3";
    }, 3000);
}
