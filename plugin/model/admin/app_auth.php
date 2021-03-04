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

//======================== 逻辑处理 ========================\

if ($P['o']){
	update_config('$config[foundphp][appid]',trim($P['appid']));
	update_config('$config[foundphp][secret]',trim($P['secret']));
	msg('',"$page_url&g=success");
	exit;
}



?>