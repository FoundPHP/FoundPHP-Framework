<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
chdir('../');
define('FoundPHP.com',true);
$m = 'install';							//入口识别

//引入核心库
require_once 'plugin/controller.php';
$support_database	= array('mysql'=>'MySQL','mariadb'=>'MariaDB','sqlite'=>'SQLite','sqlsrv'=>'SQL Server','pgsql'=>'PostgreSQL');
$support_port		= array('mysql'=>3306,'mariadb'=>3306,'sqlsrv'=>1433,'pgsql'=>'5432');

//检测是否安装系统
if (is_file('data/install.lock') && $a!='finish'){
	msg('您已经安装了FoundPHP，请不要重新安装。','../',2);
}


chdir('install');
$tpl->TemplateDir	= 'view/';
$tpl->CacheDir		= '';
$tpl->RunType		= 'replace';
$style_dir			= '../data/style/';
$a_set				= array('agreement','select','check','input','database','finish');
$model				= $a.'.php';

if(in_array($a,$a_set) && is_file($model)){
	$title		.= lang('FoundPHP安装-');
	include $model;
}else{
	msg('','index.php?a=agreement');
}