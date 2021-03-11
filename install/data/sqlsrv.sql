-- ----------------------------
-- Table admin_group
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}admin_group]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}admin_group]
GO
CREATE TABLE [dbo].[{[FoundPHP]}admin_group] (
  [agid] int IDENTITY(1,1),
  [host_id] int  NULL,
  [names] nvarchar(50) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [master] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [master_id] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [nums] int  NULL,
  [power] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [power_num] int  NOT NULL,
  [intro] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [dateline] int  NOT NULL
)
GO
EXEC sp_addextendedproperty
'MS_Description', N'服务器id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'host_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理组名',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'names'
GO
EXEC sp_addextendedproperty
'MS_Description', N'当前组的负责人',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'master'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理员id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'master_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'组员人数',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'nums'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理权限',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'power'
GO
EXEC sp_addextendedproperty
'MS_Description', N'选中权限数量',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'power_num'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分组说明描述',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'intro'
GO
EXEC sp_addextendedproperty
'MS_Description', N'最后操作更新时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group',
'COLUMN', N'dateline'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理员组',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_group'
GO
INSERT INTO [dbo].[{[FoundPHP]}admin_group] ([agid], [host_id], [names], [master], [master_id], [nums], [power], [power_num], [intro], [dateline]) VALUES (N'1', N'0', N'超级管理员', N'', N'', N'3', N'master', N'0', N'系统超级管理员组', N'0')
GO

-- ----------------------------
-- Table admin_user
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}admin_user]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}admin_user]
GO
CREATE TABLE [dbo].[{[FoundPHP]}admin_user] (
  [id] int IDENTITY(1,1) NOT NULL,
  [host_id] int  NULL,
  [fid] int  NULL,
  [son] int  NULL,
  [gid] int  NOT NULL,
  [lang] nvarchar(10) COLLATE Chinese_PRC_CI_AS NULL,
  [username] nvarchar(40) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [password] nvarchar(32) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [nickname] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [gender] tinyint  NOT NULL,
  [email] nvarchar(80) COLLATE Chinese_PRC_CI_AS  NULL,
  [phone] nvarchar(20) COLLATE Chinese_PRC_CI_AS  NULL,
  [position] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [face] nvarchar(100) COLLATE Chinese_PRC_CI_AS  NULL,
  [states] int  NOT NULL,
  [my_power] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [operate] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [last_operate] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [state_date] int  NOT NULL,
  [login_num] int  NOT NULL,
  [reg_date] int  NOT NULL,
  [reg_ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [last_date] int  NULL,
  [last_ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}admin_user] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'服务器id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'host_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'父级id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'fid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'子账户数量',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'son'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理组id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'gid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户名',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'username'
GO
EXEC sp_addextendedproperty
'MS_Description', N'密码',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'password'
GO
EXEC sp_addextendedproperty
'MS_Description', N'姓名或昵称',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'nickname'
GO
EXEC sp_addextendedproperty
'MS_Description', N'性别:1男，2女',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'gender'
GO
EXEC sp_addextendedproperty
'MS_Description', N'邮箱',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'email'
GO
EXEC sp_addextendedproperty
'MS_Description', N'电话',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'phone'
GO
EXEC sp_addextendedproperty
'MS_Description', N'职位',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'position'
GO
EXEC sp_addextendedproperty
'MS_Description', N'头像',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'face'
GO
EXEC sp_addextendedproperty
'MS_Description', N'状态：1激活，0不能登录',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'states'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理员私设权限',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'my_power'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理区域',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'operate'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理者最后操作信息',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'last_operate'
GO
EXEC sp_addextendedproperty
'MS_Description', N'帐号过期时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'state_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'登录次数',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'login_num'
GO
EXEC sp_addextendedproperty
'MS_Description', N'注册时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'reg_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'注册IP',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'reg_ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'最后登录时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'last_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'最后登录ip',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user',
'COLUMN', N'last_ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'管理员表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}admin_user'
GO
INSERT INTO [dbo].[{[FoundPHP]}admin_user] ([id], [host_id], [fid], [son], [gid], [username], [password], [nickname], [gender], [email], [phone], [position], [face], [states], [my_power], [operate], [last_operate], [state_date], [login_num], [reg_date], [reg_ip], [last_date], [last_ip]) VALUES (N'1', N'0', N'0', N'0', N'1', N'{[FoundPHP_us]}', N'{[FoundPHP_pw]}', N'FoundPHP 大师', N'0', N'{[FoundPHP_email]}', N'', N'超级管理员', N'', N'1', N'', N'', N'', N'0', N'0', N'{[FoundPHP_date]}', N'{[FoundPHP_ip]}', N'{[FoundPHP_date]}', N'{[FoundPHP_ip]}')
GO

-- ----------------------------
-- Table articles
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}articles]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}articles]
GO
CREATE TABLE [dbo].[{[FoundPHP]}articles] (
  [aid] int IDENTITY(1,1) NOT NULL,
  [uid] int  NOT NULL,
  [cate_id] int  NOT NULL,
  [page_id] int  NULL,
  [lang] nvarchar(10) COLLATE Chinese_PRC_CI_AS NULL,
  [titles] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [pinyin] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [smarty_title] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [keywords] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [description] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [result] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [thumbnail] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [pagekey] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [pageurl] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [author] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [editor] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [cases] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [date_add] int  NULL,
  [date_edit] int  NULL,
  [valid] tinyint  NULL,
  [views] int  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}articles] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'作者id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'cate_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章分页id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'page_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'标题',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'titles'
GO
EXEC sp_addextendedproperty
'MS_Description', N'对应文章的拼音标题',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'pinyin'
GO
EXEC sp_addextendedproperty
'MS_Description', N'智能系统分析的标题',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'smarty_title'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关键字',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'keywords'
GO
EXEC sp_addextendedproperty
'MS_Description', N'页面介绍',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'description'
GO
EXEC sp_addextendedproperty
'MS_Description', N'结果注释说明',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'result'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章缩略图',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'thumbnail'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章地址关键词',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'pagekey'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章链接',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'pageurl'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章作者',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'author'
GO
EXEC sp_addextendedproperty
'MS_Description', N'编辑作者',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'editor'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章类型',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'cases'
GO
EXEC sp_addextendedproperty
'MS_Description', N'添加日期',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'date_add'
GO
EXEC sp_addextendedproperty
'MS_Description', N'编辑日期',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'date_edit'
GO
EXEC sp_addextendedproperty
'MS_Description', N'设置文章是否有效，0等待审核，1审核成功，-1审核失败',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'valid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'查看次数',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles',
'COLUMN', N'views'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章主表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles'
GO
INSERT INTO [dbo].[{[FoundPHP]}articles] ([aid], [uid], [cate_id], [page_id], [lang], [titles], [pinyin], [smarty_title], [keywords], [description], [result], [thumbnail], [pagekey], [pageurl], [author], [editor], [cases], [date_add], [date_edit], [valid], [views]) VALUES (N'1', N'1', N'1687', NULL, N'zh', N'欢迎来到FoundPHP 开发世界', NULL, N'FoundPHP 框架是非常优秀的PHP开发框架', N'', N'FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架。', N'', N'', N'', N'http://www.foundphp.com', N'Admin', N'', N'articles', N'1612411395', N'1612411515', N'0', N'1')

-- ----------------------------
-- Table article_data
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}article_data]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}article_data]
GO
CREATE TABLE [dbo].[{[FoundPHP]}article_data] (
  [adid] int IDENTITY(1,1) NOT NULL,
  [cate_id] int  NULL,
  [aid] int  NULL,
  [uid] int  NULL,
  [lang] nvarchar(10) COLLATE Chinese_PRC_CI_AS NULL,
  [cases] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [subject] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [content] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [md_content] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [cache] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [author] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [dateline] int  NULL,
  [page_num] int  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}article_data] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'cate_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'aid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'作者id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章类型',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'cases'
GO
EXEC sp_addextendedproperty
'MS_Description', N'标题',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'subject'
GO
EXEC sp_addextendedproperty
'MS_Description', N'抓取内容',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'content'
GO
EXEC sp_addextendedproperty
'MS_Description', N'Markdown 内容',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'md_content'
GO
EXEC sp_addextendedproperty
'MS_Description', N'页面缓存',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'cache'
GO
EXEC sp_addextendedproperty
'MS_Description', N'发表作者',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'author'
GO
EXEC sp_addextendedproperty
'MS_Description', N'发布时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'dateline'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分页号码',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data',
'COLUMN', N'page_num'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章数据',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_data'
GO
INSERT INTO [dbo].[{[FoundPHP]}article_data] ([adid], [cate_id], [aid], [uid], [cases],[lang], [subject], [content], [md_content], [cache], [author], [dateline], [page_num]) VALUES (N'1', N'1687', N'1', N'1', N'articles', N'lang', N'FoundPHP 为你的梦想加油！', N'<h1 id=&quot;h1--foundphp-&quot;><a name=&quot;欢迎来到FoundPHP 开发世界&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>欢迎来到FoundPHP 开发世界</h1><p>FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架，用简单的方法为您实现最实用、最稳定的开发平台。</p>
<p>FoundPHP 自带多级系统权限、组织架构、系统管理、调试平台、自动开发、自动完成、AI代码修正、自动升级等功能无需开发，直接使用。</p>
<p>FoundPHP 在线AI自动化写代码、可视化系统开发，设计思维导图即可实现75％的功能代码，降低成本并提高质量，更快速的开发系统的方法。</p>
<p><code>你的作品就是我们最满意的答卷，感谢您加入我们的大家庭。</code></p>
<p>官方网址：<a href=&quot;http://www.foundphp.com&quot;>http://www.foundphp.com</a></p>
<p>开发者：<a href=&quot;http://dev.foundphp.com&quot;>http://dev.foundphp.com</a></p>
<p>FoundPHP Group<br>2021年</p>', N'# 欢迎来到FoundPHP 开发世界
FoundPHP 是目前唯一同时运行PHP5/PHP7/PHP8的开发框架，用简单的方法为您实现最实用、最稳定的开发平台。
FoundPHP 自带多级系统权限、组织架构、系统管理、调试平台、自动开发、自动完成、AI代码修正、自动升级等功能无需开发，直接使用。
FoundPHP 在线AI自动化写代码、可视化系统开发，设计思维导图即可实现75％的功能代码，降低成本并提高质量，更快速的开发系统的方法。
`你的作品就是我们最满意的答卷，感谢您加入我们的大家庭。`
官方网址：http://www.foundphp.com
开发者：http://dev.foundphp.com
FoundPHP Group
2021年', NULL, N'Admin', N'1612411395', N'0')
GO

-- ----------------------------
-- Table article_vote
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}article_vote]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}article_vote]
GO
CREATE TABLE [dbo].[{[FoundPHP]}article_vote] (
  [avid] int IDENTITY(1,1) NOT NULL,
  [uid] int  NOT NULL,
  [aid] int  NOT NULL,
  [vote_type] int  NOT NULL,
  [vote_name] int  NOT NULL,
  [vote_color] int  NOT NULL,
  [vote_num] int  NOT NULL,
  [dateline] int  NOT NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}article_vote] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'发布用户id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote',
'COLUMN', N'aid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'0单选，1多选',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote',
'COLUMN', N'vote_type'
GO
EXEC sp_addextendedproperty
'MS_Description', N'投票名称',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote',
'COLUMN', N'vote_name'
GO
EXEC sp_addextendedproperty
'MS_Description', N'投票名颜色',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote',
'COLUMN', N'vote_color'
GO
EXEC sp_addextendedproperty
'MS_Description', N'已投票数量',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote',
'COLUMN', N'vote_num'
GO
EXEC sp_addextendedproperty
'MS_Description', N'建立时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote',
'COLUMN', N'dateline'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章投票条目',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote'
GO
-- ----------------------------
-- Table article_vote_logs
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}article_vote_logs]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}article_vote_logs]
GO
CREATE TABLE [dbo].[{[FoundPHP]}article_vote_logs] (
  [avlid] int IDENTITY(1,1) NOT NULL,
  [aid] int  NOT NULL,
  [avid] int  NOT NULL,
  [uid] int  NOT NULL,
  [dateline] int  NOT NULL,
  [ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}article_vote_logs] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote_logs',
'COLUMN', N'aid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'投票id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote_logs',
'COLUMN', N'avid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'投票用户id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote_logs',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'记录时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote_logs',
'COLUMN', N'dateline'
GO
EXEC sp_addextendedproperty
'MS_Description', N'IP地址',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote_logs',
'COLUMN', N'ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'投票记录',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}article_vote_logs'
GO

GO
-- ----------------------------
-- Table articles_likes
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}articles_likes]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}articles_likes]
GO
CREATE TABLE [dbo].[{[FoundPHP]}articles_likes] (
  [alid] int IDENTITY(1,1) NOT NULL,
  [types] int  NOT NULL,
  [aid] int  NOT NULL,
  [uid] int  NOT NULL,
  [dateline] int  NOT NULL,
  [ip] nvarchar(30) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}articles_likes] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'类型 1收藏 2点赞 3关注',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_likes',
'COLUMN', N'types'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_likes',
'COLUMN', N'aid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_likes',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_likes',
'COLUMN', N'dateline'
GO
EXEC sp_addextendedproperty
'MS_Description', N'ip',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_likes',
'COLUMN', N'ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章关注。收藏、点赞表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_likes'
GO
-- ----------------------------
-- Table articles_relation
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}articles_relation]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}articles_relation]
GO
CREATE TABLE [dbo].[{[FoundPHP]}articles_relation] (
  [arid] int IDENTITY(1,1) NOT NULL,
  [types] int  NOT NULL,
  [genres] nvarchar(20) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [aid] int  NOT NULL,
  [rid] int  NOT NULL,
  [dateline] int  NOT NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}articles_relation] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'类型 1关键词关联 2文章关联',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_relation',
'COLUMN', N'types'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章类型 （articles）',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_relation',
'COLUMN', N'genres'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_relation',
'COLUMN', N'aid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关联id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_relation',
'COLUMN', N'rid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_relation',
'COLUMN', N'dateline'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章、关键词关联、文章之间的关联',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}articles_relation'
GO
-- ----------------------------
-- Table bulletin
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}bulletin]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}bulletin]
GO
CREATE TABLE [dbo].[{[FoundPHP]}bulletin] (
  [bid] int IDENTITY(1,1) NOT NULL,
  [genre] int  NOT NULL,
  [titles] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [contents] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [post_uid] int  NOT NULL,
  [post_date] int  NOT NULL,
  [post_ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}bulletin] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'公告的类型',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}bulletin',
'COLUMN', N'genre'
GO
EXEC sp_addextendedproperty
'MS_Description', N'公告标题',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}bulletin',
'COLUMN', N'titles'
GO
EXEC sp_addextendedproperty
'MS_Description', N'公告内容',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}bulletin',
'COLUMN', N'contents'
GO
EXEC sp_addextendedproperty
'MS_Description', N'发布人',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}bulletin',
'COLUMN', N'post_uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'发布时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}bulletin',
'COLUMN', N'post_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'IP地址',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}bulletin',
'COLUMN', N'post_ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户端显示公告',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}bulletin'
GO
INSERT INTO [dbo].[{[FoundPHP]}bulletin] ([bid], [genre], [titles], [contents], [post_uid], [post_date], [post_ip]) VALUES (N'1', N'1729', N'开始FoundPHP世界', N'加入FoundPHP的世界，让你在php的世界里畅游。', N'1', N'1582879687', N'127.0.0.1')
GO
-- ----------------------------
-- Table category
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}category]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}category]
GO
CREATE TABLE [dbo].[{[FoundPHP]}category] (
  [cate_id] int IDENTITY(1,1) NOT NULL,
  [host_id] int  NULL,
  [mid] int  NULL,
  [fid] int NULL,
  [icon] nvarchar(50) COLLATE Chinese_PRC_CI_AS  NULL,
  [types] nvarchar(30) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [cate_name] nvarchar(100) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [cate_title] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [language] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [cate_desc] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [cate_url] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [cate_pic] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [linkto] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [numbers] int  NULL,
  [reader] int  NULL,
  [shows] tinyint  NULL,
  [orders] int  NULL,
  [lockout] tinyint  NULL,
  [ins_time] int  NULL,
  [update_time] int  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}category] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'cate_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'服务器id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'host_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类模块id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'mid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'父id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'fid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'图标Font Awesome ',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'icon'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类属于哪个功能类型，例如article就属于文章',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'types'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类名称',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'cate_name'
GO
EXEC sp_addextendedproperty
'MS_Description', N'次要名字',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'cate_title'
GO
EXEC sp_addextendedproperty
'MS_Description', N'多语言语言内容',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'language'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类介绍',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'cate_desc'
GO
EXEC sp_addextendedproperty
'MS_Description', N'链接地址',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'cate_url'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类照片',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'cate_pic'
GO
EXEC sp_addextendedproperty
'MS_Description', N'开启后则由a=go接管',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'linkto'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类文章数',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'numbers'
GO
EXEC sp_addextendedproperty
'MS_Description', N'展示次数',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'reader'
GO
EXEC sp_addextendedproperty
'MS_Description', N'显示状态',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'shows'
GO
EXEC sp_addextendedproperty
'MS_Description', N'排序id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'orders'
GO
EXEC sp_addextendedproperty
'MS_Description', N'锁定则没有删除',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'lockout'
GO
EXEC sp_addextendedproperty
'MS_Description', N'插入时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'ins_time'
GO
EXEC sp_addextendedproperty
'MS_Description', N'最后更新时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category',
'COLUMN', N'update_time'
GO
EXEC sp_addextendedproperty
'MS_Description', N'网站分类',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}category'
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'4', N'0', N'0', N'0', N'', N'sys_model_name', N'add', N'', NULL, N'添加', N'', N'', N'0', N'0', N'0', N'0', N'37', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'6', N'0', N'0', N'0', N'', N'sys_model_name', N'edit', N'', NULL, N'编辑', N'', N'', N'0', N'0', N'0', N'0', N'36', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'7', N'0', N'0', N'0', N'', N'sys_model_name', N'del', N'', NULL, N'删除', N'', N'', N'0', N'0', N'0', N'0', N'38', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'8', N'0', N'0', N'0', N'', N'sys_model_name', N'view', N'', NULL, N'查看', N'', N'', N'0', N'0', N'0', N'0', N'39', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'9', N'0', N'0', N'0', N'', N'sys_model_name', N'search', N'', NULL, N'搜索', N'', N'', N'0', N'0', N'0', N'0', N'40', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'10', N'0', N'0', N'0', N'', N'sys_model_name', N'download', N'', NULL, N'下载', N'', N'', N'0', N'0', N'0', N'0', N'41', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'11', N'0', N'0', N'0', N'', N'sys_model_name', N'up', N'', NULL, N'上移', N'', N'', N'0', N'0', N'0', N'0', N'42', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'12', N'0', N'0', N'0', N'', N'sys_model_name', N'down', N'', NULL, N'下移', N'', N'', N'0', N'0', N'0', N'0', N'43', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'13', N'0', N'0', N'0', N'', N'sys_model_name', N'preview', N'', NULL, N'预览', N'', N'', N'0', N'0', N'0', N'0', N'44', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'14', N'0', N'0', N'0', N'', N'sys_model_name', N'title', N'', NULL, N'标题修改', N'', N'', N'0', N'0', N'0', N'0', N'45', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'15', N'0', N'0', N'0', N'', N'sys_model_name', N'import', N'', NULL, N'导入', N'', N'', N'0', N'0', N'0', N'0', N'46', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'16', N'0', N'0', N'0', N'', N'sys_model_name', N'export', N'', NULL, N'导出', N'', N'', N'0', N'0', N'0', N'0', N'47', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'18', N'0', N'0', N'0', N'', N'sys_model_name', N'bdel', N'', NULL, N'批量删除', N'', N'', N'0', N'0', N'0', N'0', N'48', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'31', N'0', N'0', N'0', N'fa fa-cogs', N'sys_menu', N'系统设置', N'', N'sys', N'', N'', N'', N'0', N'0', N'0', N'1', N'32', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'32', N'0', N'0', N'31', N'', N'sys_menu', N'网站核心设置', N'', N'sys_set', N'["edit"]', N'', N'', N'0', N'0', N'0', N'1', N'3', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'33', N'0', N'0', N'31', N'', N'sys_menu', N'样式特效设置', N'', N'sys_style', N'["edit"]', N'', N'', N'0', N'0', N'0', N'1', N'4', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'34', N'0', N'0', N'31', N'', N'sys_menu', N'数据库备份', N'', N'sys_backup', N'', N'', N'', N'0', N'0', N'0', N'1', N'8', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'35', N'0', N'0', N'31', N'', N'sys_menu', N'功能权限设定', N'', N'sys_action_name', N'["add","edit","del","search"]', N'', N'', N'0', N'0', N'0', N'1', N'2', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'36', N'0', N'0', N'31', N'', N'sys_menu', N'后台功能管理', N'', N'sys_action', N'["add","edit","del","up","down"]', N'', N'', N'0', N'0', N'0', N'1', N'1', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'37', N'0', N'0', N'0', N'fa fa-users', N'sys_menu', N'系统管理', N'', N'admin', N'', N'', N'', N'0', N'0', N'0', N'1', N'33', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'38', N'0', N'0', N'37', N'', N'sys_menu', N'管理员权限组', N'', N'admin_group', N'["add","edit","del","view","search"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'39', N'0', N'0', N'37', N'', N'sys_menu', N'管理员列表', N'', N'admin_user', N'["add","edit","del","search"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'40', N'0', N'0', N'37', N'', N'sys_menu', N'管理操作记录', N'', N'admin_log', N'["del","search"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'1', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'73', N'0', N'0', N'0', N'', N'sys_model_name', N'password', N'', NULL, N'密码修改', N'', N'', N'0', N'0', N'0', N'0', N'35', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'394', N'0', N'0', N'0', N'', N'sys_model_name', N'export_data', N'', NULL, N'批量导出', N'', N'', N'0', N'0', N'0', N'0', N'28', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'397', N'0', N'0', N'0', N'', N'sys_model_name', N'edit_myself', N'', NULL, N'资料修改', N'', N'', N'0', N'0', N'0', N'0', N'27', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'403', N'0', N'0', N'0', N'', N'sys_model_name', N'cate', N'', NULL, N'添加类别', N'', N'', N'0', N'0', N'0', N'0', N'29', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'404', N'0', N'0', N'0', N'', N'sys_model_name', N'file_list', N'', NULL, N'上传文件', N'', N'', N'0', N'0', N'0', N'0', N'30', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'509', N'0', N'0', N'0', N'fa fa-archive', N'sys_menu', N'文章管理', N'', N'article', N'', N'', N'', N'0', N'0', N'0', N'1', N'34', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'510', N'0', N'0', N'509', N'', N'sys_menu', N'文章列表', N'', N'articles_list', N'["add","edit","del","view","search","bdel"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'597', N'0', N'0', N'0', N'', N'sys_model_name', N'score', N'', NULL, N'评分', N'', N'', N'0', N'0', N'0', N'0', N'26', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'600', N'0', N'0', N'0', N'', N'sys_model_name', N'print', N'', NULL, N'打印', N'', N'', N'0', N'0', N'0', N'0', N'31', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'935', N'0', N'0', N'0', N'', N'sys_model_name', N'operation', N'', NULL, N'操作', N'', N'', N'0', N'0', N'0', N'0', N'24', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1100', N'0', N'0', N'0', N'', N'sys_model_name', N'album', N'', NULL, N'相册', N'', N'', N'0', N'0', N'0', N'0', N'25', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1148', N'0', N'0', N'0', N'', N'sys_model_name', N'transfer', N'', NULL, N'移动', N'', N'', N'0', N'0', N'0', N'0', N'1', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1685', N'0', N'0', N'509', N'', N'sys_menu', N'文章分类', N'', N'articles_cate', N'["add","edit","del"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1686', N'0', N'0', N'0', N'', N'article_cate', N'FoundPHP', N'', NULL, N'', N'', N'', N'0', N'0', N'0', N'0', N'23', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1687', N'0', N'0', N'1686', N'', N'article_cate', N'入门', N'', NULL, N'', N'', N'', N'0', N'0', N'0', N'0', N'2', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1688', N'0', N'0', N'1686', N'', N'article_cate', N'熟练', N'', NULL, N'', N'', N'', N'0', N'0', N'0', N'0', N'3', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1689', N'0', N'0', N'509', N'', N'sys_menu', N'文章关键词', N'', N'articles_keyword', N'["add","edit","del"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1692', N'0', N'0', N'0', N'', N'articles_keyword', N'php', N'', NULL, N'', N'', N'', N'0', N'0', N'0', N'0', N'4', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1696', N'0', N'0', N'31', N'', N'sys_menu', N'前台功能设置', N'', N'sys_web_action', N'["add","edit","del","up","down"]', N'', N'', N'0', N'0', N'0', N'1', N'5', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1710', N'0', N'0', N'0', N'', N'sys_model_name', N'share', N'', NULL, N'分享', N'', N'', N'0', N'0', N'0', N'0', N'6', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1711', N'0', N'0', N'0', N'', N'sys_model_name', N'recovery', N'', NULL, N'恢复', N'', N'', N'0', N'0', N'0', N'0', N'7', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1725', N'0', N'0', N'0', N'', N'sys_model_name', N'manual', N'', NULL, N'手册', N'', N'', N'0', N'0', N'0', N'0', N'8', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1726', N'0', N'0', N'31', N'', N'sys_menu', N'多语言设置', N'', N'sys_language', N'["add","edit","del"]', N'', N'', N'0', N'0', N'0', N'1', N'6', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1727', N'0', N'0', N'37', N'', N'sys_menu', N'FoundPHP公告', N'', N'found_notice', N'["add","edit","del","search"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1728', N'0', N'0', N'37', N'', N'sys_menu', N'FoundPHP公告类型设置', N'', N'found_notice_set', N'["add","edit","del"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1729', N'0', N'0', N'0', N'', N'found_notice_set', N'普通公告', N'', NULL, N'', N'', N'', N'0', N'0', N'0', N'0', N'9', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1730', N'0', N'0', N'0', N'', N'found_notice_set', N'紧急公告', N'', NULL, N'', N'', N'', N'0', N'0', N'0', N'0', N'10', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1735', N'0', N'0', N'0', N'', N'sys_model_name', N'auit', N'', NULL, N'审核', N'', N'', N'0', N'0', N'0', N'0', N'11', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1774', N'0', N'0', N'0', N'', N'sys_model_name', N'power', N'', NULL, N'权限', N'', N'', N'0', N'0', N'0', N'0', N'22', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1776', N'0', N'0', N'31', N'', N'sys_menu', N'系统首页', N'', N'default', N'', N'', N'', N'0', N'0', N'0', N'1', N'9', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1777', N'0', N'0', N'0', N'', N'articles_keyword', N'html', N'', NULL, N'', N'', N'', N'0', N'0', N'0', N'0', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1863', N'0', N'0', N'31', N'', N'sys_menu', N'多语言翻译', N'', N'sys_language_translate', N'["renew","translate"]', N'', N'', N'0', N'0', N'0', N'1', N'7', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1864', N'0', N'0', N'0', N'', N'sys_language', N'中文简体', N'', N'zh', N'', N'', N'', N'0', N'37', N'0', N'0', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1865', N'0', N'0', N'0', N'fa fa-connectdevelop', N'sys_menu', N'应用中心', N'', N'app', N'["view"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1866', N'0', N'0', N'1865', N'', N'sys_menu', N'开发者认证', N'', N'app_auth', N'["edit","view"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1867', N'0', N'0', N'1865', N'', N'sys_menu', N'应用商城', N'', N'app_store', N'["add","edit","del"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1868', N'0', N'0', N'1865', N'', N'sys_menu', N'我设计的模块', N'', N'app_model', N'["add","edit","del","view","search"]', N'', N'', N'0', N'0', N'0', N'1', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1869', N'0', N'0', N'0', N'', N'sys_model_name', N'renew', N'', NULL, N'更新', N'', N'', N'0', N'0', N'0', N'0', N'0', N'0', N'0', N'0')
GO
INSERT INTO [dbo].[{[FoundPHP]}category] ([cate_id], [host_id], [mid], [fid], [icon], [types], [cate_name], [cate_title], [language], [cate_desc], [cate_url], [cate_pic], [linkto], [numbers], [reader], [shows], [orders], [lockout], [ins_time], [update_time]) VALUES (N'1870', N'0', N'0', N'0', N'', N'sys_model_name', N'translate', N'', NULL, N'翻译', N'', N'', N'0', N'0', N'0', N'0', N'0', N'0', N'0', N'0')
GO
-- ----------------------------
-- Table language
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}language]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}language]
GO
CREATE TABLE [dbo].[{[FoundPHP]}language] (
  [lid] int IDENTITY(1,1) NOT NULL,
  [lang] nvarchar(30) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [m] nvarchar(120) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [a] nvarchar(120) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [md5] nvarchar(32) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [str] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [tra_dates] int  NULL,
  [dates] int  NOT NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}language] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'语言识别标签默认中文：zh',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language',
'COLUMN', N'lang'
GO
EXEC sp_addextendedproperty
'MS_Description', N'模块',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language',
'COLUMN', N'm'
GO
EXEC sp_addextendedproperty
'MS_Description', N'行动',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language',
'COLUMN', N'a'
GO
EXEC sp_addextendedproperty
'MS_Description', N'语言标识md5',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language',
'COLUMN', N'md5'
GO
EXEC sp_addextendedproperty
'MS_Description', N'语言字符',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language',
'COLUMN', N'str'
GO
EXEC sp_addextendedproperty
'MS_Description', N'翻译时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language',
'COLUMN', N'tra_dates'
GO
EXEC sp_addextendedproperty
'MS_Description', N'时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language',
'COLUMN', N'dates'
GO
EXEC sp_addextendedproperty
'MS_Description', N'系统语言包',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}language'
GO
-- ----------------------------
-- Table logs
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}logs]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}logs]
GO
CREATE TABLE [dbo].[{[FoundPHP]}logs] (
  [id] int IDENTITY(1,1) NOT NULL,
  [fid] int  NOT NULL,
  [uid] int  NOT NULL,
  [m] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [a] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [t] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [username] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [titles] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [todo] nvarchar(120) COLLATE Chinese_PRC_CI_AS  NULL,
  [logs] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [years] int  NULL,
  [months] tinyint  NULL,
  [days] tinyint  NULL,
  [weeks] int  NULL,
  [dates] int  NOT NULL,
  [ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NULL,
  [browse] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [url] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [referer] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}logs] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'父id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'fid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'当前用户id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'模块',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'm'
GO
EXEC sp_addextendedproperty
'MS_Description', N'动作',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'a'
GO
EXEC sp_addextendedproperty
'MS_Description', N'操作事项',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N't'
GO
EXEC sp_addextendedproperty
'MS_Description', N'操作用户名称',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'username'
GO
EXEC sp_addextendedproperty
'MS_Description', N'页面标题',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'titles'
GO
EXEC sp_addextendedproperty
'MS_Description', N'动作',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'todo'
GO
EXEC sp_addextendedproperty
'MS_Description', N'操作内容',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'logs'
GO
EXEC sp_addextendedproperty
'MS_Description', N'年份',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'years'
GO
EXEC sp_addextendedproperty
'MS_Description', N'月份',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'months'
GO
EXEC sp_addextendedproperty
'MS_Description', N'日',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'days'
GO
EXEC sp_addextendedproperty
'MS_Description', N'当月第几周',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'weeks'
GO
EXEC sp_addextendedproperty
'MS_Description', N'操作日期',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'dates'
GO
EXEC sp_addextendedproperty
'MS_Description', N'ip地址',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'浏览器手机还是pc',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'browse'
GO
EXEC sp_addextendedproperty
'MS_Description', N'浏览地址',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'url'
GO
EXEC sp_addextendedproperty
'MS_Description', N'页面来源',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs',
'COLUMN', N'referer'
GO
EXEC sp_addextendedproperty
'MS_Description', N'操作日志',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}logs'
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1002', N'0', N'1', N'admin', N'default', N'', N'FoundPHP 大师', N'系统首页', N'', N'', N'2021', N'2', N'26', N'4', N'1614317177', N'127.0.0.1', NULL, N'admin.php', N'admin.php?a=login')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1003', N'0', N'1', N'admin', N'sys_action_name', N'', N'FoundPHP 大师', N'功能权限设定', N'', N'', N'2021', N'2', N'26', N'4', N'1614317180', N'127.0.0.1', NULL, N'admin.php?a=sys_action_name', N'admin.php')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1004', N'0', N'1', N'admin', N'sys_language', N'', N'FoundPHP 大师', N'多语言设置', N'', N'', N'2021', N'2', N'26', N'4', N'1614317180', N'127.0.0.1', NULL, N'admin.php?a=sys_language', N'admin.php?a=sys_action_name')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1005', N'0', N'1', N'admin', N'sys_web_action', N'', N'FoundPHP 大师', N'前台功能设置', N'', N'', N'2021', N'2', N'26', N'4', N'1614317181', N'127.0.0.1', NULL, N'admin.php?a=sys_web_action', N'admin.php?a=sys_language')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1006', N'0', N'1', N'admin', N'sys_action_name', N'', N'FoundPHP 大师', N'功能权限设定', N'', N'', N'2021', N'2', N'26', N'4', N'1614317181', N'127.0.0.1', NULL, N'admin.php?a=sys_action_name', N'admin.php?a=sys_web_action')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1007', N'0', N'1', N'admin', N'sys_action', N'', N'FoundPHP 大师', N'后台功能管理', N'', N'', N'2021', N'2', N'26', N'4', N'1614317182', N'127.0.0.1', NULL, N'admin.php?a=sys_action', N'admin.php?a=sys_action_name')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1008', N'0', N'1', N'admin', N'articles_list', N'', N'FoundPHP 大师', N'文章列表', N'', N'', N'2021', N'2', N'26', N'4', N'1614317199', N'127.0.0.1', NULL, N'admin.php?a=articles_list', N'admin.php?a=sys_action')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1009', N'0', N'1', N'admin', N'articles_cate', N'', N'FoundPHP 大师', N'文章分类', N'', N'', N'2021', N'2', N'26', N'4', N'1614317435', N'127.0.0.1', NULL, N'admin.php?a=articles_cate', N'admin.php?a=articles_list')
GO
INSERT INTO [dbo].[{[FoundPHP]}logs] ([id], [fid], [uid], [m], [a], [t], [username], [titles], [todo], [logs], [years], [months], [days], [weeks], [dates], [ip], [browse], [url], [referer]) VALUES (N'1010', N'0', N'1', N'admin', N'articles_list', N'', N'FoundPHP 大师', N'文章列表', N'', N'', N'2021', N'2', N'26', N'4', N'1614317444', N'127.0.0.1', NULL, N'admin.php?a=articles_list', N'admin.php?a=articles_cate')
GO
-- ----------------------------
-- Table setting
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}setting]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}setting]
GO
CREATE TABLE [dbo].[{[FoundPHP]}setting] (
  [set_id] int IDENTITY(1,1) NOT NULL,
  [k] nvarchar(50) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [v] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}setting] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'所引关键字',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}setting',
'COLUMN', N'k'
GO
EXEC sp_addextendedproperty
'MS_Description', N'内容或数值',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}setting',
'COLUMN', N'v'
GO
EXEC sp_addextendedproperty
'MS_Description', N'系统设置信息',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}setting'
GO
-- ----------------------------
-- Table sys_link
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}sys_link]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}sys_link]
GO
CREATE TABLE [dbo].[{[FoundPHP]}sys_link] (
  [slid] int IDENTITY(1,1) NOT NULL,
  [link_type] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [link_us] int  NOT NULL,
  [link_id] int  NOT NULL,
  [link_view] int  NULL,
  [link_date] int  NOT NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}sys_link] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'类别为单词区分',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}sys_link',
'COLUMN', N'link_type'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关联用户',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}sys_link',
'COLUMN', N'link_us'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关联id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}sys_link',
'COLUMN', N'link_id'
GO
EXEC sp_addextendedproperty
'MS_Description', N'阅读/使用状态，0未使用，更新时间表示使用',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}sys_link',
'COLUMN', N'link_view'
GO
EXEC sp_addextendedproperty
'MS_Description', N'建立时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}sys_link',
'COLUMN', N'link_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'系统全局关联关系表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}sys_link'
GO
-- ----------------------------
-- Table temp
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}temp]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}temp]
GO
CREATE TABLE [dbo].[{[FoundPHP]}temp] (
  [tmpid] int IDENTITY(1,1) NOT NULL,
  [uid] int  NOT NULL,
  [types] int  NOT NULL,
  [states] int  NOT NULL,
  [keywords] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [names] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [vals] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [datas] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [ins_date] int  NOT NULL,
  [up_date] int  NULL,
  [ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}temp] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'类型',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'types'
GO
EXEC sp_addextendedproperty
'MS_Description', N'状态',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'states'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关键词',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'keywords'
GO
EXEC sp_addextendedproperty
'MS_Description', N'名字',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'names'
GO
EXEC sp_addextendedproperty
'MS_Description', N'数值1',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'vals'
GO
EXEC sp_addextendedproperty
'MS_Description', N'数值2',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'datas'
GO
EXEC sp_addextendedproperty
'MS_Description', N'插入时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'ins_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'更新时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'up_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'ip地址',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp',
'COLUMN', N'ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'临时应用表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}temp'
GO

-- ----------------------------
-- Table upfiles
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}upfiles]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}upfiles]
GO
CREATE TABLE [dbo].[{[FoundPHP]}upfiles] (
  [id] int IDENTITY(1,1) NOT NULL,
  [uid] int  NOT NULL,
  [aid] int  NULL,
  [fid] int  NULL,
  [cid] int  NULL,
  [types] int  NOT NULL,
  [titles] nvarchar(255) COLLATE Chinese_PRC_CI_AS  NULL,
  [path] nvarchar(128) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [filename] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [ext] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [size] nvarchar(30) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [tag_label] nvarchar(max) COLLATE Chinese_PRC_CI_AS  NULL,
  [createtime] int  NOT NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}upfiles] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'上传者id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文章关联',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'aid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'父级id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'fid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'分类id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'cid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文件类型',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'types'
GO
EXEC sp_addextendedproperty
'MS_Description', N'标题',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'titles'
GO
EXEC sp_addextendedproperty
'MS_Description', N'存储路径',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'path'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文件名（有后缀）',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'filename'
GO
EXEC sp_addextendedproperty
'MS_Description', N'后缀格式',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'ext'
GO
EXEC sp_addextendedproperty
'MS_Description', N'文件大小',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'size'
GO
EXEC sp_addextendedproperty
'MS_Description', N'标签',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'tag_label'
GO
EXEC sp_addextendedproperty
'MS_Description', N'上传时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles',
'COLUMN', N'createtime'
GO
EXEC sp_addextendedproperty
'MS_Description', N'上传文件公用表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}upfiles'
GO
-- ----------------------------
-- Table user
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}user]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}user]
GO
CREATE TABLE [dbo].[{[FoundPHP]}user] (
  [id] int IDENTITY(1,1) NOT NULL,
  [fid] int  NULL,
  [types] int  NOT NULL,
  [username] nvarchar(40) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [appkey] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [password] nvarchar(32) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [forget_password] nvarchar(10) COLLATE Chinese_PRC_CI_AS  NULL,
  [forget_date] int  NULL,
  [first_name] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [middle_name] nvarchar(20) COLLATE Chinese_PRC_CI_AS  NULL,
  [last_name] nvarchar(20) COLLATE Chinese_PRC_CI_AS  NULL,
  [gender] tinyint  NOT NULL,
  [birth_y] int  NULL,
  [birth_m] int  NULL,
  [birth_d] int  NULL,
  [age] nvarchar(20) COLLATE Chinese_PRC_CI_AS  NULL,
  [idcard] nvarchar(30) COLLATE Chinese_PRC_CI_AS  NULL,
  [email] nvarchar(80) COLLATE Chinese_PRC_CI_AS  NULL,
  [phone] nvarchar(120) COLLATE Chinese_PRC_CI_AS  NULL,
  [mobile] nvarchar(120) COLLATE Chinese_PRC_CI_AS  NULL,
  [position] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [face] nvarchar(100) COLLATE Chinese_PRC_CI_AS  NULL,
  [province] nvarchar(50) COLLATE Chinese_PRC_CI_AS  NULL,
  [city] nvarchar(50) COLLATE Chinese_PRC_CI_AS  NULL,
  [district] nvarchar(50) COLLATE Chinese_PRC_CI_AS  NULL,
  [address] nvarchar(50) COLLATE Chinese_PRC_CI_AS  NULL,
  [qq] nvarchar(20) COLLATE Chinese_PRC_CI_AS  NULL,
  [wechat] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [openid] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [sponsor] int  NULL,
  [moneys] decimal(10,2)  NULL,
  [states] int  NOT NULL,
  [state_date] int  NULL,
  [reg_date] int  NOT NULL,
  [reg_ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [last_date] int  NULL,
  [last_ip] nvarchar(15) COLLATE Chinese_PRC_CI_AS  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}user] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'父级id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'fid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户类型：1普通注册 2微信授权进入',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'types'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户名',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'username'
GO
EXEC sp_addextendedproperty
'MS_Description', N'授权秘钥',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'appkey'
GO
EXEC sp_addextendedproperty
'MS_Description', N'密码',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'password'
GO
EXEC sp_addextendedproperty
'MS_Description', N'取回密码',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'forget_password'
GO
EXEC sp_addextendedproperty
'MS_Description', N'取回密码时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'forget_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'名字',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'first_name'
GO
EXEC sp_addextendedproperty
'MS_Description', N'中间名',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'middle_name'
GO
EXEC sp_addextendedproperty
'MS_Description', N'姓氏',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'last_name'
GO
EXEC sp_addextendedproperty
'MS_Description', N'性别:1男，2女',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'gender'
GO
EXEC sp_addextendedproperty
'MS_Description', N'生日',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'birth_y'
GO
EXEC sp_addextendedproperty
'MS_Description', N'生日月份',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'birth_m'
GO
EXEC sp_addextendedproperty
'MS_Description', N'生日日期',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'birth_d'
GO
EXEC sp_addextendedproperty
'MS_Description', N'年龄',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'age'
GO
EXEC sp_addextendedproperty
'MS_Description', N'身份证号',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'idcard'
GO
EXEC sp_addextendedproperty
'MS_Description', N'邮箱',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'email'
GO
EXEC sp_addextendedproperty
'MS_Description', N'电话',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'phone'
GO
EXEC sp_addextendedproperty
'MS_Description', N'手机号码',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'mobile'
GO
EXEC sp_addextendedproperty
'MS_Description', N'职位',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'position'
GO
EXEC sp_addextendedproperty
'MS_Description', N'头像',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'face'
GO
EXEC sp_addextendedproperty
'MS_Description', N'省',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'province'
GO
EXEC sp_addextendedproperty
'MS_Description', N'市',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'city'
GO
EXEC sp_addextendedproperty
'MS_Description', N'区域',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'district'
GO
EXEC sp_addextendedproperty
'MS_Description', N'详细地址',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'address'
GO
EXEC sp_addextendedproperty
'MS_Description', N'QQ号码',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'qq'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信帐号',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'wechat'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信openid',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'openid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'赞助：0未赞助，1银<1000,2金<1000,3钻石<50000',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'sponsor'
GO
EXEC sp_addextendedproperty
'MS_Description', N'账户余额',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'moneys'
GO
EXEC sp_addextendedproperty
'MS_Description', N'状态：1激活，0不能登录',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'states'
GO
EXEC sp_addextendedproperty
'MS_Description', N'帐号过期时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'state_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'注册时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'reg_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'注册IP',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'reg_ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'最后登录时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'last_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'最后登录ip',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user',
'COLUMN', N'last_ip'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户总列表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user'
GO
-- ----------------------------
-- Table user_wechat
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}user_wechat]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}user_wechat]
GO
CREATE TABLE [dbo].[{[FoundPHP]}user_wechat] (
  [uwid] int IDENTITY(1,1) NOT NULL,
  [fid] int  NULL,
  [kind] int  NULL,
  [son_num] int  NULL,
  [types] int  NOT NULL,
  [froms] nvarchar(30) COLLATE Chinese_PRC_CI_AS  NULL,
  [names] nvarchar(120) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [openid] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NOT NULL,
  [face] nvarchar(60) COLLATE Chinese_PRC_CI_AS  NULL,
  [uid] int  NULL,
  [subscribe] int  NOT NULL,
  [subscribe_date] int  NULL,
  [date_in] int  NULL,
  [date_bind] int  NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}user_wechat] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'父级id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'fid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'1加盟商 2老师 3家长',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'kind'
GO
EXEC sp_addextendedproperty
'MS_Description', N'孩子总绑定数量',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'son_num'
GO
EXEC sp_addextendedproperty
'MS_Description', N'0：Foundphp 公众号，1 其他公众号',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'types'
GO
EXEC sp_addextendedproperty
'MS_Description', N'公众号来源',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'froms'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信用户名',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'names'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信openid',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'openid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户头像更新',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'face'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关联user表id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'是否关注 0未判断 1关注 2未关注',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'subscribe'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关注时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'subscribe_date'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信进入的时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'date_in'
GO
EXEC sp_addextendedproperty
'MS_Description', N'关联user的时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat',
'COLUMN', N'date_bind'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信用户绑定关联',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat'
GO
-- ----------------------------
-- Table user_wechat_relevance
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[{[FoundPHP]}user_wechat_relevance]') AND type IN ('U'))
	DROP TABLE [dbo].[{[FoundPHP]}user_wechat_relevance]
GO
CREATE TABLE [dbo].[{[FoundPHP]}user_wechat_relevance] (
  [uwrid] int IDENTITY(1,1) NOT NULL,
  [idtypes] int  NULL,
  [fid] int  NOT NULL,
  [weid] int  NOT NULL,
  [uid] int  NOT NULL,
  [dateline] int  NOT NULL
)
GO
ALTER TABLE [dbo].[{[FoundPHP]}user_wechat_relevance] SET (LOCK_ESCALATION = TABLE)
GO
EXEC sp_addextendedproperty
'MS_Description', N'绑定身份例如：1加盟，2老师，4学生/家长，5员工',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat_relevance',
'COLUMN', N'idtypes'
GO
EXEC sp_addextendedproperty
'MS_Description', N'上级id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat_relevance',
'COLUMN', N'fid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信表id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat_relevance',
'COLUMN', N'weid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'用户id',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat_relevance',
'COLUMN', N'uid'
GO
EXEC sp_addextendedproperty
'MS_Description', N'建立时间',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat_relevance',
'COLUMN', N'dateline'
GO
EXEC sp_addextendedproperty
'MS_Description', N'微信用户关系表',
'SCHEMA', N'dbo',
'TABLE', N'{[FoundPHP]}user_wechat_relevance'
GO

-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}admin_group
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}admin_group] ADD CONSTRAINT [PK__{[FoundPHP]}admin__58CB3097B51F74ED] PRIMARY KEY CLUSTERED ([agid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}admin_user
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}admin_user] ADD CONSTRAINT [PK__{[FoundPHP]}admin__3213E83FCA9B7F30] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}article_data
-- ----------------------------
CREATE NONCLUSTERED INDEX [aid]
ON [dbo].[{[FoundPHP]}article_data] (
  [cate_id] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}article_data
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}article_data] ADD CONSTRAINT [PK__{[FoundPHP]}artic__56B503F0B63CCF93] PRIMARY KEY CLUSTERED ([adid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO

-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}article_vote
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}article_vote] ADD CONSTRAINT [PK__{[FoundPHP]}artic__5AB34A35E8FE1905] PRIMARY KEY CLUSTERED ([avid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}article_vote_logs
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}article_vote_logs] ADD CONSTRAINT [PK__{[FoundPHP]}artic__567FE3DA6D5B50CF] PRIMARY KEY CLUSTERED ([avlid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}articles
-- ----------------------------
CREATE NONCLUSTERED INDEX [cate_id]
ON [dbo].[{[FoundPHP]}articles] (
  [cate_id] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}articles
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}articles] ADD CONSTRAINT [PK__{[FoundPHP]}artic__DE508E2EF5CA996F] PRIMARY KEY CLUSTERED ([aid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}articles_likes
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}articles_likes] ADD CONSTRAINT [PK__{[FoundPHP]}artic__58B503F89CB8479B] PRIMARY KEY CLUSTERED ([alid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}articles_relation
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}articles_relation] ADD CONSTRAINT [PK__{[FoundPHP]}artic__5DB3DCFB84E8C620] PRIMARY KEY CLUSTERED ([arid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}bulletin
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}bulletin] ADD CONSTRAINT [PK__{[FoundPHP]}bulle__DE90ADE70C7C3A81] PRIMARY KEY CLUSTERED ([bid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}category
-- ----------------------------
CREATE NONCLUSTERED INDEX [types]
ON [dbo].[{[FoundPHP]}category] (
  [types] ASC
)
GO
CREATE NONCLUSTERED INDEX [orders]
ON [dbo].[{[FoundPHP]}category] (
  [orders] ASC
)
GO
CREATE NONCLUSTERED INDEX [fid]
ON [dbo].[{[FoundPHP]}category] (
  [fid] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}category
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}category] ADD CONSTRAINT [PK__{[FoundPHP]}categ__34EAD173F44FFAD0] PRIMARY KEY CLUSTERED ([cate_id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}language
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}language] ADD CONSTRAINT [PK__{[FoundPHP]}langu__DE105D07A769B646] PRIMARY KEY CLUSTERED ([lid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}logs
-- ----------------------------
CREATE NONCLUSTERED INDEX [uid]
ON [dbo].[{[FoundPHP]}logs] (
  [uid] ASC
)
GO
CREATE NONCLUSTERED INDEX [fid]
ON [dbo].[{[FoundPHP]}logs] (
  [fid] ASC
)
GO
CREATE NONCLUSTERED INDEX [years]
ON [dbo].[{[FoundPHP]}logs] (
  [years] ASC
)
GO
CREATE NONCLUSTERED INDEX [months]
ON [dbo].[{[FoundPHP]}logs] (
  [months] ASC
)
GO
CREATE NONCLUSTERED INDEX [days]
ON [dbo].[{[FoundPHP]}logs] (
  [days] ASC
)
GO
CREATE NONCLUSTERED INDEX [m]
ON [dbo].[{[FoundPHP]}logs] (
  [m] ASC
)
GO
CREATE NONCLUSTERED INDEX [a]
ON [dbo].[{[FoundPHP]}logs] (
  [a] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}logs
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}logs] ADD CONSTRAINT [PK__{[FoundPHP]}logs__3213E83F54A18BED] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}setting
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}setting] ADD CONSTRAINT [PK__{[FoundPHP]}setti__14B092A39D0F3BEF] PRIMARY KEY CLUSTERED ([set_id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}sys_link
-- ----------------------------
CREATE NONCLUSTERED INDEX [link_us]
ON [dbo].[{[FoundPHP]}sys_link] (
  [link_us] ASC,
  [link_id] ASC
)
GO
CREATE NONCLUSTERED INDEX [link_type]
ON [dbo].[{[FoundPHP]}sys_link] (
  [link_type] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}sys_link
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}sys_link] ADD CONSTRAINT [PK__{[FoundPHP]}sys_l__32DDFDCF3C8A83BD] PRIMARY KEY CLUSTERED ([slid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}temp
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}temp] ADD CONSTRAINT [PK__{[FoundPHP]}temp__BAAB326183CDB402] PRIMARY KEY CLUSTERED ([tmpid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}upfiles
-- ----------------------------
CREATE NONCLUSTERED INDEX [uid]
ON [dbo].[{[FoundPHP]}upfiles] (
  [uid] ASC
)
GO
CREATE NONCLUSTERED INDEX [aid]
ON [dbo].[{[FoundPHP]}upfiles] (
  [aid] ASC
)
GO
CREATE NONCLUSTERED INDEX [fid]
ON [dbo].[{[FoundPHP]}upfiles] (
  [fid] ASC
)
GO
CREATE NONCLUSTERED INDEX [cid]
ON [dbo].[{[FoundPHP]}upfiles] (
  [cid] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}upfiles
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}upfiles] ADD CONSTRAINT [PK__{[FoundPHP]}upfil__3213E83F626A0606] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}user
-- ----------------------------
CREATE NONCLUSTERED INDEX [fid]
ON [dbo].[{[FoundPHP]}user] (
  [fid] ASC
)
GO
CREATE NONCLUSTERED INDEX [types]
ON [dbo].[{[FoundPHP]}user] (
  [types] ASC
)
GO
CREATE NONCLUSTERED INDEX [states]
ON [dbo].[{[FoundPHP]}user] (
  [states] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}user
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}user] ADD CONSTRAINT [PK__{[FoundPHP]}user__3213E83F558036A4] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}user_wechat
-- ----------------------------
CREATE NONCLUSTERED INDEX [uid]
ON [dbo].[{[FoundPHP]}user_wechat] (
  [uid] ASC
)
GO
CREATE NONCLUSTERED INDEX [openid]
ON [dbo].[{[FoundPHP]}user_wechat] (
  [openid] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}user_wechat
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}user_wechat] ADD CONSTRAINT [PK__{[FoundPHP]}user___7E185C6458110650] PRIMARY KEY CLUSTERED ([uwid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
-- ----------------------------
-- Indexes structure for table {[FoundPHP]}user_wechat_relevance
-- ----------------------------
CREATE NONCLUSTERED INDEX [idtypes]
ON [dbo].[{[FoundPHP]}user_wechat_relevance] (
  [idtypes] ASC
)
GO
CREATE NONCLUSTERED INDEX [uid]
ON [dbo].[{[FoundPHP]}user_wechat_relevance] (
  [uid] ASC
)
GO
CREATE NONCLUSTERED INDEX [weid]
ON [dbo].[{[FoundPHP]}user_wechat_relevance] (
  [weid] ASC
)
GO
CREATE NONCLUSTERED INDEX [fid]
ON [dbo].[{[FoundPHP]}user_wechat_relevance] (
  [fid] ASC
)
GO
-- ----------------------------
-- Primary Key structure for table {[FoundPHP]}user_wechat_relevance
-- ----------------------------
ALTER TABLE [dbo].[{[FoundPHP]}user_wechat_relevance] ADD CONSTRAINT [PK__{[FoundPHP]}user___61DE6091F6EED68C] PRIMARY KEY CLUSTERED ([uwrid])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO
