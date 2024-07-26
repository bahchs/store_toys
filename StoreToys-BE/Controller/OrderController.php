<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');	
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
	require_once("../Core/Database.php");
	require_once("../Model/OrderModel.php");
	require_once("../Model/OrderDetailModel.php");
	require_once("../Model/CartModel.php");
	
	class OrderController{
		private $orderModel;
		private $orderDetailModel;
		private $cartModel;
		
		public function __construct(){
			$this->orderModel = new OrderModel();
			$this->orderDetailModel = new OrderDetailModel();
			$this->cartModel = new CartModel();
		}
		public function handleRequest(){
			if($_SERVER['REQUEST_METHOD'] === 'GET'){
				if(isset($_GET['id_user'])){
					$this->showOrder();
				} else if($_GET['id_order']){
					$this->showOrderDetail();
				}
			} else if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->create();
			}
		}
		public function showOrder(){
			$this->orderModel->setUserID($_GET['id_user']);
			$show = $this->orderModel->show();
			if($show){
				$oder_array = array();
				while($row = $show->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$order = array(
					'order_id' => $order_id,
					'user_id' => $user_id,
					'total_money' => $total_money,
					'order_date' => $order_date,
					'note' => $note
				);
				$order_array[] = $order;
				}
			echo json_encode($order_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			}
		}
		public function showOrderDetail(){
			$this->orderDetailModel->setOrderID($_GET['id_order']);
			$show = $this->orderDetailModel->show();
			if($show){
				$order_detail_array = array();
				while($row = $show->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$order_detail = array(
					'id' => $id,
					'order_id' => $order_id,
					'product_id' => $product_id,
					'quantity' => $quantity,
					'total_price' => $total_price
				);
				$order_detail_array[] = $order_detail;
				}
			echo json_encode($order_detail_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			}
		}
		
		public function create(){
			$data = json_decode(file_get_contents("php://input"));
			$this->orderModel->setUserID($data->user_id);
			$this->orderModel->setTotalMoney($data->total_money);
			$this->orderModel->setOrderDate($data->order_date);
			$this->orderModel->setNote($data->note);
			$orderID = $this->orderModel->create();
			$response = array();
		
			if($orderID){
				$response['order_message'] = 'Order Created';
				foreach($data->product as $product){
					$this->orderDetailModel->setOrderID($orderID);
					$this->orderDetailModel->setProductID($product->product_id);
					$this->orderDetailModel->setQuantity($product->quantity);
					$this->orderDetailModel->setTotalPrice($product->total_price);
					if($this->orderDetailModel->create()){
						$response['order_detail_message'] = 'OrderDetail Created';
					} else{
						$response['order_detail_message'] = 'OrderDetail Not Created';
					}
				}
				$this->cartModel->setUserID($data->user_id);
				if($this->cartModel->delete()){
					$response['cart_message'] = 'Cart Deleted';
				} else{
					$response['cart_message'] = 'Cart Not Deleted';
				}
			} else{
				$response['order_message'] = 'Order Not Created';
			}
			echo json_encode($response);
		}
		
	}
?>