<?php
namespace app\admin\controller;

use app\comm\model\classifyModel as Classify;

/**
 * 分类管理控制器
 */
class ClassifyManageController extends \app\comm\baseClass\BaseController
{
    public function index()
    {
        return view();
    }
    public function add()
    {
        return view();
    }
    public function getList($page = 1, $limit = 10)
    {
        return Classify::getList($page, $limit);
    }
}
