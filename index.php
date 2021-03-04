<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
define('FoundPHP.com',true);

//引入核心库
require_once 'plugin/controller.php';

//提交后返回地址
if (strstr($page_url,'&id=')||strstr($page_url,'&t=')){
	$page_url_back	= str_replace(array('&t='.@$t,'&id='.@$id),'',$page_url);
}

//载入设置数据库
$db					= load('class/database/dbo','FoundPHP_dbo',$config['db']);
//模块检测
if(is_file($action)){
	//模块类库
	$_model_file 	= 'plugin/function/'.$m.'.php';
	if (is_file($_model_file)){
		require_once $_model_file;
	}
	//载入调用模块
	require_once $action;
	
	//系统日志
	logs($title);
}else{
	//检测开发模式
	if($DEVMODE){
		$develop_dir	= 'plugin/class/develop/';
		require_once $develop_dir.'default.php';
		exit;
	}else{
		header("Location: ".$config['set']['site_url']);
	}
}
//页头代码
head();
//页面中心模板
//重新定位模板
if ($a=='go'){ $tpl_file = $a; }
$_ET_TPL	= (@$tpl_file!='')?$tpl_file:$a;
$_ET_TPL	= (in_array($t,array('add','edit'))&&$t!='')?$a.'_edit':$_ET_TPL;
$tpl->set_file($_ET_TPL);	//设置模板文件
//页脚代码
foot();
?>