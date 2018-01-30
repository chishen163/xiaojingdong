<?php
namespace Admin\Controller;
use Think\Controller;
//广告设置控制器
class BannerController extends Controller {
	public function index(){
		$res = M("slide");
		$list = $res -> select();
		$this -> assign("list",$list);
		$this -> display();
    }
}
