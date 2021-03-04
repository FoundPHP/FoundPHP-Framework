<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
defined('FoundPHP.com') or die('access denied!');



	/**
	*  分类数据
	*
	*/
	function cate_block($where="types='system'",$order='orders ASC,cate_id ASC'){
		global $config;
		//服务器配置
		if ($config['set']['host_id']!=''){
			$where			.= " AND (host_id=".$config['set']['host_id']."  OR language IN('admin','admin_group','admin_user','sys','sys_set','sys_action'))";
		}
		
		global $db,$domain_set;
				$sql 		= sql_select( array('table'=> "category", 
											'where'=> $where,
											'order'=> $order, 
											'type' => 'sql')
								);
				$query	= $db->query($sql);
				$i=0;
				while($dls = $db->fetch_array($query)){
					//语言区分
					$language				= unserialize($dl['language']);
					$cate_name				= ($language[$domain_set['lang_name']]!='')?$language[$domain_set['lang_name']]:$dls['cate_name'];
					
					$result[$i]				= $dls;
					$result[$i]['name']		= $cate_name;
					$i++;
				}
			return $result;
	}

/******************************
//	添加版块的递归版块目录
//	forums:   版块信息数组
//	fup:	  关联的父ID
//	count:	  获得当前的层数
******************************/
function add_tree($forums,$fup,$count=1){
	$fup	= (int)$fup;
	$count	= (int)$count;
	$result	= "";
	for($i=0;$i<count($forums);$i++){
		$form = $forums[$i];
		if($form['fid']==$fup){
			
			//宽度处理
			$width = ($count==1)? '0' : $count-1;
			$lines = '';
			for($c=0;$c<$width;$c++){
				$lines .= '&nbsp;&nbsp;&nbsp;';
			}
			
			//递归循环
			$return_go =add_tree($forums,$form['cate_id'],$count+1);
			
		   	$line  = ($fup==0)?"":$lines."└→";
			if ($GLOBALS['id']!=$form['cate_id']){
		 	   $result .="<option value='$form[cate_id]' ".($form['cate_id']==$GLOBALS['fid']?'selected style="background-color: #DAE7F2"':'').">".$line."$form[cate_name]</option>".$return_go;
			}
		}
	}
	return $result;
}
function json_tree($forums,$fup,$count=1){
	$fup	= (int)$fup;
	$count	= (int)$count;
	$result	= "";
	for($i=0;$i<count($forums);$i++){
		$form = $forums[$i];
		if($form['fid']==$fup){
			
			//宽度处理
			$width = ($count==1)? '0' : $count-1;
			$lines = '';
			for($c=0;$c<$width;$c++){
				// $lines .= '&nbsp;&nbsp;&nbsp;';
			}
			
			//递归循环
			$return_go =json_tree($forums,$form['cate_id'],$count+1);
			
		   	$line  = ($fup==0)?"":$lines;
			if ($GLOBALS['id']!=$form['cate_id']){
		 	   $result .=json($form)."\n".$return_go;
			}
		}
	}
	return $result;
}
function article_model($ary,$fid,$count=1){
	$fid	= (int)$fid;
	$count	= (int)$count;
	$result	= "";
	for($i=0;$i<@count($ary);$i++){
		$dls = $ary[$i];
		if($dls['fid']==$fid){
			//递归循环
			$return_go = article_model($ary,$dls['cate_id'],$count+1);
			//宽度处理
			$width = ($count==1)? '0' : $count-1;
			$dirs = '└';
			for($s=0;$s<$width;$s++){
				$dirs .= '&nbsp;→&nbsp;';
			}
			
			//子论坛提示
			if($fid==0){
				$tip = '<b>'.lang('顶级').':&nbsp;';
			}else{
				$tip = '&nbsp;&nbsp;';
			}
			$ope = array();
			if ($dls['cate_desc']){
				foreach(json($dls['cate_desc']) AS $k=>$v) {
					$ope[] = $GLOBALS['_sys_pn'][$v];
				}
			}
			
			$sys_name	= '';
			$result .= "<tr scope='row'>
					<td>$dls[cate_id]</td>
					<td>".$dirs."$tip <b>$dls[name]</b>".$sys_name."</td>
					<td>$dls[orders]</td>
					<td>".($dls['shows']==1?lang('<font color="#5bc0de"><i class="fa fa-eye"></i> 显示</font>'):lang('<i class="fa fa-eye-slash"></i> 隐藏')).($dls['numbers']==1?' / <font color="#5bc0de">老师</font>':'')."</td>
				</td>
				<td>
				".taction($dls['cate_id'], array(array('link'=>"?a=$GLOBALS[a]&id=$dls[cate_id]&fid=$dls[fid]&t=up",'style'=>'fa fa-arrow-up','title'=>lang('上移')), array('link'=>"?a=$GLOBALS[a]&id=$dls[cate_id]&fid=$dls[fid]&t=down",'style'=>'fa fa-arrow-down','title'=>lang('下移'))) ,($dls['lockout']==1?array('del'):''))."
				</td>
				</tr>".$return_go;
		}
	}
	
	return $result;
}


/******************************
//	测评版块的递归版块目录
//	forums:   版块信息数组
//	fup:	  关联的父ID
//	count:	  获得当前的层数
//	dis:	  1 禁止选择父级 2禁止选择二级
******************************/
function article_tree($forums,$fup,$dis=0,$count=1){
	$fup	= (int)$fup;
	$count	= (int)$count;
	$result	= "";
	for($i=0;$i<count($forums);$i++){
		$form = $forums[$i];
		if($form['fid']==$fup){
			
			//宽度处理
			$width = ($count==1)? '0' : $count-1;
			$lines = '';
			for($c=0;$c<$width;$c++){
				$lines .= '&nbsp;&nbsp;&nbsp;';
			}
			//递归循环
			$return_go =article_tree($forums,$form['cate_id'],$dis,$count+1);
		   	$line  = ($fup==0)?"":$lines."└→";
			if ($GLOBALS['id']!=$form['cate_id']){
		 	   $result .="<option ".(($dis==1 && $form['fid']==0)?"disabled":"").($dis==2 && $form['fid']!=0?"disabled":"")." value='$form[cate_id]' ".($form['cate_id']==$GLOBALS['fid']?'selected style="background-color: #DAE7F2"':'').">".$line."$form[cate_name]</option>".$return_go;
			}
		}
	}
	return $result;
}

  
/******************************
//  模块管理递归数据
//	ary:  		数组
//	fid:		关联的父ID
//	count:		获得当前的层数
******************************/
function sys_model($ary,$fid,$count=1){
	$fid	= (int)$fid;
	$count	= (int)$count;
	$result	= "";
	if (!empty($ary)){
		for($i=0;$i<@count($ary);$i++){
			$dls = $ary[$i];
			if($dls['fid']==$fid){
				//递归循环
				$return_go = sys_model($ary,$dls['cate_id'],$count+1);
				//宽度处理
				$width = ($count==1)? '0' : $count-1;
				$dirs = '└';
				for($s=0;$s<$width;$s++){
					$dirs .= '&nbsp;→&nbsp;';
				}
				
				//子论坛提示
				if($fid==0){
					$tip = '<b>'.lang('顶级').':&nbsp;';
				}else{
					$tip = '&nbsp;&nbsp;';
				}
				$ope = array();
				if ($dls['cate_desc']){
					foreach(json($dls['cate_desc']) AS $k=>$v) {
						$ope[] = $GLOBALS['_sys_pn'][$v];
					}
				}
				
				$sys_name	= '';
				if ($dls['cm_id']>0){
					if ($dls['fid']==0){
	 				   	$sys_name	= '<td style="color:'.$GLOBALS['systems_ary'][$dls['cm_id']]['background'].';">'.$GLOBALS['systems_ary'][$dls['cm_id']]['name'].'</td>';
					}else{
	 				   	$sys_name	= '<td></td>';
					}
				}
				
				$result .= "<tr scope='row'>
						<td>$dls[cate_id]</td>
						<td>".($dls['icon']?"<i class='".$dls['icon']."'></i>":'')."</td>
						<td>$dls[language]</td>
						<td>".$dirs."$tip <b>$dls[name]</b>".$sys_name."<td>".(count($ope)>0?implode(' / ',$ope):lang('未设定'))."</td>
						<td>$dls[orders]</td>
						<td>".($dls['shows']==1?lang('<font color="#5bc0de"><i class="fa fa-eye"></i> 显示</font>'):lang('<i class="fa fa-eye-slash"></i> 隐藏')).($dls['numbers']==1?' / <font color="#5bc0de">老师</font>':'')."</td>
					</td>
					<td>
					".taction($dls['cate_id'], array(array('link'=>"?a=$GLOBALS[a]&id=$dls[cate_id]&fid=$dls[fid]&t=up",'style'=>'fa fa-arrow-up','title'=>lang('上移')), array('link'=>"?a=$GLOBALS[a]&id=$dls[cate_id]&fid=$dls[fid]&t=down",'style'=>'fa fa-arrow-down','title'=>lang('下移'))) ,($dls['lockout']==1?array('del'):''))."
					</td>
					</tr>".$return_go;
			}
		}
	}
	return $result;
}

// 测评管理递归数据
//	ary:  		数组
//	fid:		关联的父ID
//	count:		获得当前的层数
/******************************/
function exam_model($ary,$fid,$count=1){
	$fid	= (int)$fid;
	$count	= (int)$count;
	$result	= "";
	for($i=0;$i<count($ary);$i++){
		$dls = $ary[$i];
		if($dls['fid']==$fid){
			//递归循环
			$return_go = exam_model($ary,$dls['cate_id'],$count+1);
			//宽度处理
			$width = ($count==1)? '0' : $count-1;
			$dirs = '└';
			for($s=0;$s<$width;$s++){
				$dirs .= '&nbsp;→&nbsp;';
			}
			
			//子论坛提示
			if($fid==0){
				$tip = '<b>'.lang('顶级').':&nbsp;';
			}else{
				$tip = '&nbsp;&nbsp;';
			}
			$ope = array();
			if ($dls['cate_desc']){
				foreach(json($dls['cate_desc']) AS $k=>$v) {
					$ope[] = $GLOBALS['_sys_pn'][$v];
				}
			}
			
			$sys_name	= '';
			$result .= "<tr scope='row'>
					<td>$dls[cate_id]</td>
					<td>".$dirs."$tip <b>$dls[name]</b>".$sys_name."
				</td>
				<td>
				".taction($dls['cate_id'])."
				</td>
				</tr>".$return_go;
		}
	}
	
	return $result;
}

  
  
/******************************
//	添加版块的递归版块目录
//	forums:   版块信息数组
//	fup:	  关联的父ID
//	count:	  获得当前的层数
******************************/
/**
*   文章分类
*	后台调用
*/
function sel_category($types){
	$cate_data	= cate_block($types);
		$i	=0;
		unset($K,$V);
		foreach ($cate_data AS $K=>$V) {
			$i++;
			$rows[$i]			= "'$V[id]':{'id':'$V[id]','pid':'$V[fup]','title':'$V[name]'}";
			$fups[$V['fup']][]	= $V['id'];
		}
		
		//所有关联条件
		unset($K,$V);
		foreach ($fups AS $fk=>$fv) {
			$index[$fk]  = 'rowsPidIndex['.$fk.'] = new Array(\''.implode("','",$fv).'\');';
		}
	ksort($index);
	
	//树名称
	$result['rows']	 = implode(",\r\n",$rows);
	//索引关系
	$result['index']	 = implode("\r\n",$index);
	return $result;
}




/**
*	插入或更新category关联
*	
	types		分类关联类型，例如：文章是articles、产品是products
	id			产品id
	cate_id		分类id数组
*/
function cate_link_update($ary=''){
	global $host_id;
		//编辑
		if($GLOBALS['todo'] == 'edit'){
			$cate_link		= cate_link_id($ary['id']);
			
				if(count($ary['cate_id'])>0){
					unset($K,$V);
					foreach ($ary['cate_id'] AS $K=>$V) {
						//存在
						if(@in_array($V,$cate_link)){
							unset($ary['cate_id'][$V]);
							unset($cate_link[$V]);
						}
					}
				}
				
				//删除存在遗留分类id则
				if(count($cate_link)>0){
					unset($K,$V);
					foreach ($cate_link AS $K=>$V) {
						sql_del(array('table'=>'products_categorys','where'=>"pid='".$ary['id']."' AND cate_id='$V'"));
					}
				}
		}
		
		
			//文章关联的id
			$cate_link	= $ary['cate_id'];
			if(count($cate_link)>0){
				unset($K,$V);
				foreach ($cate_link AS $K=>$V) {
					if((int)$V>0){
						sql_update_insert( array('table'=>'products_categorys','data'=>array('pid'=>$ary['id'],'cate_id'=>$V,'host_id'=>$ary['host_id']),'check'=>array('pid'=>$ary['id'],'cate_id'=>$V,'host_id'=>$ary['host_id'])) );
					}
				}
			}
}



/**
*	文章关联
	id	文章id
*/
function cate_link_id($id){
	if($id>0){
		$result		= array();
		$sql_query	= $GLOBALS[db_obj]->query( sql_select( array('table'=>'products_categorys' ,'where'=>"pid='$id'", 'type'=>'sql') ) );
		while ($mdl	= $GLOBALS[db_obj]->fetch_array($sql_query)){
			$result[$mdl['cate_id']] = $mdl['cate_id'];
		}
	return $result;
	}
}


	
	
	
	/**
	*  分类排序
	* id		当前分类id
	* fid		父级id
	* mode		升降模式：up=升，down=降
	*/
	function cate_order($id,$fid=0,$mode='up'){
		global $db;
		if($id>0){
			//取得同类别的所有板块
			$sql 		= sql_select( array('table'=> "category", 
										'where'=> " fid='$fid' ",
										'order'=> "orders ASC", 
										'type' => 'sql')
								);
			$i = 0;
			$query 		= $db->query($sql);
			while($fs = $db->fetch_array( $query )){
				$i++;
				if($fs['cate_id']== $id){
					$ids[$i] = array(
							"cate_id"=>$fs['cate_id'],
							"order"=>$i,
						);
					$this_id = $i;		//用于判断ID
				}else{
					$ids[$i] = array(
							"cate_id"=>$fs['cate_id'],
							"order"=>$i,
						);
				}
			}
							
			//处理排序
			foreach($ids AS $k=>$v){
				//当前版块的前一个版块
				SWITCH($mode){
					case'up':
						if($k==($this_id-1)){
							$upid	= $this_id;
						}else{
							//当前版块
							$upid = ($k== $this_id)?($this_id - 1):$k;
						}
					break;
					default:
						if($k==($this_id+1)){
							$upid	= $this_id;
						}else{
							//当前版块
							$upid = ($k== $this_id)?($this_id + 1):$k;
						}
				
				}
				
						$data_ary	= array(
									'table'	=> 'category',
									'data'	=> array('orders'=>$upid),
									'where'	=> "cate_id='$v[cate_id]' AND fid='$fid'",
								);
						sql_update_insert($data_ary);
				
			}
		}
		
	}


	/**
	*	得到分类的列队
	*
	*/
	function cate_list($id=''){
		global $db,$domain_set,$tpl;
			//缓存文件
			$cate_cache	= 	inc_file('cache').'/category_nav_id_'.$id.'.php';
			if(is_file($cate_cache)){
				include $cate_cache;
				return $cate_cache_data;
			}else {
				//没有缓存建立文件
					$cache_forum = '';
					//获取数据库版块列表并产生新的数组
					$sql 		= sql_select( array('table'=> 'category','where'=>" types='product' ", 'type' => 'sql'));
					
					$query		= $db->query($sql);
					while($row	= $db->fetch_array($query)) {
						$forums[$row['cate_id']]	= $row;
					}
				
					if(count($forums)>0){
						//得到最后一个版块信息
						foreach($forums AS $Keys=> $v){
							if($v['cate_id'] == $id){
								$cate_id  = $v['cate_id'];
								$fid  = $v['fid'];
								$langs	= unserialize($v[language]);
								//多语言支持
								$cate_name	= ($langs[$domain_set['lang_name']]!='')?$langs[$domain_set['lang_name']]:$v[cate_name];
							}
						}
						
						if($cate_name){
							//连接
							$href			= sys_link('index.php?model=shop&action=category&name='.str_replace('& ','',$cate_name).'&cid='.$cate_id.'&page=1');
							$href			= str_replace(' ','-',$href);
							//替换默认的分类名为时尚
							$href			= str_replace('shop.category.',settings('rewrite_cate_head'),$href);
							
							$dir_list = "<li><a href=\"$href\" title='$cate_name' alt='$cate_name' class='cate_cru'>$cate_name</a></li>";		//最后一个版块显示
						}
						
						//重载循环
						while($fid!=0){
							foreach($forums AS $Key => $Value){
								$fx = $forums[$Key];
								if($fx['cate_id'] == $fid){
									$lang	= unserialize($fx[language]);
									//多语言支持
									$cate_names	= ($lang[$domain_set['lang_name']]!='')?$lang[$domain_set['lang_name']]:$fx[cate_name];
									
									//连接
									$href			= sys_link('index.php?model=shop&action=category&name='.str_replace('& ','',$cate_names).'&cid='.$fx[cate_id].'&page=1');
									$href			= str_replace(' ','-',$href);
									//替换默认的分类名为时尚
									$href			= str_replace('shop.category.',settings('rewrite_cate_head'),$href);
									$dir_list  = "<li><a href=\"$href\" title='$cate_names' alt='$cate_names'>$cate_names</a></li>".$dir_list;
									$fid = $fx['fid'];
								}
							}
						}
					}
					
					//如果多出符号替换掉
					if(substr($dir_list,0,5)==' >>> '){
						$dir_list		= substr($dir_list,5);
					}
					
					//写入缓存文件
					$out_txt			= "<?php \$cate_cache_data =  '".str_replace("'","\'",$dir_list)."';?>";
					$tpl->writer($cate_cache,$out_txt);
					
					return $dir_list;
			}
	}
	
	
/**
*	分类分页数筛选连接
*
*/
function category_select_set($ary){
	global $sys_set;
	$url	= "index.php?model=shop&action=category&name=$ary[page_title]&number=$ary[number]&orby=$ary[orby]&cid=$ary[cid]&page=$ary[page]";
	//静态化
	if($sys_set[site_mode]==1){
		$url	= sys_link($url);
		$url	= str_replace(' ','-',$url);
		//替换默认的分类名为时尚
		$url	= str_replace('shop.category.',settings('rewrite_cate_head'),$url);
	}
	return $url;
}
	
	
	
/**
*	前台分类
*
*/
function category($cid=0){
	global $db,$domain_set;
	//分类
	$cate_block	= category_block('product',$cid);
	
	unset($K,$V);
	$cate	.= '<ul id="accordion" class="accordion">';
	foreach ($cate_block AS $K=>$V) {
		if(is_int($K)){
			$cate	.= $V;
			if(is_array($cate_block['list'][$K])){
				$cate	.= implode('',$cate_block['list'][$K]);
			}
			$cate	.= '</ul></li>';
		}
	}
	$cate	.= '</ul>';
	$cate	.= '
<script>
$(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {}; this.multiple = multiple || false;
		var links = this.el.find(\'.link\');
		links.on(\'click\', {el: this.el, multiple: this.multiple}, this.dropdown)
	}
	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
		$this = $(this);$next = $this.next();
		$next.slideToggle();$this.parent().toggleClass(\'open\');
		if (!e.data.multiple) {$el.find(\'.submenu\').not($next).slideUp().parent().removeClass(\'open\'); };
	}
	var accordion = new Accordion($(\'#accordion\'), false);
});
</script>';
	
	return $cate;
}


	/**
	*  分类数据
	*
	*/
	function category_block($types='spider',$cid=0){
		global $db,$domain_set;
			
			
				$sql 		= sql_select( array('table'=> "category", 
											'where'=> "types='$types' AND shows=1 ",
											'order'=> "orders ASC,cate_id ASC", 
											'type' => 'sql')
								);
				$data_info	= $db->query($sql);
				while($dl = $db->fetch_array($data_info)){
					if ($dl['cate_id']==$cid){
						$fid		= $dl['fid'];
					}
					//语言区分
					$language		= unserialize($dl['language']);
					$cate_name		= ($language[$domain_set[lang_name]]!='')?$language[$domain_set[lang_name]]:$dl['cate_name'];
					
					//如果是数组则多分类被选中
					if(is_array($cid) && count($cid)>0 && in_array($dl[cate_id],$cid)){
						$cate_cru		= 'class="menu_activate"';
					}else {
						$cate_cru		= ($cid==$dl[cate_id])?'class="menu_activate"':'';
					}
					
					//连接
					$href			= sys_link('index.php?model=shop&action=category&name='.str_replace('& ','',$cate_name).'&cid='.$dl[cate_id].'&page=1');
					$href			= str_replace(' ','-',$href);
					//替换默认的分类名为时尚
					$href			= str_replace('shop.category.',settings('rewrite_cate_head'),$href);
					
					if($dl['fid']==0){
						$block[$dl['cate_id']]			= "<li><div class='link'>".$cate_name."</div><ul class=\"submenu\">\n";
					}else {
						$block['list'][$dl['fid']][]	= "<li><a ".$cate_cru." href='".$href."'>".$cate_name."</a></li>\n";
					}
				}
				
				if ($block[$fid]){
					$block[$fid]	= str_replace('<ul class="submenu">','<ul class="submenu" style="display: block;">',$block[$fid]);
				}
				if ($block[$cid]){
					$block[$cid]	= str_replace('<ul class="submenu">','<ul class="submenu" style="display: block;">',$block[$cid]);
				}

			return $block;
	}


/*********************************************************/
//产品关联处理 END

/**
*	过滤id并且去除重复
*
*/

function check_array($idlist=''){
	if(trim($idlist)){
		$idlistr		= explode(',', str_replace('，',',',$idlist));
		//过滤提交id
		if(is_array($idlistr)){
			unset($K,$V);
			foreach ($idlistr AS $K=>$V) {
				if(trim($V)){
					$idlista[$V] = $V;
				}
			}
			return $idlista;
		}
	}
}
/**
*	更新关联数据
*
*/
function product_link($series_list='',$table='series'){
	global $db;
	if(count($series_list)>0){
		
		//得到筛选数据
		unset($K,$V);
		foreach ($series_list AS $K=>$V) {
			$pro_id[]	= $V;					//产品titles id，需要转换成数据库id
			$title[]	= "titles='$V'";		//产生查询语句
			$titles		= implode(' OR ',$title);
		}
		
		//获取所有符合的数据组合
		$sql 		= sql_select( array('sql'=> "SELECT * FROM ".table('products')." WHERE ($titles) ORDER BY id ASC ", 'type' => 'sql') );
		$data_info	= limit($sql,100);
		//列出数据
		while ($dls = $db->fetch_array($data_info['query'])){
			//可以更新产品id
			$updates[$dls['id']]	= $dls['id'];
			$smodel[$dls['id']]		= $dls['titles'];
		}
		
		
		/*********************************************************/
		//更新数据
		/*********************************************************/
		//有一个以上的更新则进行更新
		if(count($updates)>1){
			unset($K,$V);
			foreach ($updates AS $K=>$V) {
				//内部products表id，例如1843
				$series 		= product_link_id($updates,$V);
				//具体型号例如:n51998
				$series_model	= product_link_id($smodel,$V);
				sql_update_insert(array('table'=>'products','data'=>array($table=>$series,$table.'_model'=>$series_model), 'where'=>" id='$V'"));
			}
		}
	}
}

/**
*	$ary 	得到的列表数组
*	$id		去除的数据
*/

function product_link_id($ary,$id){
	unset($ary[$id]);
	return implode(',',$ary);
}

/**
*	清空关联
*	id		当前产品id
*	table	清空关联类型
*/
function clear_link($id='',$table='series'){
	global $db;
	$get_data	= sql_select( array('table'=>'products', 'where'=>" id='$id'") );
	if($get_data[$table]!=''){
		$clear_id	= $get_data[$table].','.$id;
		//清空关联id
		sql_update_insert(array('table'=>'products','data'=>array($table=>'',$table.'_model'=>''), 'where'=>" id in($clear_id)"));
	}
}


