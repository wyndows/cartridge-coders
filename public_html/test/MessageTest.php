<?php
namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\{Message,Product,AccountId};

// grab the project test parameters
require_once("cartridgeCodersTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Message class
 *
 * This is a complete PHPUnit test of the Message class. Hopefully it passes, we're going to test both valid and invalid inputes
 *
 * @see Message
 * @author Elliot Murrey <emurrey@cnm.edu>
 **/
class MessageTest extends CartridgeCodersTest {
	/**
	 * content of the Message
	 * @var string $VALID_MESSAGECONTENT
	 **/
	protected $VALID_MESSAGECONTENT = "PHPUnit test Passing";
	/**
	 * content of the updated Message
	 * @var string $VALID_MESSAGECONTENT2
	 **/
	protected $VALID_MESSAGECONTENT2 = "PHPUnit test hopfully still working";
	/**
	 * this is the messages MailGunId
	 * @var string $VALID_MESSAGEMAILGUNID
	 **/
	protected $VALID_MESSAGEMAILGUNID = "I don't even know";
	/**
	 * this is the subject of the message
	 * @var string $VALID_MESSAGESUBJECT
	 **/
	protected $VALID_MESSAGESUBJECT = "PHPUnit test passing";
	/**
	 * Account that created this message this is for foreign key relations
	 * @var Account account
	 **/
	protected $account = null;
	/**
	 * Account that is responding to said created message
	 * @var Account account
	 **/
	protected $account = null;
	/**
	 * product that message is about
	 * @var Product product
	 **/
	protected $product = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUP() {
		// run the default setUp() method first
		parent::setUP();

		// create and insert an account to write the test Message
		$this->account = new Account(null, "10", "1", "0", "JamesDean", "JamesDean@gmail.com", "coolguy");
		$this->account->insert($this->getPDO());

		// create and insert an account to be the reciever of the test Message
		$this->account = new Account(null, "16", "1", "0", "JessicaJones", "JessicaJones@gmail.com", "hotgirl");
		$this->account->insert($this->getPDO());

		// create and insert a product into hte test Message
		$this->product = new Product(null, "2", "116", "2.22", "coolItem", "22.22", "3.00", "0", "LegendOfZelda");
		$this->product->insert($this->getPdo());
	}

	/**
	 * test inserting a valid Message and verify that the actual mySQL data matches
	 **/
	public function testInsertValidMessage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert to into mySQL
		$message = new Message(null, $this->account->getAccountId(),  $this->)VALID_MESSAGECONTENT, $this->VALID_MESSAGESUBJECT
	}
}