<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- 首页 -->
	<title alt="1"></title>
	<link rel="shortcut icon" href="/Public/Home/Images/favicon.ico" type="image/x-icon" />
	<meta name="keywords" content="" />
     <meta name="description" content="" />
	<link rel="stylesheet" href="/Public/Home/Css/header.css">
	<link rel="stylesheet" href="/Public/Home/Css/home.css">
	<link rel="stylesheet" href="/Public/Home/Css/footer.css">
	<script src="/Public/Home/Js/jquery.js"></script>
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

	<!-- 内容部分 -->
	<div id="main_content">
		<!-- 主页幻灯片 -->
		<div id="main_picSlide">
			<ul id="play_slide">
				<?php if(is_array($slide)): foreach($slide as $key=>$slide): ?><li style="display:none;">
						<a href="<?php echo ($slide["links"]); ?>">
							<img src="/Public/Home/Images/slide/<?php echo ($slide["address"]); ?>">
						</a>
					</li><?php endforeach; endif; ?>
			</ul>
			<ul id="play_btn_box">
				<?php $__FOR_START_618__=0;$__FOR_END_618__=8;for($i=$__FOR_START_618__;$i < $__FOR_END_618__;$i+=1){ ?><li></li><?php } ?>
			</ul>
		</div>

		<!-- 清除浮动 -->
		<div class="clear"></div>

		<!-- 板块 -->
		<div class="main_plate">
			<!-- 女装 -->
			<?php if(is_array($goods)): foreach($goods as $key=>$cate): ?><div class="main_Board">
				<div class="Board_title">
					<span class="Board_title_left">
						<a href="/index.php/Home/Plate/index.html?id=<?php echo ($cate["pid"]); ?>"><?php echo ($cate["navName"]); ?></a>
					</span>

					<div>
						<a href="/index.php/Home/Plate/index.html?id=<?php echo ($cate["pid"]); ?>"></a>
					</div>
				</div>
				<!-- 清除浮动 -->
				<span class="clear"></span>

				<!-- 板块左边部分 -->
				<div class="Board_left">
					<div class="img_plate">
						<ul class="nvzhuang_img">
							<?php if(is_array($cate['menu'])): foreach($cate['menu'] as $key=>$menu): ?><li class="img_goods_focus" title="<?php echo ($menu['goodsname']); ?>">
									<a href="/index.php/Home/Detial/Detial/id/<?php echo ($menu['id']); ?>">
										<img class="img_goods_pic" src="/Public/Home/Images/goods/<?php echo ($menu['goodsimg']); ?>">
										<div>
											<span class="img_goods_left"><?php echo ($menu['goodsname']); ?></span>
											<span class="img_goods_right">￥<b><?php echo ($menu['promoteprice']); ?></b></span>
										</div>
									</a>
								</li><?php endforeach; endif; ?>
						</ul>
					</div>
				</div>
			</div><?php endforeach; endif; ?>
		</div>


		<!-- 首页遮罩广告 -->
		<div id="overlay">
			<div style="background:#000;filter:alpha(opacity=40);opacity:0.4;-moz-opacity:0.4;width:100%;height:100%; position:fixed; _position:absolute;left:0px;top:0px; z-index:999998;"></div>
			<div id="screenAdPop">
				<p>
					<a href="javascript:">
						<img id="img_top" style="border:none;vertical-align:top;">
					</a>
				</p>
				<span id="screenClose"></span>
			</div>
		</div>
	
		<a href="javascript:" onfocus="this.blur();">
			<img src="/Public/Home/Images/bottombanner_1200_140219.jpg" style="margin-bottom:10px;">
		</a>
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
	//判断用户是否为登陆状态
	if(<?php echo ($state); ?> == 0){
		$("#overlay").css("display","block");
		// alert(1);
	}else{
		$("#overlay").css("display","none");
		// alert(0);
	}
	// alert(<?php echo ($state); ?>);

	// 得到屏幕工作区域的宽高
	screenWidth =  document.documentElement.clientWidth;
	screenHeight = document.documentElement.clientHeight;

	var scr = document.getElementById("screenAdPop");
	var img = document.getElementById("img_top");

	$.get("/index.php/Home/Index/getBanner",function(data){
		$("#img_top").attr("src","/Public/Home/Images/slide/"+data['address']);
	},"json");

	// 幻灯片----------------------------------------------------
	var oli = $("#play_slide li");
	var bli = $("#play_btn_box li");
	var i = num = 0;

	for(i=0;i<oli.length;i++){
		bli[i].index = i;
		bli.eq(i).mouseover(function(){
			if(num != this.index){
				num = this.index;
				show(this.index);
				clearInterval(play);
			}
		});
	}

	show(num);

	oli.mouseover(function(){
		clearInterval(play);
	});
	oli.mouseout(function(){
		autoplay();
	});

	autoplay();
	function autoplay(){
		play = setInterval(function(){
			num++;
			num >= oli.length && ( num = 0 );
			show(num);
		},3000);
	}
	
	function show(a){
		for(i=0;i<oli.length;i++){
			oli.eq(i).css("display","none");
			bli.eq(i).css("background","#9E9D9D");
		}
		oli.eq(a).fadeIn(1000);
		bli.eq(a).css("background","#CC0000");
	}
// 幻灯片----------------------------------------------------------------------




	// 首页遮罩广告
	$("#screenClose").click(function(){
		close();
	});
	
	setInterval(function(){
		close();
	},5000);

	function close(){
		$("#overlay").fadeOut(500);
	}

	// 图片加载完成后再执行下面代码，否则获取不到宽高度
	img.onload = function(){
		scr.style.left = (parseInt(screenWidth,10) - img.offsetWidth) / 2 + 'px';
		scr.style.top = (parseInt(screenHeight,10) - img.offsetHeight) / 2 + 'px';
	}

	$(".img_goods_pic").hover(function(){
		$(this).animate({left: '-5px'}, 200);
		$(this).parent().parent().css({"border":"1px solid #a10000"});
	},function(){
		$(this).animate({left: '+0px'}, 200);
		$(this).parent().parent().css("border","1px solid #E8E8EA");
	});
</script>
</html>