<?php
/*	(C)2012-2020 FoundPHP Framework.
*	   name: FoundPHP image resize
*	 weburl: http://www.FoundPHP.com
* 	   mail: master@FoundPHP.com
*	 author: 孟大川
*	version: 2.1104
*	  start: 2012-10-01
*	 update: 2020-11-04
*	payment: Free 免费
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
	
	//gif验证码
		$code	= load('class/image/code','FoundPHP_imgcode');
		$str	= $code->rand_code(6,1);
		session('admin_code',$str);
		
		$code->gif($str,'100','22');
		
	//jpg验证码
		$code	= load('class/image/code','FoundPHP_imgcode');
		$str	= $code->rand_code(6,1);
		session('admin_code',$str);
		
		$code->jpg($str,'100','22');
*/
/**
*FoundPHP_imgcode类
**/
Class FoundPHP_imgcode{
	var $GIF="GIF89a";
	var $VER="FoundPHP Verification Code V2.0530";
	var $BUF=Array();
	var $LOP=0;
	var $DIS=2;
	var $COL=-1;
	var $IMG=-1;
	var $ERR=Array(
		'ERR00'=>"Does not supported function for only one image!",
		'ERR01'=>"Source is not a GIF image!",
		'ERR02'=>"Unintelligible flag ",
		'ERR03'=>"Could not make animation from animated GIF source",
	);
	function __construct(){}
	
	
	function GIFFrame($GIF_src,$GIF_dly=100,$GIF_lop=0,$GIF_dis=0, $GIF_red=0,$GIF_grn=0,$GIF_blu=0,$GIF_mod='bin'){
		if(!is_array($GIF_src)&&!is_array($GIF_tim)){
			printf("%s: %s",$this->VER,$this->ERR['ERR00']);
			exit(0);
		}
		$this->LOP=($GIF_lop>-1)?$GIF_lop:0;
		$this->DIS=($GIF_dis>-1)?(($GIF_dis<3)?$GIF_dis:3):2;
		$this->COL=($GIF_red>-1&&$GIF_grn>-1&&$GIF_blu>-1)?($GIF_red |($GIF_grn<<8)|($GIF_blu<<16)):-1;

		for($i=0,$src_count=count($GIF_src);$i<$src_count;$i++){
			if(strToLower($GIF_mod)=="url"){
				$this->BUF[]=fread(fopen($GIF_src [$i],"rb"),filesize($GIF_src [$i]));
			}elseif(strToLower($GIF_mod)=="bin"){
				$this->BUF[]=$GIF_src[$i];
			}else{
				printf("%s: %s(%s)!",$this->VER,$this->ERR [ 'ERR02' ],$GIF_mod);
				exit(0);
			}
			if(substr($this->BUF[$i],0,6)!="GIF87a"&&substr($this->BUF [$i],0,6)!="GIF89a"){
				printf("%s: %d %s",$this->VER,$i,$this->ERR ['ERR01']);
				exit(0);
			}
			for($j=(13+3*(2<<(ord($this->BUF[$i][10])&0x07))),$k=TRUE;$k;$j++){
				switch($this->BUF [$i][$j]){
					case "!":
						if((substr($this->BUF[$i],($j+3),8))=="NETSCAPE"){
								printf("%s: %s(%s source)!",$this->VER,$this->ERR ['ERR03'],($i+1));
								exit(0);
						}
						break;
					case ";":
						$k=FALSE;
					break;
				}
			}
		}
		$this->GIFAddHeader();
		for($i=0,$count_buf=count($this->BUF);$i<$count_buf;$i++){
			$this->GIFAddFrames($i,$GIF_dly[$i]);
		}
		$this->GIFAddFooter();
	}
	
	/*
		$str		字符串
		$width		宽度
		$height		高度
		$point		干扰点数量
		$border		干扰线数量
	*/
	function jpg($str='',$width=75,$height=25){
		$font_size	= round($height/1.8);
		$im=imagecreate($width, $height);
		imagecolorallocate($im, rand(100,250), rand(200,255),rand(0,35));
		$fontStyle='data/fonts/PuHuiTi.otf';
		for($i=0;$i<round($width/10);++$i){
			$lineColor=imagecolorallocate($im, rand(50,100), rand(50,255),rand(100,150));
			imageline($im, rand(0, $width), 0,  rand(0, $width), $height, $lineColor);
		}
		for($i=0,$len=strlen($str);$i<$len;$i++){
		imagettftext($im,
			$font_size,
			rand(0,40)-rand(0, 25),
			$font_size+$i*$font_size,
			rand(($height-$font_size)+2,$height),
			imagecolorallocate($im, rand(101,200),rand(100,150),rand(10,99)),
			$fontStyle,
			$str[$i]);
		}
		for($i=0;$i<$width*2;++$i){
			imagesetpixel($im, rand(0, $width), rand(0, $height), imagecolorallocate($im, rand(100,250),rand(10,255),rand(100,255)));
		}
		ob_clean();
		header('Content-type:image/png');
		imagepng($im);
		imagedestroy($im);
	}
	/**
	生成包含验证码的GIF图片的函数
		$str		字符串
		$width		宽度
		$height		高度
		$point		干扰点数量
		$border		干扰线数量
	**/
	function gif($str='',$width=75,$height=25,$point=300,$border=4){
		$authstr		=$str?$str:((time()%2==0)?mt_rand(1000,9999):mt_rand(10000,99999));
		$board_width	=$width?$width:75;
		$board_height	=$height?$height:25;
		$point		=$point?$point:90;
		$border		=$border?$border:10;
		// 生成一个32帧的GIF动画
		for($i=0;$i<80;$i++){
			ob_start();
			$image=imagecreate($board_width,$board_height);
			imagecolorallocate($image,0,0,0);
			// 设定文字颜色数组
			$colorList[]=ImageColorAllocate($image,15,73,210);
			$colorList[]=ImageColorAllocate($image,0,64,0);
			$colorList[]=ImageColorAllocate($image,0,0,64);
			$colorList[]=ImageColorAllocate($image,0,128,128);
			$colorList[]=ImageColorAllocate($image,27,52,47);
			$colorList[]=ImageColorAllocate($image,51,0,102);
			$colorList[]=ImageColorAllocate($image,0,0,145);
			$colorList[]=ImageColorAllocate($image,0,0,113);
			$colorList[]=ImageColorAllocate($image,0,51,51);
			$colorList[]=ImageColorAllocate($image,158,180,35);
			$colorList[]=ImageColorAllocate($image,59,59,59);
			$colorList[]=ImageColorAllocate($image,0,0,0);
			$colorList[]=ImageColorAllocate($image,1,128,180);
			$colorList[]=ImageColorAllocate($image,0,153,51);
			$colorList[]=ImageColorAllocate($image,60,131,1);
			$colorList[]=ImageColorAllocate($image,0,0,0);
			$fontcolor=ImageColorAllocate($image,0,0,0);
			$gray=ImageColorAllocate($image,245,245,245);
			$color=imagecolorallocate($image,255,255,255);
			$color2=imagecolorallocate($image,255,0,0);
			imagefill($image,0,0,$gray);
			$space=$board_width/strlen($authstr);		// 字符间距
				for($k=0;$k<strlen($authstr);$k++){
					$colorRandom=mt_rand(0,sizeof($colorList)-1);
					$float_top=rand(0,$board_height-13);
					$float_left=rand(2,10);
					$space_once		= $k==0?$float_left:($space*$k)+$float_left;//判断第一位离边缘的距离
					imagestring($image,6,$space_once,$float_top,substr($authstr,$k,1),$colorList[$colorRandom]);
				}
			for($k=0;$k<$point;$k++){
				$colorRandom=mt_rand(0,sizeof($colorList)-1);
				imagesetpixel($image,rand(0,$board_width),rand(1,$board_height),$colorList[$colorRandom]);
			}

			// 添加干扰线
			for($k=0;$k<$border/2;$k++){
				$colorRandom=mt_rand(0,sizeof($colorList)-1);
				imageline($image,mt_rand(0,$board_width),mt_rand(0,$board_height),mt_rand(0,$board_width),mt_rand(0,$board_height),$colorList[$colorRandom]);
				 $w=mt_rand(10,$board_width);
				 $h=mt_rand(10,$board_width);
				 imagearc($image,$board_width-floor($w / 1),floor($h /1),$w,$h, rand(100,120),rand(100,110),$colorList[$colorRandom]);
			}
			imagegif($image);
			imagedestroy($image);
			$imagedata[]=ob_get_contents();
			ob_clean();
			++$i;
		}
		
		$this->GIFFrame($imagedata);
		Header('Content-type:image/gif');
		echo $this->GetAnimation();
	}
	
	/*
		随机验证码长度
		leng	随机字符长度
		type	类型默认英文与数字 ，1纯数字，2英文
	*/
	function rand_code($leng=5,$type=0){
		$result='';
		if ($type==1){
			for($i=0;$i<$leng;$i++){
				$result.=rand(0,9);
			}
			return $result;
		}elseif($type==2){
			$str_ary	= array('a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','J','K','L','M','N','P','R','S','T','U','V','W','X','Y','Z');
		}else{
			$str_ary	= array('a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','J','K','L','M','N','P','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
		}
		for($i=0;$i<$leng;$i++){
			$rand_ary	 = array_rand($str_ary);
			$result		.= $str_ary[$rand_ary];
		}
		return $result;
	}
	
	function GIFAddHeader(){
		$cmap=0;
		if(ord($this->BUF[0][10])&0x80){
			$cmap=3*(2<<(ord($this->BUF [0][10])&0x07));
			$this->GIF.=substr($this->BUF [0],6,7);
			$this->GIF.=substr($this->BUF [0],13,$cmap);
			$this->GIF.="!\377\13NETSCAPE2.0\3\1".FoundPHP_imgcode::GIFWord($this->LOP)."\0";
		}
	}
	function GIFAddFrames($i,$d){
		$Locals_str=13+3*(2 <<(ord($this->BUF[$i][10])&0x07));
		$Locals_end=strlen($this->BUF[$i])-$Locals_str-1;
		$Locals_tmp=substr($this->BUF[$i],$Locals_str,$Locals_end);
		$Global_len=2<<(ord($this->BUF [0][10])&0x07);
		$Locals_len=2<<(ord($this->BUF[$i][10])&0x07);
		$Global_rgb=substr($this->BUF[0],13,3*(2<<(ord($this->BUF[0][10])&0x07)));
		$Locals_rgb=substr($this->BUF[$i],13,3*(2<<(ord($this->BUF[$i][10])&0x07)));
		$Locals_ext="!\xF9\x04".chr(($this->DIS<<2)+0).chr(($d>>0)&0xFF).chr(($d>>8)&0xFF)."\x0\x0";
		if($this->COL>-1&&ord($this->BUF[$i][10])&0x80){
			for($j=0;$j<(2<<(ord($this->BUF[$i][10])&0x07));$j++){
				if(ord($Locals_rgb[3*$j+0])==($this->COL>> 0)&0xFF&&ord($Locals_rgb[3*$j+1])==($this->COL>> 8)&0xFF&&ord($Locals_rgb[3*$j+2])==($this->COL>>16)&0xFF){
					$Locals_ext="!\xF9\x04".chr(($this->DIS<<2)+1).chr(($d>>0)&0xFF).chr(($d>>8)&0xFF).chr($j)."\x0";
					break;
				}
			}
		}
		switch($Locals_tmp[0]){
			case "!":
				$Locals_img=substr($Locals_tmp,8,10);
				$Locals_tmp=substr($Locals_tmp,18,strlen($Locals_tmp)-18);
				break;
			case ",":
				$Locals_img=substr($Locals_tmp,0,10);
				$Locals_tmp=substr($Locals_tmp,10,strlen($Locals_tmp)-10);
				break;
		}
		if(ord($this->BUF[$i][10])&0x80&&$this->IMG>-1){
			if($Global_len==$Locals_len){
				if($this->GIFBlockCompare($Global_rgb,$Locals_rgb,$Global_len)){
					$this->GIF.=($Locals_ext.$Locals_img.$Locals_tmp);
				}else{
					$byte=ord($Locals_img[9]);
					$byte|=0x80;
					$byte&=0xF8;
					$byte|=(ord($this->BUF [0][10])&0x07);
					$Locals_img[9]=chr($byte);
					$this->GIF.=($Locals_ext.$Locals_img.$Locals_rgb.$Locals_tmp);
				}
			}else{
				$byte=ord($Locals_img[9]);
				$byte|=0x80;
				$byte&=0xF8;
				$byte|=(ord($this->BUF[$i][10])&0x07);
				$Locals_img[9]=chr($byte);
				$this->GIF.=($Locals_ext.$Locals_img.$Locals_rgb.$Locals_tmp);
			}
		}else{
			$this->GIF.=($Locals_ext.$Locals_img.$Locals_tmp);
		}
		$this->IMG=1;
	}
	function GIFAddFooter(){
		$this->GIF.=";";
	}
	function GIFBlockCompare($GlobalBlock,$LocalBlock,$Len){
		for($i=0;$i<$Len;$i++){
			if($GlobalBlock[(3*$i+0)]!=$LocalBlock[(3*$i+0)]||$GlobalBlock[(3*$i+1)]!=$LocalBlock[(3*$i+1)]||$GlobalBlock[(3*$i+2)]!=$LocalBlock[(3*$i+2)]){
				return(0);
			}
		}
		return(1);
	}
	function GIFWord($int){
		return(chr($int&0xFF).chr(($int>>8)&0xFF));
	}
	function GetAnimation(){
		return($this->GIF);
	}
}
?>