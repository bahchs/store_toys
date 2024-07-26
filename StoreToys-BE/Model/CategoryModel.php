<?php
	class CategoryModel extends Database{
		private $category_id;
		private $category_name;
		public function __construct(){
			$this -> connect();
		}
		public function read(){
			$query = "SELECT * FROM category";
			$statement = $this->con->prepare($query);
			$statement->execute();
			return $statement;
		}
		public function show(){
			$query = "SELECT * FROM category WHERE category_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->category_id);
			$statement->execute();
			return $statement;
		}
		public function create(){
			$query = "INSERT INTO category (category_name) VALUES(?)";
			$statement = $this->con->prepare($query);
			$this->category_name = htmlspecialchars(strip_tags($this->category_name));
			$statement->bindParam(1, $this->category_name);
			if($statement->execute()){
				return true;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function update(){
			$query = "UPDATE category SET category_name = ? WHERE category_id = ?";
			$statement = $this->con->prepare($query);
			$this->category_name = htmlspecialchars(strip_tags($this->category_name));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			$statement->bindParam(1, $this->category_name);
			$statement->bindParam(2, $this->category_id);
			if($statement->execute()){
				return true;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function delete(){
			$query = "DELETE FROM category WHERE category_id = ?";
			$statement = $this->con->prepare($query);
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			$statement->bindParam(1, $this->category_id);
			if($statement->execute()){
				return true;
			} else{
				printf("Error %s.\n" ,$statement->error);
				return false;
			}
		}
		public function setName($name){
			$this->category_name = $name;
		}
		public function setID($id){
			$this->category_id = $id;
		}
	}
?>