<?php
namespace app\comm\model;

use think\Model;

/**
 * 分类信息数据表 模型
 */
class classifyModel extends Model
{
    // 获取分类列表
    public static function getList($page = 1, $limit = 10)
    {
        // 获取所有数据
        $allList = cache("Classify_allList");
        if (!$allList) {
            $allList = collection(self::all(null, '', false)) -> toArray();
            cache("Classify_allList",$allList,60*60*24);
        }

        // 获取符合条件的数据（分页）(含缓存)
        // use 可以将外部变量拷贝进入闭包函数内
        $list = cache("Classify_list_".$page."_".$limit);
        if (!$list) {
            $list = self::all(function ($query) use ($page, $limit) {
                $query->limit(($page - 1) * $limit, $limit)->order('id', 'asc');
            }, '', false);
            // 将返回的 list 对象转换为数组
            $list = collection($list)->toArray();
            cache("Classify_list_".$page."_".$limit,$list,60*60*24);
        }

        // 返回数据
        return return_table($list,$allList);
    }
    // 转换时间戳
    public function getCreatedAtAttr($created_at)
    {
        return date("Y-m-d H:i:s",$created_at);
    }
}
