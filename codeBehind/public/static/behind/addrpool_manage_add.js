
// 插入 新的元素
function add_span(rule,obj){
	// 即将创建的内容
	var text = $(obj).parents().prev().children("input").val();
	if (text == "") {
		layer.msg("输入框不能为空！",{icon: 2});
	}else{
		// 创建节点内容
		var str = '<div class="layui-form-item del-default-rules">\
			<label for="' + rule + '" class="layui-form-label">\
				<span class="x-red"></span>                       \
			</label>\
			<div class="layui-input-inline">\
				<input type="text" id="' + rule + '" name="' + rule + '[]" lay-verify="" autocomplete="off" class="layui-input add-input" value="' + text + '"/>\
			</div>\
			<div class="layui-form-mid layui-word-aux">\
				<span class="layui-badge layui-bg-red layuiadmin-badge del-span" onclick="del_span(this)">x</span>\
			</div>\
		</div>';
		// 即将创建的节点
		var $div = $(str);
		// 将节点插入DOM树中
		$(obj).parents('.layui-form-item').append($div);
		// 创建的输入框只读不可修改
		$('.add-input').attr('readonly','readonly');
		// 清空原先的输入框
		$(obj).parents().prev().children("input").val('')
	};
}
// 删除 添加的元素
function del_span(obj){
	var obj2 = $(obj).parents('.del-default-rules');
	obj2.remove();
};
// 编辑-删除原有的元素
function delThis(obj) {
	$(obj).parents('div.demo').remove();
}