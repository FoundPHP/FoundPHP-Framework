<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

$model_data = '<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

//======================== 基本变量 ========================\\
//页面标题名称
$page_title 	= \'页面标题\';
//提交地址
$form_adds		= $page_adds.\'&todo=search\';
//模板文件 '.$tpl_mod_dir.'/'.($model=='default'?'':$model.'_').$action.'.'.$tpl_set['TplType'].'
$tpl_file_name	= '.($model=='default'?'':'$model.\'_\'.').'$action;

//======================== 逻辑处理 ========================\\

switch($todo){
	case\'del\':	//删除操作
		if ({table_tab}->del($id)){
			msg(\'恭喜，删除数据成功!\',$page_adds,3);
		}else{
			msg(\'抱歉，删除数据失败!\',$page_adds,3);
		}
	break;
	
	
	
	case\'edit\':	//编辑操作
	
		//编辑提交地址
		$form_adds		= $page_adds.\'&todo=search\';
		//编辑模板文件 '.$tpl_mod_dir.'/'.($model=='default'?'':$model.'_').'add.'.$tpl_set['TplType'].'
		$tpl_file_name	= '.($model=='default'?'':'$model.\'_\'.').'\'add\';
		//编辑页面与发布采用相同页面
		
		
		//提交操作
		if($type==\'update\'){
			
			die(\'提交检测内容，请在这里编写代码\');
			
		}
		
		die(\'请打开'.$tpl_mod_dir.'/'.($model=='default'?'':$model.'_').'/'.$action.'.php 文件修改编辑功能\');
	
	break;
	
	
	
	
	default:		//数据列表
		//搜索数据
		$where = \'\';
		if ($todo==\'search\' && trim($keys)!=\'\'){
			//提交需要搜索的数据到数据库语句中处理
			$where = array(
						\'keys\'=>$keys,
					);
		}
		//数据列表
		$data_info = {table_tab}->get_list($where,25);
		$pages = pages($data_info[\'info\']);
	
}

?>';

?>