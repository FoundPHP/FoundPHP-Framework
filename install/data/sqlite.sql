DROP TABLE IF EXISTS "{[FoundPHP]}admin_group";
CREATE TABLE "{[FoundPHP]}admin_group" (
  "agid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "host_id" integer(11),
  "names" text(50) NOT NULL,
  "master" text(255),
  "master_id" text(255),
  "nums" integer(11),
  "power" text,
  "power_num" integer(11),
  "intro" text(255),
  "dateline" integer(11)
);

INSERT INTO "{[FoundPHP]}admin_group" VALUES (1, 0, '超级管理员', '', '', 3, 'master', 0, '系统超级管理员组', 0);

DROP TABLE IF EXISTS "{[FoundPHP]}admin_user";
CREATE TABLE "{[FoundPHP]}admin_user" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "host_id" integer(11),
  "fid" integer(11),
  "son" integer(11),
  "gid" integer(11) NOT NULL,
  "lang" text(10) NULL,
  "username" text(40) NOT NULL,
  "password" text(32) NOT NULL,
  "nickname" text(60) NOT NULL,
  "gender" integer(1),
  "email" text(80),
  "phone" text(20),
  "position" text(60),
  "face" text(100),
  "states" integer(11),
  "my_power" text,
  "operate" text(255),
  "last_operate" text(255),
  "state_date" integer(11),
  "login_num" integer(11) NOT NULL,
  "reg_date" integer(11) NOT NULL,
  "reg_ip" text(15) NOT NULL,
  "last_date" integer(10),
  "last_ip" text(15)
);

INSERT INTO "{[FoundPHP]}admin_user" VALUES (1, 0, 0, 0, 1, '{[FoundPHP_us]}', '{[FoundPHP_pw]}', 'FoundPHP 大师', 0, '{[FoundPHP_email]}', '', '超级管理员', '', 1, '', '', '', 0, 0, {[FoundPHP_date]}, '{[FoundPHP_ip]}', {[FoundPHP_date]}, '{[FoundPHP_ip]}');


DROP TABLE IF EXISTS "{[FoundPHP]}articles";
CREATE TABLE "{[FoundPHP]}articles" (
  "aid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "uid" integer(11) NOT NULL,
  "cate_id" integer(11) NOT NULL,
  "page_id" integer(10),
  "lang" text(10) NULL,
  "titles" text(255),
  "pinyin" text(255),
  "smarty_title" text(255),
  "keywords" text(255),
  "description" text,
  "result" text,
  "thumbnail" text(255),
  "pagekey" text(60),
  "pageurl" text(255),
  "author" text(60),
  "editor" text(60),
  "cases" text(60),
  "date_add" integer(10),
  "date_edit" integer(10),
  "valid" integer(1),
  "views" integer(10)
);

INSERT INTO "{[FoundPHP]}articles" VALUES (1, 1, 1687, NULL,'zh', '欢迎来到FoundPHP 开发世界', NULL, 'FoundPHP 框架是非常优秀的PHP开发框架', '', 'FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架。', '', '', '', 'http://www.foundphp.com', 'Admin', '', 'phpcourse', 1612411395, 1612411515, 0, 1);

DROP TABLE IF EXISTS "{[FoundPHP]}article_data";
CREATE TABLE "{[FoundPHP]}article_data" (
  "adid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "cate_id" integer(10),
  "aid" integer(10),
  "uid" integer(10),
  "lang" text(10) NULL,
  "cases" text(60) NOT NULL,
  "subject" text(255) NOT NULL,
  "content" text,
  "md_content" text,
  "cache" text,
  "author" text(255),
  "dateline" integer(10),
  "page_num" integer(5)
);

INSERT INTO "{[FoundPHP]}article_data" VALUES (1, 1687, 1, 1, 'zh','phpcourse', 'FoundPHP 为你的梦想加油！', '<h1 id=&quot;h1--foundphp-&quot;><a name=&quot;欢迎来到FoundPHP 开发世界&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>欢迎来到FoundPHP 开发世界</h1><p>FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架，用简单的方法为您实现最实用、最稳定的开发平台。</p>
<p>FoundPHP 自带多级系统权限、组织架构、系统管理、调试平台、自动开发、自动完成、AI代码修正、自动升级等功能无需开发，直接使用。</p>
<p>FoundPHP 在线AI自动化写代码、可视化系统开发，设计思维导图即可实现75％的功能代码，降低成本并提高质量，更快速的开发系统的方法。</p>
<p><code>你的作品就是我们最满意的答卷，感谢您加入我们的大家庭。</code></p>
<p>官方网址：<a href=&quot;http://www.foundphp.com&quot;>http://www.foundphp.com</a></p>
<p>开发者：<a href=&quot;http://dev.foundphp.com&quot;>http://dev.foundphp.com</a></p>
<p>FoundPHP Group<br>2021年</p>', '# 欢迎来到FoundPHP 开发世界

FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架，用简单的方法为您实现最实用、最稳定的开发平台。

FoundPHP 自带多级系统权限、组织架构、系统管理、调试平台、自动开发、自动完成、AI代码修正、自动升级等功能无需开发，直接使用。

FoundPHP 在线AI自动化写代码、可视化系统开发，设计思维导图即可实现75％的功能代码，降低成本并提高质量，更快速的开发系统的方法。

`你的作品就是我们最满意的答卷，感谢您加入我们的大家庭。`

官方网址：http://www.foundphp.com

开发者：http://dev.foundphp.com

FoundPHP Group
2021年', NULL, 'Admin', 1612411395, 0);

DROP TABLE IF EXISTS "{[FoundPHP]}article_vote";
CREATE TABLE "{[FoundPHP]}article_vote" (
  "avid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "uid" integer(11) NOT NULL,
  "aid" integer(11) NOT NULL,
  "vote_type" integer(11) NOT NULL,
  "vote_name" integer(11) NOT NULL,
  "vote_color" integer(11) NOT NULL,
  "vote_num" integer(11) NOT NULL,
  "dateline" integer(11) NOT NULL
);

DROP TABLE IF EXISTS "{[FoundPHP]}article_vote_logs";
CREATE TABLE "{[FoundPHP]}article_vote_logs" (
  "avlid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "aid" integer(11) NOT NULL,
  "avid" integer(11) NOT NULL,
  "uid" integer(11) NOT NULL,
  "dateline" integer(11) NOT NULL,
  "ip" text(15)
);


DROP TABLE IF EXISTS "{[FoundPHP]}articles_likes";
CREATE TABLE "{[FoundPHP]}articles_likes" (
  "alid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "types" integer(11) NOT NULL,
  "aid" integer(11) NOT NULL,
  "uid" integer(11) NOT NULL,
  "dateline" integer(11) NOT NULL,
  "ip" text(30)
);

DROP TABLE IF EXISTS "{[FoundPHP]}articles_relation";
CREATE TABLE "{[FoundPHP]}articles_relation" (
  "arid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "types" integer(11) NOT NULL,
  "genres" text(20) NOT NULL,
  "aid" integer(11) NOT NULL,
  "rid" integer(11) NOT NULL,
  "dateline" integer(11) NOT NULL
);

DROP TABLE IF EXISTS "{[FoundPHP]}bulletin";
CREATE TABLE "{[FoundPHP]}bulletin" (
  "bid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "genre" integer(11) NOT NULL,
  "titles" text(255) NOT NULL,
  "contents" text NOT NULL,
  "post_uid" integer(11) NOT NULL,
  "post_date" integer(11) NOT NULL,
  "post_ip" text(15)
);

INSERT INTO "{[FoundPHP]}bulletin" VALUES (1, 1729, '开始FoundPHP世界', '加入FoundPHP的世界，让你在php的世界里畅游。', 1, 1582879687, '127.0.0.1');

DROP TABLE IF EXISTS "{[FoundPHP]}category";
CREATE TABLE "{[FoundPHP]}category" (
  "cate_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "host_id" integer(11),
  "mid" integer(10),
  "fid" integer(11),
  "icon" text(50),
  "types" text(30) NOT NULL,
  "cate_name" text(100) NOT NULL,
  "cate_title" text(255),
  "language" text(255),
  "cate_desc" text,
  "cate_url" text(255),
  "cate_pic" text(255),
  "linkto" text(255),
  "numbers" integer(11),
  "reader" integer(10),
  "shows" integer(1),
  "orders" integer(10),
  "lockout" integer(1),
  "ins_time" integer(10),
  "update_time" integer(10)
);

INSERT INTO "{[FoundPHP]}category" VALUES (4, 0, 0, 0, '', 'sys_model_name', 'add', '', NULL, '添加', '', '', 0, 0, 0, 0, 37, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (6, 0, 0, 0, '', 'sys_model_name', 'edit', '', NULL, '编辑', '', '', 0, 0, 0, 0, 36, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (7, 0, 0, 0, '', 'sys_model_name', 'del', '', NULL, '删除', '', '', 0, 0, 0, 0, 38, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (8, 0, 0, 0, '', 'sys_model_name', 'view', '', NULL, '查看', '', '', 0, 0, 0, 0, 39, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (9, 0, 0, 0, '', 'sys_model_name', 'search', '', NULL, '搜索', '', '', 0, 0, 0, 0, 40, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (10, 0, 0, 0, '', 'sys_model_name', 'download', '', NULL, '下载', '', '', 0, 0, 0, 0, 41, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (11, 0, 0, 0, '', 'sys_model_name', 'up', '', NULL, '上移', '', '', 0, 0, 0, 0, 42, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (12, 0, 0, 0, '', 'sys_model_name', 'down', '', NULL, '下移', '', '', 0, 0, 0, 0, 43, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (13, 0, 0, 0, '', 'sys_model_name', 'preview', '', NULL, '预览', '', '', 0, 0, 0, 0, 44, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (14, 0, 0, 0, '', 'sys_model_name', 'title', '', NULL, '标题修改', '', '', 0, 0, 0, 0, 45, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (15, 0, 0, 0, '', 'sys_model_name', 'import', '', NULL, '导入', '', '', 0, 0, 0, 0, 46, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (16, 0, 0, 0, '', 'sys_model_name', 'export', '', NULL, '导出', '', '', 0, 0, 0, 0, 47, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (18, 0, 0, 0, '', 'sys_model_name', 'bdel', '', NULL, '批量删除', '', '', 0, 0, 0, 0, 48, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (31, 0, 0, 0, 'fa fa-cogs', 'sys_menu', '系统设置', '', 'sys', '', '', '', 0, 0, 0, 1, 32, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (32, 0, 0, 31, '', 'sys_menu', '网站核心设置', '', 'sys_set', '["edit"]', '', '', 0, 0, 0, 1, 3, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (33, 0, 0, 31, '', 'sys_menu', '样式特效设置', '', 'sys_style', '["edit"]', '', '', 0, 0, 0, 1, 4, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (34, 0, 0, 31, '', 'sys_menu', '数据库备份', '', 'sys_backup', '', '', '', 0, 0, 0, 1, 8, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (35, 0, 0, 31, '', 'sys_menu', '功能权限设定', '', 'sys_action_name', '["add","edit","del","search"]', '', '', 0, 0, 0, 1, 2, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (36, 0, 0, 31, '', 'sys_menu', '后台功能管理', '', 'sys_action', '["add","edit","del","up","down"]', '', '', 0, 0, 0, 1, 1, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (37, 0, 0, 0, 'fa fa-users', 'sys_menu', '系统管理', '', 'admin', '', '', '', 0, 0, 0, 1, 33, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (38, 0, 0, 37, '', 'sys_menu', '管理员权限组', '', 'admin_group', '["add","edit","del","view","search"]', '', '', 0, 0, 0, 1, 0, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (39, 0, 0, 37, '', 'sys_menu', '管理员列表', '', 'admin_user', '["add","edit","del","search"]', '', '', 0, 0, 0, 1, 0, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (40, 0, 0, 37, '', 'sys_menu', '管理操作记录', '', 'admin_log', '["del","search"]', '', '', 0, 0, 0, 1, 0, 1, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (73, 0, 0, 0, '', 'sys_model_name', 'password', '', NULL, '密码修改', '', '', 0, 0, 0, 0, 35, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (394, 0, 0, 0, '', 'sys_model_name', 'export_data', '', NULL, '批量导出', '', '', 0, 0, 0, 0, 28, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (397, 0, 0, 0, '', 'sys_model_name', 'edit_myself', '', NULL, '资料修改', '', '', 0, 0, 0, 0, 27, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (403, 0, 0, 0, '', 'sys_model_name', 'cate', '', NULL, '添加类别', '', '', 0, 0, 0, 0, 29, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (404, 0, 0, 0, '', 'sys_model_name', 'file_list', '', NULL, '上传文件', '', '', 0, 0, 0, 0, 30, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (509, 0, 0, 0, 'fa fa-archive', 'sys_menu', '文章管理', '', 'article', '', '', '', 0, 0, 0, 1, 34, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (510, 0, 0, 509, '', 'sys_menu', '文章列表', '', 'articles_list', '["add","edit","del","view","search","bdel"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (597, 0, 0, 0, '', 'sys_model_name', 'score', '', NULL, '评分', '', '', 0, 0, 0, 0, 26, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (600, 0, 0, 0, '', 'sys_model_name', 'print', '', NULL, '打印', '', '', 0, 0, 0, 0, 31, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (935, 0, 0, 0, '', 'sys_model_name', 'operation', '', NULL, '操作', '', '', 0, 0, 0, 0, 24, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1100, 0, 0, 0, '', 'sys_model_name', 'album', '', NULL, '相册', '', '', 0, 0, 0, 0, 25, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1148, 0, 0, 0, '', 'sys_model_name', 'transfer', '', NULL, '移动', '', '', 0, 0, 0, 0, 1, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1685, 0, 0, 509, '', 'sys_menu', '文章分类', '', 'articles_cate', '["add","edit","del"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1686, 0, 0, 0, '', 'article_cate', 'FoundPHP', '', NULL, '', '', '', 0, 0, 0, 0, 23, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1687, 0, 0, 1686, '', 'article_cate', '入门', '', NULL, '', '', '', 0, 0, 0, 0, 2, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1688, 0, 0, 1686, '', 'article_cate', '熟练', '', NULL, '', '', '', 0, 0, 0, 0, 3, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1689, 0, 0, 509, '', 'sys_menu', '文章关键词', '', 'articles_keyword', '["add","edit","del"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1692, 0, 0, 0, '', 'articles_keyword', 'php', '', NULL, '', '', '', 0, 0, 0, 0, 4, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1696, 0, 0, 31, '', 'sys_menu', '前台功能设置', '', 'sys_web_action', '["add","edit","del","up","down"]', '', '', 0, 0, 0, 1, 5, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1710, 0, 0, 0, '', 'sys_model_name', 'share', '', NULL, '分享', '', '', 0, 0, 0, 0, 6, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1711, 0, 0, 0, '', 'sys_model_name', 'recovery', '', NULL, '恢复', '', '', 0, 0, 0, 0, 7, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1725, 0, 0, 0, '', 'sys_model_name', 'manual', '', NULL, '手册', '', '', 0, 0, 0, 0, 8, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1726, 0, 0, 31, '', 'sys_menu', '多语言设置', '', 'sys_language', '["add","edit","del"]', '', '', 0, 0, 0, 1, 6, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1727, 0, 0, 37, '', 'sys_menu', 'FoundPHP公告', '', 'found_notice', '["add","edit","del","search"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1728, 0, 0, 37, '', 'sys_menu', 'FoundPHP公告类型设置', '', 'found_notice_set', '["add","edit","del"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1729, 0, 0, 0, '', 'found_notice_set', '普通公告', '', NULL, '', '', '', 0, 0, 0, 0, 9, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1730, 0, 0, 0, '', 'found_notice_set', '紧急公告', '', NULL, '', '', '', 0, 0, 0, 0, 10, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1735, 0, 0, 0, '', 'sys_model_name', 'auit', '', NULL, '审核', '', '', 0, 0, 0, 0, 11, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1774, 0, 0, 0, '', 'sys_model_name', 'power', '', NULL, '权限', '', '', 0, 0, 0, 0, 22, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1776, 0, 0, 31, '', 'sys_menu', '系统首页', '', 'default', '', '', '', 0, 0, 0, 1, 9, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1777, 0, 0, 0, '', 'articles_keyword', 'html', '', NULL, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1863, 0, 0, 31, '', 'sys_menu', '多语言翻译', '', 'sys_language_translate', '["renew","translate"]', '', '', 0, 0, 0, 1, 7, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1864, 0, 0, 0, '', 'sys_language', '中文简体', '', 'zh', '', '', '', 0, 37, 0, 0, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1865, 0, 0, 0, 'fa fa-connectdevelop', 'sys_menu', '应用中心', '', 'app', '["view"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1866, 0, 0, 1865, '', 'sys_menu', '开发者认证', '', 'app_auth', '["edit","view"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1867, 0, 0, 1865, '', 'sys_menu', '应用商城', '', 'app_store', '["add","edit","del"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1868, 0, 0, 1865, '', 'sys_menu', '我设计的模块', '', 'app_model', '["add","edit","del","view","search"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1869, 0, 0, 0, '', 'sys_model_name', 'renew', '', NULL, '更新', '', '', 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO "{[FoundPHP]}category" VALUES (1870, 0, 0, 0, '', 'sys_model_name', 'translate', '', NULL, '翻译', '', '', 0, 0, 0, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS "{[FoundPHP]}language";
CREATE TABLE "{[FoundPHP]}language" (
  "lid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "lang" text(30) NOT NULL,
  "m" text(120) NOT NULL,
  "a" text(120) NOT NULL,
  "md5" text(32) NOT NULL,
  "str" text NOT NULL,
  "tra_dates" integer(11),
  "dates" integer(11) NOT NULL
);

DROP TABLE IF EXISTS "{[FoundPHP]}logs";
CREATE TABLE "{[FoundPHP]}logs" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "fid" integer(11),
  "uid" integer(11) NOT NULL,
  "m" text(60) NOT NULL,
  "a" text(60) NOT NULL,
  "t" text(60) NOT NULL,
  "username" text(60),
  "titles" text(255),
  "todo" text(120),
  "logs" text(255) NOT NULL,
  "years" integer(4),
  "months" integer(2),
  "days" integer(2),
  "weeks" integer(11),
  "dates" integer(10) NOT NULL,
  "ip" text(15),
  "browse" text(255),
  "url" text(255),
  "referer" text(255)
);

INSERT INTO "{[FoundPHP]}logs" VALUES (1002, 0, 1, 'admin', 'default', '', 'FoundPHP 大师', '系统首页', '', '', 2021, 2, 26, 4, 1614317177, '127.0.0.1', NULL, 'admin.php', 'admin.php?a=login');
INSERT INTO "{[FoundPHP]}logs" VALUES (1003, 0, 1, 'admin', 'sys_action_name', '', 'FoundPHP 大师', '功能权限设定', '', '', 2021, 2, 26, 4, 1614317180, '127.0.0.1', NULL, 'admin.php?a=sys_action_name', 'admin.php');
INSERT INTO "{[FoundPHP]}logs" VALUES (1004, 0, 1, 'admin', 'sys_language', '', 'FoundPHP 大师', '多语言设置', '', '', 2021, 2, 26, 4, 1614317180, '127.0.0.1', NULL, 'admin.php?a=sys_language', 'admin.php?a=sys_action_name');
INSERT INTO "{[FoundPHP]}logs" VALUES (1005, 0, 1, 'admin', 'sys_web_action', '', 'FoundPHP 大师', '前台功能设置', '', '', 2021, 2, 26, 4, 1614317181, '127.0.0.1', NULL, 'admin.php?a=sys_web_action', 'admin.php?a=sys_language');
INSERT INTO "{[FoundPHP]}logs" VALUES (1006, 0, 1, 'admin', 'sys_action_name', '', 'FoundPHP 大师', '功能权限设定', '', '', 2021, 2, 26, 4, 1614317181, '127.0.0.1', NULL, 'admin.php?a=sys_action_name', 'admin.php?a=sys_web_action');
INSERT INTO "{[FoundPHP]}logs" VALUES (1007, 0, 1, 'admin', 'sys_action', '', 'FoundPHP 大师', '后台功能管理', '', '', 2021, 2, 26, 4, 1614317182, '127.0.0.1', NULL, 'admin.php?a=sys_action', 'admin.php?a=sys_action_name');
INSERT INTO "{[FoundPHP]}logs" VALUES (1008, 0, 1, 'admin', 'articles_list', '', 'FoundPHP 大师', '文章列表', '', '', 2021, 2, 26, 4, 1614317199, '127.0.0.1', NULL, 'admin.php?a=articles_list', 'admin.php?a=sys_action');
INSERT INTO "{[FoundPHP]}logs" VALUES (1009, 0, 1, 'admin', 'articles_cate', '', 'FoundPHP 大师', '文章分类', '', '', 2021, 2, 26, 4, 1614317435, '127.0.0.1', NULL, 'admin.php?a=articles_cate', 'admin.php?a=articles_list');
INSERT INTO "{[FoundPHP]}logs" VALUES (1010, 0, 1, 'admin', 'articles_list', '', 'FoundPHP 大师', '文章列表', '', '', 2021, 2, 26, 4, 1614317444, '127.0.0.1', NULL, 'admin.php?a=articles_list', 'admin.php?a=articles_cate');

DROP TABLE IF EXISTS "{[FoundPHP]}setting";
CREATE TABLE "{[FoundPHP]}setting" (
  "set_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "k" text(50) NOT NULL,
  "v" text
);

DROP TABLE IF EXISTS "{[FoundPHP]}sys_link";
CREATE TABLE "{[FoundPHP]}sys_link" (
  "slid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "link_type" text(60) NOT NULL,
  "link_us" integer(11) NOT NULL,
  "link_id" integer(11) NOT NULL,
  "link_view" integer(11),
  "link_date" integer(11)
);

DROP TABLE IF EXISTS "{[FoundPHP]}temp";
CREATE TABLE "{[FoundPHP]}temp" (
  "tmpid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "uid" integer(10) NOT NULL,
  "types" integer(11) NOT NULL,
  "states" integer(10),
  "keywords" text(255),
  "names" text(255),
  "vals" text(255),
  "datas" text(255),
  "ins_date" integer(11) NOT NULL,
  "up_date" integer(11),
  "ip" text(15)
);

DROP TABLE IF EXISTS "{[FoundPHP]}upfiles";
CREATE TABLE "{[FoundPHP]}upfiles" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "uid" integer(11),
  "aid" integer(11),
  "fid" integer(11),
  "cid" integer(11),
  "types" integer(11) NOT NULL,
  "titles" text(255),
  "path" text(128) NOT NULL,
  "filename" text(60),
  "ext" text(60),
  "size" text(30),
  "tag_label" text,
  "createtime" integer(10) NOT NULL
);

DROP TABLE IF EXISTS "{[FoundPHP]}user";
CREATE TABLE "{[FoundPHP]}user" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "fid" integer(11),
  "types" integer(2) NOT NULL,
  "username" text(40) NOT NULL,
  "appkey" text(60),
  "password" text(32) NOT NULL,
  "forget_password" text(10),
  "forget_date" integer(10),
  "first_name" text(60),
  "middle_name" text(20),
  "last_name" text(20),
  "gender" integer(1) NOT NULL,
  "birth_y" integer(11),
  "birth_m" integer(11),
  "birth_d" integer(11),
  "age" text(20),
  "idcard" text(30),
  "email" text(80),
  "phone" text(120),
  "mobile" text(120),
  "position" text(60),
  "face" text(100),
  "province" text(50),
  "city" text(50),
  "district" text(50),
  "address" text(50),
  "qq" text(20),
  "wechat" text(60),
  "openid" text(60),
  "sponsor" integer(11),
  "moneys" real(10,2),
  "states" integer(11) NOT NULL,
  "state_date" integer(11),
  "reg_date" integer(11),
  "reg_ip" text(15),
  "last_date" integer(10),
  "last_ip" text(15)
);

DROP TABLE IF EXISTS "{[FoundPHP]}user_wechat";
CREATE TABLE "{[FoundPHP]}user_wechat" (
  "uwid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "fid" integer(11),
  "kind" integer(11),
  "son_num" integer(11),
  "types" integer(1) NOT NULL,
  "froms" text(30),
  "names" text(120) NOT NULL,
  "openid" text(60) NOT NULL,
  "face" text(60),
  "uid" integer(11),
  "subscribe" integer(11),
  "subscribe_date" integer(11),
  "date_in" integer(11),
  "date_bind" integer(11)
);

DROP TABLE IF EXISTS "{[FoundPHP]}user_wechat_relevance";
CREATE TABLE "{[FoundPHP]}user_wechat_relevance" (
  "uwrid" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "idtypes" integer(11),
  "fid" integer(11) NOT NULL,
  "weid" integer(11) NOT NULL,
  "uid" integer(11) NOT NULL,
  "dateline" integer(11) NOT NULL
);

CREATE INDEX "aid"
ON "{[FoundPHP]}article_data" (
  "cate_id" ASC
);

PRAGMA foreign_keys = true;
