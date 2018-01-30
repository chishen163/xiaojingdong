<?php
namespace Admin\Controller;
use Think\Controller;
class AddGoodsController extends Controller {
	public function index(){
		$res = M("category");
		$category = $res -> select();
		$this -> assign("category",$category);
		$this -> display();
	}

	public function getPlate(){
		$res = M("plate");
		$where['cid'] = I('id');
		$goods = $res -> where($where) -> select();
		echo json_encode($goods);
		//这里也是github实验提交
	}

	public function getAdd(){
		$res = M("goods");
		$goods = $res -> create(I());
		$goods['addtime'] = time();
		$result = $res -> data($goods) -> add();
		if($result){
			$this -> success("商品添加成功！","/Goods/index");
		}else{
			$this -> error("商品添加失败！","/AddGoods/index");
		}
	}

	 public function upload(){
	     if (!empty($_FILES)) {
	            //图片上传设置
	            $config = array(   
	                'maxSize'    =>    2145728, 
	                'rootPath'	 =>    'Public',
	                'savePath'   =>    '/Home/Images/goods/',  
	                'saveName'   =>    array('uniqid',''), 
	                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),  
	                'autoSub'    =>    false,   
	                'subName'    =>    array('date','Ymd'),
	            );
	            $upload = new \Think\Upload($config);// 实例化上传类
	            $images = $upload->upload();
	            //判断是否有图
	            if($images){
	                $info=$images['Filedata']['savename'];
	                //返回文件地址和名给JS作回调用
	                echo $info;
	            }
	            else{
	                $this->error($upload->getError());//获取失败信息
	            }
	        }
   		 }
}