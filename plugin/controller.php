<?php
/*	(C)2005-2021 FoundPHP Framework.
*	   name: Ease Template
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: 3.21.222
*	  start: 2007-05-24
*	 update: 2021-02-22
*	payment: 授权使用
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
defined('FoundPHP.com') or die('access denied!');
error_reporting(E_ALL^E_NOTICE);
ini_set("display_errors",'on');
$autoload = 'FoundPHP';

if (floatval(PHP_VERSION)<5.2){
	die('<h2>FoundPHP FrameWork Support:</h2><ol><li><b>PHP 5.4</b> <i>2012-02-29</i></li><li><b>PHP 5.5</b> <i>2013-06-20</i></li><li><b>PHP 5.6</b> <i>2014-08-27</i></li><li><b>PHP 7.0</b> <i>2015-12-03</i></li><li><b>PHP 7.1</b> <i>2016-12-02</i></li><li><b>PHP 7.2</b> <i>2017-11-29</i></li><li><b>PHP 7.3</b> <i>2018-12-06</i></li><li><b>PHP 7.4</b> <i>2019-11-27</i></li><li><b style="color:red">PHP 8.0</b> <i>2020-11-26</i></li></ol>');
}

//系统设置
include_once 'data/config.php';

//设置为北京时间
@date_default_timezone_set($TIMEZONE);
//linux 下不需要
if ($_SERVER['PWD']==''){
	//设定编码
	header('Content-Type: text/html; charset='.$CHARSET);
	//后退提交数据
	header("Cache-control: private");
	//gzip压缩
	if($GZHANDLER && extension_loaded('zlib')){ob_end_clean();ob_start("ob_gzhandler");}
	//设置超时时间
	ini_set("max_execution_time",$TIMEOUT);
	set_time_limit($TIMEOUT);
	if(!is_file('data/install.lock') && $m!='install'){header("Location: install/");}
}
//调试平台
function FoundPHP(){
	global $tpl;
	ob_start();
	function foundphp_error($set='',$type=1){
		if ($set){
			$e = error_get_last();
			$e['type']		= $type;
			$e['message']	= $set;
		}else{
			$e = error_get_last();
		}
		if (in_array($e['type'],array(1,2,4,8,16,32,64,128,4096))){
			include_once "foundphp.php";
			new FoundPHP($e);
		}
	}
	function FoundPHP_Handler(){return true;}
	set_error_handler('FoundPHP_Handler');
	register_shutdown_function('foundphp_error');
}
//======================== 数据安全过滤 ========================\\
//模块检测
$P		= array();
if(@count($_POST)){
	foreach($_POST as $k=>$v){$_POST[$k] = $P[$k] = array_fix($_POST["$k"]);}unset($k,$v);
}
$m		= $token = $t = '';
$a		= 'default';
$p		= 1;
$hide_header= $hide_footer=0;
foreach($_GET as $k=>$v){if(!in_array($k,$config['get']) && $GETSET && @$_GET['m']!='admin'){unset($_GET[$k]);}if(isset($_GET[$k])){$$k = text_fix($_GET["$k"],1);}} 
unset($k,$v);
if(isset($id)){$id = (int)$id;}
if(isset($p)){$GLOBALS['p']  = (int)$p;}
if($m){if(!preg_match("/^[A-Za-z0-9_\.\-]+$/",$m)){$m = '';}}
if($a){if(!preg_match("/^[A-Za-z0-9_\.\-]+$/",$a)){$a = '';}}
if($t){if(!preg_match("/^[A-Za-z0-9_\.\-]+$/",$t)){$t = '';}}
//自动载入
if (!@$_SERVER['PWD'] && floatval(PHP_VERSION)>=5.3){$autoload();}
//删除多余变量
unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS);
//======================== 跨域访问 ========================\\
if($config['set']['allow_on'] && @$_SERVER['PWD']==''){
	if($config['set']['allow_list'][0]=='*'){$_sys_allow = '*';}
	if(@in_array($_SERVER['HTTP_HOST'],$config['set']['allow_list'])){$_sys_allow = 'http'.($_SERVER['HTTPS']!=''?'s':'').'://'.$_SERVER['HTTP_HOST'];}
	if(@count($config['set']['allow_model'])>0){ if (!in_array(@$m,$config['set']['allow_model'])){$_sys_allow ='';} }
	if(@$_sys_allow!=''){header('Access-Control-Allow-Origin: '.$_sys_allow);}
}
//======================== 全局类 ========================\\
//model定义独立缓存目录
if(@is_dir('plugin/model/'.$m) && isset($m)){
	if ($m){ $config['tpl']['TemplateDir']	.= '/'.$m;$config['tpl']['CacheDir'] .= '/'.$m;}
	if(!is_dir($config['tpl']['CacheDir'])){ @mkdir($config['tpl']['CacheDir'], 0777);@chmod($config['tpl']['CacheDir'], 0777);}
}
//模板类
if (floatval(PHP_VERSION)>5.3){
	$tpl 	= load('class/template/ease_template','FoundPHP_template',$config['tpl']);
}else{
	$tpl 	= load('class/template/ease_template3','FoundPHP_template',$config['tpl']);
}
//======================== COOKIE/SESSION ========================\\
//ajax接收数据
if(strlen($token)==26 && $_SERVER['PWD']==''){session_id($token);}
if($SESSION_EXPIRE){
	@ini_set('session.gc_maxlifetime', $SESSION_EXPIRE);
}
//启动session
@session_start();
//全局session_id
$token = session_id();
//======================== 基础变量 ========================\\
//当前文件名
$code_name	= basename($_SERVER['SCRIPT_NAME']);

$style_dir 	= $STYLE_DIR;
$_sys_url	= parse_url($_SERVER['REQUEST_URI']);
$page_url	= $post_url	= $code_name;
if (isset($_sys_url['query'])){
	parse_str($_sys_url['query'],$_url_query);
	$post_url	 = $page_url	.= '?'.str_replace(array('&g=success','&g=del','&o='.@$o,'&g=a','&g=d'),'',http_build_query($_url_query));
}

//默认语言包
$page_msg['readd']				= lang('添加数据已存在');
$page_msg['success']			= lang('数据保存成功');
$page_msg['del']				= lang('数据删除成功');
$page_msg['del_error']			= lang('数据删除失败');
$page_msg['sorry']				= lang('抱歉，');
$page_msg['nolang']				= lang('开发模块缺少lang错误提示');
$page_msg['url_error']			= $page_msg['sorry'].lang('您访问地址错误');
$page_msg['power_error']		= $page_msg['sorry'].lang('您没有使用权限');
$page_msg['no_function']		= $page_msg['sorry'].lang('没有这个功能');
$page_msg['check_error']		= lang('数据已存在');
$page_msg['check_noset']		= lang(' 变量不存在<br>请在post_data()执行前手动加入变量 \$');
$page_msg['add']				= lang('添加');
$page_msg['edit']				= lang('编辑');
$page_msg['del']				= lang('删除');
$page_msg['user_die']			= $page_msg['sorry'].lang('您的帐号已被禁用！');
$page_msg['user_die_time']		= $page_msg['sorry'].lang('您的帐号已过期，请联系管理员！');
$page_msg['error_long']			= lang('或长度控制在[long]个字符');
$page_msg['user_null']			= $page_msg['sorry'].lang('登录帐号不存在！');
$page_msg['set_v_leng']			= $page_msg['sorry'].lang('setting设置{k}的值超出限定！');
$page_msg['post_data_ope']		= $page_msg['sorry'].lang('ope调用方法不存在,方法名：');
$page_msg['dev_model']			= lang('开发模块');
$page_msg['dev_model_case']		= lang('中缺少 case 参数');

//======================== 解析设置 ========================\\

//载入模块
$action			= 'plugin/model/'.($m!=''?$m.'/':'').$a.'.php';

//删除多余变量
unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS);

//操作日志
if($LOG && is_dir($RAND_DIR.'log')){
	$_log_data = dates(time(),'Y-m-d h:i:s')."\t".@$GLOBALS['title']."\nurl:$code_name".(@$_sys_url['query']?'?'.$_sys_url['query']:'')."\r\n".(@count($P)>0?"\$P:".implode(',',array_keys($P))."\r\n":''); 
	$GLOBALS['tpl']->writer($RAND_DIR.'log/'.dates(time(),'ymd').'_log.txt',$_log_data,'a+');
}
//全局function
if (is_file("plugin/function/globals.php")){
	include_once "plugin/function/globals.php";
}
//======================== 常用函数 ========================\\
//系统加密
$GLOBALS['FoundPHP_encrypt']	= load('class/foundphp/encrypt','FoundPHP_encrypt',$config['encrypt']);
//压缩文件
$GLOBALS['FoundPHP_zip']		= load('class/foundphp/zip','FoundPHP_zip');
//照片缩放
if (is_file('plugin/class/image/resize.php')){
	$GLOBALS['FoundPHP_image']	= load('class/image/resize','FoundPHP_image');
}
//上传文件
$GLOBALS['FoundPHP_upload']	= load('class/file/upload','FoundPHP_upload');



/*
*	单次加载
*	继承关系:类、函数、常量、变量需要$GLOBALS[xxx]才可以继承
*	name		访问的文件名，没有则返回目录，不需要加后缀格式，默认为php
* 	载入class/dbo.php 为：load('class/dbo');
*	声明类 $db = load('class/dbo','dbo',$config[db]);
*	相当于 $db = new dbo($config[db]);
*/
function load($_FD_file='',$_FD_name='',$_FD_set=''){
	$path	= array('config'=>'config','plugin'=>'plugin','class'=>'plugin/class','function'=>'plugin/function','model'=>'plugin/model');
	$fex		= explode('/',$_FD_file);
	if($path[$fex[0]]){
		$_FD_file		= str_replace($fex[0].'/',$path[$fex[0]].'/',$_FD_file).'.php';
	}
	if(@is_file($_FD_file)){
		require_once($_FD_file);
		if (trim($_FD_name)!=''){
			if($_FD_set){
				return new $_FD_name($_FD_set);
			}else{
				return new $_FD_name;
			}
		}
	}else {
		if($_FD_name==''){
			die('引用模块错误: '.$_FD_file);
		}
	}
}

/*
* 安全快速过滤数据
*	ary 		支持数组
*/
function array_fix($ary=''){
	if(is_array($ary) && isset($ary)){
		foreach($ary as $k => $v){
			$ary[$k] = array_fix($ary[$k]);
		}
	}else{
		$ary = text_fix($ary,2);
	}
	return $ary;
}

/*
*  过滤提交明感字符
*	msg 		过滤内容
*	hacker		1防止黑客攻击,2 post时不过滤空为加号
*/
function text_fix($msg='',$hacker=0){
	if (is_array($msg)){
		foreach($msg AS $k=>$v) {
			return text_fix($v);
		}
	}else{
		$ary1 = array('"',"'",'"',"'",'\\');
		$ary2 = array('&quot;','&#39;','&quot;','&#39;','&#92;');
		//GET 过滤空格
		if($hacker!=2){
			$ary1[]  = ' ';
			$ary2[]  = '+';
		}
		$msg = str_replace($ary1,$ary2,$msg);
		if(preg_match("/[ ',;*?~`!$%^&)(<>{}]|\]|\[|\\\|\"|\|/",$msg) && $hacker==1){ die('You\'re a hacker!');}
	
	}
	return $msg;
}

/*只保留字符
	str		需要过滤字符
	type	0只是字符，1字符.
*/
function str_out($str='',$type=0){
	switch($type){
		case 1:
			$preg	= '/[\w\.]/';
		break;
		default:
			$preg	= '/[\w]/';
	}
	@preg_match_all($preg,$str,$o);
	return @join('',$o[0]);
}

/*
*  还原过滤字符内容
*	msg 		过滤内容还原
*/
function htm_fix($msg=''){
	$ary1 = array('&#92;','&amp;','&quot;','&#39;','<?','?>');
	$ary2 = array('\\','&','"',"'",'&lt;?','?&gt;');
	return str_replace($ary1,$ary2,$msg);
}

/*
*	去除左右空格
*	str			内容
*	from		all 左右清除，left左清除，right右清除
*/
function trims($str,$from='all'){
	$f		= strtolower($from);
	$f		= !in_array($f,array('all','left','right'))?'all':$f;
	switch($f){
		case'left':		$str	= ltrim($str); break;
		case'right':	$str	= rtrim($str); break;
		default:		$str	= trim($str);
	}
	if (in_array($f,array('left','all'))){
		$str	= preg_replace("/^[\s\v".chr(194).chr(160)."]+/","", $str); //替换左侧
	}
	if (in_array($f,array('right','all'))){
		$str	= preg_replace("/[\s\v".chr(194).chr(160)."]+$/","", $str); //替换右侧
	}
	return $str;
}

/*
*   提示错误信息页面
*	text 		提示文字内容
*	url 		跳转地址
*	times 		跳转时间（秒）
*	nologs 		全局变量，有值时不插入log日志
*/
function msg($text='', $url = '', $times = ''){
	$times		= (int)$times;
	$logtxt		= $text;
		if($url != '') {
			//成功提示
			if(strstr($url,'=success')){
				session('msg_success',1,5);
				$url	= str_replace('&g=success','',$url);
				$logtxt	= $text.'提交操作';
			}
			//失败提示
			if(strstr($url,'=del')){
				session('msg_del',1,5);
				$url	= str_replace('&g=del','',$url);
				$logtxt	= $text.'删除操作';
				// $logtxt	.= $text.'删除操作';
			}
			
			//跳转链接
			$gourl = "href='$url'";
			if($times == 0) {
				if($GLOBALS['nologs']==''){
					//操作日志
					logs($GLOBALS['title'],htm_fix($logtxt));
				}
				
				@header("Location: $url");
				$times = '';
			} else {
				if($GLOBALS['nologs']){
					//操作日志
					logs($GLOBALS['title'],htm_fix($logtxt));
				}
				
				$times = "<meta http-equiv='refresh' content=\"$times;url='$url'\">";
			}
		} else {
			//跳转链接
			$gourl = ($url == '' && $_SERVER['HTTP_REFERER'] != '') ? 'href="#" onclick="history.back();return false;"' : "href='$url'";
		}
		
		//设置模版
		$GLOBALS['tpl']->set_var(array (
			"text" 		=> htm_fix($text),
			"url" 		=> $gourl,
			"times"	=> $times
			)
		);
	if(!is_file(@$GLOBALS['tpl']->TemplateDir.$GLOBALS['tpl_dir'].'/sys_msg.htm')){
		echo $text;
		exit;
		$GLOBALS['tpl_dir'] = '';
	}
	$GLOBALS['tpl']->set_file('sys_msg',$GLOBALS['tpl_dir']);
	$GLOBALS['tpl']->p();
	exit;
}

function msg_go(){
	cookie('page_url','');
}
/**
*   时间处理函数
*	@param int 	times 			当前时间戳
*	@param string	format 		格式
*	@param string	gmt 			GMT全球时区
*	@return string

*/
function dates($times,$format='',$gmt=0){
	$format		=$format?$format:$GLOBALS['TIME_FORMAT'];
	if(strlen($times)==10){
		if ($gmt!=0){
			return gmdate("Y/m/d H:i:s", time() + (3600*$gmt)); 
		}
		return date($format, $times);
	}
}

/*
*  系统静态动态连接处理
*	url		动态地址
*	type	输出的格式默认html，如果是js则输出js
*/
function links($url='',$type=''){
	$set_type =($GLOBALS['config']['tpl']['Rewrite']=='on')?'html':$type; 
	return $GLOBALS['tpl']->links(trim($url),$set_type);
}

/*
* 多语言函数
*	url		动态地址
*/
function lang($text=''){
	global $db,$FOUNDPHP_LANG,$m,$a,$tpl;
	$text			= @trim($text);
	if ($GLOBALS['DEVMODE'] && $text!=''){
		$strmd5		= md5($text);
		if (!empty($db)){
			/*
			//查询语言包
			$get_data	= sql_select(array('table'=>'language', 'where'=>"lang='$FOUNDPHP_LANG' AND m='$m' AND a='$a' AND md5='$strmd5'"));
			if ((int)$get_data['lid']<=0){
				$data	= $check	= array(
					'lang'	=> $FOUNDPHP_LANG,
					'm'		=> !empty($m)?$m:'default',
					'a'		=> $a,
					'md5'	=> $strmd5,
					'str'	=> $text,
					'tra_dates'	=> 0,
					'dates'	=> time()
				);
				$check	= array(
					'md5'	=> $strmd5,
					'lang'	=> $FOUNDPHP_LANG,
				);
				sql_update_insert(array(
							'table'	=> 'language',
							'data'	=> $data,
							'check'	=> $check
						)
				);
			}*/
		}
		return $GLOBALS['tpl']->lang($text);
	}else{
		return $text;
	}
}


/*
*  获得用户ip
*	url		动态地址
*/
function get_ip() {
	//代理模式下，获取客户IP
	if(@$_SERVER['HTTP_X_REAL_IP']){
		$ip=$_SERVER['HTTP_X_REAL_IP'];
	//客户端的ip
	}elseif(@isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip	 =   $_SERVER['HTTP_CLIENT_IP'];
	//浏览当前页面的用户计算机的网关
	}elseif(@isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$arr	=   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos	=   array_search('unknown',$arr);
		if(false !== $pos) unset($arr[$pos]);
		$ip	 =   trim($arr[0]);
	//浏览当前页面的用户计算机的ip地址
	}elseif(@isset($_SERVER['REMOTE_ADDR'])) {
		$ip	 =   $_SERVER['REMOTE_ADDR'];
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return ($ip=='::1')?'127.0.0.1':$ip;
}

/*
*  获取当前页面地址
*	@return string
*	type 类型 默认为完整地址，如果不是空则表示域名
*/
function get_url($type='') {
	if($type==''){
		$url = ($_SERVER['REQUEST_URI']!='')?$_SERVER['REQUEST_URI']:$_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
	}else {
		//只获得当前目录
		$url = ($_SERVER['REQUEST_URI']!='')?str_replace('\\','/',(mb_ereg('.php|.htm|.html|.js',$_SERVER['REQUEST_URI'])?dirname($_SERVER['REQUEST_URI']):$_SERVER['REQUEST_URI'] )):'';
	}
	return 'http://' . $_SERVER['HTTP_HOST'].$url;
}

/*
*	数组转换为可以写入的数据
*	ary		数组
*	keys	1 表示json解码数据key为数字的时候则省略
*/
function array_text($ary='',$type=0){
	if(is_array($ary)){
		unset($K,$V);
		foreach ($ary AS $K=>$V) {
			//对true与false不加引号
			if($V===true || $V===false){
				$arys[] = "'$K'=>".($V==true?'true':'false');
			}else {
				if(is_array($V)){
					$arys[] = "'$K'=>".array_text($V,$type);
				}else {
					if($type==1 && is_int($K)){
						$arys[] = (is_numeric($V)?$V:"'$V'");
					}else{
						$arys[] = "'$K'=>".(is_numeric($V)?$V:"'$V'");
					}
				}
			}
		}
		if(count((array)$arys)>0){
			return "array(".implode(",",$arys).")";
		}
	}
}


/*
*  页头处理
*	new_tpl 		指定页头模板名（默认已经设置为header）
*/
function head($new_tpl='',$dirs=''){
	global $tpl,$config,$hide_header;
	if ($hide_header==0){
		
		$tpl->set_var(
			array(
				'header_charset'	=> @$GLOBALS['sys_set']['charset'],
				'site_url'			=> @$GLOBALS['sys_set']['site_url'],
				'header_title'		=> strip_tags(htm_fix((!empty($config['set']['site_name'])?$config['set']['site_name'].' - ':'').$GLOBALS['title'])),
				'header_keywords'	=> @$GLOBALS['header_keywords'],
				'header_description'=> @$GLOBALS['header_description'],
				'head_tag'			=> @$GLOBALS['head_tag'],
				'style_id'			=> @$config['tpl']['ID'],
				'sys_menu'			=> @$GLOBALS['sys_menu'],
			)
		);

		$tpl_file	= (trim(@$new_tpl)!='')? $new_tpl:'header';
		$def_file	= @$GLOBALS['config']['tpl']['TemplateBase'].$tpl_file.'.'.$tpl->Ext;
		if(!is_file($tpl->TemplateDir.$tpl_file.'.'.$tpl->Ext)){
			$fulldir				= $tpl->TemplateDir;
			$tpl->TemplateDir		= str_replace($GLOBALS['m'].'/','',$tpl->TemplateDir);
		}
		//设置模版
		$tpl->set_file($tpl_file);
		if (@$fulldir){
			$tpl->TemplateDir		= $fulldir;
		}
		$tpl->n();
	}
}



/*
*  页尾处理
*	out_dir 		输出模板名（采用连载模式必须指定模板输出名称）
*	new_tpl 		重新设置模板
*/
function foot($out_dir='',$new_tpl='',$dirs=''){
	global $m,$a,$FOUNDPHP_LANG,$config,$hide_footer;
		$tpl	= $GLOBALS['tpl'];
		$tpl->n();	//连载页面中文件
		if ($hide_footer==0){
			
			$tpl->set_var(
				array(
					'wx_menu'		=> @$wx_menu,
					'_site_stat'	=> @$site_stat,
				)
			);
			
			$tpl_file = (trim($new_tpl)!='')? $new_tpl:'footer';
			if(!is_file($tpl->TemplateDir.$tpl_file.'.'.$tpl->Ext)){
				$fulldir				= $tpl->TemplateDir;
				$tpl->TemplateDir		= str_replace($GLOBALS['m'].'/','',$tpl->TemplateDir);
			}
			//设置模版
			$tpl->set_file($tpl_file);
			if (@$fulldir){
				$tpl->TemplateDir		= $fulldir;
			}
			$tpl->n();//连载页面中文件
		}

		//文件输出名称
		$_m			= $GLOBALS['m'];
		$_t			= $GLOBALS['t'];
		$out_name	= ($_m?$_m.'_':'').$GLOBALS['a'].'_'.$_t;

		//页面输出
		$tpl->p($out_name);
		//检测开发模式
		if($GLOBALS['DEBUG']){
			$tpl->inc_list();
			$GLOBALS['db']->sql_debug();
		}
		//关闭数据库
		if($GLOBALS['db']){
			$GLOBALS['db']->close();
		}
	
	//gzip压缩
	if($GLOBALS['GZHANDLER'] && extension_loaded('zlib')){ob_end_flush();}
	
	exit;
}
/*
*  配置文件变量设置
*	name		变量名
*	value		变量值
*	set_file	操作的文件
例如变量中
$config['db']['host'] = '127.0.0.1';
用法：
变量更新
update_config('$config[db][host]','192.168.1.x');
常量更新
update_config('DEBUG','1');
*/
function update_config($name='',$value='',$set_file='data/config.php'){
	$name_ex	= explode('[',substr($name,1));
	//变量
	if(substr($name,0,1)=='$'){
		$i = 0;
		foreach($name_ex AS $k=>$v){
			$v= str_replace(array('"',"'",']'),'',$v);
			if($i==0){
				$keys = '\$'.$v;
				$keyv = '$'.$v;
			}else{
				$keys .= "\[\'$v\'\]";
				$keyv .= "['$v']";
			}
			$i++;
		}
		$pattern = array('/'.$keys.'(\s*)= .+;/');
		//数组判断
		if(@is_array($value)){
			$replace	= array($keyv.'$1= '.array_text($value,1).';');
		}else{
			$replace	= (is_int($value) || is_bool($value))?array($keyv.'$1= '.$value.';'):array($keyv.'$1= \''.$value.'\';');
		}
	}else{
		//常量
		$pattern = array('/define\(\''.$name.'\',.+\);/');
		$replace = (is_int($value) || is_bool($value))?array('define(\''.$name.'\','.$value.');'):array('define(\''.$name.'\',\''.$value.'\');');
	}
	if(!$GLOBALS['tmp_config'] ){
		$GLOBALS['tmp_config'] = $GLOBALS['tpl']->reader($set_file);
	}
	$GLOBALS['tmp_config'] = preg_filter($pattern, $replace, $GLOBALS['tmp_config']);
	if($GLOBALS['tmp_config']!=''){
		$GLOBALS['tpl']->writer($set_file,$GLOBALS['tmp_config']);
	}
}


/* COOKIE操作封装
	name		Cookie 名称
	val			Cookie 值
	expire		Cookie 的过期时间
示例
	//读取数据方法
	cookie('key');				//获得数组
	cookie('key','1234');		//设置赋值
	cookie('key',array('name'=>'tonsen','mobile'=>'18028613600'));		//设置赋值
	cookie('key','[del]');		//删除
*/
function cookie($name,$val='',$expire=3600){
	if((string)$val=='[del]'){
		setcookie($name,'',(time()-86400));
		return '';
	}
	if (is_array($val)){
	 	$val	= json($val);
	}
	
	if(strlen($val)){
		if($expire>0){
			setcookie($name,$val,(time()+$expire) );
		}else{
			setcookie($name,$val);
		}
		return $val;
	}
	return json(htm_fix($GLOBALS['_COOKIE'][$name]));
}


/* Session操作封装
	name		Session 名称
	val			Session 值 设置[null]则标识删除session
	expire		有效过期时间
*/
function session($name='',$val='',$expire=86400){
	//打印所有session
	if (!strlen($name)){
		return $_SESSION;
	}
	//清空session
	if($val=='[null]'){
		unset($_SESSION[$name]);
		return '';
	}
	if (is_array($val)){
		unset($_SESSION[$name]);
		$_SESSION[$name]['val']	= $val;
		$_SESSION[$name]['exp']	= (int)$expire>0?($expire+time()):(time()+$SESSION_EXPIRE);
	}else{
		if (strlen($val)){
			unset($_SESSION[$name]);
			$_SESSION[$name]['val']	= (string)$val;
			$_SESSION[$name]['exp']	= (int)$expire>0?($expire+time()):(time()+$SESSION_EXPIRE);
		}
	}
	return @$_SESSION[$name]['val'];
}
//过期Session清理
if (@count($_SESSION)>0 && !in_array($m,array('api'))){
	foreach($_SESSION AS $k=>$v) {
		if (is_array($v)){
			if(@$v['exp']<time()){unset($_SESSION[$k]);}
		}
	}
}

	/**
	*  setting 操作
	* $k 所引关键字
	* $v 更新或插入数值
	//读取数据方法
	setting('key');				//获得数组
	setting('key','1234');		//设置赋值
	setting('key','[null]');	//设置空
	setting('key','[del]');		//删除
	
	*/
	function setting($k='',$v=''){
		global $_setting;
		if (!is_file('data/setting.php')){
			setting_cache('Cache');
		}
		@include_once 'data/setting.php';
		$k	= trim($k);
		//当更值为null的时候为空
		if($k && in_array((string)strtolower($v),array('[null]','[del]')) ){
			$where	= "k='$k'";
			//删除
			if((string)strtolower($v)=='[del]'){
				sql_del(
						array(
							'table'	=> 'setting',
							'where'	=> $where
						)
				);
			}else{
				sql_update_insert(array(
							'table'	=> 'setting',
							'data'	=> array('v'=>''),
							'where'	=> $where
						)
				);
			}
			//删除缓存
			setting_cache('Cache');
			//清空赋值
			$GLOBALS['_setting'][$k] = '';
		}
		
		//更新或插入
		if($k && strlen($v) && !in_array((string)strtolower($v),array('[null]','[del]'))){
			//更新
			if(array_key_exists($k, $GLOBALS['_setting'])){
				sql_update_insert(array(
							'table'	=> 'setting',
							'data'	=> array('v'=>$v),
							'where'	=> "k='$k'",
						));
				$result	= array('k'=>$k,'v'=>$v);
			}else{
				$result	= $data	= array('k'=>$k,'v'=>$v);
				sql_update_insert(array(
							'table'	=> 'setting',
							'data'	=> $data,
							'check'	=> array('k'=>$k),
						));
			}
			setting_cache('Cache');
			//输出结果
			$GLOBALS['_setting'][$k] = $v;
		}
		
		//获取查询
		if($k){
			$result	= setting_cache($k);
			if($result=='{Found_PHP}'){
				$get_data = sql_select(array('table'=>'setting', 'where'=>"k='$k'"));
				return $get_data['v'];
			}else{
				return $result;
			}
		}
	}
	
	/**
	*  设置缓存
	* $k 	所引关键字
	* $now	时时数据
	*/
	function setting_cache($k=''){
		global $db,$tpl;
			//设置缓存
			if (!$GLOBALS['_setting'] && is_file('data/setting.php')){
				@include_once 'data/setting.php';
			}
			if(strlen($GLOBALS['_setting'][$k])){
				return $GLOBALS['_setting'][$k];
			}
			//更新缓存
			if($k=='Cache'){
				//删除缓存
				@unlink('data/setting.php');
				//缓存数据
				$sql		= sql_select(array('table'=>'setting','type'=>'sql'));
				$query		= $db->query($sql);
				while ($dls	= $db->fetch_array($query)){
					//输出变量
					if($dls[k] == $k){
						$result			= $dls['v'];
					}
					if(strlen($dls[v])<=255){
						$set_ary[]	 		= "\t'$dls[k]'=>'$dls[v]'";
					}else{
						$set_ary[]	 		= "\t'$dls[k]'=>'{Found_PHP}'";
					}
				}
				if(is_array($set_ary)){
					$tpl->writer('data/setting.php',"<?php \$_setting = array(\n".implode(",\n",$set_ary)."\n);?>");
				}
				return $out_ary[$k];
			}
	}
	
	
	/**
	*   UTF-8 中英文字符串剪切函数
	*	@param string 	str 	待剪切的字串
	*	@param int 		len 	剪切长度
	*	@param string 	endStr 	结尾字符串
	*	@return string
	*/
	function font_cut($str, $len, $endStr='...'){
		$new_str	= array();
		$old_str	= $str;
		for($i=0;$i<$len;$i++){
			$temp_str	=substr($str,0,1);
			if(ord($temp_str) > 127){
				$i++;
				if($i<$len){
					$new_str[]	=substr($str,0,3);
					$str		=substr($str,3);
				}
			}else{
				$new_str[]	=substr($str,0,1);
				$str		=substr($str,1);
			}
		}
		$new_str	= join($new_str);
	return $new_str.((strlen($old_str)>strlen($new_str))?'...':'');
	}
	

/*	表单数据检测与数据输出
	table	数据库表名
	data	数组检测数据
	show	1输出json提示，0输出msg页面提示
				array(
					'cate_name'	=> array(								//提交表单名与数据库字段相同
						'lang'		=> lang('抱歉，没有[功能操作名]或格式不对'),	//错误提示
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==等于空，mail邮箱检测,mobile手机号检测
						'query'		=> 1,						//数据库判断是否存在
						't'			=> "add,edit",				//对应地址栏动作，add添加，edit编辑
						'long'		=> "1,5",					//字符长度,作为区间表示1到5个字，如果输入5表示小于等于5个字
					)）
	=====================
	输出数组：
	data		更新或插入数据库内容数组
	check		只有添加功能才会出现的数据检测
	
*/
function post_data($table,$data,$show=0){
	$t		= $GLOBALS['t'];
	$P		= $GLOBALS['P'];
	$ary	= $data[$table];
	foreach((array)$ary AS $k=>$v){
		//必填选项
		$req_ary		= explode(',',str_replace('，',',',$v['req']));
		//字符操作处理
		if(!empty($v['ope'])){
			if (!function_exists($v['ope'])){
				msg($GLOBALS['page_msg']['post_data_ope'].$v[ope]);
			}
			$ope_data		= $v['ope'](isset($P[$k])?$P[$k]:$GLOBALS[$k]);
			if ($ope_data){
				switch($v['ope']){
					case 'json':
						if(is_array($ope_data) && @count(array_filter((array)$ope_data))>0){
							@eval('$'.(isset($P[$k])?'P':'GLOBALS').'[\''.$k.'\'] = \''.$ope_data.'\';');
						}
					break;
					default:
						if(!is_array($ope_data)){
							@eval('$'.(isset($P[$k])?'P':'GLOBALS').'[\''.$k.'\'] = "'.str_replace(array('"','$'),array('\\"','\$'),$ope_data).'";');
						}
				}
			}
		}
		
		//字符长度
		if($v['long'] && $P[$k]){
			$long_exp	= explode(',',str_replace('，',',',$v['long']));
			
			if(@count($long_exp)==1){
				$msg	= $v['lang'].str_replace('[long]',$long_exp[0],$GLOBALS['page_msg']['error_long']);
				if(strlen($P[$k])<$long_exp[0]){
					post_data_error($msg,$show);
				}
			}else{
				$msg	= $v['lang'].str_replace('[long]',$long_exp[0].'-'.$long_exp[1],$GLOBALS['page_msg']['error_long']);
				if(strlen($P[$k])<$long_exp[0] || strlen($P[$k])>$long_exp[1]){
					post_data_error($msg,$show);
				}
			}
		}
		
		//字段编码md5或base64_encode,以及系统内的所有的function
		if(trim($v['code'])!='' && function_exists($v['code'])){
			$ope_data		= isset($P[$k])?$P[$k]:$GLOBALS[$k];
			if(@$ope_data){
				eval('$P[\''.$k.'\'] = $GLOBALS[\''.$k.'\'] = "'.str_replace('"','\\"',$v['code']($ope_data)).'";');
			}
		}
		//判断数据库是否存在
		if(in_array(strtolower($v['query']),array(1,2,'or','and')) && $GLOBALS['db']){
			switch(strtolower($v['query'])){
				case 2:
				case 'or':
					if(@array_key_exists($k,$P)){
						$where_or[]	= array('k'=>$k,'v'=>$P[$k]);
					}else{
						$where_or[]	= array('k'=>$k,'v'=>$GLOBALS[$k]);
					}
					$query[]		= $k;
				break;
				default:
					if(@array_key_exists($k,$P)){
						$where_and[]	= "$k='$P[$k]'";
					}else{
						$where_and[]	= "$k='$GLOBALS[$k]'";
					}
					$query[]		= $k;
			}
		}
		//权限操作
		if($v['t']){
			$t_ary			= explode(',',str_replace('，',',',$v['t']));
			
			//写入、更新数据
			if(in_array($t,$t_ary)){
				if(@array_key_exists($k,$P)){
					$value				= is_array($P[$k])?json($P[$k]):$P[$k];
					$result['data'][$k] = $value;
				}else{
					$value				= is_array($GLOBALS[$k])?json($GLOBALS[$k]):$GLOBALS[$k];
					$result['data'][$k] = $value;
				}
				//插入数据检测
				if (is_array($query)){
					if(in_array($k,$query)){
						if(@array_key_exists($k,$P)){
							if(!is_array($P[$k])){
								$result['check'][$k] = $P[$k];
							}
						}else{
							if(!is_array($P[$k])){
								$result['check'][$k] = $GLOBALS[$k];
							}
						}
					}
				}
			}
		}
		//判断
		if(in_array($t,$req_ary)){
			$lang	= $v['lang']!=''?$v['lang']:$GLOBALS['page_msg']['sorry'].$k.$GLOBALS['page_msg']['nolang'];
			if($v['check']){
				if(@array_key_exists($k,$P)){
					//post数据检测
					post_data_check($k,$v['check'],$P[$k],$lang,$show,0);
				}else{
					//内部变量
					post_data_check($k,$v['check'],$GLOBALS[$k],$lang,$show,1);
				}
			}
		}else{
			if($v['req'] && !in_array($t,$req_ary)){
				if($P[$k]==''){
					unset($result['data'][$k]);
				}
				if(@trim($GLOBALS[$k])=='' && $P[$k]==''){
					//内部变量
					unset($result['data'][$k]);
				}
			}
		}
	}
	//数据查询
	if(isset($where_and)){
		//id存在的时候不检查自己数据
		if($GLOBALS['id']>0 && $GLOBALS['t_index']){
			$where_and[] = $GLOBALS['t_index']."!='".$GLOBALS['id']."'";
		}
		$get_info	= sql_select( array('table'=>$table, 'where'=>implode(" AND ",$where_and)) );
		if($query[0] && $get_info[$query[0]]!=''){
			//过滤可能出现的全交字符
			preg_match_all("|\[(.+)\]|", str_replace(array('【','】'),array('[',']'),$ary[$query[0]]['lang']) ,$ck_lang,PREG_PATTERN_ORDER);
			if($ck_lang[1][0]!=''){
				post_data_error($GLOBALS['page_msg']['sorry'].$ck_lang[1][0].' '.$GLOBALS['page_msg']['check_error'],$show);
			}
		}
	}
	//数据查询
	if(is_array((array)$where_or)){
		//id存在的时候不检查自己数据
		if($GLOBALS['id']>0 && $GLOBALS['t_index']){
			$wheres		= " AND $GLOBALS[t_index]!='$GLOBALS[id]'";
		}
		foreach($where_or AS $k=>$v) {
			$where		= "$v[k]='$v[v]'";
			$get_info	= sql_select( array('table'=>$table, 'where'=>$where.$wheres) );
			if($get_info[$v['k']]==$v['v']){
				//过滤可能出现的全交字符
				preg_match_all("|\[(.+)\]|", str_replace(array('【','】'),array('[',']'),$ary[$v['k']]['lang']) ,$ck_lang,PREG_PATTERN_ORDER);
				if($ck_lang[1][0]!=''){
					post_data_error($GLOBALS['page_msg']['sorry'].$ck_lang[1][0].' '.$GLOBALS['page_msg']['check_error'],$show);
				}
			}
		}
	}
	$GLOBALS['P']	 = $P;
	return $result;
}

function post_data_check($name,$check,$val,$msg='',$show=0,$types=0){
	$check_tip	= substr($check,0,2);
	//检测是否存在
	if (!in_array($check_tip,array('id','ma','mo','!=','==','>=','<='))){
		msg('Sorry，check Function is outside the setting scope');
	}
	
	switch($check_tip){
		//身份证
		case'id':
			$id_error	= 0;
			$vCity 		= array(
				'11','12','13','14','15','21','22',
				'23','31','32','33','34','35','36',
				'37','41','42','43','44','45','46',
				'50','51','52','53','54','61','62',
				'63','64','65','71','81','82','91'
			);
			if(!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $val)) $id_error = 1;
			if(!in_array(substr($val, 0, 2), $vCity)) $id_error = 1;
			$val = preg_replace('/[xX]$/i', 'a', $val);
			$vLength = strlen($val);
			if($vLength == 18){
				$vBirthday = substr($val, 6, 4) . '-' . substr($val, 10, 2) . '-' . substr($val, 12, 2);
			} else {
				$vBirthday = '19' . substr($val, 6, 2) . '-' . substr($val, 8, 2) . '-' . substr($val, 10, 2);
			}
			if(date('Y-m-d', strtotime($vBirthday)) != $vBirthday) $id_error = 1;
			if($vLength == 18){
				$vSum = 0;
				for ($i = 17 ; $i >= 0 ; $i--){
					$vSubStr = substr($val, 17 - $i, 1);
					$vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
				}
				if($vSum % 11 != 1) $id_error = 1;
			}
			
			if($id_error){
				post_data_error($msg,$show);
			}
		break;
		//邮箱
		case'ma':
			if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
				post_data_error($msg,$show);
			}
		break;
		//手机
		case'mo':
			if(!preg_match("/^1[1234567890]\d{9}$/", $val)){
				post_data_error($msg,$show);
			}
		break;
		default:
		//通用验证
		if(in_array($check_tip,array('!=','==','>=','<='))){
			//全局变量
			if($types==1){
				@eval('if($GLOBALS[\''.$name.'\']'.$check.'){post_data_error("'.$msg.'","'.$show.'");}');
			}else{
				@eval('if($GLOBALS[\'P\'][\''.$name.'\']'.$check.'){post_data_error("'.$msg.'","'.$show.'");}');
			}
		}
	}
}

/*系统错误消息
	msg		消息内容
	show	显示方式，0网页消息,1 json输出，2返回true，3数组输出
*/
function post_data_error($msg='',$show= 0){
	$error	= array('code'=>0,'time'=>time(),'msg'=>$msg);
	switch($show){
		case 3:
			return $error;
		break;
		case 2:
			return true;
		break;
		case 1:
			return json($error);
		break;
		default:
			msg($msg);
	}
}

/*josn 编码与解码
	data	array/json		检测为数组则编码，检测为字符则解码
	fix						json 数据库写入避免 \ 被替换
	return					json或数组
*/
function json($data,$fix=0){
	if(is_array($data)){
		switch($fix){
			case 2:	//post 过滤
				return str_replace("'","&#39;",json_encode($data,JSON_UNESCAPED_UNICODE));
			break;
			case 1:	//mysql 过滤
				return str_replace('\\','\\\\',json_encode($data,JSON_UNESCAPED_UNICODE));
			break;
			default:
			if(@count(array_filter($data))>0){
				return json_encode($data,JSON_UNESCAPED_UNICODE);
			}
		}
	}else{
		$json = json_decode(str_replace("&#39;","'",$data),true);
		if (is_null($json) && strlen($data)>0){
			return $data;
		}
		return $json;
	}
}

/* 接口输出数据
	code	错误代码	数字型
	data	数据		数组
	注意：小程序或ajax请求类型非json时获取的为字符串，请不要使用此方法，采用0或1的输出
	$GLOBALS['json_out_exit']	= 1;		//禁止暂停
*/
function json_out($code,$data= array(),$show=0){
	$result['code']	= $code;
	if(!empty($data['msg'])){
		$result['msg']	= @$data['msg'];
	}
	$result = @array_merge($result,$data);
	if ($show==0){
		header('Content-type: text/json');
		global $db;
		if ($db){
			$db->close();
		}
		echo json($result);
		//默认暂停
		if ((int)$GLOBALS['json_out_exit']!=1){
			exit;
		}
	}else{
		return json($result);
	}
}

/**
*   登录用户
*/
function login($name='',$ary=''){
	$new_name = ($name=='')?$GLOBALS['m']:$name;
	//更新session
	if(is_array($ary)){
		return (array)session($new_name,$ary);
	}else{
		return (array)session($new_name);
	}
}

//在线用户插入与缓存删除
function login_session($ary,$files=0){
	$ary['create_time']	= time();
	$ary['last_time']	= 0;
	$ary['browser']		= session_id();
	$ary['status']		= 0;
	sql_update_insert( array('table' =>'login_session','data' =>$ary,'check' =>$ary));
	
	//清除缓存二维码
	if($files==1){
		$sql_sg	= sql_select( array('table'=>'login_session', 'where'=>"status='0' AND create_time<".(time()-600),'type'=>'sql') );
		$query_grade	= $db->query($sql_sg);
		while($dls = $db->fetch_array($query_grade)){
			$del_file = 'data/tmp/'.$dls['rand'].'.png';
			unlink($del_file);
		}
	}
	//删除数据库语句
	sql_del(array('table'=>'login_session','where'=>"status='0' AND create_time<".(time()-600)));
	
}

/**
*   登录用户
*	id 			当前信息的id
*	more 		附加信息，例如订单等都属于编辑状态
		more	数值为 1 表示关闭删除功能，其他内容表示附加信息
*/
function logout($name=''){
	if($name==''){
		$name	= $GLOBALS['m'];
	}
	session($name,'null');
}
/*
*  金额格式化
*/
function price($money=0){
	return number_format($money,2);
}

/**
*  文件尺寸格式化
*	size		文件尺寸
*/
function size_format($size,$types=0){
	if($size>1024){
		$temp=$size/1024;
		return size_format($temp,$types+1);
	}else{
		$unit='B';
		switch($types){case '0':$unit='B';break;case '1':$unit='KB';break;case '2':$unit='MB';break;case '3':$unit='GB';break;case '4':$unit='TB';break;case '5':$unit='PB';break;case '6':$unit='EB';break;case '7':$unit='ZB';break;}
		return sprintf('%.2f',$size).$unit;
	}
}
/**
*  在线编辑器
*	ary 用法
	id			编辑器id等于接收post名称
	data		编辑器默认数据
	mode		min表示最少功能，空则表示默认全功能
	count		1表示显示字数统计
	width		编辑器宽度 最小宽度500
	height		编辑器高度
	toolbars	空为完整编辑器，mini精简菜单，数组为自定义菜单
	readonly	true 表示只读
*/
function edit($ary=''){
	global $config,$_FDEditor;
	if (!$_FDEditor){
		include "plugin/class/edit/edit.php";
		$_FDEditor	= new FoundPHP_edit($config['edit']);
	}
	if ($ary['width']=='' && $config['edit']['width']){
		$ary['width']	= $config['edit']['width'];
	}
	if ($ary['height']=='' && $config['edit']['height']){
		$ary['height']	= $config['edit']['height'];
	}
	return$_FDEditor->edit($ary);
}



	/**
*   时间处理
*	name 		字段名称
*	date1		时间1 最早的时间
*	date2		时间2 最新的时间
*/
function date_where($name='',$date1='',$date2=''){
	$date1 		= (int)strtotime(trim($date1));
	if(dates($date1,'Y')==1970){ $date1	= ''; }
	
	if ($date2){
		$date2 		= strtotime(dates((int)strtotime(trim($date2)),'Y-m-d').' 23:59:59');;
		if(dates($date2,'Y')==1970){ $date2	= ''; }
	}else{
		$date2		= '';
	}
	
	if($name!=''){
		if($date1 && $date2 && ($date1 <= $date2)){
			return $name." >= ".$date1 ." AND ".$name." <= ".$date2;
		}elseif($date1) {
			return $name." >= ".$date1;
		}elseif($date2) {
			return $name." <= ".$date2;
		}
	}
}

/**
*   价格处理
*	name 		字段名称
*	price1		价格1
*	price2		价格2
*/
function price_where($name='',$price1='',$price2=''){
	$price1 		= (float)$price1;
	if($price1<=0){ $price1	= ''; }
	
	$price2 		= (float)$price2;
	if($price2<=0){	$price2	= ''; }
	
	if($name!=''){
		if($price1 && $price2 && ($price1 <= $price2)){
			return $name." >= ".$price1 ." AND ".$name." <= ".$price2;
		}elseif($price1) {
			return $name." >= ".$price1;
		}elseif($price2) {
			return $name." <= ".$price2;
		}
	}
}

/**
*  还原过滤字符内容
*	@param string	msg 			过滤内容
*	@return string
*/
function html_fix($msg){
	$array1 = array('&#92;','&amp;','&quot;','&#39;','<?','?>','<br>');
	$array2 = array('\\','&','"',"'",'&lt;?','?&gt;','<br />');
	$msg = str_replace($array1,$array2,$msg);
	return $msg;
}

/*
	数字金额转中文金额方法
*/
function price_cn($money=0,$type=1){
	$money = str_split($money);
	$cn_num = array('1' =>'壹','2' =>'贰','3' =>'叁','4' =>'肆','5' =>'伍','6' =>'陆','7' =>'柒','8' =>'捌','9' =>'玖','0' =>'零');
	$money_dw = array('1' =>'元','2' =>'拾','3' =>'佰','4' =>'仟','5' =>'万','6' =>'拾','7' =>'佰','8' =>'仟');
	$hb_num = array('1' =>'分','2' =>'角');
	$lenth	= @count($money);
	if($type==1){
		if($lenth<=8){
			$i = $lenth+1;
			foreach($money AS $k=>$v) {
				$i--;
				$result	.= $cn_num[$v].'  '.$money_dw[$i].' ';
			}
			return $result;
		}
	}elseif($type==2){
		
		$length = @count($money);
		
		if(!in_array('.',$money)){
			//不存在小数点，前面补零的长度，后面固定补角分
			$diff   = 9-$length;
			for($i=1;$i<=3;$i++){
				array_push($money,0);
			}
		}else{
			//存在小数，判断小数后面几位
			$offset =array_search('.',$money); 
			 $point_end = array_slice($money,$offset);
			
			//加上小数点长度不为3,后面分位补0
			if(@count($point_end)<3){
					array_push($money,0);
			}
			//算出前面补0的位数
			$length = @count($money);
			$diff   = 12-$length;
			
		}
		
		if($diff > 0){
			for($i=1;$i<=$diff;$i++){
				array_unshift($money,0);
			}
			
		}

		if(in_array('.',$money)){
			unset($money[9]);
		}
	
		
		return $money;
		
	}else{
		if($lenth<=3){
			$offset =array_search('.',$money); 
			$point_end = array_slice($money,$offset);
			if(@count($point_end)!=3){
					array_push($money,0);
			}
			$length = @count($money);
			$i = $length-1;
		
			foreach($money AS $k=>$v) {
				if($v!='.'){
				
					$result	.= $cn_num[$v].'  '.$hb_num[$i].' ';
					$i--;
				}
			}
			return $result;
		}
	}
}


/*
	操作日志
	title		标题
	todo		操作类型
	
*/
function logs($title='',$todo=''){
	global $us,$m;
	if(session('last_page')!=$GLOBALS['page_url'] && $GLOBALS['m']!='api'){
		if($m=='admin'){
			$username		= @$GLOBALS['aus']['nickname'];
			$uid			= @$GLOBALS['aus']['id'];
		}else{
			$username		= @$GLOBALS['us']['nickname'];
			$uid			= @$GLOBALS['us']['id'];
		}
		if(@(int)$GLOBALS['us']['id']<=0 && @$GLOBALS['aus']['id']<=0){
			$username		= '游客';
			$uid			= 0;
		}
		
		$todo				= ($todo==''?@$GLOBALS['_sys_pn'][$GLOBALS['t']]:$todo);
		switch($todo){
			case'go': $todo		= '保存操作'; break;
		}
		
		if($todo==$title){
			$todo				= '查看';
		}
		
		if($uid>0 && $GLOBALS['SLOG']){
			
			//去除标签
			$title					= strip_tags(htm_fix($title));
			$title					= str_replace('&nbsp;','',$title);
			
			$_SERVER['HTTP_REFERER']= str_replace($GLOBALS['config']['set']['site_url'],'',$_SERVER['HTTP_REFERER']);
			$data	= array(
					'fid'		=> @(int)$GLOBALS['us']['fid'],
					'uid'		=> $uid,
					'm'			=> $GLOBALS['m']=='admin'?'admin':$GLOBALS['m'],
					'a'			=> @$GLOBALS['a'],
					't'			=> @$GLOBALS['t'],
					'username'	=> $username,
					'titles'	=> $title,
					'todo'		=> $todo,
					'logs'		=> @$GLOBALS['logs'],
					'years'		=> date('Y'),
					'months'	=> date('m'),
					'days'		=> date('d'),
					'weeks'		=> ceil(date('j',time())/7),		//计算当月第几周
					'dates'		=> time(),
					'ip'		=> get_ip(),
				//	'browse'	=> browse(),
					'url'		=> @$GLOBALS['page_url'],
					'referer'	=> $_SERVER['HTTP_REFERER'],
					
				);
			session('last_page',$GLOBALS['page_url'],300);
			sql_update_insert( array('table' =>'logs','data' =>$data));
		}
		
	}
	
}

//获取浏览器以及版本号
function browse(){
	global $_SERVER;
	$agent  = $_SERVER['HTTP_USER_AGENT'];
	$browser  = '';
	$browser_ver  = '';
	if(preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)){
		$browser  = 'OmniWeb';
		$browser_ver   = $regs[2];
	}
	if(preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)){
		$browser  = 'Netscape';
		$browser_ver   = $regs[2];
	}
	if(preg_match('/safari\/([^\s]+)/i', $agent, $regs)){
		$browser  = 'Safari';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)){
		$browser  = 'IE';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)){
		$browser  = 'Opera';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)){
		$browser  = 'NetCaptor';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/Maxthon/i', $agent, $regs)){
		$browser  = 'Maxthon';
		$browser_ver   = '';
	}
	if(preg_match('/360SE/i', $agent, $regs)){
		$browser       = '360';
		$browser_ver   = '';
	}
	if(preg_match('/SE 2.x/i', $agent, $regs)){
		$browser       = '搜狗';
		$browser_ver   = '';
	}
	if(preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)){
		$browser  = 'FireFox';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)){
		$browser  = 'Lynx';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/Chrome\/([^\s]+)/i', $agent, $regs)){
		$browser  = 'Chrome';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/CPU iPhone OS ([^\s]+)/i', $agent, $regs)){
		$browser  = 'iPhone';
		$browser_ver   = str_replace('_','.',$regs[1]);
	}
	if(preg_match('/iPad; CPU OS ([^\s]+)/i', $agent, $regs)){
		$browser  = 'iPad';
		$browser_ver   = str_replace('_','.',$regs[1]);
	}
	if(preg_match('/.+Mac OS(.+)\) /i', $agent, $regs)){
		$browser  = 'Mac OS';
		$browser_ver   = 'Safari';
	}
	if(preg_match('/Android ([^\s]+)\;/i', $agent, $regs)){
		$browser  = 'Android';
		$browser_ver   = str_replace('_','.',$regs[1]);
	}
	if(preg_match('/Baiduspider/i', $agent, $regs)){
		$browser  = 'Baiduspider';
		$browser_ver   = str_replace('_','.',$regs[1]);
	}
	if(preg_match('/bingbot/i', $agent, $regs)){
		$browser  = 'BingSpider';
		$browser_ver   = '';
	}
	if(preg_match('/360Spider/i', $agent, $regs)){
		$browser  = '360Spider';
		$browser_ver   = '';
	}
	if(preg_match('/Sogou/i', $agent, $regs)){
		$browser  = 'SogouSpider';
		$browser_ver   = '';
	}
	if(preg_match('/haosouspider/i', $agent, $regs)){
		$browser  = 'HaoSpider';
		$browser_ver   = '';
	}
	if(preg_match('/Sosospider/i', $agent, $regs)){
		$browser	= 'SosoSpider';
		$browser_ver   = '';
	}
	if(preg_match('/; (.+Bot)\/([^\s]+);/i', $agent, $regs)){
		$browser	= trim($regs[1]);
		$browser_ver   = str_replace('_','.',$regs[2]);
	}
	if(preg_match('/; (.+Bot);/i', $agent, $regs)){
		$browser	= trim($regs[1]);
		$browser_ver   = '';
	}
	if(preg_match('/(curl.+|python.+)/i', $agent, $regs)){
		$browser	= 'Spider';
		$browser_ver   = $regs[1];
	}
	if(preg_match('/Trident\/([^\s]+)\;/i', $agent, $regs)){
		$browser  = 'Trident';
		$browser_ver   = str_replace('_','.',$regs[1]);
	}
	if($browser != ''){
		return $browser.' '.$browser_ver;
	} else{
		return $agent;
	}
}

/**
*   发送邮件函数
*	@param string 	mailto		收件人
*	@param string 	title		邮件标题
*	@param string 	text 		邮件内容
*	@param array 	set 		附件数组，数组中设置照片或文件的相对路径，例如：,array('test.rar','andorid.png')
*	@return null
*/
function mails($mailto='',$subject='',$text='',$set=array()){
	global $config;
	if ($mailto){
		echo getcwd();
		require 'plugin/class/mail/PHPMailer.php';
		require 'plugin/class/mail/SMTP.php';
		/*
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->SMTPDebug = 2;
		$mail->isSMTP();									//使用SMTP服务
		$mail->CharSet = "utf8";							//编码格式为utf8，不设置编码的话，中文会出现乱码
		$mail->SMTPAuth		= $config['mail']['check'];		//是否使用身份验证
		$mail->SMTPSecure	= $config['mail']['ssl'];		//使用ssl协议方式
		$mail->SMTPAutoTLS	= $config['mail']['tls'];		//不要tls验证
		$mail->Host			= $config['mail']['server'];	//发送方的SMTP服务器地址
		$mail->Username		= $config['mail']['user'];		//发送方的
		$mail->Password		= $config['mail']['pass'];		//客户端授权密码,而不是邮箱的登录密码！
		$mail->Port			= $config['mail']['port'];		//端口
		//$mail->Encoding		= "base64";
		$mail->isHTML((strtolower($config['mail']['format'])=='text'?false:true));				//默认发送html，可以设置发送text
		$mail->Subject		= $subject;		//邮件标题
		$mail->Body			= $text;		//邮件正文
		$mail->Debugoutput	= 'echo';
		$mail->setFrom($config['mail']['user'], $config['mail']['name']);	//设置发件人信息，如邮件格式说明中的发件人，
		$mail->addAddress($mailto, $to_name);								//设置收件人信息，如邮件格式说明中的收件人，
		$mail->addReplyTo($config['mail']['from'], $config['mail']['name']);//设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
		//附件
		if (@count($set)>0){
			foreach($set AS $k=>$v) {
				$ext	= strtolower(pathinfo($v, PATHINFO_EXTENSION));
				if (is_file($v)){
					$filename	= basename($v);
					if (in_array($ext,array('jpg','jpeg','gif','png','bmp'))){
						$mail->AddEmbeddedImage($v,$filename,$filename);
					}else{
						$mail->AddAttachment($v,$filename);
					}
				}
			}
		}*/
		ob_start();
		ob_implicit_flush(0);
			$mail->send();
			$send = ob_get_contents();
		ob_end_clean();
		
		//是否显示邮件发送信息
		if ($config['mail']['debug']){
			echo $send;
		}
		if ($config['mail']['logs']){
			$send .= "-----------------------------------------------------------\r\n\r\n";
			ECHO $GLOBALS['RAND_DIR'].'log/'.dates(time(),'ymd').'_mail.txt';
			$GLOBALS['tpl']->writer($GLOBALS['RAND_DIR'].'log/'.dates(time(),'ymd').'_mail.txt',$send,'a+');
		}
		if (!$send) { //发送邮件
			return -2;
		} else {
			//发送成功
			return 1;
		}
	}else{
		//没有邮件接收人
		return -1;
	}
}

//用户名定义
function usname($ary=''){
	if ($ary['first_name'] || $ary['last_name']){
		return $ary['first_name'].' '.$ary['last_name'];
	}
}

/*清除HTML标签代替 strip_tags
	str		html 内容
	tags	保留标签数组 array('a','p');
*/
function html_tags($str='',$tags=array()){
	if (@count($tags)>0){
		foreach($tags AS $k=>$v)$str	= str_replace(array('<'.$v,'</'.$v),array('{FD['.$v.']','{FD[/'.$v.']'),$str);
	}
	$result	= preg_replace("/<[^>]+>/i", '', $str);
	if (@count($tags)>0){
		foreach($tags AS $k=>$v)$result	= str_replace(array('{FD['.$v.']','{FD[/'.$v.']'),array('<'.$v,'</'.$v),$result);
	}
	return $result;
}