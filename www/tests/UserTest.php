<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/User.php";
	
	class UserTest extends PHPUnit_Extensions_Database_TestCase {
		
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
			$user = User::Create("new username", "user@test.com", "test");
			$this->assertNotNull($user);
			$this->assertEquals("new username", $user->getName());
		}
		
		//protected function getTearDownOperation() {
			//return PHPUnit_Extensions_Database_Operation_Factory::TRUNCATE();
		//}
	}
?>