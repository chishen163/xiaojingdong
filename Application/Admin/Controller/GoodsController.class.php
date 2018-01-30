<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller {

    public function index(){
		$res = M("category");
		$category = $res -> select();
		$this ->assign("category",$category);

		$this -> display();
	}

	public function getPlate(){
		$res = M("plate");
		$where['cid'] = I("id");
		$goods = $res -> where($where) -> select();
		if(empty($goods)){
			echo json_encode("null");
		}else{
			echo json_encode($goods);
		}
 	}

 	public function getGoods(){
 		$res = M("goods");
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

 		$goods = $res -> where($where) -> page($page['page'],$page['pagesize']) -> select();

 		if(empty($goods)){
                        //如果出错就传递0
                        echo json_encode(0);
                    }else{
                        //将分页变量个查询到的商品变量组合成数组
                        $arr['goods'] = $goods;
                        $arr['page'] = $page;
                        //将组合的数组用json格式传递到前台
                        echo json_encode($arr);
                    }
 	}

 	// 获取全部商品
 	public function getGoodsAll(){
 		$res = M("goods");
 		$where['cid'] = I('id');

 		//数据总条数
    		$page['count'] = $res -> count();

    		//每页显示的条数
    		$page['pagesize'] = 10;

    		//计算总页数
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);

    		//获取当前页码
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}

 		if($where['cid'] == "all"){
 			$goods = $res -> page($page['page'],$page['pagesize']) -> select();
 		}
 		if(empty($goods)){
                                //如果出错就传递0
 			echo json_encode(0);
 		}else{
                            //将分页变量个查询到的商品变量组合成数组
                            $arr['goods'] = $goods;
                            $arr['page'] = $page;
                            //将组合的数组用json格式传递到前台
                            echo json_encode($arr);
 		}
 	}


 	// 删除商品
 	public function getDelete(){
 		$res = M("goods");
 		$where['id'] = I('id');
 		$goods = $res -> where($where) -> delete();

 		if($goods){
 			$this -> success("商品删除成功！","/Goods/index");
 		}else{
 			$this -> error("商品删除失败！");
 		}

 		echo $goods;
 	}


        public function addPlate(){
            $res = M("plate");
            $plate = $res -> create(I());
            $result = $res -> data($plate) -> add();
            if($result){
                echo $result;
            }else{
                echo 0;
            }
        }

        public function delPlate(){
            $res = M("plate");
            $where['id'] = I("id");
            $result = $res -> where($where) -> delete();
            echo $result;
        }

        public function updPlate(){
            $res = M("plate");
            $where['id'] = I("id");
            $where['listName'] = I("listName");
            $result = $res -> save($where);
            echo $result;
        }

        // 多选删除
        public function checkAll(){
            $res = M("goods");
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

        public function getSort(){
            $res = M("goods");
            $action['act'] = I("act");
            $where['cid'] = I("cid");

            //数据总条数
            $page['count'] = $res -> count();

            //每页显示的条数
            $page['pagesize'] = 10;

            //计算总页数
            $page['pagecount'] = ceil($page['count'] / $page['pagesize']);

            //获取当前页码
            $page['page'] = I("page");
            if(empty($page['page'])){
                $page['page'] = 1;
            }

            if($where['cid'] == 0){
                switch($action['act']){
                    case 1:
                        $goods = $res -> page($page['page'],$page['pagesize']) -> order("id asc") -> select();
                        break;
                    case 2:
                        $goods = $res -> page($page['page'],$page['pagesize']) -> order("id desc") -> select();
                        break;
                }
            }else{

                switch($action['act']){
                    case 1:
                        $goods = $res -> page($page['page'],$page['pagesize']) -> where($where) -> order("id asc") -> select();
                        break;
                    case 2:
                        $goods = $res -> page($page['page'],$page['pagesize']) -> where($where) -> order("id desc") -> select();
                        break;
                }
            }
            if(empty($goods)){
                //如果出错就传递0
                    echo json_encode(0);
                }else{
                    //将分页变量个查询到的商品变量组合成数组
                    $arr['goods'] = $goods;
                    $arr['page'] = $page;
                    //将组合的数组用json格式传递到前台
                    echo json_encode($arr);
                }
        }
}