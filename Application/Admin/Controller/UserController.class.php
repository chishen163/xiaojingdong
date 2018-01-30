<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {

	//会员管理列表
	public function index() {
		$gid = $_SESSION['user']['gid'];
		if ($gid == 3 || $gid == 8) {
			
			
			//实例化user对象
			$users = M('user');
			//查询所有数据的总记录条数
			$count = $users -> count();
			//实例化分页类,传入总记录条数和每页显示条数(10)
			$Page = new \Think\Page_ajax($count,10);
			//分页显示输出
			$show = $Page -> show();
			//进行分页数据查询,用limit方法要使用Page类的属性
			$user = $users ->order('id') -> limit($Page -> firstRow.','.$Page -> listRows) -> select();
			foreach ($user as $key => $value) {
				$user[$key]['regtime'] = date("Y-m-d",$user[$key]['regtime']);
				if (!$user[$key]['photoname']) {
					$user[$key]['photoname'] = "default_photo.jpg";
				}
			}

			//赋值查询的数据集
			$this -> assign('user',$user);
			//赋值分页输出
			$this -> assign('page',$show);
			//输出模板
			$this -> display();
		} else {
			$this -> error("你无权查看此页面...");
		}

	}

	//添加用户界面
	public function adduser() {
		//判断查看与修改此页面的用户权限
		// $gid = $_SESSION['user']['gid'];
		// if ($gid != '3' || $gid != '8') {
		// 	$this -> error("你无权查看此页面...");
		// }
		
		$groups = M("group");
		$res = $groups -> select();
		$this -> assign("groups",$res);
		$this -> display();

	}

	//添加用户插入操作
	public function insert() {

		//实例化user表
		$user = M("user");
		$_POST['regtime'] = time();
		$_POST['passpwd'] = md5(trim($_POST['passpwd']));

		//根据提交的POST创建数据对象
		if ($user -> create()) {

			//写入数据库
			$res = $user -> add();
			if ($res) {
				$this -> success("添加成功",U('User/index'),0);
			} else {
				$this -> error("添加失败");
			}
		}

	}

	//检索用户名是事可用
	public function checkName() {
		//获取发送的数据username,并把它赋值给变量$name
		$name = trim($_POST['username']);
		//实例化user表
		$user = M('user');
		//按请求的数据进行条件查询
		$res = $user -> where("username = '{$name}'")
					   ->find();

		//判断用户名是否可用
		if ($res) {
			echo "用户名已经注册过";
		} else {
			echo "用户名可用";
		}

	}

	//用户信息修改界面
	public function mod() {
		//获得要修改的用户的id,并赋值给变量$id
		$id = $_GET['id'];
		$users = M('user');
		//查询所要修改的用户的信息
		$user = $users -> where("id = {$id}") -> find();
		if (!$user['photoname']) {
			$user['photoname'] = "default_photo.jpg";
		}
		$birth = explode('-',$user['birthday']);
		$user['year'] = $birth[0];
		$user['month'] = $birth[1];
		$user['day'] = $birth[2];
		//实例化group表
		$groups = M("group");
		$gps = $groups -> select();
		//赋值查询的数据集
		$this -> assign("gid",$gid);
		$this -> assign("groups",$gps);
		$this -> assign('user',$user);
		$this -> display();
	}

	//修改用户操作
	public function upduser() {
		//获得要修改的用户的id,并赋值给变量$id
		$id = $_GET['id'];
		//实例化user表
		$user = M('user');
		//用md5给密码加密
		if (!empty($_POST['passpwd'])) {
			$_POST['passpwd'] = md5(trim($_POST['passpwd']));
		} else {
			unset($_POST['passpwd']);
		}
		$_POST['birthday'] = I('post.year').'-'.I('post.month').'-'.I('post.day');		

		//判断是否上传了头像
		if (!empty($_FILES['photo'])) {

			/*实例化上传类*/
			$upload = new \Think\Upload();

			/*设置上传文件大小*/
			$upload -> maxSize = 31457280;

			/*设置上传文件的后缀名*/
			$upload -> exts = array('jpg','jpeg','gif','png');

			/*设置上传文件保存的根目录*/
			$upload -> rootPath = './';

			/*设置上传文件的保存路径*/
			$upload -> savePath = 'Public/Common/Uploads/Headpic/';

			// 把autoSub设为false,表示禁止自动使用子目录保存上传文件(默认是true)
			$upload -> autoSub = false;

			/*执行upload()方法上传文件,如果上传失败,则返回false,如果成功,则返回一个包含上传文件信息的数组*/
			$info = $upload -> upload();

			if ($info) {
				/*上传文件成功,获取上传文件信息*/				
				foreach($info as $file) {
					$_POST['photoname'] = $file['savename'];
				}			
			}
		}

		//判断根据提交的POST数据创建数据对象是否成功
		if ($user -> create()) {
			//创建数据成功就更新写入数据库
			$res = $user -> where("id = {$id}") -> save();
			if ($res) {
				$this -> success("修改成功",U("User/index"),0);
			} else {
				$this -> error("修改失败");
			}
		}
	}	

	//删除用户操作
	public function del() {
		//获得要执行删除操作的用户的id,并赋值给变量$id
		$id = $_GET['id'];
		$user = M('user');
		//执行删除
		$res = $user -> where("id = {$id}") -> delete();

		if ($res) {
			$this -> success("删除成功");
		} else {
			$this -> error("删除失败");
		}
	}

	//批量删除用户
	public function delusers() {
		$ids = $_POST['sel'];
		$idr = join(',',$ids);
		$user = M("user");
		$res = $user -> where("id in($idr)") ->delete();

		if ($res) {
			$this -> success("批量删除成功");
		} else {
			$this -> error("删除失败");
		}
	}

	//搜索用户页
	public function searchuser(){
		//搜索关键字
		$keywords = trim($_POST['keywords']);
		//实例化user对象
		$users = M('user');
		//查询所有匹配结果的记录条数
		$count = $users -> where("username like '%{$keywords}%'") -> count();
		//实例化分页类,传入总记录条数和每页显示条数(10)
		$Page = new \Think\Page_ajax($count,10);
		//分页显示输出
		$show = $Page -> show();
		//进行分页数据查询,用limit方法要使用Page类的属性
		$user = $users -> order('id') -> where("username like '%{$keywords}%'") -> limit($Page -> firstRow.','.$Page -> listRows) -> select();
		foreach ($user as $key => $value) {
			$user[$key]['regtime'] = date("Y-m-d",$user[$key]['regtime']);
		}
		//赋值查询的数据集
		$this -> assign('user',$user);
		//赋值分页输出
		$this -> assign('page',$show);
		//输出模板
		$this -> display();
	}
	
}