<?php
	namespace Home\Controller;
	use Think\Controller;

	/*
		显示订单页面时默认需要获取的各种数值，操作稍多，同时需要把相应的值传递到订单静态页面去
	*/
	class OrderController extends Controller {

		public function order() {

			//判断是否是已登录用户，如果不是，不可以提交订单
			if (!isset($_SESSION['user']['id'])) {
				$this -> redirect('user/login');
			} else {
				$user_info = $_SESSION['user'];
				$this -> assign("user_info", $user_info);
			}

			//获取登录用户id号
			$id = $_SESSION['user']['id'];

			//首先查询用户常用地址表信息，如果该用户id字段已经存在于常用地址表中，则直接读取默认地址
			$ress = M('user_address');

			//一位用户可以有多个常用收货地址，全部遍历出来
			$address = $ress -> where("userid = '{$id}'") -> select();

			//判断是否有信息
			if ($address) {
				$this -> assign('address', $address);
			}

			//读取$_SESSION['cart']中存储的商品信息，将其传递到订单填写页面去
			$goods_info = $_SESSION['cart'];
			$this -> assign('goods_info', $goods_info);

			//获取用户已经选择过的地址信息，用于显示配送在快捷栏中
			if (isset($_SESSION['ship']['ship_time']) && isset($_SESSION['ship']['ship_type'])) {
				$ship_type = $_SESSION['ship']['ship_type'];
				$ship_time = $_SESSION['ship']['ship_time'];

				$this -> assign('ship_type', $ship_type);
				$this -> assign('ship_time', $ship_time);
			} 

			//获取用户已经选择过的支付信息，用于显示在支付快捷栏中
			if (isset($_SESSION['pay']['pay_type']) ) {
				$pay_type = $_SESSION['pay']['pay_type'];
				
				$this -> assign('pay_type', $pay_type);
			} 

			//获取用户已经操作过的订单备注信息，用于显示在订单备注快捷栏中
			if (isset($_SESSION['note_content']) ) {
				$note_content = $_SESSION['note_content'];
				
				$this -> assign('note_content', $note_content);
			} 

			//获取用户操作过的发票内容，显示在发票栏中
			if (isset($_SESSION['receipt']['z_need']) &&  isset($_SESSION['receipt']['user_type'])  && isset($_SESSION['receipt']['receipt_title']) && isset($_SESSION['receipt']['receipt_content'])) {
				$z_need = $_SESSION['receipt']['z_need'];
				$user_type = $_SESSION['receipt']['user_type'];
				$receipt_title = $_SESSION['receipt']['receipt_title'];
				$receipt_content = $_SESSION['receipt']['receipt_content'];

				$this -> assign('z_need', $z_need);
				$this -> assign('user_type', $user_type);
				$this -> assign('receipt_title', $receipt_title);
				$this -> assign('receipt_content', $receipt_content);
			}

			//需要判断以下该条信息是否是用户修改订单传递过来的页面
			if (isset($_SESSION['item']['change'])) {

				//说明是从修改订单页面传递下来的页面，需要做相应的变化
				$this -> assign('change', $_SESSION['item']['change']);
			}
 
			$this -> display();
		}

		/*
			保存用户的常用收货地址，存取时需要存入用户的id字段作为表中的userid字段
		*/
		public function savePlace() {

			//获取登录用户id号
			$id = $_SESSION['user']['id'];

			/*
				查询常用地址表，看是否已有一些数据记录，如果有，检查字段status值是否存在1，
				存在则不再添加该字段，不存在则将该字段的值设为1，作为默认收货地址
			*/
			$address = M('user_address');
			$exists = $address -> where("userid = '{$id}' AND status = '1'") -> find();

			//为真则该字段有值，不需要重复设置默认地址
			if ($exists) {
				$_POST['status'] = 0;
			} else {

				//不存在这样的字段，说明用户并没有默认的常用收货地址，就将该地址作为默认的收货地址
				$_POST['status'] = 1;
			}

			//不存在该用户常用地址，将其加入到该地址表中存起来，先取出用户的邮箱，直接从超全局数组$_SESSION['user']字段中获取
			$_POST['email'] = $_SESSION['user']['email'];
			$_POST['userid'] = $id;
			
			//为方便用，将收货人姓名也存入全局数组中
			$_SESSION['address']['name'] = $_POST['name'];

			//实例化常用收货地址表
			$user = M('user_address');
			$user -> create($_POST);
			$data = $user -> add();

			//地址写入成功，直接进行重定向到订单页中来，并且重新加载
			if($data) {
				$this -> redirect('order');
			} else {
				$this -> error('地址添加失败');
			}	
		}

		/*
			获取订单页面中用户选择的送货方式，作为最佳送货时间字段字段存储在超全局数组$_SESSION['ship_']中，
			作为订单页面提交时写入数据表中
		*/
		public function shipTime() {

			//当用户调用该方法时，判断送货方式和送货时间这两个字段是否已经有值或用户是否填写该字段
			if (isset($_POST['ship_type']) && isset($_POST['ship_time'])) {

				//判断超全局数组$_SESSION['ship_']字段是否已经被占用
				if (isset($_SESSION['ship']['ship_type']) && isset($_SESSION['ship']['ship_time'])) {

					//销毁该字段后重新赋值于其中
					unset($_SESSION['ship']['ship_type']);
					unset($_SESSION['ship']['ship_time']);

					$_SESSION['ship']['ship_type'] = trim($_POST['ship_type']);
					$_SESSION['ship']['ship_time'] = trim($_POST['ship_time']);
				}  else {

					//如果不存在该字段，直接将这两个值赋值
					$_SESSION['ship']['ship_type'] = trim($_POST['ship_type']);
					$_SESSION['ship']['ship_time'] = trim($_POST['ship_time']);
				}
			} else {
				$this -> error('请核对你的送货方式和送货时间字段是否填写完整');
			}

			$this -> redirect('order');
		} 

		/*
			订单页面点击确认支付方式操作时触发该方法，该方法用于获取用户选择的支付方式选择
			同样将该值暂时存入超全局数组$_SESSION['pay_type']字段中
		*/
		public function payType() {

			//判断用户调用该方法时，是否正确传递该字段
			if (isset($_POST['pay_type'])) {

				//判断超全局数组$_SESSION['pay']字段是否已被赋值，如果被赋值则将其清空后重新赋值
				if (isset($_SESSION['pay']['pay_type'])) {
					unset($_SEEEION['pay']['pay_type']);

					$_SESSION['pay']['pay_type'] = trim($_POST['pay_type']);
				} else {

					//该字段不存在，直接进行赋值
					$_SESSION['pay']['pay_type'] = trim($_POST['pay_type']);
				}
			} else {
				$this -> error('错误操作，你必须选择一种支付方式，默认选择在线支付');
			}

			$this -> redirect('order');
		}

		/*
			回到购物车，修改产品按钮点击时触发，重定向到购物车控制器中的方法
		*/
		public function backCart() {
			$this -> redirect('cart/cart');
		}

		/*
			用户点击订单备注时触发该方法，用于获取用户的留言，该方法为用户点击订单备注按钮后
			离开时触发blur事件，表单自动提交文本内容，如果用户没有任何输入，则记录为空字符串
			同样将该字段值暂时存在超全局数组$_SESSION['note_content']字段中
		*/
		public function userSign() {

			//获取订单页面中订单备注的输入值
			if (isset($_POST['note_content'])) {

				//判断超全局数组中是否已经存在$_SESSION['note_content']字段
				//ThinkPHP框架中的$_SESSION使用新方法，检查该变量是否已经设置
				if (isset($_SESSION['note_content'])) {

					//如果已经被设置，将其删除，清空
					unset($_SESSION['note_content']);

					//重新赋值
					$_SESSION['note_content'] = $_POST['note_content'];
				} else {

					//该变量不存在，直接进行赋值操作
					$_SESSION['note_content'] = $_POST['note_content'];
				}
			}

			$this -> redirect('order');

		}

		/*
			处理来自订单页面发送过来的请求，当用户点击开具发票按钮时触发
			接收到的值将存储于超全局数组$_SESSION['receipt']字段中
		*/
		public function getReceipt() {

			//判断该值是否有设置
			if (isset($_POST['z_need']) && isset($_POST['user_type']) && isset($_POST['receipt_title']) && isset($_POST['receipt_content'])) {

				//判断用户是否需要开具发票
				if ($_POST['z_need'] == 1) {

					//$_SESSION中是否有相关的变量,直接覆盖
					$_SESSION['receipt']['z_need'] = $_POST['z_need'];
					$_SESSION['receipt']['user_type'] = $_POST['user_type'];
					$_SESSION['receipt']['rec_title'] = $_POST['receipt_title'];
					$_SESSION['receipt']['rec_content'] = $_POST['receipt_content'];
				}
			} else {
				$this -> error('你有填写不完整的字段存在');
			}
			$this -> redirect('order');
		}

		/*
			获取用户常用收货地址的地址代号id，用于处理订单时用
		*/
		public function newAddress() {

			//获取地址改变时所选择的地址id值
			$id = $_POST['newid'];

			$address = M('user_address');
			$data = $address -> find($id);

			//将地址信息整个存入到$_SESSION['address']字段中
			if (isset($_SESSION['address'])) {

				//如果该值已被设置，将其清空
				session('address', null);

				//将这个id存入$_SESSION['address']['newid']字段中
				$_SESSION['address']['id'] = $id;

				//设置该值
				$_SESSION['address'] = $data;
			} else {

				//否则该值为空，直接赋值就可以
				$_SESSION['address'] = $data;

				//将这个id存入$_SESSION['address']['newid']字段中
				$_SESSION['address']['id'] = $id;
			}
			
		}

		/*
			提交订单时触发的方法，该方法将读取该页面所有需要的信息，注意，根据用户选择进行数据库查询
			所有操作完成后进行生成订单功能，生成的订单号使用八位数字表示，
			生成订单号，当前时间的分钟和秒数组成前四位，生成惟一id函数，使用参数，
			避免同一微秒时生成重复的值，取其前四位，一共组成 八位数作为生成的订单号
			其中可能包含有数字和字母，将所有可能出现的字母转为大写形式
			strtoupper(date('is', time()).substr(uniqid('', true), 4, 4));

			该方法是订单处理的最后一步，也是最重要的一步，就是将订单数据写入订单表中
			由于付款方式统一修改为货到付款，因此这一步不再检查付款信息，只是将其标注为未付款状态
			直到生成包裹，并发货，用户收到货后支付完成，再将其订单中的付款状态修改为已付款，
			同时将订单状态修改为已完成，该订单处理过程结束
		*/
		public function subOrder() {

			//打印SESSION信息，查看字段
			//dump($_SESSION['cart']);exit;

			//获取用户方面的信息，查询用户表user
			$id = $_SESSION['user']['id'];

			//生成一个订单号
			$sn = strtoupper(date('is', time()).substr(uniqid('', true), 4, 4));

			//实例化订单-商品表
			$order_goods = M('order_goods');

			//声明一个空数组，用来存取商品的价格，这是PHP常有的做法，即用空数组来存储各种各样的值
			$arr = array();

			//获取商品信息，查询订单商品表order_goods，该信息储存在$_SESSION['cart']中，是一个二维数组
			foreach($_SESSION['cart'] as $goods) {

				/*
					$goods中存有每一件商品的详细信息，包括数量，将该商品写入到订单——商品表order_goods中
					该表中的重要键值是商品订单号键，该订单号用于搜索所有属于该订单的商品
					而订单商品表中，每一条记录仅仅记录一件商品的信息，也记录该商品的数量和常用信息
				*/
				foreach($goods as $key => $value) {
					$_POST['og'][$key] = $value;
				}

				/*
					每次遍历完成一个商品后需要修改重新赋值成成对应的字段，
					这是从购物车中遍历，但是修改订单时需要从订单商品表 中遍历
					需要用到用户该操作是否属于修改订单页面跳转过来的额标志字段，
					$_SESSION['item']['change'] = 1是否存在并且被赋值为1
					该步骤一旦执行完就要将该值清除掉
				*/
				if (isset($_SESSION['item']['change'])) {

					//说明是修改订单页面的操作，读取数据来源于订单商品表
					$_POST['og']['ordersn'] = $sn;
					$_POST['og']['goodsid'] = $_POST['og']['id'];
				} else {

					//读取数据来源于商品详情页的操作信息
					$_POST['og']['ordersn'] = $sn;
					$_POST['og']['goodsid'] = $_POST['og']['id'];
					$_POST['og']['catid'] = $_POST['og']['cid'];
					$_POST['og']['goodssn'] = $_POST['og']['goodssign'];
					$_POST['og']['name'] = $_POST['og']['goodsname'];
				}

				//每次将同一样商品的价格乘以数量算出该商品的总价格，存入数组中
				$arr[] = $_POST['og']['promoteprice'] * $_POST['og']['num'];
				

				//然后将该条商品信息写入到订单-商品表中，记住，该订单-商品表的订单编号是同一个值，属于一个订单
				unset($_POST['og']['id']);
				$order_goods -> create($_POST['og']);

				//调用add()方法直接写入到数据表中去，至此，同一个订单中的商品已经被订单号关联在一起
				$order_goods -> add();
			}

			//声明一个变量，用来存取总价格，将商品的价格累加后存入订单表中的总价格处
			$total = 0;

			foreach($arr as $price) {
				
				//将价格进行累加
				$total += $price;	
			}

			/*
				获取用户地址信息，查询结果已经存储到超全局数组$_SESSION['address']中
				如果该值没有被设置或不存在，则获取用户在常用收货地址中的默认地址，标志字段
				是状态status值为1，为0为非默认
			*/
			if (!isset($_SESSION['address']['id'])) {

				$place = M('user_address');
				$_SESSION['address'] = $place -> where("userid = '{$id}' AND status = '1'") -> find();
			} 

			//将用户的选择内容写入发票表receipt中，如果该选择有过操作，则超全局数组$_SESSION['receipt']等字段有值
			if (isset($_SESSION['receipt'])) {

				/*
					生成发票编号，计算方式为当前时间戳加上一个唯一函数生成的唯一id号，本身存在问题，有点号
					重新使用了 mt_rand()生成更好的随机数函数
					该表中的标识字段是用户当前登录并执行下单操作且填写过发票的用户id号
					一个用户可能有多个订单，但是每一个订单号唯一，因此和订单一起配合组成
					搭配的订单和发票
				*/
				$_SESSION['receipt']['ordersn'] = $sn;
				$_SESSION['receipt']['rec_sn'] = time().mt_rand();
				$_SESSION['receipt']['userid'] = $id;
				$_SESSION['receipt']['addtime'] = time();

				//实例化发票表v_receipt
				$rec = M('receipt');
				$rec -> create($_SESSION['receipt']);

				//add()方法操作后返回有效的最后主键id号
				$rec_lastid = $rec -> add();

			}

			//请求方法写入订单表，订单表是一张需要重复修改和确认的表，目前除了订单编号和用户id号、发票id号之外，所有值均为默认值，及无效值
			$_POST['order']['ordersn'] = $sn;
			$_POST['order']['userid'] = $id;
			$_POST['order']['receiptid'] = $rec_lastid;
			$_POST['order']['desc'] = $_SESSION['note_content'];
			$_POST['order']['shiptype'] = $_SESSION['ship']['ship_type'];
			$_POST['order']['paytype'] = $_SESSION['pay']['pay_type'];
			$_POST['order']['besttime'] = $_SESSION['ship']['ship_time'];
			$_POST['order']['addressid'] = $_SESSION['address']['id'];
			$_POST['order']['consignee'] = $_SESSION['address']['name'];
			$_POST['order']['total'] = $total;
			$_POST['order']['addtime'] = time();

			//默认提交的新订单都时新订单并且有效，当用户点击取消订单时将isuse字段设置为0
			$_POST['order']['isnew'] = 1;
			$_POST['order']['isuse'] = 1;

			$order = M('order');
			//var_dump($_POST['order']);
			$order -> create($_POST['order']);
			//var_dump($_POST['order']);die;
			$order_last_id = $order -> add();
			//echo "id=".$order_last_id;return;

			//如果订单表写入成功，则跳转到新订单页面，否则提示错误
			if ($order_last_id) {

				/*
					重定向到订单已经成功提交的新页面，从这里开始，订单正式进入第二个控制器，订单处理控制器中
					本页面将传递订单id号和订单编号
				*/
				$this -> redirect("orderAction/newOrder", array('orderid' => $order_last_id));
			} else {
				$this -> error("订单表写入失败",'',3);
			}
		}
	}