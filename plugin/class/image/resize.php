<?php
/*	(C)2012-2020 FoundPHP Framework.
*	   name: FoundPHP image resize
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: 3.0504
*	  start: 2012-10-01
*	 update: 2020-05-04
*	payment: Free 免费
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
Relation:
resize.php
*/
class FoundPHP_image{
	public $new_width	= '0';
	public $new_height	= '0';
	public $quality		= 93;			//压缩品质92以下会比较粗糙
	public $width		= 0;
	public $height		= 0;
	public $font_file	= 'data/fonts/PuHuiTi.otf';
	public $font_cnt	= 0;		//序列
	public $font_ary	= array();	//文字
	public $block_cnt	= 0;		//序列
	public $block_ary	= array();	//色块
	public $mark_cnt	= 0;		//序列
	public $mark_ary	= array();	//水印
	
	protected $res		= null;		//资源
	protected $ori		= 0;		//旋转角度
	protected $ext		= 'jpg';	//照片格式
	protected $img_type	= array(
			'jpg'	=> 'imagecreatefromjpeg',
			'jpeg'	=> 'imagecreatefromjpeg',
			'png'	=> 'imagecreatefrompng',
			'gif'	=> 'imagecreatefromgif'
	);
	protected $lang		= array(
		'not_file'		=> '抱歉，没有设置image()文件或文件损坏。',
		'not_ext'		=> '抱歉，文件格式只支持:jpg、png、gif',
		'not_res'		=> '抱歉，没有照片资源',
		'not_wh'		=> '抱歉，没有设置resize()输出照片宽高',
		'save_file'		=> '抱歉，没有设置保存文件名或路径错误',
		'memory_set'	=> '抱歉，请打开php.ini找到memory_limit内存设置调大1-2G',
	);
	//构造函数
	function __construct($set=array()){
		if (@$set['quality']>0){
			$this->quality	= $set['quality'];
		}
		//载入语言包
		if (@$set['language']!=''){
			$lang_file		= dirname(__FILE__).'/language/rs_'.$set['language'].'.php';
			if (is_file($lang_file)){
				include_once($lang_file);
				$this->lang	= $GLOBALS['FoundPHP_Lang'];
			}
		}
	}
	/**
	* 获得照片真实格式
	*
	*/
	function ext($files= ''){
		if (function_exists('finfo_file')){
			$finfo	= finfo_open(FILEINFO_MIME_TYPE);
			$finext	= explode('/',finfo_file($finfo,$files));
			$ext	= $finext[1];
		}else{
			$ext	= pathinfo(strtolower($files), PATHINFO_EXTENSION);
		}
		return $ext;
	}
	
	
	
	/**
	* 设置照片
	*
	*/
	function image($filename='',$ext=''){
		if (!is_file($filename)){
			$error		= $this->lang['not_file'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		$this->ext		= pathinfo(strtolower($filename), PATHINFO_EXTENSION);
		if (function_exists("finfo_open")) {
			$handle		= finfo_open(FILEINFO_MIME_TYPE);
			$get_ext	= explode('/',finfo_file($handle, $filename));
			finfo_close($handle);
			$this->ext	= $get_ext[1];
		}
		
		if (in_array($ext,array('jpg','jpeg','png','gif'))){
			$this->ext	= $ext;
		}
		
		//如果无法检测到支持格式提示
		if (!in_array($this->ext,array('jpg','jpeg','png','gif'))){
			$error		= $this->lang['not_ext'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		
		if (function_exists('exif_read_data')){
			//照片旋转处理
			$exif		= @exif_read_data($filename);
			$this->ori	= $exif['Orientation'];
		}
		
		//内存溢出(部分特殊照片单边长的请电脑处理在传)
		$sys_memory			= (int)ini_get('memory_limit');
		list($pic_w,$pic_h)	= getimagesize($filename);
		if (($pic_w>5000||$pic_h>5000) && $sys_memory<128){
			$error		= $this->lang['memory_set'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		
		//照片资源
		$this->res = call_user_func($this->img_type[$this->ext], $filename);
		if (is_resource($this->res)) {
			$this->width	= imagesx($this->res);
			$this->height	= imagesy($this->res);
		}
		
		switch($this->ori){
			case 3:$this->res = imagerotate($this->res, 180, 0);break;
			case 6:$this->res = imagerotate($this->res, -90, 0);break;
			case 8:$this->res = imagerotate($this->res, 90, 0);break;
		}
	}
	
	/**
	* 将 16 进制颜色值转换为 rgb 值
	 
	*/
	static function hexrgb($color = 'ffffff'){
		$color		= str_replace('#','',$color);
		if (strlen($color)!=6){
			$color	= 'ffffff';
		}
		$nc 		= hexdec($color);
		return array(($nc>>16)&0xff, ($nc>>8)&0xff, $nc&0xff);
	}
	
	/**
	* 照片上设置文字
	*
	*/
	function font($set = array()){
		if (trim($set['str'])){
			$this->font_ary[$this->font_cnt]	= $set;
			$this->font_cnt++;
		}
	}
	
	/**
	* 照片上加色块
	*
	*/
	function block($set = array()){
		if (trim($set['color']) && $set['width'] && $set['height']){
			$this->block_ary[$this->block_cnt]	= $set;
			$this->block_cnt++;
		}
	}
	
	/**
	* 照片上水印
	*
	*/
	function mark($set = array()){
		if (is_file($set['img'])){
			if ((int)$set['x']>0){
				$set['x']	=	(int)$set['x'];
			}
			if ((int)$set['y']>0){
				$set['y']	=	(int)$set['y'];
			}
			$this->mark_ary[$this->mark_cnt]	= $set;
			$this->mark_cnt++;
		}
	}
	
	/**
	* 照片缩放裁切功能
	*
	*/
	function resize($set = array()){
		
		if (!$this->res) {
			$error		= $this->lang['not_res'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		if ((int)$set['width']<=0 || (int)$set['height']<=0){
			$error		= $this->lang['not_wh'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		
		$width		= $set['width'];
		$height		= $set['height'];
		$def_width	= $imgx = imagesx($this->res);
		$def_height	= $imgy = imagesy($this->res);
		//不要填充情况
		if ((int)$set['lock']==1) {
			if ($imgx >= $imgy) {
				$height	= doubleval($imgy) / doubleval($imgx)* $width;
				$ratio	= doubleval($width) / doubleval($imgx);
			}else{
				$width	= doubleval($imgx) / doubleval($imgy)* $height;
				$ratio	= doubleval($height) / doubleval($imgy);
			}
		}else{
			$ratio		= doubleval($width) / doubleval($imgx);
		}
		
		$dest			= imagecreatetruecolor($width , $height);
		//自定义颜色
		$bgcolor	= $this->hexrgb(($set['bgcolor']!=''?$set['bgcolor']:'#ffffff'));
		$color = imagecolorallocate($dest, $bgcolor[0], $bgcolor[1], $bgcolor[2]);
		
		//不切图
		if ($set['cut']!=1){
			// 求缩放后的最大宽度和高度
			if ($imgy*$ratio > $height){
				$ratio	= doubleval($height) / doubleval($imgy);
			}
			if((int)$set['lock']==1){
				$dx		= $width;
				$dy		= $height;
			}else{
				$dx		= $imgx* $ratio;
				$dy		= $imgy* $ratio;
			}
			
			//缩放只有4个定位（上下左右）
			if ($set['zoom']==1){
				$set_sx	= $imgx* $ratio;
				$set_sy	= $imgy* $ratio;
			}else{
				//不缩放拥有9个定位点
				$set_sx	= $imgx;
				$set_sy	= $imgy;
				$dx		= $this->width;
				$dy		= $this->height;
			}
			
			//xy设置调整
			switch (strtolower($set['xy'])){
				case 'left':			//左中
					$ox	= 0;
					$oy	= ($height - $set_sy) / 2;
					break;
				case 'right':			//右
					$ox	= $width - $set_sx;
					$oy	= ($height - $set_sy) / 2;
					break;
				case 'top':				//顶中
					$ox	= ($width - $set_sx) / 2;
					$oy	= 0;
					break;
				case 'bottom':			//底中
					$ox	= ($width - $set_sx) / 2;
					$oy	= $height - $set_sy;
					break;
				case 'tl':		//顶左
					$ox	= $oy = 0;
					break;
				case 'tr':		//顶右
					$ox	= $width - $set_sx;
					$oy	= 0;
					break;
				case 'bl':		//底左
					$ox	= 0;
					$oy	= $height - $set_sy;
					break;
				case 'br':		//底右
					$ox	= $width - $set_sx;
					$oy	= $height - $set_sy;
					break;
				default:		//居中
					$ox	= ($width - $set_sx) / 2;
					$oy	= ($height - $set_sy) / 2;
			}
			
			switch($this->ext){
				case'gif':
					$trnprt_indx = imagecolortransparent($this->res);
					if ($trnprt_indx >= 0) {
						$trnprt_color  = imagecolorsforindex($this->res, $trnprt_indx);
						$trnprt_indx  = imagecolorallocate($dest, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
						imagefill($dest, 0, 0, $trnprt_indx);
						imagecolortransparent($dest, $trnprt_indx);
					}
				break;
				case'png':
					if ($set['bgcolor']){
						//自定义颜色
						$bgcolor	= $this->hexrgb($set['bgcolor']);
						$color = imagecolorallocate($dest, $bgcolor[0], $bgcolor[1], $bgcolor[2]);
					}else{
						imagealphablending($dest, false);
						$color = imagecolorallocatealpha($dest, 0, 0, 0, 127);
					}
					imagefill($dest, 0, 0, $color);
					imagesavealpha($dest, true);
				break;
				default:
					imagefilledrectangle($dest, 0, 0, $width, $height, $color);
					imagecolordeallocate($dest, $color);
			}
			//自定义修正定位
			if ((int)$set['x']!=0 || (int)$set['y']!=0){
				$ox		= (int)$set['x']!=0?$ox+(int)$set['x']:$ox;
				$oy		= (int)$set['y']!=0?$oy+(int)$set['y']:$oy;
			}
			
			$args = array($dest, $this->res, round($ox), round($oy), 0, 0, round($dx), round($dy), round($imgx), round($imgy));
		}else{
			//允许图像超出
			if($imgy* $ratio < $height){
				//当按比例缩放的图高小于设置的高度切掉原图右边的部分
				$ratio	= doubleval($imgy) / doubleval($height);
				$imgx	= $width* $ratio;
			}elseif($imgy* $ratio > $height) {
				//当按比例缩放的图高度大于设置的高度切掉图像底部的部分
				$ratio	= doubleval($imgx) / doubleval($width);
				$imgy	= $height* $ratio;
			}
			$cutx	= 0;
			$cuty	= 0;
			//定位切图位置
			switch (strtolower($set['xy'])){
				case 'left':
					$cutx	= 0;
					$cuty	= ($def_height - $imgy) /2;
					break;
				case 'right':
					$cutx	= $def_width - $imgx;
					$cuty	= 0;
					break;
				case 'top':
					$cuty	= $cutx	= 0;
				break;
				case 'bottom':
					$cutx	= 0;
					$cuty	= ($def_height - $imgy);
					break;
				default:
					$cutx	= ($def_width - $imgx) /2;
					$cuty	= ($def_height - $imgy) /2;
			}
			
			//自定义修正定位
			if ((int)$set['x']!=0 || (int)$set['y']!=0){
				$cutx	= (int)$set['x']!=0?$cutx-(int)$set['x']:$cutx;
				$cuty	= (int)$set['y']!=0?$cuty-(int)$set['y']:$cuty;
			}
			switch($this->ext){
				case'gif':
					$trnprt_indx = imagecolortransparent($this->res);
					if ($trnprt_indx >= 0) {
						$trnprt_color  = imagecolorsforindex($this->res, $trnprt_indx);
						$trnprt_indx  = imagecolorallocate($dest, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
						imagefill($dest, 0, 0, $trnprt_indx);
						imagecolortransparent($dest, $trnprt_indx);
					}
				break;
				case'png':
					if ($set['bgcolor']){
						//自定义颜色
						$bgcolor	= $this->hexrgb($set['bgcolor']);
						$color = imagecolorallocate($dest, $bgcolor[0], $bgcolor[1], $bgcolor[2]);
					}else{
						imagealphablending($dest, false);
						$color = imagecolorallocatealpha($dest, 0, 0, 0, 127);
					}
					imagefill($dest, 0, 0, $color);
					imagesavealpha($dest, true);
				break;
				default:
					imagecolortransparent($dest,$color); 
					imagefill($dest,0,0,$color);
			}
			$args = array($dest, $this->res, 0, 0,round($cutx) , round($cuty), round($width), round($height), round($imgx), round($imgy));
		}
		
		call_user_func_array('imagecopyresampled', $args);
		$this->res				= $dest;
		$this->save_width		= $width;
		$this->save_height		= $height;
	}
	
	/**
	* 保存文件
	* filename	保存文件路径及文件名
	*/
	function save($filename,$ext=''){
		if (trim($filename)==''){
			$error  = $this->lang['save_file'];
			function_exists('foundphp_error')?foundphp_error($error):die($error);
		}
		if(!strstr($filename,'.')){
			$filename = $filename.'.'.str_replace('jpeg','jpg',$this->ext);
		}
		
		//自定义色块
		if (count((array)$this->block_ary)){
			foreach($this->block_ary AS $k=>$v) {
				$block_c			= $this->hexrgb($v['color']);
				imagefilledrectangle($this->res,$v['x'],$v['y'],$v['x']+$v['width'],$v['y']+$v['height'],imagecolorallocate($this->res,$block_c['0'],$block_c['1'],$block_c['2']));
			}
		}
		//自定义字体
		if (count((array)$this->font_ary)){
			foreach($this->font_ary AS $k=>$v) {
				if (count($v['str'])){
					//自定义文字颜色
					$font_c			= $this->hexrgb(($v['color']!=''?$v['color']:'#ffffff'));
					$font_color		= imagecolorallocate($this->res,$font_c['0'],$font_c['1'],$font_c['2']);
					$size			= ((int)$v['size']<=0?12:(int)$v['size']);
					$font_file		= is_file($v['font'])?$v['font']:$this->font_file;
					$x				= (int)$v['x'];
					$v['y']			= ((int)$v['y']<=0|| $v['y']<=$size+2)?$size+2:$v['y'];
					$v['angle']		= (float)$v['angle']!=0?(float)$v['angle']:0;
					//自定义阴影
					if ($v['shadow']){
						$shadow_size= (int)$v['shadow_size']>0?$v['shadow_size']:1;
						$shadow_c	= $this->hexrgb($v['shadow']);
						imagettftext($this->res, $size, $v['angle'], (int)$x+$shadow_size, $v['y']+$shadow_size, imagecolorallocate($this->res,$shadow_c['0'],$shadow_c['1'],$shadow_c['2']), $font_file, $v['str']);
					}
					//内容文字
					imagettftext($this->res, $size, $v['angle'], (int)$x, $v['y'], $font_color, $font_file, $v['str']);
				}
				
			}
		}
		
		//水印
		if (count((array)$this->mark_ary)){
			foreach($this->mark_ary AS $k=>$v) {
				
				$ext		= pathinfo(strtolower($v['img']), PATHINFO_EXTENSION);
				$res		= call_user_func($this->img_type[$ext], $v['img']);
				//设置旋转角度
				if ($v['angle']){
					$pngTransparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
					imagefill($res, 0, 0, $pngTransparency);
					$res	= imagerotate($res, $v['angle'], $pngTransparency);
				//	$ext	= 'png';
				}
				//获取水印图片的宽高
				list($mark_w, $mark_h) = getimagesize($v['img']);
				$width		= $this->save_width;
				$height		= $this->save_height;
				//xy设置调整
				if ($v['xy']){
					switch (strtolower($v['xy'])){
						case 'left':			//左中
							$mk_x	= 0+$this->mark_ary[$k]['x'];
							$mk_y	= (($height - $mark_h) / 2)+$this->mark_ary[$k]['y'];
							break;
						case 'right':			//右
							$mk_x	= ($width - $set_sx)+$this->mark_ary[$k]['x'];
							$mk_y	= (($height - $mark_h) / 2)+$this->mark_ary[$k]['y'];
							break;
						case 'top':				//顶中
							$mk_x	= (($width - $mark_w) / 2)+$this->mark_ary[$k]['x'];
							$mk_y	= 0+$this->mark_ary[$k]['y'];
							break;
						case 'bottom':			//底中
							$mk_x	= (($width - $mark_w) / 2)+$this->mark_ary[$k]['x'];
							$mk_y	= ($height - $mark_h)+$this->mark_ary[$k]['x'];
							break;
						case 'tl':		//顶左
							$mk_x	= 0+$this->mark_ary[$k]['x'];
							$mk_y	= 0+$this->mark_ary[$k]['y'];
						break;
						case 'tr':		//顶右
							$mk_x	= ($width - $mark_w)+$this->mark_ary[$k]['x'];
							$mk_y	= 0+$this->mark_ary[$k]['y'];
							break;
						case 'bl':		//底左
							$mk_x	= 0+$this->mark_ary[$k]['x'];
							$mk_y	= ($height - $mark_h)+$this->mark_ary[$k]['y'];
							break;
						case 'br':		//底右
							$mk_x	= ($width - $mark_w)+$this->mark_ary[$k]['x'];
							$mk_y	= ($height - $mark_h)+$this->mark_ary[$k]['y'];
							break;
						default:		//居中
							$mk_x	= (($width - $mark_w) / 2)+$this->mark_ary[$k]['x'];
							$mk_y	= (($height - $mark_h) / 2)+$this->mark_ary[$k]['y'];
					}
				}else{
					$mk_x	= (int)$v['x']+$this->mark_ary[$k]['x'];
					$mk_y	= (int)$v['y']+$this->mark_ary[$k]['y'];
				}
				
				if ($ext=='png'){
					imagecopy($this->res, $res, $mk_x, $mk_y, 0, 0, $mark_w, $mark_h);
				}else{
					imagecopymerge($this->res, $res, $mk_x, $mk_y, 0, 0, $mark_w, $mark_h, ((int)$v['alpha']<=0?100:((int)$v['alpha']>100?100:$v['alpha'])));
				}
				//释放资源
				if ($res){
					@imagedestroy($res);
				}
			}
		}
		//手动指定输出格式
		if($ext!='' && in_array(strtolower($ext),array('gif','png','jpg','jpeg'))){
			$this->ext = $ext;
		}
		
		switch($this->ext){
			case'gif':
				imagegif($this->res, $filename);
			break;
			case'png':
				imagepng($this->res, $filename);
			break;
			case'webp':
				imagewebp($this->res, $filename);
			break;
			case'wbmp':
				imagewbmp($this->res, $filename);
			break;
			default:
				imagejpeg($this->res, $filename, $this->quality);
		}
		//清理内存
		$this->clear();
		return $filename;
	}
	
	/*照片旋转
		files			原始文件地址
		save_file		存储文件地址不需要后缀
		angle			旋转角度：0不旋转，-1可以启动自动旋转
	*/
	function trun($files='',$save_file='',$angle=0){
		//文件格式
		$ext			= $this->ext($files);
		if (is_file($files) && $save_file!=''){
			//读取文件
			$image		= imagecreatefromstring(file_get_contents($files));
			//自动旋转需要开启exif
			if (function_exists('exif_read_data') && $angle==-1){
				//读取文件
				$exif		= exif_read_data($files);
				//自动旋转
				if(!empty($exif['Orientation'])) {
					switch($exif['Orientation']) {
						//逆时针90度
						case 8:		$new_angle = 90;break;
						//顺时针180度
						case 3:		$new_angle = 180;break;
						//顺时针90度
						case 6:		$new_angle = -90;break;
					}
					if (in_array($new_angle,array('-90','90','180'))){
						$image = imagerotate($image,90,0);
					}
				}
			}
			//手动转动
			if (in_array($angle,array('-90','90','180'))){
				$angle_ary	= array('90'=>'-90','-90'=>90,'180'=>180);
				$image = imagerotate($image,$angle_ary[$angle],0);
			}
			if ($image){
				switch($ext){
					case 'bmp':
					case 'jpg':
					case 'jpeg':
					return @imagejpeg($image,$save_file.'.'.$ext,$this->quality);
					break;
					case 'webp':
					return imagewebp($image,$save_file.'.'.$ext);
					break;
					case 'wbmp':
					return imagewbmp($image,$save_file.'.'.$ext);
					break;
					case 'png':
					return imagepng($image,$save_file.'.'.$ext);
					break;
					case 'gif':
					return imagegif($image,$save_file.'.'.$ext);
					break;
				}
			}
		}
	}
	
	/**
	* 清理内存占用
	*/
	function clear(){
		if ($this->res){
			@imagedestroy($this->res);
		}
	}

}
