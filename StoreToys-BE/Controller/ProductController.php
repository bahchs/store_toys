<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');	
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
	require_once("../Core/Database.php");
	require_once("../Model/ProductModel.php");
	
	class ProductController{
		private $productModel;
		public function __construct(){
			$this->productModel = new ProductModel();
		}
		
		public function handleRequest(){
			switch($_SERVER['REQUEST_METHOD']){
				case 'GET':
					$id = isset($_GET['id']) ? $_GET['id'] : '';
					if (empty($id)) {
						$this->read();
					} 
					else {
						$this->readid($id);
					}
					break;
				case 'POST':
					$this->create();
					break;
				case 'PUT':
					$this->update();
					break;
				case 'DELETE':
					$this->delete();
					break;
				default:
					http_response_code(405);
					echo json_encode(array("message" => "Method Not Allowed"));
					break;
			}
		}
		
		public function read(){
			$read = $this->productModel->read();
			if($read){
				$product_array = array();
				while($row = $read->fetch(PDO::FETCH_ASSOC)){
						
					extract($row);
					$product = array(
						'product_id' => $product_id,
						'category_name' => $category_name,
						'brand_name' => $brand_name,
						'product_name' => $product_name,
						'product_img' => $product_img,
						'product_sex' => $product_sex,
						'product_price' => $product_price,
					);
					$product_array[] = $product;
				}
				echo json_encode($product_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			} else {
				echo json_encode(array("message" => "No products found"));
			}
		}
		public function readid($id){
			$read = $this->productModel->readid($id);
			if($read){
				$row = $read->fetch(PDO::FETCH_ASSOC);
				if ($row) {
					extract($row);
					$product = array(
						'product_id' => $product_id,
						'category_name' => $category_name,
						'brand_name' => $brand_name,
						'product_name' => $product_name,
						'product_img' => $product_img,
						'product_sex' => $product_sex,
						'product_price' => $product_price,
					);
					echo json_encode($product, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
				} else {
					echo json_encode(array("message" => "Product not found"));
				}
			} else {
				echo json_encode(array("message" => "No products found"));
			}
		}		
		
		public function updateProduct(){
			$data = json_decode(file_get_contents("php://input"));
			$this->productModel->setCategoryID($data->category_id);
			$this->productModel->setBrandID($data->brand_id);
			$this->productModel->setProductName($data->product_name);
			$this->productModel->setProductImg($data->product_img);
			$this->productModel->setProductSex($data->product_sex);
			$this->productModel->setProductPrice($data->product_price);
			
			$this->productModel->setProductID($data->product_id);
			$action = $this->productModel->update();			
			echo json_encode(array("message" => "Product " . $action));
		}

		public function createProduct(){
			$data = json_decode(file_get_contents("php://input"));
			$this->productModel->setCategoryID($data->category_id);
			$this->productModel->setBrandID($data->brand_id);
			$this->productModel->setProductName($data->product_name);
			$this->productModel->setProductImg($data->product_img);
			$this->productModel->setProductSex($data->product_sex);
			$this->productModel->setProductPrice($data->product_price);

			$action = $this->productModel->create();
			
			echo json_encode(array("message" => "Product success! " ));
		}

		public function create(){
			$this->createProduct();
		}
		
		public function update(){
			$this->updateProduct();
		}
		
		public function delete(){
			$data = json_decode(file_get_contents("php://input"));
			$this->productModel->setProductID($data->product_id);
			
			$action = $this->productModel->delete() ? "Deleted" : "Not Deleted";
	
			echo json_encode(array("message" => "Product " . $action));
		}

	}
?>
