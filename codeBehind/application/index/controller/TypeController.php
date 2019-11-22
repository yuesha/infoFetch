<?php
namespace app\index\controller;
use app\comm\model\classifyModel as Classify;

class TypeController
{
    // 获取分类列表数据
    public function getList($page = 1, $limit = 10)
    {
        // 使用模型里的方法去获取数据
        return Classify::getList($page, $limit);
    }
}
