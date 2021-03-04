<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

define('FoundPHP.com',true);

//后台代码入口
$_GET['m']		= 'admin';

//引入核心库
require_once 'plugin/controller.php';

//入口文件名
$foundphp_enter	= basename($_SERVER['SCRIPT_NAME']);

//提交后返回地址
if (strstr($page_url,'&id=')||strstr($page_url,'&t=')){
	$page_url_back			= str_replace(array('&t='.@$t,'&id='.@$id),'',$page_url);
}

//设置数据库
$db				= load('class/database/dbo','FoundPHP_dbo',$config['db']);

	//管理员资料
	$_sys_aus	= login($m.$PATH_RAND);
	if(@(int)$_sys_aus['id']){
		$aus	= sql_select(array('sql'=>"SELECT u.*,g.names,g.power FROM ".table('admin_user')." u LEFT JOIN ".table('admin_group')." g ON g.agid=u.gid WHERE u.id='".$_sys_aus['id']."' AND u.username='".$_sys_aus['username']."'"));
		//帐号禁用
		if ($aus['states']==0){
			logout($m.$PATH_RAND);
			msg($page_msg['user_die'],$foundphp_enter.'?a=login',3);
		}
		//帐号过期
		if ($aus['state_date']>0 && $aus['state_date']<time()){
			logout($m.$PATH_RAND);
			msg($page_msg['user_die_time'],$foundphp_enter.'?a=login',3);
		}
		
		//头像
		if (trim(@$aus['face'])==''){
			//根据性别选择男女头像
			$aus['photo'] = 'data/avatars/avatar'.@$aus['sex'].'.jpg';
		}else{
			$aus['photo'] = 'data/avatars/admin/'.@$aus['face'];
		}
			//菜单页面
			load('function/power');
			include_once 'data/admin_power.php';
			//检查权限

			if($aus['gid']!=1){
				//获取权限组可用权限
				$_set_power		= json($aus['power']);
				
				$sys_menu		= power($_sys_menu);
				
				//越权处理
				if ((!@array_key_exists($_sel_id,$_set_power) && !in_array($a,array('login','default','go','files','export_data')) ) || ( !in_array($a,array('login','default','go','files','export_data')) && $t!='' && !@array_key_exists($t,$_set_power[$_sel_id])) ){
					msg($page_msg['power_error']);
				}
				
				
			}else{
				//超级管理员则不检查
				//设置菜单权限
				$sys_menu 		= power($_sys_menu);
			}
			
			
		//动态获取标题
		$title	= (!empty($GLOBALS['_sel_title']))?$GLOBALS['_sel_title']:'管理中心首页';
		
	}

	if (@(int)$aus['id']<=0 &&$a!='login'){
		logout($m.$PATH_RAND);
	 	msg(logs($title),$foundphp_enter.'?a=login');
	}

//模块检测
if(is_file($action)){
	
	//开发案例检测
	if ($DEVMODE==1 && ($a!='go' && $t)){
		$action_file = $tpl->reader($action);
		if (!strchr($action_file,"case'$t':")){
			msg('<font color="red">'.$page_msg['dev_model'].' '.$a.' '.$page_msg['dev_model_case'].' <b>'.$t.'</b></font>');
		}
	}
	//载入管理员库
	include_once "plugin/function/admin.php";
	//载入调用模块
	require_once $action;
	
	//系统日志
	logs($title);
	
}else{
	if ($m!=''){
		msg($page_msg['no_function']);
	}
	
	//检测开发模式
	if($DEVMODE){
		$develop_dir	= 'plugin/class/develop/';
		require_once $develop_dir.'default.php';
		exit;
	}else{
		header("Location: ".$config['set']['site_url']);
	}
}


//标题处理
if (in_array($t,array('add','edit'))){
	$title .= '-'.$page_msg[$t];
}

//页头代码
head();
//处理当前地址model下action页面
//重新定位模板

if ($a=='go'){ $tpl_file = $a; }
	$admin_tpl	= (@$tpl_file!='')?$tpl_file:$a;
//echo $tpl_file;
if(@$tpl_file==''){
	$admin_tpl	= (in_array($t,array('add','edit')))?$a.'_edit':$a;
}

$tpl->set_file($admin_tpl);	//设置模板文件

//页脚代码
foot();
?>