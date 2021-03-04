<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/
defined('FoundPHP.com') or die('access denied!');

//======================== 逻辑处理 ========================\

switch($t){
	//保存数据
	case'go':
		if ($P['o']){
			
			update_config('$style[go][load]',(int)$P['load']);
			update_config('$style[go][style]',(int)$P['setstyle']);
			update_config('$style[go][color]',(int)$P['setcolor']);
		msg('',"$page_url&g=success");
		exit;
		}
		$title 	.= '-'.lang('跳转设置');
		//释放设置
		@extract($style['go']);
	break;
	
	//跳转效果
	case'go_view':
		$tpl->set_file('sys_style_go_view');
		$tpl->p();
		exit;
	break;

	
	//保存数据
	case'lazy':
		if ($P['o']){
			if ((int)$P['load']<=0 || (int)$P['threshold']<=0 || trim($P['limit'])<=0){
				$P['load'] = 0;
			}
			
			update_config('$style[lazy][load]',(int)$P['load']);
			update_config('$style[lazy][noscript]',(int)$P['noscript']);
			update_config('$style[lazy][fadein]',(int)$P['fadein']);
			update_config('$style[lazy][threshold]',(int)$P['threshold']);
			update_config('$style[lazy][limit]',(int)$P['limit']);
			
			msg('',"$page_url&g=success");
			exit;
		}
		$title 	.= '-'.lang('照片延载');
		
		@extract($style['lazy']);
	break;
	
	//载入照片效果
	case'lazy_view':
		$tpl->set_file('sys_style_lazy_view');
		$tpl->p();
		exit;
	break;
	default:
		$title 	.= '-'.lang('网站风格');
}




?>