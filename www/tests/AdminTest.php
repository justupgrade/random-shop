<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/Admin.php";
	
	
	class AdminTest extends PHPUnit_Extensions_Database_TestCase {
		
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
		
		//------------------ TEST ---------------------
		
		
		//TEST UPDATE 
		public function test2() {
			$admin = Admin::Load(1);
			$admin->changePassword("abcd");
			$loaded = Admin::Load($admin->getID());
			$this->assertEquals($loaded, Admin::Authenticate($loaded->getEmail(), "abcd"));
		}
		
		
		public function test1() {
			//test update
			$admin = Admin::Load(1);
			$this->assertNotNull($admin, Admin::Authenticate($admin->getEmail(), "test"));
			$this->assertEquals($admin, Admin::Authenticate($admin->getEmail(), "test"));
			
			$admin->setEmail("newEmail@test.com");
			Admin::Update($admin);
			$loaded = Admin::Load($admin->getID());
			$this->assertEquals($admin, $loaded);
			
			$this->assertEquals(1, Admin::Delete($admin->getID()));
		}
		
		
		public function test0() {
			//add admin
			$admin = Admin::Create("admin@test.com", "test");
			$this->assertNull($admin);
			
			
			$loadedFromFixture = Admin::Load(1);
			$this->assertNotNull($loadedFromFixture);
			
			$loadedCreated = Admin::Load($loadedFromFixture->getID());
			$this->assertEquals($loadedFromFixture,$loadedCreated);
		}
		
		//protected function getTearDownOperation() {
			//return PHPUnit_Extensions_Database_Operation_Factory::TRUNCATE();
		//}
	}
?>