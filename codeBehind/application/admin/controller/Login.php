<?php
namespace app\admin\controller;
use think\View;
use think\Controller;
use app\model\user;
class login extends Controller{
  public function index(){
   $view = new View();
    return $view->fetch('index');
  }

  public function login($user_name='',$user_passwd=''){
//      var_dump($user_name);die();
   $user = User::get([
      'user_name' => $user_name,
      'user_passwd' => $user_passwd
      ]);
   if($user){
      echo '登录成功';
   }else{
        return $this->error('登录失败','index');
   }
  }
}