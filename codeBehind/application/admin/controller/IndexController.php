<?php

namespace app\admin\controller;
/**
 * 后台首页控制器
 */
class IndexController extends \think\Controller
{
    // 后台首页页面渲染
    public function index()
    {
        $this -> prevent_illegal_login();
        $manage = session("manage");
        $assign['manage'] = $manage;
        return view('',$assign);
    }
    // 后台欢迎页面渲染
    public function welcome()
    {
    	$manage = session("manage");
    	// 需要传递给模型的数据
    	$data['manage'] = $manage -> toArray();
        return view('',$data);
    }
    // 防止非法登录
    private function prevent_illegal_login()
    {
        if (!session('?manage')) {
            $this -> error("请勿非法登录！",'/login.html');
            exit;
        }
    }
}
# code