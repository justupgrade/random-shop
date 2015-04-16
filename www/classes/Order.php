<?php
	class Order extends DBObject {
		private $id;
		private $status; //1 - 3
		private $user_id; //
		private $date; //
		
		private $items; //?
		
		protected function __construct($id,$status,$user_id,$date) {
			$this->id = $id;
			$this->status=$status;
			$this->user_id = $user_id;
			$this->date = $date;
		}
		
		public function getItems() {
			$query = "SELECT items.id, items.name, items.price, items.description, items.amount, items.category_id ";
			$query .= "FROM items JOIN orders_items ON orders_items.item_id=items.id ";
			$query .= "WHERE orders_items.order_id=". $this->id;
			
			$result = self::$connection->query($query);
			if($result){
				$items = array();
				while($row = $result->fetch_assoc()) {
					$id=$row['id'];
					$name= $row['name'];
					$price = $row['price'];
					$description= $row['description'];
					$amount = $row['amount'];
					$category = $row['category_id'];
					$items[] = new Item($id,$name,$price,$description,$amount,$category);
				}
				
				return $items;
			}
			
			return null;
		}
		
		public function addItem() {
			
		}
		
		public function deleteItem() {
			
		}
		
		public function changeAmountOfItems() {
			
		}
		
		public function getWholePrice() {
			
		}
		
		//-------------- CRUD --------------------
		//items : array of items ids?
		static public function Create($user_id, $items) {
			$order = null;
			
			$now = date("Y-m-d H:i:s");
			$table = 'orders';
			$columns = array('user_id', 'date');
			$values = array($user_id,$now);
			
			//CREATE ORDER IN DB
			if(($id = parent::Create($table, $columns, $values)) !== null) {
				$order = new Order($id,1,$user_id,$now);
				
				//UPDATE ORDERS-ITEMS-DB
				//look for same ids:
				$indexes = array();
				foreach($items as $itemID) {
					if(array_key_exists($itemID, $indexes)) $indexes[$itemID]++;
					else $indexes[$itemID] = 1;
				}
				
				$table = 'orders_items';
				$columns = array('order_id', 'item_id', 'amount');
				foreach($indexes as $itemID => $amount) {
					$values = array($id, $itemID, $amount);
					parent::Create($table,$columns,$values);
					//CREATE ITEM OBJECTS HERE?!
				}
			}
			
			return $order;
		}
		
		static public function Load($id) {
				
		}
		
		static public function Update($order) {
				
		}
		
		static public function Delete($id) {
				
		}
		
		
		//------------------- OTEHR STATIC -------------------
		static public function GetAllOrdersByStatus($status) {
		
		}
		
		static public function GetAllOrders() {
		
		}
		
	}
?>