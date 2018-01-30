<?php
	namespace Home\Controller;
	use Think\Controller;

	class OrderActionController extends Controller {

		/*
			该方法时订单处理也面对额第一步
			手续接收来自订单提交和订单修改页面的请求
			其次需要将订单处理表中的前四项内容写进去，作为
			用户查看我的订单详情页时能看到相关的处理状态
		*/
		public function newOrder() {

			//自动加载头文件，位于Header文件夹下面
			R("Header/index");

			//判断用户是否登录
			if (!isset($_SESSION['user'])) {
				$this -> redirect('user/login');
			}

			//此时，订单已经提交成功，理论上客户端的购物环节已经完成，如果不需要修改的话，可以清空购物车中的信息
			$_SESSION['cart'] = array();

			//清空地址信息
			$_SESSION['address'] = array();

			//清空付款信息
			$_SESSION['pay'] = array();

			//清空送货方式信息
			$_SESSION['ship'] = array();

			//清空订单备注信息
			unset($_SESSION['note_content']);

			//清空发票信息
			$_SESSION['receipt'] = array();

			//同时需要清除修改订单的标志字段值
			unset($_SESSION['item']['change']);
			
			$orderid = $_GET['orderid'];

			//获取当前登录用户id，查询所有未完成的订单
			$id = $_SESSION['user']['id'];

			//首先查询该用户所有的订单号，及在订单表中字段userid=用户id的，并且是未完成的订单所有数据
			$order = M('order');

			//查询该条订单的订单编号
			$ordersn = $order -> where("id = '{$orderid}'") -> field("ordersn") -> find();

			//打印该用户所有的未处理的订单信息
			$order_data = $order -> where("userid = '{$id}' AND orderstatus = '0'") -> select();

			//实例化订单处理表
			$order_action = M('order_action');
			$data['orderid'] = $orderid;
			$data['ordersn'] = $ordersn['ordersn'];
			$data['userid'] = $id;
			$data['is_sub'] = 1;
			$order_action -> create($data);
			$order_action_data = $order_action -> add();

			//如果写入不成功，则提示错误
			if (!$order_action_data) {
				$this -> error("订单处理不成功");
			}

			//将该数据分配到订单查看页面中
			$this -> assign('order_data', $order_data);


			//计算点击次数最多的商品，取5件
			$goods = M('goods');
			$click = $goods -> where('promoteprice > 1') -> order("clickcount desc") -> field('id, goodsname, goodsimg, goodsColor, promoteprice, goodsprice, clickcount') -> limit(5) -> select();

			$this -> assign('click_data', $click);

			$this -> display();
		}

		/*
			用户点击继续购物时实现跳转重定向，不需要传递参数，直接调回首页就可以了
		*/
		public function goShipping() {

			$this -> redirect('index/index');
		}

		
	}