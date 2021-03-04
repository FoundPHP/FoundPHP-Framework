<?php
/*	(C)2005-2018 Lightning Framework Buliding.
*	官网：http://www.l-fb.com
*	邮箱：master@l-fb.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.l-fb.com/agreement
*/


//======================== 基本变量 ========================\

//分类类别
$table['a']		= 'category';				//表名
$table['b']		= 'language';				//表名
$types			= 'sys_language';
$t_index		= 'cate_id';				//索引id
$t_field		= '*';						//字段
$t_where		= "types='$types'";			//条件
$t_order		= $t_index.' ASC';			//排序



//======================== 逻辑处理 ========================\

//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					'cate_name'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有[功能操作名]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'query'		=> 1,						//数据库判断是否存在
						't'			=> "add,edit",
					),
					'language'	=> array(
						'lang'		=> lang('抱歉，没有[语言简写]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//判断条件
						't'			=> "add,edit",
					),
					'types'	=> array(							//模块内的变量写入数据库
						'query'		=> 1,						//数据库判断是否存在
						'check'		=> "==''",					//判断条件
						't'			=> "add",
					),
					
				);

$insert[$table['b']]	= array(
					'lang'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有[语言名称]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						//'query'		=> 1,						//数据库判断是否存在
						't'			=> "translate",
					),
					'm'	=> array(
						'lang'		=> lang('抱歉，没有[模块]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//判断条件
						't'			=> "translate",
					),
					'a'	=> array(
						'lang'		=> lang('抱歉，没有[行动]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//判断条件
						't'			=> "translate",
					),
					'md5'	=> array(
						'lang'		=> lang('抱歉，没有[标识md5]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//判断条件
						't'			=> "translate",
					),
					'str'	=> array(
						'lang'		=> lang('抱歉，没有[语言字符]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//判断条件
						't'			=> "translate",
					),
					'dates'	=> array(
						'lang'		=> lang('抱歉，没有[更新日期]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//判断条件
						't'			=> "translate",
					),
					
				);

if(in_array($t,array('add'))){
	//获取 系统支持语言
	$set_lang	= $config['lang']['def'];
	
	//查询已添加的
	$sql		= sql_select( array('table'=>$table['a'],'where'=>$t_where,'order'=>$t_order,'type' => 'sql') );
	$query		= $db->query($sql);
	while($dls 	= $db->fetch_array($query)){
		$lang_ary[$dls['language']]	= $dls['language'];
	}
}
//操作处理
switch($t){
	//添加
	case'add':
		//提交数据
		if ($P['o']){
			//数据检测
			$language	= $P['lang_set'];
			$cate_name	= $set_lang[$language];
			$post = post_data($table['a'],$insert);
			// print_R($post);exit;
			if( sql_update_insert(array('table'=>$table['a'],'data'=>$post['data'],'check' =>$post['check'] )) == true ){
				$id		= $db->insert_id();
				msg('',"?a=$a&t=renew&id=".$id);
			}else{
				msg($page_msg['readd']);
			}
			
		}
	break;
	//删除数据
	case'del':
		//查询数据
		$data_info	= sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		
		//删除数据
		if(sql_del(array('table'=>$table['a'],'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'"))){
			msg('',$page_url_back.'&g=del');
		}else {
			msg($page_msg['del_error']);
		}
	break;
	//从中文里更新英文
	case'renew':
		//查询语种（不可删）
		
		$get_lang		= sql_select(array('table'=>$table['a'],'field'=>"cate_id,cate_name,language",'where'=>"cate_id='$id'",'order'=>'cate_id ASC'));
		
		//实例化翻译
		$translate		= load('class/translate/translate','FoundPHP_translate',$config['translate']);
		if($o==1){
			//进度条翻译插入
			$sql			= sql_select(array('table'=>$table['b'],'where'=>"lang='".$FOUNDPHP_LANG."'",'type'=>'sql'));
			$data_info		= limit($sql,1);
			while($dls 		= $db->fetch_array($data_info['query'])){
				//翻译
				$trans		= json($translate->convert($dls['str'],$dls['lang'],$get_lang['language']));
				//插入数据库
				if($trans['code']==1){
					$new_data	= array(
						'lang'		=> $get_lang['language'],
						'm'			=> $dls['m'],
						'a'			=> $dls['a'],
						'md5'		=> $dls['md5'],
						'str'		=> trims($trans['text']),
						'tra_dates'	=> time(),
					);
					$check['md5']	= $new_data['md5'];
					$check['lang']	= $new_data['lang'];
					sql_update_insert(array('table'=>$table['b'],'data'=>$new_data,'check'=>$check));
				}
			}
			$result['num']			= round($data_info['info']['nowpage']/$data_info['info']['pages'],2);
			$result['progress']		= round($data_info['info']['nowpage']/$data_info['info']['pages'],2)*100;
			$result['total']		= $data_info['info']['pages'];
			$result['next']	= $data_info['info']['nowpage']+1;
			json_out(1,$result);
		}
		
		$delang_num		= sql_select(array('table'=>$table['b'],'where'=>"lang='".$FOUNDPHP_LANG."'",'type'=>'num'));
		$tpl_file	= $a.'_'.$t;
	break;
	
	
	//编辑
	case'translate':
	
		//前台翻译还是后台翻译
		$s 				= $s?$s:1;
		//查询第语种（不可删）
		$get_lang		= sql_select(array('table'=>$table['a'],'field'=>"cate_id,cate_name,language",'where'=>"cate_id='$id'",'order'=>'cate_id ASC'));
		$t_where			= 'lang="'.$get_lang['language'].'"';
		//查询语言数量和中文语言数量 不相等时提示同步
		$delang_num		= sql_select(array('table'=>$table['b'],'where'=>"lang='".$FOUNDPHP_LANG."'",'type'=>'num'));
		$now_num		= sql_select(array('table'=>$table['b'],'where'=>$t_where,'type'=>'num'));
		if($now_num<$zh_num){
			$updates_lang	 = $zh_num-$now_num;
		}
		if($s==1){
			$t_where		.= ' AND m="admin"';
		}else{
			$t_where		.= ' AND m!="admin"';
		}
		if($P['o']){
			if(count($P['check'])>0){
				foreach($P['check'] as $k=>$v){
					if($v){
						//查询值
						$get_val	= sql_select(array('table'=>$table['b'],'where'=>"md5='$k' AND lang='".$get_lang['language']."' "));
						
						if($get_val['lid']>0){
							$data_ary	= array(
								'str'	=> $v,
								'check_dates'	=> time(),
							);
							//编辑
							sql_update_insert(array('table'=>$table['b'],'data'=>$data_ary,'where' =>" lid='".$get_val['lid']."'")); 
							
							
						}
					}
				}
				msg('',"?a=$a&t=$t&id=$id&p=$p&g=success");
			}
		}
		
		//查询需翻译语言
		$lang_sql		= sql_select(array('table'=>$table['b'],'where'=>$t_where,'type'=>'sql'));
		$lang_info		= limit($lang_sql,20);
		while($dls		= $db->fetch_array($lang_info['query'])){
			$lang_data[]	= $dls;
			$md5_str[$dls['md5']]	= $dls['md5'];
		}
		
		//查询默认语言
		
		$delang			= sql_select(array('table'=>$table['a'],'where'=>"language='".$FOUNDPHP_LANG."'"));
		
		if($md5_str){
			$sql		= sql_select(array('table'=>$table['b'],'where'=>"lang='".$FOUNDPHP_LANG."' AND md5 IN ('".implode("','",$md5_str)."')",'type'=>'sql'));
			$query	= $db->query($sql);
			while($dls		= $db->fetch_array($query)){
				$delang_trans[$dls['md5']]	= $dls;
			}
		}
		$pages	= pages($lang_info['info']);
			
		$tpl_file	= $a.'_'.$t;
	break;
	
	
	
	
	default:
		//统计翻译条数
		num_count(array(
			'sql'	=> "SELECT count(*) AS nums,lang AS id FROM ".table('language')." GROUP BY lang",
			'table'	=> "category",	//更新的表
			'data'	=> "numbers",			//更新字段名
			'where'	=> "language='{id}'",		//查询条件
			'types'	=> "types='$types'",		//更新表的查询条件
			'clear'	=> 0,				//清空数据,1不清空（如果不清空，没有数据则无法准确统计）
			'time'	=> 60					//定期更新时间（秒），默认不开
		));
		//默认语言数量
		
		$delang_num		= sql_select(array('table'=>$table['b'],'where'=>"lang='".$FOUNDPHP_LANG."'",'type'=>'num'));
		//获取数据列表
		$sql		= sql_select( array('table'=>$table['a'],'where'=>$t_where,'order'=>$t_order,'type' => 'sql') );
		$data_info	= limit($sql,$config['set']['limit']);
		$pages		= pages($data_info['info']);
}


?>