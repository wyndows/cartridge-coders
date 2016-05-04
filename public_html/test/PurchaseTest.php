<?php
namespace Edu\Cnm\CartridgeCoders\Test

use Edu\Cnm\Cartridgecoders\php\classes\{Purchase, Account};

//parts of this code have been modified from the original, created by Dylan Mcdonald and taken from https://bootcamp-coders.cnm.edu

// grab the project test parameters
require_once("CartridgeCodersTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * full PHPUnit test for the Purchase class
 *
 * This is a an attempt at TDD testing.
 *
 *@see Purchase
 *@author Elliot Murrey <emurrey@cnm.edu
 **/
class Purchase extends CartridgeCodersTest {
	/**
	 * timestamp of Purchase
	 * @var DateTime $VALID_PURCHASECREATEDATE
	 **/
	protected $VALID_PURCHASECREATEDATE = null;
	/**
	 * Account that created this Purchase; this is for foreign key relations
	 * @var Account account
	 **/
	protected $account = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final fuction setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert a Account to own the test Purchase
	$this->account = new Account(null, "25", "1", "jamesdean", "james@dean.com", "spar109");
	$this->profile-insert($this->getPDO());
		// calculate the date (just use the time the unit test ws created...)
		$this->VALID_PURCHASECREATEDATE = new \DateTim();
	}
	/**
 	* test inserting a valid Purchase and verify that hte actual mySQL data matches
 	**/
	public function testInsertValidPurchase(){
		// cont the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// grab the data from mySQL and enforce the fields match out expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $tweet->getPurchaseId());
		$this->assertEquals($numbRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertEquals($pdoPurchase->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoPurchase->getPurchasePayPalTransactionId(),$this->purchasePayPalTransaction->getPurchasePayPalTransactionId());
		$this->assertEquals($pdoPurchase->getPurchaseCreateDate(), $this->valid_PURCHASECREATEDATE);
}
/**
 * test inserting a Purchase that already exists
 *
 * @expectedException PDOException
 **/
	public function testInsertInvalidPurchase() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount(Purchase);

		//create a new Purchase and insert to into mySQL
		$
}
}