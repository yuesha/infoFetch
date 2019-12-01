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
        // 获取所有数据
        $allList = fetchPool::all(function($query){
            $query -> where('auto_rule <> "[]"') -> where('auto_url IS NOT NULL') -> where('auto_url <> ""');
        },'',true);
        $allList = collection($allList) -> toArray();
        // 获取符合条件的数据（分页）(含缓存)
        // use 可以将外部变量拷贝进入闭包函数内
        $list = fetchPool::all(function ($query) use ($page, $limit) {
            $query -> where('auto_rule <> "[]"') -> where('auto_url IS NOT NULL') -> where('auto_url <> ""') -> limit(($page - 1) * $limit, $limit)->order('id', 'asc');
        }, '', true);
        // 将返回的 list 对象转换为数组
        $list = collection($list)->toArray();

        // 返回数据
        return return_table($list,$allList);
    }
}
