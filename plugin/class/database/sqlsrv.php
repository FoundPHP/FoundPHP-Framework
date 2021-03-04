<?php
/*	(C)2006-2020 FoundPHP Framework.
*	   name: Database Object
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: v3.210226
*	  start: 2006-05-24
*	 update: 2021-02-26
*	payment: Free 免费
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

Class Dirver_sqlsrv{
	public $LinkID;
	//连接数据库
	function DBLink($dba=''){
		$this->LinkID	= sqlsrv_connect($dba['dbhost'].($dba['dbport']!=''?','.$dba['dbport']:''), array( "Database"=>$dba['dbname'], "UID"=>$dba['dbuser'], "PWD"=>$dba['dbpass'],'CharacterSet' => "UTF-8"));
		$info	= sqlsrv_errors();
		if(!empty($info[1][2])){
			return 4;
		}
		if (!$this->LinkID){return 2;}
		$this->charset	= $dba['charset'];
		$this->set_names= 0;
		return $this->LinkID;
	}
	
	//查询语句
	function query($query,$limit='') {
		//检测如果有限制数据集则处理
		if($limit>0){
			$query = str_ireplace('select ','select TOP '.$limit.' ',$query);
		}
		//时间处理
		if (stristr($query, "now()") !== FALSE){
			$query = preg_replace("/(.*)\'now\(\)\'(.*)/is","\\1now()\\2",$query);
		}
		$query		= str_replace('`','',$query);
		//统计用途
		if ($limit=='-1'){
			$sql_query	=sqlsrv_query($this->LinkID,$query,array(),array("Scrollable" => SQLSRV_CURSOR_KEYSET));
		}else{
			$sql_query	=sqlsrv_query($this->LinkID,$query);
		}
		
		return array('query'=>$sql_query,'sql'=>$query);
	}
	
	//返回数组资料
	function fetch_array($query) {
		return sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC);
	}
	
	//取得返回列的数目
	function num_rows($query){
		return sqlsrv_num_rows($query);
	}
	
	//返回最后一次使用 INSERT 指令的 ID
	function insert_id(){
		$sql 		= "select @@IDENTITY;";
		$query		= $this->query($sql);
		$insert_id	= (int)@current($this->fetch_array($query['query']));
		return $insert_id;
	}
	
	//关闭当前数据库连接
	function close(){
		return @sqlsrv_close($this->LinkID);
	}
	
	//检测mysql版本
	function version($types=0){
		$sql 		= "select @@VERSION";
		$query		= $this->query($sql);
		$version 	= @current($this->fetch_array($query['query']));
		$version	= substr($version,0,strrpos($version,' -'));//截取-之前的文字
		if ($types==1){
			$ver_exp= explode(' ',$version);
			foreach($ver_exp AS $k=>$v) {
				if (strlen((int)trim($v))==4){
					return $v;
				}
			}
		}
		return	$version;
	}
}
?>