<?php
	class Item extends DBObject {
		private $id;
		private $name;
		private $price;
		private $description;
		private $amount;
		private $categoryID;
		
		static protected $table = 'items';
		
		public function __construct($id,$name,$price,$description,$amount,$categoryID) {
			$this->id=$id;
			$this->name=$name;
			$this->price=$price;
			$this->description=$description;
			$this->amount = 1; //DEFAULT AMOUNT 1	
			$this->categoryID = $categoryID;
		}
		
		static public function CreateFromArray($data){
			return new Item($data['id'],$data['name'], $data['price'], $data['description'], $data['amount'], $data['category_id']);
		}
		
		//-------------------- DISPLAY ------------------
		
		public function cartHtml() {
			//name -> amount -> price
			$out = $this->name . ": (" . $this->amount . "x " . $this->price . " PLN)";
			$out .= "<input type='submit' class='input-button-inline' style='width:30px' name='AddMoreItemsSubmit' value='+'>";
			$out .= "<input type='submit' class='input-button-inline' style='width:30px' name='DecreaseItem' value='-'>";
			$out .= "<input type='submit' class='input-button-inline delete' style='width:30px' name='RemoveItem' value='X'><br>";
			$out .= "<input type='hidden' name='in_cart_item_id' value='" . $this->id . "'>";
			
			return $out;
		}
		
		public function getAdminDetails() {
			$out = "<div class='margin-top-spacing'>";
			$out .= "Name: <input type='text' name='new_name' value='"  . $this->name . "'><br>";
			$out .= "Description: <input type='text' name='new_description' value='" . $this->description . "'><br>";
			$out .= "Price: <input type='text' name='new_price' value='" . $this->price . "'><br>";
			$out .= "</div>";
			
			return $out;
		}
		
		public function getAdminOptions() {
			//delete , update
			$out = "<div>";
			$out .= "<input type='hidden' id='updating_item_id' name='updating_item_id' value='".$this->id."'>";
			$out .= "<input type='submit' class='submit-btn-update' name='SubmitUpdateItem' value='Update Product'>";
			$out .= "</div>";
			
			return $out;
		}
		
		public function addButtonHtml() {
			$out = "<input type='submit' class='submit-btn-add' value='Add to Cart'>";
			$out .= "<input type='hidden' name='selected_item_id' value='" . $this->id . "'>";
			return $out;
		}
		
		public function toInputHtml() {
			$class = 'item-input';
			
			$out = "<input type='submit' class='".$class."'  value='".$this->name."' name='SubmitInputItem'>";
			$out .= "<input type='hidden' name='item_id' value='".$this->id."'>";
				
			return $out;
		}
		
		public function detailsToHtml() {
			$out = "<div>";
			$out .= "Name: "  . $this->name . '<br>';
			$out .= "Description: " . $this->description . '<br>';
			$out .= "Price: " . $this->price . '<br>';
			$out .= "</div>";
			
			return $out;
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
		public function getPrice() { return $this->amount * $this->price; }
		public function getDescription() { return $this->description; }
		public function getName() { return $this->name; }
		public function getAmount() { return $this->amount; }
		
		public function setPrice($new) { $this->price = $new; }
		public function setName($new) { $this->name = $new; }
		public function setAmount($new) { $this->amount = $new; }
		public function setDescription($new) { $this->description = $new; }
		
		public function add() {
			$this->amount++;
		}
		
		public function remove() {
			$this->amount--;
		}
		
		
	}
?>