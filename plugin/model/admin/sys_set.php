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
//页面标题名称

$title_security	= lang('安全设置');
$title_view		= lang('视图设置');
$title_cache	= lang('缓存清理');
$title_cookie	= lang('Cookie');
$title_def		= lang('基本设置');


//======================== 逻辑处理 ========================\

switch($t){
	//保存数据
	case'view':
		if ($P['o']){
				
				update_config('$config[tpl][AutoImage]',(int)$P['AutoImage']);
				update_config('$config[tpl][Compress]',(int)$P['Compress']);
				update_config('$config[tpl][Rewrite]',(int)$P['Rewrite']);
			
			msg('',"$page_url&g=success");
			exit;
		}
		$title		.= '-'.$title_view;
	break;
	
	//保存数据
	case'security':
		if ($P['o']){
			if ($P['PATH_RAND']){
				update_config('$SLOG',(int)$P['SLOG']);
				update_config('$LOG',(int)$P['LOG']);
				update_config('$DEBUG',(int)$P['DEBUG']);
				update_config('$DEVMODE',(int)$P['DEVMODE']);
				if ((int)$P['TIMEOUT']<=0){
					$P['TIMEOUT']	= 30;
				}
				update_config('$TIMEOUT',(int)$P['TIMEOUT']);
				if (strlen((int)$P['PATH_RAND'])>=6){
					update_config('PATH_RAND',(int)$P['PATH_RAND']);
					//变更名字
					rename ("./data/backup_".$PATH_RAND, "./data/backup_".(int)$P['PATH_RAND']);
					rename ("./data/task_".$PATH_RAND, "./data/task_".(int)$P['PATH_RAND']);
					rename ("./data/log_".$PATH_RAND, "./data/log_".(int)$P['PATH_RAND']);
					rename ("./data/error_".$PATH_RAND, "./data/error_".(int)$P['PATH_RAND']);
				}
				
				
			}
			if ($P['o']==2){
				update_config('$GETSET',(int)$P['GETSET']);
				//数据过滤
				$get_list	= explode(',',str_replace('，',',',$P['getlist']));
				foreach($get_list AS $k=>$v){
					if (trim($v)){
						$getlist[] = str_out( strip_tags(htm_fix($v)) );
					}
				}
				if (count($getlist) && (int)$P['GETSET']==1 && $P['getlist']){
					update_config('$config[get]',$getlist);
				}
			}
			//跨域设置
			if ($P['o']==3){
				$allow_on		= (int)$P['allow_on'];
				$allow_list		= str_replace(array('http://','https://'),'',strtolower($P['allow_list']));
				update_config('$config[set][allow_on]',(int)$P['allow_on']);
				if ($allow_on>0){
					$allow_ex	= explode("\r\n",$allow_list);
					foreach($allow_ex AS $k=>$v) {
						$v		= trim($v);
						if ($v){
							$allow_ls[$v]		= $v;
						}
					}
					if ($allow_ls){
						$allow_txt	= implode(',',$allow_ls);
						if (strstr($allow_txt,'*')){
							$allow_txt			= '*';
						}
						update_config('$config[set][allow_list]',explode(',',$allow_txt));
					}else{
						update_config('$config[set][allow_list]','');
					}
					
					$allow_model	= explode(",",str_replace('，',',',$P['allow_model']));
					foreach($allow_model AS $k=>$v) {
						$allow_ml[$v]		= $v;
					}
					if ($allow_ml){
						update_config('$config[set][allow_model]',explode(',',implode(',',$allow_ml)));
					}else{
						update_config('$config[set][allow_model]','');
					}					
				}
			}
			msg('',"$page_url&g=success");
			exit;
		}
		
		$title		.= '-'.$title_security;
	break;
	
	//载入照片效果
	case'lazy_view':
		if ($P['o']){
			$tpl->set_file('sys_style_lazy_view');
			$tpl->p();
			exit;
		}
	break;
	
	//保存数据
	case'cache':
		if ($P['o']){
			
			//删除缓存
			if ($P['CacheDir']){
				echo 1;
				$tpl->del_dir(dirname($config['tpl']['CacheDir']),1);
			}
			if ($P['HtmDir']){
				$tpl->del_dir($config['tpl']['HtmDir'],1);
			}
			if ($P['LangDir']){
				$tpl->del_dir($config['tpl']['LangDir'],1);
			}
			if ($P['LogDir']){
				$tpl->del_dir('./data/log_'.$PATH_RAND,1);
				$tpl->writer('./data/log_'.$PATH_RAND.'/index.htm','');
			}
			
			msg('',"$page_url&g=success");
			exit;
		}
		$dir_adds	= './data/log_'.$PATH_RAND;
		if (is_dir($dir_adds)){
			$handle 	= opendir($dir_adds);
			$file_size	= 0;
			while(($file = readdir($handle)) !== false){
				if($file != '.' && $file != '..' && mb_ereg('\.',$file) ) {
				//获取文件
				$filename 	= $dir_adds . '/'. $file;
				//获得文件时间
				$file_size += filesize($filename);
				}
			}
			@closedir($handle);
			$file_size		= number_format($file_size/1024/1024,2);
		}else{
			$file_size		= 0;
		}
		
		$title		.= '-'.$title_cache;
	break;	
	
	//保存数据
	case'cookie':
		if ($P['o']){
			update_config('$COOKIE_SHARE',(int)$P['COOKIE_SHARE']);
			update_config('$COOKIE_SECURE',(int)$P['COOKIE_SECURE']);
			update_config('$COOKIE_PATH',trim($P['COOKIE_PATH']));
			update_config('$COOKIE_DOMAIN',trim($P['COOKIE_DOMAIN']));
			update_config('$COOKIE_EXPIRE',(int)$P['COOKIE_EXPIRE']);
			update_config('$SESSION_EXPIRE',(int)$P['SESSION_EXPIRE']);
			msg('',"$page_url&g=success");
			exit;
		}
		$title		.= '-'.$title_cookie;
	break;
	
	default:
		if ($P['o']){
				update_config('$TIME_FORMAT',trim($P['TIME_FORMAT']));
				update_config('$TIMEZONE',trim($P['TIMEZONE']));
				update_config('$config[set][site_name]',trim($P['site_name']));
				update_config('$config[set][site_author]',trim($P['site_author']));
				update_config('$config[set][site_key]',trim($P['site_key']));
				update_config('$config[set][site_desc]',trim($P['site_desc']));
				update_config('$config[set][site_url]',trim($P['site_url']));
				update_config('$config[ueditor][auto_save]',intval($P['auto_save']));
				update_config('$config[link_key]',trim($P['link_key']));
				update_config('$config[file_size]',trim($P['file_size']));
				update_config('$config[file_ext]',trim($P['file_ext']));
				
				update_config('$GZHANDLER',(int)$P['GZHANDLER']);
				
			
			msg('',"$page_url&g=success");
			exit;
		}
		$t 			= 'def';
		$title		.= '-'.$title_def;
		
}




?>