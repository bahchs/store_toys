<?php
	class CartModel extends Database{
		private $cart_id;
		private $user_id;
		private $product_id;
		private $quantity;
		
		public function __construct(){
			$this->connect();
		}
		public function show(){
			$query = "SELECT cart.cart_id, product.product_name, product.product_img, product.product_price, cart.quantity, cart.product_id FROM cart
						INNER JOIN product ON cart.product_id = product.product_id WHERE user_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			if ($statement->execute()) {
            	return $statement;
        	} else {
            	printf("Error %s.\n", $statement->error);
            	return false;
        	}
		}
		public function create(){
			$query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			$statement->bindParam(2, $this->product_id);
			$statement->bindParam(3, $this->quantity);
			if($statement->execute()){
				return true;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function update(){
			$query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->quantity);
			$statement->bindParam(2, $this->user_id);
			$statement->bindParam(3, $this->product_id);
			if($statement->execute()){
				return true;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function delete(){
			$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			$statement->bindParam(2, $this->product_id);
			if($statement->execute()){
				return true;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function checkCart(){
			$query = "SELECT product_id FROM cart WHERE user_id = ? AND product_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			$statement->bindParam(2, $this->product_id);
			if($statement->execute()){
				return $statement;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function getQuantity(){
			$query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			$statement->bindParam(2, $this->product_id);
			if($statement->execute()){
				return $statement;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function setUserID($userID){
			$this->user_id = $userID;
		}
		public function setProductID($productID){
			$this->product_id = $productID;
		}
		public function setQuantity($quantity){
			$this->quantity = $quantity;
		}
	}
?>