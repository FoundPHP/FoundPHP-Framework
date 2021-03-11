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

Class Dirver_mariadb{
	var $Lists	= '';
	var $nums	= 0;
	//连接数据库
	function DBLink($dba=''){
		$this->LinkID = new mysqli($dba['dbhost'].($dba['dbport']!=''?':'.$dba['dbport']:'3306'), $dba['dbuser'], $dba['dbpass'],$dba['dbname']);
		if ($this->LinkID->connect_error!=''){ return 2; }
		$this->charset	= $dba['charset'];
		@mysqli_set_charset($this->LinkID,$dba['charset']);//设置编码
		$this->set_names= 0;
		return $this->LinkID;
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
	
	//关闭当前数据库连接
	function close(){
		return $this->LinkID->close();
	}
	
	//检测mysql版本
	function version(){
		return	$this->LinkID->server_info;
	}
}
?>