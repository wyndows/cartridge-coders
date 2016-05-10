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
 * 	test inserting a ProductCategory with foreign key outside the limit
 * 	test inserting a ProductCategory with a different foreign key outside the limit
 * 	test updating a ProductCategory that already exists
 * 	test creating a ProductCategory using categoryId and then deleting it
 * 	test creating a ProductCategory using a productId and then deleting it
 * 	test deleting a ProductCategory that does not exist
 * 	test grabbing a ProductCategory by a CategoryId that does not exist
 * 	test grabbing a ProductCategory by a ProductId that does not exist
 * 	test grabbing all ProductCategory Primary Composite keys
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

		protected $account = null;

		protected $image = null;
		
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
			$this->product = new Product(null, $this->account->getAccountId(), $this->image->getImageId(), 2.00, "cartridge", 10.00, 5.99, 0, "cheap");
			$this->product->insert($this->getPDO());
		}

		/**
	 	* test inserting a valid ProductCategory composite key and verify that the actual mySQL data matches
	 	*/
		public function testInsertValidProductCategory() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("productCategory");
			  
			// create a new productcategory and insert into mySQL
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
		public function testInsertInvalidProductCategoryCategoryId() {
			// create a ProductCategory with a non null category id and watch it fail
			$productCategory = new ProductCategory(CartridgeCodersTest::INVALID_KEY, $this->product->getProductId());
			$productCategory->insert($this->getPDO());
		}

		/**
		 * test inserting a ProductCategory with a different foreign key outside the limit
		 *
		 * @expectedException PDOException
		 **/
		public function testInsertInvalidProductCategoryProductId() {
			// create a ProductCategory with a non null category id and watch it fail
			$productCategory = new ProductCategory($this->category->getCategoryId(), CartridgeCodersTest::INVALID_KEY);
			$productCategory->insert($this->getPDO());
		}

		/**
		 * test updating a ProductCategory that already exists
		 *
		 * @expectedException PDOException
		 **/
		public function testUpdateInvalidProductCategory() {
			// create a ProductCategory with an existing foreign key and watch it fail
			$productCategory = new ProductCategory($this->category->getCategoryId(), $this->product->getProductId());
			$productCategory->update($this->getPDO());
		}

		/**
		 * test creating a ProductCategory using productCategoryCategoryId and then deleting it
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
			$pdoProductCategory = ProductCategory::getProductCategoryByProductCategoryCategoryId($this->getPDO(), $productCategory->getProductCategoryCategoryId());
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
			$pdoProductCategory = ProductCategory::getProductCategoryByProductCategoryProductId($this->getPDO(), $productCategory->getProductCategoryProductId());
			$this->assertNull($pdoProductCategory);
			$this->assertEquals($numRows, $this->getConnection()->getRowCount("productCategory"));
		}

		/**
		 * test deleting a ProductCategory that does not exist
		 *
		 * @expectedException PDOException
		 **/
		public function testDeleteInvalidProductCategory() {
			// create a ProductCategory and try to delete it without actually inserting it
			$productCategory = new ProductCategory($this->category->getCategoryId(), $this->product->getProductId());
			$productCategory->delete($this->getPDO());
		}

		/**
		 * test grabbing a ProductCategory by a CategoryId that does not exist
		 **/
		public function testGetInvalidProductCategoryByProductCategoryCategoryId() {
			// grab a productcategorycategory id that exceeds the maximum allowable category id
			$productCategory = ProductCategory::getProductCategoryByProductCategoryCategoryId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
			$this->assertNull($productCategory);
		}

		/**
		 * test grabbing a ProductCategory by a ProductId that does not exist
		 **/
		public function testGetInvalidProductCategoryByProductCategoryProductId() {
			// grab a productcategoryproduct id that exceeds the maximum allowable category id
			$productCategory = ProductCategory::getProductCategoryByProductCategoryProductId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
			$this->assertNull($productCategory);
		}

		/**
		 * test grabbing all ProductCategory Primary Composite keys
		 **/
		public function testGetAllValidProductCategory() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("productCategory");

			// create a new ProductCategory and insert to into mySQL
			$productCategory = new ProductCategory($this->category->getCategoryId(), $this->product->getProductId());
			$productCategory->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$results = ProductCategory::getAllProductCategory($this->getPDO());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productCategory"));
			$this->assertCount(1, $results);
			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\ProductCategory", $results);

			// grab the result from the array and validate it
			$pdoProductCategory = $results[0];
			$this->assertEquals($pdoProductCategory->getProductCategoryCategoryId(), $this->category->getCategoryId());
			$this->assertEquals($pdoProductCategory->getProductCategoryProductId(), $this->product->getProductId());
		}

	}

?>