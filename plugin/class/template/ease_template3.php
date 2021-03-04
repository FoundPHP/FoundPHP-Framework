<?php
/*	(C)2005-2021 FoundPHP Framework.
*	   name: Ease Template
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: 1.21.34
*	  start: 2005-05-24
*	 update: 2021-03-04
*	support: PHP4，<=5.3
*	payment: Free 免费
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
Relation:
ease_template.php, ease_template_mime.php, language/et_en.php
*/
define('ET_E_unconnect',	'MemCache 不能连接!');
define('ET_E_not_exist1',	'抱歉 <b>');
define('ET_E_not_exist2',	'</b> 文件名错误或是文件不存在.');
define('ET_E_not_exist3',	'<br>抱歉，此文件为空或是模板语法错误不能载入 ');
define('ET_E_not_exist4',	' .');
define('ET_E_copyright',	'版权模式只有Cache模式下可以开启');
define('ET_E_mc_save',		'无法存储到memchache服务器.');
define('ET_E_not_write1',	'抱歉,');
define('ET_E_not_write2',	' 写入失败!');
define('ET_E_clear_cache',	'清除缓存');
define('ET_E_inc_tpl',		'LFB Ease Template 模板调试平台');
define('ET_E_tpl_file',		'ET 载入模板文件数');
define('ET_E_inc_file',		'系统载入php文件数');
define('ET_E_open_file',	'打开模板文件: ');
define('ET_E_cache_id',		'缓存&nbsp;&nbsp;ID:');
define('ET_E_index',		'索引模式:');
define('ET_E_format',		'模板格式:');
define('ET_E_cache',		'缓存目录:');
define('ET_E_template',		'模板目录:');
define('ET_E_memory',		'占用内存:');
define('ET_E_run_time',		'运行时间:');
define('ET_E_second',		'秒');
define('ET_E_support',		'技术支持:');
define('ET_E_cache_del',	'缓存文件删除成功.\r\n页面即将刷新.');
define('ET_E_routing',		'采用路由模式后，您的配置文件必须设置WebURL网站真实地址.<br>例如: $tpl = new template( array( "WebURL" => "http://www.systn.com/" ) );');
define('ET_E_memcache',		'请修改 php.ini 中增加 memcache 模块');
define('ET_E_error',		'Ease Template 错误：');
define('ET_E_error_file',	'错误文件：');
define('ET_E_error_line',	'错误行号：');
define('ET_E_error_info',	'错误信息：');
define('ET_E_error_code',	'错误代码：');
define("ET3!",TRUE);
error_reporting(E_ALL & ~E_NOTICE);			//不显示注意

$_ET = '';
class FoundPHP_template{
	public $ThisFile	= '';				//当前文件
	public $IncFile		= '';				//引入文件
	public $ThisValue	= array();			//当前数值
	public $FileList	= array();			//载入文件列表
	public $IncList		= array();			//引入文件列表
	public $ImgDir		= array('images','assets');	//图片地址目录
	public $HtmDir		= 'cache_htm/';		//静态存放的目录
	public $HtmID		= '';				//静态文件ID
	public $HtmTime		= '180';			//秒为单位，默认三分钟
	public $AutoImage	= 1;				//自动解析图片目录开关默认值
	public $Rewrite		= 1;				//地址自动静态化
	public $Hacker		= "<?php defined('ET3!') OR die('You are Hacker!<br>Power by Ease Template!');";
	public $Compile		= array();
	public $Analysis	= array();
	public $Emc			= array();
	public $Ext			= 'htm';
	public $get_dir_ext	= array(); 			//格式：array('php','htm');
	public $get_dir_num	= 0; 				//目录深度：0不限制，2表示目录2级深度
	/*
	*	声明模板用法
	*/
	public function __construct(
		$set = array(
				'ID'		 =>1,					//缓存ID
				'TplType'	 =>'htm',				//模板格式
				'CacheDir'	 =>'cache',				//缓存目录
				'TemplateDir'=>'template',			//模板存放目录
				'AutoImage'	 =>1,				//自动解析图片目录开关 on表示开放 off表示关闭
				'LangDir'	 =>'language',			//语言文件存放的目录
				'Language'	 =>'default',			//语言的默认文件
				'Copyright'	 =>1,				//版权保护
				'MemCache'	 =>'',					//Memcache服务器地址例如:127.0.0.1:11211
				'Compress'	 =>1,				//压缩代码
				'WebURL'	 =>'',					//如果采用路由模式请设定真实网站地址
				'Rewrite'	 =>0,				//是否开启地址重写的静态方式
				'StartTime'	 =>1,				//启用执行时间计算
			)
		){
		
		$this->TplID		= (defined('TemplateID')?TemplateID:( (@(int)$set['ID']<=1)?1:(int)$set['ID']) ).'_';
		$this->CacheDir   	= (defined('NewCache')?NewCache:( (trim($set['CacheDir']) != '')?$set['CacheDir']:'cache') ).'/';
		$this->TemplateDir	= (defined('NewTemplate')?NewTemplate:( (trim($set['TemplateDir']) != '')?$set['TemplateDir']:'template') ).'/';
		$this->Ext			= (@$set['TplType'] != '')?$set['TplType']:'htm';
		$this->AutoImage	= (@$set['AutoImage']==1)?1:0;
		$this->Compress		= (@$set['Compress']==1)?1:0;
		$this->Rewrite		= (@$set['Rewrite']==1)?1:0;
		$this->version		= (@trim($_GET['EaseTemplateVer']))?die('Ease Templae E3!'):'';
		if (@$set['Copyright']=='off'){
			$this->Copyright= 0;
		}else{
			$this->Copyright= 1;
			if (!is_writable($set['CacheDir'])){
				die(ET_E_copyright);
			}
		}
		//得到当前执行时间
		$this->start_time	= $this->get_time();
		
		if(@$set['WebURL'] != ''){
			$this->WebURL		= $set['WebURL'];
			if(substr($this->WebURL,-1)!='/'){
				$this->WebURL	.= '/';
			}
		}
		if(isset($_SERVER["PATH_INFO"]) && trim($_SERVER["PATH_INFO"])!='' && $this->WebURL==''){
			$path_info 		= explode('/',$_SERVER["PATH_INFO"]);
			if(count($path_info)>0){
				die(ET_E_routing);
			}
		}
		
		//载入语言文件
		$this->Language	= (defined('Language')?Language:( (($set['Language']!='default' && $set['Language'])?$set['Language']:'default') ));
		$this->LangDir		= (defined('LangDir')?LangDir:( ((@$set['LangDir']!='language' && @$set['LangDir'])?$set['LangDir']:'language') )).'/';
		
		if(is_dir($this->LangDir)){
			if(@is_file($this->LangDir.$this->Language.'.php')){
				$lang = array();
				include_once $this->LangDir.$this->Language.'.php';
				$this->LangData = $GLOBALS['lang'];
			}
		}else{
			$this->Language = 'default';
		}
		
		//缓存目录检测以及运行模式
		if(strchr(@$set['MemCache'],':')){
			$this->RunType		= 'MemCache';
			if(!function_exists('memcache_connect')){
				die(ET_E_memcache);
			}
			$memset		= explode(":",$set['MemCache']);
			$this->Emc	= @memcache_connect($memset[0], $memset[1]) OR die(ET_E_unconnect);
		}else{
	  	 	$this->RunType		= (@substr(@sprintf('%o', @fileperms($this->CacheDir)), -3)==777 && is_dir($this->CacheDir))?'Cache':'Replace';
		}
	}
	
	/*
	*	设置数值
	*	set_var(变量名或是数组,设置数值[数组不设置此值]);
	*/
	public function set_var(
				$name,
				$value = ''
			){
		if (is_array($name)){
			$this->ThisValue = @array_merge($this->ThisValue,$name);
		}else{
			$this->ThisValue[$name] = $value;
		}
	}


	/*
	*	设置模板文件
	*	set_file(文件名,设置目录);
	*/
	public function set_file(
				$FileName,
				$NewDir = ''
			){
		//当前模板名
		$this->ThisFile  = $FileName.'.'.$this->Ext;

		//目录地址检测
		if(trim($NewDir) != ''){
			$this->FileDir[$this->ThisFile] = strstr($NewDir.'/',$this->TemplateDir)?$NewDir.'/':$this->TemplateDir.$NewDir.'/';
		}else {
			$this->FileDir[$this->ThisFile] = $this->TemplateDir;
		}
		
		$this->IncFile[$FileName]		 = $this->FileDir[$this->ThisFile].$this->ThisFile;
		
		if(!is_file($this->IncFile[$FileName]) && $this->Copyright==1){
			die(ET_E_not_exist1.$this->IncFile[$FileName].ET_E_not_exist2);
		}
		
		//bug 系统
		$this->IncList[] = $this->ThisFile;
	}
	
	
	function replace_inc($m=''){
						$Files = $m[2];
						if($Files){
							if (!strrpos($Files,$this->Ext)){
								$Files	= $Files.".".$this->Ext;
							}
							
							$filels		= $this->TemplateDir.$Files;
							//新风格模板不存在则采用默认模板
							if(!is_file($filels)){
								$this->TemplateDir	= 'templates/default/';
								$filels				= $this->TemplateDir.$Files;
							}
							
							$contents = $this->ParseCode($filels, $Files);
									
								if($this->RunType=='Cache' || $this->RunType=='MemCache'){
									$this->FileDir[$Files]	= $this->TemplateDir;
									//引用模板
									$this->IncList[]		= $Files;
									$cache_file 			= $this->FileName($Files,$this->TplID);
									
									$this->IncHtm[$filels]	= $cache_file;
									
									return '[DNA_F];$this->FileDir["'.$Files.'"] = "'.$this->TemplateDir.'"; if(is_file("'.$cache_file.'")){include("'.$cache_file.'");} $_ET.= [DNA_F]';
								}else{
									//引用模板
									$this->FileDir[$Files] = $this->TemplateDir;
									$this->IncList[] = $Files;
									
									return $contents;
								}
						}
	}
	
	function replace_xml($m=''){
		return '<ET_XJ>'.base64_encode($m[1]).'</ET_XJ>'; 
	}
	function replace_xmlde($m=''){
		return base64_decode($m[1]);
	}
	function replace_php($m=''){
				$parse	= parse_url($m[2]);
				unset($vals,$code_array);
				foreach((array)explode('&',$parse['query']) AS $vals){
					$code_array .= preg_replace_callback('/(.+)=(.+)/',create_function('$m','return ";\$_GET[\'$m[1]\']=\$$m[1]=\"$m[2]\"";'),$vals);
				}
				return '\''.$code_array.';ob_start();ob_implicit_flush(0);@include\''.$parse['path'].'\'; $c=ob_get_contents();ob_end_clean();$_ET.=$c;$_ET.=\'';
	}
	function replace_lang($m=''){
		return $this->lang($m[1]);
	}
	function replace_if($m=''){
		return "';if(".$this->FixOther($m[1])."){\$_ET.='";
	}
	function replace_elseif($m=''){
		return "';}elseif(".$this->FixOther($m[1])."){\$_ET.='";
	}
	
	function replace_foreach($m=''){
		return "';\$_i=0;foreach((array)".$this->FixOther($m[1])." AS $m[3]){\$_i++;\$_ET.='";
	}
	function replace_for($m=''){
		$m['2']	= str_replace("\'","'",$m['2']);
		return "';for(".$m['1'].";".$m['2'].";".$m['3']."){\$_ET.='";
	}
	function replace_while($m=''){
		return "';\$_i=0;while(".$this->FixOther($m[1])."){\$_i++;\$_ET.='";
	}
	function replace_code($m=''){
					$first		= substr($m[1],0,1);
					if(preg_match("/^[a-zA-Z\s]+$/",$first ) || $first=='_'){
						$m[1]	= str_replace("\'","'",$m[1]);
						return "';\$_ET.=\$".$m[1].";\$_ET.='";
					}else{
						return '{'.$m[1].'}';
					}
	}
	function replace_row($m=''){
		return $this->Row($m[2]);
	}
	function replace_color($m=''){
		return $this->Color($m[2]);
	}
	function replace_js($m=''){
		return $this->FixJS($m[1]);
	}
	function replace_fixphp($m=''){
		return $this->FixPHP($m[1]);
	}
	function replace_link($m=''){
		return $this->links($m[2],$m[1]);
	}
	function lazy_img($m=''){
		$newsrc = str_ireplace('src=','data-original=',$m[1]);
		$newsrc = str_ireplace('def=','src=',$newsrc);
			return "<img ".trim($newsrc).">";
	}
	function order($m=''){
		if (trim($m[3])){
			return "<a href=\"$GLOBALS[page_url]&o=$m[3]&g=';\$_ET.=(\$GLOBALS['o']=='$m[3]' && \$GLOBALS['g']=='a'?'d':'a');\$_ET.='\"><span class=\"fa fa-caret-';\$_ET.=(\$GLOBALS['o']=='$m[3]' && \$GLOBALS['g']=='a'?'up':'down');\$_ET.='\"></span></a>";
		}
	}
	
	//解析替换程序
	public function ParseCode(
				$FileList = '',
				$CacheFile = ''
			){
			//模板数据
			$ShowTPL = '';
			//解析续载
			if (@is_array($FileList) && $FileList!='include_page'){
				foreach ($FileList AS $K=>$V){
					$read_file= $this->reader($V.$K);
					$ShowTPL .= $this->ImgCheck($read_file, $V.$K);
				}
			}else{
				//如果指定文件地址则载入
				$SourceFile = ($FileList!='')?$FileList:$this->FileDir[$this->ThisFile].$this->ThisFile;
				
				if(!is_file($SourceFile) && $this->Copyright==0){
					die(ET_E_not_exist1.$SourceFile.ET_E_not_exist2);
				}
				$ShowTPL = $this->ImgCheck($this->reader($SourceFile) ,$SourceFile);
			}
			
			
			//inc引用模板函数
			if(strchr($ShowTPL,'inc:') || strchr($ShowTPL,'#include')){
				$ShowTPL = preg_replace_callback(
					array('/(\{\s*|<!--\s*)inc\s*:\s*([^\{\} ]{1,100})(\s*\}|\s*-->)/is','/<\!--\s*\#include\s*file\s*=\s*(\"|\')\s*([a-zA-Z0-9_\.\|\/]{1,100})\s*(\"|\')\s*-->/is'),array($this, 'replace_inc'),$ShowTPL
				);
				
			}
	 		//修复代码中\\错误,双引号问题
			$ShowTPL = str_replace( array('\\',"'"), array('\\\\',"\'"), $ShowTPL);
			
			//多语言
			$ShowTPL = preg_replace( array('/<lang><\/lang>/is','/<lang>\s*<\/lang>/is'), '',$ShowTPL);
			$ShowTPL = preg_replace_callback( '/<lang>(.+?)<\/lang>/is', array($this, 'replace_lang'),$ShowTPL);
			
			//保护 XML
			$ShowTPL = preg_replace_callback(
					array('/(<\?xml.+?\?>)/is'),array($this, 'replace_xml'),$ShowTPL
			);
			
			//编译运算
			//引用php
			$ShowTPL = preg_replace_callback('/(\{\s*|<!--\s*)inc_php:([a-zA-Z0-9_\[\]\.\,\/\?\=\$\#\&\:\;\->\|\^]{2,100})(\s*\}|\s*-->)/is',array($this,'replace_php'),$ShowTPL);
			
			//内部执行
			$ShowTPL = preg_replace_callback(array('/(\{\s*|<!--\s*)run\:(\}|\s*-->)\s*(.+?)\s*(\{|<!--\s*)\/run(\s*\}|\s*-->)/is','/(\{\s*|<!--\s*)(run\:)(.+?)(\s*\}|\s*-->)/is'),create_function('$m', 'return "(T_T)$m[3];(T_T!)";'),$ShowTPL);
			//表格排序
			$ShowTPL = preg_replace_callback(array('/(\{\s*|<!--\s*)order\:(\}|\s*-->)\s*(.+?)\s*(\{|<!--\s*)\/run(\s*\}|\s*-->)/is','/(\{\s*|<!--\s*)(order\:)(.+?)(\s*\}|\s*-->)/is'),array($this,'order'),$ShowTPL);
			
			//判断
			$ShowTPL = preg_replace_callback('/<!--\s*DEL\s*-->/is',create_function('$m', 'return "\';if(\$ET_Del==true){\$_ET.=\'";'),$ShowTPL);
			$ShowTPL = preg_replace_callback('/<!--\s*IF\s*[\(|\[](.+?)[\)|\]]\s*-->/is',array($this, 'replace_if'),$ShowTPL);
			$ShowTPL = preg_replace_callback('/<!--\s*ELSEIF\s*[\(|\[](.+?)[\)|\]]\s*-->/is',array($this, 'replace_elseif'),$ShowTPL);
			
			$ShowTPL = preg_replace_callback('/<!--\s*ELSE\s*-->/is',create_function('$m', 'return "\';}else{\$_ET.=\'";'),$ShowTPL);
			$ShowTPL = preg_replace_callback('/<!--\s*END\s*-->/is',create_function('$m', 'return "\';}\$_ET.=\'";'),$ShowTPL);
			//循环
			$ShowTPL = preg_replace_callback('/<!--\s*([a-zA-Z0-9_\[\]\$\'\\\"]{1,100}|[a-zA-Z0-9_\[\]]{1,100}\->[a-zA-Z0-9_[\]\$\'\\\"\->\(\)\;]{1,100})\s*( [ASas]{2} )\s*(.+?)\s*-->/',array($this,'replace_foreach'),$ShowTPL);
			$ShowTPL = preg_replace_callback('/<!--\s*while\:\s*(.+?)\s*-->/is',array($this,'replace_while'),$ShowTPL);
			$ShowTPL = preg_replace_callback('/<!--\s*([a-zA-Z0-9_\[\]\'\$\\\"=]{4,30})\s*;\s*(.+)\s*;\s*([a-zA-Z0-9_\[\]\$\'\\\"\-\+]{4})\s*-->/',array($this,'replace_for'),$ShowTPL);
			//变量
			$ShowTPL = preg_replace_callback('/\{([a-zA-Z0-9_\[\]\$\'\\\"]{1,40}|[a-zA-Z0-9_\[\]]{1,40}\->[a-zA-Z0-9_[\]\$\'\\\"\->\(\)\;]{1,40})\}/',array($this,'replace_code'),$ShowTPL);
			
			//换行
			$ShowTPL = preg_replace_callback('/(\{\s*|<!--\s*)row\:(.+?)(\s*\}|\s*-->)/is',array($this,'replace_row'),$ShowTPL);
			//颜色
			$ShowTPL = preg_replace_callback('/(\{\s*|<!--\s*)color\:\s*([\#0-9A-Za-z]+\,[\#0-9A-Za-z]+)(\s*\}|\s*-->)/is', array($this,'replace_color'),$ShowTPL);
			
 			//还原js错误
			$ShowTPL = preg_replace_callback( '/(<script.*<\/script>)/is', array($this,'replace_js'),$ShowTPL);
			
			//修复php运行错误
			$ShowTPL = preg_replace_callback(array("/\(T_T\)(.+?)\(T_T!\)/is"), array($this,'replace_fixphp'),$ShowTPL);
			$ShowTPL = preg_replace_callback(array("/';\s*([if|echo |$].+?)\s*echo\s*'/"), array($this,'replace_fixphp'),$ShowTPL);
			
			//还原xml
			$ShowTPL = preg_replace_callback( '/<ET_XJ>(.+?)<\/ET_XJ>/i',array($this,'replace_xmlde') ,$ShowTPL);
			
			//地址静态化
			$ShowTPL = preg_replace_callback( array('/<(link)>(.+?)<\/link>/is','/<(js)>(.+?)<\/js>/is'), array($this,'replace_link'),$ShowTPL);
			
			//照片懒加载
			$ShowTPL = preg_replace_callback( '/<lazy\s*(.+?)>/is', array($this,'lazy_img'),$ShowTPL);
			//从数组中将变量导入到当前的符号表
			$sys_val = $this->Value();
			unset($sys_val['GLOBALS']);
			@extract($sys_val);
			//修复"问题
			//修复语言中的变量
			$ShowTPL	= str_replace('\\\\$','$', $ShowTPL);
			$ShowTPL	= str_replace('[DNA_F]',"'", $ShowTPL);
			
			//修复部分linux换行错误
			$ext_n	= explode("\n",$ShowTPL);
			if (strlen($ShowTPL)>10 && count($ext_n)<=1){
				$ext_r	= explode("\r",$ShowTPL);
				if (count($ext_r)>count($ext_n)){
					$ShowTPL	= str_replace("\r","\r\n",$ShowTPL);
				}
			}
			
			switch($this->RunType){
				//编译模板
				case'Cache':
					$this->CompilePHP($ShowTPL,$CacheFile);
				break;
				
				//MemCache 编译
				case'':
					memcache_set($this->Emc,$this->ThisFile.'_date', time()) OR die(ET_E_mc_save);
					memcache_set($this->Emc,$this->ThisFile, $ShowTPL) OR die(ET_E_mc_save);
				break;
			}
			
			if ($this->RunType=='Cache'){
			//	$ShowTPL = str_replace('echo','$_ET.=',$ShowTPL);
				$output = '$_ET.=\''.$ShowTPL.'\';';
				ob_start();
				ob_implicit_flush(0);
				$output = '$_ET.=\''.$ShowTPL.'\';';
					@eval($output);
					echo $_ET;
					$content = ob_get_contents();
				ob_end_clean();				
			}else{
				$ShowTPL	= str_replace('$_ET.=',"echo ", $ShowTPL);
				ob_start();
				ob_implicit_flush(0);
					eval('echo '."'".$ShowTPL."';");
					$content = ob_get_contents();
				ob_end_clean();
			}

			
			//错误检测
			if(strchr($content,'<b>Parse error</b>') && strchr($content,' in ') && strchr($content,"eval()'d code") && strchr($content,"on line")){
				$content = $this->Error($content,$ShowTPL,$SourceFile);
			}
			
			
			//错误检查
			if(strlen($content)<=0){
				die(ET_E_not_exist3.$SourceFile.ET_E_not_exist4);
			}
		return $content;
	}

	/*
	*  编译解析处理
	*/
	public function CompilePHP(
				$content='',
				$cachename = ''
			){
		if ($content){
			//如果没有安全文件则自动创建
			if($this->RunType=='Cache' && !is_file($this->CacheDir.'index.htm')){
				$Ease_name   = 'Ease Template!';
				$Ease_base   = "<title>$Ease_name</title><a href='http://www.systn.com'>$Ease_name</a>";
				$this->writer($this->CacheDir.'index.html',$Ease_base);
				$this->writer($this->CacheDir.'default.htm',$Ease_base);
			}
			
			$wfile   = ($cachename)?$cachename:$this->ThisFile;
			
			$serialize_data	= serialize(@$this->IncHtm);
			if(strlen($serialize_data)>2){
				$serial_data= '$EaseTemplate3_inc = unserialize(\''.$serialize_data.'\');';
			}
			
			//代码压缩
			if($this->Compress==1){
				$content	= $this->compress_html($content);
			}
			
			$this->writer($this->FileName($wfile,$this->TplID) ,$this->Hacker.$serial_data.' $_ET.=\''.$content.'\';');
		}
	}
	
	
	/*
	*	输出运算
	*   Filename	连载编译输出文件名
	*/
	public function output(
				$Filename = ''
			){
			
		switch($this->RunType){
			
			//Mem编译模式
			case'MemCache':
				if ($Filename=='include_page'){
					//直接输出文件
					$contents	= $this->reader($this->FileDir[$this->ThisFile].$this->ThisFile);
				}else{
					
					$FileNames	= ($Filename)?$Filename:$this->ThisFile;
					//检测模版更新
					$updateT	= memcache_get($this->Emc,$FileNames.'_date');
					
					$update	= filemtime($this->FileDir[$this->ThisFile].$this->ThisFile);
					//更新缓存
					if($update>$updateT){
						//创建缓存
						$contents	= $Filename?$this->ParseCode($this->FileList,$Filename):$this->ParseCode();
						//关闭memcache
						memcache_close($this->Emc);
					}else{
						//获取缓存
						$CacheData = memcache_get($this->Emc,$FileNames);
						//关闭memcache
						memcache_close($this->Emc);
						
						@extract($this->Value());
							ob_start();
							ob_implicit_flush(0);
								eval('echo \''.$CacheData.'\';');
								$content = ob_get_contents();
							ob_end_clean();

							//错误检测
							if(strchr($content,'<b>Parse error</b>') && strchr($content,' in ') && strchr($content,"eval()'d code") && strchr($content,"on line")){
								$file_text	= $this->reader($CacheFile);
								$content	= $this->Error($content,$file_text,$CacheFile);
							}
								
						$contents	= $content;
						unset($content);		//释放内存
					}
					
				}
			break;
			
			
			//编译模式
			case'Cache':

				if ($Filename=='include_page'){
					
					//直接输出文件
					$contents	= $this->reader($this->FileDir[$this->ThisFile].$this->ThisFile);
				}else{
					$FileNames	= ($Filename)?$Filename:$this->ThisFile;
					$CacheFile	= $this->FileName($FileNames,$this->TplID);
					
					$CacheFile	= $this->FileUpdate($CacheFile);
					if (@is_file($CacheFile)){
						@extract($this->Value());
							$_ET = '';
							include $CacheFile;
							//获得引用列表
							if(is_array($EaseTemplate3_inc)){
								foreach ($EaseTemplate3_inc AS $K=>$V){
									if(@filemtime($K)>@filemtime($V)) $update = 1;
								}
							}
							
							//更新缓存
							if(@$update ==1){
								$contents	= $Filename?$this->ParseCode($this->FileList,$Filename):$this->ParseCode();
							}
							
							//获得列表文件
							if($_ET!=''  && @$update!=1){
								$content = $_ET;
								//错误检测
								if(strchr($content,'<b>Parse error</b>') && strchr($content,' in ') && strchr($content,"eval()'d code") && strchr($content,"on line")){
									$file_text	= $this->reader($CacheFile);
									$content	= $this->Error($content,$file_text,$CacheFile);
								}
								
								$contents	= $content;
								unset($content);		//释放内存
							}
					}else{
						
						$contents	= $Filename?$this->ParseCode($this->FileList,$Filename):$this->ParseCode();
					}
				}
				
			break;
			
			
			//替换引擎
			default:
				if($Filename){
					if ($Filename=='include_page'){
						//直接输出文件
						$contents	= $this->reader($this->FileDir[$this->ThisFile].$this->ThisFile);
					}else {
						$contents	= $this->ParseCode($this->FileList);
					}
				}else{
					$contents	= $this->ParseCode();
				}
		}
		
			//代码压缩
			if($this->Compress==1){
				$contents	= $this->compress_html($contents);
			}
			
			
			//写入静态文件
			if($this->HtmID){
				$this->writer($this->HtmDir.$this->HtmID,$contents);
			}
			
			return $contents;
		
	}

	/*
	*  多语言
	*/
	public function lang(
				$str = ''
			){
		global $db_obj;
		if (is_dir($this->LangDir)){
			$str	= trim($str);
			//采用MD5效验
			$id 	= md5($str);
			$lang_file	= $this->LangDir.$this->Language;
			//不存在数据则写入
			if($this->LangData[$id]==''){
				//语言包文件
				if (@is_file($lang_file.'.php')){
					//unset($GLOBALS['lang']);
					include_once($lang_file.'.php');
				}
				
				//如果检测到有数据则输出
				if ($GLOBALS['lang'][$id]){
					return $GLOBALS['lang'][$id];
				}else{
				
					//文件安全处理
					$data = (!is_file($this->LangDir.'default.php'))?"<?php\n/*\n/* SYSTN ET Language For ".$this->Language."\n*/\n":'';
					
					//记录语言包
					if (!$GLOBALS['lang'][$id]){
						//过滤语言中的变量
						$str	= preg_replace_callback("/([$][a-zA-Z0-9\_\$]{2,100})/is",create_function('$m', 'return $m[1];'),$str);
						$str	= str_replace('\\"','"', $str);
						$w_str	= str_replace(array('\\','\\\\$'), array('\\\\','\\\\\$'), $str);
						
						if(strlen($w_str)>200){
							$this->writer($lang_file.'.'.$id.'.php','<?php $EaseLang = <<< EOT'."\n".$w_str."\nEOT;\n?>");
							$w_str	= 'Ease Template Language Loading...';	//语言新文件
						}
						//写入数据
						if (!$GLOBALS['lang'][$id]){
							$data.= '$GLOBALS[\'lang\'][\''.$id.'\'] = <<< EOT'."\n".$w_str."\n".'EOT;'."\n";
							$this->writer($this->LangDir.'default.php',$data,'a+');
						}
					}
				}
			}
			
				//单独语言文件包
				if($this->LangData[$id]=='Ease Template Language Loading...'){
					unset($EaseLang);
					if(is_file($lang_file.'.'.$id.'.php')){
						include_once $lang_file.'.'.$id.'.php';
						$this->LangData[$id] = $EaseLang;
					}
				}
				
			return ($this->LangData[$id])?$this->LangData[$id]:$str;
		}else{
			return $str;
		}
	}




	
	//修复PHP执行时产生的错误
	public static function FixPHP(
				$content=''
			){
		$search		= array(
				'\\\\',
				'\$',
				"\'",
				"echo "
			);
		
		$replace	= array(
				'\\',
				'$',
				"'",
				"\$_ET.="
			);
			$content = str_ireplace($search, $replace, $content);
			$content = str_ireplace('in_array', '@in_array', $content);
			
	  	$content	= @preg_replace_callback("/(print_r\((.+?)\))/is",array($this,'preg_fixphp'),$content);

		return '\';'.$content.'$_ET.=\'';
	}
	function preg_fixphp($m=''){
		$text	= 'ob_start();ob_implicit_flush(0);'.$m[0].';$result = ob_get_contents();ob_end_clean();$_ET.=$result;';
	  	return $text;
	}
	function preg_fixjs($m=''){
		$text		= str_replace('echo ',';$_ET.=',$m[1]);
		$text		= str_replace("\'","'",$text);
		return "';".$text.';$_ET.=\'';
	}
	
	
	//修复JS执行时产生的错误
	public static function FixJS(
				$content=''
			){
		$content = @preg_replace_callback('/\(T_T\)(.+?)\(T_T\!\)/is',array($this,'preg_fixjs'),$content);
		return $content;
	}
	
	//其他用途修复
	public static function FixOther(
				$content=''
			){
			
			$search		= array(
					"\'",
					'in_array'
				);
			
			$replace	= array(
					"'",
					'@in_array'
				);
		$content = str_replace($search, $replace, $content);
		return $content;
	}
	/*
	*  检测缓存是否要更新
	*	filename	缓存文件名
	*/
	public function FileUpdate($filname,$settime=0){
		
		//检测设置模板文件
		if (is_array($this->IncFile)){
			unset($k,$v);
			$update		= 0;
			$settime	= ($settime>0)?$settime:@filemtime($filname);
			foreach ($this->IncFile AS $k=>$v){
				if (@filemtime($v)>$settime){$update = 1;}
			}
			//更新缓存
			if($update==1){
				return false;
			}else {
				return $filname;
			}
			
		}else{
			return $filname;
		}
	}
	
	
	
	//函数名: compress_js
	//参数: $string
	//返回值: 压缩后的$string
	public function compress_js($str){
		$str = preg_replace_callback(array('/(\/\/.*\r\n)/',"/\s(?=\s)/"),create_function('$m', 'return "";'),$str);
			$search		= array('var','\"',"\r\n","\t"," = ","; ","  ","if (",") ",", ","} else {","{ ","} ");
			$replace		= array('var ','"','','','=',";"," ","if(",")",",","}else{","{","}");
			$str= str_replace($search, $replace, $str);
			return $str;
	}
	
	function replace_compress($m=''){
		return $this->compress_js($m[1]);
	}
	//函数名: compress_html
	//参数: $string
	//返回值: 压缩后的$string
	public function compress_html($str){
		$str = preg_replace_callback("/(<script.+?<\/script>)/is",array($this,'replace_compress'),$str);
		$str = preg_replace_callback(array('~>\s+\n~','~>\s+\r~'),create_function('$m', 'return ">";'),$str);
		$str = preg_replace_callback(array('~>\s+<~'),create_function('$m', 'return "><";'),$str);
		$str = preg_replace_callback(array("/\s*\r\n/"),create_function('$m', 'return "\r\n";'),$str);
		
		$search		= array(
				"\r\n",				//清除换行符
				"\n",				//清除换行符
				"\t",				//清除制表符
				"O_N_O",			////清除换行符
				"\r\n\r\n",
			);
		
		$replace	= array(
				' ',
				' ',
				'',
				"\r\n",
				"\r\n",
			);
		$str = str_replace($search, $replace, $str);
		return $str;
	}
	
	
	/*
	*  连载函数
	*/
	public function n(){
		//连载模板
		$this->FileList[$this->ThisFile] = $this->FileDir[$this->ThisFile];
	}


	/*
	*	输出模板内容
	*   Filename	连载编译输出文件名
	*/
	public function r(
				$Filename = ''
			){
		$output	= $this->output($Filename);
		unset($this);
		return $output;
	}


	/*
	*	打印模板内容
	*   Filename	连载编译输出文件名
	*/
	public function p(
				$Filename = ''
			){
		echo $this->output($Filename);
		unset($this);
	}


	/*
	*	分析图片地址
	*   content		分析内容
	*   fileadds	文件名
	*/
	public function ImgCheck(
				$content,
				$fileadds=''
			){
		//Check Image Dir
		if($this->AutoImage==1){
			$file_dir	= dirname($fileadds);
			
			if(isset($_SERVER["PATH_INFO"]) || $this->WebURL){
				$file_dir	= $this->WebURL.$file_dir;
			}
			
			//增加替换照片目录
			preg_match_all('@<!--\s*dir\s*\:\s*([a-zA-Z0-9]+)\s*-->@i', $content, $matches);
			$adds_ary = $matches[1];
			
			//合并目录数组
			if(is_array($adds_ary)){
				$this->ImgDir = (!in_array($adds_ary,$this->ImgDir))?@array_merge($adds_ary, $this->ImgDir):$adds_ary;
			}
			
			if(is_array($this->ImgDir)){
				foreach($this->ImgDir AS $rep){
					$rep = trim($rep);
					//检测是否执行替换
					if(strrpos($content,$rep."/")){
						if(substr($rep,-1)=='/'){
							$rep = substr($rep,0,strlen($rep)-1);
						}
						$content = str_replace($rep.'/',$file_dir.'/'.$rep.'/',$content);
					}
				}
			}
		}
		
		return $content;
	}
	
	
	/*
	*	映射图片地址
	*/
	public function Dirs(
				$adds = ''
			){
		$adds_ary = explode(",",$adds);
		if(is_array($adds_ary)){
			$this->ImgDir = (is_array($this->ImgDir))?@array_merge($adds_ary, $this->ImgDir):$adds_ary;
		}
	}
	
	
	/*
	*	编译错误提示
	*/
	public function Error($content='',$check_data='',$error_file=''){
		if($content){
			$error_line	 = preg_replace_callback("/.+on line <b>([0-9]{1,5})<\/b>.+/is",create_function('$m', 'return (int)$m[1];'),$content);
			
			$error_info	 = trim(strip_tags( preg_replace_callback("/.+:(.+) in .+/is",create_function('$m', 'return $m[1];'),$content) ));
			
			$content_ext = explode("\n",$check_data);
			$content  	 = '<font color="red"><h2>'.ET_E_error.'</h2></font><dir>';
			if($error_file){
				$content.= '<li><b>'.ET_E_error_file.'</b>'.$error_file;
			}
			$content 	.= '</li><li><b>'.ET_E_error_line.'</b>'.$error_line;
			$content 	.= '</li><li><b>'.ET_E_error_info.'</b>'.$error_info;
			$content 	.= '</li><li><b>'.ET_E_error_code.'</b><font color="red">'.trim(htmlspecialchars($content_ext[($error_line-1)]));
			$content 	.= '</font></li></dir>';
			return $content;
		}
	}

	/*
	*	获得所有设置与公共变量
	*/
	public function Value(){
		return (is_array($this->ThisValue))?array_merge($this->ThisValue,$GLOBALS):$GLOBALS;
	}

	/*
	*	清除设置
	*/
	public function clear(){
		$this->RunType = 'Replace';
	}

	/*
	*  静态文件写入
	*/
	public function htm_w(
				$w_dir = '',
				$w_filename = '',
				$w_content = ''
			){
		$dvs  = '';
		if($w_dir && $w_filename && $w_content){
			//目录检测数量
			$w_dir_ex  = explode('/',$w_dir);
			$w_new_dir = '';	//处理后的写入目录
			unset($dvs,$fdk,$fdv,$w_dir_len);
			foreach((array)$w_dir_ex AS $dvs){
				if(trim($dvs) && $dvs!='..'){
					$w_dir_len .= '../';
					$w_new_dir .= $dvs.'/';
					if (!@is_dir($w_new_dir)) @mkdir($w_new_dir, 0777);
				}
			}
			//获得需要更改的目录数
			foreach((array)$this->FileDir AS $fdk=>$fdv){
				$w_content = str_replace($fdv,$w_dir_len.str_replace('../','',$fdv),$w_content);
			}
			if(!is_dir($w_dir)){
				$this->mk_dir($w_dir);
			}
			$this->writer($w_dir.$w_filename,$w_content);
		}
	}

	/*
	*  改变静态刷新时间
	*/
	public function htm_time($times=0){
		if((int)$times>0){
			$this->HtmTime = (int)$times;
		}
	}

	/*
	*  静态文件存放的绝对目录
	*/
	public function htm_dir($Name = ''){
		if(trim($Name)){
			$this->HtmDir = trim($Name).'/';
		}
	}

	/*
	*  产生静态文件输出
	*/
	public function HtmCheck(
				$Name = ''
			){
		//缓存文件夹
		$this->cache_dir	= md5(dirname($_SERVER['REQUEST_URI'])).'/'.basename(str_replace(".","_",$_SERVER['SCRIPT_NAME'])).'/';
		//建立缓存文件夹
		if(!is_dir($this->HtmDir.$this->cache_dir)){
			$this->mk_dir($this->HtmDir.$this->cache_dir);
		}
		$this->cache_action	= md5($_SERVER['QUERY_STRING']);
		$this->HtmID		= (trim($Name) ? trim($Name) : $this->cache_dir.$this->cache_action). '.php';
		$file_adds			= $this->HtmDir.$this->HtmID;
		
		//检测时间
		if(is_file($file_adds) && (time() - @filemtime($file_adds)<=$this->HtmTime)){
			return $this->reader($file_adds);
		}
	}

	/*
	*  打印静态内容
	*/
	public function htm_p(
				$Name = ''
			){
		$Name	= preg_replace_callback('/[\/|\?|\&|=|\-]/',create_function('$m', 'return "";'),$Name);
		$output = $this->HtmCheck($Name);
		if ($output){
			echo $output;
			exit;
		}
	}

	/*
	*  输出静态内容
	*/
	public function htm_r(
				$Name = ''
			){
		return $this->HtmCheck($Name);
	}

	/*
	*	解析文件
	*/
	public function FileName(
				$name,
				$id = '1'
			){
		$extdir = explode("/",$name);
		$dirnum = @count($extdir) - 1;
		
		if($dirnum>0){
			if(!is_dir($this->CacheDir.'/'.$dirnum)){
				@mkdir($this->CacheDir.'/'.$dirnum,0777);	//建立多级缓存目录
			}
			return $this->CacheDir.$dirnum.'/'.$id.str_replace("/",',',$name).".".$this->Language.'.php';
		}
		return $this->CacheDir.$id.$name.".".$this->Language.'.php';
	}

	/*
	*	换行函数
	*	Row(换行数,换行颜色);
	*	Row("5,#ffffff:#e1e1e1");
	*/
	public static function Row(
				$Num = ''
			){
		$Num = trim($Num);
		if($Num != ''){
			$Nums  = explode(",",$Num);
			$Numr  = ((int)$Nums[0]>0)?(int)$Nums[0]:2;
			$input = (trim($Nums[1]) == '')?'</tr><tr>':$Nums[1];
			if(trim($Nums[1]) != ''){
				$Co	 	= explode(":",$Nums[1]);
				$OutStr = "if(\$_i%$Numr===0){\$row_count++;echo(\$row_count%2===0)?'</tr><tr bgcolor=\"$Co[0]\">':'</tr><tr bgcolor=\"$Co[1]\">';}";
			}else{
				$OutStr = "if(\$_i%$Numr===0){\$_ET.='$input';}";
			}
			return '\';'.$OutStr.'$_ET.=\'';
		}
	}

	/*
	*	间隔变色
	*	Color(两组颜色代码);
	*	Color('#FFFFFF,#DCDCDC');
	*/
	public static function Color(
				$color = ''
			){
		if($color != ''){
			$OutStr = preg_replace_callback("/(.+),(.+)/",create_function('$m','return "_i%2===0)?\'$m[1]\':\'$m[2]\';";'),$color);
			if(strrpos($OutStr,"%2")){
				return '\';$_ET.=($'.$OutStr.'$_ET.=\'';
			}
		}
	}
	
	
	//动态与静态链接切换
	function links($url,$type='html'){
		$url = str_replace('\"','"', $url);
		//地址重写
		if($this->Rewrite==1){
			//解析网站地址
			$url_parse = parse_url($url);
			parse_str($url_parse['query'], $output);
			//分页地址处理
			if($output['page']!=''){$page = '_'.$output['page'];unset($output['page']); }
			
			if(count($output)>0){
				$html_url = implode('.',$output).$page;
			}else {
				$html_url = 'index';
			}
			
			return $html_url.'_'.(($type=='link')?'htm':$type);
			
		}else {
			return $url;
		}
	}
	
	/*
		CURL GET/POST
		url		提交数据或获取地址，url连接后加入::2 表示2秒超时
		post	提交数据数组
		cookie	cookie数组或明文;分割,例如username=tonsen;
	*/
	public function curl($url,$post='',$cookie=''){
		$url_ex	= explode('::',$url);
		$purl	= parse_url($url_ex[0]);
		$curl	= curl_init();
		if ($cookie){
			$set_cookie					= '';
			if (is_array($cookie)){
				foreach($cookie AS $k=>$v){
					$set_cookie		.= $k.'='.$v.'; ';
				}
			}else{
				$set_cookie			= $cookie;
			}
			
			$set[CURLOPT_COOKIEFILE]	= $set_cookie;
			$set[CURLOPT_COOKIEJAR]		= $set_cookie;
		}
		$set	= array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 60,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => ($post!=''?"POST":"GET"),
			CURLOPT_HTTPHEADER => array(
				"accept: */*",
				"accept-encoding: gzip, deflate",
				"accept-language: zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4,ja;q=0.2",
				"cache-control: no-cache",
				"connection: keep-alive",
				"content-type: application/x-www-form-urlencoded",
				"origin: $purl[scheme]://$purl[host]",
				"pragma: no-cache",
				"referer: $purl[scheme]://$purl[host]",
				"user-agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.110 Safari/537.36",
				($set_cookie?"cookie: $set_cookie":'')
			)
		);
		if ($post){
				//http_build_query支持post数组
			if (count($post)>0 && is_array($post)){
				$set[CURLOPT_POSTFIELDS] = http_build_query($post);
			}else{
				$set[CURLOPT_POSTFIELDS] = $post;
			}
		}	
		
		curl_setopt_array($curl, $set);
		//https请求
		if (strtolower($purl[scheme])=='https'){
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);		// https请求时要设置为false 不验证证书和hosts  FALSE 禁止 cURL 验证对等证书（peer's certificate）, 自cURL 7.10开始默认为 TRUE。从 cURL 7.10开始默认绑定安装。 
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);		//检查服务器SSL证书中是否存在一个公用名(common name)。
		}
		//url
		curl_setopt($curl, CURLOPT_URL, $url_ex[0]);
		$result		= curl_exec($curl);
		$err		= curl_error($curl);
		$httpcode	= curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		return $result;
	}

	
	/*
	*	读取函数
	*	reader(文件名);
	*/
	public function reader(
				$filename
			){
		$handle = @fopen($filename, "r");
		$data = @fread($handle, filesize($filename));
		@fclose($handle);
		return $data;
		//return @file_get_contents($filename);
	}


	/*
	*	写入函数
	*	writer(文件名,写入数据, 写入数据方式);
	*/
	public function writer(
				$filename,
				$data = '',
				$mode='w'
			){
		if(trim($filename)){
			$file = @fopen($filename, $mode);
			@fwrite($file, $data);
			@fclose($file);
			if(!is_file($filename)){
				die(ET_E_not_write1.$filename.ET_E_not_write2);
			}
		}
	}
	
	/*
	*	获取目录
	*	$tpl->get_dir('data',$get_list);
		print_r($get_list);
	*/
	function get_dir($path, &$ary){
		$dir_handle	= scandir($path);
		foreach ($dir_handle as $file){
			$files	= $path.'/'.$file;
			$files	= str_replace('./','',$files);
			if ($file!="." && $file!=".."){
				if (count($this->get_dir_ext)>0){
					$ext			= pathinfo(strtolower($files),PATHINFO_EXTENSION);
					if ($this->get_dir_num>0){
						$file_num	= explode('/',dirname($files));
						if (count($file_num)<=$this->get_dir_num){
							if (in_array($ext,$this->get_dir_ext)){
								$ary[$files] = $this->get_file($files);
							}
						}
					}else{
						if (in_array($ext,$this->get_dir_ext)){
							$ary[$files] = $this->get_file($files);
						}
					}
				}else {
					$ary[$files] = $this->get_file($files);
				}
			}
			if (is_dir($files) && $file!="." && $file!=".."){
				$this->get_dir($files,$ary);
			}
		}
	}
	
	/*
	*	获取文件或目录尺寸与权限
	*	$tpl->get_file('index.php');
	*/
	function get_file($files=''){
		if (!empty($files)){
			$result =  array(
					'name'	=> basename($files),
					'dir'	=> str_replace('./','',dirname($files).'/'),
					'size'	=> filesize($files),
					'chmod'	=> substr(sprintf('%o', fileperms($files)), -4),
					'type'	=> 'file',
				);
			$ext	= pathinfo(strtolower($files),PATHINFO_EXTENSION);
			if (!empty($ext)){
				$result['ext']	= $ext;
			}
			if (is_dir($files)){
				$result['type']	= 'folder';
				$result['dir']	= $files.'/';
			}
			$depth				= explode('/',dirname($files));
			$result['depth']	= (empty($result['dir']))?0:count($depth);
			return $result;
		}
	}
	
	/*
	*	建立目录
		dir_adds	目录地址支持递归创建
		mod			目录权限
	*	mk_dir('data/cache/test/pic/go');
	*/
	public function mk_dir($dirs='',$mod=0777){
		$falg = true;
		$dirs  = trim($dirs);
		if($dirs!=''){
			$dirs = str_replace(array('//','\\','\\\\'),'/',$dirs);
			if (!is_dir($dirs)){
				$temp = explode('/',$dirs);
				$cur_dir = '';
				for($i=0;$i<count($temp);$i++){
					$cur_dir .= $temp[$i].'/';
					if (!@is_dir($cur_dir)){
						if(@mkdir($cur_dir,$mod)){
							chmod($cur_dir,$mod);
						}else{
							$falg = false;
						}
					} 
				}
			}
			return $falg;
		}
	}


	/*
	*	删除目录及目录下所有文件
	*	del_dir(删除的路径,1表示删除目录下数据，0默认删除本目录);
	*/
	public function del_dir($dir_adds='',$del_def=0){
		$result		= false;
		$dir_adds	= str_replace('\\','/',$dir_adds);
		if(! is_dir($dir_adds)){
			return false;
		}
		$handle = opendir($dir_adds);
		while(($file = readdir($handle)) !== false){
			if($file != '.' && $file != '..'){
				$dir = $dir_adds . DIRECTORY_SEPARATOR . $file;
				is_dir($dir) ? $this->del_dir($dir) : unlink($dir);
			}
		}
		@closedir($handle);
		if($del_def==0){
			$result = @rmdir($dir_adds) ? true : false;
		}else {
			$result = true;
		}
		return $result;
	}


	/*
	*   得到当前毫秒时间
	*/
	public function get_time(){
		$t = explode(" ",microtime());
		return (float)$t['1'] + (float)$t['0'];
	}


	/*
	*   得到页面时间
		$length		显示结果长度，单位为秒
	*/
	public function run_time($length=4){
		return number_format(($this->get_time()-$this->start_time) ,$length);
	}


	/*
	*   获取当前内存占用率用于分析程序效率
	*/
	
	public function memory(){
		if(function_exists('memory_get_usage') ){
			$mem_size	= memory_get_usage();
			return ($mem_size < 1048576)?round($mem_size/1024,2)." kb":round($mem_size/1048576,2)." mb";
		}else {
			return '0 kb';
		}
	} 
	
	/*
	*   获取当前PHP版本
	*/
	function version(){
		return substr(PHP_VERSION,0,3);
	}
	
	/*
	*	引入模板系统
	*	察看当前使用的模板以及调试信息
	*	$mode 默认为直接显示，设置任意值将为return代码
	*/
	function inc_list($mode='print'){
			//清除缓存 START
			if(strrpos($_SERVER['REQUEST_URI'],'Ease_Templatepage=Clear')){
				if(file_exists($this->CacheDir)){
					$this->del_dir($this->CacheDir,1);
				}
				$EXTS = explode("/",$_SERVER['REQUEST_URI']);
				$Last = count($EXTS) -1;
				echo '<meta HTTP-EQUIV="refresh" CONTENT="0; URL='.urldecode( preg_replace_callback("/.+?REFERER=(.+?)!!!/",create_function('$m', 'return $m[1];'),$EXTS[$Last]) ).'">';
				exit;
			}
			//清除缓存 END

		if(is_array($this->FileDir)){
			$list_file		= array();
			$file_nums		= count($this->FileDir);
			$now_dir		= dirname($_SERVER['SCRIPT_FILENAME']).'/';
			if ($this->Copyright==0){
				//引用模板
				$list_file[] = "<tr><td colspan=\"2\" align=\"left\" bgcolor=\"#F7F7F7\"><font color='#475054' style='font-size:14px;'><b>".ET_E_tpl_file."</b></font><font color='#475054' style='font-size:11px;'>（引用模板：".count($this-> FileDir)." 个文件）</font></td></tr>";
				
				foreach($this->FileDir AS $K=>$V){
					$File_Size   = @round(@filesize($V.$K) / 1024 * 100) / 100 . 'KB';
					if(isset($_SERVER["PATH_INFO"])){
						if($this->WebURL!=''){
							$links	 = "<a title='".ET_E_open_file.$this->WebURL.$V.$K."' href='".$this->WebURL.$V.$K."' target='_blank'>";
						}
					}else {
						$links	 = "<a title='".ET_E_open_file.$this->WebURL.$V.$K."' href='".$this->WebURL.$V.$K."' target='_blank'>";
					}
					
					$list_file[] = "<tr><td colspan=\"2\" align=\"left\" bgcolor=\"#F7F7F7\">".$links."<font color='#00ABE3' style='font-size:14px;'>".$V.$K."</font></a><br>修改：".date('Y-m-d H:i ',@filemtime($V.$K))." <font color='#6F7D84' style='font-size:11px;'>大小：".$File_Size."</font></td></tr>";
				}
			}
			//引入php
			$list_file[] = "<tr><td colspan=\"2\" align=\"left\" bgcolor=\"#F7F7F7\"><font color='#475054' style='font-size:14px;'><b>".ET_E_inc_file."</b></font><font color='#475054' style='font-size:11px;'>（引用模板：".count(get_included_files())." 个文件）</font></td></tr>";
			foreach(get_included_files() AS $K=>$V){
				$File_Size   = @round(@filesize($V) / 1024 * 100) / 100 . 'KB';
				
				$list_file[] = "<tr><td colspan=\"2\" align=\"left\" bgcolor=\"#F7F7F7\"><font color='#00ABE3' style='font-size:14px;'>".str_replace($now_dir,'',str_replace('\\','/',$V))."</font></a><font color='#6F7D84' style='font-size:11px;'>&nbsp;&nbsp;".$File_Size."</font><br>修改：".date('Y-m-d H:i ',filemtime($V))." 执行：".date('Y-m-d H:i:s ').'<font color="#808000">'.substr(microtime(),0,5)."</font></td></tr>";
			}
			
			//路由连接地址
			if(isset($_SERVER["PATH_INFO"])){
				$BackURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];;
			}else{
				$BackURL = preg_replace_callback("/.+:(.+) in .+/is",create_function('$m', 'return $m[1];'),$_SERVER['REQUEST_URI']);
			}
			if(trim($BackURL)==''){
				$BackURL = 'index.php';
			}
			$NowPAGE	 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
			
			$clear_link  = $NowPAGE."?Ease_Templatepage=Clear&REFERER=".urlencode($BackURL)."!!!";
			$sf13		 = ' style="font-size:13px;color:#666666"';
			$result		 = '<br><table border="1" width="960" align="center" cellpadding="3" style="border-collapse: collapse" bordercolor="#DCDCDC">
<tr bgcolor="#B5BDC1"><td align="left"><a href="http://ET.FoundPHP.com" target="_blank"><font color=#000000 style="font-size:16px;"><b>'.ET_E_inc_tpl.'</a> [PHP Ver:'.$this->version().'] (Power by FoundPHP.com)</b></font></td>
<td align="right">';

if($this->RunType=='Cache'){
	$result.= '[<a onclick="alert(\''.ET_E_cache_del.'\');location=\''.$clear_link.'\';return false;" href="'.$clear_link.'"><font style="font-size:13px;color:#111">'.ET_E_clear_cache.'</font></a>]';
}

$result.= '</td></tr><tr><td colspan="2" bgcolor="#F7F7F7"><table border="0" width="100%" cellpadding="0" style="border-collapse: collapse">
<tr><td'.$sf13.'>'.ET_E_cache_id.' <b>'.substr($this->TplID,0,-1).'</b></td>
<td'.$sf13.'>'.ET_E_index.' <b>'.((count($this->FileList)==0)?'False':'True').'</b></td>
<td'.$sf13.'>'.ET_E_cache.' <b>'.($this->RunType=='MemCache'?'Memcache Engine':($this->RunType == 'Replace'?'Replace Engine':$this->CacheDir)).'</b></td>
<td'.$sf13.'>'.ET_E_template.' <b>'.$this->TemplateDir.'</b></td></tr>
<tr><td'.$sf13.'>'.ET_E_format.' <b>'.$this->Ext.'</b></td>
<td'.$sf13.'>'.ET_E_memory.' <b>'.$this->memory().'</b></td>
<td'.$sf13.'>'.ET_E_run_time.' <b>'.($this->start_time>0?$this->run_time().ET_E_second:ET_E_run_error).'</b></td>
<td'.$sf13.'>'.ET_E_support.' <b><a href="http://et.FoundPHP.com" target="_blank"><font color="#666666">ET.FoundPHP.com</font></a></b></td>
<td'.$sf13.'></td>
<td'.$sf13.'></td></tr>
</table></td></tr>'.implode("",$list_file)."</table><br>";
		}
		
		if($mode!='print'){
			return $result;
		}
		echo $result;
	}
}

?>