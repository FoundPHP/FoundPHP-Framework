<?php
/*	(C)2005-2021 FoundPHP Development framework.
*	   name: AES DES Encrypt
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: 1.21.33
*	  start: 2013-05-24
*	 update: 2021-03-03
*	payment: 免费
*	This is not a freeware,use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
示例：
//压缩

//压缩文件与文件数组【支持目录】
$FoundPHP_zip->zip('foundphp.zip',array('index.php','admin.php'));


//解压缩
include 'plugin/class/foundphp/zip.php';
$zip	= new FoundPHP_zip();
//压缩文件与解压缩目录
$FoundPHP_zip->unzip('foundphp.zip','test/');

*/

class FoundPHP_zip{
	var $zip		= '';
	var $num		= 0;
	var $password	= '';
	var $lang		= array(
		'error_create'		=> '抱歉，文件无法建立或无法打开',
		'error_unzip'		=> '抱歉，没有打开压缩文件',
		'error_php5'		=> 'PHP5.2以上版本才可以执行压缩',
		'error_php7'		=> '设置密码需要PHP7.2及以上版本',
		'error_pass_empty'	=> '设置密码不能为空',
		'error_pass_set'	=> '设置密码失败',
		);
	function __construct($set=array()){
		if (PHP_VERSION<5.2){
			$error		= $this->lang['error_php5'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		$this->zip = new ZipArchive();
	}
	
	/* 设置密码
		pass	设置密码
	*/
	function password($pass=''){
		if (PHP_VERSION<7.2){
			$error		= $this->lang['error_php7'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		if (empty($pass)){
			$error		= $this->lang['error_pass_empty'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		$this->password	= $pass;
	}
	
	/* 压缩文件 7.0以下不支持中文
		zip		
		ary		可以支持目录或文件或文件数组
	*/
	function zip($zip='',$ary=''){
		global $tpl;
		if($this->zip->open($zip,ZIPARCHIVE::CREATE)!==TRUE){
			$error		= $this->lang['error_create'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		//设置密码
		if (!empty($this->password)){
			if (!$this->zip->setPassword($this->password)) {
				$error		= $this->lang['error_pass_set'];
				function_exists('foundphp_error')?foundphp_error($error):die($error);
			}
		}
		$result['num']	= 0;
		//检测类型['文件数组']
		if (is_array($ary)){
			foreach ($ary as $k => $v) {
				if (PHP_VERSION<7.1){
					$v		= iconv('UTF-8',(DIRECTORY_SEPARATOR == '/'?'UTF-8//IGNORE':'GBK//IGNORE'),$v);
				}
				if(is_file($v)){
					$result['num']++;
					if (PHP_VERSION<7.1){
						$result['file'][] = iconv((DIRECTORY_SEPARATOR == '/'?'UTF-8':'GBK'),'UTF-8//IGNORE',$v);
					}else{
						$result['file'][] = $v;
					}
					$this->zip->addFromString( $v, file_get_contents($v));//中文使用这个 
					if ($this->password){
						$this->zip->setEncryptionName($v, ZipArchive::EM_AES_256);
					}
				}
				if (is_dir($v)){
					$tpl->get_dir($v,$lists);
					asort($lists);
					foreach($lists AS $lk=>$lv) {
						if (PHP_VERSION<7.1){
							$lk		= iconv('UTF-8',(DIRECTORY_SEPARATOR == '/'?'UTF-8//IGNORE':'GBK//IGNORE'),$lk);
						}
						if (stristr($lk,'.')){
							$result['num']++;
							if (PHP_VERSION<7.1){
								$result['file'][] = iconv((DIRECTORY_SEPARATOR == '/'?'UTF-8':'GBK'),'UTF-8//IGNORE',$lk);
							}else{
								$result['file'][] = $lk;
							}
							$this->zip->addFile($lk);
							if ($this->password){
								$this->zip->setEncryptionName($lk, ZipArchive::EM_AES_256);
							}
						}
					}
				}
			}
		}
		$this->close();
		return $result;
	}
	
	/* 解压缩文件
		zip		
		dir		
	*/
	function unzip($zip='',$dir=''){
		global $tpl;
		if($this->zip->open($zip)!==TRUE){
			$error		= $this->lang['error_unzip'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		//设置密码
		if (!empty($this->password)){
			if (!$this->zip->setPassword($this->password)) {
				$error		= $this->lang['error_pass_set'];
				function_exists('foundphp_error')?foundphp_error($error):die($error);
			}
		}
		$result['num']	= 0;
		$dir			.= substr($dir,0-1)=='/'?'':'/';
		if(!is_dir($dir)){$tpl->mk_dir($dir);}
		$files	= $this->zip->numFiles;
		for($i	= 0; $i < $files; $i++){
			$get_info		= $this->zip->statIndex($i);
			//建立目录
			if (strstr($get_info['name'],'/')){
				$file_dir	= $dir.'/'.dirname($get_info['name']);
				//新建目录
				if(!is_dir($file_dir)){$tpl->mk_dir($file_dir);}
			}
		}
		
		for($i	= 0; $i < $files; $i++){
			$get_info		= $this->zip->statIndex($i);
			$filename		= $get_info['name'];
			//文件编码gbk 5.2、5.3、5.4、5.5
			//乱码文件
			if(strstr($filename,'.')) {
				$save_file	= $save_dir.$filename;
				if (PHP_VERSION<7.1){
				//	$save_file = iconv('UTF-8',(DIRECTORY_SEPARATOR == '/'?'UTF-8//IGNORE':'GBK//IGNORE'),$save_file);
				}
				$filename		= basename($filename);
				$save_dir	= dirname($get_info['name']).'/';
				$save_dir	= str_replace('./','',$save_dir);
				$this->zip->extractTo($dir,$save_file);
				if (is_file($dir.$save_file)){
					$result['num']++;
					$result['file'][] = $dir.$save_file;
				}
			}
		}
		
		$this->close();
		if (!empty($result['file'])){
			$result['num']	= count($result['file']);
		}
		return $result;
	}
	/*
		关闭文件链接
	*/
	function close(){
		$this->zip->close();//关闭
	}
}
?>