<?php
namespace app\admin\controller;

use app\comm\model\fetchPoolModel as fetchPool;
use app\comm\model\classifyModel as Classify;
use app\comm\model\manageLogModel as ManageLog;

/**
 * 从目录抓取地址 控制器
 */
class DireFetchController extends \app\comm\baseClass\BaseController
{
    // 符合自动抓取地址条件的 地址池列表首页渲染
    public function index()
    {
        // 获取所有分类信息
        $data = [];
        return view('',$data);
    }
    // 获取 符合自动抓取地址条件的 地址池列表数据
    public function getList($page = 1, $limit = 10)
    {

        // return return_table();
    }
}
