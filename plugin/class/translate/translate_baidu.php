<?php
/*	(C)2005-2021 Lightning Framework Buliding.
*	官网：http://www.FoundPHP.com
*	介绍：baidu 翻译接口
*	版本：V20200702
*	邮箱：2335097467@qq.com
*	作者：朱樱倾 Vicky
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement

Example:
//获取ID与key 的网址 https://api.fanyi.baidu.com/api/trans/product/desktop?req=developer
//开发手册网址 https://api.fanyi.baidu.com/doc/21

$config['translate']['type']	= 'baidu';								//翻译平台
$config['translate']['id']		= '';									//开发平台APPID
$config['translate']['key']		= '';									//开发平台密钥
$config['translate']['lang']	= 'zh';
$string				= 'FoundPHP 非常棒！';
$FoundPHP_translate = load('class/translate/translate','FoundPHP_translate',$config['translate']);
$res = $FoundPHP_translate->convert($string,'zh','en');

print_R(json($res));

*/
class translate_api{
	public $types		= 'baidu';//翻译平台
	public $id			= '';//appid
	public $key			= '';//秘钥
	public $lang_type	=  array(
						'en'	=> '英语',
						'zh'	=> '中文简体',
						'yue'	=> '中文繁体',
						'jp'	=> '日语',
						'kor'	=> '韩语',
						'de'	=> '德语',
						'fra'	=> '法语',
						'th'	=> '泰语',
						'spa'	=> '西班牙语',
						'ara'	=> '阿拉伯语',
						'ru'	=> '俄罗斯语',
				);
	//平台专属需要转换的翻译语言类型
	public $lang_change	=  array(
						'zht'	=> 'yue'
				);
	
	public function __construct($set = array()){
		//版本检测 (PHP 5 >= 5.1.0, PHP 7) 可用
		$this->id			= $set['id'];
		$this->key			= $set['key'];
		$this->log_file		= $set['log_file'];//赋值日志路径
		$this->tpl 			= $GLOBALS['tpl'];
		
		
	}

	/* 语言翻译 
	*/
	public function convert($str,$from='',$to=''){
		//转换翻译语言
		if($this->lang_change[$from]!=''){
			$from 	= $this->lang_change[$from];
		}
		if($this->lang_change[$to]!=''){
			$to 	= $this->lang_change[$to];
		}
		$url = 'http://api.fanyi.baidu.com/api/trans/vip/translate';
		$appid 		= $this->id;
		$key 		= $this->key;
		$salt 		= date('YmdHis').rand(1000,9999);
		$sign		= md5($appid.$str.$salt.$key);
		$ary		= array(
					'q'		=> $str,
					'from'	=> $from,
					'to'	=> $to,
					'appid'	=> $appid,
					'salt'	=> $salt,
					'sign'	=> $sign,
				);

		$res = json($this->tpl->curl($url,$ary));
		if($res['error_code']!=''){
			$result['code']			= 0;
			$result['error_code']	= $res['error_code'];
			$result['error_msg']	= $res['error_msg'];
		}else{
			//将所有段落组合在一起
			foreach($res['trans_result'] AS $k=>$v){
				$res_str .= $v['dst']."\r\n\r\n";
			}
			
			$result['code']			= 1;
			$result['text']			= $res_str;
		}
		return json($result);
		
	}
	
}
?>