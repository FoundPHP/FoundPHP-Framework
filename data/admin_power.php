<?php
/*	(C)2005-2020 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	作者：孟大川
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.FoundPHP.com/agreement
*/

//模块权限名称
$_sys_pn =array('renew'=>'更新','translate'=>'翻译','transfer'=>'移动','share'=>'分享','recovery'=>'恢复','manual'=>'手册','auit'=>'审核','power'=>'权限','operation'=>'操作','album'=>'相册','score'=>'评分','edit_myself'=>'资料修改','export_data'=>'批量导出','cate'=>'添加类别','file_list'=>'上传文件','print'=>'打印','password'=>'密码修改','edit'=>'编辑','add'=>'添加','del'=>'删除','view'=>'查看','search'=>'搜索','download'=>'下载','up'=>'上移','down'=>'下移','preview'=>'预览','title'=>'标题修改','import'=>'导入','export'=>'导出','bdel'=>'批量删除');


//模块功能列表
$_sys_menu = array(
array('cate_id'=>38,'host_id'=>0,'mid'=>0,'fid'=>37,'cate_name'=>'管理员权限组','cate_title'=>'','language'=>'admin_group','cate_desc'=>array('add','edit','del','view','search'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>39,'host_id'=>0,'mid'=>0,'fid'=>37,'cate_name'=>'管理员列表','cate_title'=>'','language'=>'admin_user','cate_desc'=>array('add','edit','del','search'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>40,'host_id'=>0,'mid'=>0,'fid'=>37,'cate_name'=>'管理操作记录','cate_title'=>'','language'=>'admin_log','cate_desc'=>array('del','search'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>510,'host_id'=>0,'mid'=>0,'fid'=>509,'cate_name'=>'文章列表','cate_title'=>'','language'=>'articles_list','cate_desc'=>array('add','edit','del','view','search','bdel'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1685,'host_id'=>0,'mid'=>0,'fid'=>509,'cate_name'=>'文章分类','cate_title'=>'','language'=>'articles_cate','cate_desc'=>array('add','edit','del'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1689,'host_id'=>0,'mid'=>0,'fid'=>509,'cate_name'=>'文章关键词','cate_title'=>'','language'=>'articles_keyword','cate_desc'=>array('add','edit','del'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1727,'host_id'=>0,'mid'=>0,'fid'=>37,'cate_name'=>'FoundPHP公告','cate_title'=>'','language'=>'found_notice','cate_desc'=>array('add','edit','del','search'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1728,'host_id'=>0,'mid'=>0,'fid'=>37,'cate_name'=>'FoundPHP公告类型设置','cate_title'=>'','language'=>'found_notice_set','cate_desc'=>array('add','edit','del'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1865,'host_id'=>0,'mid'=>0,'fid'=>0,'icon'=>'fa fa-connectdevelop','cate_name'=>'应用中心','cate_title'=>'','language'=>'app','cate_desc'=>array('view'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1866,'host_id'=>0,'mid'=>0,'fid'=>1865,'cate_name'=>'开发者认证','cate_title'=>'','language'=>'app_auth','cate_desc'=>array('edit','view'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1867,'host_id'=>0,'mid'=>0,'fid'=>1865,'cate_name'=>'应用商城','cate_title'=>'','language'=>'app_store','cate_desc'=>array('add','edit','del'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1868,'host_id'=>0,'mid'=>0,'fid'=>1865,'cate_name'=>'我设计的模块','cate_title'=>'','language'=>'app_model','cate_desc'=>array('add','edit','del','view','search'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>36,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'后台功能管理','cate_title'=>'','language'=>'sys_action','cate_desc'=>array('add','edit','del','up','down'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>35,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'功能权限设定','cate_title'=>'','language'=>'sys_action_name','cate_desc'=>array('add','edit','del','search'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>32,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'网站核心设置','cate_title'=>'','language'=>'sys_set','cate_desc'=>array('edit'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>33,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'样式特效设置','cate_title'=>'','language'=>'sys_style','cate_desc'=>array('edit'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1696,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'前台功能设置','cate_title'=>'','language'=>'sys_web_action','cate_desc'=>array('add','edit','del','up','down'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1726,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'多语言设置','cate_title'=>'','language'=>'sys_language','cate_desc'=>array('add','edit','del'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1863,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'多语言翻译','cate_title'=>'','language'=>'sys_language_translate','cate_desc'=>array('renew','translate'),'cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>34,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'数据库备份','cate_title'=>'','language'=>'sys_backup','cate_desc'=>'','cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>1776,'host_id'=>0,'mid'=>0,'fid'=>31,'cate_name'=>'系统首页','cate_title'=>'','language'=>'default','cate_desc'=>'','cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>31,'host_id'=>0,'mid'=>0,'fid'=>0,'icon'=>'fa fa-cogs','cate_name'=>'系统设置','cate_title'=>'','language'=>'sys','cate_desc'=>'','cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>37,'host_id'=>0,'mid'=>0,'fid'=>0,'icon'=>'fa fa-users','cate_name'=>'系统管理','cate_title'=>'','language'=>'admin','cate_desc'=>'','cate_pic'=>'','numbers'=>0,'reader'=>0,'lockout'=>1,'ins_time'=>0,'update_time'=>0),
array('cate_id'=>509,'host_id'=>0,'mid'=>0,'fid'=>0,'icon'=>'fa fa-archive','cate_name'=>'文章管理','cate_title'=>'','language'=>'article','cate_desc'=>'','cate_pic'=>'','numbers'=>0,'reader'=>0,'ins_time'=>0,'update_time'=>0)
);
$_sys_file = array(

);