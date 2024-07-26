<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');	
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
	require_once("../Core/Database.php");
	require_once("../Model/UserModel.php");
	
	class UserController {
		private $userModel;
		
		public function __construct() {
			$this->userModel = new UserModel();
		}
		
		public function handleRequest() {
			if($_SERVER['REQUEST_METHOD'] === 'GET') {
				if(isset($_GET['id'])) {
					$this->show();
				} else {
					$this->read();
				}
			} else if($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->create();
			} else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
				$this->update();
			} else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
				$this->delete();
			}
		}
		
		public function read() {
			$read = $this->userModel->read();
			if($read) {
				$user_array = array();
				while($row = $read->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					$user = array(
						'user_id' => $user_id,
						'username' => $username,
						'password' => $password,
						'fullname' => $fullname,
						'phone' => $phone,
						'address' => $address,
						'sex' => $sex,
						'email' => $email,
						'role' => $role
					);
					$user_array[] = $user;
				}
				echo json_encode($user_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			}
		}
		
		public function show() {
			$this->userModel->setUserID($_GET['id']);
			$show = $this->userModel->show();
			if($show) {
				$user_array = array();
				while($row = $show->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					$user = array(
						'user_id' => $user_id,
						'username' => $username,
						'password' => $password,
						'fullname' => $fullname,
						'phone' => $phone,
						'address' => $address,
						'sex' => $sex,
						'email' => $email,
						'role' => $role
					);
					$user_array[] = $user;
				}
				echo json_encode($user_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			}
		}
		
		public function create() {
			$data = json_decode(file_get_contents("php://input"));
			$this->userModel->setUsername($data->username);
			$this->userModel->setPassword($data->password);
			$this->userModel->setFullname($data->fullname);
			$this->userModel->setPhone($data->phone);
			$this->userModel->setAddress($data->address);
			$this->userModel->setSex($data->sex);
			$this->userModel->setEmail($data->email);
			$this->userModel->setRole($data->role);
			if($this->userModel->create()) {
				echo json_encode(array('message', 'User Created'));
			} else {
				echo json_encode(array('message', 'User Not Created'));
			}
		}
		
		public function update() {
			$data = json_decode(file_get_contents("php://input"));
			$this->userModel->setUserID($data->user_id);
			$this->userModel->setUsername($data->username);
			$this->userModel->setPassword($data->password);
			$this->userModel->setFullname($data->fullname);
			$this->userModel->setPhone($data->phone);
			$this->userModel->setAddress($data->address);
			$this->userModel->setSex($data->sex);
			$this->userModel->setEmail($data->email);
			$this->userModel->setRole($data->role);
			if($this->userModel->update()) {
				echo json_encode(array('message', 'User Updated'));
			} else {
				echo json_encode(array('message', 'User Not Updated'));
			}
		}
		
		public function delete() {
			$data = json_decode(file_get_contents("php://input"));
			$this->userModel->setUserID($data->user_id);
			if($this->userModel->delete()) {
				echo json_encode(array('message', 'User Deleted'));
			} else {
				echo json_encode(array('message', 'User Not Deleted'));
			}
		}
		public function login($data) {
			$username = $data->username;
			$password = $data->password;
	
			$result = $this->userModel->login($username, $password);
	
			if ($result !== false) {
				$user_array = array();

				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					$user = array(
						'user_id' => $user_id,
						'username' => $username,
						'fullname' => $fullname,
						'role' => $role
						
					);
					$user_array[] = $user;
				}
				echo json_encode($user_array);
			} else {
				echo json_encode(array('message' => 'Đăng nhập thất bại'));
			}
		}
		public function register($data) {
			$username = $data->username;
			$password = $data->password;
			$fullname = $data->fullname;
			$email = $data->email;
			$phone = $data->phone;
			$address = $data->address;
			$sex = $data->sex;
		
			if ($this->userModel->usernameExists($username)) {
				echo json_encode(array('message' => 'Tên đăng nhập đã tồn tại'));
				return;
			}
		
			if ($this->userModel->register($username, $password, $fullname, $email, $phone, $address, $sex)) {
				$newUser = array(
					'username' => $username,
					'fullname' => $fullname,
					'email' => $email,
					'phone' => $phone,
					'address' => $address,
					'sex' => $sex,
				);
				echo json_encode(array('message' => 'Đăng ký thành công'));
			} else {
				echo json_encode(array('message' => 'Đăng ký thất bại'));
			}
		}		
		
	}
?>
