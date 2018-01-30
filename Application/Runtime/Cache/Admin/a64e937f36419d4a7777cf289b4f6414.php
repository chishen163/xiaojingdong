<?php if (!defined('THINK_PATH')) exit();?><!-- 
	顶部订单列表使用的搜索框，可以根据订单号进行搜索 
	注意：该页面的所有操作均在控制器Order中，直接请求该控制器中的方法就可

	该页面有一个逻辑联系，就是生成发货单之前一定要先生成包装，负责属于操作上的逻辑错误
-->
<!doctype html>
<html>
	<head>
		<title>订单列表页</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/Public/Admin/Css/bootstrap.css">
		<link rel="stylesheet" href="/Public/Admin/Css/z_order.css">
		<script src="/Public/Admin/Js/jquery.js"></script>
		<script type="text/javascript">
			$(function(){
				$("tr:odd").addClass("odd");  /* 奇数行添加样式*/
				$("tr:even").addClass("even"); /* 偶数行添加样式*/
			})
		</script>
		<style>
			.even { 
				background:#FFF38F;
			}  /* 偶数行样式*/
			.odd { 
				background:#FFFFEE;
			}  /* 奇数行样式*/
		</style>
	</head>
	<body>
		<div class="order_main">
			<div class="z_order_search">
				<div>
					<div class="z_input_ordersn">
						<span>输入订单号:</span><input  type="text" value="" name="ordersn">
					</div>
					<button class="order_search" onclick="search()">搜索</button>
				</div>
			</div>
			<div class="order_list">
				<div class="order_list_title">
					<div class="list_title_left">订单列表:</div>
					<div class="list_title_middle">
						<button onclick="select('use')">有效</button>
						<button onclick="select('notuse')">无效</button>
						<button onclick="select('notpay')">未付款</button>
						<button onclick="select('pay')">已付款</button>
						<button onclick="select('delivery')">已发货</button>
						<button onclick="select('end')">已完成</button>
						<button>全部</button>
					</div>
					<div class="list_title_right">
						<button>订单管理</button>
					</div>
				</div>
				<div class="order_list_content">
					<form>
					<table class="order_table table table-hover">
						<tr>
							<th>选择</th>
							<th>订单号</th>
							<th>收货人</th>
							<th>下单时间</th>
							<th>订单价</th>
							<th>配送费</th>
							<th>支付方式</th>
							<th>总计</th>
							<th>订单状态</th>
							<th>包装</th>
							<th>发货单</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($order_data)): foreach($order_data as $key=>$order): ?><tr>
								<td><input type="checkbox" name="ids[]" value="<?php echo ($order["id"]); ?>" class="order_status"></td>
								<td><a href="javascript:print('<?php echo ($order["id"]); ?>')"><?php echo ($order["ordersn"]); ?></a></td>
								<td><?php echo ($order["consignee"]); ?></td>
								<td><?php echo (date("Y-m-d H:i:s", $order["addtime"])); ?></td>
								<td><?php echo ($order["total"]); ?></td>
								<td>0.00</td>
								<td><?php echo ($order["paytype"]); ?></td>
								<td><?php echo ($order['total'] + 0); ?></td>
								<td class="status_layout">
									<input type="checkbox" <?php if($order['isnew'] == 1): ?>checked<?php endif; ?>>新订单
									<input type="checkbox" <?php if($order['isuse'] == 1): ?>checked<?php endif; ?>>有效
									<a href="javascript:"><input type="checkbox" <?php if($order['payid'] > 0): ?>checked<?php endif; ?>></a>已付款
									<input type="checkbox" <?php if($order['packid'] > 0): ?>checked<?php endif; ?>>已包装
									<input type="checkbox" <?php if($order['deliveryid'] > 0): ?>checked<?php endif; ?>>已生成发货单
									<input type="checkbox" <?php if($order['isshipping'] == 1): ?>checked<?php endif; ?>>已发货
									<input type="checkbox" <?php if($order['orderstatus'] == 1): ?>checked<?php endif; ?>>已完成
								</td>
								<td><a href="javascript:pack('<?php echo ($order["id"]); ?>')">生成包装</a></td>
								<td><a href="javascript:delivery('<?php echo ($order["id"]); ?>')">生成发货单</a></td>
								<td><a href="javascript:modify('<?php echo ($order["id"]); ?>')">修改</a>|<a href="javascript:del('<?php echo ($order["id"]); ?>')">删除</a></td>
							</tr><?php endforeach; endif; ?>
					</table>
					</form>
				</div>
				<div class="order_font_layout">
					<input type="button" value="全选" onclick="qx()">
					<input type="button" value="反选" onclick="fx()">
					<input type="button" value="全不选" onclick="qbx()">
					<input type="button" value="删除" onclick="dels()">
					<input type="button" value="设为已付款状态" onclick="paied()">
					<input type="button" value="设为已发货状态" onclick="shipped()">
					<input type="button" value="设为已完成状态" onclick="finished()">
				</div>
				<div class="order_font_layout" style="margin:10px 30px 30px 0px;border:1px solid #cccccc; "><?php echo ($page); ?></div>
			</div>
		</div>
	</body>
	<script>

		/*
			定义一个函数，用来局部动态请求该页面，每次点击页码时都是局部刷新操作，
			注意，不要自动调用一次该函数，否则会无限循环调用下去
			但是修改了框架中的分页类，重新改名为Page_ajax.class.php
			原分页类仍然是原名，不受影响
		*/
		function setPage(url) {
			$.get(url, function(data) {
				$('.order_main').html(data);
			});
		}

		/*
			全选，反选，全不选函数集合
			选中元素的方式$('input[type=checkbox].order_status')，过滤掉后面的状态按钮
		*/

		//全选函数
		function qx() {
			$('input[type=checkbox].order_status').attr('checked', 'true');
		}

		//反选函数
		function fx() {
			var length = $('input[type=checkbox].order_status').length;
			for(var i = 0; i < length; i++) {
				$('input[type=checkbox].order_status').eq(i).attr('checked', !$('input[type=checkbox].order_status').eq(i).attr('checked')) ;
			}
		}

		//全不选函数
		function qbx() {
			$('input[type=checkbox].order_status').removeAttr('checked');
		}

		//点击修改按钮时触发的函数
		function modify(id) {

			//将订单id号通过ajax请求发送后控制器的modify()方法中,将修改页面请求到当前主体div中
			$.post("/admin.php/Admin/Order/modify", {id : id}, function(data) {
				$('.order_main').html(data);
			});
		}

		//点击订单编号时触发该函数，该函数可以进行打印订单操作，同时将订单处理表中的字段设置为已打印
		function print(id) {

			$.post("/admin.php/Admin/Order/orderPrint", {id : id}, function(data) {
				$('.order_main').html(data);
			});
		}

		//因为设为已付款、已发货、已完成的取值操作一致，因此封装一个简单的函数，该函数返回一个数组
		function getIds() {

			/*
				此时需要通过js方式获取所有复选框的选中状态，并且获得其value值传递到控制器中去
				算法是：先获取满足条件input输入框的个数
				声明一个空数组用来存取每个输入框的id值
				通过for循环遍历出所有满足条件的id值
				注意要使用eq()来过滤，下标从0开始读取
				然后使用jQuery中的ajax请求控制器中的方法，将订单表中的字段修改为已付款状态
			*/
			var length = $('input[type=checkbox].order_status:checked').length;
			var ids = new Array();
			for(var i = 0; i < length; i++) {
				ids[i] = $('input[type=checkbox].order_status:checked').eq(i).val();
			}

			//返回一个数组给调用处
			return ids;
		}

		//点击生成包装时触发的方法
		function pack(id) {

			$.post("/admin.php/Admin/Order/pack", {id : id}, function(data) {
				$('.order_main').html(data);
			});
		}

		//点击生成发货单时触发的函数，这里有一个逻辑需要判断，生成发货单前必须先生成包装
		function delivery(id) {
			
			$.post("/admin.php/Admin/Order/delivery", {id : id}, function(data) {
				$('.order_main').html(data);
			});
		}

		//点击设为已付款状态时触发的函数
		function paied() {

			//调用自定义函数
			var ids = getIds();

			$.post("/admin.php/Admin/Order/changeStatus", {ids : ids, status : 'paied'}, function(data) {
				$('.order_main').html(data);
			});
		}

		//点击设为已发货状态时触发的函数
		function shipped() {

			//调用自定义函数getIds()
			var ids = getIds();

			$.post("/admin.php/Admin/Order/changeStatus", {ids : ids, status : 'shipped'}, function(data) {
				$('.order_main').html(data);
			});
		}

		//点击设为已完成状态时触发的函数
		function finished() {

			//调用自定义函数getIds()
			var ids = getIds();

			$.post("/admin.php/Admin/Order/changeStatus", {ids : ids, status : 'finished'}, function(data) {
				$('.order_main').html(data);
			});
		}

		/*
			当操作每个订单后面的快捷按钮时，应该能动态修改相应的字段值，
			虽然效率很低，但很常用，使用函数实现，每次附带传递一个状态值
			作为判断用户点击的是哪一个复选框
		*/

		//点击删除操作时触发的函数
		function dels() {

			//获得订单ids数组值
			var ids = getIds();

			if (confirm("删除该订单将连同订单下面的发票，包装和发货单、付款单、订单处理表、订单商品表中的数据记录也一并删除，你确认要删除吗?")) {
				
				$.post("/admin.php/Admin/Order/dels", {ids : ids}, function(data) {
					$('.order_main').html(data);
				});
			}
		}

		//订单处理中操作选项里的单条订单删除操作
		function del(id) {

			//获得到得值是订单id值，单条数据操作时批量数据操作的简单形式
			if (confirm("删除该订单将连同订单下面的发票，包装和发货单、付款单、订单处理表、订单商品表中的数据记录也一并删除，你确认要删除吗?")) {
				
				$.post("/admin.php/Admin/Order/dels", {id : id}, function(data) {
					$('.order_main').html(data);
				});
			}
		}

		//点击搜索时触发的方法
		function search() {
			
			//获取输入的订单号
			var ordersn = $('input[name=ordersn]').val();
			$.post("/admin.php/Admin/Order/search", {ordersn : ordersn}, function(data) {
				$('.order_main').html(data);
			});
		}

		//栏目快速筛选符合条件的项目
		function select(status) {

			$.post("/admin.php/Admin/Order/select", {status : status}, function(data) {
				$('.order_main').html(data);
			});
		}
	</script>
</html>