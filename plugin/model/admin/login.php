<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
defined('FoundPHP.com') or die('access denied!');

//======================== 基本变量 ========================\
//页面标题名称
$title 			= lang('系统登录');
$page_msg1		= lang('登陆成功');
$page_msg2		= lang('登陆失败');
$page_msg3		= lang('登陆失败');
$page_msg4		= lang('恭喜，登陆成功!');
$page_msg5		= lang('抱歉，登陆失败! 您的登陆操作已经被记录!');
$page_msg6		= lang('您已经安全退出！');
$page_msg7		= lang('抱歉，验证码错误!');

$table['a']		= 'admin_user';				//表名

//======================== 逻辑处理 ========================\
$username		= trim(@$P['username']);
$password		= md5(trim(@$P['password']));
$login_err		= intval(session('admin_login_err'));
if ($login_err>=2){
	$code			= trim(@$P['code']);
}
switch($t){
	//验证码
	case'code':
		$code	= load('class/image/code','FoundPHP_imgcode');
		$str	= $code->rand_code(6,1);
		session('admin_code',$str);
		
		$code->gif($str,'100','22');
		exit;
	break;
	
	//安全退出
	case'exit':
		logout($m.$PATH_RAND);
		msg($page_msg6,$code_name,3);
	break;
	default:
		
		//登录验证
		if($a=='login' && $username && $password){
			$ck	= sql_select( array('table'=>$table['a'], 'where'=>"username='".$username."' AND password='".$password."'") );
			
			if($ck['username']==$username){
				//帐号禁用
				if ($ck['states']==0){
					msg($page_msg['user_die']);
				}
				if ($ck['state_date']>0 && $ck['state_date']<time()){
					msg($page_msg['user_die_time']);
				}
				
				//验证码检测
				if ($login_err>=2 && $code!=session('admin_code')){
					msg($page_msg7);
				}
				
				//建立登陆信息
				$login_ary	= array(
						'id'		=>$ck['id'],
						'username'	=>$ck['username']
						);
				
				login($m.$PATH_RAND,$login_ary);
				
				
				$post['data']		= array(
						'last_date'	=>time(),
						'last_ip'	=>get_ip()
						);
				sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>"id='$ck[id]'"));
				session('admin_login_err','[del]');
				//返回地址
				msg($page_msg4,$foundphp_enter,0);
			}else{
				//错误统计
				session('admin_login_err',($login_err+1));
				logout($m.$PATH_RAND);
				//返回地址
				msg($page_msg5,$foundphp_enter.'?m='.$m.'&a=login',1);
			}
		}
		
		logout($m.$PATH_RAND);
		$tpl->set_file($a);	//设置模板文件
		$tpl->p();
		exit;
}


?>