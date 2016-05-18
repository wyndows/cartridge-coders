<?php

/**
 * Formulating plan for unit testing of ProductPurchase class
 *
 * Class will consist of:
 * 	ProductPurchasePurchaseId
 * 	ProductPurchaseProductId
 *
 * Primary key:
 * 	composite key of ProductPurchasePurchaseId and ProductPurchaseProductId
 *
 * Foreign Keys:
 * 	ProductPurchasePurchaseId
 * 	ProductPurchaseProductId
 *
 * Testing will be on:
 * 	insertProductPurchase
 * 	updateProductPurchase
 * 	deleteProductPurchase
 * 	getProductPurchaseByProductPurchasePurchaseId
 * 	getProductPurchaseByProductPurchaseProductId
 *
 * Testing will consist of the following:
 * 	test inserting a valid ProductPurchase composite key and verify that the actual mySQL data matches
 * 	test inserting a ProductPurchase with foreign key outside the limit
 * 	test inserting a ProductPurchase with a different foreign key outside the limit
 * 	test updating a ProductPurchase that already exists
 * 	test creating a ProductPurchase using purchaseId and then deleting it
 * 	test creating a ProductPurchase using a productId and then deleting it
 * 	test deleting a ProductPurchase that does not exist
 * 	test grabbing a ProductPurchase by a PurchaseId that does not exist
 * 	test grabbing a ProductPurchase by a ProductId that does not exist
 * 	test grabbing all ProductPurchase Primary Composite keys
 *
 * @author Marlan Ball <wyndows@earthlink.net> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\ProductPurchase;
use Edu\Cnm\CartridgeCoders\Product;
use Edu\Cnm\CartridgeCoders\Purchase;
use Edu\Cnm\CartridgeCoders\Account;
use Edu\Cnm\CartridgeCoders\Image;


// grab the project test parameters
require_once("CartridgeCodersTest.php");

// grab the class under scrutiny
require_once("../php/classes/autoload.php");

/**
 * Unit testing for the ProductPurchase class for Cartridge Coders
 *
 * @see ProductPurchase
 */
class ProductPurchaseTest extends CartridgeCodersTest {

	/**
	 * creating mock objects for foreign keys
	 * @var Purchase profile
	 * @var Product profile
	 */
	protected $purchase = null;

	protected $product = null;

	protected $account = null;

	protected $image = null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();


		// create and insert an Image to own the test Product
		$this->image = new Image(null, "filename", "image/jpg");
		$this->image->insert($this->getPDO());


		// create and insert an Account to own the test Product
		$this->account = new Account(null, $this->image->getImageId(), 1, 0, "john", "john@john.com", "johndoe");
		$this->account->insert($this->getPDO());


		// create and insert a Purchase class
		$this->purchase = new Purchase(null, $this->account->getAccountId(), "pptransactionid", "2016-05-05 09:30:30");
		$this->purchase->insert($this->getPDO());




		// create and insert a Product class
		$this->product = new Product(null, $this->account->getAccountId(), $this->image->getImageId(), 2.00, "cartridge", 10.00, 5.99, 0, "cheap");
		$this->product->insert($this->getPDO());
	}

	/**
	 * test inserting a valid ProductPurchase composite key and verify that the actual mySQL data matches
	 */
	public function testInsertValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new productpurchase and insert into mySQL
		$productPurchase = new productPurchase($this->purchase->getPurchaseId(), $this->product->getProductId());
		$productPurchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchasePurchaseIdAndProductId($this->getPDO(), $productPurchase->getProductPurchasePurchaseId(), $productPurchase->getProductPurchaseProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
	}

	/**
	 * test inserting a ProductPurchase that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductPurchase() {
		// create an invalid ProductPurchase and try to insert it
		$productPurchase = new ProductPurchase(CartridgeCodersTest::INVALID_KEY, CartridgeCodersTest::INVALID_KEY);
		$productPurchase->insert($this->getPDO());
	}

	/**
	 * test updating a ProductPurchase
	 *
	 *
	 **/
	public function testUpdateValidProductPurchase() {
		// create a Product with a non null product id and watch it fail
		$productPurchase = new ProductPurchase($this->purchase->getPurchaseId(), $this->product->getProductId());
		$productPurchase->update($this->getPDO());
	}

	/**
	 * test updating a ProductPurchase
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProductPurchase() {
		// create a Product with a non null product id and watch it fail
		$productPurchase = new ProductPurchase(CartridgeCodersTest::INVALID_KEY, CartridgeCodersTest::INVALID_KEY);
		$productPurchase->update($this->getPDO());
	}

	/**
	 * test creating a ProductPurchase using a purchaseId and productId and then deleting it
	 **/
	public function testDeleteValidProductPurchasePurchaseIdAndProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new ProductPurchase and insert into mySQL
		$productPurchase = new productPurchase($this->purchase->getPurchaseId(), $this->product->getProductId());
		$productPurchase->insert($this->getPDO());

		// delete the ProductPurchase from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$productPurchase->delete($this->getPDO());

		// grab the data from mySQL and enforce the ProductPurchase does not exist
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchasePurchaseIdAndProductId($this->getPDO(), $productPurchase->getProductPurchasePurchaseId(), $productPurchase->getProductPurchaseProductId());
		$this->assertNull($pdoProductPurchase);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productPurchase"));
	}

	/**
	 * test deleting a ProductPurchase that does not exist
	 *
	 *
	 **/
	public function testDeleteInvalidProductPurchase() {
		// create a ProductPurchase and try to delete it without actually inserting it
		$productPurchase = new ProductPurchase($this->purchase->getPurchaseId(), $this->product->getProductId());
		$productPurchase->delete($this->getPDO());
	}

	/**
	 * test grabbing a ProductPurchase by a PurchaseId and ProductId that do not exist
	 *
	 **/
	public function testGetProductPurchaseByInvalidProductPurchasePurchaseIdAndProductId() {
		// grab a product purchase purchaseid and productid that exceed the maximum allowable purchase id and product id
		$productPurchase = ProductPurchase::getProductPurchaseByProductPurchasePurchaseIdAndProductId($this->getPDO(), CartridgeCodersTest::INVALID_KEY, CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($productPurchase);
	}

	/**
	 * test grabbing all ProductPurchase Primary Composite keys
	 **/
	public function testGetAllValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new ProductPurchase and insert to into mySQL
		$productPurchase = new ProductPurchase($this->purchase->getPurchaseId(), $this->product->getProductId());
		$productPurchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = ProductPurchase::getAllProductPurchases($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\ProductPurchase", $results);

		// grab the result from the array and validate it
		$pdoProductPurchase = $results[0];
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->purchase->getPurchaseId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->product->getProductId());
	}

}

?>
