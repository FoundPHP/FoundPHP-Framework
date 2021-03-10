<?php
/*	(C)2006-2020 FoundPHP Framework.
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

Class Dirver_sqlite3{
	var $Lists		= '';
	var $nums		= 0;
	//连接数据库
	function DBLink($dba=''){
		$this->LinkID = new SQLite3($dba['dbhost'].$dba['dbname']);
		$this->set_names= 0;
		return $this->LinkID;
	}
	
	//查询创建编辑语句
	function query($query,$limit='') {
		//检测如果有限制数据集则处理
		if($limit>0){
			$query	= $query.' LIMIT '.$limit;
		}
		//时间处理
		if (@stristr($query, "now()") !== FALSE){
			$query	= preg_replace("/(.*)\'now\(\)\'(.*)/is","\\1now()\\2",$query);
		}
		$query		= str_replace('`','',$query);
		if(stristr($query,'select ')){
			$db_query	= $this->LinkID->query($query);
		}else{
			$db_query	= @$this->LinkID->exec($query);
		}
		return array('query'=>$db_query,'sql'=>$query);
	}
	
	//返回数组资料
	function fetch_array($query) {
		if ($query){
			return $query->fetchArray();
		}
		return false;
	}
	
	//取得返回列的数目
	function num_rows($query){
		if ($query){
			return $query->numColumns();
		}
		return false;
	}
	
	
	//返回最后一次使用 INSERT 指令的 ID
	function insert_id(){
		return $this->LinkID->lastInsertRowID();
	}
	//创建数据库
	function create_db($dbname){
		$this->LinkID->query("CREATE DATABASE ".$dbname);
	}
	//创建数据库表
	function create_table($set=array(),$ary=array()){
		//数组符合要求
		foreach($ary AS $k=>$v){
			$sql 	= '';
			if(count($v)==10){
				//拼接语句
				if($v['types'] == 'INT'){
					$v['types']	= 'INTEGER';
				}
				$sql .= "`$v[field]` $v[types] ";
				if($v['length']>0 && empty($v['key_index'])){
					$sql .= "($v[length])";//长度
				}
				
				if($v['null']>0){	//是否定义空
					$sql .= " NULL ";
				}else{
					$sql .= " NOT NULL ";
				}
				
				//主键
				if($v['key_index']){
					
					$sql .= $v['key_index']." KEY  ";
				}
				if($v['extra']>0){	//是否定义空
					$sql .= " AUTOINCREMENT ";
				}
				
				$sql_ary[]	= $sql;
			}
		}
		$query 	= "CREATE TABLE IF NOT EXISTS `".$set['table']."` (";
		$query	.= implode(',',$sql_ary);
		$query 	.= ");";
		$this->LinkID->query($query);
	}
	//列出数据库 sqlite 不支持
	function show_db(){
		return array('');
	}
	//列出数据表字段
	function show_field($table){
		$query 		= $this->LinkID->query("PRAGMA table_info([$table])");
		while($dls 	= $this->fetch_array($query)){
				$result[] 	= array(
					'field'			=> $dls['name'],
					'type'			=> $dls['type'],
					'collation'		=> '',
					'null'			=> $dls['notnull']==1?'NO':'YES',
					'key'			=> $dls['pk']==1?'PRIMARY':'',
					'default'		=> $dls['dflt_value'],
					'extra'			=> $dls['pk'],
					'comment'		=> '',
				);
		} 
		return $result;
	}
	
	//列出数据库表
	function show_table(){
		$query =  $this->LinkID->query("select name,upper(name) from SQLITE_MASTER where type = 'table' order by 2");
		while($dls = $this->fetch_array($query)){
			if(!strstr($dls['name'],'sqlite_sequence')){
				$result[]	= array(
					'name'			=> $dls['name'],
					'rows'			=> '0',
					'data_length'	=> '0',
					'index_length'	=> '0',
				);
			}
		}
		return $result;
	}
	//关闭当前数据库连接
	function close(){
		return $this->LinkID->close();
	}
	
	//检测mysql版本
	function version(){
		$version	= $this->LinkID->version();
		return	$version['versionString'];
	}
}
?>