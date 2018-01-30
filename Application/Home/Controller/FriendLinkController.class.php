<?php
namespace Home\Controller;
use Think\Controller;
class FriendLinkController extends Controller {

	//友情链接首页页面
	public function index() {
		 R("Header/index");
		 $user = $_SESSION['user'];
		//实例化friendlink表
		$fdlink = M('friendlink');
		//按条件查询数据表中的数据
		$res = $fdlink -> field('linkname,url,introduction') ->where('isshow = 1 AND passed = 1') ->order('linkorder') -> select();
		//判断查询是否成功
		if ($res) {
			//成功则分配结果集数据给前台模板
			$this -> assign('link',$res);
		} else {
			$this -> error("查询失败");
		}
		$this -> assign("user",$user);
		$this -> display();
	}

	//输出验证码方法
	public function code() {
		//设置配置的基本参数
		$config = array(
			'fontSize' => 20,
			'length' => 4,
			'useNoise' => false,
			'useImgBg' => true,
			);
		//实例化验证码类
		$verify = new \Think\Verify($config);
		$verify -> entry();
	}

	public function getApply() {
		// 获得提交的验证码,并赋值给变量$code
		$code = $_POST['code'];
		$_POST['addtime'] = time();
		// 实例化验证码类		
		$verify = new \Think\Verify();
		$res = $verify -> check($code);
		// 判断验证是否正确
		if ($res) {

			$fdlink = M('friendlink');
			if ($fdlink -> create()) {
				//如果成功,则写入数据库
				$result = $fdlink -> add();
				if ($result) {
					// echo "提交成功,请等待后台人员审核,再与您联系";
					$this -> success("提交成功,请等待后台人员审核,再与您联系",U('FriendLink/index'));
				} else {
					$this -> error("申请失败");
				}
			}
		} else {
			$this -> error('验证码错误');
		}
	}

}