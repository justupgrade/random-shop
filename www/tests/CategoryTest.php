<?php
	require_once "./classes/DBObject.php";
	require_once "./classes/Category.php";
	require_once "./classes/Item.php";
	
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
		
		public function test4() {
			//null subcategories
			$uncategoriezed = Category::Load(1);
			$this->assertNull($uncategoriezed->getAllSubcategories());
			
			//good parent:
			$cat2 = Category::Load(2);
			$cat3 = Category::Create("cat 3", 2);
			
			$parent = $cat3->getParent();
			
			$this->assertEquals($cat2, $parent);
		}
		
		public function test3() {
			$uncategorized = Category::Load(1);
			$uncategorized->setName('items with out category');
			$this->assertTrue(Category::Update($uncategorized));
			
			$this->assertEquals($uncategorized, Category::Load(1));
		}
		
		public function test2() {
			$category = Category::Load(2); 
			$currentNumberOfItems = count($category->getAllItems());
			$this->assertEquals(5, $currentNumberOfItems);
			Category::Delete($category);
			$this->assertNull(Category::Load(2));
			$uncategorized = Category::Load(1);
			$this->assertCount(5,$uncategorized->getAllItems());
		}
		
		public function test1() {
			$category = Category::Create('new name', '2');
			$this->assertEquals('new name', $category->getName());
		}
	}
?>