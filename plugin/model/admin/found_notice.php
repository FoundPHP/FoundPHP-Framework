<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
//引入分类函数库
load('function/category');
load('function/power');
$table['a']		= 'bulletin';				//表名
$table['b']		= 'category';				//表名
$t_index		= 'bid';						//索引id
$t_field		= '*';						//字段
$t_where		= "";						//条件
$t_order		= $t_index.' DESC';	//排序
$post_date		= time();
$post_ip		= get_ip();

//======================== 逻辑处理 ========================\
//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					'titles'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[公告标题]'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",			//必填
						't'			=> "add,edit",			//数据输出的操作
						//'query'		=> 1,					//数据是否存在
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'genre'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[公告类型]'),
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==0",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",			//必填
						't'			=> "add,edit",			//数据输出的操作
						//'query'		=> 1,					//数据是否存在
						//'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'contents'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[公告内容]'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						//'req'		=> "add,edit",			//必填
						't'			=> "add,edit",			//数据输出的操作
						//'query'		=> 1,					//数据是否存在
						//'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'post_uid'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[建立者]'),
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==0",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						//'req'		=> "add",			//必填
						't'			=> "add",			//数据输出的操作
						//'query'		=> 1,					//数据是否存在
						//'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'post_date'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[创建时间]'),
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==0",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						//'req'		=> "add",			//必填
						't'			=> "add",			//数据输出的操作
						//'query'		=> 1,					//数据是否存在
						//'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'post_ip'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[创建ip]'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						//'req'		=> "add",			//必填
						't'			=> "add",			//数据输出的操作
						//'query'		=> 1,					//数据是否存在
						//'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
				);

//查询公告类型
$found_notice_sql		= sql_select(array('table'=>$table['b'],'where'=>"types='found_notice_set'",'type'=>'sql'));
$found_notice_query		= $db->query($found_notice_sql);
while($dls	= $db->fetch_array($found_notice_query)){
	$found_notice[]		= $dls;
	$found_name[$dls['cate_id']]		= $dls['cate_name'];
}

//操作处理
switch($t){
	//添加
	case'add':
		$post_uid		= $aus['id'];
		//提交数据
		if ($P['o']){
			//数据检测
			$post = post_data($table['a'],$insert);
			
			if( sql_update_insert(array('table'=>$table['a'],'data'=>$post['data'],'check' =>$post['check'] )) == true ){
				msg('',$page_url_back.'&g=success');
			}else{
				msg($page_msg['readd']);
			}
			
		}
		
		//默认激活
		$states		= 1;
	break;
	
	
	//编辑
	case'edit':
		
		//查询数据
		$data_info = sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}

		
		//提交数据
		if ($P['o']){
			//数据检测
			$post = post_data($table['a'],$insert);
			sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>($t_where?$t_where.' AND ':'')."$t_index='$id'"));
			msg('',$page_url_back.'&g=success');
		}
		
		//释放字段为变量
		extract($data_info);
	
		
		
		//性别选择
		$gender_ck 	= 'gender_ck'.$gender;
		$$gender_ck 	= 'checked';
	break;
	
	
	//删除数据
	case'del':
		//查询数据
		$data_info	= sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}
		
		//删除数据
		if(sql_del(array('table'=>$table['a'],'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'"))){
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