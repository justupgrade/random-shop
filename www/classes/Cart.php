<?php
	class Cart {
		private $items;

		public function  __construct() {
			$this->items = array();
		}
		
		//---------------- display -------------------
		
		public function getFinalizeForm() {
			$out = "<form method='POST' action=''>";
			$out .= "<input class='input-button' type='submit' name='ConfirmOrder' value='Finalize'>";
			$out .= "</form>";
			
			return $out;
		}
		
		//----------------------------------------------

		public function addItem($item) {
			if(array_key_exists("id".$item->getID(), $this->items)) {
				$this->items["id".$item->getID()]->add();
				//trigger_error('add anoteer!');
			} else {
				//
				$this->items["id".$item->getID()] = $item;
			}
		}
		
		public function getItemIndexes() {
			$indexes = array();
			foreach ($this->items as $item) {
				for($i=0; $i < $item->getAmount(); $i++) {
					$indexes[] = $item->getID();
				}
			}
			
			return $indexes;
		}

		public function removeItem($item) {
			if(array_key_exists("id".$item->getID(), $this->items)){
				$this->items["id".$item->getID()]->remove();
				if($this->items["id".$item->getID()]->getAmount() === 0) {
					array_splice($this->items,array_search("id".$item->getID(), $this->items),1);
				}
			}
		}
		
		public function removeTotaly($item) {
			if(array_key_exists("id".$item->getID(), $this->items)){
				array_splice($this->items,array_search("id".$item->getID(), $this->items),1);
			}
		}

		public function getTotalCost(){
			$cost = 0;
			foreach($this->items as $item) {
				$cost += $item->getPrice();
			}
			
			return $cost;
		}
		
		public function getItem($id) {
			return $this->items["id".$id];
		}
		
		public function getAllItems() {
			return $this->items;
		}

		public function toHtml() {
			
		}
		
		public function getNumberOfProducts() {
			return count($this->items);
		}

		public function finalize() {
			//DBObject::SetUpConnection();
			//Order::Create(...);
		}
	}
?>