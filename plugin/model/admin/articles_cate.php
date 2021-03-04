<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

load('function/power');
load('function/category');

$table['a']		= 'category';				//表名
$types			= "article_cate";						//类型
$t_index		= 'cate_id';						//索引id
$t_field		= '*';						//字段
$t_where		= "types='$types'";						//条件
$t_order		= $t_index.' ASC';	//排序


//======================== 逻辑处理 ========================\
//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					'cate_name'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[名称]'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",				//必填
						't'			=> "add,edit",				//数据输出的操作
						'query'		=> 1,					//数据是否存在
					),
			
					'fid'	=> array(
						'ope'		=> 'intval',
						't'			=> "add,edit",
						'query'		=> 1,	
					),
					'types'	=> array(
						't'			=> "add",
						'query'		=> 1,	
					),
					'orders'	=> array(
						'ope'		=> 'intval',
						't'			=> "add,edit",
					),/* 
					'shows'	=> array(
						'ope'		=> "intval",
						't'			=> "add,edit",
					), */
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
		$tree = article_tree(cate_block("fid=0 AND ".$t_where),0,2);
		
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
			// print_r($post);exit;
			sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>($t_where?$t_where.' AND ':'')."$t_index='$id'"));
			msg('',$page_url_back.'&g=success');
		}
		
		//释放字段为变量
		extract($data_info);
	
		
		$tree = article_tree(cate_block("fid=0 AND ".$t_where),0,2);
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
		$data_list	= article_model(cate_block($t_where),0);
}


?>