<?php
/*	(C)2005-2021 FoundPHP Framework.
*	官网：http://www.FoundPHP.com
*	邮箱：master@FoundPHP.com
*	This is not a freeware, use is subject to license terms.
*	此软件为授权使用软件，请参考软件协议。
*	http://www.foundphp.com/?m=agreement
*/
$template_data = '

<table border="0" width="100%">
<form method="POST" id="Eee_form" name="Eee_form" action="{form_adds}">
	<tr>
		<td>快速搜索: <input type="text" name="keys" value="{keys}" size="20">
	    <input value=" 确定 " onclick="Eee_form.submit();" type="button">  
		</td>
		<td></td>
	</tr>
</form>
</table>


<table border="1" width="100%" id="table1" style="border-collapse: collapse" cellspacing="1" cellpadding="2" bordercolor="#C6C6C6">
	<tr>
		<td bgcolor="#E4E4E4" align="center" width="30">ID</td>
		<td bgcolor="#E4E4E4" align="center">标题</td>
		<td bgcolor="#E4E4E4" align="center">日期</td>
		<td bgcolor="#E4E4E4" align="center" width="80">操作</td>
	</tr>
<!-- while:$dl = $db_obj->fetch_array($data_info[\'query\']) -->
	<tr  bgcolor="{color:#fffff,#ececec}">
		<td align="center">{dl[id]}</td>
		<td>{dl[subject]}</td>
		<td align="center">{run:=date("Y-m-d H:i",$dl[\'dates\'])}</td>
		<td align="center"><a href="{sys_page}?model={model}&action={action}&todo=edit&id={dl[id]}">编辑</a> | 
		<a onclick="javascript:if(confirm(\'您确定要继续当前操作吗?\'))location=\'{page_adds}&todo=del&id={dl[id]}\';return false;" href="{page_adds}&todo=del&id={dl[id]}" style="color:#800000">删除</a></td>
	</tr>
<!-- END -->

<!-- IF($_i==0) -->
	<tr>
		<td colspan="6" height="50" align="center" class="font13"><b>目前没有数据列表</b></td>
	</tr>
<!-- END -->
	<tr>
		<td colspan="6" align="left" class="font13">{pages}</td>
	</tr>
</table>
';

?>