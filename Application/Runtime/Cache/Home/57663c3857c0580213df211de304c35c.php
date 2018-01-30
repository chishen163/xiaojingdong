<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<title>我的订单</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/fanke/Public/Home/Css/skim_order.css">
		<script type="text/javascript" src="/fanke/Public/Home/Js/jquery.js"></script>
	</head>
	<body>
		<div class="order_main">
			<div class="order_title">
				<span>我的订单</span>
			</div>
			<div class="order_list">
				<div class="list_title_top">
					<div>全部订单</div>
					<div class="common_left">进行中</div>
					<div class="common_left">已完成</div>
					<div class="common_left">无效</div>
				</div>

				<?php if(is_array($order_data)): foreach($order_data as $key=>$order): ?><!-- 循环遍历的开始 -->
				<div class="order_table">
					<div class="table_title">
						<p class="order_total">订单总金额￥<?php echo ($order["total"]); ?>元</p>
						<p class="none_order"><?php if($order["isuse"] == 1): ?>有效订单<?php else: ?>无效订单<?php endif; ?></p>
						<p class="order_time"><?php echo (date("Y-m-d H:i:s", $order["addtime"])); ?></p>
					</div>
					<div class="table_list">
						<div class="tl_name">
							<span><a href="/fanke/index.php/Home/MyVancl/detail/id/<?php echo ($order["id"]); ?>"><?php echo ($order["ordersn"]); ?></a></span>

							<?php if(is_array($order['goodsimg'])): foreach($order['goodsimg'] as $key=>$img): ?><img src="/fanke/Public/Home/Images/goods/<?php echo ($img); ?>" alt="" width="50" heihgt="50"><?php endforeach; endif; ?>

						</div>
						<div class="tl_extr">
							<div class="tl_info">
								<p>应付：￥<?php echo ($order["total"]); ?></p>
								<p><?php echo ($order["paytype"]); ?></p>
								<p><?php echo ($order["consignee"]); ?></p>
							</div>
						</div>
						<div class="tl_extr">
							<div class="tl_info">
								<p><?php if(($order["isnew"] == 1) AND ($order["orderstatus"] == 0)): ?>等待收货<?php elseif($order["orderstatus"] == 1): ?>送达成功<?php endif; ?></p>
								<p><?php if($order["isuse"] == 1): ?>有效订单<?php else: ?>无效订单<?php endif; ?></p>
								<a href="/fanke/index.php/Home/MyVancl/detail/id/<?php echo ($order["id"]); ?>#pro_status"><p><?php if($order["isnew"] == 1): ?>订单跟踪<?php elseif($order["orderstatus"] == 1): ?>订单跟踪<?php endif; ?></p></a>
							</div>
						</div>
						<div class="tl_extr">
							<div class="tl_info">
								<p><?php if(($order["isnew"] == 1) AND ($order["orderstatus"] == 0) AND ($order["packid"] == 0)): ?><a href="/fanke/index.php/Home/Cart/cart/orderid/<?php echo ($order["id"]); ?>" target="_blank">修改订单</a><?php elseif(($order["isnew"] == 1) AND ($order["orderstatus"] == 0) AND ($order["packid"] > 0)): ?>正在配送<?php elseif($order["orderstatus"] == 1): ?><a href="/fanke/index.php/Home/MyVancl/point/id/<?php echo ($order["id"]); ?>">发表评论</a><?php endif; ?></p>
								<p><?php if($order["isuse"] == 0): ?><a href="/fanke/index.php/Home/Cart/cart/orderid/<?php echo ($order["id"]); ?>" target="_blank">购买</a><?php endif; ?></p>
								<p><?php if(($order["isnew"] == 1) AND ($order["orderstatus"] == 0)): ?><a href="/fanke/index.php/Home/myVancl/cancl/id/<?php echo ($order["id"]); ?>">取消订单</a><?php elseif($order["orderstatus"] == 1): ?><a href="/fanke/index.php/Home/Cart/cart/orderid/<?php echo ($order["id"]); ?>" target="_blank">再次购买</a><?php endif; ?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="space"></div>
				<!-- 循环遍历的结束 --><?php endforeach; endif; ?>
	
				<!-- 分页信息显示 -->
				<div class="order_fpage"><?php echo ($page); ?></div>
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
	</script>
</html>