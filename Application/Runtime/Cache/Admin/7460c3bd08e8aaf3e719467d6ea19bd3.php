<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商品列表</title>
	<link rel="stylesheet" href="/Public/Admin/Css/Goods/select.css">
	<script src="/Public/Home/Js/jquery.js"></script>
	<script src="/Public/Home/Js/getDate.js"></script>
</head>
<body>
	<div id="goods_box">
		<!-- <div id="goods_title">商品列表</div> -->

		<div id="goods_content">
			<table>
				<tr>
					<td colspan=13>商品种类：
						<select name="category" id="category">
							<option value="0">全部商品</option>
							<?php if(is_array($category)): foreach($category as $key=>$category): ?><option value="<?php echo ($category["id"]); ?>"><?php echo ($category["name"]); ?></option><?php endforeach; endif; ?>
						</select>
						　　　商品分类：
						<select name="plate" id="plate">
							<option value="0">请选择</option>
						</select>

						<input type="button" id="add" value="添加分类">
						<input type="button" id="upd" value="修改分类" disabled="disabled">
						<input type="button" id="del" value="删除分类" disabled="disabled">
					</td>
				</tr>

				<tr style="background:#D9AD73;">
					<th class="sorts" style="cursor:pointer;" alt="1">
						降序↓
					</th>
					<th style="border:none;">商品名</th>
					<th> </th>
					<th>缩略图</th>
					<th>原价</th>
					<th>促销价</th>
					<th>销量</th>
					<th>好评</th>
					<th>差评</th>
					<th>库存</th>
					<th>点击量</th>
					<th>上架时间</th>
					<th>赠送积分</th>
				</tr>
				<tbody id="tbody">

				</tbody>

				<tr id="tool_bottom">
					<td style="width:10px"></td>
					<td colspan="4">
						<select name="check_all" id="check_all">
							<option value="1">全选</option>
							<option value="2" selected>不选</option>
							<option value="3">反选</option>
						</select>
						<button id="del_btn_all" onclick="">删除</button>
					</td>
					<td style="width:500px;"></td>
					<td colspan="7">
						<span>共 <em class="page_count">5</em> 条记录</span>
						<a class="page_home">首页</a>
						<a class="page_prev">上一页</a>
						<span>
							<em class="page_page">4</em>/
							<em class="page_size">5</em>
						</span>
						<a class="page_next">下一页</a>
						<a class="page_last">尾页</a>
					</td>
				</tr>
			</table>
		</div>

		<div class="float_add" style="width:400px;height:100px;">
			<div class="float_title">添加分类</div>
			<div class="float_content">
				<b class="add_title"></b><input type="text" class="addPlate" placeholder="请输入分类名称"><br>
				<input type="button"  value="取消" onclick="fadeOuts('float_add');">
				<input type="button" id="add_btn"  value="确定">
			</div>
		</div>

		<div class="float_del" style="width:400px;height:100px;">
			<div class="float_title">删除分类</div>
			<div class="float_content">
				<span class="del_label" style="margin:10px 0 0 0;display:block;">你确定要删除"<b></b>"分类吗？</span><br>
				<input type="button"  value="取消" onclick="fadeOuts('float_del');">
				<input type="button" id="del_btn"  value="确定">
			</div>
		</div>

		<div class="float_upd" style="width:400px;height:100px;">
			<div class="float_title">修改分类</div>
			<div class="float_content">
				<input type="text" class="updPlate" placeholder="请输入分类名称"><br>
				<input type="button"  value="取消" onclick="fadeOuts('float_upd');">
				<input type="button" id="upd_btn"  value="确定">
			</div>
		</div>

		<img id="goods_minimg" src=""/>
	</div>
</body>
<script>
	var pagecount = 0;//总页数
	var page = 0;//当前页

	$("table").width($(document).width()-10);

	// 商品排序
	$(".sorts").toggle(function(){
		$(this).html("升序↑");
		$(this).attr("alt","2");
		$.get("/admin.php/Admin/Goods/getSort?act="+$(this).attr("alt")+"&cid="+parseInt($("#plate").val()),function(data){
			all_function(data);
			// add_tbody(data);
			// alert(data);
		},"json");
	},function(){
		$(this).html("降序↓");
		$(this).attr("alt","1");
		$.get("/admin.php/Admin/Goods/getSort?act="+$(this).attr("alt")+"&cid="+parseInt($("#plate").val()),function(data){
			all_function(data);
			// add_tbody(data);
			// alert(data);
		},"json");
	});

	// 添加分类
	$("#add").click(function(){
		
		if($("#category").val() < 1){
			alert("请先选择商品种类");
		}else{
			// $(".float_add").css("display","block");
			$(".add_title").html($("#category option[value='"+$("#category").val()+"']").text()+"　->　");
			$(".float_add").fadeIn(500);
		}
	});

	function fadeOuts(data){
		$("."+data+"").fadeOut(500);
	}

	$("#add_btn").click(function(){
		if($(".addPlate").val() == ""){
				alert("请输入有效的分类名称！");
				return false;
			}else{
			$.get("/admin.php/Admin/Goods/addPlate?cid="+$("#category").val()+"&listName="+$(".addPlate").val(),function(data){
				// alert(data);
				if(data > 0){
					alert("添加成功！");
					$("#plate").append("<option value=\""+data+"\">"+$(".addPlate").val()+"</option>");
					$(".float_add").fadeOut(500);
				}else{
					alert("添加失败！请重新尝试！");
				}
				
			});
		}
	});


	//修改分类
	$("#upd").click(function(){
		// alert(2);
		$(".float_upd").fadeIn(500);
		$(".updPlate").val($("#plate option[value='"+$("#plate").val()+"']").text());
		$("#upd_btn").click(function(){
			$.get("/admin.php/Admin/Goods/updPlate?id="+$("#plate").val()+"&listName="+$(".updPlate").val(),function(data){
				// alert(data);
				if(data == 1){
					alert("修改成功！");
					$("#plate option[value='"+$("#plate").val()+"']").text($(".updPlate").val());
					$(".float_upd").fadeOut(500);
				}else{
					alert("修改失败！");
				}
			});
		});
	});

	//删除分类
	$("#del").click(function(){
		// alert("aa");
		$(".float_del").fadeIn(500);
		$(".del_label b").html($("#plate option[value='"+$("#plate").val()+"']").text());
		$("#del_btn").click(function(){
			// alert("bb");
			$.get("/admin.php/Admin/Goods/delPlate?id="+$("#plate").val(),function(data){
				// alert(data);
				if(data == 1){
					$("#plate").find("option[value='"+$("#plate").val()+"']").remove();
					$(".float_del").fadeOut(500);
				}
			});
		});
		
	});

	//加载页面时自动请求数据
	$.get("/admin.php/Admin/Goods/getGoodsAll?id=all",function(data){
		all_function(data);
	},"json");
	
	//商品种类被选择
	$("#category").change(function(){
		//如果其值为0，则查询所有数据
		if(parseInt($(this).attr("value")) == 0){
			$.get("/admin.php/Admin/Goods/getGoodsAll?id=all",function(data){
				$("#plate").empty().append("<option>请选择</option>");
				all_function(data);
			},"json");
			$("#upd").attr("disabled","disabled");
			$("#del").attr("disabled","disabled");
		}else{
				$.get("/admin.php/Admin/Goods/getPlate",{id:$("#category").attr("value")},function(data){
				var options = "";
					options += "<option value='0'>请选择</option>";
				for(var i=0;i<data.length;i++){
					options += "<option value="+data[i]['id']+">"+data[i]['listName']+"</option>";
				}
				$("#plate").empty().append(options);
				
			},"json");
		}
	});

	// 商品分类被选择
	$("#plate").change(function(){
		if($("#plate").val() < 1){
			$("#upd").attr("disabled","disabled");
			$("#del").attr("disabled","disabled");
		}else{
			$("#upd").removeAttr("disabled");
			$("#del").removeAttr("disabled");
		}
		$.get("/admin.php/Admin/Goods/getGoods",{id:$("#plate").val()},function(data){
			all_function(data);
		},"json");
	});

	
	function hover(){
		$(".mouse_img").hover(function(){
			if($(this).attr("src") != "/progect/Public/Home/Images/goods/"){
				$("#goods_minimg").css("display","block");
				$("#goods_minimg").attr("src",$(this).attr("src"));
			}else{
				 
			}
		},function(){
			$("#goods_minimg").css("display","none");
		});
	}

	// 动态添加商品列表
	function add_tbody(data){
		$td = "";
		if(parseInt(data) == 0){
			$td += "<tr class='tr_hover'><td colspan=14>抱歉，此类还没有商品！</td></tr>";
		}else{
			for(var i=0;i<data.length;i++){
				$td += "<tr class='tr_hover' alt=\""+data[i]['id']+"\">";
				$td += "<td style='width:70px;'><input type='checkbox' class='id_check' name='checkbox[]' value=\""+data[i]['id']+"\">"+data[i]['id']+"</td>";
				$td += "<td style='text-align:left;' title='"+data[i]['goodsname']+"'><a class='goodsname'>"+data[i]['goodsname']+"</a></td>";
				$td += "<td class='td_imgbtn'><a class='img_update' href='javascript:' title='修改' alt='"+data[i]['id']+"'></a><a class=\"img_delete\" href='javascript:' title='删除' alt='"+data[i]['id']+"' onclick=\"return confirm('确认要删除商品吗？');\"></a></td>";
				$td += "<td><img style='border-radius:5px;' class=\"mouse_img\" src='/Public/Home/Images/goods/"+data[i]['goodsimg']+"' width='30' height='25'></td>";
				$td += "<td class='goodsprice'><del style=\"color:#999;\">"+data[i]['goodsprice']+"</del>￥</td>";
				$td += "<td class='promoteprice'><b style=\"color:red;\">"+data[i]['promoteprice']+"</b>￥</td>";
				$td += "<td class='goodssales'>"+data[i]['goodssales']+"</td>";
				$td += "<td class='isGood'>"+data[i]['isGood']+"</td>";
				$td += "<td class='isPoor'>"+data[i]['isPoor']+"</td>";
				$td += "<td class='goodsnumber'>"+data[i]['goodsnumber']+"</td>";
				$td += "<td class='clickcount'>"+data[i]['clickcount']+"</td>";
				$td += "<td class='addtime'>"+getDate(data[i]['addtime'])+"</td>";
				$td += "<td class='giveintegra'>"+data[i]['giveintegral']+"</td>";
				$td += "</tr>";
			}
		}
		$("#tbody").empty().append($td);
	}

	//首页
	$(".page_home").click(function(){
		$.get("/admin.php/Admin/Goods/getGoodsAll?id=all&page=1",function(data){
			all_function(data);
		},"json");
	});

	// 上一页
	$(".page_prev").click(function(){
		if(parseInt(page) != 1){
			$.get("/admin.php/Admin/Goods/getGoodsAll?id=all&page="+(parseInt(page)-1),function(data){
				all_function(data);
			},"json");
		}
	});

	//下一页
	$(".page_next").click(function(){
		if(parseInt(page) != pagecount){
			$.get("/admin.php/Admin/Goods/getGoodsAll?id=all&page="+(parseInt(page)+1),function(data){
				all_function(data);
			},"json");
		}
	});

	//尾页
	$(".page_last").click(function(){
		$.get("/admin.php/Admin/Goods/getGoodsAll?id=all&page="+pagecount,function(data){
			all_function(data);
		},"json");
	});

	//将所有其他函数放到一起调用
	function all_function(data){
		data != 0 ? add_tbody(data['goods']) : add_tbody(data);
		hover();
		goods_delete();
		goods_update();
		if(data != 0){
			page_function(data['page']['count'],data['page']['page'],data['page']['pagecount']);
		}else{
			page_function(0,0,0);
		}
	}
	
	//page_function(数据总数,页码,共多少页)
	function page_function(counts,pages,pgcounts){
		$(".page_count").html(counts);
		$(".page_page").html(pages);
		$(".page_size").html(pgcounts);
		pagecount = pgcounts;
		page = pages;
	}

	//全选、多选按钮
	$("#check_all").change(function(){
		var value = $(this).attr("value");
		switch(parseInt(value)){
			case 1:
				$(".id_check").attr("checked",true);
				break;
			case 2:
				$(".id_check").attr("checked",false);
				break;
			case 3:
				$("input[type='checkbox']").each(function(){
					if($(this).attr("checked")){
						$(this).removeAttr("checked");
					}else{
						$(this).attr("checked","true");
					}
				});
				break;
		}
	});

	//删除数据
	function goods_delete(){
		$(".img_delete").click(function(){
			var id = $(this).attr("alt");
			$.get("/admin.php/Admin/Goods/getDelete?id="+id,function(data){
				$("tr[alt='"+id+"']").fadeOut(500);
			});
		});
	}

	//修改数据
	function goods_update(){
		$(".img_update").click(function(){
			location.href = "/admin.php/Admin/SavaGoods/index?id="+$(this).attr("alt");
		});
	}

	// 多选删除
	$("#del_btn_all").click(function(){
		//声明一个数组，将选中的值放到数组中
		var arr = Array();
		var brr = Array();
		if($("input:checked").length < 1){
			alert("请选择要删除的商品");
			return false;
		}else{
			for(var i=0;i<$("input[type='checkbox']:checked").length;i++){
				//循环一次就将值写入到数组中
				arr.push($("input[type='checkbox']:checked").eq(i).val());
			}

			//将数组拆分成字符串传递给php
			brr = arr;
			arr.join(",");

			if(confirm("选中商品 "+$("input[type='checkbox']:checked").length+" 条,确定要删除?")){
				$.get("/admin.php/Admin/Goods/checkAll?id="+arr,function(data){
					if(data == 1){
						alert("删除成功！");
						for(var i=0;i<brr.length;i++){
							$("tr[alt='"+brr[i]+"']").fadeOut(500);
						}
						$("input:checked").remove().fadeOut(500);
					}else{
						alert("删除失败！");
					}
				},"json");
			}else{
				return false;
			}
		}	
	});

	$("#tool_bottom").css({"position":"absolute","left":"0","bottom":"0"});
</script>
</html>