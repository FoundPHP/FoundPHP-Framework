<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/


class FP{
	public $dev_url	= 'http://tool.foundphp.com/?';
	public $appid	= 'FoundPHP.com';
	public $secret	= 'LFB-1234567890654321';
	
	function __construct($set= array('appid'=>'','secret'=>'')){
		$this->url	= $this->dev_url.'m=build&n='.$set['appid'].'&s='.$set['secret'];
	}
	
	function error($data){
		switch($data['errcode']){
			case 40001:
				msg('不合法的凭证类型或认证code过期');
			break;
			
			case 40002:
				msg('授权token出错或过期，请重新生成');
			break;
			
		}
		if ((int)$data['errcode']!=1){
			msg('系统验证失败，没有授权或服务器繁忙');
		}
	}
	
	//更新变量
	function update_var($content,$vars=''){
		if ($content){
			//拆分设置
			$vars_ex	= explode("\r\n\r\n",$vars);
			$vars_set	= explode("\n",trim($vars_ex[1]));
			//移除变量
			$content_s	= explode("基本变量 ========================\\",$content);
			$result		= $content_s[0]."基本变量 ========================\\";
			$content_e	= explode("\n\$t_index",$content_s[1]);
			$result		.= "\n".$vars_ex[0];
			$result		.= "\n\n\n\$t_index".$content_e[1];
			//替换变量
			foreach($vars_set AS $k=>$v) {
				$val		= explode("\t= ",$v);
				$pattern 	= "/\n".trim($val[0]).'.+=.+\n/';
				$replace	= "\n".trim($val[0])."\t\t= ".trim($val[1])."\n";
				switch(trim($val[0])){
					case '$t_index':
						$result= preg_replace("/\n\\\$t_index.+\n/",$replace,$result);
					break;
					case '$t_field':
						$result= preg_replace("/\n\\\$t_field.+\n/",$replace,$result);
					break;
					case '$t_where':
						$result= preg_replace("/\n\\\$t_where.+\n/",$replace,$result);
						$result= str_replace("&#39;","\'",$result);
						$result= str_replace("\'.","'.",$result);
						$result= str_replace(".\'",".'",$result);
						$result= str_replace("&quot;",'"',$result);
					break;
					case '$t_order':
						$result= preg_replace("/\n\\\$t_order.+\n/",$replace,$result);
					break;
					
				}
			}
			
			return $result;
		}
	}
	
	//获取变量
	function get_var($files=''){
		if (is_file($files)){
			$content	= $GLOBALS['tpl']->reader($files);
			//移除变量
			$content_s	= explode("基本变量 ========================\\",$content);
			$content_e	= explode("//======================== 逻辑处理",$content_s[1]);
			return base64_encode($content_e[0]);
		}
	}
	
	function show_sql(){
			if ($_SESSION['table']){
				$GLOBALS['t_index']		= ($_SESSION['ltable']['t_index']?$_SESSION['ltable']['t_index']:'');
				$GLOBALS['t_field']		= ($_SESSION['ltable']['t_field']?$_SESSION['ltable']['t_field']:'');
				$t_where				= ($_SESSION['ltable']['t_where']?$_SESSION['ltable']['t_where']:'');
				$t_order				= ($_SESSION['ltable']['t_order']?$_SESSION['ltable']['t_order']:'');
				$GLOBALS['table']['a']	= $_SESSION['ltable']['table'];
				foreach($_SESSION['table'] AS $k=>$v) {
					if ($v['a']!=''){
						$GLOBALS['table'][$k]	= $v['a'];
					}
					if ($v['ljoin']!=''){
						$GLOBALS['ljoin'][$k]	= $v['ljoin'];
					}
				}
			}
			
			
		$sql	= sql_select( array('sql'=>sql_join(),'where'=>$t_where,'order'=>$t_order, 'type' => 'sql') );
		$_SESSION['ltable']['sql']	= $sql;
		return $sql;
	}
	
	
	//默认页面
	function def($post=''){
		//获取数据
		$data	= json($GLOBALS['tpl']->curl($this->url.'&t=make',$post));
		return $data;
		
	}
	
	
	//数据库设计
	function sql($post=''){
		//获取数据
		$data	= json($GLOBALS['tpl']->curl($this->url.'&t=make_sql',$post));
		return $data;
		
	}
	
	
	//模块设计
	function model($post=''){
		//获取数据
		$data	= json($GLOBALS['tpl']->curl($this->url.'&t=model_set',$post));
		return $data;
		
	}
	
	
	
	//操作完成
	function success($post=''){
		$this->url.'&t=success';
		//获取数据
		$data	= json($GLOBALS['tpl']->curl($this->url.'&t=success',$post));
		return $data;
		
	}
	
	
	//获得所有数据库
	function table_all(){
	//	print_r($_SESSION['table']);
		foreach($_SESSION['table']['a'] AS $k=>$v) {
			if (isset($k) && isset($v)){
				$sel_table[$v]	= $v;
				$index[$v]	= $k;
			}
		}
		//print_r($_SESSION['table']['a']);
		//获得所有数据库
		$query = $GLOBALS['db']->query("SHOW TABLE STATUS");
		while($tl = $GLOBALS['db']->fetch_array($query)){
			$tname	= substr($tl['Name'],strlen($GLOBALS['config']['db']['pre']));
				$result['table'][]	= array(
						'name'		=>$tname,
						'comment'	=>$tl['Comment'],
						'nums'		=>$tl['Rows'],
					);
			//echo $tname."\r\n";
			//关联表
			if (in_array($tname,$sel_table)){
				$result['ltable'][]	= array(
						'name'		=>$tname,
						'index'		=>$index[$tname],
						'comment'	=>$tl['Comment'],
						'nums'		=>$tl['Rows'],
						);
			}
		}
		return $result;
	}
	
	//获得某个表的所有字段
	function table_field($table=''){
		if ($table){
			$query = $GLOBALS['db']->query('SHOW FULL COLUMNS FROM '.$GLOBALS['config']['db']['pre'].$table);
			while($tl = $GLOBALS['db']->fetch_array($query)){
				$result[] = array(
					'name'		=>$tl['Field'],
					'type'		=>$tl['Type'],
					'key'		=>($tl['Key']=='PRI' && $tl['Extra']=='auto_increment'?1:0),
					'comment'	=>($tl['Key']=='PRI' && $tl['Extra']=='auto_increment'?'主键自增':$tl['Comment']),
				);
			}
			return $result;
		}
	}
	
	
	//步骤样式设定
	function step_icon($type=0){
		$si_ary	= array(0=>'disabled',1=>'done',2=>'selected');
		return $si_ary[$type];
	}
	
	//表单样式
	//1input, 2radio, 3checkbox, 4select, 5file
	function step_input($type=0,$out=''){
		switch($type){
			//输入框
			case 1:
				$v			= $out[0];
				$result		= '<input type="text" maxlength="100" name="'.$v['id'].'" id="'.$v['id'].'" value="'.$v['v'].'"'.($v['r']==1?'required="required"':'').' class="form-control col-md-7 col-xs-12">';
			break;
			//单选
			case 2:
				$result		= '<div class="radio">';
				foreach($out AS $k=>$v) {
					$result.= '<label><input type="radio" class="flat"'.($v['sel']==1?' checked':'').' name="'.$v['id'].'" id="'.$v['id'].'" value="'.$v['v'].'"> '.$v['n'].'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
				$result		.= '</div>';
			break;
			//复选框
			case 3:
				$result		= '<div class="checkbox">';
				foreach($out AS $k=>$v) {
					$result.= '<label><input type="checkbox" class="flat"'.($v['sel']==1?' checked':'').' name="'.$v['id'].'" id="'.$v['id'].'" value="'.$v['v'].'"> '.$v['n'].'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
				$result		.= '</div>';
			break;
			//文本框
			case 4:
				$v			= $out[0];
				$result		= '<textarea rows="18"  name="'.$v['id'].'" id="'.$v['id'].'" cols="33"  class="form-control col-md-7 col-xs-12">'.$v['v'].'</textarea>';
			break;
			//显示文本
			case 5:
				$v			= $out[0];
				switch($v['r']){
					//列表页 列表与编辑
					case 5:
						$file_name	= $GLOBALS['config']['tpl']['TemplateDir'].'/'.$path.$v['v'].'.htm';
						$list_content	= ($GLOBALS['result']['tpl']['list']?$GLOBALS['result']['tpl']['list']:$content);
						$file_ls	= $file_name.' <font color="red">[缺失]</font><br><textarea rows="18"  name="tf['.$file_name.']" cols="33"  class="form-control col-md-7 col-xs-12" style="margin-bottom:20px;">'.$list_content.'</textarea>';
						
						$file_name	= $GLOBALS['config']['tpl']['TemplateDir'].'/'.$path.$v['v'].'_edit.htm';
						$edit_content	= ($GLOBALS['result']['tpl']['edit']?$GLOBALS['result']['tpl']['edit']:$content);
						$file_ls	.= $file_name.' <font color="red">[缺失]</font><br><textarea rows="18"  name="tf['.$file_name.']" cols="33"  class="form-control col-md-7 col-xs-12" style="margin-bottom:20px;">'.$edit_content.'</textarea>';
						$result		= '<div style="padding-top:7px;color:#999;">'.$file_ls.' </div>';
					break;
					
					//单页模板
					case 4:
						$file_name	= $path.$v['v'];
						$content	= $v['content'].$file_name;
						$file_ls	= $file_name.' <font color="red">[缺失]</font><br><textarea rows="18"  name="tf['.$file_name.']" cols="33"  class="form-control col-md-7 col-xs-12" style="margin-bottom:20px;">'.$content.'</textarea>';
						$result		= '<div style="padding-top:7px;color:#999;">'.$file_ls.' </div>';
					break;
					
					//影子模板检测
					case 3:
						$models		= dirname(str_replace('plugin/model/','',$v['v']));
						$modeln		= basename($GLOBALS['config']['tpl']['TemplateDir']);
						$path		= str_replace('/'.$modeln,'/'.$models,$GLOBALS['config']['tpl']['TemplateDir']).'/';
						$files		= explode('.',basename($v['v']));
						$ext		= basename($files['0']).'+';
						$file_ls	=  '<input name="old_m" value="'.trim($files['0']).'" type="hidden">';
						if(is_dir($path)){
							$p=opendir($path);
							while ($f=readdir($p))		{
								if ($f=="." || $f=="..") continue;
								
								if($ext!=''){
									if(mb_ereg($ext,$f)){
										$file_ck	= (is_file($path.$f)?' [存在]':' <font color="red">[缺失]</font>');
										//获取文件内容
										$content	= file_get_contents($path.$f);
										$content	= str_replace("search('".$files['0'],"search('".$GLOBALS['P']['a'],$content);
										//修复textarea方式
										$content	= str_replace("</textarea>","&lt;/textarea&gt;",$content);
										$file_ls	.= $path.$f.$file_ck.'<br><textarea rows="18"  name="tpl['.$path.$f.']" cols="33"  class="form-control col-md-7 col-xs-12" style="margin-bottom:20px;">'.$content.'</textarea>';
									}
								}
								
							}
						}
						$result		= '<div style="padding-top:7px;color:#999;">'.$file_ls.' </div>';
					break;
					
					//影子模板检测
					case 2:
						$path	= $GLOBALS['config']['tpl']['TemplateDir'].'/';
						$files	= explode('.',basename($v['v']));
						$ext	= basename($files['0']).'+';
						if(is_dir($path)){
							$p=opendir($path);
							while ($f=readdir($p))		{
								if ($f=="." || $f=="..") continue;
								
								if($ext!=''){
									if(mb_ereg($ext,$f)){
										//检测模版是否存在
										$nf			= str_replace($files['0'],$GLOBALS['P']['a'],$f);
										//$file_ck	= (is_file($path.$nf)?' [存在]':' <font color="red">[缺失]</font>');
										$file_ls	.= $path.$nf.$file_ck.'<br>';
									}
								}
								
							}
						}
						$result		= '<div style="padding-top:7px;color:#666;">'.$file_ls.' </div>';
					break;
					//PHP模块检测
					case 1:
						$file_check = (is_file($v['v'])?' [存在]':' <font color="red">[缺失]</font>');
						$result		= '<div style="padding-top:7px;color:#666;">'.$v['v'].$file_check.' </div>';
					break;
					default:
						$result		= '<div style="padding-top:7px;color:#999;">'.$v['v'].'</div>';
					
				}
			break;
		}
		echo $result;
	}
	
	
	function dir_list($dirs=''){
		if ($dirs){
			//自动获取前端的模块
			$handle = opendir ( $dirs );
			$i	= 0;
			while ( false !== ($f = readdir ( $handle )) ) {
				if ($f != "." && $f != "..") {
					if (is_dir($f)){
						return dir_list($dirs.$f);
					}else{
					//	echo ($f).'<br>';
						if ($i<=0){
							$select_file	= $f;
						}
						ob_start();
							include $get_dir.'/'.$f;
							echo $page_title;
							if($page_title){$name = ob_get_contents();}
						ob_end_clean();
						$alist[]		= array('val'=>substr($f,0,strrpos($f,'.')),'name'=>$name);
						return $alist;
					}
				}
			}
			//关闭句柄
			closedir ( $handle );
		}
	}
	
	function getdir($path,$set=''){
		$dir = opendir($path);
		while(($d = readdir($dir)) == true){
		//不让.和..出现在读取出的列表里
		if($d == '.' || $d == '..' || $d == 'index.htm' ){
		continue;
		}
			//判断如果是目录，继续读取
			if(is_dir($path.'/'.$d)){
				$lists = getdir($path.'/'.$d,$d);
				$result[$d] = $lists;
			}else{
					$model_r = $GLOBALS['tpl']->reader($path.'/'.$d);
					//print_r($model_r);
					preg_match_all('/\$title\s*=\s*lang\(\'(.*)\'\);\n/',$model_r,$r);
				if ($set==''){
		   		 	$result['default'][] = $d.' '.$r[1][0];
				}else{
		   		 	$result[] = $d.' '.$r[1][0];
					
				}
			}
			
		}
		return $result;
	}	
	
	
	
	
}