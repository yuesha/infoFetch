<?php

namespace app\comm\baseClass;

/**
 * 后台控制器 基类
 */
class BaseController extends \think\Controller
{
    // 继承时自动执行
    function __construct()
    {
        $this -> prevent_illegal_login();
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