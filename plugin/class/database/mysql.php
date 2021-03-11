<?php
/*	(C)2006-2021 FoundPHP Framework.
*	   name: Database Object
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: v3.201212
*	  start: 2006-05-24
*	 update: 2020-12-12
*	payment: Free 免费
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

Class Dirver_mysql{
	//连接数据库
	function DBLink($dba=''){
		$this->LinkID = (@$dba['pconnect'] == 1)? @mysql_pconnect($dba['dbhost'].($dba['dbport']!=''?':'.$dba['dbport']:':3306'), $dba['dbuser'], $dba['dbpass']) : @mysql_connect($dba['dbhost'], $dba['dbuser'], $dba['dbpass']);
		if (!$this->LinkID){ return 2; }
		
		//选择连接数据库
		if (!@mysql_select_db($dba['dbname'], $this->LinkID)){ return 2; }
		
		$this->charset	= $dba['charset'];
		$this->set_names= 0;
		return $this->LinkID;
	}
	
	//查询语句
	function query($query,$limit='') {
		//字符集处理
		if($this->version() > '4.1') {
			$charset = (in_array(strtolower($this->charset), array('gbk', 'big5', 'utf-8')))?$this->charset:'utf-8';
			@mysql_query("SET NAMES '".str_replace('-', '', $this->charset)."'",$this->LinkID);
		}
		
		//检测如果有限制数据集则处理
		if($limit>0){
			$query = $query.' LIMIT '.$limit;
		}
		//时间处理
		if (stristr($query, "now()") !== FALSE){
			$query = preg_replace("/(.*)\'now\(\)\'(.*)/is","\\1now()\\2",$query);
		}
		return array('query'=>mysql_query($query,$this->LinkID),'sql'=>$query);
	}
	
	//返回数组资料
	function fetch_array($query) {
		return @mysql_fetch_array($query, MYSQL_ASSOC);
	}
	
	//取得返回列的数目
	function num_rows($query){
		return @mysql_num_rows($query);
	}
	
	//返回最后一次使用 INSERT 指令的 ID
	function insert_id(){
		return @mysql_insert_id($this->LinkID);
	}
	//创建数据库表
	function create_table($set=array(),$ary=array()){
		//数组符合要求
		foreach($ary AS $k=>$v){
			$sql 	= '';
			if(count($v)==10){
				//拼接语句
				$sql .= "`$v[field]` $v[types] ";
				if($v['length']>0){
					$sql .= "($v[length])";//长度
				}
				if($v['attr']){
					$sql .= " $v[attr] ";//属性
				}
				if($v['null']>0){	//是否定义空
					$sql .= " NULL ";
				}else{
					$sql .= " NOT NULL ";
				}
				//默认值
				if($v['default']!=''){
					$sql .= " DEFAULT '".$v['default']."'";
				}
				//是否自增
				if($v['extra']==1){
					$sql .= " AUTO_INCREMENT ";
				}
				//字段注释
				if($v['comment']){
					$sql .= " COMMENT '$v[comment]'";
				}
				//主键
				if($v['key_index']){
					
					$sql_key[] = $v['key_index']." KEY (`$v[field]`)";
				}
				
				$sql_ary[]	= $sql;
			}
		}
		$query 	= "CREATE TABLE IF NOT EXISTS `".$set['table']."` (";
		$query	.= implode(',',$sql_ary).",";
		$query	.= implode(' , ',$sql_key);
		$query 	.= ")ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='".$set['comment']."';";//='管理员组' AUTO_INCREMENT=57 
		$this->query($query);
	}
	//创建数据库
	function create_db($dbname){
		$this->query("CREATE DATABASE ".$dbname);
	}
	//列出数据库
	function show_db(){
		$query 	 = $this->query("SHOW DATABASES ");
		while($r = $this->fetch_array($query['query'])){
			$result[] = $r['Database'];
		}
		return $result;
	}
	//列出数据表字段
	function show_field($table){
		$query = $this->query("SHOW  FULL FIELDS FROM `$table`");
		while($dls = $this->fetch_array($query['query'])){
				//转为小写
			foreach($dls AS $k=>$v){
				$ks = strtolower($k);
				$dls[$ks] = $v;
				unset($dls[$k]);
			}
			$result[]	= $dls;
		}
		return $result;
	}
	//列出数据库表
	function show_table(){
		$query =  $this->query("SHOW TABLE STATUS");
			$table_ary	= array();
		while($dls = $this->fetch_array($query['query'])){
			//转为小写
			foreach($dls AS $k=>$v){
				$ks = strtolower($k);
				$dls[$ks] = $v;
				unset($dls[$k]);
			}
			$result[]	= $dls;
		}
		return $result;
	}
	//关闭当前数据库连接
	function close(){
		return @mysql_close($this->LinkID);
	}
	
	//检测mysql版本
	function version(){
		$query = @mysql_query("SELECT VERSION()",$this->LinkID);
		return	@mysql_result($query, 0);
	}
}
?>