$(".add-span").click(function(){
	// 即将创建的内容
	var text = $(this).parents().prev().children("input").val();
	if (text == "") {
		layer.msg("输入框不能为空！",{icon: 2});
	}else{
		// 创建节点内容
		var str = '<div class="layui-form-item del-default-rules">\
			<label for="default_rule" class="layui-form-label">\
				<span class="x-red"></span>                       \
			</label>\
			<div class="layui-input-inline">\
				<input type="text" id="default_rule" name="default_rule" lay-verify="" autocomplete="off" class="layui-input add-input" value="' + text + '"/>\
			</div>\
			<div class="layui-form-mid layui-word-aux">\
				<span class="layui-badge layui-bg-green layuiadmin-badge del-span" onclick="del_span(this)">x</span>\
			</div>\
		</div>';
		// 即将创建的节点
		var $div = $(str);
		// 将节点插入DOM树中
		$(this).parents('.layui-form-item').append($div);
		// 清空原先的输入框
		$(this).parents().prev().children("input").val('')
	};
});
function del_span(obj){
	var obj2 = $(obj).parents('.del-default-rules');
	obj2.remove();
};