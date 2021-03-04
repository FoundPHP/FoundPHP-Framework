<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com                                                                                                                                
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
defined('FoundPHP.com') or die('access denied!');
$title		= '数据导出';

load('class/html_parser');
load('class/csv');
$csv		= new lfb_csv();
$save_dir	= './data/tmp/';

//分页
$config['set']['limit']  = 50;

//操作处理
switch($t){
	
	//导出过程
	case'go':
		
		//数量
		$nums		= (int)session('search_num');
		if ($nums<=0){
			msg('抱歉，没有捕捉到可以导出的数据',"?a=".$n,3);
		}
		
		//分页信息
		$progress	= 0;
		//$next_url	= "?".($m!=''?'m='.$m.'&':'')."a=export_data&t=go&n=$n&p=".($page['nowpage']+1).(($o && in_array($g,array('a','d')))?"&o=$o&g=$g":'');
		
		$tpl_file	= "export_data_".$t;
	break;
	
	
	
	//进程进度
	case'process':
		
		
		//引入模块
		include_once $n.'.php';
		
		$GLOBALS['a']	= $n;
		$page		= $data_info['info'];
		//print_r($page);
		//进度处理
		$progress	= @number_format(( ($page['nowpage']*$page['limit'])/$page['nums'] )*100,2, '.', '');
		$progress	= $progress>100?100:$progress;
		$tpl->set_file($n);
		$page_data	= $tpl->r();
		//输出完成转下载页面
		if ($p>$page['pages']){
			msg('',"?".($m!=''?'m='.$m.'&':'')."a=export_data&t=down&n=$n".(($o && in_array($g,array('a','d')))?"&o=$o&g=$g":'') );
		}
		
		//保存文件名称,第一页删除旧文件
		$save_name	= session('export_filename');
		if ($page['nowpage']<=1){@unlink($save_dir.$save_name.'.csv');};
		
		//解析字符
		$page_data	= str_replace('&nbsp;',' ',$page_data);
		$html_dom	= new html_parser($page_data);
		
		
		//获得内容区域
		$tr	= $html_dom->find('tr');
		
		//获得标题
		foreach($tr[0]->find('th') AS $k=>$v) {
			if ( !in_array(trim($v->getPlainText()),array('操作','查看全部')) ){
				$title_ary[] = $save_data[0][] = trim($v->getPlainText());
			}
		}
		
		foreach($tr AS $rk=>$rv) {
			$i		= 0;
			foreach($rv->find('th') AS $v) {
				if ($i<count($title_ary)){
					$id_title	= '';
					foreach($v->find('i') AS $iv) {
						$id_title			= $iv->getAttr("title");
					}
					
					$save_data[$rk][$i]	= trim($v->getPlainText()).($id_title!=''?' '.$id_title:'' );
				}
				$i++;
			}
			foreach($rv->find('td') AS $dv) {
				if ($i<count($title_ary)){
					//例如帐号禁用的标签
					$ot_title	= '';
					foreach($dv->find('i') AS $iv) {
						$ot_title			= $iv->getAttr("title");
					}
					$save_data[$rk][$i]	= trim($dv->getPlainText()).($ot_title!=''?' '.$ot_title:'' );
				}
				$i++;
			}
		}
		//去除标题
		if ($p>1){
			unset($save_data[0]);
		}
		
		//建立csv文件
			$csv->save(array(
				'data'		=> $save_data,
				'dir'		=> $save_dir,
				'filename'	=> $save_name,
				'model'		=> 'a+',
			));
		
		json_out(1,array('nums'=>$page['nums'],'progress'=>$progress,'next'=>($page['nowpage']+1),'pages'=>$page['pages']));
		exit;
	break;
	
	
	
	//下载
	case'down':
		
		if (!is_file($save_dir.session('export_filename').'.csv')){
			msg('抱歉，下载超时请重新生成',"?a=".$n,3);
		}
		
		//清空搜索缓存
		session('search_sql','[null]');
		session('search_where','[null]');
		session('search_order','[null]');
		session('search_group','[null]');
		
		
		$action_name	= session('action_name');
		
		$filename	= session('export_filename');
		$tpl_file	= "export_data_".$t;
	break;
	
	
	//获取文件
	case'getfile':
		$action_name	= session('action_name');
		$csv->download($save_dir.session('export_filename').'.csv',($action_name?$action_name.' ':'').dates(time(),'Y年m月d日H点').'.csv');
		
		exit;
	break;
	
	
	
	default:
		//筛选条件
		$sql_ary	= session('search_data');
		$sql		= $sql_ary['sql'];
		$where		= $sql_ary['where'];
		$order		= $sql_ary['order'];
		$group		= $sql_ary['group'];
		session('search_sql',$sql);
		session('search_where',$where);
		session('search_order',$order);
		session('search_group',$group);
		
		if ($sql==''){
			msg('抱歉，没有捕捉到可以导出的数据');
		}
		
		//临时存储文件名
		session('export_filename',substr(md5(time().'_'.$n),10,-12));
		
		
		//项目模块名
		if ($_sys_menu && $n){
			foreach($_sys_menu AS $k=>$v) {
				if ($n==$v['language']){
					$action_name	= $v['cate_name'];
					session('action_name',$v['cate_name']);
				}
			}
		}
		//消息总数
		$nums	= sql_select( array('sql'=>$sql,'where'=>$where, 'order'=>$order,'group'=>$group,'type'=>'num' ) );
		//消息总数
		session('search_num',$nums);
		
}


?>