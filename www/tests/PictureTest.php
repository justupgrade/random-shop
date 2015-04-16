<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/Picture.php";
	require_once "./classes/Item.php";
	 
	
	
	class PictureTest extends PHPUnit_Extensions_Database_TestCase {
		
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
		
		// =============================== TESTS =====================================
		
		public function test2() {
			//edit? download binary? save to another location? 
		}
		
		public function test1() {
			//upload? -> leave for selenium
			//create? -> protected
			//load:
			$path = './uploads/1/2015/04/16/67af/sword.png';
			$pictures = Picture::Load(1);
			$this->assertCount(1,$pictures);
		}
		
		public function test0() {
			//clear db
		}
	}
?>