<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	介绍：翻译接口
*	版本：V20200702
*	邮箱：2335097467@qq.com
*	作者：朱樱倾 Vicky
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement

Example:
	

*/
class FoundPHP_translate{
	public $type	= '';//翻译类型
	//默认中文包
	public $lang_type_def	= array(
						'en'	=> '英语',
						'zh'	=> '中文简体',
						'zht'	=> '中文繁体',
						'jp'	=> '日语',
						'kor'	=> '韩语',
						'de'	=> '德语',
						'fr'	=> '法语',
						'th'	=> '泰语',
						'sp'	=> '西班牙语',
						'ru'	=> '俄罗斯语',
	);
	//英语包
	public $lang_type_en	= array(
						'en'	=> 'English',
						'zh'	=> 'Chinese_simplified',
						'zht'	=> 'Chinese_traditional',
						'jp'	=> 'Japanese',
						'kor'	=> 'Korean',
						'de'	=> 'German',
						'fr'	=> 'French',
						'th'	=> 'Thai',
						'sp'	=> 'Spanish',
						'ru'	=> 'Russian',
	);
	//报错语言包
	public $lang	=  array(
						'sorry'			   	=> '抱歉,',
						'set_type'		   	=> '未设定翻译平台类型',
						'set_notype'	   	=> '未知的接口平台:',
						'key_secret'	   	=> '必须填写key和id',
						'no_content'	  	=> '没有可翻译的字符',
						'from_lang_error'	=> '不支持此类型翻译语言来源:',
						'to_lang_error'	   	=> '不支持翻译到此类型:',
					);
	public function __construct($ary = array()){
		//载入语言包
		if ($ary['lang']!=''){
			$lang	= dirname(__FILE__).'/language/translate_'.$ary['lang'].'.php';
			if (is_file($lang)){
				include_once($lang);
				$this->lang	= $GLOBALS['FoundPHP_Lang'];
			}
		}

		if (!isset($ary['type']) || $ary['type'] == '') {
			$error  = $this->lang['sorry'].$this->lang['set_type'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		$this->type 	= strtolower($ary['type']);
		//引入的接口存在与否
		$api_file		= 'plugin/class/translate/translate_'.$this->type.'.php';
		if (!isset($ary['id']) || $ary['key'] == '') {
			$error  = $this->lang['sorry'].$this->lang['key_secret'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		if (is_file($api_file)){
			include_once $api_file;
			$this->translate 	= new translate_api($ary);
		}else{
			$error  = $this->lang['sorry'].$this->lang['set_notype'].$this->type;
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		
	}
	/* 字符串翻译
		str 	需翻译的字符串
		from	翻译的语言
		to 		被翻译的语言
	*/
	public function convert($str='',$from='zh',$to='en'){
		if($str==''){
			$error  = $this->lang['sorry'].$this->lang['no_content'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		//验证from 和 to 是不是支持使用
		$from   = strtolower($from);
		$to   	= strtolower($to);
		if($this->lang_type_def[$from]==''){
			$error  = $this->lang['sorry'].$this->lang['from_lang_error'].$from;
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		
		if($this->lang_type_def[$to]==''){
			$error  = $this->lang['sorry'].$this->lang['to_lang_error'].$to;
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		
		$ret 	= $this->translate->convert($str,$from,$to);
		return $ret;
	}
	
}
?>