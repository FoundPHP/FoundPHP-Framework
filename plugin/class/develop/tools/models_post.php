<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
$model_data = '<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

//======================== 基本变量 ========================\\
//页面标题名称
$page_titles 	= \'页面标题\';

//模板文件 '.$tpl_mod_dir.'/'.($model=='default'?'':$model.'_').$action.'.'.$tpl_set['TplType'].'
$tpl_file_name	= '.($model=='default'?'':'$model.\'_\'.').'$action;


//======================== 逻辑处理 ========================\\
	
	//编辑新闻
	if ($id>0){
		$page_title = $page_titles.\' - 编辑\';
		
		//提交地址
		$form_adds	= $page_adds.\'&todo=update&id=\'.$id;
		
		//获取数据
		$info	= {table_tab}->get_info($id);
		
		if($info[id]!=$id){
			msg("抱歉，您访问地址存在错误!");
		}
		
		
	}else{
		$page_title = $page_titles.\' - 添加\';

		$form_adds	= $page_adds.\'&todo=update\';
	}
	
	
	
		//添加数据
		if($todo==\'update\'){
		//过滤空格
		$_POST[\'subject\'] = trim($_POST[\'subject\']);
		$_POST[\'content\'] = trim($_POST[\'content\']);
		
		
		//提交数据批量过滤（检测是否为空）
			$error = post_check(
				array(
					array(
						\'name\'=>\'标题\',
						\'data\'=>$_POST[\'subject\']
					),
					array(
						\'name\'=>\'内容\',
						\'data\'=>$_POST[\'content\']
					),
				)
			);



			//没有错误则写入数据
			if(!$error){
				//插入数据
				$data = array(
							\'subject\'=>$_POST[\'subject\'],
							\'content\'=>$_POST[\'content\'],
						);
				
				
				//编辑资料
				if ($id>0 && is_array($info)){
					//修改日期
					$data[\'dates\']		= strtotime($_POST[\'dates\']);
					if($data[\'dates\']==\'\'){
						$data[\'dates\']	= time();
					}
					if ({table_tab}->update($data,"id=\'$id\'")){
						msg(\'恭喜，操作数据成功!\',$page_adds.\'&id=\'.$id,3);			//编辑成功后3秒跳转
					}else {
						msg(\'操作数据失败!\');
					}
				}
				
				
				//发布
				if ($id==0){
					//插入数据补充
					$data[\'dates\']	= time();
					
					//重复效验数据
					$check	= array(
								\'subject\'=>$subject,
							);
					
					//插入数据
					if ({table_tab}->insert($data,$check)){
						
						$id = $db_obj->insert_id();
						
						msg(\'恭喜，操作数据成功!\',$page_adds,3);
					}else{
						msg(\'操作数据失败,或已经存在!\');
					}
				}
				
			}else{
				msg(\'操作数据失败!\');
			}
		}
	


?>';

?>