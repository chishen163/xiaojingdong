<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>凡客诚品 - 会员登录</title>
		<link rel="stylesheet" type="text/css" href="/Public/Home/css/login.css">
	</head>
	<body>
		<center>
			<div class="login_top">
				<a href="/index.php/Home/Index/index"><img src="/Public/Home/Images/login_a1.jpg" alt=""></a>
				<p>
					<a href="javascript::">帮助</a>
				</p>
			</div>
		</center>
		<div class="login_middle">
			<div class="login_middle_left">
				<div class="tags">
					<ul>
						<li class="on"><a href="javascript::">VANCL用户</a></li>
						<li><a href="javascript::">V+用户</a></li>
					</ul>
				</div>
				<div class="shows">
					<span class="blank"></span>
					<form action="/index.php/Home/MyVancl/log" method="post" name="h_myform" onsubmit="return CheckPost();">
						<div class="user_info">
							<p>
								<label>用户名:</label>
								<input type="text" name="username" placeholder="Email/手机号" />
							</p>
							<span class="blank"></span>
							<p>
								<label>密&nbsp;&nbsp;码:</label>
								<input type="password" name="passpwd" />
							</p>
							<span class="blank"></span>
							<div class="btn">
								<input type="image" src="/Public/Home/Images/login_sub.jpg" />
								<a href="#">密码忘记了?</a>
							</div>
							<span class="blank"></span>
							<div class="login_prompt">
								<span>提示:</span>
								还不是VANCL会员?点击这里 <a href="/index.php/Home/User/regedit">免费注册</a>
								<p>如果您是V+用户可以使用V+用户名进行登录</p>
							</div>
							<div class="glup">
								<span class="blank1"></span>
								<p>使用合作网站账号登录凡客</p>
								<span class="blank1"></span>
								<p>
									<a href="#"><img src="/Public/Home/Images/login_three.jpg" alt=""></a>
								</p>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="login_middle_right">
				<img src="/Public/Home/Images/login_middle.jpg" alt="">
			</div>
			<span class="blank2"></span>
		</div>
		<center>
			<div class="login_bottom">
				<p>Copyright 2007-2013 vancl.com All Rights Reserved 京ICP证100557号 京公网安备11010102000579号 出版物经营许可证新出发京批字直110138号</p>
				<div>
					<a href=""><img src="/Public/Home/Images/footer_11.jpg" alt=""></a>
					<a><img src="/Public/Home/Images/footer_12.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_13.jpg" alt=""></a>
					<a href=""><img src="/Public/Home/Images/footer_14.jpg" alt=""></a>
				</div>
			</div>
		</center>
	</body>
	<script type="text/javascript">
		function CheckPost() {
			if (h_myform.username.value == "") {
				h_myform.username.focus();
				return false;
			}

			if (h_myform.passpwd.value == "") {
				h_myform.passpwd.focus();
				return false;
			}
		}
	</script>
</html>