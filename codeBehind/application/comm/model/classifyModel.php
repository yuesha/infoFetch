<?php
namespace app\comm\model;

use think\Model;

/**
 * 分类信息数据表 模型
 */
class classifyModel extends Model
{
    public static function getList($page = 1, $limit = 10)
    {
        // 获取所有数据
        $allList = self::all(null, '', true);
        $allList = collection($allList)->toArray();

        // 获取符合条件的数据（分页）(含缓存)
        // use 可以将外部变量拷贝进入闭包函数内
        $list = self::all(function ($query) use ($page, $limit) {
            $query->limit(($page - 1) * $limit, $limit)->order('id', 'asc');
        }, '', true);
        $list = collection($list)->toArray();

        $data['code'] = 0;
        $data['msg'] = '正常回调';
        $data['count'] = count($allList);
        $data['data'] = $list;
        // halt($data);
        $dataJson = json($data);
        return $dataJson;
    }
}
