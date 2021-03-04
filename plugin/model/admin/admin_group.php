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

$table['a']		= 'admin_group';			//表名
$table['b']		= 'admin_user';				//表名

$types			= 'sys_menu';				//类型
$t_index		= 'agid';						//索引id
$t_field		= '*';						//字段
$t_where		= "";						//条件
$t_order		= $t_index.' ASC';			//排序

//分组管理员限制人数
$master_num		= 5;

$dateline		= time();

//服务器配置
if (isset($config['set']['host_id'])){
	$host_id	= $config['set']['host_id'];
	$t_where	= "host_id=".$host_id;
}

//======================== 逻辑处理 ========================\

//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					'host_id'	=> array(					//提交内容
						'ope'		=> 'intval',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'names'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[管理组名]'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",			//必填
						't'			=> "add,edit",			//数据输出的操作
						'query'		=> 1,					//数据是否存在
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'master_id'	=> array(						//提交内容
						'code'		=> 'json',				//json编码
						't'			=> "add,edit",			//数据输出的操作
					),
					'master'	=> array(						//提交内容
						'lang'		=> lang('抱歉，没有选择[组管理员]'),
						'ope'		=> 'trim',				//json编码
						't'			=> "add,edit",			//数据输出的操作
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'intro'	=> array(						//提交内容
						'lang'		=> lang('抱歉，没有输入[管理组介绍]'),
						'ope'		=> 'trim',				//json编码
						't'			=> "add,edit",			//数据输出的操作
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'power'	=> array(						//提交内容
						'code'		=> 'json',				//json编码
						't'			=> "add,edit",			//数据输出的操作
					),
					'power_num'	=> array(						//提交内容
						'ope'		=> 'intval',				//int编码
						't'			=> "add,edit",				//数据输出的操作
					),
					'dateline'	=> array(						//提交内容
						'ope'		=> 'intval',				//int编码
						't'			=> "add,edit",			//数据输出的操作
					),

				);




//操作处理
switch($t){
	//添加
	case'add':
		//提交数据
		if ($P['o']){
			//计算权限数量
			if (is_array($P['power'])){
				$power_num	= 0;
				$power_num	= count($P['power']);
			}
			
			//数据检测
			$post = post_data($table['a'],$insert);
			
			if( sql_update_insert(array('table'=>$table['a'],'data'=>$post['data'],'check' =>$post['check'] )) == true ){
				msg('',$page_url_back.'&g=success');
			}else{
				msg($page_msg['readd']);
			}
			
		}
		
		//数据显示
		$data_list	= power_select(cate_block("types='$types'"),0);
	break;
	
	
	//编辑
	case'edit':
		//查询数据
		$data_info = sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		if($data_info[$t_index]!= $id || $id<=1){
			msg($page_msg['url_error']);
		}
		
		//管理员
		$sql		= sql_select( array('table'=>$table['b'],'field'=>'id,username', 'where'=>$t_where,'type'=>'sql') );
		$query		= $db->query($sql,200);
		while($dls	= $db->fetch_array($query)){
			$master_ary[$dls['id']] = $dls;
		}
		
		//提交数据
		if ($P['o']){
			//管理员检测
			if (!empty($P['master'])){
				$i=1;
				foreach($P['master'] AS $k=>$v) {
					if ($master_ary[$v] && $i<=$master_num){
						$i++;
						$master_id[]		= $v;
						$master_name[]		= $master_ary[$v]['username'];
					}
				}
				if (count($master_name)>0){
					$master					= implode(',',$master_name);
				}
				$P['master']				= $master;
			}
			//计算权限数量
			if (is_array($P['power'])){
				$power_num	= 0;
				$power_num	= count($P['power']);
			}
			
			//数据检测
			$post = post_data($table['a'],$insert);
			
			sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>($t_where?$t_where.' AND ':'')."$t_index='$id'"));
			msg('',$page_url_back.'&g=success');
		}
		
		//释放字段为变量
		extract($data_info);
		
		
		
		
		//权限解码
		$power		= json($power);
		//数据显示
		$data_list	= power_select(cate_block("types='$types'"),0);
	break;
	
	
	//删除数据
	case'del':
		//查询数据
		$data_info	= sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		if($data_info[$t_index]!= $id || $id<=1){
			msg($page_msg['url_error']);
		}
		//删除数据
		if(sql_del(array('table'=>$table['a'],'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'"))){
			msg('',$page_url_back.'&g=del');
		}else {
			msg($page_msg['del_error']);
		}
	break;
	
	
	//检查权限关联数据
	case'ajax';
	
	break;
	
	
	
	case'view':	
		$group		= sql_select(array('table'=>$table['a'],'where'=>"$t_index=$id"));
		$title      = $group['names']."组管理员";
		//查询数据
		$sql = sql_select( array('table'=>$table['b'], 'where'=>"gid='$id'",'type'=>'sql') );
		$data_info	= limit($sql,$config['set']['limit']);
		$pages 		= pages($data_info['info']);
		
		$tpl_file   = "admin_group_view";
		
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