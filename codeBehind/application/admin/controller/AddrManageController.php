<?php
namespace app\admin\controller;

use app\comm\model\fetchPoolModel as fetchPool;
use app\comm\model\fetchUrlModel as fetchUrl;
use app\comm\model\manageLogModel as ManageLog;

/**
 * 地址管理控制器
 */
class AddrManageController extends \app\comm\baseClass\BaseController
{
    // 地址列表首页渲染
    public function index()
    {
        $data['addrpool'] = fetchPool::all(null,'',true);
        return view('',$data);
    }
    // 数据验证
    private function checkData()
    {
        $initData = input('post.');
        $data['fetch_pool_id'] = (int)$initData['fetch_pool_id'];
        $data['title'] = trim_blank($initData['title']);
        $data['url'] = trim_blank($initData['url']);
        foreach ($initData['rule'] as $k1 => $v1) {
            if (empty($v1)) {
                unset($initData['rule'][$k1]);
            }
        }
        $data['rule'] = json_encode($initData['rule']);
        return $data;
    }
    // 地址添加渲染
    public function add()
    {
        $data['session'] = session('manage') -> toArray();
        $data['addrpool'] = fetchPool::all(null,'',true);
        return view('',$data);
    }
    // 地址修改渲染
    public function edit($id)
    {
        $fetchUrl = fetchUrl::get($id);
        if (!$fetchUrl) {
            exit_msg("未知错误");
        }
        $data['fetchUrl']  = $fetchUrl -> toArray();
        $data['fetchPool']  = fetchPool::all(null,'',true);
        $data['session']  = session('manage') -> toArray();
        // halt($data['fetchUrl']);
        return view('',$data);
    }
    // 获取地址列表数据
    public function getList($page = 1, $limit = 10,$addrpool_id = 0)
    {
        // 使用模型里的方法去获取数据
        return fetchUrl::getList($page, $limit, $addrpool_id);
    }
    // 保存地址信息
    public function save()
    {
        // 接收地址信息
        $data = $this -> checkData();
        $id = (int)input('post.id');
        if ($id === 0) {
            // 添加时判断地址是否存在
            $isset = fetchUrl::getByTitle($data['title']);
            if ($isset) {
                exit_msg("此地址已存在，请勿重复添加");
            }
            // 添加地址信息
            $data['is_fetch'] = 0;
            $data['add_user'] = session("manage") -> name;
            $data['created_at'] = time();
            fetchUrl::create($data);
            $sql = fetchUrl::getLastsql();
            // 记录添加地址日志
            ManageLog::log($data['title']." 地址添加成功",$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg($data['title']." 地址添加成功！",0);
        }else{
            // 修改时确定此地址存在
            $fetchUrl = fetchUrl::get($id);
            if (!$fetchUrl) {
                exit_msg("此地址不存在");
            }
            $old_title = $fetchUrl -> title;
            $fetchUrl -> allowField(true)-> update($data,['id' => $id]);
            // $demo = new fetchUrl();
            // $demo -> where('id',$id) -> update($data);
            // $fetchUrl ->isUpdate(true) -> save($data);
            $sql = $fetchUrl::getLastsql();
            ManageLog::log("修改 ".$old_title." 地址 成功",$sql);
            // 清除缓存
            \think\Cache::clear();
            exit_msg("修改成功！",0);
        }
    }
    // 删除地址信息
    public function del()
    {
        $id = (int)input('post.id');
        if ($id === 0) {
            exit_msg("未知错误");
        }
        $fetchUrl = fetchUrl::get($id);
        if ($fetchUrl) {
            $fetchUrl_name = $fetchUrl -> name;
            $fetchUrl -> delete();
            // 清除缓存
            \think\Cache::clear();
            $sql = $fetchUrl::getLastsql();
            ManageLog::log("删除地址 ".$fetchUrl_name." 成功",$sql);
            exit_msg("删除成功",0);
        }else{
            exit_msg("此地址不存在");
        }
    }
}