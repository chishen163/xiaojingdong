<?php if (!defined('THINK_PATH')) exit();?><!--
	我的购物车静态页面mycart.html
	时间：2014-08-02    21:24
-->
<!doctype html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="/test/fanke/Public/Home/Css/z_simple_header.css">
		<link rel="stylesheet" type="text/css" href="/test/fanke/Public/Home/Css/z_mycart.css">
		<link rel="stylesheet" type="text/css" href="/test/fanke/Public/Home/Css/z_order.css">
		<link rel="stylesheet" type="text/css" href="/test/fanke/Public/Home/Css/z_simple_footer.css">
		<script src="/test/fanke/Public/Home/Js/jquery.js"></script>
		<script src="/test/fanke/Public/Home/Js/PCASClass.js"></script>
	</head>
	<body>
		<div class="z_simple_head">
			<div class="z_simple_logo">
				<img src="/test/fanke/Public/Home/Images/z_vancl_logo.png" alt="" onclick="location.href='/test/fanke/index.php/Home/Index/index'">
			</div>
			<div class="z_simple_quick">
				<?php if($user_info['id'] > 0): ?><div class="z_wellcom">
					<p>您好<?php echo ($user_info['username']); ?>，欢迎光临凡客诚品</p>
				</div>
				<?php else: ?>
				<div class="z_login_register">
					<p><a href="">登录</a>|<a href="">注册</a></p>
				</div><?php endif; ?>
				<div class="z_help">
					<p><a href="">帮助中心</a></p>
				</div>
			</div>
		</div>

<!-- 我的购物车页面 -->
<div class="z_mycart_main">
	
	<!-- 快速定位进度条 -->
	<div id="z_step">
		<div class="z_step_status">
			<div class="z_status_left"><?php if($change == 1): ?>1.修改商品<?php else: ?>1.我的购物车<?php endif; ?></div>
			<div class="z_status_middle"><?php if($change == 1): ?>2.修改信息单<?php else: ?>2.填写核对信息单<?php endif; ?></div>
			<div class="z_status_right"><?php if($change == 1): ?>3.修改成功<?php else: ?>3.成功提交订单<?php endif; ?></div>
		</div>
	</div>

	<!-- 我的购物车快速预览信息 -->
	<div id="z_mycart_quick">
		<div class="z_cart_position">
			<div class="cart_image"></div>
			<div class="cart_sign"><?php if($userid > 0): ?>我的购物车<?php else: ?>临时购物车<?php endif; ?></div>
			<div class="cart_info"><?php if($userid > 0): else: ?>现在[登录]，您的选购清单将被记录。<?php endif; ?></div>
		</div>
		<div class="z_cart_notice">
			温馨提示：1.选购清单中的商品无法保留库存，请您及时结算。2.商品的价格和库存将以订单提交时为准。3.促销活动满减优惠将均摊至商品小计中。
		</div>
	</div>

	<!-- 购物车详细信息 -->
	<div id="z_mycart_content">
		<div class="cart_title">
			<span><input type="checkbox" value="顶部全选" name="" class="z_select_all" onclick="qx()">全选</span>
			<div>商品名称</div>
			<span>尺寸</span>
			<span>积分</span>
			<span>单价</span>
			<span>数量</span>
			<span>优惠</span>
			<span>小计</span>
			<span>操作</span>
		</div>
		<div class="cart_content">
			<div class="cart_need">
				<div><input type="checkbox" name="ids[]" value="" class="z_separate_good">以下商品由凡客诚品负责配送</div>
				<span>您目前可享受全场购物免运费</span>
			</div>
			<div class="cart_build">
				<div><input type="checkbox" name="ids[]" value="" class="z_separate_good">店铺： VANCL 凡客诚品旗舰店</div>
			</div>
			<div class="cart_content_list">

				<?php if(is_array($data)): foreach($data as $key=>$goods): ?><!-- 一个购物车一件商品的详细信息遍历开始 -->
					<div class="cart_list_info">
						<input type="checkbox" name="ids[]" value="<?php echo ($goods["id"]); ?>" class="z_separate_good z_goods">
						<div>
							<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" alt="" width="50">
							<span><?php echo ($goods["goodsname"]); ?></span>
						</div>
						<span><?php echo ($goods["size"]); ?></span>
						<span><?php echo ($goods["integral"]); ?>分</span>
						<span>￥<?php echo ($goods["goodsprice"]); ?>元</span>
						<span>
							<input class="z_info_left" id="isdisabled" type="text" value="-" readonly onclick="location.href='/test/fanke/index.php/Home/Cart/updateCart/id/<?php echo ($goods["id"]); ?>/num/-1'" />
							<input class="z_info_middle" type="text" value="<?php echo ($goods["num"]); ?>" />
							<input class="z_info_left" type="text" value="+" readonly onclick="location.href='/test/fanke/index.php/Home/Cart/updateCart/id/<?php echo ($goods["id"]); ?>/num/1'" />
						</span>
						<span>￥<?php echo ($goods["promoteprice"]); ?>元</span>
						<!-- ThinkPHP框架中运算时不支持点语法操作，一定要写成中括号的形式才支持算术计算 -->
						<span>￥<?php echo ($goods['promoteprice'] * $goods['num']); ?>元</span>
						<span>
							<a  class="z_a_con" href="javascript:mycol('<?php echo ($goods["goodsid"]); ?>')">收藏</a>
							<a class="z_a_con" href="/test/fanke/index.php/Home/Cart/del/id/<?php echo ($goods["goodsid"]); ?>">删除</a>
						</span>
					</div>

					<!-- 
						ThinkPHP框架又一个用法，在前台模板中自定义变量，使用内置标签assign，格式如下
						先定义变量，然后赋值，并且该值可以实现累加，达到求和的目的，在这里是求出商品
						的总价格和总数量，因为不在控制器中进行处理，出现在前台模板中，让我找了很久才
						学到这个方法，然后使用大括号加美元符直接引用就可以得到这个值
					 -->
					<?php $sum = $sum += $goods['num']; ?>
					<?php $total = $total += $goods['promoteprice'] * $goods['num']; ?>
				<!-- 购物车中一件商品的相关信息遍历结束 --><?php endforeach; endif; ?>

			</div>
		</div>

		<!-- 订单结算 -->
		<div class="cart_total">
			<div class="cart_total_left">
				<div><input type="checkbox" name="ids[]" value="底部全选" class="z_select_all z_separate_good" onclick="qx()"></div>
				<div >全选</div>
				<div>删除</div>
				<div>数量总计：<?php echo ($sum); ?>件</div>
				<div>产品金额总计(不含运费)：<font>￥<?php echo ($total); ?>元</font></div>
			</div>
			<div class="cart_total_middle" onclick="location.href='/test/fanke/index.php/Home/Index/index'"><<继续购物</div>
			<div class="cart_total_right" ><a href="/test/fanke/index.php/Home/Order/order"><?php if($change == 1): ?>下一步<?php else: ?>￥去结算>><?php endif; ?></a></div>
		</div>
	</div>

	<!-- 促销特惠商品 -->
	<div id="z_promote">
		<div class="promote_title">
			<div></div>
			<span>促销特惠商品</span>
		</div>
		<div class="promote_collect">

			<!-- 促销特惠商品一个框遍历的开始 -->
			<?php if(is_array($new_goods_data)): foreach($new_goods_data as $key=>$new): ?><div>
				<div class="z_collect_title">全场购买任意商品</div>
				<div class="z_collect_content">
					<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($new["goodsimg"]); ?>" alt="">
					<div class="collect_cat">
						<div><?php echo ($new["goodsname"]); ?></div>
						<div>促销价：￥<?php echo ($new["promoteprice"]); ?>元 商品价：￥<?php echo ($new["goodsprice"]); ?>元</div>
						<span class="collect_color">
							<span>颜色：</span>
							<div id="left_color_click">
								<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($new["goodsimg"]); ?>" alt="1">
								<!-- <img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="2">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="3">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="4">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt="">
								<img src="/test/fanke/Public/Home/Images/z_promote_color.jpg" alt=""> -->
							</div>
						</span>
						<div class="collect_size">
							<span>尺码：</span>
							<div id="left_size_click">
								<div><?php echo ($new["goodsSize"]); ?></div>
							</div>
						</div>
						<div id="left_result">你可选择：颜色<?php echo ($new["goodsColor"]); ?>和尺寸<?php echo ($new["goodsSize"]); ?></div>
						<button class="collect_button" onclick="location.href='/test/fanke/index.php/Home/Detial/detial/id/<?php echo ($new["id"]); ?>'">查看详情</button>
					</div>
				</div>
			</div><?php endforeach; endif; ?>
			<!-- 促销特惠商品遍历的结束 -->


		</div>
		<div class="promote_lower">
			<div class="z_lower_top">
				<!-- <div><span>1元以下区</span><img src="/test/fanke/Public/Home/Images/col_drop.png" alt=""></div>
				<div><span>5元以下区</span><img src="/test/fanke/Public/Home/Images/col_drop.png" alt=""></div> -->
				<div><span>99元以下区</span><img src="/test/fanke/Public/Home/Images/col_drop.png" alt=""></div>
				<!-- <div><span>更多优惠商品</span><img src="/test/fanke/Public/Home/Images/col_drop.png" alt=""></div> -->
			</div>
			<div class="z_lower_bottom">
				<img class="z_lb_left" src="/test/fanke/Public/Home/Images/z_prev.png">
				<div class="z_lb_middle">

					<!-- 一个小商品遍历的开始 -->
					<?php if(is_array($nine)): foreach($nine as $key=>$n): ?><div>
						<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($n["goodsimg"]); ?>" alt="">
						<div>
							<p><?php echo ($n["goodsname"]); ?>  <?php echo ($n["goodsColor"]); ?></p>
							<p>原价：￥<?php echo ($n["goodsprice"]); ?>元</p>
							<p>现价：￥<?php echo ($n["promoteprice"]); ?>元</p>
							<button onclick="location.href='/test/fanke/index.php/Home/Detial/detial/id/<?php echo ($n["id"]); ?>'">查看详情</button>
						</div>
					</div><?php endforeach; endif; ?>
					<!-- 一个小商品遍历的结束 -->

				</div>
				<img class="z_lb_right" src="/test/fanke/Public/Home/Images/z_next.png">
			</div>
		</div>
	</div>

	<!-- 最近浏览商品 -->
	<div id="z_lasty_look">
		<div class="z_last_title">
			<!-- <div>最近浏览商品</div>
			<div>推荐商品</div> -->
			<div>收藏夹</div>
		</div>
		<div class="z_last_content">

			<div class="z_lb_middle">

					<!-- 一个小商品遍历的开始 -->
					<?php if(is_array($arr)): foreach($arr as $key=>$col): ?><div>
						<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($col["goodsimg"]); ?>" alt="">
						<div>
							<p><?php echo ($col["goodsname"]); ?>  <?php echo ($col["goodsColor"]); ?></p>
							<p>原价：￥<?php echo ($col["goodsprice"]); ?>元</p>
							<p>现价：￥<?php echo ($col["promoteprice"]); ?>元</p>
							<button onclick="location.href='/test/fanke/index.php/Home/Detial/detial/id/<?php echo ($col["id"]); ?>'">查看详情</button>
						</div>
					</div><?php endforeach; endif; ?>
					<!-- 一个小商品遍历的结束 -->

				</div>

		</div>
	</div>
</div>

		<div class="z_simple_footer">
			<div class="z_copyright">
				<small>Copyright 2007 - 2014 vancl.com All Rights Reserved 京ICP证100557号 京公网安备11010102000579号 出版物经营许可证新出发京批字第直110138号</small>
			</div>
			<div class="z_safe_img">
				<div class="z_img_center">
					<img src="/test/fanke/Public/Home/Images/cert_redlogo.png" alt="">
					<img src="/test/fanke/Public/Home/Images/cert_costumeorg.gif" alt="">
					<img src="/test/fanke/Public/Home/Images/cert_wsjybzzx.png" alt="">
				</div>
			</div>
		</div>
	</body>
</html>
<script>
	//判断当商品数量为1时，禁用减少商品按钮，使其变为不可用状态
	if ($('.z_info_middle').val() == 1) {
		$('#isdisabled').attr('disabled', true);
	}

	//以下代码是获取颜色的部分
	var left_color = null;
	$('#left_color_click img').hover(function() {
		$(this).css({'cursor' : 'pointer'});
	});
	$('#left_color_click img').click(function() {
		$('#left_click img').css({'border' : ''});
		$(this).css({'border' : '1px solid #a10000'});
		left_color = $(this).attr('alt');
	});

	//以下代码是获取尺寸的部分
	var left_size = null;
	$('#left_size_click div').hover(function() {
		$(this).css({'cursor' : 'pointer'});
	});

	$('#left_size_click div').click(function() {
		$('#left_click div').css({'border' : ''});
		$(this).css({'border' : '1px solid #a10000'});
		left_size = $(this).text();
		
		if (left_color != null && left_size != null) {
			$('#left_result').text("你选择了："+left_color+'尺寸：'+left_size);
		}
	});

	//获得被选择商品id号函数
	function getIds() {

		/*
			此时需要通过js方式获取所有复选框的选中状态，并且获得其value值传递到控制器中去
			算法是：先获取满足条件input输入框的个数
			声明一个空数组用来存取每个输入框的id值
			通过for循环遍历出所有满足条件的id值
			注意要使用eq()来过滤，下标从0开始读取
			然后使用jQuery中的ajax请求控制器中的方法，将订单表中的字段修改为已付款状态
		*/
		var length = $('input[type=checkbox].z_goods:checked').length;
		var ids = new Array();
		for(var i = 0; i < length; i++) {
			ids[i] = $('input[type=checkbox].z_goods:checked').eq(i).val();
		}

		//返回一个数组给调用处
		return ids;
	}

	//全选函数
	function qx() {
		
		$('input[type=checkbox].z_separate_good').attr('checked', 'true');

		//先选中之后再次获取被选中状态的值，之后需要请求控制器中的方法单独计算一次价格
		var ids = getIds();
	}

	//确认收藏函数
	function mycol(id) {
		
		if (confirm("你确认要收藏该商品吗？")) {
			$.post("/test/fanke/index.php/Home/Cart/mycol", {id : id}, function(data) {
				alert(data);
			});
		}
	}
</script>