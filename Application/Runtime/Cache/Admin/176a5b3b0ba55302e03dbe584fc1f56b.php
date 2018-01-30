<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商品列表</title>
	<link rel="stylesheet" href="/fanke/Public/Admin/Css/Goods/slide.css">
	<script src="/fanke/Public/Home/Js/jquery.js"></script>
	<script src="/fanke/Public/Home/Js/getDate.js"></script>

</head>
<body>
	<div id="goods_box">
		<!-- <div id="goods_title">商品列表</div> -->

		<div id="goods_content">
			<table border=1 width="970">
				<tr>
					<td colspan=8>广告位置：
						<select name="category" id="category">
							<option value="0">首页</option>
							<?php if(is_array($category)): foreach($category as $key=>$category): ?><option value="<?php echo ($category["id"]); ?>"><?php echo ($category["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</td>
				</tr>

				<tr>
					<th>ID</th>
					<th>图片地址</th>
					<th style="width:400px">链接地址</th>
					<th> </th>
					<th>是否显示</th>
					<th>打开方式</th>
					<th>添加时间</th>
					<th>排序</th>
				</tr>

				<tbody id="tbody">
				
				</tbody>

				<tr id="tool_bottom">
					<td style="width:10px"></td>
					<td colspan="3">
						<select name="check_all" id="check_all">
							<option value="1">全选</option>
							<option value="2" selected>不选</option>
							<option value="3">反选</option>
						</select>
						<button id="del_btn_all" onclick="">删除</button>
					</td>
					<td style="width:500px;"></td>
					<td colspan="3">
						<span>共 <em class="page_count">5</em> 条记录</span>
						<a class="page_home" href="javascript:">首页</a>
						<a class="page_prev" href="javascript:">上一页</a>
						<span>
							<em class="page_page">4</em>/
							<em class="page_size">5</em>
						</span>
						<a class="page_next" href="javascript:">下一页</a>
						<a class="page_last" href="javascript:">尾页</a>
					</td>
				</tr>
			</table>
		</div>

		<img id="goods_minimg" src=""/>
	</div>
</body>
<script>
	var pagecount = 0;//总页数
	var page = 0;//当前页

	$("table").width($(document).width()-10);
	
	$("#category").change(function(){
		$.get("/fanke/admin.php/Admin/Slide/gethome?id="+$(this).val(),function(data){
			all_function(data);
		},"json");
	});

	//加载时自动请求数据
	$.get("/fanke/admin.php/Admin/Slide/gethome?id=0",function(data){
		all_function(data);
	},"json");

	function add_tbody(data){
		$td = "";
		var show=opentype="";
		if(parseInt(data) == 0){
			$td += "<tr><td colspan=7 align=center>抱歉，此类还没有广告！</td></tr>";
		}else{
			for(var i=0;i<data.length;i++){
				$td += "<tr class='tr_hover' alt=\""+data[i]['id']+"\">";
				$td += "<td style='width:50px;'><input type='checkbox' class='id_check' name='checkbox[]' value=\""+data[i]['id']+"\"></td>";
				$td += "<td><img class=\"mouse_img\" style=\"width:25px;height:25px;border-radius:5px;margin-top:5px;\" src=\"/fanke/Public/Home/Images/slide/"+data[i]['address']+"\" title="+data[i]['address']+"></td>";
				$td += "<td style=\"text-align:left;overflow:hidden;\"><a href=\""+data[i]['links']+"\">"+data[i]['links']+"</a></td>";
				$td += "<td class='td_imgbtn'><a class='img_update'  title='修改' alt='"+data[i]['id']+"'></a><a class=\"img_delete\"  title='删除' alt='"+data[i]['id']+"'></a></td>";
					data[i]['isshow'] = 1 ? show = "显示" : show = "不显示";
				$td += "<td>"+show+"</td>";
					switch(parseInt(data[i]['opentype'])){
						case 1 : opentype = "新窗口打开";break;
						case 2 : opentype = "父窗口打开";break;
						case 3 : opentype = "当前窗口打开";break;
						case 4 : opentype = "顶级窗口打开";break;
					}
				$td += "<td>"+opentype+"</td>";
				$td += "<td>"+getDate(data[i]['addtime'])+"</td>";
				$td += "<td>"+data[i]['orders']+"</td>";
				$td += "</tr>";
			}
		}
		$("#tbody").empty().append($td);
	}
	
	function hover(){
		$(".mouse_img").hover(function(){
			if($(this).attr("src") != "/progect/Public/Home/Images/slide/"){
				$("#goods_minimg").css("display","block");
				$("#goods_minimg").attr("src",$(this).attr("src"));
			}else{
				 
			}
		},function(){
			$("#goods_minimg").css("display","none");
		});
	}

	//将所有其他函数放到一起调用
	function all_function(data){
		data != 0 ? add_tbody(data['slide']) : add_tbody(data);
		hover();
		goods_delete();
		goods_update();
		page_function(data['page']['count'],data['page']['page'],data['page']['pagecount']);
	}

	//page_function(数据总数,页码,共多少页)
	function page_function(counts,pages,pgcounts){
		$(".page_count").html(counts);
		$(".page_page").html(pages);
		$(".page_size").html(pgcounts);
		pagecount = pgcounts;
		page = pages;
	}

		//首页
	$(".page_home").click(function(){
		$.get("/fanke/admin.php/Admin/Slide/gethome?id="+$("#category").val()+"&page=1",function(data){
			all_function(data);
		},"json");
	});

	// 上一页
	$(".page_prev").click(function(){
		if(parseInt(page) != 1){
			$.get("/fanke/admin.php/Admin/Slide/gethome?id="+$("#category").val()+"&page="+(parseInt(page)-1),function(data){
				all_function(data);
			},"json");
		}
	});

	//下一页
	$(".page_next").click(function(){
		if(parseInt(page) != pagecount){
			$.get("/fanke/admin.php/Admin/Slide/gethome?id="+$("#category").val()+"&page="+(parseInt(page)+1),function(data){
				all_function(data);
				alert(Request['id']);
			},"json");
		}
	});

	//尾页
	$(".page_last").click(function(){
		$.get("/fanke/admin.php/Admin/Slide/gethome?id="+$("#category").val()+"&page="+pagecount,function(data){
			all_function(data);
		},"json");
	});


	//全选、多选
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

	// 删除按钮
	function goods_delete(){
		$(".img_delete").click(function(){
			var id = $(this).attr("alt");
			$.get("/fanke/admin.php/Admin/Slide/getDelete?id="+id,function(data){
				if(data > 0){
					$("tr[alt='"+id+"']").fadeOut(500);
				}
			},"json");
		});
	}

	//修改按钮
	function goods_update(){
		$(".img_update").click(function(){
			location.href = "/fanke/admin.php/Admin/SavaSlide/index?id="+$(this).attr("alt");
		});
	}

	// 多选删除
	$("#del_btn_all").click(function(){
		//声明一个数组，将选中的值放到数组中
		var arr = Array();
		var brr = Array();
		if($("input:checked").length < 1){
			alert("请选择要删除的广告");
			return false;
		}else{
			for(var i=0;i<$("input[type='checkbox']:checked").length;i++){
				//循环一次就将值写入到数组中
				arr.push($("input[type='checkbox']:checked").eq(i).val());
			}

			//将数组拆分成字符串传递给php
			brr = arr;
			arr.join(",");
			// alert(arr);
			if(confirm("选中 "+$("input[type='checkbox']:checked").length+" 条广告,确定要删除吗?")){
				$.get("/fanke/admin.php/Admin/Slide/checkAll?id="+arr,function(data){
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


	//页脚工具栏(翻页。。)定位
	$("#tool_bottom").css({"position":"absolute","left":"0","bottom":"0"});
</script>
</html>