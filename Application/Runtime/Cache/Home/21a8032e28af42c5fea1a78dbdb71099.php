<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="/fanke/Public/Home/Css/z_simple_header.css">
		<link rel="stylesheet" type="text/css" href="/fanke/Public/Home/Css/z_mycart.css">
		<link rel="stylesheet" type="text/css" href="/fanke/Public/Home/Css/z_order.css">
		<link rel="stylesheet" type="text/css" href="/fanke/Public/Home/Css/z_simple_footer.css">
		<script src="/fanke/Public/Home/Js/jquery.js"></script>
		<script src="/fanke/Public/Home/Js/PCASClass.js"></script>
	</head>
	<body>
		<div class="z_simple_head">
			<div class="z_simple_logo">
				<img src="/fanke/Public/Home/Images/z_vancl_logo.png" alt="" onclick="location.href='/fanke/index.php/Home/Index/index'">
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

<div class="z_myorder_main">
	
	<!-- 快速定位进度条 -->
	<div id="z_step">
		<div class="z_step_status">
			<div class="z_status_rleft"><?php if($change == 1): ?>1.修改商品<?php else: ?>1.我的购物车<?php endif; ?></div>
			<div class="z_status_rmiddle"><?php if($change == 1): ?>2.修改信息单<?php else: ?>2.填写核对信息单<?php endif; ?></div>
			<div class="z_status_rright"><?php if($change == 1): ?>3.修改成功<?php else: ?>3.成功提交订单<?php endif; ?></div>
		</div>
	</div>

	<!-- 收货地址、配送方式、支付选择和礼品卡 -->
	<div class="myorder_address">
		<div>
			<span>收货地址：</span>
			<div class="add_order_address">
				<form action="/fanke/index.php/Home/Order/savePlace" method="post" class="z_new_address">
					<?php if(is_array($address)): foreach($address as $key=>$user_data): ?><p class="position"><input type="radio" name="position" value="<?php echo ($user_data["id"]); ?>" class="exists_place"  <?php if($user_data["status"] == 1): ?>checked<?php endif; ?>>
						<?php if($user_data == ''): ?>你还没有常用收货地址
						<?php else: ?>
							<?php echo ($user_data["country"]); ?> - <?php echo ($user_data["pname"]); ?> - <?php echo ($user_data["cname"]); ?>  - <?php echo ($user_data["county"]); ?>  <?php echo ($user_data["address"]); ?>  <?php echo ($user_data["zipcode"]); ?> (<?php echo ($user_data["name"]); ?> 收) <?php echo ($user_data["phone"]); endif; ?>
					</p><?php endforeach; endif; ?>
					<p><input type="radio" name="position" value="" id="new_place">添加新地址</p>
					<div class="is_write">
						<p>*收&nbsp;货&nbsp;人：<input type="text" name="name" placeholder="请输入收货人姓名"></p>
						<span class="z_msg"></span>
						<p>*地&nbsp;&nbsp;&nbsp;&nbsp;区：<select name="pname"></select><select name="cname"></select><select name="county"></select></p>
						<span class="z_msg"></span>
						<p>*详细地址：<input type="text" name="address" value="" class="detial_address"></p>
						<span class="z_msg"></span>
						<p>*邮政编码：<input type="number" name="zipcode" value=""></p>
						<span class="z_msg"></span>
						<p>*手&nbsp;&nbsp;&nbsp;&nbsp;机：<input type="number" name="phone" value="">座&nbsp;&nbsp;机：<input type="number" name="tel" value=""></p>
						<span class="z_msg"></span>
					<p><button class="address_save" type="submit">保存并配送到这个地址</button></p>
					</div>
				</form>
			</div>
		</div>

		<div>
			<span>配送方式：</span><a href="javascript:" class="z_modify">修改</a>
			<?php if(($ship_type != '') AND ($ship_time != '')): ?><p id="z_f_p" class="z_msg_content"><b>送货方式：</b><?php echo ($ship_type); ?>&nbsp;&nbsp;<b>送货时间：</b><?php echo ($ship_time); ?></p>
			<?php else: ?>
				<div class="add_option">
					<form action="/fanke/index.php/Home/Order/shipTime" method="post" id="position_info">
						<table class="z_table">
								<tr>
									<th>送货方式：</th>
									<td><input type="radio" name="ship_type" id="ship_type" value="快递" checked>快递</td>
								</tr>
								<tr>
									<th>送货时间：</th>
									<td><input type="radio" name="ship_time" value="周一周五、工作日均可送货" checked>周一周五、工作日均可送货</td>
								</tr>
								<tr>
									<th></th>
									<td><input type="radio" name="ship_time" value="周六、周日、假日送货">周六、周日、假日送货</td>
								</tr>
								<tr>
									<th></th>
									<td><input type="radio" name="ship_time" value="周一周六、假日均可送货">周一周六、假日均可送货</td>
								</tr>
								<tr>
									<th></th>
									<td><input type="radio" name="ship_time" value="校园配送（特别安排可能超出预计送货天数）">校园配送（特别安排可能超出预计送货天数）</td>
								</tr>
								<tr>
									<th></th>
									<td><button type="submit">确认配送方式</button></td>
								</tr>
								<tr>
									<th></th>
									<td>
										<b>声明</b>:1.送货时间：早8:30至晚7:30<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.我们会努力按照你选择的时间进行配送，但因天气、交通等因素的影响，你的订单有可能会有延迟现象，请您谅解!
									</td>
								</tr>
						</table>
					</form>
				</div><?php endif; ?>
		</div>

		<div>
			<span>支付方式：</span><a href="javascript:" class="z_modify">修改</a>
			<?php if($pay_type != ''): ?><p class="z_msg_content"><?php echo ($pay_type); ?></p>
			<?php else: ?>
				<div class="add_option">
				<form action="/fanke/index.php/Home/Order/payType" method="post">
					<table class="z_table_pay">
						<tr>
							<th>请选择支付方式</th><th></th><th></th>
						</tr>
						<tr>
							<td class="z_pay_select"><input type="radio" name="pay_type" value="在线" checked>在线支付</td>
							<td>在线支付支持支付宝、财付通及绝大多数银行借记卡和部分银行信用卡</td>
						</tr>
						<tr>
							<td class="z_pay_select"><input type="radio" name="pay_type" value="邮局汇款">邮局汇款</td>
							<td>请您下单后尽快到邮局汇款，同时在汇款单填写汇款金额、汇款人相关信息，并在附言栏注明订单号</td>
						</tr>
						<tr>
							<td class="z_pay_select"><input type="radio" name="pay_type" value="货到付款">货到付款</td>
							<td>支持货到付款，订单额过大时为安全考虑不支持使用大量现金</td>
						</tr>
						<tr>
							<td class="z_pay_select"><button type="submit">确认支付方式</button></td>
							<td></td>
						</tr>
					</table>
					</form>
				</div><?php endif; ?>
		</div>
	<div>
			<span>使用礼品卡：</span>
			<div class="use_card">
				<div>卡号：<input type="text" name=""></div><div>密码：<input type="password" name=""></div><button>使用礼品卡</button>
			</div>
			<div class="z_space"></div>
		</div>
	</div>

	<!-- 商品清单 -->
	<div class="myorder_order_info">
		<div class="mygoods_order">
			<a class="mygoods_o" href="javascript:">商品清单</a>
			<a class="mygoods_back_cart" href="/fanke/index.php/Home/Order/backCart">回到购物车，修改产品>></a>
		</div>
		<div class="myorder_info"><b>订单1</b>    将从上海二库发出，预计发货后3天内送达</div>
		<div class="myorder_content">
			<p>店铺: VANCL 凡客诚品旗舰店</p>
			<div>
				<table class="myorder_list">
					<tr class="myorder_th"><th>商品名称</th><th>尺码</th><th>赠送积分</th><th>单价</th><th>数量</th><th>优惠</th><th>小计</th></tr>

					<?php if(is_array($goods_info)): foreach($goods_info as $key=>$order): ?><tr class="myorder_tr">
							<td class="myorder_td"><?php echo ($order["goodsname"]); ?></td>
							<td><?php echo ($order["size"]); ?></td>
							<td><?php echo ($order["integral"]); ?></td>
							<td>￥<?php echo ($order["promoteprice"]); ?></td>
							<td><?php echo ($order["num"]); ?></td>
							<td><?php echo ($order["promoteprice"]); ?></td>
							<td>￥<?php echo ($order['promoteprice'] * $order['num']); ?></td>
						</tr>
						<?php $total = $total += $order['promoteprice'] * $order['num']; endforeach; endif; ?>

					<!-- 商品金额小计 -->
					<tr><td colspan="7" class="myorder_total">商品金额小计:￥<?php echo ($total); ?>   +  运费:￥<?php echo ($shipping = 0); ?>   =  应付:￥<?php echo ($total + $shipping); ?></td></tr>
				</table>
			</div>
		</div>
	</div>

	<!-- 订单备注、开发票和提交订单 -->
	<div class="myorder_order_note">
		<div><span>您共需要为订单支付：￥<?php echo ($total + $shipping); ?>元</span></div>
		<div>
			<div class="order_note_vote">
				<div id="z_order_sign">+订单备注</div><span class="sign_vote"><?php echo ($note_content); ?></span>
				<form action="/fanke/index.php/Home/Order/userSign" method="post" id="frm_sign">
					<textarea rows='4' cols="80" id="note_place" name="note_content">此处请勿填写有关配送、支付等方面的信息，留言请在50字以内</textarea>
				</form>
				<div id="give_vote">+开发票</div>
				<span class="sign_vote">
					<?php if($user_type != ''): ?><b>客户类型：</b><?php echo ($user_type); ?>&nbsp;&nbsp;<b>发票抬头：</b><?php echo ($receipt_title); ?>&nbsp;&nbsp;<b>发票内容：</b><?php echo ($receipt_content); endif; ?>
				</span>
				<form action="/fanke/index.php/Home/Order/getReceipt" method="post" id="z_frm_vote">
					<p class="frm_title">你需要开具发票吗？<input type="radio" name="z_need" value="1">是&nbsp;&nbsp;<input type="radio" name="z_need" value="0" checked>否</p>
					<p>*客户类型<select name="user_type" id="">
						<option value="个人">个人</option>
						<option value="公司">公司</option>
						<option value="个体工商户">个体工商户</option>
						<option value="外籍">外籍</option>
						<option value="港澳台">港、澳、台</option>
					</select></p>
					<p>*发票抬头<input type="text" name="receipt_title"></p>
					<p>*发票内容<select name="receipt_content" id="">
						<option value="服装">服装</option>
						<option value="鞋">鞋</option>
						<option value="家居">家居</option>
						<option value="配饰">配饰</option>
						<option value="化妆品">化妆品</option>
						<option value="家电">家电</option>
						<option value="箱包">箱包</option>
						<option value="明细">明细</option>
					</select></p>
					<p><input type="submit" value="保存" class="save_receipt"></p>
				</form>
			</div>
			<div class="sub_myorder" onclick="location.href='/fanke/index.php/Home/Order/subOrder'"><?php if($change == 1): ?>提交修改<?php else: ?>提交订单<?php endif; ?></div>
		</div>
	</div>

</div>

		<div class="z_simple_footer">
			<div class="z_copyright">
				<small>Copyright 2007 - 2014 vancl.com All Rights Reserved 京ICP证100557号 京公网安备11010102000579号 出版物经营许可证新出发京批字第直110138号</small>
			</div>
			<div class="z_safe_img">
				<div class="z_img_center">
					<img src="/fanke/Public/Home/Images/cert_redlogo.png" alt="">
					<img src="/fanke/Public/Home/Images/cert_costumeorg.gif" alt="">
					<img src="/fanke/Public/Home/Images/cert_wsjybzzx.png" alt="">
				</div>
			</div>
		</div>
	</body>
</html>

<script>
	//实例化一个省市级三级联动下拉选项框，关于该插件的说明：详见视图目录
	new PCAS("pname","cname","county");

	/*
		该两段JS是用来处理是否获取用户常用收货地址和添加新地址的显示与影藏用
	*/
	$('.exists_place').click(function() {
		$('.exists_place').parent().removeClass('select_exists_place');
		$(this).parent().addClass('select_exists_place');
		$('.is_write').css('display', 'none');
		var newid = $(this).val();
		$.post("/fanke/index.php/Home/Order/newAddress", 'newid='+newid);
	});

	$('#new_place').click(function() {
		$('.exists_place').parent().removeClass('select_exists_place');
		$('.is_write').css('display', 'block');
	});

	$('.z_modify').click(function() {
		if($('.z_modify').text() == '修改') {
			$('.z_modify').text('添加');
			$('#z_f_p').hide();
			$('#position_info').css('display', 'block');
		} else {
			$('.z_modify').text('修改');
		}
	});

	$('#z_order_sign').click(function() {
		$('#frm_sign').css('display', 'block');
	});

	$('#note_place').focus(function() {
		$('#note_place').val('');
	});

	//其实这个请求是成功的
	$('#note_place').blur(function() {
		var note_content = $('#note_place').val();
		$.post("/fanke/index.php/Home/Order/userSign", 'note_content='+note_content);
	});

	$('#give_vote').click(function() {
		$('#z_frm_vote').show();
	});
</script>