<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/Category.php";
	
	class CategoryTest extends PHPUnit_Extensions_Database_TestCase {
		
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
		
		public function test1() {
			$category = Category::Create('new name', '1');
			$this->assertEquals('new name', $category->getName());
		}
	}
?>