<?php
namespace Admin\Controller;
use Think\Controller;
class WebSetController extends Controller {

	//网站配置首页
	public function index() {
		$webset = M("website");
		$res = $webset ->order('id') -> select();
		
		foreach ($res as $key => $value) {
			switch ($res[$key]['status']) {
				case 1:
					$res[$key]['status'] = '是';
					break;
				case 0:
					$res[$key]['status'] = '否';
					break;
			}
		}
		
		$this -> assign("setup",$res);
		$this -> display();
	}

	//添加网站配置
	public function addWebSet() {
		$this -> display();
	}

	//添加网站配置操作
	public function addset() {
		$webset = M('website');
		//添加logo图标
		if (!empty($_FILES['logo'])) {
			$config = array(
				'maxSize' => 10000000,
				'exts' => array('png','jpg','jpeg','gif'),
				'rootPath' => './',
				'savePath' => 'Public/Common/Uploads/Photos/',
				'autoSub' => false,
				);
			$upload = new \Think\Upload($config);
			$info = $upload -> upload();
			if ($info) {
				foreach ($info as $file) {
					$_POST['logo'] = $file['savename'];
				}
			}

		}

		//写入数据到数据库中
		if ($webset -> create()) {
			$res = $webset -> add();
			if ($res) {
				$this -> success("配置添加成功",U("WebSet/index"),0);
			} else {
				$this -> error("配置添加失败");
			}
		}

	}

	//修改网站配置
	public function updWebSet() {
		$id = $_GET['id'];
		$webset = M('website');
		$res = $webset -> where("id = {$id}") -> find();
		if ($res) {
			$this -> assign("setup",$res);
		}
		$this -> display();
	}

	//修改网站配置操作
	public function upd() {
		$id = $_GET['id'];
		$webset = M("website");
		//修改logo操作
		if (!empty($_FILES['logo'])) {
			$config = array(
				'maxSize' => 10000000,
				'exts' => array('png','jpg','jpeg','gif'),
				'rootPath' => './',
				'savePath' => 'Public/Common/Uploads/Photos/',
				'autoSub' => false,
				);
			$upload = new \Think\Upload($config);
			$info = $upload -> upload();
			if ($info) {
				foreach ($info as $file) {
					$_POST['logo'] = $file['savename'];
				}
			}
		}
		//写入数据到数据库
		if ($webset -> create()) {
			$result = $webset -> where("id = {$id}") -> save();
			if ($result) {
				$this -> success("修改配置成功",U("WebSet/index"),0);
			} else {
				$this -> error("修改配置失败");
			}
		}
	}

	//删除网站配置
	public function delWebSet() {
		$id = $_GET['id'];
		$webset = M("website");
		$res = $webset -> where("id = {$id}") -> delete();
		if ($res) {
			$this -> success("删除成功",U("WebSet/index"),0);
		} else {
			$this -> error("删除失败");
		}
	}

}