<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/


/*
*  开发模式下自动建立页面系统
*/
$lang_txt1		= lang('存在');
$lang_txt2		= lang('缺少');
$lang_txt3		= lang('目录权限不够');
//声明交互类
$FoundPHP			= load('class/develop/foundphp','FP',array('appid'=>$config['fp']['appid'],'secret'=>$config['fp']['secret']));

//数据库表索引关系
$table_index	= array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','u','v','w','x','y','z');

if ((int)$t>0){
//	$post_url		= str_replace('&t='.$t,'&t='.($t+1),$post_url);
}else{
//	$post_url		= $post_url.'&t=2';
}

if($DEVMODE){
	//重新定向ET模板目录
	$tpl->RunType 			= 'Replace';		//采用替换引擎
	$tpl->Compress 			= 0;				//禁用压缩
	$tpl->TemplateDir		= './'.$develop_dir.'templates/';
	//开发工具
	$develop_path 			= $develop_dir.'tools/';
	
	$templates_dir	 		= $config['tpl']['TemplateDir'].($m=='default'?'':'/'.$m);
	
	//======================== 检测 ========================\\
	if(is_dir($model_dir)){
		//权限检测
		$models_chmod 	= (@substr(@sprintf('%o', @fileperms($model_dir)), -3)==777)?'':'，'.$lang_txt3;
		$models_dir_check	= $lang_txt1.$models_chmod.'';
	}else{
		$models_dir_check	= $lang_txt2;
	}
	
	
	//权限检测
	$templates_dir_chmod 	= (@substr(@sprintf('%o', @fileperms($templates_dir)), -3)==777)?'':'，'.$lang_txt3;
	$templates_dir_check	= (is_dir($templates_dir))?$lang_txt1.$templates_dir_chmod.'':$lang_txt2;
	
	$templates_name 		= $templates_dir.'/'.$a.'.'.( (trim($tpl_set['TplType'])!='')?$tpl_set['TplType']:'htm' );
	$templates_name_check = (is_file($templates_name))?$lang_txt1:$lang_txt2;
	
	//获取当前地址
	$page_adds			= get_url();
	
	//======================== 创建页面 ========================\\
	//建立模块与操作
	$P['m']				= (PLUGIN=='admin'?'admin':$m);
	$P['a']				= $a;
	$P['dir']			= @strstr($config['tpl']['TemplateDir'],$P['m'])?$config['tpl']['TemplateDir'].'/':$config['tpl']['TemplateDir'].'/'.$P['m'].'/';
	$P['step']			= ((int)$t<=1?1:(int)$t);
	//认证提交
	$P['oauth_code']	= $o!=''?$o:session('oauth_code');
	
	switch($t){
		case 2:
			if ($P['o']){
				$P['t_index']		= trim($P['t_index']);
				$P['t_field']		= trim($P['t_field']);
				$P['t_where']		= trim($P['t_where']);
				$P['t_order']		= trim($P['t_order']);
				$P['sql']			= trim($P['sql']);
				unset($P['tables'],$P['dir']);
				
			}
			
			// 最后彻底销毁session.
			//	session_destroy();
			
			//影子模式
			if ($_SESSION['dev_type']==3 && (int)$P['o']!=1){
				$P['o']				= 2;	//获取数据
				$P['table_code']	= $FoundPHP->get_var($_SESSION['_sel_model']);
			}
			
			if ($P){
			//	echo '<pre>';
			//	print_r($_SESSION);
			//	exit;
			}
			
			
			
			//云交互
			$result = $FoundPHP->sql($P);
			//echo '<pre>';print_r($result);
			//exit;
			if ($result['next']>0){
				//清空数据库表缓存
				unset($_SESSION['ltable'],$_SESSION['table'],$_SESSION['tpl']);
				msg('',str_replace('t='.$P['step'],'t='.$result['next'],$page_url.(strstr($page_url,'t=')?'':'&t='.$result['next'])));
			}
			
			//如果存在数据则读取
			if ($result['P']['ltable'] && $result['P']['table']){
				$_SESSION['ltable']		= $result['P']['ltable'];
				$_SESSION['table']		= $result['P']['table'];
			}
			
			//获得所有数据库
			$query = $db->query("SHOW TABLE STATUS");
			while($tl = $db->fetch_array($query)){
				$pre_len	= strlen($config['db']['pre']);
				$table[]	= array(
							'name'		=>substr($tl['Name'],$pre_len),
							'comment'	=>$tl['Comment'],
							'nums'		=>$tl['Rows'],
							);
			}
			
			//设定表1为a
			$last_table		= @key($result['P']['table']);
			$now			= $_SESSION['now']?$_SESSION['now']:'a';
			if ($last_table=='a'){
				$now		= $last_table;
			}
			if ($_SESSION['tablea']){
				$result['tablea']	= $_SESSION['tablea'];
				$tablea				= $result['tablea'];
			}
			
			//显示已经存在数据列表
			if (count($_SESSION['table'])>0){
				$table_data	= $FoundPHP->table_all();
				$table		= $table_data['table'];
				$ltable		= $table_data['ltable'];
				foreach($_SESSION['table'] AS $k=>$v) {
					if ($k!='a' && in_array($k,$table_index)){
					$now	= $k;
					
					$table1 = $FoundPHP->table_field($v['a']);
					$table2 = $FoundPHP->table_field($v['b']);
					
					//关联字段选中
					$join_ex	= explode('=',$v['ljoin']);
					$ljoina		= explode('.',trim($join_ex['0']));
					$ljoinb		= explode('.',trim($join_ex['1']));
					
					//关联字段
					if ($ljoina['1'] && $ljoinb['1']){
						$tpl->set_file('step2_field');
						$sub_now	 = $tpl->r();
					}else{
						$sub_now	 = '';
					}
					
					$tpl->set_file('step2_table');
					$tablelist	 .= $tpl->r();
					}
				}
			}
			
			
			//关联表
			$ltable				= $_SESSION['ltable'];
			
			//载入模板
			$tpl->set_file('step2');
			$tpl->p();
		break;
		
		//主表显示
		case'tablea':
				$table['a']			= trim($P['now']);
				$result['table']	= $table['a'];
				if ($table['a']){
					$query = $db->query('show full columns FROM '.$config['db']['pre'].$table['a']);
					while($tl = $db->fetch_array($query)){
						if ($tl['Key']=='PRI' && $tl['Extra']=='auto_increment'){
							$result['t_index'] = $t_index	= $tl['Field'];
							$result['t_order'] = $t_order	= $tl['Field'] .' ASC';
						}
					}
				}
				
				$result['t_field']	= $t_field		= trim($P['t_field'])!=''?trim($P['t_field']):'*';				//查询表字段
				$result['t_where']	= $t_where		= trim($P['t_where']);
				
				
				$_SESSION['ltable']	= $result;
				
				//关联表
				$_SESSION['table']['a'] = array('a'=>$table['a'],'b'=>'','ljoin'=>'');
				
				$result['sql']	= html_fix($FoundPHP->show_sql());
				echo json($result);
			exit;
		break;
		
		
		
		//插入表
		case'table':
			
			if (!in_array($P['now'],$table_index)){
				echo lang('抱歉格式错误');
				exit;
			}
			
			//当前组的定位，例如b、c、d
			$offset			= array_search($P['now'],$table_index);
			$result['now']	= $now		= $table_index[($offset+1)];
			
			$_SESSION['now']= $result['now'];
			
			//序列
		//	$_SESSION['table'][$result['now']] = array('a'=>'','b'=>'','ljoin'=>'');
		//	print_r($result['now']);  
			
			//获得所有数据库
			$table_data	= $FoundPHP->table_all();
			$table		= $table_data['table'];
			$ltable		= $table_data['ltable'];
		//	print_r($table_data);
		//	exit;
			
			//载入模板
			$tpl->set_file('step2_table');
			$result['html']	 = $tpl->r();
			
			echo json($result);
		exit;
		break;
		
		//插入表
		case'tabled':
			if (!in_array($P['now'],$table_index)){
				echo lang('抱歉格式错误');
				exit;
			}
			//当前组的定位，例如b、c、d
			$offset			= array_search($P['now'],$table_index);
			$result['now']	= $now		= $table_index[($offset-1)];
			if ($P['now']!='a'){
				unset($_SESSION['table'][$P['now']]);
			}
			
			$_SESSION['now']= $result['now'];
			$result['sql']	= $FoundPHP->show_sql();
			
			echo json($result);
			exit;
		break;
		
		//获取表的字段
		case'field':
			$table_ex	= explode(':',$o);
			$result['now']	= $now		= $P['now'];
			
			if ($table_ex['0']){
				$table1 	= $FoundPHP->table_field($table_ex['0']);
				$_SESSION['table'][$now]['a'] = $table_ex['0'];
			}
			if ($table_ex['2']){
				$table2 	= $FoundPHP->table_field($table_ex['2']);
				$_SESSION['table'][$now]['b'] = $table_ex['2'];
			}else{
				$_SESSION['table'][$now]['b'] = '';
			}
			
			
			
			//更新关联
			foreach($_SESSION['table'] AS $k=>$v) {
				if ($v['ljoin']!=''){
					$ljoin[$k]	= $v['ljoin'];
				}
			}
			
			//更新语句
			$_SESSION['ltable']['sql']	= $result['sql'];
			
			$result['sql']		= $FoundPHP->show_sql();
			
			$result['show']		= ($table_ex['0'] && $table_ex['2'])?1:0;
			
			//载入模板
			$tpl->set_file('step2_field');
			$result['html']	 = $tpl->r();
			
			echo json($result);
			exit;
		break;
		
		
		case'fieldset':
			if (count($_SESSION['table'])>0){
				foreach($_SESSION['table'] AS $k=>$v) {
					$table[$k]	= $v['a'];
				}
			}
			
			$result['t_index']	= $t_index		= trim($P['t_index'])!=''?trim($P['t_index']):'*';				//查询表字段
			if ($t_index){
				$_SESSION['ltable']['t_index']	= $t_index;
			}
			$result['t_field']	= $t_field		= trim($P['t_field'])!=''?trim($P['t_field']):'*';				//查询表字段
			if ($t_field){
				$_SESSION['ltable']['t_field']	= $t_field;
			}
			$result['t_where']	= $t_where		= trim($P['t_where']);
			if ($t_where){
				$_SESSION['ltable']['t_where']	= $t_where;
			}
			$result['t_order']	= $t_order		= trim($P['t_order']);
			if ($t_order){
				$_SESSION['ltable']['t_order']	= $t_order;
			}
			
			//更新关联
			if ($_SESSION['table'][$P['now']]['a']){
				$_SESSION['table'][$P['now']]['ljoin']	= trim($P['ljoin']);
			}
			
			//更新关联
			foreach($_SESSION['table'] AS $k=>$v) {
				if ($v['ljoin']!=''){
					$ljoin[$k]	= $v['ljoin'];
				}
			}
			
			//更新语句
			$_SESSION['ltable']['sql']	= $result['sql'];
			
			$result['sql']		= $FoundPHP->show_sql();
			
			$result['ljoin']	= $P['ljoin'];
			$result['tablea']	= $result;
			
			echo json($result);
			exit;
		break;
		
		case 3:
			if ($P['o']){
				//禁止提交文件内容
					foreach($P['tpl'] AS $k=>$v) {
							$name		= str_replace($P['old_m'],$a,$k);
							if ($_SESSION['dev_type']!=3){
								$_SESSION['tpl'][$a][$name] = base64_encode($v);
							}
							unset($P['tpl'][$k]);
							$P['tpl'][]	= $k;
					}
			}
			//云交互
			$result 	= $FoundPHP->model($P);
			//'<pre>';
			//print_r($P);
			
			if ($result['next']>0 && $P['o']){
				msg('',str_replace('t='.$P['step'],'t='.$result['next'],$page_url.(strstr($page_url,'t=')?'':'&t='.$result['next'])));
			}
			//载入模板
			$tpl->set_file('step3');
			$tpl->p();
			
		break;
		
		case 4:
			
			//云交互
			$result 	= $FoundPHP->success($P);
			//print_r($P);
		//	exit;
			if ($result['php']['name']){
				//模块名
				$mp_name					= basename($result['php']['name'],'.php');
				
				//影子模式
				if (is_file($result['php']['copy'])){
					$result['php']['table']	= $result['php']['data'];
					$result['php']['data']	= $tpl->reader($result['php']['copy']);
					//更新变量
					$result['php']['data']	= $FoundPHP->update_var($result['php']['data'],$result['php']['table']);
				}
				
				if (!is_dir(dirname($result['php']['name']))){
					mkdir(dirname($result['php']['name']));
				}
				
				
				$tpl->writer($result['php']['name'],$result['php']['data']);
			}
			
			//
			if (count($result['tpl'])){
				$mt_name				= basename($result['tpl'][0],'.htm');
				$mt_dir					= dirname($result['tpl']['0']);
				
				
				//删除模块相关的模版
				del_file($mt_dir.'/',$mp_name.'+');
				foreach($result['tpl'] AS $k=>$v) {
						if ($_SESSION['dev_type']==3){
							$tpl->writer(str_replace($mt_name,$mp_name,$v),$tpl->reader($v));
						}else{
							if (!is_dir(dirname($v))){
								mkdir(dirname($v));
							}
							$tpl->writer($v,html_fix(base64_decode($_SESSION['tpl'][$a][$v])));
						}
				}
			}
			//载入模板
			$tpl->set_file('step4');
			$tpl->p();
			
		break;
		
		
		default:
			
			
			$default_model	= 'plugin/model/';
			//ajax 查询程序内容
			if (is_dir($default_model.$s) && $s){
				//获得所有model模块
				$get_file	=  $tpl->get_dir($default_model.$s,1);
				echo json($get_file);
				exit;
			}
			
			//认证
			if ($o=='' && strlen($o)!=32){
				$oauth_url		= $FoundPHP->dev_url.'m=oauth&n='.$config['fp']['secret'].'&g='.base64_encode($config['set']['site_url'].$page_url);
				msg('',$oauth_url);
			}else{
				//认证存储时间
				if (strlen($o)==32){
					session('oauth_code',$o,7200);
				}
			}
			
			
			//提交检测
			if ($P['o']){
				if ($P['titles']==''){
					msg('抱歉，没有输入模块标题');
				}
				
				//影子模式
				if ($P['types']==3){
					if (trim($P['model'])=='' || trim($P['action'])==''){
						msg('抱歉，没有选择复制的模块与文件');
					}
					//记录类型
					$_SESSION['_sel_model'] = $P['action'];
					if (!strstr($P['action'],'.php')){
						msg('抱歉，只支持php格式文件');
					}
				}
				
				
				//非影子模式清楚文件地址
				if ($P['types']!=3){
					unset($P['model'],$P['action']);
				}
				
				$_SESSION['dev_type']	= $P['types'];
			}else{
				if ($_sel_title){
					$P['titles']	= $_sel_title;
				}
				
			}
			
			//云交互
			$result 	= $FoundPHP->def($P);
			
			if ($result['next']>0){
				//清空数据库表缓存
				unset($_SESSION['ltable'],$_SESSION['table'],$_SESSION['tpl']);
				msg('',str_replace('t='.$P['step'],'t='.$result['next'],$page_url.(strstr($page_url,'t=')?'':'&t='.$result['next'])));
			}
			//返回数据
			if ($result['P']['post']){
				$get_data	= json($result['P']['post']);
				$get_file	=  $tpl->get_dir($default_model.$get_data['model'],1);
				
			}
			
			//获得所有model模块
			$model_dir	=  $tpl->get_dir($default_model);
			
			unset($_SESSION['dev_type'],$_SESSION['_sel_model']);
			//载入模板
			$tpl->set_file('step1');
			$tpl->p();
	}
	
	
}
