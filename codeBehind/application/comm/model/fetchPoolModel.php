<?php
namespace app\comm\model;

use think\Model;

/**
 * 地址池信息数据表 模型
 */
class fetchPoolModel extends Model
{
    // 获取地址池列表
    public static function getList($page = 1, $limit = 10, $classify_id = 0)
    {
        $condition = $classify_id == 0 ? null : 'classify_id = '.$classify_id ;
        // 获取所有数据
        $allList = self::all($condition, '', true);
        $allList = collection($allList)->toArray();

        // 获取符合条件的数据（分页）(含缓存)
        // use 可以将外部变量拷贝进入闭包函数内
        $list = self::all(function ($query) use ($page, $limit, $condition) {
            $query-> where($condition) -> limit(($page - 1) * $limit, $limit)->order('id', 'asc');
        }, '', true);
        // 将返回的 list 对象转换为数组
        $list = collection($list)->toArray();

        // 返回数据
        return return_table($list,$allList,$classify_id);
    }
    // 转换时间戳
    public function getCreatedAtAttr($created_at)
    {
        return date("Y-m-d H:i:s",$created_at);
    }
    // 转换是否自动抓取标识位
    public function getIsAutoAttr($is_auto)
    {
        return $is_auto == 0?'否':'是';
    }
    // 转换抓取目录规则
    public function getAutoRuleAttr($auto_rule)
    {
        $auto_rule = json_decode($auto_rule);
        return $auto_rule;
    }
    // 转换默认抓取规则
    public function getDefaultRuleAttr($default_rule)
    {
        $default_rule = json_decode($default_rule);
        return $default_rule;
    }
}
