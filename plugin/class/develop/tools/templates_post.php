<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/

$template_data = '
<form method="POST" id="Eee_form" name="Eee_form" action="{form_adds}">
<table border="1" width="100%" style="border-collapse: collapse" cellspacing="1" cellpadding="2" bordercolor="#C6C6C6">
	<tr>
		<td bgcolor="#E4E4E4" align="center" width="150">项目</td>
		<td bgcolor="#E4E4E4" align="center">内容</td>
	</tr>
	<tr>
		<td align="center">标题</td>
		<td align="left"><input type="text" name="subject" size="40" value="{info[subject]}"></td>
	</tr>
	
	<!-- IF($id>0) -->
	<tr>
		<td align="center">日期</td>
		<td align="left"><input type="text" name="dates" size="40" value="{run:=date(\'Y-m-d H:i\',$info[dates]);}"></td>
	</tr>
	<!-- END -->
	<tr>
		<td align="center">内容</td>
		<td align="left"><textarea rows="18" name="content" cols="50">{info[content]}</textarea></td>
	</tr>
	<tr>
		<td align="center"></td>
		<td align="left"><input type="submit" value="提交"></td>
	</tr>
</table>
</form>



';




?>