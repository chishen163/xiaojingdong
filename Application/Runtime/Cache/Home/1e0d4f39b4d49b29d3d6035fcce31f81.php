<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<title>我的订单页面</title>
		<meta charset="utf-8" /> 
		<link rel="stylesheet" href="/fanke/Public/Home/Css/header.css">
		<link rel="stylesheet" href="/fanke/Public/Home/Css/z_neworder.css">
		<link rel="stylesheet" href="/fanke/Public/Home/Css/footer.css">
		<script src="/fanke/Public/Home/Js/jquery.js"></script>
	</head>
	<body>
		<!-- 加载头文件 -->
			<!-- 回到顶部 -->
	<div style="right: 10px; bottom: 10px; position: fixed; z-index: 9999; display: block;">
		<a href="#">
			<div style="cursor: pointer;background-image:url(/fanke/Public/Home/Images/go2top.png);background-color:transparent;background-repeat:no-repeat;width:25px;height:90px"></div>
		</a>
	</div>

	<!-- 顶部信息栏 -->
	<div id="top">
		<div id="top_box">
			<!-- 左边登陆部分 -->
			<div id="top_box_left">

				<!-- 判断SESSION的值是否为空,若为空则未登录,否则为登录 -->
				<?php if($user["username"] == null): ?><span>您好, 欢迎光临凡客诚品!</span>
					<a href="/fanke/index.php/Home/User/login" class="login_reg">[&nbsp;&nbsp;登陆&nbsp;&nbsp;</a>|
					<a href="/fanke/index.php/Home/User/regedit" class="login_reg">&nbsp;&nbsp;注册&nbsp;&nbsp;]</a>
				<?php elseif($user["username"] != null): ?>
					<span>您好,&nbsp;<?php echo ($user["username"]); ?></span>
					<a href="/fanke/index.php/Home/Index/loginout" class="login_reg">&nbsp;退出登录</a> | <a href="/fanke/index.php/Home/User/login" class="login_reg">更换用户&nbsp;</a><?php endif; ?>
				　　
				<a href="/fanke/index.php/Home/myVancl/myvancl" target="_blank">我的订单</a>　
				<a href="javascript:void(0);" onclick="AddFavorite('我的网站',location.href)">收藏本站</a>
			</div>
			
			<!-- 右边部分 -->
			<div id="top_box_right">
				<!-- 我的凡客 -->
				<div class="my_vancl">
					<!-- //判断是否为登录用户 -->
					<?php if($user == null): ?><a href="/fanke/index.php/Home/MyVancl/login"class="mapDropTitle" target="_blank">我的凡客</a>
					<?php else: ?>
						<a href="/fanke/index.php/Home/MyVancl/myvancl"class="mapDropTitle" target="_blank">我的凡客</a><?php endif; ?>

					<div class="my_vancl_list">
						<ul class="mapDropList">
							<li onclick="location.href='/fanke/index.php/Home/myVancl/myvancl'">我的订单</li>
							<li onclick="location.href='/fanke/index.php/Home/myVancl/myvancl'">我的收藏</li>
							<li>积分管理</li>
						</ul>
					</div>
					<div class="vancl_list_img"></div>
				</div>

				<!-- 网站导航 -->
				<div class="my_vancl">
					<a href="javascript::" class="mapDropTitle">网站导航</a>
					<div class="my_vancl_list">
						<ul class="mapDropList">
							<li>网站联盟</li>
							<li>礼品卡</li>
							<li>资讯中心</li>
							<li>达人提现</li>
						</ul>
					</div>
					<div class="vancl_list_img"></div>
				</div>

				<!-- 帮助中心 -->
				<div class="my_vancl">
					<a href="javascript::" class="mapDropTitle">帮助中心</a>
					<div class="my_vancl_list">
						<ul class="mapDropList">
							<li>购物指南</li>
							<li>配送方式</li>
							<li>支付方式</li>
							<li>售后服务</li>
							<li>投诉建议</li>
							<li>在线客服</li>
						</ul>
					</div>
					<div class="vancl_list_img"></div>
				</div>
				<!-- 网站公告 -->
				<div class="my_vancl">
					<a href="javascript::" class="mapDropTitle">网站公告</a>
					<div class="my_vancl_list">
						<ul class="mapDropList">
							<li>网站公告</li>
							<li>重要提示</li>
						</ul>
					</div>
					<div class="vancl_list_img"></div>
				</div>
				
				<!-- 手机凡客 -->
				<div class="sjvancl">
					<a href="javascript:"></a>
				</div>

				<!-- 新浪 -->
				<div class="xinlang">
					<a href="javascript:"></a>
				</div>

				<!-- 微信 -->
				<div class="weixin">
					<a href="javascript:">
						<b></b>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- logo部分 -->
	<div id="logo">
		<div id="logo_left">
			<a href="/fanke/index.php"></a>
		</div>
		<div id="logo_center">
			<div class="logo_nav">
				<ul>
					<li class="check">凡客成品</li>
					<li class="">V+商城</li>
				</ul>
			</div>
			<div class="logo_search">
				<input type="text" class="search_input" name="search_input" placeholder="搜“牛津纺衬衫”，经典再升级">
				<input type="button" id="search_key">
			</div>
		</div>
		<div id="logo_right">
			<div class="shopping">
				<p>
					<a href="/fanke/index.php/Home/Cart/cart" class="shopping_link">
						购物车 (
							<span class="shopping_count">
								<?php if($gcount == null): ?>0
								<?php else: ?>
								<?php echo ($gcount); endif; ?>
							</span>
						) 件
					</a>
					<s></s>
				</p>

				<div class="shoppingList">
					<!-- 购物车为空时显示 -->
					<?php if($cart_info == null): ?><div class="shopru">
						<div class="shopPageNo">你的购物车中没有任何物品</div>
						<div class="shopPageImg"></div>
					</div>
					<?php else: ?>
					<!-- 购物车有值时显示商品信息 -->
					<div class="look_mygoods">
						<div class="last_add">最近加入商品：</div>
						<?php if(is_array($cart_info)): foreach($cart_info as $key=>$cart): $total = $total += $cart['goodsprice'] * $cart['num']; ?>
						<div class="one_good" alt="<?php echo ($cart["id"]); ?>">
							<img src="/fanke/Public/Home/Images/goods/<?php echo ($cart["goodsimg"]); ?>" alt="">
							<div>
								<p><?php echo ($cart["goodsname"]); ?></p>
								<br>
								<p>￥<b><?php echo ($cart["goodsprice"]); ?></b>元</p>
							</div>
							<!-- <span><a class="delGoods">删除</a></span> -->
						</div><?php endforeach; endif; ?>
						<div class="total_price">
							<span>共计(未计算促销折扣)</span>
							<span>￥<b><?php echo ($total); ?></b>元</span>
							<a href="/fanke/index.php/Home/Cart/cart" target="_blank">去购物车</a>
						</div>
					</div><?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<!-- 导航部分 -->
	<div id="nav_box">
		<div class="nav_left">
			<h2>
				<a>
					所有商品分类
				</a>
			</h2>
		</div>

		<div class="nav_sortBox">
			<ul>
				<?php if(is_array($food)): foreach($food as $key=>$cate): ?><li class="sortItem">
						<h3>
							<em class="itemIcon"></em>
							<s></s>
							<a href="/fanke/index.php/Home/Plate/index.html?id=<?php echo ($cate["id"]); ?>"><?php echo ($cate["navName"]); ?></a>
						</h3>
						<p class="allBox">
							<?php if(is_array($cate['menu'])): foreach($cate['menu'] as $key=>$menu): ?><a href="/fanke/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($menu['id']); ?>"><?php echo ($menu['listName']); ?></a><?php endforeach; endif; ?>
						</p>
					</li><?php endforeach; endif; ?>
			</ul>
		</div>



		<div class="nav_center">
			<ul class="main_nav">
				<!-- 循环遍历导航菜单 -->
				<li><a href="/fanke/index.php">首页</a></li>
				<?php if(is_array($nav)): foreach($nav as $key=>$nav): ?><li><a href="/fanke/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($nav["id"]); ?>"><?php echo ($nav["listName"]); ?></a></li><?php endforeach; endif; ?>
			</ul>
		</div>
		<div class="nav_right">
			<ul>    
    				<li><a href="javascript:">V码</a></li>
				<li><a href="javascript:">特惠</a></li>
				<li><a href="javascript:">团购</a></li>
				<li><a href="javascript:">限时抢</a></li>
				<li class="shop_V">
					<a href="javascript:"><span>V+商城</span><s></s></a>
				</li>
			</ul>
		</div>
	</div>

	<script>
		//判断购物车商品是否删除成功
		// $(".delGoods").click(function(){
		// 	$.get("/fanke/index.php/Home/Header/delGoods?delId="+$(".one_good").attr("alt"),function(data){
		// 		if(data > 0){
		// 			$(".one_good[alt='"+data+"']").fadeOut(500);
		// 		}else{
		// 			alert("删除失败！");
		// 		}
		// 	},"json");
		// });

		$.get("/fanke/index.php/Home/Header/getWeb",function(data){
			// alert(data);
			$("title").html(data['title']);
			$("meta[name='keywords']").attr("content",data['keywords']);
			$("meta[name='description']").attr("content",data['description']);
			$(".search_input").attr("placeholder",data["hotsearch"]);
			$(".footer-middle").html(data['copy']);
		},"json");

		//按下回车键
		$('.search_input').keypress(function(event){  
		    var keycode = (event.keyCode ? event.keyCode : event.which);  
		    if(keycode == 13){  
		        searchKey();    
		    }  
		}); 

		// 搜索选项菜单
		$(".logo_nav ul li").click(function(){
			$(this).addClass('check').siblings().removeClass('check');
		});

		// 搜索框选择
		$("input[name=search_input]").mouseover(function(){
			this.select();
		});


		var nav = $(".nav_sortBox");

		nav_show();

		$(".nav_left").hover(function(){
			nav.css("display","block");
		},function(){
			nav_show();
		});

		function nav_show(){
			$("title").attr("alt") == '1' ? nav.css("display","block") : sortBox();
		}

		function sortBox(){
			nav.hover(function(){
				nav.css("display","block");
			},function(){
				nav.css("display","none");
			});
		}


		// 收藏本站
		function AddFavorite(title, url) {
  			try {
				window.external.addFavorite(url, title);
			} catch (e) {
				try {
					window.sidebar.addPanel(title, url, "");
				} catch (e) {
						alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
					}
				}
		}

		$("#search_key").click(function(){
			searchKey();
		});

		function searchKey(){
			if($(".search_input").val() == ""){
				location.href = "/fanke/index.php/Home/Search/index";
			}else{
				location.href = "/fanke/index.php/Home/Search/index?key="+$(".search_input").val();
			}
		}
	</script>
	
		<!-- 顶部占位，留出一段空白位置 -->
		<div class="static_space"></div>

		<!-- 主体内容区域 -->
		<div id="neworder">
			
			<!-- 浏览订单部分 -->
			<div id="order_list">
				<div class="order_list_top">
					<div class="order_list_top_left">

						<!-- 表格上面的付款等提示 -->
						<div class="z_order_notice">
							<div>订单已提交成功，请您等待收货！</div>
							<span>下载客户端，随时查看订单状态。</span>
						</div>

						<!-- 订单详情表 -->
						<table>
							<tr class="z_tab_th">
								<th class="z_ordersn">订单号</th>
								<th class="z_ordersn">需支付金额</th>
								<th class="z_ordersn">支付方式</th>
								<th class="z_house">发货库房</th>
								<th class="z_ordersn">预计配送时间</th>
							</tr>

							<?php if(is_array($order_data)): foreach($order_data as $key=>$order): ?><!-- 一个订单中一件商品遍历的开始 -->
							<tr>
								<td class="z_ordersn"><?php echo ($order["ordersn"]); ?></td>
								<td class="z_ordersn"><?php echo ($order["total"]); ?></td>
								<td class="z_ordersn"><?php echo ($order["paytype"]); ?></td>
								<td  class="z_house_content">由凡客北京二店负责发货</td>
								<td class="z_ordersn">由北京凡客诚品负责配送</td>
							</tr>

							<!-- 妹遍历一次，就对订单中的价格累加一次 -->
							<?php $total = $total +=$order['total']; ?>
							<!-- 该订单中每件商品遍历的结束 --><?php endforeach; endif; ?>
							
						</table>
					</div>
					<div class="order_list_top_right">
						<img src="/fanke/Public/Home/Images/z_gzkf.png" alt="">
					</div>
				</div>
				<div class="order_list_bottom">
					<div class="bottom_notice">
						<div>请选择支付方式完成付款</div>
						<span>请在3小时内完成付款，否则订单将会被自动取消</span>
					</div>
					<div class="bottom_type">
						<div class="normal_pay_type">常用支付方式</div>
						<span class="all_pay_type">全部支付方式</span>
					</div>

					<div class="bottom_bank_quick">
						<div class="bank_list_quick">
							<!-- 银行列表，一排四张 -->
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/upico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/gsico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/zsico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/zgico.png" alt="" />
							</div>
							<!-- 第一排结束 -->
						</div>
					</div>

					<!-- 银行列表区域默认是影藏不显示的 -->
					<div class="bottom_bank">
						<div class="bank_title">银行或支付机构：</div>
						<div class="bank_list">

							<!-- 银行列表，一排四张 -->
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/upico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/gsico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/zsico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/zgico.png" alt="" />
							</div>
							<!-- 第一排结束 -->

							<!-- 银行列表，一排四张 -->
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/jsico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/nyico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/gfico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/xyico.png" alt="" />
							</div>
							<!-- 第二排结束 -->

							<!-- 银行列表，一排四张 -->
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/bjico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/ncico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/yzico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/jtico.png" alt="" />
							</div>
							<!-- 第三排结束 -->

							<!-- 银行列表，一排四张 -->
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/pfico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/szico_1.jpg" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/gdico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/msico.png" alt="" />
							</div>
							<!-- 第四排结束 -->

							<!-- 银行列表，一排四张 -->
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/zxico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/paico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/hzico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/nbico.png" alt="" />
							</div>
							<!-- 第五排结束 -->

						</div>

						<div class="bank_title">支付平台：</div>
						<div class="bank_list">

							<!-- 支付平台，一排四张 -->
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/alipayscancode.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/zfbico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/sjzfico.png" alt="" />
							</div>
							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/cftico.png" alt="" />
							</div>
							<!-- 第一排结束 -->

							<div>
								<div><input type="radio" name="bank" value="" /></div>
								<img src="/fanke/Public/Home/Images/Bank/tenpay_kuaijie1.jpg" alt="" />
							</div>
						</div>

					</div>
					<!-- 以上区域默认是不显示的 -->

					<!-- 支付按钮 -->
					<div class="bottom_pay">
						<div>
							<div class="need_info">您共需要为订单支付：</div>
							<div class="pay_money">￥<?php echo ($total); ?>元</div>
							<div class="to_pay">去付款</div>
						</div>
					</div>
				</div>
			</div>

			<!-- 订单操作快捷键部分 -->
			<div id="order_quick">
				<div class="order_quick_top">
					<div class="order_quick_bar">
						<span class="">您目前共有 10 积分，<b class="integral_eco">积分商城</b></span>
						<span class="second_status" onclick="location.href='/fanke/index.php/Home/myVancl/myvancl/id/1'">修改订单</span>
						<span class="second_status" onclick="location.href='/fanke/index.php/Home/myVancl/myvancl/id/1'">查看订单</span>
						<span class="second_status" onclick="location.href='/fanke/index.php/Home/Index/index'">继续购物</span>
					</div>
				</div>
				<div class="order_quick_bottom">点击最多:</div>
			</div>

			<!-- 购买以上商品的顾客还购买过 -->
			<div id="inner_goods">

				<!-- 一个盒子遍历的开始 -->
				<?php if(is_array($click_data)): foreach($click_data as $key=>$click): ?><div class="goods_position">
					<img class="goods_position_image" src="/fanke/Public/Home/Images/goods/<?php echo ($click["goodsimg"]); ?>" alt="" onclick="location.href='/fanke/index.php/Home/Detial/detial/id/<?php echo ($click["id"]); ?>'">
					<div class="goods_position_content">
						<p><?php echo ($click["goodsname"]); ?></p>
						<p><del>商品价：￥<?php echo ($click["goodsprice"]); ?>元</del></p>
						<p>促销价：￥<?php echo ($click["promoteprice"]); ?>元</p>
					</div>
				</div><?php endforeach; endif; ?>
				<!-- 一个盒子遍历的结束 -->

			</div>
		</div>

		<!-- 底部占位，留出一段空白位置 -->
		<div class="static_space"></div>

		<!-- 加载尾文件 -->
				<div class="footer">
			<div class="footer-top">
				<div class="ldiv">
					<div>
						<ul>
							<li><h3><span>|</span>关于凡客</h3></li>
							<li><a href="#">公司简介</a></li>
							<li><a href="#">加入VANCL</a></li>
							<li><a href="#">合作专区</a></li>
							<li><a href="#">联系我们</a></li>
							<li><a href="/fanke/index.php/Home/FriendLink/index">友情链接</a></li>
						</ul>
					</div>
					<div>
						<ul>
							<li><h3><span>|</span>新手指南</h3></li>
							<li><a href="#">账户注册</a></li>
							<li><a href="#">购物流程</a></li>
							<li><a href="#">大宗购物</a></li>
							<li><a href="#">网站地图</a></li>
							<li><a href="#">商家入驻</a></li>
						</ul>
					</div>
					<div>
						<ul>
							<li><h3><span>|</span>配送范围及时间</h3></li>
							<li><a href="#">国内配送</a></li>
							<li><a href="#">订单拆分</a></li>							
						</ul>
					</div>
					<div>
						<ul>
							<li><h3><span>|</span>支付方式</h3></li>
							<li><a href="#">在线支付</a></li>
							<li><a href="#">礼品卡及账户余额</a></li>
							<li><a href="#">其他支付方式</a></li>				
						</ul>
					</div>
					<div>
						<ul>
							<li><h3><span>|</span>售后服务</h3></li>
							<li><a href="#">退换贷政策</a></li>
							<li><a href="#">退换贷办理流程</a></li>
							<li><a href="#">退换贷网上办理</a></li>
							<li><a href="#">退款说明</a></li>
						</ul>
					</div>
					<div>
						<ul>
							<li><h3><span>|</span>帮助</h3></li>
							<li><a href="#">在线客服</a></li>
							<li><a href="#">找回密码</a></li>
							<li><a href="#">邮件订阅</a></li>
							<li><a href="#">产品册订阅</a></li>
							<li><a href="#">隐私声明</a></li>
						</ul>
					</div>
				</div>
				<div class="rdiv">
					<img src="/fanke/Public/Home/Images/erweima.jpg" alt="" />
					<span>火热下载中...</span>					
				</div>
				<span class="blank"></span>
				<div class="top1">
					<a href=""><img src="/fanke/Public/Home/Images/footer_1.jpg" alt=""></a>
					<a href=""><img src="/fanke/Public/Home/Images/footer_2.jpg" alt=""></a>
					<a href=""><img src="/fanke/Public/Home/Images/footer_3.jpg" alt=""></a>
					<a href=""><img src="/fanke/Public/Home/Images/footer_4.jpg" alt=""></a>
				</div>
				<span class="blank"></span>
			</div>
			<span class="blank1"></span>
			<div class="footer-middle">
				Copyright 2007 - 2014 vancl.com All Rights Reserved 京ICP证100557号 京公网安备11011502002400号 出版物经营许可证新出发京批字第直110138号
			</div>
			<span class="blank2"></span>
			<div class="footer-bottom">
				<div>
					<a href=""><img src="/fanke/Public/Home/Images/footer_11.jpg" alt=""></a>
					<a><img src="/fanke/Public/Home/Images/footer_12.jpg" alt=""></a>
					<a href=""><img src="/fanke/Public/Home/Images/footer_13.jpg" alt=""></a>
					<a href=""><img src="/fanke/Public/Home/Images/footer_14.jpg" alt=""></a>
					<a href=""><img src="/fanke/Public/Home/Images/footer_15.jpg" alt=""></a>
				</div>
			</div>
		</div>
	</body>
	<script>
		//银行列表的显示与影藏代码
		$('.all_pay_type').click(function() {
			$('.bottom_bank_quick').css('display', 'none');
			$('.bottom_bank').css('display', 'block');
		});

		$('.normal_pay_type').click(function() {
			$('.bottom_bank').css('display', 'none');
			$('.bottom_bank_quick').css('display', 'block');
		});
	</script>
</html>