<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

$title	.= lang('服务器检测');
$right		= '<i class="glyphicon  glyphicon-ok" style="color:#2ecc71"></i> ';
$error		= '<i class="glyphicon glyphicon_error glyphicon-remove" style="color:red"></i> ';
$error_suggest	= '<i class="glyphicon glyphicon-adjust" style="color:#f0ad4e"></i> ';

//gd库检测
$tmp				= function_exists('gd_info') ? gd_info() : array();
$gdversion			= empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];

//运行平台
if (!stristr($_SERVER['SERVER_SOFTWARE'],'apache') || !stristr($_SERVER['SERVER_SOFTWARE'],'nginx') || !stristr($_SERVER['SERVER_SOFTWARE'],'iis')){
	$sys_ext		= explode(' ',$_SERVER['SERVER_SOFTWARE']);
	$software		= $right.$sys_ext[0];
}else{
	$software		= $error.$_SERVER['SERVER_SOFTWARE'];
}
ob_start();
ob_implicit_flush(0);
	phpinfo();
	$sys_info = ob_get_contents();
ob_end_clean();

if (floatval(PHP_VERSION)>5.6){
	//openssl
	$open_ext			= explode('SSL Version',$sys_info);
	$open_ver			= explode('</td></tr>',$open_ext['1']);
	$openssl			= (function_exists('openssl_open')?$right.trim(strip_tags($open_ver[0])):$error.' '.lang('打开php.ini 开启openssl'));
}
//附件大小
$attachmentupload = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';

//curl
if(function_exists('curl_init') && function_exists('curl_version')){
	$v			= curl_version();
	$curl		= $lang['enable'].' '.$v['version'];
}else{
	$curl		= $lang['disable'];
}

//zip检测
$zip_ext			= explode('Zip version',$sys_info);
$zip_ver			= explode('</td></tr>',$zip_ext['1']);
if (!empty($zip_ver)){
	$zip		= $right.trim(strip_tags($zip_ver['0']));
}else{
	$zip		= $error;
}


$root_dirsize	= (int)(disk_total_space('./')/(1024*1024));

//目录权限
$system_dir			= dirname(getcwd());
chdir('../');
$tpl->get_dir_ext	= array('','php');
$tpl->get_dir_num	= 1;
$tpl->get_dir('.',$get_list);
chdir('install/');

foreach($get_list AS $k=>$v) {
	if (stristr($k,'install')){
		unset($get_list[$k]);
	}
}

$tpl->set_file($a);	//设置模板
$tpl->p();
?>