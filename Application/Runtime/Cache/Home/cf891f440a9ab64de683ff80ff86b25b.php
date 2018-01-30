<?php if (!defined('THINK_PATH')) exit();?><!-- 
	商品详情页z_detail.html
	时间：2014-08-01    10:30
 -->
 <!doctype html>
 <html>
 	<head>
		<link rel="stylesheet" href="/test/fanke/Public/Home/Css/header.css">
		<link rel="stylesheet" href="/test/fanke/Public/Home/Css/z_detial.css">
		<link rel="stylesheet" href="/test/fanke/Public/Home/Css/jquery.jqzoom.css">
		<link rel="stylesheet" href="/test/fanke/Public/Home/Css/footer.css">
		<script src="/test/fanke/Public/Home/Js/jquery.js"></script>
		<script src="/test/fanke/Public/Home/Js/jquery.raty.js"></script>

		<!-- 图片放大镜插件 -->
		<script src="/test/fanke/Public/Home/Js/jquery.jqzoom-core.js"></script>

		<!-- 页面弹出一个遮盖层插件 -->
		<script src="/test/fanke/Public/Home/Js/EV_Mode.js"></script>
 	</head>
 	<body>
			<!-- 回到顶部 -->
	<div style="right: 10px; bottom: 10px; position: fixed; z-index: 9999; display: block;">
		<a href="#">
			<div style="cursor: pointer;background-image:url(/test/fanke/Public/Home/Images/go2top.png);background-color:transparent;background-repeat:no-repeat;width:25px;height:90px"></div>
		</a>
	</div>

	<!-- 顶部信息栏 -->
	<div id="top">
		<div id="top_box">
			<!-- 左边登陆部分 -->
			<div id="top_box_left">

				<!-- 判断SESSION的值是否为空,若为空则未登录,否则为登录 -->
				<?php if($user["username"] == null): ?><span>您好, 欢迎光临凡客诚品!</span>
					<a href="/test/fanke/index.php/Home/User/login" class="login_reg">[&nbsp;&nbsp;登陆&nbsp;&nbsp;</a>|
					<a href="/test/fanke/index.php/Home/User/regedit" class="login_reg">&nbsp;&nbsp;注册&nbsp;&nbsp;]</a>
				<?php elseif($user["username"] != null): ?>
					<span>您好,&nbsp;<?php echo ($user["username"]); ?></span>
					<a href="/test/fanke/index.php/Home/Index/loginout" class="login_reg">&nbsp;退出登录</a> | <a href="/test/fanke/index.php/Home/User/login" class="login_reg">更换用户&nbsp;</a><?php endif; ?>
				　　
				<a href="/test/fanke/index.php/Home/myVancl/myvancl" target="_blank">我的订单</a>　
				<a href="javascript:void(0);" onclick="AddFavorite('我的网站',location.href)">收藏本站</a>
			</div>
			
			<!-- 右边部分 -->
			<div id="top_box_right">
				<!-- 我的凡客 -->
				<div class="my_vancl">
					<!-- //判断是否为登录用户 -->
					<?php if($user == null): ?><a href="/test/fanke/index.php/Home/MyVancl/login"class="mapDropTitle" target="_blank">我的凡客</a>
					<?php else: ?>
						<a href="/test/fanke/index.php/Home/MyVancl/myvancl"class="mapDropTitle" target="_blank">我的凡客</a><?php endif; ?>

					<div class="my_vancl_list">
						<ul class="mapDropList">
							<li onclick="location.href='/test/fanke/index.php/Home/myVancl/myvancl'">我的订单</li>
							<li onclick="location.href='/test/fanke/index.php/Home/myVancl/myvancl'">我的收藏</li>
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
			<a href="/test/fanke/index.php"></a>
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
					<a href="/test/fanke/index.php/Home/Cart/cart" class="shopping_link">
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
							<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($cart["goodsimg"]); ?>" alt="">
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
							<a href="/test/fanke/index.php/Home/Cart/cart" target="_blank">去购物车</a>
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
							<a href="/test/fanke/index.php/Home/Plate/index.html?id=<?php echo ($cate["id"]); ?>"><?php echo ($cate["navName"]); ?></a>
						</h3>
						<p class="allBox">
							<?php if(is_array($cate['menu'])): foreach($cate['menu'] as $key=>$menu): ?><a href="/test/fanke/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($menu['id']); ?>"><?php echo ($menu['listName']); ?></a><?php endforeach; endif; ?>
						</p>
					</li><?php endforeach; endif; ?>
			</ul>
		</div>



		<div class="nav_center">
			<ul class="main_nav">
				<!-- 循环遍历导航菜单 -->
				<li><a href="/test/fanke/index.php">首页</a></li>
				<?php if(is_array($nav)): foreach($nav as $key=>$nav): ?><li><a href="/test/fanke/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($nav["id"]); ?>"><?php echo ($nav["listName"]); ?></a></li><?php endforeach; endif; ?>
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
		// 	$.get("/test/fanke/index.php/Home/Header/delGoods?delId="+$(".one_good").attr("alt"),function(data){
		// 		if(data > 0){
		// 			$(".one_good[alt='"+data+"']").fadeOut(500);
		// 		}else{
		// 			alert("删除失败！");
		// 		}
		// 	},"json");
		// });

		$.get("/test/fanke/index.php/Home/Header/getWeb",function(data){
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
				location.href = "/test/fanke/index.php/Home/Search/index";
			}else{
				location.href = "/test/fanke/index.php/Home/Search/index?key="+$(".search_input").val();
			}
		}
	</script>

		<!-- 页面主体区域内容 -->
		<div id="z_main">

			<!-- 面包屑导航区：首页》男装》卫衣... -->
			<div id="z_detial_nav">
				<!-- <ul>
					<li><a href="#">首页</a></li><span>></span>
					<li><a href="#">男装</a></li><span>></span>
					<li><a href="#">卫衣</a></li><span>></span>
					<li><a href="#">开衫卫衣</a></li><span>></span>
					<li><a href="#">轻柔棉感时尚连帽马甲 男</a></li>
				</ul> -->
			</div>
			
			<!-- 商品详情展示区：主体商品图片、大图浏览、购买和价格详情处 -->
			<div id="z_goods_show">

				<!-- 商品和标题显示部分 -->
				<div id="z_show_title">
					<div id="z_title"><?php echo ($goods["goodsname"]); ?> <span>特惠 直降<?php echo ($goods['goodsprice'] - $goods['promoteprice']); ?>元</span></div>
					<div id="z_goods_number">商品编号:<?php echo ($goods["goodssign"]); ?></div>
				</div>

				<!-- 商品主要展示区 -->
				<div id="z_show_box">

					<!-- 左部快速浏览区 -->
					<div id="show_box_left">
						<span class="z_zoom_top"></span>
						<div class="zoom_small_1">
							<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" alt="" width="70" height="70">
						</div>
						<!-- <div class="zoom_small_2"></div>
						<div class="zoom_small_3"></div>
						<div class="zoom_small_4"></div>
						<div class="zoom_small_5"></div> -->
						<span class="z_zoom_bottom"></span>
					</div>

					<!-- 中间放大特效图 -->
					<div id="show_box_middle">

						<!-- 调用放大镜效果插件处 -->
						<a href="/test/fanke/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" width="800" heihgt="800" class="jqzoom" title="">
							<img id="z_d_default_1" src="/test/fanke/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" title="" width="400" heihgt="400">
						</a>
						<div id="z_middle_share">
							<a href="">点击分享:</a>
							<span>

								<!-- 调用商品收藏夹使用遮盖插件处 -->
								<a href="javascript:collect(<?php echo ($goods["id"]); ?>)" id="mycollect">收藏商品</a>
								<a href="">放大查看</a>
							</span>
						</div>

						<!-- 收藏商品影藏框 -->
						<div class="use_collect" id="EV_Mode_plug">
							<div class="collect_goods">
								<div>
									<div id="collect_msg"></div>
									<a href="/test/fanke/index.php/Home/MyVancl/myvancl"><div class="collect_look">查看收藏夹>></div></a>

									<!-- 该图标是关闭当前窗口时调用插件中的方法 -->
									<div class="collect_close" onclick="EV_closeAlert()"></div>
								</div>
								<div>
									<div class="collect_notice">您还可以通过添加标签为商品分类，或添加邮箱订制</div>
									<div class="collect_look">余量通知</div>
								</div>
								<div>
									<div class="collect_tag"></div>
									<div class="collect_look">收藏标签</div>
								</div>
								<div>
									<div class="collect_check"></div>
									<div class="collect_look">余量通知</div>
								</div>
							</div>
							<hr />
							<div class="like_goods">
								<div>
									<span class="similar_goods">看过该商品的人还购买过</span>
									<span class="more_goods"><a href="">更多您可能喜欢的商品>></a></span>
								</div>
								<div class="collect_order">
									<div>
										<img src="/test/fanke/Public/Home/Images/z_collect_example.jpg" alt="">
										<div>
											<p>秋之北纬 4韩版女装小清新简约风紫色收腰雪纺连衣裙001CPP-1 紫色</p>
											<p>售价￥79.00</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- 收藏商品影藏框结束位置 -->

					</div>

					<!-- 右边商品购买快速详情预览部分 -->
					<div id="show_box_right">

						<!-- 商品品牌 -->
						<div id="z_right_first">
							<div id="z_f_left">VANCL 凡客诚品旗舰店</div>
							<div id="z_f_right"> 商品品牌：VANCL 凡客诚品</div>
						</div>

						<!-- 商品价格等信息 -->
						<div id="z_right_second">
							<div id="z_s_price">特惠价：￥<?php echo ($goods["promoteprice"]); ?>元</div>
							<div id="z_s_market"> 市场价：<i>￥<?php echo ($goods["goodsprice"]); ?>元</i> &nbsp;&nbsp;售价：￥<?php echo ($goods["goodsprice"]); ?> 元</div>
							<div id="z_s_service">配送服务：下单后立即发货，由凡客诚品负责配送并开具发票</div>
							<div id="z_s_score"> 用户评分： (<?php echo ($count); ?>人已评论) </div>
						</div>

						<!-- 颜色、尺码、数量和购物车快速操作区 -->
						<div id="z_right_third">

							<!-- 颜色 -->
							<div id="z_t_color">
								<div id="z_color_left"><span>颜色:</span></div>
								<div class="z_color_right">
									<span>
										<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" alt="" width="35" height="35">
										<div><?php echo ($goods["goodsColor"]); ?></div>
									</span>
									<!-- <span>
										<img src="" alt="">
										<div>浅灰色</div>
									</span>
									<span>
										<img src="" alt="">
										<div>浅灰色</div>
									</span>
									<span>
										<img src="" alt="">
										<div>浅灰色</div>
									</span>
									<span>
										<img src="" alt="">
										<div>浅灰色</div>
									</span> -->
									
								</div>
									<div class="z_color_right">
									<!-- <span>
										<img src="/test/fanke/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" alt="" width="35" height="35">
										<div>浅灰色</div>
									</span> -->
								</div>
							</div>

							<!-- 尺码 -->
							<div id="z_t_size">
								<div id="z_size_left">尺码:</div>
								<div id="z_size_middle">
									<div><?php echo ($goods["goodsSize"]); ?></div>
								</div>
								<div id="z_size_right"><a href="#look_tab_size">查看尺码表</a></div>
							</div>

							<!-- 一个影藏的购物车盒子开始 -->
							<div class="z_show_cart_page">
								<div class="z_page_title">
									<span>商品成功放入购物车</span>
									<div id="z_page_close">关闭</div>
								</div>
								<div class="z_page_content">
									<span>
										<div class="z_content_left_cart">
											<img src="" alt="">
											<div>
												<p></p>
												<p></p>
											</div>
										</div>
										<div class="z_content_right_continue">
											<div><a href=""><<继续购物</a></div>
											<span><a href="/test/fanke/index.php/Home/Detial/gocart">去购物车>></a></span>
										</div>
									</span>
									<div>
										<span>
											<p>购买过该商品的人还购买过</p>
											<span>你可能喜欢的商品>></span>
										</span>
										<div>
											<div>
												<img src="/test/fanke/Public/Home/Images/z_cart_default_last.jpg" alt="">
												<div>
													<p>经典质感花纱短袖POLO(男款) 花纱绿色</p>
													<p>售价￥101.00</p>
												</div>
											</div>
											<div></div>
											<div></div>
											<div></div>
											<div></div>
										</div>
									</div>
								</div>
							</div>
							<!-- 影藏的购物车盒子结束 -->

							<!-- 数量 -->
							<div id="z_t_num">
								<div id="z_num_left">数量:</div>
								<div id="z_num_right">
									<input id="need_num" type="number" min="1" value="1">
								</div>
								<span class="notice_msg"></span>
							</div>

							<!-- 已选购信息 -->
							<div id="z_t_sel">
								<div id="z_sel_left">已选:</div>
								<div id="z_sel_right"></div>
							</div>

							<!-- 购物车图标 -->
							<div id="z_t_car">
								<div id="z_car_view"><a href="javascript:">放入购物车</a></div>
							</div>
						</div>
					</div>
				</div>

				<!-- 优惠提示支付和区域选择部分 -->
				<div id="z_pay">
					<hr  class="z_pay_line" />
					<span id="z_pay_notice">优惠提示:免运费</span>
					<hr  id="z_p_line" />

					<!-- 支付和地区选择 -->
					<div id="z_p_zone">
						<div id="z_zone_left">支付:</div>
						<div id="z_zone_middle">
							<a href="">货到付款(部分地区)</a>&nbsp;|
							<a href="">在线支付</a>&nbsp;|
							<a href="">邮局汇款</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 商品详情页，包括左边快速浏览页 -->
			<div id="z_goods_detial">

				<!-- 看过此商品的用户最终购买了以下一些商品 -->
				<div class="z_fast_left">
					
					<div class="z_fast_top">点击次数最多的商品</div>

					<!-- 对上一小标题所作的关联商品列表，限制5项遍历 -->
					<div class="z_fast_bottom">

						<!-- 15.7%的用户购买本商品，还有相关信息页面展示的一个小标题 -->
						<div class="z_fast_notice"></div>

						<!-- 一个完整的小区块 -->
						<?php if(is_array($click_data)): foreach($click_data as $key=>$click): ?><div class="z_finial_buy">
							<img class="z_b_images" src="/test/fanke/Public/Home/Images/goods/<?php echo ($click["goodsimg"]); ?>" alt="" onclick="location.href='/test/fanke/index.php/Home/Detial/detial/id/<?php echo ($click["id"]); ?>'" />
							<div class="z_b_content">
								<div class="z_content_sty">共点击<?php echo ($click["clickcount"]); ?>次</div>
								<div class="z_content_sty"><?php echo ($click["goodsname"]); ?> <?php echo ($click["goodsColor"]); ?></div>
								<div class="z_content_sty">商品价￥<?php echo ($click["goodsprice"]); ?>元 促销价￥<?php echo ($click["promoteprice"]); ?>元</div>
							</div>
						</div><?php endforeach; endif; ?>
						<!-- 结束位置 -->

					</div>
				</div>

				<!-- 页面右边部分栏目布局总盒子，商品详情页以下的所有栏目均在该盒子中 -->
				<div id="z_detial_right">

					<!-- 针对商品详情信息的解析，各种图片和商品信息 -->
					<div id="z_goods_images">

						<!-- 盒子顶部的四个选项：最新提问、最新评论、售后服务和如何购买快捷菜单 -->
						<div id="z_images_top">
							<div>最新提问(<?php echo ($newcount); ?>)</div>
							<div>最新评论(<?php echo ($count); ?>)</div>
							<div>售后服务</div>
							<div>如何购买</div>
						</div>

						<!-- 该商品的各种图片展示 -->
						<div id="z_watch_images">
							<!-- 产品描述 -->
							<div class="z_product_desc new_dash">
								<div class="z_desc_bottom">产品描述：</div>
								<div class="z_desc_unique">简洁时尚的男款马甲，采用环保时尚的毛圈卫衣面料，更加清爽舒适，是春夏秋季节的搭配首选单品。采用当下最时尚的合体修身剪裁，优质的YKK撞色金属拉链，提升整件衣服的品质感。</div>
								<div class="z_desc_bottom z_desc_color">温馨提示:此款产品蓝绿色内里为抓绒材质，其他颜色内里为毛圈材质。</div>
							</div>

							<!-- 产品属性 -->
							<div class="z_product_desc">
								<div class="z_desc_bottom">产品属性：</div>
								<div class="z_desc_value">
									<div>人群：男</div>
									<div>季节：四季</div>
									<div>袖长：无袖</div>
									<div>花色：纯色</div>
									<div>成分：棉+聚酯纤维</div>
								</div>
								<div class="z_desc_bottom z_desc_color new_notice">
									<span>洗涤说明</span>
									<div>
										<div class="new_img1"></div>
										<div class="new_img2"></div>
										<div class="new_img3"></div>
										<div class="new_img4"></div>
										<div class="new_img5"></div>
										<div class="new_img6"></div>
										<div class="new_img7"></div>
									</div>
								</div>
							</div>

							<!-- 产品尺码表 -->
							<!-- 增加一个锚链接 -->
							<a href="" name="look_tab_size"></a>
							<div class="size_tab">
								<div class="tab_tit">产品尺码表：（单位:cm）</div>
								<div class="tab_con">
									<table>
										<tr class="bold_tit">
											<td>号型</td>
											<td>尺码</td>
											<td>腰围</td>
											<td colspan="8">成品规格表(单位CM)</td>
										</tr>
										<tr>
											<td>身高/净腰围</td>
											<td>英寸</td>
											<td>市尺(仅供参考)</td>
											<td>腰围</td>
											<td>臀围</td>
											<td>大腿围</td>
											<td>膝围</td>
											<td>脚口围</td>
											<td>前浪</td>
											<td>后浪</td>
											<td>外长</td>
										</tr>
										<tr>
											<td>155/62A</td>
											<td>25</td>
											<td>1尺9寸</td>
											<td>68.5</td>
											<td>83.5</td>
											<td>49.4</td>
											<td>33</td>
											<td>27.6 </td>
											<td>20</td>
											<td>31</td>
											<td>98</td>
										</tr>
										<tr>
											<td>160/64A</td>
											<td>26</td>
											<td>2尺</td>
											<td>71</td>
											<td>86</td>
											<td>50.6</td>
											<td>34</td>
											<td>28.4</td>
											<td>20</td>
											<td>31</td>
											<td>99</td>
										</tr>
										<tr>
											<td>160/66A</td>
											<td>27</td>
											<td>2尺05</td>
											<td>73.5</td>
											<td>88.5</td>
											<td>51.8</td>
											<td>35</td>
											<td>29.2</td>
											<td>20.5</td>
											<td>31.5</td>
											<td>100</td>
										</tr>
										<tr>
											<td>165/70A</td>
											<td>28</td>
											<td>2尺1寸5</td>
											<td>76</td>
											<td>91</td>
											<td>53</td>
											<td>36</td>
											<td>30</td>
											<td>20.5 </td>
											<td>31.5</td>
											<td>101</td>
										</tr>
										<tr>
											<td>165/72A</td>
											<td>29 </td>
											<td>2尺2寸</td>
											<td>78.5</td>
											<td>93.5</td>
											<td>54.2</td>
											<td>37</td>
											<td>30.8</td>
											<td>21</td>
											<td>32</td>
											<td>102</td>
										</tr>
										<tr>
											<td>170/74A</td>
											<td>30</td>
											<td>2尺3寸</td>
											<td>81</td>
											<td>96</td>
											<td>55.4</td>
											<td>38</td>
											<td>31.6</td>
											<td>21</td>
											<td>32</td>
											<td>103</td>
										</tr>
										<tr>
											<td>170/76A</td>
											<td>31 </td>
											<td>2尺3寸5 </td>
											<td>83.5</td>
											<td>98.5 </td>
											<td>56.6</td>
											<td>39</td>
											<td>32.4 </td>
											<td>21.5</td>
											<td>32.5</td>
											<td>104</td>
										</tr>
										<tr>
											<td>175/80A</td>
											<td>32</td>
											<td>2尺4寸5 </td>
											<td>86</td>
											<td>101</td>
											<td>57.8</td>
											<td>40</td>
											<td>33.2</td>
											<td>21.5 </td>
											<td>32.5</td>
											<td>105</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>

					<!-- 空盒子，该主题结束的标志分隔符 -->
					<div class="z_images_end"></div>
					
					<!-- 使用include加载用户评价部分页面，该页面已被分离出去 -->
					<div class="comment_include">
						<!-- 该商品评论的总体信息，快速浏览，具体信息在下面 -->
<div id="z_comment">
	<div id="z_comment_top">
		<a href="" class="zc_good_comm">商品评论（共<?php echo ($count); ?>名用户）</a>
		<a href=""> 我要评论</a>
		<a href="" class="zc_right">所有打分及评论均来自已购买本产品的用户</a>
	</div>
	<div id="z_comment_middle">
		<div id="z_cmiddle_left">评价</div>
		<div id="z_cmiddle_right">
		<!-- 	<div  class="z_cmr_st">尺码</div>
		<div class="z_cmr_sr">86%的用户认为尺码<合适></div>
		<div class="z_cmr_sr">1%的用户认为尺码<偏小></div>
		<div class="z_cmr_sr">13%的用户认为尺码<偏大></div> -->
		</div>
	</div>
	<div id="z_comment_bottom">
		<div id="zb_left">
			<span>大家都在说：</span>
		</div>
		<div id="zb_right">
			<div>挺好看的</div>
			<div>快递很快</div>
			<div>穿着挺舒服</div>
			<div>颜色漂亮</div>
			<div>尺码正好</div>
			<div>手感很好</div>
			<div>质量没得挑</div>
			<div>价格便宜</div>
			<div>性价比一般</div>
			<div>颜色不喜欢</div>
		</div>
	</div>
</div>

<!-- 商品评价的三个选项：好评、中评和差评 -->
<div id="comment_option">
	<span class="new_com">最新评论(<?php echo ($count); ?>)</span>
	<span>好评()</span>
	<span>中评()</span>
	<span>差评()</span>
</div>

<a href="" name="anchor_comment"></a>

<div class="need_ajax">
<!-- 商品评论信息遍历区域，限制10个 -->
<?php if(is_array($comment_data)): foreach($comment_data as $key=>$comment): ?><!-- 遍历开始 -->
<div class="z_discuss">
	<div class="z_discuss_left">
		<!-- 默认头像 -->
		<img class="zdl_image" src="/test/fanke/Public/Home/Images/z_comment_vancl.jpg" alt="" />
		<span><?php echo ($comment["email"]); ?></span>
		<span><?php if($user["userrank"] == 0): ?>普通会员<?php else: echo ($user["userrank"]); endif; ?></span>
		<span>省份</span>
		<span><a href="javascript:ourCom('<?php echo ($comment["email"]); ?>', '<?php echo ($comment["goodsid"]); ?>')">该用户的评论>></a></span>
	</div>
	<div class="z_discuss_right">
		<div class="z_dright_top">
			
				<div class="score_font">评分：</div>
				<div class="raty_place"></div>
				<!-- <img src="/test/fanke/Public/Home/Images/z_fav.gif" alt="">
				<img src="/test/fanke/Public/Home/Images/z_fav.gif" alt="">
				<img src="/test/fanke/Public/Home/Images/z_fav.gif" alt="">
				<img src="/test/fanke/Public/Home/Images/z_fav.gif" alt="">
				<img src="/test/fanke/Public/Home/Images/z_fav.gif" alt=""> -->
			
			<p>颜色：浅花灰  尺码：L</p>
			<p>身高：<?php echo ($comment["height"]); ?>	体重：<?php echo ($comment["weight"]); ?>    该用户认为实际尺码：[<?php echo ($comment["comfort"]); ?>]</p>
		</div>
		<div class="z_dright_middle">
			<div class="zdright_mleft">评价:</div>
			<div class="zdright_mright">
				<p>
					<?php echo ($comment["content"]); ?>
				</p>
			</div>
		</div>
		<div class="z_dright_bottom">
			<div class="zbottom_left">这条评论对我：</div>
			<div class="zbottom_middle">
				<span><a href="">有用(0)</a></span>
				<span><a href="">没用(0)</a></span>
				<span><a href="">我要回复(0)</a></span>
			</div>
			<div class="zbottom_right">评论时间 <?php echo (date("Y/m/d H:i:s", $comment["addtime"])); ?></div>
		</div>
	</div>
</div>
<!-- 遍历结束 --><?php endforeach; endif; ?>
</div>

<!-- 针对评价部分的分页控制信息 -->
<div id="z_page">
	<div class="comment_page"><?php echo ($cpage); ?></div>
</div>
<script>
	/*
		一个简单的算法，通过JS字符串函数split()将字符串分割成数组和
		数组函数pop()弹出数组最后一个元素进行浏览器地址的分割处理
		最后得到浏览器地址中的id值，用于jQuery向控制器进行异步请求
	*/
	function goodsid() {
		var str = location.pathname;
		str = str.split('/');
		str = str.pop();

		return str;
	}

	var goodsid = goodsid();

	//点击查看我所有的评论时请求的函数
	function ourCom(email, id) {
		$.post("/test/fanke/index.php/Home/Detial/ourCom", {email : email, id : id}, function(data) {
			$('.comment_include').html(data);
		});
	}

	var cid = $('input[type=hidden]').val();
	//加载星级插件时使用的方法
	$('.raty_place').raty(
		{path: '/test/fanke/Public/Home/Images/img'}
	);

	//星级插件的默认宽度是100px，但有时候是无法堆叠在一起，需要使用jQuery的方式动态修改星级插件的div宽度
	$('.raty_place').css('width', '110px');

	/*
		找到问题所在了，即是分页的页码不变，只要页码变化，请求就成功了
		捣鼓了一个下午，最后实现了一步刷新请求这个功能，鸡肋的是居然需要点击两次才能
		触发成功。也就是说，第一次点击请求a标签，第二次请求才发送数据到控制器中去
		暂时先这样
	*/

	
</script>
					</div>

					<!-- 一个简单的投票评价：满意、一般、不满意 -->
					<div id="z_vote">
						<span class="z_vote_left">您在使用“商品页”时？</span>
						<span class="z_vote_right">
							<input type="radio" name="notice">满意
							<input type="radio" name="notice">一般
							<input type="radio" name="notice">不满意
							<input type="button" value = "提交">
						</span>
					</div>

					<!-- 该主题结束的标志分隔符 -->
					<div class="z_images_end"></div>
					
					<!-- 加载用户提问咨询内容部分 -->
					<div class="question_include">
						<!-- 对该商品的提问和回答区域 -->
<div id="z_answer">

	<!-- 最新提问，总体条数等 -->
	<div id="z_answer_top">
		<div class="z_answer_top_left"> 最新提问 共<?php echo ($newcount); ?>条</div>
		<div class="z_answer_top_right">
			<div class="z_answer_sort">
				<span class="z_sort_word">排序方式:</span>
				<select name="">
					<option value="">更新时间</option>
					<option value="">回复次数</option>
				</select>
			</div>
			<div class="z_myquestion">我要提问</div>
		</div>
	</div>

	<!-- 提问和回答区域，对话实现 -->

	
	<?php if(empty($question_data)): ?><div class="z_dt_dd"><span class="noquestion_notice">该商品暂时还没有提问</span></div><?php endif; ?>

	<?php if(is_array($question_data)): foreach($question_data as $key=>$question): ?><!-- 遍历开始 -->
	<div class="z_dt_dd">
		<div class="z_dd z_dt_top">
			<span class="z_dt_padding"><?php echo ($question["email"]); ?>问：</span>
			<span class="z_dt_common"><?php echo (date("Y/m/d H:i:s", $question["ctime"])); ?></span>
			<span class="z_dt_myre" name="<?php echo ($question["id"]); ?>">我要回复</span>
		</div>
		<div class="z_dd z_dt_second"><?php echo ($question["content"]); ?></div>
		<div class="z_dd z_dt_middle">管理员<?php echo ($question["adminname"]); ?>回答：</div>
		<div class="z_dd z_dt_end"><?php echo ($question["answer"]); ?></div>
	</div>

	<!-- 定义一个锚点位置，用于表单处理完毕后返回到此处 -->
	<a href="" name="myreply"></a>

	<!-- 展示回复区域位置 -->
	<div class="show_reply" name="<?php echo ($question["id"]); ?>">
		<!-- <div class="sr_title">
			<div class="name_say"><b>1234回复说：</b></div>
			<div class="reply_time">1234</div>
		</div>
		<div class="sr_content">
			<p>234567</p>
		</div> -->
	</div>

	<!-- 我要回复操作 -->
	<form method="post" action="">
	<div class="myrequest" name="<?php echo ($question["id"]); ?>">
		<input type="hidden" name="authorid" value="<?php echo ($question["id"]); ?>">
		<div class="my_tit">发表回复</div>
		<textarea name="content" class="re_con" id="<?php echo ($question["id"]); ?>" cols="30" rows="10"></textarea>
		<div class="re_btn">
			<input type="button" value="回复" class="ajax_reply">
			<input type="button" value="关闭" class="close_frm">
		</div>
	</div>
	</form>
	<!-- 遍历结束 --><?php endforeach; endif; ?>

	<!-- 用来显示分页的盒子 -->
	<div class="q_page"><?php echo ($page); ?></div>
</div>

<!-- 这里是我要提问的内容录入框，默认影藏该框 -->
<div id="z_myquestion_edit">
	<form action="" method="post" id="question_frm">
	<div id="z_question_title">
		<div id="question_img">
				<div></div>
				<span>提问：</span>
		</div>
		<div id="question_gname">
			<?php echo ($goods["goodsname"]); ?>
		</div>
	</div>
	<div id="z_question_container">
		<div id="question_con_left">
			<div>提问类型：</div>
			<div>提问内容：</div>
		</div>
		<div id="question_con_right">
			<div>
				<span><input type="radio" name="question" value="商品提问">商品提问</span>
				<span><input type="radio" name="question" value="促销活动提问">促销活动提问</span>
				<span><input type="radio" name="question" value="库存及物流提问">库存及物流提问</span>
				<span><input type="radio" name="question" value="售后提问">售后提问</span>
				<span id="qt_msg"></span>
			</div>
			<span>
				<textarea name="question_content" id="q_editor" cols="80" rows="5"></textarea>
				<span id="qc_msg"></span>
				<div onclick="question()"></div>
				<span id="q_result">取消关闭</span>
			</span>
		</div>
	</div>
	</form>
</div>
<!-- 我要提问部分结束 -->

<script>
	//将该字段声明为全局，整个脚本有效的变量
	var name = null;

	//点击我要回复时，获取到该条提问信息的id值，作为name变量的值，在所有遍历出来的盒子中，暂时只有它是惟一的，通过他可以找到具体的盒子
	$('.z_dt_myre').click(function() {
		
		//获取当前被点击元素的name值，用来确定需要显示的回复区域框位置
		name= $(this).attr('name');

		/*
			属性值是可以通过变量的方式来指定的
			这里根据每一条提问的id号来定位和我要回复相对应的回复区域框
			获取方式是通过指定两个盒子的name值，并且该值是提问的id值
			方式是alert($('.myrequest[name='+name+']').attr('name'));
			然后让相应的回复区域框显示出来就可以了
		*/
		$('.myrequest').css('display', 'none');
		$('.myrequest[name='+name+']').css('display', 'block');
	});

	//必须使用ajax请求来动态更新数据，该方法发送数据去控制器中，写入数据表储存起来
	$('.ajax_reply').click(function() {

		//获取到影藏表单的value值，即是该条提问信息的id值
		var questionid = $('input[value='+name+']').val();

		//获得提问内容
		var content = $('textarea[id='+name+']').val();

		$.post("/test/fanke/index.php/Home/Detial/myReply", {authorid: questionid, content : content}, function(data) {
			if (data == 'yes') {

				//调用函数，将信息读取出来显示在列表中
				getMsg();
			} else {

				//回复失败
				alert('回复失败');
			}
		});
	});

	//自定义一个函数用来显示回复数据的信息
	function getMsg() {

		//获取到影藏表单的value值，即是该条提问信息的id值，该id值是回复表中的父类id值，通过它可以判断每一条回复信息的显示
		var questionid = $('input[value='+name+']').val();

		$.post("/test/fanke/index.php/Home/Detial/getReply", {authorid : questionid}, function(data) {

			//每一次都要让它已有的数据清空
			$('.show_reply[name='+name+']').html('');

			//请求大数据量时需要使用循环遍历json格式的数据
			var length = data.length;
			for (var i = 0; i < length; i++) {
				$('.show_reply[name='+name+']').append('<div class="sr_title"><div class="name_say">'+(i+1)+'、<b>'+data[i].email+'回复说：</b></div><div class="reply_time">'+data[i].addtime+'</div></div><div class="sr_content"><p>'+data[i].content+'</p></div>');
			}			
		}, 'json');
	}

	//增加一个周期性事件，用于动态获取回复数据信息，每隔两秒钟获取一次数据
	/*setInterval(function() {
		getMsg();		
	}, 2000);*/

	//关闭弹出的表单输入区域
	$('.close_frm').click(function() {
		$('.myrequest').css('display', 'none');
	});

	/*
		一个简单的算法，通过JS字符串函数split()将字符串分割成数组和
		数组函数pop()弹出数组最后一个元素进行浏览器地址的分割处理
		最后得到浏览器地址中的id值，用于jQuery向控制器进行异步请求
	*/
	function goodsid() {
		var str = location.pathname;
		str = str.split('/');
		str = str.pop();

		return str;
	}

	var goodsid = goodsid();

	//用户提问处代码，显示提问编辑区域
	$('.z_myquestion').click(function() {
		$('#z_myquestion_edit').css('display', 'block');
	});

	/*
		用户点击提交问题时触发的函数，该 函数将判断编辑区域中的内容
		符合要求后发送到PHP端进行处理，一个用户对同一个商品可以有多个提问
	*/
	function question() {

		//声明一个变量，用来作为用户是否修改该字段的标志，默认为假值
		var qt = false;

		//获取提问类型中被选中的项的val值
		var q_type = $('#question_frm input:checked').val();

		//判断该值是否已被定义，如果未被定义，则输出提示信息
		if (typeof(q_type) == 'undefined') {

			$('#qt_msg').css({color : 'red'});
			$('#qt_msg').text("请选择提问类型");
		} else {

			//否则该值已被定义，去除样式，并把标志值修改为真值
			$('#qt_msg').css({color : ''});
			$('#qt_msg').text("");
			qt = true;
		}

		//声明一个标志变量，用来确认提问内容的输入情况，默认为假
		var qc = false;

		//获取提问内容
		var q_content = $('#q_editor').val();

		//判断，如果提问内容不为空，就认为是输入了提问，否则输出提示信息
		if (q_content == '') {

			$('#qc_msg').css({color : 'red'});
			$('#qc_msg').text("请输入提问内容");
		} else {

			//说明有提问内容，清除样式，将标志值修改为真值
			$('#qc_msg').css({color : ''});
			$('#qc_msg').text("");
			qc = true;
		}

		/*
			如果提问类型和提问内容均有值存在，再执行提交功能
		*/
		if (qt == true && qc == true) {

			//通过JS自定义函数获取商品id,提问类型和内容传递给控制器处理，使用json格式
			$.post("/test/fanke/index.php/Home/Detial/question", {goodsid : goodsid, q_type : q_type, q_content : q_content}, function(data) {
				if (data != '1') {
					alert(data);
				}
			});
		}

		//提问完成，此时将提问编辑区影藏
		$('#z_myquestion_edit').css('display', 'none');

		//点击取消提问时，将提问区域影藏起来
		$('#q_result').click(function() {
			$('#z_myquestion_edit').css('display', 'none');
		});
	}

	/*
		找到问题所在了，即是分页的页码不变，只要页码变化，请求就成功了
		捣鼓了一个下午，最后实现了一步刷新请求这个功能，鸡肋的是居然需要点击两次才能
		触发成功。也就是说，第一次点击请求a标签，第二次请求才发送数据到控制器中去
		暂时先这样
	*/

	function setPage(url) {
		
		$('.q_page a').mouseup(function() {
			
			var p = $(this).text();
			var str = location.pathname;
			str = str.split('/');
			str = str.pop();

			$.get("/test/fanke/index.php/Home/Detial/qpage",{id : str, p : p}, function(data) {
				$('.question_include').html(data);
			});
		});
	}

</script>
					</div>
					
				</div>
			</div>

			<!-- 一个空白的30px高的占位条，用于与页脚分开 -->
			<div class="z_space_bar"></div>
		</div>

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
							<li><a href="/test/fanke/index.php/Home/FriendLink/index">友情链接</a></li>
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
					<img src="/test/fanke/Public/Home/Images/erweima.jpg" alt="" />
					<span>火热下载中...</span>					
				</div>
				<span class="blank"></span>
				<div class="top1">
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_1.jpg" alt=""></a>
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_2.jpg" alt=""></a>
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_3.jpg" alt=""></a>
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_4.jpg" alt=""></a>
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
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_11.jpg" alt=""></a>
					<a><img src="/test/fanke/Public/Home/Images/footer_12.jpg" alt=""></a>
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_13.jpg" alt=""></a>
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_14.jpg" alt=""></a>
					<a href=""><img src="/test/fanke/Public/Home/Images/footer_15.jpg" alt=""></a>
				</div>
			</div>
		</div>
	</body>
	<script>
		/*
			一个简单的算法，通过JS字符串函数split()将字符串分割成数组和
			数组函数pop()弹出数组最后一个元素进行浏览器地址的分割处理
			最后得到浏览器地址中的id值，用于jQuery向控制器进行异步请求
		*/
		function goodsid() {
			var str = location.pathname;
			str = str.split('/');
			str = str.pop();

			return str;
		}

		/*
			图像放大镜插件，使用方法为：
			1，加载jquery.js插件和jquery.jqzoom.css样式表到当前页面中
			2，标签格式为
			<a href="/test/fanke/Public/Home/Images/z_zoom_big_1.jpg" class="jqzoom">
				<img id="z_d_default_1" src="/test/fanke/Public/Home/Images/z_zoom_thumb_1.jpg" title="无下限无节操">
			</a>
			3，网页中显示的图像为img标签中显示的图像，一般是一张缩略图
			4，需要一张大图放在比如a标签的href属性中，这张大图是必须使用的，同时需要给a标签加上class=“jqzoom”这个类样式
			5，同时加载如下的js代码
			6，所有设置项有：
				zoomType，默认值：’standard’，另一个值是’reverse’，是否将原图用半透明图层遮盖。
			      zoomWidth，默认值：200，放大窗口的宽度。
			      zoomHeight，默认值：200，放大窗口的高度。
			      xOffset，默认值：10，放大窗口相对于原图的x轴偏移值，可以为负。
			      yOffset，默认值：0，放大窗口相对于原图的y轴偏移值，可以为负。
			      position，默认值：’right’，放大窗口的位置，值还可以是:’right’ ,’left’ ,’top’ ,’bottom’。
			      lens，默认值：true，若为false，则不在原图上显示镜头。
			      imageOpacity，默认值：0.2，当zoomType的值为’reverse’时，这个参数用于指定遮罩的透明度。
			      title，默认值：true，在放大窗口中显示标题，值可以为a标记的title值，若无，则为原图的title值。
			      showEffect，默认值：’show’，显示放大窗口时的效果，值可以为: ‘show’ ,’fadein’。
			      hideEffect，默认值：’hide’，隐藏放大窗口时的效果: ‘hide’ ,’fadeout’。
			      fadeinSpeed，默认值：’fast’，放大窗口的渐显速度(选项: ‘fast’,'slow’,'medium’)。
			      fadeoutSpeed，默认值：’slow’，放大窗口的渐隐速度(选项: ‘fast’,'slow’,'medium’)。
			      showPreload，默认值：true，是否显示加载提示Loading zoom(选项: ‘true’,'false’)。
			      preloadText，默认值：’Loading zoom’，自定义加载提示文本。
			      preloadPosition，默认值：’center’，加载提示的位置，值也可以为’bycss’，以通过css指定位置。
		*/
		$(document).ready(function() {
			$('.jqzoom').jqzoom({
		            zoomType: 'standard',
		            lens:true,
		            xOffset:20,
				zoomWidth:400,
				zoomHeight:400,
		            preloadImages: false,
		            alwaysOn:false
		        });	
		});

		//定义一个变量储存颜色的值
		//默认选择黑色
		$('.z_color_right span').eq(2).css('border', '2px solid red');
		var color = $('.z_color_right span div').eq(2).html();

		//设置购物车处已选状态
		$('#z_sel_right').html('默认颜色&nbsp;&nbsp'+color);

		$('.z_color_right span').click(function() {
			$('.z_color_right span').css('border', '');
			$(this).css('border', '2px solid red');
			color = $(this).text();

			//设置购物车处已选状态
			$('#z_sel_right').html('颜色&nbsp;&nbsp'+color+'尺寸&nbsp;&nbsp'+size);
		});

		//定义一个变量存储尺寸的值
		var size = null;
		$('#z_size_middle div').click(function() {
			$('#z_size_middle div' ).css('border', '');
			$(this).css('border', '2px solid red');
			size = $(this).html();

			//设置购物车处已选状态
			$('#z_sel_right').html('颜色&nbsp;&nbsp'+color+'&nbsp;&nbsp;尺寸&nbsp;&nbsp'+size);
		});

		//点击放入购物车时，将其存入SESSION['goods']字段中，读取处数量和总价格显示在突显框内供用户查看
		$('#z_car_view a').click(function() {
			if (color == null)  {
				alert('请选择颜色');
			} else if(size == null){
				alert('请选择尺寸');
			}else {
				var str = location.pathname;
				str = str.split('/');
				str = str.pop();
				
				//获取该用户选择该商品时的数量
				var num = $('#need_num').val();

				//需要局部请求判断需要的数量是否大于商品库存量
				$.post("/test/fanke/index.php/Home/Detial/check", {num : num, id : str}, function(data) {
					if (data == '-1') {
						$('.notice_msg').html("查询不到该商品信息");
					} else if (data != '1') {
						$('.notice_msg').html('该商品目前的库存量是'+data+'件');
					} else {
						$('.notice_msg').html('');

						//可以购买，使用jQuery请求数据库，查询该商品的信息，将商品id传递到控制器中去，返回json格式的字符串
						$.post('/test/fanke/index.php/Home/Detial/addcart', {id : str, num : num, color : color, size : size},  function(data) {
				
							$('.z_content_left_cart > div > p').eq(0).html('共有'+data.sum+'件商品');
							$('.z_content_left_cart > div > p').eq(1).html('总计￥'+data.total+'元');
						}, 'json');

						//请求成功，显示购物车概略信息
						$('.z_show_cart_page').css('display', 'block');
					}
				});
			}
		});

		$('#z_page_close').click(function() {
			$('.z_show_cart_page').css('display', 'none');
		});

		/*
			收藏商品时调用的函数，该函数需要继续调用遮盖层插件
		*/
		function collect(id) {

			//获得商品id号，通过调用goodsid()函数获取
			var goods_id = goodsid();
			

			$.post("/test/fanke/index.php/Home/Detial/collect", 'id='+goods_id, function(data) {

				//调用遮盖层插件函数
				EV_modeAlert('EV_Mode_plug');

				switch(data) {
					case '1':
						$('#collect_msg').text('成功收藏该商品');
						break;
					case '-1':
						$('#collect_msg').text('你已经收藏了该商品，不需要重复收藏');
						break;
					case '-2':
						$('#collect_msg').text('收藏商品失败');
						break;
					case '-3':
						$('#collect_msg').text('查询不到该商品的信息');
						break;

					case '-4':
						$('#collect_msg').text('登录用户才可以收藏商品');
						break;
				}
			}, 'json');	
		}

		function setPage(url) {
		
		$('.comment_page a').mouseup(function() {
			
			var p = $(this).text();
			var str = location.pathname;
			str = str.split('/');
			str = str.pop();
			
			$.get("/test/fanke/index.php/Home/Detial/cpage", {id : str, p : p}, function(data) {
				$('.comment_include').html(data);
			});
		});
	}

	/*$('.shopping').click(function() {
			$.post("/test/fanke/index.php/Home/Cart/checkCart", function(data) {

				if (data != 'no') {
					var html='';
					for(var i in data) {

						html = '<div class="one_good" style="width:308px;height:50px;">';
						html += '<img src="/test/fanke/Public/Home/Images/goods/'+data[i]['goodsimg']+' style="float:left;width:36px;height:36px;margin:5px 7px 0 5px;"><div style="float:left;width:200px;height:40px;margin:5px 0 0 5px;font-size:12px;">';
						html += '<p style="float:left;width:200px;height:20px;font-size:12px;line-height:20px;">'+data[i]['goodsname']+'</p>';
						html += '<p style="float:left;width:200px;height:20px;font-size:12px;line-height:20px;">￥'+data[i]['promoteprice']+'元</p></div>';
						html += '<a href="javascript:del('+data[i]+')" style="float:left;width:40px;height:40px;margin:5px 0 0 0;font-size:12px;line-height:40px;text-align:right;">删除</a></div>';
						alert(html);
					}
				}
				$('.one_good').html(html);
			}, 'json');
		});*/
	</script>
</html>