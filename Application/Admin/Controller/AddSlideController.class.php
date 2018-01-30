<?php
namespace Admin\Controller;
use Think\Controller;
class AddSlideController extends Controller {
	public function index(){
		$this -> display();
	}


	public function getBanner(){
		$res = M("category");
		$category = $res -> select();
		echo json_encode($category);
	}

	public function getAdd(){
		$res = M("slide");
		$goods = $res -> create(I());
		$goods['addtime'] = time();
		$result = $res -> data($goods) -> add();
		if($result){
			$this -> success("商品添加成功！","/index");
		}else{
			$this -> error("商品添加失败！","/AddSlide/index");
		}
	}

	public function upload(){
	     if (!empty($_FILES)) {
	            //图片上传设置
	            $config = array(   
	                'maxSize'    =>    2145728, 
	                'rootPath'	 =>    'Public',
	                'savePath'   =>    '/Home/Images/slide/',  
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