<?php
	require_once './classes/DBObject.php';
	require_once './classes/Cart.php';
	require_once './classes/Order.php';
	require_once './classes/Item.php';

	//normal unit test?
	//or check if Order is Created in DB -> integration test too? 
	class CartTest extends PHPUnit_Extensions_Database_TestCase {
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
		
		public function testGetTotalCost() {
			$cart = new Cart();
			$item = Item::Load(1);
			$cart->addItem($item);
			$this->assertEquals(5, $cart->getTotalCost());
			$cart->addItem($item);
			$this->assertEquals(10, $cart->getTotalCost());
			$item2 = Item::Load(2);
			$cart->addItem($item2);
			$this->assertEquals(22, $cart->getTotalCost());
			$cart->removeItem($item);
			$this->assertEquals(17, $cart->getTotalCost());
		}
		
		public function testRemoveItem() {
			$cart = new Cart();
			$item = Item::Load(1);
			//$cart->removeItem($item); //nothing should happen -> no error either!
			$cart->addItem($item);
			$cart->removeItem($item);
			$this->assertCount(0, $cart->getAllItems());
			$item = Item::Load(1);
			
			$cart->addItem($item); 
			//var_dump($cart->getAllItems());
			
			$cart->addItem($item);
			
		//	var_dump($cart->getAllItems());
			
			$cart->removeItem($item);
			
			//var_dump($cart->getAllItems());

			$inCartItem = $cart->getItem($item->getID());
			$this->assertEquals(1, $inCartItem->getAmount());
			$this->assertCount(1, $cart->getAllItems());
		}
		
		public function testAddItem() {
			$cart = new Cart();
			$item = Item::Load(1); //5zl
			$cart->addItem($item);
			
			$this->assertCount(1,$cart->getAllItems());
			$cart->addItem($item);
			$this->assertCount(1,$cart->getAllItems());
			
			$inCartItem = $cart->getItem($item->getID());
			$this->assertEquals(2, $inCartItem->getAmount());
			
			$item = Item::Load(2);
			$cart->addItem($item);
			$this->assertCount(2,$cart->getAllItems());
		}
		
		public function test() {
			
		}
	}
?>