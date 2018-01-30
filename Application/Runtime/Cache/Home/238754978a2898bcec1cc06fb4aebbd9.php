<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>凡客诚品 - 会员免费注册</title>
		<link rel="stylesheet" type="text/css" href="/fanke/Public/Home/Css/regedit.css">
		<script type="text/javascript" src="/fanke/Public/Home/Js/jquery.js"></script>
	</head>
	<body>
		<div id="regedit_top">
			<a href="/fanke/index.php/Home/Index/index"><img src="/fanke/Public/Home/Images/login_a1.jpg" title="凡客诚品" alt="凡客诚品" /></a>
		</div>

		<!-- 注册账户页面 -->
		<div id="regedit_middle">
			<div class="regedit_middle_div1">
				注册新用户
			</div>
			<div class="regedit_middle_div2">
				<div class="middle_left">
					<center>

						<!-- 选择注册账户所用的账号方式 -->
						<div class="regedit_method">
							<div class="method_selector">
								<img src="/fanke/Public/Home/Images/select_1.jpg" alt="" /><p>选择注册方式:</p>
							</div>
							<div class="method_selector1">
								<a href="javascript::" class="method1"><img src="/fanke/Public/Home/Images/regedit_method_pic1.jpg" alt="" /></a>
								<a href="javascript::" class="method2"><img src="/fanke/Public/Home/Images/regedit_method_pic2.jpg" alt="" /></a>
							</div>
						</div>

						<!-- 填写注册信息 -->
						<form action="/fanke/index.php/Home/User/reg" method="post" onsubmit = "return fun()">
							<div id="regedit_info">
								<p id="write_info">
									<img src="/fanke/Public/Home/Images/select_2.jpg" alt="" />
									<span>填写您的信息:</span>
								</p>

								<!-- 填写用户邮箱作为账户名称 -->
								<div class="user_info" id="user_info_first">
									<span class="titl">&nbsp;&nbsp;&nbsp;Email地址:</span> 
									<input type="email" name="username" class="email" />
									<span class="prompt_info"></span>
								</div>

								<!-- 填写账户登录密码 -->
								<div class="user_info">
									<span class="titl">设定登录密码: </span>
									<input type="password" name="passpwd" class="userpwd"/>
									<span class="prompt_info"></span>
								</div>

								<!-- 再次确认账户登录密码 -->
								<div class="user_info">
									<span class="titl">再次输入密码:</span> 
									<input type="password" name="repwd" class="repwd"/>
									<span class="prompt_info"></span>
								</div>

								<!-- 输入验证码 -->
								<div class="user_info" style="height:65px">
									<span class="titl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;验证码: </span>
									<input type="text" name="code" class="code" id="code1" />									
									<span class="prompt_info" id="ppt"></span>
									<img src="/fanke/index.php/Home/User/code" class="h_img" onclick="this.src = this.src + '?' + new Date().getTime();"/>
								</div>

								<!-- 提交button -->
								<div class="user_btn">
									<p>请阅读<a href="">《VANCL凡客诚品服务条款》</a></p>
									<input type="image" src="/fanke/Public/Home/Images/regedit_btn.jpg" />
								</div>							
							</div>
						</form>
					</center>
				</div>
				<div class="middle_right">
					<center>
						我已经注册,现在就
						<a href="/fanke/index.php/Home/User/login"><input type="button" value="登录" class="swth" /></a>
					</center>
				</div>	
			</div>
		</div>

		<!-- 底部页脚部分 -->
		<div id="regedit_bottom">
			<center>
				<p>Copyright 2007 - 2013 vancl.com All Rights Reserved 京ICP证100567号 京公网安备11010102000579号 出版物经营许可证新出发京批字第直110138号</p>
				<div class="bottom">
					<a href="javascript::"><img src="/fanke/Public/Home/Images/footer_11.jpg" alt="" /></a>
					<a href="javascript::"><img src="/fanke/Public/Home/Images/footer_12.jpg" alt="" /></a>
					<a href="javascript::"><img src="/fanke/Public/Home/Images/footer_13.jpg" alt="" /></a>
					<a href="javascript::"><img src="/fanke/Public/Home/Images/footer_14.jpg" alt="" /></a>
				</div>
			</center>
		</div>
	</body>
	<script type="text/javascript">
		var isname = false;
		var ispwd = false;
		var isrepwd = false;
		var iscode  = false;

		/*鼠标悬停事件*/
		$("div:.user_info,.user_btn").bind("mouseover", function() {
			$(this).addClass("cont");
		});
		$("div:.user_info,.user_btn").bind("mouseout", function() {
			$(this).removeClass("cont");
		});

		/*form表单输入框获得焦点时,设置的提示信息*/
		$("input:.email").focus(function() {
			$(this).next().html("Email作为账户，用于接收信息、订单及找回密码等");
			$(this).next().css("color","");
		});
		$("input:.userpwd").focus(function() {

			$(this).next().html("6位以上的字母、数字和下划线字符组合");
			$(this).next().css("color","");
		});
		$("input:.repwd").focus(function() {

			$(this).next().html("请再次输入登录密码，两次必须一致");
			$(this).next().css("color","");
		});
		$("input:.code").focus(function() {
			$(this).next().html("请输入图片中的字符，大小写不限");
			$(this).next().css("color","");
		});

		/*验证邮箱格式是否正确*/
		$("input:.email").blur(function() {
			var $str = $(this).val();
			var pattern = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;

			if ($str != '') {
				if (pattern.test($str)) {
					$.post("/fanke/index.php/Home/User/checkName",{'username':$str}, function(data) {

						$(".email").next().html(data);
						if (data == "用户名已经注册过") {						
							$(".email").next().css("color","red");
							isname = false;
						} else if (data == "用户名可用") {
							$(".email").next().css("color","blue");
							isname = true;
						}					
					});			      			     
				} else {
				      $(this).next().html("错误的邮箱,请填写合法的邮箱地址");
				      $(this).next().css("color","red");
				      isname = false;
				}
			} else {
				$(this).next().html("邮箱不能为空");
				$(this).next().css("color","red");
				isname = false;
			}
		});

		/*检索密码字符数不得少于6位*/
		$("input:.userpwd").blur(function() {
			var $str = $(this).val();
			var len = $str.length;
			if(len > 5) {
				$(this).next().html("密码位数符合规定的字符数");
				$(this).next().css("color","blue");
				ispwd = true;
			} else if (len == 0) {
				$(this).next().html("密码不能为空");
				$(this).next().css("color","red");
			} else {
				$(this).next().html("密码少于6位，不符合规定");
				$(this).next().css("color","red");
				ispwd = false;
			}
		});

		/*检索两次密码输入是否一致*/
		$("input:.repwd").blur(function() {
			var len1 = $(this).val().length;
			var len2 = $("input:.userpwd").val().length;

			if (len2 == 0) {
				$(this).next().html("密码不能为空");
				$(this).next().css("color","red");
			} else if(len1 == len2) {
				$(this).next().html("两次输入的密码一致");
				$(this).next().css("color","blue");
				isrepwd = true;
			} else {
				$(this).next().html("两次输入的密码不一致");
				$(this).next().css("color","red");
				isrepwd = false;
			}
		});

		/*验证码失去焦点时的行为*/
		$("input:.code").blur(function() {
			var len = $(this).val().length;
			if(len < 1){
				$(this).next().html("验证码不能为空");
				$(this).next().css("color","red");
				iscode = false;
			} else {
				$(this).next().html("");
				iscode = true;
			}
			
		});

		/*当点击提交时,调用此函数*/
		function fun() {
			if(isname && ispwd && isrepwd) {
				return true;
			} else {
				if(!isname) {
					$("input:.email").next().html("请输入正确的邮箱");
				}

				if(!ispwd) {
					$("input:.userpwd").next().html("请输入至少6位字符");
				}

				if(!isrepwd) {
					$("input:.repwd").next().html("两次必须输入一样的密码");
				}

				return false;
			}
		}


	</script>
</html>