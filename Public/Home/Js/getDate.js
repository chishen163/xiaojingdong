//将时间戳转换为日期时间格式
function getDate(tm){
		var tt=new Date(parseInt(tm) * 1000).toLocaleString().substr(0,10);
		return tt;
}