<?php
namespace app\admin\controller;

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
        return view();
    }
    // 地址池添加渲染
    public function add()
    {
        $data['session'] = session('manage') -> toArray();
        return view('',$data);
    }
    // 地址池修改渲染
    public function edit($id)
    {
        $classify = Classify::get($id);
        if (!$classify) {
            exit_msg("未知错误");
        }
        $data['classify']  = $classify -> toArray();
        $data['session']  = session('manage') -> toArray();
        return view('',$data);
    }
    // 获取地址池列表数据
    public function getList($page = 1, $limit = 10)
    {
        // 使用模型里的方法去获取数据
        return Classify::getList($page, $limit);
    }
    // 保存地址池信息
    public function save()
    {
        // 接收地址池信息
        $name = trim_blank(input('post.name'));
        $id = (int)input('post.id');
        if ($id === 0) {
            // 添加时判断地址池是否存在
            $isset = Classify::getByName($name);
            if ($isset) {
                exit_msg("此地址池已存在，请勿重复添加");
            }
            // 添加地址池信息
            $data['name'] = $name;
            $data['add_user'] = session("manage") -> name;
            $data['created_at'] = time();
            Classify::create($data);
            $sql = Classify::getLastsql();
            // 记录添加地址池日志
            ManageLog::log($name." 地址池添加成功",$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg($name." 地址池添加成功！",0);
        }else{
            // 修改时确定此地址池存在
            $classify = Classify::get($id);
            if (!$classify) {
                exit_msg("此地址池不存在");
            }
            $old_name = $classify -> name;
            $classify -> name = $name;
            $classify -> save();
            $sql = $classify::getLastsql();
            ManageLog::log("修改 ".$old_name." 地址池名称为： ".$name,$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg("修改成功！",0);
        }
    }
    // 删除地址池信息
    public function del()
    {
        $id = (int)input('post.id');
        if ($id === 0) {
            exit_msg("未知错误");
        }
        $classify = Classify::get($id);
        if ($classify) {
            $classify_name = $classify -> name;
            $classify -> delete();
            // 清除缓存
            \think\Cache::clear();
            $sql = $classify::getLastsql();
            ManageLog::log("删除地址池 ".$classify_name." 成功",$sql);
            exit_msg("删除成功",0);
        }else{
            exit_msg("此地址池不存在");
        }
    }
}
