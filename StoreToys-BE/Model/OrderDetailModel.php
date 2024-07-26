<?php
	class OrderDetailModel extends Database{
		private $id;
		private $order_id;
		private $product_id;
		private $quantity;
		private $total_price;
		
		public function __construct(){
			$this -> connect();
		}
		public function show(){
			$query = "SELECT * FROM order_detail WHERE order_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->order_id);
			$statement->execute();
			return $statement;
		}
		
		public function create(){
			$query = "INSERT INTO order_detail (order_id, product_id, quantity, total_price) 
							VALUES (?, ?, ?, ?)";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->order_id);
			$statement->bindParam(2, $this->product_id);
			$statement->bindParam(3, $this->quantity);
			$statement->bindParam(4, $this->total_price);
			if($statement->execute()){
				return true;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function setOrderID($orderID){
			$this->order_id = $orderID;
		}
		public function setProductID($productID){
			$this->product_id = $productID;
		}
		public function setQuantity($quantity){
			$this->quantity = $quantity;
		}
		public function setTotalPrice($totalPrice){
			$this->total_price = $totalPrice;
		}
	}
?>