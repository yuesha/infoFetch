<?php
namespace app\admin\controller;

use app\comm\model\fetchPoolModel as fetchPool;
use app\comm\model\classifyModel as Classify;
use app\comm\model\manageLogModel as ManageLog;

/**
 * 地址池管理控制器
 */
class AddrpoolManageController extends \app\comm\baseClass\BaseController
{
    // 地址池列表首页渲染
    public function index()
    {
        // 获取所有分类信息
        $data['classify'] = Classify::all(null, '', true);
        return view('',$data);
    }
    // 地址池添加渲染
    public function add()
    {
        $data['session'] = session('manage') -> toArray();
        $data['classify'] = Classify::all();
        return view('',$data);
    }
    // 地址池修改渲染
    public function edit($id)
    {
        // 检测目标地址池是否有效
        $fetchPool = fetchPool::get($id);
        if (!$fetchPool) {
            exit_msg("未知错误");
        }
        // 获取目标地址池信息
        $data['fetchPool']  = $fetchPool -> toArray();
        // 获取所有分类信息
        $data['classify']  = Classify::all(null, '', true);
        // 获取管理员信息
        $data['session']  = session('manage') -> toArray();
        return view('',$data);
    }
    // 获取地址池列表数据
    public function getList($page = 1, $limit = 10, $classify_id = 0)
    {
        $classify_id = (int)$classify_id;
        // 使用模型里的方法去获取数据
        return fetchPool::getList($page, $limit, $classify_id);
    }
    // 保存地址池信息
    public function save()
    {
        // 接收地址池信息
        $id = (int)input('post.id');
        $data = $this -> checkData();
        if ($id === 0) {
            // 添加时判断地址池是否存在
            $isset = fetchPool::getByName($data['name']);
            if ($isset) {
                exit_msg("此地址池已存在，请勿重复添加");
            }
            // 添加地址池信息
            $data['created_at'] = time();
            fetchPool::create($data);
            $sql = fetchPool::getLastsql();
            // 记录添加地址池日志
            ManageLog::log($data['name']." 地址池添加成功",$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg($data['name']." 地址池添加成功！",0);
        }else{
            // 修改时确定此地址池存在
            $fetchPool = fetchPool::get($id);
            if (!$fetchPool) {
                exit_msg("此地址池不存在");
            }
            $old_name = $fetchPool -> name;
            $fetchPool -> save($data,['id' => $id]);
            $sql = $fetchPool::getLastsql();
            ManageLog::log("修改 ".$old_name." 地址池信息成功",$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg("修改成功！",0);
        }
    }
    // 数据验证
    private function checkData()
    {
        $initData = input('post.');
        $data['name'] = trim_blank($initData['name']);
        $data['auto_url'] = trim_blank($initData['auto_url']);
        foreach ($initData['auto_rule'] as $k1 => $v1) {
            if (empty($v1)) {
                unset($initData['auto_rule'][$k1]);
            }
        }
        foreach ($initData['default_rule'] as $k2 => $v2) {
            if (empty($v2)) {
                unset($initData['default_rule'][$k2]);
            }
        }
        $data['auto_rule'] = json_encode($initData['auto_rule']);
        $data['default_rule'] = json_encode($initData['default_rule']);
        // 如果自动抓取标识位未选中，则转换为0
        $initData['is_auto'] = isset($initData['is_auto'])?$initData['is_auto']:0;
        $data['is_auto'] = (int)$initData['is_auto'];
        $data['classify_id'] = (int)$initData['classify_id'];
        // halt($data);
        return $data;
    }
    // 删除地址池信息
    public function del()
    {
        $id = (int)input('post.id');
        if ($id === 0) {
            exit_msg("未知错误");
        }
        $fetchPool = fetchPool::get($id);
        if ($fetchPool) {
            $fetchPool_name = $fetchPool -> name;
            $fetchPool -> delete();
            // 清除缓存
            \think\Cache::clear();
            $sql = $fetchPool::getLastsql();
            ManageLog::log("删除地址池 ".$fetchPool_name." 成功",$sql);
            exit_msg("删除成功",0);
        }else{
            exit_msg("此地址池不存在");
        }
    }
}
