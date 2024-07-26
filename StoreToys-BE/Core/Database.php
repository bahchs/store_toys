<?php
	class Database{
		private $HOST = 'localhost';
		private $USERNAME = 'root';
		private $PASSWORD = '';
		private $DB_NAME = 'storetoy';
		protected $con;
		
		public function connect(){
			try{
				$this->con = new PDO("mysql:host=$this->HOST;dbname=$this->DB_NAME", $this->USERNAME, $this->PASSWORD);
				$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $this->con;
			} catch(PDOException $e){
				echo("Không thể kết nối với máy chủ.\n");
				echo "Lỗi: " . $e->getMessage();
			}
		}
	}
?>