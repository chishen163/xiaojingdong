<?php
namespace Home\Controller;
use Think\Controller;
class GoodsListController extends Controller {
    public function index($goods,$page){
    		R("Header/index");

                    $res = M("plate");
                    $wheres['id'] = I("id");
                    $result = $res -> field('cid,listName') -> where($wheres) -> find();
                    $this -> assign("dataname",$result);

                    $category = M("category");
                    $where['id'] = $result['cid'];
                    $category = $category -> where($where) -> find();
                    $this -> assign("category",$category);

                    $wherec['cid'] = $result['cid'];
                    $p_nav = $res -> where($wherec) -> select();
                    $this -> assign("datas",$p_nav);            

    		// 销售排行
    		$res = M("goods");
    		$whereg['cid'] = I('id');
    		$sales = $res -> where($whereg) -> order("goodssales asc") ->limit(4) -> select();
    		$this -> assign("sales",$sales);

                    $like = $res -> where($whereg) -> order("addtime desc") -> limit(4) -> select();
                    $this -> assign("like",$like);
		
		// 判断传递过来的商品变量是否为空
		if(!empty($goods)){
    			$this -> assign("goods",$goods);
    		}else{
    			$this -> assign("goods","null");
    		}
            // var_dump($where['cid']);
                    $this -> assign("where",$whereg);
    		$this -> assign("page",$page);
		$this -> display("index");
    }

    // 查询商品详细信息
    public function getGoods(){
    		$res = M("goods");
    		$where['id'] = I("id");
    		$data = $res -> where($where) -> find();
    		echo json_encode($data);
    }

    // 按默认排序
    public function getDefault(){
    		$res = M("goods");
    		$where['cid'] = I("id");
    		if(empty($where['cid'])){
    			$where['cid'] = 1;
    		}
    		//数据总条数
    		$page['count'] = $res -> field("cid") -> where($where) -> count();

    		//每页显示的条数
    		$page['pagesize'] = 20;

    		//计算总页数
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);

    		//获取当前页码
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}

    		$goods = $res ->where($where)-> page($page['page'],$page['pagesize']) -> select();
    		$this -> index($goods,$page);
    }

    // 商品价格搜索
    public function getPrice(){
    		$res = M("goods");
    		$where['cid'] = I('id');
    		$low = I('low');
    		$high = I('high');
    		if(empty($where['cid'])){
    			$where['cid'] = 1;
    		}
    		if(!empty($low) && !empty($high)){
    			$where['promoteprice'] = array('between',array($low,$high));
    		}elseif(!empty($low) && empty($high)){
    			$where['promoteprice'] = array('egt',$low);
    		}elseif(!empty($high) && empty($low)){
    			$where['promoteprice'] = array('elt',$high);
    		}

    		//数据总条数
    		$page['count'] = $res -> field("cid") -> where($where) -> count();

    		//每页显示的条数
    		$page['pagesize'] = 20;

    		//计算总页数
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);

    		//获取当前页码
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}
    		$goods = $res -> where($where) -> page($page['page'],$page['pagesize']) -> select();

    		$this -> index($goods,$page);
    }

    // 按销售量排序
    public function getSales(){
    		$res = M("goods");
    		$where['cid'] = I('id');
    		if(empty($where['cid'])){
    			$where['cid'] = 1;
    		}

    		$page['count'] = $res -> field("cid") -> where($where) -> count();
    		$page['pagesize'] = 20;
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}
    		$goods = $res -> where($where) -> order("goodssales desc") -> page($page['page'],$page['pagesize']) -> select();
    		$this -> index($goods,$page);
    }

    // 按价格排序
    public function getPriceOrder(){
    		$res = M("goods");
    		$where['cid'] = I("id");
    		if(empty($where['cid'])){
    			$where['cid'] = 1;
    		}
    		$page['count'] = $res -> field("cid") -> where($where) -> count();
    		$page['pagesize'] = 20;
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}
    		$goods = $res -> where($where) -> page($page['page'],$page['pagesize']) -> order("promoteprice asc") -> select();
    		$this -> index($goods,$page);
    }

    // 按好评排序
    public function getIsGood(){
    		$res = M("goods");
    		$where['cid'] = I("id");
    		if(empty($where['cid'])){
    			$where['cid'] = 1;
    		}
    		$page['count'] = $res -> field("cid") -> where($where) -> count();
    		$page['pagesize'] = 20;
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}
    		$goods = $res -> where($where) -> page($page['page'],$page['pagesize']) -> order("isGood desc") -> select();

    		$this -> index($goods,$page);
    }

    //按最新上架时间排序
    public function getNew(){
    		$res = M("goods");
    		$where['cid'] = I("id");
    		if(empty($where['cid'])){
    			$where['cid'] = 1;
    		}
    		$page['count'] = $res -> field("cid") -> where($where) -> count();
    		$page['pagesize'] = 20;
    		$page['pagecount'] = ceil($page['count'] / $page['pagesize']);
    		$page['page'] = I("page");
    		if(empty($page['page'])){
    			$page['page'] = 1;
    		}
    		$goods = $res -> where($where) -> page($page['page'],$page['pagesize']) -> order("addtime desc") -> select();
    		$this -> index($goods,$page);
    }

}