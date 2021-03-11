<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

$title	.= lang('服务器信息');

//选中数据库
$sel_db				= session('sel_sql');
$dbtype				= $support_database[$sel_db];
$dbport				= $support_port[$sel_db];

$config_file		= '../data/config.php';
if($P['o']==1){
	unset($P['o']);

	foreach($P AS $k=>$v) {
		$P[$k]		= trim($v);
	}
	
	if ($P['site_name']==''){
		msg('抱歉，没有输入网站名称');
	}
	update_config('$config[set][site_name]',$P['site_name'],$config_file);
	if ($P['weburl']=='' || !strstr($P['weburl'],'://')){
		msg('抱歉，没有输入网站地址');
	}
	update_config('$config[set][site_url]',$P['weburl'],$config_file);
	update_config('$config[set][site_author]',$P['site_author'],$config_file);
	update_config('$config[set][site_key]',$P['site_key'],$config_file);
	update_config('$config[set][site_desc]',$P['site_desc'],$config_file);
	if ($sel_db==''){
		msg('抱歉，没有设置数据库类型');
	}
	update_config('$config[db][dbtype]',$sel_db,$config_file);
	if ($P['dbhost']==''){
		msg('抱歉，没有设置数据库地址');
	}
	update_config('$config[db][dbhost]',$P['dbhost'],$config_file);
	if ($P['dbhost']==''){
		msg('抱歉，没有设置数据库地址');
	}
	update_config('$config[db][dbhost]',$P['dbhost'],$config_file);
	
	update_config('$config[db][dbport]',$P['dbport'],$config_file);
	
	if (!in_array($sel_db,array('sqlite'))){
		if ($P['dbname']=='' || !preg_match('/^[a-zA-Z0-9\-_]{1,32}$/',$P['dbname'])){
			msg('抱歉，没有设置数据库名称或不符合标准');
		}
		if ($P['dbuser']==''){
			msg('抱歉，没有设置数据库用户');
		}
	}
	update_config('$config[db][dbname]',$P['dbname'],$config_file);
	update_config('$config[db][dbuser]',$P['dbuser'],$config_file);

	update_config('$config[db][dbpass]',$P['dbpass'],$config_file);
	
	
	update_config('$config[db][pre]',$P['pre'],$config_file);
	if ($P['adminuser']==''){
		msg('抱歉，没有输入系统管理帐号');
	}
	if ($P['password']==''){
		msg('抱歉，没有输入系统管理密码');
	}
	session('adminuser',$P['adminuser']);
	session('password',$P['password']);
	session('email',$P['email']);
	
	//产生随机数
	$rand_dir		= chr(rand(97,122)).rand(100000,999999).chr(rand(65,90));
	$dirs			= '../data/FoundPHP_'.$rand_dir.'/';
	if (mkdir($dirs)){
		mkdir($dirs.'/cache');
		mkdir($dirs.'/log');
		mkdir($dirs.'/language');
		mkdir($dirs.'/backup');
		update_config('$PATH_RAND',$rand_dir,$config_file);
		if ($sel_db=='sqlite'){
			update_config('$config[db][dbhost]','data/FoundPHP_'.$rand_dir.'/'.$P['dbhost'],$config_file);
		}
	}
	
	include $config_file;
	chdir('../');
	unset($config['db']['dbname']);
	//载入设置数据库
	$config['db']['install']	= 1;
	//载入设置数据库
	$db							= load('class/database/dbo','FoundPHP_dbo',$config['db']);
	chdir('install/');
	if ($db->DB->LinkID->connect_error){
		msg('抱歉，账号信息或服务器有限制<br>参考信息：'.$db->DB->LinkID->connect_error);
	}
	//建立数据库
	if (in_array(strtolower($config['db']['dbtype']),array('mysql','mariadb'))){
		$data_info	= sql_select(array('sql'=>"SELECT SCHEMA_NAME AS name FROM information_schema.SCHEMATA where SCHEMA_NAME='".$P['dbname']."';"));
		if ($data_info['name']!=$P['dbname']){
			//建立数据库
			$db->query("CREATE DATABASE ".$P['dbname']);
		}
	}
	if (in_array(strtolower($config['db']['dbtype']),array('sqlsrv'))){
		$data_info	= sql_select(array('sql'=>"select * From master.dbo.sysdatabases where name='".$P['dbname']."'"));
		if ($data_info['name']!=$P['dbname']){
			//建立数据库
			$db->query("CREATE DATABASE ".$P['dbname']);
		}
	}
	msg('','?a=database');
}

$tpl->set_file($a);	//设置模板
$tpl->p();
?>