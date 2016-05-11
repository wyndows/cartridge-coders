<?php

/**
 * Formulating plan for unit testing of ProductPurchase class
 *
 * Class will consist of two foreign keys only, primary will be a compost of the two
 *
 * Foreign keys:
 * ProductPurchaseProductId
 * ProductPurchasePurchaseId
 *
 * Testing will be on;
 * insert on productPurchase
 * update on productPurchase
 * delete on product Purchase
 * get of productPurchase by productId
 * get of productPurchase by purchaseId
 *
 * Testing will consist of;
 * test inserting valid ProductPurchase and verifying
 * test inserting invalid ProductPurchase (over limit) and verifying
 * test inserting ProductPurchase where already exist
 * test updating ProductPurchase where already exist
 * test getting ProductPurchase by productId where does not exist
 * test getting ProductPurchase by purchaseId where does not exist
 *
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\{
	ProductPurchase, Product, Purchase
};


// grab  the project test parameters
require_once("CartridgeCodersTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Unit testing for the ProductPurchase class
 * @see ProductPurchase
 */
class ProductPurchaseTest extends CartridgeCodersTest {

	/**
	 * creating mock objects for foreign keys
	 * @var Product profile
	 * @var Purchase profile
	 */
	protected $product = null;
	protected $purchase = null;
	protected $account = null;
	protected $image = null;
	

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();



		// create and insert a Account class
		$this->account = new Account(null, $this->account->getAccountId(), $this->product->getProductId(), 33, "description would be here", 44, 55, 0, "the title is here");
		$this->product->insert($this->getPDO());


		// create and insert a Product class
		$this->product = new Product(null, $this->account->getAccountId(), $this->image->getProductId(), 33, "description would be here", 44, 55, 0, "the title is here");
		$this->product->insert($this->getPDO());
		

		// create and insert Purchase class
		$this->purchase = new Purchase(null, 21, "transaction0123456789numbers", "2016-05-09 17:00:00");
	}

	/**
	 * test inserting a valid ProductPurchase composit key and verify that the actuial mySQL data matches
	 */
	public function testInsertValidProductPurchase() {
		// count the number of rowsa andsave it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");
		// create a new productPurchase and insert into mySQL
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId());
		$productPurchase->insert($this->getPDO());
		// grab the data from mysql and enforce the fields match our expectations
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductId($this->getPDO(), $productPurchase->getProductPurchasePurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection() - getRowCount("productPurchase"));
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->productPurchase->getProductPurchaseProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->productPurchase->getProductPurchasePurchaseId());
	}

	/**
	 * test inserting a ProductPurchase with a foreign key outside the limit
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidProductPurchasePurchaseId() {
		// create a ProductPurchase wirh a non null purchaseId and watch it fail
		$productPurchase = new ProductPurchase(CartridgeCodersTest::INVALID_KEY, $this->purchase->getPurchaseId);
		$productPurchase->insert($this->getPDO());
	}

	/**
	 * test inserting a ProductPurchase with a foreign key outside the limit
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidProductPurchaseProductId() {
		// create a ProductPurchase wirh a non null productId and watch it fail
		$productPurchase = new ProductPurchase(CartridgeCodersTest::INVALID_KEY, $this->product->getProductId);
		$productPurchase->insert($this->getPDO());
	}

	/**
	 * test updating a ProductPurchase that already exist
	 * @expectedException \PDO
	 */
	public function testUpdateInvalidProductPurchase() {
		// create a ProductPurchase with an existing foreign key and watch it fail
		$productPurchase = new ProductPurchase($this->purchase->getPurchaseId(), $this->product->getProductId());
		$productPurchase->update($this->getPDO());
	}


	/**
	 * test creating a product purchase using purchase id and then deleting it
	 */
	public function testDeleteValidProductPurchasePurchaseId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");
		// create a new product purchase and insert into mysql
		$productPurchase = new productPurchase($this->purchase->getPurchaseId(), $this->product->getProductId());
		$productPurchase->insert($this->getPDO());
		// delete the product purchase from mysql
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$productPurchase->delete($this->getPDO());
		// grab the data from mysql and enforce the productPurchase does not exist
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByPurchaseId($this->getPDO(), $productPurchase->getProductPurchasePurchaseId());
		$this->assertNull($pdoProductPurchase);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productPurchase"));
	}


	/**
	 * test creating a product purchase using product id and then deleting it
	 */
	public function testDeleteValidProductPurchaseProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");
		// create a new product purchase and insert into mysql
		$productPurchase = new productPurchase($this->product->getProductId(), $this->purchase->getPurchaseId());
		$productPurchase->insert($this->getPDO());
		// delete the product purchase from mysql
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$productPurchase->delete($this->getPDO());
		// grab the data from mysql and enforce the productPurchase does not exist
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductId($this->getPDO(), $productPurchase->getProductPurchaseProductId());
		$this->assertNull($pdoProductPurchase);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productPurchase"));
	}

	/**
	 * test deleting a product purchase that does not exist
	 * @expectedExcption PDOException
	 */
	public function testDeleteInvalidProductPurchase() {
		// create a product purchase and try to delete it without actually inserting it
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId());
		$productPurchase->delete($this->getPDO());
	}

	/**
	 * test grabbing a product purchase by product id that does not exist
	 */
	public function testGetInvalidProductPurchaseByProductPurchaseProductId(){
		// grab a product purchase product id that exceeds the maximum allowable product id
		$productPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($productPurchase);
	}

	/**
	 * test grabbing a product purchase by purchase id that does not exist
	 */
	public function testGetInvalidProductPurchaseByProductPurchasePurchaseId(){
		// grab a product purchase product id that exceeds the maximum allowable product id
		$productPurchase = ProductPurchase::getProductPurchaseByProductPurchasePurchaseId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($productPurchase);
	}

	/**
	 * test grabbing all product purchase primary composit keys
	 */
	public function testGetAllValidProductPurchase(){
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");
		// create a new product purchase and insert into mysql
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId());
		$productPurchase->insert($this->getPDO());
		// grab the data from mysql and enforce the fields match our expectations
		$results = productPurchase::getAllProductPurchase($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()-getRowCount("productPurchase"));
		$this->assertCount(1, $results);
		$this->asserContainsOnlyInstancesOf("Edu\\Cnm||CartridgesCoders\\ProductPurchase", $results);

		// grab the result from the array and validate
		$pdoProductPurchase = $results[0];
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->purchase->getPurchaseId());
	}
	
}


























