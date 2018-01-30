<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>我的资料</title>
		<link rel="stylesheet" type="text/css" href="/fanke/Public/Home/Css/my_userinfo.css">
		<script type="text/javascript" src="/fanke/Public/Home/Js/jquery.js"></script>
		<script src="/fanke/Public/Home/Js/area.js"></script>
	</head>
	<body>	
		<div class="h_content_data">
			<h4>我的资料</h4>
		</div>

		<!-- 个人资料菜单栏 -->
		<div class="h_content_menu">
			<ul class="h_list_menu">
				<li class="h_list_menu_li active" id="my_default_style"><a href="Javascript::">基本资料</a></li>
				<li class="h_list_menu_li"><a href="javascript::">详细资料</a></li>
				<li class="h_list_menu_li"><a href="javascript::">身材/偏好</a></li>
				<li style="float:left;height:30px;list-style:none;width:572px;border-bottom:2px solid #cdcdcd;"></li>
			</ul>
		</div>

		<!--修改头像表单-->
		<form action="/fanke/index.php/Home/MyVancl/upload" method="post"  enctype="multipart/form-data">
			<!-- 上传头像 -->
			<div id="my_photo">
				<img width="100" height="100" src="/fanke/Public/Common/Uploads/Headpic/<?php echo ($user["photoname"]); ?>" id="my_uploaded_photo" />
				<input type="file" name="photo" id="my_will_upload" />
				<p><input type="image" src="/fanke/Public/Home/Images/my_savephoto.jpg" id="upload_btn" /></p>
			</div>
		</form>

			<!-- 当前登录的用户名 -->
			<div id="my_username" >
				<span>用&nbsp;户&nbsp;&nbsp;名:</span>
				<span><?php echo ($user["username"]); ?></span>
			</div>

			<!-- 用户已经验证的邮箱 -->
			<div id="my_email">
				<span>验证过的邮箱:<?php echo ($user['email']); ?></span>
				<span style="font-size:13px;color:red;">(用于收发促销消息,订单信息)</span>			
			</div>

			<!-- 验证手机 -->
			<div id="my_promptinfo" style="font-size:13px;">
				你还没有验证手机,请验证手机,现在<a href="/fanke/index.php/Home/MyVancl/accountsafe">验证</a>,还会增送10积分哦!!
			</div>	
		
		<!-- 填写个人资料form表单 -->
		<form action="/fanke/index.php/Home/MyVancl/update" method="post" name="form1">

			<!-- 设置个人的昵称	 -->
			<div id="my_nickname" class="my_userinfo">
				<span>用户昵称:</span>
				<input type="text" name="nickname" class="my_info_table" value="<?php echo ($user["nickname"]); ?>" />
			</div>

			<!-- 填写个人的真实姓名  -->
			<div id="my_realname" class="my_userinfo">
				<span>真实姓名:</span>
				<input type="text" name="realname" class="my_info_table" value ="<?php echo ($user["realname"]); ?>" />
			</div>

			<!-- 填写性别 -->
			<div id="my_sex" class="my_userinfo">
				<span>性&nbsp;&nbsp;&nbsp;别:</span>
				<input type="radio" value="0" name="sex" <?php if($user["sex"] == 0): ?>checked<?php endif; ?> />女
				<input type="radio" value="1" name="sex" <?php if($user["sex"] == 1): ?>checked<?php endif; ?> />男
			</div>

			<!-- 填写出生日期信息 -->
			<div id="my_birthday" class="my_userinfo">
				<span>出生日期:</span>
				<select id="year" onchange="changeday()" name="year">
					 <option value="<?php echo ($user["year"]); ?>"><?php echo ($user["year"]); ?>年</option>
				 </select>
    				<select id="month" name="month"  onchange="changeday()">
    					<option value="<?php echo ($user["month"]); ?>"><?php echo ($user["month"]); ?>月</option> 
    				</select>
    				<select id="day" name="day" >
    					<option value="<?php echo ($user["day"]); ?>"><?php echo ($user["day"]); ?>日</option>
    				 </select> 
				<em>(注意:出生日期填写后将不可更改,请认真填写,3Q!!)</em>
			</div>

			<!-- 填写用户所属的地区 -->
			<div id="my_area" class="my_userinfo">
				<span style="margin-right:6px;">所属地区:</span><?php echo ($city); ?>				
			</div>

			<!-- 填写用户详细的住址 -->
			<div id="my_detailaddress" class="my_userinfo">
				<span>详细地址:</span>
				<input type="text" name="detailaddress" class="my_info_table" id="my_homeaddr" value="<?php echo ($user["detailaddress"]); ?>" />
			</div>
			
			<!-- 用户所在地区邮政编号 -->
			<div id="my_detailaddress" class="my_userinfo">
				<span>邮政编码:</span>
				<input type="text" name="postalcode" class="my_info_table" style="width:80px;" value="<?php echo ($user["postalcode"]); ?>" />
			</div>

			<!-- 填写个人的手机号 -->
			<div id="my_mobilephone" class="my_userinfo">
				<span>手&nbsp;机&nbsp;号:</span>
				<input type="text" name="mobilephone"  class="my_info_table" value="<?php echo ($user["mobilephone"]); ?>" />
				<a href="/fanke/index.php/Home/MyVancl/accountsafe">去验证>></a>
			</div>
			<div id="my_savebtn" class="my_userinfo">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="image" src="/fanke/Public/Home/Images/my_savebtn.jpg" />
			</div>
		</form>
	</body>

	<!-- JS代码 -->
	<script>
		/*鼠标单击事件*/
		$(".h_list_menu_li").click(function() {
			$(this).siblings().removeClass("active");
			$(this).addClass("active");
		});

		/*鼠标悬停事件hover*/
		$(".h_list_menu_li").hover(function() {
			$(this).addClass("actived");
		}, function() {
			$(this).removeClass("actived");
		});

	//JS出生年月日插件
	 var curdate = new Date(); 
                var year = document.getElementById("year"); 
                var month = document.getElementById("month"); 
                var day = document.getElementById("day"); 
          //绑定年份月分的默认 
          function add() { 
              var curyear = curdate.getFullYear(); 
              var minyear = curyear - 100; 
              var maxyear = curyear + 0; 
			for (maxyear; maxyear >= minyear; maxyear = maxyear - 1) { 
                     year.options.add(new Option(maxyear, maxyear)); 
             	} 
               for (var mindex = 1; mindex <= 12; mindex++) { 
                     month.options.add(new Option(mindex, mindex)); 
              } 
         } 

          //判断是否是闰年 
          function leapyear(intyear) { 
              var result = false; 
              if (((intyear % 400 == 0) && (intyear % 100 != 0)) || (intyear % 4 == 0)) { 
                  result = true; 
              } 
              else { 
                  result = false; 
              } 
              return result; 
          } 
          //绑定天数 
          function addday(maxday) { 
              day.options.length = 1; 
              for (var dindex = 1; dindex <= maxday; dindex++) { 
                  day.options.add(new Option(dindex, dindex)); 
              } 
          } 
          function changeday() { 
              if (year.value == null || year.value == "") { 
                  alert("请先选择年份！"); 
                  return false; 
              } 
              else { 
                  if (month.value == 1 || month.value == 3 || month.value == 5 || month.value == 7 || month.value == 8 || month.value == 10 || month.value == 12) { 
                      addday(31); 
                  } 
                  else { 
                      if (month.value == 4 || month.value == 6 || month.value == 9 || month.value == 11) { 
                          addday(30); 
                      } 
                      else { 
                          if (leapyear(year.value)) { 
                              addday(29); 
                          } 
                          else { 
                              addday(28); 
                          } 
                      } 
                  } 
              } 
          } 
          window.onload = add; 
	</script>
</html>