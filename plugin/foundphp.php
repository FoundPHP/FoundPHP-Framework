<?php
/*	(C)2005-2021 Found PHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	 author: 孟大川
*	version: 1.21.208
*	  start: 2015-05-24
*	 update: 2021-02-08
*	payment: 授权使用
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
//增加出错日志
//注意：如果出现错误代码没有图形界面表示代码串不支持

class FoundPHP{
	var $found	= '1.116';
	var	$tpl	= '';
	var	$files	= '';
	var $set_lang	= 'zh';		//语言
	var $lang	= array(
		'error_code'		=> '错误代码：',
		'error_trace'		=> '错误原因：',
		'error_from'		=> '错误溯源：',
		'error_analysis'	=> '出错修改建议',
		'error_details'		=> '错误详情',
		'error_type'		=> '描述',
		'error_introduce'	=> '详情',
		'error_introduce'	=> '详情',
		'error_file'		=> '报错文件',
		'error_line'		=> '出错行号',
		'error_str'			=> '错误字符：',
		'error_future'		=> '（这个问题PHP 7.2 版本以后成为严重错误）',
		'back'				=> '后退',
		'refresh'			=> '刷新',
		'fix'				=> '修复代码',
		'line'				=> '行',
		'think_time'		=> '您已经思考',
		'think_hour'		=> '小时',
		'think_minute'		=> '分',
		'think_second'		=> '秒',
		'not_function'		=> '没有找到函数方法：',
		'not_class'			=> '没有找到类：',
		'not_class_func'	=> '没有找到类中的函数方法：',
		'not_undefined'		=> '没有定义的方法：',
		'not_open'			=> '打开文件不存在：',
		'not_constant'		=> '未定义常量：',
		'not_redeclare'		=> '重复声明：',
		'not_convert_str'	=> '无法转换为字符：',
				);
	
	/*
	*	声明模板用法
	*/
	function __construct($e=array(),$files=''){
		global $FOUNDPHP_LANG,$_GET;
		//设置语言
		if (!empty($FOUNDPHP_LANG)){
			$this->set_lang			= $FOUNDPHP_LANG;
		}
		$this->tpl					= $GLOBALS['tpl'];
		if (isset($GLOBALS['tpl'])){
			$this->tpl->TemplateDir		= dirname(__FILE__).'/class/foundphp/view/';
			$this->tpl->RunType			= 'Replace';
			$this->tpl->CacheDir		= '';
		}
		
		switch($e['type']){
			case 1://致命的运行时错误
				//方法不存在
				if (strstr($e['message'],'undefined function')){
					$e['types']	= 11;
					$e['func']	= $this->lang['not_function'].preg_replace_callback("/.+Call.+function(\s*[a-zA-Z0-9\_\$\(\)]{2,100})(\s*.+|)/is",function($m=''){return trim($m[1]);},$e['message']);
				}
				//类不存在
				if (strstr($e['message'],'Uncaught Error: Class')){
					$e['types']	= 12;
					$e['func']	= $this->lang['not_class'].preg_replace_callback("/.+Class\s*\'([a-zA-Z0-9\_\$\(\)]{2,100})\'\s*not.+/is",function($m=''){return trim($m[1]);},$e['message']);
				}
				//类方法没找到
				if (strstr($e['message'],'Call to a member function')){
					$e['types']	= 13;
					$e['func']	= $this->lang['not_class_func'].preg_replace_callback("/.+function\s*([a-zA-Z0-9\_\$\(\)]{2,100})(\s*.+|)/is",function($m=''){return trim($m[1]);},$e['message']);
				}
				//类方法没找到
				if (strstr($e['message'],'Class') && strstr($e['message'],'not found')){
					$e['types']	= 14;
					$e['func']	= preg_replace_callback("/Class\s*([a-zA-Z0-9\_\$\(\)]{2,100})(\s*.+|)/is",function($m=''){return trim($m[1]);},$e['message']);
					if (strstr($e['func'],'not found in')){
						$e['func']	= $this->lang['not_class_func'].preg_replace_callback("/.+(Class.+not found).+/is",function($m=''){return trim($m[1]);},$e['message']);
					}
				}
				//声明错误
				if (strstr($e['message'],'Call to undefined method')){
					$e['types']	= 14;
					$e['func']	= $this->lang['not_undefined'].preg_replace_callback("/.+undefined method\s*([a-zA-Z0-9\_\$\(\)\:]{2,100})(\s*.+|)/is",function($m=''){return trim($m[1]);},$e['message']);
				}
				if (isset($e['message']) && @(int)$e['types']<=0){
					$e['types']	= 19;
					$e['func']	= $e['message'];
					
				}
			break;
			
			case 2:	//运行时警告 (非致命错误)
				if (strstr($e['message'],'Failed opening')){
					$e['types']	= 21;
					$e['func']	= $this->lang['not_open'].preg_replace_callback("/.+Failed opening\s*\'([a-zA-Z0-9\_\.]{2,100})\'\s*for.+/is",function($m=''){return trim($m[1]);},$e['message']);
				}elseif(strstr($e['message'],'Use of undefined constant')){
					$e['types']	= 22;
					$e['func']	= $this->lang['not_constant'].preg_replace_callback("/Use of undefined constant\s*\'([a-zA-Z0-9\_\.]{2,100})\'\s*for.+/is",function($m=''){return trim($m[1]);},$e['message']);
				}
			break;
			case 4://编译时语法解析错误
				if (strstr($e['message'],'syntax error, unexpected')){
					$e['types']	= 41;
					$e['func']	= $e['message'];
				}else{
					$e['types']	= 40;
					$e['func']	= $e['message'];
				}
				
			break;
			case 8://编译时语法解析错误
				if (strstr($e['message'],'Undefined index')){
				//	$e['types']	= 81;
				//	$e['func']	= $e['message'];
				}
				
			break;
			case 16://在PHP初始化启动过程中发生的致命错误
				
			break;
			case 32://PHP初始化启动过程中发生的警告
				
			break;
			case 64://致命编译时错误
				//类方法没找到
				if (strstr($e['message'],'Cannot redeclare')){
					$e['types']	= 64;
					$e['func']	= $this->lang['not_redeclare'].preg_replace_callback("/.+redeclare\s*([a-zA-Z0-9\_\$\(\)]{2,100})(\s*.+|)/is",function($m=''){return trim($m[1]);},$e['message']);
				}
				if (strstr($e['message'],'Failed opening required')){
					$e['types']	= 641;
					$e['func']	= $this->lang['not_open'].preg_replace_callback("/.+opening required\s*\'(.+)\' .+/is",function($m=''){print_r($m);return trim($m[1]);},$e['message']);
				}
				if (isset($e['message']) && (int)$e['types']<=0){
					$e['types']	= 19;
					$e['func']	= $e['message'];
					
				}
				
			break;
			case 128://编译时警告 (非致命错误)
				
			break;
			case 2048://启用PHP对代码的修改建议
				
			break;
			case 4096://可被捕捉的致命错误
				if (strstr($e['message'],'could not be converted to string')){
					$e['types']	= 4096;
					$e['func']	= $this->lang['not_convert_str'].preg_replace_callback("/.+of class\s*([a-zA-Z0-9\_\$\(\)]{2,100})(\s*.+|)could not be.+/is",function($m=''){return trim($m[1]);},$e['message']);
				}
			break;
		}
		$this->display($e);
	}
	
	function head($title){
		$this->tpl->set_var(
			array(
				'header_title'	=> $title
			)
		);
		$this->tpl->set_file('header');
		$result = $this->tpl->r();
		if (stristr(get_url(),'/install/index.php?a=')){
			$result	= str_replace('data/style/','../data/style/',$result);
			$result	= str_replace('../../','../',$result);
		}
		echo $result;
	}
	
	//显示错误界面
	function display($ary=array()){
		if (@$ary['func']){
				$content	= ob_get_contents();
				ob_end_clean();
			if (stristr($ary['func'],'{FD}')){
				$func_ext	= explode('{FD}',$ary['func']);
				$ary['func']= $func_ext['0'];
				$ary['file']= $func_ext['1'];
				$ary['line']= '';
			}
			
			//自动修复代码
			if (strstr($ary['func'],'Undefined constant')||strstr($ary['func'],'Use of undefined constant')){
				$this->fix_file(str_replace('\\','/',$ary['file']));
			}
			//php8 版本解析
			$ary['func']	= $this->analysis($ary['func'],$ary['file'],$ary['line']);
			
			//linux 下调试信息
			if (!empty($GLOBALS['_SERVER']['PWD'])){
				echo $this->lang['error_details']	.$this->error_intro($ary['types'])."\r\n";
				echo $this->lang['error_details']	.$ary['func']."\r\n";
				echo $this->lang['error_file']		.$ary['file']."\r\n";
				if (!empty($ary['line'])){
				echo $this->lang['error_line']		.$ary['line']."\r\n";
				}
			}else{
			//web 调试
				$this->head('FoundPHP Error System');
				$this->tpl->set_var(
					array(
						'error_intro'=>$this->error_intro($ary['types']),
						'func'=>$ary['func'],
						'file'=>$ary['file'],
						'line'=>$ary['line'],
						'lang'=>$this->lang
					)
				);
				$this->tpl->set_file('display');
				$this->tpl->p();
			}
			if (!empty($ary['func'])){
				$result	.= date('Y-m-d H:i:s')." ".$ary['file'].(!empty($ary['line'])?" Line:".$ary['line']:'')."\r\n";
				$result	.= "Err:".$ary['func']."\r\n\r\n";
				@file_put_contents(dirname(__DIR__).'/'.$GLOBALS['RAND_DIR'].'/log/'.dates(time(),'ymd').'_error.txt',strip_tags($result),FILE_APPEND);
			}
			exit;
		}
		exit;
	}
	
	//解析php8代码说明
	function analysis($str='',$files='',$line=0){
		if (stristr($str,'Stack trace:')){
			//php 8 说明
			$exp_str		= explode('Stack trace:',$str);
			$exp_str['0']	= str_replace(' in '," in<br>",$exp_str['0']);
			$file_exp		= explode('#',$exp_str['1']);
			$error_info		= explode('):',$file_exp['1']);
			if ($this->set_lang!='en'){
				$exp_str['0']	 = str_replace('Uncaught Error:','<b>'.$this->lang['error_trace'].'</b>',$exp_str['0']);
			}
			$str			= $exp_str['0']."<br><br><b>".$this->lang['error_from']."</b>".$error_info['1'].' '.str_replace('(',':',str_replace('0 ','<br>',$error_info['0']));
		}elseif(stristr($str,'Use of undefined constant')){
			//php7 说明
			$str_ext		= explode('-',$str);
			$error_id		= str_replace('Use of undefined constant','',$str_ext['0']);
			if (!empty($error_id)){
				$str		= $this->lang['error_code'].$this->fix_file($files,$line).'<br>'.$this->lang['error_str'].$error_id.'<br>'.$this->lang['error_future'];
			}
		}
		return $str;
	}
	
	//修复错误文件
	function fix_file($files='',$line=0){
		if (is_file($files) && !strstr($files,'controller')){
			$f 	= explode("\n",$this->tpl->reader($files));
			if (!empty($line)){
				return $f[($line-1)];
			}
			foreach($f AS $k=>$v) {
				$result[$k]	= $this->fix_line($v);
			}
			$this->tpl->writer($files,implode("\n",$result));
			
		}
	}
	
	//修复错误标识的php文件
	function fix_line($str=''){
		if (!empty($str)){
			//过滤单引号中的中括号
			$str = preg_replace_callback(array('/(\'.+\')/is'),function ($m=''){return "<FoundFix>".base64_encode($m[1])."<FoundFIX>";},$str);
			//过滤SQL代码
			$str = preg_replace_callback(array('/(".+")/is'),function ($m=''){return "<FoundFix>".base64_encode($m[1])."<FoundFIX>";},$str);
			//修复缺少标识的php代码
			$fix_str = preg_replace_callback(array('/(\[([a-zA-Z0-9_]{1,32})\])/is'),function ($m=''){return "['".$m[2]."']";},$str);
			if ($fix_str!=$str){
				$str = $fix_str;
			}
			$str = preg_replace_callback(array('/\<FoundFix\>(.+)\<FoundFIX\>/is'),function ($m=''){return base64_decode($m[1]);},$str);
			return $str;
		}else{
			return $str;
		}
	}
		
	function error_intro($types=0){
		switch($types){
			case 11;
				$intro['cn']	= '开发代码中出现方法丢失或调用错误，请修正或采用系统下载更新。';
			break;
			
			case 12;
				$intro['cn']	= '开发代码中存在声明Class错误，未引用类文件或声明错误。';
				
			break;
			case 13;
				$intro['cn']	= '开发代码中调用Class中的方法缺失，检查是否拼写正确。';
				
			break;
			case 14;
				$intro['cn']	= '没有找到声明类，大多没有引用类文件。';
				
			break;
			case 19;
				$intro['cn']	= '建议根据[出错原因]修改代码。';
				
			break;
		
			case 21;
				$intro['cn']	= '引用文件不存在或输入错误。';
				
			break;
		
			case 22;
				$intro['cn']	= "应用数组PHP7.2以上需要增加单引号,例如:\$FoundPHP['good']";
			break;
		
			case 41;
				$intro['cn']	= '代码行结束缺少;符号或缺少其他字符。';
				
			break;
		
			case 64;
				$intro['cn']	= '调用文件出现相同名称的function，请排除不需要的方法或改名。';
				
			break;
				
			case 641;
				$intro['cn']	= 'require 打开的文件目录不正确或文件不存在。';
				
			break;
			case 4096;
				$intro['cn']	= '字符中不可以包含对象。';
				
			break;

		}
		$intro['cn']	.= '<br>建议检查错误文件行号附近代码。';
		if (!empty($intro['cn'])){
			return $intro['cn'];
		}
	}
	
}



