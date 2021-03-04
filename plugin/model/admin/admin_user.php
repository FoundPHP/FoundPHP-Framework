<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/
defined('FoundPHP.com') or die('access denied!');

//引入权限
load('function/power');
//======================== 基本变量 ========================\

$table['a']		= 'admin_user';				//表名
$table['b']		= 'admin_group';			//表名
$ljoin['b'] 	= "b.agid=a.gid";				//关联
$table['c']		= "category";
$t_index		= 'id';						//索引id
$t_field		= 'a.*,b.names';			//字段
$t_where		= "";						//条件
$t_order		= 'a.'.$t_index.' ASC';	//排序


//服务器配置
if (isset($config['set']['host_id'])){
	$host_id	= $config['set']['host_id'];
	$t_where	= "a.id=1 OR a.host_id=".$host_id;
	$d_where	= "host_id=".$host_id;
}

//添加用户时的时间与ip
$reg_date		= time();
$reg_ip			= get_ip();
//======================== 逻辑处理 ========================\

//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					'host_id'	=> array(					//提交内容
						'ope'		=> 'intval',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'gid'	=> array(						//提交内容
						'lang'		=> lang('抱歉，没有选择[管理权限]或格式错误'),
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==0",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",			//必填
						't'			=> (@$id!=$aus['id']?"add,edit":''),				//数据输出的操作
						'query'		=> 1,					//数据是否存在
					),
					'lang'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有选择[语言]种类'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",			//必填
						't'			=> "add,edit",
					),
					'username'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[用户名]或格式错误'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add",				//必填
						't'			=> "add",				//数据输出的操作
						'query'		=> 1,					//数据是否存在
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
						'order'		=> 1,
					),
					'password'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[密码]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'code'		=> 'md5',					//md5或base64  对数据编码
						'long'		=> '6,20',						//字符长度6表示最小字符，6,20标识6-20位长度
						'req'		=> "add",					//必填
						't'			=> "add,edit",
					),
					'nickname'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[用户姓名]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",				//必填
						't'			=> "add,edit",
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'email'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[邮箱地址]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "mail",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						't'			=> "add,edit",
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'phone'	=> array(
						'lang'		=> lang('抱歉，没有输入[手机/电话]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'position'	=> array(
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'operate'	=> array(
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'gender'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'states'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'reg_date'	=> array(
						't'			=> "add",
					),
					'reg_ip'	=> array(
						't'			=> "add",
					),
				);

//操作处理
switch($t){
	//添加
	case'add':
		//提交数据
		if ($P['o']){
			if (!empty($P['operate_ary'])){
				$operate = @implode(',',$P['operate_ary']);
			}
			//数据检测
			$post = post_data($table['a'],$insert);
			
			if( sql_update_insert(array('table'=>$table['a'],'data'=>$post['data'],'check' =>$post['check'] )) == true ){
				
			
					//选中分组数量更新统计
					$update_cnt[]	= array(
										'set'	=>array('nums'=> sql_select(array('table'=>$table['a'],'where' =>($d_where?$d_where.' AND ':'')." gid='".$P['gid']."'",'type'=>'num')) ),
										'where'	=>"agid='".$P['gid']."'"
										);
					//更新统计
					sql_update_count(array('table' =>$table['b'],'data'=>$update_cnt));
				
				
				msg('',$page_url_back.'&g=success');
			}else{
				msg($page_msg['readd']);
			}
			
		}
		
		
		//获取 系统支持语言
		$set_lang	= $config['lang']['def'];
		$sql		= sql_select( array('table'=>'category','where'=>"types='sys_language'",'order'=>"cate_id ASC",'type' => 'sql') );
		$query		= $db->query($sql);
		while($dls 	= $db->fetch_array($query)){
			$lang_ary[$dls['language']]	= $dls['language'];
		}
		
		
		//权限组
		$sql 		= sql_select( array('table'=> $table['b'], 
											'where'=> $d_where,
											'order'=> "agid ASC",
											'type' => 'sql')
								);
		$query		= $db->query($sql);
		//默认激活
		$states		= 1;
	break;
	
	
	//编辑
	case'edit':
	
		//查询数据
		$data_info = sql_select( array('table'=>$table['a'], 'where'=>($d_where?$d_where.' AND ':'')."$t_index='$id'") );
		
		
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}

		
		//提交数据
		if ($P['o']){
			if ($P['operate_ary']){
				$operate = implode(',',$P['operate_ary']);
			}
			
			//数据检测
			$post = post_data($table['a'],$insert);
			//更新数据
			sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>($d_where?$d_where.' AND ':'')."$t_index='$id'"));
			
			
			//选中分组数量更新统计
			$update_cnt[]	= array(
								'set'	=>array('nums'=> sql_select(array('table'=>$table['a'],'where' =>($d_where?$d_where.' AND ':'')." gid='".$P['gid']."'",'type'=>'num')) ),
								'where'	=>"agid='".$P['gid']."'"
								);
			
			if ($P['gid_old']!=$P['gid']){
				//旧分组数量更新统计
				$update_cnt[]		= 	array(
								'set'	=>array('nums'=> sql_select(array('table'=>$table['a'],'where' =>($d_where?$d_where.' AND ':'')." gid='".$P['gid_old']."'",'type'=>'num')) ),
								'where'	=>"agid='".$P['gid_old']."'"
								);
			}
			//更新统计
			sql_update_count(array('table' =>$table['b'],'data'=>$update_cnt));
			
			msg('',$page_url_back.'&g=success');
		}
		
		//释放字段为变量
		extract($data_info);
		
		$gid	   = $s?$s:$gid;
		
		
		//获取 系统支持语言
		$set_lang	= $config['lang']['def'];
		$sql		= sql_select( array('table'=>'category','where'=>"types='sys_language'",'order'=>"cate_id ASC",'type' => 'sql') );
		$query		= $db->query($sql);
		while($dls 	= $db->fetch_array($query)){
			$lang_ary[$dls['language']]	= $dls['language'];
		}
		
		//权限组
		$sql 		= sql_select( array('table'=> $table['b'], 
											'where'=> $d_where,
											'order'=> "agid ASC", 
											'type' => 'sql')
								);
		$query		= $db->query($sql);
		
		//性别选择
		$gender_ck 	= 'gender_ck'.$gender;
		$$gender_ck 	= 'checked';
	break;
	
	
	//删除数据
	case'del':
		//查询数据
		$data_info	= sql_select( array('table'=>$table['a'], 'where'=>($d_where?$d_where.' AND ':'')."$t_index='$id'") );
		
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}
		
		//删除数据
		if(sql_del(array('table'=>$table['a'],'where'=>($d_where?$d_where.' AND ':'')."$t_index='$id'"))){
			
			//选中分组数量更新统计
			$update_cnt[]	= array(
							'set'	=>array('nums'=> sql_select(array('table'=>$table['a'],'where' =>($d_where?$d_where.' AND ':'')." gid='".$data_info['gid']."'",'type'=>'num')) ),
							'where'	=>"agid='".$data_info['gid']."'"
							);
			//更新统计
			sql_update_count(array('table' =>$table['b'],'data'=>$update_cnt));
			
			msg('',$page_url_back.'&g=del');
		}else {
			msg($page_msg['del_error']);
		}
	break;

	
	
	default:
		//搜索
		$t_where	= search_where($t_where,30);
		//排序
		$t_order	= search_order($t_order);
		
		//数据列表
		$sql		= sql_select( array('sql'=>sql_join(),'where'=>$t_where['text'],'order'=>$t_order, 'type' => 'sql') );
		$data_info	= limit($sql,$config['set']['limit']);
		$pages		= pages($data_info['info']);
}


?>