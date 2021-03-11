<?php
$title		= lang('安装完成');
chdir('../');
if(!is_file('data/install.lock')){
	$tpl->writer('data/install.lock');
}
if (!is_dir($RAND_DIR)){
	if (mkdir($RAND_DIR)){
		mkdir($RAND_DIR.'/cache');
		mkdir($RAND_DIR.'/log');
		mkdir($RAND_DIR.'/language');
		mkdir($RAND_DIR.'/backup');
	}
}
chdir('install');
$tpl->set_file('finish');	//设置模板
$tpl->p();
?>