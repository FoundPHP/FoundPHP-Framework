<?php

//上传文件解密
$des_code		= explode('|',$FoundPHP_encrypt->decode($o,'FoundPHP'));
ob_start();
print_r($_FILES);
					$content = ob_get_contents();
ob_end_clean();	
$tpl->writer('a.txt',$content);
//声明编辑器
if (!$_FDEditor){
	$_FDEditor	= load('class/edit/edit','FoundPHP_edit',$config['edit']);
}



//编辑器权限检测
if ($des_code[0]!=strtolower($config['edit']['type'])){
	echo $_FDEditor->msg(0,array('msg'=>'抱歉，您的来源数据有问题'));
	exit;
}

//安全检测
$timeout	= time()-$des_code['2'];
if ($timeout>$config['edit']['timeout'] || (int)$des_code['2']==0){
	echo $_FDEditor->msg(0,array('msg'=>'抱歉，编辑器超时，请刷新页面重新提交'));
	exit;
}


switch($t){
	
	//文件管理
	case'manger':
		//管理照片
		echo $_FDEditor->manger($path);
		exit;
	break;
	
	//上传文件
	default:
		//上传文件
		if ($_FILES){
			$file_id	= $_FDEditor->get_id();
			//上传文件接收
			$files			= json($FoundPHP_upload->save(array(
				'id'		=> $file_id,				//表单提交元素名
				'json'		=> 1,						//json 输出
				'maxsize'	=> $config['edit']['size'],	//上传限制单位kb
				'dir'		=> $config['edit']['path'].($config['edit']['path_day']!=''?dates(time(),$config['edit']['path_day']).'/':''),	//存储路径
				'name'		=> dates(time(),'ymd_Hi').rand(1000,9999),				//存储路径
				'type'		=> $_FDEditor->get_type(),	//支持的格式
			)));
		ob_start();
		print_r($files);
			$content = ob_get_contents();
		ob_end_clean();	
		$tpl->writer('a1.txt',$content);

			//上传错误
			if ($files['code']==0 && $files['msg']!=''){
				echo $_FDEditor->msg(0,array('msg'=>$files['msg']));
				exit;
			}
			
			//上传成功
			if (is_file($files['dir'].$files['filename'])){
				echo $_FDEditor->msg(1,array('url'=>$files['dir'].$files['filename']));
				exit;
			}
			
		}
		
		//初始数据
		$_FDEditor->welcome();
}
exit;