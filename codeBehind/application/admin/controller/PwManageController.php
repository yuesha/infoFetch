<?php
namespace app\admin\controller;

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
    	//接收表单的值
    	$data=input('post.');
    	$manage = session("manage");
    	//请求数据库
    	$admin_info=$manage->where(name,$manage)->find();
    	//如果接收到值
    	if($data){
    		//判断原密码和新密码是否一致
    		if((md5($data['oldPw'])) == $admin_info['pw']){
    			//判断新密码和重复密码是否一致
    			if($data['pw'] == $data['repass']){
    				$md5_pw=md5($data['pw']);
    				//更新数据库
    				$result=manage::where(name,$manage)->update(['pw'=>$md5_pw]);
    				if($result){
    					exit_msg("密码修改成功");
    				}
    			}else{
    				exit_msg("密码修改失败");
    			}
    		}else{
    			exit_msg("原密码输入错误");
    		}
    	}
    	return view();
    }
}
