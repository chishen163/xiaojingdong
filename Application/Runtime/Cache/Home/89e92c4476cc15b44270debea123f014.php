<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<title>我的收藏</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/fanke/Public/Home/Css/skim_order.css">
		<script type="text/javascript" src="/fanke/Public/Home/Js/jquery.js"></script>
	</head>
	<body>
		<div class="collect">
			<div class="col_title">
				<span>我的收藏（暂存架）</span>
			</div>
			<div class="col_con">
				<div class="col_notice">
					<div>
						<img src="/fanke/Public/Home/Images/ico_tips.png" alt="">关于我的收藏：遇到感兴趣的商品时，如果还没决定立即购买，或者商品暂时缺货，您可以先把它放入我的收藏，以便下次的查找与购买。
					</div>
				</div>

				<!-- 顶部分页和全选按钮 -->
				<div class="col_top_tit">
					<div class="quick_op">
						<div class="qx">
							<input type="button" value="全选" onclick="qx()">
							<input type="button" value="反选" onclick="fx()">
							<input type="button" value="全不选" onclick="qbx()">
							<input type="button" value="删除" onclick="del()">
						</div>
						<div class="page"><?php echo ($page); ?></div>
					</div>
					<div class="quick_look">
						<div>商品</div>
						<span>价格</span>
						<span>人气</span>
						<span>操作</span>
					</div>
				</div>

				<!-- 收藏商品列表 -->

				<?php if(is_array($collect_data)): foreach($collect_data as $key=>$collect): ?><!-- 一个商品收藏遍历的开始 -->
				<div class="col_bottom_con">
					<div class="col_div">
						<div class="col_goods">
							<div class="col_inp"><input type="checkbox" name="id" value="<?php echo ($collect["goodsid"]); ?>" class="collect_status"></div>
							<img src="/fanke/Public/Home/Images/goods/<?php echo ($collect["goodsimg"]); ?>" alt="">
							<div class="col_text">

								<!-- 使用a链接的属性，即打开新窗口的方式既可以避开ajax响应式分页 -->
								<p class="goods_tit"><a href="/fanke/index.php/Home/Detial/detial/id/<?php echo ($collect["goodsid"]); ?>" target="_blank"><?php echo ($collect["goodsname"]); ?> <?php echo ($collect["goodsColor"]); ?></a></p>
								<p>店铺: VANCL 凡客诚品旗舰店</p>
							</div>
						</div>
						<div class="col_price">
							<div class="col_price_p">￥<?php echo ($collect["goodsprice"]); ?>元</div>
						</div>
						<div class="col_price">
							<p class="col_people">查看评论（<?php echo ($collect["counts"]); ?>条）</p>
							<p class="col_people"><?php echo (date("Y-m-d", $collect["addtime"])); ?> 收藏</p>
						</div>
						<div class="col_price">
							<a href="/fanke/index.php/Home/Detial/detial/id/<?php echo ($collect["goodsid"]); ?>" target="_blank"><img src="/fanke/Public/Home/Images/gmbtn.jpg" alt="" class="col_img"></a>
							<p class="col_people" onclick="del('<?php echo ($collect["goodsid"]); ?>')">删除</p>
						</div>
					</div>
				</div>
				<!-- 一个收藏商品遍历的结束 --><?php endforeach; endif; ?>

				<!-- 底部分页和全选按钮 -->
				<div class="col_top_tit">
					<div class="quick_op">
						<div class="qx">
							<input type="button" value="全选" onclick="qx()">
							<input type="button" value="反选" onclick="fx()">
							<input type="button" value="全不选" onclick="qbx()">
							<input type="button" value="删除" onclick="dels()">
						</div>
						<div class="page"><?php echo ($page); ?></div>
					</div>
				</div>

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
				$('.collect').html(data);
			});
		}

		//全选
		function qx() {
			$("input[type=checkbox]").attr('checked', 'true');
		}

		//反选
		function fx() {
			var length = $('input[type=checkbox]').length;

			for(var i = 0; i < length; i++) {
				$('input[type=checkbox]').eq(i).attr('checked', !$('input[type=checkbox]').eq(i).attr('checked'));
			}
		}

		//全不选
		function qbx() {
			$("input[type=checkbox]").removeAttr('checked');
		}

		//获得商品id号函数
		function getIds() {

			/*
				此时需要通过js方式获取所有复选框的选中状态，并且获得其value值传递到控制器中去
				算法是：先获取满足条件input输入框的个数
				声明一个空数组用来存取每个输入框的id值
				通过for循环遍历出所有满足条件的id值
				注意要使用eq()来过滤，下标从0开始读取
				然后使用jQuery中的ajax请求控制器中的方法，将订单表中的字段修改为已付款状态
			*/
			var length = $('input[type=checkbox].collect_status:checked').length;
			var ids = new Array();
			for(var i = 0; i < length; i++) {
				ids[i] = $('input[type=checkbox].collect_status:checked').eq(i).val();
			}

			//返回一个数组给调用处
			return ids;
		}

		//点击批量删除商品时的操作
		function dels() {

			//获得商品id值数组
			var ids = getIds();
			
			$.post("/fanke/index.php/Home/MyVancl/collectDel", {ids : ids}, function(data) {
				$('.collect').html(data);
			});
		}

		//点击单条商品收藏信息删除时触发的函数
		function del(id) {

			$.post("/fanke/index.php/Home/MyVancl/collectDel", {id : id}, function(data) {
				$('.collect').html(data);
			});
		} 
	</script>
</html>