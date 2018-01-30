<?php
	namespace Home\Controller;
	use Think\Controller;

	class PayController extends Controller {

		//启动支付功能，需要提供事务处理支持
		public function pay() {
		
			//接收传递过来的订单编号和付款额数
			$ordersn = $_POST['ordersn'];
			$pay = $_POST['pay'];

			//获取用户名，模拟当前登录用户
			$name = 'zhgxun';

			//获取管理员姓名admin
			$admin_name = 'admin';

			//实例化两张表，模拟付款和扣款，功能是从test_pay表中向admin_pay表中转钱
			$admin = M('admin_pay');
			$test = M('test_pay');

			//开启事务处理机制
			$admin -> startTrans();

			//首先从test_pay表中扣去pay数量的钱
			$test_data = $test -> where("name = '{$name}'") -> find();

			//需要判断余额减去扣款之后必须满足大于0才能执行
			if ($test_data && $test_data['money'] > $pay) {
				
				$data['money'] = $test_data['money'] - $pay;
				$new_test = $test -> where("name = '{$name}'") -> save($data);

				//如果扣款失败，则直接退出
				if ($new_test) {

						//张三扣款成功，需要向管理员转账
						$admin_data = $admin -> where("name = '{$admin_name}'") -> find();

						if ($admin_data) {
							$data['money'] = $admin_data['money'] + $pay;
							$new_admin = $admin -> where("name = '{$admin_name}'") -> save($data);

							//如果管理员收款成功，则提示付款成功，否则需要回滚事务
							if ($new_admin) {
								$admin -> commit();

								//将信息写入付款表中作为记录需要修改订单处理表和订单表中的字段
								$pay_tab = M('pay');

								//生成付款编号
								$sn = time().rand(10000, 99999);
								$arr['ordersn'] = $ordersn;
								$arr['paysn'] = $sn;
								$arr['name'] = $name;
								$arr['payfee'] = $pay;
								$arr['addtime'] = time();
								$arr['isonline'] = 0;
								$pay_tab -> create($arr);
								$pay_tab_data = $pay_tab -> add();

								//如果付款表写入成功，则将付款表信息写入订单表中
								if ($pay_tab_data) {

									$order = M('order');
									$payid['payid'] = $pay_tab_data;
									$payid['ispay'] = 1;
									$order_data = $order -> where("ordersn = '{$ordersn}'") -> save($payid);

									//如果订单表写入成功，继续写入订单处理表
									if ($order_data) {

										//修改订单处理表中的数据
										$order_action = M('order_action');
										$is_pay['is_pay'] = 1;
										$order_action_data = $order_action -> where("ordersn = '{$ordersn}'") -> save($is_pay);

										//如果订单处理表写入成功，付款过程可以结束
										if (!$order_action_data) {

											//订单处理表写入失败
											echo '订单处理表写入失败';
										}
									} else {

										//订单表写入失败
										echo '订单表写入失败';
									}
								} else {

									//付款表写入失败
									echo '付款表写入失败';
								}

								//付款成功
								echo '付款成功';
							} else {
								$admin -> rollback();

								//管理员收款失败，事务回滚
								echo '管理员收款失败，事务回滚';
							}
						} else {
							//管理员余额查询失败
							echo '管理员余额查询失败';
						}
				} else {
					//张三扣款失败
					echo '张三扣款失败';
				}
			} else {
				//查询张三余额失败
				echo '查询张三余额失败';
			}
		}
	}