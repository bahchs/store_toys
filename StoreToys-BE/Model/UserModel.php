<?php
	class UserModel extends Database{
		private $user_id;
		private $username;
		private $password;
		private $fullname;
		private $phone;
		private $address;
		private $sex;
		private $email;
		private $role;

		public function __construct(){
			$this->connect();
		}

		public function read(){
			$query = "SELECT * FROM user";
			$statement = $this->con->prepare($query);
			$statement->execute();
			return $statement;
		}

		public function show(){
			$query = "SELECT * FROM user WHERE user_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			$statement->execute();
			return $statement;
		}

		public function create(){
			$query = "INSERT INTO user (username, password, fullname, phone, address, sex, email, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$statement = $this->con->prepare($query);
			$this->bindValues($statement);
			if($statement->execute()){
				return true;
			} else {
				printf("Error: %s.\n", $statement->error);
				return false;
			}
		}

		public function update(){
			$query = "UPDATE user SET username = ?, password = ?, fullname = ?, phone = ?, address = ?, sex = ?, email = ?, role = ? WHERE user_id = ?";
			$statement = $this->con->prepare($query);
			$this->bindValues($statement);
			$statement->bindParam(9, $this->user_id);
			if($statement->execute()){
				return true;
			} else {
				printf("Error: %s.\n", $statement->error);
				return false;
			}
		}

		public function delete(){
			$query = "DELETE FROM user WHERE user_id = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $this->user_id);
			if($statement->execute()){
				return true;
			} else {
				printf("Error: %s.\n", $statement->error);
				return false;
			}
		}
		public function login($username, $password){
			$query = "SELECT * FROM user WHERE username = ? AND password = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $username);
			$statement->bindParam(2, $password);
			$statement->execute();

			if ($statement->rowCount() > 0) {
				return $statement;
			} else {
				return false;
			}
		}
		public function register($username, $password, $fullname, $email, $phone, $address, $sex){
			if ($this->usernameExists($username)) {
				return false; 
			}

			$query = "INSERT INTO user (username, password, fullname, email, phone, address, sex, role) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $username);
			$statement->bindParam(2, $password);
			$statement->bindParam(3, $fullname);
			$statement->bindParam(4, $email);
			$statement->bindParam(5, $phone);
			$statement->bindParam(6, $address);
			$statement->bindParam(7, $sex);

			if ($statement->execute()) {
				return true; 
			} else {
				return false;
			}
		}
		public function usernameExists($username)
		{
			$query = "SELECT * FROM user WHERE username = ?";
			$statement = $this->con->prepare($query);
			$statement->bindParam(1, $username);
			$statement->execute();

			if ($statement->rowCount() > 0) {
				return true; 
			} else {
				return false; 
			}
		}

		public function setUserId($user_id){
			$this->user_id = $user_id;
		}		

		public function setUsername($username){
			$this->username = $username;
		}

		public function setPassword($password){
			$this->password = $password;
		}

		public function setFullname($fullname){
			$this->fullname = $fullname;
		}

		public function setPhone($phone){
			$this->phone = $phone;
		}

		public function setAddress($address){
			$this->address = $address;
		}

		public function setSex($sex){
			$this->sex = $sex;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function setRole($role){
			$this->role = $role;
		}

		private function bindValues($statement){
			$statement->bindParam(1, $this->username);
			$statement->bindParam(2, $this->password);
			$statement->bindParam(3, $this->fullname);
			$statement->bindParam(4, $this->phone);
			$statement->bindParam(5, $this->address);
			$statement->bindParam(6, $this->sex);
			$statement->bindParam(7, $this->email);
			$statement->bindParam(8, $this->role);
		}
	}
?>
