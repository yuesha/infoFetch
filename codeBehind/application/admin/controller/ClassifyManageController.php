<?php
namespace app\admin\controller;

use app\comm\model\classifyModel as Classify;

/**
 * 分类管理控制器
 */
class ClassifyManageController extends \app\comm\baseClass\BaseController
{
    // 分类列表首页渲染
    public function index()
    {
        return view();
    }
    // 分类添加首页渲染
    public function add()
    {
        return view();
    }
    // 获取分类列表数据
    public function getList($page = 1, $limit = 10)
    {
        return Classify::getList($page, $limit);
    }
}
