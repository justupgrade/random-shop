<?php
	class Cart {
		private $items;

		public function  __construct() {
			$this->items = array();
		}

		public function addItem($item) {
			if(array_key_exists($item->getID(), $this->items)) {
				$this->items[$item->getID()]->add();
			} else {
				$this->items[$item->getID()] = $item;
			}
		}

		public function removeItem($item) {
			$this->items[$item->getID()]->remove();
		}

		public function getTotalCost(){
			$cost = 0;
			foreach($this->items as $item) {
				$cost += $item->getPrice();
			}
		}

		public function toHtml() {
			
		}

		public function finalize() {
			//DBObject::SetUpConnection();
			//Order::Create(...);
		}
	}
?>