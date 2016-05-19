<?php
namespace Edu\Cnm\CartridgeCoders\test;

use Edu\Cnm\Cartridgecoders\{
	Purchase, Account, Image
};

//parts of this code have been modified from the original, created by Dylan Mcdonald and taken from https://bootcamp-coders.cnm.edu with assistance from Marlan Ball

// grab the project test parameters
require_once("CartridgeCodersTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * full PHPUnit test for the Purchase class
 *
 * This is a an attempt at TDD testing.
 *
 * @see Purchase
 * @author Elliot Murrey <emurrey@cnm.edu
 **/
class PurchaseTest extends CartridgeCodersTest {
	/**
	 * the payPall transactionId
	 * @var string $VALID_PAYPALTRANSACTIONIDVALID
	 **/
	protected $VALID_PAYPALTRANSACTIONID = "215454we52652665235";
	/**
	 * content of updated Purchase
	 * timestamp of Purchase
	 * @var DateTime $VALID_PURCHASECREATEDATE
	 **/
	protected $VALID_PURCHASECREATEDATE = null;
	/**
	 * image for account
	 * @var Image image
	 **/
	protected $image = null;
	/**
	 * Account that created this Purchase; this is for foreign key relations
	 * @var Account account
	 **/
	protected $purchaseAccountId = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();
		// create and insert an account image to go with the accont
		$this->image = new Image(null, "fileName", "image/jpg");
		$this->image->insert($this->getPDO());

		// create and insert an account to own this purchase
		$this->purchaseAccountId = new Account(null, $this->image->getImageId(), "1", "0", "JamesDean", "JamesDean@gmail.com", "coolguy");
		$this->purchaseAccountId->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Purchase and verify that hte actual mySQL data matches
	 **/
	public function testInsertValidPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->VALID_PAYPALTRANSACTIONID, $this->VALID_PURCHASECREATEDATE, $this->purchaseAccountId->getAccountId());
		$purchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match out expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertEquals($pdoPurchase->getPurchaseAccountId(), $this->purchaseAccountId->getAccountId());
		$this->assertEquals($pdoPurchase->getPurchasePayPalTransactionId(), $this->VALID_PAYPALTRANSACTIONID);
		$this->assertEquals($pdoPurchase->getPurchaseCreateDate(), $this->VALID_PURCHASECREATEDATE);
	}

	/**
	 * test inserting a Purchase that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidPurchase() {
		//create a Purchase with a non null purchase Id and watch it fail
		$purchase = new Purchase(CartridgeCodersTest::INVALID_KEY, $this->purchaseAccountId->getAccountId(), $this->VALID_PAYPALTRANSACTIONID, $this->VALID_PURCHASECREATEDATE);
		$purchase->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Purchase and verify that hte actual mySQL data matches
	 **/
	public function testGetValidPurchaseByPurchaseId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->VALID_PAYPALTRANSACTIONID, $this->VALID_PURCHASECREATEDATE, $this->purchaseAccountId->getAccountId());
		$purchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match out expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertEquals($pdoPurchase->getPurchaseAccountId(), $this->purchaseAccountId->getAccountId());
		$this->assertEquals($pdoPurchase->getPurchasePayPalTransactionId(), $this->VALID_PAYPALTRANSACTIONID);
		$this->assertEquals($pdoPurchase->getPurchaseCreateDate(), $this->VALID_PURCHASECREATEDATE);
	}
	/**
	 * test grabbing a Purchase that does not exist
	 **/
	public function testGetInvalidPurchaseByPurchaseId() {
		// grab a purchase id that exceeds the maximum allowable purchase id
		$purchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($purchase);
	}
}
?>