<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
// 全局设置
	include_once "globals.php";


	
	/**
	*   添加功能按钮
	*	id 			当前信息的id
	*	more 		附加信息，例如订单等都属于编辑状态
			more	数值为 1 表示关闭删除功能，其他内容表示附加信息
	*/
	function add($die_power=array()){
		global $aus;
		if (is_array($GLOBALS['now_powers'])){
			if(@array_key_exists('add',$GLOBALS['now_powers'])){
				$result = '<button type="button" class="btn btn-dark" onclick="location=\''.$GLOBALS['page_url'].'&t=add\'">'.lang('添加').'</button>';
			}
			//导出数据
			if(@array_key_exists('export_data',$GLOBALS['now_powers']) && !in_array('export_data',$die_power)){
				$result .= '&nbsp;<button type="button" class="btn btn-primary" onclick="location=\'?'.($GLOBALS['m']!=''?'m='.$GLOBALS['m'].'&':'').'a=export_data&n='.$GLOBALS['a'].($GLOBALS['o'] && in_array($GLOBALS['g'],array('a','d'))?"&o=".$GLOBALS['o']."&g=".$GLOBALS['g']:'').'\'">'.$GLOBALS['_sys_pn']['export_data'].'</button>';
			}
			//导入数据
			if(@array_key_exists('import_data',$GLOBALS['now_powers']) && !in_array('import_data',$die_power)){
				$result .= '&nbsp;<button type="button" class="btn btn-primary" onclick="location=\'?'.($GLOBALS['m']!=''?'m='.$GLOBALS['m'].'&':'').'a='.$GLOBALS['a'].'&t=import_data\'">'.$GLOBALS['_sys_pn']['import_data'].'</button>';
			}
			
			//批量删除
			if(@array_key_exists('bdel',$GLOBALS['now_powers'])){
				$result .= '&nbsp;<button type="submit" class="btn btn-danger" onclick="javascript:if(confirm(\''.lang('您确定要删除吗?').'\'))return ture; else return false;">批量删除</button>';
			}
			
			return $result;
		}
	}
	
	
	/*
	*	搜索权限
	*	
	*/
	function search($search_file='_search'){
		if (is_array($GLOBALS['now_powers'])){
			if(array_key_exists('search',$GLOBALS['now_powers'])){
				
				//session 搜索数据
				$t		= ($GLOBALS['t'] && $GLOBALS['id']>0?'_'.$GLOBALS['t'].$GLOBALS['id']:'');
				$k		= $GLOBALS['m'].'_'.$GLOBALS['a'].$t;
				$GLOBALS['search_val']	= $search_val	= json(session($k));
				$input	= array();
				//获得关键词
				foreach($GLOBALS['insert'] AS $K=>$V){
					foreach($V AS $sk=>$sv){
						if ((@$sv['search']==1 || @$sv['search']=='like') && $sv['lang']){
							preg_match_all('@\[(.+)\]@i', $sv['lang'], $matches);
							$value		= (@$search_val[$sk]?@$search_val[$sk]:@$GLOBALS['P'][$sk]);
							$input[]	= array('title'=>$matches['1']['0'],'name'=>$sk,'value'=>$value,'type'=>'text');
						}
					}
				}
				
				
				if (count($input)>0){
					//设置搜索值
					$GLOBALS['tpl']->set_var('_search_val',$search_val);
					$GLOBALS['tpl']->set_var('_search_input',$input);
					$GLOBALS['tpl']->set_file($search_file,@$GLOBALS['tpl_dir']);
					return @$id.$GLOBALS['tpl']->r();
				}
			}
		}
	}
	
	
	//搜索条件
	//搜索数据保留30分钟
	function search_where($set_where='',$times=30){
		$t		= ($GLOBALS['t'] && $GLOBALS['id']>0?'_'.$GLOBALS['t'].$GLOBALS['id']:'');
		$k		= $GLOBALS['m'].'_'.$GLOBALS['a'].$t;
		//清空搜索记录
		if (@$GLOBALS['s']=='clear'){
			session($k,'[null]');
			session('search_sql','[null]');
			session('search_where','[null]');
			session('search_order','[null]');
			session('search_group','[null]');
			msg('',str_replace('&s=clear','',$GLOBALS['page_url']));
			return '';
		}
		//存储
		if (@$GLOBALS['P']['key']){
			$post	= array();
			foreach($GLOBALS['P']['key'] AS $pk=>$pv) {
				if ($pv || strlen($pv)>0){
					$post[$pk]	= $pv;
				}
			}
			//没有搜索内容则清空
			if (count($post)<=0){
				session($k,'[null]');
				session('search','[null]');
			}
			$result['data']	= $s		= $post;
			$val= json($s);
			session($k,$val);
			session('search','1');
			msg('',$GLOBALS['page_url'].'#'.rand(1000,9999));
			exit;
		}else{
			$result['data']	= $s	= json(session($k));
		}
		
		
		$table_index	= array_flip(@$GLOBALS['table']);
		$ljoin_num		= count(@(array)$GLOBALS['ljoin']);
		$where			= array();
			//获得关键词
			foreach($GLOBALS['insert'] AS $K=>$V){
				$dot	= $table_index[$K];
				foreach($V AS $sk=>$sv){
					if (!empty($sv['search'])){
						if ($s[$sk]){
							
							switch($sv['search']){
								//等于
								case 1:
									@$where[]	= ($ljoin_num>=1?"$dot.":'')."$sk='".trim($s[$sk])."'";
								break;
								//单独加入的下拉框
								case 'select':
									@$where[]	= ($ljoin_num>=1?"$dot.":'')."$sk='".trim($s[$sk])."'";
								break;
								
								//模糊查询
								case 'like':
									@$where[]	= ($ljoin_num>=1?"$dot.":'')."$sk LIKE '%".trim($s[$sk])."%'";
								break;
								//不会产生搜索框
								case 'likes':
									@$where[]	= ($ljoin_num>=1?"$dot.":'')."$sk LIKE '%".trim($s[$sk])."%'";
								break;
							}
						}
					}
				}
			}
		
		//导出数据筛选条件
		if ($GLOBALS['a']=='export_data' && session('search_where')){
			$result['text']	= session('search_where');
			return $result;
		}
		
		
		if (count((array)$where)){
			$result['text']	= ($set_where?$set_where.' AND ':'').implode(' AND ',$where);
			return $result;
		}else{
			$result['text']	= $set_where;
			return $result;
		}
	}
	
	
	//排序
	function search_order($set=''){
		//导出数据筛选条件
		if ($GLOBALS['a']=='export_data' && (session('search_order') || session('search_group'))){
			$set	= (session('search_order')!=''?session('search_order'):'');
			return $set;
		}

		if (@$GLOBALS['o'] && in_array($GLOBALS['g'],array('a','d'))){
			$set	= $GLOBALS['o'].($GLOBALS['g']=='d'?' DESC':' ASC');
		}
		return $set;
	}
	
	//表格操作
	function torder($set=''){
		if ($GLOBALS['o'] && in_array($GLOBALS['g'],array('a','d'))){
			$set	= $GLOBALS['o'].($GLOBALS['g']=='d'?' DESC':' ASC');
		}
		return $set;
	}
	
	/**
	*	后台编辑管理
	*	set_id 		当前信息的id
	*	die_power	禁用权限
	*/
	function taction($set_id=0,$die_power=''){
		global $aus,$dls;
		$now_powers	= $GLOBALS['now_powers'];
		if (isset($now_powers['add'])){unset($now_powers['add']);}
		if (isset($now_powers['bdel'])){unset($now_powers['bdel']);}
		//保护系统功能
		if (is_array($now_powers)){
			if(@array_key_exists('del',$now_powers)){
				$GLOBALS['tpl']->set_var('del_url',$GLOBALS['page_url'].'&id='.$set_id.'&t=del'.($GLOBALS['p']?'&p='.$GLOBALS['p']:''));
				unset($now_powers['del']);
			}
			if(@array_key_exists('edit',$now_powers)){
				$GLOBALS['tpl']->set_var('edit_url',$GLOBALS['page_url'].'&id='.$set_id.'&t=edit'.($GLOBALS['p']?'&p='.$GLOBALS['p']:''));
				unset($now_powers['edit']);
			}
		}
		
		if (!empty($now_powers['search'])){unset($now_powers['search']);}
		if (!empty($now_powers['export_data'])){unset($now_powers['export_data']);}
		if (!empty($now_powers['import_data'])){unset($now_powers['import_data']);}
		if (!empty($now_powers) && is_array($now_powers)){
			$GLOBALS['tpl']->set_var('more_link',$GLOBALS['page_url'].'&id='.$set_id.($GLOBALS['p']?'&p='.$GLOBALS['p']:''));
			$GLOBALS['tpl']->set_var('more',$now_powers);
		}
		$GLOBALS['tpl']->set_var('set_id',@$set_id);
		$GLOBALS['tpl']->set_var('die_power',@$die_power);
		$GLOBALS['tpl']->set_file('_taction',@$tpl_dir);
		return @$id.$GLOBALS['tpl']->r();
	}
	
	/**
	*	批量删除条件
	*/
	function batch_del(){
		global $aus;
		if(@array_key_exists('del',$GLOBALS['now_powers'])){
			return true;
		}
		return false;
	}
	
	/**
	*	搜索条件
	*/
	function back_search(){
		global $aus;
		if(@array_key_exists('search',$GLOBALS['now_powers'])){
			return true;
		}
		return false;
	}
	
	
	
	
	
	