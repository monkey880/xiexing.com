<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_data.php
 * 数据备份/还原model
 * @date 2013-3-6
 * @author yuhailong zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_data extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $this->load->library('tool');
        
        //跳转到一下页的JS
        $this->gotojs = "function GotoNextPage(){
	       document.gonext." . "submit();
            }" . "\r\nset" . "Timeout('GotoNextPage()',500);";

        $this->dojs = "<script language='javascript'>$this->gotojs</script>";
        
        $this->backDir = ROOTPATH.DIRECTORY_SEPARATOR."data/backup";
    }
    
    /**
     * 获得数据库表列表
     * @return array $tableArray 数据库表列表数组
     */
    public function getTableList()
    {
        $tableArray = $this->db->list_tables();
        $db = (array) $this->db;
        $dbprefix = $db['dbprefix'];
        $dbprefixLenth = strlen ($dbprefix);
        $tableNum = count($tableArray);
        $tableList = array();
        foreach ($tableArray as $key=>$val) {
            if (substr($val,0,$dbprefixLenth) == $dbprefix) {
                $tableNumTmp = count($tableList);
                $tableList[$tableNumTmp]['tableName'] = $val;
                $tableList[$tableNumTmp]['tableCount'] = $this->tableCount($val);      
            }       
        }
        return $tableList;
    }
    
    /**
     * 取表的记录数
     * @param string $tableName
     * @return int $count
     */
    public function tableCount($tableName)
    {
        $count = $this->db->count_all_results($tableName);
    	return $count;
    }
    
    /**
     * 获取数据库信息
     * @param 
     * @return 
     */
     public function getDBInfo () 
     {
        $db = (array) $this->db;
        $dbinfo['database'] = $db['database'];   //数据库名
        $dbinfo['char_set'] = $db['char_set'];   //SET NAMES 编码
        return $dbinfo;
     }
     
    /**
     * 数据库备份操作
     * @param 
     * @return 
     */
    public function doBackupData($tablearr, $startpos, $isstruct, $fsize, $datatype, $start_count, $limit_do_count)
    {
        $nowtable = empty($_POST['nowtable']) ? '' : $_POST['nowtable'];  
        $time = time();
        $today = date('Y-m-d', $time);
        
        $dbinfo = $this->getDBInfo();
        $dbname = $dbinfo['database'];
        $cfg_db_language = $dbinfo['char_set'];

        $bkdir = $this->backDir.'/'. $today;

        if (!is_dir($bkdir)) {
            $this->tool->CreateFolder($bkdir);
        }

        //初始化使用到的变量
        $tables = explode(',', $tablearr);
        $fsize = $fsize > 2048 ? '2048' : $fsize;
        $fsizeb = $fsize * 1024;

        //第一页的操作
        if ($nowtable == '') {
            $tmsg = '';
            $dh = dir($bkdir); //读取备份目录
            while ($filename = $dh->read()) {
                if (!preg_match("/txt$/", $filename)) { //如果不存在txt的备份文件 则继续操作
                    continue;
                }
                $filename = $bkdir . "/$filename";
                if (!is_dir($filename)) { //文件名不是一个目录.删掉全部的备份文件
                    unlink($filename);
                }
            }
            $dh->close();
            $tmsg .= "清除备份目录旧数据完成...<br />";
            if ($isstruct == 1) { //备份表节构信息
                $bkfile = $bkdir . "/tables_struct_" . substr(md5(time() . mt_rand(1000, 5000)), 0, 16) . ".txt";
                $mysql_version = $this->db->version();
                $fp = fopen($bkfile, "w");
                foreach ($tables AS $t) {
                    fwrite($fp, "DROP TABLE IF EXISTS `$t`;\r\n\r\n");
                    $row = $this->db->query("SHOW CREATE TABLE " . $dbname . "." . $t)->result_array();
                    
                    //去除AUTO_INCREMENT
                    $row[0]["Create Table"] = preg_replace("/AUTO_INCREMENT=([0-9]{1,})[ \r\n\t]{1,}/", "", $row[0]["Create Table"]);

                    //4.1以下版本备份为低版本
                    if ($datatype == 4.0 && $mysql_version > 4.0) {
                        $eng1 = "ENGINE=MyISAM[ \r\n\t]{1,}DEFAULT[ \r\n\t]{1,}CHARSET=" . $cfg_db_language;
                        $tableStruct = preg_replace('/' . $eng1 . '/', "TYPE=MyISAM", $row[0]["Create Table"]);
                    }

                    //4.1以下版本备份为高版本
                    else if ($datatype == 4.1 && $mysql_version < 4.1) {
                        $eng1 = "ENGINE=MyISAM DEFAULT CHARSET={$cfg_db_language}";
                        $tableStruct = preg_replace("/TYPE=MyISAM/", $eng1, $row[0]);
                    }

                    //普通备份
                    else {
                        $tableStruct = $row[0]["Create Table"];
                    }
                    fwrite($fp, '' . $tableStruct . ";\r\n\r\n");
                }
                fclose($fp);
                $tmsg .= "备份数据表结构信息完成...<br />";
            }
            
            $tmsg .= "<font color='red'>正在进行数据备份的初始化工作，请稍后...</font>";
            $doneForm = "<form name='gonext' method='post' action='".base_url(CFG_ADMINURL.'/data/doback')."'>
               <input type='hidden' name='isstruct' value='$isstruct' />
               <input type='hidden' name='fsize' value='$fsize' />
               <input type='hidden' name='tablearr' value='$tablearr' />
               <input type='hidden' name='nowtable' value='{$tables[0]}' />
               <input type='hidden' name='startpos' value='0' />\r\n</form>\r\n{$this->dojs}\r\n";
               
            $this->PutInfo($tmsg, $doneForm);
            exit();
        }
        //执行分页备份
        else {
            $j = 0; //初始化变量 j .一个表中有字段 的数量
            $fs = $bakStr = '';

            //查看数据库大小　超过30MB的要分页取
            $check_row = $this->db->query("SHOW TABLE STATUS FROM `$dbname` LIKE '$nowtable'")->row_array();
            $table_length = $check_row['Avg_row_length'] + $check_row['Data_length'] + $check_row['Index_length'];
            $table_length = ceil($table_length / 1024 / 1024);

            $row = $this->db->query("SHOW COLUMNS FROM `$nowtable`")->result_array();
            foreach ($row AS $k => $v) {
                $fs[] = $row[$k]['Field']; //字段数组  [agid][gid][abody][time]
                $j++;
            }
            $fsd = $j - 1;  //fsd 字段数
            $intable = "INSERT INTO `$nowtable` VALUES(";

            //读取表的内容
            //判断是不是超过了30MB
            $biger = 30;
            if ($table_length > $biger) {
                //$nowtable总记录数
                $count_row = $this->db->getOne("Select count(*) From `$nowtable` ");
                //分成多少段来取$nowtable ?
                $limit_count = ceil($table_length / $biger);
                //每次取多少条记录?
                $limit = ceil($count_row / $limit_count);

                $limit_num = $limit * $limit_do_count;

                if ($startpos >= ($limit_num + $limit)) {
                    $limit_do_count++;
                    $limit_num = $limit * $limit_do_count;
                    $start_count = 0;
                }

                $row2 = $this->db->getAll("Select * From `$nowtable` LIMIT $limit_num, $limit");
            } else {
                $row2 = $this->db->query("Select * From `$nowtable` ")->result_array();
                $limit_do_count = 0;
                $limit_count = 1;
            }
            $mcount = 0;
            $bakfilename = "$bkdir/{$nowtable}_{$startpos}_" . substr(md5(time() . mt_rand(1000, 5000)), 0, 16) . ".txt";
            foreach ($row2 AS $v) {
                if ($mcount < $start_count) { //当前备份表的分表数
                    $mcount++;
                    continue;
                }

                //检测数据是否达到规定大小
                if (strlen($bakStr) > $fsizeb) {
                    $fp = fopen($bakfilename, "w");
                    fwrite($fp, $bakStr);
                    fclose($fp);
                    $tmsg = "<font color='red'>完成到{$startpos}条记录的备份，继续备份{$nowtable}...</font>";
                    $doneForm = "<form name='gonext' method='post' action='".base_url(CFG_ADMINURL.'/data/doback')."'>
                        <input type='hidden' name='isstruct' value='$isstruct' />
                        <input type='hidden' name='dopost' value='bak' />
                        <input type='hidden' name='fsize' value='$fsize' />
                        <input type='hidden' name='tablearr' value='$tablearr' />
                        <input type='hidden' name='nowtable' value='$nowtable' />
                        <input type='hidden' name='start_count' value='$start_count' />
                        <input type='hidden' name='limit_do_count' value='$limit_do_count' />
                        <input type='hidden' name='startpos' value='$startpos' />\r\n</form>\r\n{$this->dojs}\r\n";
                    $this->PutInfo($tmsg, $doneForm);
                    exit();
                }

                //正常情况
                $line = $intable;
                for ($j = 0; $j <= $fsd; $j++) {
                    if ($j < $fsd) {
                        $line .= "'" . $this->RpLine(addslashes($v[$fs[$j]])) . "',";  //得到字段内容
                    } else {
                        $line .= "'" . $this->RpLine(addslashes($v[$fs[$j]])) . "');\r\n"; //最后一个字段加上括号收起来
                    }
                }
                $mcount++;  //循环一次 增加一条记录数
                $start_count++;
                $startpos++;
                $bakStr .= $line;
            }

            //如果数据比卷设置值小
            if ($bakStr != '') {
                $fp = fopen($bakfilename, "w");
                fwrite($fp, $bakStr);
                fclose($fp);
            }

            $tmsg = "<font color='red'>完成到{$startpos}条记录的备份，";
            for ($i = 0; $i < count($tables); $i++) {
                if ($tables[$i] == $nowtable) {
                    //判断是不是最后一次limit
                    if (($limit_do_count + 1) == $limit_count) {
                        if (isset($tables[$i + 1])) {
                            $nowtable = $tables[$i + 1];
                            $startpos = 0;
                            $start_count = 0;
                            break;
                        } else {
                            //$this->PutInfo("完成所有数据备份！", "");
                            $alertMsg = '完成所有数据备份！';
				            $redirectUrl = site_url('/'.CFG_ADMINURL.'/data');
				            echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
                            exit();
                        }
                    }
                }
            }
            $tmsg .= "继续备份{$nowtable}...</font>";
            $doneForm = "<form name='gonext' method='post' action='".base_url(CFG_ADMINURL.'/data/doback')."'>
              <input type='hidden' name='isstruct' value='$isstruct' />
              <input type='hidden' name='fsize' value='$fsize' />
              <input type='hidden' name='tablearr' value='$tablearr' />
              <input type='hidden' name='nowtable' value='$nowtable' />
              <input type='hidden' name='start_count' value='$start_count' />
              <input type='hidden' name='limit_do_count' value='$limit_do_count' />
              <input type='hidden' name='startpos' value='$startpos'>\r\n</form>\r\n{$this->dojs}\r\n";
            $this->PutInfo($tmsg, $doneForm);
            exit();
        }
    }
    
    public function PutInfo($msg1, $msg2='')
    {
        $msginfo = "<html>\n<head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			<title>提示信息,程序运行时请不要刷新浏览器!</title>
			<base target='_self'/>\n</head>\n<body leftmargin='0' topmargin='0'>\n<center>
			<br/>
			<div style='width:400px;padding-top:4px;height:24;font-size:10pt;border-left:1px solid #9DB3C5;border-top:1px solid #9DB3C5;border-right:1px solid #9DB3C5;background-color:#5692D0;'> 提示信息！</div>
			<div style='width:400px;height:100px;font-size:10pt;border:1px solid #9DB3C5;background-color:#F6F9FD'>
			<span style='line-height:160%'><br/>{$msg1}</span>
			<br/><br/></div>\r\n{$msg2}";
        echo $msginfo . "</center>\n</body>\n</html>";
    }
    
    public function RpLine($str)
    {
        $str = str_replace("\r", "\\r", $str);
        $str = str_replace("\n", "\\n", $str);
        return $str;
    }
    
    public function doRevertData()
    {
        $backfiles = !empty($_POST['backfiles']) ? $_POST['backfiles'] : '';
        $path = $_POST['path'];
        $structfile = empty($_POST['structfile']) ? '' : $_POST['structfile']; //表节构信息
        $delfile = empty($_POST['delfile']) ? '' : $_POST['delfile'];     //是否删除备份信息
        $bkdir = $this->backDir;

        if ($backfiles == '') {
            echo "<script>alert('没指定任何要还原的文件！')</script>";
            exit;
        }
        if ($path == '') {
            echo "<script>alert('没指定任何要还原的日期！')</script>";
            exit;
        }
        $backfilesTmp = $backfiles;
        $backfiles = explode(',', $backfiles);
        if (empty($structfile)) { // 表节构信息
            $structfile = "";
        }
        if (empty($delfile)) { //是否删除备份文件
            $delfile = 0;
        }
        if (empty($startgo)) { //
            $startgo = 0;
        }
        if ($startgo == 0 && $structfile != '') { //第一次开始 有表节构信息 
            $tbdata = ''; //初始还原数据
            $back_sql_path = $bkdir.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$structfile;
            $fp = fopen($back_sql_path, 'r');
            while (!feof($fp)) {
                $tbdata .= fgets($fp, 1024);
            }
            fclose($fp); //完成对节构表的读取
            $querys = explode(';', $tbdata);
            unset($querys[count($querys)-1]);
            
            foreach ($querys as $q) {
                //替换表前缀
                //$q = $this->Rpdbprefix($q);
                if (!empty($q)) {
                    $this->db->query(trim($q) . ';');        
                }
           }
            
            if ($delfile == 1) {
                @unlink("$bkdir/$path/$structfile");
            }
            $tmsg = "<font color='red'>完成数据表信息还原，准备还原数据...</font>";
            $doneForm = "<form name='gonext' method='post' action='".base_url(CFG_ADMINURL.'/data/dorevert')."'>
                <input type='hidden' name='startgo' value='1' />
        		<input type='hidden' name='path' value='$path' />
                <input type='hidden' name='delfile' value='$delfile' />
                <input type='hidden' name='backfiles' value='$backfilesTmp' />
        		</form>\r\n{$this->dojs}\r\n";
            $this->PutInfo($tmsg, $doneForm);
            exit();
        } else { //表节构还原完成 开始还原数据
            $nowfile = $backfiles[0];
            $backfilesTmp = preg_replace('/' . $nowfile . "[,]{0,1}/", "", $backfilesTmp);
            $oknum = 0;
            if (filesize("$bkdir/$path/$nowfile") > 0) {
                $fp = fopen("$bkdir/$path/$nowfile", 'r');
                while (!feof($fp)) {
                    $line = trim(fgets($fp, 512 * 1024));
                    if ($line == "") {
                        continue;
                    }
                    //替换表前缀
                    //$line = $this->Rpdbprefix($line);
                    $rs = $this->db->query($line);
                    if ($rs) {
                        $oknum++;
                    }
                }
                fclose($fp);
            }
            if ($delfile == 1) { //如果删除 则删除备份文件
                @unlink("$bkdir/$path/$nowfile");
            }
            if ($backfilesTmp == "") {
                //$this->PutInfo('成功还原所有的文件的数据！');
                $alertMsg = '成功还原所有的文件的数据！';
				$redirectUrl = site_url('/'.CFG_ADMINURL.'/data/revert');
				echo '<script>alert("'.$alertMsg.'");location = "'.$redirectUrl.'";</script>';
                exit();
            }
            $tmsg = "成功还原{$nowfile}的{$oknum}条记录<br/><br/>正在准备还原其它数据...";
            $doneForm = "<form name='gonext' method='post' action='".base_url(CFG_ADMINURL.'/data/dorevert')."'>
        		<input type='hidden' name='startgo' value='1' />
        		<input type='hidden' name='path' value='$path' />
        		<input type='hidden' name='delfile' value='$delfile' />
        		<input type='hidden' name='backfiles' value='$backfilesTmp' />
                </form>\r\n{$this->dojs}\r\n";
            $this->PutInfo($tmsg, $doneForm);
            exit();
        }
    }
    
    /**
     * 还原sql的时候把prefix数据库表前缀也更新了
     * @param <type> $sql
     */
    public function Rpdbprefix($sql)
    {
        $prefix_search = array('INSERT INTO `zhuna_', 'CREATE TABLE `zhuna_', 'DROP TABLE IF EXISTS `zhuna_','CREATE TABLE IF NOT EXISTS `zhuna_');
        $prefix_replace = array("INSERT INTO `{$this->dbinfo['dbprefix']}", "CREATE TABLE `{$this->dbinfo['dbprefix']}", 
                                "DROP TABLE IF EXISTS `{$this->dbinfo['dbprefix']}","CREATE TABLE IF NOT EXISTS `" . $this->dbinfo['dbprefix'] . "");
        $prefix_sql = str_replace($prefix_search, $prefix_replace, $sql);
        return $prefix_sql;
    }

    /**
     * 删除选中的备份文件
     */
    public function delData($backfiles)
    {
        $good = 1;
        foreach ($backfiles AS $k => $v) {
            $bkdirs = $this->backDir . '/' . $v;
            if (!$this->deldir($bkdirs)) {
                $good = 0;
            }
        }
        return $good;
        if ($good == 1) {
            $this->redirect('成功删除指定的备份文件！', PHP_SELF . '?m=data.revert');
            exit();
        }
    }
    
    /**
     * 删除非空文件夹
     * @param $dir;
     * return
     */
    public function deldir($dir)
    {
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }

        closedir($dh);

        if (rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
}
?>