<?php
defined('FoundPHP.com') or die('access denied!');
/* ----------------------------- 基本设置 ----------------------------- */
$PATH				= './';							//当前目录
$PATH_RAND			= '';					//随机目录名安装时生成
$RAND_DIR			= 'data/FoundPHP_'.$PATH_RAND.'/';	//随机目录
$FILE_DIR			= 'data/files/';
$STYLE_DIR			= 'data/style/';
$CHARSET			= 'UTF-8';				//编码
$GZHANDLER			= 1;					//gzip压缩,开启压缩访问提速会占用cpu
$TIMEOUT			= 60;					//超时时长（单位秒）
$SLOG				= 1;					//系统安全日志
$LOG				= 1;					//系统日志
$DEVMODE			= 1;					//开发模式1开启,0关闭
$BUGLOG				= 1;					//错误日志
$DEBUG				= 1;					//调试平台
$TIME_FORMAT		= 'Y/m/d H:i';			//时间格式
$TIMEZONE			= 'PRC';				//时区设置
$PHPCCTIME			= '0';					//防止CC攻击小于一定时间则视为攻击，例如0.1秒
$PHPCCOUT			= 3;					//如果检查出攻击则延时一定时间时间为秒默认0
$PHPCCURL			= '';					//发现攻击可以跳转到别的网站
$BACKUP_PASS		= 'FoundPHP.com';		//数据备份密码
$TPLSTYLE			= 'default';			//默认样式
$GETSET				= 1;					//_GET数据接收限制开关
$FOUNDPHP_LANG		= 'zh';					//语言设置
$FoundPHP_Ver		= '1.2.6';					//安装版本

/* ----------------------------- COOKIE / SESSION设置 ----------------------------- */
$COOKIE_SHARE		= 1;					//开启域名共享cookie
$COOKIE_PATH		= '/';					//cookie路径
$COOKIE_DOMAIN		= '';					//cookie域名
$COOKIE_EXPIRE		= 86400;				//cookie有效时间
$COOKIE_SECURE		= 1;					//cookie通过HTTPS连接传给客户端
$SESSION_EXPIRE		= 86400;				//SESSION有效时间

$DISPLAY_ERROR		= 1;					//打开所有错误
$DISPLAY_NOTICE		= 1;

$config = array();
/* ----------------------------- 数据库设置 ----------------------------- */
$config['db']['dbtype']	 		= 'mysql';					//数据库类型php 5.4后请用mysqli
$config['db']['dbhost'] 		= '127.0.0.1';				//服务器地址
$config['db']['dbport'] 		= '3306';					//服务器端口
$config['db']['dbname'] 		= 'foundphp';					//数据库名
$config['db']['dbuser'] 		= 'root';					//账号
$config['db']['dbpass'] 		= 'root';					//密码
$config['db']['charset'] 		= 'utf8mb4';				//语言编码
$config['db']['cache'] 			= $RAND_DIR.'cache/';		//缓存目录
$config['db']['lang'] 			= $FOUNDPHP_LANG;			//语言
$config['db']['pre'] 			= 'fp_';						//数据库表头标识，多个项目在一个数据库中用于区分项目
if ($LOG){
$config['db']['sqllog'] 		= 'data/tmp_'.$PATH_RAND.'/log/';//sql语句日志
}

/* ----------------------------- 基本设置 ----------------------------- */
$config['foundphp']['appid'] 	= '';				//后台应用权限密钥
$config['foundphp']['secret'] 	= '';		//后台应用权限密钥

$config['encrypt']['type'] 		= 'aes';						//AES与DES
$config['encrypt']['key'] 		= 'www.FoundPHP.comwww.FoundPHP.com';					//对接密钥,AES为32位，DES为8位
$config['encrypt']['iv'] 		= 'www.FoundPHP.com';			//加密偏移值AES为16位，DES为8位

$config['file_size'] 			= '20000';						//上传限制单位kb
$config['file_ext'] 			= '*.pptx;*.ppt;*.doc;*.docx;*.mp4;*.mp3;*.xls;*.xlsx;*.zip;*.rar;*.pdf;*.png;*.jpeg;*.jpg;*.gif;*.cdr;*.ai;*.eps;*.psd;*.psb;*.dotx;';					//与其他网站对接密钥

$config['set']['host_id']		= 0;					//项目id

$config['set']['site_name']		= 'FoundPHP 建立的网站';
$config['set']['site_author']	= '';				//作者信息
$config['set']['site_key']		= '';					//网站关键词
$config['set']['site_desc']		= '';				//网站介绍

$config['set']['site_url'] 		= 'http://foundphp.com';	//网站首页
$config['set']['wx_url'] 		= 'http://wx.foundphp.com/';	//微信首页

$config['set']['limit']			= 20;							//默认分页数

$config['set']['allow_on']		= 1;								//允许跨域域名
$config['set']['allow_list']	= array('www.foundphp.com','FoundPHP.com');		//允许跨域域名
$config['set']['allow_model']	= array('profile','api');			//允许model名

/* ----------------------------- GET 入口设置 ----------------------------- */
$config['get']					= array('m','a','t','o','g','s','p','id','key','cid','token','n','code','state','path');


/* ----------------------------- 模板设置 ----------------------------- */
$config['tpl']['ID'] 			= '1';							//样式id
$config['tpl']['Style'] 		= 'default';					//样式地址

$config['tpl']['CacheDir']		= $RAND_DIR.'cache';				//缓存目录
$config['tpl']['HtmDir'] 		= 'data/html';					//静态化目录
$config['tpl']['TemplateDir']	= 'plugin/view/'.$TPLSTYLE;	//模板目录
$config['tpl']['LangDir']		= $RAND_DIR.'language';				//语言包目录
$config['tpl']['AutoImage']		= 1;							//自动解析照片
$config['tpl']['Compress']		= 0;							//压缩代码
$config['tpl']['Rewrite']		= 0;							//重写地址
$config['tpl']['Copyright']		= 'off';						//版权保护关闭
$config['tpl']['Language'] 		= $FOUNDPHP_LANG;				//语言


/* ----------------------------- 样式设置 ----------------------------- */
$style['go']['load'] 			= 1;
$style['go']['style']			= 8;
$style['go']['style_ary']		= array('bounce','center-atom','center-circle','material','center-radar','corner-indicator','loading-bar','center-simple','flash','flat-top','mac-osx','minimal'); 
$style['go']['setstyle']		= $style['go']['style_ary'][$style['go']['style']];
$style['go']['color']			= 8;
$style['go']['color_ary']		= array('black','white','silver','green','orange','pink','purple','red','blue','yellow'); 
$style['go']['setcolor']		= $style['go']['color_ary'][$style['go']['color']];

$style['lazy']['load']			= 1;
$style['lazy']['noscript']		= 0;
$style['lazy']['fadein']		= 1;
$style['lazy']['threshold']		= 300;
$style['lazy']['limit']			= 11;

/* ----------------------------- 微信设置 ----------------------------- */
$config['wx']['appid']			= '';					//绑定支付的APPID
$config['wx']['secret']			= '';					//公众帐号secert
$config['wx']['mchid']			= '';					//商户号
$config['wx']['key']			= '';					//商户支付密钥
$config['wx']['sslcert']		= getcwd()."/".$RAND_DIR.'cert/apiclient_cert.pem';//证书
$config['wx']['sslkey']			= getcwd()."/".$RAND_DIR.'cert/apiclient_key.pem';//证书
$config['wx']['log_file']		= $RAND_DIR."pay_logs/".date("Y-m-d").".txt";//日志记录文件
$config['wx']['dev']			= 1;				//开发者模式
$config['wx']['dev_token']		= 'FoundPHP';	//开发验证信息
$config['wx']['dev_asekey']		= '';	//开发验证信息
$config['wx']['dev_qrcode']		= '1';				//生成二维码的方式 1永久 0 临时
$config['wx']['cache']			= $RAND_DIR.'cache/';				//缓存目录
$config['wx']['url']			= 'https://www.foundphp.com/';	//微信网址
$config['wx']['subscribe']		= 0;								//订阅:1强制关注，0不强制
$config['wx']['qrcode']			= $RAND_DIR.'cert/qrcode.jpg';		//公众号二维码文件
$config['wx']['face_save']		= 0;								//头像是否保存
$config['wx']['face_dir']		= 'data/avatars/wechat/';			//头像保存地址



/* ----------------------------- 邮件设置 ----------------------------- */
$config['mail']['format']	= 'HTML';			//邮件格式 text 表示文本邮件
$config['mail']['port'] 	= 465;			//邮件端口
$config['mail']['check']	= true;			//身份验证	true验证 false不验证
$config['mail']['ssl']		= false;			//调试信息	true查看 false不看
$config['mail']['tls']		= false;			//调试信息	true查看 false不看
$config['mail']['debug']	= false;			//调试信息	true查看 false不看
$config['mail']['logs']		= true;			//记录日志 data/mail_log 目录下
$config['mail']['server'] 	= 'smtp.xxx.com';	//邮件SMTP服务器
$config['mail']['name']		= 'Service';			//收到邮件人看到的发件人名称
$config['mail']['from']		= 'admin@xxx.com';		//回复收件人邮件
$config['mail']['user']		= 'admin@xxx.com';		//认证用户名
$config['mail']['pass']		= '';				//密码

/* ----------------------------- 编辑器配置 ----------------------------- */
$config['edit']['type']			= 'mdeditor';		//text则为文本编辑器，mdeditor MarkDownEditor, kindeditor kind编辑器, ueditor 百度编辑器
$config['edit']['lang']			= $FOUNDPHP_LANG;	//支持的语言
$config['edit']['lang']			= 'zh';			//支持的语言
$config['edit']['php']			= 'index.php?a=upfile';		//上传文件路径
$config['edit']['timeout']		= '10800';			//编辑器3小时过期，单位秒
$config['edit']['size']			= '20480';			//上传文件尺寸单位KB
$config['edit']['file']			= 'jpg,gif';		//支持上传格式逗号,png
$config['edit']['path']			= 'data/files/edit/';	//存储路径
$config['edit']['path_day']		= 'y/m/d';				//存储日期方式，年月日Y/m/d/
$config['edit']['width']		= '100%';				//全局宽度
$config['edit']['height']		= '800';				//全局高度

/* ----------------------------- 语言包标识 ----------------------------- */
$config['translate']['type']	= 'baidu';								//翻译平台
$config['translate']['id']		= '';					//开发平台APPID
$config['translate']['key']		= '';				//开发平台密钥
$config['translate']['lang']	= $FOUNDPHP_LANG;						//提示语言

//默认中文包
$config['lang']['def']	= array(
						'en'	=> '英语',
						'zh'	=> '中文简体',
						'zht'	=> '中文繁体',
						'jp'	=> '日语',
						'kor'	=> '韩语',
						'de'	=> '德语',
						'fra'	=> '法语',
						'th'	=> '泰语',
						'spa'	=> '西班牙语',
						'ara'	=> '阿拉伯语',
						'ru'	=> '俄罗斯语',
);
//英语包
$config['lang']['en']	= array(
						'en'	=> 'English',
						'zh'	=> 'Chinese_simplified',
						'zht'	=> 'Chinese_traditional',
						'jp'	=> 'Japanese',
						'kor'	=> 'Korean',
						'de'	=> 'German',
						'fra'	=> 'French',
						'th'	=> 'Thai',
						'spa'	=> 'Spanish',
						'ara'	=> 'Arabic',
						'ru'	=> 'Russian',
);



