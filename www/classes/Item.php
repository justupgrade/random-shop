<?php
	class Item extends DBObject {
		private $id;
		private $name;
		private $price;
		private $descirpiotn;
		private $amount;
		private $categoryID;
		
		
		
		public function __construct($id,$name,$price,$description,$amount,$categoryID) {
			$this->id=$id;
			$this->name=$name;
			$this->price=$price;
			$this->description=$description;
			$this->amount = $amount;
			$this->categoryID = $categoryID;
		}
		
		//----------- methods -----------------
		//------------------ PICTURES ----------------------
		public function getAllPictures() {
			
		}
		
		public function addPicture() {
			
		}
		
		public function deletePicture() {
			
		}
		
		//-------------- CRUD --------------------
		static public function Create($name,$price,$description,$amount,$category) {
			$table = 'items';
			$columns = array('name', 'price', 'description', 'amount', 'category_id');
			$values = array($name,$price,$description,$amount,$category);
			
			if(($id = parent::Create($table, $columns, $values)) !== null) {
				return new Item($id,$name,$price,$description,$amount,$category);
			}
			
			return null;
		}
		
		static public function Load($id) {
			
		}
		
		static public function Update() {
			
		}
		
		static public function Delete($id) {
			
		}
		
		//------------------- OTEHR STATIC -------------------
		static public function GetAllItems() {
			
		}
		
		
		
	}
?>