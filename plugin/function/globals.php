<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com  原网站：http://www.systn.com
*	邮箱：master@foundphp.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=faq&n=agreement
*/

/*通用统计
//简单示例：
num_count(array(
	'sql'	=> "SELECT count(*) AS nums,gid AS id FROM ".table('admin_user')." GROUP BY gid",
	'table'	=> "admin_group",	//更新的表
	'data'	=> "nums",			//更新字段名
	'where'	=> "id='{id}'",		//查询条件
	'types'	=> "types='4'",		//更新表的查询条件
	'clear'	=> 0,				//清空数据,1不清空（如果不清空，没有数据则无法准确统计）
	'time'=> 30					//定期更新时间（秒），默认不开
));
*/
function num_count($ary=array(),$show=0){
	//有效期设置
	if (isset($ary['time'])){
		$update	= cookie('update_'.$GLOBALS['m'].'_'.$GLOBALS['a']);
	}
	if (isset($ary['sql']) && !isset($update)){
		if (trim($ary['table'])==''){
			$text	= lang('没有设置更新 table 表名称');
			if ($show==0){echo $text;}else{return $text;}
			exit;
		}
		if (trim($ary['data'])==''){
			$text	= lang('没有设置更新 data 字段名');
			if ($show==0){echo $text;}else{return $text;}
			exit;
		}
		if (trim($ary['where'])==''){
			$text	= lang('没有设置 where 条件');
			if ($show==0){echo $text;}else{return $text;}
			exit;
		}
		//清空默认值
		if ((int)$ary['clear']!=1){
			sql_update_insert( array('table' =>$ary['table'],'data' =>array($ary['data']=>0),'where'=>trim($ary['types'])?$ary['types']:'1'));
		}
		//获得用户
		$sql 		= sql_select( array('sql'=>$ary['sql'],'type' => 'sql') );
		$query		= $GLOBALS['db']->query($sql);
		while ($dls	= $GLOBALS['db']->fetch_array($query)){
			if (!array_key_exists('nums',$dls) || !array_key_exists('id',$dls)){
				$text	= lang('抱歉，没有设置统计值或更新所需的id');
				if ($show==0){echo $text;}else{return $text;}
				exit;
			}
			if (isset($ary['where'])){
				//更新数据
				$where		= str_ireplace("{id}",$dls['id'],$ary['where']);
				$res = sql_update_insert( array('table' =>$ary['table'],'data' =>array($ary['data']=>(int)$dls['nums']),'where' =>$where));
			}
		}
		if (isset($ary['time'])){
			cookie('update_'.$GLOBALS['m'].'_'.$GLOBALS['a'],1,$ary['time']);
		}
	}
}

/* //剪切授权密钥 
	str 字符
	len 需要的长度
*/
function cut_key($str,$len=20){
	//随机切开头
	$max_rand	= strlen($str)-$len;
	$stratcut	= rand(0,$max_rand);
	$result		= substr($str,$startcut,$len);
	return $result;
}