/*e.preventDefault();//阻止元素发生默认的行为(例如,当点击提交按钮时阻止对表单的提交*/



/* 文本框控件 text
acc  是 class="component" 的DIV 
e 是 class="etplugins" 的控件
*/
ET.ary['text'] = function(active_component, et) {
	var popover = $(".popover");
	//右弹form  初始化值
	$(popover).find("#orgtitle").val(active_component.find(".tag-title").text());
	$(popover).find("#orgalt").val($(et).attr("placeholder"));
	$(popover).find("#orgname").val($(et).attr("name"));
	$(popover).find("#orgid").val($(et).attr("id"));
	$(popover).find("#orgvalue").val($(et).val());
	$(popover).find("#orgclass").val($(et).attr("class").replace(/etplugins/g, "").trim());
	//右弹form  取消控件
	$(popover).delegate(".btn-danger", "click", function(e) {
		active_component.popover("hide");
	});
	//右弹form  确定控件
	$(popover).delegate(".btn-info", "click", function(e) {

		var inputs = $(popover).find("input");
		if ($(popover).find("textarea").length > 0) {
			inputs.push($(popover).find("textarea")[0]);
		}

		$.each(inputs, function(i, e) {
			var attr_name = $(e).attr("id"); //属性名称
			var attr_val = $(e).val();
			switch (attr_name) {
			case 'orgtitle':
				active_component.find(".tag-title").text(attr_val);
				break;
			case 'orgalt':
				$(et).attr("placeholder", attr_val);
				break;
			case 'orgname':
				$(et).attr("name", attr_val);
				break;
			case 'orgid':
				$(et).attr("id", attr_val);
				break;
			case 'orgvalue':
				$(et).attr("value", attr_val);
				break;
			case 'orgclass':
				$(et).attr("class", 'etplugins '+attr_val);
				break;
			default:
				$(et).attr(attr_name, attr_val);
			}
			active_component.popover("hide");
			ET.getcode(); //输出html
		});
	});
}

/* 多行文本框控件 textarea
acc  是 class="component" 的DIV 
e 是 class="etplugins" 的控件
*/
ET.ary['textarea'] = function(active_component, et) {
	var popover = $(".popover");
	//右弹form  初始化值
	$(popover).find("#orgtitle").val(active_component.find(".tag-title").text());
	$(popover).find("#orgalt").val($(et).attr("placeholder"));
	$(popover).find("#orgname").val($(et).attr("name"));
	$(popover).find("#orgid").val($(et).attr("id"));
	$(popover).find("#orgvalue").val($(et).val());
	$(popover).find("#orgclass").val($(et).attr("class").replace(/etplugins/g, "").trim());
	if ($(et).attr("lang")=='editor'){
		$(popover).find("#orgeditor").attr("checked","checked");
	}

	//右弹form  取消控件
	$(popover).delegate(".btn-danger", "click", function(e) {

		active_component.popover("hide");
	});
	//右弹form  确定控件
	$(popover).delegate(".btn-info", "click", function(e) {

		var inputs = $(popover).find("input");
		if ($(popover).find("textarea").length > 0) {
			inputs.push($(popover).find("textarea")[0]);
		}
		$.each(inputs, function(i, e) {
			var attr_name = $(e).attr("id"); //属性名称
			var attr_val = $(e).val();
			switch (attr_name) {
			case 'orgtitle':
				active_component.find(".tag-title").text(attr_val);
				break;
			case 'orgalt':
				$(et).attr("placeholder", attr_val);
				break;
			case 'orgname':
				$(et).attr("name", attr_val);
				break;
			case 'orgid':
				$(et).attr("id", attr_val);
				break;
			case 'orgvalue':
				$(et).attr("value", attr_val);
				$(et).text(attr_val);
				break;
			case 'orgclass':
				$(et).attr("class", 'etplugins '+attr_val);
				break;
			case 'orgeditor':
				if ($(e).is(":checked")==true){
					$(et).attr("lang", 'editor');
				}else {
					$(et).attr("lang", '');
				}
				break;
			default:
				$(et).attr(attr_name, attr_val);
			}
			active_component.popover("hide");
			ET.getcode(); //输出html
		});

	});
}
/* 下拉框控件 select
acc  是 class="component" 的DIV 
e 是 class="etplugins" 的控件
*/
ET.ary['select'] = function(active_component, et) {
	var popover = $(".popover");
	//右弹form  初始化值
	$(popover).find("#orgtitle").val(active_component.find(".tag-title").text());
	$(popover).find("#orgname").val($(et).attr("name"));
	$(popover).find("#orgid").val($(et).attr("id"));
	$(popover).find("#orgselect").val($(et).attr("lang"));

	var val = $.map($(et).find("option"), function(e, i) {
		select = $(e).is(":checked")==true?">":"";
		return select+$(e).val() + '=' + $(e).text();
	});
	val = val.join("\r");
	$(popover).find("#orgvalue").text(val);
	//右弹form  取消控件
	$(popover).delegate(".btn-danger", "click", function(e) {
		active_component.popover("hide");
	});
	//右弹form  确定控件
	$(popover).delegate(".btn-info", "click", function(e) {

		var inputs = $(popover).find("input");
		if ($(popover).find("textarea").length > 0) {
			inputs.push($(popover).find("textarea")[0]);
		}
		$.each(inputs, function(i, e) {
			var attr_name = $(e).attr("id"); //属性名称
			var attr_val = $(e).val();
			switch (attr_name) {
			case 'orgtitle':
				active_component.find(".tag-title").text(attr_val);
				break;
			case 'orgname':
				$(et).attr("name", attr_val);
				break;
			case 'orgid':
				$(et).attr("id", attr_val);
				break;
			case 'orgvalue':
				var options = attr_val.split("\n");
				$(et).html("");
				$.each(options, function(i, e) {
					var strs = new Array(); //定义一数组 
					strs = e.split("="); //字符分割
					$(et).append("\n");
					if (strs[1].trim()) {
						//判断是否选中
						check_set	= strs[0].trim().charAt(0);
						check 		= (check_set==">")?' selected ':'';
						$(et).append("<option"+check+" value='"+stripscript(strs[0].trim())+"'>"+strs[1].trim()+"</option>");
					}
				});
				break;
			case 'orgselect':
				$(et).attr("lang", attr_val);
				break;
			default:
				$(et).attr(attr_name, attr_val);
			}
			active_component.popover("hide");
			ET.getcode(); //输出html
		});

	});
}

/* 复选控件 checkbox
acc  是 class="component" 的DIV 
e 是 class="etplugins" 的控件
*/
ET.ary['checkbox'] = function(active_component, et) {
	var popover = $(".popover");
	//右弹form  初始化值
	$(popover).find("#orgtitle").val(active_component.find(".tag-title").text());
	$(popover).find("#orgname").val($(et).attr("name"));
	$(popover).find("#orgclass").val($(et).attr("class").replace(/etplugins/g, "").trim());

	val = $.map($(et), function(e, i) {
		select = $(e).is(":checked")==true?">":"";
		return select+$(e).val() + '=' + $(e).attr("title");
	});
	val = val.join("\r");
	$(popover).find("#orgvalue").text(val);
	//右弹form  取消控件
	$(popover).delegate(".btn-danger", "click", function(e) {

		active_component.popover("hide");
	});
	//右弹form  确定控件
	$(popover).delegate(".btn-info", "click", function(e) {

		var inputs = $(popover).find("input");
		if ($(popover).find("textarea").length > 0) {
			inputs.push($(popover).find("textarea")[0]);
		}
		$.each(inputs, function(i, e) {
			var attr_name = $(e).attr("id"); //属性名称
			var attr_val = $(e).val();
			if (attr_name == 'orgclass') {
				class_name = attr_val.trim();
			}

			switch (attr_name) {
			case 'orgtitle':
				active_component.find(".tag-title").text(attr_val);
				break;
			case 'orgname':
				$(et).attr("name", attr_val);
				break;
				//要break
			case 'orgvalue':
				var checkboxes = attr_val.split("\n");
				var html = "";


				$.each(checkboxes, function(i, e) {
					var strs = new Array(); //定义一数组 
					strs = e.split("="); //字符分割
					if (e.length > 0) {
						var new_class = attr_val
						var vName = $(et).eq(i).attr("name"),
							vTitle = $(et).eq(i).attr("title"),
							orginline = $(et).eq(i).attr("orginline");
						if (!vName) vName = '';
						if (!vTitle) vTitle = '';
						if (!orginline) orginline = '';
						
						//判断是否选中
						check_set	= strs[0].trim().charAt(0);
						check 		= (check_set==">")?' checked ':'';
						html += '<label class="checkbox ' + orginline + '">\n<input'+check+' type="checkbox" name="' + vName + '" title="' + strs[1].trim() + '" value="' + stripscript(strs[0].trim()) + '" orginline="' + orginline + '" class="' + class_name + '" et="checkbox" >' + strs[1].trim() + '\n</label>';
					}
					$(active_component).find(".et-orgvalue").html(html);
				});
				break;
			case 'orgclass':
				$(et).attr("class", 'etplugins '+attr_val);
				break;

			default:
				$(et).attr(attr_name, attr_val);
			}
			active_component.popover("hide");
			ET.getcode(); //输出html
		});

	});
}

/* 复选控件 radio
acc  是 class="component" 的DIV 
e 是 class="etplugins" 的控件
*/
ET.ary['radio'] = function(active_component, et) {
	var popover = $(".popover");
	//右弹form  初始化值
	$(popover).find("#orgtitle").val(active_component.find(".tag-title").text());
	$(popover).find("#orgname").val($(et).attr("name"));
	$(popover).find("#orgclass").val($(et).attr("class").replace(/etplugins/g, "").trim());
	val = $.map($(et), function(e, i) {
		select = $(e).is(":checked")==true?">":"";
		return select+$(e).val() + '=' + $(e).attr("title");
	});
	val = val.join("\r");
	$(popover).find("#orgvalue").text(val);
	//右弹form  取消控件
	$(popover).delegate(".btn-danger", "click", function(e) {
		active_component.popover("hide");
	});
	//右弹form  确定控件
	$(popover).delegate(".btn-info", "click", function(e) {

		var inputs = $(popover).find("input");
		if ($(popover).find("textarea").length > 0) {
			inputs.push($(popover).find("textarea")[0]);
		}
		$.each(inputs, function(i, e) {
			var attr_name 	= $(e).attr("id"); //属性名称
			var attr_val 		= $(e).val();
			if (attr_name == 'orgclass') {
				class_name = attr_val.trim();
			}
			switch (attr_name) {
			case 'orgtitle':
				active_component.find(".tag-title").text(attr_val);
				break;
			case 'orgname':
				$(et).attr("name", attr_val);
				break;
			case 'orgvalue':
				var checkboxes = attr_val.split("\n");
				var html = "";
				$.each(checkboxes, function(i, e) {
					var strs = new Array(); //定义一数组 
					strs = e.split("="); //字符分割
					if (e.length > 0) {
						var vName = $(et).eq(i).attr("name"),
							vTitle = $(et).eq(i).attr("title"),
							orginline = $(et).eq(i).attr("orginline");
						if (!vName) vName = '';
						if (!vTitle) vTitle = '';
						if (!orginline) orginline = '';
						
						//判断是否选中
						check_set	= strs[0].trim().charAt(0);
						check 		= (check_set==">")?' checked ':'';
						
						html += '<label class="radio ' + orginline + '">\n<input'+check+' type="radio" name="' + vName + '" title="' + strs[1].trim() + '" value="' + stripscript(strs[0].trim()) + '" orginline="' + orginline + '" class="' + class_name + '" et="radio" >' + strs[1].trim() + '\n</label>';
					}
					$(active_component).find(".et-orgvalue").html(html);
				});
				break;
			case 'orgclass':
				$(et).attr("class", 'etplugins '+attr_val);
				break;
			default:
				$(et).attr(attr_name, attr_val);
			}
			active_component.popover("hide");
			ET.getcode(); //输出html
		});

	});
}

/* 上传控件 uploadfile
acc  是 class="component" 的DIV 
e 是 class="etplugins" 的控件
*/
ET.ary['uploadfile'] = function(active_component, et) {
	var popover = $(".popover");
	//右弹form  初始化值
	$(popover).find("#orgtitle").val(active_component.find(".tag-title").text());
	$(popover).find("#orgname").val($(et).attr("name"));
	$(popover).find("#orgid").val($(et).attr("id"));
	$(popover).find("#orgclass").val($(et).attr("class").replace(/etplugins/g, "").trim());
	//右弹form  取消控件
	$(popover).delegate(".btn-danger", "click", function(e) {

		active_component.popover("hide");
	});
	//右弹form  确定控件
	$(popover).delegate(".btn-info", "click", function(e) {

		var inputs = $(popover).find("input");
		if ($(popover).find("textarea").length > 0) {
			inputs.push($(popover).find("textarea")[0]);
		}
		$.each(inputs, function(i, e) {
			var attr_name = $(e).attr("id"); //属性名称
			var attr_val = $(e).val();
			switch (attr_name) {
			case 'orgtitle':
				active_component.find(".tag-title").text(attr_val);
				break;
			case 'orgalt':
				$(et).attr("placeholder", attr_val);
				break;
			case 'orgname':
				$(et).attr("name", attr_val);
				break;
			case 'orgid':
				$(et).attr("id", attr_val);
				break;
			case 'orgclass':
				$(et).attr("class", 'etplugins '+attr_val);
				break;
			default:
				$(et).attr(attr_name, attr_val);
			}
			active_component.popover("hide");
			ET.getcode(); //输出html
		});

	});
}