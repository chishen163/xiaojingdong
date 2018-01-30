<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

	public function index(){

		//显示后台默认首页index.php
		if (empty($_SESSION['user'])) {
			
                $this -> redirect("Index/login");
				
		} else if($_SESSION['user']['gid'] == 1 || $_SESSION['user']['gid'] ==3 || $_SESSION['user']['gid'] == 6 || $_SESSION['user']['gid'] == 8) {
			$this -> assign('user',$_SESSION['user']);
			$this -> display();
		} else {
                $this -> redirect("Index/login");
            }
		
    }

    //后台登录界面
    public function login() {
		
    		$this -> display();
    }

    //验证登录用户提交的信息
    public function log() {
    		
      	$user = M('user');
      	$name = $_POST['username'];
      	$pwd = md5($_POST['passpwd']);
      	//查询用户
      	$res = $user -> where("username = '{$name}' AND passpwd = '{$pwd}'") -> find();
      	//判断用户是否存在
      	if ($res) {
                  //实例化用户组
      		$group = M("group");
      		//查询用户组,判断用户是否有权限登录后台
      		$result = $group -> where("id = {$res['gid']}") -> find();
      		if ($result) {
      			$_SESSION['user'] = $res;
      			//如果成功,则跳转到首页
      			$this -> redirect("Index/index");
      		} else {
      			//如果用户无权,则退出登录
      			$this -> error("你想越权登录后台吗,我去...");
      		}
      	} else {
      		$this -> error("账号或密码不正确");
      	}
    }

    // 退出后台登录
    public function loginout() {
    		//设置SESSION值为空
    		$_SESSION['user'] = null;
    		$this -> redirect("Index/login");
    }

}
