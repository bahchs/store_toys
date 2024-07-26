<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');	
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
	require_once("../Core/Database.php");
	require_once("../Model/BrandModel.php");
	
	class BrandController {
		private $brandModel;
		
		public function __construct() {
			$this->brandModel = new BrandModel();
		}
		
		public function handleRequest() {
			switch ($_SERVER['REQUEST_METHOD']) {
				case 'GET':
					$this->read();
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
					http_response_code(405); // Method Not Allowed
					echo json_encode(array("message" => "Method Not Allowed"));
					break;
			}
		}
		
		public function read() {
			$read = $this->brandModel->read();
			if ($read) {
				$brand_array = array();
				while ($row = $read->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					$brand = array(
						'brand_id' => $brand_id,
						'brand_name' => $brand_name,
						'brand_img' => $brand_img
					);
					$brand_array[] = $brand;
				}
				echo json_encode($brand_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			} else {
				echo json_encode(array("message" => "No brands found"));
			}
		}
		
		public function createOrUpdate($isUpdate = false) {
			$data = json_decode(file_get_contents("php://input"));
			$this->brandModel->setBrandName($data->brand_name);
			$this->brandModel->setBrandImg($data->brand_img);
			
			if ($isUpdate) {
				$this->brandModel->setBrandID($data->brand_id);
				$action = $this->brandModel->update() ? "Updated" : "Not Updated";
			} else {
				$action = $this->brandModel->create() ? "Created" : "Not Created";
			}
			
			echo json_encode(array("message" => "Brand " . $action));
		}

		
		public function create() {
			$this->createOrUpdate();
		}
		
		public function update() {
			$this->createOrUpdate(true);
		}
		
		public function delete() {
			$data = json_decode(file_get_contents("php://input"));
			$this->brandModel->setBrandID($data->brand_id);
			
			$action = $this->brandModel->delete() ? "Deleted" : "Not Deleted";
	
			echo json_encode(array("message" => "Brand " . $action));
		}
	}
?>
