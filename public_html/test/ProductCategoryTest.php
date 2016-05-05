<?php

/**
 * Formulating plan for unit testing of ProductCategory class
 *
 * Class will consist of:
 * 	ProductCategoryCategoryId
 * 	ProductCategoryProductId
 *
 * Primary key:
 * 	composite key of ProductCategoryCategoryId and ProductCategoryProductId
 *
 * Foreign Keys:
 * 	ProductCategoryCategoryId
 * 	ProductCategoryProductId
 *
 * Testing will be on:
 * 	insertProductCategory
 * 	updateProductCategory
 * 	deleteProductCategory
 * 	getProductCategoryByProductCategoryCategoryId
 * 	getProductCategoryByProductCategoryProductId
 *
 * Testing will consist of the following:
 * 	test inserting a valid ProductCategory composite key and verify that the actual mySQL data matches
 * 	test inserting a ProductCategory composite key that already exists
 * 	test inserting a ProductCategory composite key, editing it, and then updating it
 * 	test updating a ProductCategory composite key that already exists
 * 	test creating a ProductCategory composite key and then deleting it
 * 	test deleting a ProductCategory composite key that does not exist
 * 	test grabbing a ProductCategory composite key that does not exist
 * 	test grabbing a ProductCategory composite key by categoryId
 * 	test grabbing a ProductCategory composite key by productId
 * 	test grabbing a ProductCategory by categoryId that does not exist
 * 	test grabbing a ProductCategory by productId that does not exist
 * 	test grabbing all composite keys in the table
 *
 * @author Marlan Ball <wyndows@earthlink.net> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

	namespace Edu\Cnm\CartridgeCoders\Test;
	
	use Edu\Cnm\CartridgeCoders\ProductCategory;
	
	// grab the project test parameters
	require_once("CartridgeCodersTest.php");
	
	// grab the class under scrutiny
	require_once(dirname(__DIR__) . "/php/classes/autoload.php");
	
	/**
	 * Unit testing for the ProductCategory class for Cartridge Coders
	 * 
	 * @see ProductCategory
	 */
	class ProductCategoryTest extends CartridgeCodersTest {
		
		/**
		 * creating mock objects for foreign keys
		 * @var Category profile
		 * @var Product profile
		 */
		protected $category = null;

		protected $product = null;
		
		/**
		 * create dependent objects before running each test
		 */
		public final function setUp() {
			// run the default setUp() method first
			parent::setUp();
			
			// create and insert a Category class
			$this->category = new Category(null, "nintendo");
			$this->category->insert($this->getPDO());

			// create and insert a Product class
			$this->product = new Product(null, 25, 35, .75, "cartridge", 10.00, 5.99, 0, "cheap");
			$this->product->insert($this->getPDO());
		}
		
		/**
		 * test inserting a valid ProductCategory composite key and verify that the actual mySQL data matches 
		 */
		public function testInsertValidProductCategory() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("productCategory");
			
			// create a new category and insert into mySQL
			$productCategory = new ProductCategory($this->category->getCategoryId(), $this->product->getProductId());
			$productCategory->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$pdoProductCategory = ProductCategory::getProductCategoryByProductCategoryCategoryId($this->getPDO(), $productCategory->getProductCategoryCategoryId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productCategory"));
			$this->assertEquals($pdoProductCategory->getProductCategoryCategoryId(), $this->productCategory->getProductCategoryCategoryId());
			$this->assertEquals($pdoProductCategory->getProductCategoryProductId(), $this->productCategory->getProductCategoryProductId());
		}


	}

?>