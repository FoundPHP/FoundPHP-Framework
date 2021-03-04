<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/
defined('FoundPHP.com') or die('access denied!');


//======================== 基本变量 ========================\

//分类类别
$table['a']		= 'category';				//表名
$types			= 'sys_language';			//类型
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
					'cate_desc'	=> array(
						'lang'		=> lang('抱歉，没有[功能名称]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//判断条件
						't'			=> "add,edit",
					),
					'types'	=> array(							//模块内的变量写入数据库
						'query'		=> 1,						//数据库判断是否存在
						'check'		=> "==''",					//判断条件
						't'			=> "add",
					),
					'linkto'	=> array(							//模块内的变量写入数据库
						'lang'		=> lang('抱歉，没有选择[默认语言]'),
						'ope'		=> 'intval',						//数据库判断是否存在
						'check'		=> "==''",					//判断条件
						't'			=> "add,edit",
					),
					
				);



//操作处理
switch($t){
	//添加
	case'add':
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
	
	default:
		
		//获取数据列表
		$sql		= sql_select( array('table'=>$table['a'],'where'=>$t_where,'order'=>$t_order,'type' => 'sql') );
		$data_info	= limit($sql,$config['set']['limit']);
		$pages		= pages($data_info['info']);
}


?>