//当前页面地址
var page_url = window.location.search; 
//jQuery
window.jQuery || document.write("<script language=javascript src='"+style_dir+"js/jquery.1.min.js'></script>");
//带搜索下拉框
document.write("<script language=javascript src='"+style_dir+"js/tinyselect/tinyselect.min.js'></script>");
//Bootstrap
document.write("<script language=javascript src='"+style_dir+"bootstrap/js/bootstrap.min.js'></script>");
//Layer UI
document.write("<script language=javascript src='"+style_dir+"js/layer/layer.js'></script>");

/*成功消息
	text		提示文字
	settime		消失时长 秒，默认1秒
*/
function sys_good(text,settime){
	var FD_timeout	= (settime>0)?settime*1000:1000;
	layer.msg(text,{time: FD_timeout,icon:1,shade:0.6,shadeClose:true});
}
/*失败消息
	text		提示文字
	settime		消失时长 秒，默认1秒
*/
function sys_error(text,settime){
	var FD_timeout	= (settime>0)?settime*1000:1000;
	layer.msg(text,{time: FD_timeout,icon:2,shade:0.6,shadeClose:true});

}
/* 消息提示
	text		提示文字
	url			跳转连接地址
	settime		跳转时长 秒
 */
function msg(text,url,settime){
	var FD_timeout	= (settime>0)?settime*1000:1000;
	//网址跳转
	if (url!='' && FD_timeout==0){
		if (url!=undefined){
		top.location = url;
		}
		return false;
	}
	//弹窗
	layer.alert(text,{
		skin: 'layui-layer-lan'
		,closeBtn: 0
		,shade:0.6
		,anim:2 //动画类型
		,time: FD_timeout
	},function(){
		if (url!=undefined){
			top.location = url;
		}
		return false;
	});
	//延时跳转
	if (text!='' && url!='' && FD_timeout>0){
		setTimeout(function(){top.location = url},FD_timeout);return false;
	}
}


