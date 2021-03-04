<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/
defined('FoundPHP.com') or die('access denied!');

//======================== 基本变量 ========================\
//页面标题名称
$title		.= '-'.lang('开发者认证');

$appid		= $config['foundphp']['appid'];
$appmd5		= md5($appid.$config['foundphp']['secret']);
$app_check	= '&n='.$appid.'&s='.$appmd5;
$appstore	= 'http://plugin.foundphp.com/?m=store';
$app_cache	= $RAND_DIR.'cache/';
//======================== 逻辑处理 ========================\
$store_cache= $app_cache.'FoundPHP_store_type.php';
if (!is_file($store_cache)){
	//获取类目
	$res			= json($tpl->curl($appstore.$app_check));
	$foundphp_type	= $res['data'];
	$tpl->writer($store_cache,'<?php $foundphp_type= '.array_text($foundphp_type).';');
}else{
	include $store_cache;
}



?>