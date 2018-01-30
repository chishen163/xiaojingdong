<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends Controller{
	public function index(){
		// 调用Header控制器的index方法
      	R("Header/index");

      	$res = M("goods");
      	$low = I('low');
    		$high = I('high');

      	// 组合查询关键字
      	$key = "%".I("key")."%";
      	$where['goodsname'] = array('like',$key);
      	$where['keywords'] = array('like',$key);
      	$where['_logic'] = 'or';

      	//数据总条数
    		$page['count'] = $res -> field("cid") -> where($where) -> count();

    		//每页显示的条数
    		$page['pagesize'] = 8;

    		//计算总页数
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);

    		//获取当前页码
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}

    		if(!empty($low) && !empty($high)){
    			$where['promoteprice'] = array('between',array($low,$high));
    			$where['_logic'] = 'and';
    		}elseif(!empty($low) && empty($high)){
    			$where['promoteprice'] = array('egt',$low);
    			$where['_logic'] = 'and';
    		}elseif(!empty($high) && empty($low)){
    			$where['promoteprice'] = array('elt',$high);
    			$where['_logic'] = 'and';
    		}

    		switch(I("act")){
    			case getSales:
    				$goods = $res -> where($where) -> order("goodssales desc") -> page($page['page'],$page['pagesize']) -> select();
    				break;
    			case getPriceOrder:
    				$goods = $res -> where($where) -> order("promoteprice asc") -> page($page['page'],$page['pagesize']) -> select();
    				break;
    			case getIsGood:
    				$goods = $res -> where($where) -> order("isGood desc") -> page($page['page'],$page['pagesize']) -> select();
    				break;
    			case getNew:
    				$goods = $res -> where($where) -> order("addtime desc") -> page($page['page'],$page['pagesize']) -> select();
    				break;
    			default:
    				$goods = $res -> where($where) -> page($page['page'],$page['pagesize']) -> select();
    				break;
    		}



      	

      	if(empty($goods)){
      		$this -> assign("goods","null");
      	}else{
      		$this -> assign("goods",$goods);
      	}
      
      	$this -> assign("page",$page);
      	$this -> assign("keys",I('key'));

      	// 查询销量
      	$sales = $res -> order("goodssales desc") ->limit(5) -> select();
      	$this -> assign("sales",$sales);

		$this -> display();
	}

	 // 查询商品详细信息
    public function getGoods(){
    		$res = M("goods");
    		$where['id'] = I("id");
    		$data = $res -> where($where) -> find();
    		echo json_encode($data);
    }
}