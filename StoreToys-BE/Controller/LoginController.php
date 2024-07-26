<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once("../Core/Database.php");
require_once("../Model/UserModel.php");

class LoginController{
    private $userModel;
    
    public function __construct(){
        $this->userModel = new UserModel();
    }
    
    public function handleRequest(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->getUser();
        }
    }
    
    public function getUser(){
        $data = json_decode(file_get_contents("php://input"));
        $username = $data->username;
        $password = $data->password;

        $result = $this->userModel->login($username, $password);

        if ($result !== false) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $user = array(
                'user_id' => $user_id,
                'username' => $username,
				'password' => $password,
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'sex' => $sex,
                'role' => $role
            );
            
            echo json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('message' => 'Đăng nhập thất bại'));
        }
    }
}
?>
