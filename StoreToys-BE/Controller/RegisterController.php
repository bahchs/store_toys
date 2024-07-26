<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once("../Core/Database.php");
require_once("../Model/UserModel.php");

class RegisterController{
    private $userModel;
    
    public function __construct(){
        $this->userModel = new UserModel();
    }
    
    public function handleRequest(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->register();
        }
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"));
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
