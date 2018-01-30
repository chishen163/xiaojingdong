<?php
namespace Admin\Controller;
use Think\Controller;
class SavaGoodsController extends Controller {
	public function index(){
		$res = M("category");
		$category = $res -> select();
		$this -> assign("category",$category);

		$this -> display();
	}

	public function getInfo(){
		$res = M("goods");
		$where['id'] = I('id');
		if(empty($where['id'])){
			$where['id'] = 1;
		}

		$goods = $res -> where($where) -> find();
		if(empty($goods)){
			echo json_encode(0);
		}else{
			echo json_encode($goods);
		}
	}


	public function Plate(){
		$res = M("plate");
		$where['cid'] = I('id');
		$goods = $res -> where($where) -> select();
		echo json_encode($goods);
	}


	public function getPlate(){
		$res = M("goods");
		$where['id'] = I("id");
		$goods = $res -> field("pid") -> where($where) -> find();

		$result = M("plate");
		$wherep['cid'] = $goods['pid'];
		$plate = $result -> where($wherep) -> select();
		echo json_encode($plate);
	}


	public function getUpdate(){
		$res = M("goods");
		$where['id'] = I("id");
		if($res -> create()){
			$goods = $res -> where($where) -> save();
			if($goods){
				$this -> success("商品修改成功！","/Goods/index");
			}else{
				$this -> error("你没有修改商品信息","/AddGoods/index");
			}
		}
	}
}