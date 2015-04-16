<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/Category.php";
	require_once "./classes/Item.php";
	
	class ItemTest extends PHPUnit_Extensions_Database_TestCase {
		
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
			//delete item-> not possible? -> breaks orders
			//try to delete item
			$deletion = null;
			$error = null;
			try {
				$deletion = Item::Delete(1);
			} catch (Error $err){
				$error = true;
			}
			
			$this->assertNull($deletion);
			$this->assertTrue($error);
		}
		
		public function test1() {
			$item = Item::Create("new item", 2.33, "item description", 1, 1);
			$this->assertNotNull($item);
		}
	}
?>