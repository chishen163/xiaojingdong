<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<title>发票</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/Public/Admin/Css/z_delivery.css">
		<script src="/Public/Admin/Js/jquery.js"></script>
		<script type="text/javascript">
			$(function(){
				$("tr:odd").addClass("odd");  /* 奇数行添加样式*/
				$("tr:even").addClass("even"); /* 偶数行添加样式*/
			})
		</script>
		<style>
			.even { 
				background:#FFF38F;
			}  /* 偶数行样式*/
			.odd { 
				background:#FFFFEE;
			}  /* 奇数行样式*/
		</style>
	</head>
	<body>
		<div id="receipt">
			<div class="receipt_search">
				<div>
					<div>
						<span>请输入搜索内容：</span>
						<input type="text" name="keywords">
					</div>
					<button>搜索</button>
				</div>
			</div>
			<div class="receipt_title">发票列表：</div>
			<div class="receipt_content">
				<table class="receipt_table">
					<tr>
						<th>选择</th><th>发票编号</th><th>订单编号</th><th>用户名</th><th>发票类型</th><th>发票标题</th><th>发票内容</th><th>生成时间</th><th>打印状态</th><th>完善状态</th>
					</tr>

					<?php if(is_array($receipt_data)): foreach($receipt_data as $key=>$rec): ?><!-- 发票遍历的开始 -->
					<tr>
						<td><input type="checkbox" name="ids" value="<?php echo ($rec["id"]); ?>" class="receipt_status"></td>
						<td><a href="javascript:skim('<?php echo ($rec["id"]); ?>', 'print')"><?php echo ($rec["rec_sn"]); ?></a></td>
						<td><?php echo ($rec["ordersn"]); ?></td>
						<td><?php echo ($rec["username"]); ?></td>
						<td><?php echo ($rec["user_type"]); ?></td>
						<td><?php echo ($rec["rec_title"]); ?></td>
						<td><?php echo ($rec["rec_content"]); ?></td>
						<td><?php echo (date("Y-m-d H:i:s", $rec["addtime"])); ?></td>
						<td>
							<input type="checkbox" name="print" value="1" <?php if($rec['print'] == 1): ?>checked<?php endif; ?>/>是
							<input type="checkbox" name="print" value="0" <?php if($rec['print'] == 0): ?>checked<?php endif; ?>/>否
						</td>
						<td>
							<input type="checkbox" name="isprefect" value="1" <?php if($rec['isprefect'] == 1): ?>checked<?php endif; ?>>已完善
							<input type="checkbox" name="isprefect" value="0" <?php if($rec['isprefect'] == 0): ?>checked<?php endif; ?>><a href="javascript:skim('<?php echo ($rec["id"]); ?>', 'prefect')">去完善</a>
						</td>
					</tr>
					<!-- 发票遍历的结束 --><?php endforeach; endif; ?>
					<tr>
						<td colspan="10" class="receipt_quick">
							<input type="button" value="全选" onclick="qx()">
							<input type="button" value="反选" onclick="fx()">
							<input type="button" value="全不选" onclick="qbx()">
							<input type="button" value="删除" onclick="dels()">
							<input type="button" value="设为已打印" onclick="action()">
						</td>
					</tr>
				</table>
				<div class="del_page"><?php echo ($page); ?></div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		//获取批量数据id值函数
		function getIds() {

			/*
				此时需要通过js方式获取所有复选框的选中状态，并且获得其value值传递到控制器中去
				算法是：先获取满足条件input输入框的个数
				声明一个空数组用来存取每个输入框的id值
				通过for循环遍历出所有满足条件的id值
				注意要使用eq()来过滤，下标从0开始读取
				然后使用jQuery中的ajax请求控制器中的方法，将订单表中的字段修改为已付款状态
			*/
			var length = $('input[type=checkbox].receipt_status:checked').length;
			var ids = new Array();
			for(var i = 0; i < length; i++) {
				ids[i] = $('input[type=checkbox].receipt_status:checked').eq(i).val();
			}

			//返回一个数组给调用处
			return ids;
		}

		//点击完善发票编时触发的方法，传递发票id
		function skim(id, status) {

			$.post("/admin.php/Admin/Delivery/prefect", {id : id, status : status}, function(data) {
				$('#receipt').html(data);
			});
		}

		/*
			定义一个函数，用来局部动态请求该页面，每次点击页码时都是局部刷新操作，
			注意，不要自动调用一次该函数，否则会无限循环调用下去
			但是修改了框架中的分页类，重新改名为Page_ajax.class.php
			原分页类仍然是原名，不受影响
		*/
		function setPage(url) {
			$.get(url, function(data) {
				$('#receipt').html(data);
			});
		}

		/*
			全选，反选，全不选函数集合
			选中元素的方式$('input[type=checkbox].delivery_status')，过滤掉后面的状态按钮
		*/

		//全选函数
		function qx() {
			$('input[type=checkbox].receipt_status').attr('checked', 'true');
		}

		//反选函数
		function fx() {
			var length = $('input[type=checkbox].receipt_status').length;
			for(var i = 0; i < length; i++) {
				$('input[type=checkbox].receipt_status').eq(i).attr('checked', !$('input[type=checkbox].receipt_status').eq(i).attr('checked')) ;
			}
		}

		//全不选函数
		function qbx() {
			$('input[type=checkbox].receipt_status').removeAttr('checked');
		}

		//快捷批量删除操作，该页面没有单条数据删除的操作
		function dels() {

			//通过自定义函数获取要删除的批量发票id值数组
			var ids = getIds();

			if (confirm("你确认要删除这些发票吗？")) {

				$.post("/admin.php/Admin/Delivery/receiptDel", {ids : ids}, function(data) {
					$('#receipt').html(data);
				});
			}
		}
	</script>
</html>