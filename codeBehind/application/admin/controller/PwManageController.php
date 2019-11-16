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
    	$data=input('post.');
    	$manage = session("manage");
    	$admin_info=$manage->where(name,$manage)->find();
    	if($data){
    		if((md5($data['oldPw'])) == $admin_info['pw']){
    			if($data['pw'] == $data['repass']){
    				$md5_pw=md5($data['pw']);
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
