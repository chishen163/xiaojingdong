<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {

	/*注册界面*/
	public function regedit() {		
		$this -> display();
	}

	/*验证要注册的用户名是否已经注册过*/
	public function checkName() {

		$name = trim($_POST['username']);
		$user = M('user');
		$res = $user -> field('username')
					   -> where("username = '{$name}'")
					   -> find();
		if($res) {
			echo "用户名已经注册过";
		} else {
			echo "用户名可用";
		}
	}

	/*判断注册的账户信息是否合法,然后确定是否允许注册,并插入数据库中*/
	public function reg() {
		$code = $_POST['code'];

		/*检验验证码是否正确*/
		$verify = new \Think\Verify();
		$ret = $verify -> check($code);
		if(!$ret) {
			//验证码不正确则退出,继续注册
			$this -> error("验证码错误");
		} else {		
			if($_POST['repwd'] == $_POST['passpwd']) {

				$_POST['username'] = trim($_POST['username']);
				$_POST['passpwd'] = md5($_POST['passpwd']);
				$_POST['regtime'] = time();

				/*实例化user用户表*/
				$user = M('user');

				/*创建数据对象,即把数据放入内存中*/
				if ($user -> create()) {
					$res = $user -> add();
					//echo $res;return;
					/*判断数据写入是否成功*/
					if ($res) {
						$result = $user -> where("id = {$res}") -> find();
						$_SESSION['user'] = $result;
						$this -> success("注册成功",U("Index/index"),0);
					} else {
						$this -> error("注册失败,请重新填写正确的信息","regedit",0);
					}
				}			
			} else {
				$this -> error("两次密码输入不一致");
			}
		}
	
	}

	/*登录界面*/
	public function login() {
		$this -> display();
	}

	/*判断登录账户操作*/
	public function log() {
		$username = trim($_POST['username']);
		$passpwd = md5(trim($_POST['passpwd']));		

		/*实例化user表*/
		$user = M('user');

		$res = $user -> where("username = '{$username}' AND passpwd = '{$passpwd}'")
					   -> find();		
		/*判断查询结果*/
		if ($res) {
			$_SESSION['user'] = $res;

			/*如果成功就跳转到首页*/						
			$this -> redirect("Index/index");
		} else {

			/*失败则返回登录页面,重新登录*/
			$this -> error("登录失败,请重新登录","login",1);
		}
	}

	/*验证码分配到模板*/
	public function code() {
		$Verify =     new \Think\Verify();
		$Verify -> fontSize = 25;
		$Verify -> length   = 4;
		$Verify -> useNoise = false;
		$Verify -> entry();
	}

}