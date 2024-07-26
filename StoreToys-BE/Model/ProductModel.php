<?php

    class ProductModel extends Database{


        private $product_id;
        private $category_id;
        private $brand_id;
        private $product_name;
        private $product_img;
        private $product_sex;
        private $product_price;


        public function __construct(){
            $this -> connect();
        }

        public function read(){
            $query = "SELECT p.*, c.category_name AS category_name, b.brand_name AS brand_name
            FROM product p 
            INNER JOIN category c ON p.category_id = c.category_id
            INNER JOIN brand b ON p.brand_id = b.brand_id";
                $statement = $this->con->prepare($query);
                $statement->execute();
                return $statement;
        }
        public function readid($id){
            $query = "SELECT p.*, c.category_name AS category_name, b.brand_name AS brand_name
                    FROM product p 
                    INNER JOIN category c ON p.category_id = c.category_id
                    INNER JOIN brand b ON p.brand_id = b.brand_id
                    WHERE p.product_id = :id";
            $statement = $this->con->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
            return $statement;
        }        

        public function show(){
            $query = "SELECT * FROM `product` WHERE product_id=? LIMIT 1";
            $statement = $this->con->prepare($query);
            $statement->bindParam(1, $this->product_id);
            $statement->execute();

            $row= $statement->fetch(PDO::FETCH_ASSOC);

            // Gán giá trị từ kết quả truy vấn vào các thuộc tính
            $this->category_id = $row['category_id'];
            $this->brand_id = $row['brand_id'];
            $this->product_name = $row['product_name'];
            $this->product_img = $row['product_img'];
            $this->product_sex = $row['product_sex'];
            $this->product_price = $row['product_price'];
        }

        public function setProductID($product_id) {
            $this->product_id = $product_id;
        }
        public function setCategoryID($category_id) {
            $this->category_id = $category_id;
        }
        public function setBrandID($brand_id) {
            $this->brand_id = $brand_id;
        }
        public function setProductName($product_name) {
            $this->product_name = $product_name;
        }
        public function setProductImg($product_img) {
            $this->product_img = $product_img;
        }
        public function setProductSex($product_sex) {
            $this->product_sex = $product_sex;
        }
        public function setProductPrice($product_price) {
            $this->product_price = $product_price;
        }


        public function create(){
            $query = "INSERT INTO product (category_id, brand_id, product_name, product_img, product_sex, product_price) VALUES (:category_id, :brand_id, :product_name, :product_img, :product_sex, :product_price)";
            $statement = $this->con->prepare($query);
    
            $statement->bindParam(':category_id', $this->category_id);
            $statement->bindParam(':brand_id', $this->brand_id);
            $statement->bindParam(':product_name', $this->product_name);
            $statement->bindParam(':product_img', $this->product_img);
            $statement->bindParam(':product_sex', $this->product_sex);
            $statement->bindParam(':product_price', $this->product_price);
   
            if($statement->execute()){
                return true;
            }
            return false;
        }

        public function update(){
            $query = "UPDATE product SET category_id = :category_id, brand_id = :brand_id, product_name = :product_name, product_img = :product_img, product_sex = :product_sex, product_price = :product_price WHERE product_id = :product_id";
            $statement = $this->con->prepare($query);
    
            $statement->bindParam(':product_id', $this->product_id);
            $statement->bindParam(':category_id', $this->category_id);
            $statement->bindParam(':brand_id', $this->brand_id);
            $statement->bindParam(':product_name', $this->product_name);
            $statement->bindParam(':product_img', $this->product_img);
            $statement->bindParam(':product_sex', $this->product_sex);
            $statement->bindParam(':product_price', $this->product_price);
    
            if($statement->execute()){
                return true;
            }
            return false;
        }

        public function delete(){
            $query = "DELETE FROM product WHERE product_id = :product_id";
            $statement = $this->con->prepare($query);
    
            $statement->bindParam(':product_id', $this->product_id);
    
            if($statement->execute()){
                return true;
            }
            return false;
        }

    }


?>