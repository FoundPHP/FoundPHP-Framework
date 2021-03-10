SET NAMES utf8mb4;
-- ----------------------------
-- Table admin_group
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}admin_group`;
CREATE TABLE `{[FoundPHP]}admin_group`  (
  `agid` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `host_id` int(11) NULL DEFAULT 0 COMMENT '服务器id',
  `names` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '管理组名',
  `master` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '当前组的负责人',
  `master_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '管理员id',
  `nums` int(11) NULL DEFAULT 0 COMMENT '组员人数',
  `power` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '管理权限',
  `power_num` int(11) NOT NULL DEFAULT 0 COMMENT '选中权限数量',
  `intro` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分组说明描述',
  `dateline` int(11) NOT NULL DEFAULT 0 COMMENT '最后操作更新时间',
  PRIMARY KEY (`agid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员组' ROW_FORMAT = Dynamic;

INSERT INTO `{[FoundPHP]}admin_group` VALUES (1, 0, '超级管理员', '', '', 3, 'master', 0, '系统超级管理员组', 0);

-- ----------------------------
-- Table admin_user
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}admin_user`;
CREATE TABLE `{[FoundPHP]}admin_user`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `host_id` int(11) NULL DEFAULT NULL COMMENT '服务器id',
  `fid` int(11) NOT NULL DEFAULT 0 COMMENT '父级id',
  `son` int(11) NULL DEFAULT 0 COMMENT '子账户数量',
  `gid` int(11) NOT NULL DEFAULT 0 COMMENT '管理组id',
  `lang` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL default 'zh' COMMENT '用户语言',
  `username` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `nickname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名或昵称',
  `gender` tinyint(1) NOT NULL DEFAULT 0 COMMENT '性别:1男，2女',
  `email` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `position` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '职位',
  `face` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `states` int(11) NOT NULL DEFAULT 0 COMMENT '状态：1激活，0不能登录',
  `my_power` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '管理员私设权限',
  `operate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理区域',
  `last_operate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理者最后操作信息',
  `state_date` int(11) NOT NULL DEFAULT 0 COMMENT '帐号过期时间',
  `login_num` int(11) NOT NULL DEFAULT 0 COMMENT '登录次数',
  `reg_date` int(11) NOT NULL DEFAULT 0 COMMENT '注册时间',
  `reg_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '注册IP',
  `last_date` int(10) NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '最后登录ip',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

INSERT INTO `{[FoundPHP]}admin_user` (`id`, `host_id`, `fid`, `son`, `gid`, `username`, `password`, `nickname`, `gender`, `email`, `phone`, `position`, `face`, `states`, `my_power`, `operate`, `last_operate`, `state_date`, `login_num`, `reg_date`, `reg_ip`, `last_date`, `last_ip`) VALUES (1, 0, 0, 0, 1, '{[FoundPHP_us]}', '{[FoundPHP_pw]}', 'FoundPHP 大师', 0, '{[FoundPHP_email]}', '', '超级管理员', '', 1, '', '', '', 0, 0, {[FoundPHP_date]}, '{[FoundPHP_ip]}', {[FoundPHP_date]}, '{[FoundPHP_ip]}');


-- ----------------------------
-- Table articles
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}articles`;
CREATE TABLE `{[FoundPHP]}articles`  (
  `aid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '作者id',
  `cate_id` int(11) NOT NULL DEFAULT 0 COMMENT '分类id',
  `page_id` int(10) NULL DEFAULT NULL COMMENT '文章分页id',
  `lang` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci  NULL DEFAULT 'zh' COMMENT '文章语言',
  `titles` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `pinyin` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '对应文章的拼音标题',
  `smarty_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '智能系统分析的标题',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关键字',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '页面介绍',
  `result` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '结果注释说明',
  `thumbnail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章缩略图',
  `pagekey` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章地址关键词',
  `pageurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章链接',
  `author` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章作者',
  `editor` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '编辑作者',
  `cases` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章类型',
  `date_add` int(10) NULL DEFAULT 0 COMMENT '添加日期',
  `date_edit` int(10) NULL DEFAULT 0 COMMENT '编辑日期',
  `valid` tinyint(1) NULL DEFAULT 0 COMMENT '设置文章是否有效，0等待审核，1审核成功，-1审核失败',
  `views` int(10) NULL DEFAULT 1 COMMENT '查看次数',
  PRIMARY KEY (`aid`) USING BTREE,
  INDEX `cate_id`(`cate_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章主表' ROW_FORMAT = Dynamic;

INSERT INTO `{[FoundPHP]}articles` VALUES (1, 1, 1687, NULL, 'zh', '欢迎来到FoundPHP 开发世界', NULL, 'FoundPHP 框架是非常优秀的PHP开发框架', '', 'FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架。', '', '', '', 'http://www.foundphp.com', 'Admin', '', 'phpcourse', 1612411395, 1612411515, 0, 1);

-- ----------------------------
-- Table article_data
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}article_data`;
CREATE TABLE `{[FoundPHP]}article_data`  (
  `adid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cate_id` int(10) NULL DEFAULT 0 COMMENT '分类id',
  `aid` int(10) NULL DEFAULT 0 COMMENT '文章id',
  `uid` int(10) NULL DEFAULT 0 COMMENT '作者id',
  `lang` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci  NULL DEFAULT 'zh' COMMENT '文章语言',
  `cases` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章类型',
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '抓取内容',
  `md_content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Markdown 内容',
  `cache` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '页面缓存',
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发表作者',
  `dateline` int(10) NULL DEFAULT 0 COMMENT '发布时间',
  `page_num` int(5) NULL DEFAULT 0 COMMENT '分页号码',
  PRIMARY KEY (`adid`) USING BTREE,
  INDEX `aid`(`cate_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章数据' ROW_FORMAT = Dynamic;

INSERT INTO `{[FoundPHP]}article_data` VALUES (1, 1687, 1, 1,'zh', 'phpcourse', 'FoundPHP 为你的梦想加油！', '<h1 id=&quot;h1--foundphp-&quot;><a name=&quot;欢迎来到FoundPHP 开发世界&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>欢迎来到FoundPHP 开发世界</h1><p>FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架，用简单的方法为您实现最实用、最稳定的开发平台。</p>\r\n<p>FoundPHP 自带多级系统权限、组织架构、系统管理、调试平台、自动开发、自动完成、AI代码修正、自动升级等功能无需开发，直接使用。</p>\r\n<p>FoundPHP 在线AI自动化写代码、可视化系统开发，设计思维导图即可实现75％的功能代码，降低成本并提高质量，更快速的开发系统的方法。</p>\r\n<p><code>你的作品就是我们最满意的答卷，感谢您加入我们的大家庭。</code></p>\r\n<p>官方网址：<a href=&quot;http://www.foundphp.com&quot;>http://www.foundphp.com</a></p>\r\n<p>开发者：<a href=&quot;http://dev.foundphp.com&quot;>http://dev.foundphp.com</a></p>\r\n<p>FoundPHP Group<br>2021年</p>', '# 欢迎来到FoundPHP 开发世界\r\n\r\nFoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架，用简单的方法为您实现最实用、最稳定的开发平台。\r\n\r\nFoundPHP 自带多级系统权限、组织架构、系统管理、调试平台、自动开发、自动完成、AI代码修正、自动升级等功能无需开发，直接使用。\r\n\r\nFoundPHP 在线AI自动化写代码、可视化系统开发，设计思维导图即可实现75％的功能代码，降低成本并提高质量，更快速的开发系统的方法。\r\n\r\n`你的作品就是我们最满意的答卷，感谢您加入我们的大家庭。`\r\n\r\n官方网址：http://www.foundphp.com\r\n\r\n开发者：http://dev.foundphp.com\r\n\r\nFoundPHP Group\r\n2021年', NULL, 'Admin', 1612411395, 0);

-- ----------------------------
-- Table article_vote
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}article_vote`;
CREATE TABLE `{[FoundPHP]}article_vote`  (
  `avid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '发布用户id',
  `aid` int(11) NOT NULL DEFAULT 0 COMMENT '文章id',
  `vote_type` int(11) NOT NULL DEFAULT 0 COMMENT '0单选，1多选',
  `vote_name` int(11) NOT NULL DEFAULT 0 COMMENT '投票名称',
  `vote_color` int(11) NOT NULL DEFAULT 0 COMMENT '投票名颜色',
  `vote_num` int(11) NOT NULL DEFAULT 0 COMMENT '已投票数量',
  `dateline` int(11) NOT NULL DEFAULT 0 COMMENT '建立时间',
  PRIMARY KEY (`avid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章投票条目' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table article_vote_logs
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}article_vote_logs`;
CREATE TABLE `{[FoundPHP]}article_vote_logs`  (
  `avlid` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL DEFAULT 0 COMMENT '文章id',
  `avid` int(11) NOT NULL DEFAULT 0 COMMENT '投票id',
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '投票用户id',
  `dateline` int(11) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP地址',
  PRIMARY KEY (`avlid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '投票记录' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table articles_likes
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}articles_likes`;
CREATE TABLE `{[FoundPHP]}articles_likes`  (
  `alid` int(11) NOT NULL AUTO_INCREMENT,
  `types` int(11) NOT NULL DEFAULT 0 COMMENT '类型 1收藏 2点赞 3关注',
  `aid` int(11) NOT NULL DEFAULT 0 COMMENT '文章id',
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `dateline` int(11) NOT NULL DEFAULT 0 COMMENT '时间',
  `ip` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ip',
  PRIMARY KEY (`alid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章关注。收藏、点赞表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table articles_relation
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}articles_relation`;
CREATE TABLE `{[FoundPHP]}articles_relation`  (
  `arid` int(11) NOT NULL AUTO_INCREMENT,
  `types` int(11) NOT NULL DEFAULT 0 COMMENT '类型 1关键词关联 2文章关联',
  `genres` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章类型 （phpcourse）',
  `aid` int(11) NOT NULL DEFAULT 0 COMMENT '文章id',
  `rid` int(11) NOT NULL DEFAULT 0 COMMENT '关联id',
  `dateline` int(11) NOT NULL DEFAULT 0 COMMENT '时间',
  PRIMARY KEY (`arid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章、关键词关联、文章之间的关联' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table bulletin
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}bulletin`;
CREATE TABLE `{[FoundPHP]}bulletin`  (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `genre` int(11) NOT NULL DEFAULT 0 COMMENT '公告的类型',
  `titles` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告标题',
  `contents` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告内容',
  `post_uid` int(11) NOT NULL DEFAULT 0 COMMENT '发布人',
  `post_date` int(11) NOT NULL DEFAULT 0 COMMENT '发布时间',
  `post_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP地址',
  PRIMARY KEY (`bid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户端显示公告' ROW_FORMAT = Dynamic;

INSERT INTO `{[FoundPHP]}bulletin` VALUES (1, 1729, '开始FoundPHP世界', '加入FoundPHP的世界，让你在php的世界里畅游。', 1, 1582879687, '127.0.0.1');

-- ----------------------------
-- Table category
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}category`;
CREATE TABLE `{[FoundPHP]}category`  (
  `cate_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `host_id` int(11) NULL DEFAULT NULL COMMENT '服务器id',
  `mid` int(10) NULL DEFAULT 0 COMMENT '分类模块id',
  `fid` int(11) NULL DEFAULT 0 COMMENT '父id',
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标Font Awesome ',
  `types` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类属于哪个功能类型，例如article就属于文章',
  `cate_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
  `cate_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '次要名字',
  `language` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '多语言语言内容',
  `cate_desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '分类介绍',
  `cate_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `cate_pic` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类照片',
  `linkto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开启后则由a=go接管',
  `numbers` int(11) NULL DEFAULT 0 COMMENT '分类文章数',
  `reader` int(10) NULL DEFAULT 0 COMMENT '展示次数',
  `shows` tinyint(1) NULL DEFAULT 0 COMMENT '显示状态',
  `orders` int(10) NULL DEFAULT 0 COMMENT '排序id',
  `lockout` tinyint(1) NULL DEFAULT 0 COMMENT '锁定则没有删除',
  `ins_time` int(10) NULL DEFAULT 0 COMMENT '插入时间',
  `update_time` int(10) NULL DEFAULT 0 COMMENT '最后更新时间',
  PRIMARY KEY (`cate_id`) USING BTREE,
  INDEX `types`(`types`) USING BTREE,
  INDEX `orders`(`orders`) USING BTREE,
  INDEX `fid`(`fid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '网站分类' ROW_FORMAT = Dynamic;

INSERT INTO `{[FoundPHP]}category` (`cate_id`, `host_id`, `mid`, `fid`, `icon`, `types`, `cate_name`, `cate_title`, `language`, `cate_desc`, `cate_url`, `cate_pic`, `linkto`, `numbers`, `reader`, `shows`, `orders`, `lockout`, `ins_time`, `update_time`) VALUES
(6, 0, 0, 0, '', 'sys_model_name', 'edit', '', NULL, '编辑', '', '', 0, 0, 0, 0, 36, 0, 0, 0),
(4, 0, 0, 0, '', 'sys_model_name', 'add', '', NULL, '添加', '', '', 0, 0, 0, 0, 37, 0, 0, 0),
(7, 0, 0, 0, '', 'sys_model_name', 'del', '', NULL, '删除', '', '', 0, 0, 0, 0, 38, 0, 0, 0),
(8, 0, 0, 0, '', 'sys_model_name', 'view', '', NULL, '查看', '', '', 0, 0, 0, 0, 39, 0, 0, 0),
(9, 0, 0, 0, '', 'sys_model_name', 'search', '', NULL, '搜索', '', '', 0, 0, 0, 0, 40, 0, 0, 0),
(10, 0, 0, 0, '', 'sys_model_name', 'download', '', NULL, '下载', '', '', 0, 0, 0, 0, 41, 0, 0, 0),
(11, 0, 0, 0, '', 'sys_model_name', 'up', '', NULL, '上移', '', '', 0, 0, 0, 0, 42, 0, 0, 0),
(12, 0, 0, 0, '', 'sys_model_name', 'down', '', NULL, '下移', '', '', 0, 0, 0, 0, 43, 0, 0, 0),
(13, 0, 0, 0, '', 'sys_model_name', 'preview', '', NULL, '预览', '', '', 0, 0, 0, 0, 44, 0, 0, 0),
(14, 0, 0, 0, '', 'sys_model_name', 'title', '', NULL, '标题修改', '', '', 0, 0, 0, 0, 45, 0, 0, 0),
(15, 0, 0, 0, '', 'sys_model_name', 'import', '', NULL, '导入', '', '', 0, 0, 0, 0, 46, 0, 0, 0),
(16, 0, 0, 0, '', 'sys_model_name', 'export', '', NULL, '导出', '', '', 0, 0, 0, 0, 47, 0, 0, 0),
(18, 0, 0, 0, '', 'sys_model_name', 'bdel', '', NULL, '批量删除', '', '', 0, 0, 0, 0, 48, 0, 0, 0),
(36, 0, 0, 31, '', 'sys_menu', '后台功能管理', '', 'sys_action', '[\"add\",\"edit\",\"del\",\"up\",\"down\"]', '', '', 0, 0, 0, 1, 1, 1, 0, 0),
(37, 0, 0, 0, 'fa fa-users', 'sys_menu', '系统管理', '', 'admin', '', '', '', 0, 0, 0, 1, 33, 1, 0, 0),
(38, 0, 0, 37, '', 'sys_menu', '管理员权限组', '', 'admin_group', '[\"add\",\"edit\",\"del\",\"view\",\"search\"]', '', '', 0, 0, 0, 1, 0, 1, 0, 0),
(39, 0, 0, 37, '', 'sys_menu', '管理员列表', '', 'admin_user', '[\"add\",\"edit\",\"del\",\"search\"]', '', '', 0, 0, 0, 1, 0, 1, 0, 0),
(35, 0, 0, 31, '', 'sys_menu', '功能权限设定', '', 'sys_action_name', '[\"add\",\"edit\",\"del\",\"search\"]', '', '', 0, 0, 0, 1, 2, 1, 0, 0),
(34, 0, 0, 31, '', 'sys_menu', '数据库备份', '', 'sys_backup', '', '', '', 0, 0, 0, 1, 8, 1, 0, 0),
(31, 0, 0, 0, 'fa fa-cogs', 'sys_menu', '系统设置', '', 'sys', '', '', '', 0, 0, 0, 1, 32, 1, 0, 0),
(32, 0, 0, 31, '', 'sys_menu', '网站核心设置', '', 'sys_set', '[\"edit\"]', '', '', 0, 0, 0, 1, 3, 1, 0, 0),
(33, 0, 0, 31, '', 'sys_menu', '样式特效设置', '', 'sys_style', '[\"edit\"]', '', '', 0, 0, 0, 1, 4, 1, 0, 0),
(40, 0, 0, 37, '', 'sys_menu', '管理操作记录', '', 'admin_log', '[\"del\",\"search\"]', '', '', 0, 0, 0, 1, 0, 1, 0, 0),
(509, 0, 0, 0, 'fa fa-archive', 'sys_menu', '文章管理', '', 'article', '', '', '', 0, 0, 0, 1, 34, 0, 0, 0),
(510, 0, 0, 509, '', 'sys_menu', '文章列表', '', 'articles_list', '[\"add\",\"edit\",\"del\",\"view\",\"search\",\"bdel\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(73, 0, 0, 0, '', 'sys_model_name', 'password', '', NULL, '密码修改', '', '', 0, 0, 0, 0, 35, 0, 0, 0),
(597, 0, 0, 0, '', 'sys_model_name', 'score', '', NULL, '评分', '', '', 0, 0, 0, 0, 26, 0, 0, 0),
(397, 0, 0, 0, '', 'sys_model_name', 'edit_myself', '', NULL, '资料修改', '', '', 0, 0, 0, 0, 27, 0, 0, 0),
(394, 0, 0, 0, '', 'sys_model_name', 'export_data', '', NULL, '批量导出', '', '', 0, 0, 0, 0, 28, 0, 0, 0),
(403, 0, 0, 0, '', 'sys_model_name', 'cate', '', NULL, '添加类别', '', '', 0, 0, 0, 0, 29, 0, 0, 0),
(404, 0, 0, 0, '', 'sys_model_name', 'file_list', '', NULL, '上传文件', '', '', 0, 0, 0, 0, 30, 0, 0, 0),
(600, 0, 0, 0, '', 'sys_model_name', 'print', '', NULL, '打印', '', '', 0, 0, 0, 0, 31, 0, 0, 0),
(935, 0, 0, 0, '', 'sys_model_name', 'operation', '', NULL, '操作', '', '', 0, 0, 0, 0, 24, 0, 0, 0),
(1100, 0, 0, 0, '', 'sys_model_name', 'album', '', NULL, '相册', '', '', 0, 0, 0, 0, 25, 0, 0, 0),
(1148, 0, 0, 0, '', 'sys_model_name', 'transfer', '', NULL, '移动', '', '', 0, 0, 0, 0, 1, 0, 0, 0),
(1685, 0, 0, 509, '', 'sys_menu', '文章分类', '', 'articles_cate', '[\"add\",\"edit\",\"del\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1686, 0, 0, 0, '', 'article_cate', 'FoundPHP', '', NULL, '', '', '', 0, 0, 0, 0, 23, 0, 0, 0),
(1687, 0, 0, 1686, '', 'article_cate', '入门', '', NULL, '', '', '', 0, 0, 0, 0, 2, 0, 0, 0),
(1688, 0, 0, 1686, '', 'article_cate', '熟练', '', NULL, '', '', '', 0, 0, 0, 0, 3, 0, 0, 0),
(1689, 0, 0, 509, '', 'sys_menu', '文章关键词', '', 'articles_keyword', '[\"add\",\"edit\",\"del\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1692, 0, 0, 0, '', 'articles_keyword', 'php', '', NULL, '', '', '', 0, 0, 0, 0, 4, 0, 0, 0),
(1696, 0, 0, 31, '', 'sys_menu', '前台功能设置', '', 'sys_web_action', '[\"add\",\"edit\",\"del\",\"up\",\"down\"]', '', '', 0, 0, 0, 1, 5, 0, 0, 0),
(1710, 0, 0, 0, '', 'sys_model_name', 'share', '', NULL, '分享', '', '', 0, 0, 0, 0, 6, 0, 0, 0),
(1711, 0, 0, 0, '', 'sys_model_name', 'recovery', '', NULL, '恢复', '', '', 0, 0, 0, 0, 7, 0, 0, 0),
(1725, 0, 0, 0, '', 'sys_model_name', 'manual', '', NULL, '手册', '', '', 0, 0, 0, 0, 8, 0, 0, 0),
(1727, 0, 0, 37, '', 'sys_menu', 'FoundPHP公告', '', 'found_notice', '[\"add\",\"edit\",\"del\",\"search\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1728, 0, 0, 37, '', 'sys_menu', 'FoundPHP公告类型设置', '', 'found_notice_set', '[\"add\",\"edit\",\"del\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1729, 0, 0, 0, '', 'found_notice_set', '普通公告', '', NULL, '', '', '', 0, 0, 0, 0, 9, 0, 0, 0),
(1730, 0, 0, 0, '', 'found_notice_set', '紧急公告', '', NULL, '', '', '', 0, 0, 0, 0, 10, 0, 0, 0),
(1735, 0, 0, 0, '', 'sys_model_name', 'auit', '', NULL, '审核', '', '', 0, 0, 0, 0, 11, 0, 0, 0),
(1774, 0, 0, 0, '', 'sys_model_name', 'power', '', NULL, '权限', '', '', 0, 0, 0, 0, 22, 0, 0, 0),
(1776, 0, 0, 31, '', 'sys_menu', '系统首页', '', 'default', '', '', '', 0, 0, 0, 1, 9, 0, 0, 0),
(1777, 0, 0, 0, '', 'articles_keyword', 'html', '', NULL, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0),
(1726, 0, 0, 31, '', 'sys_menu', '多语言设置', '', 'sys_language', '[\"add\",\"edit\",\"del\"]', '', '', 0, 0, 0, 1, 6, 0, 0, 0),
(1863, 0, 0, 31, '', 'sys_menu', '多语言翻译', '', 'sys_language_translate', '[\"renew\",\"translate\"]', '', '', 0, 0, 0, 1, 7, 0, 0, 0),
(1864, 0, 0, 0, '', 'sys_language', '中文简体', '', 'zh', '', '', '', 0, 37, 0, 0, 0, 0, 0, 0),
(1865, 0, 0, 0, 'fa fa-connectdevelop', 'sys_menu', '应用中心', '', 'app', '[\"view\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1866, 0, 0, 1865, '', 'sys_menu', '开发者认证', '', 'app_auth', '[\"edit\",\"view\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1867, 0, 0, 1865, '', 'sys_menu', '应用商城', '', 'app_store', '[\"add\",\"edit\",\"del\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1868, 0, 0, 1865, '', 'sys_menu', '我设计的模块', '', 'app_model', '[\"add\",\"edit\",\"del\",\"view\",\"search\"]', '', '', 0, 0, 0, 1, 0, 0, 0, 0),
(1869, 0, 0, 0, '', 'sys_model_name', 'renew', '', NULL, '更新', '', '', 0, 0, 0, 0, 0, 0, 0, 0),
(1870, 0, 0, 0, '', 'sys_model_name', 'translate', '', NULL, '翻译', '', '', 0, 0, 0, 0, 0, 0, 0, 0);

-- ----------------------------
-- Table language
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}language`;
CREATE TABLE `{[FoundPHP]}language`  (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'zh' COMMENT '语言识别标签默认中文：zh',
  `m` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块',
  `a` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '行动',
  `md5` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '语言标识md5',
  `str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '语言字符',
  `tra_dates` int(11) NULL DEFAULT 0 COMMENT '翻译时间',
  `dates` int(11) NOT NULL DEFAULT 0 COMMENT '时间',
  PRIMARY KEY (`lid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统语言包' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table logs
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}logs`;
CREATE TABLE `{[FoundPHP]}logs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL DEFAULT 0 COMMENT '父id',
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '当前用户id',
  `m` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块',
  `a` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '动作',
  `t` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作事项',
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作用户名称',
  `titles` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '页面标题',
  `todo` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '动作',
  `logs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作内容',
  `years` int(4) NULL DEFAULT NULL COMMENT '年份',
  `months` tinyint(2) NULL DEFAULT NULL COMMENT '月份',
  `days` tinyint(2) NULL DEFAULT NULL COMMENT '日',
  `weeks` int(11) NULL DEFAULT 0 COMMENT '当月第几周',
  `dates` int(10) NOT NULL DEFAULT 0 COMMENT '操作日期',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ip地址',
  `browse` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '浏览器手机还是pc',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '浏览地址',
  `referer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '页面来源',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `fid`(`fid`) USING BTREE,
  INDEX `years`(`years`) USING BTREE,
  INDEX `months`(`months`) USING BTREE,
  INDEX `days`(`days`) USING BTREE,
  INDEX `m`(`m`) USING BTREE,
  INDEX `a`(`a`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1002 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '操作日志' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table setting
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}setting`;
CREATE TABLE `{[FoundPHP]}setting`  (
  `set_id` int(11) NOT NULL AUTO_INCREMENT,
  `k` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所引关键字',
  `v` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容或数值',
  PRIMARY KEY (`set_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统设置信息' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table sys_link
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}sys_link`;
CREATE TABLE `{[FoundPHP]}sys_link`  (
  `slid` int(11) NOT NULL AUTO_INCREMENT,
  `link_type` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类别为单词区分',
  `link_us` int(11) NOT NULL DEFAULT 0 COMMENT '关联用户',
  `link_id` int(11) NOT NULL DEFAULT 0 COMMENT '关联id',
  `link_view` int(11) NULL DEFAULT 0 COMMENT '阅读/使用状态，0未使用，更新时间表示使用',
  `link_date` int(11) NOT NULL DEFAULT 0 COMMENT '建立时间',
  PRIMARY KEY (`slid`) USING BTREE,
  INDEX `link_us`(`link_us`, `link_id`) USING BTREE,
  INDEX `link_type`(`link_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统全局关联关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table temp
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}temp`;
CREATE TABLE `{[FoundPHP]}temp`  (
  `tmpid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL COMMENT '用户id',
  `types` int(11) NOT NULL DEFAULT 0 COMMENT '类型',
  `states` int(10) NOT NULL COMMENT '状态',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关键词',
  `names` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名字',
  `vals` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '数值1',
  `datas` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '数值2',
  `ins_date` int(11) NOT NULL DEFAULT 0 COMMENT '插入时间',
  `up_date` int(11) NULL DEFAULT 0 COMMENT '更新时间',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'ip地址',
  PRIMARY KEY (`tmpid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '临时应用表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table upfiles
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}upfiles`;
CREATE TABLE `{[FoundPHP]}upfiles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '上传者id',
  `aid` int(11) NULL DEFAULT 0 COMMENT '文章关联',
  `fid` int(11) NULL DEFAULT 0 COMMENT '父级id',
  `cid` int(11) NULL DEFAULT 0 COMMENT '分类id',
  `types` int(11) NOT NULL DEFAULT 0 COMMENT '文件类型',
  `titles` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `path` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '存储路径',
  `filename` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件名（有后缀）',
  `ext` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '后缀格式',
  `size` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '文件大小',
  `tag_label` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '标签',
  `createtime` int(10) NOT NULL DEFAULT 0 COMMENT '上传时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `aid`(`aid`) USING BTREE,
  INDEX `fid`(`fid`) USING BTREE,
  INDEX `cid`(`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '上传文件公用表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table user
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}user`;
CREATE TABLE `{[FoundPHP]}user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fid` int(11) NULL DEFAULT 0 COMMENT '父级id',
  `types` int(2) NOT NULL COMMENT '用户类型：1普通注册 2微信授权进入',
  `username` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `appkey` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权秘钥',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `forget_password` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '取回密码',
  `forget_date` int(10) NULL DEFAULT NULL COMMENT '取回密码时间',
  `first_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名字',
  `middle_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '中间名',
  `last_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓氏',
  `gender` tinyint(1) NOT NULL DEFAULT 0 COMMENT '性别:1男，2女',
  `birth_y` int(11) NULL DEFAULT 0 COMMENT '生日',
  `birth_m` int(11) NULL DEFAULT 0 COMMENT '生日月份',
  `birth_d` int(11) NULL DEFAULT 0 COMMENT '生日日期',
  `age` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '年龄',
  `idcard` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '身份证号',
  `email` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `mobile` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `position` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '职位',
  `face` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `province` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '省',
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '市',
  `district` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '区域',
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '详细地址',
  `qq` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'QQ号码',
  `wechat` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信帐号',
  `openid` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信openid',
  `sponsor` int(11) NULL DEFAULT 0 COMMENT '赞助：0未赞助，1银<1000,2金<1000,3钻石<50000',
  `moneys` decimal(10, 2) NULL DEFAULT NULL COMMENT '账户余额',
  `states` int(11) NOT NULL DEFAULT 0 COMMENT '状态：1激活，0不能登录',
  `state_date` int(11) NULL DEFAULT 0 COMMENT '帐号过期时间',
  `reg_date` int(11) NOT NULL DEFAULT 0 COMMENT '注册时间',
  `reg_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '注册IP',
  `last_date` int(10) NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '最后登录ip',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fid`(`fid`) USING BTREE,
  INDEX `types`(`types`) USING BTREE,
  INDEX `states`(`states`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户总列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table user_wechat
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}user_wechat`;
CREATE TABLE `{[FoundPHP]}user_wechat`  (
  `uwid` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NULL DEFAULT 0 COMMENT '父级id',
  `kind` int(11) NULL DEFAULT 0 COMMENT '1加盟商 2老师 3家长',
  `son_num` int(11) NULL DEFAULT 0 COMMENT '孩子总绑定数量',
  `types` int(1) NOT NULL COMMENT '0：Foundphp 公众号，1 其他公众号',
  `froms` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公众号来源',
  `names` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信用户名',
  `openid` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信openid',
  `face` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户头像更新',
  `uid` int(11) NULL DEFAULT 0 COMMENT '关联user表id',
  `subscribe` int(11) NOT NULL DEFAULT 0 COMMENT '是否关注 0未判断 1关注 2未关注',
  `subscribe_date` int(11) NULL DEFAULT 0 COMMENT '关注时间',
  `date_in` int(11) NULL DEFAULT 0 COMMENT '微信进入的时间',
  `date_bind` int(11) NULL DEFAULT 0 COMMENT '关联user的时间',
  PRIMARY KEY (`uwid`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `openid`(`openid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信用户绑定关联' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table user_wechat_relevance
-- ----------------------------
DROP TABLE IF EXISTS `{[FoundPHP]}user_wechat_relevance`;
CREATE TABLE `{[FoundPHP]}user_wechat_relevance`  (
  `uwrid` int(11) NOT NULL AUTO_INCREMENT,
  `idtypes` int(11) NULL DEFAULT 0 COMMENT '绑定身份例如：1加盟，2老师，4学生/家长，5员工',
  `fid` int(11) NOT NULL DEFAULT 0 COMMENT '上级id',
  `weid` int(11) NOT NULL DEFAULT 0 COMMENT '微信表id',
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `dateline` int(11) NOT NULL DEFAULT 0 COMMENT '建立时间',
  PRIMARY KEY (`uwrid`) USING BTREE,
  INDEX `idtypes`(`idtypes`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `weid`(`weid`) USING BTREE,
  INDEX `fid`(`fid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信用户关系表' ROW_FORMAT = Fixed;

