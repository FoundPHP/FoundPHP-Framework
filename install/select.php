<?php
$title	.= lang('选择数据库');

//设置选中的数据库
if (!empty($P['o'])){
	$sel_sql	= strtolower($P['sel_sql']);
	if (!empty($support_database[$sel_sql])){
		session('sel_sql',$sel_sql);
		msg('','index.php?a=check');
	}
}



ob_start();
ob_implicit_flush(0);
	phpinfo();
	$sys_info = ob_get_contents();
ob_end_clean();

$mysql		= $mariadb= $sqlite= $sqlserver= $postgresql= $oracle=0;
$bind_db	= $support_database;
//mysql
if (strstr($sys_info,'>mysql<') || strstr($sys_info,'>mysqli<')){
	$mysql			= 1;
	$mariadb		= 1;
}else{
	unset($bind_db['mysql']);
}
//sqlite
if (strstr($sys_info,'>sqlite<') || strstr($sys_info,'>sqlite3<')){
	$sqlite			= 1;
}else{
	unset($bind_db['sqlite']);
}

//sqlserver
if (strstr($sys_info,'>sqlsrv<')){
	$sqlsrv			= 1;
}else{
	unset($bind_db['sqlsrv']);
}

//sqlserver
if (strstr($sys_info,'>pgsql<') || strstr($sys_info,'>pdo_pgsql<')){
	$pgsql			= 1;
}else{
	unset($bind_db['pgsql']);
}

//oracle
if (strstr($sys_info,'>oci') || strstr($sys_info,'>pdo_oci')){
	$oracle			= 1;
}else{
	unset($bind_db['oracle']);
}

session('support_database',$bind_db);


$tpl->set_file('select');	//设置模板
$tpl->p();

?>