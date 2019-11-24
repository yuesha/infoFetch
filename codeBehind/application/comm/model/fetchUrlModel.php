<?php
namespace app\comm\model;

use think\Model;

/**
 * 地址信息数据表 模型
 */
class fetchUrlModel extends Model
{
    // 获取地址列表
    public static function getList($page = 1, $limit = 10, $addrpool_id = 0)
    {
        $condition = $addrpool_id == 0 ? null : 'fetch_pool_id = ' . $addrpool_id;
        // 获取所有数据
        $allList = self::all($condition, '', true);
        $allList = collection($allList)->toArray();

        // 获取符合条件的数据（分页）(含缓存)
        // use 可以将外部变量拷贝进入闭包函数内
        $list = self::all(function ($query) use ($page, $limit, $condition) {
            $query->where($condition)->limit(($page - 1) * $limit, $limit)->order('id', 'asc');
        }, '', true);
        // 将返回的 list 对象转换为数组
        $list = collection($list)->toArray();

        // 返回数据
        return return_table($list, $allList, $addrpool_id);
    }
    // 转换时间戳
    public function getCreatedAtAttr($created_at)
    {
        return date("Y-m-d H:i:s", $created_at);
    }
}
