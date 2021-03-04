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

Class Dirver_memcached{
	//连接数据库
	function DBLink($dba=''){
		if (class_exists('Memcached')==false){
			return 2;
		}
		$this->LinkID = new Memcached();
		$this->LinkID->addServer($dba['dbhost'],($dba['dbport']!=''?$dba['dbport']:11211));
		
		return $this->LinkID;
	}
	
	//单条语句查询,默认先进先出
	function query($name) {
		
		$result	= $this->LinkID->get($name);
		return $result;
	}
	
	//插入语句
	/* 
	 name 
	 $db->insert('key',array('val'=>'test','time'=>3600));
	 
	*/
	function insert($name,$data=array()) {
		if(is_array($data) && $data['val']!=''){
			if($data['time']>0){
				$this->LinkID->delete($name);
				$query	= $this->LinkID->set($name, $data['val'],$data['time']);
			}else{
				$this->LinkID->delete($name);
				$query	= $this->LinkID->set($name, $data['val']);
			}
		}
		return array('query'=>$query);
	}
	
	//关闭当前数据库连接
	function close(){
		return $this->LinkID->quit();
	}
	
	//获得版本
	function version(){
		$version =  $this->LinkID->getVersion();
		
		return current($version);
	}
}
?>