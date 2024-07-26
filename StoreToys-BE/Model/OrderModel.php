<?php
	class OrderModel extends Database{
		private $order_id;
		private $user_id;
		private $total_money;
		private $order_date;
		private $note;
		public function __construct(){
			$this -> connect();
		}
		public function show(){
			$query = "SELECT * FROM orders WHERE user_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			$statement->execute();
			return $statement;
		}
		public function create(){
			$query = "INSERT INTO orders (user_id, total_money, order_date, note) VALUES (?, ?, ?, ?)";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			$statement->bindParam(2, $this->total_money);
			$statement->bindParam(3, $this->order_date);
			$statement->bindParam(4, $this->note);
			if($statement->execute()){
				$lastInsertedId = $this->con->lastInsertId();
        		return $lastInsertedId;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function setUserID($userID){
			$this->user_id = $userID;
		}
		public function setTotalMoney($totalMoney){
			$this->total_money = $totalMoney;
		}
		public function setOrderDate($orderDate){
			$this->order_date = $orderDate;
		}
		public function setNote($note){
			$this->note = $note;
		}
	}
?>