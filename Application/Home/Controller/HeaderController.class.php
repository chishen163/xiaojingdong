<?php
	namespace Home\Controller;
	use Think\Controller;

	class HeaderController extends Controller {
		public function index() {

			 //判断用户登录状态
		       $user = $_SESSION['user'];
		       $this -> assign('user',$user);
		       
		       //随机导航
			$res = M("plate");
			$count = $res -> count();
			$nav = array();
			for($i=0;$i<7;$i++){
				$wheres['id'] = rand(1,$count);
				$nav[$i] = $res -> where($wheres) -> find();
			}
			$this -> assign("nav",$nav);

			// 左侧导航菜单
			$Article = D("plate");
			$class = D('category');
			$cate = $class -> select();
			$food = array();
			foreach ($cate as $key => $value){
				$where['cid'] = $cate[$key]['id'];
				$food[$key]['navName'] = $cate[$key]['name'];
				$food[$key]['id'] = $cate[$key]['id'];
				$food[$key]['menu'] = $Article -> where($where) -> select();
				$this -> assign("food",$food);
			}


		//新增，判断超全局数组$_SESSION['cart']中是否有购物车信息，如果有，需要分配一个标志变量去头部
       	 if (isset($_SESSION['cart'])) {
            $cart_info = $_SESSION['cart'];
            $num = 0;
            foreach($cart_info as $value) {
                $num += $value['num'];
            }

            // 读取session中商品的数量
            $gcount = count($_SESSION['cart']);
            if(empty($gcount)){
            	$this -> assign("gcount","0");
            }else{
            	$this -> assign("gcount",$gcount);
            }
            
        }

        $this -> assign('num', $num);
        $this -> assign('cart_info', $cart_info);
		}


		public function getWeb(){
			$res = M("website");
			$website = $res -> find();
			echo json_encode($website); 
		}

		// public function delGoods(){
		// 	$id = $_GET['delId'];
		// 	//删除session中的商品
		// 	unset($_SESSION['cart'][$id]);

		// 	//判断上面的商品是否删除成功
		// 	if(empty($_SESSION['cart'][$id])){
		// 		echo json_encode($id);
		// 	}else{
		// 		echo json_encode("0");
		// 	}
		// }
	}