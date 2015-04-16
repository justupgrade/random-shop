<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/User.php";
	require_once "./classes/Order.php";
	
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
		
		//------------------ TEST ---------------------
		
		public function test7() {
			$user = User::Authenticate("test@test.com", "test");
			$this->assertCount(1,$user->getAllOrders());
		}
		
		public function test6() {
			//test authenictace
			$new = User::Create("username", "username@email.com", "test");
			$this->assertNull(User::Authenticate("username@email.com", "wrong_password"));
			$this->assertEquals($new, User::Authenticate("username@email.com", "test"));
		}
		
		public function test5() {
			//get all users...
			$new = User::Create("new", "new email", "aaa");
			$this->assertNotNull($new);
			$this->assertEquals(2,$new->getID());
			$this->assertCount(2,User::GetAllUsers());
		}
		
		public function test4() {
			$user = User::Load(1);
			$user->setEmail("newEmail@test.com");
			$user->setCity("new city");
			$user->setPostal("80-100");
			$user->setSurname("Surname New");
			
			$this->assertEquals('newEmail@test.com', $user->getEmail());
			$this->assertEquals('new city', $user->getCity());
			$this->assertEquals('80-100', $user->getPostal());
			$this->assertEquals('Surname New', $user->getSurname());
			
			User::Update($user);
			
			$loadedUser = User::Load($user->getID());
			$this->assertEquals($user, $loadedUser);
		}
		
		public function test3() {
			$this->assertEquals(1, User::Delete(1));
		}
		
		public function test2() {
			$user = User::Load(1);
			$this->assertNotNull($user);
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