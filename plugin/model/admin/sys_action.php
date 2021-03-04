<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/
defined('FoundPHP.com') or die('access denied!');

//引入分类函数库
load('function/category');
load('function/power');
//======================== 基本变量 ========================\

//分类类别
$table['a']		= 'category';				//表名
$types			= 'sys_menu';				//类型
$t_index		= 'cate_id';				//索引id
$t_field		= '*';						//字段
$t_where		= "types='$types'";			//条件
$t_order		= 'orders ASC,'.$t_index.' ASC';	//排序

//服务器配置
if ($config['set']['host_id']!=''){
	$host_id		= $config['set']['host_id'];
}

//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					'host_id'	=> array(					//提交内容
						'ope'		=> 'intval',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'fid'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有[上级菜单]或格式错误'),
						'ope'		=> 'intval',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> ($id>0)?"==$id":'',					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						't'			=> "add,edit",
					),
					'language'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有[模块标识]或格式不对'),
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'query'		=> 1,						//数据库判断是否存在
						't'			=> "add,edit",
					),
					'icon'	=> array(					//提交内容
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'cate_name'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有[模块名称]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						't'			=> "add,edit",
					),
					'cate_desc'	=> array(
						't'			=> "add,edit",
					),
					'cate_url'	=> array(
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'linkto'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'orders'	=> array(							//模块内的变量写入数据库
						'ope'		=> 'intval',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'shows'	=> array(							//模块内的变量写入数据库
						'ope'		=> 'intval',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'lockout'	=> array(							//用于文件管理
						'ope'		=> 'intval',
						't'			=> "add,edit",
					),
					'types'	=> array(							//模块内的变量写入数据库
						'query'		=> 1,						//数据库判断是否存在
						'check'		=> "==''",					//判断条件
						't'			=> "add",
					),
					
				);


//======================== 逻辑处理 ========================\



//添加编辑通用调用
if (in_array($t,array('add','edit'))){
	//查询权限名
	$sql 		= sql_select( array('table'=> $table['a'], 
						'where'=> "types='sys_model_name'",
						'order'=> 'cate_id ASC', 
						'type' => 'sql')
					);
	$ope_query		= $db->query($sql);



}

//缓存菜单
sys_power_cache();


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
	//分类
	$tree	= add_tree(cate_block("types='$types'"),0);
	//显示添加数据
	$shows	= 1;
	
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
			
			//缓存菜单
			sys_power_cache();
			
			msg('',$page_url_back.'&g=success');
		}
		
		//释放字段为变量
		extract($data_info);
		//解码菜单权限
		$ope_select = json($cate_desc);
		//分类
		$tree = add_tree(cate_block("types='$types'"),0);
	break;
	
	
	//删除数据
	case'del':
		//查询数据
		$data_info	= sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		
		//删除数据
		if(sql_del(array('table'=>$table['a'],'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'"))){
			//缓存菜单
			sys_power_cache();
			
			msg('',$page_url_back.'&g=del');
		}else {
			msg($page_msg['del_error']);
		}
	break;
	
	//分类上升
	case'up':
		//查询数据
		$data_info	= sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}
		$fid = $data_info['fid'];
		
		cate_order($id,$fid,$t);
		msg('',str_replace(array('&t='.$t,'&id='.$id,'&fid='.$fid),'',$page_url));

	break;
	
	
	//分类下降
	case'down':
		$data_info	= sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}
		$fid = $data_info['fid'];
		
		cate_order($id,$fid,$t);
		msg('',str_replace(array('&t='.$t,'&id='.$id,'&fid='.$fid),'',$page_url));
	break;
	
	default:
	//数据显示
		$data_list	= sys_model(cate_block("types='$types'"),0);
	
}


?>