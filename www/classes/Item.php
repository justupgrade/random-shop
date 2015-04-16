<?php
	class Item extends DBObject {
		private $id;
		private $name;
		private $price;
		private $descirpiotn;
		private $amount;
		private $categoryID;
		
		static protected $table = 'items';
		
		public function __construct($id,$name,$price,$description,$amount,$categoryID) {
			$this->id=$id;
			$this->name=$name;
			$this->price=$price;
			$this->description=$description;
			$this->amount = $amount;
			$this->categoryID = $categoryID;
		}
		
		//----------- methods -----------------
		
		
		//-------------- CRUD --------------------
		static public function Create($name,$price,$description,$amount,$category) {
			$columns = array('name', 'price', 'description', 'amount', 'category_id');
			$values = array($name,$price,$description,$amount,$category);
			
			if(($id = parent::Create(self::$table, $columns, $values)) !== null) {
				return new Item($id,$name,$price,$description,$amount,$category);
			}
			
			return null;
		}
		
		static public function Load($id) {
			$data = parent::Load($id, self::$table);
			
			if(($data=$data->fetch_assoc())) return self::CreateFromArray($data);
			
			return null;
		}
		
		static private function CreateFromArray($data){
			return new Item($data['id'],$data['name'], $data['price'], $data['description'], $data['amount'], $data['category_id']);
		}
		
		static public function Update() {
			
		}
		
		static public function Delete($id) {
			trigger_error("You can not delete item, you bastard!!!");
		}
		
		//------------------- OTEHR STATIC -------------------
		static public function GetAllItems() {
			
		}
		
		
		// ---------------- get / set ----------------------
		public function getCategoryID() { return $this->categoryID; }
		public function getID() { return $this->id; }
		public function getPrice() { return $this->price; }
		public function getDescription() { return $this->description; }
		public function getName() { return $this->name; }
		public function getAmount() { return $this->amount; }
		
		public function setPrice($new) { $this->price = $new; }
		public function setName($new) { $this->name = $new; }
		public function setAmount($new) { $this->amount = $new; }
		public function setDescription($new) { $this->description = $new; }
		
		
	}
?>