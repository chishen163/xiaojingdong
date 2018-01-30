<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>网站基本配置</title>
		<style type="text/css">
			body{
				background:url("/fanke/Public/Admin/Images/w70.png") repeat;
			}
			table{
				border-collapse:collapse;
			}
			tr{
				border-top:2px solid #f9f0e1;
			}
			td{
				height:60px;
			}
			tr:hover{
				background:#f9f0e1;
			}
			th{
				color:#d39c59;
				line-height:40px;
			}
			td{
				text-align:
			}
			#tooltip{
                        position:absolute;
                        border:1px solid #ccc;
                        background:#333;
                        padding:2px;
                        display:none;
                        color:#fff;
                 } 
                 textarea{
                 	padding:5px;
                 	margin-left:20px;
                 }
		</style>
		<script src="/fanke/Public/Admin/Js/jquery.js"></script>
	</head>
	<body id="page_ing">
		<center width="1100" style="height:50px;line-height:50px;"><b style="font-size:30px;color:#d39c59;">网站基本配置</b></center>
		<center>
			<table width="850">
		
				<?php if(is_array($setup)): foreach($setup as $key=>$st): ?><tr>
						<th>网站标题 :</th>
						<td><textarea name="title" id="" cols="80" rows="3"><?php echo ($st["title"]); ?></textarea></td>
					</tr>
					<tr>
						<th>网站版权 :</th>
						<td><textarea name="copy" id="" cols="80" rows="3"><?php echo ($st["copy"]); ?></textarea></td>
					</tr>
					<tr>
						<th>网站Logo :</th>
						<td><a href="/fanke/Public/Common/Uploads/Photos/<?php echo ($st["logo"]); ?>" class="tooltip"><img src="/fanke/Public/Common/Uploads/Photos/<?php echo ($st["logo"]); ?>" alt="" height="60" style="margin-left:20px;"></a></td>
					</tr>
					<tr>
						<th>网站关键字 :</th>
						<td><textarea name="keywords" id="" cols="80" rows="3"><?php echo ($st["keywords"]); ?></textarea></td>
					</tr>
					<tr>
						<th>网站描述 :</th>
						<td><textarea name="description" id="" cols="80" rows="3"><?php echo ($st["description"]); ?></textarea></td>
					</tr>
					<tr>
						<th>今日搜索 :</th>
						<td><textarea name="hotsearch" id="" cols="80" rows="3"><?php echo ($st["hotsearch"]); ?></textarea></td>
					</tr>
					<tr>
						<th>网站作者 :</th>
						<td><textarea name="author" id="" cols="80" rows="3"><?php echo ($st["author"]); ?></textarea></td>
					</tr>
					<tr>
						<th>是否启用 :</th>
						<td style="color:#ff9d59;"><span style="margin-left:20px;"><?php echo ($st["status"]); ?></span></td>
						
							
						
					</tr>
					<tr>
						<th>配置操作:</th>
						<td  style="line-height:50px;" colspan="4">
							<a href="/fanke/admin.php/Admin/WebSet/updWebSet/id/<?php echo ($st["id"]); ?>" style="text-decoration:none;margin-left:20px;">修改</a> | <a href="/fanke/admin.php/Admin/WebSet/delWebSet/id/<?php echo ($st["id"]); ?>" style="text-decoration:none;">删除</a> | 
						
						<!-- <td align="center"  style="line-height:50px;"> -->
							<a href="/fanke/admin.php/Admin/WebSet/addWebSet" style="text-decoration:none;">添加配置</a>
						</td>
					</tr><?php endforeach; endif; ?>
			</table>
		</center>
	</body>
	<script type="text/javascript">

		//鼠标悬停头像,使之放大
          	var x = 70;
       	var y = 80;
        	$("a.tooltip").mouseover(function(e){
            this.myTitle = this.title;
            this.title = "";
            var imgTitle = this.myTitle? "<br/>" + this.myTitle : "";
            var tooltip = "<div id='tooltip'><img src='"+ this.href +"' alt='精品预览图'/ width='200' height='160'>"+imgTitle+"<\/div>"; //创建 div 元素
            $("body").append(tooltip);  //把它追加到文档中
            $("#tooltip")
              .css({
                "top": (e.pageY-y) + "px",
                "left":  (e.pageX+x)  + "px"
              }).show("fast");    //设置x坐标和y坐标，并且显示
            }).mouseout(function(){
            this.title = this.myTitle;
            $("#tooltip").remove();  //移除
            }).mousemove(function(e){
            $("#tooltip")
              .css({
                "top": (e.pageY-y) + "px",
                "left":  (e.pageX+x)  + "px"
              });
          	});
	</script>
</html>