<?php
namespace app\comm\model;

use think\Model;

/**
 * 管理员用户日志数据表 模型
 */
class manageLogModel extends Model
{
    // 记录日志信息
    public static function log($detail,$sql="无")
    {
        $manage = session('manage');
        $data['manage_id'] = $manage -> id;
        $data['action'] = $detail;
        $data['ip'] = request() -> ip();
        $data['created_at'] = time();
        $data['sql'] = $sql;
        return self::create($data);
    }
}