<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');    
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
require_once("../Core/Database.php");
require_once("../Model/CartModel.php");

class CartController{
    private $cartModel;

    public function __construct(){
        $this->cartModel = new CartModel();
    }

    public function handleRequest(){
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $this->show();
        } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->createOrUpdateCartItem(); 
        } else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $this->update();
        } else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            $this->delete();
        }
    }

    public function show(){
		$user_id = $_GET['user_id'] ?? null;
		if($user_id !== null) {
			$this->cartModel->setUserID($user_id);
			$show = $this->cartModel->show();
			if($show){
				$cart_array = array();
				while($row = $show->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					$cart = array(
						'cart_id' => $cart_id,
						'user_id' => $user_id,
						'product_id' => $product_id,
						'product_name' => $product_name,
						'product_img' => $product_img,
						'product_price' => $product_price,
						'quantity' => $quantity,
					);
					$cart_array[] = $cart;
				}
				echo json_encode($cart_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			}
		} else {
			echo json_encode(array('message' => 'Missing user_id in URL'));
		}
	}
	

    public function createOrUpdateCartItem(){ 
        $data = json_decode(file_get_contents("php://input"));
        $user_id = $data->user_id ?? null; 
        if($user_id !== null) {
            $this->cartModel->setUserID($user_id);
            $this->cartModel->setProductID($data->product_id);
            $show = $this->cartModel->checkCart();
            if($show){
                if(!$show->fetch(PDO::FETCH_ASSOC)){
                    $this->cartModel->setQuantity($data->quantity);
                    if($this->cartModel->create()){
                        echo json_encode(array('message', 'Sản phẩm đã được thêm vào giỏ hàng thành công'));
                    } else{
                        echo json_encode(array('message', 'Thêm sản phẩm vào giỏ hàng thất bại'));
                    }
                } else{
                    $show = $this->cartModel->getQuantity();
                    $row = $show->fetch(PDO::FETCH_ASSOC);
                    $quantityNew = $data->quantity + $row['quantity'];
                    $this->cartModel->setQuantity($quantityNew);
                    if($this->cartModel->update()){
                        echo json_encode(array('message', 'Sản phẩm đã được thêm vào giỏ hàng thành công'));
                    } else{
                        echo json_encode(array('message', 'Cập nhật giỏ hàng thất bại'));
                    }
                }
            }
        } else {
            echo json_encode(array('message' => 'Missing user_id in request'));
        }
    }

    public function update(){
		$user_id = $_GET['user_id'] ?? null;
		$data = json_decode(file_get_contents("php://input"));
		if($user_id !== null && isset($data->quantity)) { 
			$this->cartModel->setUserID($user_id);
			$this->cartModel->setQuantity($data->quantity);
			if($this->cartModel->update()){
				echo json_encode(array('message' => 'Cart Updated'));
			} else{
				echo json_encode(array('message' => 'Cart Not Updated'));
			}
		} else {
			echo json_encode(array('message' => 'Missing user_id or quantity in request'));
		}
	}
	
	public function delete(){
		$user_id = $_GET['user_id'] ?? null; 
		$product_id = $_GET['id'] ?? null;
		$data = json_decode(file_get_contents("php://input"));
		if($user_id !== null && $product_id !== null) { 
			$this->cartModel->setUserID($user_id);
			$this->cartModel->setProductID($product_id);
			if($this->cartModel->delete()){
				echo json_encode(array('message' => 'Cart Deleted')); 
			} else{
				echo json_encode(array('message' => 'Cart Not Deleted')); 
			}
		} else {
			echo json_encode(array('message' => 'Missing user_id or product_id in request')); 
		}
	}	
	
}
?>
