<?php

namespace app\admin\controller;
use app\comm\model\manageModel as Manage;
use app\comm\model\manageLogModel as ManageLog;
/**
 * 登陆控制器
 */
class LoginController extends \think\Controller
{
    // 登录页面渲染
    public function index()
    {
        return view();
    }

    // 登录数据验证
    public function action()
    {
        // 输入数据
        $data['username'] = input('post.username');
        $data['password'] = input('post.password');

        // 验证数据,如果成功则获取管理员信息
        $manage = $this -> checkData($data);

        // 写入 session
        session('manage',$manage);

        // 记录登录日志
        ManageLog::log("登录成功");

        exit_msg("登录成功",0);
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
        // 根据用户名查询是否存在此用户
        $manage = Manage::getByName($data['username']);
        if (!$manage) {
            exit_msg("此用户不存在");
        }
        // 给密码加密（方式：用户名+密码进行md5加密）
        $encrPw = encr($data['username'].$data['password']);
        // 密码错误则弹出
        if ($encrPw != $manage -> pw) {
            exit_msg("密码错误");
        }
        return $manage;
    }

    // 登出操作
    public function loginout()
    {
        ManageLog::log("登出成功");
        session(null);
        exit_msg("登出成功",0);
    }
}