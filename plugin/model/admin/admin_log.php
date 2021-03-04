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

$table['a']		= 'logs';				//表名
$t_index		= 'id';						//索引id
$t_field		= '*';			//字段
$t_where		= "";						//条件
$t_order		= $t_index.' DESC';	//排序


//添加用户时的时间与ip
$reg_date		= time();
$reg_ip			= get_ip();
//======================== 逻辑处理 ========================\
//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					
					'username'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有选择[操作人]或格式错误'),
						't'		=> "add",				//数据输出的操作
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'titles'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有选择[页面标题]或格式错误'),
						't'		=> "add",				//数据输出的操作
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'todo'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有选择[动作]或格式错误'),
						't'		=> "add",				//数据输出的操作
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'logs'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有选择[操作内容]或格式错误'),
						't'		=> "add",				//数据输出的操作
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					
					'dates'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有选择[操作时间]或格式错误'),
						't'		=> "add",				//数据输出的操作
					//	'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					
				);


//添加编辑通用调用
if (in_array($t,array('add','edit'))){

	
}





//操作处理
switch($t){
	//添加
	case'add':
		$gid = $s;
		//提交数据
		if ($P['o']){
			$operate = implode(',',$P['operate_ary']);
			//数据检测
			$post = post_data($table['a'],$insert);
			
			if( sql_update_insert(array('table'=>$table['a'],'data'=>$post['data'],'check' =>$post['check'] )) == true ){
				msg('',$page_url_back.'&g=success');
			}else{
				msg($page_msg['readd']);
			}
			
		}
		 //运营中心
		$sql		= sql_select( array('table'=>$table['c'], 'where'=>"types='join_operate'",'order'=>'cate_id ASC','type'=>'sql') );
		$query		= $db->query($sql);
		while($dls = $db->fetch_array($query)){
			$operate_ary[] = $dls;
		}
	
		//权限组
		$sql 		= sql_select( array('table'=> $table['b'], 
											'order'=> " id ASC", 
											'type' => 'sql')
								);
		$query		= $db->query($sql);
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
			$operate = implode(',',$P['operate_ary']);
			//数据检测
			$post = post_data($table['a'],$insert);
			
			sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>($t_where?$t_where.' AND ':'')."$t_index='$id'"));
			$logs = $post['data']['nickname'];
			msg('',$page_url_back.'&g=success');
		}
		
		//释放字段为变量
		extract($data_info);
		
		$gid	   = $s?$s:$gid;
		//运营中心
		$sql		= sql_select( array('table'=>$table['c'], 'where'=>"types='join_operate'",'order'=>'cate_id ASC','type'=>'sql') );
		$query		= $db->query($sql);
		while($dls = $db->fetch_array($query)){
			$operate_ary[] = $dls;
		}
		//权限组
		$sql 		= sql_select( array('table'=> $table['b'], 
											'order'=> " id ASC", 
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
		//时间筛选
		if ($t_where['data']['date_start'] || $t_where['data']['date_end']){
			$t_where['text']	.= ($t_where['text']!=''?' AND ':'').date_where('dates',$t_where['data']['date_start'],$t_where['data']['date_end']);
		}
		
		//排序
		$t_order	= search_order($t_order);
		
		//数据列表
		$sql		= sql_select( array('sql'=>sql_join(),'where'=>$t_where['text'],'order'=>$t_order, 'type' => 'sql') );
		$data_info	= limit($sql,$config['set']['limit']);
		$pages		= pages($data_info['info']);
}


?>