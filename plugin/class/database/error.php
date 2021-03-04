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


class DB_Error{
	var $error		= '';
	//返回友情提示信息
	function __construct($query='',$sql_type,$error='',$error_msg='',$states=''){
		global $PHP_SELF,$_GET;
			//出错语句提示
			$errors = preg_replace("/'(.+?)'/is","&nbsp;'<font color='#8899DF'><b>\\1</b></font>'&nbsp;",$this->error);
			
				//提示语言
				$lang = Array('This SQL Error Info!', 'Error Script:', 'Present time:',
							'Http Host:', 'Server Name:', 'Server Software:',
							'Host IP Address:', 'Remote User Agent:', 'Current File:', 
							'Current Line:', 'Line.', 'The Error number:', 
							'The specific Error was:', 'SQL Query :', 'Not discover whateverly SQL Sentence !',
							'SQL Type:'
							);
				$lang = Array('SQL 语句错误!', '错误脚本:', '当前时间:',
							'服务器地址:', '网址:', '服务器信息:',
							'服务器IP:', '浏览器头信息:', 'Current File:', 
							'Current Line:', 'Line.', '错误号:', 
							'错误原因:', 'SQL语句:', 'Not discover whateverly SQL Sentence !',
							'数据库类型:');
				//时间处理
				$nowdate = date('Y-m-d H:i A');
			
			//检测是否有语句
			if($query!=''){
			//linux 下调试信息
			if (!empty($GLOBALS['_SERVER']['PWD'])){
				echo "\r\nFoundPHP SQL Error:\r\n";
				echo $lang[11].$error."\r\n";
				echo $lang[12].(($error_msg=='')?'N/A':$error_msg)."\r\n";
				echo $lang[15].$sql_type.' '.$states."\r\n\r\n";
				echo $lang[13].$query."\r\n-----------------------------------\r\n";
				return ;
			}
			
			echo "<table style='BORDER-COLLAPSE: collapse;font-size:9pt;' borderColor='#a8b7c6' cellSpacing='1' width='100%' border='1' cellpadding='3' align='center'>
					<tr>
						<td bgColor='#F9F9F9' height='38' colspan='2'>
						<font size='4' face='Arial' color='#800000'>$lang[0]</font></td>
					</tr>
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[2]</td>
						<td bgColor='#F9F9F9'>$nowdate</td>
					</tr>";
					if($_SERVER['REMOTE_ADDR']!='::1'){
						echo "
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[6]</td>
						<td bgColor='#F9F9F9'><font color=\"#800000\">".(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'127.0.0.1')."</font></td>
					</tr>";
					}echo "
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[5]</td>
						<td bgColor='#F9F9F9'>".$_SERVER['SERVER_SOFTWARE']."</td>
					</tr>
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[7]</td>
						<td bgColor='#F9F9F9'><font color=\"#000080\">".$_SERVER['HTTP_USER_AGENT'].";</font></td>
					</tr>
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[15]</td>
						<td bgColor='#F9F9F9'><font color=\"#000080\"><B>".$sql_type.'&nbsp;'.$states."</B></font></td>
					</tr>";
					if($error){
						echo "
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[11]</td>
						<td bgColor='#F9F9F9'><font color=red>".$error."</font></td>
					</tr>";
					}
					if($error_msg){
					echo "
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[12]</td>
						<td bgColor='#F9F9F9'><font color=#CC3300><b>".(($error_msg=='')?'N/A':$error_msg)."</b></font></td>
					</tr>";
					}
					echo "
					<tr>
						<td bgColor='#F9F9F9' width='165'>
						<p align='right'>$lang[13]</td>
						<td bgColor='#F9F9F9'>$query</td>
					</tr>
				</table>
				
					<hr color='#a8b7c6' width='36%' size='1' align='right'>
					<table border='0' width='100%' style='border-collapse: collapse' cellpadding='0'>
						<tr>
							<td align='right'><font style='font-size: 9pt'>Copyright &copy; 2005-".date('Y',time())." by <a href='http://www.systn.com' target='_blank'><b><font color='#000000' style='text-decoration:none;'>SYSTN</font></b></a> All rights Reserved.</font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
	</body>
	</html>";EXIT;
			}
	}
}
?>