<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/
defined('FoundPHP.com') or die('access denied!');

//引入权限
load('function/power');
//======================== 基本变量 ========================\

$table['a']		= 'admin_user';				//表名
$table['b']		= 'admin_group';			//表名
$ljoin['b'] 	= "b.id=a.gid";				//关联

$t_index		= 'id';						//索引id
$t_field		= 'a.*,b.names';			//字段
$t_where		= "";						//条件
$t_order		= 'a.'.$t_index.' ASC';	//排序

//添加用户时的时间与ip
$reg_date		= time();
$reg_ip			= get_ip();
//======================== 逻辑处理 ========================\

//数据套入数据库表，多个表写入则列入多个数据
$insert[$table['a']]	= array(
					
					'password'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[密码]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'code'		=> 'md5',					//md5或base64  对数据编码
						'long'		=> '5,20',						//字符长度6表示最小字符，6,20标识6-20位长度
						'req'		=> "add",					//必填
						't'			=> ($t=='password'?"add,edit":''),
					),
					'nickname'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[用户姓名]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> "add",				//必填
						't'			=> ($t=='edit_myself'?"add,edit":''),
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'email'	=> array(					//提交内容
						'lang'		=> lang('抱歉，没有输入[邮箱地址]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "mail",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						't'		=> ($t=='edit_myself'?"add,edit":''),
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'phone'	=> array(
						'lang'		=> lang('抱歉，没有输入[手机/电话]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'		=> ($t=='edit_myself'?"add,edit":''),
						'search'	=> 'like',				//搜索数据1表示等于，like表示模糊搜索
					),
					'face'	=> array(
						'lang'		=> lang('抱歉，没有输入[头像]或格式不对'),
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						'check'		=> "==''",					//拦截条件!=不为，==，mail邮箱检测 不要输入空格,mobile手机号检测
						'req'		=> ($t=='edit_myself'?"add,edit":''),					//必填
						't'		=> ($t=='edit_myself'?"add,edit":''),
					),
					'position'	=> array(
						'ope'		=> 'trim',					//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'			=> ($t=='edit_myself'?"add,edit":''),
					),
					'gender'	=> array(
						'ope'		=> 'intval',				//trim 去空，boolval布尔值,intval整数值，floatval 浮点值
						't'		=> ($t=='edit_myself'?"add,edit":''),
					),
					
				);


//通用添加与编辑
if ($P['o']) {
    //上传文件接收
    $files = $FoundPHP_upload -> save(array(
    'id' 		=> 'attach', //表单提交元素名
    'maxsize' 		=> '4000', //上传限制单位kb
    'width' 		=> '400', //宽度 仅对图像有效 宽高必须同时赋值
    'height' 		=> '400', //高度 仅对图像有效 宽高必须同时赋值
    'dir' 		=> 'data/avatars/admin/' . dates(time(), 'Ym') . '/', //存储路径
    'name'		=> $aus['id'], //存储路径
    'type'		=> array('jpg','png','jpeg'),	//支持的格式
  ));
    if ($files['filename']) {
	$thumbnail = $files['dir'] . $files['filename'];
    }

}




//操作处理
switch($t){
	
	//编辑
	case'edit_myself':
		
		$title	   = lang('资料修改');
		$id		   = $aus['id'];
		//查询数据
		$data_info = sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}

		
		//提交数据
		if ($P['o']){
			$t	  = 'edit';
			if($files['filename']){
				$P['face'] =  dates(time(), 'Ym') . '/'.$files[filename];
			}else{
				$P['face'] =  $data_info['face'];
			}
			
			//数据检测
			$post = post_data($table['a'],$insert);
		
			sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>($t_where?$t_where.' AND ':'')."$t_index='$id'"));
			msg('', $page_url.'&g=success');
		}
		
		if($o == 'del'){
			$faces = explode('/',$data_info['face']);
			$filedir = "data/avatars/admin";
			del_file($filedir.'/'.$faces[0].'/',$faces[1]);
			$face_ary = array('face'=>'');
			sql_update_insert( array('table' =>$table['a'],'data' =>$face_ary,'where' =>($t_where?$t_where.' AND ':'')."$t_index='$id'"));
			msg('', $page_url.'&g=del');
		}
		
		
		//释放字段为变量
		extract($data_info);
		
		//权限组
		$sql 		= sql_select( array('table'=> $table['b'], 
											'order'=> " id ASC", 
											'type' => 'sql')
								);
		$query		= $db->query($sql);
		//性别选择
		$gender_ck 	= 'gender_ck'.$gender;
		$$gender_ck 	= 'checked';
		$tpl_file		= 'my_edit_myself';
	break;
	
	
	case'password':
		$title	   = lang('密码修改');
		$id		   = $aus['id'];
		//查询数据
		$data_info = sql_select( array('table'=>$table['a'], 'where'=>($t_where?$t_where.' AND ':'')."$t_index='$id'") );
		
		if($data_info[$t_index]!= $id || $id<=0){
			msg($page_msg['url_error']);
		}

		
		//提交数据
		if ($P['o']){
			if(strlen(trim($P['opassword'])) >= 5 && strlen(trim($P['password'])) >= 5){
				$t	  = 'edit';
				//验证旧密码是否正确
				if(md5($P['opassword']) == $data_info['password']){
					//数据检测
					$post = post_data($table['a'],$insert);
					sql_update_insert( array('table' =>$table['a'],'data' =>$post['data'],'where' =>"id = '$aus[id]'"));
					msg('',"?a=my_info&t=password&g=success");
				}else{
					msg('原密码错误，不能修改密码',$post_url,3);
				}
			}else{
				msg('密码少于5个字符',"?a=my_info&t=password",3);
			
			}
		}
		
		
		//释放字段为变量
		extract($data_info);
		$tpl_file		= 'my_edit_password';
	break;
	
	
	default:
		//搜索
		$t_where	= search_where($set_search,30);
		//排序
		$t_order	= search_order($t_order);
		
		
		
		//数据列表
		$sql		= sql_select( array('sql'=>sql_join(),'where'=>$t_where['text'],'order'=>$t_order, 'type' => 'sql') );
		$data_info	= limit($sql,$config['set']['limit']);
		$pages		= pages($data_info['info']);
}


?>