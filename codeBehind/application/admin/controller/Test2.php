<?php
// 命名空间：表示这个文件所处的位置
namespace app\admin\controller;
//use 引入某个类
use think\Db;
use think\Controller;
class Test2 extends Controller
{
	public function test2()//传入两个参数
	{
		$data=DB::name('user_info')->where('id=1')->find();
		// dump($data);
		$this->assign('name',$data);
		return $this->fetch('test2');
		// return view();
		// echo "hello:".$name."".$age;
	}
	public function hello()
	{
		//定义一个数组,不能直接返回数组
		// $data=['name'=>'thinkphp','status'=>'1'];
		//转为json格式，调用json方法，把这个数组以json的形式返回
		// return json($data);
		//xml形式返回
		//return xml($data);
		//渲染模板方式返回 assign()方法，模板赋值
		$this->assign('name','渲染 模板');
		return $this->fetch('test2');

	}
	public function hello2(){
		//路径thinkphp/tpl/dispatch_jump.tpl
		//$this->success('正确的页面跳转','test2/test2');
		//重定向
		$this->redirect('http://www.tp-shop.cn');
	}
	public function hello3(){
		//$result=Db::name('user_info')->where('id',2)->find();
		// $result=Db::name('user_info')->where('id','between',[1,5])->find();
		// dump($result);
		//查询某个字段是否为空
		// $result=Db::name('user_info')
		// ->where('name','null')
		// ->select();
		// dump($result);
		//使用exp条件表达式，表示后面是原生的SQL语句表达式
		// $result=Db::name('user_info')->where('id','exp',">1 ")->select();
		// dump($result);
		//使用多个字段查询
		// $result=Db::name('user_info')
		// ->where('id','>=',1)
		// ->where('name','like','%舍予亭%')
		// ->select();
		// dump($result);
		//使用or和and混合条件查询
		// $result=Db::name('user_info')
		// ->where('name','like','zhangqian')
		// ->where('id',['in',[1,2,3]],['>=',1],'or')
		// ->limit(1)
		// ->select();
		// dump($result);


	}
	//出不来 
	public function hello4()
	{
		$result=Db::view('blog_info','id,title,cont')
		->view('user_info',['nickname'=>'user_name','user_pw','r_time'],'blog_info.user_id=user_info.id')
		->where('blog_info.user_id',1)
		->order('id desc')
		->select();
		dump($result);

	}
	public function hello5()
	{
		//获取某列
		// $name=Db::name('user_info')
		// ->where('id',5)
		// ->column('name');
		// dump($name);

		//获取id键名name位值的键值对
		// $list=Db::name('user_info')
		// ->where('id'>=1)
		// ->column('name','id');
		// dump($list);

		//获取id键名的数据集
		// $list=Db::name('user_info')
		// ->where('id'>=1)
		// ->column('*','id');
		// dump($list);

		//统计data表的数据
	// 	$count=Db::name('user_info')
	// 	->where('id'>=1)
	// 	->count();
	// 	echo $count;
	// }

		//出不来，抱错
		//统计data表中的最大id
		// $max=Db::name('user_info')
		// ->where('pw',123)
		// ->max('id');
		// echo $max;

		//查询最近两天添加的数据 whereTime


}
