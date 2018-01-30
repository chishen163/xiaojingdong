<?php
namespace Admin\Controller;
use Think\Controller;
class GroupController extends Controller {

	//用户组列表页面
	public function index() {
		// $gid = $_SESSION['user']['gid'];
		// if ($gid != '3' || $gid != '8') {
		// 	$this -> error("你无权查看此页面...");
		// }
		$gps = M('group');
		$count = $gps -> count();
		//实例化分页类
		$page = new \Think\Page_ajax($count,7);
		$show = $page -> show();
		$groups = $gps -> limit($page -> firstRow.','.$page -> listRows) -> select();
		$this -> assign('groups',$groups);
		$this -> assign("page",$show);
		$this -> display();
	}

	//添加用户组操作
	public function insertGroup() {
		$name = trim($_POST['groupname']);
		$groups = M('group');
		//判断组名是否已经添加过
		$res = $groups -> where("groupname = '{$name}'") -> select();
		if (!$res) {
			$_POST['name'] = $name;
			if ($groups -> create()) {
				//添加数据到库中
				$result = $groups -> add();
				if ($result) {
					$this -> success("添加成功",U("Group/index"),0);
				}
			}
		} else {
			$this -> error("添加失败");
		}

	}

	//修改用户组界面
	public function mod() {
		$id = $_GET['id'];
		$groups = M('group');
		$res = $groups -> where("id = {$id}") -> find();

		if ($res) {
			$this -> assign('groups',$res);
		}
		$this -> display();
	}

	//修改用户组操作
	public function updgroup() {
		$id = $_GET['id'];
		$groups = M('group');
		//用户权限修改操作
		if ($_POST['useradmin'] != 1) {
			$_POST['useradmin'] = 0;
		}

		if ($_POST['commentadmin'] != 1) {
			$_POST['commentadmin'] = 0;
		}

		if ($_POST['webadmin'] != 1) {
			$_POST['webadmin'] = 0;
		}

		if ($_POST['sendmessage'] != 1) {
			$_POST['sendmessage'] = 0;
		}

		if ($_POST['sendarticle'] != 1) {
			$_POST['sendarticle'] = 0;
		}

		if ($_POST['articleadmin'] != 1) {
			$_POST['articleadmin'] = 0;
		}

		if ($groups -> create()) {
			$res = $groups ->where("id = {$id}") -> save();
			if ($res) {
				$this -> success("修改成功",U("Group/index"),0);
			} else {
				$this -> error('修改失败');
			}
		}

	}

	//删除用户组操作
	public function del() {
		$id = $_GET['id'];
		$groups = M('group');
		$res = $groups -> where("id = {$id}") -> delete();

		if ($res) {
			$this -> success("删除成功",U('Group/index'),0);
		} else {
			$this -> error('删除失败');
		}
	}

	//用户组查询
	public function searchGroup() {
		//搜索关键字
		$keywords = $_POST["keywords"];
		$gps = M('group');
		$count = $gps -> where("groupname like '%{$keywords}%'") -> count();
		//实例化分页类
		$page = new \Think\Page_ajax($count,7);
		$show = $page -> show();
		$groups = $gps -> where("groupname like '%{$keywords}%'") -> limit($page -> firstRow.','.$page -> listRows) -> select();
		
		$this -> assign('groups',$groups);
		$this -> assign("page",$show);
		$this -> display();
	}

} 