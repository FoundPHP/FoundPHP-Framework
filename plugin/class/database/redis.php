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

Class Dirver_redis{
	//连接数据库
	function DBLink($dba=''){
		if (class_exists('Redis')==false){
			return 2;
		}
		$this->LinkID = new Redis();
		$this->LinkID->connect($dba['dbhost'],($dba['dbport']!=''?$dba['dbport']:6379));
		//设置库
		if ((int)$dba['dbname']&& $dba['dbpass']==''){
			@$this->LinkID->select((int)$dba['dbname']);
		}
		//设置密码
		if ($dba['dbpass']){
			$auth	= $this->LinkID->auth(trim($dba['dbpass']));
			if ($auth==false){
				return 3;
			}
		}
		return $this->LinkID;
	}
	
	//单条语句查询,默认先进先出
	function query($name,$types='') {
		switch($types){
			case'lpop':
				$result	= $this->LinkID->lpop($name);
			break;
			default:
				$result	= $this->LinkID->rpop($name);
		}
		return $result;
	}
	
	//插入语句
	function insert($name,$val='',$types='') {
		switch($types){
			case'rpush':
				$result	= $this->LinkID->rpush($name, $val);
			break;
			default:
				$query	= $this->LinkID->lpush($name, $val);
		}
		return array('query'=>$query);
	}
	
	//关闭当前数据库连接
	function close(){
		return $this->LinkID->close();
	}
	
	//获得版本
	function version(){
		$redis_ver	= $this->LinkID->info();
		ob_start();
		ob_implicit_flush(0);
			phpinfo();$php_info = ob_get_contents();
		ob_end_clean();
		foreach(explode("\n",$php_info) AS $k=>$v) {
			if (strstr($v,'Redis Version')){
				$verext	= explode('Redis Version',strip_tags($v));
				return 'PHP Redis:'.trim($verext[1]).', Redis Version:'.$redis_ver['redis_version'];
			}
		}
	}
}
?>