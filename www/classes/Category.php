<?php
	class Category extends DBObject {
		
		private $id;
		private $name;
		private $parentID;
		
		static protected $table = 'categories';
		static private $selectedID = -1;
		
		protected function __construct($id,$name,$parentID) {
			$this->id = $id;
			$this->name=$name;
			$this->parentID=$parentID;
		}
		
		static protected function CreateFromArray($data) {
			return new Category($data['id'], $data['name'], $data['parent_id']);
		}
		
		//-------------------- DISPLAY ------------------
		public function toDivHtml() {
			$out = "<div>";
			$out .= $this->name;
			$out .= "</div>";
			
			return $out;
		}
		
		public function toInputHtml() {
			$class = 'category-input';
			if($this->id === self::$selectedID) $class = 'category-input selected-category';
			$out = "<input type='submit' class='".$class."' value='".$this->name."' name='SubmitChangeCategory'>";
			$out .= "<input type='hidden' name='category_id' value='".$this->id."'>";
			
			return $out;
		}
		
		//----------- methods -----------------
		public function getAllItems() {
			$query = "SELECT * FROM items WHERE category_id=" . $this->id;
			$data = self::$connection->query($query);
			if($data && $data->num_rows > 0) {
				$items = array();
				while($row = $data->fetch_assoc()) {
					$items[] = Item::CreateFromArray($row);
				}
				
				return $items;
			}
			
			return null;
		}
		
		//get parent as category?
		public function getParent() {
			return self::Load($this->parentID);
		}
		
		public function getAllSubCategories() {
			$query = "SELECT * FROM categories WHERE parent_id=".$this->id;
			$data = self::$connection->query($query);
			
			if($data && $data->num_rows > 0) {
				$subcategories = array();
				while($row = $data->fetch_assoc()) {
					$subcategories[] = self::CreateFromArray($row);
				}
				
				return $subcategories;
			}
			
			return null;
		}
		
		//-------------- CRUD --------------------
		static public function Create($name, $parentID) {
			$columns = array('name', 'parent_id');
			$values = array($name,$parentID);
				
			if(($id = parent::Create($columns, $values)) !== null) {
				return new Category($id,$name,$parentID);
			}
				
			return null;
		}
		
		static public function Update($category) {
			$columns = array('name', 'parent_id');
			$values = array($category->getName(), $category->getParentID());
				
			return parent::Update($columns,$values, $category->getID());
		}
		
		static public function Delete($category) {
			//on delete category: update all of it items! -> set category to null or 0
			if(($items = $category->getAllItems())) {
				foreach($items as $item){
					$item->resetCategory();
					Item::Update($item);
				}
			}
			
			parent::Delete($category->getID());
		}
		
		//------------------- OTEHR STATIC -------------------
		
		static public function SetCurrentCategory($id=-1) {
			self::$selectedID = $id;
		}
		
		//--------------------- get / set -----------------
		public function getID() {
			return $this->id;
		}
		
		public function getName() {
			return $this->name;
		}
		
		public function getParentID() {
			return $this->parentID;
		}
		
		public function setName($new) {
			$this->name = $new;
		}
	}
?>