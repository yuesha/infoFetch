<?php
namespace app\admin\controller;
use app\comm\model\manageLogModel as manageLog;
/**
 * 日志管理控制器
 */
class LogManageController extends \app\comm\baseClass\BaseController
{
    public function index()
    {
        return view();

    }
    public function getlist($page = 1,$limit = 10)
    {
        return manageLog::getList($page,$limit);
    }
}
