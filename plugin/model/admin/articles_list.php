<?php
/*	(C)2005-2019 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/
defined('FoundPHP.com') or die('access denied!');

//======================== 基本变量 ========================\
load('function/category');

$table['a']		= 'articles';
$table['b']		= 'article_data';
if ($t=='edit'){
$ljoin['b']		= 'b.aid=a.aid';
}
$table['c']		= "category";
$ljoin['c']		= 'c.cate_id=a.cate_id';
$table['d']		= "articles_relation";


$cases			= 'phpcourse';

$t_index		= 'aid';						//索引id
if ($t=='edit'){
$t_field		= 'a.*,b.*';			//字段
}else {
$t_field		= 'a.*,c.cate_name';			//字段
}
$t_where		= "a.cases='$cases'";						//条件
$t_order		= 'a.date_edit DESC';		//排序

//添加用户时的时间与ip
$date_add = $date_edit = $dateline= time();
//======================== 逻辑处理 ========================\

//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					'cate_id'	=> array(
						'lang'		=> lang('抱歉，没有设置[文章分类]'),
						'ope'		=> 'intval',
						'check'		=> "==0",
						'req'		=> "add,edit",
						't'			=> "add,edit",
						'query'		=> 1,
					),
					
					'titles'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[文章标题]或格式错误'),
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",				//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add,edit",
						't'			=> "add,edit",
						'query'		=> 1,
						'search'	=> 'like',
					),
					'smarty_title'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[SEO标题]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'req'		=> "add",					//必填
						't'			=> "add,edit",
					),
					'keywords'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[关键词]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'req'		=> "add,edit",				//必填
						't'			=> "add,edit",
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'description'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[文章简介]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'thumbnail'	=> array(
						'lang'		=> lang('抱歉，没有输入[缩略图]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
					),
					'pageurl'	=> array(
						'lang'		=> lang('抱歉，没有输入[文章链接]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add,edit",
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'uid'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'author'	=> array(
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'cases'	=> array(
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'date_add'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'date_edit'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "edit",
					),
					
				);

$insert[$table['b']]	= array(
					'cate_id'	=> array(
						'lang'		=> lang('抱歉，没有设置[文章分类]'),
						'ope'		=> 'intval',
						'check'		=> "==0",
						'req'		=> "add,edit",
						't'			=> "add,edit",
					),
					'aid'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[文章标题]或格式错误'),
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'req'		=> "add",
						't'			=> "add",
					),
					'uid'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'subject'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[文章标题]'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",
						'req'		=> "add",					//必填
						't'			=> "add,edit",
					),
					'content'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[文章内容]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",
						'req'		=> "add,edit",				//必填
						't'			=> "add,edit",
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'md_content'	=> array(					//提交内容
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'req'		=> "add,edit",				//必填
						't'			=> "add,edit",
					),
					'author'	=> array(
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'cases'	=> array(
						'ope'		=> 'trim',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'dateline'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					'page_num'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "edit",
					),
					
				);
$insert[$table['d']]	= array(
					'types'	=> array(
						'lang'		=> lang('抱歉，没有设置[关联类型]'),
						'ope'		=> 'intval',
						'check'		=> "==0",
						'req'		=> "add,edit",
						't'			=> "add,edit",
					),
					'genres'	=> array(
						'lang'		=> lang('抱歉，没有设置[关联文章类型]'),
						'ope'		=> 'trim',
						'check'		=> "==''",
						'req'		=> "add,edit",
						't'			=> "add,edit",
					),
					'aid'	=> array(
						'lang'		=> lang('抱歉，没有设置[关联文章id]'),
						'ope'		=> 'intval',
						'check'		=> "==0",
						'req'		=> "add,edit",
						't'			=> "add,edit",
					),
					'rid'	=> array(
						'lang'		=> lang('抱歉，没有设置[关联id]'),
						'ope'		=> 'intval',
						'check'		=> "==0",
						'req'		=> "add,edit",
						't'			=> "add,edit",
					),
					
					'dateline'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> "add",
					),
					
				);
//通用添加与编辑
if ( in_array($t,array('add','edit','view'))){
	if($P['o']){
		//如果mdedit编辑器则调整存储数据
		if ($config['edit']['type']=='mdeditor'){
			$P['md_content']	= $P['content'];
			$P['content']		= $P['content-html-code'];
		}
			
			//上传文件接收
			$files			= $FoundPHP_upload->save(array(
				'id'		=> 'attach',				//表单提交元素名
				'maxsize'	=> '4000',						//上传限制单位kb
				'width'		=> '430',						//宽度 仅对图像有效 宽高必须同时赋值
				'height'	=> '430',						//高度 仅对图像有效 宽高必须同时赋值
				'dir'		=> $FILE_DIR.'articles/'.dates(time(),'Ym').'/',	//存储路径
				'name'		=> rand(1000,9999),				//存储路径
				'type'		=> array('jpg','jpeg','png'),	//支持的格式
			));
			
			
		if ($files['filename']){
			$thumbnail		= $files['dir'].$files['filename'];
		}
	}
	//查询、关键词
	$sql = sql_select(array('table'=>$table['c'],'field'=>"cate_id,cate_name,types",'where'=>"types='article_cate'",'type'=>"sql"));
	$query	= $db->query($sql);
	while($dls = $db->fetch_array($query)){
		$keyword_ary[$dls['cate_name']]	= $dls;
		$rele_key[$dls['cate_id']]	= $dls['cate_name'];
	}
	//查询其他文章进行关联
	if($t=='edit'){
		$s_where = "a.aid!='$id'";
	}
	$sql	= sql_select(array('sql'=>sql_join(),'where'=>$s_where,'type'=>"sql"));
	$query	= $db->query($sql);
	while($dls = $db->fetch_array($query)){
		$rele_ls[$dls['titles']]	= $dls;
		$rele_art[$dls['id']]	= $dls['titles'];
	} 
}


//操作处理
switch($t){
	case'art_rele':
		$str = $P['q'];
		//查询其他文章进行关联
		$s_where	= " a.titles LIKE '%".$str."%'";
		if($id>0){
			$s_where	.= " AND a.$t_index !='$id'";
		}
		$sql	= sql_select(array('sql'=>sql_join(),'where'=>$s_where,'type'=>"sql"));
		$query	= $db->query($sql);
		while($dls = $db->fetch_array($query)){
			$data['id']		= $dls['id'];
			$data['titles']	= $dls['titles'];
			$rele_ls[]	= $dls['titles'];
		}
		if(count($rele_ls)>0){
			json_out(1,array('list'=>$rele_ls));
		}else{
			
			json_out(0);
		}
	break;
	case'key_rele':
		$str = $P['q'];
		//查询其他文章进行关联
		$sql = sql_select(array('table'=>$table['c'],'field'=>"cate_id,cate_name,types",'where'=>"types='article_cate' AND cate_name LIKE '%".$str."%'",'type'=>"sql"));
		$query	= $db->query($sql);
		while($dls = $db->fetch_array($query)){
			$cate_all[]	= $dls['cate_name'];
		}
		if(count($cate_all)>0){
			json_out(1,array('list'=>$cate_all));
		}else{
			
			json_out(0);
		}
	break;
	//查看
	case'view':
		//查询数据
		$data_info = sql_select( array('sql'=>sql_join(), 'where'=>"$t_index='$id'" ) );
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}
		extract($data_info);
		/*
		//查询关联文章
		$sql	= sql_select(array('table'=>$table['d'],'field'=>"rid,types",'where'=>"aid='$id' AND genres='phpcourse'",'type'=>"sql"));
		$query	= $db->query($sql);
		while($dls = $db->fetch_array($query)){
			if($dls['types']==2){
				$dls['titles']	= "'".$rele_art[$dls['rid']]."'";
			}else{
				$dls['titles']	= "'".$rele_key[$dls['rid']]."'";
			}
			$sel_rele[$dls['types']][] =$dls['titles'];
		}
		$sel_aid	= $sel_rele[2];
		$sel_kid	= $sel_rele[1];
		*/
		$cate_ary	= article_tree(cate_block("types='article_cate'"),0,1);//文章分类
		$tpl_file	= "articles_list_view";
	break;
	//添加
	case'add':
		//提交数据
		if ($P['o']){
			$id			= 0;
			$author		= $aus['nickname'];
			$uid		= $aus['id'];
			//数据检测
			$post = post_data($table['a'],$insert);
			$post_b = post_data($table['b'],$insert);
			
			if( sql_update_insert(array('table'=>$table['a'],'data'=>$post['data'],'check' =>$post['check'] )) == true ){
				$aid	= $db->insert_id();
				$post_b['data']['aid']	= $aid;
				sql_update_insert(array('table'=>$table['b'],'data'=>$post_b['data'],'check' =>$post_b['check'] ));
				//处理关联文章
				$rele_article	 = explode(',',$P['rele_article']);
				if(count($rele_article)>0){
					//先删除原来的 关联id
					// sql_del(array('table'=>$table['d'],'where'=>"types=2 AND genres='phpcourse' AND aid='$aid'"));
					foreach($rele_article AS $k=>$v){
						$rid	= $rele_ls[$v]['id'];
						if($rid>0){
							$types	= 2;
							$genres	= 'phpcourse';
							$post	= post_data($table['d'],$insert);
							sql_update_insert(array('table'=>$table['d'],'data'=>$post['data'],'check'=>$post['check']));
						}
					}
				}
				
				//处理关联关键词
				$rele_key	 = explode(',',$P['rele_key']);
				if(count($rele_key)>0){
					//先删除原来的 关联id
					// sql_del(array('table'=>$table['d'],'where'=>"types=1 AND genres='phpcourse' AND aid='$aid'"));
					foreach($rele_key AS $k=>$v){
						$rid	= $keyword_ary[$v]['cate_id'];
						if($rid>0){
							$types	= 1;
							$genres	= 'phpcourse';
							$post	= post_data($table['d'],$insert);
							sql_update_insert(array('table'=>$table['d'],'data'=>$post['data'],'check'=>$post['check']));
						}
					}
				}
				msg('',$page_url_back.'&g=success');
			}else{
				msg($page_msg['readd']);
			}
			
		}
		
		$cate_ary = article_tree(cate_block("types='article_cate'"),0,1);//文章分类
		//默认激活
		$states		= 1;
	break;
	
	
	//编辑
	case'edit':
		//查询数据
		
		$data_info = sql_select( array('sql'=>sql_join(), 'where'=>"a.$t_index='$id'" ) );
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}
		
		//提交数据
		if ($P['o']){
			//数据检测
			
			$post = post_data($table['a'],$insert);
			// print_R($post);exit;
			sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>"$t_index='$id'" ));
			$aid		= $id;
			$post_b = post_data($table['b'],$insert);
			sql_update_insert(array('table'=>$table['b'],'data'=>$post_b['data'],'where' =>"aid='$id'"));
			//处理关联文章
			$rele_article	 = explode(',',$P['rele_article']);
			if(count($rele_article)>0){
				//先删除原来的 关联id
				sql_del(array('table'=>$table['d'],'where'=>"types=2 AND genres='phpcourse' AND aid='$aid'"));
				foreach($rele_article AS $k=>$v){
					$rid	= $rele_ls[$v]['id'];
					if($rid>0){
						$types	= 2;
						$genres	= 'phpcourse';
						$post	= post_data($table['d'],$insert);
						sql_update_insert(array('table'=>$table['d'],'data'=>$post['data'],'check'=>$post['check']));
					}
				}
			}
			
			//处理关联关键词
			$rele_key	 = explode(',',$P['rele_key']);
			if(count($rele_key)>0){
				//先删除原来的 关联id
				sql_del(array('table'=>$table['d'],'where'=>"types=1 AND genres='phpcourse' AND aid='$aid'"));
				foreach($rele_key AS $k=>$v){
					$rid	= $keyword_ary[$v]['cate_id'];
					if($rid>0){
						$types	= 1;
						$genres	= 'phpcourse';
						$post	= post_data($table['d'],$insert);
						sql_update_insert(array('table'=>$table['d'],'data'=>$post['data'],'check'=>$post['check']));
					}
				}
			}
			
			msg('',$page_url_back.'&g=success');
		}
		
		//删除缩略图数据
		if ($o=='del'){
			unlink($data_info['thumbnail']);
			sql_update_insert( array('table' =>$table['a'],'data' =>array('thumbnail'=>''),'where' =>"$t_index='$id'" ));
			msg('','?a='.$a.'&id='.$id.'&t=edit&g=success');
		}
		/*
		//查询关联文章
		$sql	= sql_select(array('table'=>$table['d'],'field'=>"rid,types",'where'=>"aid='$id' AND genres='phpcourse'",'type'=>"sql"));
		$query	= $db->query($sql);
		while($dls = $db->fetch_array($query)){
		
			if($dls['types']==2){
				$dls['titles']	= "'".$rele_art[$dls['rid']]."'";
			}else{
				$dls['titles']	= "'".$rele_key[$dls['rid']]."'";
			}
			$sel_rele[$dls['types']][] =$dls['titles'];
		}
		$sel_aid	= $sel_rele[2];
		
		$sel_kid	= $sel_rele[1];*/
		
		//释放字段为变量
		extract($data_info);
		$fid		= $cate_id;//修复文章分类默认选中
		
		//如果mdedit编辑器则调整存储数据
		if ($config['edit']['type']=='mdeditor'){
			$content		= $md_content;
		}
		
		$cate_ary = article_tree(cate_block("types='article_cate'"),0,1);//文章分类
	break;
	
	
	//删除数据
	case'del':
		$list_id = $P['sel_index'];
		if(is_array($list_id) ){
				$del_data	= '';
				//获得删除数据id
				$sql 		= sql_select( array('table'=>'articles', 'where'=>" id IN (".implode(',',$list_id).") ",'type' => 'sql') );
				$data_info	= limit($sql,$config['set']['limit']);
				while ($dls	= $db->fetch_array($data_info['query'])){
					//检测数据是否存在
					if(in_array($dls['id'],$list_id)){
						@unlink($dls['thumbnail']);
						//删除数据id
						$del_data[]	= $dls['id'];
					}
				}
				//如果获取到数据则执行删除操作
				if(count($del_data)>0){
					sql_del( array('table'=>'articles', 'where'=>"id IN (".implode(',',$del_data).")") );
					sql_del( array('table'=>'article_data', 'where'=>"aid IN (".implode(',',$del_data).")") );
					//删除关系
					sql_del( array('table'=>$table['d'], 'where'=>"aid IN (".implode(',',$del_data).")") );
					msg('',$page_url_back.'&g=del');
				}
		//单一删除
		}elseif ($data_info	= sql_select( array('table'=>$table['a'], 'where'=>"$t_index='$id'" ) )){
			if($data_info[$t_index]!= $id || $id<=0){
				msg($page_msg['url_error']);
			}
			
			//删除数据
			if(sql_del(array('table'=>$table['a'],'where'=>"$t_index='$id'" ))){
				//删除照片
				@unlink($data_info['thumbnail']);
				sql_del( array('table'=>$table['b'], 'where'=>"aid='$id'") );
				//删除关系
				sql_del( array('table'=>$table['d'], 'where'=>"aid ='$id'") );
				msg('',$page_url_back.'&g=del');
			}else {
				msg($page_msg['del_error']);
			}
			
		}else{
				msg($page_msg['url_error']);
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