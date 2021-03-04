//过滤非法字符
function stripscript(s) {
	var pattern = new RegExp("[`~!@#$%^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）――|{}【】‘；：\\”“'。，、？]")
	var rs = "";
	for (var i = 0; i < s.length; i++) {
		rs = rs + s.substr(i, 1).replace(pattern, '');
	}
	return rs;
}(function() {
	var ET = window.ET = window.ET || {
		ary: [],
		//HTML输出
		getcode: function() {
			var $temptxt = $("<div>").html($("#build").html());
			$($temptxt).find(".component").attr({
				"title": null,
				"data-original-title": null,
				"data-type": null,
				"data-content": null,
				"rel": null,
				"trigger": null,
				"style": null
			});
			$($temptxt).find(".valtype").attr("data-valtype", null).removeClass("valtype");
			$($temptxt).find(".component").removeClass("component");
			$($temptxt).find("form").attr({
				"id": null,
				"style": null
			});
			
			source = $temptxt.html().replace(/\n<\/div>/g, "\n\t</div>");
			source = source.replace(/\setplugins=\".+\"/g, "");
			source = source.replace(/etplugins\s|etplugins/g, "");
			source = source.replace(/\<input\s.*etplugins=".+\"\>\n/g, "");
			source = source.replace(/\n\s+\n/g, "");
			source = source.replace(/\s+class=\"\"/g, "");
			source = source.replace(/\s+disabled=\"\"/g, "");
			source = source.replace(/\sformadds/g, "");
			$("#source").val(source);
			//输出mysql
			table = $($temptxt).find("form").attr("title");
			table_n = $($temptxt).find("#from_title").html();
			//字段内容
			table_l = $($temptxt).find(".control-group");
			var fields = new Array();
			desc = "";
			$.each(table_l, function(i, item) {
				//判断类型
				input_t = $(item).find("input");
				if (input_t.attr("type") == 'text' || input_t.attr("type") == 'radio' || input_t.attr("type") == 'checkbox' || input_t.attr("type") == 'file') {
					switch (input_t.attr("type")) {
						//文本框
						case 'text':
							name = stripscript(input_t.attr("name")).trim();
							field_id = "  `" + name + "` varchar(125) ";
							//默认值
							val = stripscript(input_t.attr("value"));
							if (val) {
								field_id += "DEFAULT '" + val + "'";
							} else {
								field_id += "NOT NULL";
							}
							//备注
							check = stripscript(input_t.attr("placeholder"));
							if (check) {
								desc += $(item).find(".tag-title").html().trim() + "{[]}" + check;
							} else {
								desc += $(item).find(".tag-title").html().trim();
							}
						break;
						//单选
						case 'radio':
							desc = stripscript($(item).find(".tag-title").html().trim()) + "{[";
							radios = $(item).find(":radio");
							var desc_ary = new Array();
							$.each(radios, function(ri, rval) {
								name = stripscript($(rval).attr('name').trim());
								select = $(rval).is(":checked") == true ? ">" : "";
								desc_ary[ri] = select + stripscript($(rval).attr('value').trim()) + '=' + stripscript($(rval).attr('title').trim());
							});
							field_id = "  `" + name + "` tinyint(2)";
							//备注
							if (Array.isArray(desc_ary) && desc_ary.length > 0) {
								desc += desc_ary.join("|");
							}
							desc += "]}";
						break;
						//复选框
						case 'checkbox':
							desc = stripscript($(item).find(".tag-title").html().trim()) + "{[";
							radios = $(item).find(":checkbox");
							var desc_ary = new Array();
							$.each(radios, function(ri, rval) {
								name = stripscript($(rval).attr('name').trim());
								select = $(rval).is(":checked") == true ? ">" : "";
								desc_ary[ri] = select + stripscript($(rval).attr('value').trim()) + '=' + stripscript($(rval).attr('title').trim());
							});
							field_id = "  `" + name + "` varchar(255) NOT NULL";
							//备注
							if (Array.isArray(desc_ary) && desc_ary.length > 0) {
								desc += desc_ary.join("|");
							}
							desc += "]}";
						break;
						
						//上传文件 上传文件{[file:fields=xxx|name=attach]}
						case 'file':
							name	= stripscript(input_t.attr("name")).trim();
							id		= stripscript(input_t.attr("id")).trim();
							field_id = "  `" + name + "` varchar(255) NOT NULL";
							desc 	= stripscript($(item).find(".tag-title").html().trim()) + "{[";
							desc += "file:fields="+id;
							desc += "|name="+name;
							
							desc += "]}";
							
						break;
					}
				} else {
					field_id = '';
					input_t = $(item).find("textarea");
					if (input_t.length) {
						name = input_t.attr("name").trim();
						field_id = "  `" + name + "` text ";
						//动态编辑器
						editor = input_t.attr("lang")
						if (editor == 'editor') {
							desc_exe = "exe:editor()";
						} else {
							desc_exe = "";
						}
						//默认值
						if (input_t.val() && desc_exe != '') {
							desc_exe += "|val=" + input_t.val();
						} else if (input_t.val()) {
							desc_exe += "val=" + input_t.val();
						}
						//备注
						check = stripscript(input_t.attr("placeholder"));
						if (check) {
							desc += $(item).find(".tag-title").html().trim() + "{[" + desc_exe + "]}" + check;
						} else {
							desc += $(item).find(".tag-title").html().trim() + "{[" + desc_exe + "]}";
						}
					}
					//下拉框
					input_t = $(item).find("select");
					if (input_t.length) {
						name = stripscript(input_t.attr("name")).trim();
						field_id = "  `" + name + "` varchar(125) ";
						desc = stripscript($(item).find(".tag-title").html().trim()) + "{[";
						where = input_t.attr("lang");
						if (where) {
							desc += where.replace(/\'/g, "''");
						} else {
							option = $(item).find("select option");
							var desc_ary = new Array();
							$.each(option, function(si, sval) {
								select = $(sval).is(":selected") == true ? ">" : "";
								desc_ary[si] = select + stripscript($(sval).val().trim()) + '=' + stripscript($(sval).text().trim());
							});
							//选项
							if (Array.isArray(desc_ary) && desc_ary.length > 0) {
								desc += desc_ary.join("|");
							}
						}
						desc += "]}";
					}
				}
				if (field_id) {
					fields[i] = field_id + " COMMENT '" + desc + "'";
				}
			});
			if (Array.isArray(fields) && fields.length > 0) {
				fieldr = ",\n" + fields.join(",\n") + "\n";
			} else {
				fieldr = "\n";
			}
			output = "CREATE TABLE IF NOT EXISTS `" + table + "` (\n  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT" + fieldr + ")\nENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='" + table_n + "';\n";
			$("#mysql").val(output);
		}
	};
/* 表单名称控件 form_name
	acc  是 class="component" 的DIV 
	e 是 class="etplugins" 的控件
	*/
	ET.ary['et_from'] = function(active_component, etplugins) {
		var popover = $(".popover");
		//右弹form  初始化值
		$(popover).find("#orgtable").val($(".formadds").attr('lang'));
		$(popover).find("#orgtitle").val(active_component.find(".et_from").text());
		$(popover).find("#orgvalue").val($(".formadds").attr('action'));
		var post_get = $(".formadds").attr('method');
		if (post_get == 'POST') {
			$("#FROM_POST").attr('checked', 'true');
		} else {
			$("#FROM_GET").attr('checked', 'true');
		}
		var attach = $(".formadds").attr('enctype');
		if (attach == 'multipart/form-data') {
			$("#FROM_ATTACH").attr('checked', 'true');
		}
		//右弹form  取消控件
		$(popover).delegate(".btn-danger", "click", function(e) {
			e.preventDefault();
			active_component.popover("hide");
		});
		//右弹form  确定控件
		$(popover).delegate(".btn-info", "click", function(e) {
			e.preventDefault(); //阻止元素发生默认的行为(例如,当点击提交按钮时阻止对表单的提交
			var inputs = $(popover).find("input");
			$.each(inputs, function(i, e) {
				var attr_name = $(e).attr("id"); //属性名称
				var attr_val = $("#" + attr_name).val();
				switch (attr_name) {
				case 'FROM_POST':
					check_pg = $("#FROM_POST").attr("checked");
					if (check_pg == 'checked') {
						$(".formadds").attr('method', 'POST');
					}
					break;
				case 'FROM_GET':
					check_pg = $("#FROM_GET").attr("checked");
					if (check_pg == 'checked') {
						$(".formadds").attr('method', 'GET');
					}
					break;
					//上传附件标识
				case 'FROM_ATTACH':
					check_pg = $("#FROM_ATTACH").attr("checked");
					if (check_pg == 'checked') {
						$(".formadds").attr('enctype', 'multipart/form-data');
					} else {
						$(".formadds").removeAttr('enctype');
					}
					break;
				case 'orgtable':
					$(".formadds").attr('lang', attr_val);
					break;
				case 'orgtitle':
					$(".et_from").text(attr_val);
					break;
				case 'orgvalue':
					$(".formadds").attr('action', attr_val);
					break;
				default:
					$(etplugins).attr(attr_name, attr_val);
				}
				active_component.popover("hide");
				ET.getcode(); //重置源代码
			});
		});
	}
})();
//启动项目
$(document).ready(function() {
	$("#navtab").delegate("#sourcetab", "click", function(e) {
		ET.getcode();
	});
	$("#navtab").delegate("#mysqltab", "click", function(e) {
		ET.getcode();
	});
	$("form").delegate(".component", "mousedown", function(md) {
		$(".popover").remove();
		md.preventDefault();
		var tops = [];
		var mouseX = md.pageX;
		var mouseY = md.pageY;
		var $temp;
		var timeout;
		var $this = $(this);
		var delays = {
			main: 0,
			form: 120
		}
		var type;
		if ($this.parent().parent().parent().parent().attr("id") === "components") {
			type = "main";
		} else {
			type = "form";
		}
		var delayed = setTimeout(function() {
			if (type === "main") {
				$temp = $("<form class='form-horizontal span6' id='temp'></form>").append($this.clone());
			} else {
				if ($this.attr("id") !== "legend") {
					$temp = $("<form class='form-horizontal span6' id='temp'></form>").append($this);
				}
			}
			$("body").append($temp);
			$temp.css({
				"position": "absolute",
				"top": +mouseY - ($temp.height() / 2) + "px",
				"left": mouseX - ($temp.width() / 2) + "px",
				"opacity": "0.8"
			}).show()
			var half_box_height = ($temp.height() / 2);
			var half_box_width = ($temp.width() / 2);
			var $target = $("#target");
			var tar_pos = $target.position();
			var $target_component = $("#target .component");
			$(document).delegate("body", "mousemove", function(mm) {
				var mm_mouseX = mm.pageX;
				var mm_mouseY = mm.pageY;
				
				$temp.css({
					"top": mm_mouseY - half_box_height + "px",
					"left": mm_mouseX - half_box_width + "px"
				});
				if (mm_mouseX > tar_pos.left && mm_mouseX < tar_pos.left + $target.width() + $temp.width() / 2 && mm_mouseY > tar_pos.top && mm_mouseY < tar_pos.top + $target.height() + $temp.height() / 2) {
					$("#target").css("background-color", "#fafdff");
					$target_component.css({
						"border-top": "1px solid white",
						"border-bottom": "none"
					});
					tops = $.grep($target_component, function(e) {
						return ($(e).position().top - mm_mouseY + half_box_height > 0 && $(e).attr("id") !== "legend");
					});
					
					if (tops.length > 0) {
						$(tops[0]).css("border-top", "1px solid #22aaff");
					} else {
						if ($target_component.length > 0) {
							$($target_component[$target_component.length - 1]).css("border-bottom", "1px solid #22aaff");
						}
					}
				} else {
					$("#target").css("background-color", "#fff");
					$target_component.css({
						"border-top": "1px solid white",
						"border-bottom": "none"
					});
					$target.css("background-color", "#fff");
				}
			});
			$("body").delegate("#temp", "mouseup", function(mu) {
				mu.preventDefault();
				var mu_mouseX = mu.pageX;
				var mu_mouseY = mu.pageY;
				var tar_pos = $target.position();
				$("#target .component").css({
					"border-top": "1px solid white",
					"border-bottom": "none"
				});
				// acting only if mouse is in right place
				if (mu_mouseX + half_box_width > tar_pos.left && mu_mouseX - half_box_width < tar_pos.left + $target.width() && mu_mouseY + half_box_height > tar_pos.top && mu_mouseY - half_box_height < tar_pos.top + $target.height()) {
					$temp.attr("style", null);
					// where to add
					if (tops.length > 0) {
						$($temp.html()).insertBefore(tops[0]);
					} else {
						$("#target fieldset").append($temp.append("\n\n\ \ \ \ ").html());
					}
				} else {
					// no add
					$("#target .component").css({
						"border-top": "1px solid white",
						"border-bottom": "none"
					});
					tops = [];
				}
				//clean up & add popover
				$target.css("background-color", "#fff");
				$(document).undelegate("body", "mousemove");
				$("body").undelegate("#temp", "mouseup");
				$("#target .component").popover({
					trigger: "manual"
				});
				$temp.remove();
				ET.getcode();
			});
		}, delays[type]);
		$(document).mouseup(function() {
			clearInterval(delayed);
			return false;
		});
		$(this).mouseout(function() {
			clearInterval(delayed);
			return false;
		});
	});
	//activate legend popover
	$("#target .component").popover({
		trigger: "manual"
	});
	
	//弹出编辑菜单
	$("#target").delegate(".component", "click", function(e) {
		e.preventDefault();
		var active_component = $(this);
		active_component.popover("show");
		var etplugins = active_component.find(".etplugins");
		var plu_name = $(etplugins).attr("etplugins"); //etplugins="text"
		if (typeof(ET.ary[plu_name]) == 'function') {
			try {
				ET.ary[plu_name](active_component, etplugins);
			} catch (e) {
				alert('载入控件代码错误！');
			}
		} else {
			alert("代码错误或找不到控件！");
		}
	});
});