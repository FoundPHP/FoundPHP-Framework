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


Class Dirver_pgsql{
	public $nums		= 0;
	public $Lists		= '';
	public $insert_id	= 0;
	//连接数据库
	function DBLink($dba=''){
		$dba['dbport']	= @$dba['dbport']?$dba['dbport']:5432;
		$this->LinkID = pg_connect("host=".$dba['dbhost']." port=".$dba['dbport']." dbname=".$dba['dbname']." user=".$dba['dbuser']." password=".$dba['dbpass']);
		if (!$this->LinkID){ return 2; }
		if (@$dba['charset']){
			$this->charset	= $dba['charset'];
		}
		$this->set_names= 0;
		return $this->LinkID;
	}
	
	//查询语句
	function query($query,$limit='') {
		$query	= trim($query);
		//检测如果有限制数据集则处理
		if($limit>0){
			$query = $query.' LIMIT '.$limit.' OFFSET 0;';
		}
		//时间处理
		if (stristr($query, "now()") !== FALSE){
			$query = preg_replace("/(.*)\'now\(\)\'(.*)/is","\\1now()\\2",$query);
		}
		if (stristr($query,'insert into')){
			$querys	= substr($query,-1);
			if ($querys==';'){
				$query = substr($query,0,strlen($query)-1);
			}
			$query	.= ' RETURNING id;';
			$pgq		= pg_query($this->LinkID,$query);
			$pg_ins	= $this->fetch_array($pgq);
			$this->insert_id	= $pg_ins[0];
		}else{
			$pgq		= pg_query($this->LinkID,$query);
		}
		return array('query'=>$pgq,'sql'=>$query);
	}
	
	//返回数组资料
	function fetch_array($query) {
		return @pg_fetch_array($query);
	}
	
	//取得返回列的数目
	function num_rows($query){
		return @pg_num_rows($query);
	}
	
	//返回最后一次使用 INSERT 指令的 ID
	function insert_id(){
		return $this->insert_id;
	}
	//创建数据库
	function create_db($dbname){
		pg_query($this->LinkID,"CREATE DATABASE ".$dbname);
	}
	//列出数据库
	function show_db(){
		$query = pg_query($this->LinkID,"SHOW DATABASES ");
		while($r = $this->fetch_array($query)){
			$result[] = $r['Database'];
		}
		return $result;
	}
	//关闭当前数据库连接
	function close(){
		return pg_close($this->LinkID);
	}
	
	//检测版本
	function version(){
		$v = pg_version($this->LinkID);
		return $v['client'];
	}
}
?>