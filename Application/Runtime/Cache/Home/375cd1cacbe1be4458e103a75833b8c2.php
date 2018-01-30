<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商品列表</title>
	<link rel="stylesheet" href="/Public/Home/Css/header.css">
	<link rel="stylesheet" href="/Public/Home/Css/goodslist.css">
	<link rel="stylesheet" href="/Public/Home/Css/goodsDetail.css">
	<link rel="stylesheet" href="/Public/Home/Css/footer.css">
	<script src="/Public/Home/Js/jquery.js"></script>
	<script src="/Public/Home/Js/GetRequest.js"></script>
	<script src="/Public/Home/Js/getDate.js"></script>
</head>
<body>
	<!-- 载入头文件 -->
		<!-- 回到顶部 -->
	<div style="right: 10px; bottom: 10px; position: fixed; z-index: 9999; display: block;">
		<a href="#">
			<div style="cursor: pointer;background-image:url(/Public/Home/Images/go2top.png);background-color:transparent;background-repeat:no-repeat;width:25px;height:90px"></div>
		</a>
	</div>

	<!-- 顶部信息栏 -->
	<div id="top">
		<div id="top_box">
			<!-- 左边登陆部分 -->
			<div id="top_box_left">

				<!-- 判断SESSION的值是否为空,若为空则未登录,否则为登录 -->
				<?php if($user["username"] == null): ?><span>您好, 欢迎光临凡客诚品!</span>
					<a href="/index.php/Home/User/login" class="login_reg">[&nbsp;&nbsp;登陆&nbsp;&nbsp;</a>|
					<a href="/index.php/Home/User/regedit" class="login_reg">&nbsp;&nbsp;注册&nbsp;&nbsp;]</a>
				<?php elseif($user["username"] != null): ?>
					<span>您好,&nbsp;<?php echo ($user["username"]); ?></span>
					<a href="/index.php/Home/Index/loginout" class="login_reg">&nbsp;退出登录</a> | <a href="/index.php/Home/User/login" class="login_reg">更换用户&nbsp;</a><?php endif; ?>
				　　
				<a href="/index.php/Home/myVancl/myvancl" target="_blank">我的订单</a>　
				<a href="javascript:void(0);" onclick="AddFavorite('我的网站',location.href)">收藏本站</a>
			</div>
			
			<!-- 右边部分 -->
			<div id="top_box_right">
				<!-- 我的凡客 -->
				<div class="my_vancl">
					<!-- //判断是否为登录用户 -->
					<?php if($user == null): ?><a href="/index.php/Home/MyVancl/login"class="mapDropTitle" target="_blank">我的凡客</a>
					<?php else: ?>
						<a href="/index.php/Home/MyVancl/myvancl"class="mapDropTitle" target="_blank">我的凡客</a><?php endif; ?>

					<div class="my_vancl_list">
						<ul class="mapDropList">
							<li onclick="location.href='/index.php/Home/myVancl/myvancl'">我的订单</li>
							<li onclick="location.href='/index.php/Home/myVancl/myvancl'">我的收藏</li>
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
			<a href="/index.php"></a>
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
					<a href="/index.php/Home/Cart/cart" class="shopping_link">
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
							<img src="/Public/Home/Images/goods/<?php echo ($cart["goodsimg"]); ?>" alt="">
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
							<a href="/index.php/Home/Cart/cart" target="_blank">去购物车</a>
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
							<a href="/index.php/Home/Plate/index.html?id=<?php echo ($cate["id"]); ?>"><?php echo ($cate["navName"]); ?></a>
						</h3>
						<p class="allBox">
							<?php if(is_array($cate['menu'])): foreach($cate['menu'] as $key=>$menu): ?><a href="/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($menu['id']); ?>"><?php echo ($menu['listName']); ?></a><?php endforeach; endif; ?>
						</p>
					</li><?php endforeach; endif; ?>
			</ul>
		</div>



		<div class="nav_center">
			<ul class="main_nav">
				<!-- 循环遍历导航菜单 -->
				<li><a href="/index.php">首页</a></li>
				<?php if(is_array($nav)): foreach($nav as $key=>$nav): ?><li><a href="/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($nav["id"]); ?>"><?php echo ($nav["listName"]); ?></a></li><?php endforeach; endif; ?>
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
		// 	$.get("/index.php/Home/Header/delGoods?delId="+$(".one_good").attr("alt"),function(data){
		// 		if(data > 0){
		// 			$(".one_good[alt='"+data+"']").fadeOut(500);
		// 		}else{
		// 			alert("删除失败！");
		// 		}
		// 	},"json");
		// });

		$.get("/index.php/Home/Header/getWeb",function(data){
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
				location.href = "/index.php/Home/Search/index";
			}else{
				location.href = "/index.php/Home/Search/index?key="+$(".search_input").val();
			}
		}
	</script>

	<!-- main部分 -->
	<div id="goods_content">
		<!-- 频道导航 -->
		<div id="main_minNav">
			<h1>
				<a class="track"><?php echo ($category['name']); ?>频道</a>
			</h1>
			<div class="navList">
				<ul>
					<?php if(is_array($datas)): foreach($datas as $key=>$datas): ?><li>
							<a class="dataname" href="/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($datas["id"]); ?>"><?php echo ($datas["listName"]); ?></a>
						</li><?php endforeach; endif; ?>
				</ul>
			</div>
		</div>

		<!-- 左边列表部分 -->
		<div id="goods_leftList">
			<!-- 商品筛选盒子 -->
			<!-- <div class="left_filtrateBox">
				<div class="filtrate_Category">
					<h2>
						<a href="javascript:">重置筛选项</a>
						<span>衬衫</span>
					</h2>

					<dl>
						<dt>品牌</dt>
						<dd>
							<a href="javascript:">vancl 凡客诚品</a>
						</dd>
					</dl>


					<dl>
						<dt>风格</dt>
						<dd>
							<a href="javascript:">日系</a>
						</dd>
						<dd>
							<a href="javascript:">韩系</a>
						</dd>
						<dd>
							<a href="javascript:">时尚</a>
						</dd>
						<dd>
							<a href="javascript:">OL</a>
						</dd>
					</dl>

					<dl>
						<dt>版型</dt>
						<dd>
							<a href="javascript:">修身</a>
						</dd>
						<dd>
							<a href="javascript:">标准</a>
						</dd>
					</dl>

					频道搜索
					<div class="list_search">
						<input type="text" value="频道内搜索">
						<input type="button">
					</div>
				</div>
			</div> -->

			<div class="left_order">
				<div class="list_title">
					<h2>
						<span>销量排行</span>
					</h2>
				</div>

				<div class="list_detail">
					<div>
						<?php if(is_array($sales)): foreach($sales as $k=>$sales): ?><span class="blank"></span>
							<ul title="<?php echo ($sales['goodsname']); ?>">
								<li class="topImgs">
									<a href="/index.php/Home/Detial/Detial/id/<?php echo ($sales["id"]); ?>">
										<img src="/Public/Home/Images/goods/<?php echo ($sales["goodsimg"]); ?>" alt="">
									</a>
								</li>
								<li class="topWord">
									<p>
										<span><?php echo ($k+1); ?></span>
									</p>
									<p class="list_name">
										<a href="/index.php/Home/Detial/Detial/id/<?php echo ($sales["id"]); ?>"><?php echo ($sales['goodsname']); ?></a>
									</p>
									<span class="blank"></span>
									<p class="Sprice">售价：￥<?php echo ($sales["promoteprice"]); ?></p>
								</li>
							</ul><?php endforeach; endif; ?>
					</div>
				</div>
			</div>


			
			<div class="left_order">
				<div class="list_title">
					<h2>
						<span>您可能感兴趣的商品</span>
					</h2>
				</div>

				<div class="list_detail">
					<div>
						<?php if(is_array($like)): foreach($like as $k=>$like): ?><span class="blank"></span>
							<ul>
								<li class="topImgs">
									<a href="/index.php/Home/Detial/Detial/id/<?php echo ($like["id"]); ?>">
										<img src="/Public/Home/Images/goods/<?php echo ($like["goodsimg"]); ?>" alt="">
									</a>
								</li>
								<li class="topWord">
									<p>
										<span><?php echo ($k+1); ?></span>
									</p>
									<p class="list_name">
										<a href="/index.php/Home/Detial/Detial/id/<?php echo ($like["id"]); ?>"><?php echo ($like["goodsname"]); ?></a>
									</p>
									<span class="blank"></span>
									<p class="Sprice">售价：￥<?php echo ($like["promoteprice"]); ?></p>
								</li>
							</ul><?php endforeach; endif; ?>
					</div>
				</div>
			</div>

			<!-- <div class="left_order">
				<div class="list_title">
					<h2>
						<span>最近浏览过的商品</span>
					</h2>
				</div>

				<div class="list_detail">
					<div>
						<?php $__FOR_START_4470__=0;$__FOR_END_4470__=5;for($i=$__FOR_START_4470__;$i < $__FOR_END_4470__;$i+=1){ ?><span class="blank"></span>
							<ul>
								<li class="topImgs">
									<a href="javascript:">
										<img src="/Public/Home/Images/0538827-1j201307051156146001.jpg" alt="">
									</a>
								</li>
								<li class="topWord">
									<p>
										<span>1</span>
									</p>
									<p class="list_name">
										<a href="javascript:">[VT]基础素色背心(女款..</a>
									</p>
									<span class="blank"></span>
									<p class="Sprice">售价：￥9</p>
								</li>
							</ul><?php } ?>
					</div>
				</div>
			</div> -->

		</div>

		<!-- 右边商品部分 -->
		<div id="goods_rightList">
			<!-- 工具栏部分 -->
			<div id="toolbar">
				<!-- 浮动div -->
				<div id="floatDiv" style="background-color: rgb(255, 255, 255); z-index: 100; position: static; top: 0px;">
					<div id="filterBox">
						<div id="filter_top">
							<div id="filter_top_left">
								<h3>排序：</h3>
								<div id="filter_order">
									<a class="getDefault" href="/index.php/Home/GoodsList/getDefault.html?id=<?php echo ($where['cid']); ?>" class="checked">默认</a>
									<a class="getSales" href="/index.php/Home/GoodsList/getSales.html?id=<?php echo ($where['cid']); ?>">销量</a>
									<a class="getPriceOrder" href="/index.php/Home/GoodsList/getPriceOrder.html?id=<?php echo ($where['cid']); ?>">价格</a>
									<a class="getIsGood" href="/index.php/Home/GoodsList/getIsGood.html?id=<?php echo ($where['cid']); ?>">好评</a>
									<a class="getNew" href="/index.php/Home/GoodsList/getNew.html?id=<?php echo ($where['cid']); ?>">最新</a>
								</div>
							</div>
							<div id="filter_top_right">
								<div id="pageDiv">
									<span>相关商品<strong><?php echo ($page['count']); ?></strong>款</span>
									<span>
										<span href="javascript:" class="page_prev" onclick="page_prev();"></span>
									</span>
									<span><?php echo ($page['page']); ?>/<?php echo ($page['pagecount']); ?></span>
									<span>
										<span href="javascript:" class="page_next" onclick="page_next();"></span>
									</span>
								</div>
							</div>
						</div>

						<div id="filter_bottom">
							<div id="bottom_left">
								配送方式：
								<span>
									<label for="all"><input id="all" type="radio" name="radio" /> 全部</label>
								</span>
								<span>
									<label for="vancl"><input id="vancl" type="radio" name="radio" /> 凡客配送</label>
								</span>
								<span>
									<label for="disanf"><input id="disanf" type="radio" name="radio" /> 第三方配送</label>
								</span>
							</div>

							<div id="bottom_price">
								<h3>价格：</h3>
								<div id="price_input">
									<div id="price_search">
										<input type="text" title="按价格区间筛选 最低价" id="price_low">
										<span>—</span>
										<input type="text" title="按价格区间筛选 最高价" id="price_high">
									</div>
									<div id="price_foused">
										<p>
											<span class="searchbarBtnCommon">清空</span>
											<a class="searchbarBtnStrong"></a>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- 商品详细列表部分 -->
			<div id="productList">
				<ul id="listDetail">
					<?php if($goods == 'null'): ?><!-- 商品不存在 -->
						<div id="noresult">
							<p>抱歉！没有找到符合你要求的商品，</p>
							<p>
								您可以
								<span style="color:#a10000">改变或减少筛选条件</span>
								的限制试试。
							</p>
						</div>
					<?php else: ?>
						<?php if(is_array($goods)): foreach($goods as $key=>$goods): ?><li>
								<strong>
									<a href="/index.php/Home/Detial/Detial/id/<?php echo ($goods["id"]); ?>">
										<img class="popup_detail" src="/Public/Home/Images/goods/<?php echo ($goods["goodsimg"]); ?>" alt="<?php echo ($goods["id"]); ?>">
									</a>
								</strong>
								<p class="product_name">
									<a href="/index.php/Home/Detial/Detial/id/<?php echo ($goods["id"]); ?>"><?php echo ($goods["goodsname"]); ?>　<?php echo ($goods["goodsColor"]); ?>　<?php echo ($goods["goodsdesc"]); ?></a>
								</p>
								<p class="product_price">
									<del>市场价 ￥<?php echo ($goods["goodsprice"]); ?></del><br>
									<strong>售价 ￥<?php echo ($goods["promoteprice"]); ?></strong>
								</p>
								<p class="storeinfo">
									<span></span>
									<a href="javascript:">VANCL 凡客诚品旗舰店</a>
								</p>
								<div></div>
							</li><?php endforeach; endif; endif; ?>
				</ul>
			</div>

		</div>

	</div>

	<div class="clears"></div>

	<!-- 底部分页菜单开始 -->
	<div id="page_box">
		<div id="bottom_page">
			<input type="button" id="page_Okbtn" />
			<strong>页</strong>
			<input type="text" id="page_text" value="1" />
			<strong>到第</strong>
			<em id="page_count">共<?php echo ($page['pagecount']); ?>页</em>
			<span id="page_next" onmouseout="$(this).css('background-position', '46px -1954px');" onmouseover="$(this).css('background-position', '46px -1976px');" style="background-position: 46px -1954px;" onclick="page_next();">
				<a>下一页</a>
			</span>
			<ul id="page_ul">
				
			</ul>
			<span id="page_prev" onmouseout="$(this).css('background-position', '3px -1996px');" onmouseover="$(this).css('background-position', '3px -2018px');" style="background-position: 3px -1996px;" onclick="page_prev();">
				<a>上一页</a>
			</span>
		</div>
	</div>
	<!-- 底部分页菜单结束 -->

	<div class="clears"></div>

	<!-- 载入商品详细页面 -->
		<div id="arrowIcon" class="ico" style="z-index:1002;display:none;"></div>
	<div id="popup" class="popup" style="display:none;position:fixed;z-index:1001;">
		<div class="pop_pic"></div>
		<div class="pop_title">
			<span>[VT]印花T恤 滚石(女款) 黑色</span>
			<em>总销量：</em>
			<div class="good_box">
				<div class="isgood">12</div>
				<div class="ispoor">55</div>
			</div>
		</div>
		<div class="market"></div>
		<ul class="pop_price">
			<li class="price1">
				<strong>售价：￥59</strong>
			</li>
			<li class="price2">
				市场价：
				<del>￥159</del>
				<span></span>
			</li>
		</ul>
		<p class="pop_praise">
			<span>好评率</span>
			<em>89%</em>
		</p>
		<div style="clear:both;display:block;height:10px;width:1px;overflow:hidden;"></div>
		<div id="pop_comment">
			<div class="comment" style="position:relative">
				<!-- <div style="height:36px;word-wrap:break-word;overflow:hidden;margin:10px;">1340*****84：物流很快一天就到了，很好看，只是料子不太好。</div> -->

				<!-- <div style="height:36px;word-wrap:break-word;overflow:hidden;margin:10px;">**********ulie@hotmail.com：好看是好看！面前那块要是布做的就更好了！总体说喜欢！</div>
				<div style="height:36px;word-wrap:break-word;overflow:hidden;margin:10px;">ThirdSignweib*****：很漂亮！很喜欢！面料也很好</div>
				<div style="height:36px;word-wrap:break-word;overflow:hidden;margin:10px;">1340*****84：物流很快一天就到了，很好看，只是料子不太好。</div>
				<div style="height:36px;word-wrap:break-word;overflow:hidden;margin:10px;">不错呦,我就喜欢</div>
				<div style="height:36px;word-wrap:break-word;overflow:hidden;margin:10px;">买大了一码,悲剧</div> -->
			</div>
		</div>
	</div>
	<!-- 载入脚文件 -->
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
							<li><a href="/index.php/Home/FriendLink/index">友情链接</a></li>
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
					<img src="/Public/Home/Images/erweima.jpg" alt="" />
					<span>火热下载中...</span>					
				</div>
				<span class="blank"></span>
				<div class="top1">
					<a href=""><img src="/Public/Home/Images/footer_1.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_2.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_3.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_4.jpg" alt=""></a>
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
					<a href=""><img src="/Public/Home/Images/footer_11.jpg" alt=""></a>
					<a><img src="/Public/Home/Images/footer_12.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_13.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_14.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_15.jpg" alt=""></a>
				</div>
			</div>
		</div>
</body>
<script>
	//根据接收到的总页数来动态添加分页按钮的数量
	var count = 0;
	//设置分页按钮的最大个数
	if(<?php echo ($page['pagecount']); ?> >= 10 ){
		count = 10;
	}else{
		count = <?php echo ($page['pagecount']); ?>;
	}
	var addLi = "";
	for(var i=1;i<=count;i++){
		if(i == <?php echo ($page['page']); ?>){
			addLi += "<li class=\"page_current\">"+i+"</li>";
		}else{
			addLi += "<li>"+i+"</li>";
		}
	}
	$("#page_ul").empty().append(addLi);

	//上一页
	function page_prev(){
		var urls = location.href;
		if(Request['page'] > 1){
			location.href = urls.replace(/&page=<?php echo ($page['page']); ?>/,"&page="+(parseInt(Request['page']) - 1));
		}
	}

	// // 下一页
	function page_next(){
		var urls = location.href;
		if(<?php echo ($page['page']); ?> == 1 && <?php echo ($page['pagecount']); ?> > 1){
			location.href = urls + "&page=2";
		}
		if(Request['page'] < <?php echo ($page['pagecount']); ?>){
			location.href = urls.replace(/&page=<?php echo ($page['page']); ?>/,"&page="+(<?php echo ($page['page']); ?> + 1));
		}
	}

	//单击页码
	$("#page_ul li").click(function(){
		var urls = location.href;
		if(Request['page'] == null){
			location.href = urls + "&page=" + $(this).html();
			return false;
		}

		if(Request['page'] != ""){
			location.href = urls.replace(/&page=<?php echo ($page['page']); ?>/,"&page="+$(this).html());
		}
	});

	// 单击确定按钮跳转
	$("#page_Okbtn").click(function(){
		var urls = location.href;
		if(Request['page'] == null){
			location.href = urls+"&page="+$("#page_text").val();
			return false;
		}
		if($("#page_text").val() <= <?php echo ($page['count']); ?>){
			location.href = urls.replace(/&page=<?php echo ($page['page']); ?>/,"&page="+$("#page_text").val());
		}
	});

	// 工具栏排序
	var p_url = "/index.php/Home/GoodsList/getDefault";
	var p_arr = p_url.split("/");
	$("." +p_arr.pop()).addClass("checked").siblings().removeClass("checked");

	// 工具栏定位
	$(window).scroll(function(){
		if($(document).scrollTop() > $("#filterBox").offset().top){
			$("#filterBox").css({"position":"fixed","top":"0"});
		}
		if($(document).scrollTop() < 255){
			$("#filterBox").css("position","relative");
		}
	});

	// 频道导航
	for(var i=0;i<$(".navList ul li").length;i++){
		$(".dataname")[i].index = i;
		if($(".dataname").eq(i).html() == "<?php echo ($dataname["listName"]); ?>"){
			$(".dataname").eq(i).parent().addClass("current");
		}
	}
	

	$(".navList ul li").click(function(){
		$(this).addClass("current").siblings().removeClass("current");
	});


	// 商品详情信息
	var popup_detail = $(".popup_detail");
	popup_detail.hover(function(event){
		var eve = event || window.event;
		$(this).css("border","1px solid #B33333");
		$("#arrowIcon").css("display","block");
		$("#popup").css("display","block");
		$("#arrowIcon").css("left",$(this).offset().left + $(this).width());
		$("#popup").css("left",$(this).offset().left + $(this).width() + $("#arrowIcon").width());
		$("#arrowIcon").css("top",eve.pageY);

		if(eve.pageY > $(this).offset().top + $(this).height() / 2){
			$("#arrowIcon").css("top",eve.pageY - 25)
		}

		var screenHeight = $(window).height();
		if(eve.clientY > screenHeight / 2){
			$("#popup").css("top",screenHeight - $("#popup").height() - 5);
		}else{
			$("#popup").css("top",(screenHeight / 10) - 60);
		}

		if($(this).offset().left > $(document).width() / 2){
			$("#arrowIcon").css({"background-position":"0 -28px","left":$(this).offset().left - $("#arrowIcon").width()});
			$("#popup").css("left",$(this).offset().left - $("#popup").width() - $("#arrowIcon").width()-1);
		}else{
			$("#arrowIcon").css("background-position","0 0");
		}


		// ajax请求数据
		$.get("/index.php/Home/GoodsList/getGoods",{"id":$(this).attr("alt")},function(data){
			$(".pop_pic").html('<img src="/Public/Home/Images/goods/' + data.goodsimg + '">');
			$(".pop_title span").html(data.goodsname);
			$(".pop_title em").html("总销量："+data.goodssales);
			$(".isgood").html("好评：" + data.isGood);
			$(".ispoor").html("差评：" + data.isPoor);

			$(".market").html("上架时间："+getDate(data.addtime));
			$(".price1 strong").html("售价：￥"+data.promoteprice);
			$(".price2 del").html("￥"+data.goodsprice);
			var sum = (parseInt(data.isGood) + parseInt(data.isPoor));
			var result = Math.round(parseInt(data.isGood) / parseInt(sum) * 100) + "%";
			if(result == "NaN%"){
				result = "100%";
			}
			$(".pop_praise em").html(result);
		},"json");

	},function(){
		$(this).css("border","1px solid #DCDCDC");
		$("#pop_pic_detail").attr("src"," ");
		$("#arrowIcon").css("display","none");
		$("#popup").css("display","none");
	});

	// 价格查询
	// 清除按钮
	$(".searchbarBtnCommon").click(function(){
		$("#price_low,#price_high").val("");
	});
	//确定按钮
	$(".searchbarBtnStrong").click(function(){
		var url = "/index.php/Home/GoodsList/getPrice.html?id="+Request['id'];
		var low = "&low="+$("#price_low").val();
		var high = "&high="+$("#price_high").val();
		var t_low = $("#price_low").val();
		var t_high = $("#price_high").val();

		if(t_low && t_high != ""){
			location.href = url+ low+high;
		}else if(t_low != "" && t_high == ""){
			location.href = url+low;
		}else if(t_low == "" && t_high != ""){
			location.href = url+high;
		}else{
			alert("至少输入一个值");
		}
	});
</script>
</html>