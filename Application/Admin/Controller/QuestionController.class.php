<?php
	namespace Admin\Controller;
	use Think\Controller;

	class QuestionController extends Controller {

		/*
			用户提问列表页面，需要分页输出
		*/
		public function question() {

			$question = M('question');

			$count = $question -> count();

			//实例化框架自带的分页类，有改动，修改为ajax局部刷新分页，每次请求该方法
			$Page = new \Think\Page_ajax($count, 2);

			$show = $Page -> show();

			$question_data = $question -> order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

			$this -> assign('page', $show);
			$this -> assign('question_data', $question_data);
			$this -> display();
		} 

		/*
			该方法是进行批量操作时触发的方法，进行批量已处理和已通过操作
			需要将修改的字段值写入到数据表中
		*/
		public function action() {

			//实例化提问表
			$question = M('question');

			//接收传递过来的数据，首先需要判断状态
			switch($_POST['status']) {
				case 'action':

					//设为已处理时触发的选择，给字段赋值为1
					$data['status'] = 1;
					break;
				case 'pass':

					//设为已通过时触发的选择，给字段赋值为1
					$data['pass'] = 1; 
					break;
			}

			//需要循环遍历出每一条提问记录的id号，直接修改写入数据表中
			foreach($_POST['ids'] as $id) { 

				$question_data = $question -> where("id = '{$id}'") -> save($data);

				//如果返回值不存在，则报错退出
				if (!$question_data) {
					echo "数据更新失败";
				}
			}

			//否则，认为处理成功，直接重定向回提问咨询列表首页
			$this -> redirect('question');	
		}

		/*
			管理员点击回复用户咨询时触发该方法，该方法首先将问题以表单形式显示，提供回复区域
			如果已经有回复数据，希望是显示出来
		*/
		public function answer() {

			//接收传递过来的每一个问题相应id值
			$question = M('question');
			$question_data = $question -> find($_POST['id']);

			$this -> assign('question_data', $question_data);
			$this -> display(); 
		}

		/*
			管理员提交回复时触发的方法，该方法将回复内容和时间以及管理员的名字写入提问表中
		*/
		public function subAnswer() {

			//获取当前登录的管理员姓名
			$data['adminname'] = $_SESSION['admin']['email'] = '978771018@qq.com'; 

			//接收传递过来的id和管理员回复信息，增加相应的值，要将咨询状态设置为1，已处理
			$data['status'] = 1;
			$data['answer'] = $_POST['answer'];
			$data['endtime'] = time();

			$question = M('question');

			//将数据写入表中
			$question_data = $question -> where("id = '{$_POST['id']}'") -> save($data);

			//如果数据修改成功，直接重定向回提问表列表页，否则同时错误
			if ($question_data) {
				$this -> redirect('question');
			} else {
				echo "数据更改失败";
			}
		}

		/*
			回复列表部分控制器方法，该方法用于显示所有回复提问列表信息
			需要查询两个表提问表和回复表
		*/
		public function reply() {

			$reply = M('myreply');
			$question = M('question');

			$count = $reply -> count();
			$Page = new \Think\Page_ajax($count, 2);
			$show = $Page -> show();

			//获取回复表中的所有数据，是一个二维数组
			$reply_data = $reply -> field('id, pid, email, content, addtime, ip, pass') -> order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();

			//如果回复表中查询到数据，则继续查询提问表，否则提示错误信息
			if ($reply_data) {

				//每次遍历出一条回复信息的父类id名称，需要使用引用变量，也可以再次遍历成一维数组
				foreach($reply_data as &$value) {
					$pid = $value['pid'];
					$question_data = $question -> field('id, email, ctime, adminname, name') -> where("id = '{$pid}'") -> find();

					//如果获取到提问表中的数据，每次将提问信息以新数组下标的方法写入到回复数据中，否则提示错误
					if (!$question_data) {
						$this -> error("查询不到提问数据");
					} else {
						$value['question'] = $question_data;
					}
				}

				$this -> assign('page', $show);
				$this -> assign('reply_data', $reply_data);
			} else {
				$this -> error("查询不到回复数据");
			}

			$this -> display();
		}

		/*
			查看回复列表中点击提问者邮箱名时显示与该提问相关的管理员回复和用户回复信息
			需要查询提问表和相对应的每一个回复表，因为需要将回复表中的数据遍历到提问详情页中
		*/
		public function detial() {

			//获取到传递过来的提问表id值，该id值是回复表中的父类pid值
			$question = M('question');
			$reply = M('myreply');

			//获取提问表中的该条数据，是一维数组
			$question_data = $question -> field('id, name, type, email, content, ctime, adminname, answer,endtime') -> find($_POST['id']);

			//如果数据获取成功，则继续查询回复表中的数据，否则提示错误消息
			if ($question_data) {

				//一条提问数据中可能有多个回复，数据类型是一个二维数组
				$reply_data = $reply -> field('content, addtime, email') -> where("pid = '{$_POST['id']}'") -> select();

				//如果获取到回复数据，则将其显示，否则提示错误
				if ($reply_data) {

					$this -> assign('reply_data', $reply_data);
					$this -> assign('question_data', $question_data);
				} else {
					echo '系统查询不到该提问的回复数据';
				}
 			} else {
				echo '没有查询到提问数据';
			}

			$this -> display();
		}

		/*
			回复列表中设为不通过状态时触发该方法，该方法比较简单，仅仅修改一个字段
		*/
		public function notPass() {

			$reply = M('myreply');

			switch($_POST['status']) {

				//设为可见状态
				case 'show':
					$data['pass'] = 1;
					break;

				//设为不可见状态
				case 'notpass':
					$data['pass'] = 0;
					break;
 			}

			//该字段是pass，默认是1，通过，可以使其不通过，前台页面中将不显示出来
			foreach($_POST['ids'] as $id) {
				
				$reply_data = $reply -> where("id = '{$id}'") -> save($data);

				//如果字段值修改失败，则报错，否则跳转到回复首页列表
				if ($reply_data) {
					$this -> redirect('reply');
				} else {
					echo '回复表字段值修改失败';
				}
			}
		}

		/*
			评价列表浏览页
			为获得商品名，需要查一次商品表
			需要使用分页类
		*/
		public function comment() {

			//查询评论表数据，类型是一个二维数组
			$comment = M('comment');
			$goods = M('goods');
			$count = $comment -> count();
			$Page = new \Think\Page_ajax($count, 2);
			$show = $Page -> show();

			$comment_data = $comment -> field('id, userid, goodsid, value, email, name, content, rank, watch, comfort, freely, color, prefect, thick, addtime, ip, status, hidden') -> order('addtime desc')->limit($Page->firstRow.','.$Page->listRows) -> select();

			//如果获取到评论数据，遍历一次评论表数据，获取每一条评论表中的商品id值，否则提示错误，使用引用变量方法
			if ($comment_data) {

				foreach($comment_data as &$value) {

					//获取商品名，是一个一维数组
					$goods_data = $goods -> where("id = '{$value['goodsid']}'") -> field('goodsname') -> find();

					//如果获取到商品数据，将其写入到原数组中，否则提示错误
					if ($goods_data) {
						$value['goodsname'] = $goods_data['goodsname'];
					} else {
						$this -> error("系统无法获取商品数据信息");
					}
				}
			} else {
				$this -> error("无法获取评论数据");
			}

			$this -> assign('page', $show);
			$this -> assign('comment_data', $comment_data);
			$this -> display();
		}

		/*
			评论列表页面点击设为已处理和不可见状态时触发该方法
		*/
		public function comInfo() {

			$comment = M('comment');

			//判断传递过来的状态值
			switch($_POST['status']) {

				//设为已处理状态
				case 'action':
					$data['status'] = 1;
					break;

				//设为可见状态
				case 'show':
					$data['hidden'] = 0;
					break;

				//设为不可见状态
				case 'hidden':
					$data['hidden'] = 1;
					break;
			}

			//传递过来的值是评论的id数组值
			foreach($_POST['ids'] as $id) {

				$comment_data = $comment -> where("id = '{$id}'") -> save($data);

				//如果评价表中的字段修改成功，则返回评价列表首页，否则提示错误
				if ($comment_data) {
					$this -> redirect('Question/comment');
				} else {
					echo '评论表中的字段修改失败';
				}
			}	
		}

		/*
			评论列表页删除操作，该方法直接删除，不做回收站了
		*/
		public function dels() {

			//获得所有选中的评论id值数组
			$ids = $_POST['ids'];

			$comment = M('comment');

			foreach($ids as $id) {
				$comment_data = $comment -> delete($id);

				//如果删除失败，提示错误
				if (!$comment_data) {
					$this -> error('删除评论失败');
				}
			}

			//重定向回评论列表
			$this -> redirect('comment');
		}

		/*
			提问列表页删除操作，该操作将连同该提问下面的回复也一并删除
		*/
		public function questionDel() {

			//获得传递过来的数组提问id值
			$ids = $_POST['ids'];

			$question = M('question');
			$reply = M('myreply');

			//遍历出每一个提问id，分别获取相应的回复id值
			foreach($ids as $id) {

				//查询提问回复数据内容
				$reply_data = $reply -> where("pid = '{$id}'") -> field('id') -> select();

				//如果获取到相应的回复id值，则需要先删除回复才能删除提问
				if ($reply_data) {

					//说明有回复内容，需要先删除所有的回复才能删除提问
					foreach($reply_data as $value) {

						//删除回复数据内容
						$new_repy = $reply -> delete($value['id']);
					}

					//如果删除失败，则提示错误
					if ($new_reply) {

						$question_data = $question -> delete($id);

						//如果删除提问失败，则提示错误
						if (!$question_data) {
							$this -> error("删除完回复后删除提问失败");
						}

					} else {
						$this -> error("删除回复内容失败");
					}

				} else {

					// 没有查询到回复数据，说明没有回复内容，直接删除即可
					$question_data = $question -> delete($id);

					//如果删除失败，则需要提示错误
					if (!$question_data) {
						$this -> error("删除提问失败");
					}
				}
			}

			//删除完成，直接跳转到提问列表首页
			$this -> redirect('question');
		}

		/*
			删除回复操作，该方法仅删除该类回复，即传递过来的id值
		*/
		public function replyDel() {

			//获得传递过来的id数组
			$ids = $_POST['ids'];
			$reply = M('myreply');

			//遍历出每一条回复id值
			foreach($ids as $id) {
				$reply_data = $reply -> delete($id);

				//如果删除失败，则提示错误
				if (!$reply_data) {
					$this -> error("删除回复时失败");
				}
			}

			//直接跳转到回复首页面
			$this -> redirect('reply');
		}
	}