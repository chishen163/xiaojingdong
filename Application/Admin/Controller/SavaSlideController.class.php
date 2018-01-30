<?php
namespace Admin\Controller;
use Think\Controller;
class SavaSlideController extends Controller {
	public function index(){
		$this -> display();
	}

	public function category(){
		$res = M("category");
		$category = $res -> select();
		echo json_encode($category);
	}

	public function cateInfo(){
		$res = M("slide");
		$where['id'] = I("id");
		$slide = $res -> where($where) -> find();
		echo json_encode($slide);
	}

	public function getUpdate(){
		$res = M("slide");
		$where['id'] = I("id");
		if($res -> create()){
			$goods = $res -> where($where) -> save();
			if($goods){
				$this -> success("广告修改成功！","/Slide/index");
			}else{
				$this -> error("你没有修改广告信息","/Slide/index");
			}
		}
	}
}