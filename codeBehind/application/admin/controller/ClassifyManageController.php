<?php
namespace app\admin\controller;

use app\comm\model\classifyModel as Classify;
use app\comm\model\manageLogModel as ManageLog;

/**
 * 分类管理控制器
 */
class ClassifyManageController extends \app\comm\baseClass\BaseController
{
    // 分类列表首页渲染
    public function index()
    {
        return view();
    }
    // 分类添加渲染
    public function add()
    {
        $data['session'] = session('manage') -> toArray();
        return view('',$data);
    }
    // 分类修改渲染
    public function edit($id)
    {
        $classify = Classify::get($id);
        if (!$classify) {
            exit_msg("未知错误");
        }
        $data['classify']  = $classify -> toArray();
        // halt($data['classify']);
        return view('',$data);
    }
    // 获取分类列表数据
    public function getList($page = 1, $limit = 10)
    {
        // 使用模型里的方法去获取数据
        return Classify::getList($page, $limit);
    }
    // 保存分类信息
    public function save()
    {
        // 接收分类信息
        $name = trim_blank(input('post.name'));
        $id = (int)input('post.id');
        if ($id === 0) {
            // 添加时判断分类是否存在
            $isset = Classify::getByName($name);
            if ($isset) {
                exit_msg("此分类已存在，请勿重复添加");
            }
            // 添加分类信息
            $data['name'] = $name;
            $data['add_user'] = session("manage") -> name;
            $data['created_at'] = time();
            Classify::create($data);
            $sql = Classify::getLastsql();
            // 记录添加分类日志
            ManageLog::log($name." 分类添加成功",$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg($name." 分类添加成功！",0);
        }else{
            // 修改时确定此分类存在
            $classify = Classify::get($id);
            if (!$classify) {
                exit_msg("此分类不存在");
            }
            $old_name = $classify -> name;
            $classify -> name = $name;
            $classify -> save();
            $sql = $classify::getLastsql();
            ManageLog::log("修改 ".$old_name." 分类名称为： ".$name,$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg("修改成功！",0);
        }
    }
}
