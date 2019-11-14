<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    // 注册登录路由
    'login/'       => [
        // 目标地址
        'admin/login/index',
        // 路由参数
        [
            // 请求方式
            'method'    =>   'get',
            // 请求后缀
            'ext'       =>   'html',
        ],
    ],
    // 注册后台首页路由
    'adminIndex/'       => [
        // 目标地址
        'admin/index/index',
        // 路由参数
        [
            'method'    =>   'get',
            'ext'       =>   'html',
        ],
    ],
];
