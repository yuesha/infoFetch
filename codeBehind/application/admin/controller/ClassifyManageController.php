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
        // 使用模型里的方法去获取数据
        return Classify::getList($page, $limit);
    }
    // 保存分类信息
    public function save()
    {
        // 接收分类信息
        $name = trim_blank(input('post.name'));
        $id = (int)input('post.id');
        // 添加时判断分类是否存在
        if (!$id) {
            $isset = Classify::getByName($name);
            if ($isset) {
                exit_msg("此分类已存在，请勿重复添加");
            }
        }
    }
}
