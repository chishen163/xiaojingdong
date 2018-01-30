<?php
	namespace Home\Controller;
	use Think\Controller;

	class CartController extends Controller {

		//动态输出该用户购物车中的商品，该方法还承载了用户个人中心发送的订单修改请求任务
		public function cart() {

			//获取该登录用户的id 号，作为购物车中的用户id字段查询该用户购物车中的所有商品，同时该值是用来判断用户是否登录用的
			$userid = $_SESSION['user']['id'];

			//需要判断该方法的请求来源，如果是从订单提交成功，需要修改，则会在浏览器收到一个orderid字段，该字段存取已经提交成功的订单号
			if (isset($_GET['orderid'])) {
				$orderid = $_GET['orderid'];
				$userid = $_SESSION['user']['id'];
				$order = M('order');
				$order_data = $order -> where("id = '{$orderid}'") -> field("ordersn, userid") -> find();

				//通过订单号遍历订单 商品表中的所有商品，是一个二维数组
				$order_goods = M('order_goods');
				$order_goods_data = $order_goods -> where("ordersn = '{$order_data['ordersn']}'") -> select();

				//自定义一个状态值表示本操作时修改订单操作，并将其写入$_SESSION中用来跟踪该条订单的传递信息
				$change = 1;
				$_SESSION['item']['change'] = 1;

				//使用一致的方式，需要将这些商品按件的方式存入$_SESSION['cart']中
				foreach($order_goods_data as $value) {
					$_SESSION['cart'][$value['id']] = $value;
					$_SESSION['cart'][$value['id']]['goodsname'] = $value['name'];
					$data = $_SESSION['cart'];
				}
			} else {
				//读取客户端存储的所有SESSION['cart']信息，将其分配到前台购物车模板上去
				$data = $_SESSION['cart'];

				//如果是正常流入，则需要进行值的转化，将商品id值统一修改为goodsid字段
				foreach($data as $key => $value) {
					$data[$key]['goodsid'] = $value['id'];
				}
			}

			//检测用户是否登录，如果登录，则将变量名传递到前台去
			if (isset($_SESSION['user']['id'])) {
				$user_info = $_SESSION['user'];
				$this -> assign('user_info', $user_info);
			}

			//加载商品促销信息
			$goods = M('goods');
			$new_goods_data = $goods -> where("promoteprice > 1") -> order('promoteprice') -> field('id, goodsimg, goodsname, promoteprice, goodsprice, goodsColor, goodsSize') -> limit(2) -> select();

			//查询商品收藏夹
			$collect = M('collect');
			$collect_data = $collect -> order("addtime desc") -> select();
			$arr = '';

			foreach($collect_data as $value) {
				$col_goods_data = $goods -> where("id = '{$value['goodsid']}'") -> field('id, goodsname, goodsimg, promoteprice, goodsprice, goodsColor, goodsSize') -> limit(5) -> find();
				$arr[] = $col_goods_data;
			}

			//搜索9元以下区
			$nine = $goods -> where("promoteprice < '99' AND promoteprice > '1'") -> field('id, goodsname, goodsimg, promoteprice, goodsprice, goodsColor, goodsSize') -> limit(5) -> select();
			
			$this -> assign('nine', $nine);
			$this -> assign('arr', $arr);
			$this -> assign('new_goods_data', $new_goods_data);
			$this -> assign('userid', $userid);
			$this -> assign('change', $change);
			$this -> assign('data', $data);
			$this -> display();
		}

		/*
			该方法用于删除购物车中的商品，即是删除客户端存储的SESSION值，
			当再次根据该值获取商品信息时，用户删除过的商品不应该被重复读取出来
		*/
		public function del() {

			//获取点击删除按钮时附带传递过来的相关商品id号
			$id = $_GET['id'];

			//清除客户端中存储的$_SESSION['cart'][$data['id']]信息
			unset($_SESSION['cart'][$id]);

			//判断Cookie中是否保存有SESSIO ID 
			if (isset($_COOKIE[session_name()]))  {

				//设置过期，整个网站根目录有效
				setcookie(session_name(), -3600, '/');
			}

			//最后销毁session
			session_destroy($_SESSION['cart'][$id]);

			$this -> redirect('cart');
		}

		/*
			接收购物车列表中数量一项中增加和删除商品数量点击事件传递过来的参数，
			用于处理商品数量，同时要将更新后的信息传递回去，因此如此操作频繁的用户
			将导致查询和计算次数增多，幸好该查询仅仅是查询SESSION和做一些基本
			的计算工作
		*/
		public function updateCart() {

			//获得传递过来的商品id号和所要进行相加减的参数值
			$id = $_GET['id'];

			//获得参数值，点击增加是传递1，点击减少时传递-1，这样相加一次就可以达到改变数量的效果
			$num = $_GET['num'];

			//在SESSION['cart'][$id]['num']中进行商品数量的添加减
			$_SESSION['cart'][$id]['num'] += $num;

			//但是执行相减操作时，一定要防止0和负数出现，因此限制最小值为1，当为最小值时，如果用户不需要该商品，只能执行删除操作
			if ($_SESSION['cart'][$id]['num'] <= 1) {
				$_SESSION['cart'][$id]['num'] = 1;
			}

			//执行成功后，需要全新加载页面，局部刷新也可以做到，但本页面压力不大，直接重新加载cart方法即可
			$this -> redirect('cart/cart');

		}

		//购物车列表中点击收藏时触发的方法，该方法不返回信息
		public function mycol() {

			//如果用户没有登录，是不可以收藏商品的
			if (!isset($_SESSION['user']['id'])) {
				echo '只有登录用户才可以收藏商品';
				exit;
			}

			//接收到传递过来的该商品id号，查询商品表中的数据
			$goods = M('goods');
			$collect = M('collect');
			$goods_data = $goods -> find($_POST['id']);

			//如果查询到该商品的数据，并且要先判断该用户是否已经收藏过该商品
			if ($goods_data) {

				//查询商品收藏表，检查是否已经存在该收藏
				$collect_data = $collect -> where("userid = '{$_SESSION['user']['id']}' AND goodsid = '{$_POST['id']}'") -> find();

				//如果该数据存在值说明已经有过收藏，不需要重复收藏，没有收藏过才需要收藏
				if (!$collect_data) {

					$data['userid'] = $_SESSION['user']['id'];
					$data['goodsid'] = $_POST['id'];
					$data['addtime'] = time();

					$collect -> create($data);
					$new_collect = $collect -> add();

					//如果成功，则返回收藏成功
					if ($new_collect) {
						echo '收藏成功';
					} else {
						echo '收藏不成功';
					}
				} else {
					echo '你已经收藏过该商品，不需要重复收藏';
				}
			} else {
				echo '查询不到该商品信息';
			}
		}

		//在网页任何地方，只要鼠标移动到首页顶部我的购物车时，将触发该方法
		public function checkCart() {

			//先判断购物车数组中是否有值
			if (isset($_SESSION['cart'])) {

				//说明购物车是有值的，直接将值分配过去
				$cart_data = $_SESSION['cart'];
				
				echo json_encode($cart_data);
			} else {

				//购物车为空
				echo 'no';
			}
		}

		//临时删除购物车中的信息
		function cartDel() {
			$id = $_POST['id'];

			//清空当前$_SESSION['cart']中的该条信息
			unset($_SESSION['cart'][$id]);

			$this -> redirect('Index/index');
		}
	}