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
	var $Lists	= '';
	var $nums	= 0;
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
			$db_query	= $this->LinkID->exec($query);
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