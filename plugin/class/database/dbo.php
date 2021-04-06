<?php
/*	(C)2006-2021 FoundPHP Framework.
*	   name: Database Object
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: v3.210406
*	  start: 2006-05-24
*	 update: 2021-04-06
*	payment: Free 免费
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

//驱动处理
class FoundPHP_dbo{
	var $dbtype		= '';
	var $sql_list	= '';
	var $sql_num	= 0;
	var $error		= 0;		//1表示禁止报错
	var	$cache_dir	= './';
	var $lang		= array(
			'not_support'		=> '抱歉，不支持您设置的数据库。',
			'mariadb_error'		=> 'mariadb 或没有开启mysqli。',
			'odbc_driver'		=> 'SQL Server 缺少ODBC驱动<br>PHP 驱动:http://go.microsoft.com/fwlink/?LinkId=163712<br>ODBC驱动:https://docs.microsoft.com/zh-cn/sql/connect/odbc/download-odbc-driver-for-sql-server?view=sql-server-ver15',
			'ser_not_support1'	=> '您的服务器不支持 ',
			'ser_not_support2'	=> '数据库。',
			'not_drive1'		=> '无法载入 ',
			'not_drive2'		=> '数据库驱动。',
			'connect_success'	=> '数据库连接成功',
			'connect_die'		=> '数据库连接失败',
			'connect_pwssword'	=> '连接密码错误',
			'connect_check'		=> '请检查数据库设置。',
			'db_insert'			=> ' 插入id： ',
			'db_close'			=> ' 数据库关闭。',
			'page_total1'		=> '共有',
			'page_total2'		=> '条',
			'front_5'			=> '前5页',
			'next_5'			=> '后5页',
			'first_page'		=> '第一页',
			'last_page'			=> '最后一页',
			'debug_title'		=> '调试平台',
			'debug_db'			=> '数据库',
			'debug_server'		=> '技术支持',
			'debug_support'		=> '数据库',
			'debug_dbname'		=> '库名',
			'debug_user'		=> '帐号',
			'debug_code'		=> '编码',
			'debug_total'		=> '数据查询',
			'debug_run'			=> '执行语句：',
			'debug_num'			=> '条',
			'debug_time'		=> '运行时间: ',
		);
	/**
	*  处理数据库载入单元
	*/
	function __construct($set=array()){
		//debug 文件目录
		$this->debug_file	= @$set['sqllog'];
		//当前数据库类型
		$this->dbtype		= strtolower($set['dbtype']);
		//载入语言包
		if (isset($set['lang'])){
			$dblang			= dirname(__FILE__).'/language/dbo_'.$set['lang'].'.php';
			if (is_file($dblang)){
				include_once($dblang);
				$this->lang	= $FoundPHP_DB_Lang;
			}
		}
		if (!empty($set['cache'])){
			$this->cache_dir= $set['cache'];
		}
		//服务器检测
		switch($this->dbtype){
			case'mysql':
			case'mysqli':
				$this->db_name	= 'MYSQL';
				$this->dbtype	= function_exists('mysqli_connect')?'mysqli':'mysql';
				$func_name 		= $this->dbtype.'_connect';
			break;
			case'mariadb':
				$this->db_name	= 'MariaDB';
				$func_name 		= 'mysqli_connect';
			break;
			case'sqlsrv':
				$this->db_name	= 'SQL Server';
				$func_name		= $this->dbtype.'_connect';
			break;
			case'sqlite':
				$this->db_name	= 'SQLite3';
				$this->dbtype	= 'sqlite3';
				$func_name		= $this->db_name;
			break;
			case'pgsql':
				$this->db_name	= 'PostgreSQL';
				$func_name		= 'pg_connect';
			break;
			case'redis':
				$func_name		= $this->db_name	= 'Redis';
				if (class_exists('Redis')==false){
					$error		= $this->lang['not_support'].'['.$func_name.']';
					function_exists('foundphp_error')?foundphp_error($error):die('FoundPHP Error:'.$error);
				}
			break;
			case'memcached':
				$func_name		= $this->db_name	= 'Memcached';
			break;
			default:
				$error		= $this->lang['not_support'];
				function_exists('foundphp_error')?foundphp_error($error):die('FoundPHP Error:'.$error);
		}
		if (!in_array($this->dbtype,array('sqlite','sqlite3','redis','memcached'))){
			if (!function_exists($func_name)){
				if ($this->dbtype=='mariadb'){
					$this->dbtype = $this->lang['mariadb_error'];
				}
				$error	= $this->lang['ser_not_support1'].$this->dbtype.$this->lang['ser_not_support2'];
				function_exists('foundphp_error')?foundphp_error($error):die($error);
			}
		}
		
		//引入驱动
		if(!is_file(dirname(__FILE__)."/".$this->dbtype.".php")){
			$error		= $this->lang['not_drive1'].$this->dbtype.$this->lang['not_drive2'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		include_once dirname(__FILE__)."/".$this->dbtype.".php";
		
		//声明驱动单元
		$FoundPHPclass	= "Dirver_".$this->dbtype;
		$this->DB		= new $FoundPHPclass;
		$dblink			= $this->DB->DBLink($set);
		@$this->dbhost	= $set['dbhost'];
		@$this->dbport	= $set['dbport'];
		if (!empty($set['dbname'])){
			@$this->dbname	= $set['dbname'];
		}
		@$this->dbuser	= $set['dbuser'];
		@$this->charset	= $set['charset'];
		$error			= $this->db_name.' '.$this->lang['connect_die'].' (SERVER:'.$set['dbhost'].((trim($set['dbuser'])=='')?'':' USER:'.$set['dbuser']).((trim($set['dbname'])=='')?'':' DB:'.$set['dbname']).') '.$this->lang['connect_check'];
		switch($dblink){
			case 4://http://go.microsoft.com/fwlink/?LinkId=163712
			echo 1121;
				$error	= $set['dbhost'].' '.$this->lang['odbc_driver'];
				$this->log_write("\n".$error,'#008000');
				function_exists('foundphp_error')?foundphp_error($error):die($error);
			break;
			case 3:
				$error	= $set['dbhost'].' '.$this->lang['connect_pwssword'];
				$this->log_write("\n".$error,'#008000');
				function_exists('foundphp_error')?foundphp_error($error):die($error);
			case 2:
				$this->log_write("\n".$error,'#008000');
				if ($set['install']){
					return $error;
				}else{
					function_exists('foundphp_error')?foundphp_error($error):die($error);
				}
			break;
			default:
				//连接成功写入记录
				$this->log_write("\n".$error,'#008000');
		}
		//运行时间
		if (isset($GLOBALS['tpl'])){
			$this->start_time	= $GLOBALS['tpl']->get_time();
		}
	}
	
	/**
	*  返回数组资料行
	*/
	function rows($query) {
		return $this->fetch_array($this->query($query));
	}
	
	/**
	*  返回数组行
	*/
	function nums($query) {
		return $this->num_rows($this->query($query));
	}
	/**
	* 创建数据库
	*/
	function create_db($db_name){
		$this->DB->create_db($db_name);
	}
	/**
	* 创建表
	* set 表名、注释
	* ary 字段信息
	*/
	function create_table($set=array(),$ary=array()){
		return $this->DB->create_table($set,$ary);
	}
	
	/**
	* 查询全部数据库
	*/
	function show_db(){
		return $this->DB->show_db($db_name);
	}
	
	/**
	* 查询数据库全部表
	*/
	function show_table(){
		return $this->DB->show_table();
	}
	
	/**
	* 查询数据表字段
	*/
	function show_field($table){
		return $this->DB->show_field($table);
	}
	
	
	/**
	*  一个查询字符串
	*  limit大于0则表示限制数据集，小于0则禁止错误调试
	*/
	function query($sql='',$limit=''){
		if (isset($sql)){
			if ($this->db_name!='Redis'){
				$limit	= intval($limit);
			}
			$db_query	= $this->DB->query($sql,$limit);
			if (in_array($this->db_name,array('Redis','Memcached'))){ return $db_query;}
			$query		= $db_query['query'];
			$runtime	= '';
			//执行时间
			if (isset($GLOBALS['tpl'])){
				$runtime = $GLOBALS['tpl']->run_time(3,$this->start_time);
			}
			$this->log_write($db_query['sql']);
			$this->sql_list	.= $db_query['sql'].'&nbsp;&nbsp;<font>'.date('Y-m-d H:i:s ').'<font color="#808000">'.$runtime."</font><br>";
			
			//连接关闭提示
			if (!$query && stristr($sql, 'INSERT') === FALSE && $this->error==0){$this->error($db_query['sql']);}
			if(!$query && $this->error==0){$this->error($db_query['sql']);}
			$this->sql_num++;
			return $query;
		}
	}
	
	
	/**
	*	插入数据表记录行
	*	table	表名
	*	data	插入数据的数组array('username'=>'md-chinese')
	*/
	function insert($table, $data,$types=''){
		if ($this->db_name=='Redis'){
			$this->DB->insert($table, $data,$types);
		}elseif ($this->db_name=='Memcached'){
			$this->DB->insert($table, $data);
		}else{
			$sql_field = implode('`, `', array_keys($data));
			$sql_value = implode("', '",$data);
			if (is_array($data)){
				
				//忽略重复
				if (in_array($this->db_name,array('MYSQLi','MYSQLi','MariaDB')) && $types==1){
					$ignore	= 'IGNORE ';
				}else{
					$ignore	= '';
				}
				return $this->query('INSERT '.@$ignore.'INTO `'.$table .'` (`'.$sql_field.'`) VALUES (\''.$sql_value.'\')');
			}
		}
	}
	
	/**
	*	更新数据表记录行
	*	table	表名
	*	data	插入数据的数组array('username'=>'md-chinese') ,字段加一为 array('views'=>'num+1');
	*	table	条件语句
	*/
	function update($table, $data, $parameters){
		@reset($data);
		$num	= 0;
		foreach (array_keys($data) AS $k=>$v) {
			if(strchr($data[$v],'num+')){
				$num	= preg_replace("/^num\+([0-9]{1,10})$/i","\\1",$data[$v]);
			}
			if ($num>0){
				$attribute[] = "`$v` = $v+".$num;
			}else{
				$attribute[] = "`$v` = '".$data[$v]."'";
			}
		}
		//条件属性
		$parameters = ($parameters)?' WHERE '.$parameters:'';
		if (is_array($attribute)){
			return $this->query('UPDATE `'.$table.'` SET '.implode(",",$attribute).$parameters);
		}
	}
	
	/**
	*  取得返回列的数目
	*/
	function num_rows($query) {
		return $this->DB->num_rows($query);
	}
	
	/**
	*  返回数组资料
	*/
	function fetch_array($query){
		return $this->DB->fetch_array($query);
	}
	
	//返回单列的各字段
	function fetch_row($query) {
		return $this->DB->fetch_row($query);
	}
	
	/**
	*  返回数组资料
	*/
	function list_array($info){
		if($info['query'] && trim($info['seek'])){
			mssql_data_seek($info['query'],$info['seek']);
			return $this->DB->fetch_array($info['query']);
		}else{
			return $this->DB->fetch_array($info['query']);
		}
	}
	
	
	/**
	*  返回最后一次插入指令的 ID
	*/
	function insert_id(){
		$insertid = $this->DB->insert_id();
		$this->log_write(''.$this->db_name.$this->lang['db_insert'].$insertid.')');
		return $insertid;
	}
	
	
	/**
	*  关闭当前数据库连接
	*/
	function close(){
		$this->log_write($this->db_name.$this->lang['db_close']);
		return $this->DB->close();
	}
	
	
	/**
	*  检测数据库版本
	*/
	function version(){
		$ver = $this->DB->version();
		$this->log_write('Get '.$this->db_name.' version number. (Value:'.$ver.')','#000080');
		return $ver;
	}
	
	/**
	*  缓存开始
	*	id		字段名防止多次使用冲突
	*	endtime	缓存数据有效寿命，单位秒
	demo:
		//开始缓存，时间3600秒
		$m		= 'FoundPHP_menu';
		if ($db_sql_cache =$db->cache($m,3600)){
			//获取菜单
			$menu_ary	= article_block("fid=0 AND types='article_cate'");
		}
		extract($db->cache($m));
	*/
	function cache($id='FoundPHP',$endtime=0){
		$cache_file	= $this->cache_dir.(substr($this->cache_dir,-1)!='/'?'/':'').'FoundPHP_DB_'.md5($id).'.php';
		if ($endtime>0 && is_file($cache_file)){
			$ctime	= filemtime($cache_file);
			if (time()-$ctime>$endtime){
				//清除缓存
				unlink($cache_file);
			}
		}
		//建立
		if ($id && (int)$endtime>0){
			$GLOBALS['_db_s']	= 'start';
			return (is_file($cache_file))?0:1;
		}else{
			if (is_file($cache_file)){
				include $cache_file;
				if ($_sqlc){return json($_sqlc);}
			}
			$i = 0;
			$result				= array();
			foreach($GLOBALS AS $k=>$v) {
				unset($cdata['sql']);
				if ($k=='db_sql_cache'){$i=1;}
				if ($i>0){
					$i++;
					$result[$k]	= $v;
					unset($GLOBALS[$k]);
				}
			}
			unset($result['db_sql_cache']);
			if (count((array)$result)>0){
				if (!is_dir($this->cache_dir)){
					$GLOBALS['tpl']->mk_dir($this->cache_dir);
				}
				$GLOBALS['tpl']->writer($cache_file,"<?php \n\$_sqlc = '".str_replace("'","\'",json($result))."';");
			}
			
			return $result;
		}
	}
	
	/**
	*  分页预处理函数
	*  sql		SQL语句
	*  page		当前页数
	*  limit	每页显示的数量
	*  maxs		查询总数
	*/
	function limit($sql,$page='0',$limit=10,$maxs=''){
		$show	= Array();
		$page	= (trim($page)>0)?$page:1;
		$limit	= (trim($limit)>0)?$limit:1;
		$sqls	= $sql	= str_replace('`','',$sql);
		
		//信息数
		if(trim($maxs)==''){
			if (in_array($this->dbtype,array('mysql','mysqli','pgsql'))){
				$order	= preg_replace("/.+(order.+)/i","\\1",$sql);
				if(stristr($order, 'order') !== FALSE){
					$sqls	= str_replace($order,"",$sql);
				}else{
					$order	= '';
					$sqls	= $sql;
				}
				//对关联语句的判断
				if (stristr($sql, ' join ') === FALSE){
					if(stristr($sql, 'where') !== FALSE){
						$new_sql= preg_replace("/SELECT.+FROM \s*(.+)order\s*by.+/is","SELECT COUNT(*) AS cnt FROM \\1",$sql);
						$new_sql= preg_replace("/SELECT.+FROM \s*(.+)group\s*by.+/is","SELECT COUNT(*) AS cnt FROM \\1",$new_sql);
						$new_sql= preg_replace("/SELECT.+FROM \s*(.+)/is","SELECT COUNT(*) AS cnt FROM \\1",$new_sql);
						
					}else{
						$exts	= explode("||",preg_replace("/SELECT.+FROM \s*([A-Za-z0-9_\.\[\]]{1,50})/","SELECT COUNT(*) AS cnt FROM \\1||",$sql));
						$new_sql= $exts['0'];
					}
					
					if(stristr($sql, 'group by')){
						$groups	= trim(preg_replace("/.+group\s*by(.+)/is","\\1",$sql));
						if(stristr($groups, 'group') !== FALSE){
							$groupby1	= explode(' ',$groups);
							$groups	= $groupby1['0'];
						}
						$groupby	= ($groups!='')?' GROUP BY '.$groups:'';
						$Alls = $this->nums($new_sql.$groupby);
					}else {
						if (strstr($new_sql,'COUNT(*) AS') && !stristr($sql,'HAVING')){
							$counts = $this->fetch_array($this->query( $new_sql ));
							$Alls	= $counts['cnt'];
						}else{
							if (stristr($sql,'HAVING')){
								$new_sql	= $sql;
							}
							$Alls = $this->nums($new_sql.$groupby);
						}
					}
				}else{
					$new_sql= preg_replace("/(SELECT.+FROM\s*[a-zA-Z0-9_\.\[\]]+)order\s*by.+/is","\\1",$sql);
					$Alls = $this->num_rows($this->query($new_sql ));
				}
			}else{
				//统计数据总数
				switch($this->dbtype){
					case'sqlsrv':
						//计算总行数
						$counts	= $this->num_rows($this->query($sql,-1));
						$Alls	= $counts;
					break;
				}
			}
		}else{
			$Alls	= $maxs;
		}
		//处理分了几页
		$max_page	= (int)ceil($Alls/$limit);
		$seek		= (($page > $max_page)? $max_page-1: $page-1)*$limit;
		$seek		= ($seek<=0)?0:$seek;
		
		switch($this->dbtype){
			case'sqlsrv':
				if ($this->DB->version(1)>=2012){
					$query_sql		= $sql.(stristr($sql,'order by ')?'':' order by id')." offset ".$seek." rows fetch next ".$limit." rows only;";
				}else{
					$seek_start	= ($page>1)?($seek+1):$seek;
					//关联查询
					if (stristr($sql,' join ')){
						$sql		= str_ireplace('order by ','ORDER BY ',$sql);
						$sql		= str_ireplace(' from ',' FROM ',$sql);
						$sql_ex		= explode('ORDER BY ',$sql);//
						$sql		= str_replace(' FROM ',',ROW_NUMBER() OVER (ORDER BY '.$sql_ex[1].') AS FPNum FROM ',$sql_ex[0]);
						$query_sql	= 'SELECT * FROM ('.$sql.') FoundPHP WHERE FoundPHP.FPNum BETWEEN '.$seek_start.' and '.($limit);
					}else{
						$sql		= str_ireplace('order by ','ORDER BY ',$sql);
						$sql		= str_ireplace(' from ',' FROM ',$sql);
						$sql_ex		= explode('ORDER BY ',$sql);//
						$sql		= str_replace(' FROM ',',ROW_NUMBER() OVER (ORDER BY '.$sql_ex[1].') AS FPNum FROM ',$sql_ex[0]);
						$query_sql	= 'SELECT * FROM ('.$sql.') FoundPHP WHERE FoundPHP.FPNum BETWEEN '.$seek_start.' and '.($limit+$seek);
					}
				}
			break;
			case'pgsql':
				$query_sql	= "$sql LIMIT $limit OFFSET ".$seek;
			break;
			default:
				$query_sql	= "$sql LIMIT ".$seek.",$limit";
		}
		
		$show['query']	= $this->query($query_sql);			//执行语句
		
		$show['info']	= array(
		"limit"		=> intval($limit),				//每页的分页数
		"nowlimit" 	=> intval(count($show)),		//列出当前的信息数
		"nowpage"	=> intval(($page > $max_page)? $max_page:$page),
		"pages"		=> intval($max_page),			//分了几页
		"nums"		=> intval($Alls),				//当前查询中最大信息数
		);
		return $show;
	}
	
	/**
	*  显示详细的SQL语句
	*/
	function sql_debug(){
			$sql_data = '';
			$sql_list = $this->color($this->sql_list);
			unset($ks,$vs);
			foreach (explode("<br><hr id='DL_EeeFrame'>",$sql_list) AS $ks=>$vs) {
				if(trim($vs)!=''){
					$sql_data .= '<tr colspan="5"><td bgcolor="#FFFFFF" colspan="5">'.$vs.'</td></tr>';
				}
			}
		echo '<table style="border-collapse: collapse;" align="center" width="100%" border="1" bordercolor="#D2E1D9" cellpadding="3">
		<tr bgcolor="#b2d4df">
		<td colspan="5" align="left"style="padding:5px"><a href="http://DB.FoundPHP.com" target="_blank"><font style="font-size: 16px;" color="#000000"><b>FoundPHP DataBase Object '.$this->lang['debug_title'].' (Power by FoundPHP.com)</b></a>
		</tr><tr>
		<td style="font-size: 13px;" bgcolor="#EAF4EA">'.$this->lang['debug_db'].':<b> '.$this->db_name.' '.$this->version().'</b></td>
		<td style="font-size: 13px;" bgcolor="#EAF4EA">'.$this->lang['debug_server'].':<b> '.$this->dbhost.'</b></td>
		<td style="font-size: 13px;" bgcolor="#EAF4EA">'.$this->lang['debug_support'].':<b> <a href="http://DB.FoundPHP.com" target="_blank">DB.FoundPHP.com</a></b></td>
		</tr>';
		if (!empty($this->dbname) && !empty($this->dbuser)){
		echo '<tr><td style="font-size: 13px;" bgcolor="#EAF4EA">'.$this->lang['debug_dbname'].':<b> '.$this->dbname.'</b></td>
		<td style="font-size: 13px;" bgcolor="#EAF4EA">'.$this->lang['debug_user'].':<b> '.$this->dbuser.'</b></td>
		<td style="font-size: 13px;" bgcolor="#EAF4EA">'.$this->lang['debug_code'].':<b> '.$this->charset.'</b></td></tr>';
		}
		echo '<tr bgcolor="#fff">
			<td colspan="5" align="left" style="color:#475054"><font style="font-size: 14px;"><b>'.$this->lang['debug_total'].'</b></font>（'.$this->lang['debug_run'].$this->sql_num.$this->lang['debug_num'].'）</td>
		</tr>
		<tr colspan="5"><td bgcolor="#FFFFFF" colspan="5" style="font-size: 13px;padding:5px;">'.str_replace('<br>','<br>'.$this->lang['debug_time'],$sql_list).'</td></tr></table><br>';
	}
	
	
	/**
	*  SQL语句色彩处理
	*/
	function color($show){
			$show = str_replace('<br>', "<hr style=margin:1px>\r\n", $show);
			$show = preg_replace("#SELECT(.+\s)FROM#i", 'SELECT<font color=#AA4F51>\\1</font> FROM',$show);
			$show = preg_replace( "#\s{1,}(AND|OR|ON|<>)\s{1,}#i", " <font color=dodgerblue>\\1</font> "    , $show );
			$show = preg_replace( "#\s{1,}(FROM|INTO|UPDATE|JOIN)\s([`a-zA-Z0-9_]+)\s#is", " \\1<font color=#4172A3>&nbsp;<u>\\2</u>&nbsp;</font>" , $show);
			$show = preg_replace('#(SELECT)\s*#i', '<font color=deepskyblue>\\1</font> ', $show);
			$show = preg_replace('#^(DELETE)\s*#i', '<font color=red><b>\\1</b></font> ', $show);
			$show = preg_replace('#(INSERT\s*INTO|\sVALUES|UPDATE\s)#i', '<font color=#1ABB9C>\\1</font>', $show);
			$show = preg_replace("#\s(LEFT\sJOIN|RIGHT\sJOIN)#i", ' <font color=salmon>\\1</font>', $show);
			$show = preg_replace("#(FROM|WHERE|\sLIMIT|\sSET|\sORDER\sBY|\sASC|\sDESC|\sAS|\sIN\s)#i", '<font color=#18A3F5>\\1</font>' , $show );
			$show = str_replace('&nbsp;&nbsp;<font>', '&nbsp;<br><font style=color:#999>', $show);
		return $show;
	}
	
	
	/**
	*  错误处理机制
	*/
	function error($sql='',$e_id='',$e_msg=''){
		include_once dirname(__FILE__).'/error.php';
			//错误类别细节分析
			switch($this->dbtype){
				case'sqlite3':
					$error		= $this->DB->LinkID->lastErrorCode();
					$error_msg	= $this->DB->LinkID->lastErrorMsg();
				break;
				case'mysql':
					$error		= mysql_errno($this->DB->LinkID);
					$error_msg	= (mysql_error()=='')?'N/A':mysql_error($this->DB->LinkID);
				break;
				case'mysqli':
					$dblink		= $this->DB->LinkID;
					$GLOBALS['_SERVER']['REMOTE_ADDR']	= $dblink->host_info;
					$error			= $dblink->errno;
					$error_msg	= ($dblink->error=='')?'N/A':$dblink->error;
					$states		= $dblink->stat;
				break;
				case'pgsql':
					$error_msg	= (pg_last_error($this->DB->LinkID)=='')?'N/A':pg_last_error($this->DB->LinkID);
				break;
				case'sqlsrv':
					$error_info	= sqlsrv_errors();
					$error 		= $error_info['0']['code'];
					$error_msg	= $error_info['0'][ 'message']?$error_info['0'][ 'message']:'N/A';
				break;
				default:
					$error		= 5178;		//未知语句错误
					$error_msg	= 'There are mistakes in the current sentence, please check the spelling.';
			}
		//指定错误信息则载入系统错误信息
		if (trim($e_msg)!=''){
			$error		= $e_id;
			$error_msg	= $e_msg;
		}
		//linux 下调试信息
		if (!empty($GLOBALS['_SERVER']['PWD'])){
			new DB_Error($sql,$this->db_name,$error,$error_msg,$states);
		}else{
			new DB_Error($this->color($sql),$this->db_name,$error,$error_msg,$states);
		}
	}
	
	/**
	*  log日志系统
	*/
	function log_write($sql,$color=''){
		if (is_dir($this->debug_file)){
			//缓存目录检测以及运行模式
			$chmods = @substr(@sprintf('%o', @fileperms($this->debug_file)), -3);
			
			if (in_array($chmods,array(777,644))){
				
				//文字增加颜色
				//$sql = '$sql_log[] = array(\'type\'=>\''.$this->db_name."','time'=>'".date('Y-m-d H:i:s')."','sessionid'=>'".session_id()."','query'=>'".base64_encode($sql)."','url'=>'http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."');\n";
				$sql 	= "db:$this->db_name\tdate:".date('Y-m-d H:i:s')."\turl:http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\n".$sql."\n";
				
				$GLOBALS['tpl']->writer($this->debug_file.'/'.date("ymd").'_sql.txt',$sql,'a+');
			}
		}
	}
}

	//sql关联查询
	function sql_join(){
		if (count($GLOBALS['table'])>1){
			foreach($GLOBALS['table'] AS $k=>$v) {
				if ($v){
					if($k=='a'){
						$sql[] 	= table($v).' '.$k;
					}
					if(@$GLOBALS['ljoin'][$k] && @$GLOBALS['ljoin'][$k]){
						$sql[]	= table($v).' '.$k.($GLOBALS['ljoin'][$k]!=''?' ON '.$GLOBALS['ljoin'][$k]:'');
					}
				}
			}
			$table		= implode(' LEFT JOIN ',$sql);
		}else{
			$table		= table($GLOBALS['table']['a']);
		}
		$sql			= 'SELECT '.$GLOBALS['t_field'].' FROM '.$table;
		if (function_exists('session')){
			session('search_sql',$sql,600);
		}
		return $sql;
	}
	
 	//简单的数据查询
	function sql_select($ary=''){
		global $db;
		
		//单一语句
		if (isset($ary['where']) && trim($ary['where'])!=''){
			$where	= sql_where($ary['where']);
		}else{
			$where	= '';
		}
		$order	= ' '.(isset($ary['group']) && $ary['group']!=''?' GROUP BY '.$ary['group'].' ':'').(isset($ary['order']) && $ary['order']!=''?'ORDER BY '.$ary['order']:'');
		if(@$ary['sql']!=''){
			$sql= $ary['sql'];
		}else {
			//统计输出语句
			if($ary['type']=='count'){
				$select = "SELECT count(*) AS cnt FROM ";
			}else {
				$field	= (@$ary['field']!=''?$ary['field']:'*');
				
				$select = "SELECT $field FROM ";
			}
			$sql= $select.table($ary['table']);
		}
		//记录sql列表语句
		if (@isset($GLOBALS['a']) && @$ary['type']=='sql'){
			if (isset($ary['where'])){
				$wheres	= sql_where($ary['where'],1);
				$session_data['where']	= $ary['where'];
			}
			
			if (function_exists('session')){
				$session_data['sql']	= $sql;
				$session_data['order']	= isset($ary['order']) && $ary['order']!=''?$ary['order']:'';
				$session_data['group']	= isset($ary['group']) && $ary['group']!=''?$ary['group']:'';
				session('search_data',$session_data);
			}
		}
		//直接输出sql
		if(@$ary['type']=='sql'){
			return $sql.$where.$order;
		}
		//统计数据
		if(@$ary['type']=='num'){
			return $db->nums($sql.$where.$order);
		}
		return $db->rows($sql.$where.$order);
	}
	
	//获得查询条件
	function sql_where($where='',$set=0){
		global $db;
		if(is_array($where)){
			unset($ks,$vs);
			foreach ($where AS $ks=>$vs) {
				if($vs!=''){
					$wheres[] = " $ks LIKE '%$vs%'";
				}
			}
			//根据条件重组查询语句
			if(is_array($wheres)){
				$where = implode(' AND ',$wheres);
			}
		}
		return ($set!=1 && $where?' WHERE '.$where:$where);
	}
	
	/**
	*	插入或更新数据
	*	当存在where条件的时候就为更新数据
	*/
	function sql_update_insert($ary=''){
		global $db,$dbo_msg;
		//没有数据
		if(count($ary['data'])<=0){
			return false;
		}
		foreach($ary['data'] AS $k=>$v) {
			$ary['data'][$k]	= str_replace(array("\\","'"),array("\\\\","\'"),$v);
		}
		if(@$ary['where']!=''){
			return $db->update(table($ary['table']),$ary['data'],$ary['where']);
		}else {
			//重复效验
			if (@is_array((array)$ary['check'])){
				unset($k,$v);
				$w		= array();
				foreach (@(array)$ary['check'] AS $k=>$v) {
					$w[]= "`$k`='".str_replace(array("\\","'"),array("\\\\","\'"),$v)."'";
				}
				if ($w){
					$ck = $db->rows("SELECT count(*) AS cnt FROM ".table($ary['table'])." WHERE ".implode(' AND ',$w));
					//如果存在则提示
					if (@$ck['cnt']>=1){
						return false;
					}
				}

				$types	= 0;
			}else{
				//忽略数据
				$types	= 1;
			}
			return $db->insert(table($ary['table']),$ary['data'],$types);
		}
	}
	
	/**
	*	插入或更新数据
	*	ary
			table	更新数据表
			data	二维数组，支持多组更新
				set		设置更新资料
				where	设置更新条件
				
				set		设置更新资料
				where	设置更新条件
		示例：
		//更新统计
		sql_update_count(array('table' =>'category','data'=>array(
			array(
			'set'	=>array('nums'=>1),
			'where'	=>"cid='2'"
			),
			array(
			'set'	=>array('nums'=>1),
			'where'	=>"cid='1'"
			)
		)));
	*/
	function sql_update_count($ary=''){
		global $db,$dbo_msg;
		//没有数据
		if(count($ary['data'])<=0 || trim($ary['table'])==''){
			return false;
		}
		foreach($ary['data'] AS $k=>$v) {
			$db->update(table($ary['table']),$v['set'],$v['where']);
		}
	}
	
	//删除数据
	function sql_del($ary=''){
		global $db;
		$sql	= "DELETE FROM ".table($ary['table']).sql_where($ary['where']);
		return $db->query($sql);
	}
	
	//数据库名称处理
	function table($name=''){
		switch(strtolower($GLOBALS['config']['db']['dbtype'])){
			//SQL Server
			case'sqlsrv':
				return $GLOBALS['config']['db']['pre'].$name;
			break;
			default:
				return $GLOBALS['config']['db']['pre'].$name;
		}
	}
	
	//系统通用分页
	function limit($sql='',$num=0,$dbo=''){
		global $db,$_GET,$sys_set;
		if($sql!=''){
			if (function_exists('session')){
				//批量导出用途
				$search = session('search_data');
				if ($search['sql']){
					session('search_sql',$search['sql']);
					if ($search['where']){
						session('search_where',$search['where']);
					}
					if ($search['order']){
						session('search_order',$search['order']);
					}
				}
			}
			//区分前后台分页
			$nums		= ((int)$num<=0)?20:$num;
			if ($dbo){
				return $dbo->limit($sql, @$_GET['p'], $nums);
			}else{
				return $db->limit($sql, @$_GET['p'], $nums);
			}
		}
	}
	
	/**
	*  分页方法
	*	@param array		info 		分页数组
						nums		获得数据数量
						limit		每页分多少信息数
						nowpage		当前页数
						pages		得到分页数量
	*	@param array		set 		
					js		呼叫当前页面的JavaScript funciton page(id);
					url		连接地址,{page}表示分页页数其他用设置连接
					show	0 默认分页也显示数量，1 没有分页不显示
					
	*	@return string
	
	example:
			$sql = "SELECT * FROM videos_list WHERE v_user='$us[username]' ORDER BY ".$orders;
			$info = $db->limit($sql,$page,10);
			$data_list = $info['query'];		//数据查询query
			$pages = pages($info['info']);
	*/
	function pages($info,$set=array()) {
		global $_SERVER,$target,$keys,$page_adds,$config,$db;
		//信息接收处理
		$num		= $info['nums'];
		$perpage	= $info['limit'];
		$curr_page	= $info['nowpage'];
		$pages 		= $info['pages'];
		
		$now_url	= $_SERVER['SCRIPT_NAME'].($_SERVER['QUERY_STRING']!=''?'?'.$_SERVER['QUERY_STRING']:'');
		
		//载入语言包
		$lang	= $GLOBALS['FoundPHP_DB_Lang'];
		
		$mpurl = preg_replace("/&p=[0-9]+/is","",$now_url);
		$mpurl = preg_replace("/&g=success/is","",$mpurl);
		
		//自定义网址
		if (@$set['url']){
			$mpurl	= $set['url'];
		}
		
		
		$mpurl		= explode("{page}",$mpurl);
	
		$mpurl1		= $mpurl['0'].(@$set['url']?'':'&p=');
		$mpurl2		= @$mpurl['1'];
		$mpurl3		= (@$mpurl2=='')?'':"+'$mpurl2'";
		
		//根据搜索
		$mpurl2		= $mpurl2.((trim($keys))?'&k='.$k:'');
		
		$multipage = '';
		if($num > $perpage){
			$page = 5;
			$offset = 2;

			$from = $curr_page - $offset;
			$to = $curr_page + $page - $offset - 1;
			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				if($from < 1) {
					$to = $curr_page + 1 - $from;
					$from = 1;
					if(($to - $from) < $page && ($to - $from) < $pages) {
						$to = $page;
					}
				} else if($to > $pages) {
					$from = $curr_page - $pages + $to;
					$to = $pages;
					if(($to - $from) < $page && ($to - $from) < $pages) {
						$from = $pages - $page + 1;
					}
				}
			}
			
			if(strchr($mpurl1,'?')){
				$mpurl1 .= '';
			}else {
				$mpurl1 .= '?';
			}
			if (empty($set['js'])){$set['js'] = '';}
			
			$show_num	= $num>0?'<li><a href="#" onclick="return false;">'.$db->lang['page_total1'].number_format($num,0).$db->lang['page_total2'].'</a></li>':'';
			$multipage .= '<nav class="text-center pagenav"><ul class="pagination">'.$show_num;
			if(($curr_page-5)<=1){$pt= 1;}else{$pt=$curr_page-5;}
			$multipage .= "<li><a ".($set['js']?'onclick="'.$set['js'].'(\''.sys_link($mpurl1.'1'.$mpurl2).'\');return false;"':"href='".sys_link($mpurl1.'1'.$mpurl2)."'")."><<</a></li>\n";
			if ($curr_page>1){
				$multipage .= "<li><a ".($set['js']?'onclick="'.$set['js'].'(\''.$mpurl1.$pt.$mpurl2.'\');return false;"':"href=\"$mpurl1$pt$mpurl2\"")." title=\"".$db->lang['front_5']."\" alt=\"".$db->lang['front_5']."\"><</a></li>\n";
			}
			for($i = $from; $i <= $to; $i++) {
				if($i != $curr_page) {
					$multipage .= "<li><a ".($set['js']?'onclick="'.$set['js'].'(\''.sys_link($mpurl1.$i.$mpurl2).'\');return false;"':"href='".sys_link($mpurl1.$i.$mpurl2)."'").">$i</a></li>";
				} else {
					$multipage .= "<li class=\"active\"><a href='javascript:;'>$i</a></li>";
				}
			}
			
			if(($curr_page+5)>=$pages){$pd= $pages;}else{$pd=$curr_page+5;}
			$multipage .= "<li><a ".($set['js']?'onclick="'.$set['js'].'(\''.sys_link($mpurl1.$pd.$mpurl2).'\');return false;"':"href=\"".sys_link($mpurl1.$pd.$mpurl2)."\"")." title=\"".$db->lang['next_5']."\" alt=\"".$db->lang['next_5']."\">></a></li>";
			$multipage .= "<li><a ".($set['js']?'onclick="'.$set['js'].'(\''.sys_link($mpurl1.$pages.$mpurl2).'\');return false;"':"href='".sys_link($mpurl1.$pages.$mpurl2)."'").">>></a></li></ul>\n";
		}else{
			if (@$set['show']!=1 && $num){
				$multipage .= '<nav class="text-center pagenav"><ul class="pagination"><li><a href="#" onclick="return false;">'.$db->lang['page_total1'].$num.$db->lang['page_total2'].'</a></li></ul></nav>';
			}
		}
		//检测是否需要连接控制
		if(trim($target)!=''){
			$multipage	= str_replace("<a ","<a target='".$target."' ",$multipage);
		}
	  return $multipage;
	}
	
	if (!function_exists('sys_link')){
		function sys_link($url=''){return $url;}
	}
?>