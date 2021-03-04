<?php
define('FoundPHP.com',true);
$code				= trim($_GET['code']);
$_dev_echostr		= trim($_GET['echostr']);
$_dev_signature		= trim($_GET['signature']);
$_dev_timestamp		= trim($_GET['timestamp']);
$_dev_nonce			= trim($_GET['nonce']);
$_dev_msgsign		= trim($_GET['msg_signature']);
include_once "plugin/controller.php";

//实例微信库
$wx		= load('class/wechat/service','FoundPHP_wechat_service',$config['wx']);
//实例数据库
$db			= load('class/database/dbo','FoundPHP_dbo',$config['db']);
switch($m){
	//用户资料
	case'user':
		//获得用户信息
		$usinfo		= $wx->usinfo($code);
		//访问模块
		$wx->auth_view($t);
	break;
	default:
		//服务号认证
		if(!empty($t)){
			$wx->auth();
		}else{
			empty($_dev_echostr)?$wx->dev_valid():$wx->dev_msg();exit;
		}
}
