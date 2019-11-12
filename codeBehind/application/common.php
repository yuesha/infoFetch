<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/*
 * 接口返回数据函数
*/
function exit_msg($msg = "调试信息",$code = 1){
    $data['msg'] = $msg;
    $data['code'] = $code;
    exit(json_encode($data));
}

/*
* 密码加密
*/
function encr($pw)
{
    return md5(md5($pw));
}