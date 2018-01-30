<?php
	namespace Home\Controller;
	use Think\Controller;

	class DetialController extends Controller {

		//读取数据库，加载动态内容到商品详情页中，同时将该商品的点击次数增加1
		public function detial() {

			R('Header/index');

			/************** 仅分配商品信息 **************/

			//用来显示该页面的商品id值，该值从浏览器中获取
			$id = $_GET['id'];

			$goods = M('goods');
			$data = $goods -> where("id = '{$id}'") -> find();
			if ($data) {

				//将该商品的点击次数获取到
				$click['clickcount'] = ++$data['clickcount'];

				$click_data = $goods -> where("id = '{$id}'") -> save($click);

				//点击次数增加1成功后，将商品信息变量分配到页面中去
				if ($click_data) {
					$this -> assign('goods', $data);
				} else {
					$this -> error("商品加载出现未知错误");
				}
				
			} else {
				$this -> error('没有查询到该商品的信息，请确保提供了合法的参数');
			}

			/*********************** 仅分配用户评价表内容 **************************/
			$comment = M('comment');
			$count = $comment -> where("goodsid = '{$id}'") -> count();

			$Page = new \Think\Page_ajax($count, 2);

			$show = $Page -> show();

			$comment_data = $comment -> where("goodsid = '{$id}'") -> order("addtime desc") -> limit($Page->firstRow.','.$Page->listRows) -> select();

			$this -> assign('user', $_SESSION['user']);
			$this -> assign('count', $count);
			$this -> assign('cpage', $show);
			$this -> assign('comment_data', $comment_data);


			/*********************  仅分配用户提问去信息列表  *****************/

			//查询用户提问数据，并将其分配到前台模板，需要使用分页程序，限制每页三条,，并且是提问状态值pass=1的字段方可以显示
			$question = M('question');

			//获取与该商品id关联的所有用户提问和咨询信息，暂时按提问时间倒序排序
			$newCount = $question -> where("goodsid = '{$id}' AND pass = 1") -> count();

			//实例化框架自带的分页类，有改动，修改为ajax局部刷新分页，每次请求该方法
			$newPage = new \Think\Page_ajax($newCount, 2);
			$newshow = $newPage -> show();

			$question_data = $question -> where("goodsid = '{$id}' AND pass = 1") -> order('ctime desc')->limit($newPage->firstRow.','.$newPage->listRows)->select();

			//计算点击次数最多的商品，取5件
			$click = $goods -> where('promoteprice > 1') -> order("clickcount desc") -> field('id, goodsname, goodsimg, goodsColor, promoteprice, goodsprice, clickcount') -> limit(5) -> select();

			$this -> assign('click_data', $click);
			$this -> assign('newcount', $newCount);
			$this -> assign('page', $newshow);
			$this -> assign('question_data', $question_data); 

			$this -> display();
		}

		/*
			用户点击放入购物车时触发的方法，此时将查询商品和购物车表，
			在购物车表中，存放用户曾经添加到购物车中的商品，该商品不一定被提交
			查询商品表使用商品id字段
			查询购物车表查询当前登录用户的id字段，当前用户一旦添加商品到购物车
			就将该用户id存放到购物车表中的userid字段中

			需要增加颜色和尺寸两个新值
		*/
		public function addcart() {

			//通过jQuery请求，接收发送过来的商品id号和商品数量
			$id = $_POST['id'];
			$num = $_POST['num'];

			//接收颜色和尺寸值
			$color = $_POST['color'];
			$size = $_POST['size'];
			
			//查询该商品是否存在，读取商品信息
			$shop = M('goods');
			$data = $shop -> where("id = '{$id}'") -> find();
			
			//如果有这个商品，则进行处理
			if($data) {

				//同时增加一个数量字段，用于存放同时购买一类商品时的数量，将本次添加作为初始商品数量记录下来
				$data['num'] = $num;

				//将整个商品信息存到超全局数组$_SESSION['cart'][$data['id']]中，为了区别不同的商品，使用该商品id号作为索引下标
				if(isset($_SESSION['cart'][$data['id']])) {

					//如果该变量已经存在，则将该商品的数量增加
					$_SESSION['cart'][$data['id']]['num'] += $num;
					
				} else {

					//该商品不存在，是新商品，将其写入到$_SESSION['cart']中
					$_SESSION['cart'][$data['id']] = $data;
					$_SESSION['cart'][$data['id']]['color'] = $color;
					$_SESSION['cart'][$data['id']]['size'] = $size;

				}

				//开始读取商品信息，并计算出总数量和总价钱，用于在页面中显示
				$sum = 0;
				$total = 0;
				if(isset($_SESSION['cart'])) {
					foreach($_SESSION['cart'] as $value) {

						//一类商品的价格总和
						$price = $value['promoteprice'] * $value['num'];

						//商品的总数量就是各商品数量之和
						$sum += $value['num'];

						//所有商品价格总和就是购物车中商品的总价格之和
						$total += $price;                 
					}

					$arr['sum'] = $sum;
					$arr['total'] = $total;
					echo json_encode($arr);
				}
			} else {
				echo '该商品不存在';
			}

		}

		/*
			商品收藏方法，该方法的原理是用户点击收藏该商品时，将得到该商品的id号
			此时需要再次查询数据库，验证该商品是否存在
			然后将该商品id和用户id等信息写入商品收藏表中
		*/
		public function collect() {

			$str = '';

			if (!isset($_SESSION['user']['id'])) {

				//登录用户才可以收藏商品
				$str .= '-4';
			} else {

				$goodsid = $_POST['id'];
				$userid = $_SESSION['user']['id'];

				//实例化商品表，验证该商品确实存在才有必要收藏
				$g = M('goods');
				$data = $g -> where("id = '{$goodsid}'") -> find();

				if ($data) {

					//说明该商品存在，可以收藏。但是还需要在查询一次商品收藏表中是否已经有了该收藏
					$c = M('collect');
					$c_data = $c -> where("goodsid = '{$goodsid}'") -> find();

					if ($c_data) {

						//说明该商品已经在用户收藏表中，不需要重复收藏
						$str .= "-1";
					} else {

						//收藏表中不存在该条信息，可以收藏，将其写入数据表中
						$_POST['collect']['userid'] = $userid;
						$_POST['collect']['goodsid'] = $goodsid;
						$_POST['collect']['addtime'] = time();

						$c -> create($_POST['collect']);
						$c_last_id = $c -> add();

						if ($c_last_id) {

							//成功收藏该商品
							$str .= '1';
						} else {

							//收藏商品失败
							$str .= '-2';
						}
					}
				} else {

					//查询不到该商品的信息
					$str .= '-3';
				}
			}

			echo json_encode($str);
		}

		/*
			该方法把页面重定向到购物车控制器下的cart购物车方法
		*/
		public function goCart() {
			$this -> redirect('cart/cart');
		}

		/*
			用户针对某商品进行我的提问操作后触发的方法，该方法收集用户的提问信息，并将其写入到用户
			提问表v_question中，需要字段信息有用户id，商品id，商品名，邮箱，提问标题和类型，内容等
		*/
		public function question() {

			//获取用户id
			if (!isset($_SESSION['user']['id'])) {
				echo '只有登录用户可以提问';
			} else {
				$id = $_SESSION['user']['id'];

				//需要确认用户信息，并获取相应值
				$u = M('user');

				$u_data = $u -> field('username') -> where("id = '{$id}'") -> find();

				//如果用户信息存在，则提取并验证该商品是否存在
				if ($u_data) {

					//获取商品id
					$goodsid = $_POST['goodsid'];

					$g = M('goods');

					$g_data = $g -> field('goodsname') -> where("id = '{$goodsid}'") -> find();

					//如果商品存在，则进行读取用户的提问信息，并将其存入到提问表中
					if ($g_data) {

						//获取表单数据段，需要处理成特定格式
						$_POST['question']['userid'] = $id;
						$_POST['question']['goodsid'] = $goodsid;
						$_POST['question']['name'] = $g_data['goodsname'];
						$_POST['question']['email'] = $u_data['username'];
						$_POST['question']['type'] = $_POST['q_type'];
						$_POST['question']['content'] = $_POST['q_content'];
						$_POST['question']['ctime'] = time();

						//实例化提问表
						$q = M('question');
						$q -> create($_POST['question']);
						$q_data = $q -> add();

						if ($q_data) {
							echo '1';
						} else {
							echo '提问添加失败';
						}
					} else {

						//找不到该商品
						echo "系统找不到该商品，无法进行提问";
					}
				} else {

					//找不到用户信息
					echo '找不到用户信息，无法对该商品进行提问';
				}
			}
		}

		/*
			获得用户对我要提问区域点击我要回复操作时的处理，该回复是需要存入数据表中的
		*/
		public function myReply() {

			//接收到传递过来的提问id和回复内容
			$qid = $_POST['authorid'];
			$content = $_POST['content'];

			//需要获取当前登录用户的信息
			$userid = $_SESSION['user']['id'];
			$email = $_SESSION['user']['username'];

			//实例化提问表，需要获取数据商品id和该提问用户的id
			$question = M('question');
			$question_data = $question -> find($qid);

			//如果存在该提问的信息，则进行信息获取
			if ($question_data) {

				//实例化问题回复表，该表中的父级id是回复提问的问题id
				$reply = M('myreply');
				$data['pid'] = $qid;
				$data['userid'] = $userid;
				$data['goodsid'] = $question_data['goodsid'];
				$data['addtime'] = time();
				$data['ip'] = get_client_ip();
				$data['content'] = $content;
				$data['email'] = $email;
				$data['author'] = $question_data['email'];
				$data['authorid'] = $question_data['userid'];

				$reply -> create($data);
				$reply_data = $reply -> add();

				//如果写入回复成功，则跳回到商品详情页中的回复区域部分
				if ($reply_data) {

					//数据写入成功，不需要跳转，返回一个正确值yes
					echo 'yes';

					/*//使用重定向函数跳转，可以附带锚链接地址，方便跳转后定位到特定的区域
					redirect("detial/id/$data[goodsid]#myreply");*/
				} else {

					//写入回复表失败
					echo 'no';
				}

			} else {
				echo '该提问信息不存在，无法回复';
			}
		}

		/*
			得到回复数据，并使用周期性事件将其显示出来
		*/
		public function getReply() {

			//获得该条提问的id值，搜索该条提问是否有回复信息，如果有，将其显示出来，如果足够多，需要考虑分页显示
			$id = $_POST['authorid'];
			$reply = M('myreply');

			//获取得到的回复信息是一个二维数组，需要处理成为特定的格式，每次只取5条数据，按时间倒序排序
			$reply_data = $reply -> where("pid = '{$id}'") -> order("addtime desc") -> limit(5) -> select();

			//如果存在信息，则将其转化为json格式，否则提示错误
			if ($reply_data) {

				//使用php首先将日期时间格式化为年月日时分秒以字符串的方式打印到页面中去
				foreach($reply_data as &$value) {
					$value['addtime'] = date('Y-m-d H:i:s', $value['addtime']);
				}

				//说明获取到数据
				echo json_encode($reply_data);
			} else {
				echo '系统找不到回复信息';
			}
		}

		/*
			清空SESSION用
		*/
		public function sess() {
			session(null);
		}

		/*
			用户提问部分单独请求的分页输出信息，进入商品详情页时是detial方法自动调用的显示
			仅调用来为了显示，不具有分页功能和局部刷新功能
		*/
		public function qpage() {
	
			//查询用户提问数据，并将其分配到前台模板，需要使用分页程序，限制每页三条,，并且是提问状态值pass=1的字段方可以显示
			$question = M('question');

			//获取与该商品id关联的所有用户提问和咨询信息，暂时按提问时间倒序排序
			$count = $question -> where("goodsid = '{$_GET['id']}' AND pass = 1") -> count();

			//实例化框架自带的分页类，有改动，修改为ajax局部刷新分页，每次请求该方法
			$Page = new \Think\Page_ajax($count, 2);
			$show = $Page -> show();

			$question_data = $question -> where("goodsid = '{$_GET['id']}' AND pass = 1") -> order('ctime desc')->limit($Page->firstRow.','.$Page->listRows)->select();

			$this -> assign('page', $show);
			$this -> assign('question_data', $question_data); 
			$this -> display('question');
		}

		/*
			用户评价部分单独请求的分页输出信息，进入商品详情页时是detial方法自动调用的显示
			仅调用来为了显示，不具有分页功能和局部刷新功能
		*/
		public function cpage() {
	
			//查询用户提问数据，并将其分配到前台模板，需要使用分页程序，限制每页三条,，并且是提问状态值pass=1的字段方可以显示
			$comment = M('comment');

			//获取与该商品id关联的所有用户提问和咨询信息，暂时按提问时间倒序排序
			$count = $comment -> where("goodsid = '{$_GET['id']}' AND hidden = 0")-> count();
			$this -> assign('count', $count);

			//实例化框架自带的分页类，有改动，修改为ajax局部刷新分页，每次请求该方法
			$Page = new \Think\Page_ajax($count, 2);
			$show = $Page -> show();

			$comment_data = $comment -> where("goodsid = '{$_GET['id']}' AND hidden = 0") -> order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();

			$this -> assign('user', $_SESSION['user']);
			$this -> assign('cpage', $show);
			$this -> assign('comment_data', $comment_data); 
			$this -> display('comment');
		}

		/*
			该方法用来获取该用户对该商品的评论内容，用于将其输出到评论列表中
		*/
		public function ourCom() {

			//获取该用户的邮箱号和该商品的id号
			$email = $_POST['email'];
			$id = $_POST['id'];

			$comment = M('comment');

			$Page = new \Think\Page_ajax($count, 2);
			$show = $Page -> show();

			$count = $comment-> where("email = '{$email}' AND goodsid = '{$id}'") -> count();

			//查询该用户与该商品对应的所有评论内容
			
			$comment_data = $comment -> where("email = '{$email}' AND goodsid = '{$id}'") -> order('addtime desc')->limit($Page->firstRow.','.$Page->listRows) -> select();

			//如果查询到数据则分配到模板中，否则提示错误
			if ($comment_data) {
				$this -> assign('comment_data', $comment_data);
				$this -> display('comment');
			} else {
				echo '没有查询到该用户与商品相关的评论信息';
			}
		}

		/*
			当用户点击选择商品数量时，需要判断该数量是否大于该商品目前的库存量
		*/
		public function check() {

			//获得传递过来的数量值和商品id值
			$num = $_POST['num'];
			$id = $_POST['id'];

			$goods = M('goods');
			$goods_data = $goods -> field('goodsnumber') -> find($id);

			//如果查询不到该商品信息，则出错中断操作
			if ($goods_data) {

				//库存数量大于等于购买数量才可以购买该商品
				if ($goods_data['goodsnumber'] >= $num) {

					//数量没有超过库存，可以购买，返回1
					echo '1';
				} else {
					//库存不足，目前只有多少商品
					echo $goods_data['goodsnumber'];
				}
			} else {
				//查询不到该商品信息，返回-1
				echo '-1';
			}
		}
	}
