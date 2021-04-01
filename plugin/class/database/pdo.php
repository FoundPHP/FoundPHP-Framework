<?php
/*	(C)2006-2021 FoundPHP Framework.
*	   name: Database Object
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: v3.201212
*	  start: 2013-05-24
*	 update: 2021-02-23
*	payment: Free 免费
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/


Class Dirver_pdo{
	var $Lists	= '';
	var $nums	= 0;
	//连接数据库
	function DBLink($dba=''){
		try {
			$this->LinkID = @new PDO($dba['type'].':dbname='.$dba['dbname'].' host='.$dba['dbhost'].($dba['dbport']!=''?':'.$dba['dbport']:''), $dba['dbuser'], $dba['dbpass']);
			$this->charset	= $dba['charset'];
			$this->LinkID->exec($this->charset);	//设置编码
			$this->set_names= 0;
			return $this->LinkID;
			ignore_user_abort();
		}catch (PDOException $e){
			return 2;
		}
	}
	
	//查询语句
	function query($query,$limit='') {
		//检测如果有限制数据集则处理
		if($limit>0){
			$query = $query.' LIMIT '.$limit;
		}
		//时间处理
		if (@stristr($query, "now()") !== FALSE){
			$query = preg_replace("/(.*)\'now\(\)\'(.*)/is","\\1now()\\2",$query);
		}
		return array('query'=>mysqli_query($this->LinkID,$query),'sql'=>$query);
	}
	
	//返回数组资料
	function fetch_array($query) {
		if ($query){
			return $query->fetch_array(MYSQLI_ASSOC);
		}
		return false;
	}
	
	//取得返回列的数目
	function num_rows($query){
		if ($query){
			return mysqli_num_rows($query);
		}
		return false;
	}
	
	//返回最后一次使用 INSERT 指令的 ID
	function insert_id(){
		return mysqli_insert_id($this->LinkID);
	}
	//创建数据库
	function create_db($dbname){
		mysqli_query($this->LinkID,"CREATE DATABASE ".$dbname);
	}
	//列出数据库
	function show_db(){
		$query = mysqli_query($this->LinkID,"SHOW DATABASES ");
		while($r = $this->fetch_array($query)){
			$result[] = $r['Database'];
		}
		return $result;
	}
	//关闭当前数据库连接
	function close(){
		return @mysqli_close($this->LinkID);
	}
	
	//检测mysql版本
	function version(){
		return @mysqli_get_server_info($this->LinkID);
	}
}
?>