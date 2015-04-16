<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/Order.php";
	
	class OrderTest extends PHPUnit_Extensions_Database_TestCase {
		
		public function getConnection(){
			$conn = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
			return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
		}
		
		public function getDataSet(){
			return $this->createFlatXMLDataSet('./data/random_shop.xml');
		}
		
		static public function setUpBeforeClass() {
			DBObject::SetUpConnection(
				new mysqli($GLOBALS['DB_HOST'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD'],$GLOBALS['DB_NAME'])
			);
		}
		
		public function test2() {
			
		}
		
		public function test1() {
			$items = array(1,3,2,2,4,5); //5 items (item_id=2 => 2x)
			$user_id = 1;
			$order = Order::Create($user_id, $items);
			$this->assertNotNull($order);
			
			$allItems = $order->getItems();
			$this->assertCount(5,$allItems);
		}
	}
?>