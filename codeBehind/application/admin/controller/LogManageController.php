<?php
namespace app\admin\controller;
use think\Db;
/**
 * 日志管理控制器
 */
class LogManageController extends \app\comm\baseClass\BaseController
{
    public function index()
    {
        return view();

    }
    public function getlist()
    {
        $manage = session("manage");
        //请求数据库
        $loglist=DB::table('manage_log')->Order("id desc")->select();
        dump($loglist);
        //如果接收到值
        $this->assign("",$loglist);
   
    }
}
