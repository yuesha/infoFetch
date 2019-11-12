<?php

namespace app\admin\controller;
use app\comm\model\manageModel as Manage;
/**
 * 登陆控制器
 */
class LoginController extends \think\Controller
{
    // 登录页面渲染
    public function index()
    {
        // halt(url('action'));
        return view();
    }
    // 登录数据验证
    public function action()
    {
        // 输入数据
        $data = [
            'username'  => input('post.username'),
            'password' => input('post.password')
        ];
        $this -> checkData($data);

        exit_msg();
    }
    // 验证登录数据
    private function checkData($data)
    {
        // 进行简单验证
        $result = $this->validate($data, [
            'username|用户名'  => 'require',
            'password|密码'   => 'require|min:6|max:12',
        ]);
        // 简单验证结果
        if(true !== $result){
            // 验证失败 输出错误信息
            exit_msg($result);
        }
        $manage = Manage::getByName($data['username']);
        if (!$manage) {
            exit_msg("此用户不存在");
        }
        $encrPw = encr($data['username'].$data['password']);
        // exit_msg($encrPw);
        if ($encrPw != $manage -> pw) {
            exit_msg("密码错误");
        }
        exit_msg("登录成功",0);
    }
}