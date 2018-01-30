<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<title>发表评论商品</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/fanke/Public/Home/Css/skim_order.css">
		<script src="/fanke/Public/Home/Js/jquery.js"></script>
	</head>
	<body>
		<div class="say">
			<div class="say_tit">
				<span>我要评价：</span>
			</div>
			<div class="say_con">
				<div class="con_left">
					<div>
						<p>订单号：<?php echo ($order_data["ordersn"]); ?></p>
						<p>购买时间：<?php echo (date("Y-m-d", $order_data["addtime"])); ?></p>
					</div>
				</div>
				<div class="con_right">

					<?php if(is_array($order_goods_data)): foreach($order_goods_data as $key=>$goods): ?><!-- 已购买商品遍历的开始 -->
					<div>
						<img src="/fanke/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" alt="">
						<div class="test_con">
							<p><?php echo ($goods["name"]); ?></p>
							<p><?php echo ($goods["color"]); ?></p>
							<p><?php echo ($goods["size"]); ?></p>
						</div>

						<input type="hidden" name="id" value="<?php echo ($goods["goodsid"]); ?>">
	
						<?php if(is_array($goods['have'])): foreach($goods['have'] as $key=>$have): ?><!-- 遍历评论和查看评论图标开始 -->
						<div class="test_btn">
							<?php if($have == 1): ?><img src="/fanke/Public/Home/Images/tplBTN.jpg" alt="查看评论" width="77" height="25" id="look_mycom">
							<?php else: ?>
								<img src="/fanke/Public/Home/Images/pjBTN.jpg" alt="发表评论" width="97" height="27" onclick="location.href='/fanke/index.php/Home/MyVancl/say/id/<?php echo ($goods["goodsid"]); ?>'"><?php endif; ?>
						</div>
						<!-- 遍历评论和查看评论图标结束 --><?php endforeach; endif; ?>

					</div>
					<!-- 已购买商品遍历的结束 --><?php endforeach; endif; ?>

				</div>

				<!-- 查看我的全部评价 -->
				<div class="mycom">
					
				</div>

			</div>
		</div>
	</body>
	<script>
		//点击查看评论时触发的函数，该函数请求该商品的用户评论表，重新加载
		$('#look_mycom').click(function() {

			//通过影藏表单获得该商品的id号
			var id = $('input[name=id]').val();

			$.post("/fanke/index.php/Home/MyVancl/myCom", {id : id}, function(data) {
				$('.mycom').html(data);
			});
		});
	</script>
</html>