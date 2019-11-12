<?php

namespace app\admin\controller;
/**
 * 后台首页控制器
 */
class IndexController extends \think\Controller
{
    function __construct()
    {
        $this -> prevent_illegal_login();
    }
    // 后台首页页面渲染
    public function index()
    {
        $manage = session("manage");
        $assign['manage'] = $manage;
        return view('',$assign);
    }
    // 后台欢迎页面渲染
    public function welcome()
    {
        return view();
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