<?php
/*	(C)2005-2018 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	作者：孟大川
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.FoundPHP.com/agreement
*/
defined('FoundPHP.com') or die('access denied!');
$page_m['1']	= lang('越权操作');
$page_m['2']	= lang('抱歉，您目前权限无法访问此地址。');



/*系统菜单权限管理
	data		菜单数据
	fid			父ID
	level		菜单深度，限定4级深度
*/
function power($data,$fid=0,$level=0){
	$set_powers	= @$GLOBALS['_set_power'];
	$html		= '';
	$sub		= '';
	//层级处理
	if ($level>0){
		$i		= $level;
		$i++;
	}
	
	foreach($data as $k => $v){
		if($v['fid'] == $fid){
			if ($v['fid']==0){$i=1;}
			//限制显示4层
			if ($i<=4){
				$sub = power($data, $v['cate_id'],$i);
				if ($fid>0 && !$sub){
					//加密链接
					$action	= (@$v['linkto']?'go&t='.$v['language']:$v['language']);
					$url	= 'href="'.'?a='.$action.'"';
					//文件管理
					$url	= (@$v['lockout']>0 && @$v['cate_url'])?'href="'.$v['cate_url'].'"':$url;
				}
				//选中菜单
				$check		= (@$GLOBALS['a']=='go' && $GLOBALS['t']!='')?$GLOBALS['t']:$GLOBALS['a'];
				
				if (@$GLOBALS['o']==$v['language']){
					$check	= $GLOBALS['o'];
				}
				
				//导出文件选中菜单
				if ($GLOBALS['a']=='export_data' && $GLOBALS['n']==$v['language']){
					$check	= $GLOBALS['n'];
				}
				
				//替换状态数量
				$cate_name	= session($v['cate_name']);
				if ($cate_name){
					$v['cate_name']				= $cate_name;
				}
				
				if ($check==$v['language']){
					$GLOBALS['_set_fid']		= $v['fid'];
					$GLOBALS['_sel_title']		= $v['cate_name'];
					$GLOBALS['_sel_id']			= $v['cate_id'];
					if (@$set_power[$v['cate_id']]['-o-']){
						unset($set_power[$v['cate_id']]['-o-']);
					}
					
					$GLOBALS['now_powers']		= @$set_powers[$v['cate_id']];
					
					//管理员权限限定
					if($GLOBALS['aus']['gid']==1 && is_array($v['cate_desc'])){
						$GLOBALS['now_powers']		= array_flip($v['cate_desc']);
					}					
					$html .= '<li><a class="btn-dark" '.$url.'><b>'.(@$v['icon']?'<i class="'.$v['icon'].'"></i>':'').$v['cate_name']. '</b><i class="fa fa-caret-right pull-right" style="padding-top: 4px;	margin-right: -6px;"></i></a>';
				}else{
					if ($set_powers[$v['cate_id']]['-o-']==1 || $GLOBALS['aus']['gid']==1){
						$url = $fid==0||$sub?'':$url;
						$html .= '<li class="menu'.$v['cate_id'].'['.$v['fid'].']"><a '.$url.($GLOBALS['a']==$v['language']?'class="current-page"':'').'>'.(@$v['icon']?'<i class="'.$v['icon'].'"></i>':'').$v['cate_name'].($fid==0||$sub?'<span class="fa fa-chevron-down"></span>':''). '</a>';
					}
				}
				$html .=$sub."</li>\r\n";
			}
		}
	}
	
	if ($html && $fid==0){
		$html = power_active($html,@$GLOBALS['_set_fid']);
	}
	
	
	//$result = $html ? "\r\n<ul class=\"nav ".($fid>0?'child_menu':'side-menu')."\" style=\"$fid\">".$html."</ul>\r\n" : $html;
	$result = $html ? "\r\n<ul class=\"nav ".($fid>0?'child_menu':'side-menu')." \" style=\"$fid".($i<=2 && $GLOBALS['a']=='default'?';display:block;':'')."\">".$html."</ul>\r\n" : $html;
	return $result;
}


/*菜单激活状态
	html		菜单html
	id			选中id
*/
function power_active($html,$id=''){
	preg_match_all("|menu".$id."\[([0-9]+)\]|U",$html,$out, PREG_PATTERN_ORDER);
	$html = str_replace(@$out['0']['0'],'active',$html);
	$html = str_replace('style="'.$id.'"','style="display:block;"',$html);
	if (@$out['1']['0']>0){
		$html = power_active($html,$out['1']['0']);
	}
	return $html;
}



//管理组权限
function power_select($ary,$fid,$count=1){
	$set	= $GLOBALS['power'];
	$fid	= (int)$fid;
	$count	= (int)$count;
	$result	= "";
	for($i=0;$i<count($ary);$i++){
		$dls = $ary[$i];
		if($dls['fid']==$fid){
			//递归循环
			$return_go = power_select($ary,$dls['cate_id'],$count+1);
			//宽度处理
			$width = ($count==1)? '0' : $count-1;
			$dirs = '└';
			for($s=0;$s<$width;$s++){
				$dirs .= '->';
			}
			//子论坛提示
			if($fid==0){
				$tip = '<b>'.lang('顶级').':&nbsp;';
			}else{
				$tip = '&nbsp;';
			}
			$ope = array();
			if ($dls['cate_desc']){
				foreach(json($dls['cate_desc']) AS $k=>$v) {
					$ope[] = '<label class="foundphp-style"><input type="checkbox" name="power['.$dls['cate_id'].']['.$v.']" value="1" class="fps-ck mini green c'.$dls['cate_id'].'  m'.$v.$dls['cate_id'].' f'.$fid.'" fid="'.$fid.'" onclick="gb_sel(\''.$dls['cate_id'].'\',\''.$fid.'\')"'.(isset($set[$dls['cate_id']][$v]) && $set[$dls['cate_id']][$v]==1?' checked':'').'><span class="fps-show"></span> <span>'.$GLOBALS['_sys_pn'][$v].'</span></label>';
				}
			}
			
			if ($fid==0){
				$result .= '<tr><td colspan="2"><br>
					<h4><b>'.$dls['name'].'</b> <button type="button" class="btn btn-info btn-xs" onclick="gb_selall('.$dls['cate_id'].','.$fid.')">'.lang('全选').'</button> <label class="foundphp-style" onclick="gb_selall('.$dls['cate_id'].','.$fid.')"><input type="checkbox" name="power['.$dls['cate_id'].'][-o-]" class="fps-ck mini blue m'.$dls['cate_id'].' open'.$dls['cate_id'].' f'.$fid.'" fid="'.$fid.'" value="1"'.(isset($set[$dls['cate_id']]['-o-']) && $set[$dls['cate_id']]['-o-']==1?' checked':'').'><span class="fps-show"></span> <span>'.lang('访问').'</span></font></label></h4>
					</td></tr>';
			}else{
			
		   		 $result .= "<tr scope='row'>
					<td width='200'>".$dirs."$tip$dls[name]</td>
					<td><table><tr><td width='45' valign='top'><button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"gb_all(".$dls['cate_id'].",$fid)\">".lang('全选')."</button> </td><td><label class=\"foundphp-style\"><input onclick=\"gb_open(".$dls['cate_id'].",$fid)\" <font style=\"font-size:14px;\" type=\"checkbox\" name=\"power[".$dls['cate_id']."][-o-]\" class=\"fps-ck mini blue m$dls[cate_id] open$dls[cate_id] f$fid\" id=\"$dls[cate_id]\"fid=\"$fid\" value=\"1\"".(isset($set[$dls['cate_id']]['-o-']) && $set[$dls['cate_id']]['-o-']==1?' checked':'')."><span class='fps-show'></span> <span>".lang('访问')."</span></label>&nbsp;&nbsp;&nbsp;".(count($ope)>0?implode('&nbsp;&nbsp;&nbsp;',$ope):'')."</td></tr></table> </td>
				</tr>";
			}
			
			$result .= $return_go;
		}
	}
	
	return $result;
}


/*缓存系统菜单设置文件
	files		缓存路径，默认config/admin_power.php
	
*/
function sys_power_cache($files='admin_power'){
	global $config;
		//权限名
		$sql 		= sql_select( array('table'=> $GLOBALS['table']['a'], 
											'where'=> 'types="sys_model_name"',
											'order'=> $GLOBALS['t_order'], 
											'type' => 'sql')
								);
		$query		= $GLOBALS['db']->query($sql);
		while($dls = $GLOBALS['db']->fetch_array( $query )){
			$power[$dls['cate_name']]	= $dls['cate_desc'];
		}
		//服务器配置
		if ($config['set']['host_id']!=''){
			$GLOBALS['t_where']			.= " AND (host_id=".$config['set']['host_id']." OR language IN('admin','admin_group','admin_user','sys','sys_set','sys_action')) ";
		}
		
		//菜单参数
		$sql 		= sql_select( array('table'=> $GLOBALS['table']['a'], 
											'where'=> $GLOBALS['t_where'].' AND shows=1',
											'order'=> $GLOBALS['t_order'], 
											'type' => 'sql')
								);
		$query		= $GLOBALS['db']->query($sql);
		while($dls = $GLOBALS['db']->fetch_array( $query )){
			unset($dls['types'],$dls['orders'],$dls['up_date'],$dls['shows']);
			if (trim($dls['icon'])==''){
				unset($dls['icon']);
			}
			
			if ((int)$dls['cm_id']<=0){
				unset($dls['cm_id']);
			}
			if ((int)$dls['linkto']<=0){
				unset($dls['linkto']);
			}
			if ((int)$dls['lockout']<=0){
				unset($dls['lockout']);
			}			
			$dls['cate_desc'] =  json($dls['cate_desc']);
			if (trim($dls['cate_url'])==''){unset($dls['cate_url']);}
			
			$data[] 	= array_text($dls,1);
			
			if ($dls['lockout'] && $dls['cate_url']){
				$sys_file[]	= "'".$dls['language']."'=>".$dls['lockout'];
			}
			
		}
		if (@$data){
			$GLOBALS['tpl']->writer('data/'.$files.'.php',"<?php\n/*	(C)2005-2020 Lightning Framework Buliding.\n*	官网：http://www.FoundPHP.com\n*	邮箱：master@FoundPHP.com\n*	作者：孟大川\n*	This is not a freeware, use is subject to license terms.\n*	此软件为授权使用软件，请参考软件协议。\n*	http://www.FoundPHP.com/agreement\n*/\n\n//".lang('模块权限名称')."\n\$_sys_pn =".array_text($power).";\n\n\n//".lang('模块功能列表')."\n\$_sys_menu = array(\n".implode(",\n",$data)."\n);\n\$_sys_file = array(\n".(@count((array)$sys_file)>0?implode(",",$sys_file):'')."\n);");
		}
}

//前端菜单
//支持定义显示菜单主id数组
function web_power($data,$fid=0,$level=0){
	$set_powers	= $GLOBALS['_set_power'];
	$show		= $GLOBALS['system_show'];
	$html		= '';
	$sub		= '';
	//层级处理
	if ($level>0){
		$i		= $level;
		$i++;
	}
	
	foreach($data as $k => $v){
		
		if($v['fid'] == $fid){
			if ($v['fid']==0){$i=1;}
			//限制显示4层
			if ($i<=4){
					$sub = web_power($data, $v['cate_id'],$i);
					
					if ($fid>0 && !$sub){
						//加密链接
						$action	= ($v['linkto']?'go&t='.$v['language']:$v['language']);
						$url	= 'href="'.'?m='.$GLOBALS['m'].'&a='.$action.'"';
						//文件管理
						$url	= ($v['lockout']>0 && $v['cate_url'])?'href="'.$v['cate_url'].'"':$url;
					}
					
					//选中菜单
					$check		= ($GLOBALS['a']=='go' && $GLOBALS['t']!='')?$GLOBALS['t']:$GLOBALS['a'];
					
					//文件管理
					if ($GLOBALS['a']=='files' && $GLOBALS['o']!=''){
						$check	= $GLOBALS['o'];
					}
					
					if ($check==$v['language']){
						$GLOBALS['_set_fid']		= $v['fid'];
						$GLOBALS['_sel_title']		= $v['cate_name'];
						$GLOBALS['_sel_id']			= $v['cate_id'];
						unset($set_power[$v['cate_id']]['-o-']);
						$GLOBALS['now_powers']		= @array_flip($v['cate_desc']);
						
						$html .= '<li class="current-page"><a  '.$url.'"><b>'.($v['icon']?'<i class="'.$v['icon'].'"></i>':'').$v['cate_name']. '</b><i class="fa fa-caret-right pull-right" style="width:10%!important;"></i></a>';
					}else{
						$url	= $fid==0||$sub?'':$url;
						$html .= '<li class="menu'.$v['cate_id'].'['.$v['fid'].']"><a '.$url.($GLOBALS['a']==$v['language']?'class="current-page"':'').'>'.($v['icon']?'<i class="'.$v['icon'].'"></i>':'').$v['cate_name'].($fid==0||$sub?'<span class="fa fa-chevron-down"></span>':''). '</a>';
					}
					$html .=$sub."</li>\r\n";
			}
		}
	}
	
	if ($html && $fid==0){
		$html = power_active($html,$GLOBALS['_set_fid']);
	}
	
	$result = $html ? "\r\n<ul class=\"nav ".($fid>0?'child_menu':'side-menu')." \" style=\"$fid".($i<=2 && $GLOBALS['a']=='default'?';display:block;':'')."\">".$html."</ul>\r\n" : $html;
	return $result;
}


/* 分类路径
	types	类型
	id		最终分类id
	url		连接地址
	show	id显示id序列，反之显示连接
	用法
echo cate_path(array(
		'types'	=> 'sys_menu',
		'id'	=> 385,
		'url'	=> 'admin.php?a=sys_action',
		'show'	=> 'id',
	));
*/
function cate_path($set = array(
				'types'=>'','id'=>0,'url'=>''
			)){
	
	//sql查询
	$sql		= sql_select( array('table'=>'category', 'where'=>"types='$set[types]'",'order'=>'cate_id ASC','type'=>'sql') );
	$query		= $GLOBALS['db']->query($sql);
	while($dls	=  $GLOBALS['db']->fetch_array($query)){
		$category[$dls['cate_id']]	= $dls;
	}
	
	//类目id
	if ($set['show']=='id'){
		return substr(cate_path_id($category,$set[id],$set[url]),1);
	}else{
		return cate_path_sub($category,$set[id],$set[url]);
	}
}
//分类子目录
function cate_path_sub($data,$fid,$url='',$level=0){
	$html		= '';
	$sub		= '';
	if ($data[$fid]){
		$v		= $data[$fid];
		$result	= '&nbsp;>&nbsp;<a href="'.$url.$v['cate_id'].'">'.$v['cate_name'].'</a>';
		$sub	= cate_path_sub($data, $v['fid'],$url,$i+1);
		$result = $sub.$result;
	}
	return $result;
}


//分类子ID
function cate_path_id($data,$fid,$url='',$level=0){
	$html		= '';
	$sub		= '';
	if ($data[$fid]){
		
		$v		= $data[$fid];
		$result	= ','.$v['cate_id'];
		$sub	= cate_path_id($data, $v['fid'],$url,$i+1);
		$result =$sub.$result;
	}
	
	return $result;
}

//获得各个分类数量
function cate_file_number($cateid,$file_type){
	$ary	= explode(',',$cateid);

	foreach($ary AS $k=>$v){
		$sql1	= sql_select( array('table'=>'category', 'where'=>"fid=$v",'order'=>'cate_id ASC','type'=>'sql') );
		$query1 = $GLOBALS['db']->query($sql1);
		while($dls = $GLOBALS['db']->fetch_array($query1)){
			$folder[$v][] = $dls;
		}
		$sql2	= sql_select( array('table'=>'upfiles', 'where'=>"cid=$v AND types=$file_type",'order'=>'id ASC','type'=>'sql') );
		$query2 = $GLOBALS['db']->query($sql2);
		while($dls = $GLOBALS['db']->fetch_array($query2)){
			$file[$v][] = $dls;
		}
		$number[$v] = count($folder[$v])+count($file[$v]);
	
	}
	return  $number;
}