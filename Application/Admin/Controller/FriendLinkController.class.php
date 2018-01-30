<?php
namespace Admin\Controller;
use Think\Controller;
class FriendLinkController extends Controller {

	/*友情链接列表*/
	public function index() {
		// 实例化friendlink表
		$fdlink = M('friendlink');
		$count = $fdlink -> count();
		//实例化分页类Page
		$page = new \Think\Page_ajax($count,10);
		$show = $page -> show();
		$link = $fdlink -> order('id') -> limit($page -> firstRow.','.$page -> listRows) -> select();
		
		foreach ($link as $key => $value) {

			// 判断链接是否显示
			switch($value['isshow']) {
				case 0:
					$link[$key]['isshow'] = "否";
					break;
				case 1:
					$link[$key]['isshow'] = "是";
					break;
			}

			//判定是否已审核过
			switch ($value['passed']) {
				case 0:
					$link[$key]['passed'] = '否';
					break;
				case 1:
					$link[$key]['passed'] = '是';
					break;
			}

			//判定打开链接方式
			switch ($value['linktype']) {
				case 1:
					$link[$key]['linktype'] = "新窗口打开";
					break;
				case 2:
					$link[$key]['linktype'] = "当前窗口打开";
					break;
				case 3:
					$link[$key]['linktype'] = "父级窗口打开";
					break;
				case 4:
					$link[$key]['linktype'] = "顶级窗口打开";
					break;
			}			
		}
		
		$this -> assign('link',$link);
		$this -> assign('page',$show);
		$this -> display();
	}

	// 添加友情链接
	public function addlink() {
		$this -> display();
	}

	//添加链接页面
	public function ADD() {
	
		/*实例化friendlink表*/
		$FdLink = M('friendlink');
		$_POST['addtime'] = time();

		/*根据用户提交的表单数据创建数据对象,即写内存中*/
		if ($FdLink -> create()) {

			/*写入到数据库中*/
			$res = $FdLink -> add();
			if ($res) {

				/*成功后返回最新插入的值的ID*/
				$insertId = $res['id'];
				$this -> success("添加链接成功",U('FriendLink/index'),0);
			} else {
				$this -> error("添加失败");
			}
		}
			
	}

	//修改链接界面
	public function mod() {

		//获取提交的数据的id,并赋值给变量$id
		$id = $_GET['id'];

		//实例化friendlink表
		$fdlink = M('friendlink');

		//查询要修改的链接数据
		$link = $fdlink -> where("id = {$id}") -> find();

		//将查询的结果分配给模板输出
		$this -> assign('link',$link);
		$this -> display();
	}

	//修改链接操作
	public function upd() {
		$id = $_GET['id'];
		$fdlink = M('friendlink');
		
		if ($fdlink -> create()) {
			$res = $fdlink -> where("id = {$id}") -> save();
			if ($res) {
				$this -> success("修改成功",U("FriendLink/index"),0);
			} else {
				$this -> error("修改失败");
			}
		} 
	}

	//删除操作
	public function del() {
		
		// 实例化friendlink表
		$link = M('friendlink');

		//把要删除的数据的id赋值给$id
		$id = $_GET['id'];

		// 删除数据
		$result = $link -> where("id = {$id}") -> delete();

		// 判断删除操作是否成功,并输出提示信息
		if ($result) {
			$this -> success("删除成功",U('index'),0);
		} else {
			$this -> error("删除失败",U('index'),0);
		}
	}

	//批量删除操作
	public function delall() {
		$ids = $_POST['sel'];

		//将数组$ids转换成字符串
		$id = join(',',$ids);
		//实例化friendlink表
		$fdlink = M('friendlink');
		//按where(id in('1,2,3,4,5,6'))条件,逐条执行删除操作
		$res = $fdlink -> where("id in($id)") -> delete();
		//判断删除操作是否成功
		if ($res) {
			$this -> success("删除成功",U('FriendLink/index'),0);
		} else {
			$this -> error("删除失败");
		}
	}

	// 链接搜索页面
	public function searchengine() {
		// 搜索关键字
		$keywords = trim($_POST['keywords']);

		// 实例化friendlink
		$fdlink = M('friendlink');
		$count = $fdlink -> where("linkname like '%{$keywords}%' || introduction like '%{$keywords}%'") -> count();
		$page = new \Think\Page($count,10);
		$show = $page -> show();

		//搜索内容为链接名称与链接介绍
		$link = $fdlink ->order('id') ->where("linkname like '%{$keywords}%' || introduction like '%{$keywords}%'") -> limit($page -> firstRow.','.$page -> listRows) -> select();
		
		foreach ($link as $key => $value) {

			// 判断链接是否显示
			switch($value['isshow']) {
				case 0:
					$link[$key]['isshow'] = "否";
					break;
				case 1:
					$link[$key]['isshow'] = "是";
					break;
			}

			//判定是否已审核过
			switch ($value['passed']) {
				case 0:
					$link[$key]['passed'] = '否';
					break;
				case 1:
					$link[$key]['passed'] = '是';
					break;
			}

			//判定打开链接方式
			switch ($value['linktype']) {
				case 1:
					$link[$key]['linktype'] = "新窗口打开";
					break;
				case 2:
					$link[$key]['linktype'] = "当前窗口打开";
					break;
				case 3:
					$link[$key]['linktype'] = "父级窗口打开";
					break;
				case 4:
					$link[$key]['linktype'] = "顶级窗口打开";
					break;
			}			
		}
		
		$this -> assign('link',$link);
		$this -> assign('page',$show);
		$this -> display();
	
	}

}