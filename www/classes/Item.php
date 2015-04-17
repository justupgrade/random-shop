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
		
		static public function CreateFromArray($data){
			return new Item($data['id'],$data['name'], $data['price'], $data['description'], $data['amount'], $data['category_id']);
		}
		
		//----------- methods -----------------
		
		//reset category if category deleted -> CATEGORY 1 MEANS uncategorized
		public function resetCategory() {
			$this->categoryID = 1;
		}
		
		//-------------- CRUD --------------------
		static public function Create($name,$price,$description,$amount,$category) {
			$columns = array('name', 'price', 'description', 'amount', 'category_id');
			$values = array($name,$price,$description,$amount,$category);
			
			if(($id = parent::Create($columns, $values)) !== null) {
				return new Item($id,$name,$price,$description,$amount,$category);
			}
			
			return null;
		}
		
		
		//
		static public function Update($item) {
			$columns = array('name', 'price', 'description', 'amount', 'category_id');
			$values = array($item->getName(), $item->getPrice(), $item->getDescription(), $item->getAmount(), $item->getCategoryID());
				
			return parent::Update($columns,$values, $item->getID());
		}
		
		static public function Delete($id) {
			throw new Exception("You can not delete item, you bastard!!!");
		}
		
		//------------------- OTEHR STATIC -------------------
		
		
		
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