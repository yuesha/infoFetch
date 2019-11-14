<?php

namespace app\admin\controller;
/**
 * 后台首页控制器
 */
class IndexController extends \app\comm\baseClass\BaseController
{
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
    	$manage = session("manage");
    	// 需要传递给模型的数据
    	$data['manage'] = $manage -> toArray();
        return view('',$data);
    }
}