<?php
	namespace Admin\Controller;
	use Think\Controller;

	class DeliveryController extends Controller {

		/*
			发货控制器下的第一个方法，显示发货表
		*/
		public function delivery() {

			//需要再次查询订单表和发票表，获取两个编号
			$delivery = M('delivery');

			//获取总记录数，用来分页输出
			$count = $delivery -> count();

			//实例化分页类，使用ajax式分页程序
			$page = new \Think\Page_ajax($count, 15);

			//显示分页程序数据
			$show = $page -> show();

			//分配到模板中
			$this -> assign('page', $show);

			//获取数据并遍历
			$delivery_data = $delivery -> order('id desc')->limit($page->firstRow.','.$page->listRows)->select();

			foreach($delivery_data as $key => $value) {

				//每次遍历后都将它不改变下标，重新生成新数组
				$arr[$key] = $value;

				//遍历后是一个一维数组，需要获取订单编号和发票编号
				$orderid = $value['orderid'];

				//查询订单编号
				$order = M('order');
				$ordersn = $order -> field('ordersn') -> where("id = '{$orderid}'") -> find();

				//将订单标号写入$delivery_data['ordersn']中
				$arr[$key]['ordersn'] = $ordersn['ordersn'];

				//查询发票编号
				$receiptid = $value['receiptid'];
				$receipt = M('receipt');
				$rec_sn = $receipt -> field('rec_sn') -> find($receiptid);

				//将发票编号写入$delivery_data['rec_sn']中
				$arr[$key]['rec_sn'] = $rec_sn['rec_sn'];
			}

			//分配数据到发票单列表模块
			$this -> assign('delivery_data', $arr);
			$this -> display();
		}

		/*
			点击发货单表中的发货单编号按钮时触发的方法，该方法同时也是浏览发货单详情的页面
		*/
		public function look() {

			//接收传递过来的发货单id值并实例化发货单对象
			$delivery = M('delivery');

			//获取发货单中的所有数据
			$delivery_data = $delivery -> find($_POST['id']);

			//获取订单id号，需要查询数据
			$orderid = $delivery_data['orderid'];

			//获取订单中的数据
			$order = M('order');
			$order_data = $order -> find($orderid);

			//获取订单编号，需要查询订单商品表
			$ordersn = $order_data['ordersn'];

			//获取包装编号
			$packid = $order_data['packid'];

			//查询包装信息
			$pack = M('pack'); 
			$pack_data = $pack -> find($packid);

			//查询订单商品表，通过订单编号关联
			$order_goods = M('order_goods');
			$order_goods_data = $order_goods -> where("ordersn = '{$ordersn}'") ->select();

			//分配数据到模板文件中
			$this -> assign("delivery_data", $delivery_data);
			$this -> assign("order_data", $order_data);
			$this -> assign('pack_data', $pack_data);
			$this -> assign("order_goods_data", $order_goods_data);
			$this -> display();
		}

		/*
			点击修改按钮时触发的方法，简单修改发货单的一些信息
		*/
		public function modify() {

			//接收发货单id号，实例化发货单表
			$delivery = M('delivery');
			$delivery_data = $delivery -> find($_POST['id']);

			//获取订单id和发票id
			$orderid = $delivery_data['orderid'];
			$receiptid = $delivery_data['receiptid'];

			//获取订单编号和发票编号
			$order = M('order');
			$receipt = M('receipt');
			$order_data = $order -> field('ordersn') -> find($orderid);
			$receipt_data = $receipt -> field('rec_sn') -> find($receiptid);

			//将数据分配到修改发货单模板中
			$this -> assign('delivery_data', $delivery_data);
			$this -> assign('order_data', $order_data);
			$this -> assign('receipt_data', $receipt_data);
			$this -> display();
		}

		/*
			 点击确认修改发货单时触发的方法
			 该方法只能更新部分字段，一些关键字段是不允许修改的
			 同时此时也不推荐在更改字段，以免造成混乱
		*/
		public function updateDelivery() {

			//获取字段信息值，并实例化发货单表
			$deliveryid = $_POST['id'];
			unset($_POST['id']);
			$delivery = M('delivery');
			$_POST['starttime'] = time();
			$delivery_data = $delivery -> where("id = '{$deliveryid}'") -> save($_POST);

			//如果数据更新成功，则回到发货单首页，否则报错
			if ($delivery_data) {
				$this -> redirect('delivery');
			} else {
				$this -> error("数据更新失败，请检查");
			}
		}

		/*
			打印发货单时使用的方法，该方法能将发货单表中的打印字段值设为1，并且也会将订单处理表
			中的订单状态改为已发货状态
			还需要将发货单中的状态修改为1
		*/
		public function subPrint() {

			//获得发货单id
			$delivery = M('delivery');
			$data['status'] = 1;
			$delivery_data = $delivery -> where("id = '{$_POST['id']}'") -> save($data);

			//如果修改成功，则继续修改订单处理表，否则提示错误
			if ($delivery_data) {

				//查询该发货单中的订单号
				$orderid = $delivery -> where("id = '{$_POST['id']}'") -> field('orderid') -> find();

				//实例化订单表
				$order = M('order');
				$ordersn = $order -> where("id = '{$orderid['orderid']}'") -> field('ordersn') -> find();

				//需要将订单表中的发货字段更改为1
				$isshipping['isshipping'] = 1;
				$order_data = $order -> where("ordersn = '{$ordersn['ordersn']}'") -> save($isshipping);

				//如果订单更改成功则继续修改订单处理表
				if ($order_data) {
					$order_action = M('order_action');
					$ship['is_ship'] = 1;
					$order_action_data = $order_action -> where("ordersn = '{$ordersn['ordersn']}'") -> save($ship);

					//如果成功，则返回发货单列表，否则提示错误
					if ($order_action_data) {

						//所有步骤执行完毕后，提交打印订单方法才算完成，跳转到发货单列表首页
						$this -> redirect('delivery');
					} else {
						echo '订单处理表写入失败';
					}
				} else {
					//订单修改失败
					echo '订单修改失败';
				}
			} else {
				echo '发货单写入失败';
			}
		}

		/*
			点击设为已处理和已完成时触发的方法，该方法将修改发货单表中的字段
		*/
		public function action() {

			//获取字段信息并实例化发货单表
			$delivery = M('delivery');

			switch($_POST['status']) {

				//设为已处理状态
				case 'action':
					$data['status'] = 1;
					break;

				//设为已完成状态
				case 'finished': 
					$data['finished'] = 1;
					break;
			}

			foreach($_POST['ids'] as $id) {

				//每循环一次，输出一个id值，就可以获取一条发货单记录，同时将值写入起其中
				$delivery_data = $delivery -> where("id = '{$id}'") -> save($data);

				//如果出错则输出提示信息，否则回到发货单列表首页
				if (!$delivery_data) {
					$this -> error("数据更新失败，请检查");
				}
			}

			//否则认为没有错误，直接跳转回发货单列表页
			$this -> redirect('delivery');
		}

		/*
			发票列表，将其安置于发货单控制器中
		*/
		public function receipt() {

			//实例化发票表，有一点小的关联，但是对发票的处理简单就可以了
			$receipt = M('receipt');

			//获取总记录数，用来分页输出
			$count = $receipt -> count();

			//实例化分页类，使用ajax式分页程序
			$page = new \Think\Page_ajax($count, 15);

			//显示分页程序数据
			$show = $page -> show();

			//分配到模板中
			$this -> assign('page', $show);

			//获取数据并遍历，是一个二维数组
			$receipt_data = $receipt -> order('id desc')->limit($page->firstRow.','.$page->listRows)->select();

			$user = M('user');

			//需要将这两个数组合一下，使用一个空的新数组就可以
			foreach($receipt_data as $key => $value) {

				//使用新数组将原来的值储存起来，仍然是一个二维数组
				$arr[$key] = $value;

				//此时的$value事一个一维数组，可以分别取出该条记录中的用户id值
				$userid = $value['userid'];

				//是一个一维数组
				$user_data = $user -> field('username') -> find($userid);

				//此时将用户名重新写入新数组$arr中
				$arr[$key]['username'] = $user_data['username'];
			}

			//将生成的新数组分配到模板文件receipt.html中
			$this -> assign('receipt_data', $arr);
			$this -> display();
		}

		/*
			该方法用来完善发票内容显示，发票就提供这两个方法就可以了
		*/
		public function prefect() {

			//传递过来的值是发票id号，获取发票所有数据
			$receipt = M('receipt');
			$receipt_data = $receipt -> find($_POST['id']);

			//获取用户名
			$userid = $receipt_data['userid'];
			$user = M('user');
			$user_data = $user -> field('username') -> find($userid);

			//获得订单编号，通过订单编号获取与该订单关联的商品，是个二维数组
			$ordersn = $receipt_data['ordersn'];
			$order_goods = M('order_goods');
			$order_goods_data = $order_goods -> field('name, promoteprice, num') -> where("ordersn = '{$ordersn}'") -> select();

			//将数据扔到模板中
			$this -> assign('receipt_data', $receipt_data);
			$this -> assign('user_data', $user_data);
			$this -> assign('order_goods_data', $order_goods_data);

			switch($_POST['status']) {

				case 'print':
					$this -> display('receiptprint');
					break;
				case 'prefect':
					$this -> display('prefect');
					break;
			}
		}

		/*
			将发票内容在发票表中更新字段，作为发票信息的补充，之后发票表就完成了
		*/
		public function endReceipt() {

			//接收请求发送过来的所有值，已经经过过滤，可以直接使用来写入数据表中
			$id = $_POST['id'];
			unset($_POST['id']);

			//并且将发票表中的标志字段发票表是否以完善设为为已完善
			$_POST['isprefect'] = 1;
			$receipt =M('receipt');
			$receipt_data = $receipt -> where("id = '{$id}'") -> save($_POST);

			//如果数据更新成功，将重定向回发票单列表中，否则提示错误或者不显示任何信息
			if ($receipt_data) {
				$this -> redirect('receipt');
			} else {
				$this -> error("数据更新失败");
			}
		}

		/*
			打印发票方法，该方法将修改发票中的已打印字段
		*/
		public function receiptPrint() {

			//获取发票id号
			$receipt = M('receipt');
			$data['print'] = 1;
			$receipt_data = $receipt -> where("id = '{$_POST['id']}'") -> save($data);

			//如果发票字段更新成功，则返回到发票列表页
			if ($receipt_data) {
				$this -> redirect('receipt');
			}  else {
				echo '发票内容字段修改失败';
			}
		}

		/*
			发货单列表中的批量删除操作方法，从底层删除仅仅删除自己这条数据
			不能连同父级数据一并删除，只有父级数据或与父级关联的数据在父级
			需要删除时才会一并连同底层数据一起删除
		*/
		public function dels() {

			//如果发货单id值是通过批量操作传递过来的，则是一个数组值
			if (isset($_POST['ids'])) {
				$ids = $_POST['ids'];
			}

			/*
				如果发货单id值是一个字符串，则是操作选项中的单挑数据删除方式，
				单条数据时批量数据处理中最简单的形式，将其转存为数组的形式
			*/
			if (isset($_POST['id'])) {
				$ids[] = $_POST['id'];
			}

			$delivery = M('delivery');

			//遍历所有发货单id值
			foreach($ids as $id) {

				//删除单条发货单数据
				$delivery_data = $delivery -> delete($id);

				//如果删除失败，则输出错误信息
				if (!$delivery_data) {
					echo "删除该条发货单数据失败";
					exit;
				}
			}

			//执行完毕后，跳回到发货单首页面
			$this -> redirect('delivery');
		}

		/*
			发票列表中的批量数据删除操作方法
			该方法仅仅是删除发票操作，不删除关联表项
		*/
		public function receiptDel() {

			//接收到发送过来的批量发票id数据数组
			if (isset($_POST['ids'])) {
				$ids = $_POST['ids'];
			}

			$receipt = M('receipt');

			//遍历出每一条发票id值
			foreach($ids as $id) {

				//删除每一条发票数据信息
				$receipt_data = $receipt -> delete($id);

				//如果删除失败，提示错误信息
				if (!$receipt_data) {
					echo '该条发票信息删除失败';
					exit;
				}
			}

			//删除发票成功后，跳转到发票列表首页
			$this -> redirect('receipt');
		}

		//搜索发货单标号
		public function search() {

			$sn = trim($_POST['sn']);

			//实例化
			$map['deliverysn'] = array('like', "%$sn%");

			$delivery = M('delivery');

			$new_delivery_data = $delivery -> where($map) -> field('deliverysn') -> select();

			//如果获取到数据，则输出至页面，否则提示错误
			if ($new_delivery_data) {

				//遍历出单条发货单编号
				foreach($new_delivery_data as $dsn) {
					$delivery_data[] = $delivery -> where("deliverysn = '{$dsn['deliverysn']}'") -> find();
				}

				//如果获取数据成功则继续获取订单编号和发票编号
				if ($delivery_data) {

					foreach($delivery_data as $key => $value) {

						//每次遍历后都将它不改变下标，重新生成新数组
						$arr[$key] = $value;

						//遍历后是一个一维数组，需要获取订单编号和发票编号
						$orderid = $value['orderid'];

						//查询订单编号
						$order = M('order');
						$ordersn = $order -> field('ordersn') -> where("id = '{$orderid}'") -> find();

						//将订单标号写入$delivery_data['ordersn']中
						$arr[$key]['ordersn'] = $ordersn['ordersn'];

						//查询发票编号
						$receiptid = $value['receiptid'];
						$receipt = M('receipt');
						$rec_sn = $receipt -> field('rec_sn') -> find($receiptid);

						//将发票编号写入$delivery_data['rec_sn']中
						$arr[$key]['rec_sn'] = $rec_sn['rec_sn'];
					}

					$this -> assign('delivery_data', $arr);
					$this -> display('delivery');
				} else {
					echo '无法将数据输出至页面中';
				}
			} else {
				echo '查询不到符合条件的记录';
			}
		} 

		//筛选操作，已发货和未完成按钮
		public function select() {

			switch($_POST['status']) {

				//已发货
				case 'shipped':
					$data['status'] = 1;
					break;

				//未完成
				case 'notship':
					$data['finished'] = 0;
					break;
			}

			$delivery = M('delivery');
			$delivery_data = $delivery -> where($data) -> select();

			//仍然需要遍历出相应的订单编号和发票编号，如果获取数据成功则继续获取订单编号和发票编号
			if ($delivery_data) {

				foreach($delivery_data as $key => $value) {

					//每次遍历后都将它不改变下标，重新生成新数组
					$arr[$key] = $value;

					//遍历后是一个一维数组，需要获取订单编号和发票编号
					$orderid = $value['orderid'];

					//查询订单编号
					$order = M('order');
					$ordersn = $order -> field('ordersn') -> where("id = '{$orderid}'") -> find();

					//将订单标号写入$delivery_data['ordersn']中
					$arr[$key]['ordersn'] = $ordersn['ordersn'];

					//查询发票编号
					$receiptid = $value['receiptid'];
					$receipt = M('receipt');
					$rec_sn = $receipt -> field('rec_sn') -> find($receiptid);

					//将发票编号写入$delivery_data['rec_sn']中
					$arr[$key]['rec_sn'] = $rec_sn['rec_sn'];
				}

				$this -> assign('delivery_data', $arr);
				$this -> display('delivery');
			} else {
				echo '无法将数据输出至页面中';
			}
		}
	}