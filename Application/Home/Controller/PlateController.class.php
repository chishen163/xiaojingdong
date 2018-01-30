<?php
namespace Home\Controller;
use Think\Controller;
class PlateController extends Controller {

	public function index(){
		//跨模块调用
		R("Header/index");

		// 查询板块菜单
		$plate = M("plate");
		$sql['cid'] = I("id");
		$plate = $plate ->where($sql) -> select();
		$this -> assign("plate",$plate);

		//查询板块名
		$category = M("category");
		$id['id'] = $_GET['id'];
		$logos = $category -> where($id) -> find();
		$this -> assign("logo",$logos);

		$slide = M("slide");
		$where['cid'] = $_GET['id'];
		$slide = $slide -> where($where) -> order("cid asc") -> select();
		$this -> assign("slide",$slide);

		// 查询商品
		$goods = M("goods");
		$whereg['pid'] = I("id");
		$goods = $goods -> where($whereg) -> select();
		if(empty($goods)){
			$this -> assign("goods","null");
		}else{
			$this -> assign("goods",$goods);
		}

		$this -> display();
	}

	public function getSlide(){
		$res = M("slide");
		$where['id'] = I('id');
		$slide = $res -> where($where) -> select();
		echo json_encode($slide);
	}

	public function showSlide(){
		$res = M("slide");
		$where['cid'] = I("cid");
		$slide = $res -> where($where) -> select();
		echo json_encode($slide);
	}

	 // 查询商品详细信息
    public function getGoods(){
    		$res = M("goods");
    		$where['id'] = I("id");
    		$data = $res -> where($where) -> find();
    		echo json_encode($data);
    }
}