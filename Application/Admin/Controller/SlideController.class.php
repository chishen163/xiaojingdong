<?php
namespace Admin\Controller;
use Think\Controller;
//幻灯片设置控制器
class SlideController extends Controller {
	public function index(){
		$res = M("category");
		$category = $res -> select();
		$this -> assign("category",$category);
		$this -> display();
    }

    public function gethome(){
    		$res = M("slide");
    		$where['cid'] = I('id');

                    //数据总条数
                    $page['count'] = $res -> field("cid") -> where($where) -> count();

                    //每页显示的条数
                    $page['pagesize'] = 10;

                    //计算总页数
                    $page['pagecount'] = ceil($page['count'] / $page['pagesize']);

                    //获取当前页码
                    $page['page'] = I("page");
                    if(empty($page['page'])){
                        $page['page'] = 1;
                    }


    		$slide = $res -> where($where) -> page($page['page'],$page['pagesize']) -> select();

    		if(empty($slide)){
                        //如果出错就传递0
                        echo json_encode(0);
                    }else{
                        //将分页变量个查询到的商品变量组合成数组
                        $arr['slide'] = $slide;
                        $arr['page'] = $page;
                        //将组合的数组用json格式传递到前台
                        echo json_encode($arr);
                    }
    }

    public function getDelete(){
    		$res =M("slide");
    		$where['id'] = I("id");
    		$slide = $res -> where($where) -> delete();
    		echo json_encode($slide);
    }


       // 多选删除
        public function checkAll(){
            $res = M("slide");
            $arr = I("id");
            $id = explode(',',$arr);
            $counts = count($id);
            for($i=0;$i<$counts;$i++){
                $where['id'] = $id[$i];
                $result = $res -> where($where) -> delete();
            }
            if(!empty($result)){
                echo json_encode($result);
            }else{
                echo json_encode(0);
            }
        }
}
