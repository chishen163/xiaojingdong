<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>账户余额</title>
		<link rel="stylesheet" type="text/css" href="/fanke/Public/Home/Css/accountbalance.css">
	</head>
	<body>
		<div id="balan_div">
			<span><b>账户余额</b></span>
		</div>
		<div id="balan_div1">
			<p>
				<!-- 账户安全等级 -->
				账户安全: <img src="/fanke/Public/Home/Images/account_secury_rank.jpg" alt="">
				<!-- 手机验证 -->
				<span><img src="/fanke/Public/Home/Images/phone_noverify.jpg" alt=""><a href="/fanke/index.php/Home/MyVancl/accountsafe" style="text-decoration:none;">手机未验证</a></span>
				<!-- 邮箱验证 -->
				<span><img src="/fanke/Public/Home/Images/verified_email.jpg" alt=""><a href="/fanke/index.php/Home/MyVancl/accountsafe" style="text-decoration:none;">邮箱已验证</a></span>
				<!-- 设置支付密码 -->
				<span><img src="/fanke/Public/Home/Images/nopay_pwd.jpg" alt=""><a href="/fanke/index.php/Home/MyVancl/accountsafe" style="text-decoration:none;">未设置支付密码</a></span>
				<!-- 安全设置 -->
				<span>为保障账户及资金安全,建议您开启全部 <a href="/fanke/index.php/Home/MyVancl/accountsafe" style="text-decoration:none;color:red;">安全设置</a></span>
				
			</p>
			<p>您的虚拟账户余额:<b style="color:red;margin-left:10px;"><?php echo ($user["usermoney"]); ?>元</b></p>
		</div>
		<div id="balan_main">
			<div id="balan_title">虚拟账户交易记录</div>
			<div id="balan_list">
				<p>时间</p>
				<p>存入 / 取出</p>
				<p>金额</p>
				<p>订单号</p>
			</div>
			<div class="balan_indent" style="height:30px;border:1px solid #cdcdcd;border-top:0px;text-align:center;line-height:30px;"><span style="font-size:13px;color:red;">你暂时还没有交易记录</span></div>
		</div>
	</body>
</html>