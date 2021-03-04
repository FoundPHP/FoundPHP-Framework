<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
$frame_data = '<?php
/*
AIP SYSTEM
BY SYSTN.COM
AUTHOR:TONSEN@SYSTN.COM
*/


//页头代码
head();





//提交地址
$form_adds	= $page_adds;

//模板文件
$tpl_file_name	= ($tpl_file_name!=\'\')?$tpl_file_name:$action;


//处理当前地址model下action页面
$tpl_obj->set_file($tpl_file_name,$tpl_mod_dir);	//设置模板文件

//页脚代码
foot($tpl_set[\'CacheDir\'].\'/\'.$model.\'/\');
?>';




?>