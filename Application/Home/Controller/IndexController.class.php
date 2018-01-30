<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
        // 调用Header控制器的index方法
        R("Header/index");

        //修改网站配置
        $setup = M('website');
        $sta = 1;
        $res = $setup -> where("status = {$sta}") -> find();
        $this -> assign("setup",$res);
        
        //判断用户登录状态
        $user = $_SESSION['user'];
        $this -> assign('user',$user);

        //如果用户为登陆状态，刷新首页不显示广告，否则显示
        if(empty($user)){
        	$this -> assign("state",0);
        }else{
        	$this -> assign("state",1);
        }

        // 查询首页幻灯片
        $res = M("slide");
        $where['cid'] = 0; 
        $slide = $res -> where($where) -> order("id desc") -> limit(8) -> select();
        $this -> assign("slide",$slide);

       $resg = D("goods");
        $resc = D('category');
        $cate = $resc -> select();

        $food = array();
        foreach ($cate as $key => $value){
            $whereg['pid'] = $cate[$key]['id'];
            $food[$key]['navName'] = $cate[$key]['name'];
            $food[$key]['pid'] = $cate[$key]['id'];
            $food[$key]['menu'] = $resg -> where($whereg) -> order("addtime desc") -> limit(12) -> select();
        }

        //将没有商品的数组销毁
        $len = count($food);
            for($i=0;$i<$len;$i++){
                if($food[$i]['menu'] == null){
                    unset($food[$i]);
                }
            }
           $this -> assign("goods",$food);
           // var_dump($food);

         //新增，判断超全局数组$_SESSION['cart']中是否有购物车信息，如果有，需要分配一个标志变量去头部
        if (isset($_SESSION['cart'])) {
            $cart_info = $_SESSION['cart'];
            $num = 0;
            foreach($cart_info as $value) {
                $num += $value['num'];
            }
        }

        $this -> assign('num', $num);
        $this -> assign('cart_info', $cart_info);
        
        $this -> display();
    }

    //获取首页幻灯片地址
    public function getSlideImg(){
        $res = M('slide');
        $count = $res -> select();
        echo json_encode($count);
    }

    public function getBanner(){
        $res = M('slide');
        $where['cid'] = 0;
        $banner = $res -> where($where) -> order("id desc") -> find();
        echo json_encode($banner);
    }

    //退出登录   
    public function loginout() {
        $_SESSION['user'] = null;
        $this -> redirect("Index/index");
    }

}