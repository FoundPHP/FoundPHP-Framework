<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

	$title	.= ('数据库安装');
	$config_file		= '../data/config.php';
	include $config_file;
	chdir('../');
	//载入设置数据库
	$db							= load('class/database/dbo','FoundPHP_dbo',$config['db']);
	chdir('install/');
	
	if ($t=='data'){
		
		$p			= $p-1;
		$p			= $p<=0?0:$p;
		$error	= $type		= 0;
		//写入数据库
		$database	= 'data/'.$config['db']['dbtype'].'.sql';
		$sql_data	= $tpl->reader($database);
		//用户信息
		$sql_data	= str_replace('{[FoundPHP_us]}',session('adminuser'),$sql_data);
		//用户密码
		$sql_data	= str_replace('{[FoundPHP_pw]}',md5(session('password')),$sql_data);
		//用户信息
		$sql_data	= str_replace('{[FoundPHP_email]}',session('email'),$sql_data);
		$sql_data	= str_replace('{[FoundPHP_date]}',time(),$sql_data);
		$sql_data	= str_replace('{[FoundPHP_ip]}',get_ip(),$sql_data);
		//表头数据库
		$sql_data	= str_replace('{[FoundPHP_database]}',$config['db']['dbname'],$sql_data);
		//表头替换
		$sql_data	= str_replace('{[FoundPHP]}',$config['db']['pre'],$sql_data);		
		
		switch($config['db']['dbtype']){
			case'sqlsrv':
				$sql_ary	= explode("GO\r\n",$sql_data);
				$now_sql	= str_replace('[dbo].','',trim($sql_ary[$p]));
				$table_exp	= explode('[',$now_sql);
				$table_ex	= explode(']',$table_exp[1]);
				$table		= str_replace($config['db']['pre'],'',$table_ex[0]);
			break;
			case'sqlite':
				$sql_ary	= explode(";\r\n",$sql_data);
				$now_sql	= trim($sql_ary[$p]);
				$table_exp	= explode('"',$now_sql);
				$table_ex	= explode('"',$table_exp[1]);
				$table		= str_replace($config['db']['pre'],'',$table_ex[0]);
			break;
			default:
				$sql_ary	= explode(";\r\n",$sql_data);
				$now_sql	= trim($sql_ary[$p]);
				$table_exp	= explode('`',$now_sql);
				$table		= str_replace($config['db']['pre'],'',$table_exp[1]);
				if (count($sql_ary)<=1){
				$sql_ary	= explode(";\r\n",$sql_data);
				}
		}
		//删除表
		if (stristr($now_sql,'DROP TABLE')){
			$type	= 1;
		}
		//创建表
		if (stristr($now_sql,'CREATE TABLE')){
			$type	= 2;
		}
		//插入数据
		if (stristr($now_sql,'INSERT INTO') && $config['db']['dbtype']=='sqlsrv'){
			$now_sql= 'SET IDENTITY_INSERT '.$config['db']['pre'].$table.' ON; '.$now_sql.';SET IDENTITY_INSERT '.$config['db']['pre'].$table.' OFF;';
			$type	= 3;
		}
		//优化表数据
		if (stristr($now_sql,'ALTER TABLE')){
			$type	= 4;
		}
		//优化表数据
		if (stristr($now_sql,'EXEC ')||stristr($now_sql,'SET NAMES ')){
			$type	= 5;
		}
		//执行语句
		if (trim($now_sql)){
			$db->error = 1;
			$query = $db->query($now_sql);
		//	echo $now_sql;
			//print_r($db->DB->LinkID->lastErrorMsg());
			//致命错误
			if($query==false){
				$error	= 1;
			}
		}
		
		//执行完成
		if ($p>=count($sql_ary)){
			//产生随机数
			$dirs			= '../data/FoundPHP_'.$PATH_RAND.'/';
			if (is_dir($dirs)){
				//需要报告完成
				$type			= 9;
				//锁定系统不能装
				$tpl->writer('../data/install.lock','FoundPHP FrameWork - '.dates(time()));
			}else{
				//改写目录失败
				$type			= 7;
				$error			= 1;
			}
		}
		json_out(1,array('all'=>count($sql_ary),'now'=>$p,'table'=>$table,'type'=>$type,'error'=>$error));
		//print_r($sql_ary);
		//exit;
	}


$tpl->set_file($a);	//设置模板
$tpl->p();
?>