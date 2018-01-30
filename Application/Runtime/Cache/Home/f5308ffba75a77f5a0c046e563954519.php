<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>修改密码</title>
	</head>
	<script type="text/javascript" src="/fanke/Public/Home/Js/jquery.js"></script>
	<style type="text/css">
		*{
			padding:0px;
			margin:0px;
		}
		#upd_pwd_top{
			border-bottom:2px solid #f4f4f4;
		}
		.updpwd_info{
			min-height:50px;
			line-height:50px;
			/*margin-top:30px;*/
		}
		.updpwd_info>span{
			height:50px;
			width:260px;
			text-align:right;
			margin-right:15px;
			margin-left:300px;
		}
		.updpwd_info>input{
			height:22px;
			width:230px;
		}
	</style>
	<body>
		<div id="upd_pwd_top">
			<span style="font-weight:bold;border-bottom:2px solid #910000;height:25px;width:100px;text-align:center;">修改密码</span>
			<span style="color:#666666;font-size:13px;height:25px;margin-left:400px;">为了保障你的账户安全,建议避免使用与其它网站相同的密码</span>
		</div>

		<!-- 修改密码表单 -->
		<form action="/fanke/index.php/Home/MyVancl/updpwd/id/<?php echo ($user["id"]); ?>" method="post">
			<!-- 旧密码 -->
			<p  class="updpwd_info" style="margin-bottom:20px;margin-top:50px;"><span>旧密码:</span><input type="password" name="passpwd" /></p>
			<!-- 新密码 -->
			<p class="updpwd_info"><span>新密码:</span><input type="password" name="newpwd" id="upd_pwd_new" /></p>
			<h5 style="height:30px;width:300px;margin-left:370px;line-height:30px;color:#999999;" id="updpwd_prompte1"></h5>
			<!-- 再次确认新密码 -->
			<p style="margin-left:251px;margin-bottom:15px;"><span>请确认新密码:</span><input type="password" name="renewpwd" style="height:22px;width:230px;margin-left:15px;" id="upd_pwd_renew" /></p>
			<h5 style="height:30px;width:300px;margin-left:370px;line-height:30px;color:#999999;" id="updpwd_prompte2"></h5>
			<!-- 验证码 -->
			<p style="margin-left:370px;margin-top:10px;"><span></span><img src="/fanke/index.php/Home/MyVancl/code" onclick="this.src = this.src + '?' + new Date().getTime();"/></p>
			<!-- 输入验证码 -->
			<p style="margin-left:235px;margin-top:10px;"><span>请输入上面验证码:</span><input type="text" name="code" style="height:22px;width:160px;"/></p>

			<p style="margin-left:370px;margin-top:20px;"><span></span><input type="image" src="/fanke/Public/Home/Images/upd_pwd_confirm.jpg" /></p>
		</form>
	</body>
	<script>
		// 获得焦点时的提示信息
		$("#upd_pwd_new").focus(function() {
			$("#updpwd_prompte1").html("6-15位字符,可以使用数字、字母和下划线的组合");
		});
		$("#upd_pwd_renew").focus(function() {
			$("#updpwd_prompte2").html("请再次输入新密码,两次输入必须一致");
		});

		// 失去焦点时输出的提示信息
		$("#upd_pwd_new").blur(function() {
			var pwd = $("input[name=newpwd]").val(); //犯了一个先后的逻辑错误
			var len = $("#upd_pwd_new").val().length;

			if (pwd == '') {
				$("#updpwd_prompte1").html("请输入密码");
			} else if (len < 6) {
				$("#updpwd_prompte1").html("请输入至少6位以上的字符");
			} else if (len > 5) {
				$("#updpwd_prompte1").html("");
			}
		});
		$("#upd_pwd_renew").blur(function() {
			var repwd = $("#upd_pwd_renew").val();
			var pwd = $("input[name=newpwd]").val();
			if (pwd == repwd) {
				$("#updpwd_prompte2").html("两次输入密码相同");
			} else {
				$("#updpwd_prompte2").html("两次输入密码不一致");
			}
			
		});
	</script>
</html>