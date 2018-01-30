<?php
	namespace Admin\Controller;
	use Think\Controller;

	class OrderController extends Controller {

		/*
			后台首页中，用户点击订单项中的订单列表时触发JS函数orderList()
			该函数首先调用IndexCotroller()控制器中的order()方法
			该方法重定向到OrderController（）控制器中的order（）方法
			方法实例化订单，同时进行分页操作，将数据传递到控制器Order目录下的order.html页面
		*/
		public function order() {

			$order = M('order');
			$count = $order -> count();

			//实例化框架自带的分页类，有改动，修改为ajax局部刷新分页，每次请求该方法
			$Page = new \Think\Page_ajax($count, 8);

			$show = $Page -> show();

			$order_data = $order -> order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

			$this -> assign('page', $show);
			$this -> assign('order_data', $order_data);
			$this -> display();
		}

		/*
			该方法是操作订单列表中的修改项时触发
		*/
		public function modify() {

			//接收触发时附带发送过来的订单id号
			$id = $_POST['id'];

			//实例化订单表
			$order = M('order');

			//只需要取一条数据
			$order_data = $order -> find($id);

			//获取用户id
			$userid = $order_data['userid'];

			//获取管理员id
			$adminid = $order_data['adminid'];

			//获取包装id
			$packid = $order_data['packid'];

			//实例化用户表，获取用户名
			$user = M('user');

			//获取用户名和邮箱并存入数据$user_data中
			$user_data = $user ->  field('username, email') -> where("id = '{$userid}'") -> find();

			//获取管理员姓名存入数据$admin_data中


			//获取包装信息并存入数据$pack_data中
			$pack = M('pack');

			$pack_data = $pack -> find($packid);

			//开始分配数据到模板文件modify.html中去

			//分配订单数据
			$this -> assign('order_data', $order_data);

			//分配用户数据
			$this -> assign('user_data', $user_data);

			//分配包装数据
			$this -> assign('pack_data', $pack_data);

			//数据分配完成，将其显示到母版文件中
			$this -> display();
		}

		/*
			修改订单数据的保存，可以修改收件人和填写处理者信息
		*/
		public function saveModify() {

			//获取订单id号
			$id = $_POST['id'];
			unset($_POST['id']);

			$order = M('order');

			$order_data = $order -> where("id = '{$id}'") -> save($_POST);

			//如果修改成功，直接跳回订单列表页面
			if ($order_data) {
				$this -> redirect('order');
			} else {
				echo '订单修改失败';
			}
		}

		/*
			打印订单方法，该方法将i修改订单处理表中的打印字段

			同时需要查询订单商品表，将商品信息显示出来
		*/
		public function orderPrint() {

			//获得订单号
			$id = $_POST['id'];
			$order = M('order');
			$order_data = $order -> find($id);

			//查询下单者姓名
			$user = M('user');
			$user_data = $user -> where("id = '{$order_data['userid']}'") -> field('username') -> find();

			//查询用户收货地址信息
			$user_address = M('user_address');
			$user_address_data = $user_address -> where("id = '{$order_data['addressid']}'") -> find();

			//查询用户发票信息
			$receipt = M('receipt');
			$receipt_data = $receipt -> where("id = '{$order_data['receiptid']}'") -> find();

			//查询用户订单商品信息
			$order_goods = M('order_goods');
			$order_goods_data = $order_goods -> where("ordersn = '{$order_data['ordersn']}'") -> select();

			$this -> assign('order_data', $order_data);
			$this -> assign('user_data', $user_data);
			$this -> assign('user_address_data', $user_address_data);
			$this -> assign('receipt_data', $receipt_data);
			$this -> assign('order_goods_data', $order_goods_data);
			$this -> display();

		}

		/*
			处理订单打印信息，将修改订单处理表中的打印字段
		*/
		public function subPrint() {

			//获得订单id号
			$order_action = M('order_action');
			$data['is_print'] = 1;
			$order_action_data = $order_action -> where("orderid = '{$_POST['id']}'") -> save($data);

			//如果修改成功，跳转到订单列表页面
			if ($order_action_data) {
				$this -> redirect('order');
			} else {
				echo '订单处理写入失败';
			}
		}

		/*
			生成包装操作，点击后数据将被写入包装表中，同时将该包装表的id值传递过来
			写入订单表中的packid字段里

			需要写一次订单处理表，将订单处理表中的字段设置为1
		*/
		public function pack() {

			//获取订单id号，是一个一维数组
			$id = $_POST['id'];
			$order = M('order');
			$order_data = $order -> find($id);

			//实例化包装表，因为可能含有数据，或者数据已经被修改过
			$pack = M('pack');
			$pack_data = $pack -> where("ordersn = '{$order_data['ordersn']}'") -> find();

			$this -> assign('pack_data', $pack_data);
			$this -> assign('order_data', $order_data);
			$this -> display();
		}

		/*
			确认生成包装时触发的方法，该方法将接受传递过来的值，并写入包装表中
			注意，写入包装表后将生成新的包装id 
			需要将该值重写写入订单表中去

			要修改订单处理表中的is_pack字段值，将其设置为1
		*/
		public function buildPack() {

			//获取传递过来的值，并存入一个临时数组中
			$_POST['pack']['ordersn'] = $_POST['ordersn'];
			$_POST['pack']['userid'] = $_POST['userid'];
			$_POST['pack']['packname'] = $_POST['name'];
			$_POST['pack']['packfee'] = $_POST['fee'];
			$_POST['pack']['packfree'] = $_POST['free'];
			$_POST['pack']['packdesc'] = $_POST['desc'];
			$_POST['pack']['addtime'] = time();

			//实例化包装表
			$pack = M('pack');
			$pack -> create($_POST['pack']);
			$pack_last_id = $pack -> add();

			//实例化订单表，将返回的最后有效id 值更新到字段packid
			$order = M('order');

			$data['packid'] = $pack_last_id;

			$order_data = $order -> where("ordersn = '{$_POST['pack']['ordersn']}'") -> save($data);

			//实例化订单处理表
			$order_action = M('order_action');
			$is_pack['is_pack'] = 1;
			$order_action_data = $order_action -> where("ordersn = '{$_POST['ordersn']}'") -> save($is_pack);

			//如果写入成功，则页面将一样跳转到本控制器的第一个方法order（）方法
			if ($order_data && $order_action_data) {
				$this -> redirect('order');
			} else {
				echo "数据写入失败，请检查";
			}
		}

		/*
			点击生成发货单时触发的控制器方法，该方法比较复杂，涉及字段有点多
			此时就可以显示已发货状态了，当然发货单还是可以做一些简单的修改的
		*/
		public function delivery() {

			//获得传递过来的订单id号
			$id = $_POST['id'];

			//实例化订单表
			$order = M('order');

			//查询出该订单的所有字段信息
			$order_data = $order -> find($id);

			//首先获取包装id号
			$packid = $order_data['packid'];

			//实例化包装表
			$pack = M('pack');

			//获取包装信息
			$pack_data = $pack -> find($packid);

			//获取用户id
			$userid = $order_data['userid'];

			//获取用户信息
			$user = M('user');

			$user_data = $user -> find($userid);

			//获取订单表中用户地址id
			$addressid = $order_data['addressid'];

			//获取用户常用地址所有信息，用户选择的默认收货地址有变，暂时去默认收货地址算
			$user_address = M('user_address');

			$user_address_data = $user_address -> where("id = '{$addressid}'") -> find();

			//获取订单编号，用户查询订单商品表，获取与该订单相关的商品信息
			$ordersn = $order_data['ordersn'];

			//实例化订单商品表，获取所有信息
			$order_goods = M('order_goods');

			//获取订单商品表中的所有字段信息
			$order_goods_data = $order_goods -> where("ordersn = '{$ordersn}'") -> select();

			//开始分配变量到生成发货单模板中
			$this -> assign('user_data', $user_data);
			$this -> assign('order_data', $order_data);
			$this -> assign('pack_data', $pack_data);
			$this -> assign('user_address_data', $user_address_data);
			$this -> assign('order_goods_data', $order_goods_data);
			$this -> display();
		}

		/*
			生成发货单的最后一步，及确定写入数据表的操作
			该操作需要生成一个发货编号，采用同商品编号类似的算法
			即是当前时间的分钟和秒数组成前四位，生成惟一id函数，使用参数，
			避免同一微秒时生成重复的值，取其前四位，一共组成 八位数作为生成的发货编号
			其中可能包含有数字和字母，将所有可能出现的字母转为大写形式
			strtoupper(date('is', time()).substr(uniqid('', true), 0, 4));

			成功生成发货单后，还需要将最后有效的id值写入订单表中的发货单id字段

		*/
		public function subDelivery() {

			//生成8位发货单编号，即货运号
			$deliverysn = strtoupper(date('is', time()).substr(uniqid('', true), 0, 4));

			//接收生成发货单页面传递过来的订单编号和发货单描述
			$ordersn = $_POST['ordersn'];
			$desc = $_POST['desc'];dump($ordersn);

			//通过订单编号查询订单号及所有该订单信息
			$order = M('order');

			$order_data = $order -> where("ordersn = '{$ordersn}'") -> find();

			//查询包装id
			$packid = $order_data['packid'];

			//查询收货人收货地址id
			$addressid = $order_data['addressid'];

			//获取收货人地址信息
			$address = M('user_address');

			$address_data = $address -> find($addressid);

			//查询包装表中的运费
			$pack = M('pack');

			$pack_data = $pack -> field('packfee')  -> find($packid);

			//整理数据，将其写入包发货单表中
			$orderid = $order_data['id'];

			$data['deliverysn'] = $deliverysn;
			$data['orderid'] = $orderid;
			$data['receiptid'] = $order_data['receiptid'];
			$data['addtime'] = time();
			$data['userid'] = $order_data['userid'];
			$data['consignee'] = $order_data['consignee'];
			$data['country'] = $address_data['country'];
			$data['pname'] = $address_data['pname'];
			$data['cname'] = $address_data['cname'];
			$data['county'] = $address_data['county'];
			$data['address'] = $address_data['address'];
			$data['zipcode'] = $address_data['zipcode'];
			$data['phone'] = $address_data['phone'];
			$data['email'] = $address_data['email'];
			$data['tel'] = $address_data['tel'];
			$data['besttime'] = $order_data['besttime'];
			$data['desc'] = $desc;
			$data['shipping'] = $pack_data['packfee'];

			//实例化发货单表
			$delivery = M('delivery');
			$delivery -> create($data);
			$delivery_last_id = $delivery -> add();

			//将这个值写入订单表中的发货单id字段
			$data['order']['deliveryid'] = $delivery_last_id;
			$new_order_data = $order -> where("id = '{$orderid}'") -> save($data['order']);


			if ($new_order_data) {

				//写入成功，跳回到订单列表页，进入发货单列表可以看到已经生成的发货单信息，同时写入订单处理表中
				$order_action = M('order_action');

				//设置字段值
				$is_delivery['is_delivery'] = 1;
				$order_action_data = $order_action -> where("ordersn = '{$ordersn}'") -> save($is_delivery);

				//如果数据写入出错，输出错误信息
				if (!$order_action_data) {
					echo "数据修改错误";
				}

				$this -> redirect('order');
			} else {
				$this -> error("订单表写入失败，请检查");
			}
		}

		/*
			该方法是后台点击设为已付款状态时触发的方法
			调用该方法时，将订单表中的ispay字段修改为值1
			完成后需要重新加载该控制器中的order方法
		*/
		public function changeStatus() {

			//获取的值是一个操作一维数组，需要遍历操作
			//$ids = $_POST['ids'];

			//实例化订单表
			$order = M('order');

			foreach($_POST['ids'] as $value) {
				
				//通过该选择，确定页面请求的选项，在赋相应的值
				switch($_POST['status']) {

					//选择设为已付款
					case "paied":

						//同时操作数据表，将该字段修改成为1
						$data['ispay'] = 1;
						break;

					//选择设为已发货
					case "shipped":

						//同时操作数据表，将该字段修改成为1
						$data['isshipping'] = 1;

						//同时设置订单处理表，修改为已发货状态
						$order_action = M('order_action');
						$is_ship['is_ship'] = 1;
						$order_action_data = $order_action -> where("orderid = '{$value}'") -> save($is_ship);

						//如果出错需要提示错误
						if (!$order_action_data) {
							echo '订单处理表中的字段is_ship修改失败';
						}
						break;

					//选择设为已完成
					case "finished":

						//同时操作数据表，将该字段修改成为1
						$data['orderstatus'] = 1;
						$order_action = M('order_action');
						$is_place['is_place'] = 1;
						$is_place['is_finished'] = 1;
						$order_action_data = $order_action -> where("orderid = '{$value}'") -> save($is_place);

						//如果出错需要提示错误
						if (!$order_action_data)  {
							echo '订单处理表中的字段is_ship和is_finished修改失败';
						}
						break;
				}

				$order_data = $order -> where("id = '{$value}'") -> save($data);

				//如果更新失败，则提示错误
				if (!$order_data) {
					$this -> error("字段更改失败");
				} 
			}

			//数据全部更新完毕，需要跳转回原页面
			$this -> redirect('order');
		}

		/*
			订单列表页面中，点击删除操作时触发，该方法支持批量操作，即批量删除
			删除该订单将连同该订单下面的发票、包装、发货单、付款单、订单处理表
			订单商品表也将被一并删除，且不可逆
		*/
		public function dels() {

			//获得数组订单id值，属于批量操作传递过来的数据，单条数据仅仅是批量操作中最简单的一种
			if (isset($_POST['ids'])) {
				$ids = $_POST['ids'];
			}

			//如果是单个id值，则属于点击订单操作项目中的删除按钮触发，属于单条数据删除，将其转化为数组形式
			if (isset($_POST['id'])) {
				$ids[] = $_POST['id'];
			}

			$order = M('order');
			$receipt = M('receipt');
			$pack = M('pack');
			$delivery = M('delivery');
			$pay = M('pay');
			$order_action = M('order_action');
			$order_goods = M('order_goods');

			//遍历出每一个订单id值
			foreach($ids as $id) {
				
				//获取相应id值对应的订单编号
				$order_data = $order -> where("id = '{$id}'") -> field('ordersn') -> find();

				//如果获取到订单编号，则取出，否则提示错误
				if ($order_data) {

					//获取订单编号
					$ordersn = $order_data['ordersn'];

					//查询是否有发票，如果有发票则先删除发票
					$receipt_data = $receipt -> where("ordersn = '{$ordersn}'") -> field('id') -> find();

					//如果有发票，则删除
					if ($receipt_data) {

						//有发票，删除
						$new_receipt = $receipt -> delete($receipt_data['id']);

						//如果删除失败则提示错误
						if (!$new_receipt) {
							echo '删除订单中的关联发票失败';
							exit;
						}
					}

					//查询是否有包装，如果有，删除包装
					$pack_data = $pack -> where("ordersn = '{$ordersn}'") -> field('id') -> find();

					//如果有包装，删除
					if ($pack_data) {

						//有包装，删除
						$new_pack = $pack -> delete($pack_data['id']);

						//如果删除失败，提示错误
						if (!$new_pack) {
							echo '删除订单中的关联包装失败';
							exit;
						}
					}

					//如果有发货单，删除发货单，需要订单id字段
					$delivery_data = $delivery -> where("orderid = '{$id}'") -> field('id') -> find();

					//如果有发货单，需要删除发货单
					if ($delivery_data) {

						//删除发货单
						$new_delivery = $delivery -> delete($delivery_data['id']);

						//删除发货单失败，输出提示信息
						if (!$new_delivery) {
							echo '删除订单中的关联发货单失败';
							exit;
						}
					}

					//如果有付款单，需要删除付款单
					$pay_data = $pay -> where("ordersn = '{$ordersn}'") -> field('id') -> find();

					//如果有付款单信息，先删除付款单
					if ($pay_data) {

						//删除付款单
						$new_pay = $pay -> delete($pay_data['id']);

						//如果删除失败，输出提示信息
						if (!$new_pay) {
							echo '删除订单中的关联付款单失败';
							exit;
						}
					}

					//如果有订单处理表，将删除订单处理表中的记录
					$order_action_data = $order_action -> where("ordersn = '{$ordersn}'") -> field('id') -> find();

					//如果有订单处理表，删除
					if ($order_action_data) {

						//删除订单处理表
						$new_order_action = $order_action -> delete($order_action_data['id']);

						//如果删除失败，则提示错误
						if (!$new_order_action) {
							echo '订单中的关联订单处理表删除失败';
							exit;
						}
					}

					//如果有商品订单记录，删除订单商品表，该数据类型是一个二维数组
					$order_goods_data = $order_goods -> where("ordersn = '{$ordersn}'") -> field('id') -> select();

					//如果订单商品表中有数据
					if ($order_goods_data) {

						//遍历出每一条商品记录
						foreach($order_goods_data as $value) {

							//删除每一条商品记录
							$new_order_goods = $order_goods -> delete($value['id']);

							//如果删除失败，输出错误信息
							if (!$new_order_goods) {
								echo '删除订单中的关联订单商品表失败';
								exit;
							}
						}
					}

					//执行到这里，所有的关联都已经删除，可以删除该条订单了
					$new_order = $order -> delete($id);

					//如果订单删除失败，输出提示信息
					if ($new_order) {
						$this -> redirect('order');
					} else {
						echo '订单删除失败';
						exit;
					}
				} else {
					echo '获取不到订单编号';
				}
			}
		}

		//点击订单号进行搜索
		public function search() {

			//实例化订单表，按订单编号进行搜索，可以搜索类似订单，也可以时模糊搜索和精确搜索
			$ordersn = trim($_POST['ordersn']);
			$order = M('order');
			$map['ordersn'] = array('like', "%$ordersn%");
			$new_order_data = $order -> where($map) -> field('ordersn') -> select();

			//如果搜索到内容则显示，否则提示找不到数据
			if ($new_order_data) {

				//遍历出所有的订单编号
				foreach($new_order_data as $value) {
					
					//获取每一条订单信息，组合成新数组
					$order_data[] = $order -> where("ordersn = '{$value['ordersn']}'") -> find();
				}

				//如果获取到数据
				if ($order_data) {

					$this -> assign('order_data', $order_data);
					$this -> display('order');
				} else {
					echo '已搜索到内容，但是无法读取到订单数据';
				}
			} else {
				echo '搜索不到符合该条件的数据';
			}
		}

		//栏目快速筛选符合条件的数据
		public function select() {

			//接收状态值用于处理模型类
			switch($_POST['status']) {

				//选择有效订单
				case 'use':
					$data['isuse'] = 1;
					break;

				//选择无效订单
				case 'notuse':
					$data['isuse'] = 0;
					break;

				//选择未付款订单
				case 'notpay':
					$data['ispay'] = 0;
					break;

				//选择已付款订单
				case 'pay':
					$data['ispay'] = 1;
					break;

				//选择已发货订单
				case 'delivery':
					$data['isshipping'] = 1;
					break;

				//选择已完成订单
				case 'end':
					$data['orderstatus'] = 1;
					break;
			}

			//实例化订单
			$order = M('order');

			$count = $order -> where($data) -> count();

			$Page = new \Think\Page_ajax($count, 8);

			$show = $Page -> show();

			$order_data = $order -> where($data) -> order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

			//如果搜索到数据，则返回
			if ($order_data) {

				$this -> assign('page', $show);
				$this -> assign('order_data', $order_data);
				$this -> display('order');
			} else {
				echo '搜索不到符合条件的数据';
			}
		}	
	}