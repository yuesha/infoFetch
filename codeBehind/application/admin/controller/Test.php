<?php
// 命名空间：表示这个文件所处的位置
namespace app\admin\controller;
//use 引入某个类
use think\Db;
// use think\controller;
/**
 * 
 */
class Test extends controller
{
	public function test2()
	{
		return "这是 admin 模块下 Test 控制器 test2 操作，即 访问方式为 /admin/test/test2";
		return view();
	}
	public function test3()
	{
		return "这是 admin 模块下 Test 控制器 test3 操作，即 访问方式为 /admin/test/test3";
		$res = Db::table("user_info") -> where("id=2") -> find();
		$res2 = Db::table("user_info") -> where("id=2") -> select();
		dump($res);
		dump($res2);
		 // $res3 = Db::table("user_info") -> where("id=2") -> findOrFail();
		 // dump($res3);
		// Db::query('select * from user_info where id=?',[1]);
		// Db::execute('insert info user_info(id,name) values(?,?)',[1,'thinkphp']);
	}

}