<?php
namespace app\admin\controller;

use app\comm\model\fetchPoolModel as fetchPool;
use app\comm\model\fetchUrlModel as fetchUrl;
use app\comm\model\classifyModel as Classify;
use app\comm\model\manageLogModel as ManageLog;
use QL\QueryList;

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

    // 从目录抓取地址信息
    public function catch()
    {
        $redis = new \redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('121213');
        // 获取地址池id
        $id = (int)input('post.id');
        $fetchPoolRow = $this -> checkPool($id);

        $url = parse_url($fetchPoolRow -> auto_url);
        echo $url['host'];exit;
        $rule = "#list dl dd a";
        $rules = [
            // 采集章节名称
            'title' => ['#list dl dd a','text'],
            // 采集章节地址
            'href' => ['#list dl dd a','href'],
        ];
        $data = QueryList::get($url)->rules($rules)->query()->getData();
        $data = $data -> all();

        // 清除此地址池当中的所有地址
        fetchUrl::where(['fetch_pool_id' => $id]) -> delete();
        $insData['fetch_pool_id'] = $id;
        $insData['is_fetch'] = 1;
        $insData['rule'] = '';
        $insData['add_user'] = session('manage') -> name;
        foreach ($data as $urlRow) {
            $insData['title'] = $urlRow['title'];
            $insData['url'] = $urlRow['href'];
            $insData['created_at'] = time();
            fetchUrl::create($insData);
            // $redis->lpush("demo1", $insData['title']);
        }
        exit_msg("抓取成功",0);
    }

    // 检查地址池信息
    private function checkPool(int $id = 0)
    {
        if (!$id) {
            exit_msg("地址池信息错误！",1);
        }
        $fetchPoolRow = fetchPool::get($id);
        if ($fetchPoolRow == NULL) {
            exit_msg("地址池信息错误！",2);
        }
        if ($fetchPoolRow -> auto_rule == []) {
            exit_msg("地址池不存在自动抓取规则！",3);
        }
        return $fetchPoolRow;
    }
}
