<?php
namespace Home\Controller;
use Think\Controller;
use Think\Area;

class MyVanclController extends Controller {

	/*我的凡客个人中心页面*/
	public function myvancl() {
		
		R('Header/index');
		if (!empty($_SESSION['user'])) {
			$user = $_SESSION['user'];
			$this -> assign('user',$user);
			$this -> display();
		} else {
			$this -> redirect("MyVancl/login");
		}
	
	}

	/*登录界面*/
	public function login() {
		$this -> display();
	}

	/*判断登录账户操作*/
	public function log() {
		$username = trim($_POST['username']);
		$passpwd = md5(trim($_POST['passpwd']));		

		/*查询user表用户数据*/
		$user = M('user');
		$res = $user -> where("username = '{$username}' AND passpwd = '{$passpwd}'")
					   -> find();
		
		/*判断查询结果*/
		if ($res) {
			//将查询结果集赋值SESSION['user']
			$_SESSION['user'] = $res;

			/*如果成功就跳转到首页*/						
			$this -> redirect("MyVancl/myvancl");

		} else {

			/*失败则返回登录页面,重新登录*/
			$this -> error("登录失败,请重新登录","login",1);
		}
	}

	//分配输出验证码
	public function code() {
		$config = array(
			'useImgBg' => true,
			'length' => 4,
			'userNoise' => false,
			'imageH' => 60,
			'imageW' => 200,
			'expire' => 30,
			);
		$verify = new \Think\Verify($config);
		$verify ->entry();

	}

	/*上传文件方法*/
	public function upload(){
		/*实例化上传类*/
		$upload = new \Think\Upload();

		/*设置上传文件大小*/
		$upload -> maxSize = 3145728;

		/*设置上传文件的后缀名*/
		$upload -> exts = array('jpg','jpeg','gif','png');

		/*设置上传文件的保存路径*/
		$upload -> savePath = 'Public/Common/Uploads/Headpic/';

		/*设置上传文件保存的根目录*/
		$upload -> rootPath = './';

		/*设为false表示禁止使用子目录保存上传文件*/
		$upload -> autoSub = false;

		/*执行upload()方法上传文件,如果上传失败,则返回false,如果成功,则返回一个包含上传文件信息的数组*/
		$info = $upload -> upload();

		if (!$info) {
			/*上传文件失败,提示错误信息*/
			$this -> error($upload -> getError());
		} else {
			/*上传文件成功,获取上传文件信息*/				
			foreach($info as $file) {
				$user = M('user');

				$username = $_SESSION['user']['username'];
				$data['photoname'] = $file['savename'];
				//写入数据到数据库
				$res = $user -> where("username = '{$username}'")
					-> save($data);

				if ($res) {
					$_SESSION['user']['photoname'] = $file['savename'];
					$this -> success("修改头像成功");
				} else {
					$this -> error("修改头像失败");
				}
			}
		}
	}

	/*我的资料页面*/
	public function userinfo() {
		//获取SESSION中的用户名,并赋值给变量$name
		$user = $_SESSION['user'];
		$area = explode('/',$user['userarea']);

		$user['province'] = $area[0];
		$user['city'] = $area[1];
		$user['county'] = $area[2];
		
		$pro = array("{$user[province]}", "{$user[city]}",  "{$user[county]}"); 

		$birth = explode('-',$user['birthday']);
		$user['year'] = $birth[0];
		$user['month'] = $birth[1];
		$user['day'] = $birth[2];

		if (!$user['photoname']) {
			$user['photoname'] = "default_photo.jpg";
		}

		//分配变量到模板,输出变量
		$this -> assign('user',$user);
		$this->assign("city", Area::city($pro));
		$this -> display();


	}

	/*保存个人资料的修改*/
	public function update() {
		/*实例化user表*/
		$user = M('user');

		/*获得用户的用户名*/
		$username = $_SESSION['user']['username'];

		/*把用户填写的信息赋值给数组$data*/
		$data['nickname'] = I('post.nickname');
		$data['realname'] = I('post.realname');
		$data['sex'] = I('post.sex');
		$data['birthday'] = I('post.year').'-'.I('post.month').'-'.I('post.day');
		$data['userarea'] = I('post.province').'/'.I('post.city').'/'.I('post.county');
		$data['detailaddress'] = I('post.detailaddress');
		$data['mobilephone'] = I('post.mobilephone');
		$data['postalcode'] = I("post.postalcode");

		$res = $user ->where("username = '{$username}'")
			  		   -> save($data);
		if($res) {
			$result = $user -> where("username = '{$username}'") -> find();
			if ($result) {
				$_SESSION['user'] = $result;
				$this -> success("修改成功");
			}			
		} else {
			$this -> error("修改失败");
		}
	}

	//账户余额页面
	public function accountbalance(){
		$user = $_SESSION['user'];
		$this -> assign("user",$user);
		$this -> display();
	}

	//收货地址页面
	public function getaddress() {
		//查询用户的收货地址
		$addr = M("user_address");
		$userid = $_SESSION['user']['id'];
		$res = $addr -> where("userid = {$userid}") -> select();
		$this -> assign("address",$res);

		//省市级三联动
		$pro = array("-省份/直辖市-", "---市---",  "--县/区--"); 
		$this -> assign('city',Area::city($pro));
		$this -> display();
	}

	//添加新收货地址
	public function addaddress() {

		$_POST['userid'] = $_SESSION['user']['id'];
		$_POST['email'] = $_SESSION['user']['email'];
		$_POST['pname'] = $_POST['province'];
		$_POST['cname'] = $_POST['city'];
		$_POST['conty'] = $_POST['conty'];
		$addr = M("user_address");
		if ($addr -> create()) {
			$res = $addr -> add();
			if ($res) {
				$this -> success("添加成功");
			} else {
				$this -> error("添加失败");
			}
		}
	}

	//编辑收货地址
	public function modaddr() {
		$id = $_POST['id'];
		$useraddr = M('user_address');
		$res = $useraddr -> where("id = {$id}") -> find();
		echo json_encode($res);
	}

	//编辑收货地址操作
	public function updAddress() {
		$id = $_GET['id'];
		$addr = M("user_address");
		if ($_POST['status'] != 1) {
			$_POST['status'] = 0;
		}
		$_POST['pname'] = $_POST['province3'];
		$_POST['cname'] = $_POST['city3'];
		$_POST['county'] = $_POST['area3'];
		if ($addr -> create()) {
			$res = $addr -> where("id = {$id}") -> save();
			if ($res) {
				$this -> success("编辑成功",U('MyVancl/getaddress'),0);
			} else {
				$this -> error("编辑失败");
			}
		}
	}

	//删除收货地址
	public function deladdress() {
		$id = $_GET['id'];
		$addr = M("user_address");
		$res = $addr -> where("id = {$id}") -> delete();
		if ($res) {
			$this -> success("删除成功");
		} else {
			$this -> error("删除失败  ");
		}
	}

	//账户安全页面
	public function accountsafe() {
		$user = $_SESSION['user'];
		$this -> assign('user',$user);
		$this -> display();
	}

	//修改密码界面
	public function updatepwd() {
		$user = $_SESSION['user'];
		$this -> assign('user',$user);
		$this -> display();
	}

	//修改密码操作
	public function updpwd() {
		$id = $_GET['id'];
		//验证验证码是否正确
		$code = $_POST['code'];
		$verify = new \Think\Verify();
		$ret = $verify -> check($code);
		if ($ret) {
			//实例化user表
			$user = M("user");
			$pwd = md5($_POST['passpwd']);
			$res = $user -> where("id = {$id} AND passpwd = '{$pwd}'") -> find();
			if ($res) {
				$data['passpwd'] = md5($_POST['newpwd']);
				//写入修改后的密码
				$result = $user -> where("id = {$id}") ->save($data);
				if ($result) {
					//写入成功,将新密码赋值给session
					$_SESSION['user']['passpwd'] = md5($_POST['newpwd']);
					$this -> success("修改密码成功",U('MyVancl/accountsafe'),0);
				} else {
					//写入失败
					$this -> error("修改失败");
				}
			} else {
				//原密码不正确
				$this -> error("原密码错误");
			}
		} else {
			$this -> error("验证码不正确");
		}
	}

	//我的关联账户方法
	public function releaccount() {
		$this -> display();
	}

	//促销信息退订方法
	public function celpromotion() {
		$this -> display();
	}

	/*
		个人中心显示我的订单页面
	*/
	public function order() {

		//获取当前登录用户的id号
		$id = $_SESSION['user']['id'];

		//获取订单信息，是一个二维数组
		$order = M('order');

		//使用分页类
		$count = $order -> where("userid = '{$id}'") -> count();

		//实例化框架自带的分页类，有改动，修改为ajax局部刷新分页，每次请求该方法
		$Page = new \Think\Page_ajax($count, 4);

		$show = $Page -> show();

		$order_data = $order -> where("userid = '{$id}'") -> field('id, ordersn, total, consignee, paytype, addtime, isnew, orderstatus, isuse')  -> limit($Page->firstRow.','.$Page->listRows) -> order('id desc') -> select();

		$order_goods = M('order_goods');

		/*
			遍历出订单信息中的订单号
			使用引用变量的方法要简单很多，之前使用数组相对就麻烦了
			数组循环两次，第二次才将商品名取到，并且赋值到原来的数组中
			制定一个下标，在模板中时再次循环该数组
		*/
		foreach($order_data as &$value) {

			//通过订单号遍历出商品名称和商品图片名，还是一个二维数组
			$ordersn = $value['ordersn'];
			$order_goods_data = $order_goods -> where("ordersn = '{$ordersn}'") -> field('goodsid') -> select();

			foreach($order_goods_data as $name) {

				//通过商品id号查找图片，注意需要再次指明订单编号作为搜索条件，否则将只会显示第一条，而且商品id在这里本身没意义
				$goodsid = $name['goodsid'];
				$goods_data = $order_goods -> where("goodsid = '{$goodsid}' AND ordersn = '{$ordersn}'") -> field('goodsimg') -> find();

				//将商品图片也写入
				$value['goodsimg'][] = $goods_data['goodsimg'];
			}
		}
		
		//分配变量到模板
		$this -> assign('page', $show);
		$this -> assign('order_data', $order_data);
		$this -> display();
	}

	/*
		查看订单详情页
		该页面需要跟踪订单处理表，随时显示不同的记录和步骤
	*/
	public function detail() {

		//该页面接收到的值是订单id号
		$order = M('order');
		$order_data = $order -> where("id = '{$_GET['id']}'") -> find();

		//获取收货地址信息
		$addressid = $order_data['addressid'];
		$address = M('user_address');
		$address_data = $address -> find($addressid);

		//获取发票信息
		$receiptid = $order_data['receiptid'];
		$receipt = M('receipt');
		$receipt_data = $receipt -> find($receiptid);

		//获取与该订单编号相关的商品信息，是个二维数组
		$ordersn = $order_data['ordersn'];
		$order_goods = M('order_goods');
		$order_goods_data = $order_goods -> where("ordersn = '{$ordersn}'") -> select();

		//获取订单处理表的信息
		$order_action = M('order_action');
		$order_action_data = $order_action -> where("ordersn = '{$ordersn}'") -> find();

		//分配变量到订单详情模板
		$this -> assign('order_data', $order_data);
		$this -> assign('address_data', $address_data);
		$this -> assign('order_goods_data', $order_goods_data);
		$this -> assign('receipt_data', $receipt_data);
		$this -> assign('order_action_data', $order_action_data);
		$this -> display();
	}

	/*
		用户在个人中心等地方取消订单用方法
		该方法将订单中的可用状态字段isuse设置为0
		因为默认是可用，值为1

		同时要将是否是新订单的字段值isnew设为非新订单
		因此这个字段仅仅是作为有效订单来显示一些操作用的

		取消订单的记录也要写在订单处理表中，同时订单取消后应该在订单表和订单处理表中都有记录，方便查询
	*/
	public function cancl() {

		//获得传递过来的订单id号
		$order = M('order');
		$data['isuse']  = 0;
		$data['isnew'] = 0;
		$order_data = $order -> where("id = '{$_GET['id']}'") -> save($data);

		//如果取消成功，则跳回我的订单列表，否则提示错误
		if ($order_data) {
			$this -> redirect('order');
		} else {
			$this -> error("订单取消失败");
		}
	}

	/*
		写评论方法，首先跳转到商品列表，在根据商品id号进行评论

		该方法第二个功能是，评论提交后需要回到本页面，此时传递过来的是商品id号
		需要进行转化成订单id号后，，就成通用的方法了

		该方法需要查询的第三个数据表是用户评论表，用来验证该用户是否已经对商品
		进行过评论，如果已经有过评论，就显示查看评论的按钮，否则就是立即评论的
		按钮
	*/
	public function point() {

		//实例化模型
		$order = M('order');
		$order_goods = M('order_goods');
		$comment = M('comment');

		//如果接收到的是商品id号
		if (isset($_GET['goodsid'])) {

			//则直接查询订单商品表中的订单编号
			$new_order_goods_data = $order_goods -> where("goodsid = '{$_GET['goodsid']}'") -> field('ordersn') -> find();

			//查询订单id号
			$new_order_data = $order -> where("ordersn = '{$new_order_goods_data['ordersn']}'") -> field('id') -> find();
			$id = $new_order_data['id'];
		} else if (isset($_GET['id'])) {
			$id = $_GET['id'];  
		} else {

			//如果不存在用户提供的商品id值和订单id值，则表示用户是从个人中心点击我要评价进入该页面的，此时搜索该用户的已完成订单
			$uid = $_SESSION['user']['id'];
			$new_order_data = $order -> where("userid = '{$uid}' AND orderstatus = '1'") -> order("addtime desc") -> limit(1) -> find();
			$id = $new_order_data['id'];
		}

		//接收到该订单的id号
		$order_data = $order -> where("id = '$id'") -> field('ordersn, addtime') -> find();

		//通过订单编号查询该订单下面所有的商品，是一个二维数组
		$order_goods_data = $order_goods -> where("ordersn = '{$order_data['ordersn']}'") -> field('goodsid, name, color, size, goodsimg') -> select();

		//查询登录用户的用户评论表信息，需要得到所有的商品id号，需要遍历一次数组
		foreach($order_goods_data as &$value) {

			//如果在商品表中查询到用户有记录，则返回真，存入一个状态值have=1引用传值存入到订单商品数据中传递到模板文件
			$comment_data = $comment -> where("goodsid = '{$value['goodsid']}' AND userid = '{$_SESSION['user']['id']}'") -> find();

			if ($comment_data) {
				$value['have'][] = 1;
			} else {
				$value['have'][] = 0;
			}
		}

		//分配到模板中
		$this -> assign('order_data', $order_data);
		$this -> assign('order_goods_data', $order_goods_data);
		$this -> display();
	}

	/*
		发表评论页面显示方法
	*/
	public function say() {

		//接收到商品id值，结果集为一维数组
		$goods = M('order_goods');
		$goods_data = $goods -> where("goodsid = '{$_GET['id']}'") -> field('goodsid, name, goodsimg, goodsprice, size') -> find();

		//分配变量到模板中
		$this -> assign('goods', $goods_data);
		$this -> display();
	}

	/*
		用户发表完评论提交评论时触发的方法
		该方法接收数据之后将该数据写入到评论表中
		默认是通过的，单从后台可以禁止显示
		此时的状态是未审核，需要审核通过后才可以在页面中显示
	*/
	public function subSay() {

		//接收一系列的值，先获取商品id和当前登录用户信息
		$_POST['userid'] = $_SESSION['user']['id'];
		$_POST['email'] = $_SESSION['email'];
		$_POST['name'] = $_SESSION['username'];
		$_POST['rank'] = $_SESSION['rank'];
		$_POST['addtime'] = time();

		//获取客户端ip
		$_POST['ip'] = get_client_ip();

		//实例化评价表
		$comment = M('comment');
		$comment -> create();
		$comment_data = $comment -> add();

		//如果写入成功，返回上一页，继续点击浏览详情页中的所有评价信息
		if ($comment_data) {
			$this -> redirect('point', array('goodsid' => $_POST['goodsid']));
		} else {
			echo '评论失败';
		}
	}

	/*
		点击查看我的收藏时触发该方法
		该方法使用到分页插件
	*/
	public function collect() {

		//需要查询收藏表、商品表和评论表
		$collect = M('collect');
		$goods = M('goods');
		$comment = M('comment');

		//获取符合用户名的总记录条数
		$count = $collect -> where("userid = '{$_SESSION['user']['id']}'") -> count();
		$Page = new \Think\Page_ajax($count, 2);
		$show = $Page -> show();

		//二维数组
		$collect_data = $collect -> where("userid  = '{$_SESSION['user']['id']}'") -> limit($Page->firstRow.','.$Page->listRows) -> order("addtime desc") -> select();

		//需要使用引用传值修改原值
		foreach($collect_data as &$value) {

			//需要遍历出每个商品收藏记录中的商品id，来查询商品信息，是一个一维数组
			$goods_data = $goods -> where("id = '{$value['goodsid']}'") -> field('id, goodsname, goodsimg, goodsprice, goodsColor') -> find();

			//此时还需要做一件事情，就是找到该商品id值，并且已有用户id值，需要遍历出评论表中该用户该商品的评论表中的记录总条数
			$count = $comment -> where("userid = '{$_SESSION['user']['id']}' AND goodsid = '{$value['goodsid']}'") -> count();

			//使用引用传值单独拼接
			$value['goodsid'] = $goods_data['id'];
			$value['goodsname'] = $goods_data['goodsname'];
			$value['goodsimg'] = $goods_data['goodsimg'];
			$value['goodsprice'] = $goods_data['goodsprice'];
			$value['counts'] = $count;
		}

		$this -> assign('page', $show);
		$this -> assign('collect_data', $collect_data);
		$this -> display();
	}

	/*
		点击查看我的评论时触发的方法
		该方法将登陆用户的评论显示在当前页面中，点击
		查看全部评论才会跳转到商品详情页中的猫链接处
	*/
	public function myCom() {

		//接收到传递过来的商品id号，获取当前登录用户的id号，查询与此相关的评论内容
		$goodsid = $_POST['id'];
		$userid = $_SESSION['user']['id'];

		$comment = M('comment');
		$comment_data = $comment -> where("goodsid = '{$goodsid}' AND userid = '{$userid}'") -> find();

		//如果查询到内容，则将其发送到模板中去
		if ($comment_data) {

			//查询订单商品表
			$order_goods = M('order_goods');
			$order_goods_data = $order_goods -> where("goodsid = '{$goodsid}'") -> field('color, size') -> find();

			//如果从查询到该商品信息，则将数据分配到前段模板中
			if ($order_goods_data) {
				$this -> assign('order_goods_data', $order_goods_data);
				$this -> assign('comment_data', $comment_data);
				$this -> display();
			} else {
				echo '查询不到该评论对应的商品信息';
			}
		} else {
			echo '暂时找不到该用户对该商品的评论内容';
		}
	}

	/*
		个人中心中删除我的收藏操作，属于批量操作范围
	*/
	public function collectDel() {

		//首先判断传递过来的id值是单条数据还是数组数据
		if (isset($_POST['ids'])) {

			//数组类型
			$ids = $_POST['ids'];
		}

		if (isset($_POST['id'])) {

			//字符类型，组合成数组
			$ids[] = $_POST['id'];
		}

		$collect = M('collect');

		//遍历出每一条商品id值
		foreach($ids as $id) {

			//从商品收藏表中删除该商品收藏
			$collect_data = $collect -> where("goodsid = '{$id}'") -> delete();

			//如果删除失败，需要提示出错信息
			if (!$collect_data) {
				$this -> error("删除该条商品收藏失败");
			}
		}

		//操作完成，回到商品收藏首页
		$this -> redirect('collect');
	}
}