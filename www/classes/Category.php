<?php
	class Category extends DBObject {
		
		private $id;
		private $name;
		private $parentID;
		
		protected function __construct($id,$name,$parentID) {
			$this->id = $id;
			$this->name=$name;
			$this->parentID=$parentID;
		}
		
		//----------- methods -----------------
		public function getAllItems() {
				
		}
		
		public function getParent() {
				
		}
		
		public function getAllSubCategories() {
				
		}
		
		//-------------- CRUD --------------------
		static public function Create($name, $parentID) {
			$table = 'categories';
			$columns = array('name', 'parent_id');
			$values = array($name,$parentID);
				
			if(($id = parent::Create($table, $columns, $values)) !== null) {
				return new Category($id,$name,$parentID);
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
		static public function GetAllCategories() {
				
		}
		
		//--------------------- get / set -----------------
		public function getName() {
			return $this->name;
		}
	}
?>