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
 * 	test inserting a ProductCategory composite key with categoryId that already exists
 * 	test inserting a ProductCategory composite key with productId that already exists
 * 	test inserting a ProductCategory composite key, editing it, and then updating it
 * 	test inserting a ProductCategory composite key, with productId editing it, and then updating it
 * 	test updating a ProductCategory composite key with categoryId that already exists
 * 	test updating a ProductCategory composite key with productId that already exists
 * 	test creating a ProductCategory composite key with categoryId and then deleting it
 * 	test creating a ProductCategory composite key with productId and then deleting it
 * 	test deleting a ProductCategory composite key with categoryId that does not exist
 * 	test deleting a ProductCategory composite key with productId that does not exist
 * 	test grabbing a ProductCategory composite key with categoryId does not exist
 * 	test grabbing a ProductCategory composite key with productId does not exist
 * 	test grabbing a ProductCategory composite key by categoryId
 * 	test grabbing a ProductCategory composite key by productId
 * 	test grabbing a ProductCategory by categoryId that does not exist
 * 	test grabbing a ProductCategory by productId that does not exist
 * 	test grabbing all composite keys in the table
 *
 * @author Marlan Ball <wyndows@earthlink.net> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

	namespace Edu\Cnm\CartridgeCoders\Test;
	
	use Edu\Cnm\CartridgeCoders\{ProductCategory, Product, Category};
	
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

		/**
		 * test inserting a ProductCategory with foreign key outside the limit
		 *
		 * @expectedException PDOException
		 **/
		public function testInsertInvalidProductCategory() {
			// create a ProductCategory with a non null category id and watch it fail
			$productCategory = new ProductCategory(CartridgeCodersTest::INVALID_KEY, $this->product->getProductId);
			$category->insert($this->getPDO());
		}

		/**
		 * test inserting a ProductCategory with a different foreign key outside the limit
		 *
		 * @expectedException PDOException
		 **/
		public function testInsertInvalidProductCategory() {
			// create a ProductCategory with a non null category id and watch it fail
			$productCategory = new ProductCategory($this->category->getCategoryId, CartridgeCodersTest::INVALID_KEY);
			$category->insert($this->getPDO());
		}

		/**
		 * test updating a ProductCategory that already exists
		 *
		 * @expectedException PDOException
		 **/
		public function testUpdateInvalidProductCategory() {
			// create a ProductCategory with an existing foreign key and watch it fail
			$productCategory = new ProdutCategory($this->category->getCategoryId(), $this->product->getProductId());
			$productCategory->update($this->getPDO());
		}

		/**
		 * test creating a ProductCategory using categoryId and then deleting it
		 **/
		public function testDeleteValidProductCategoryCategoryId() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("productCategory");

			// create a new ProductCategory and insert to into mySQL
			$productCategory = new productCategory($this->category->getCategoryId(), $this->product->getProductId());
			$productCategory->insert($this->getPDO());

			// delete the ProductCategory from mySQL
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productCategory"));
			$productCategory->delete($this->getPDO());

			// grab the data from mySQL and enforce the ProductCategory does not exist
			$pdoProductCategory = ProductCategory::getProductCategoryByCategoryId($this->getPDO(), $ProductCategory->getProductCategoryCategoryId());
			$this->assertNull($pdoProductCategory);
			$this->assertEquals($numRows, $this->getConnection()->getRowCount("productCategory"));
		}

		/**
		 * test creating a ProductCategory using a productId and then deleting it
		 **/
		public function testDeleteValidProductCategoryProductId() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("productCategory");

			// create a new ProductCategory and insert to into mySQL
			$productCategory = new productCategory($this->category->getCategoryId(), $this->product->getProductId());
			$productCategory->insert($this->getPDO());

			// delete the ProductCategory from mySQL
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productCategory"));
			$productCategory->delete($this->getPDO());

			// grab the data from mySQL and enforce the ProductCategory does not exist
			$pdoProductCategory = ProductCategory::getProductCategoryByProductId($this->getPDO(), $ProductCategory->getProductCategoryProductId());
			$this->assertNull($pdoProductCategory);
			$this->assertEquals($numRows, $this->getConnection()->getRowCount("productCategory"));
		}

	}

?>