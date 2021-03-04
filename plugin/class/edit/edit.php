<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：43309611@qq.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*	Last：2020-01-20
*/

class FoundPHP_edit{
	public $type 		= 'text';		//编辑器类型

	//构造快递方法
	function __construct($ary=array()) {
		
		if (!isset($ary['type']) || $ary['type'] == '') {
			return '请设置类型';
		}
		
		$this->type 	= strtolower($ary['type']);
		//默认字符文本
		if (in_array($this->type,array('text',''))){
			$this->type	= 'text';
		}else{		//引入的接口存在与否
			$api_file		= 'plugin/class/edit/edit_'.$this->type.'.php';
			
			if (is_file($api_file)){
				include_once $api_file;
				$this->ed 	= new edit_api($ary);
				
			}else{
				die('抱歉，找不到 '.$this->type.' 库');//不存在
			}
		}
	}
	
	//初始化数据
	function welcome(){
		$this->ed->welcome();
	}
	
	/*
		编辑器
		ary 用法
			id			编辑器id等于接收post名称
			data		编辑器默认数据
			width		编辑器宽度 最小宽度500
			height		编辑器高度	自动为auto
			readonly	true 表示只读
			echo edit(array('id'=>'content','data'=>$content,'height'=>300));
	*/
	function edit($ary=array()){
		if ($this->type=='text'){
			$set		= '';
			if ($ary['readonly']){
				$set 	.= ' readonly="readonly"';
			}
			$width	= 'width:'.($ary['width']!=''?$ary['width']:'100%').';';
			$height	= 'height:'.($ary['height']!=''?$ary['height']:'300px').';';
			$set		.= ' style="'.$width.$height.'"';
			
			return '<textarea name="'.$ary['id'].'"'.$set.'>'.$ary['data'].'</textarea>';
		}else{
			return $this->ed->edit($ary);
		}
	}
	
	/*消息提示
		code		0失败 1成功
		ary
			msg		消息内容
			url		链接
	*/
	function msg($code=0,$ary=array()){
		return $this->ed->msg($code,$ary);
	}
	
	/*上传文件
	*/
	function get_id($ary=array()){
		return $this->ed->get_id($ary);
	}
	
	/*上传文件类型
	*/
	function get_type($ary=array()){
		return $this->ed->get_type($ary);
	}
	
	//管理文件
	function manger($dirs=''){
		return $this->ed->manger($dirs);
	}
}