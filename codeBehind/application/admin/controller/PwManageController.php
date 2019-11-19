<?php
namespace app\admin\controller;
use app\comm\model\manageModel as Manage;
use app\comm\model\manageLogModel as ManageLog;
/**
 * 密码管理控制器
 */
class PwManageController extends \app\comm\baseClass\BaseController
{
    public function index()
    {
        return view();
    }

    public function save()
    {
        // 接收前台 post 方式的传值
        $data = input('post.');

        // 数据验证
        $new_pw = $this->checkData($data);

        // 更新密码
        session("manage") -> pw = $new_pw;
        session('manage') -> save();

        // 记录操作日志
        ManageLog::log("修改管理员的登录密码成功",Manage::getLastsql());
        session("manage",null);
        exit_msg("修改成功",0);
    }
    // 验证提交数据
    private function checkData($data)
    {
        $manage = session("manage");
        $oldPw = $manage->pw;
        $oldPw1 = encr($manage->name . $data['oldPw']);

        // 进行简单验证
        $result = $this->validate($data, [
            'oldPw|原密码' => 'require',
            'pw|新密码' => 'require',
            'repass|重复密码' => 'require',
        ]);
        // 简单验证结果
        if (true !== $result) {
            // 验证失败 输出错误信息
            exit_msg($result);
        }
        // 判断新密码、重复密码是否相同
        if ($data['pw'] != $data['repass']) {
            exit_msg("新密码、重复密码不相同！");
        }
        // 判断原密码是否正确(前面是用户输入的，后面是数据库的正确密码)
        if ($oldPw1 != $oldPw) {
            exit_msg("原密码输入错误");
        }
        return encr($manage->name . $data['pw']);
    }
}
