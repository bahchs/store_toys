<?php
class BrandModel extends Database {
	private $brand_id;
	private $brand_name;
	private $brand_img;

	public function __construct() {
		$this->connect();
	}

	public function read() {
		$query = "SELECT * FROM `brand`";
		$statement = $this->con->prepare($query);
		$statement->execute();
		return $statement;
	}

	public function setBrandID($brand_id) {
		$this->brand_id = $brand_id;
	}

	public function setBrandName($brand_name) {
		$this->brand_name = $brand_name;
	}

	public function setBrandImg($brand_img) {
		$this->brand_img = $brand_img;
	}

	public function create() {
		$query = "INSERT INTO brand (brand_name, brand_img) VALUES (:brand_name, :brand_img)";
		$statement = $this->con->prepare($query);

		$statement->bindParam(':brand_name', $this->brand_name);
		$statement->bindParam(':brand_img', $this->brand_img);

		if ($statement->execute()) {
			return true;
		}
		return false;
	}

	public function update() {
		$query = "UPDATE brand SET brand_name = :brand_name, brand_img = :brand_img WHERE brand_id = :brand_id";
		$statement = $this->con->prepare($query);

		$statement->bindParam(':brand_id', $this->brand_id);
		$statement->bindParam(':brand_name', $this->brand_name);
		$statement->bindParam(':brand_img', $this->brand_img);

		if ($statement->execute()) {
			return true;
		}
		return false;
	}

	public function delete() {
		$query = "DELETE FROM brand WHERE brand_id = :brand_id";
		$statement = $this->con->prepare($query);

		$statement->bindParam(':brand_id', $this->brand_id);

		if ($statement->execute()) {
			return true;
		}
		return false;
	}
}
?>
