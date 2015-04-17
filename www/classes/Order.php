<?php
	class Order extends DBObject {
		private $id;
		private $status; //1 - 3
		private $user_id; //
		private $date; //
		
		static protected $table = 'orders';
		
		public function __construct($id,$status,$user_id,$date) {
			$this->id = $id;
			$this->status=$status;
			$this->user_id = $user_id;
			$this->date = $date;
		}
		
		//ABSTRACT HAS TO BE IMPLEMENTED
		static protected function CreateFromArray($data){
			return new Order($data['id'], $data['status'], $data['user_id'], $data['date']);
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
		
		//-------------- CRUD --------------------
		//items : array of items ids?
		static public function Create($user_id, $items) {
			$order = null;
			self::$table = 'orders'; //HAS TO BE UPDATES SO LATE STATIC BINDING IN PARENT CLASS WORKS!
			$now = date("Y-m-d H:i:s");
			$columns = array('user_id', 'date');
			$values = array($user_id,$now);
			
			//CREATE ORDER IN DB
			if(($id = parent::Create($columns, $values)) !== null) {
				$order = new Order($id,1,$user_id,$now);
				
				//UPDATE ORDERS-ITEMS-DB
				//look for same ids:
				$indexes = array();
				foreach($items as $itemID) {
					if(array_key_exists($itemID, $indexes)) $indexes[$itemID]++;
					else $indexes[$itemID] = 1;
				}
				
				self::$table = 'orders_items'; //HAS TO BE UPDATES SO LATE STATIC BINDING IN PARENT CLASS WORKS!
				$columns = array('order_id', 'item_id', 'amount');
				foreach($indexes as $itemID => $amount) {
					$values = array($id, $itemID, $amount);
					parent::Create($columns,$values);
					//CREATE ITEM OBJECTS HERE?!
				}
				
				self::$table = 'orders'; //HAS TO BE UPDATES SO LATE STATIC BINDING IN PARENT CLASS WORKS!
			}
			
			return $order;
		}
		
		static public function Update($order) {
				
		}
		
		static public function Delete($id) {
				
		}
		
		
		//------------------- OTEHR STATIC -------------------
		static public function GetAllOrdersByStatus($status) {
		
		}
		
	}
?>