<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');	
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
	require_once("../Core/Database.php");
	require_once("../Model/CategoryModel.php");
	class CategoryController{
		private $categoryModel;
		public function __construct(){
			$this->categoryModel = new CategoryModel();
		}
		public function handleRequest(){
			if($_SERVER['REQUEST_METHOD'] === 'GET'){
				if(isset($_GET['id'])){
					$this->show();
				} else{
					$this->read();
				}
			} else if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->create();
			} else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
				$this->update();
			} else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
				$this->delete();
			}
		}
		public function read(){
			$read = $this->categoryModel->read();
			if($read){
				$category_array = array();
				while($row = $read->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$category = array(
					'category_id' => $category_id,
					'category_name' => $category_name,
				);
				$category_array[] = $category;
				}
			echo json_encode($category_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			}
		}
		public function show(){
			$this->categoryModel->setID($_GET['id']);
			$show = $this->categoryModel->show();
			if($show){
				$category_array = array();
				while($row = $show->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					$category = array(
						'category_id' => $category_id,
						'category_name' => $category_name
					);
				$category_array[] = $category;
				}
				echo json_encode($category_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			}
		}
		public function create(){
			$data = json_decode(file_get_contents("php://input"));
			$this->categoryModel->setName($data->category_name);
			if($this->categoryModel->create()){
				echo json_encode(array('message', 'Category Created'));
			} else{
				echo json_encode(array('message', 'Category Not Created'));
			}
		}
		public function update(){
			$data = json_decode(file_get_contents("php://input"));
			$this->categoryModel->setName($data->category_name);
			$this->categoryModel->setID($data->category_id);
			if($this->categoryModel->update()){
				echo json_encode(array('message', 'Category Updated'));
			} else{
				echo json_encode(array('message', 'Category Not Updated'));
			}
		}
		public function delete(){
			$data = json_decode(file_get_contents("php://input"));
			$this->categoryModel->setID($data->category_id);
			if($this->categoryModel->delete()){
				echo json_encode(array('message', 'Category Deleted'));
			} else{
				echo json_encode(array('message', 'Category Not Deleted'));
			}
		}
	}
?>